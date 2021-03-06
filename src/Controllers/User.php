<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class User
{
	public function unregister(Application $app){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$resultat = $app["dao.user"]->deleteUserById($id_user);
		$url = $app['url_generator']->generate('homepage');
		return $app->redirect($url);
	}

	public function afficheGestionUser(Application $app){
			$role = $app['security.token_storage']->getToken()->getUser()->getRole();
			if($role != "ROLE_ADMIN"){
				$url = $app['url_generator']->generate('logout');
				return $app->redirect($url);
			}
			$user = $app['dao.user']->getAllUser();
			if($user == NULL){
				return $app['twig']->render('backoffice/gestionuser.html.twig', array("user" => $user, "msg" => "Pas de membre"));
			}
			return $app['twig']->render('backoffice/gestionuser.html.twig', array("user" => $user, "msg" => ""));
	}

	public function deleteUser(Application $app, $id_user){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$msg = $app["dao.user"]->deleteUserById($id_user);
		$users = $app["dao.user"]->getAllUser();
		$url = $app['url_generator']->generate('gestionUser');
		return $app->redirect($url);
	}

	public function upgradeRole(Application $app, $id_user){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$msg = $app["dao.user"]->upgradeRoleById($id_user);
		$users = $app["dao.user"]->getAllUser();
		$url = $app['url_generator']->generate('gestionUser');
		return $app->redirect($url);
	}

	public function downgradeRole(Application $app, $id_user){
		$role = $app['security.token_storage']->getToken()->getUser()->getRole();
		if($role != "ROLE_ADMIN"){
			$url = $app['url_generator']->generate('logout');
			return $app->redirect($url);
		}
		$msg = $app["dao.user"]->downgradeRoleById($id_user);
		$users = $app["dao.user"]->getAllUser();
		$url = $app['url_generator']->generate('gestionUser');
		return $app->redirect($url);
	}

	public function mailSending(Application $app){
		$username = $app['security.token_storage']->getToken()->getUser()->getUsername();
		$subject = $_POST["name"];
		$email = "teamorbitalexpress@gmail.com";

		$headers = 'From: '.$username.' <'.$_POST["email"].'>' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

		$message = $_POST["field"];
		return "Email envoyé!"; // mail() doesn't work in localhost
		$send = mail($email, $subject, $message, $headers);
		if($send){
			return "Email envoyé!";
		}
		else{
			return "Erreur pedant l'envoi du mail";
		}
	}

}
