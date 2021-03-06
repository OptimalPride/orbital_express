<?php

namespace OrbitalExpress\Controllers;

use Silex\Application;

class Game
{
	public function getPageInfo(Application $app){
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
			$infos_save = array(
				"id_save" => $id_save,
				"id_current_page" => $id_landing_page
			);
			$app["dao.save"]->updateSave($infos_save);
			$page = $app["dao.page"]->getContentById($id_landing_page);
			if($page["ending"] != NULL){
				if($page["ending"] == "success"){
					return array("cheat" => "false", "page" => $page, "choices" => "", "ending"=>"success");
				}
				if($page["ending"] == "fail"){
					return array("cheat" => "false", "page" => $page, "choices" => "", "ending"=>"fail");
				}
			}
			else{
				$choices = $app["dao.choice"]->getChoicesByPageId($id_landing_page);
				return array("cheat" => "false", "page" => $page, "choices" => $choices, "ending"=>"");
			}
		}
	}

	public function startNewGame(Application $app, $id_adventure){
		$id_user = (int) $app['security.token_storage']->getToken()->getUser()->getId_User();
		$id_current_page = $app["dao.page"]->getFirstPageByIdAdventure($id_adventure);
		$id_current_page = (int) $id_current_page["id_page"];
		$adventure_name = $app["dao.adventure"]->getAdventureById($id_adventure);
		$adventure_name = $adventure_name["name"];
		$infos = array("id_user"=>$id_user,"id_current_page"=>$id_current_page, "adventure_name"=>$adventure_name);
		$id_save = $app['dao.save']->createNewSave($infos);
		$app["session"]->set("id_save", $id_save);
		return $app['twig']->render('/game/page-jeu.html.twig', array("id_current_page"=>$id_current_page));
	}

	public function continueGame(Application $app, $id_save){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$infos = array("id_user"=>$id_user, "id_save"=>$id_save);
		$verify_save_owner = $app["dao.save"]->verfifySaveOwnership($infos);
		if($verify_save_owner){
		$app["session"]->set("id_save", $id_save);
		$save = $app["dao.save"]->getSaveByIdSave($id_save);
		$id_current_page = $save["id_current_page"];
		return $app['twig']->render('/game/page-jeu.html.twig', array("id_current_page"=>$id_current_page));
		}
		else{
			return "Ceci n'est pas votre sauvegarde";
		}
	}

	public function successDisplay(Application $app, $id_page){
		$page = $app["dao.page"]->getContentById($id_page);
		return $app['twig']->render('/game/success.html.twig', array("page"=>$page));		
	}

	public function failDisplay(Application $app, $id_page){
		$page = $app["dao.page"]->getContentById($id_page);
		return $app['twig']->render('/game/fail.html.twig', array("page"=>$page));		
	}
}
