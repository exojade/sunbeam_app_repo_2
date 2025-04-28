/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 5.6.45-log : Database - sunbeam_appdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `advisory` */

DROP TABLE IF EXISTS `advisory`;

CREATE TABLE `advisory` (
  `advisory_id` varchar(100) DEFAULT NULL,
  `section_id` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `teacher_id` varchar(100) DEFAULT NULL,
  `max_students` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `advisory` */

insert  into `advisory`(`advisory_id`,`section_id`,`grade_level`,`school_year`,`teacher_id`,`max_students`) values 
('ADVB4BBD7EF5420B','SECF875B8B2F6DD0','Grade 4','SY1','TDEC9218A0D6B5',35),
('ADVCE3AAA218B77C','SEC5DF1F26E0354A','Grade 5','SY03FBB1599C61C','TDFDB936CDE413',35),
('ADV49EC384CD87CD','SEC616E07096778D','Kindergarten 1','SY03FBB1599C61C','T392DF740696AD',35),
('ADV31BE4DAE5CEAD','SEC616E07096778D','Grade 1','SY03FBB1599C61C','T699EBCDE12880',35),
('ADV98EEA1C4ADC4F','SECB83A9B1FD2EE5','Grade 3','SY03FBB1599C61C','TE73F9F3CE2494',35),
('ADVF43E094A5A13C','SECF875B8B2F6DD0','Grade 4','SY03FBB1599C61C','TDEC9218A0D6B5',35),
('ADV37A37989430D0','SEC51FF453E2D3EB','Grade 6','SY03FBB1599C61C','T158F0C1C96533',35),
('ADV35B9B1ABF3B33','SECA24093ECD2301','Grade 2','SY03FBB1599C61C','TEBB45FA054403',35),
('ADV8C9A41EB6A614','SEC616E07096778D','Grade 1','SY03FBB1599C61C','TDEC9218A0D6B5',35);

/*Table structure for table `announcement` */

DROP TABLE IF EXISTS `announcement`;

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement` text,
  `from_sender` varchar(100) DEFAULT NULL,
  `type` enum('school','advisory') DEFAULT NULL,
  `advisory_id` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `dateTimePosted` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `announcement` */

insert  into `announcement`(`announcement_id`,`announcement`,`from_sender`,`type`,`advisory_id`,`syid`,`dateTimePosted`) values 
(12,'<p>Hi guys welcome to my vlog</p><p>admo dre office</p>','1','school',NULL,'SY03FBB1599C61C','2024-12-05 14:12:49'),
(13,'WALAY KLASEEEEEEEEEEEEEEEE!!','T158F0C1C96533','advisory','ADV37A37989430D0','SY03FBB1599C61C','2024-12-12 21:14:43'),
(14,'IS OJT is now started. Take care students. You are call to lead.','1','school',NULL,'SY03FBB1599C61C','2025-02-12 09:45:39'),
(15,'To our new enrollees, the Sunbeam Christian School of Panabo is now accepting new enrollees. Come and visit us and we are happy to assist you. Thank you!&nbsp;','1','school',NULL,'SY03FBB1599C61C','2025-02-12 10:05:01'),
(16,'To our parents, we are having an event to help our student improve their skills in Sci-Math. The schedule will be posted out soon. Thank you!','1','school',NULL,'SY03FBB1599C61C','2025-02-12 10:11:16'),
(17,'Welcome to the section announcement. We are happy to give your child a lot of homework this school year. Thank You!','TDFDB936CDE413','advisory','ADVCE3AAA218B77C','SY03FBB1599C61C','2025-02-17 14:16:15');

/*Table structure for table `bankdetails` */

DROP TABLE IF EXISTS `bankdetails`;

CREATE TABLE `bankdetails` (
  `tblid` varchar(100) DEFAULT NULL,
  `bankName` varchar(100) DEFAULT NULL,
  `instructions` text,
  `accountNumber` varchar(100) DEFAULT NULL,
  `accountName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `bankdetails` */

insert  into `bankdetails`(`tblid`,`bankName`,`instructions`,`accountNumber`,`accountName`) values 
('BANK0001','GCASH',NULL,'09912021547','BRIAN JADE GARCIA');

/*Table structure for table `captureform137` */

DROP TABLE IF EXISTS `captureform137`;

CREATE TABLE `captureform137` (
  `form137_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(100) DEFAULT NULL,
  `school_id` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `division` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `adviser_name` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`form137_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `captureform137` */

/*Table structure for table `captureform137_grades` */

DROP TABLE IF EXISTS `captureform137_grades`;

CREATE TABLE `captureform137_grades` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `form137_id` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `first_grading` varchar(100) DEFAULT NULL,
  `second_grading` varchar(100) DEFAULT NULL,
  `third_grading` varchar(100) DEFAULT NULL,
  `fourth_grading` varchar(100) DEFAULT NULL,
  `final_rating` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `order_grades` decimal(10,1) DEFAULT NULL,
  `order_parent` varchar(100) DEFAULT NULL,
  `subject_head_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tblid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `captureform137_grades` */

/*Table structure for table `documentrequest` */

DROP TABLE IF EXISTS `documentrequest`;

CREATE TABLE `documentrequest` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(100) DEFAULT NULL,
  `parent_id` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `request_status` enum('PENDING','CLAIMED','FOR CLAIM') DEFAULT NULL,
  `dateRequested` varchar(100) DEFAULT NULL,
  `claim_due_date` varchar(100) DEFAULT NULL,
  `date_claimed` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tblid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

/*Data for the table `documentrequest` */

insert  into `documentrequest`(`tblid`,`document`,`parent_id`,`student_id`,`request_status`,`dateRequested`,`claim_due_date`,`date_claimed`) values 
(21,'Grade Card','USR-a8ef4c1ca89b5-241205','LRN40559200000027','CLAIMED','2025-02-27 21:52:44','2025-02-28','2025-03-03'),
(22,'Honorable Dismissal','USR-a8ef4c1ca89b5-241205','LRN40559200000027','FOR CLAIM','2025-02-27 22:45:52','2025-02-28',''),
(23,'Form 137','USR-a8ef4c1ca89b5-241205','LRN40559200000027','CLAIMED','2025-02-28 07:53:15','2025-02-28','2025-02-28'),
(24,'Honorable Dismissal','USR-a8ef4c1ca89b5-241205','LRN40559200000027','FOR CLAIM','2025-02-28 08:36:39','2025-03-03',''),
(25,'Honorable Dismissal','USR-a8ef4c1ca89b5-241205','LRN40559200000028','FOR CLAIM','2025-02-28 09:22:53','2025-03-03',''),
(26,'Grade Card','USR-a8ef4c1ca89b5-241205','LRN40559200000026','FOR CLAIM','2025-02-28 09:43:06','2025-03-03',''),
(27,'Grade Card','USR-a8ef4c1ca89b5-241205','LRN40559200000027','PENDING','2025-02-28 13:17:13',NULL,NULL),
(28,'Grade Card','USR-a8ef4c1ca89b5-241205','LRN40559200000027','FOR CLAIM','2025-02-28 13:24:18','2025-03-03','');

/*Table structure for table `enrollment` */

DROP TABLE IF EXISTS `enrollment`;

CREATE TABLE `enrollment` (
  `enrollment_id` varchar(100) DEFAULT NULL,
  `dateEnrolled` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `advisory_id` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `credit_balance` varchar(100) DEFAULT NULL,
  `monthly` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `enrollment` */

insert  into `enrollment`(`enrollment_id`,`dateEnrolled`,`syid`,`student_id`,`grade_level`,`advisory_id`,`status`,`credit_balance`,`monthly`) values 
('ENR28A8B2E4F8A63','2024-12-05 13:24:04','SY03FBB1599C61C','LRN40559200000026','Grade 6','ADV37A37989430D0','ENROLLED',NULL,'1702.5'),
('ENRA1EA5410495D2','2024-12-05 14:21:12','SY03FBB1599C61C','LRN40559200000027','Grade 5','ADVCE3AAA218B77C','ENROLLED',NULL,'2218'),
('ENR254D85C83D568','2024-12-12 21:07:41','SY03FBB1599C61C','LRN40559200000028','Grade 6','ADV37A37989430D0','ENROLLED',NULL,'1202.5'),
('ENRD71F47821BA90','2025-02-21 19:02:44','SY1','LRN40559200000029','Grade 4','ADVB4BBD7EF5420B','ENROLLED',NULL,'0'),
('ENRFD53228F26C2C','2025-04-28 09:18:23','SY03FBB1599C61C','LRN405501010101__','Grade 1','ADV8C9A41EB6A614','ENROLLED',NULL,'1322.5');

/*Table structure for table `enrollment_fees` */

DROP TABLE IF EXISTS `enrollment_fees`;

CREATE TABLE `enrollment_fees` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `fee` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `fees_id` decimal(10,2) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=utf8mb4;

/*Data for the table `enrollment_fees` */

insert  into `enrollment_fees`(`fee_id`,`enrollment_id`,`fee`,`type`,`amount`,`status`,`fees_id`,`priority`) values 
(238,'ENR51F06B33E62AC','JOGGING PANTS (LARGE)','OTHERS','410','PAYMENT',NULL,NULL),
(239,'ENR51F06B33E62AC','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(240,'ENR51F06B33E62AC','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(241,'ENR51F06B33E62AC','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(242,'ENR51F06B33E62AC','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(243,'ENR51F06B33E62AC','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(244,'ENR51F06B33E62AC','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(245,'ENRD3F64DD722246','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(246,'ENRD3F64DD722246','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(247,'ENRD3F64DD722246','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(248,'ENRD3F64DD722246','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(249,'ENRD3F64DD722246','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(250,'ENRD3F64DD722246','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(251,'ENRC2110BC03E64E','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(252,'ENRC2110BC03E64E','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(253,'ENRC2110BC03E64E','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(254,'ENRC2110BC03E64E','BOOKS','MAIN','6000','PAYMENT',NULL,NULL),
(255,'ENRC2110BC03E64E','MISCELLANEOUS FEE','MAIN','7000','PAYMENT',NULL,NULL),
(256,'ENRC2110BC03E64E','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(257,'ENR7CA1D13C8FA81','JOGGING PANTS(SMALL)','OTHERS','350','PAYMENT',NULL,NULL),
(258,'ENR7CA1D13C8FA81','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(259,'ENR7CA1D13C8FA81','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(260,'ENR7CA1D13C8FA81','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(261,'ENR7CA1D13C8FA81','BOOKS','MAIN','6000','PAYMENT',NULL,NULL),
(262,'ENR7CA1D13C8FA81','MISCELLANEOUS FEE','MAIN','7000','PAYMENT',NULL,NULL),
(263,'ENR7CA1D13C8FA81','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(264,'ENR7CA1D13C8FA81','JOGGING PANTS(SMALL)','OTHERS','350','PAYMENT',NULL,NULL),
(265,'ENR2AC45944F5ABA','CHOREOGRAPHER FIELD DEMO','OTHERS','500','PAYMENT',NULL,NULL),
(266,'ENR2AC45944F5ABA','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(267,'ENR2AC45944F5ABA','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(268,'ENR2AC45944F5ABA','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(269,'ENR2AC45944F5ABA','BOOKS','MAIN','6000','PAYMENT',NULL,NULL),
(270,'ENR2AC45944F5ABA','MISCELLANEOUS FEE','MAIN','7000','PAYMENT',NULL,NULL),
(271,'ENR2AC45944F5ABA','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(272,'ENR2AC45944F5ABA','JOGGING PANTS(SMALL)','OTHERS','350','PAYMENT',NULL,NULL),
(273,'ENR07FB350C3D27A','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(274,'ENR07FB350C3D27A','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(275,'ENR07FB350C3D27A','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(276,'ENR07FB350C3D27A','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(277,'ENR07FB350C3D27A','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(278,'ENR07FB350C3D27A','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(279,'ENR3ACE2EBE58FA0','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(280,'ENR3ACE2EBE58FA0','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(281,'ENR3ACE2EBE58FA0','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(282,'ENR3ACE2EBE58FA0','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(283,'ENR3ACE2EBE58FA0','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(284,'ENR3ACE2EBE58FA0','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(285,'ENR02BC2CA3FE933','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(286,'ENR02BC2CA3FE933','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(287,'ENR02BC2CA3FE933','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(288,'ENR02BC2CA3FE933','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(289,'ENR02BC2CA3FE933','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(290,'ENR02BC2CA3FE933','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(291,'ENRF845947319D18','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(292,'ENRF845947319D18','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(293,'ENRF845947319D18','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(294,'ENRF845947319D18','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(295,'ENRF845947319D18','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(296,'ENRF845947319D18','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(297,'ENR28A8B2E4F8A63','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(298,'ENR28A8B2E4F8A63','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(299,'ENR28A8B2E4F8A63','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(300,'ENR28A8B2E4F8A63','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(301,'ENR28A8B2E4F8A63','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(302,'ENR28A8B2E4F8A63','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(303,'ENRA1EA5410495D2','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(304,'ENRA1EA5410495D2','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(305,'ENRA1EA5410495D2','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(306,'ENRA1EA5410495D2','BOOKS','MAIN','6000','PAYMENT',NULL,NULL),
(307,'ENRA1EA5410495D2','MISCELLANEOUS FEE','MAIN','7000','PAYMENT',NULL,NULL),
(308,'ENRA1EA5410495D2','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(309,'ENR254D85C83D568','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(310,'ENR254D85C83D568','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(311,'ENR254D85C83D568','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(312,'ENR254D85C83D568','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(313,'ENR254D85C83D568','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(314,'ENR254D85C83D568','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(315,'ENRD71F47821BA90','REGISTRATION','MAIN','1000','PAYMENT',NULL,NULL),
(316,'ENRD71F47821BA90','TUITION','MAIN','6000','PAYMENT',NULL,NULL),
(317,'ENRD71F47821BA90','ELECTRIC SUBSIDY','MAIN','3800','PAYMENT',NULL,NULL),
(318,'ENRD71F47821BA90','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(319,'ENRD71F47821BA90','BOOKS','MAIN','5495','PAYMENT',NULL,NULL),
(320,'ENRD71F47821BA90','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(322,'ENRFD53228F26C2C','JOGGING PANTS(SMALL)','OTHERS','350','PAYMENT',41.00,NULL),
(323,'ENRFD53228F26C2C','BOOKS','MAIN','4645','PAYMENT',NULL,NULL),
(324,'ENRFD53228F26C2C','ELECTRIC SUBSIDY','MAIN','3300','PAYMENT',NULL,NULL),
(325,'ENRFD53228F26C2C','ID AND INSURANCE','MAIN','380','PAYMENT',NULL,NULL),
(326,'ENRFD53228F26C2C','MISCELLANEOUS FEE','MAIN','5350','PAYMENT',NULL,NULL),
(327,'ENRFD53228F26C2C','REGISTRATION','MAIN','1000','PAYMENT',NULL,'YES'),
(328,'ENRFD53228F26C2C','TUITION','MAIN','6000','PAYMENT',NULL,'YES');

/*Table structure for table `enrollment_requirements` */

DROP TABLE IF EXISTS `enrollment_requirements`;

CREATE TABLE `enrollment_requirements` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `document_name` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tblid`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Data for the table `enrollment_requirements` */

insert  into `enrollment_requirements`(`tblid`,`enrollment_id`,`document_name`,`status`,`student_id`) values 
(46,'ENR28A8B2E4F8A63','BIRTH CERTIFICATE','YES','LRN40559200000026'),
(47,'ENR28A8B2E4F8A63','GOOD MORAL','YES','LRN40559200000026'),
(48,'ENR28A8B2E4F8A63','FORM 137','YES','LRN40559200000026'),
(49,'ENRA1EA5410495D2','BIRTH CERTIFICATE','YES','LRN40559200000027'),
(50,'ENRA1EA5410495D2','GOOD MORAL','YES','LRN40559200000027'),
(51,'ENRA1EA5410495D2','FORM 137','YES','LRN40559200000027'),
(52,'ENR254D85C83D568','BIRTH CERTIFICATE','NO','LRN40559200000028'),
(53,'ENR254D85C83D568','GOOD MORAL','NO','LRN40559200000028'),
(54,'ENR254D85C83D568','FORM 137','NO','LRN40559200000028'),
(55,'ENRD71F47821BA90','BIRTH CERTIFICATE','YES','LRN40559200000029'),
(56,'ENRD71F47821BA90','GOOD MORAL','YES','LRN40559200000029'),
(57,'ENRD71F47821BA90','FORM 137','YES','LRN40559200000029'),
(58,'ENRFD53228F26C2C','BIRTH CERTIFICATE','YES','LRN405501010101__'),
(59,'ENRFD53228F26C2C','GOOD MORAL','YES','LRN405501010101__'),
(60,'ENRFD53228F26C2C','FORM 137','YES','LRN405501010101__');

/*Table structure for table `fees` */

DROP TABLE IF EXISTS `fees`;

CREATE TABLE `fees` (
  `fees_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level` varchar(100) DEFAULT NULL,
  `fee_title` varchar(100) DEFAULT NULL,
  `fee_type` varchar(100) DEFAULT NULL,
  `fee_amount` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fees_id`),
  UNIQUE KEY `grade_level` (`grade_level`,`fee_title`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4;

/*Data for the table `fees` */

insert  into `fees`(`fees_id`,`grade_level`,`fee_title`,`fee_type`,`fee_amount`,`status`,`priority`) values 
(17,'Grade 1','TUITION','MAIN','6000','ACTIVE','YES'),
(18,'Grade 1','ELECTRIC SUBSIDY','MAIN','3300','ACTIVE',NULL),
(19,'Grade 1','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(24,'Grade 4','REGISTRATION','MAIN','1000','ACTIVE',NULL),
(25,'Grade 4','TUITION','MAIN','6000','ACTIVE',NULL),
(26,'Grade 4','ELECTRIC SUBSIDY','MAIN','3800','ACTIVE',NULL),
(27,'Grade 4','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(28,'Grade 4','BOOKS','MAIN','5495','ACTIVE',NULL),
(29,'Grade 4','MISCELLANEOUS FEE','MAIN','5350','ACTIVE',NULL),
(30,'Grade 5','REGISTRATION','MAIN','1000','ACTIVE',NULL),
(31,'Grade 5','TUITION','MAIN','6000','ACTIVE',NULL),
(32,'Grade 5','ELECTRIC SUBSIDY','MAIN','3800','ACTIVE',NULL),
(33,'Grade 5','BOOKS','MAIN','6000','ACTIVE',NULL),
(34,'Grade 5','MISCELLANEOUS FEE','MAIN','7000','ACTIVE',NULL),
(35,'Grade 5','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(38,'Grade 1','BOOKS','MAIN','4645','ACTIVE',NULL),
(39,'Grade 1','MISCELLANEOUS FEE','MAIN','5350','ACTIVE',NULL),
(41,'Grade 1','JOGGING PANTS(SMALL)','OTHERS','350','ACTIVE',NULL),
(42,'Grade 2','REGISTRATION','MAIN','1000','ACTIVE',NULL),
(43,'Grade 2','TUITION','MAIN','6000','ACTIVE',NULL),
(44,'Grade 2','ELECTRIC SUBSIDY','MAIN','3500','ACTIVE',NULL),
(45,'Grade 2','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(46,'Grade 2','BOOKS','MAIN','4645','ACTIVE',NULL),
(47,'Grade 2','MISCELLANEOUS FEE','MAIN','5350','ACTIVE',NULL),
(49,'Grade 3','REGISTRATION','MAIN','1000','ACTIVE',NULL),
(50,'Grade 3','TUITION','MAIN','6000','ACTIVE',NULL),
(51,'Grade 3','ELECTRIC SUBSIDY','MAIN','3800','ACTIVE',NULL),
(52,'Grade 3','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(53,'Grade 3','BOOKS','MAIN','5195','ACTIVE',NULL),
(58,'Grade 1','JOGGING PANTS (LARGE)','OTHERS','350','ACTIVE',NULL),
(59,'Grade 1','JOGGING PANTS (MEDIUM)','OTHERS','350','ACTIVE',NULL),
(66,'Grade 6','REGISTRATION','MAIN','1000','ACTIVE',NULL),
(67,'Grade 6','TUITION','MAIN','6000','ACTIVE',NULL),
(68,'Grade 6','ELECTRIC SUBSIDY','MAIN','3800','ACTIVE',NULL),
(69,'Grade 6','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(70,'Grade 6','BOOKS','MAIN','5495','ACTIVE',NULL),
(71,'Grade 6','MISCELLANEOUS FEE','MAIN','5350','ACTIVE',NULL),
(72,'Grade 3','MISCELLANEOUS FEE','MAIN','5350','ACTIVE',NULL),
(73,'Kindergarten 1','REGISTRATION','MAIN','1000','ACTIVE',NULL),
(74,'Kindergarten 1','TUITION','MAIN','6000','ACTIVE',NULL),
(75,'Kindergarten 1','ELECTRIC SUBSIDY','MAIN','2500','ACTIVE',NULL),
(76,'Kindergarten 1','ID AND INSURANCE','MAIN','380','ACTIVE',NULL),
(77,'Kindergarten 1','BOOKS','MAIN','3530','ACTIVE',NULL),
(78,'Kindergarten 1','MISCELLANEOUS FEE','MAIN','4850','ACTIVE',NULL),
(82,'Grade 1','REGISTRATION','MAIN','1000','ACTIVE','YES');

/*Table structure for table `grade_level` */

DROP TABLE IF EXISTS `grade_level`;

CREATE TABLE `grade_level` (
  `grade_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`grade_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `grade_level` */

insert  into `grade_level`(`grade_level_id`,`grade_level`) values 
(1,'Kindergarten 1'),
(2,'Kindergarten 2'),
(3,'Grade 1'),
(4,'Grade 2'),
(5,'Grade 3'),
(6,'Grade 4'),
(7,'Grade 5'),
(8,'Grade 6');

/*Table structure for table `installment` */

DROP TABLE IF EXISTS `installment`;

CREATE TABLE `installment` (
  `installment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `amount_due` varchar(100) DEFAULT '',
  `is_paid` varchar(100) DEFAULT NULL,
  `installment_number` int(11) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `from_balance` varchar(100) DEFAULT NULL,
  `to_balance` varchar(100) DEFAULT NULL,
  `credit_balance` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`installment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=628 DEFAULT CHARSET=utf8mb4;

/*Data for the table `installment` */

insert  into `installment`(`installment_id`,`enrollment_id`,`amount_due`,`is_paid`,`installment_number`,`syid`,`type`,`payment_id`,`from_balance`,`to_balance`,`credit_balance`) values 
(573,'ENR28A8B2E4F8A63','5000','DONE',1,'SY03FBB1599C61C','DOWNPAYMENT',NULL,NULL,NULL,NULL),
(574,'ENR28A8B2E4F8A63','702.5','DONE',2,'SY03FBB1599C61C','INSTALLMENT','141',NULL,NULL,NULL),
(575,'ENR28A8B2E4F8A63','1702.5','DONE',3,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(576,'ENR28A8B2E4F8A63','1702.5','DONE',4,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(577,'ENR28A8B2E4F8A63','1702.5','DONE',5,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(578,'ENR28A8B2E4F8A63','1702.5','DONE',6,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(579,'ENR28A8B2E4F8A63','1702.5','DONE',7,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(580,'ENR28A8B2E4F8A63','1702.5','DONE',8,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(581,'ENR28A8B2E4F8A63','1702.5','DONE',9,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(582,'ENR28A8B2E4F8A63','1702.5','DONE',10,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(583,'ENR28A8B2E4F8A63','1702.5','DONE',11,'SY03FBB1599C61C',NULL,'141',NULL,NULL,NULL),
(584,'ENRA1EA5410495D2','2000','DONE',1,'SY03FBB1599C61C','DOWNPAYMENT',NULL,NULL,NULL,NULL),
(585,'ENRA1EA5410495D2','218','DONE',2,'SY03FBB1599C61C','INSTALLMENT','148',NULL,NULL,NULL),
(586,'ENRA1EA5410495D2','2218','DONE',3,'SY03FBB1599C61C',NULL,'149',NULL,NULL,NULL),
(587,'ENRA1EA5410495D2','2218','DONE',4,'SY03FBB1599C61C',NULL,'149',NULL,NULL,NULL),
(588,'ENRA1EA5410495D2','2218','DONE',5,'SY03FBB1599C61C',NULL,'151',NULL,NULL,NULL),
(589,'ENRA1EA5410495D2','2218','NOT DONE',6,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(590,'ENRA1EA5410495D2','2218','NOT DONE',7,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(591,'ENRA1EA5410495D2','2218','NOT DONE',8,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(592,'ENRA1EA5410495D2','2218','NOT DONE',9,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(593,'ENRA1EA5410495D2','2218','NOT DONE',10,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(594,'ENRA1EA5410495D2','2218','NOT DONE',11,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(595,'ENR254D85C83D568','10000','DONE',1,'SY03FBB1599C61C','DOWNPAYMENT',NULL,NULL,NULL,NULL),
(596,'ENR254D85C83D568','1202.5','DONE',2,'SY03FBB1599C61C','INSTALLMENT','147',NULL,NULL,NULL),
(597,'ENR254D85C83D568','1202.5','DONE',3,'SY03FBB1599C61C',NULL,'147',NULL,NULL,NULL),
(598,'ENR254D85C83D568','607.5','DONE',4,'SY03FBB1599C61C',NULL,'150',NULL,NULL,NULL),
(599,'ENR254D85C83D568','1202.5','DONE',5,'SY03FBB1599C61C',NULL,'152',NULL,NULL,NULL),
(600,'ENR254D85C83D568','1202.5','NOT DONE',6,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(601,'ENR254D85C83D568','1202.5','NOT DONE',7,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(602,'ENR254D85C83D568','1202.5','NOT DONE',8,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(603,'ENR254D85C83D568','1202.5','NOT DONE',9,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(604,'ENR254D85C83D568','1202.5','NOT DONE',10,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(605,'ENR254D85C83D568','1202.5','NOT DONE',11,'SY03FBB1599C61C',NULL,NULL,NULL,NULL,NULL),
(606,'ENRD71F47821BA90','22025','DONE',1,'SY1','DOWNPAYMENT',NULL,NULL,NULL,NULL),
(607,'ENRD71F47821BA90','0','NOT DONE',2,'SY1',NULL,NULL,NULL,NULL,NULL),
(608,'ENRD71F47821BA90','0','NOT DONE',3,'SY1',NULL,NULL,NULL,NULL,NULL),
(609,'ENRD71F47821BA90','0','NOT DONE',4,'SY1',NULL,NULL,NULL,NULL,NULL),
(610,'ENRD71F47821BA90','0','NOT DONE',5,'SY1',NULL,NULL,NULL,NULL,NULL),
(611,'ENRD71F47821BA90','0','NOT DONE',6,'SY1',NULL,NULL,NULL,NULL,NULL),
(612,'ENRD71F47821BA90','0','NOT DONE',7,'SY1',NULL,NULL,NULL,NULL,NULL),
(613,'ENRD71F47821BA90','0','NOT DONE',8,'SY1',NULL,NULL,NULL,NULL,NULL),
(614,'ENRD71F47821BA90','0','NOT DONE',9,'SY1',NULL,NULL,NULL,NULL,NULL),
(615,'ENRD71F47821BA90','0','NOT DONE',10,'SY1',NULL,NULL,NULL,NULL,NULL),
(616,'ENRD71F47821BA90','0','NOT DONE',11,'SY1',NULL,NULL,NULL,NULL,NULL),
(617,'ENRFD53228F26C2C','7800','DONE',1,'SY03FBB1599C61C','DOWNPAYMENT',NULL,NULL,NULL,NULL),
(618,'ENRFD53228F26C2C','1322.5','DONE',2,'SY03FBB1599C61C','INSTALLMENT','154',NULL,NULL,NULL),
(619,'ENRFD53228F26C2C','1145','DONE',3,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(620,'ENRFD53228F26C2C','1322.5','DONE',4,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(621,'ENRFD53228F26C2C','1322.5','DONE',5,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(622,'ENRFD53228F26C2C','1322.5','DONE',6,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(623,'ENRFD53228F26C2C','1322.5','DONE',7,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(624,'ENRFD53228F26C2C','1322.5','DONE',8,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(625,'ENRFD53228F26C2C','1322.5','DONE',9,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(626,'ENRFD53228F26C2C','1322.5','DONE',10,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL),
(627,'ENRFD53228F26C2C','1322.5','DONE',11,'SY03FBB1599C61C',NULL,'155',NULL,NULL,NULL);

/*Table structure for table `learning_areas` */

DROP TABLE IF EXISTS `learning_areas`;

CREATE TABLE `learning_areas` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `learning_area` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tblid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `learning_areas` */

insert  into `learning_areas`(`tblid`,`learning_area`) values 
(1,'Mother Tongue'),
(2,'Filipino'),
(3,'English'),
(4,'Mathematics'),
(5,'Science'),
(6,'Araling Panlipunan'),
(7,'MAPEH - Music'),
(8,'MAPEH - Arts'),
(9,'MAPEH - Physical Education'),
(10,'MAPEH - Health'),
(11,'Eduk. sa Pagpapakatao - Arabic Language'),
(12,'Eduk. sa Pagpapakatao - Islamic Values Education');

/*Table structure for table `notification` */

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` varchar(100) DEFAULT NULL,
  `message` text,
  `created` int(11) DEFAULT NULL,
  `read_at` int(11) DEFAULT NULL,
  `sender_id` varchar(100) DEFAULT NULL,
  KEY `notification_id` (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

/*Data for the table `notification` */

insert  into `notification`(`notification_id`,`receiver_id`,`message`,`created`,`read_at`,`sender_id`) values 
(7,'1','a:2:{s:7:\"message\";s:39:\"LYVEE JEAN GALORIO requested Grade Card\";s:4:\"link\";s:15:\"documentRequest\";}',1740664364,1740664436,'USR-a8ef4c1ca89b5-241205'),
(8,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:115:\"REGISTRAR :  You may now claim your request document Grade Card for Student: Brian Rey Galorio on February 28, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740664401,1740664422,'1'),
(11,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:110:\"REGISTRAR :  Parent claimed the requested document Grade Card for Student: Brian Rey Galorio on March 03, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740664643,1740664664,'1'),
(12,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : T83A4BC67C617A\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740664684,1740668228,'USR-a8ef4c1ca89b5-241205'),
(13,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:106:\"Lebi san: accepted your proof of payment thru online payment. Check this Transaction Code : T83A4BC67C617A\";s:4:\"link\";s:13:\"onlinePayment\";}',1740664710,1740664720,'USR-bf7e8239f391b-240728'),
(14,'1','a:2:{s:7:\"message\";s:48:\"LYVEE JEAN GALORIO requested Honorable Dismissal\";s:4:\"link\";s:15:\"documentRequest\";}',1740667553,1740692111,'USR-a8ef4c1ca89b5-241205'),
(15,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:124:\"REGISTRAR :  You may now claim your request document Honorable Dismissal for Student: Brian Rey Galorio on February 28, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740667801,1740692166,'1'),
(16,'1','a:2:{s:7:\"message\";s:37:\"LYVEE JEAN GALORIO requested Form 137\";s:4:\"link\";s:15:\"documentRequest\";}',1740700395,1740700417,'USR-a8ef4c1ca89b5-241205'),
(17,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:113:\"REGISTRAR :  You may now claim your request document Form 137 for Student: Brian Rey Galorio on February 28, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740700440,1740700470,'1'),
(18,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:111:\"REGISTRAR :  Parent claimed the requested document Form 137 for Student: Brian Rey Galorio on February 28, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740700526,1740702916,'1'),
(19,'1','a:2:{s:7:\"message\";s:48:\"LYVEE JEAN GALORIO requested Honorable Dismissal\";s:4:\"link\";s:15:\"documentRequest\";}',1740702999,1740705628,'USR-a8ef4c1ca89b5-241205'),
(20,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:121:\"REGISTRAR :  You may now claim your request document Honorable Dismissal for Student: Brian Rey Galorio on March 03, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740703056,1740703071,'1'),
(21,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:121:\"REGISTRAR :  You may now claim your request document Honorable Dismissal for Student: Brian Rey Galorio on March 03, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740703133,1740703237,'1'),
(22,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : TCFD305FF3CCE0\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740703304,1740703327,'USR-a8ef4c1ca89b5-241205'),
(23,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:106:\"Lebi san: accepted your proof of payment thru online payment. Check this Transaction Code : TCFD305FF3CCE0\";s:4:\"link\";s:13:\"onlinePayment\";}',1740703346,1740703388,'USR-bf7e8239f391b-240728'),
(24,'1','a:2:{s:7:\"message\";s:48:\"LYVEE JEAN GALORIO requested Honorable Dismissal\";s:4:\"link\";s:15:\"documentRequest\";}',1740705773,1740705823,'USR-a8ef4c1ca89b5-241205'),
(25,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:122:\"REGISTRAR :  You may now claim your request document Honorable Dismissal for Student: Darren Kent Tusias on March 03, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740705842,1740705897,'1'),
(26,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : TA6E6F8AB5F3D1\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740706192,1740706215,'USR-a8ef4c1ca89b5-241205'),
(27,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:106:\"Lebi san: accepted your proof of payment thru online payment. Check this Transaction Code : TA6E6F8AB5F3D1\";s:4:\"link\";s:13:\"onlinePayment\";}',1740706247,1740706266,'USR-bf7e8239f391b-240728'),
(28,'1','a:2:{s:7:\"message\";s:39:\"LYVEE JEAN GALORIO requested Grade Card\";s:4:\"link\";s:15:\"documentRequest\";}',1740706986,1740718101,'USR-a8ef4c1ca89b5-241205'),
(29,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:112:\"REGISTRAR :  You may now claim your request document Grade Card for Student: Michael Virtudazo on March 03, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740707013,1740707030,'1'),
(30,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : T40349A6B739F7\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740707151,1745802603,'USR-a8ef4c1ca89b5-241205'),
(31,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:106:\"Lebi san: accepted your proof of payment thru online payment. Check this Transaction Code : T40349A6B739F7\";s:4:\"link\";s:13:\"onlinePayment\";}',1740707196,1740707209,'USR-bf7e8239f391b-240728'),
(32,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : T8D6106404D407\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740719474,1740719503,'USR-a8ef4c1ca89b5-241205'),
(33,'USR-bf7e8239f391b-240728','a:2:{s:7:\"message\";s:143:\"LYVEE JEAN GALORIO have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : TF34050B7FF397\";s:4:\"link\";s:20:\"onlinePaymentCashier\";}',1740719708,1745802598,'USR-a8ef4c1ca89b5-241205'),
(34,'1','a:2:{s:7:\"message\";s:39:\"LYVEE JEAN GALORIO requested Grade Card\";s:4:\"link\";s:15:\"documentRequest\";}',1740719833,1740719857,'USR-a8ef4c1ca89b5-241205'),
(35,'1','a:2:{s:7:\"message\";s:39:\"LYVEE JEAN GALORIO requested Grade Card\";s:4:\"link\";s:15:\"documentRequest\";}',1740720258,1740720273,'USR-a8ef4c1ca89b5-241205'),
(36,'USR-a8ef4c1ca89b5-241205','a:2:{s:7:\"message\";s:112:\"REGISTRAR :  You may now claim your request document Grade Card for Student: Brian Rey Galorio on March 03, 2025\";s:4:\"link\";s:15:\"documentRequest\";}',1740720297,1740720309,'1');

/*Table structure for table `onlinepayment` */

DROP TABLE IF EXISTS `onlinepayment`;

CREATE TABLE `onlinepayment` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `transactionCode` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `proofPayment` varchar(100) DEFAULT NULL,
  `status` enum('PENDING','DONE','RETURNED') DEFAULT NULL,
  `transactionDate` varchar(100) DEFAULT NULL,
  `paidBy` varchar(100) DEFAULT NULL,
  `bankDetailsId` varchar(100) DEFAULT NULL,
  `installment_number` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tblid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `onlinepayment` */

insert  into `onlinepayment`(`tblid`,`transactionCode`,`amount`,`proofPayment`,`status`,`transactionDate`,`paidBy`,`bankDetailsId`,`installment_number`,`syid`) values 
(5,'T-be19f26de4b7e-241205','1000','uploads/proofPayment/T-be19f26de4b7e-241205.jpg','DONE','2024-12-05 13:46:57','USR-a8ef4c1ca89b5-241205','BANK0001','2','SY03FBB1599C61C'),
(6,'T83A4BC67C617A','5000','uploads/proofPayment/T83A4BC67C617A.jpg','DONE','2025-02-27 21:58:04','USR-a8ef4c1ca89b5-241205','BANK0001','5','SY03FBB1599C61C'),
(7,'TCFD305FF3CCE0','218','uploads/proofPayment/TCFD305FF3CCE0.png','DONE','2025-02-28 08:41:44','USR-a8ef4c1ca89b5-241205','BANK0001','2','SY03FBB1599C61C'),
(8,'TA6E6F8AB5F3D1','5043.5','uploads/proofPayment/TA6E6F8AB5F3D1.JPG','DONE','2025-02-28 09:29:52','USR-a8ef4c1ca89b5-241205','BANK0001','4','SY03FBB1599C61C'),
(9,'T40349A6B739F7','3420.5','uploads/proofPayment/T40349A6B739F7.png','DONE','2025-02-28 09:45:51','USR-a8ef4c1ca89b5-241205','BANK0001','5','SY03FBB1599C61C'),
(10,'T8D6106404D407','3420.5','uploads/proofPayment/T8D6106404D407.png','PENDING','2025-02-28 13:11:14','USR-a8ef4c1ca89b5-241205','BANK0001','6','SY03FBB1599C61C'),
(11,'TF34050B7FF397','4436','uploads/proofPayment/TF34050B7FF397.png','PENDING','2025-02-28 13:15:08','USR-a8ef4c1ca89b5-241205','BANK0001','7','SY03FBB1599C61C');

/*Table structure for table `onlinepaymentstudents` */

DROP TABLE IF EXISTS `onlinepaymentstudents`;

CREATE TABLE `onlinepaymentstudents` (
  `tblid` int(11) NOT NULL AUTO_INCREMENT,
  `transactionCode` varchar(100) DEFAULT NULL COMMENT 'connected to main Table',
  `enrollment_id` varchar(100) DEFAULT NULL,
  `sy_id` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `amount_paid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tblid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `onlinepaymentstudents` */

insert  into `onlinepaymentstudents`(`tblid`,`transactionCode`,`enrollment_id`,`sy_id`,`student_id`,`amount_paid`) values 
(5,'T-be19f26de4b7e-241205','ENR28A8B2E4F8A63','SY03FBB1599C61C','LRN40559200000026','1000'),
(6,'T83A4BC67C617A','ENRA1EA5410495D2','SY03FBB1599C61C','LRN40559200000027','2000'),
(7,'T83A4BC67C617A','ENR254D85C83D568','SY03FBB1599C61C','LRN40559200000028','3000'),
(8,'TCFD305FF3CCE0','ENRA1EA5410495D2','SY03FBB1599C61C','LRN40559200000027','218'),
(9,'TA6E6F8AB5F3D1','ENRA1EA5410495D2','SY03FBB1599C61C','LRN40559200000027','4436'),
(10,'TA6E6F8AB5F3D1','ENR254D85C83D568','SY03FBB1599C61C','LRN40559200000028','607.50'),
(11,'T40349A6B739F7','ENRA1EA5410495D2','SY03FBB1599C61C','LRN40559200000027','2218'),
(12,'T40349A6B739F7','ENR254D85C83D568','SY03FBB1599C61C','LRN40559200000028','1202.50'),
(13,'T8D6106404D407','ENRA1EA5410495D2','SY03FBB1599C61C','LRN40559200000027','2218'),
(14,'T8D6106404D407','ENR254D85C83D568','SY03FBB1599C61C','LRN40559200000028','1202.50'),
(15,'TF34050B7FF397','ENRA1EA5410495D2','SY03FBB1599C61C','LRN40559200000027','4436');

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `amount_paid` varchar(100) DEFAULT NULL,
  `date_paid` varchar(100) DEFAULT NULL,
  `method_of_payment` varchar(100) DEFAULT NULL,
  `or_number` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `paid_by` varchar(100) DEFAULT NULL,
  `proof_of_payment` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `installment_id` varchar(100) DEFAULT NULL,
  `cashier` varchar(100) DEFAULT NULL,
  `onlinePaymentId` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment` */

insert  into `payment`(`payment_id`,`enrollment_id`,`syid`,`amount_paid`,`date_paid`,`method_of_payment`,`or_number`,`remarks`,`paid_by`,`proof_of_payment`,`type`,`installment_id`,`cashier`,`onlinePaymentId`) values 
(139,'ENR28A8B2E4F8A63','SY03FBB1599C61C','5000','2024-12-05 13:27:00','CASH','OR10111',NULL,NULL,NULL,'DOWNPAYMENT',NULL,'USR-bf7e8239f391b-240728',NULL),
(140,'ENR28A8B2E4F8A63','SY03FBB1599C61C','1000','2024-12-05 05:48:21','BANK','OR1000',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'PROMISSORY',NULL,'USR-bf7e8239f391b-240728','5'),
(141,'ENR28A8B2E4F8A63','SY03FBB1599C61C','16025','2024-12-05 05:50:00','CASH','OR1023',NULL,'Lyvee Galorio',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728',NULL),
(142,'ENRA1EA5410495D2','SY03FBB1599C61C','2000','2024-12-05 14:21:00','CASH','OR2002',NULL,NULL,NULL,'DOWNPAYMENT',NULL,'USR-bf7e8239f391b-240728',NULL),
(143,'ENR254D85C83D568','SY03FBB1599C61C','10000','2024-12-12 21:10:00','CASH','123-4567-890',NULL,NULL,NULL,'DOWNPAYMENT',NULL,'USR-bf7e8239f391b-240728',NULL),
(144,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'USR-bf7e8239f391b-240728',NULL),
(145,'ENRD71F47821BA90','SY1','22025','2025-02-21 19:03:00','CASH','OR2004',NULL,NULL,NULL,'DOWNPAYMENT',NULL,'USR-bf7e8239f391b-240728',NULL),
(146,'ENRA1EA5410495D2','SY03FBB1599C61C','2000','2025-02-27 13:58:30','BANK','OR3000',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'PROMISSORY',NULL,'USR-bf7e8239f391b-240728','6'),
(147,'ENR254D85C83D568','SY03FBB1599C61C','3000','2025-02-27 13:58:30','BANK','OR5200',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'PROMISSORY',NULL,'USR-bf7e8239f391b-240728','6'),
(148,'ENRA1EA5410495D2','SY03FBB1599C61C','218','2025-02-28 00:42:26','BANK','OR21212',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728','7'),
(149,'ENRA1EA5410495D2','SY03FBB1599C61C','4436','2025-02-28 01:30:47','BANK','OR2112',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728','8'),
(150,'ENR254D85C83D568','SY03FBB1599C61C','607.50','2025-02-28 01:30:47','BANK','OR2113',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728','8'),
(151,'ENRA1EA5410495D2','SY03FBB1599C61C','2218','2025-02-28 01:46:36','BANK','OR101',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728','9'),
(152,'ENR254D85C83D568','SY03FBB1599C61C','1202.50','2025-02-28 01:46:36','BANK','OR102',NULL,'USR-a8ef4c1ca89b5-241205',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728','9'),
(153,'ENRFD53228F26C2C','SY03FBB1599C61C','7800','2025-04-28 09:53:00','CASH','OR10111011',NULL,NULL,NULL,'DOWNPAYMENT',NULL,'USR-bf7e8239f391b-240728',NULL),
(154,'ENRFD53228F26C2C','SY03FBB1599C61C','1500','2025-04-28 10:06:23','CASH','OR505555',NULL,'MAMA DONCIC',NULL,'PROMISSORY',NULL,'USR-bf7e8239f391b-240728',NULL),
(155,'ENRFD53228F26C2C','SY03FBB1599C61C','11725','2025-04-28 16:15:02','CASH','OR900111',NULL,'DADDY DONCIC',NULL,'INSTALLMENT',NULL,'USR-bf7e8239f391b-240728',NULL);

/*Table structure for table `payment_installment` */

DROP TABLE IF EXISTS `payment_installment`;

CREATE TABLE `payment_installment` (
  `payment_id` varchar(100) DEFAULT NULL,
  `installment_id` varchar(100) DEFAULT NULL,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `tbl_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_balance` varchar(100) DEFAULT NULL,
  `to_balance` varchar(100) DEFAULT NULL,
  `credit_balance` varchar(100) DEFAULT NULL,
  `paid` varchar(100) DEFAULT NULL,
  `amount_due` varchar(100) DEFAULT NULL,
  KEY `tbl_id` (`tbl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment_installment` */

insert  into `payment_installment`(`payment_id`,`installment_id`,`enrollment_id`,`tbl_id`,`from_balance`,`to_balance`,`credit_balance`,`paid`,`amount_due`) values 
('139','573','ENR28A8B2E4F8A63',276,'22025','17025',NULL,'5000','5000'),
('140','574','ENR28A8B2E4F8A63',277,'17025','16025',NULL,'1000','1702.5'),
('141','574','ENR28A8B2E4F8A63',278,'16025','15322.5',NULL,'702.5','702.5'),
('141','575','ENR28A8B2E4F8A63',279,'15322.5','13620',NULL,'1702.5','1702.5'),
('141','576','ENR28A8B2E4F8A63',280,'13620','11917.5',NULL,'1702.5','1702.5'),
('141','577','ENR28A8B2E4F8A63',281,'11917.5','10215',NULL,'1702.5','1702.5'),
('141','578','ENR28A8B2E4F8A63',282,'10215','8512.5',NULL,'1702.5','1702.5'),
('141','579','ENR28A8B2E4F8A63',283,'8512.5','6810',NULL,'1702.5','1702.5'),
('141','580','ENR28A8B2E4F8A63',284,'6810','5107.5',NULL,'1702.5','1702.5'),
('141','581','ENR28A8B2E4F8A63',285,'5107.5','3405',NULL,'1702.5','1702.5'),
('141','582','ENR28A8B2E4F8A63',286,'3405','1702.5',NULL,'1702.5','1702.5'),
('141','583','ENR28A8B2E4F8A63',287,'1702.5','0',NULL,'1702.5','1702.5'),
('142','584','ENRA1EA5410495D2',288,'24180','22180',NULL,'2000','2000'),
('143','595','ENR254D85C83D568',289,'22025','12025',NULL,'10000','10000'),
('145','606','ENRD71F47821BA90',290,'22025','0',NULL,'22025','22025'),
('146','585','ENRA1EA5410495D2',291,'22180','20180',NULL,'2000','2218'),
('147','596','ENR254D85C83D568',292,'12025','10822.5',NULL,'1202.5','1202.5'),
('147','597','ENR254D85C83D568',293,'10822.5','9620',NULL,'1202.5','1202.5'),
('147','598','ENR254D85C83D568',294,'9620','9025',NULL,'595','1202.5'),
('148','585','ENRA1EA5410495D2',295,'20180','19962',NULL,'218','218'),
('149','586','ENRA1EA5410495D2',296,'19962','17744',NULL,'2218','2218'),
('149','587','ENRA1EA5410495D2',297,'17744','15526',NULL,'2218','2218'),
('150','598','ENR254D85C83D568',298,'9025','8417.5',NULL,'607.5','607.5'),
('151','588','ENRA1EA5410495D2',299,'15526','13308',NULL,'2218','2218'),
('152','599','ENR254D85C83D568',300,'8417.5','7215',NULL,'1202.5','1202.5'),
('153','617','ENRFD53228F26C2C',301,'21025','13225',NULL,'7800','7800'),
('154','618','ENRFD53228F26C2C',302,'13225','11902.5',NULL,'1322.5','1322.5'),
('154','619','ENRFD53228F26C2C',303,'11902.5','11725',NULL,'177.5','1322.5'),
('155','619','ENRFD53228F26C2C',304,'11725','10580',NULL,'1145','1145'),
('155','620','ENRFD53228F26C2C',305,'10580','9257.5',NULL,'1322.5','1322.5'),
('155','621','ENRFD53228F26C2C',306,'9257.5','7935',NULL,'1322.5','1322.5'),
('155','622','ENRFD53228F26C2C',307,'7935','6612.5',NULL,'1322.5','1322.5'),
('155','623','ENRFD53228F26C2C',308,'6612.5','5290',NULL,'1322.5','1322.5'),
('155','624','ENRFD53228F26C2C',309,'5290','3967.5',NULL,'1322.5','1322.5'),
('155','625','ENRFD53228F26C2C',310,'3967.5','2645',NULL,'1322.5','1322.5'),
('155','626','ENRFD53228F26C2C',311,'2645','1322.5',NULL,'1322.5','1322.5'),
('155','627','ENRFD53228F26C2C',312,'1322.5','0',NULL,'1322.5','1322.5');

/*Table structure for table `payment_settings` */

DROP TABLE IF EXISTS `payment_settings`;

CREATE TABLE `payment_settings` (
  `installment_number` varchar(100) DEFAULT NULL,
  `dueDate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment_settings` */

insert  into `payment_settings`(`installment_number`,`dueDate`) values 
('2','2025-07-30');

/*Table structure for table `schedule` */

DROP TABLE IF EXISTS `schedule`;

CREATE TABLE `schedule` (
  `schedule_id` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `advisory_id` varchar(100) DEFAULT NULL COMMENT 'alternate for section with adviser',
  `subject_id` varchar(100) DEFAULT NULL,
  `teacher_id` varchar(100) DEFAULT NULL,
  `from_time` varchar(100) DEFAULT NULL,
  `to_time` varchar(100) DEFAULT NULL,
  `minutes` varchar(100) DEFAULT NULL,
  `monday` varchar(100) DEFAULT NULL,
  `tuesday` varchar(100) DEFAULT NULL,
  `wednesday` varchar(100) DEFAULT NULL,
  `thursday` varchar(100) DEFAULT NULL,
  `friday` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `schedule` */

insert  into `schedule`(`schedule_id`,`syid`,`advisory_id`,`subject_id`,`teacher_id`,`from_time`,`to_time`,`minutes`,`monday`,`tuesday`,`wednesday`,`thursday`,`friday`) values 
('SCHED9A6BA41F2DC88','SY1','ADVB4BBD7EF5420B','SUBJEDE9205EC2D09','TDEC9218A0D6B5','7:30 AM','8:05 AM',NULL,'1','1','1','1','1'),
('SCHED08C428AE3D72A','SY1','ADVB4BBD7EF5420B','SUBJ92E51EC18A701','TE73F9F3CE2494','8:05 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHEDE45358D27B4C4','SY1','ADVB4BBD7EF5420B','SUBJ02DAC88F0F0A1','TDEC9218A0D6B5','8:50 AM','9:35 AM',NULL,'1','1','1','1','1'),
('SCHED9DC3A9EE0E734','SY1','ADVB4BBD7EF5420B','SUBJE77713F7C6A33','TDFDB936CDE413','9:50 AM','10:35 AM',NULL,'1','1','1','1','1'),
('SCHEDA9683DEFC1A13','SY1','ADVB4BBD7EF5420B','SUBJF8E11A50DE474','TDEC9218A0D6B5','10:35 AM','11:20 AM',NULL,'1','1','1','1','1'),
('SCHEDA532640C770A2','SY1','ADVB4BBD7EF5420B','SUBJD8093D5D1FA2B','T158F0C1C96533','12:20 PM','1:05 PM',NULL,'1','1','1','1','1'),
('SCHED67E9813B6A7BD','SY1','ADVB4BBD7EF5420B','SUBJEC230F002A831','TDEC9218A0D6B5','1:05 PM','1:50 PM',NULL,'1','1','1','1','1'),
('SCHEDDE9C0F1E92A9F','SY1','ADVB4BBD7EF5420B','SUBJB4BFECB6D5EE7','TDEC9218A0D6B5','1:50 PM','2:35 PM',NULL,'1','1','1','1','1'),
('SCHED58E9B93D1C55A','SY03FBB1599C61C','ADVCE3AAA218B77C','SUBJFCE25D759253C','TDFDB936CDE413','7:30 AM','8:05 AM',NULL,'1','1','1','1','1'),
('SCHED7E8C7620B49E2','SY03FBB1599C61C','ADVCE3AAA218B77C','SUBJFC78994270B2C','TDEC9218A0D6B5','8:05 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHEDFDE10E37857C9','SY03FBB1599C61C','ADVCE3AAA218B77C','SUBJFC78994270B2C','TE73F9F3CE2494','9:10 AM','10:10 AM',NULL,'1','1','1','1','1'),
('SCHEDF1ECFE14332C0','SY03FBB1599C61C','ADV49EC384CD87CD','SUBJ82301CF8E96A1','T392DF740696AD','8:35 AM','9:25 AM',NULL,'1','1','0','0','0'),
('SCHEDBCB548698DAAC','SY03FBB1599C61C','ADV49EC384CD87CD','SUBJE1C5B2EFBFCEC','T392DF740696AD','7:30 AM','8:20 AM',NULL,'1','1','0','0','0'),
('SCHEDA23D8326F2C71','SY03FBB1599C61C','ADV49EC384CD87CD','SUBJ6B071566C5CC2','T392DF740696AD','8:35 AM','9:25 AM',NULL,'0','0','1','1','0'),
('SCHEDABE11F7A3BA46','SY03FBB1599C61C','ADV49EC384CD87CD','SUBJ4B514E15A0A04','T392DF740696AD','8:45 AM','9:30 AM',NULL,'0','0','0','0','1'),
('SCHED97A319E3CCC81','SY03FBB1599C61C','ADV31BE4DAE5CEAD','SUBJ3E39D8690E79C','T699EBCDE12880','7:30 AM','8:10 AM',NULL,'1','1','1','1','1'),
('SCHED633D0B2C3F370','SY03FBB1599C61C','ADV31BE4DAE5CEAD','SUBJ00BE5D7E0A809','TEBB45FA054403','8:10 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHED2002907E5CDD9','SY03FBB1599C61C','ADV31BE4DAE5CEAD','SUBJD2199CBAA95B6','T699EBCDE12880','9:05 AM','9:45 AM',NULL,'1','1','1','1','1'),
('SCHED6732077664025','SY03FBB1599C61C','ADV31BE4DAE5CEAD','SUBJE1C5B2EFBFCEC','T699EBCDE12880','9:45 AM','10:25 AM',NULL,'1','1','1','1','1'),
('SCHED2F3ECDBD6C37B','SY03FBB1599C61C','ADV31BE4DAE5CEAD','SUBJ6620E8FD80AFE','T699EBCDE12880','10:25 AM','11:05 AM',NULL,'1','1','1','1','1'),
('SCHED405C3747C260E','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJAD725F3830A10','TEBB45FA054403','7:30 AM','8:10 AM',NULL,'1','1','1','1','1'),
('SCHED0D5B8E78C7FB1','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJB9E373050221D','T699EBCDE12880','8:10 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHED49AC5AFF26B66','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJ916F107C60D25','TEBB45FA054403','8:50 AM','9:30 AM',NULL,'1','1','1','1','1'),
('SCHEDA63E21665D7E1','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJ8C775AC3D2C38','TEBB45FA054403','9:45 AM','10:25 AM',NULL,'1','1','1','1','1'),
('SCHEDB013C29F2C17E','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJ95B7BBA41721F','TEBB45FA054403','10:25 AM','11:05 AM',NULL,'1','1','1','1','1'),
('SCHEDEC98967A6E74C','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJEBEF8E67C9381','TEBB45FA054403','12:45 PM','1:25 PM',NULL,'1','1','1','1','1'),
('SCHEDB3F664CECF3C2','SY03FBB1599C61C','ADV35B9B1ABF3B33','SUBJ9E569E62AC89C','TEBB45FA054403','12:05 PM','12:45 PM',NULL,'1','1','1','1','1'),
('SCHED61875A3032624','SY03FBB1599C61C','ADV98EEA1C4ADC4F','SUBJAD725F3830A10','TE73F9F3CE2494','7:30 AM','8:05 AM',NULL,'1','1','1','1','1'),
('SCHED640C51EECC199','SY03FBB1599C61C','ADV98EEA1C4ADC4F','SUBJEA28EF6AD4494','TDFDB936CDE413','8:05 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHEDDCD3A0EBB10C5','SY03FBB1599C61C','ADV98EEA1C4ADC4F','SUBJ14CB55A4DD6CD','TDEC9218A0D6B5','9:50 AM','10:35 AM',NULL,'1','1','1','1','1'),
('SCHED7A841D803E9BA','SY03FBB1599C61C','ADV98EEA1C4ADC4F','SUBJBA3695DEF7CF0','T158F0C1C96533','10:35 AM','11:20 AM',NULL,'1','1','1','1','1'),
('SCHED1771119EC889E','SY03FBB1599C61C','ADV98EEA1C4ADC4F','SUBJ673B033EB2043','TE73F9F3CE2494','12:20 PM','1:05 PM',NULL,'1','1','1','1','1'),
('SCHEDAD067516AA057','SY03FBB1599C61C','ADV98EEA1C4ADC4F','SUBJ8767CF64F8B1F','T158F0C1C96533','1:05 PM','1:50 PM',NULL,'1','1','1','1','1'),
('SCHED97AFD55BFA265','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJ3E39D8690E79C','TDEC9218A0D6B5','7:30 AM','8:05 AM',NULL,'1','1','1','1','1'),
('SCHED6753F51304046','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJ92E51EC18A701','TE73F9F3CE2494','8:05 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHEDD4C4574C4BD29','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJ02DAC88F0F0A1','TDEC9218A0D6B5','8:50 AM','9:35 AM',NULL,'1','1','1','1','1'),
('SCHEDC026DDBFF731D','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJE77713F7C6A33','TDFDB936CDE413','9:50 AM','10:35 AM',NULL,'1','1','1','1','1'),
('SCHEDE44C8B2B1A48C','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJF8E11A50DE474','TDEC9218A0D6B5','10:35 AM','11:20 AM',NULL,'1','1','1','1','1'),
('SCHEDE4A4EAD1B94AF','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJD8093D5D1FA2B','T158F0C1C96533','12:20 PM','1:05 PM',NULL,'1','1','1','1','1'),
('SCHED783865CABB3E7','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJEC230F002A831','TDEC9218A0D6B5','1:05 PM','1:50 PM',NULL,'1','1','1','1','1'),
('SCHED24CCFDC6BF15F','SY03FBB1599C61C','ADVF43E094A5A13C','SUBJB4BFECB6D5EE7','TDEC9218A0D6B5','1:50 PM','2:35 PM',NULL,'1','1','1','1','1'),
('SCHED36851805F108C','SY03FBB1599C61C','ADV37A37989430D0','SUBJD5F563D52DD58','T158F0C1C96533','7:30 AM','8:05 AM',NULL,'1','1','1','1','1'),
('SCHED26ACB9F8D979B','SY03FBB1599C61C','ADV37A37989430D0','SUBJ67E5D9552F08C','T158F0C1C96533','8:05 AM','8:50 AM',NULL,'1','1','1','1','1'),
('SCHEDC3C4C9D0AE0A7','SY03FBB1599C61C','ADV37A37989430D0','SUBJBEB413FE43C18','TDFDB936CDE413','8:50 AM','9:35 AM',NULL,'1','1','1','1','1'),
('SCHED4DCA7DF128A8F','SY03FBB1599C61C','ADV37A37989430D0','SUBJCC9C596D7EC37','T158F0C1C96533','9:50 AM','10:35 AM',NULL,'1','1','1','1','1'),
('SCHED300CCA74EC13B','SY03FBB1599C61C','ADV37A37989430D0','SUBJE3F84C6FEB80F','TE73F9F3CE2494','10:35 AM','11:20 AM',NULL,'1','1','1','1','1'),
('SCHED17E0AEA934BCB','SY03FBB1599C61C','ADV37A37989430D0','SUBJ808FA8B46244D','TDFDB936CDE413','12:20 PM','1:05 PM',NULL,'1','1','1','1','1'),
('SCHED74F6C1B8A0D08','SY03FBB1599C61C','ADV37A37989430D0','SUBJ98B0FE1920949','T158F0C1C96533','1:50 PM','2:35 PM',NULL,'1','1','1','1','1'),
('SCHEDC700C0934E5DD','SY03FBB1599C61C','ADV37A37989430D0','SUBJ95BD0E8EA9263','T499692CC26249','1:05 PM','1:50 PM',NULL,'1','1','1','1','1'),
('SCHED29E66B498DF53','SY03FBB1599C61C','ADV31BE4DAE5CEAD','SUBJF83642480CDF9','TDEC9218A0D6B5','12:10 PM','1:00 PM',NULL,'1','1','1','1','1');

/*Table structure for table `school_year` */

DROP TABLE IF EXISTS `school_year`;

CREATE TABLE `school_year` (
  `syid` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `school_year` */

insert  into `school_year`(`syid`,`school_year`,`active_status`) values 
('SY1','2023-2024','INACTIVE'),
('SY03FBB1599C61C','2024-2025','ACTIVE'),
('SYFBB81F85BEC2F','2025-2026','INACTIVE');

/*Table structure for table `section` */

DROP TABLE IF EXISTS `section`;

CREATE TABLE `section` (
  `section_id` varchar(100) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `section` */

insert  into `section`(`section_id`,`section`,`grade_level`,`status`) values 
('SECF875B8B2F6DD0','4',NULL,'ACTIVE'),
('SEC5DF1F26E0354A','5',NULL,'ACTIVE'),
('SEC616E07096778D','1',NULL,'ACTIVE'),
('SECB83A9B1FD2EE5','3',NULL,'ACTIVE'),
('SEC51FF453E2D3EB','6',NULL,'ACTIVE'),
('SECA24093ECD2301','2',NULL,'ACTIVE'),
('SECD1E6E994D17DC','7',NULL,'ACTIVE');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `grading_period` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `settings` */

insert  into `settings`(`grading_period`,`active_status`) values 
('first_grading','active'),
('second_grading','active'),
('third_grading','active'),
('fourth_grading','active');

/*Table structure for table `student` */

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `student_id` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `name_extension` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city_mun` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `active_sy` varchar(100) DEFAULT NULL,
  `birthDate` varchar(100) DEFAULT NULL,
  `birthPlace` varchar(100) DEFAULT NULL,
  `sex` varchar(100) DEFAULT NULL,
  `ip_flag` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `father_firstname` varchar(100) DEFAULT NULL,
  `father_middlename` varchar(100) DEFAULT NULL,
  `father_lastname` varchar(100) DEFAULT NULL,
  `mother_firstname` varchar(100) DEFAULT NULL,
  `mother_middlename` varchar(100) DEFAULT NULL,
  `mother_lastname` varchar(100) DEFAULT NULL,
  `father_contact` varchar(100) DEFAULT NULL,
  `father_fb` varchar(100) DEFAULT NULL,
  `mother_contact` varchar(100) DEFAULT NULL,
  `mother_fb` varchar(100) DEFAULT NULL,
  `guardian_firstname` varchar(100) DEFAULT NULL,
  `guardian_middlename` varchar(100) DEFAULT NULL,
  `guardian_lastname` varchar(100) DEFAULT NULL,
  `guardian_phone` varchar(100) DEFAULT NULL,
  `guardian_occupation` varchar(100) DEFAULT NULL,
  `last_gradelevel` varchar(100) DEFAULT NULL,
  `last_schoolname` varchar(100) DEFAULT NULL,
  `last_schooladdress` varchar(100) DEFAULT NULL,
  `last_sycompleted` varchar(100) DEFAULT NULL,
  `last_schoolid` varchar(100) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `father_education` varchar(100) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `mother_education` varchar(100) DEFAULT NULL,
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` varchar(100) DEFAULT NULL,
  `current_enrollment_id` varchar(100) DEFAULT NULL,
  `grade_settings` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `auto_id` (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

/*Data for the table `student` */

insert  into `student`(`student_id`,`firstname`,`middlename`,`lastname`,`name_extension`,`region`,`province`,`city_mun`,`barangay`,`address`,`active_sy`,`birthDate`,`birthPlace`,`sex`,`ip_flag`,`religion`,`father_firstname`,`father_middlename`,`father_lastname`,`mother_firstname`,`mother_middlename`,`mother_lastname`,`father_contact`,`father_fb`,`mother_contact`,`mother_fb`,`guardian_firstname`,`guardian_middlename`,`guardian_lastname`,`guardian_phone`,`guardian_occupation`,`last_gradelevel`,`last_schoolname`,`last_schooladdress`,`last_sycompleted`,`last_schoolid`,`father_occupation`,`father_education`,`mother_occupation`,`mother_education`,`auto_id`,`parent_id`,`current_enrollment_id`,`grade_settings`) values 
('LRN405501010101__','LUKA','L','DONCIC','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Gredu (Pob.)','HOUSE 1','SY03FBB1599C61C','2018-04-28','DAVAO CITY','Male',NULL,'ROMAN CATHOLIC','DADDY','','DONCIC','MOMMY','','DONCIC','(+63) 1231231231','AWIT G','(+63) 1231231231','NONE','','','','','',NULL,NULL,NULL,NULL,NULL,'BUSINESS MAN','COLLEGE GRADUATE','HOUSE WIFE','COLLEGE GRADUATE',30,NULL,'ENRFD53228F26C2C','ACTIVE'),
('LRN40559200000026','Michael','Bayron','Virtudazo','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CARMEN','Cebulano','Purok 3','SY03FBB1599C61C','2002-05-04','DAVAO CITY','Male',NULL,'Roman Catholic','','','','','','','','','','','ALthea','Bayron','Galorio','(+63) 9850623148','BUSINESSMAN',NULL,NULL,NULL,NULL,NULL,'','','','',26,'USR-a8ef4c1ca89b5-241205','ENR28A8B2E4F8A63','INACTIVE'),
('LRN40559200000027','Brian Rey','Galo','Galorio','','AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)','BASILAN','CITY OF LAMITAN','Arco','Purok 3','SY03FBB1599C61C','2002-05-04','DAVAO CITY','Male',NULL,'Roman Catholic','','','','','','','','','','','michael','Oh','Caballes','(+63) 9850623148','GUARDIAN',NULL,NULL,NULL,NULL,NULL,'','','','',27,'USR-a8ef4c1ca89b5-241205','ENRA1EA5410495D2','ACTIVE'),
('LRN40559200000028','Darren Kent','Abenion','Tusias','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Salvacion','Purok 3, Salvacion, Panabo City','SY03FBB1599C61C','2002-04-27','Tagum City, Davao Del Norte','Male',NULL,'Catholic','','','','','','','','','','','Dasha','Taran','Taran','(+63) 9770985031','Chief Executive Officer',NULL,NULL,NULL,NULL,NULL,'','','','',28,'USR-a8ef4c1ca89b5-241205','ENR254D85C83D568','INACTIVE'),
('LRN40559200000029','Kobe','','Byrant','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CARMEN','Cebulano','2','SY1','2025-09-23','Carmen','Male',NULL,'Roman Catholic','Brian','','Caballes','','','','(+63) 1231313131','OFFICIAL FB','','','','','','','',NULL,NULL,NULL,NULL,NULL,'BUSINESSMAN','COLLEGE GRADUATE','','',29,NULL,'ENRD71F47821BA90','ACTIVE');

/*Table structure for table `student_grades` */

DROP TABLE IF EXISTS `student_grades`;

CREATE TABLE `student_grades` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` varchar(100) DEFAULT NULL,
  `schedule_id` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `advisory_id` varchar(100) DEFAULT NULL,
  `first_grading` varchar(100) DEFAULT NULL,
  `second_grading` varchar(100) DEFAULT NULL,
  `third_grading` varchar(100) DEFAULT NULL,
  `fourth_grading` varchar(100) DEFAULT NULL,
  `average` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8mb4;

/*Data for the table `student_grades` */

insert  into `student_grades`(`grade_id`,`subject_id`,`schedule_id`,`student_id`,`advisory_id`,`first_grading`,`second_grading`,`third_grading`,`fourth_grading`,`average`,`remarks`) values 
(149,'SUBJD5F563D52DD58','SCHED36851805F108C','LRN40559200000026','ADV37A37989430D0','74','85','90','75',NULL,NULL),
(150,'SUBJ67E5D9552F08C','SCHED26ACB9F8D979B','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(151,'SUBJBEB413FE43C18','SCHEDC3C4C9D0AE0A7','LRN40559200000026','ADV37A37989430D0','90','82','81','90',NULL,NULL),
(152,'SUBJCC9C596D7EC37','SCHED4DCA7DF128A8F','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(153,'SUBJ5F6FCDBB91442','SCHED300CCA74EC13B','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(154,'SUBJ42CF5DF29E6BD','SCHED300CCA74EC13B','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(155,'SUBJFAD96F628A015','SCHED300CCA74EC13B','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(156,'SUBJA76E10A8BC50A','SCHED300CCA74EC13B','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(157,'SUBJ808FA8B46244D','SCHED17E0AEA934BCB','LRN40559200000026','ADV37A37989430D0','90','86','91','92',NULL,NULL),
(158,'SUBJ95BD0E8EA9263','SCHEDC700C0934E5DD','LRN40559200000026','ADV37A37989430D0',NULL,NULL,NULL,NULL,NULL,NULL),
(159,'SUBJ98B0FE1920949','SCHED74F6C1B8A0D08','LRN40559200000026','ADV37A37989430D0','99','94','98','92',NULL,NULL),
(160,'SUBJFCE25D759253C','SCHED58E9B93D1C55A','LRN40559200000027','ADVCE3AAA218B77C','90','85','85','90',NULL,NULL),
(161,'SUBJFC78994270B2C','SCHEDFDE10E37857C9','LRN40559200000027','ADVCE3AAA218B77C','90','92','85','93',NULL,NULL),
(162,'SUBJD5F563D52DD58','SCHED36851805F108C','LRN40559200000028','ADV37A37989430D0','85','90','92','89',NULL,NULL),
(163,'SUBJ67E5D9552F08C','SCHED26ACB9F8D979B','LRN40559200000028','ADV37A37989430D0','90','92','89','92',NULL,NULL),
(164,'SUBJBEB413FE43C18','SCHEDC3C4C9D0AE0A7','LRN40559200000028','ADV37A37989430D0','92','94','91','93',NULL,NULL),
(165,'SUBJCC9C596D7EC37','SCHED4DCA7DF128A8F','LRN40559200000028','ADV37A37989430D0','90','93','91','92',NULL,NULL),
(166,'SUBJ5F6FCDBB91442','SCHED300CCA74EC13B','LRN40559200000028','ADV37A37989430D0','90','91','93','90',NULL,NULL),
(167,'SUBJ42CF5DF29E6BD','SCHED300CCA74EC13B','LRN40559200000028','ADV37A37989430D0','90','92','93','94',NULL,NULL),
(168,'SUBJFAD96F628A015','SCHED300CCA74EC13B','LRN40559200000028','ADV37A37989430D0','91','90','92','93',NULL,NULL),
(169,'SUBJA76E10A8BC50A','SCHED300CCA74EC13B','LRN40559200000028','ADV37A37989430D0','93','94','92','95',NULL,NULL),
(170,'SUBJ808FA8B46244D','SCHED17E0AEA934BCB','LRN40559200000028','ADV37A37989430D0','89','90','91','93',NULL,NULL),
(171,'SUBJ95BD0E8EA9263','SCHEDC700C0934E5DD','LRN40559200000028','ADV37A37989430D0','92','93','91','94',NULL,NULL),
(172,'SUBJ98B0FE1920949','SCHED74F6C1B8A0D08','LRN40559200000028','ADV37A37989430D0','98','97','97','99',NULL,NULL),
(173,'SUBJEDE9205EC2D09','SCHED9A6BA41F2DC88','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(174,'SUBJ3E019105754A7','SCHED08C428AE3D72A','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(175,'SUBJB232AC8A4691C','SCHED08C428AE3D72A','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(176,'SUBJ13B47BE10D5E9','SCHED08C428AE3D72A','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(177,'SUBJ36044A4F83E49','SCHED08C428AE3D72A','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(178,'SUBJ02DAC88F0F0A1','SCHEDE45358D27B4C4','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(179,'SUBJE77713F7C6A33','SCHED9DC3A9EE0E734','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(180,'SUBJF8E11A50DE474','SCHEDA9683DEFC1A13','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(181,'SUBJD8093D5D1FA2B','SCHEDA532640C770A2','LRN40559200000029','ADVB4BBD7EF5420B','90','80','90','87',NULL,NULL),
(182,'SUBJEC230F002A831','SCHED67E9813B6A7BD','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL),
(183,'SUBJB4BFECB6D5EE7','SCHEDDE9C0F1E92A9F','LRN40559200000029','ADVB4BBD7EF5420B',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `subject_main` */

DROP TABLE IF EXISTS `subject_main`;

CREATE TABLE `subject_main` (
  `subject_head_id` decimal(10,1) NOT NULL,
  `subject_head_name` varchar(100) DEFAULT NULL,
  `main_subject` int(1) DEFAULT NULL,
  PRIMARY KEY (`subject_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subject_main` */

insert  into `subject_main`(`subject_head_id`,`subject_head_name`,`main_subject`) values 
(1.0,'Mother Tongue',1),
(2.0,'Filipino',1),
(3.0,'English',1),
(4.0,'Mathematics',1),
(5.0,'Science',1),
(6.0,'Araling Panlipunan',1),
(7.0,'EPP / TLE',1),
(8.0,'MAPEH',1),
(8.1,'Music',0),
(8.2,'Arts',0),
(8.3,'Physical Education',0),
(8.4,'Health',0),
(9.0,'Edukasyon sa Pagpapakatao',1),
(10.0,'Computer',1);

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `subject_id` varchar(100) DEFAULT NULL,
  `subject_code` varchar(100) DEFAULT NULL,
  `subject_title` varchar(100) DEFAULT NULL,
  `subject_description` varchar(100) DEFAULT NULL,
  `subject_head_id` varchar(100) DEFAULT NULL COMMENT 'mao ni mabutang sa grade card na subject jud',
  `subject_type` enum('PARENT','CHILD') DEFAULT NULL,
  `subject_parent_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `subjects` */

insert  into `subjects`(`subject_id`,`subject_code`,`subject_title`,`subject_description`,`subject_head_id`,`subject_type`,`subject_parent_id`) values 
('SUBJ3E39D8690E79C','GMRC / BIBLE','GMRC / BIBLE','GMRC / BIBLE','9.0','PARENT',NULL),
('SUBJ00BE5D7E0A809','MATH 1','MATH 1','MATH 1','4.0','PARENT',NULL),
('SUBJ5D3512C8E76B6','ENGLISH 1','ENGLISH 1','ENGLISH 1','3.0','PARENT',NULL),
('SUBJE1C5B2EFBFCEC','READING AND LITERACY 1','READING AND LITERACY 1','READING AND LITERACY 1','1.0','PARENT',NULL),
('SUBJEDE9205EC2D09','GMRC/BIBLE 4','GMRC/BIBLE 4','GMRC/BIBLE 4','9.0','PARENT',NULL),
('SUBJ92E51EC18A701','MAPEH 4','MAPEH 4','MAPEH 4','8.0','PARENT',NULL),
('SUBJ3E019105754A7','','Music','','8.1','CHILD','SUBJ92E51EC18A701'),
('SUBJB232AC8A4691C','','Arts','','8.2','CHILD','SUBJ92E51EC18A701'),
('SUBJ13B47BE10D5E9','','Physical Education','','8.3','CHILD','SUBJ92E51EC18A701'),
('SUBJ36044A4F83E49','','Health','','8.4','CHILD','SUBJ92E51EC18A701'),
('SUBJ02DAC88F0F0A1','EPP 4','EPP 4','EPP 4','7.0','PARENT',NULL),
('SUBJE77713F7C6A33','MATH 4','MATH 4','MATH 4','4.0','PARENT',NULL),
('SUBJF8E11A50DE474','Filipino 4','Filipino 4','Filipino 4','2.0','PARENT',NULL),
('SUBJD8093D5D1FA2B','Araling Panlipunan 4','Araling Panlipunan 4','Araling Panlipunan 4','6.0','PARENT',NULL),
('SUBJEC230F002A831','Science 4','Science 4','Science 4','5.0','PARENT',NULL),
('SUBJB4BFECB6D5EE7','English 4','English 4','English 4','3.0','PARENT',NULL),
('SUBJFCE25D759253C','ESP / BIBLE 5','ESP / BIBLE 5','ESP / BIBLE 5','9.0','PARENT',NULL),
('SUBJFC78994270B2C','EPP 5','EPP 5','EPP 5','7.0','PARENT',NULL),
('SUBJA0F29F9BC6B7B','ESP 3','ESP 3','ESP/BIBLE','9.0','PARENT',NULL),
('SUBJEA28EF6AD4494','MATH 3','MATH 3','MATHEMATICS 3','4.0','PARENT',NULL),
('SUBJF1EEFAE1CAF4D','MAPEH 3','MAPEH 3','MAPEH 3','8.0','PARENT',NULL),
('SUBJEA3B0F220F59C','','Music','','8.1','CHILD','SUBJF1EEFAE1CAF4D'),
('SUBJ87EAF539F1E0C','','Arts','','8.2','CHILD','SUBJF1EEFAE1CAF4D'),
('SUBJ0F924CB584797','','Physical Education','','8.3','CHILD','SUBJF1EEFAE1CAF4D'),
('SUBJE3AF773C889C2','','Health','','8.4','CHILD','SUBJF1EEFAE1CAF4D'),
('SUBJ14CB55A4DD6CD','SCIENCE 3','SCIENCE 3','SCIENCE 3','5.0','PARENT',NULL),
('SUBJBA3695DEF7CF0','FILIPINO 3','FILIPINO 3','FILIPINO 3','2.0','PARENT',NULL),
('SUBJ673B033EB2043','ARALING PANLIPUNAN 3','ARALING PANLIPUNAN 3','ARALING PANLIPUNAN 3','6.0','PARENT',NULL),
('SUBJ8767CF64F8B1F','ENGLISH 3','ENGLISH 3','ENGLISH 3','3.0','PARENT',NULL),
('SUBJ662273E1C47E6','ENGLISH 5','ENGLISH 5','ENGLISH 5','3.0','PARENT',NULL),
('SUBJ27F90E4F6B88B','MAPEH 5','MAPEH 5','MAPEH 5','8.0','PARENT',NULL),
('SUBJCF17199D41B06','','Music','','8.1','CHILD','SUBJ27F90E4F6B88B'),
('SUBJD3699C20FC1E0','','Arts','','8.2','CHILD','SUBJ27F90E4F6B88B'),
('SUBJ3010129B0525A','','Physical Education','','8.3','CHILD','SUBJ27F90E4F6B88B'),
('SUBJFD96008B83E18','','Health','','8.4','CHILD','SUBJ27F90E4F6B88B'),
('SUBJD5DC3D1534808','MATH 5','MATH 5','MATHEMATICS 5','4.0','PARENT',NULL),
('SUBJ23D8C7C2624D8','SCIENCE 5','SCIENCE 5','SCIENCE 5','5.0','PARENT',NULL),
('SUBJ466B2F94CEAC2','ARALING PANLIPUNAN 5','ARALING PANLIPUNAN 5','ARALING PANLIPUNAN 5','6.0','PARENT',NULL),
('SUBJ1FCC2312C6C92','FILIPINO 5','FILIPINO 5','FILIPINO 5','2.0','PARENT',NULL),
('SUBJD5F563D52DD58','ESP / BIBLE 6','ESP / BIBLE 6','ESP/ BIBLE 6','9.0','PARENT',NULL),
('SUBJ67E5D9552F08C','EPP 6','EPP 6','EPP 6','7.0','PARENT',NULL),
('SUBJBEB413FE43C18','MATH 6','MATH 6','MATHEMATICS 6','4.0','PARENT',NULL),
('SUBJCC9C596D7EC37','FILIPINO 6','FILIPINO 6','FILIPINO 6','2.0','PARENT',NULL),
('SUBJE3F84C6FEB80F','MAPEH 6','MAPEH 6','MAPEH 6','8.0','PARENT',NULL),
('SUBJ5F6FCDBB91442','','Music','','8.1','CHILD','SUBJE3F84C6FEB80F'),
('SUBJ42CF5DF29E6BD','','Arts','','8.2','CHILD','SUBJE3F84C6FEB80F'),
('SUBJFAD96F628A015','','Physical Education','','8.3','CHILD','SUBJE3F84C6FEB80F'),
('SUBJA76E10A8BC50A','','Health','','8.4','CHILD','SUBJE3F84C6FEB80F'),
('SUBJ808FA8B46244D','ARALING PANLIPUNAN 6','ARALING PANLIPUNAN 6','ARALING PANLIPUNAN 6','6.0','PARENT',NULL),
('SUBJ95BD0E8EA9263','ENGLISH 6','ENGLISH 6','ENGLISH 6','3.0','PARENT',NULL),
('SUBJ98B0FE1920949','SCIENCE 6','SCIENCE 6','SCIENCE 6','5.0','PARENT',NULL),
('SUBJ5D33EB2A30AF4','Science 1','Language/Physical and Natural Science','Science 1','5.0','PARENT',NULL),
('SUBJ82301CF8E96A1','SCI 1','Language/Physical and Natural Science','Language/Physical and Natural Science','5.0','PARENT',NULL),
('SUBJ6B071566C5CC2','GMRC/MAKABANSA','GMRC/MAKABANSA','GMRC/MAKABANSA','2.0','PARENT',NULL),
('SUBJ4B514E15A0A04','Computer 1','Computer 1','Computer 1','10.0','PARENT',NULL),
('SUBJD2199CBAA95B6','Language ','Language ','Language ','1.0','PARENT',NULL),
('SUBJ6620E8FD80AFE','Makabansa','Makabansa','Makabansa','2.0','PARENT',NULL),
('SUBJAD725F3830A10','ESP/BIBLE','ESP/BIBLE','ESP/BIBLE','9.0','PARENT',NULL),
('SUBJB9E373050221D','ENGLISH 2','ENGLISH 2','ENGLISH 2','3.0','PARENT',NULL),
('SUBJ916F107C60D25','Araling Panlipunan 2','Araling Panlipunan 2','Araling Panlipunan 2','6.0','PARENT',NULL),
('SUBJ8C775AC3D2C38','Math 2','Math 2','Math 2','4.0','PARENT',NULL),
('SUBJ95B7BBA41721F','Filipino 2','Filipino 2','Filipino 2','2.0','PARENT',NULL),
('SUBJEBEF8E67C9381','Reading and Literacy 2','Reading and Literacy 2','Reading and Literacy 2','3.0','PARENT',NULL),
('SUBJ9E569E62AC89C','MAPEH/COMPUTER','MAPEH/COMPUTER','MAPEH/COMPUTER','8.0','PARENT',NULL),
('SUBJD89F1FA5B59B2','','Music','','8.1','CHILD','SUBJ9E569E62AC89C'),
('SUBJ83723CAD913EF','','Arts','','8.2','CHILD','SUBJ9E569E62AC89C'),
('SUBJ8A77179A05B90','','Physical Education','','8.3','CHILD','SUBJ9E569E62AC89C'),
('SUBJ813A869C19F9D','','Health','','8.4','CHILD','SUBJ9E569E62AC89C'),
('SUBJF83642480CDF9','FIlipino 1','FIlipino 1','FIlipino 1','2.0','PARENT',NULL),
('SUBJ82F9C485A1164',NULL,NULL,NULL,NULL,'PARENT',NULL),
('SUBJ7DE206D3E645A',NULL,NULL,NULL,NULL,'PARENT',NULL),
('SUBJA3CA171CC9C5F',NULL,NULL,NULL,NULL,'PARENT',NULL),
('SUBJB5A77178B8BD5',NULL,NULL,NULL,NULL,'PARENT',NULL),
('SUBJ7D41AB5954600',NULL,NULL,NULL,NULL,'PARENT',NULL),
('SUBJ9C42E04A2E9DB',NULL,NULL,NULL,NULL,'PARENT',NULL);

/*Table structure for table `teacher` */

DROP TABLE IF EXISTS `teacher`;

CREATE TABLE `teacher` (
  `teacher_id` varchar(100) DEFAULT NULL,
  `teacher_firstname` varchar(100) DEFAULT NULL,
  `teacher_middlename` varchar(100) DEFAULT NULL,
  `teacher_lastname` varchar(100) DEFAULT NULL,
  `teacher_extension` varchar(100) DEFAULT NULL,
  `teacher_region` varchar(100) DEFAULT NULL,
  `teacher_province` varchar(100) DEFAULT NULL,
  `teacher_citymun` varchar(100) DEFAULT NULL,
  `teacher_barangay` varchar(100) DEFAULT NULL,
  `teacher_address` varchar(100) DEFAULT NULL,
  `college_course` varchar(100) DEFAULT NULL,
  `post_graduate_course` varchar(100) DEFAULT NULL,
  `teacher_birthdate` varchar(100) DEFAULT NULL,
  `teacher_gender` varchar(100) DEFAULT NULL,
  `teacher_emailaddress` varchar(100) DEFAULT NULL,
  `teacher_contactNumber` varchar(100) DEFAULT NULL,
  `teacher_profile` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `teacher` */

insert  into `teacher`(`teacher_id`,`teacher_firstname`,`teacher_middlename`,`teacher_lastname`,`teacher_extension`,`teacher_region`,`teacher_province`,`teacher_citymun`,`teacher_barangay`,`teacher_address`,`college_course`,`post_graduate_course`,`teacher_birthdate`,`teacher_gender`,`teacher_emailaddress`,`teacher_contactNumber`,`teacher_profile`) values 
('TDEC9218A0D6B5','Ellen Joy','S','Boctoto','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','J.P. Laurel','PUROK 2','BSIT','MIT','1990-05-05','Male','sakmaestro@gmail.com','(+63) 9912021547','uploads/profile_images/TDEC9218A0D6B5/profile_image.jpg'),
('TE73F9F3CE2494','Japhet','V','Tolentino','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 5','BS Education Major in English','Master in Secondary Education','1990-01-01','Male','shernancy@gmail.com','(+63) 9912021547',NULL),
('TDFDB936CDE413','Craizia Jane','M','Del Rosario','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 3','BS EDUC','','1984-05-05','Female','monkeygarp@gmail.com','(+63) 9912021900',NULL),
('T965A22ED6A3A7','Kaloy','','Loie','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Buenavista','PUROK 3','BS Educ in Math','','1976-09-21','Male','kaloyloie@gmail.com','(+63) 0991020222',NULL),
('T158F0C1C96533','Ailyn','S','Exclamado','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 1','BS in Education','','1990-01-01','Male','gifty_joy@yopmail.com','(+63) 1231231231',NULL),
('T392DF740696AD','Leah','M','Araneta ','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','New Visayas','Gentiles Subd','BS IN EDUCATION','Master in Education','1965-01-08','Female','leah_araneta@yopmail.com','(+63) 9297501250',NULL),
('T699EBCDE12880','Gifty Joy','Gencianos','Pandio','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Gredu (Pob.)','Purok Maharlika','BS IN EDUCATION','Master in Education','1996-10-08','Female','gifty_joy@yopmail.com','(+63) 9122700871',NULL),
('TFAA14AD1015E8','Charlene','Catalan','Serina','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Sindaton','Purok 3','BS IN EDUCATION','Master in Education','1996-01-29','Female','charlene_serina@yopmail.com','(+63) 9518444498',NULL),
('T6483BBFF587BC','Corie Anne Joy','Camino','Uypala','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CARMEN','Ising (Pob.)','Purok 13','BS IN EDUCATION','Master in Education','1986-03-13','Female','corie_anne@yopmail.com','(+63) 9631908956',NULL),
('TEBB45FA054403','Aniegyn','P','Advincula','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Kauswagan','PUROK 5','BS IN EDUCATION','Master in Education','1986-05-21','Female','aniegyn_advincula@yopmail.com','(+63) 0950581374',NULL),
('T499692CC26249','Angelyn','P','Comendador','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Datu Abdul Dadia','Purok 3','BS in Education','Master in Education','1980-05-02','Female','angelyn@yopmail.com','(+63) 9850623789',NULL),
('T9C605AAF7C68E','Ellen Joy','S','Boctoto','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','J.P. Laurel','Purok 2','BSIT','MIT','1990-05-05','Male','sakmaestro@asdfasdfasdf.com','(+63) 9912021547',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `active_remarks` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `profile_image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`role`,`active_remarks`,`fullname`,`gender`,`profile_image`) values 
('1','registrar','$2y$10$/IQUBLgWzYqQ3f.McUCBWeOw/697fyTx3ZehWh6Yds.CP7fp96WPK','admin','active','REGISTRAR',NULL,NULL),
('T158F0C1C96533','ailyn@yopmail.com','$2y$10$oduItQquavEivEjdYizQE.P9wvie8rovaUhlszq5R/hrJUEwLHdSe','teacher','active','Ailyn Exclamado',NULL,NULL),
('T392DF740696AD','leah_araneta@yopmail.com','$2y$10$LCmE6CLkz6/AZK1bVNuZ6uHyClizWVMYohffg11xh2my50niTjukq','teacher','active','Leah Araneta ',NULL,NULL),
('T499692CC26249','angelyn@yopmail.com','$2y$10$0OF6LG6oiTudml6Wbq30teD9mtV0bB7KCg7bUMksr2ZuKc3s.YS5e','teacher','active','Angelyn Comendador',NULL,NULL),
('T6483BBFF587BC','corie_anne@yopmail.com','$2y$10$2nzPr.dskDKKDfVeAMqyTeK0ZzOV3wOQSAYB6omHEB4R6Hwg4NJ9q','teacher','active','Corie Anne Joy Uypala',NULL,NULL),
('T699EBCDE12880','gifty_joy@yopmail.com','$2y$10$wRQ7tPuWF7A4PmIpqAw1FOUEA0WHGIrum2O93KZXoIezhGNNrVWSG','teacher','active','Gifty Joy Pandio',NULL,NULL),
('T9C605AAF7C68E','sakmaestro@asdfasdfasdf.com','$2y$10$kult2lWzTEl2iZpG5LPP1ev1.RkdUt6Oh.zaBL76k1Av94UjMl5gi','teacher','active','Ellen Joy Boctoto',NULL,NULL),
('TDEC9218A0D6B5','ellenjoy@yopmail.com','$2y$10$/IQUBLgWzYqQ3f.McUCBWeOw/697fyTx3ZehWh6Yds.CP7fp96WPK','teacher','active','Ellen Joy Boctoto',NULL,NULL),
('TDFDB936CDE413','craizia@yopmail.com','$2y$10$Ed7uBalvL71wslBUN3.1/u01lmaO4oN1XU6E/IB3nH1f0qP/kD7Oi','teacher','active','Craizia Jane Del Rosario',NULL,NULL),
('TE73F9F3CE2494','japhet@yopmail.com','$2y$10$orztpllakLvLF6TYdCnq.OTO3hjzHo9QAONfauHlWRzJI39BZhYpO','teacher','inactive','Japhet Tolentino',NULL,NULL),
('TEBB45FA054403','aniegyn_advincula@yopmail.com','$2y$10$ajp91aWsK1mYD6mAXKAmXOSdCRE8a/rUL0.u53nwaeqEV3QHuBbHK','teacher','active','Aniegyn Advincula',NULL,NULL),
('TFAA14AD1015E8','charlene_serina@yopmail.com','$2y$10$gTGT7VBqLsYO9Nzu2slmremuZSNilugjoREU8IR7u9kLGP7.i2iTe','teacher','active','Charlene Serina',NULL,NULL),
('USR-a8ef4c1ca89b5-241205','lyvee@yopmail.com','$2y$10$3U/it.ycbXHW96DioREZOe6WziLp38tz6nZZS8S2TWkPuB7RSzER2','parent','active','LYVEE JEAN GALORIO','FEMALE','uploads/users/default.jpg'),
('USR-bf7e8239f391b-240728','cashier@yopmail.com','$2y$10$n4ya6pMOanUCRdfZMrh3quKKCflNAK9sFWPFCEayDb1qX90N/Q692','cashier','active','Lebi san','MALE','uploads/users/fullname.png'),
('USR-d8644e21bf759-250219','alejandro@gmail.com','$2y$10$9Pr7Zy6Pbf8Sz2ezVbF7ju8ekuO0617usXN.8WYb6KVhyZuZplRuO','parent','active','ALEJANDRO DURAN','MALE','uploads/users/default.jpg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
