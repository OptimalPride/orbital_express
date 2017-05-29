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

class Adventure
{

	public function afficheGestionAdventure(Application $app){
		$pages = $app["dao.page"]->getAllPages();
		$adventures = $app["dao.adventure"]->getAllAdventures();
		return $app['twig']->render('backoffice/gestionadventure.html.twig', array("adventures" => $adventures, "pages" => $pages, "msg" => ""));
	}

	public function getAdventures(Application $app){
		$adventures = $app["dao.adventure"]->getAllAdventures();
		return array("adventures" => $adventures);
	}

	public function getAdventureById(Application $app){
		$id_adventure = $_POST["id_adventure"];
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
		$page = $app["dao.page"]->getPagesByIdAdventure($id_adventure);
		return array("adventure" => $adventure, "page" => $page);
	}

	public function deleteAdventure(Application $app, $id_adventure){
		$msg = $app["dao.adventure"]->deleteAdventureById($id_adventure);
		$adventures = $app["dao.adventure"]->getAllAdventures();
		$url = $app['url_generator']->generate('gestionAdventure');
		return $app->redirect($url);
	}

	public function displayAdventure(Application $app, $id_adventure){
		$pages =  $app["dao.page"]->getPagesByIdAdventure($id_adventure);
		return $app['twig']->render('backoffice/displayadventure.html.twig', array("pages" => $pages));
	}

	public function createAdventure(Application $app, Request $request){
	    $data = array(
	        "name" => "Nom de l'aventure",
	        "description" => "Description de l'aventure",
	        "pitch" => "Pitch de l'aventure, l'accroche"
	    );
	    $form = $app['form.factory']->createBuilder(FormType::class, $data)
	        ->add('name')
	        ->add('description')
	        ->add('pitch')
	        ->add('submit', SubmitType::class, [
	            'label' => 'Ajouter aventure',
	        ])
	        ->getForm();

	    $form->handleRequest($request);

	    if ($form->isValid()) {
	        $data = $form->getData();
	        if (isset($data["name"]) && isset($data["description"]) && isset($data["pitch"])) {
	            $information = array("name" => $data["name"], "description" => $data["description"], "pitch" => $data["pitch"]);
	            $msg = $app["dao.adventure"]->addNewAdventure($information);
	            $adventures = $app["dao.adventure"]->getAllAdventures();
	            return $app['twig']->render('backoffice/gestionadventure.html.twig', array("adventures" => $adventures, "msg" => $msg));
	        }
	        else{
	            throw new \Exception("Veuillez remplir toutes les informations");
	        }
	    }
			$url = $app['url_generator']->generate('gestionAdventure');
			return $app->redirect($url);
	}

	public function modifyAdventure(Application $app, Request $request, $id_adventure){
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
    $data = array(
        "name" => $adventure['name'],
        "description" => $adventure['description'],
        "pitch" => $adventure['pitch']
    );
    $form = $app['form.factory']->createBuilder(FormType::class, $data)
        ->add('name')
        ->add('description')
        ->add('pitch')
        ->add('submit', SubmitType::class, [
            'label' => 'Modifier aventure',
        ])
        ->getForm();

    $form->handleRequest($request);

		if ($form->isValid()) {

		}
    return $app['twig']->render('backoffice/modifyadventure.html.twig', array('form' => $form->createView()));
	}

	public function getAvailableAdventures(Application $app){
		$adventures = $app["dao.adventure"]->getActiveAdventures();
		return $app['twig']->render('game/newadventure.html.twig', array("adventures" => $adventures));
	}

	public function newAdventure(Application $app, $id_adventure){
		$adventure = $app["dao.adventure"]->getAdventureById($id_adventure);
		return $app['twig']->render('game/intro.html.twig', array("adventure" => $adventure));
	}
}
