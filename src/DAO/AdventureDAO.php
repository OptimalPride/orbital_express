<?php

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;
use orbital_express\Entity\Adventure;

class AdventureDAO extends DAO
{
	public function getAllAdventures(){
		$requete = "SELECT * FROM adventure";
		$resultat = $this->getDb()->fetchAll($requete);
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aventures non trouvées.");
		}
	}

	public function getAdventureById($id_adventure){
		$requete = "SELECT * FROM adventure where id_adventure = ?";
		$resultat = $this->getDb()->fetchAssoc($requete, array($id_adventure));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune aventure à l'id:$id_adventure");
		}
	}

	public function deleteAdventureById($id_adventure){
		$requete = "DELETE FROM adventure WHERE id_adventure = ?";
		if ($this->getDb()->executeUpdate($requete, array($id_adventure))){
			$msg = "Aventure supprimée";
		}
		else {
			$msg = "Erreur pendant la suppression";
		}
		return $msg;
		;
	}

	public function addNewAdventure($information){
		$name = $information["name"];
		$description = $information["description"];
		$pitch = $information["pitch"];

		$requete = "INSERT INTO adventure (name, description, pitch) VALUES (?, ?, ?)";
		if ($this->getDb()->executeUpdate($requete, array($name, $description, $pitch))){
			$msg = "Aventure Ajoutée";
		}
		else {
			$msg = "Erreur pendant l'ajout";
		}
		return $msg;
		;
	}

	public function updateAdventure($information){
		$name = $information["name"];
		$description = $information["description"];
		$pitch = $information["pitch"];
		$requete = "UPDATE adventure(name, description, pitch) VALUES (:name, :description, :pitch)";
		
	}

	protected function buildEntityObject(array $value){
		$adventure = new adventure;

		$adventure -> setId_Adventure($value["id_adventure"]);
		$adventure -> setName($value["name"]);
		$adventure -> setDescription($value["description"]);
		$adventure -> setPitch($value["pitch"]);
		$adventure -> setActive($value["active"]);

		return $adventure;
	}
}


?>
