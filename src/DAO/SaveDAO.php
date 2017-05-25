<?php

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;
use OrbitalExpress\Entity\Save;

class SaveDAO extends DAO
{

	public function getAllSaves(){
		$requete = "SELECT * FROM save";
		$resultat = $this->getDb()->fetchAll($requete, array());
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune sauvegarde dans la base de donnée");
		}
	}

	public function getAllSavesByIdUser($id_user){
		$requete = "SELECT * FROM save where id_user = ?";
		$resultat = $this->getDb()->fetchAll($requete, array($id_user));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune sauvegarde pour l'id:$id_user");
		}
	}

	public function getSaveByIdSave($id_save){
		$requete = "SELECT * FROM save where id_save = ?";
		$resultat = $this->getDb()->fetchAssoc($requete, array($id_save));
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucune sauvegarde à l'id:$id_save");
		}
	}

	public function verifyPageBySave(array $infos){
		$requete = "SELECT id_current_page FROM save where id_save = ?";
		$id_save = $infos["id_save"];
		$id_current_page = $infos["id_current_page"];
		$resultat = $this->getDb()->fetchAssoc($requete, array($id_save));
		if($resultat["id_current_page"] == $id_current_page){
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	protected function buildEntityObject(array $value){
		$save = new save;

		$save -> setId_Save($value["id_save"]);
		$save -> setId_User($value["id_user"]);
		$save -> setId_Current_Page($value["id_current_page"]);
		$save -> setHistoric($value["historic"]);

		return $save;
	}
}
?>
