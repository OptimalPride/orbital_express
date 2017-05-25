<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Home
{
	public function hello(Application $app, $name){
		return $app['twig']->render('home/hello.html.twig', ["name" => $name]);
	}

	public  function login(Request $request, Application $app) {
			$params = array(
				'error' => $app['security.last_error']($request),
				'last_username' => $app['session'] -> get('_security.last_username'),
				'title' =>	'Connexion'
			);

			return $app['twig'] -> render('login.html.twig', $params);

		}

	public function index( Application $app){
		return $app['twig']->render('index.html.twig');
	}

	public function getRegister(Application $app, Request $request){
		$user = new \OrbitalExpress\Entity\User;
		$userForm = $app["form.factory"] -> create(\OrbitalExpress\Form\Type\Usertype::class, $user);
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
			"userForm" => $userForm->createView()
		);

		 return $app["twig"]->render("register.html.twig", $params);
	}
}

?>
