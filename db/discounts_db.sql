-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for discounts
CREATE DATABASE IF NOT EXISTS `discounts` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `discounts`;

-- Dumping structure for table discounts.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `date_since` date NOT NULL,
  `revenue` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Information about customer';

-- Dumping data for table discounts.customers: ~2 rows (approximately)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` (`id`, `name`, `date_since`, `revenue`) VALUES
	(1, 'Coca Cola', '2014-06-28', 492.12),
	(2, 'Teamleader', '2015-01-15', 1505.95),
	(3, 'Jeroen De Wit', '2016-02-11', 0.00);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- Dumping structure for table discounts.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` varchar(50) NOT NULL DEFAULT '',
  ` description` varchar(100) NOT NULL DEFAULT '',
  `category` int(11) NOT NULL DEFAULT '0',
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Information about product and their categories ';

-- Dumping data for table discounts.products: ~4 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `productId`, ` description`, `category`, `price`) VALUES
	(1, 'A101', 'Screwdriver', 1, 9.75),
	(2, 'A102', 'Electric screwdriver', 1, 49.50),
	(3, 'B101', 'Basic on-off switch', 2, 4.99),
	(4, 'B102', 'Press button', 2, 4.99),
	(5, 'B103', 'Switch with motion detector', 2, 12.95);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
