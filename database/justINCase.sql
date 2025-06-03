-- MySQL dump 10.13  Distrib 8.0.38, for macos14 (arm64)
--
-- Host: 127.0.0.1    Database: litCrit
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Books`
--

DROP TABLE IF EXISTS `Books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Books` (
  `bookID` int(11) NOT NULL AUTO_INCREMENT,
  `bookTitle` varchar(70) NOT NULL,
  `bookAuthor` varchar(80) NOT NULL,
  `yearOfPublishing` int(11) NOT NULL,
  `bookGenre` int(11) DEFAULT NULL,
  `bookAnnotation` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bookCover` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`bookID`),
  KEY `bookGenre` (`bookGenre`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`bookGenre`) REFERENCES `genre` (`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Books`
--

LOCK TABLES `Books` WRITE;
/*!40000 ALTER TABLE `Books` DISABLE KEYS */;
INSERT INTO `Books` VALUES (1,'Пипи Дългото чорапче','Астрид Линдгрен',2013,4,'Pippi Longstocking is the fictional main character in a series of children\'s books by Swedish author Astrid Lindgren. Pippi was named by Lindgren\'s daughter Karin, who asked her mother for a get-well story when she was off school.','images/677ff17ba16a2.jpg'),(2,'Ян Бибиян','Елин Пелин',2014,4,'Yan Bibiyan is the first Bulgarian fantasy novel for children by the Bulgarian writer Elin Pelin and the name of its protagonist. The novel is described as \" the most celebrated children’s fantasy novel\".','images/677ff21de03cc.jpg'),(3,'The idea of you','Robinne Lee',2019,5,'Solène Marchand, the thirty-nine-year-old owner of an art gallery in Los Angeles, is reluctant to take her daughter, Isabelle, to meet her favorite boy band. But since her divorce, she\'s more eager than ever to be close to Isabelle.','images/677ff36ccd983.jpg'),(4,'Библия','Последователите на Исус <3',100,1,'The Bible is a collection of religious texts and scriptures that are held to be sacred in Christianity, and partly in Judaism, Samaritanism, Islam, the Baháʼí Faith, and other Abrahamic religions. The Bible is an anthology originally written in Hebrew, Aramaic, and Koine Greek. ','images/677ff4495bb11.jpg'),(5,'Book','Booker',2012,2,'aaaa','images/6780bbe346489.jpg'),(6,'Book','Booker',2012,2,'aaaa','images/6780bbe843645.jpg');
/*!40000 ALTER TABLE `Books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genre` (
  `genreID` int(11) NOT NULL AUTO_INCREMENT,
  `genreOrder` int(11) DEFAULT NULL,
  `bookGenre` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,1,'Поезия'),(2,2,'Проза'),(3,3,'Роман'),(4,4,'Детска Литература'),(5,5,'Романтика'),(6,6,'Комедия'),(7,7,'Криминалистика'),(8,8,'Фантастика');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-15 10:03:21
