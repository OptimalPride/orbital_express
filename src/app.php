<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Silex\Provider\FormServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    return $twig;
});

$app -> register(new Silex\Provider\DoctrineServiceProvider());

$app->register(new FormServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app["dao.page"] = function($app){
	return new OrbitalExpress\DAO\PageDAO($app["db"]);
};
$app["dao.choice"] = function($app){
	return new OrbitalExpress\DAO\ChoiceDAO($app["db"]);
};

$app["dao.adventure"] = function($app){
	return new OrbitalExpress\DAO\AdventureDAO($app["db"]);
};

return $app;
