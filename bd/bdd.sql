CREATE DATABASE orbital_express;

USE orbital_express;

CREATE TABLE IF NOT EXISTS User (
  id_user INT(5) NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(128) NOT NULL,
  avatar VARCHAR(50) DEFAULT NULL,
  role VARCHAR(20) DEFAULT "ROLE_USER",
  PRIMARY KEY (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Save (
  id_save INT(5) NOT NULL AUTO_INCREMENT,
  id_user INT(5) NOT NULL,
  id_current_page INT(5) NOT NULL,
  historic VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_save),
  FOREIGN KEY (id_user) REFERENCES User (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Adventure (
  id_adventure INT(5) NOT NULL,
  name VARCHAR(20) NOT NULL,
  description VARCHAR(200) NOT NULL,
  pitch VARCHAR(2000) NOT NULL,
  active BOOLEAN,
  PRIMARY KEY (id_adventure)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Page (
  id_page INT(5) NOT NULL AUTO_INCREMENT,
  page_number INT(5) NOT NULL,
  id_adventure INT(5) NOT NULL,
  story VARCHAR(1000) NOT NULL,
  background VARCHAR(50) NOT NULL,
  animation VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_page),
  FOREIGN KEY (id_adventure) REFERENCES Adventure (id_adventure)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE Page ADD INDEX(page_number);

CREATE TABLE IF NOT EXISTS Choice (
  id_choice INT(5) NOT NULL,
  id_current_page INT(5) NOT NULL,
  id_landing_page INT(5) NOT NULL,
  crew VARCHAR(20) NOT NULL,
  response VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_choice),
  FOREIGN KEY (id_current_page) REFERENCES Page (page_number),
  FOREIGN KEY (id_landing_page) REFERENCES Page (page_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Adventure (id_adventure, name, description, pitch, active) values (1, "test", "test de db", "ceci est un test", true);