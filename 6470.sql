-- MySQL dump 10.13  Distrib 5.1.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: 6470_main
-- ------------------------------------------------------
-- Server version	5.1.37-1ubuntu5.1

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
-- Table structure for table `apiconfig`
--

DROP TABLE IF EXISTS `apiconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apiconfig` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `updater` varchar(50) NOT NULL,
  `configcursor` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apiconfig`
--

LOCK TABLES `apiconfig` WRITE;
/*!40000 ALTER TABLE `apiconfig` DISABLE KEYS */;
/*!40000 ALTER TABLE `apiconfig` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `band`
--

DROP TABLE IF EXISTS `band`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `band` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `collegeid` int(5) NOT NULL,
  `band` int(1) NOT NULL,
  `article` text NOT NULL,
  `views` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27764 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `band`
--

LOCK TABLES `band` WRITE;
/*!40000 ALTER TABLE `band` DISABLE KEYS */;
/*!40000 ALTER TABLE `band` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bandalias`
--

DROP TABLE IF EXISTS `bandalias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bandalias` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `artistid` int(5) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `band` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bandalias`
--

LOCK TABLES `bandalias` WRITE;
/*!40000 ALTER TABLE `bandalias` DISABLE KEYS */;
/*!40000 ALTER TABLE `bandalias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bandgenre`
--

DROP TABLE IF EXISTS `bandgenre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bandgenre` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `artistid` int(5) NOT NULL,
  `genreid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bandgenre`
--

LOCK TABLES `bandgenre` WRITE;
/*!40000 ALTER TABLE `bandgenre` DISABLE KEYS */;
/*!40000 ALTER TABLE `bandgenre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bandtalk`
--

DROP TABLE IF EXISTS `bandtalk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bandtalk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `bandid` int(5) NOT NULL,
  `userid` int(5) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bandtalk`
--

LOCK TABLES `bandtalk` WRITE;
/*!40000 ALTER TABLE `bandtalk` DISABLE KEYS */;
/*!40000 ALTER TABLE `bandtalk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `captcha` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `answer` int(3) NOT NULL,
  `captchakey` int(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=511 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `captcha`
--

LOCK TABLES `captcha` WRITE;
/*!40000 ALTER TABLE `captcha` DISABLE KEYS */;
/*!40000 ALTER TABLE `captcha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `college`
--

DROP TABLE IF EXISTS `college`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `college` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `college` varchar(100) CHARACTER SET utf8 NOT NULL,
  `emaildomain` varchar(50) NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `city` varchar(100) CHARACTER SET utf8 NOT NULL,
  `state` varchar(20) CHARACTER SET utf8 NOT NULL,
  `zip` varchar(10) NOT NULL,
  `country` varchar(2) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6727 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `college`
--

LOCK TABLES `college` WRITE;
/*!40000 ALTER TABLE `college` DISABLE KEYS */;
/*!40000 ALTER TABLE `college` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collegetalk`
--

DROP TABLE IF EXISTS `collegetalk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collegetalk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `collegeid` int(5) NOT NULL,
  `userid` int(5) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collegetalk`
--

LOCK TABLES `collegetalk` WRITE;
/*!40000 ALTER TABLE `collegetalk` DISABLE KEYS */;
/*!40000 ALTER TABLE `collegetalk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=330 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dailypicks`
--

DROP TABLE IF EXISTS `dailypicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dailypicks` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `picktype` varchar(20) NOT NULL,
  `pickid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dailypicks`
--

LOCK TABLES `dailypicks` WRITE;
/*!40000 ALTER TABLE `dailypicks` DISABLE KEYS */;
/*!40000 ALTER TABLE `dailypicks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(200) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `lat` float NOT NULL,
  `long` float NOT NULL,
  `views` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventbands`
--

DROP TABLE IF EXISTS `eventbands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventbands` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `eventid` int(5) NOT NULL,
  `bandid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventbands`
--

LOCK TABLES `eventbands` WRITE;
/*!40000 ALTER TABLE `eventbands` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventbands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventmusic`
--

DROP TABLE IF EXISTS `eventmusic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventmusic` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `eventid` int(5) NOT NULL,
  `musicid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventmusic`
--

LOCK TABLES `eventmusic` WRITE;
/*!40000 ALTER TABLE `eventmusic` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventmusic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventtalk`
--

DROP TABLE IF EXISTS `eventtalk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventtalk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(5) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventtalk`
--

LOCK TABLES `eventtalk` WRITE;
/*!40000 ALTER TABLE `eventtalk` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventtalk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1543 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `music` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `trackno` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `album` varchar(100) NOT NULL,
  `genreid` int(5) NOT NULL,
  `bandid` int(5) NOT NULL,
  `views` int(11) NOT NULL,
  `article` text NOT NULL,
  `picture` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63993 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music`
--

LOCK TABLES `music` WRITE;
/*!40000 ALTER TABLE `music` DISABLE KEYS */;
/*!40000 ALTER TABLE `music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musictalk`
--

DROP TABLE IF EXISTS `musictalk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `musictalk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `musicid` int(5) NOT NULL,
  `userid` int(5) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musictalk`
--

LOCK TABLES `musictalk` WRITE;
/*!40000 ALTER TABLE `musictalk` DISABLE KEYS */;
/*!40000 ALTER TABLE `musictalk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `realname` varchar(100) NOT NULL,
  `registerdate` date NOT NULL,
  `collegeid` int(5) NOT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'http://albertyw.mit.edu/6470/img/profile/default.jpg',
  `lastfmusername` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userbandfav`
--

DROP TABLE IF EXISTS `userbandfav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userbandfav` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `bandid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userbandfav`
--

LOCK TABLES `userbandfav` WRITE;
/*!40000 ALTER TABLE `userbandfav` DISABLE KEYS */;
/*!40000 ALTER TABLE `userbandfav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userbandview`
--

DROP TABLE IF EXISTS `userbandview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userbandview` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `bandid` int(5) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=483 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userbandview`
--

LOCK TABLES `userbandview` WRITE;
/*!40000 ALTER TABLE `userbandview` DISABLE KEYS */;
/*!40000 ALTER TABLE `userbandview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usereventfav`
--

DROP TABLE IF EXISTS `usereventfav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usereventfav` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `eventid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usereventfav`
--

LOCK TABLES `usereventfav` WRITE;
/*!40000 ALTER TABLE `usereventfav` DISABLE KEYS */;
/*!40000 ALTER TABLE `usereventfav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usereventview`
--

DROP TABLE IF EXISTS `usereventview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usereventview` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `eventid` int(5) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usereventview`
--

LOCK TABLES `usereventview` WRITE;
/*!40000 ALTER TABLE `usereventview` DISABLE KEYS */;
/*!40000 ALTER TABLE `usereventview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usermusicfav`
--

DROP TABLE IF EXISTS `usermusicfav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usermusicfav` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `musicid` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usermusicfav`
--

LOCK TABLES `usermusicfav` WRITE;
/*!40000 ALTER TABLE `usermusicfav` DISABLE KEYS */;
/*!40000 ALTER TABLE `usermusicfav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usermusicview`
--

DROP TABLE IF EXISTS `usermusicview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usermusicview` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userid` int(5) NOT NULL,
  `musicid` int(5) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usermusicview`
--

LOCK TABLES `usermusicview` WRITE;
/*!40000 ALTER TABLE `usermusicview` DISABLE KEYS */;
/*!40000 ALTER TABLE `usermusicview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertalk`
--

DROP TABLE IF EXISTS `usertalk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertalk` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `writerid` int(5) NOT NULL,
  `recipientid` int(5) NOT NULL,
  `text` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertalk`
--

LOCK TABLES `usertalk` WRITE;
/*!40000 ALTER TABLE `usertalk` DISABLE KEYS */;
/*!40000 ALTER TABLE `usertalk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertemporary`
--

DROP TABLE IF EXISTS `usertemporary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertemporary` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `realname` varchar(50) NOT NULL,
  `collegeid` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `confirmationcode` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertemporary`
--

LOCK TABLES `usertemporary` WRITE;
/*!40000 ALTER TABLE `usertemporary` DISABLE KEYS */;
/*!40000 ALTER TABLE `usertemporary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useruserfav`
--

DROP TABLE IF EXISTS `useruserfav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useruserfav` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user1id` int(5) NOT NULL,
  `user2id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useruserfav`
--

LOCK TABLES `useruserfav` WRITE;
/*!40000 ALTER TABLE `useruserfav` DISABLE KEYS */;
/*!40000 ALTER TABLE `useruserfav` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-04-13 14:58:31
