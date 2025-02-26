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
  `teacher_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `advisory` */

insert  into `advisory`(`advisory_id`,`section_id`,`grade_level`,`school_year`,`teacher_id`) values 
('ADV2DD86A4FD6CE0','SEC668082EFCE2E5','Grade 1','SY1','TDEC9218A0D6B5');

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
('ENR541D507E186C1','2024-11-09 14:30:45','SY1','LRN40559200000011','Grade 1','ADV2DD86A4FD6CE0','ENROLLED',NULL,'2002.5');

/*Table structure for table `enrollment_fees` */

DROP TABLE IF EXISTS `enrollment_fees`;

CREATE TABLE `enrollment_fees` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `fee` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4;

/*Data for the table `enrollment_fees` */

insert  into `enrollment_fees`(`fee_id`,`enrollment_id`,`fee`,`type`,`amount`,`status`) values 
(212,'ENR541D507E186C1','REGISTRATION FEE','MAIN','1000','PAYMENT'),
(213,'ENR541D507E186C1','TUITION','MAIN','6000','PAYMENT'),
(214,'ENR541D507E186C1','ELECTRICITY SUBSIDY','MAIN','3800','PAYMENT'),
(215,'ENR541D507E186C1','ID AND INSURANCE','MAIN','380','PAYMENT'),
(216,'ENR541D507E186C1','BOOKS','MAIN','5495','PAYMENT'),
(217,'ENR541D507E186C1','MISCELLANEOUS FEE','MISCELLANEOUS','5350','PAYMENT');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

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
(11,'Grade 2','TUITION FEE','MAIN','6000','ACTIVE'),
(12,'Grade 5','REGISTRATION FEE','MAIN','10000','ACTIVE');

/*Table structure for table `grade_level` */

DROP TABLE IF EXISTS `grade_level`;

CREATE TABLE `grade_level` (
  `grade_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_level` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`grade_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=397 DEFAULT CHARSET=utf8mb4;

/*Data for the table `installment` */

