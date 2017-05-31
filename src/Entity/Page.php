<?php 

namespace OrbitalExpress\Entity; 

class Page
{
	private $id_page;
	private $page_number;
	private $id_adventure;
	private $story;
	private $background;
	private $animation;
	private $ending;

	public function getId_Page() {
		return $this->id_page;
	}

	public function setId_Page($id_page) {
		$this->id_page = $id_page;
	}

	public function getPage_Number() {
		return $this->page_number;
	}

	public function setPage_Number($page_number) {
		$this->page_number = $page_number;
	}

	public function getId_Adventure() {
		return $this->id_adventure;
	}

	public function setId_Adventure($id_adventure) {
		$this->id_adventure = $id_adventure;
	}

	public function getStory() {
		return $this->story;
	}

	public function setStory($story) {
		$this->story = $story;
	}

	public function getBackground() {
		return $this->background;
	}

	public function setBackground($background) {
		$this->background = $background;
	}

	public function getAnimation() {
		return $this->animation;
	}

	public function setAnimation($animation) {
		$this->animation = $animation;
	}

	public function getEnding() {
		return $this->ending;
	}

	public function setEnding($ending) {
		$this->ending = $ending;
	}
}
?>