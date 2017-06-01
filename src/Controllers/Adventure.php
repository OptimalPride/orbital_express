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
		$adventures = $app["dao.adventure"]->getAllAdventuresInfos();
		if($adventures == NULL){
			return $app['twig']->render('backoffice/gestionadventure.html.twig', array("adventures" => $adventures, "pages" => $pages, "msg" => "Pas d'aventures"));
		}
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

	public function createAdventure(Application $app){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
	    return $app['twig']->render('backoffice/createadventure.html.twig', array());
	}

	public function createAdventureFormProcessing(Application $app){
 		$information = array("name" => $_POST["name"], "description" => $_POST["description"], "pitch" => $_POST["pitch"]);
	    $msg = $app["dao.adventure"]->addNewAdventure($information);
	    return $msg;
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

	public function modifyAdventureFormProcessing(Application $app, $id_adventure){
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
        $information = array("name" => $_POST["name"], "description" => $_POST["description"], "pitch" => $_POST["pitch"], "id_adventure"=>$id_adventure);
        $msg = $app["dao.adventure"]->updateAdventure($information);
        return $msg;
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

	public function createAdventureBackup(Application $app, $id_adventure){
		/*Idea : create a backup generator for an adventure. 
			Export with sql requests: get adventure infos by id_adventure, get pages infos by id_adventure, get choices for each page.
			put infos in a txt file with a write, in the form of sql inserts. Have a import button. First insert adventure, get new id_adventure (lastInsertId()), insert pages with the new the id_adventure, get new id_page for each page and insert choices with new id pages. difficulty : getting the new id_landing_pages. Solution : get id page by pagenumber and id_adventure.
		*/
			return "Feature to be implemented";
	}
}
