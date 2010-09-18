-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.6


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema mepsol
--

CREATE DATABASE IF NOT EXISTS mepsol;
USE mepsol;
CREATE TABLE  `mepsol`.`connections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `expr` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
INSERT INTO `mepsol`.`connections` VALUES  (32,127,131,''),
 (44,131,128,'Share'),
 (43,131,130,'Limited'),
 (42,131,129,'Individual'),
 (45,130,134,'');
CREATE TABLE  `mepsol`.`services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
INSERT INTO `mepsol`.`services` VALUES  (1,'Uzņēmuma reģistrācija','Kā reģistrēt uzņēmumus, dažādām komercdarbības formām?'),
 (6,'lalala','la');
CREATE TABLE  `mepsol`.`states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `w` float NOT NULL,
  `h` float NOT NULL,
  `type` char(1) CHARACTER SET latin1 NOT NULL,
  `description_lv` text NOT NULL,
  `description_gr` text NOT NULL,
  `description_en` text NOT NULL,
  `info_lv` text NOT NULL,
  `info_gr` text NOT NULL,
  `info_en` text NOT NULL,
  `document_lv` text NOT NULL,
  `document_gr` text NOT NULL,
  `document_en` text NOT NULL,
  `video_link_lv` text NOT NULL,
  `video_link_gr` text NOT NULL,
  `video_link_en` text NOT NULL,
  `question_lv` text NOT NULL,
  `question_gr` text NOT NULL,
  `question_en` text NOT NULL,
  `answers_lv` text NOT NULL,
  `answers_gr` text NOT NULL,
  `answers_en` text NOT NULL,
  `decision_type` varchar(30) NOT NULL,
  `decision_variable` varchar(30) NOT NULL,
  `store_variable` varchar(30) NOT NULL,
  `input_type` varchar(30) NOT NULL,
  `checked` char(7) NOT NULL,
  `serviceid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;
INSERT INTO `mepsol`.`states` VALUES  (127,'Start',9.99992e+06,1.00001e+07,119,40,'s','','','','','','Izmaksas Ls10','','','Document1.doc','','','Šis ir links;Daudzi linki;Daudz vairāk..','','','','','','','','','','','checked',0),
 (128,'Share',9.9999e+06,9.99989e+06,117,40,'s','','','','','','','','','','','','','','','','','','','','','','','',0),
 (129,'Individual',1.00001e+07,9.99988e+06,120,40,'s','','','','','','','','','','','','','','','','','','','','','','','',0),
 (130,'Ltd',9.99966e+06,9.99993e+06,120,40,'s','','','','','','','','','','','','','','','','','','','','','','','',0),
 (131,'What_company?',9.9999e+06,9.99995e+06,135,97,'d','','','','','','','','','','','','','','','What is the type of the company?','','','','Input','','','DropDown','',0),
 (134,'sdsdsa',9.99966e+06,9.99985e+06,120,40,'s','','','','','','','','','','','','','','','','','','','','','','','',0);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
