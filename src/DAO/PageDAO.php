<?php

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;
use OrbitalExpress\Entity\Page;

class PageDAO extends DAO
{

	public function getAllPages(){
		$requete = "SELECT * FROM page";
		$resultat = $this->getDb()->fetchAll($requete, array());
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune histoire dans la base de donnée");
		}
	}

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
	protected function buildEntityObject(array $value){
		$page = new page;

		$page -> setId_Page($value["id_page"]);
		$page -> setPage_Number($value["page_number"]);
		$page -> setId_Adventure($value["id_adventure"]);
		$page -> setStory($value["story"]);
		$page -> setBackground($value["background"]);
		$page -> setAnimation($value["animation"]);

		return $page;
	}

}

?>
