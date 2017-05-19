<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;

class Game
{
	public function afficheStory(Application $app, $id_page){
		$page = $app["dao.page"]->getStoryById($id_page);
		$choices = $app["dao.choice"]->getChoicesByPageId($id_page);
		return $app['twig']->render('game.html.twig', ["page" => $page, "choices" => $choices]);
	}

}
