-- MySQL dump 10.14  Distrib 5.5.37-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: skm
-- ------------------------------------------------------
-- Server version	5.5.37-MariaDB
use skm;
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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `UID` int(11) DEFAULT NULL,
  `GIDname` varchar(20) DEFAULT NULL,
  `GID` int(11) DEFAULT NULL,
  `homedir` varchar(50) DEFAULT NULL,
  `GECOS` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=274 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hak`
--

DROP TABLE IF EXISTS `hak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hak` (
  `id_host` int(11) NOT NULL DEFAULT '0',
  `id_account` int(11) NOT NULL DEFAULT '0',
  `id_keyring` int(11) NOT NULL DEFAULT '0',
  `id_key` int(11) NOT NULL DEFAULT '0',
  `expand` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_host`,`id_account`,`id_keyring`,`id_key`),
  KEY `id_key` (`id_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hak`
--

LOCK TABLES `hak` WRITE;
/*!40000 ALTER TABLE `hak` DISABLE KEYS */;
/*!40000 ALTER TABLE `hak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts`
--

DROP TABLE IF EXISTS `hosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `TypeOfHost` enum('Instance','Physique','Host','N/D') NOT NULL DEFAULT 'N/D',
  `FrameName` varchar(100) NOT NULL DEFAULT 'N/A',
  `NumberOfVM` char(3) NOT NULL DEFAULT 'N/A',
  `Goal` varchar(100) NOT NULL DEFAULT '---',
  `FinSousCategorie` varchar(100) NOT NULL,
  `ClasseService` varchar(20) NOT NULL,
  `ostype` varchar(20) NOT NULL DEFAULT 'Unix',
  `Environment` varchar(40) NOT NULL DEFAULT 'N/D',
  `Entity` varchar(40) NOT NULL DEFAULT 'N/D',
  `TypeOfHosting` enum('Hebergement','Distribue') NOT NULL DEFAULT 'Hebergement',
  `BuyOrLease` varchar(40) NOT NULL DEFAULT '',
  `DateIntro` date NOT NULL,
  `CTIName` varchar(40) NOT NULL DEFAULT '',
  `TownName` varchar(40) NOT NULL DEFAULT '',
  `vendor` varchar(40) NOT NULL,
  `model` varchar(40) NOT NULL,
  `osvers` varchar(60) NOT NULL,
  `NumberCPUPhys` int(11) NOT NULL DEFAULT '0',
  `NumberCPUVirt` int(11) NOT NULL DEFAULT '0',
  `CPUSpeed` int(11) NOT NULL DEFAULT '0',
  `Memory` int(11) NOT NULL DEFAULT '0',
  `DASD` varchar(20) NOT NULL DEFAULT '0',
  `MonthlyUsage` int(11) NOT NULL DEFAULT '0',
  `PeekMonthly` int(11) NOT NULL DEFAULT '0',
  `serialno` varchar(255) NOT NULL,
  `SanOr` varchar(100) NOT NULL DEFAULT 'N/A',
  `SanArgent` varchar(100) NOT NULL DEFAULT 'N/A',
  `SanBronze` varchar(100) NOT NULL DEFAULT 'N/A',
  `DateDecom` date DEFAULT NULL,
  `MAJ` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Comments` varchar(255) NOT NULL DEFAULT '',
  `Releve` varchar(20) NOT NULL,
  `TypeOfCluster` varchar(20) NOT NULL,
  `ConsoService` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=744 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts`
--

LOCK TABLES `hosts` WRITE;
/*!40000 ALTER TABLE `hosts` DISABLE KEYS */;
/*!40000 ALTER TABLE `hosts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts-accounts`
--

DROP TABLE IF EXISTS `hosts-accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts-accounts` (
  `id_host` int(11) NOT NULL DEFAULT '0',
  `id_account` int(11) NOT NULL DEFAULT '0',
  `expand` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_host`,`id_account`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts-accounts`
--

LOCK TABLES `hosts-accounts` WRITE;
/*!40000 ALTER TABLE `hosts-accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `hosts-accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts-groups`
--

DROP TABLE IF EXISTS `hosts-groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts-groups` (
  `id_host` int(11) NOT NULL DEFAULT '0',
  `id_group` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_host`,`id_group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts-groups`
--

LOCK TABLES `hosts-groups` WRITE;
/*!40000 ALTER TABLE `hosts-groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `hosts-groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts-identities`
--

DROP TABLE IF EXISTS `hosts-identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts-identities` (
  `id_host` bigint(20) unsigned NOT NULL,
  `id_identities` int(20) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_identities` (`id_identities`,`id_host`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts-identities`
--

LOCK TABLES `hosts-identities` WRITE;
/*!40000 ALTER TABLE `hosts-identities` DISABLE KEYS */;
/*!40000 ALTER TABLE `hosts-identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hosts-tags`
--

DROP TABLE IF EXISTS `hosts-tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hosts-tags` (
  `id-hosts` int(11) NOT NULL,
  `id-tags` int(11) NOT NULL,
  PRIMARY KEY (`id-hosts`,`id-tags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hosts-tags`
--

LOCK TABLES `hosts-tags` WRITE;
/*!40000 ALTER TABLE `hosts-tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `hosts-tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identities`
--

DROP TABLE IF EXISTS `identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `identities` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `identity_file` blob NOT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identities`
--

LOCK TABLES `identities` WRITE;
/*!40000 ALTER TABLE `identities` DISABLE KEYS */;
/*!40000 ALTER TABLE `identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keyrings`
--

DROP TABLE IF EXISTS `keyrings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keyrings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `expand` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keyrings`
--

LOCK TABLES `keyrings` WRITE;
/*!40000 ALTER TABLE `keyrings` DISABLE KEYS */;
/*!40000 ALTER TABLE `keyrings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keyrings-keys`
--

DROP TABLE IF EXISTS `keyrings-keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keyrings-keys` (
  `id_keyring` int(11) NOT NULL DEFAULT '0',
  `id_key` int(11) NOT NULL DEFAULT '0',
  `expand` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_keyring`,`id_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keyrings-keys`
--

LOCK TABLES `keyrings-keys` WRITE;
/*!40000 ALTER TABLE `keyrings-keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `keyrings-keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `key` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=443 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keys`
--

LOCK TABLES `keys` WRITE;
/*!40000 ALTER TABLE `keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security`
--

DROP TABLE IF EXISTS `security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security`
--

LOCK TABLES `security` WRITE;
/*!40000 ALTER TABLE `security` DISABLE KEYS */;
/*!40000 ALTER TABLE `security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skmadmins`
--

DROP TABLE IF EXISTS `skmadmins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skmadmins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skmadmins`
--

LOCK TABLES `skmadmins` WRITE;
/*!40000 ALTER TABLE `skmadmins` DISABLE KEYS */;
INSERT INTO `skmadmins` VALUES (16,'skm','Admin','skmadmin','613ca542ca40bb0759eefb04b5a96e1a');
/*!40000 ALTER TABLE `skmadmins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-24 23:52:24
