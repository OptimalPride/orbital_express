<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpKernel\HttpKernelInterface;



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
    return $app['twig']->render('page-jeu.html.twig', array());
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

$app->match("/gestionsave/", "OrbitalExpress\\Controllers\\Adventure::afficheGestionSave")->bind("gestionSave");


$app->match("/deleteadventure/{id_adventure}", "OrbitalExpress\\Controllers\\Adventure::deleteAdventure")->bind("deleteadventure");

$app->match("/modifyadventure/{id_adventure}", "OrbitalExpress\\Controllers\\Adventure::modifyAdventure")->bind("modifyadventure");

$app->match("/displayadventure/{id_adventure}", "OrbitalExpress\\Controllers\\Adventure::displayAdventure")->bind("displayadventure");

$app->match("/createadventure/", "OrbitalExpress\\Controllers\\Adventure::createAdventure")->bind("createadventure");

$app->match("/login/" , "OrbitalExpress\\Controllers\\Home::login")
->bind('login');

$app->get("/profil/{id}", function($id) use ($app){
	$user = $app["dao.user"]->find($id);

	$params = array(
		"user" => $user,
	);
  return $app["twig"]->render("profil.html.twig", $params);
}) -> bind("profil");

$app->match("/login/redirect" , "OrbitalExpress\\Controllers\\Home::index")
->bind('home_index');

// START REGISTER
$app -> match("/register/", function(Request $request) use($app){

	$user = new OrbitalExpress\Entity\User;
	$userForm = $app["form.factory"] -> create(OrbitalExpress\Form\Type\Usertype::class, $user);
	$userForm -> handleRequest($request);

	if($userForm->isSubmitted() && $userForm->isValid()){
		$username = $user -> getUsername();

		if($app["dao.user"]->verifyIfNameTaken($username)){
			return "Pseudo indisponible";
		}
		else{
			$salt = substr(md5(time()), 0, 23);
			$user -> setSalt($salt);
			$password = $user-> getPassword(); // 'Bonjour'
			$password_encode = $app["security.encoder.bcrypt"]->encodePassword($password, $user->getSalt());

			$user->setPassword($password_encode);
			$app["dao.user"]->save($user);
			$app["session"]->getFlashBag()->add("success", "votre inscription a été prise en compte");
			// return $app["twig"]->render("index.html.twig");

			return "ça marche !!";
		}

	}
	$userFormView = $userForm->createView();

	$params = array(
		"userForm" => $userForm->createView()
	);

	 return $app["twig"]->render("register.html.twig", $params);

}) -> bind("register");

$app->match("/goprofil/", function () use ($app){
    $infos = array("redirect" => "true");
    return $infos;
    // return $app->redirect($app["url_generator"]->generate("profil"));
});

$app->match("/profil/", function () use ($app){
	$userTest = $app["session"]->get("user");
    return $app['twig']->render('profil.html.twig', array("userTest" =>$userTest));
})->bind('profil');

$app->match("/contact/", function () use ($app){
    return $app['twig']->render('support.html.twig', array());
})->bind('contact');

$app->match("/tableau/", function () use ($app){
    return $app['twig']->render('tableau-de-bord.html.twig', array());
})->bind('tableau');

$app->match("/unregister/{id_user}", "OrbitalExpress\\Controllers\\User::unregister")->bind("unregister");