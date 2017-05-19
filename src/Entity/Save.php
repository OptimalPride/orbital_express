<?php 

namespace OrbitalExpress\Entity; 

class Save
{
	private $id_save;
	private $id_user;
	private $id_current_page;
	private $historic;

    public function getId_Save() {
        return $this->id_save;
    }

    public function setId_Save($id_save) {
        $this->id_save = $id_save;
    }

    public function getId_User() {
        return $this->id_user;
    }

    public function setId_User($id_user) {
        $this->id_user = $id_user;
    }

    public function getId_Current_Page() {
        return $this->id_current_page;
    }

    public function setId_Current_Page($id_current_page) {
        $this->id_current_page = $id_current_page;
    }

    public function getHistoric() {
        return $this->historic;
    }

    public function setHistoric($historic) {
        $this->historic = $historic;
    }
}

?>