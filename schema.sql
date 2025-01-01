-- MySQL dump 10.13  Distrib 8.2.0, for Linux (x86_64)
--
-- Host: localhost    Database: monolegacy
-- ------------------------------------------------------
-- Server version	8.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
mysqldump: Error: 'Access denied; you need (at least one of) the PROCESS privilege(s) for this operation' when trying to dump tablespaces

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `a_text` text NOT NULL,
  `a_time` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `appID` int NOT NULL AUTO_INCREMENT,
  `appUSER` int NOT NULL DEFAULT '0',
  `appGANG` int NOT NULL DEFAULT '0',
  `appTEXT` text NOT NULL,
  PRIMARY KEY (`appID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attacklogs`
--

DROP TABLE IF EXISTS `attacklogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attacklogs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `attacker` int NOT NULL DEFAULT '0',
  `attacked` int NOT NULL DEFAULT '0',
  `result` enum('won','lost') NOT NULL DEFAULT 'won',
  `time` int NOT NULL DEFAULT '0',
  `stole` int NOT NULL DEFAULT '0',
  `attacklog` longtext NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attacklogs`
--

LOCK TABLES `attacklogs` WRITE;
/*!40000 ALTER TABLE `attacklogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `attacklogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bankxferlogs`
--

DROP TABLE IF EXISTS `bankxferlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bankxferlogs` (
  `cxID` int NOT NULL AUTO_INCREMENT,
  `cxFROM` int NOT NULL DEFAULT '0',
  `cxTO` int NOT NULL DEFAULT '0',
  `cxAMOUNT` int NOT NULL DEFAULT '0',
  `cxTIME` int NOT NULL DEFAULT '0',
  `cxFROMIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `cxBANK` enum('bank','cyber') NOT NULL DEFAULT 'bank',
  PRIMARY KEY (`cxID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bankxferlogs`
--

LOCK TABLES `bankxferlogs` WRITE;
/*!40000 ALTER TABLE `bankxferlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `bankxferlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blacklist`
--

DROP TABLE IF EXISTS `blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blacklist` (
  `bl_ID` int NOT NULL AUTO_INCREMENT,
  `bl_ADDER` int NOT NULL DEFAULT '0',
  `bl_ADDED` int NOT NULL DEFAULT '0',
  `bl_COMMENT` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`bl_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklist`
--

LOCK TABLES `blacklist` WRITE;
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashxferlogs`
--

DROP TABLE IF EXISTS `cashxferlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cashxferlogs` (
  `cxID` int NOT NULL AUTO_INCREMENT,
  `cxFROM` int NOT NULL DEFAULT '0',
  `cxTO` int NOT NULL DEFAULT '0',
  `cxAMOUNT` int NOT NULL DEFAULT '0',
  `cxTIME` int NOT NULL DEFAULT '0',
  `cxFROMIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`cxID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashxferlogs`
--

LOCK TABLES `cashxferlogs` WRITE;
/*!40000 ALTER TABLE `cashxferlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashxferlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `challengebots`
--

DROP TABLE IF EXISTS `challengebots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `challengebots` (
  `cb_npcid` int NOT NULL DEFAULT '0',
  `cb_money` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challengebots`
--

LOCK TABLES `challengebots` WRITE;
/*!40000 ALTER TABLE `challengebots` DISABLE KEYS */;
/*!40000 ALTER TABLE `challengebots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `challengesbeaten`
--

DROP TABLE IF EXISTS `challengesbeaten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `challengesbeaten` (
  `userid` int NOT NULL DEFAULT '0',
  `npcid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challengesbeaten`
--

LOCK TABLES `challengesbeaten` WRITE;
/*!40000 ALTER TABLE `challengesbeaten` DISABLE KEYS */;
/*!40000 ALTER TABLE `challengesbeaten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `cityid` int NOT NULL AUTO_INCREMENT,
  `cityname` varchar(255) NOT NULL DEFAULT '',
  `citydesc` longtext NOT NULL,
  `cityminlevel` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`cityid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Default City','A standard city added to start you off',1);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactlist`
--

DROP TABLE IF EXISTS `contactlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactlist` (
  `cl_ID` int NOT NULL AUTO_INCREMENT,
  `cl_ADDER` int NOT NULL DEFAULT '0',
  `cl_ADDED` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`cl_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactlist`
--

LOCK TABLES `contactlist` WRITE;
/*!40000 ALTER TABLE `contactlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `crID` int NOT NULL AUTO_INCREMENT,
  `crNAME` varchar(255) NOT NULL DEFAULT '',
  `crDESC` text NOT NULL,
  `crCOST` int NOT NULL DEFAULT '0',
  `crENERGY` int NOT NULL DEFAULT '0',
  `crDAYS` int NOT NULL DEFAULT '0',
  `crSTR` int NOT NULL DEFAULT '0',
  `crGUARD` int NOT NULL DEFAULT '0',
  `crLABOUR` int NOT NULL DEFAULT '0',
  `crAGIL` int NOT NULL DEFAULT '0',
  `crIQ` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`crID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coursesdone`
--

DROP TABLE IF EXISTS `coursesdone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coursesdone` (
  `userid` int NOT NULL DEFAULT '0',
  `courseid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coursesdone`
--

LOCK TABLES `coursesdone` WRITE;
/*!40000 ALTER TABLE `coursesdone` DISABLE KEYS */;
/*!40000 ALTER TABLE `coursesdone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crimegroups`
--

DROP TABLE IF EXISTS `crimegroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crimegroups` (
  `cgID` int NOT NULL AUTO_INCREMENT,
  `cgNAME` varchar(255) NOT NULL DEFAULT '',
  `cgORDER` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`cgID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crimegroups`
--

LOCK TABLES `crimegroups` WRITE;
/*!40000 ALTER TABLE `crimegroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `crimegroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crimes`
--

DROP TABLE IF EXISTS `crimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crimes` (
  `crimeID` int NOT NULL AUTO_INCREMENT,
  `crimeNAME` varchar(255) NOT NULL DEFAULT '',
  `crimeBRAVE` int NOT NULL DEFAULT '0',
  `crimePERCFORM` text NOT NULL,
  `crimeSUCCESSMUNY` int NOT NULL DEFAULT '0',
  `crimeSUCCESSCRYS` int NOT NULL DEFAULT '0',
  `crimeSUCCESSITEM` int NOT NULL DEFAULT '0',
  `crimeGROUP` int NOT NULL DEFAULT '0',
  `crimeITEXT` text NOT NULL,
  `crimeSTEXT` text NOT NULL,
  `crimeFTEXT` text NOT NULL,
  `crimeJTEXT` text NOT NULL,
  `crimeJAILTIME` int NOT NULL DEFAULT '0',
  `crimeJREASON` varchar(255) NOT NULL DEFAULT '',
  `crimeXP` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`crimeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crimes`
--

LOCK TABLES `crimes` WRITE;
/*!40000 ALTER TABLE `crimes` DISABLE KEYS */;
/*!40000 ALTER TABLE `crimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crystalmarket`
--

DROP TABLE IF EXISTS `crystalmarket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crystalmarket` (
  `cmID` int NOT NULL AUTO_INCREMENT,
  `cmQTY` int NOT NULL DEFAULT '0',
  `cmADDER` int NOT NULL DEFAULT '0',
  `cmPRICE` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`cmID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crystalmarket`
--

LOCK TABLES `crystalmarket` WRITE;
/*!40000 ALTER TABLE `crystalmarket` DISABLE KEYS */;
/*!40000 ALTER TABLE `crystalmarket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crystalxferlogs`
--

DROP TABLE IF EXISTS `crystalxferlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crystalxferlogs` (
  `cxID` int NOT NULL AUTO_INCREMENT,
  `cxFROM` int NOT NULL DEFAULT '0',
  `cxTO` int NOT NULL DEFAULT '0',
  `cxAMOUNT` int NOT NULL DEFAULT '0',
  `cxTIME` int NOT NULL DEFAULT '0',
  `cxFROMIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`cxID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crystalxferlogs`
--

LOCK TABLES `crystalxferlogs` WRITE;
/*!40000 ALTER TABLE `crystalxferlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `crystalxferlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dps_accepted`
--

DROP TABLE IF EXISTS `dps_accepted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dps_accepted` (
  `dpID` int NOT NULL AUTO_INCREMENT,
  `dpBUYER` int NOT NULL DEFAULT '0',
  `dpFOR` int NOT NULL DEFAULT '0',
  `dpTYPE` varchar(255) NOT NULL DEFAULT '',
  `dpTIME` int NOT NULL DEFAULT '0',
  `dpTXN` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`dpID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dps_accepted`
--

LOCK TABLES `dps_accepted` WRITE;
/*!40000 ALTER TABLE `dps_accepted` DISABLE KEYS */;
/*!40000 ALTER TABLE `dps_accepted` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `evID` int NOT NULL AUTO_INCREMENT,
  `evUSER` int NOT NULL DEFAULT '0',
  `evTIME` int NOT NULL DEFAULT '0',
  `evREAD` int NOT NULL DEFAULT '0',
  `evTEXT` text NOT NULL,
  PRIMARY KEY (`evID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fedjail`
--

DROP TABLE IF EXISTS `fedjail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fedjail` (
  `fed_id` int NOT NULL AUTO_INCREMENT,
  `fed_userid` int NOT NULL DEFAULT '0',
  `fed_days` int NOT NULL DEFAULT '0',
  `fed_jailedby` int NOT NULL DEFAULT '0',
  `fed_reason` text NOT NULL,
  PRIMARY KEY (`fed_id`),
  UNIQUE KEY `fed_userid` (`fed_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fedjail`
--

LOCK TABLES `fedjail` WRITE;
/*!40000 ALTER TABLE `fedjail` DISABLE KEYS */;
/*!40000 ALTER TABLE `fedjail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_forums`
--

DROP TABLE IF EXISTS `forum_forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_forums` (
  `ff_id` int NOT NULL AUTO_INCREMENT,
  `ff_name` varchar(255) NOT NULL DEFAULT '',
  `ff_desc` varchar(255) NOT NULL DEFAULT '',
  `ff_posts` int NOT NULL DEFAULT '0',
  `ff_topics` int NOT NULL DEFAULT '0',
  `ff_lp_time` int NOT NULL DEFAULT '0',
  `ff_lp_poster_id` int NOT NULL DEFAULT '0',
  `ff_lp_poster_name` text NOT NULL,
  `ff_lp_t_id` int NOT NULL DEFAULT '0',
  `ff_lp_t_name` varchar(255) NOT NULL DEFAULT '',
  `ff_auth` enum('public','gang','staff') NOT NULL DEFAULT 'public',
  `ff_owner` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_forums`
--

LOCK TABLES `forum_forums` WRITE;
/*!40000 ALTER TABLE `forum_forums` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_posts`
--

DROP TABLE IF EXISTS `forum_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_posts` (
  `fp_id` int NOT NULL AUTO_INCREMENT,
  `fp_topic_id` int NOT NULL DEFAULT '0',
  `fp_forum_id` int NOT NULL DEFAULT '0',
  `fp_poster_id` int NOT NULL DEFAULT '0',
  `fp_poster_name` text NOT NULL,
  `fp_time` int NOT NULL DEFAULT '0',
  `fp_subject` varchar(255) NOT NULL DEFAULT '',
  `fp_text` text NOT NULL,
  `fp_editor_id` int NOT NULL DEFAULT '0',
  `fp_editor_name` text NOT NULL,
  `fp_editor_time` int NOT NULL DEFAULT '0',
  `fp_edit_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`fp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_posts`
--

LOCK TABLES `forum_posts` WRITE;
/*!40000 ALTER TABLE `forum_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_topics`
--

DROP TABLE IF EXISTS `forum_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_topics` (
  `ft_id` int NOT NULL AUTO_INCREMENT,
  `ft_forum_id` int NOT NULL DEFAULT '0',
  `ft_name` varchar(150) NOT NULL DEFAULT '',
  `ft_desc` varchar(255) NOT NULL DEFAULT '',
  `ft_posts` int NOT NULL DEFAULT '0',
  `ft_owner_id` int NOT NULL DEFAULT '0',
  `ft_owner_name` text NOT NULL,
  `ft_start_time` int NOT NULL DEFAULT '0',
  `ft_last_id` int NOT NULL DEFAULT '0',
  `ft_last_name` text NOT NULL,
  `ft_last_time` int NOT NULL DEFAULT '0',
  `ft_pinned` tinyint NOT NULL DEFAULT '0',
  `ft_locked` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`ft_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_topics`
--

LOCK TABLES `forum_topics` WRITE;
/*!40000 ALTER TABLE `forum_topics` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendslist`
--

DROP TABLE IF EXISTS `friendslist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friendslist` (
  `fl_ID` int NOT NULL AUTO_INCREMENT,
  `fl_ADDER` int NOT NULL DEFAULT '0',
  `fl_ADDED` int NOT NULL DEFAULT '0',
  `fl_COMMENT` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fl_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendslist`
--

LOCK TABLES `friendslist` WRITE;
/*!40000 ALTER TABLE `friendslist` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendslist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gangevents`
--

DROP TABLE IF EXISTS `gangevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gangevents` (
  `gevID` int NOT NULL AUTO_INCREMENT,
  `gevGANG` int NOT NULL DEFAULT '0',
  `gevTIME` int NOT NULL DEFAULT '0',
  `gevTEXT` text NOT NULL,
  PRIMARY KEY (`gevID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gangevents`
--

LOCK TABLES `gangevents` WRITE;
/*!40000 ALTER TABLE `gangevents` DISABLE KEYS */;
/*!40000 ALTER TABLE `gangevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gangs`
--

DROP TABLE IF EXISTS `gangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gangs` (
  `gangID` int NOT NULL AUTO_INCREMENT,
  `gangNAME` varchar(255) NOT NULL DEFAULT '',
  `gangDESC` text NOT NULL,
  `gangPREF` varchar(12) NOT NULL DEFAULT '',
  `gangSUFF` varchar(12) NOT NULL DEFAULT '',
  `gangMONEY` int NOT NULL DEFAULT '0',
  `gangCRYSTALS` int NOT NULL DEFAULT '0',
  `gangRESPECT` int NOT NULL DEFAULT '0',
  `gangPRESIDENT` int NOT NULL DEFAULT '0',
  `gangVICEPRES` int NOT NULL DEFAULT '0',
  `gangCAPACITY` int NOT NULL DEFAULT '0',
  `gangCRIME` int NOT NULL DEFAULT '0',
  `gangCHOURS` int NOT NULL DEFAULT '0',
  `gangAMENT` longtext NOT NULL,
  PRIMARY KEY (`gangID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gangs`
--

LOCK TABLES `gangs` WRITE;
/*!40000 ALTER TABLE `gangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `gangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gangwars`
--

DROP TABLE IF EXISTS `gangwars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gangwars` (
  `warID` int NOT NULL AUTO_INCREMENT,
  `warDECLARER` int NOT NULL DEFAULT '0',
  `warDECLARED` int NOT NULL DEFAULT '0',
  `warTIME` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`warID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gangwars`
--

LOCK TABLES `gangwars` WRITE;
/*!40000 ALTER TABLE `gangwars` DISABLE KEYS */;
/*!40000 ALTER TABLE `gangwars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `houses` (
  `hID` int NOT NULL AUTO_INCREMENT,
  `hNAME` varchar(255) NOT NULL DEFAULT '',
  `hPRICE` int NOT NULL DEFAULT '0',
  `hWILL` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`hID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES (1,'Default House',0,100);
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imarketaddlogs`
--

DROP TABLE IF EXISTS `imarketaddlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imarketaddlogs` (
  `imaID` int NOT NULL AUTO_INCREMENT,
  `imaITEM` int NOT NULL DEFAULT '0',
  `imaPRICE` int NOT NULL DEFAULT '0',
  `imaINVID` int NOT NULL DEFAULT '0',
  `imaADDER` int NOT NULL DEFAULT '0',
  `imaTIME` int NOT NULL DEFAULT '0',
  `imaCONTENT` text NOT NULL,
  PRIMARY KEY (`imaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imarketaddlogs`
--

LOCK TABLES `imarketaddlogs` WRITE;
/*!40000 ALTER TABLE `imarketaddlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `imarketaddlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imbuylogs`
--

DROP TABLE IF EXISTS `imbuylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imbuylogs` (
  `imbID` int NOT NULL AUTO_INCREMENT,
  `imbITEM` int NOT NULL DEFAULT '0',
  `imbADDER` int NOT NULL DEFAULT '0',
  `imbBUYER` int NOT NULL DEFAULT '0',
  `imbPRICE` int NOT NULL DEFAULT '0',
  `imbIMID` int NOT NULL DEFAULT '0',
  `imbINVID` int NOT NULL DEFAULT '0',
  `imbTIME` int NOT NULL DEFAULT '0',
  `imbCONTENT` text NOT NULL,
  PRIMARY KEY (`imbID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imbuylogs`
--

LOCK TABLES `imbuylogs` WRITE;
/*!40000 ALTER TABLE `imbuylogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `imbuylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imremovelogs`
--

DROP TABLE IF EXISTS `imremovelogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imremovelogs` (
  `imrID` int NOT NULL AUTO_INCREMENT,
  `imrITEM` int NOT NULL DEFAULT '0',
  `imrADDER` int NOT NULL DEFAULT '0',
  `imrREMOVER` int NOT NULL DEFAULT '0',
  `imrIMID` int NOT NULL DEFAULT '0',
  `imrINVID` int NOT NULL DEFAULT '0',
  `imrTIME` int NOT NULL DEFAULT '0',
  `imrCONTENT` text NOT NULL,
  PRIMARY KEY (`imrID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imremovelogs`
--

LOCK TABLES `imremovelogs` WRITE;
/*!40000 ALTER TABLE `imremovelogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `imremovelogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory` (
  `inv_id` int NOT NULL AUTO_INCREMENT,
  `inv_itemid` int NOT NULL DEFAULT '0',
  `inv_userid` int NOT NULL DEFAULT '0',
  `inv_qty` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itembuylogs`
--

DROP TABLE IF EXISTS `itembuylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itembuylogs` (
  `ibID` int NOT NULL AUTO_INCREMENT,
  `ibUSER` int NOT NULL DEFAULT '0',
  `ibITEM` int NOT NULL DEFAULT '0',
  `ibTOTALPRICE` int NOT NULL DEFAULT '0',
  `ibQTY` int NOT NULL DEFAULT '0',
  `ibTIME` int NOT NULL DEFAULT '0',
  `ibCONTENT` text NOT NULL,
  PRIMARY KEY (`ibID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itembuylogs`
--

LOCK TABLES `itembuylogs` WRITE;
/*!40000 ALTER TABLE `itembuylogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `itembuylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemmarket`
--

DROP TABLE IF EXISTS `itemmarket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemmarket` (
  `imID` int NOT NULL AUTO_INCREMENT,
  `imITEM` int NOT NULL DEFAULT '0',
  `imADDER` int NOT NULL DEFAULT '0',
  `imPRICE` int NOT NULL DEFAULT '0',
  `imCURRENCY` enum('money','crystals') NOT NULL DEFAULT 'money',
  `imQTY` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`imID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmarket`
--

LOCK TABLES `itemmarket` WRITE;
/*!40000 ALTER TABLE `itemmarket` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemmarket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `itmid` int NOT NULL AUTO_INCREMENT,
  `itmtype` int NOT NULL DEFAULT '0',
  `itmname` varchar(255) NOT NULL DEFAULT '',
  `itmdesc` text NOT NULL,
  `itmbuyprice` int NOT NULL DEFAULT '0',
  `itmsellprice` int NOT NULL DEFAULT '0',
  `itmbuyable` int NOT NULL DEFAULT '0',
  `effect1_on` tinyint NOT NULL DEFAULT '0',
  `effect1` text NOT NULL,
  `effect2_on` tinyint NOT NULL DEFAULT '0',
  `effect2` text NOT NULL,
  `effect3_on` tinyint NOT NULL DEFAULT '0',
  `effect3` text NOT NULL,
  `weapon` int NOT NULL DEFAULT '0',
  `armor` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`itmid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemselllogs`
--

DROP TABLE IF EXISTS `itemselllogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemselllogs` (
  `isID` int NOT NULL AUTO_INCREMENT,
  `isUSER` int NOT NULL DEFAULT '0',
  `isITEM` int NOT NULL DEFAULT '0',
  `isTOTALPRICE` int NOT NULL DEFAULT '0',
  `isQTY` int NOT NULL DEFAULT '0',
  `isTIME` int NOT NULL DEFAULT '0',
  `isCONTENT` text NOT NULL,
  PRIMARY KEY (`isID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemselllogs`
--

LOCK TABLES `itemselllogs` WRITE;
/*!40000 ALTER TABLE `itemselllogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemselllogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemtypes`
--

DROP TABLE IF EXISTS `itemtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemtypes` (
  `itmtypeid` int NOT NULL AUTO_INCREMENT,
  `itmtypename` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itmtypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemtypes`
--

LOCK TABLES `itemtypes` WRITE;
/*!40000 ALTER TABLE `itemtypes` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemxferlogs`
--

DROP TABLE IF EXISTS `itemxferlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itemxferlogs` (
  `ixID` int NOT NULL AUTO_INCREMENT,
  `ixFROM` int NOT NULL DEFAULT '0',
  `ixTO` int NOT NULL DEFAULT '0',
  `ixITEM` int NOT NULL DEFAULT '0',
  `ixQTY` int NOT NULL DEFAULT '0',
  `ixTIME` int NOT NULL DEFAULT '0',
  `ixFROMIP` varchar(255) NOT NULL DEFAULT '',
  `ixTOIP` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ixID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemxferlogs`
--

LOCK TABLES `itemxferlogs` WRITE;
/*!40000 ALTER TABLE `itemxferlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemxferlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jaillogs`
--

DROP TABLE IF EXISTS `jaillogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jaillogs` (
  `jaID` int NOT NULL AUTO_INCREMENT,
  `jaJAILER` int NOT NULL DEFAULT '0',
  `jaJAILED` int NOT NULL DEFAULT '0',
  `jaDAYS` int NOT NULL DEFAULT '0',
  `jaREASON` longtext NOT NULL,
  `jaTIME` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`jaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jaillogs`
--

LOCK TABLES `jaillogs` WRITE;
/*!40000 ALTER TABLE `jaillogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jaillogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobranks`
--

DROP TABLE IF EXISTS `jobranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobranks` (
  `jrID` int NOT NULL AUTO_INCREMENT,
  `jrNAME` varchar(255) NOT NULL DEFAULT '',
  `jrJOB` int NOT NULL DEFAULT '0',
  `jrPAY` int NOT NULL DEFAULT '0',
  `jrIQG` int NOT NULL DEFAULT '0',
  `jrLABOURG` int NOT NULL DEFAULT '0',
  `jrSTRG` int NOT NULL DEFAULT '0',
  `jrIQN` int NOT NULL DEFAULT '0',
  `jrLABOURN` int NOT NULL DEFAULT '0',
  `jrSTRN` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`jrID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobranks`
--

LOCK TABLES `jobranks` WRITE;
/*!40000 ALTER TABLE `jobranks` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobranks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `jID` int NOT NULL AUTO_INCREMENT,
  `jNAME` varchar(255) NOT NULL DEFAULT '',
  `jFIRST` int NOT NULL DEFAULT '0',
  `jDESC` varchar(255) NOT NULL DEFAULT '',
  `jOWNER` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`jID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mail` (
  `mail_id` int NOT NULL AUTO_INCREMENT,
  `mail_read` int NOT NULL DEFAULT '0',
  `mail_from` int NOT NULL DEFAULT '0',
  `mail_to` int NOT NULL DEFAULT '0',
  `mail_time` int NOT NULL DEFAULT '0',
  `mail_subject` varchar(255) NOT NULL DEFAULT '',
  `mail_text` text NOT NULL,
  PRIMARY KEY (`mail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail`
--

LOCK TABLES `mail` WRITE;
/*!40000 ALTER TABLE `mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oclogs`
--

DROP TABLE IF EXISTS `oclogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oclogs` (
  `oclID` int NOT NULL AUTO_INCREMENT,
  `oclOC` int NOT NULL DEFAULT '0',
  `oclGANG` int NOT NULL DEFAULT '0',
  `oclLOG` text NOT NULL,
  `oclRESULT` enum('success','failure') NOT NULL DEFAULT 'success',
  `oclMONEY` int NOT NULL DEFAULT '0',
  `ocCRIMEN` varchar(255) NOT NULL DEFAULT '',
  `ocTIME` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`oclID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oclogs`
--

LOCK TABLES `oclogs` WRITE;
/*!40000 ALTER TABLE `oclogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `oclogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orgcrimes`
--

DROP TABLE IF EXISTS `orgcrimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orgcrimes` (
  `ocID` int NOT NULL AUTO_INCREMENT,
  `ocNAME` varchar(255) NOT NULL DEFAULT '',
  `ocUSERS` int NOT NULL DEFAULT '0',
  `ocSTARTTEXT` text NOT NULL,
  `ocSUCCTEXT` text NOT NULL,
  `ocFAILTEXT` text NOT NULL,
  `ocMINMONEY` int NOT NULL DEFAULT '0',
  `ocMAXMONEY` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ocID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgcrimes`
--

LOCK TABLES `orgcrimes` WRITE;
/*!40000 ALTER TABLE `orgcrimes` DISABLE KEYS */;
/*!40000 ALTER TABLE `orgcrimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papercontent`
--

DROP TABLE IF EXISTS `papercontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `papercontent` (
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papercontent`
--

LOCK TABLES `papercontent` WRITE;
/*!40000 ALTER TABLE `papercontent` DISABLE KEYS */;
INSERT INTO `papercontent` VALUES ('Here you can put game news, or prehaps an update log.');
/*!40000 ALTER TABLE `papercontent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls`
--

DROP TABLE IF EXISTS `polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `polls` (
  `id` int NOT NULL AUTO_INCREMENT,
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `question` varchar(255) NOT NULL DEFAULT '',
  `choice1` varchar(255) NOT NULL DEFAULT '',
  `choice2` varchar(255) NOT NULL DEFAULT '',
  `choice3` varchar(255) NOT NULL DEFAULT '',
  `choice4` varchar(255) NOT NULL DEFAULT '',
  `choice5` varchar(255) NOT NULL DEFAULT '',
  `choice6` varchar(255) NOT NULL DEFAULT '',
  `choice7` varchar(255) NOT NULL DEFAULT '',
  `choice8` varchar(255) NOT NULL DEFAULT '',
  `choice9` varchar(255) NOT NULL DEFAULT '',
  `choice10` varchar(255) NOT NULL DEFAULT '',
  `voted1` int NOT NULL DEFAULT '0',
  `voted2` int NOT NULL DEFAULT '0',
  `voted3` int NOT NULL DEFAULT '0',
  `voted4` int NOT NULL DEFAULT '0',
  `voted5` int NOT NULL DEFAULT '0',
  `voted6` int NOT NULL DEFAULT '0',
  `voted7` int NOT NULL DEFAULT '0',
  `voted8` int NOT NULL DEFAULT '0',
  `voted9` int NOT NULL DEFAULT '0',
  `voted10` int NOT NULL DEFAULT '0',
  `votes` int NOT NULL DEFAULT '0',
  `winner` int NOT NULL DEFAULT '0',
  `hidden` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls`
--

LOCK TABLES `polls` WRITE;
/*!40000 ALTER TABLE `polls` DISABLE KEYS */;
/*!40000 ALTER TABLE `polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preports`
--

DROP TABLE IF EXISTS `preports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preports` (
  `prID` int NOT NULL AUTO_INCREMENT,
  `prREPORTER` int NOT NULL DEFAULT '0',
  `prREPORTED` int NOT NULL DEFAULT '0',
  `prTEXT` longtext NOT NULL,
  PRIMARY KEY (`prID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preports`
--

LOCK TABLES `preports` WRITE;
/*!40000 ALTER TABLE `preports` DISABLE KEYS */;
/*!40000 ALTER TABLE `preports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referals`
--

DROP TABLE IF EXISTS `referals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referals` (
  `refID` int NOT NULL AUTO_INCREMENT,
  `refREFER` int NOT NULL DEFAULT '0',
  `refREFED` int NOT NULL DEFAULT '0',
  `refTIME` int NOT NULL DEFAULT '0',
  `refREFERIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `refREFEDIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`refID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referals`
--

LOCK TABLES `referals` WRITE;
/*!40000 ALTER TABLE `referals` DISABLE KEYS */;
/*!40000 ALTER TABLE `referals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `conf_id` int NOT NULL AUTO_INCREMENT,
  `conf_name` varchar(255) NOT NULL DEFAULT '',
  `conf_value` text NOT NULL,
  PRIMARY KEY (`conf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'validate_period','15'),(2,'validate_on','0'),(3,'regcap_on','0'),(4,'hospital_count','0'),(5,'jail_count','0'),(6,'sendcrys_on','1'),(7,'sendbank_on','1'),(8,'ct_refillprice','12'),(9,'ct_iqpercrys','5'),(10,'ct_moneypercrys','200'),(11,'staff_pad','Here you can store notes for all staff to see.'),(12,'willp_item','0'),(13,'jquery_location','js/jquery-1.7.1.min.js'),(14,'game_name','Monolegacy'),(15,'game_description','Description'),(16,'game_owner','Owner');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopitems`
--

DROP TABLE IF EXISTS `shopitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopitems` (
  `sitemID` int NOT NULL AUTO_INCREMENT,
  `sitemSHOP` int NOT NULL DEFAULT '0',
  `sitemITEMID` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`sitemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopitems`
--

LOCK TABLES `shopitems` WRITE;
/*!40000 ALTER TABLE `shopitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `shopitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shops` (
  `shopID` int NOT NULL AUTO_INCREMENT,
  `shopLOCATION` int NOT NULL DEFAULT '0',
  `shopNAME` varchar(255) NOT NULL DEFAULT '',
  `shopDESCRIPTION` text NOT NULL,
  PRIMARY KEY (`shopID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stafflog`
--

DROP TABLE IF EXISTS `stafflog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stafflog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL DEFAULT '0',
  `time` int NOT NULL DEFAULT '0',
  `action` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stafflog`
--

LOCK TABLES `stafflog` WRITE;
/*!40000 ALTER TABLE `stafflog` DISABLE KEYS */;
/*!40000 ALTER TABLE `stafflog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffnotelogs`
--

DROP TABLE IF EXISTS `staffnotelogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staffnotelogs` (
  `snID` int NOT NULL AUTO_INCREMENT,
  `snCHANGER` int NOT NULL DEFAULT '0',
  `snCHANGED` int NOT NULL DEFAULT '0',
  `snTIME` int NOT NULL DEFAULT '0',
  `snOLD` longtext NOT NULL,
  `snNEW` longtext NOT NULL,
  PRIMARY KEY (`snID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffnotelogs`
--

LOCK TABLES `staffnotelogs` WRITE;
/*!40000 ALTER TABLE `staffnotelogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffnotelogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surrenders`
--

DROP TABLE IF EXISTS `surrenders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surrenders` (
  `surID` int NOT NULL AUTO_INCREMENT,
  `surWAR` int NOT NULL DEFAULT '0',
  `surWHO` int NOT NULL DEFAULT '0',
  `surTO` int NOT NULL DEFAULT '0',
  `surMSG` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`surID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surrenders`
--

LOCK TABLES `surrenders` WRITE;
/*!40000 ALTER TABLE `surrenders` DISABLE KEYS */;
/*!40000 ALTER TABLE `surrenders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unjaillogs`
--

DROP TABLE IF EXISTS `unjaillogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unjaillogs` (
  `ujaID` int NOT NULL AUTO_INCREMENT,
  `ujaJAILER` int NOT NULL DEFAULT '0',
  `ujaJAILED` int NOT NULL DEFAULT '0',
  `ujaTIME` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ujaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unjaillogs`
--

LOCK TABLES `unjaillogs` WRITE;
/*!40000 ALTER TABLE `unjaillogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `unjaillogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `userpass` varchar(255) NOT NULL DEFAULT '',
  `level` int NOT NULL DEFAULT '0',
  `exp` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `money` int NOT NULL DEFAULT '0',
  `crystals` int NOT NULL DEFAULT '0',
  `laston` int NOT NULL DEFAULT '0',
  `lastip` varchar(255) NOT NULL DEFAULT '',
  `job` int NOT NULL DEFAULT '0',
  `energy` int NOT NULL DEFAULT '0',
  `will` int NOT NULL DEFAULT '0',
  `maxwill` int NOT NULL DEFAULT '0',
  `brave` int NOT NULL DEFAULT '0',
  `maxbrave` int NOT NULL DEFAULT '0',
  `maxenergy` int NOT NULL DEFAULT '0',
  `hp` int NOT NULL DEFAULT '0',
  `maxhp` int NOT NULL DEFAULT '0',
  `lastrest_life` int NOT NULL DEFAULT '0',
  `lastrest_other` int NOT NULL DEFAULT '0',
  `location` int NOT NULL DEFAULT '0',
  `hospital` int NOT NULL DEFAULT '0',
  `jail` int NOT NULL DEFAULT '0',
  `jail_reason` varchar(255) NOT NULL DEFAULT '',
  `fedjail` int NOT NULL DEFAULT '0',
  `user_level` int NOT NULL DEFAULT '1',
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `daysold` int NOT NULL DEFAULT '0',
  `signedup` int NOT NULL DEFAULT '0',
  `gang` int NOT NULL DEFAULT '0',
  `daysingang` int NOT NULL DEFAULT '0',
  `course` int NOT NULL DEFAULT '0',
  `cdays` int NOT NULL DEFAULT '0',
  `jobrank` int NOT NULL DEFAULT '0',
  `donatordays` int NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `login_name` varchar(255) NOT NULL DEFAULT '',
  `display_pic` text NOT NULL,
  `duties` varchar(255) NOT NULL DEFAULT 'N/A',
  `bankmoney` int NOT NULL DEFAULT '0',
  `cybermoney` int NOT NULL DEFAULT '-1',
  `staffnotes` longtext NOT NULL,
  `mailban` int NOT NULL DEFAULT '0',
  `mb_reason` varchar(255) NOT NULL DEFAULT '',
  `hospreason` varchar(255) NOT NULL DEFAULT '',
  `lastip_login` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `lastip_signup` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `last_login` int NOT NULL DEFAULT '0',
  `voted` text NOT NULL,
  `crimexp` int NOT NULL DEFAULT '0',
  `attacking` int NOT NULL DEFAULT '0',
  `verified` int NOT NULL DEFAULT '0',
  `forumban` int NOT NULL DEFAULT '0',
  `fb_reason` varchar(255) NOT NULL DEFAULT '',
  `posts` int NOT NULL DEFAULT '0',
  `forums_avatar` varchar(255) NOT NULL DEFAULT '',
  `forums_signature` varchar(250) NOT NULL DEFAULT '',
  `new_events` int NOT NULL DEFAULT '0',
  `new_mail` int NOT NULL DEFAULT '0',
  `friend_count` int NOT NULL DEFAULT '0',
  `enemy_count` int NOT NULL DEFAULT '0',
  `new_announcements` int NOT NULL DEFAULT '0',
  `boxes_opened` int NOT NULL DEFAULT '0',
  `user_notepad` text NOT NULL,
  `equip_primary` int NOT NULL DEFAULT '0',
  `equip_secondary` int NOT NULL DEFAULT '0',
  `equip_armor` int NOT NULL DEFAULT '0',
  `force_logout` tinyint NOT NULL DEFAULT '0',
  `pass_salt` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userstats`
--

DROP TABLE IF EXISTS `userstats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userstats` (
  `userid` int NOT NULL DEFAULT '0',
  `strength` float NOT NULL DEFAULT '0',
  `agility` float NOT NULL DEFAULT '0',
  `guard` float NOT NULL DEFAULT '0',
  `labour` float NOT NULL DEFAULT '0',
  `IQ` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userstats`
--

LOCK TABLES `userstats` WRITE;
/*!40000 ALTER TABLE `userstats` DISABLE KEYS */;
/*!40000 ALTER TABLE `userstats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votes` (
  `userid` int NOT NULL DEFAULT '0',
  `list` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `willps_accepted`
--

DROP TABLE IF EXISTS `willps_accepted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `willps_accepted` (
  `dpID` int NOT NULL AUTO_INCREMENT,
  `dpBUYER` int NOT NULL DEFAULT '0',
  `dpFOR` int NOT NULL DEFAULT '0',
  `dpAMNT` varchar(255) NOT NULL DEFAULT '',
  `dpTIME` int NOT NULL DEFAULT '0',
  `dpTXN` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`dpID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `willps_accepted`
--

LOCK TABLES `willps_accepted` WRITE;
/*!40000 ALTER TABLE `willps_accepted` DISABLE KEYS */;
/*!40000 ALTER TABLE `willps_accepted` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-01 12:03:59
