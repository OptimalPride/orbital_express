<?php 

namespace OrbitalExpress\Entity; 

class Adventure
{
	private $id_adventure;
	private $name;
	private $description;
	private $pitch;
	private $active;

    public function getId_Adventure() {
        return $this->id_adventure;
    }

    public function setId_Adventure($id_adventure) {
        $this->id_adventure = $id_adventure;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPitch() {
        return $this->pitch;
    }

    public function setPitch($pitch) {
        $this->pitch = $pitch;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }
}


?>