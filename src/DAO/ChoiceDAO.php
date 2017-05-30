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

	public function getAllChoices(){
		$requete = "SELECT * FROM choice";
		$resultat = $this->getDb()->fetchAll($requete, array());
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucun choix dans la bdd");
		}
	}

	public function createChoicesForAPage($choices){

		$id_current_page = $choices["id_current_page"];

		if($choices["1"]["id_landing_page"] == ""){
			$choices["1"]["id_landing_page"] = NULL;
		}
		if($choices["2"]["id_landing_page"] == ""){
			$choices["2"]["id_landing_page"] = NULL;
		}
		if($choices["3"]["id_landing_page"] == ""){
			$choices["3"]["id_landing_page"] = NULL;
		}

		$requete = "INSERT INTO choice(id_current_page, id_landing_page, crew, response) VALUES(?,?,?,?),(?,?,?,?),(?,?,?,?)";

	    $resultat = $this->getDb()->executeUpdate($requete, array($id_current_page, $choices["1"]["id_landing_page"], $choices["1"]["crew"], $choices["1"]["response"], $id_current_page, $choices["2"]["id_landing_page"], $choices["2"]["crew"], $choices["2"]["response"], $id_current_page, $choices["3"]["id_landing_page"], $choices["3"]["crew"], $choices["3"]["response"]));
	    if($resultat){
			return "Choix ajoutés";
		}
		else{
			throw new \Exception("Erreur pendant l'ajout des choix");
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
