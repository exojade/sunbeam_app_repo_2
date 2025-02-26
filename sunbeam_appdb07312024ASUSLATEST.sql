/*
SQLyog Community v12.4.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - sunbeam_appdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sunbeam_appdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sunbeam_appdb`;

/*Table structure for table `advisory` */

DROP TABLE IF EXISTS `advisory`;

CREATE TABLE `advisory` (
  `advisory_id` varchar(100) DEFAULT NULL,
  `section_id` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `teacher_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `advisory` */

insert  into `advisory`(`advisory_id`,`section_id`,`grade_level`,`school_year`,`teacher_id`) values 
('ADV1C40A26E5FDFA','SEC668082EFCE2E5','Grade 1','SY1','TDEC9218A0D6B5'),
('ADV166E9C96EBEE0','SECCEDE107BB83B7','Grade 1','SY1','TE73F9F3CE2494'),
('ADVD8965A9662B2C','SEC070F73C456932','Grade 5','SY1','TDEC9218A0D6B5'),
('ADVE66196031AA40','SEC070F73C456932','Grade 2','SY03FBB1599C61C','T965A22ED6A3A7');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `enrollment` */

insert  into `enrollment`(`enrollment_id`,`dateEnrolled`,`syid`,`student_id`,`grade_level`,`advisory_id`,`status`,`credit_balance`,`monthly`) values 
('ENR388DEA392F02F','2024-07-28 09:21:30','SY1','LRN40559200000001','Grade 1','ADV166E9C96EBEE0','ENROLLED',NULL,'1737.5'),
('ENRE9E319BBE7C68','2024-07-31 21:03:18','SY1','LRN40559200000002','Grade 1','ADV166E9C96EBEE0','ENROLLED',NULL,'2102.5'),
('ENR3300858063722','2024-07-31 22:29:15','SY1','LRN40559200000003','Grade 1','ADV1C40A26E5FDFA','ENROLLED',NULL,'1652.5'),
('ENR58D015C0FC346','2024-07-31 23:18:30','SY03FBB1599C61C','LRN40559200000002','Grade 2','ADVE66196031AA40','ENROLLED',NULL,'780');

/*Table structure for table `enrollment_fees` */

DROP TABLE IF EXISTS `enrollment_fees`;

CREATE TABLE `enrollment_fees` (
  `fee_id` int(100) NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `fee` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `enrollment_fees` */

insert  into `enrollment_fees`(`fee_id`,`enrollment_id`,`fee`,`type`,`amount`,`status`) values 
(73,'ENR388DEA392F02F','JOGGING PANTS (LARGE)','OTHERS','350','PAYMENT'),
(74,'ENR388DEA392F02F','REGISTRATION FEE','MAIN','1000','PAYMENT'),
(75,'ENR388DEA392F02F','TUITION','MAIN','6000','PAYMENT'),
(76,'ENR388DEA392F02F','ELECTRICITY SUBSIDY','MAIN','3800','PAYMENT'),
(77,'ENR388DEA392F02F','ID AND INSURANCE','MAIN','380','PAYMENT'),
(78,'ENR388DEA392F02F','BOOKS','MAIN','5495','PAYMENT'),
(79,'ENR388DEA392F02F','MISCELLANEOUS FEE','MISCELLANEOUS','5350','PAYMENT'),
(80,'ENRE9E319BBE7C68','FOUNDATION FEE (2024)','OTHERS','1000','PAYMENT'),
(81,'ENRE9E319BBE7C68','REGISTRATION FEE','MAIN','1000','PAYMENT'),
(82,'ENRE9E319BBE7C68','TUITION','MAIN','6000','PAYMENT'),
(83,'ENRE9E319BBE7C68','ELECTRICITY SUBSIDY','MAIN','3800','PAYMENT'),
(84,'ENRE9E319BBE7C68','ID AND INSURANCE','MAIN','380','PAYMENT'),
(85,'ENRE9E319BBE7C68','BOOKS','MAIN','5495','PAYMENT'),
(86,'ENRE9E319BBE7C68','MISCELLANEOUS FEE','MISCELLANEOUS','5350','PAYMENT'),
(87,'ENR3300858063722','RESERVOIR FEE','OTHERS','1500','PAYMENT'),
(88,'ENR3300858063722','REGISTRATION FEE','MAIN','1000','PAYMENT'),
(89,'ENR3300858063722','TUITION','MAIN','6000','PAYMENT'),
(90,'ENR3300858063722','ELECTRICITY SUBSIDY','MAIN','3800','PAYMENT'),
(91,'ENR3300858063722','ID AND INSURANCE','MAIN','380','PAYMENT'),
(92,'ENR3300858063722','BOOKS','MAIN','5495','PAYMENT'),
(93,'ENR3300858063722','MISCELLANEOUS FEE','MISCELLANEOUS','5350','PAYMENT'),
(94,'ENR58D015C0FC346','RESERVOIR FEE','OTHERS','2000','PAYMENT'),
(95,'ENR58D015C0FC346','REGISTRATION FEE','MAIN','1000','PAYMENT'),
(96,'ENR58D015C0FC346','TUITION FEE','MAIN','6000','PAYMENT');

/*Table structure for table `fees` */

DROP TABLE IF EXISTS `fees`;

CREATE TABLE `fees` (
  `fees_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level` varchar(100) DEFAULT NULL,
  `fee_title` varchar(100) DEFAULT NULL,
  `fee_type` varchar(100) DEFAULT NULL,
  `fee_amount` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fees_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fees` */

insert  into `fees`(`fees_id`,`grade_level`,`fee_title`,`fee_type`,`fee_amount`,`status`) values 
(1,'Grade 1','REGISTRATION FEE','MAIN','1000','ACTIVE'),
(2,'Grade 1','TUITION','MAIN','6000','ACTIVE'),
(3,'Grade 1','ELECTRICITY SUBSIDY','MAIN','3800','ACTIVE'),
(4,'Grade 1','ID AND INSURANCE','MAIN','380','ACTIVE'),
(5,'Grade 1','BOOKS','MAIN','5495','ACTIVE'),
(6,'Grade 1','MISCELLANEOUS FEE','MISCELLANEOUS','5350','ACTIVE'),
(7,'','JOGGING PANTS (LARGE)','OTHERS','350','ACTIVE'),
(8,'','FOUNDATION FEE (2024)','OTHERS','1000','ACTIVE'),
(9,'','RESERVOIR FEE','OTHERS','','ACTIVE'),
(10,'Grade 2','REGISTRATION FEE','MAIN','1000','ACTIVE'),
(11,'Grade 2','TUITION FEE','MAIN','6000','ACTIVE');

/*Table structure for table `grade_level` */

DROP TABLE IF EXISTS `grade_level`;

CREATE TABLE `grade_level` (
  `grade_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`grade_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `installment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `amount_due` varchar(100) DEFAULT '',
  `is_paid` varchar(100) DEFAULT NULL,
  `installment_number` int(11) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `from_balance` varchar(100) DEFAULT NULL,
  `to_balance` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`installment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `installment` */

insert  into `installment`(`installment_id`,`enrollment_id`,`amount_due`,`is_paid`,`installment_number`,`syid`,`type`,`payment_id`,`from_balance`,`to_balance`) values 
(176,'ENR388DEA392F02F','5000','DONE',1,'SY1','DOWNPAYMENT','10','22375','17375'),
(177,'ENR388DEA392F02F','1737.5','NOT DONE',2,'SY1',NULL,NULL,NULL,NULL),
(178,'ENR388DEA392F02F','1737.5','NOT DONE',3,'SY1',NULL,NULL,NULL,NULL),
(179,'ENR388DEA392F02F','1737.5','NOT DONE',4,'SY1',NULL,NULL,NULL,NULL),
(180,'ENR388DEA392F02F','1737.5','NOT DONE',5,'SY1',NULL,NULL,NULL,NULL),
(181,'ENR388DEA392F02F','1737.5','NOT DONE',6,'SY1',NULL,NULL,NULL,NULL),
(182,'ENR388DEA392F02F','1737.5','NOT DONE',7,'SY1',NULL,NULL,NULL,NULL),
(183,'ENR388DEA392F02F','1737.5','NOT DONE',8,'SY1',NULL,NULL,NULL,NULL),
(184,'ENR388DEA392F02F','1737.5','NOT DONE',9,'SY1',NULL,NULL,NULL,NULL),
(185,'ENR388DEA392F02F','1737.5','NOT DONE',10,'SY1',NULL,NULL,NULL,NULL),
(186,'ENR388DEA392F02F','1737.5','NOT DONE',11,'SY1',NULL,NULL,NULL,NULL),
(187,'ENRE9E319BBE7C68','2000','DONE',1,'SY1','DOWNPAYMENT','11','23025','21025'),
(188,'ENRE9E319BBE7C68','2102.5','NOT DONE',2,'SY1',NULL,NULL,NULL,NULL),
(189,'ENRE9E319BBE7C68','2102.5','NOT DONE',3,'SY1',NULL,NULL,NULL,NULL),
(190,'ENRE9E319BBE7C68','2102.5','NOT DONE',4,'SY1',NULL,NULL,NULL,NULL),
(191,'ENRE9E319BBE7C68','2102.5','NOT DONE',5,'SY1',NULL,NULL,NULL,NULL),
(192,'ENRE9E319BBE7C68','2102.5','NOT DONE',6,'SY1',NULL,NULL,NULL,NULL),
(193,'ENRE9E319BBE7C68','2102.5','NOT DONE',7,'SY1',NULL,NULL,NULL,NULL),
(194,'ENRE9E319BBE7C68','2102.5','NOT DONE',8,'SY1',NULL,NULL,NULL,NULL),
(195,'ENRE9E319BBE7C68','2102.5','NOT DONE',9,'SY1',NULL,NULL,NULL,NULL),
(196,'ENRE9E319BBE7C68','2102.5','NOT DONE',10,'SY1',NULL,NULL,NULL,NULL),
(197,'ENRE9E319BBE7C68','2102.5','NOT DONE',11,'SY1',NULL,NULL,NULL,NULL),
(198,'ENR3300858063722','7000','DONE',1,'SY1','DOWNPAYMENT','12','23525','16525'),
(199,'ENR3300858063722','1652.5','NOT DONE',2,'SY1',NULL,NULL,NULL,NULL),
(200,'ENR3300858063722','1652.5','NOT DONE',3,'SY1',NULL,NULL,NULL,NULL),
(201,'ENR3300858063722','1652.5','NOT DONE',4,'SY1',NULL,NULL,NULL,NULL),
(202,'ENR3300858063722','1652.5','NOT DONE',5,'SY1',NULL,NULL,NULL,NULL),
(203,'ENR3300858063722','1652.5','NOT DONE',6,'SY1',NULL,NULL,NULL,NULL),
(204,'ENR3300858063722','1652.5','NOT DONE',7,'SY1',NULL,NULL,NULL,NULL),
(205,'ENR3300858063722','1652.5','NOT DONE',8,'SY1',NULL,NULL,NULL,NULL),
(206,'ENR3300858063722','1652.5','NOT DONE',9,'SY1',NULL,NULL,NULL,NULL),
(207,'ENR3300858063722','1652.5','NOT DONE',10,'SY1',NULL,NULL,NULL,NULL),
(208,'ENR3300858063722','1652.5','NOT DONE',11,'SY1',NULL,NULL,NULL,NULL),
(209,'ENR58D015C0FC346','1200','DONE',1,'SY03FBB1599C61C','DOWNPAYMENT','13','9000','7800'),
(210,'ENR58D015C0FC346','780','NOT DONE',2,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(211,'ENR58D015C0FC346','780','NOT DONE',3,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(212,'ENR58D015C0FC346','780','NOT DONE',4,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(213,'ENR58D015C0FC346','780','NOT DONE',5,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(214,'ENR58D015C0FC346','780','NOT DONE',6,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(215,'ENR58D015C0FC346','780','NOT DONE',7,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(216,'ENR58D015C0FC346','780','NOT DONE',8,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(217,'ENR58D015C0FC346','780','NOT DONE',9,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(218,'ENR58D015C0FC346','780','NOT DONE',10,'SY03FBB1599C61C',NULL,NULL,NULL,NULL),
(219,'ENR58D015C0FC346','780','NOT DONE',11,'SY03FBB1599C61C',NULL,NULL,NULL,NULL);

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `payment_id` int(100) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `payment` */

insert  into `payment`(`payment_id`,`enrollment_id`,`syid`,`amount_paid`,`date_paid`,`method_of_payment`,`or_number`,`remarks`,`paid_by`,`proof_of_payment`,`type`) values 
(10,'ENR388DEA392F02F','SY1','5000','2024-07-31 22:22:00','CASH','OR101',NULL,NULL,NULL,'DOWNPAYMENT'),
(11,'ENRE9E319BBE7C68','SY1','2000','2024-07-31 22:23:00','CASH','OR111',NULL,NULL,NULL,'DOWNPAYMENT'),
(12,'ENR3300858063722','SY1','7000','2024-07-31 22:30:00','CASH','OR202',NULL,NULL,NULL,'DOWNPAYMENT'),
(13,'ENR58D015C0FC346','SY03FBB1599C61C','1200','2024-07-31 23:20:00','CASH','OR303',NULL,NULL,NULL,'DOWNPAYMENT');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `schedule` */

insert  into `schedule`(`schedule_id`,`syid`,`advisory_id`,`subject_id`,`teacher_id`,`from_time`,`to_time`,`minutes`,`monday`,`tuesday`,`wednesday`,`thursday`,`friday`) values 
('SCHEDD4BB2A9E711D9','SY1','ADV1C40A26E5FDFA','SUBJ1801B5A461CAB','TDEC9218A0D6B5','7:30 AM','8:20 AM',NULL,'1','1','1','1','1'),
('SCHED3707B34EAEB63','SY1','ADV166E9C96EBEE0','SUBJ48D57B440739C','TE73F9F3CE2494','8:00 AM','8:45 AM',NULL,'1','1','1','1','1'),
('SCHEDF385955F64373','SY1','ADVD8965A9662B2C','SUBJ1801B5A461CAB','TE73F9F3CE2494','1:00 PM','2:00 PM',NULL,'1','1','1','1','1'),
('SCHED0605F0BBAC48F','SY1','ADV1C40A26E5FDFA','SUBJB07950A78E0CB','T965A22ED6A3A7','8:20 AM','9:20 AM',NULL,'1','1','1','1','1'),
('SCHED9913E993DBAB5','SY1','ADV1C40A26E5FDFA','SUBJ48D57B440739C','TDFDB936CDE413','9:20 AM','10:20 AM',NULL,'1','1','1','1','1'),
('SCHEDB5D04B834591A','SY1','ADV1C40A26E5FDFA','SUBJF070442933CE3','TE73F9F3CE2494','10:20 AM','11:20 AM',NULL,'1','1','1','1','1'),
('SCHED017E461BDDA86','SY03FBB1599C61C','ADVE66196031AA40','SUBJ5670758291A59','TDFDB936CDE413','8:10 AM','9:10 AM',NULL,'1','1','1','1','1'),
('SCHEDBFF46F8D930DC','SY03FBB1599C61C','ADVE66196031AA40','SUBJ5609E8E519845','TE73F9F3CE2494','9:10 AM','10:10 AM',NULL,'1','1','1','1','1'),
('SCHED7E3CB697C3CE7','SY03FBB1599C61C','ADVE66196031AA40','SUBJ0794F636B91EF','TE73F9F3CE2494','10:10 AM','11:10 AM',NULL,'1','1','1','1','1');

/*Table structure for table `school_year` */

DROP TABLE IF EXISTS `school_year`;

CREATE TABLE `school_year` (
  `syid` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `school_year` */

insert  into `school_year`(`syid`,`school_year`,`active_status`) values 
('SY1','2023-2024','INACTIVE'),
('SY03FBB1599C61C','2024-2025','ACTIVE');

/*Table structure for table `section` */

DROP TABLE IF EXISTS `section`;

CREATE TABLE `section` (
  `section_id` varchar(100) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `section` */

insert  into `section`(`section_id`,`section`,`grade_level`,`status`) values 
('SEC668082EFCE2E5','SECTION APPLE',NULL,'ACTIVE'),
('SEC03ACF136A866F','SECTION ORANGE',NULL,'ACTIVE'),
('SECCEDE107BB83B7','SECTION GRAPES',NULL,'ACTIVE'),
('SEC070F73C456932','SECTION ABACA',NULL,'ACTIVE');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `grading_period` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `settings` */

insert  into `settings`(`grading_period`,`active_status`) values 
('first_grading','active'),
('second_grading','inactive'),
('third_grading','inactive'),
('fourth_grading','inactive');

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
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `auto_id` (`auto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `student` */

insert  into `student`(`student_id`,`firstname`,`middlename`,`lastname`,`name_extension`,`region`,`province`,`city_mun`,`barangay`,`address`,`active_sy`,`birthDate`,`birthPlace`,`sex`,`ip_flag`,`religion`,`father_firstname`,`father_middlename`,`father_lastname`,`mother_firstname`,`mother_middlename`,`mother_lastname`,`father_contact`,`father_fb`,`mother_contact`,`mother_fb`,`guardian_firstname`,`guardian_middlename`,`guardian_lastname`,`guardian_phone`,`guardian_occupation`,`last_gradelevel`,`last_schoolname`,`last_schooladdress`,`last_sycompleted`,`last_schoolid`,`father_occupation`,`father_education`,`mother_occupation`,`mother_education`,`auto_id`,`parent_id`,`current_enrollment_id`) values 
('LRN40559200000001','GEANICA','NAMUAG','GARCIA','GEANICA','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 3','SY1','1994-12-12','DAVAO CITY','Male',NULL,'WALA','GEANICA','NAMUAG','GARCIA','asdasd','asdasd','asdasd','(+63) 0991202157','','(+63) 9919191911','asdasasdasd','asdasd','asdasd','asdasd','(+63) 1231231231','asdasdasd',NULL,NULL,NULL,NULL,NULL,'asdasdasd','asdasdasd','asdasd','asdasdasd',1,'USR-e3823d1193c62-240715','ENR388DEA392F02F'),
('LRN40559200000002','BRIAN JADE','','GARCIA','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cagangohan','PUROK KWATRO','SY1','1994-12-12','DAVAO CITY','Male',NULL,'WALA','asdasd','asdasd','asdasd','GEANICA','NAMUAG','GARCIA','(+63) 0991919191','','(+63) 0991202157','','','','','','',NULL,NULL,NULL,NULL,NULL,'ASD','ASD','ASD','ASD',2,'USR-e3823d1193c62-240715','ENR58D015C0FC346'),
('LRN40559200000003','ROSS','','GELLER','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Mabunao','PUROK 3','SY1','2010-09-09','DAVAO CITY','Male',NULL,'NONE','CHANDLER','','BING','MONICA','','BING','(+63) 1919199191','ASDASDASD','(+63) 9191991919','ASDASDASD','','','','','',NULL,NULL,NULL,NULL,NULL,'TRANSPONDSTER','MASTERS','CHEF','MASTERS',3,'USR-e3823d1193c62-240715','ENR3300858063722');

/*Table structure for table `student_grades` */

DROP TABLE IF EXISTS `student_grades`;

CREATE TABLE `student_grades` (
  `grade_id` int(100) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `student_grades` */

insert  into `student_grades`(`grade_id`,`schedule_id`,`student_id`,`advisory_id`,`first_grading`,`second_grading`,`third_grading`,`fourth_grading`,`average`,`remarks`) values 
(34,'SCHED3707B34EAEB63','LRN40559200000001','ADV166E9C96EBEE0',NULL,NULL,NULL,NULL,NULL,NULL),
(35,'SCHED3707B34EAEB63','LRN40559200000002','ADV166E9C96EBEE0',NULL,NULL,NULL,NULL,NULL,NULL),
(36,'SCHEDD4BB2A9E711D9','LRN40559200000003','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
(37,'SCHED0605F0BBAC48F','LRN40559200000003','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
(38,'SCHED9913E993DBAB5','LRN40559200000003','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
(39,'SCHEDB5D04B834591A','LRN40559200000003','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
(40,'SCHED017E461BDDA86','LRN40559200000002','ADVE66196031AA40',NULL,NULL,NULL,NULL,NULL,NULL),
(41,'SCHEDBFF46F8D930DC','LRN40559200000002','ADVE66196031AA40',NULL,NULL,NULL,NULL,NULL,NULL),
(42,'SCHED7E3CB697C3CE7','LRN40559200000002','ADVE66196031AA40',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `subject_id` varchar(100) DEFAULT NULL,
  `subject_code` varchar(100) DEFAULT NULL,
  `subject_title` varchar(100) DEFAULT NULL,
  `subject_description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `subjects` */

insert  into `subjects`(`subject_id`,`subject_code`,`subject_title`,`subject_description`) values 
('SUBJ1801B5A461CAB','MATH101','Intro to Mathematics','Introduction to basic Mathematics'),
('SUBJ48D57B440739C','ENG101','English 101','Intro to Grammar'),
('SUBJ5670758291A59','ARALPAN1','ARALING PANLIPUNAN','HISTORY OF PANABO'),
('SUBJB07950A78E0CB','PE1','PHYSICAL EDUCAITON','PHYSICAL EDUCAITON'),
('SUBJF070442933CE3','SCI1','SCIENCE 1','Biology'),
('SUBJ5609E8E519845','MATH 2','MATH FOR GRADE 2','MATHEMATICS 2'),
('SUBJ0794F636B91EF','FILIPINO 2','FILIPINO FOR GRADE 2','PARA SA GRADE 2');

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
  `teacher_contactNumber` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `teacher` */

insert  into `teacher`(`teacher_id`,`teacher_firstname`,`teacher_middlename`,`teacher_lastname`,`teacher_extension`,`teacher_region`,`teacher_province`,`teacher_citymun`,`teacher_barangay`,`teacher_address`,`college_course`,`post_graduate_course`,`teacher_birthdate`,`teacher_gender`,`teacher_emailaddress`,`teacher_contactNumber`) values 
('TDEC9218A0D6B5','SHELDON','','COOPER','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','J.P. Laurel','PUROK 2','BSIT','MIT','1990-05-05','Male','tradebryant@gmail.com','(+63) 9912021547'),
('TE73F9F3CE2494','LEONARD','','HOFTSTADTER','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 5','BS Education Major in English','Master in Secondary Education','1990-01-01','Male','keylower930@gmail.com','(+63) 9912021547'),
('TDFDB936CDE413','ILLEST','','MORENA','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 3','BS EDUC','','1984-05-05','Female','illestmorena@gmail.com','(+63) 9912021900'),
('T965A22ED6A3A7','HEV','','ABI','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Buenavista','PUROK 3','BS Educ in Math','','1976-09-21','Male','hevabi@gmail.com','(+63) 0991020222');

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
  `profile_image` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`role`,`active_remarks`,`fullname`,`gender`,`profile_image`) values 
('1','admin','$2y$10$/IQUBLgWzYqQ3f.McUCBWeOw/697fyTx3ZehWh6Yds.CP7fp96WPK','admin','active','ADMIN',NULL,NULL),
('LRN40559200000001','LRN40559200000001','$2y$10$8lc89xbqjairQ2O/Zeb1/eP8ZsB3jDND0OryIe1UNRf5gpjOiWMpC','student','active','IRVING, KYRIE',NULL,NULL),
('LRN40559200000002','LRN40559200000002','$2y$10$bGVLdHSDte377JcbjKbUV.HV1anWR.XBtvc37yybhUneUKkDiePO2','student','active','JOKIC, NIKOLA',NULL,NULL),
('LRN40559200000003','LRN40559200000003','$2y$10$j..Ho4WtmcG1MwK47p/tFu9Iv6hL7Mr5pEO4m7Z8neV4oJtU8J5/K','student','active','EDWARDS, ANTHONY',NULL,NULL),
('LRN40559200000004','LRN40559200000004','$2y$10$jpRpIhPYEq6mkOuRNI5CIe3Qb9ZYW2f2OS2PS6tnNpqci9mV4sd4.','student','active','TOWNS, KARL ANTONY',NULL,NULL),
('T965A22ED6A3A7','hevabi@gmail.com','$2y$10$3kpWFMZcw7xh1BiDDXLh4eodEEg6pE/Y64q4SWsjgE4cH2t1FW77W','teacher','active','HEV ABI',NULL,NULL),
('TDEC9218A0D6B5','tradebryant@gmail.com','$2y$10$/IQUBLgWzYqQ3f.McUCBWeOw/697fyTx3ZehWh6Yds.CP7fp96WPK','teacher','active','SHELDON COOPER',NULL,NULL),
('TDFDB936CDE413','illestmorena@gmail.com','$2y$10$Ed7uBalvL71wslBUN3.1/u01lmaO4oN1XU6E/IB3nH1f0qP/kD7Oi','teacher','active','ILLEST MORENA',NULL,NULL),
('TE73F9F3CE2494','keylower930@gmail.com','$2y$10$orztpllakLvLF6TYdCnq.OTO3hjzHo9QAONfauHlWRzJI39BZhYpO','teacher','active','LEONARD HOFTSTADTER',NULL,NULL),
('USR-bf7e8239f391b-240728','cashier@yopmail.com','$2y$10$n4ya6pMOanUCRdfZMrh3quKKCflNAK9sFWPFCEayDb1qX90N/Q692','cashier','active','CASHIER USER','MALE','uploads/users/fullname.png'),
('USR-e3823d1193c62-240715','parent@yopmail.com','$2y$10$hw3UuUB3WeEokxQ8YAjINekzEjQYh4c8vGlYnVPpsAMd6C6yyJ2HK','parent','active','JADE ANADON','MALE','uploads/users/fullname.png');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
