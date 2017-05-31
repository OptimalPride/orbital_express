<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class Adventure
{

	public function afficheGestionAdventure(Application $app){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$pages = $app["dao.page"]->getAllPages();
		$adventures = $app["dao.adventure"]->getAllAdventures();
		return $app['twig']->render('backoffice/gestionadventure.html.twig', array("adventures" => $adventures, "pages" => $pages, "msg" => ""));
	}

	public function getAdventures(Application $app){
		$adventures = $app["dao.adventure"]->getAllAdventures();
		return array("adventures" => $adventures);
	}

	public function getAdventureById(Application $app, $id_adventure){
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
		$pages = $app["dao.page"]->getPagesByIdAdventure($id_adventure);
		$choices = $app["dao.choice"]->getAllChoices();
		return $app['twig']->render('backoffice/listepage.html.twig', array("adventure" => $adventure, "page" => $pages, "choices"=>$choices));
	}


	public function deleteAdventure(Application $app, $id_adventure){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$msg = $app["dao.adventure"]->deleteAdventureById($id_adventure);
		$adventures = $app["dao.adventure"]->getAllAdventures();
		$url = $app['url_generator']->generate('gestionAdventure');
		return $app->redirect($url);
	}

	public function displayAdventure(Application $app, $id_adventure){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$pages =  $app["dao.page"]->getPagesByIdAdventure($id_adventure);
		return $app['twig']->render('backoffice/displayadventure.html.twig', array("pages" => $pages));
	}

	public function createAdventure(Application $app, Request $request){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
	    $data = array(
	        "name" => "Nom de l'aventure",
	        "description" => "Description de l'aventure",
	        "pitch" => "Pitch de l'aventure, l'accroche"
	    );
	    $adventureform = $app['form.factory']->create(\OrbitalExpress\Form\Type\AdventureType::class, $data);
	    $adventureform->handleRequest($request);

	    if ($adventureform->isValid()) {
	        $data = $adventureform->getData();
	        if (isset($data["name"]) && isset($data["description"]) && isset($data["pitch"])) {
	            $information = array("name" => $data["name"], "description" => $data["description"], "pitch" => $data["pitch"]);
	            $msg = $app["dao.adventure"]->addNewAdventure($information);
	            $adventures = $app["dao.adventure"]->getAllAdventures();
				$url = $app['url_generator']->generate('gestionAdventure');
				return $app->redirect($url);
	        }
	        else{
	            throw new \Exception("Veuillez remplir toutes les informations");
	        }
	    }
	    return $app['twig']->render('backoffice/createadventure.html.twig', array('adventureform' => $adventureform->createView()));
	}

	public function modifyAdventure(Application $app, Request $request, $id_adventure){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
	    return $app['twig']->render('backoffice/modifyadventure.html.twig', array('adventure' => $adventure));
	}

	public function getAvailableAdventures(Application $app){
		$adventures = $app["dao.adventure"]->getActiveAdventures();
		return $app['twig']->render('game/newadventure.html.twig', array("adventures" => $adventures));
	}

	public function newAdventure(Application $app, $id_adventure){
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
		return $app['twig']->render('game/preface-aventure.html.twig', array("adventure" => $adventure));
	}

	public function adventureEditForm(Application $app,Request $request, $id_adventure){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
	    $data = array(
	        "name" => $adventure["name"],
	        "description" => $adventure["description"],
	        "pitch" => $adventure["pitch"]
	    );

	    $adventureform = $app['form.factory']->create(\OrbitalExpress\Form\Type\AdventureType::class, $data);
	    $adventureform->handleRequest($request);

	    if ($adventureform->isValid()) {
	        $data = $adventureform->getData();
	        if (isset($data["name"]) && isset($data["description"]) && isset($data["pitch"])) {
	            $information = array("name" => $data["name"], "description" => $data["description"], "pitch" => $data["pitch"], "id_adventure"=>$id_adventure);
	            $msg = $app["dao.adventure"]->updateAdventure($information);
	            return "Aventure modifiée";
	        }
	        else{
	            throw new \Exception("Veuillez remplir toutes les informations");
	        }
	    }
	    return $app['twig']->render('backoffice/adventureform.html.twig', array('adventureform' => $adventureform->createView()));
	}

	public function toggleAdventure(Application $app, $id_adventure){
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
		$active = $adventure["active"];
		if($active == TRUE){
			$order = FALSE;
		}
		elseif($active == FALSE){
			$order = TRUE;
		}
		$infos = array("id_adventure"=>$id_adventure, "active"=>$order);
		$app["dao.adventure"]->setActiveStatus($infos);
		$url = $app['url_generator']->generate('modifyadventure', ['id_adventure' =>$id_adventure]);
		return $app->redirect($url);

	}

	public function createAdventureBackup(Application $app){

	}
}
