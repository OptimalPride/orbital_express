<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;

class Adventure
{

	public function afficheGestionAdventure(Application $app){
		$adventures = $app["dao.adventure"]->getAllAdventures();
		return $app['twig']->render('backoffice/gestionadventure.html.twig', array("adventures" => $adventures, "msg" => ""));
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
		return $app['twig']->render('backoffice/gestionadventure.html.twig', array("adventures" => $adventures, "msg" => $msg));
	}

	public function displayAdventure(Application $app, $id_adventure){
		$pages =  $app["dao.page"]->getPagesByIdAdventure($id_adventure);
		return $app['twig']->render('backoffice/displayadventure.html.twig', array("pages" => $pages));
	}

	public function modifyAdventure(Application $app, Request $request, $id_adventure){
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

    }
    return $app['twig']->render('backoffice/modifyAdventure.html.twig', array('form' => $form->createView()));
	}
}

