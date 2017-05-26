<?php

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;
use OrbitalExpress\Entity\Choice;

class ChoiceDAO extends DAO
{
	public function getChoicesByPageId($id_page){
		$requete = "SELECT * FROM choice where id_current_page = ?";
		$resultat = $this->getDb()->fetchAll($requete, array($id_page));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucun choix à l'id:$id_page");
		}
	}

	protected function buildEntityObject(array $value){
		$choice = new choice;

		$choice -> setId_Choice($value["id_choice"]);
		$choice -> setId_Current_Page($value["id_current_page"]);
		$choice -> setId_Landing_Page($value["id_landing_page"]);
		$choice -> setCrew($value["crew"]);
		$choice -> setResponse($value["respon
			"]);
		
		return $choice;
	}
}
?>
