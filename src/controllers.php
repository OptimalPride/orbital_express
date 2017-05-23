<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});

$app->match("/page/", function () use ($app){
    return $app['twig']->render('game.html.twig', array());
});


$app->view(function(array $results) {
    
    // TODO check if request is an ajax request
  
    return json_encode($results);
});

$app->match("/gamefunction/", "OrbitalExpress\\Controllers\\Game::getPageInfo");

$app->get("/backoffice/", function () use ($app){
    return $app['twig']->render('backoffice/gestion.html.twig', array());
});


$app->match("/gestionuser/", "OrbitalExpress\\Controllers\\Adventure::afficheGestionUser")->bind("gestionUser");

$app->match("/gestionadventure/", "OrbitalExpress\\Controllers\\Adventure::afficheGestionAdventure")->bind("gestionAdventure");

$app->match("/gestionsave/", "OrbitalExpress\\Controllers\\Adventure::afficheGestionAdventure")->bind("gestionSave");


$app->match("/deleteadventure/{id_adventure}", "OrbitalExpress\\Controllers\\Adventure::deleteAdventure")->bind("deleteadventure");

$app->match("/modifyadventure/{id_adventure}", "OrbitalExpress\\Controllers\\Adventure::modifyAdventure")->bind("modifyadventure");

$app->match("/displayadventure/{id_adventure}", "OrbitalExpress\\Controllers\\Adventure::displayAdventure")->bind("displayadventure");

$app->match("/createadventure/", function (Request $request) use ($app){
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
    return $app['twig']->render('backoffice/createadventure.html.twig', array('form' => $form->createView()));
})->bind("createadventure");
