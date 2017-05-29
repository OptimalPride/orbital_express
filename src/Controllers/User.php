<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class User
{
	public function unregister(Application $app){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$resultat = $app["dao.user"]->deleteUserById($id_user);
		$url = $app['url_generator']->generate('homepage');
		return $app->redirect($url);
	}

	public function afficheGestionUser(Application $app){
			$user = $app['dao.user']->getAllUser();
			return $app['twig']->render('backoffice/gestionuser.html.twig', array("user" => $user, "msg" => ""));
	}

	public function deleteUser(Application $app, $id_user){
		$msg = $app["dao.user"]->deleteUserById($id_user);
		$users = $app["dao.user"]->getAllUser();
		$url = $app['url_generator']->generate('gestionUser');
		return $app->redirect($url);
	}

}
