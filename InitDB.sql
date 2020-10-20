DROP DATABASE IF EXISTS `esales`;
CREATE DATABASE `esales`;
USE `esales`;

DROP TABLE IF EXISTS `bikes`;
CREATE TABLE `bikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `model` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `buyer_name` varchar(50) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;