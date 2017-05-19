<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app -> register(new Silex\Provider\DoctrineServiceProvider());

$app["dao.page"] = function($app){
	return new OrbitalExpress\DAO\PageDAO($app["db"]);
};
$app["dao.choice"] = function($app){
	return new OrbitalExpress\DAO\ChoiceDAO($app["db"]);
};

return $app;
