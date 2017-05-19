<?php 

namespace OrbitalExpress\DAO;

use Doctrine\DBAL\Connection;

abstract class DAO
{
	/**
	*Database connexion
	*
	* @var \Doctrine\DBAL\Connection
	*/
	private $db;

	/**
	* Constructor
	*
	* @param \Doctrine\DBAL\Connection (objet de connexion a la BDD)
	*/
	public function __construct(Connection $db){
		$this->db = $db;
	}


	/**
	* Donne acces a l'objet connection pour nos heritiers (car private)
	*
	* @return \Doctrine\DBAL\Connection The database conection object
	*/
	public function getDb(){
		return $this->db;
	}

	/**
	* Creer un objet a partir de l'Entity a partir d'un array
	*Doit OBLIGATOIREMENT etre redefini chez les heritiers
	*
	*/
	// protected abstract function buildEntityObject(array $row);
	
}


?>