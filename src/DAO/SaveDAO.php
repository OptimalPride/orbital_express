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
			return NULL;
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

	public function updateSave(array $infos){
		$requete = "UPDATE save SET id_current_page = ? WHERE id_save = ?";
		$id_current_page = $infos["id_current_page"];
		$id_save = $infos["id_save"];
		if ($this->getDb()->executeUpdate($requete, array($id_current_page, $id_save))){
			$msg = "sauvegarde réussie";
		}
		else {
			$msg = "Erreur pendant l'update de la sauvegarde";
		}
		return $msg;
	}

	public function deleteSaveById($id_save){
		$requete = "DELETE FROM save WHERE id_save = ?";
		if ($this->getDb()->executeUpdate($requete, array($id_save))){
			$msg = "Progression supprimée";
		}
		else {
			$msg = "Erreur pendant la suppression";
		}
		return $msg;
		;
	}
	
	public function createNewSave(array $infos){
		$id_user = $infos["id_user"];
		$id_current_page = $infos["id_current_page"];
		$adventure_name = $infos["adventure_name"];
		$time_frame = date('d/m/Y H\hi');
		$requete = "INSERT INTO save (id_user, id_current_page, adventure_name, time_frame) VALUES (?, ?, ?, ?)";
		$resultat = $this->getDb()->executeUpdate($requete, array($id_user, $id_current_page, $adventure_name, $time_frame));
		$id_save = $this->getDb()->lastInsertId();
		return $id_save;
	}

	public function verfifySaveOwnership(array $infos){
		$id_save = $infos["id_save"];
		$id_user = $infos["id_user"];
		$requete = "SELECT * FROM save WHERE id_save = ? AND id_user = ?";
		$resultat = $this->getDb()->fetchAssoc($requete, array($id_save, $id_user));
		if($resultat){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	protected function buildEntityObject(array $value){
		$save = new save;

		$save -> setId_Save($value["id_save"]);
		$save -> setId_User($value["id_user"]);
		$save -> setId_Current_Page($value["id_current_page"]);
		$save -> setHistoric($value["historic"]);
		$save -> setTime_Frame($value["time_frame"]);
		$save -> setAdventure_Name($value["adventure_name"]);

		return $save;
	}
}
?>
