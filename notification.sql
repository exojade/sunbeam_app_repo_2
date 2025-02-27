/*
SQLyog Community v12.4.0 (64 bit)
MySQL - 8.0.39 : Database - sunbeam_appdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `notification` */

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `receiver_id` varchar(100) DEFAULT NULL,
  `message` text,
  `created` int DEFAULT NULL,
  `read_at` int DEFAULT NULL,
  `sender_id` varchar(100) DEFAULT NULL,
  KEY `notification_id` (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `notification` */

insert  into `notification`(`notification_id`,`receiver_id`,`message`,`created`,`read_at`,`sender_id`) values 
(1,'1','a:2:{s:7:\"message\";s:39:\"LYVEE JEAN GALORIO requested Grade Card\";s:4:\"link\";s:15:\"documentRequest\";}',1740659202,1740659659,'USR-a8ef4c1ca89b5-241205'),
(3,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:115:\"REGISTRAR :  You may now claim your request document Grade Card for Student: Michael Virtudazo on February 28, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740662367,1740662525,'1'),
(4,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:64:\"REGISTRAR :  The parent claimed the document : February 28, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740662427,1740662524,'1'),
(5,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : T2692FC5DF12A5\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740663016,1740663035,'USR-a8ef4c1ca89b5-241205'),
(6,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:106:\"Lebi san: accepted your proof of payment thru online payment. Check this Transaction Code : T2692FC5DF12A5\";s:4:\"link\";s:13:\"onlinePayment\";}',1740663570,1740663589,'USR-bf7e8239f391b-240728');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
