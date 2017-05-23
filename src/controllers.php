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

$app->match("/createadventure/", "OrbitalExpress\\Controllers\\Adventure::createAdventure")->bind("createadventure");
