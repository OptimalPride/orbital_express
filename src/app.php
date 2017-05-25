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

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app -> register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login' => '/login', 'check_path' => '/login_check',
              'default_target_path' => '/profil',
              'always_use_default_target_path' => true),
            'users' => function () use ($app) {
                return new OrbitalExpress\DAO\UserDAO($app['db']);
            },
        ),
    ),
));

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    return $twig;
});

$app -> register(new Silex\Provider\DoctrineServiceProvider());

$app->register(new FormServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app["dao.page"] = function($app){
	return new OrbitalExpress\DAO\PageDAO($app["db"]);
};
$app["dao.choice"] = function($app){
	return new OrbitalExpress\DAO\ChoiceDAO($app["db"]);
};


$app["dao.adventure"] = function($app){
	return new OrbitalExpress\DAO\AdventureDAO($app["db"]);
};

$app["dao.user"] = function($app){
    return new OrbitalExpress\DAO\UserDAO($app["db"]);
};

$app["dao.save"] = function($app){
	return new OrbitalExpress\DAO\SaveDAO($app["db"]);
};

return $app;
