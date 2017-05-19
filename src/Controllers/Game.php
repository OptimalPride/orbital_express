<?php 

namespace OrbitalExpress\Controllers;

use Silex\Application;

class Game
{
	public function afficheStory(Application $app, $id_page){
		$story = $app["dao.page"]->getStoryById($id_page);
		return $app['twig']->render('game.html.twig', ["story" => $story]);
	}
}