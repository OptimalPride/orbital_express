CREATE DATABASE orbital_express;

USE orbital_express;

CREATE TABLE IF NOT EXISTS User (
  id_user INT(5) NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(128) NOT NULL,
  avatar VARCHAR(50) DEFAULT NULL,
  role VARCHAR(20) DEFAULT "ROLE_USER",
  salt VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Save (
  id_save INT(5) NOT NULL AUTO_INCREMENT,
  id_user INT(5) NOT NULL,
  id_current_page INT(5) NOT NULL,
  historic VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_save),
  FOREIGN KEY (id_user) REFERENCES User (id_user) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_current_page) REFERENCES page (id_page) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Adventure (
  id_adventure INT(5) NOT NULL AUTO_INCREMENT,
  name VARCHAR(20) NOT NULL,
  description VARCHAR(200) NOT NULL,
  pitch VARCHAR(2000) NOT NULL,
  active BOOLEAN DEFAULT FALSE,
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
  FOREIGN KEY (id_adventure) REFERENCES Adventure (id_adventure) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE Page ADD INDEX(page_number);

CREATE TABLE IF NOT EXISTS Choice (
  id_choice INT(5) NOT NULL AUTO_INCREMENT,
  id_current_page INT(5) NOT NULL,
  id_landing_page INT(5) DEFAULT NULL,
  crew VARCHAR(20) NOT NULL,
  response VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_choice),
  FOREIGN KEY (id_current_page) REFERENCES Page (id_page) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_landing_page) REFERENCES Page (id_page) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO Adventure (id_adventure, name, description, pitch, active) 
values (1, "test", "test de db", "ceci est un test", true);

INSERT INTO 
`page` (`id_page`, `page_number`, `id_adventure`, `story`, `background`, `animation`) 
VALUES ('1', '1', '1', 'Ceci est la page un', 'background1', 'anim1'), 
('2', '2', '1', 'Ceci est la page deux', 'background2', 'sdd2'), 
('3', '3', '1', 'Ceci est la page 3', 'background3', 'sdd3'), 
('4', '4', '1', 'Ceci est la page 4', 'background4', 'sdd4');


INSERT INTO 
`choice` (`id_choice`, `id_current_page`, `id_landing_page`, `crew`, `response`) 
VALUES ('1', '1', '2', 'Jonhson', 'reponse jonhson'), 
('2', '1', '3', 'Sabrovich', 'reponse sabrovich'), 
('3', '1', '4', 'Hans', 'Reponse Hans'),
('4', '2', NULL, 'Jonhson', 'Reponse Jonhson 2'),
('5', '2', NULL, 'Sabrovich', 'Reponse Sabrovich 2'),
('6', '2', NULL, 'Hans', 'Reponse Hans 2'),
('7', '3', NULL, 'Jonhson', 'Reponse HanJonhsons 3'),
('8', '3', NULL, 'Sabrovich', 'Reponse Sabrovich 3'),
('9', '3', NULL, 'Hans', 'Reponse Hans 3'),
('10', '4', NULL, 'Jonhson', 'Reponse Jonhson 4'),
('11', '4', NULL, 'Sabrovich', 'Reponse Sabrovich 4'),
('12', '4', NULL, 'Hans', 'Reponse Hans 4');