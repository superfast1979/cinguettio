/*
SQLyog Community v12.2.4 (64 bit)
MySQL - 10.1.8-MariaDB : Database - cinguettio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cinguettio` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cinguettio`;

/*Table structure for table `cinguettio` */

DROP TABLE IF EXISTS `cinguettio`;

CREATE TABLE `cinguettio` (
  `IdProg` int(11) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `DataOraCreazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdProg`,`Email`),
  KEY `Email` (`Email`),
  CONSTRAINT `cinguettio_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `utente` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cinguettio` */

/*Table structure for table `citta` */

DROP TABLE IF EXISTS `citta`;

CREATE TABLE `citta` (
  `NomeC` varchar(30) NOT NULL,
  `PrefissoTel` varchar(5) NOT NULL,
  `Targa` char(2) NOT NULL,
  `CAP` char(5) NOT NULL,
  PRIMARY KEY (`NomeC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `citta` */

insert  into `citta`(`NomeC`,`PrefissoTel`,`Targa`,`CAP`) values 
('','','',''),
('Milano','02','MI','20100'),
('Viterbo','0761','VT','01100');

/*Table structure for table `commento` */

DROP TABLE IF EXISTS `commento`;

CREATE TABLE `commento` (
  `Email` varchar(30) NOT NULL,
  `NomeF` varchar(30) NOT NULL,
  `TestoC` varchar(50) NOT NULL,
  `DataOraC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Email`),
  UNIQUE KEY `NomeF` (`NomeF`),
  CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `esperto` (`Email`),
  CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`NomeF`) REFERENCES `foto` (`NomeF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `commento` */

/*Table structure for table `esperto` */

DROP TABLE IF EXISTS `esperto`;

CREATE TABLE `esperto` (
  `Email` varchar(30) NOT NULL,
  `DataUpgrade` date NOT NULL,
  PRIMARY KEY (`Email`),
  CONSTRAINT `esperto_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `utente` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `esperto` */

/*Table structure for table `foto` */

DROP TABLE IF EXISTS `foto`;

CREATE TABLE `foto` (
  `IdProg` int(11) NOT NULL,
  `Path` varchar(150) NOT NULL,
  `NomeF` varchar(30) NOT NULL,
  `Descrizione` varchar(50) NOT NULL,
  `DataCaricamento` date NOT NULL,
  `Apprezzamento` char(1) DEFAULT NULL,
  PRIMARY KEY (`IdProg`),
  UNIQUE KEY `NomeF` (`NomeF`),
  CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`IdProg`) REFERENCES `cinguettio` (`IdProg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `foto` */

/*Table structure for table `luogo` */

DROP TABLE IF EXISTS `luogo`;

CREATE TABLE `luogo` (
  `IdProg` int(11) NOT NULL,
  `Latitudine` varchar(10) NOT NULL,
  `Longitudine` varchar(10) NOT NULL,
  PRIMARY KEY (`IdProg`),
  CONSTRAINT `luogo_ibfk_1` FOREIGN KEY (`IdProg`) REFERENCES `cinguettio` (`IdProg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luogo` */

/*Table structure for table `segue` */

DROP TABLE IF EXISTS `segue`;

CREATE TABLE `segue` (
  `UtenteA` varchar(30) NOT NULL,
  `UtenteB` varchar(30) NOT NULL,
  PRIMARY KEY (`UtenteA`),
  UNIQUE KEY `UtenteB` (`UtenteB`),
  CONSTRAINT `segue_ibfk_1` FOREIGN KEY (`UtenteA`) REFERENCES `utente` (`Email`),
  CONSTRAINT `segue_ibfk_2` FOREIGN KEY (`UtenteB`) REFERENCES `utente` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `segue` */

/*Table structure for table `testo` */

DROP TABLE IF EXISTS `testo`;

CREATE TABLE `testo` (
  `IdProg` int(11) NOT NULL,
  `Testo` varchar(150) NOT NULL,
  `Inappropriato` char(1) DEFAULT NULL,
  PRIMARY KEY (`IdProg`),
  CONSTRAINT `testo_ibfk_1` FOREIGN KEY (`IdProg`) REFERENCES `cinguettio` (`IdProg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `testo` */

/*Table structure for table `utente` */

DROP TABLE IF EXISTS `utente`;

CREATE TABLE `utente` (
  `Email` varchar(30) NOT NULL,
  `Pswd` varchar(16) NOT NULL,
  `Nickname` varchar(15) NOT NULL,
  `Nome` varchar(20) DEFAULT NULL,
  `Cognome` varchar(20) DEFAULT NULL,
  `DataNascita` date DEFAULT NULL,
  `LuogoNascita` varchar(30) DEFAULT NULL,
  `Sesso` char(1) DEFAULT NULL,
  `Hobby` varchar(50) DEFAULT NULL,
  `NomeC` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Email`),
  KEY `utente_ibfk_1` (`NomeC`),
  CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`NomeC`) REFERENCES `citta` (`NomeC`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `utente` */

insert  into `utente`(`Email`,`Pswd`,`Nickname`,`Nome`,`Cognome`,`DataNascita`,`LuogoNascita`,`Sesso`,`Hobby`,`NomeC`) values 
('ciao@me.it','0000','pluto','Giovanni','Versi','1991-04-03','Roma','M','Tennis','Viterbo'),
('ecco@mi.com','punto','minni','','','0000-00-00','','','','Milano'),
('io@tu.it','1234','pippo','Mario','Rossi','1978-05-02','Parma','M','Calcio',NULL),
('noi@loro.it','4567','topolino',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
('sono@qui.it','cocco','paperino',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
