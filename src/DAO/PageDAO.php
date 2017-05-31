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
			return "Aucune pages à l'id:$id_adventure";
		}
	}

	public function deletePageById($id_page){
		$requete = "DELETE FROM page WHERE id_page = ?";
		if ($this->getDb()->executeUpdate($requete, array($id_page))){
			$msg = "Page supprimée";
		}
		else {
			$msg = "Erreur pendant la suppression";
		}
		return $msg;
		;
	}

	public function getFirstPageByIdAdventure($id_adventure){
		$requete = "SELECT id_page FROM page WHERE page_number = 1 AND id_adventure = ?";
		$resultat = $this->getDb()->fetchAssoc($requete, array($id_adventure));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Pas de page 1 pour cette aventure");
		}
	}

	public function createPage($infos){
	    $page_number = $infos["page_number"];
	    $id_adventure = $infos["id_adventure"];
	    $story = $infos["story"];
	    $ending = $infos["ending"];
	    if ($ending == "non") {
	    	$ending = NULL;
	    }
	    $requete = "INSERT INTO page(page_number, id_adventure, story, ending) VALUES (?,?,?,?)";
	    $resultat = $this->getDb()->executeUpdate($requete, array($page_number, $id_adventure, $story, $ending));
	    if($resultat){
	    	$id_current_page = $this->getDb()->lastInsertId();
			return $id_current_page;
		}
		else{
			throw new \Exception("Erreur pendant la creation de page");
		}
	}

	public function updatePage($infos){
	    $page_number = $infos["page_number"];
	    $story = $infos["story"];
	    $ending = $infos["ending"];
	    $id_page = $infos["id_page"];
	    if ($ending == "non") {
	    	$ending = NULL;
	    }
	    $requete = "UPDATE page set page_number = ?, story = ?, ending = ? WHERE id_page = ?";
	    $resultat = $this->getDb()->executeUpdate($requete, array($page_number, $story, $ending, $id_page));
	    if($resultat){
			return "Update réussi";
		}
		else{
			// throw new \Exception("Erreur pendant l'update de la page");
			return "Erreur pendant l'update de la page";
		}
	}

	public function getPageIdByPageNumber($page_number, $id_adventure){
		$requete = "SELECT id_page FROM page WHERE page_number = ? AND id_adventure = ?";
		$id_page = $this->getDb()->fetchAssoc($requete, array($page_number, $id_adventure));
		if ($id_page) {
			return $id_page;
		}
		else{
			return NULL;
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
		$page -> setEnding($value["ending"]);

		return $page;
	}

}

?>
