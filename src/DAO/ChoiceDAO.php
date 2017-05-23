<?php

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;
use orbital_express\Entity\Choice;

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
}
?>
