<?php 

namespace OrbitalExpress\Entity;

class Choice
{
	private $id_choice;
	private $id_current_page;
	private $id_landing_page;
	private $crew;
	private $response;

	public function getId_Choice() {
		return $this->id_choice;
	}

	public function setId_Choice($id_choice) {
		$this->id_choice = $id_choice;
	}

	public function getId_Current_Page() {
		return $this->id_current_page;
	}

	public function setId_Current_Page($id_current_page) {
		$this->id_current_page = $id_current_page;
	}

	public function getId_Landing_Page() {
		return $this->id_landing_page;
	}

	public function setId_Landing_Page($id_landing_page) {
		$this->id_landing_page = $id_landing_page;
	}

	public function getCrew() {
		return $this->crew;
	}

	public function setCrew($crew) {
		$this->crew = $crew;
	}

	public function getResponse() {
		return $this->response;
	}

	public function setResponse($response) {
		$this->response = $response;
	}
}

?>