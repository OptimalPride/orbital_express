<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;

class Game
{
	public function getPageInfo(Application $app){
		$app["session"]->set("id_save", 1);
		$id_save = $app["session"]->get("id_save");
		$id_landing_page = (int) $_POST["id_landing_page"];
		$id_current_page = (int) $_POST["id_current_page"];
		$infos = array(
			"id_save" => $id_save,
			"id_current_page" => $id_current_page
		);
		$cheat_detect = $app["dao.save"]->verifyPageBySave($infos);
		if ($cheat_detect) {
			return array("cheat" => "true", "message" => "Ce n'est pas bien de tricher.");
		}
		else{
			$page = $app["dao.page"]->getContentById($id_landing_page);
			$choices = $app["dao.choice"]->getChoicesByPageId($id_landing_page);
			return array("page" => $page, "choices" => $choices);
		}
	}
}
