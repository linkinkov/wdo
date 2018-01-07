-- MySQL dump 10.16  Distrib 10.2.9-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: wdo
-- ------------------------------------------------------
-- Server version	10.2.9-MariaDB

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
-- Table structure for table `adv`
--

DROP TABLE IF EXISTS `adv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adv` (
  `adv_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `descr` varchar(40) NOT NULL,
  `portfolio_id` int(11) NOT NULL,
  `prolong_limit` int(11) NOT NULL,
  `prolong_days` smallint(5) NOT NULL,
  `created` int(10) NOT NULL,
  `modified` int(10) NOT NULL,
  `status_id` tinyint(3) NOT NULL,
  `last_prolong` int(10) NOT NULL,
  `accepted` int(10) NOT NULL,
  `hold_transaction_id` varchar(32) NOT NULL,
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adv`
--

LOCK TABLES `adv` WRITE;
/*!40000 ALTER TABLE `adv` DISABLE KEYS */;
/*!40000 ALTER TABLE `adv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adv_statuses`
--

DROP TABLE IF EXISTS `adv_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adv_statuses` (
  `status_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adv_statuses`
--

LOCK TABLES `adv_statuses` WRITE;
/*!40000 ALTER TABLE `adv_statuses` DISABLE KEYS */;
INSERT INTO `adv_statuses` VALUES (1,'Активные'),(2,'На модерации'),(3,'Черновики'),(4,'Архив'),(5,'Отклоненные');
/*!40000 ALTER TABLE `adv_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arbitrage`
--

DROP TABLE IF EXISTS `arbitrage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arbitrage` (
  `ticket_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `project_id` int(11) NOT NULL,
  `respond_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `descr` varchar(4096) CHARACTER SET utf8 NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT 1,
  `timestamp` int(10) NOT NULL,
  `timestamp_modified` int(10) DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arbitrage`
--

LOCK TABLES `arbitrage` WRITE;
/*!40000 ALTER TABLE `arbitrage` DISABLE KEYS */;
INSERT INTO `arbitrage` VALUES ('fc490ca45c00b1249bbe3554a4fdf6fb',6,5,2,'Полный отстой, верните средства',3,1514458067,1514477617);
/*!40000 ALTER TABLE `arbitrage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arbitrage_comments`
--

DROP TABLE IF EXISTS `arbitrage_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arbitrage_comments` (
  `comment_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `ticket_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `message` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` int(10) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arbitrage_comments`
--

LOCK TABLES `arbitrage_comments` WRITE;
/*!40000 ALTER TABLE `arbitrage_comments` DISABLE KEYS */;
INSERT INTO `arbitrage_comments` VALUES ('0a255209574d230cadf79e938141678e','fc490ca45c00b1249bbe3554a4fdf6fb','sssqwwq',1,1514476590),('1c481aa99d081c32182011a758f73d33','fc490ca45c00b1249bbe3554a4fdf6fb','Исполнитель не выходит на связь в течении недели',1,1514425110),('27d023aea58df842a769f69d0f92661c','fc490ca45c00b1249bbe3554a4fdf6fb','sss',1,1514476681),('7d6ebff162ecab2b9a467df2400a95e4','fc490ca45c00b1249bbe3554a4fdf6fb','qwe',1,1514477617),('8e347f9c0396cf3c5a5c0ec91b809690','fc490ca45c00b1249bbe3554a4fdf6fb','ssss',1,1514476604),('97412b9282e636c76b0559c002f183c3','fc490ca45c00b1249bbe3554a4fdf6fb','asd',1,1514476476),('cda44843ac60ea1f490f6863f10c4efd','fc490ca45c00b1249bbe3554a4fdf6fb','Начата проверка',1,1514172110),('cff337289e68f3861d04ea6acd4cfb30','fc490ca45c00b1249bbe3554a4fdf6fb','q',1,1514477552),('d165e1ffadb18967f93ca2664cd35e81','fc490ca45c00b1249bbe3554a4fdf6fb','www',1,1514476638),('f2b6a9b14a038b8d1100dcbddc2f820c','fc490ca45c00b1249bbe3554a4fdf6fb','assqw',1,1514476728);
/*!40000 ALTER TABLE `arbitrage_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arbitrage_statuses`
--

DROP TABLE IF EXISTS `arbitrage_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arbitrage_statuses` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arbitrage_statuses`
--

LOCK TABLES `arbitrage_statuses` WRITE;
/*!40000 ALTER TABLE `arbitrage_statuses` DISABLE KEYS */;
INSERT INTO `arbitrage_statuses` VALUES (1,'Новый'),(2,'На рассмотрении'),(3,'Завершен');
/*!40000 ALTER TABLE `arbitrage_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attaches`
--

DROP TABLE IF EXISTS `attaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attaches` (
  `attach_id` varchar(32) NOT NULL,
  `attach_type` varchar(20) NOT NULL,
  `for_project_id` int(11) NOT NULL DEFAULT 0,
  `for_respond_id` int(11) NOT NULL DEFAULT 0,
  `for_portfolio_id` int(11) NOT NULL DEFAULT 0,
  `file_name` varchar(38) DEFAULT NULL,
  `file_title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`attach_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attaches`
--

LOCK TABLES `attaches` WRITE;
/*!40000 ALTER TABLE `attaches` DISABLE KEYS */;
INSERT INTO `attaches` VALUES ('0ad2434b2feca121bd46de2584bbee14','image',0,4,0,'3d13751509c932ea71fc43a01d614697.jpg','3.jpg',NULL,1514460013,25),('49e6a692adbf63499ea9fb5b739e3969','image',0,4,0,'dc9becdcfc33d4d069e89fe4910283c9.jpg','photo_2017-12-24_11-22-37.jpg',NULL,1514460013,25),('7e93b219f47c77bb7de3200581693cd7','image',0,1,0,'281183ab995569dbfb290919fcf62f5a.png','full.png',NULL,1514391721,3),('a15a549aaa13c215a0ad25ea05559202','image',8,0,0,'6a8cf6ede81cf26ee33815f102a709b2.jpg','photo_2017-12-24_11-43-11.jpg',NULL,1514535827,2),('f0cac5308be47d283a4c81b41aba8595','image',0,2,0,'1ae4b0a92b3856c60c59e1b666d1c89c.jpg','1.jpg',NULL,1514455457,3);
/*!40000 ALTER TABLE `attaches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES ('0e35088cce93094b296c472cf58d41bd','','https://weedo.ru/profile/id15#portfolio25','main_banners',1507633745,1),('a50109995c34e1c9b037eb6f12ccbd71','','https://weedo.ru/profile/id1#portfolio29','main_banners',1507633737,1);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cats`
--

DROP TABLE IF EXISTS `cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `translated` varchar(255) NOT NULL,
  `sort` smallint(5) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cats`
--

LOCK TABLES `cats` WRITE;
/*!40000 ALTER TABLE `cats` DISABLE KEYS */;
INSERT INTO `cats` VALUES (1,'Фото и видео','foto_i_video',3,0),(2,'Шоу-программа','shou-programma',2,0),(3,'Залы, рестораны','zaly,_restorany',5,0),(5,'Флористика','floristika',0,0),(6,'Одежда и аксессуары','odezhda_i_aksessuary',0,0),(7,'Красота','krasota',0,0),(8,'Транспорт','transport',0,0),(9,'Кухня','kuhnya',0,0);
/*!40000 ALTER TABLE `cats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Москва',1),(2,'Санкт-Петербург',1),(3,'Сочи',1),(4,'Новосибирск',1),(5,'Минск',2),(6,'Брест',2),(7,'Нижний-Новгород',1);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Россия'),(2,'Беларусь');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dialogs`
--

DROP TABLE IF EXISTS `dialogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dialogs` (
  `dialog_id` varchar(32) NOT NULL,
  `dialog_users` varchar(255) NOT NULL,
  `for_event_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`dialog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dialogs`
--

LOCK TABLES `dialogs` WRITE;
/*!40000 ALTER TABLE `dialogs` DISABLE KEYS */;
INSERT INTO `dialogs` VALUES ('a1e79f5ca7b33a14fd3f76e4fa3636a5','2,25',NULL);
/*!40000 ALTER TABLE `dialogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `username` varchar(255) NOT NULL,
  `time` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  KEY `username_login` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
INSERT INTO `login_attempts` VALUES ('admin@weedo.ru',1492265776,'127.0.0.1'),('admin@weedo.ru',1492265873,'127.0.0.1'),('admin@weedo.ru',1492265895,'127.0.0.1'),('admin@weedo.ru',1492265902,'127.0.0.1'),('admin@weedo.ru',1492265938,'127.0.0.1'),('admin@weedo.ru',1492265942,'127.0.0.1'),('admin@weedo.ru',1492265967,'127.0.0.1'),('admin@weedo.ru',1492266034,'127.0.0.1'),('admin@weedo.ru',1492266642,'127.0.0.1'),('admin@weedo.ru',1492266699,'127.0.0.1'),('admin@weedo.ru',1492266725,'127.0.0.1'),('admin@weedo.ru',1492266763,'127.0.0.1'),('admin@weedo.ru',1492274708,'127.0.0.1'),('admin@weedo.ru',1492274824,'127.0.0.1'),('admin@weedo.ru',1492274850,'127.0.0.1'),('admin@weedo.ru',1492274862,''),('admin@weedo.ru',1492274909,'127.0.0.1'),('admin@weedo.ru',1492275023,'127.0.0.1'),('admin@weedo.ru',1492275057,'127.0.0.1'),('admin@weedo.ru',1492276111,'127.0.0.1'),('admin@weedo.ru',1492276209,'127.0.0.1'),('admin@weedo.ru',1492276225,'127.0.0.1'),('admin@weedo.ru',1492295204,'127.0.0.1'),('admin@weedo.ru',1492295207,'127.0.0.1'),('admin@weedo.ru',1492295212,'127.0.0.1'),('admin@weedo.ru',1492295281,'127.0.0.1'),('admin@weedo.ru',1492295360,'127.0.0.1'),('admin@weedo.ru',1492295423,'127.0.0.1'),('admin@weedo.ru',1492295768,'127.0.0.1'),('admin@weedo.ru',1492295779,'127.0.0.1'),('admin@weedo.ru',1492295887,'127.0.0.1'),('admin@weedo.ru',1492448870,'127.0.0.1'),('admin@weedo.ru',1492448952,'127.0.0.1'),('admin@weedo.ru',1492543973,'127.0.0.1'),('admin@weedo.ru',1492543991,'127.0.0.1'),('admin@weedo.ru',1492544003,'127.0.0.1'),('admin@weedo.ru',1492544376,'127.0.0.1'),('admin@weedo.ru',1492544417,'127.0.0.1'),('demo',1492544485,'127.0.0.1'),('demo',1492544495,'127.0.0.1'),('demo',1492544560,'127.0.0.1'),('admin@weedo.ru',1492589386,'127.0.0.1'),('admin@weedo.ru',1492592296,'127.0.0.1'),('demo',1493035543,'127.0.0.1'),('demo',1493040247,'127.0.0.1'),('admin@weedo.ru',1493112480,'127.0.0.1'),('admin@weedo.ru',1493112972,'127.0.0.1'),('demo',1493113995,'127.0.0.1'),('demo',1493125409,'127.0.0.1'),('demo',1493126246,'127.0.0.1'),('manager',1493128466,'127.0.0.1'),('manager',1493128469,'127.0.0.1'),('manager',1493128472,'127.0.0.1'),('manager',1493128680,'127.0.0.1'),('demo',1493132994,'127.0.0.1'),('manager',1493134873,'127.0.0.1'),('demo',1493206793,'127.0.0.1'),('manager',1493224739,'127.0.0.1'),('demo',1493228001,'127.0.0.1'),('demo',1493228081,'127.0.0.1'),('demo',1493228106,'127.0.0.1'),('demo',1493228133,'127.0.0.1'),('demo',1493228164,'127.0.0.1'),('demo',1493228238,'127.0.0.1'),('admin@weedo.ru',1493228352,'127.0.0.1'),('demo',1493228417,'127.0.0.1'),('admin@weedo.ru',1493292417,'127.0.0.1'),('admin@weedo.ru',1493294151,'127.0.0.1'),('admin@weedo.ru',1493296784,'127.0.0.1'),('demo',1493381142,'127.0.0.1'),('demo',1493384772,'127.0.0.1'),('admin@weedo.ru',1493391694,'127.0.0.1'),('admin@weedo.ru',1493477371,'127.0.0.1'),('manager',1493480445,'127.0.0.1'),('admin@weedo.ru',1493539017,'127.0.0.1'),('demo',1493572081,'127.0.0.1'),('demo',1493572259,'127.0.0.1'),('admin@weedo.ru',1493717470,'127.0.0.1'),('demo',1493730517,'127.0.0.1'),('demo',1493735079,'127.0.0.1'),('admin@weedo.ru',1493736523,'127.0.0.1'),('manager',1493738479,'127.0.0.1'),('demo',1493828979,'127.0.0.1'),('admin@weedo.ru',1493880581,'127.0.0.1'),('manager',1493893103,'127.0.0.1'),('admin@weedo.ru',1493905679,'127.0.0.1'),('admin@weedo.ru',1493905705,'127.0.0.1'),('demo',1493905728,'127.0.0.1'),('demo',1494402033,'127.0.0.1'),('manager',1494402043,'127.0.0.1'),('demo',1494402126,'83.68.44.33'),('demo',1494410567,'83.68.44.33'),('demo',1494427267,'127.0.0.1'),('admin@weedo.ru',1494427276,'127.0.0.1'),('admin@weedo.ru',1494427551,'127.0.0.1'),('demo',1494427957,'127.0.0.1'),('admin@weedo.ru',1494582511,'127.0.0.1'),('demo',1494582564,'127.0.0.1'),('demo',1494592727,'127.0.0.1'),('demo',1494934854,'127.0.0.1'),('admin@weedo.ru',1495042605,'127.0.0.1'),('demo',1495098772,'127.0.0.1'),('demo',1495115418,'127.0.0.1'),('demo',1495116545,'127.0.0.1'),('demo',1495439296,'127.0.0.1'),('demo',1495472673,'127.0.0.1'),('admin@weedo.ru',1495539784,'127.0.0.1'),('manager',1495546996,'127.0.0.1'),('manager',1495547306,'127.0.0.1'),('admin@weedo.ru',1495615215,'127.0.0.1'),('demo',1495624389,'127.0.0.1'),('manager',1495624413,'127.0.0.1'),('admin@weedo.ru',1495630934,'127.0.0.1'),('admin@weedo.ru',1495799695,'127.0.0.1'),('admin@weedo.ru',1496048607,'127.0.0.1'),('demo',1496065858,'127.0.0.1'),('demo',1496078430,'127.0.0.1'),('admin@weedo.ru',1496134665,'127.0.0.1'),('admin@weedo.ru',1496134893,'127.0.0.1'),('admin@weedo.ru',1496136498,'127.0.0.1'),('demo',1496141129,'127.0.0.1'),('manager',1496141484,'127.0.0.1'),('manager',1496151654,'127.0.0.1'),('admin@weedo.ru',1496152426,'127.0.0.1'),('demo',1496238074,'83.68.44.33'),('admin@weedo.ru',1496238179,'127.0.0.1'),('demo',1496238491,'127.0.0.1'),('admin@weedo.ru',1496316567,'127.0.0.1'),('admin@weedo.ru',1496317212,'127.0.0.1'),('admin@weedo.ru',1496317444,'127.0.0.1'),('admin@weedo.ru',1496317497,'127.0.0.1'),('demo',1496317509,'127.0.0.1'),('demo',1496317536,'127.0.0.1'),('admin@weedo.ru',1496317553,'127.0.0.1'),('admin@weedo.ru',1496318232,'127.0.0.1'),('demo',1496319687,'127.0.0.1'),('demo',1496321140,'83.68.44.33'),('demo',1496321585,'83.68.44.33'),('manager',1496322686,'83.68.44.33'),('manager',1496323453,'127.0.0.1'),('demo',1496323646,'83.68.44.33'),('demo',1496325309,'83.68.44.33'),('manager',1496325734,'127.0.0.1'),('manager',1496330555,'127.0.0.1'),('demo',1496400121,'127.0.0.1'),('demo',1496407005,'83.68.44.33'),('admin@weedo.ru',1496409809,'127.0.0.1'),('admin@weedo.ru',1496594299,'::1'),('admin@weedo.ru',1496658501,'127.0.0.1'),('demo',1496659371,'127.0.0.1'),('admin@weedo.ru',1496677975,'127.0.0.1'),('admin@weedo.ru',1496678050,'127.0.0.1'),('demo',1496678888,'127.0.0.1'),('manager',1496678964,'127.0.0.1'),('admin@weedo.ru',1496679503,'127.0.0.1'),('admin@weedo.ru',1496680695,'127.0.0.1'),('admin@weedo.ru',1496680705,'127.0.0.1'),('admin@weedo.ru',1496680722,'127.0.0.1'),('admin@weedo.ru',1496767305,'127.0.0.1'),('admin@weedo.ru',1496767321,'127.0.0.1'),('admin@weedo.ru',1497000079,'127.0.0.1'),('admin@weedo.ru',1497456523,'127.0.0.1'),('admin@weedo.ru',1497456835,'127.0.0.1'),('admin@weedo.ru',1497456839,'127.0.0.1'),('admin@weedo.ru',1497515267,'127.0.0.1'),('admin@weedo.ru',1497515270,'127.0.0.1'),('admin@weedo.ru',1497515279,'127.0.0.1'),('admin@weedo.ru',1497515318,'127.0.0.1'),('admin@weedo.ru',1497515322,'127.0.0.1'),('admin@weedo.ru',1497515339,'127.0.0.1'),('admin@weedo.ru',1497516154,'127.0.0.1'),('admin@weedo.ru',1497599099,'127.0.0.1'),('teterin@simicon.com',1497885628,'127.0.0.1'),('teterin@simicon.com',1497885649,'127.0.0.1'),('roundcubez@gmail.com',1497885652,'127.0.0.1'),('teterin@simicon.com',1497886234,'127.0.0.1'),('teterin@simicon.com',1497886568,'127.0.0.1'),('teterin@simicon.com',1497886621,'127.0.0.1'),('teterin@simicon.com',1497886657,'127.0.0.1'),('teterin@simicon.com',1497886880,'127.0.0.1'),('teterin@simicon.com',1497886885,'127.0.0.1'),('teterin@simicon.com',1497887150,'127.0.0.1'),('teterin@simicon.com',1497887490,'127.0.0.1'),('teterin@simicon.com',1497887692,'127.0.0.1'),('teterin@simicon.com',1497951163,'127.0.0.1'),('admin@weedo.ru',1497952992,'127.0.0.1'),('admin@weedo.ru',1498031731,'127.0.0.1'),('admin@weedo.ru',1498031946,'127.0.0.1'),('admin@weedo.ru',1498032094,'127.0.0.1'),('admin@weedo.ru',1498034264,'127.0.0.1'),('admin@weedo.ru',1498034364,'127.0.0.1'),('admin@weedo.ru',1498034435,'127.0.0.1'),('admin@weedo.ru',1498035215,'127.0.0.1'),('admin@weedo.ru',1498035277,'127.0.0.1'),('admin@weedo.ru',1498035481,'127.0.0.1'),('admin@weedo.ru',1498035522,'127.0.0.1'),('admin@weedo.ru',1498045244,'127.0.0.1'),('admin@weedo.ru',1498045255,'127.0.0.1'),('admin@weedo.ru',1498045298,'127.0.0.1'),('admin@weedo.ru',1498045310,'127.0.0.1'),('admin@weedo.ru',1498045365,'127.0.0.1'),('admin@weedo.ru',1498045388,'127.0.0.1'),('admin@weedo.ru',1498045412,'127.0.0.1'),('manager@weedo.ru',1498047701,'127.0.0.1'),('admin@weedo.ru',1500283177,'127.0.0.1'),('admin@weedo.ru',1500369922,'127.0.0.1'),('admin@weedo.ru',1500467278,'127.0.0.1'),('manager@weedo.ru',1500467644,'127.0.0.1'),('jev.chern@gmail.com',1500473685,'83.68.44.33'),('jev.chern@gmail.com',1500557425,'83.68.44.33'),('manager@weedo.ru',1500558090,'127.0.0.1'),('manager@weedo.ru',1500651589,'127.0.0.1'),('admin@weedo.ru',1500653837,'127.0.0.1'),('admin@weedo.ru',1500887380,'127.0.0.1'),('manager@weedo.ru',1500887428,'127.0.0.1'),('admin@weedo.ru',1501083774,'127.0.0.1'),('admin@weedo.ru',1501154581,'85.143.184.138'),('admin@weedo.ru',1501248294,'127.0.0.1'),('admin@weedo.ru',1501690297,'127.0.0.1'),('admin@weedo.ru',1501690302,'127.0.0.1'),('admin@weedo.ru',1502284347,'127.0.0.1'),('admin@weedo.ru',1503067089,'127.0.0.1'),('admin@weedo.ru',1503130087,'::1'),('admin@weedo.ru',1503333491,'127.0.0.1'),('admin@weedo.ru',1503913617,'127.0.0.1'),('jev.chern@gmail.com',1503920115,'83.68.44.33'),('jev.chern@gmail.com',1503920130,'83.68.44.33'),('jev.chern@gmail.com',1503921191,'83.68.44.33'),('jev.chern@gmail.com',1503921327,'83.68.44.33'),('jev.chern@gmail.com',1503921338,'83.68.44.33'),('jev.chern@gmail.com',1503921346,'83.68.44.33'),('admin@weedo.ru',1503922970,'127.0.0.1'),('jev.chern@gmail.com',1503923174,'83.68.44.33'),('jev.chern@gmail.com',1503923179,'83.68.44.33'),('jev.chern@gmail.com',1503923195,'83.68.44.33'),('admin@weedo.ru',1503923288,'127.0.0.1'),('jev.chern@gmail.com',1504011646,'83.68.44.33'),('admin@weedo.ru',1504011957,'127.0.0.1'),('admin@weedo.ru',1504015493,'127.0.0.1'),('jev.chern@gmail.com',1504080061,'83.68.44.33'),('admin@weedo.ru',1504082100,'127.0.0.1'),('jev.chern@gmail.com',1504182258,'83.68.44.33'),('jev.chern@gmail.com',1504182262,'83.68.44.33'),('admin@weedo.ru',1504183796,'127.0.0.1'),('jev.chern@gmail.com',1504184324,'83.68.44.33'),('jev.chern@gmail.com',1504255960,'83.68.44.33'),('admin@weedo.ru',1504264600,'127.0.0.1'),('jev.chern@gmail.com',1504513009,'83.68.44.33'),('admin@weedo.ru',1504515727,'193.169.110.85'),('admin@weedo.ru',1504516157,'127.0.0.1'),('admin@weedo.ru',1504533370,'127.0.0.1'),('jev.chern@gmail.com',1504535221,'83.68.44.33'),('admin@weedo.ru',1504535275,'127.0.0.1'),('admin@weedo.ru',1504620440,'85.143.184.138'),('jev.chern@gmail.com',1504698657,'83.68.44.33'),('jev.chern@gmail.com',1504705006,'83.68.44.33'),('jev.chern@gmail.com',1504705141,'83.68.44.33'),('admin@weedo.ru',1504706032,'85.143.184.138'),('info@mskiso.ru',1504708387,'83.68.44.33'),('info@mskiso.ru',1504710139,'83.68.44.33'),('info@mskiso.ru',1504725470,'188.243.176.12'),('jev.chern@gmail.com',1504786226,'83.68.44.33'),('evgenya.chern@yandex.ru',1504788601,'83.68.44.33'),('evgenya.chern@yandex.ru',1504793205,'83.68.44.33'),('info@mskiso.ru',1504794429,'83.68.44.33'),('jev.chern@gmail.com',1504795107,'83.68.44.33'),('jev.chern@gmail.com',1504795700,'83.68.44.33'),('jev.chern@gmail.com',1504873147,'83.68.44.33'),('jev.chern@gmail.com',1504873157,'83.68.44.33'),('jev.chern@gmail.com',1506936437,'83.68.44.33'),('jev.chern@gmail.com',1506936448,'83.68.44.33'),('jev.chern@gmail.com',1507114891,'83.68.44.33'),('info@kokoso.ru',1507202002,'83.68.44.33'),('manager@mskiso.ru',1507202761,'83.68.44.33'),('manager3@mskiso.ru',1507203262,'83.68.44.33'),('jev.chern@gmail.com',1507204415,'83.68.44.33'),('manager7@mskiso.ru',1507204589,'83.68.44.33'),('jev.chern@gmail.com',1507204703,'83.68.44.33'),('info@mskiso.ru',1507204785,'83.68.44.33'),('manager3@mskiso.ru',1507204834,'83.68.44.33'),('admin@weedo.ru',1507483914,'188.242.136.98'),('admin@weedo.ru',1507556702,'85.143.184.138'),('jev.chern@gmail.com',1507559349,'83.68.44.33'),('jev.chern@gmail.com',1507634466,'83.68.44.33'),('manager@mskiso.ru',1507634795,'83.68.44.33'),('admin@weedo.ru',1507650729,'85.143.184.138'),('admin@weedo.ru',1507821499,'85.143.184.138'),('jev.chern@gmail.com',1507891002,'83.68.44.33'),('admin@weedo.ru',1508331555,'85.143.184.138'),('admin@weedo.ru',1508408924,'85.143.184.138'),('admin@weedo.ru',1508509372,'85.143.184.138'),('jev.chern@gmail.com',1509018175,'83.68.44.33'),('admin@weedo.ru',1509109851,'85.143.184.138'),('jev.chern@gmail.com',1509364173,'83.68.44.33'),('jev.chern@gmail.com',1509369730,'83.68.44.33'),('jev.chern@gmail.com',1509369734,'83.68.44.33'),('jev.chern@gmail.com',1511769144,'83.68.44.33'),('admin@weedo.ru',1512052092,'85.143.184.138'),('admin@weedo.ru',1512407424,'::1'),('manager@weedo.ru',1512571975,'::1'),('demo@weedo.ru',1512656440,'::1'),('demo@weedo.ru',1512656442,'::1'),('manager@weedo.ru',1512656597,'::1'),('manager@weedo.ru',1512656606,'::1'),('manager@weedo.ru',1512987799,'::1'),('manager@weedo.ru',1513001771,'::1'),('admin@weedo.ru',1513424914,'::1'),('manager@weedo.ru',1513424966,'::1'),('demo@weedo.ru',1513425024,'::1'),('manager@weedo.ru',1513433179,'::1'),('manager@weedo.ru',1513433181,'::1'),('admin@weedo.ru',1513437714,'::1'),('manager@weedo.ru',1513437749,'::1'),('admin@weedo.ru',1513438370,'::1'),('admin@weedo.ru',1513601569,'::1'),('manager@weedo.ru',1513601582,'::1'),('manager@weedo.ru',1513779102,'::1'),('admin@weedo.ru',1513781995,'::1'),('manager@weedo.ru',1514104691,'::1'),('demo@weedo.ru',1514104704,'::1'),('admin@weedo.ru',1514104955,'::1'),('manager@weedo.ru',1514105464,'::1'),('admin@weedo.ru',1514122765,'::1'),('demo@weedo.ru',1514124130,'::1'),('demo@weedo.ru',1514284184,'::1'),('admin@weedo.ru',1514284453,'::1'),('admin@weedo.ru',1514368324,'::1'),('admin@weedo.ru',1514382340,'::1'),('manager@weedo.ru',1514382533,'::1'),('demo@weedo.ru',1514383934,'::1'),('admin@weedo.ru',1514455303,'::1'),('teterin@simicon.com',1514458744,'::1'),('demo@weedo.ru',1514461024,'::1'),('teterin@simicon.com',1514466308,'::1');
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` varchar(32) NOT NULL,
  `message_text` varchar(1024) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `dialog_id` varchar(32) NOT NULL,
  `user_id_from` int(11) NOT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES ('adb88e6a2a64ec36b1c7c44a196240cd','Привет! Приходи к 14:00 завтра',1514460924,'a1e79f5ca7b33a14fd3f76e4fa3636a5',2,1),('eb617d975f4d03d0e9d1c30488b529a6','Хорошо, буду вовремя!',1514460949,'a1e79f5ca7b33a14fd3f76e4fa3636a5',25,1);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolio` (
  `portfolio_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `descr` varchar(2048) NOT NULL,
  `created` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cover_id` varchar(32) NOT NULL,
  `views` int(11) NOT NULL,
  PRIMARY KEY (`portfolio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (8,3,7,'VIP Кинотеатр','ад',1495022219,3,'f42078f277d7033664a2510feb67f7bb',2),(9,2,4,'1','2',1495026432,3,'cab66418fd4716f078fde05783d1b143',2),(10,1,2,'2','qqq\n\n\nasd\nas\n\n\n\n\nqweq\nw',1495026547,3,'eb10f8d50367d114fa20587108e09423',2),(11,1,3,'3','q',1495026605,3,'2d581d7c2341e7a17f5dde1e4173f1e9',3),(12,2,4,'4','4',1495026619,3,'95a63ebbb5496117e031d2210bc050cf',3),(13,2,5,'5','5',1495026625,3,'',2),(14,2,6,'6','6',1495026632,3,'',1),(15,3,7,'7','7',1495026638,3,'',0),(16,3,8,'83','854',1495026644,3,'70af5806a42ba3da6751ca3ec66c8ced',5),(17,3,9,'9','9',1495026649,3,'',1),(18,3,10,'10','10',1495026656,3,'',0),(19,2,4,'11','11',1495026666,3,'',0),(20,2,6,'12','12',1495026672,3,'',2),(21,3,10,'Птички','Всякие разные',1495026681,3,'5428abcf36c423e5f8e3b2e763ccc4e2',5),(23,3,9,'Коттедж для вашего праздника','Смотрите сами!',1495625525,2,'6121ed8b8d9ad902b7e53b2343bcb6cf',5),(24,5,25,'букет невесты','стильные букеты по завышенным ценам',1504096400,15,'e890af5535213a06249e3ee0da170355',7),(25,5,25,'букет невесты 2','ещ дорогущие букеты',1504096702,15,'b0dde65b435554f3df061fcacc2eb592',14),(26,7,17,'укладка','укладка',1504790048,17,'',2),(27,6,13,'серженьки','Серьги ручной работы ',1507203023,20,'04eb9bc0d7a50a5ee5d58a685ccb4330',1),(28,9,21,'мороженое','жареное мороженое',1507203563,21,'6db1830526a8b2560baa978aef1cf8b8',1),(29,5,25,'Цветы для вас','Любые',1507635695,1,'e15635cd432fc72c313b653eb5847d14',1);
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `descr` varchar(2048) NOT NULL,
  `cost` mediumint(9) NOT NULL,
  `created` int(10) NOT NULL,
  `status_id` tinyint(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accept_till` int(10) NOT NULL,
  `start_date` int(10) NOT NULL,
  `end_date` int(10) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `safe_deal` tinyint(1) NOT NULL,
  `vip` tinyint(1) NOT NULL,
  `views` int(11) NOT NULL,
  `for_user_id` int(11) NOT NULL,
  `for_event_id` varchar(32) NOT NULL,
  `last_prolong` int(10) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (2,'a1','a1 100',100,1514391685,3,2,1514926800,1514996452,1514996452,1,1,2,1,0,3,0,'',0),(3,'a2','a2 150',150,1514455360,5,2,1515060141,1515060141,1515060141,2,4,2,1,1,1,0,'',0),(4,'a3','a3 140',140,1514455406,3,2,1515060185,1515060185,1515060185,2,6,2,1,1,2,0,'',0),(5,'a4','a4 120',120,1514456073,3,2,1515060856,1515060856,1515060856,2,5,2,1,0,4,0,'',0),(6,'a5','a5 50',50,1514464872,3,2,1515069650,1515069650,1515069650,2,4,2,1,0,4,0,'',0),(8,'a6','ddd',100,1514535827,1,2,1515140522,1515140522,1515140522,5,25,2,1,0,1,0,'',0);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_responds`
--

DROP TABLE IF EXISTS `project_responds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_responds` (
  `respond_id` int(11) NOT NULL AUTO_INCREMENT,
  `for_project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `descr` varchar(1024) NOT NULL,
  `cost` mediumint(9) NOT NULL,
  `status_id` tinyint(1) NOT NULL,
  `modify_timestamp` int(10) NOT NULL,
  PRIMARY KEY (`respond_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds`
--

LOCK TABLES `project_responds` WRITE;
/*!40000 ALTER TABLE `project_responds` DISABLE KEYS */;
INSERT INTO `project_responds` VALUES (1,2,3,1514391721,'Могу за 70 сделать!',70,5,1514392436),(2,4,3,1514455457,'заявка на а3 160руб',160,5,1514455494),(3,5,3,1514456111,'заявка на а4 120',120,1,1514461510),(4,5,25,1514460013,'Сделаю за 80 руб',80,5,1514460594),(5,6,3,1514464886,'30',30,4,1514466218);
/*!40000 ALTER TABLE `project_responds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_responds_statuses`
--

DROP TABLE IF EXISTS `project_responds_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_responds_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds_statuses`
--

LOCK TABLES `project_responds_statuses` WRITE;
/*!40000 ALTER TABLE `project_responds_statuses` DISABLE KEYS */;
INSERT INTO `project_responds_statuses` VALUES (1,'Опубликован'),(2,'Отказано автором проекта'),(3,'Выбран исполнителем'),(4,'Заблокирован'),(5,'Выполнен');
/*!40000 ALTER TABLE `project_responds_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_statuses`
--

DROP TABLE IF EXISTS `project_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_statuses` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_statuses`
--

LOCK TABLES `project_statuses` WRITE;
/*!40000 ALTER TABLE `project_statuses` DISABLE KEYS */;
INSERT INTO `project_statuses` VALUES (1,'Открыт'),(2,'В работе'),(3,'Выполнен'),(4,'Истёк'),(5,'Заблокирован'),(6,'На модерации');
/*!40000 ALTER TABLE `project_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scenario_templates`
--

DROP TABLE IF EXISTS `scenario_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scenario_templates` (
  `scenario_id` int(11) NOT NULL AUTO_INCREMENT,
  `scenario_name` varchar(255) NOT NULL,
  `scenario_subcats` varchar(255) NOT NULL,
  `sort` smallint(3) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`scenario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scenario_templates`
--

LOCK TABLES `scenario_templates` WRITE;
/*!40000 ALTER TABLE `scenario_templates` DISABLE KEYS */;
INSERT INTO `scenario_templates` VALUES (1,'Свадьба','1,13,8,17,5,15,16,2,4,11,6,14,3',0,0),(3,'День рождения','1,8,5,4',1,0),(5,'ULTIMATESHOW','1,3,10,5,2,4,6',0,0);
/*!40000 ALTER TABLE `scenario_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `param_name` varchar(50) NOT NULL,
  `param_value` int(11) NOT NULL,
  PRIMARY KEY (`param_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('adv_cost',90),('adv_promote_cost',110),('safe_deal_comission',10),('vip_cost',250);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcats`
--

DROP TABLE IF EXISTS `subcats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_cat_id` int(11) NOT NULL,
  `subcat_name` varchar(255) NOT NULL,
  `translated` varchar(255) NOT NULL,
  `sort` smallint(5) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcats`
--

LOCK TABLES `subcats` WRITE;
/*!40000 ALTER TABLE `subcats` DISABLE KEYS */;
INSERT INTO `subcats` VALUES (1,1,'Фотографы','fotografy',0,0),(2,1,'Видеографы','videografy',0,0),(3,1,'1111','fotobudki',0,1),(4,2,'Ведущие','veduschie',2,0),(5,2,'Музыканты','muzykanty',1,0),(6,2,'Артисты','artisty',0,0),(7,3,'Банкетные залы','banketnye_zaly',0,0),(8,3,'Рестораны','restorany',0,0),(9,3,'Коттеджи','kottedzhi',0,0),(10,3,'Теплоходы','teplohody',0,0),(12,6,'Свадебные салоны','svadebnye_salony',0,0),(13,6,'Украшения','ukrasheniya',0,0),(14,6,'Аксессуары','aksessuary',0,0),(15,7,'Маникюр','manikyur',0,0),(16,7,'Макияж','makiyazh',0,0),(17,7,'Прическа','pricheska',0,0),(18,8,'Автобусы','avtobusy',0,0),(19,8,'Лимузины','limuziny',0,0),(20,8,'Автомобили','avtomobili',0,0),(21,9,'Торты','torty',0,0),(22,9,'Кейтеринг','keytering',0,0),(23,6,'Карнавальные костюмы','karnavaljnye_kostyumy',0,0),(24,6,'Прокат','prokat',0,0),(25,5,'Букеты и оформление','bukety_i_oformlenie',0,0);
/*!40000 ALTER TABLE `subcats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_calendar`
--

DROP TABLE IF EXISTS `user_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `for_project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_calendar`
--

LOCK TABLES `user_calendar` WRITE;
/*!40000 ALTER TABLE `user_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_notes`
--

DROP TABLE IF EXISTS `user_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_notes` (
  `note_text` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `for_user_id` int(11) NOT NULL,
  `timestamp` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`for_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_notes`
--

LOCK TABLES `user_notes` WRITE;
/*!40000 ALTER TABLE `user_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_readed_log`
--

DROP TABLE IF EXISTS `user_readed_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_readed_log` (
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`type`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_readed_log`
--

LOCK TABLES `user_readed_log` WRITE;
/*!40000 ALTER TABLE `user_readed_log` DISABLE KEYS */;
INSERT INTO `user_readed_log` VALUES (1,'project_respond',5),(2,'project_respond',1),(2,'project_respond',2),(2,'project_respond',3),(2,'project_respond',4),(2,'project_respond',5),(2,'user_respond',1),(3,'project_respond',1),(3,'project_respond',2),(3,'project_respond',3),(3,'project_respond',4),(3,'user_respond',1),(3,'user_respond',2),(25,'project_respond',3),(25,'project_respond',4),(25,'project_respond',5),(25,'user_respond',3);
/*!40000 ALTER TABLE `user_readed_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_responds`
--

DROP TABLE IF EXISTS `user_responds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_responds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `descr` varchar(2048) NOT NULL,
  `created` int(10) NOT NULL,
  `grade` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_responds`
--

LOCK TABLES `user_responds` WRITE;
/*!40000 ALTER TABLE `user_responds` DISABLE KEYS */;
INSERT INTO `user_responds` VALUES (1,3,2,2,'111',1514392488,10),(2,3,4,2,'aga',1514456007,10),(3,25,5,2,'ваывавы',1514464291,8);
/*!40000 ALTER TABLE `user_responds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_scenarios`
--

DROP TABLE IF EXISTS `user_scenarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_scenarios` (
  `event_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `scenario_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `budget` mediumint(7) NOT NULL,
  `timestamp_start` int(10) NOT NULL,
  `timestamp_end` int(10) NOT NULL,
  `subcats` varchar(130) NOT NULL,
  `archive` tinyint(1) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_scenarios`
--

LOCK TABLES `user_scenarios` WRITE;
/*!40000 ALTER TABLE `user_scenarios` DISABLE KEYS */;
INSERT INTO `user_scenarios` VALUES ('5bdb695dc6e33841f616be6dfc5c3879',15,5,'Тест№10000',150000,1507728837,1507728837,'1,2,4,5,6,10',1),('72740b7664199f45d2cb59b0a7b816ca',16,3,'День рождения',60000,1511298000,1511384399,'1,4,5,8',0),('d39776f90252c5325a202dc8dc2cde9e',16,1,'Свадьба',120000,1513803600,1513976399,'1,2,4,5,6,8,11,15,17',0),('d52b85fbc44f177c819c539489a04f76',15,5,'Тест №100001',150000,1514581200,1514667599,'1,2,4,5,6,10',0);
/*!40000 ALTER TABLE `user_scenarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_statuses`
--

DROP TABLE IF EXISTS `user_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_statuses` (
  `status_id` smallint(1) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_statuses`
--

LOCK TABLES `user_statuses` WRITE;
/*!40000 ALTER TABLE `user_statuses` DISABLE KEYS */;
INSERT INTO `user_statuses` VALUES (1,'Активен'),(2,'Не активирован'),(3,'Заблокирован'),(4,'Удалён');
/*!40000 ALTER TABLE `user_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_templates`
--

DROP TABLE IF EXISTS `user_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_templates` (
  `template_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `templateName` varchar(255) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_templates`
--

LOCK TABLES `user_templates` WRITE;
/*!40000 ALTER TABLE `user_templates` DISABLE KEYS */;
INSERT INTO `user_templates` VALUES (1,'Общие'),(2,'Модератор');
/*!40000 ALTER TABLE `user_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_wallets`
--

DROP TABLE IF EXISTS `user_wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_wallets` (
  `wallet_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` mediumint(7) NOT NULL DEFAULT 0,
  PRIMARY KEY (`wallet_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_wallets`
--

LOCK TABLES `user_wallets` WRITE;
/*!40000 ALTER TABLE `user_wallets` DISABLE KEYS */;
INSERT INTO `user_wallets` VALUES ('17c03c1e79d2db017ea9f156230e43f6',15,0),('2c3722e3571dc3c7f45760cf94999ad9',17,0),('3541e16430b0dc449a3ceecb3fa5e122',22,0),('44e22e8b54546672144205bbefa8d58c',19,0),('4a049e3e38588d4c6692df204b8fb215',1,31),('57cb17194f4fb310043ccf6c946d916a',14,0),('69657e51bdc1543235f9bfd89f3a14e8',3,230),('7b385a53660e62b841295bff498012f6',13,0),('803d17f81cb5cb901de37788b77f5cc7',25,80),('84dc334e2367beffe5d6dfbc832f57ba',2,152),('95efe3906b6b47e67acb98aa895c759a',21,0),('a6d30552d02a32033b41bd338e9f2905',20,0),('eb8cd59184ce977e9cdc62a21e3b8419',16,0),('fefcaa60360f0125b80d0fcf2646ec57',8,0);
/*!40000 ALTER TABLE `user_wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_warnings`
--

DROP TABLE IF EXISTS `user_warnings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_warnings` (
  `warning_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_text` varchar(1024) NOT NULL,
  `created` int(10) NOT NULL,
  `for_user_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`warning_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_warnings`
--

LOCK TABLES `user_warnings` WRITE;
/*!40000 ALTER TABLE `user_warnings` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_warnings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `real_user_name` varchar(70) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `telegram` varchar(75) DEFAULT NULL,
  `city_id` int(4) NOT NULL DEFAULT 1,
  `country_id` int(11) NOT NULL DEFAULT 1,
  `registered` int(10) NOT NULL,
  `type_id` tinyint(1) NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `last_login` int(10) DEFAULT NULL,
  `as_performer` tinyint(1) NOT NULL DEFAULT 0,
  `status_id` smallint(1) NOT NULL,
  `template_id` smallint(5) NOT NULL DEFAULT 1,
  `rating` int(11) NOT NULL DEFAULT 0,
  `site` varchar(255) DEFAULT NULL,
  `gps` varchar(255) DEFAULT NULL,
  `gps_point` point DEFAULT NULL,
  `signature` varchar(140) DEFAULT NULL,
  `rezume` varchar(2048) DEFAULT NULL,
  `birthday` int(10) DEFAULT NULL,
  `rek_last_name` varchar(100) DEFAULT NULL,
  `rek_first_name` varchar(100) DEFAULT NULL,
  `rek_second_name` varchar(100) DEFAULT NULL,
  `rek_inn` varchar(32) DEFAULT NULL,
  `rek_ogrnip` varchar(32) DEFAULT NULL,
  `rek_ras_schet` varchar(32) DEFAULT NULL,
  `rek_kor_schet` varchar(32) DEFAULT NULL,
  `rek_bik` varchar(32) DEFAULT NULL,
  `ts_project_responds` int(10) DEFAULT NULL,
  `performer_service_cost` int(6) DEFAULT NULL,
  `performer_service_type` text DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'GUEST','0-','0-','','GUEST','','','','',0,0,1492371605,1,'::1',0,0,3,1,0,'','','','','',0,'','','','0','0','0','0','0',0,0,''),(1,'admin@weedo.ru','4052a28f3e6dd1985e5a914959366a7c2928c7f24b9eb2735d020bd318de7eaae0f361c3e970c993302a2592ffe4296ff0c4be937b8ac6a40c53a88ffc93f050','390e7342f25f7547ad72477ed1c6109b08d204057710fe8807e57096b33fd8e80f200d5464413b3a73c565aee5b0eac02563e313e734492b0268c90bc40489ed','WEEDO COMPANY Z','Тетерин','Евгений','WEEDO COMPANY','79312553075','t.me/e.teterin',2,1,1492271605,2,'::1',1514535712,1,1,2,0,'','59.9843134170805,30.20952701568604','\0\0\0\0\0\0\0��g���M@\0\0��5>@','Halliluyah!!!','ХЗ!',-178426800,'','','','','','','','',1503503305,600,'В часик'),(2,'manager@weedo.ru','c4e47d8a39278de06599df99e7858b58478dbcc6e5e62d29c594af5b7213ca88bbfd88c1dd7181f37cd4fe5c3293fc3bd04fbcb74bd44a27cf30376554639822','848bd526cde43789fec3e8e6987959a4a5db37becd8a17d07804386fb52a84ab5595b07f2d00dae3b854a9692055b17f9329093457105b5ed0887543626d54f7','Manager 1','Менеджер 1','','Manager Company','','',2,1,1492171605,2,'::1',1514535828,0,1,1,55,'','60.047146433033355,30.133438110351566','\0\0\0\0\0\0\0+\0��N@\0\0\0)\">@','','Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! ',511045200,'','','','','','','','',1496333789,0,''),(3,'demo@weedo.ru','2a04e3d3ff6353d201fd021ff9795b2a389de6ed973e40ce6357e669abd63b58b0f79482e58d0bfd2285bc6ecaba3c00c3169c53b6cc182331c5ff423c4cb282','e31c083c156a6014a56da3f6657a075ff39fefa38ab675e2c1593b724ac59d20c58c2f9840a8357b6e0df6c258f3ce8c0889099c3931b7b98eb933bc21a69b1f','Гранат и Компания!','Демо','','&lt;script&gt;alert(1)&lt;/script&gt;','','',2,1,1491971605,1,'::1',1514466301,1,1,1,20,'','59.96057488864537,30.370674133300785','','Лучшее световое шоу!','Лучшее световое шоу в России и странах СНГ!',580593600,'','','','','','','','',1496678955,0,''),(15,'jev.chern@gmail.com','c31f8225edbc213a2eb4cf89e9540c62e670f3cb7b17835a84e06ca80dffbc7c5ae3e887ff52b05b7b2fc7c4831f111580d60bc308d4e8377e93ba98c1deca04','696f39f8a3bd8c242f4fcd9c111f8768ccb454941902cdae3c1906fbcd2994c256fb5cbfe793e1d92bb21d3713b97f77a580b9d01241beffa5c57d99bb59a978','Женя','','','','','',2,1,1500473128,2,'83.68.44.33',1511769237,1,1,2,0,'','59.92750007133506,30.314712524414066','\0\0\0\0\0\0\0���R��M@\0\0\0�P>@','','тест тест тест',489873600,'','','','','','','','',1504102364,0,''),(16,'info@mskiso.ru','ed58e330db7c97502d51cad6ffd2f673c9bb9023d8c58646ab594a8f7f62ef4bc29fc61d4fad5ca726dbfecbfe3eb40fb199bf100e9e55c684f3ba73c693c4fe','0074385ee6e2c6c1267c851c1877903d39718e81dd80d6a6141fa2206e061446d19cc1e98f713279c9a4785bc44cffaa07d677ee7c5c2cf05f641b43ab32bed8','Анна Попова','','','','','',2,1,1504708313,1,'83.68.44.33',1507204806,0,1,1,0,'','','','','',632005200,'','','','','','','','',0,0,''),(17,'evgenya.chern@yandex.ru','57a5864a3d75a9732d77f7f26b282930906f11d4b0464a3de1ee6cf9b942c61fcd17584626528dbd974664e8a62287faf82658675fe1ea35f0fa4b19917cf22c','d3766f37bfcc56af03a2aefb9176bbfcf7f565c1110cce02fe114fcdb20d885b5ed04c97ff0aac57caba4d40ac93c580b137876be3bc25130bb4109fff673398','Евгения','','','','','',2,1,1504788569,2,'83.68.44.33',1504795363,1,1,1,0,'','59.934360698501514,30.358657836914066','\0\0\0\0\0\0\0�]�!��M@\0\0\0�[>@','','',412462800,'','','','','','','','',0,0,''),(19,'info@kokoso.ru','df1ac600dcca3b9d8a24fecc6ea868a648fcd6d04c449e6af71523b595b8a2a7318179974873d91f316380ff540e47949eee2bb8f716b3bc674a478d4c7660b8','607ebe9f2d90d22881690bf10261cfea66900f46f3253b081aee06432914065c5325a9811e34c848ea3dddc3f2a359f7484c7c32bcce69a3f8b944036b767107','info','','','','','',2,1,1507130198,1,'83.68.44.33',1507202171,0,1,1,0,'','','','','',0,'','','','','','','','',0,0,''),(20,'manager@mskiso.ru','5840b9f0f69c47be8abd3d31a365f290d61214c5033b646f3b096e92e8f5486f8c88231c14e776d647a64009d495739346df140e4d5e8ded058c5f14d97327b5','3476e9f4dfa21b706ecf17dd035d624cf0bbaeecfbde18f02bb6fc37b2995c2ffc3cebd53921fae8e6501bfa7b9885d28f3fe8b76c730345acc422df282e68a5','Vika','','','','','',2,1,1507202268,2,'83.68.44.33',1507638016,1,1,1,0,'','59.96238950144212 30.36291500553489','\0\0\0\0\0\0\0�ZE�/�M@\0p��\\>@','','',0,'','','','','','','','',0,0,''),(21,'manager3@mskiso.ru','c2ba0077b38f57255ba64a3a984ca3d786f521ced0ac467c3676ec54c25a36b4569c6c72abe15249d2529bf816eb295ee55e20e670286d493681bb25a940ce7c','97d92c7e33e86541e0d28e19c1b07e14917365bd97322b97f88574308666014bc396d0ac268f42dd5324bdfab7a8fe2b1e1f3a07acf91c81ab9284c12ae573a2','Katya','','','','','',2,1,1507202332,2,'83.68.44.33',1507204852,0,1,1,0,'','59.915100933921515,30.30400085030124','\0\0\0\0\0\0\0��\"�M@\0���M>@','','',0,'','','','','','','','',0,0,''),(22,'manager7@mskiso.ru','76e51ec415941d0fb58385de6b845cf8d901ca5cca7ebe4878f400975dd917c4cb1819014dc72a4472d353fcee9a9a1b3aca4d1eae98af83b798f335fe123459','ec6ef9335f3e2f89310e702c81ca96f1eeba3ab790cfd26aecb23736858a92fb519a641eee3c5879db8eb083b489eb1c10ccaec47d3c1e628d304e25118721ba','ОЛЕНЬ','','','','','',2,1,1507204523,2,'83.68.44.33',1507204668,0,1,1,0,'','','','','',0,'','','','','','','','',0,0,''),(25,'teterin@simicon.com','11f7334d98136f4e51e07e4a43c9e2d1a9a9e7dcf6a338392fafe45ecbdc76b87b7826d10004baffe2c9fc205c6c1d721990e1eae3b9feb08ecbeb3bb4cfa0d0','41c987ad1d0deb6a387e0571c02a76d438536718ee6250babd6d4747c5a9e441e5958607c232c447b6f4e1d8af6341c6a2356d70abfe0e7a624f43f181aa5b62','Eugeny',NULL,NULL,NULL,'','',2,1,1514458667,2,'::1',1514466339,1,1,1,8,'','',NULL,'','',0,'','','','','','','','',NULL,0,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_requests`
--

DROP TABLE IF EXISTS `wallet_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet_requests` (
  `request_id` varchar(32) NOT NULL,
  `wallet_id` varchar(32) NOT NULL,
  `amount` mediumint(7) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `processed` tinyint(1) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_requests`
--

LOCK TABLES `wallet_requests` WRITE;
/*!40000 ALTER TABLE `wallet_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet_transactions` (
  `transaction_id` varchar(32) NOT NULL,
  `reference_id` varchar(32) NOT NULL,
  `wallet_id` varchar(32) NOT NULL,
  `type` varchar(11) NOT NULL,
  `amount` mediumint(7) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `timestamp_modified` int(10) DEFAULT 0,
  `descr` varchar(255) NOT NULL,
  `for_project_id` int(11) NOT NULL,
  `for_adv_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
INSERT INTO `wallet_transactions` VALUES ('0452778dbc638155c9cd1deb089b1733','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',140,1514455406,1514456007,'Списание за безопасную сделку',4,''),('052f3f528ac51aeae7fb525479898f13','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',70,1514391685,1514392488,'Списание за безопасную сделку',2,''),('384150c4794b96b12c265f6b6dd51937','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',80,1514456073,1514464291,'Списание за безопасную сделку',5,''),('393d65c51477430052b50a362fa89e50','ee8548814c52d7383479446a78b179ba','84dc334e2367beffe5d6dfbc832f57ba','CANCEL',3,1514464872,1514483882,'Возврат за безопасную сделку (комиссия)',6,''),('3d2f31ea8375bb3164ed5d1dd98b0641','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','HOLD',100,1514535827,0,'Удержание за безопасную сделку',8,''),('415a4bdaf33746f1386c7895c5ccad8f','0452778dbc638155c9cd1deb089b1733','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',14,1514455406,1514456007,'Списание за безопасную сделку (комиссия)',4,''),('4ce9b2c177053298de382c83d08f74f2','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','CANCEL',250,1514455360,1514455374,'Возврат за платный проект',3,''),('5104d651a8dc90f20ab44576b1bc24c9','','84dc334e2367beffe5d6dfbc832f57ba','PAYMENT',500,1514391678,0,'Пополнение кошелька',0,''),('5164ff70e2628b6f70fa2d8b34d595c0','f5fd3e6ed7f3cfd82434b31e875a08c9','4a049e3e38588d4c6692df204b8fb215','PAYMENT',8,1514464291,0,'Удержание за безопасную сделку (комиссия)',5,''),('59ea6113893bdb64bcacc4f7b94f2bb1','0452778dbc638155c9cd1deb089b1733','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',2,1514455494,1514456007,'Списание сверх бюджета в проекте (комиссия)',4,''),('6d1b3de9f6156e49dd7ddc1a091f582e','7e0d9ec41837d25ae4a0fe50661f2169','4a049e3e38588d4c6692df204b8fb215','PAYMENT',7,1514392488,0,'Удержание за безопасную сделку (комиссия)',2,''),('73329c05e8a8baf9b14847486c9a49a8','','84dc334e2367beffe5d6dfbc832f57ba','PAYMENT',148,1514456047,0,'Пополнение кошелька',0,''),('7e0d9ec41837d25ae4a0fe50661f2169','052f3f528ac51aeae7fb525479898f13','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',7,1514391685,1514392488,'Списание за безопасную сделку (комиссия)',2,''),('89f606050ac1c39aec578720f1aa478e','0452778dbc638155c9cd1deb089b1733','69657e51bdc1543235f9bfd89f3a14e8','PAYMENT',160,1514456007,0,'Зачисление за исполненную заявку',4,''),('95482da0c9515931c4f1d0257f2ef6d4','384150c4794b96b12c265f6b6dd51937','803d17f81cb5cb901de37788b77f5cc7','PAYMENT',80,1514464291,0,'Зачисление за исполненную заявку',5,''),('95aec3a83d087ae40e00fa8136a01b70','415a4bdaf33746f1386c7895c5ccad8f','4a049e3e38588d4c6692df204b8fb215','PAYMENT',14,1514456007,0,'Удержание за безопасную сделку (комиссия)',4,''),('a4b516da640405bdd9c6f554e89baae0','','84dc334e2367beffe5d6dfbc832f57ba','PAYMENT',5,1514455487,0,'Пополнение кошелька',0,''),('abe76f1cbe9f186e1771a2e1aff5d9ab','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','CANCEL',150,1514455360,1514455374,'Возврат за безопасную сделку',3,''),('be5f0aec95189365df933eaf924a6982','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',250,1514455406,1514455420,'Списание за платный проект',4,''),('c868a8e952e701c6f0f0c9a9bbff9bc6','0452778dbc638155c9cd1deb089b1733','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',20,1514455494,1514456007,'Списание сверх бюджета в проекте',4,''),('d161ed7ee35c21a0f41d694dc51cb192','59ea6113893bdb64bcacc4f7b94f2bb1','4a049e3e38588d4c6692df204b8fb215','PAYMENT',2,1514456007,0,'Удержание сверх бюджета в проекте (комиссия)',4,''),('d9f4e1d05ce433ae94591e30cdb3500a','3d2f31ea8375bb3164ed5d1dd98b0641','84dc334e2367beffe5d6dfbc832f57ba','HOLD',10,1514535827,0,'Удержание за безопасную сделку (комиссия)',8,''),('e003ded02a4bc20be6b5cf9e1cfd3c22','052f3f528ac51aeae7fb525479898f13','69657e51bdc1543235f9bfd89f3a14e8','PAYMENT',70,1514392488,0,'Зачисление за исполненную заявку',2,''),('e2a4a2786a4474aefa3586902045486d','','84dc334e2367beffe5d6dfbc832f57ba','PAYMENT',200,1514535824,0,'Пополнение кошелька',0,''),('e2baa67e09eecee7f46f41513388ef6f','abe76f1cbe9f186e1771a2e1aff5d9ab','84dc334e2367beffe5d6dfbc832f57ba','CANCEL',15,1514455360,1514455374,'Возврат за безопасную сделку (комиссия)',3,''),('ee8548814c52d7383479446a78b179ba','5104d651a8dc90f20ab44576b1bc24c9','84dc334e2367beffe5d6dfbc832f57ba','CANCEL',30,1514464872,1514483882,'Возврат за безопасную сделку',6,''),('f5fd3e6ed7f3cfd82434b31e875a08c9','384150c4794b96b12c265f6b6dd51937','84dc334e2367beffe5d6dfbc832f57ba','WITHDRAWAL',8,1514456073,1514464291,'Списание за безопасную сделку (комиссия)',5,'');
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `update_transaction_modified` BEFORE UPDATE ON `wallet_transactions` FOR EACH ROW IF OLD.transaction_id = NEW.transaction_id THEN
	SET new.timestamp_modified = UNIX_TIMESTAMP();
END IF */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `warnings`
--

DROP TABLE IF EXISTS `warnings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warnings` (
  `warning_id` int(11) NOT NULL AUTO_INCREMENT,
  `for_project_id` int(11) NOT NULL,
  `for_respond_id` int(11) NOT NULL,
  `for_user_id` int(11) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` int(10) NOT NULL,
  PRIMARY KEY (`warning_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warnings`
--

LOCK TABLES `warnings` WRITE;
/*!40000 ALTER TABLE `warnings` DISABLE KEYS */;
/*!40000 ALTER TABLE `warnings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-07 18:23:13
