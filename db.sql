-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

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
-- Table structure for table `cats`
--

DROP TABLE IF EXISTS `cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `transliterated` varchar(255) NOT NULL,
  `sort` smallint(5) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cats`
--

LOCK TABLES `cats` WRITE;
/*!40000 ALTER TABLE `cats` DISABLE KEYS */;
INSERT INTO `cats` VALUES (1,'Фото и видео','Foto_i_video',0,0),(2,'Шоу-программа','Shou-programma',0,0),(3,'Залы, рестораны','Zaly,_restorany',0,0);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Москва'),(2,'Санкт-Петербург'),(3,'Сочи'),(4,'Новосибирск');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
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
INSERT INTO `login_attempts` VALUES ('admin@weedo.ru',1492265776,'127.0.0.1'),('admin@weedo.ru',1492265873,'127.0.0.1'),('admin@weedo.ru',1492265895,'127.0.0.1'),('admin@weedo.ru',1492265902,'127.0.0.1'),('admin@weedo.ru',1492265938,'127.0.0.1'),('admin@weedo.ru',1492265942,'127.0.0.1'),('admin@weedo.ru',1492265967,'127.0.0.1'),('admin@weedo.ru',1492266034,'127.0.0.1'),('admin@weedo.ru',1492266642,'127.0.0.1'),('admin@weedo.ru',1492266699,'127.0.0.1'),('admin@weedo.ru',1492266725,'127.0.0.1'),('admin@weedo.ru',1492266763,'127.0.0.1'),('admin@weedo.ru',1492274708,'127.0.0.1'),('admin@weedo.ru',1492274824,'127.0.0.1'),('admin@weedo.ru',1492274850,'127.0.0.1'),('admin@weedo.ru',1492274862,''),('admin@weedo.ru',1492274909,'127.0.0.1'),('admin@weedo.ru',1492275023,'127.0.0.1'),('admin@weedo.ru',1492275057,'127.0.0.1'),('admin@weedo.ru',1492276111,'127.0.0.1'),('admin@weedo.ru',1492276209,'127.0.0.1'),('admin@weedo.ru',1492276225,'127.0.0.1'),('admin@weedo.ru',1492295204,'127.0.0.1'),('admin@weedo.ru',1492295207,'127.0.0.1'),('admin@weedo.ru',1492295212,'127.0.0.1'),('admin@weedo.ru',1492295281,'127.0.0.1'),('admin@weedo.ru',1492295360,'127.0.0.1'),('admin@weedo.ru',1492295423,'127.0.0.1'),('admin@weedo.ru',1492295768,'127.0.0.1'),('admin@weedo.ru',1492295779,'127.0.0.1'),('admin@weedo.ru',1492295887,'127.0.0.1');
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `cost` mediumint(9) NOT NULL,
  `created` int(10) NOT NULL,
  `status_id` tinyint(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` int(10) NOT NULL,
  `end_date` int(10) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `safe_deal` tinyint(1) NOT NULL,
  `vip` tinyint(1) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'test project','test project description',1507,1492098513,1,1,1492300000,1494819200,2,5,2,1,0),(2,'project 2','project 2 descr',3896,1492012113,1,1,1492098537,1492184943,1,3,2,0,0),(3,'project 3','project 3 descr',3315,1491925713,1,1,1492012125,1492012125,2,6,1,0,0),(4,'project 4','project 4 descr',556,1491839314,1,1,1491925742,1492012154,1,1,2,0,0),(5,'project 5','project 5 descr',1839,1491752914,1,1,1491839334,1491839334,2,6,2,0,0),(6,'project 6','project 6 descr',4087,1491666514,1,1,1491752944,1491839362,1,1,2,0,0),(7,'project 7','project 7 descr',4216,1491580114,1,1,1491666605,1491666605,1,2,2,0,0),(8,'project 8','project 8 descr',1272,1491493714,1,1,1491580162,1491666570,2,5,1,0,0),(9,'project 9','project 9 descr',4883,1491407314,1,1,1491493804,1491493804,2,5,2,0,0),(10,'project 10 AAAAAAAAAAAAAAAAAAAAAABBBBBBBBBBWWWWW]','project 10 descr',3456,1491320914,3,1,1491407344,1491493754,1,1,2,0,0),(11,'project 11','project 11 descr',3816,1491234514,1,1,1491321013,1491321013,1,3,2,0,0),(12,'project 12','project 12 descr',4328,1491148114,1,1,1491234610,1491321034,1,2,2,0,0),(13,'project 13','project 13 descr',3034,1491061714,1,1,1491148296,1491148296,2,5,2,0,0),(14,'project 14','project 14 descr',4816,1490975314,1,1,1491061854,1491148296,2,6,2,0,0),(15,'project 15','project 15 descr',820,1490888914,1,1,1490975479,1490975479,1,1,2,0,0),(16,'project 16','project 16 descr',3160,1490802514,1,1,1490888962,1490975378,2,6,2,0,0),(17,'project 17','project 17 descr',2312,1490716114,1,1,1490802684,1490802684,1,2,2,0,0),(18,'project 18','project 18 descr',1689,1490629714,1,1,1490716294,1490802748,1,3,2,0,0),(19,'project 19','project 19 descr',4133,1490543314,1,1,1490629771,1490629771,1,1,2,0,0),(20,'project 20','project 20 descr',648,1490456914,1,1,1490543454,1490629874,1,1,2,0,0),(21,'project 21','project 21 descr',2524,1490370514,1,1,1490457019,1490457019,1,2,2,0,0),(22,'project 22','project 22 descr',4984,1490284114,1,1,1490370668,1490457090,1,2,2,0,0),(23,'project 23','project 23 descr',2388,1490197714,1,1,1490284367,1490284367,2,5,2,0,0),(24,'project 24','project 24 descr',3319,1490189322,1,1,1490275986,1490362410,1,0,1,0,0),(25,'project 25','project 25 descr',4848,1490102922,1,1,1490189622,1490189622,1,0,3,0,0),(26,'project 26','project 26 descr',4037,1490016522,1,1,1490103052,1490103052,1,0,1,0,0),(27,'project 27','project 27 descr',4373,1489930122,1,1,1490016711,1490103138,1,0,3,0,0),(28,'project 28','project 28 descr',4689,1489843722,1,1,1489930234,1489930234,1,0,1,0,0),(29,'project 29','project 29 descr',3091,1489757322,1,1,1489843896,1489843896,2,0,1,0,0),(30,'project 30','project 30 descr',3121,1489670922,1,1,1489757562,1489844022,2,0,3,0,0),(31,'project 31','project 31 descr',2021,1489584522,1,1,1489671108,1489671108,2,0,2,0,0),(32,'project 32','project 32 descr',2636,1489498122,1,1,1489584906,1489584906,1,0,1,0,0),(33,'project 33','project 33 descr',2649,1489411722,1,1,1489498584,1489585017,1,0,1,0,0),(34,'project 34','project 34 descr',4649,1489325322,1,1,1489411926,1489411926,1,0,3,0,0),(35,'project 35','project 35 descr',2528,1489238922,1,1,1489325497,1489325497,2,0,3,0,0),(36,'project 36','project 36 descr',2346,1489152522,1,1,1489239174,1489325646,2,0,2,0,0),(37,'project 37','project 37 descr',2502,1489066122,1,1,1489153003,1489153003,1,0,1,0,0),(38,'project 38','project 38 descr',1546,1488979722,1,1,1489066502,1489066502,1,0,1,0,0),(39,'project 39','project 39 descr',4850,1488893322,1,1,1488980190,1489066707,2,0,1,0,0),(40,'project 40','project 40 descr',2179,1488806922,1,1,1488893442,1488893442,2,0,1,0,0),(41,'project 41','project 41 descr',1234,1488720522,1,1,1488807332,1488807332,2,0,2,0,0),(42,'project 42','project 42 descr',1933,1488634123,1,1,1488721111,1488807595,2,0,1,0,0),(43,'project 43','project 43 descr',4921,1488547723,1,1,1488634467,1488634467,1,0,2,0,0),(44,'project 44','project 44 descr',538,1488461323,1,1,1488548295,1488548295,1,0,2,0,0),(45,'project 45','project 45 descr',4457,1488374923,1,1,1488461683,1488548173,2,0,1,0,0),(46,'project 46','project 46 descr',4558,1488288523,1,1,1488375567,1488375567,1,0,1,0,0),(47,'project 47','project 47 descr',3496,1488202123,1,1,1488289087,1488289087,1,0,2,0,0),(48,'project 48','project 48 descr',766,1488115723,1,1,1488202411,1488288907,1,0,3,0,0),(49,'project 49','project 49 descr',2234,1488029323,1,1,1488116164,1488116164,1,0,2,0,0),(50,'project 50','project 50 descr',872,1487942923,1,1,1488029573,1488029573,2,0,3,0,0),(51,'project 51','project 51 descr',3108,1487856553,1,1,1487943565,1488030016,2,0,2,0,0),(52,'project 52','project 52 descr',541,1487770153,1,1,1487856917,1487856917,1,0,3,0,0),(53,'project 53','project 53 descr',3611,1487683753,1,1,1487770471,1487770471,1,0,2,0,0),(54,'project 54','project 54 descr',664,1487597353,1,1,1487684185,1487770693,2,0,2,0,0),(55,'project 55','project 55 descr',1176,1487510953,1,1,1487597738,1487597738,1,0,3,0,0),(56,'project 56','project 56 descr',568,1487424553,1,1,1487511289,1487511289,2,0,1,0,0),(57,'project 57','project 57 descr',1624,1487338153,1,1,1487424895,1487511352,2,0,1,0,0),(58,'project 58','project 58 descr',1883,1487251753,1,1,1487338849,1487338849,2,0,3,0,0),(59,'project 59','project 59 descr',533,1487165353,1,1,1487252579,1487252579,1,0,2,0,0),(60,'project 60','project 60 descr',3093,1487078953,1,1,1487166073,1487252533,2,0,1,0,0),(61,'project 61','project 61 descr',3239,1486992553,1,1,1487079441,1487079441,2,0,1,0,0),(62,'project 62','project 62 descr',4920,1486906153,1,1,1486992801,1486992801,1,0,1,0,0),(63,'project 63','project 63 descr',3911,1486819753,1,1,1486906657,1486993183,1,0,2,0,0),(64,'project 64','project 64 descr',2866,1486733353,1,1,1486820393,1486820393,1,0,3,0,0),(65,'project 65','project 65 descr',4314,1486646953,1,1,1486734003,1486734003,1,0,1,0,0),(66,'project 66','project 66 descr',2180,1486560553,1,1,1486647349,1486733881,2,0,2,0,0),(67,'project 67','project 67 descr',2273,1486474153,1,1,1486560888,1486560888,1,0,2,0,0),(68,'project 68','project 68 descr',2066,1486387753,1,1,1486474969,1486474969,2,0,2,0,0),(69,'project 69','project 69 descr',4499,1486301353,1,1,1486388581,1486475188,1,0,2,0,0),(70,'project 70','project 70 descr',1273,1486214953,1,1,1486302193,1486302193,1,0,3,0,0),(71,'project 71','project 71 descr',2373,1486128553,1,1,1486215663,1486215663,1,0,1,0,0),(72,'project 72','project 72 descr',1150,1486042154,1,1,1486129562,1486216178,1,0,2,0,0),(73,'project 73','project 73 descr',4096,1485955754,1,1,1486043030,1486043030,2,0,1,0,0),(74,'project 74','project 74 descr',2334,1485869354,1,1,1485955976,1485955976,1,0,3,0,0),(75,'project 75','project 75 descr',2259,1485782954,1,1,1485870254,1485956729,1,0,1,0,0),(76,'project 76','project 76 descr',1665,1485696554,1,1,1485783182,1485783182,1,0,3,0,0),(77,'project 77','project 77 descr',4375,1485610154,1,1,1485697324,1485697324,1,0,1,0,0),(78,'project 78','project 78 descr',1326,1485523754,1,1,1485611090,1485697646,2,0,2,0,0),(79,'project 79','project 79 descr',3862,1485437354,1,1,1485524228,1485524228,2,0,1,0,0),(80,'project 80','project 80 descr',1103,1485350954,1,1,1485438314,1485438314,1,0,1,0,0),(81,'project 81','project 81 descr',630,1485264554,1,1,1485351602,1485438083,2,0,2,0,0),(82,'project 82','project 82 descr',1356,1485178154,1,1,1485264964,1485264964,1,0,2,0,0),(83,'project 83','project 83 descr',1882,1485091754,1,1,1485178984,1485178984,1,0,1,0,0),(84,'project 84','project 84 descr',1551,1485005354,1,1,1485092258,1485178742,1,0,3,0,0),(85,'project 85','project 85 descr',3419,1484918954,1,1,1485006034,1485006034,2,0,1,0,0),(86,'project 86','project 86 descr',4950,1484832554,1,1,1484919814,1484919814,1,0,1,0,0),(87,'project 87','project 87 descr',4254,1484746154,1,1,1484833250,1484919737,2,0,1,0,0),(88,'project 88','project 88 descr',4126,1484659754,1,1,1484746682,1484746682,2,0,2,0,0),(89,'project 89','project 89 descr',1818,1484573354,1,1,1484660199,1484660199,1,0,3,0,0),(90,'project 90','project 90 descr',3170,1484486954,1,1,1484574434,1484661014,1,0,1,0,0),(91,'project 91','project 91 descr',2976,1484400554,1,1,1484487500,1484487500,1,0,1,0,0),(92,'project 92','project 92 descr',3191,1484314154,1,1,1484401566,1484401566,2,0,2,0,0),(93,'project 93','project 93 descr',3578,1484227754,1,1,1484314991,1484401577,1,0,1,0,0),(94,'project 94','project 94 descr',4639,1484141355,1,1,1484228413,1484228413,1,0,1,0,0),(95,'project 95','project 95 descr',3172,1484054955,1,1,1484141735,1484141735,1,0,3,0,0),(96,'project 96','project 96 descr',2318,1483968555,1,1,1484055627,1484142123,2,0,1,0,0),(97,'project 97','project 97 descr',2144,1483882155,1,1,1483969622,1483969622,1,0,2,0,0),(98,'project 98','project 98 descr',1773,1483795755,1,1,1483883429,1483883429,2,0,2,0,0),(99,'project 99','project 99 descr',763,1483709355,1,1,1483796349,1483883046,1,0,3,0,0),(100,'project 100','project 100 descr',3816,1483622955,1,1,1483709855,1483709855,2,0,3,0,0),(101,'project 101','project 101 descr',4039,1483536555,1,1,1483624167,1483624167,1,0,1,0,0),(102,'project 102','project 102 descr',3074,1483450155,1,1,1483537677,1483624179,1,0,3,0,0),(103,'project 103','project 103 descr',3524,1483363755,1,1,1483451597,1483451597,1,0,3,0,0),(104,'Фотограф на свадьбу','Должна быть просторная игровая комната, с отдельным залом для обеда, в игровой комнате должно быть все для развлечения детей',4984,1483277355,1,1,1492347581,1492347581,1,2,2,1,1),(105,'project 105','project 105 descr',4221,1483190955,1,1,1483278300,1483365015,1,0,3,0,0),(106,'project 106','project 106 descr',1776,1483104555,1,1,1483192333,1483192333,2,0,1,0,0),(107,'project 107','project 107 descr',3525,1483018155,1,1,1483105732,1483105732,1,0,3,0,0),(108,'project 108','project 108 descr',2206,1482931755,1,1,1483019667,1483106175,1,0,2,0,0),(109,'project 109','project 109 descr',4647,1482845355,1,1,1482932300,1482932300,1,0,3,0,0),(110,'project 110','project 110 descr',2693,1482758955,1,1,1482845685,1482845685,2,0,3,0,0),(111,'project 111','project 111 descr',3069,1482672555,1,1,1482759954,1482846687,2,0,1,0,0),(112,'project 112','project 112 descr',4139,1482586155,1,1,1482673339,1482673339,1,0,2,0,0),(113,'project 113','project 113 descr',1558,1482499755,1,1,1482586946,1482586946,1,0,1,0,0),(114,'project 114','project 114 descr',1822,1482413356,1,1,1482501238,1482587866,2,0,2,0,0),(115,'project 115','project 115 descr',1457,1482326956,1,1,1482414161,1482414161,2,0,3,0,0),(116,'project 116','project 116 descr',2569,1482240556,1,1,1482328232,1482328232,2,0,1,0,0),(117,'project 117','project 117 descr',1776,1482154156,1,1,1482241375,1482328126,2,0,1,0,0),(118,'project 118','project 118 descr',2177,1482067756,1,1,1482154864,1482154864,2,0,1,0,0),(119,'project 119','project 119 descr',1297,1481981356,1,1,1482069065,1482069065,2,0,2,0,0),(120,'project 120','project 120 descr',905,1481894956,1,1,1481982796,1482069556,2,0,2,0,0),(121,'project 121','project 121 descr',4606,1481808556,1,1,1481895561,1481895561,2,0,2,0,0),(122,'project 122','project 122 descr',3694,1481722156,1,1,1481810264,1481810264,2,0,3,0,0),(123,'project 123','project 123 descr',3661,1481635756,1,1,1481722771,1481809294,1,0,3,0,0),(124,'project 124','project 124 descr',2945,1481549356,1,1,1481637492,1481637492,2,0,2,0,0),(125,'project 125','project 125 descr',4650,1481462956,1,1,1481549981,1481549981,2,0,4,0,0),(126,'project 126','project 126 descr',2208,1481376556,1,1,1481464594,1481551120,2,0,4,0,0),(127,'project 127','project 127 descr',3465,1481290156,1,1,1481377953,1481377953,2,0,4,0,0),(128,'project 128','project 128 descr',3525,1481203756,1,1,1481291436,1481291436,1,0,2,0,0),(129,'project 129','project 129 descr',4995,1481117356,1,1,1481205562,1481292220,1,0,4,0,0),(130,'project 130','project 130 descr',1224,1481030956,1,1,1481119176,1481119176,2,0,4,0,0),(131,'project 131','project 131 descr',1233,1480944585,1,1,1481031640,1481031640,1,0,3,0,0),(132,'project 132','project 132 descr',1130,1480858185,1,1,1480944981,1481031513,2,0,2,0,0),(133,'project 133','project 133 descr',2483,1480771785,1,1,1480859382,1480859382,2,0,2,0,0),(134,'project 134','project 134 descr',3088,1480685385,1,1,1480773259,1480773259,2,0,1,0,0),(135,'project 135','project 135 descr',3932,1480598985,1,1,1480685925,1480772460,1,0,2,0,0),(136,'project 136','project 136 descr',1378,1480512585,1,1,1480599393,1480599393,1,0,2,0,0),(137,'project 137','project 137 descr',4021,1480426185,1,1,1480513270,1480513270,1,0,3,0,0),(138,'project 138','project 138 descr',3081,1480339786,1,1,1480426876,1480513690,2,0,4,0,0),(139,'project 139','project 139 descr',4358,1480253386,1,1,1480341593,1480341593,2,0,1,0,0),(140,'project 140','project 140 descr',792,1480166986,1,1,1480255346,1480255346,2,0,3,0,0),(141,'project 141','project 141 descr',2303,1480080586,1,1,1480167973,1480254655,1,0,4,0,0),(142,'project 142','project 142 descr',862,1479994186,1,1,1480081012,1480081012,2,0,2,0,0),(143,'project 143','project 143 descr',904,1479907786,1,1,1479994615,1479994615,1,0,2,0,0),(144,'project 144','project 144 descr',2582,1479821386,1,1,1479908506,1479995338,2,0,3,0,0),(145,'project 145','project 145 descr',1279,1479734986,1,1,1479823126,1479823126,1,0,4,0,0),(146,'project 146','project 146 descr',3164,1479648586,1,1,1479735862,1479735862,2,0,1,0,0),(147,'project 147','project 147 descr',2751,1479562186,1,1,1479650644,1479737338,1,0,2,0,0),(148,'project 148','project 148 descr',2783,1479475786,1,1,1479563666,1479563666,2,0,2,0,0),(149,'project 149','project 149 descr',983,1479389386,1,1,1479477872,1479477872,2,0,4,0,0),(150,'project 150','project 150 descr',2061,1479302986,1,1,1479390886,1479477736,1,0,3,0,0),(151,'project 151','project 151 descr',2818,1479216586,1,1,1479304949,1479304949,2,0,1,0,0),(152,'project 152','project 152 descr',3308,1479130186,1,1,1479218410,1479218410,2,0,1,0,0),(153,'project 153','project 153 descr',3908,1479043786,1,1,1479131410,1479218116,1,0,3,0,0),(154,'project 154','project 154 descr',4347,1478957386,1,1,1479045172,1479045172,2,0,1,0,0),(155,'project 155','project 155 descr',1046,1478870986,1,1,1478958161,1478958161,2,0,1,0,0),(156,'project 156','project 156 descr',3186,1478784587,1,1,1478873015,1478959883,2,0,1,0,0),(157,'project 157','project 157 descr',1988,1478698187,1,1,1478786314,1478786314,2,0,1,0,0),(158,'project 158','project 158 descr',3601,1478611787,1,1,1478699451,1478699451,2,0,2,0,0),(159,'project 159','project 159 descr',2737,1478525387,1,1,1478613377,1478700095,1,0,2,0,0),(160,'project 160','project 160 descr',4182,1478438987,1,1,1478527307,1478527307,1,0,2,0,0),(161,'project 161','project 161 descr',1949,1478352587,1,1,1478441080,1478441080,2,0,4,0,0),(162,'project 162','project 162 descr',514,1478266187,1,1,1478353235,1478439797,1,0,4,0,0),(163,'project 163','project 163 descr',3902,1478179787,1,1,1478267980,1478267980,1,0,4,0,0),(164,'project 164','project 164 descr',2990,1478093387,1,1,1478181099,1478181099,2,0,2,0,0),(165,'project 165','project 165 descr',2749,1478006987,1,1,1478094212,1478180942,2,0,2,0,0),(166,'project 166','project 166 descr',2381,1477920587,1,1,1478007485,1478007485,2,0,4,0,0),(167,'project 167','project 167 descr',3724,1477834187,1,1,1477921756,1477921756,2,0,3,0,0),(168,'project 168','project 168 descr',4272,1477747787,1,1,1477836371,1477923275,2,0,4,0,0),(169,'project 169','project 169 descr',3162,1477661387,1,1,1477750153,1477750153,2,0,2,0,0),(170,'project 170','project 170 descr',736,1477574987,1,1,1477663257,1477663257,1,0,1,0,0),(171,'project 171','project 171 descr',3176,1477488587,1,1,1477576697,1477663268,2,0,1,0,0),(172,'project 172','project 172 descr',908,1477402187,1,1,1477489791,1477489791,1,0,3,0,0),(173,'project 173','project 173 descr',4514,1477315787,1,1,1477403571,1477403571,2,0,2,0,0),(174,'project 174','project 174 descr',1322,1477229387,1,1,1477317005,1477403579,2,0,3,0,0),(175,'project 175','project 175 descr',3704,1477142987,1,1,1477230962,1477230962,2,0,3,0,0),(176,'project 176','project 176 descr',2134,1477056587,1,1,1477143867,1477143867,1,0,2,0,0),(177,'project 177','project 177 descr',3303,1476970187,1,1,1477058180,1477145111,1,0,3,0,0),(178,'project 178','project 178 descr',3572,1476883787,1,1,1476971255,1476971255,1,0,4,0,0),(179,'project 179','project 179 descr',2227,1476797387,1,1,1476885040,1476885040,1,0,2,0,0),(180,'project 180','project 180 descr',4639,1476710987,1,1,1476798107,1476884867,2,0,3,0,0),(181,'project 181','project 181 descr',539,1476624588,1,1,1476713341,1476713341,1,0,3,0,0),(182,'project 182','project 182 descr',4748,1476538188,1,1,1476625316,1476625316,1,0,3,0,0),(183,'project 183','project 183 descr',3557,1476451788,1,1,1476540018,1476626967,2,0,1,0,0),(184,'project 184','project 184 descr',2581,1476365388,1,1,1476453812,1476453812,1,0,1,0,0),(185,'project 185','project 185 descr',2067,1476278988,1,1,1476367423,1476367423,1,0,3,0,0),(186,'project 186','project 186 descr',2965,1476192588,1,1,1476281220,1476367806,2,0,3,0,0),(187,'project 187','project 187 descr',4537,1476106188,1,1,1476194832,1476194832,1,0,2,0,0),(188,'project 188','project 188 descr',2211,1476019788,1,1,1476106752,1476106752,1,0,4,0,0),(189,'project 189','project 189 descr',3914,1475933388,1,1,1476020922,1476107889,2,0,1,0,0),(190,'project 190','project 190 descr',3350,1475846988,1,1,1475935288,1475935288,2,0,4,0,0),(191,'project 191','project 191 descr',3059,1475760588,1,1,1475847752,1475847752,1,0,3,0,0),(192,'project 192','project 192 descr',1871,1475674188,1,1,1475762892,1475849676,1,0,3,0,0),(193,'project 193','project 193 descr',4496,1475587788,1,1,1475675925,1475675925,1,0,3,0,0),(194,'project 194','project 194 descr',3997,1475501388,1,1,1475588952,1475588952,1,0,4,0,0),(195,'project 195','project 195 descr',3788,1475414988,1,1,1475503728,1475590518,2,0,1,0,0),(196,'project 196','project 196 descr',3328,1475328588,1,1,1475416164,1475416164,2,0,3,0,0),(197,'project 197','project 197 descr',1277,1475242188,1,1,1475329573,1475329573,1,0,4,0,0),(198,'project 198','project 198 descr',546,1475155788,1,1,1475244564,1475331360,1,0,2,0,0),(199,'project 199','project 199 descr',2019,1475069388,1,1,1475156982,1475156982,2,0,1,0,0),(200,'project 200','project 200 descr',3556,1474982989,1,1,1475071389,1475071389,2,0,1,0,0);
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
  PRIMARY KEY (`respond_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds`
--

LOCK TABLES `project_responds` WRITE;
/*!40000 ALTER TABLE `project_responds` DISABLE KEYS */;
INSERT INTO `project_responds` VALUES (1,104,1,1492078859,'beri menya!',0,1),(2,104,1,1492178859,'sdelayu za 10',0,1);
/*!40000 ALTER TABLE `project_responds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_responds_statuses`
--

DROP TABLE IF EXISTS `project_responds_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_responds_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds_statuses`
--

LOCK TABLES `project_responds_statuses` WRITE;
/*!40000 ALTER TABLE `project_responds_statuses` DISABLE KEYS */;
INSERT INTO `project_responds_statuses` VALUES (1,'Опубликован'),(2,'Отказано пользователем'),(3,'Выбран исполнителем'),(4,'Заблокирован');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_statuses`
--

LOCK TABLES `project_statuses` WRITE;
/*!40000 ALTER TABLE `project_statuses` DISABLE KEYS */;
INSERT INTO `project_statuses` VALUES (1,'Открыт'),(2,'Завершен'),(3,'Заблокирован');
/*!40000 ALTER TABLE `project_statuses` ENABLE KEYS */;
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
  `transliterated` varchar(255) NOT NULL,
  `sort` smallint(5) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcats`
--

LOCK TABLES `subcats` WRITE;
/*!40000 ALTER TABLE `subcats` DISABLE KEYS */;
INSERT INTO `subcats` VALUES (1,1,'Фотографы','Fotografy',0,0),(2,1,'Видеографы','Videografy',0,0),(3,1,'Фотобудки','Fotobudki',0,0),(4,2,'Ведущие','Veduschie',0,0),(5,2,'Музыканты','Muzykanty',0,0),(6,2,'Артисты','Artisty',0,0),(7,3,'Банкетные залы','Banketnye_zaly',0,0),(8,3,'Рестораны','Restorany',0,0),(9,3,'Коттеджи','Kottedzhi',0,0),(10,3,'Теплоходы','Teplohody',0,0);
/*!40000 ALTER TABLE `subcats` ENABLE KEYS */;
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
INSERT INTO `user_responds` VALUES (1,1,104,3,'good user respond',1492359453,5),(2,1,104,3,'bad user respond',1492359453,4),(3,1,104,3,'good user respond 2',1492359476,8);
/*!40000 ALTER TABLE `user_responds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_statuses`
--

DROP TABLE IF EXISTS `user_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_statuses` (
  `state_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `stateName` varchar(255) NOT NULL,
  PRIMARY KEY (`state_id`)
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
INSERT INTO `user_templates` VALUES (1,'Общие'),(2,'Администратор');
/*!40000 ALTER TABLE `user_templates` ENABLE KEYS */;
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
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city_id` int(4) NOT NULL,
  `registered` int(10) NOT NULL,
  `type_id` tinyint(1) NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `last_login` int(10) NOT NULL,
  `as_performer` tinyint(1) NOT NULL,
  `state_id` smallint(5) NOT NULL,
  `template_id` smallint(5) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'GUEST','0-','0-','GUEST','','','',0,1492371605,1,'::1',0,0,3,1,0),(1,'admin@weedo.ru','4052a28f3e6dd1985e5a914959366a7c2928c7f24b9eb2735d020bd318de7eaae0f361c3e970c993302a2592ffe4296ff0c4be937b8ac6a40c53a88ffc93f050','390e7342f25f7547ad72477ed1c6109b08d204057710fe8807e57096b33fd8e80f200d5464413b3a73c565aee5b0eac02563e313e734492b0268c90bc40489ed','Директор','','WEEDO COMPANY','',0,1492271605,2,'127.0.0.1',1492346615,0,1,1,0),(2,'manager','0cd70e6f975a5b33c004c985bd54ee205ae4948bc5b5bf884fd7c00d05003a8ea282cef4de856774d6dfa4a624eb82688731a6b154f25f4bcf7aee134afe7208','85efddff8007206baa90b823d8f970aefbde37bb60d605ab9c6e925fea73d21bcdda2b9a77a995d689daa94bdd3654f3043c55c275e36800742c457f5f2ba707','Менеджер 1','','','',0,1492171605,1,'192.168.2.245',1491926934,0,1,1,0),(3,'demo','2a04e3d3ff6353d201fd021ff9795b2a389de6ed973e40ce6357e669abd63b58b0f79482e58d0bfd2285bc6ecaba3c00c3169c53b6cc182331c5ff423c4cb282','e31c083c156a6014a56da3f6657a075ff39fefa38ab675e2c1593b724ac59d20c58c2f9840a8357b6e0df6c258f3ce8c0889099c3931b7b98eb933bc21a69b1f','Демо','','OOO Гранат & Company & Friends','',0,1491971605,2,'192.168.2.245',1491829749,0,1,1,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-17  0:43:24
