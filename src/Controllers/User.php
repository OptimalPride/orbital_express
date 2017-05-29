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
}