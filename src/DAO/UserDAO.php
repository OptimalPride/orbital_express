<?php

namespace OrbitalExpress\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use OrbitalExpress\Entity\User;

class UserDAO extends DAO implements UserProviderInterface
{
  public function getAllUser(){
		$requete = "SELECT id_user, username, email, role FROM user";
		$resultat = $this->getDb()->fetchAll($requete, array());
		if($resultat){
			return $resultat;
		}
		else{
			throw new \Exception("Aucun membre dans la base de donnée");
		}
	}

  public function loadUserByUsername($username){
    $requete = "SELECT * FROM user WHERE username = ?";
    $resultat = $this -> getDb() -> fetchAssoc($requete, array($username));

    if($resultat){
      return $this -> buildEntityObject($resultat);
    }
    else{
      throw new UsernameNotFoundException("L'utilisateur n'existe pas :" . $username);
    }
  }

  public function supportsClass($class){
		return 'OrbitalExpress\Entity\User' === $class;
	}

  public function refreshUser(UserInterface $user){
		$class = get_class($user);
		if(!$this -> supportsClass($class)){
			throw new UnsupportedUserException('La classe instanciée n\'est pas supportée : ' . $class);
		}
		return $this -> loadUserByUsername($user -> getUsername());
	}

	public function verifyIfNameTaken($username){
		$requete = "SELECT * FROM user WHERE username = ?";
		$resultat = $this -> getDb() -> fetchAssoc($requete, array($username));
		if($resultat){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

  public function findAll(){
		$requete = "SELECT * FROM user";
		$resultat = $this -> getDb() -> fetchAll($requete);


		$alluser = array();
		foreach($resultat as $value){
			$id_user = $value['id_user'];

			$alluser[$id_user] = $this -> buildEntityObject($value);
		}
		return $alluser;
	}

  /**
	* Retourne un objet de la classe User.
	*
	* @param integer $id_user The user id_user.
	*
	* @return \OrbitalExpress\Entity\User|throws an exception si pas de matching
	*/
  public function find($id_user){
    $requete = "SELECT * FROM user WHERE id_user = ?";
    $resultat = $this -> getDb() -> fetchAssoc($requete, array($id_user));

    if($resultat){
      return $this -> buildEntityObject($resultat);
    }
    else{
      throw new \Exception("Aucun membre à l'id:" . $id_user);
    }
  }

  protected function buildEntityObject(array $resultat){
    $user = new User();
    $user -> setId_user($resultat['id_user']);
    $user -> setUsername($resultat['username']);
    $user -> setEmail($resultat['email']);
    $user -> setPassword($resultat['password']);

    $user -> setRole($resultat['role']);
    $user -> setSalt($resultat['salt']);

    return $user;

  }

  public function save(User $user){
		$userData = array(
      "id_user" => $user -> getId_user(),
			"username" => $user -> getUsername(),
			"password" => $user -> getPassword(),
			"email" => $user -> getEmail(),

      "role" => $user -> getRole(),
			"salt" => $user -> getSalt()
		);

		if($user -> getId_user()){ // dans le cas d'une modif
			$userData["role"] = $user -> getRole();

			$this -> getDb() -> update("user", $userData, array("id_user"=>$user->getId_user()));
		}
		else{ // dans le cas d'une inscription
			$userData["role"] = 'ROLE_USER';
			$this->getDb()->insert("user", $userData);

			$user->setId_User($this->getDb()->lastInsertId());
		}
	}

	public function getUserData(){
		$user = $this->get('security.token_storage')->getToken()->getUser();
		return $user;
	}

	public function deleteUserById($id_user){
		$requete = "DELETE FROM user WHERE id_user = ?";
		$resultat = $this->getDb()->executeUpdate($requete, array($id_user));
		if($resultat){
			return "Utilisateur supprimé";
		}
		else{
			return "Erreur pedant la suppression";
		}
	}
}












?>
