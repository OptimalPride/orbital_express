<?php

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;
use orbital_express\Entity\Page;

class PageDAO extends DAO
{
	public function getContentById($id_page){
		$requete = "SELECT * FROM page where id_page = ?";
		$resultat = $this->getDb()->fetchAssoc($requete, array($id_page));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune histoire à l'id:$id_page");
		}
	}
	
	public function getPagesByIdAdventure($id_adventure){
		$requete = "SELECT * FROM page where id_adventure = ?";
		$resultat = $this->getDb()->fetchAll($requete, array($id_adventure));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune pages à l'id:$id_adventure");
		}
	}
}

?>