insert  into `installment`(`installment_id`,`enrollment_id`,`amount_due`,`is_paid`,`installment_number`,`syid`,`type`,`payment_id`,`from_balance`,`to_balance`,`credit_balance`) values 
(386,'ENR541D507E186C1','2000','DONE',1,'SY1','DOWNPAYMENT',NULL,NULL,NULL,NULL),
(387,'ENR541D507E186C1','2002.5','NOT DONE',2,'SY1',NULL,NULL,NULL,NULL,NULL),
(388,'ENR541D507E186C1','2002.5','NOT DONE',3,'SY1',NULL,NULL,NULL,NULL,NULL),
(389,'ENR541D507E186C1','2002.5','NOT DONE',4,'SY1',NULL,NULL,NULL,NULL,NULL),
(390,'ENR541D507E186C1','2002.5','NOT DONE',5,'SY1',NULL,NULL,NULL,NULL,NULL),
(391,'ENR541D507E186C1','2002.5','NOT DONE',6,'SY1',NULL,NULL,NULL,NULL,NULL),
(392,'ENR541D507E186C1','2002.5','NOT DONE',7,'SY1',NULL,NULL,NULL,NULL,NULL),
(393,'ENR541D507E186C1','2002.5','NOT DONE',8,'SY1',NULL,NULL,NULL,NULL,NULL),
(394,'ENR541D507E186C1','2002.5','NOT DONE',9,'SY1',NULL,NULL,NULL,NULL,NULL),
(395,'ENR541D507E186C1','2002.5','NOT DONE',10,'SY1',NULL,NULL,NULL,NULL,NULL),
(396,'ENR541D507E186C1','2002.5','NOT DONE',11,'SY1',NULL,NULL,NULL,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `onlinepayment` */

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `onlinepaymentstudents` */

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
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment` */

insert  into `payment`(`payment_id`,`enrollment_id`,`syid`,`amount_paid`,`date_paid`,`method_of_payment`,`or_number`,`remarks`,`paid_by`,`proof_of_payment`,`type`,`installment_id`) values 
(112,'ENR541D507E186C1','SY1','2000','2024-11-09 15:13:00','CASH','OR10001',NULL,NULL,NULL,'DOWNPAYMENT',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment_installment` */

insert  into `payment_installment`(`payment_id`,`installment_id`,`enrollment_id`,`tbl_id`,`from_balance`,`to_balance`,`credit_balance`,`paid`,`amount_due`) values 
('112','386','ENR541D507E186C1',211,'22025','20025',NULL,'2000','2000');

/*Table structure for table `payment_settings` */

DROP TABLE IF EXISTS `payment_settings`;

CREATE TABLE `payment_settings` (
  `installment_number` varchar(100) DEFAULT NULL,
  `dueDate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `payment_settings` */

insert  into `payment_settings`(`installment_number`,`dueDate`) values 
('2','2024-11-01');

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
('SCHED33DD43964D77E','SY1','ADV2DD86A4FD6CE0','SUBJ8F7889199F869','T965A22ED6A3A7','8:00 AM','9:00 AM',NULL,'1','1','1','1','1'),
('SCHED684E55F7824F4','SY1','ADV2DD86A4FD6CE0','SUBJ1848057FCE0CA','TDEC9218A0D6B5','9:00 AM','10:00 AM',NULL,'1','1','1','1','1');

/*Table structure for table `school_year` */

DROP TABLE IF EXISTS `school_year`;

CREATE TABLE `school_year` (
  `syid` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `school_year` */

insert  into `school_year`(`syid`,`school_year`,`active_status`) values 
('SY1','2023-2024','ACTIVE'),
('SY03FBB1599C61C','2024-2025','INACTIVE');

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
('SEC668082EFCE2E5','SECTION APPLE',NULL,'ACTIVE'),
('SEC03ACF136A866F','SECTION ORANGE',NULL,'ACTIVE'),
('SECCEDE107BB83B7','SECTION GRAPES',NULL,'ACTIVE'),
('SEC070F73C456932','SECTION ABACA',NULL,'ACTIVE');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `grading_period` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `student` */

insert  into `student`(`student_id`,`firstname`,`middlename`,`lastname`,`name_extension`,`region`,`province`,`city_mun`,`barangay`,`address`,`active_sy`,`birthDate`,`birthPlace`,`sex`,`ip_flag`,`religion`,`father_firstname`,`father_middlename`,`father_lastname`,`mother_firstname`,`mother_middlename`,`mother_lastname`,`father_contact`,`father_fb`,`mother_contact`,`mother_fb`,`guardian_firstname`,`guardian_middlename`,`guardian_lastname`,`guardian_phone`,`guardian_occupation`,`last_gradelevel`,`last_schoolname`,`last_schooladdress`,`last_sycompleted`,`last_schoolid`,`father_occupation`,`father_education`,`mother_occupation`,`mother_education`,`auto_id`,`parent_id`,`current_enrollment_id`) values 
('LRN40559200000011','BARNEY','WAITFORIT','STINSON','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cagangohan','PUROK 11','SY1','1990-01-01','DAVAO CITY','Male',NULL,'ROMAN CATHOLIC','DONALD','','TRUMP','MELANIA','','TRUMP','(+63) 1231231231','DONALD TRUMP OFFICIAL','(+63) 1231231231','MELANIA TRUMP OFFICIAL','','','','','',NULL,NULL,NULL,NULL,NULL,'BUSINESS MAN','COLLEGE GRADUATE','HOUSE WIFE','COLLEGE GRADUATE',11,'USR-e3823d1193c62-240715','ENR541D507E186C1');

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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;

/*Data for the table `student_grades` */

insert  into `student_grades`(`grade_id`,`subject_id`,`schedule_id`,`student_id`,`advisory_id`,`first_grading`,`second_grading`,`third_grading`,`fourth_grading`,`average`,`remarks`) values 
(65,'SUBJ6BB07B0386C3E','SCHED684E55F7824F4','LRN40559200000011','ADV2DD86A4FD6CE0',NULL,NULL,NULL,NULL,NULL,NULL),
(66,'SUBJE2F7CE242878A','SCHED684E55F7824F4','LRN40559200000011','ADV2DD86A4FD6CE0',NULL,NULL,NULL,NULL,NULL,NULL),
(67,'SUBJ386E77DEC1812','SCHED684E55F7824F4','LRN40559200000011','ADV2DD86A4FD6CE0',NULL,NULL,NULL,NULL,NULL,NULL),
(68,'SUBJDA96037EEFC9F','SCHED684E55F7824F4','LRN40559200000011','ADV2DD86A4FD6CE0',NULL,NULL,NULL,NULL,NULL,NULL),
(69,'SUBJ8F7889199F869','SCHED33DD43964D77E','LRN40559200000011','ADV2DD86A4FD6CE0','99',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `subject_main` */

DROP TABLE IF EXISTS `subject_main`;

CREATE TABLE `subject_main` (
  `subject_head_id` int(100) NOT NULL AUTO_INCREMENT,
  `subject_head_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`subject_head_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `subject_main` */

insert  into `subject_main`(`subject_head_id`,`subject_head_name`) values 
(1,'Mother Tongue'),
(2,'Filipino'),
(3,'English'),
(4,'Mathematics'),
(5,'Science'),
(6,'Araling Panlipunan'),
(7,'EPP / TLE'),
(8,'MAPEH'),
(9,'Edukasyon sa Pagpapakatao');

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
('SUBJ8F7889199F869','MATH 101','MATH FOR GRADE 1','INTRO TO MATHEMATICS','4','PARENT',NULL),
('SUBJ1848057FCE0CA','MAPEH 1','INTRO TO MAPEH','SAYAW SAYAW UG ARTE ARTE','8','PARENT',NULL),
('SUBJ6BB07B0386C3E','','Music','','','CHILD','SUBJ1848057FCE0CA'),
('SUBJE2F7CE242878A','','Arts','','','CHILD','SUBJ1848057FCE0CA'),
('SUBJ386E77DEC1812','','Physical Education','','','CHILD','SUBJ1848057FCE0CA'),
('SUBJDA96037EEFC9F','','Health','','','CHILD','SUBJ1848057FCE0CA');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `profile_image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
