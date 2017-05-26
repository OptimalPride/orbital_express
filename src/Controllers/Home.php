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
			$infos = array("redirect"=> "false", "display" => $app['twig'] -> render('login.html.twig', $params));
			return $infos;
		}

	public function index(Application $app){
		return $app['twig']->render('index.html.twig');
	}
  
	public function sessionSet(Application $app){
		if($_POST){
			$id_user = $_POST["id_user"];
			$username = $_POST["username"];
			$email = $_POST["email"];
			$role = $_POST["role"];
			$app['session']->set("user", array(
				"id_user" => $id_user,
				"username" => $username,
				"email" => $email,
				"role" => $role
			));
		}
		return "session set done";
	}
}

?>
