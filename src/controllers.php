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

$app->match("/test/json", "OrbitalExpress\\Controllers\\Game::testJson");

$app->match("/testing/", "OrbitalExpress\\Controllers\\Game::testingJs");

$app->view(function(array $results) {

    // TODO check if request is an ajax request

    return json_encode($results);
});

$app->match("/gamefunction/", "OrbitalExpress\\Controllers\\Game::getPageInfo");

$app->match("/login" , "OrbitalExpress\\Controllers\\Home::login")
->bind('login');

$app->match("/login/redirect" , "OrbitalExpress\\Controllers\\Home::index")
->bind('home_index');

$app -> match("/register", function(Request $request) use($app){

	$user = new OrbitalExpress\Entity\User;
	$userForm = $app["form.factory"] -> create(OrbitalExpress\Form\Type\Usertype::class, $user);
	$userForm -> handleRequest($request);

	if($userForm->isSubmitted() && $userForm->isValid()){
		$salt = substr(md5(time()), 0, 23);
		$user -> setSalt($salt);

		$password = $user-> getPassword(); // 'Bonjour'
		$password_encode = $app["security.encoder.bcrypt"]->encodePassword($password, $user->getSalt());

		$user->setPassword($password_encode);
		$app["dao.user"]->save($user);
		$app["session"]->getFlashBag()->add("success", "votre inscription a été prise en compte");
	}
	$userFormView = $userForm->createView();

	$params = array(
		"title" => "Inscription",
		"userForm" => $userFormView
	);

	return $app["twig"]->render("register.html.twig", $params);

}) -> bind("register");
