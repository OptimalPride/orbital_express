<?php 

namespace OrbitalExpress\Entity; 

use Symfony\Component\Security\Core\User\UserInterface;

class User
{
	private $id_user;
	private $username;
	private $email;
	private $password;
	private $avatar;
	private $role;

    public function getId_User() {
        return $this->id_user;
    }

    public function setId_User($id_user) {
        $this->id_user = $id_user;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

	public function getRole(){
		return $this ->role;
	}

	public function setRole($role){
		$this ->role = $role;
	}

	/**
	* @inheritDoc
	*/
	public function getRoles(){
		return array($this -> getRole());
	}

	/**
	* @inheritDoc
	*/
	public function eraseCredentials(){
		// Nothing here
	}
}

?>