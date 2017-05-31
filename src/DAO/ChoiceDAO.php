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
			return "Page et choix ajoutés";
		}
		else{
			return "Erreur pendant l'ajout des choix";
		}
	}

	public function updateChoicesForAPage($choices){

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

		$requete = "UPDATE choice c1 JOIN choice c2 JOIN choice c3 ON c1.id_choice = ? AND c2.id_choice = ? AND c3.id_choice = ? SET c1.id_landing_page = ?, c1.crew = ?, c1.response = ?, c2.id_landing_page = ?, c2.crew = ?, c2.response = ?, c3.id_landing_page = ?, c3.crew = ?, c3.response = ?";

	    $resultat = $this->getDb()->executeUpdate($requete, array($choices["1"]["id_choice"], $choices["2"]["id_choice"], $choices["3"]["id_choice"], $choices["1"]["id_landing_page"], $choices["1"]["crew"], $choices["1"]["response"], $choices["2"]["id_landing_page"], $choices["2"]["crew"], $choices["2"]["response"], $choices["3"]["id_landing_page"], $choices["3"]["crew"], $choices["3"]["response"]));

	    if($resultat){
			return "choix modifiés";
		}
		else{
			return "choix non modifiés";
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
