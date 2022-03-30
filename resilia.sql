-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: resilia
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `nonprofitorglist`
--

DROP TABLE IF EXISTS `nonprofitorglist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nonprofitorglist` (
  `name` varchar(64) NOT NULL,
  `501C3Status` varchar(64) NOT NULL,
  `state` varchar(2) NOT NULL,
  `city` varchar(64) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nonprofitorglist`
--

LOCK TABLES `nonprofitorglist` WRITE;
/*!40000 ALTER TABLE `nonprofitorglist` DISABLE KEYS */;
INSERT INTO `nonprofitorglist` VALUES ('Feed America','Applied','NY','New York'),('Help the Birds','Approved','CA','San Jose'),('Save the Children','Application In Progress','IL','Chicago'),('Save the Children 2','Application In Progress','NY','Chicago'),('Save the Children 3','Application In Progress','CA','Chicago');
/*!40000 ALTER TABLE `nonprofitorglist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userlist`
--

DROP TABLE IF EXISTS `userlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userlist` (
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `role` varchar(64) NOT NULL,
  `org` varchar(64) NOT NULL,
  UNIQUE KEY `unique_index` (`email`,`org`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlist`
--

LOCK TABLES `userlist` WRITE;
/*!40000 ALTER TABLE `userlist` DISABLE KEYS */;
INSERT INTO `userlist` VALUES ('Amy Johnson','amy@helpthebirds.org','STAFF','Help the Birds'),('Jeremy Taylor','jeremy.taylor@yahoo.com','STAFF','Save the Children'),('John Rivers','john.rivers@helpthebirds.org','ADMIN','Help the Birds'),('Scott Branch','scott.branch@feedus.com','ADMIN','Feed America'),('Test','test@test','ADMIN','Save the Children 3');
/*!40000 ALTER TABLE `userlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-30  8:40:44
