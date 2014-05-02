CREATE DATABASE  IF NOT EXISTS`shady_grove` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `shady_grove`;
-- MySQL dump 10.13  Distrib 5.1.40, for Win32 (ia32)
--
-- Host: 127.0.0.1    Database: shady_grove
-- ------------------------------------------------------
-- Server version	5.1.30-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `a_request`
--

DROP TABLE IF EXISTS `a_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `a_request` (
  `a_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `j_title` varchar(100) NOT NULL,
  `j_volume` varchar(45) NOT NULL,
  `j_issue` varchar(45) DEFAULT NULL,
  `j_month` varchar(15) DEFAULT NULL,
  `j_year` year(4) NOT NULL,
  `a_title` varchar(150) NOT NULL,
  `a_author` varchar(45) NOT NULL,
  `a_issn` varchar(45) DEFAULT NULL,
  `a_incl_pages` varchar(50) NOT NULL,
  `a_notes` varchar(1000) DEFAULT NULL,
  `a_supply_method` varchar(45) DEFAULT NULL,
  `a_loan_period` varchar(45) DEFAULT NULL,
  `c_id` mediumint(8) unsigned NOT NULL,
  `a_barcode` varchar(45) DEFAULT NULL,
  `a_ordered_date` date DEFAULT NULL,
  `a_recalled_date` date DEFAULT NULL,
  `a_date_entered` date DEFAULT NULL,
  `a_date_deleted` date DEFAULT NULL,
  `a_prof_copy` char(1) DEFAULT NULL,
  `a_syllabi` char(1) DEFAULT NULL,
  `a_comments` varchar(1000) DEFAULT NULL,
  `p_email` varchar(50) NOT NULL,
  `a_req_date` date DEFAULT NULL,
  PRIMARY KEY (`a_id`),
  KEY `c_id` (`c_id`),
  KEY `p_email` (`p_email`),
  CONSTRAINT `a_request_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`),
  CONSTRAINT `a_request_ibfk_3` FOREIGN KEY (`p_email`) REFERENCES `professor` (`p_email`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=894879 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `a_request`
--

LOCK TABLES `a_request` WRITE;
/*!40000 ALTER TABLE `a_request` DISABLE KEYS */;
INSERT INTO `a_request` VALUES (260180,'Journal 2','Volume 2','Issue 2','Month 2',2009,'Article 2','Author 2','ISSN 2','Pages 2','Notes 2','Pull Off Shelf','',18,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sid25786@gmail.com','2010-04-08'),(318520,'Journal 1','Volume 1','Issue 1','Month 1',2010,'Article 1','Author 1','ISSN 1','Pages 1','Notes 1','Pull Off Shelf','2 hrs',17,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sid25786@gmail.com','2010-04-08'),(473767,'Its1','Only1','issue1','mon1',2010,'which1','is1','problems1','causing1','Dont know why1','Will Upload a File','2 hrs',34,'barcode1','2001-10-01','2001-09-19','2001-08-18','2001-07-17','Y','N','Commented1','Works1','2010-04-08'),(758858,'Journal 2','Volume 2','Issue 2','Month 2',2010,'Article 2','Author 2','ISSN 2','Pages 2','Notes 2','Pull Off Shelf','1 day',18,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'asd@asd.com','2010-04-08'),(894878,'Journalism','vol','issue','Jan',2019,'Titles','Author Is Me','102918','Pages I dont know','No notes to make','Will Bring to Library','',20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Email','2010-04-08');
/*!40000 ALTER TABLE `a_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `b_request`
--

DROP TABLE IF EXISTS `b_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `b_request` (
  `b_id` int(10) unsigned NOT NULL,
  `b_title` varchar(100) NOT NULL,
  `b_author` varchar(100) NOT NULL,
  `b_publisher` varchar(100) DEFAULT NULL,
  `b_place_of_pub` varchar(100) DEFAULT NULL,
  `b_date_of_pub` varchar(20) NOT NULL,
  `b_book_edition` varchar(20) DEFAULT NULL,
  `b_isbn` varchar(45) DEFAULT NULL,
  `b_supply_method` varchar(45) DEFAULT NULL,
  `b_notes` varchar(1000) DEFAULT NULL,
  `b_call_number` varchar(50) DEFAULT NULL,
  `b_loan_period` varchar(20) DEFAULT NULL,
  `b_barcode` varchar(45) DEFAULT NULL,
  `b_ordered_date` date DEFAULT NULL,
  `b_recalled_date` date DEFAULT NULL,
  `b_date_entered` date DEFAULT NULL,
  `b_date_deleted` date DEFAULT NULL,
  `b_prof_copy` char(1) DEFAULT NULL,
  `b_syllabi` char(1) DEFAULT NULL,
  `b_comments` varchar(1000) DEFAULT NULL,
  `p_email` varchar(50) NOT NULL,
  `c_id` mediumint(8) unsigned NOT NULL,
  `b_req_date` date DEFAULT NULL,
  PRIMARY KEY (`b_id`),
  UNIQUE KEY `b_id_UNIQUE` (`b_id`),
  UNIQUE KEY `b_barcode_UNIQUE` (`b_barcode`),
  KEY `c_id` (`c_id`),
  KEY `p_email` (`p_email`),
  CONSTRAINT `b_request_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`),
  CONSTRAINT `b_request_ibfk_3` FOREIGN KEY (`p_email`) REFERENCES `professor` (`p_email`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `b_request`
--

LOCK TABLES `b_request` WRITE;
/*!40000 ALTER TABLE `b_request` DISABLE KEYS */;
INSERT INTO `b_request` VALUES (314619,'A Really REally reaally loooonnnnggg boook title','Author','Publisher','Place','Date','edition','7608184761-38','Will Bring to Library','Note','1010','2 hrs','184739174929','2020-10-25','2021-10-20','2031-10-20','2041-10-20','N','Y','Comments Here','sid25786@gmail1.com',29,'2010-04-08'),(387315,'this','time','the','book','request','with','around','Pull Off Shelf','','cmon','','','0000-00-00','0000-00-00','0000-00-00','0000-00-00','','','','asd@asd.com',23,'2010-04-08'),(442629,'this','time','the','book','request','with','around','Pull Off Shelf','','cmon','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'See@asd.\\\\\\com',23,'2010-04-08'),(651058,'Be','Working','Reason','','Works','Some','For','Will Bring to Library','','NOW','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Doesn\\\\\\\\\\\\\\\'t',21,'2010-04-08'),(749786,'hhsdgsdg','13tgsdhfdh','','','weh2','','','Pull Off Shelf','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sid25786@gmail1.com',31,'2010-04-13'),(924590,'this','time','the','book','request','with','around','Pull Off Shelf','','cmon','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'See',23,'2010-04-08'),(935220,'this','time','the','book','request','with','around','Pull Off Shelf','','cmon','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'See@asd.\\\\\\\\\\\\com',23,'2010-04-08');
/*!40000 ALTER TABLE `b_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c_request`
--

DROP TABLE IF EXISTS `c_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `c_request` (
  `bc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bc_author` varchar(100) NOT NULL,
  `bc_publisher` varchar(100) DEFAULT NULL,
  `bc_place_of_pub` varchar(100) DEFAULT NULL,
  `bc_edition` varchar(20) DEFAULT NULL,
  `bc_isbn` varchar(45) DEFAULT NULL,
  `bc_incl_pages` varchar(50) NOT NULL,
  `bc_date_of_pub` varchar(20) NOT NULL,
  `bc_notes` varchar(1000) DEFAULT NULL,
  `bc_supply_method` varchar(45) DEFAULT NULL,
  `bc_loan_period` varchar(20) DEFAULT NULL,
  `bc_b_title` varchar(100) NOT NULL,
  `bc_barcode` varchar(45) DEFAULT NULL,
  `bc_c_title` varchar(150) NOT NULL,
  `bc_ordered_date` date DEFAULT NULL,
  `bc_recalled_date` date DEFAULT NULL,
  `bc_date_entered` date DEFAULT NULL,
  `bc_date_deleted` date DEFAULT NULL,
  `bc_prof_copy` char(1) DEFAULT NULL,
  `bc_syllabi` char(1) DEFAULT NULL,
  `bc_comments` varchar(1000) DEFAULT NULL,
  `c_id` mediumint(8) unsigned NOT NULL,
  `p_email` varchar(50) NOT NULL,
  `bc_call_number` varchar(50) DEFAULT NULL,
  `bc_req_date` date DEFAULT NULL,
  PRIMARY KEY (`bc_id`),
  UNIQUE KEY `c_id_UNIQUE` (`bc_id`),
  KEY `bc_b_title` (`bc_b_title`),
  KEY `bc_c_title` (`bc_c_title`),
  KEY `c_id` (`c_id`),
  KEY `p_email` (`p_email`),
  CONSTRAINT `c_request_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `course` (`c_id`),
  CONSTRAINT `c_request_ibfk_3` FOREIGN KEY (`p_email`) REFERENCES `professor` (`p_email`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=528100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c_request`
--

LOCK TABLES `c_request` WRITE;
/*!40000 ALTER TABLE `c_request` DISABLE KEYS */;
INSERT INTO `c_request` VALUES (234147,'author1','apgmkn1','publication1','edition1','12341231','3-5,8-201','date1','Notes1','Will Bring to Library','2 hrs','title1','10291021','chpt1','2011-11-21','2011-10-20','2011-09-19','2011-08-18','N','Y','Comments here 1',32,'asd@asd.umd.edu','call 111','2010-06-08'),(304410,'with','in','various','junk','inserted','code','text boxes','','Pull Off Shelf','','form',NULL,'some j',NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,'try \\\\\\\\\\\\\\\\\\\\\\\\','','2010-04-08'),(528099,'author1','apgmkn1','12312t','edition1','1234123123','3-5,8-20','612435','I have no notest to make Notes','attachment','','title1',NULL,'ctitle1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,19,'asd@asd.com','g1','2010-04-08');
/*!40000 ALTER TABLE `c_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `c_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `course_no` varchar(20) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `semester_year` year(4) NOT NULL,
  `course_title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (17,'No1','Summer II',2012,'Course 1'),(18,'No2','Summer II',2011,'Course 2'),(19,'1234','Summer I',2010,'asd'),(20,'101','Summer II',2014,'Course'),(21,'To','Spring',2011,'Seem'),(22,'Fine','Summer I',2010,'Just'),(23,'happens','Summer II',2017,'This is the new title'),(24,'this','Summer I',2010,'validating'),(26,'1010','Spring',2020,'Name'),(27,'asd','Fall',2017,'What'),(28,'Number 1','Spring',2019,'Title 1'),(29,'happens','Spring',2012,'This is the new title'),(30,'8269','Summer I',2010,''),(31,'a124','Summer I',2010,'asd'),(32,'12341','Summer II',2011,'asd1'),(33,'Fine1','Summer II',2011,'Just1'),(34,'','Summer II',2011,'Just1'),(35,'asd','Summer II',2011,'Just1');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professor`
--

DROP TABLE IF EXISTS `professor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professor` (
  `p_email` varchar(50) NOT NULL,
  `p_last_name` varchar(50) NOT NULL,
  `p_first_name` varchar(50) NOT NULL,
  `p_university` varchar(100) DEFAULT NULL,
  `p_phone_number` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`p_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES ('asd@asd.com','c','s','Bowie State University','1231231234'),('asd@asd.com1','c1','s1','University of Maryland, College Park','2231231234'),('asd@asd.umd.edu','c1','s1','University of Maryland, College Park','2231231234'),('asd@gmail.com','Let','Us','',''),('asd\\asd2','Let','Us','Towson University',''),('asd\\\\asd2','Let','Us','Towson University',''),('asd\\\\\\\\asd2','Let','Us','Towson University',''),('Doesn\\\\\\\\\\\\\\\'t','This','Form','University of Baltimore',''),('Doesn\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'t','This','Form','University of Baltimore',''),('Doesn\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'t','This','Form','University of Baltimore',''),('Doesn\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'t','This','Form','University of Baltimore',''),('Email','Choksi','Siddharth','','4433792023'),('sdjghkj','Siddhar','asg','Towson University',''),('See','Let','Us','Towson University',''),('See@asd.com','Let','Us','University of Maryland, College Park',''),('See@asd.\\\\\\com','Let','Us','Towson University',''),('See@asd.\\\\\\\\\\\\com','Let','Us','Towson University',''),('sid25786@gmail.com','Choksi','Siddharth','University of Maryland, College Park','4433792023'),('sid25786@gmail1.com','Let','Us','Other','4433792023'),('try \\\\\\\\\\\\','Let','Us','University of Maryland University College',''),('try \\\\\\\\\\\\\\\\\\\\\\\\','Let','Us','University of Maryland University College',''),('Works','This','One','Towson University',''),('Works1','This1','One1','University of Baltimore','1235426423');
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `validate`
--

DROP TABLE IF EXISTS `validate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validate` (
  `username` varchar(40) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `validate`
--

LOCK TABLES `validate` WRITE;
/*!40000 ALTER TABLE `validate` DISABLE KEYS */;
INSERT INTO `validate` VALUES ('priddyreserves','d09a60e0274ef0c2495c781336b86513');
/*!40000 ALTER TABLE `validate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-05-12 16:28:56
