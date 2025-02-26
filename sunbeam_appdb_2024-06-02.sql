# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.28-MariaDB)
# Database: sunbeam_appdb
# Generation Time: 2024-06-02 11:33:36 AM +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table advisory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `advisory`;

CREATE TABLE `advisory` (
  `advisory_id` varchar(100) DEFAULT NULL,
  `section_id` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `teacher_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `advisory` WRITE;
/*!40000 ALTER TABLE `advisory` DISABLE KEYS */;

INSERT INTO `advisory` (`advisory_id`, `section_id`, `grade_level`, `school_year`, `teacher_id`)
VALUES
	('ADV1C40A26E5FDFA','SEC668082EFCE2E5','Grade 1','SY1','TDEC9218A0D6B5'),
	('ADV166E9C96EBEE0','SECCEDE107BB83B7','Grade 1','SY1','TE73F9F3CE2494'),
	('ADVD8965A9662B2C','SEC070F73C456932','Grade 5','SY1','TDEC9218A0D6B5');

/*!40000 ALTER TABLE `advisory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table enrollment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `enrollment`;

CREATE TABLE `enrollment` (
  `enrollment_id` varchar(100) DEFAULT NULL,
  `dateEnrolled` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `advisory_id` varchar(100) DEFAULT NULL,
  `balance` varchar(100) DEFAULT NULL,
  `per_month` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `enrollment` WRITE;
/*!40000 ALTER TABLE `enrollment` DISABLE KEYS */;

INSERT INTO `enrollment` (`enrollment_id`, `dateEnrolled`, `syid`, `student_id`, `grade_level`, `advisory_id`, `balance`, `per_month`)
VALUES
	('ENRFADB039F2EF44','2024-06-02 15:35:06','SY1','LRN40559200000001','Grade 5','ADVD8965A9662B2C','20900','2090'),
	('ENRD1574E4EAA12D','2024-06-02 18:23:16','SY1','LRN40559200000002','Grade 5','ADVD8965A9662B2C','10900','1090'),
	('ENRB3ECE9543C226','2024-06-02 19:10:19','SY1','LRN40559200000003','Grade 1','ADV1C40A26E5FDFA','23300','2330'),
	('ENR9962C37016989','2024-06-02 19:32:21','SY1','LRN40559200000004','Grade 1','ADV1C40A26E5FDFA','17500','1750');

/*!40000 ALTER TABLE `enrollment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table enrollment_fees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `enrollment_fees`;

CREATE TABLE `enrollment_fees` (
  `enrollment_id` varchar(100) DEFAULT NULL,
  `fee` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `fee_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `enrollment_fees` WRITE;
/*!40000 ALTER TABLE `enrollment_fees` DISABLE KEYS */;

INSERT INTO `enrollment_fees` (`enrollment_id`, `fee`, `type`, `amount`, `fee_id`)
VALUES
	('ENRFADB039F2EF44','ELECTRICITY FEE',NULL,'1500',NULL),
	('ENRFADB039F2EF44','REGISTRATION FEE',NULL,'9000',NULL),
	('ENRFADB039F2EF44','BOOKS FEE',NULL,'6000',NULL),
	('ENRFADB039F2EF44','TUITION FEE',NULL,'7000',NULL),
	('ENRFADB039F2EF44','ID / INSUR. FEE',NULL,'400',NULL),
	('ENRFADB039F2EF44','MISCELLANEOUS FEE',NULL,'5000',NULL),
	('ENRFADB039F2EF44','',NULL,'0',NULL),
	('ENRD1574E4EAA12D','ELECTRICITY FEE',NULL,'3000',NULL),
	('ENRD1574E4EAA12D','REGISTRATION FEE',NULL,'6000',NULL),
	('ENRD1574E4EAA12D','BOOKS FEE',NULL,'1500',NULL),
	('ENRD1574E4EAA12D','TUITION FEE',NULL,'2000',NULL),
	('ENRD1574E4EAA12D','ID / INSUR. FEE',NULL,'400',NULL),
	('ENRD1574E4EAA12D','MISCELLANEOUS FEE',NULL,'8000',NULL),
	('ENRD1574E4EAA12D','',NULL,'0',NULL),
	('ENRB3ECE9543C226','ELECTRICITY FEE',NULL,'2000',NULL),
	('ENRB3ECE9543C226','REGISTRATION FEE',NULL,'8000',NULL),
	('ENRB3ECE9543C226','BOOKS FEE',NULL,'7000',NULL),
	('ENRB3ECE9543C226','TUITION FEE',NULL,'3450',NULL),
	('ENRB3ECE9543C226','ID / INSUR. FEE',NULL,'400',NULL),
	('ENRB3ECE9543C226','MISCELLANEOUS FEE',NULL,'8900',NULL),
	('ENRB3ECE9543C226','ID SLING',NULL,'50',NULL),
	('ENR9962C37016989','ELECTRICITY FEE',NULL,'1600',NULL),
	('ENR9962C37016989','REGISTRATION FEE',NULL,'9000',NULL),
	('ENR9962C37016989','BOOKS FEE',NULL,'3500',NULL),
	('ENR9962C37016989','TUITION FEE',NULL,'10000',NULL),
	('ENR9962C37016989','ID / INSUR. FEE',NULL,'400',NULL),
	('ENR9962C37016989','MISCELLANEOUS FEE',NULL,'13000',NULL),
	('ENR9962C37016989','',NULL,'0',NULL);

/*!40000 ALTER TABLE `enrollment_fees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table installment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `installment`;

CREATE TABLE `installment` (
  `installment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `amount_due` varchar(100) DEFAULT '',
  `is_paid` int(1) DEFAULT NULL,
  `installment_number` int(11) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`installment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `installment` WRITE;
/*!40000 ALTER TABLE `installment` DISABLE KEYS */;

INSERT INTO `installment` (`installment_id`, `enrollment_id`, `amount_due`, `is_paid`, `installment_number`, `syid`)
VALUES
	(31,'ENRFADB039F2EF44','2090',0,1,'SY1'),
	(32,'ENRFADB039F2EF44','2090',0,2,'SY1'),
	(33,'ENRFADB039F2EF44','2090',0,3,'SY1'),
	(34,'ENRFADB039F2EF44','2090',0,4,'SY1'),
	(35,'ENRFADB039F2EF44','2090',0,5,'SY1'),
	(36,'ENRFADB039F2EF44','2090',0,6,'SY1'),
	(37,'ENRFADB039F2EF44','2090',0,7,'SY1'),
	(38,'ENRFADB039F2EF44','2090',0,8,'SY1'),
	(39,'ENRFADB039F2EF44','2090',0,9,'SY1'),
	(40,'ENRFADB039F2EF44','2090',0,10,'SY1'),
	(41,'ENRD1574E4EAA12D','1090',0,1,'SY1'),
	(42,'ENRD1574E4EAA12D','1090',0,2,'SY1'),
	(43,'ENRD1574E4EAA12D','1090',0,3,'SY1'),
	(44,'ENRD1574E4EAA12D','1090',0,4,'SY1'),
	(45,'ENRD1574E4EAA12D','1090',0,5,'SY1'),
	(46,'ENRD1574E4EAA12D','1090',0,6,'SY1'),
	(47,'ENRD1574E4EAA12D','1090',0,7,'SY1'),
	(48,'ENRD1574E4EAA12D','1090',0,8,'SY1'),
	(49,'ENRD1574E4EAA12D','1090',0,9,'SY1'),
	(50,'ENRD1574E4EAA12D','1090',0,10,'SY1'),
	(51,'ENRB3ECE9543C226','2330',0,1,'SY1'),
	(52,'ENRB3ECE9543C226','2330',0,2,'SY1'),
	(53,'ENRB3ECE9543C226','2330',0,3,'SY1'),
	(54,'ENRB3ECE9543C226','2330',0,4,'SY1'),
	(55,'ENRB3ECE9543C226','2330',0,5,'SY1'),
	(56,'ENRB3ECE9543C226','2330',0,6,'SY1'),
	(57,'ENRB3ECE9543C226','2330',0,7,'SY1'),
	(58,'ENRB3ECE9543C226','2330',0,8,'SY1'),
	(59,'ENRB3ECE9543C226','2330',0,9,'SY1'),
	(60,'ENRB3ECE9543C226','2330',0,10,'SY1'),
	(61,'ENR9962C37016989','1750',0,1,'SY1'),
	(62,'ENR9962C37016989','1750',0,2,'SY1'),
	(63,'ENR9962C37016989','1750',0,3,'SY1'),
	(64,'ENR9962C37016989','1750',0,4,'SY1'),
	(65,'ENR9962C37016989','1750',0,5,'SY1'),
	(66,'ENR9962C37016989','1750',0,6,'SY1'),
	(67,'ENR9962C37016989','1750',0,7,'SY1'),
	(68,'ENR9962C37016989','1750',0,8,'SY1'),
	(69,'ENR9962C37016989','1750',0,9,'SY1'),
	(70,'ENR9962C37016989','1750',0,10,'SY1');

/*!40000 ALTER TABLE `installment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `payment_id` varchar(100) DEFAULT NULL,
  `enrollment_id` varchar(100) DEFAULT NULL,
  `syid` varchar(100) DEFAULT NULL,
  `amount_paid` varchar(100) DEFAULT NULL,
  `date_paid` varchar(100) DEFAULT NULL,
  `method_of_payment` varchar(100) DEFAULT NULL,
  `or_number` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `paid_by` varchar(100) DEFAULT NULL,
  `proof_of_payment` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;

INSERT INTO `payment` (`payment_id`, `enrollment_id`, `syid`, `amount_paid`, `date_paid`, `method_of_payment`, `or_number`, `remarks`, `paid_by`, `proof_of_payment`)
VALUES
	('PAY6753D28D1E76D','ENR454AB6F820F7E','SY1','3400','2024-06-01 13:42:21','CASH','OR1990','DOWNPAYMENT','MAMA SHOUTOUT TV',NULL),
	('PAY534119025F1C8','ENR50727948EBAC3','SY1','3400','2024-06-01 14:08:11','CASH','OR1990','DOWNPAYMENT','MAMA SHOUTOUT TV',NULL),
	('PAY57F0408BD25B2','ENR4F4991C4B6C41','SY1','9000','2024-06-02 15:07:25','CASH','OR92922','DOWNPAYMENT','FATHER',NULL),
	('PAYA5B6E42C9D711','ENRFADB039F2EF44','SY1','8000','2024-06-02 15:35:06','CASH','OR2022','DOWNPAYMENT','FATHER',NULL),
	('PAY26AC778E9E75A','ENRD1574E4EAA12D','SY1','10000','2024-06-02 18:23:16','CASH','OR90999','DOWNPAYMENT','MOTHER',NULL),
	('PAYFA69181FEC53F','ENRB3ECE9543C226','SY1','6500','2024-06-02 19:10:19','CASH','OR 9000','DOWNPAYMENT','MJ',NULL),
	('PAY22E7320DCD965','ENR9962C37016989','SY1','20000','2024-06-02 19:32:21','CASH','OR8000','DOWNPAYMENT','GUARDIAN',NULL);

/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table schedule
# ------------------------------------------------------------

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

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;

INSERT INTO `schedule` (`schedule_id`, `syid`, `advisory_id`, `subject_id`, `teacher_id`, `from_time`, `to_time`, `minutes`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`)
VALUES
	('SCHEDD4BB2A9E711D9','SY1','ADV1C40A26E5FDFA','SUBJ1801B5A461CAB','TDEC9218A0D6B5','7:30 AM','8:20 AM',NULL,'1','1','1','1','1'),
	('SCHED3707B34EAEB63','SY1','ADV166E9C96EBEE0','SUBJ48D57B440739C','TE73F9F3CE2494','8:00 AM','8:45 AM',NULL,'1','1','1','1','1'),
	('SCHEDF385955F64373','SY1','ADVD8965A9662B2C','SUBJ1801B5A461CAB','TE73F9F3CE2494','1:00 PM','2:00 PM',NULL,'1','1','1','1','1'),
	('SCHED0605F0BBAC48F','SY1','ADV1C40A26E5FDFA','SUBJB07950A78E0CB','T965A22ED6A3A7','8:20 AM','9:20 AM',NULL,'1','1','1','1','1'),
	('SCHED9913E993DBAB5','SY1','ADV1C40A26E5FDFA','SUBJ48D57B440739C','TDFDB936CDE413','9:20 AM','10:20 AM',NULL,'1','1','1','1','1'),
	('SCHEDB5D04B834591A','SY1','ADV1C40A26E5FDFA','SUBJF070442933CE3','TE73F9F3CE2494','10:20 AM','11:20 AM',NULL,'1','1','1','1','1');

/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table school_year
# ------------------------------------------------------------

DROP TABLE IF EXISTS `school_year`;

CREATE TABLE `school_year` (
  `syid` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `school_year` WRITE;
/*!40000 ALTER TABLE `school_year` DISABLE KEYS */;

INSERT INTO `school_year` (`syid`, `school_year`, `active_status`)
VALUES
	('SY1','2023-2024','ACTIVE'),
	('SY03FBB1599C61C','2024-2025','INACTIVE');

/*!40000 ALTER TABLE `school_year` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table section
# ------------------------------------------------------------

DROP TABLE IF EXISTS `section`;

CREATE TABLE `section` (
  `section_id` varchar(100) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `grade_level` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;

INSERT INTO `section` (`section_id`, `section`, `grade_level`, `status`)
VALUES
	('SEC668082EFCE2E5','SECTION APPLE',NULL,'ACTIVE'),
	('SEC03ACF136A866F','SECTION ORANGE',NULL,'ACTIVE'),
	('SECCEDE107BB83B7','SECTION GRAPES',NULL,'ACTIVE'),
	('SEC070F73C456932','SECTION ABACA',NULL,'ACTIVE');

/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `grading_period` varchar(100) DEFAULT NULL,
  `active_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`grading_period`, `active_status`)
VALUES
	('first_grading','active'),
	('second_grading','inactive'),
	('third_grading','inactive'),
	('fourth_grading','inactive');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student
# ------------------------------------------------------------

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
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `auto_id` (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;

INSERT INTO `student` (`student_id`, `firstname`, `middlename`, `lastname`, `name_extension`, `region`, `province`, `city_mun`, `barangay`, `address`, `active_sy`, `birthDate`, `birthPlace`, `sex`, `ip_flag`, `religion`, `father_firstname`, `father_middlename`, `father_lastname`, `mother_firstname`, `mother_middlename`, `mother_lastname`, `father_contact`, `father_fb`, `mother_contact`, `mother_fb`, `guardian_firstname`, `guardian_middlename`, `guardian_lastname`, `guardian_phone`, `guardian_occupation`, `last_gradelevel`, `last_schoolname`, `last_schooladdress`, `last_sycompleted`, `last_schoolid`, `father_occupation`, `father_education`, `mother_occupation`, `mother_education`, `auto_id`)
VALUES
	('LRN40559200000001','KYRIE','','IRVING','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Quezon','CABILI','SY1','2015-12-12','DAVAO CITY','Male',NULL,'ROMAN CATHOLIC','LEBRON','','JAMES','MAMA','STA','TERESA','09912021990','KALYE IRVING','0991020202','MOTHER TERESA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'BUSINESSMAN','COLLEGE GRADUATE','HOUSEWIFE','ELEMENTARY GRADUATE',1),
	('LRN40559200000002','NIKOLA','','JOKIC','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Gredu (Pob.)','SAVE FOR LESS','SY1','2014-07-01','CARMEN DDN','Male',NULL,'ROMAN CATHOLIC','DENVER','B','NUGGETS','SALOME','','SALVI','099120219021','DENVERNUGGETS','09192929211','MAMA TV',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'BARANGAY CHAIRMAN','COLLEGE GRADUATE','GOVERNMENT EMPLOYEE','COLLEGE GRADUATE',2),
	('LRN40559200000003','ANTHONY','','EDWARDS','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Kiotoy','PUROK 4','SY1','2014-09-10','DAVAO CITY','Male',NULL,'ROMAN CATHOLIC','MICHAEL','B','JORDAN','STEPHEN','','KYURI','09918181818','MJORDAN NIKE','0998112737123','STEPH',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CHIEF EXECUTIVE OFFICER','HIGH SCHOOL GRADUATE','HOUSEWIFE','COLLEGE GRADUATE',3),
	('LRN40559200000004','KARL ANTONY','','TOWNS','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Gredu (Pob.)','LAGUNA STORE','SY1','2015-08-08','CARMEN DDN','Male',NULL,'ROMAN CATHOLIC','LUCA','','DONCIC','KAYRI','','MADONNA','(+63) 9912021900','LUKA LUKA','(+63) 9912029192','KAIRI','DEREK','','LIVELY','(+63) 9910202022','NONE',NULL,NULL,NULL,NULL,NULL,'BARANGAY POLICE','HIGH SCHOOL GRADUATE','BUSINESS WOMAN','HIGH SCHOOL GRADUATE',4);

/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student_grades
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `student_grades` WRITE;
/*!40000 ALTER TABLE `student_grades` DISABLE KEYS */;

INSERT INTO `student_grades` (`grade_id`, `schedule_id`, `student_id`, `advisory_id`, `first_grading`, `second_grading`, `third_grading`, `fourth_grading`, `average`, `remarks`)
VALUES
	(22,'SCHEDF385955F64373','LRN40559200000001','ADVD8965A9662B2C','89',NULL,NULL,NULL,NULL,NULL),
	(23,'SCHEDF385955F64373','LRN40559200000002','ADVD8965A9662B2C',NULL,NULL,NULL,NULL,NULL,NULL),
	(24,'SCHEDD4BB2A9E711D9','LRN40559200000003','ADV1C40A26E5FDFA','92',NULL,NULL,NULL,NULL,NULL),
	(25,'SCHED0605F0BBAC48F','LRN40559200000003','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
	(26,'SCHED9913E993DBAB5','LRN40559200000003','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
	(27,'SCHEDB5D04B834591A','LRN40559200000003','ADV1C40A26E5FDFA','88',NULL,NULL,NULL,NULL,NULL),
	(28,'SCHEDD4BB2A9E711D9','LRN40559200000004','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
	(29,'SCHED0605F0BBAC48F','LRN40559200000004','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
	(30,'SCHED9913E993DBAB5','LRN40559200000004','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL),
	(31,'SCHEDB5D04B834591A','LRN40559200000004','ADV1C40A26E5FDFA',NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `student_grades` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `subject_id` varchar(100) DEFAULT NULL,
  `subject_code` varchar(100) DEFAULT NULL,
  `subject_title` varchar(100) DEFAULT NULL,
  `subject_description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_title`, `subject_description`)
VALUES
	('SUBJ1801B5A461CAB','MATH101','Intro to Mathematics','Introduction to basic Mathematics'),
	('SUBJ48D57B440739C','ENG101','English 101','Intro to Grammar'),
	('SUBJ5670758291A59','ARALPAN1','ARALING PANLIPUNAN','HISTORY OF PANABO'),
	('SUBJB07950A78E0CB','PE1','PHYSICAL EDUCAITON','PHYSICAL EDUCAITON'),
	('SUBJF070442933CE3','SCI1','SCIENCE 1','Biology');

/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teacher
# ------------------------------------------------------------

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

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;

INSERT INTO `teacher` (`teacher_id`, `teacher_firstname`, `teacher_middlename`, `teacher_lastname`, `teacher_extension`, `teacher_region`, `teacher_province`, `teacher_citymun`, `teacher_barangay`, `teacher_address`, `college_course`, `post_graduate_course`, `teacher_birthdate`, `teacher_gender`, `teacher_emailaddress`, `teacher_contactNumber`)
VALUES
	('TDEC9218A0D6B5','SHELDON','','COOPER','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','J.P. Laurel','PUROK 2','BSIT','MIT','1990-05-05','Male','tradebryant@gmail.com','(+63) 9912021547'),
	('TE73F9F3CE2494','LEONARD','','HOFTSTADTER','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 5','BS Education Major in English','Master in Secondary Education','1990-01-01','Male','keylower930@gmail.com','(+63) 9912021547'),
	('TDFDB936CDE413','ILLEST','','MORENA','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Cacao','PUROK 3','BS EDUC','','1984-05-05','Female','illestmorena@gmail.com','(+63) 9912021900'),
	('T965A22ED6A3A7','HEV','','ABI','','REGION XI (DAVAO REGION)','DAVAO DEL NORTE','CITY OF PANABO','Buenavista','PUROK 3','BS Educ in Math','','1976-09-21','Male','hevabi@gmail.com','(+63) 0991020222');

/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `active_remarks` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `active_remarks`, `fullname`)
VALUES
	('1','admin','$2y$10$/IQUBLgWzYqQ3f.McUCBWeOw/697fyTx3ZehWh6Yds.CP7fp96WPK','admin','active','ADMIN'),
	('LRN40559200000001','LRN40559200000001','$2y$10$8lc89xbqjairQ2O/Zeb1/eP8ZsB3jDND0OryIe1UNRf5gpjOiWMpC','student','active','IRVING, KYRIE'),
	('LRN40559200000002','LRN40559200000002','$2y$10$bGVLdHSDte377JcbjKbUV.HV1anWR.XBtvc37yybhUneUKkDiePO2','student','active','JOKIC, NIKOLA'),
	('LRN40559200000003','LRN40559200000003','$2y$10$j..Ho4WtmcG1MwK47p/tFu9Iv6hL7Mr5pEO4m7Z8neV4oJtU8J5/K','student','active','EDWARDS, ANTHONY'),
	('LRN40559200000004','LRN40559200000004','$2y$10$jpRpIhPYEq6mkOuRNI5CIe3Qb9ZYW2f2OS2PS6tnNpqci9mV4sd4.','student','active','TOWNS, KARL ANTONY'),
	('T965A22ED6A3A7','hevabi@gmail.com','$2y$10$3kpWFMZcw7xh1BiDDXLh4eodEEg6pE/Y64q4SWsjgE4cH2t1FW77W','teacher','active','HEV ABI'),
	('TDEC9218A0D6B5','tradebryant@gmail.com','$2y$10$/IQUBLgWzYqQ3f.McUCBWeOw/697fyTx3ZehWh6Yds.CP7fp96WPK','teacher','active','SHELDON COOPER'),
	('TDFDB936CDE413','illestmorena@gmail.com','$2y$10$Ed7uBalvL71wslBUN3.1/u01lmaO4oN1XU6E/IB3nH1f0qP/kD7Oi','teacher','active','ILLEST MORENA'),
	('TE73F9F3CE2494','keylower930@gmail.com','$2y$10$orztpllakLvLF6TYdCnq.OTO3hjzHo9QAONfauHlWRzJI39BZhYpO','teacher','active','LEONARD HOFTSTADTER');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
