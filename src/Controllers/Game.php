<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;

class Game
{
	public function getPageInfo(Application $app){
		$id_page = $_POST["id_page"];
		$page = $app["dao.page"]->getContentById($id_page);
		$choices = $app["dao.choice"]->getChoicesByPageId($id_page);
		return array("page" => $page, "choices" => $choices);
	}

	public function testingJs(Application $app){
		$id_page = $_POST["id_page"];
		$story = $app["dao.page"]->getStoryById($id_page);
		return array("story" => $story);	
	}
}

