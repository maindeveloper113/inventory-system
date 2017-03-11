/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.1.53-community-log : Database - inventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`inventory` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `inventory`;

/*Table structure for table `deleted_inventory` */

DROP TABLE IF EXISTS `deleted_inventory`;

CREATE TABLE `deleted_inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `part_number` varchar(50) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `description` varchar(70) NOT NULL,
  `location` varchar(10) NOT NULL,
  `register_time` datetime NOT NULL,
  `register_userid` int(11) NOT NULL,
  `remove_userid` int(11) DEFAULT NULL,
  `remove_time` datetime DEFAULT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `deleted_inventory` */

/*Table structure for table `inventory` */

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `part_number` varchar(50) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `description` varchar(70) NOT NULL,
  `location` varchar(10) NOT NULL,
  `register_time` datetime NOT NULL,
  `register_userid` int(11) NOT NULL,
  `remove_userid` int(11) DEFAULT '0',
  `remove_time` datetime DEFAULT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

/*Data for the table `inventory` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`user_id`,`email`,`pass`,`user_name`,`user_level`) values (16,'admin','21232f297a57a5a743894a0e4a801fc3','ADMIN',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
