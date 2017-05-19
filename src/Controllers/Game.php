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
	public function testJson() {
		return array('kikoo' => "lol");
	}

	public function testingJs(Application $app){
		$id_page = $_POST["id_page"];
		$story = $app["dao.page"]->getStoryById($id_page);
		return array("story" => $story);	
	}
}

