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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds`
--

LOCK TABLES `project_responds` WRITE;
/*!40000 ALTER TABLE `project_responds` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_responds`
--

LOCK TABLES `user_responds` WRITE;
/*!40000 ALTER TABLE `user_responds` DISABLE KEYS */;
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
INSERT INTO `user_wallets` VALUES ('17c03c1e79d2db017ea9f156230e43f6',15,0),('2c3722e3571dc3c7f45760cf94999ad9',17,0),('3541e16430b0dc449a3ceecb3fa5e122',22,0),('44e22e8b54546672144205bbefa8d58c',19,0),('4a049e3e38588d4c6692df204b8fb215',1,0),('57cb17194f4fb310043ccf6c946d916a',14,0),('69657e51bdc1543235f9bfd89f3a14e8',3,0),('7b385a53660e62b841295bff498012f6',13,0),('803d17f81cb5cb901de37788b77f5cc7',25,0),('84dc334e2367beffe5d6dfbc832f57ba',2,0),('95efe3906b6b47e67acb98aa895c759a',21,0),('a6d30552d02a32033b41bd338e9f2905',20,0),('eb8cd59184ce977e9cdc62a21e3b8419',16,0),('fefcaa60360f0125b80d0fcf2646ec57',8,0);
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
INSERT INTO `users` VALUES (0,'GUEST','0-','0-','','GUEST','','','','',0,0,1492371605,1,'::1',0,0,3,1,0,'','','','','',0,'','','','0','0','0','0','0',0,0,''),(1,'admin@weedo.ru','4052a28f3e6dd1985e5a914959366a7c2928c7f24b9eb2735d020bd318de7eaae0f361c3e970c993302a2592ffe4296ff0c4be937b8ac6a40c53a88ffc93f050','390e7342f25f7547ad72477ed1c6109b08d204057710fe8807e57096b33fd8e80f200d5464413b3a73c565aee5b0eac02563e313e734492b0268c90bc40489ed','WEEDO COMPANY Z','Тетерин','Евгений','WEEDO COMPANY','79312553075','t.me/e.teterin',2,1,1492271605,2,'::1',1516107134,1,1,2,0,'','59.9843134170805,30.20952701568604','\0\0\0\0\0\0\0��g���M@\0\0��5>@','Halliluyah!!!','ХЗ!',-178426800,'','','','','','','','',1503503305,600,'В часик'),(2,'manager@weedo.ru','c4e47d8a39278de06599df99e7858b58478dbcc6e5e62d29c594af5b7213ca88bbfd88c1dd7181f37cd4fe5c3293fc3bd04fbcb74bd44a27cf30376554639822','848bd526cde43789fec3e8e6987959a4a5db37becd8a17d07804386fb52a84ab5595b07f2d00dae3b854a9692055b17f9329093457105b5ed0887543626d54f7','Manager 1','Менеджер 1','','Manager Company','','',2,1,1492171605,2,'::1',1516107102,1,1,1,55,'','60.047146433033355,30.133438110351566','\0\0\0\0\0\0\0+\0��N@\0\0\0)\">@','','Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! ',511045200,'','','','','','','','',1496333789,0,''),(3,'demo@weedo.ru','2a04e3d3ff6353d201fd021ff9795b2a389de6ed973e40ce6357e669abd63b58b0f79482e58d0bfd2285bc6ecaba3c00c3169c53b6cc182331c5ff423c4cb282','e31c083c156a6014a56da3f6657a075ff39fefa38ab675e2c1593b724ac59d20c58c2f9840a8357b6e0df6c258f3ce8c0889099c3931b7b98eb933bc21a69b1f','Гранат и Компания!','Демо','','&lt;script&gt;alert(1)&lt;/script&gt;','','',2,1,1491971605,1,'::1',1516107149,1,1,1,20,'','59.96057488864537,30.370674133300785','','Лучшее световое шоу!','Лучшее световое шоу в России и странах СНГ!',580593600,'','','','','','','','',1496678955,0,''),(15,'jev.chern@gmail.com','c31f8225edbc213a2eb4cf89e9540c62e670f3cb7b17835a84e06ca80dffbc7c5ae3e887ff52b05b7b2fc7c4831f111580d60bc308d4e8377e93ba98c1deca04','696f39f8a3bd8c242f4fcd9c111f8768ccb454941902cdae3c1906fbcd2994c256fb5cbfe793e1d92bb21d3713b97f77a580b9d01241beffa5c57d99bb59a978','Женя','','','','','',2,1,1500473128,2,'83.68.44.33',1511769237,1,1,2,0,'','59.92750007133506,30.314712524414066','\0\0\0\0\0\0\0���R��M@\0\0\0�P>@','','тест тест тест',489873600,'','','','','','','','',1504102364,0,''),(16,'info@mskiso.ru','ed58e330db7c97502d51cad6ffd2f673c9bb9023d8c58646ab594a8f7f62ef4bc29fc61d4fad5ca726dbfecbfe3eb40fb199bf100e9e55c684f3ba73c693c4fe','0074385ee6e2c6c1267c851c1877903d39718e81dd80d6a6141fa2206e061446d19cc1e98f713279c9a4785bc44cffaa07d677ee7c5c2cf05f641b43ab32bed8','Анна Попова','','','','','',2,1,1504708313,1,'83.68.44.33',1507204806,0,1,1,0,'','','','','',632005200,'','','','','','','','',0,0,''),(17,'evgenya.chern@yandex.ru','57a5864a3d75a9732d77f7f26b282930906f11d4b0464a3de1ee6cf9b942c61fcd17584626528dbd974664e8a62287faf82658675fe1ea35f0fa4b19917cf22c','d3766f37bfcc56af03a2aefb9176bbfcf7f565c1110cce02fe114fcdb20d885b5ed04c97ff0aac57caba4d40ac93c580b137876be3bc25130bb4109fff673398','Евгения','','','','','',2,1,1504788569,2,'83.68.44.33',1504795363,1,1,1,0,'','59.934360698501514,30.358657836914066','\0\0\0\0\0\0\0�]�!��M@\0\0\0�[>@','','',412462800,'','','','','','','','',0,0,''),(19,'info@kokoso.ru','df1ac600dcca3b9d8a24fecc6ea868a648fcd6d04c449e6af71523b595b8a2a7318179974873d91f316380ff540e47949eee2bb8f716b3bc674a478d4c7660b8','607ebe9f2d90d22881690bf10261cfea66900f46f3253b081aee06432914065c5325a9811e34c848ea3dddc3f2a359f7484c7c32bcce69a3f8b944036b767107','info','','','','','',2,1,1507130198,1,'83.68.44.33',1507202171,0,1,1,0,'','','','','',0,'','','','','','','','',0,0,''),(20,'manager@mskiso.ru','5840b9f0f69c47be8abd3d31a365f290d61214c5033b646f3b096e92e8f5486f8c88231c14e776d647a64009d495739346df140e4d5e8ded058c5f14d97327b5','3476e9f4dfa21b706ecf17dd035d624cf0bbaeecfbde18f02bb6fc37b2995c2ffc3cebd53921fae8e6501bfa7b9885d28f3fe8b76c730345acc422df282e68a5','Vika','','','','','',2,1,1507202268,2,'83.68.44.33',1507638016,1,1,1,0,'','59.96238950144212 30.36291500553489','\0\0\0\0\0\0\0�ZE�/�M@\0p��\\>@','','',0,'','','','','','','','',0,0,''),(21,'manager3@mskiso.ru','c2ba0077b38f57255ba64a3a984ca3d786f521ced0ac467c3676ec54c25a36b4569c6c72abe15249d2529bf816eb295ee55e20e670286d493681bb25a940ce7c','97d92c7e33e86541e0d28e19c1b07e14917365bd97322b97f88574308666014bc396d0ac268f42dd5324bdfab7a8fe2b1e1f3a07acf91c81ab9284c12ae573a2','Katya','','','','','',2,1,1507202332,2,'83.68.44.33',1507204852,0,1,1,0,'','59.915100933921515,30.30400085030124','\0\0\0\0\0\0\0��\"�M@\0���M>@','','',0,'','','','','','','','',0,0,''),(22,'manager7@mskiso.ru','76e51ec415941d0fb58385de6b845cf8d901ca5cca7ebe4878f400975dd917c4cb1819014dc72a4472d353fcee9a9a1b3aca4d1eae98af83b798f335fe123459','ec6ef9335f3e2f89310e702c81ca96f1eeba3ab790cfd26aecb23736858a92fb519a641eee3c5879db8eb083b489eb1c10ccaec47d3c1e628d304e25118721ba','ОЛЕНЬ','','','','','',2,1,1507204523,2,'83.68.44.33',1507204668,0,1,1,0,'','','','','',0,'','','','','','','','',0,0,''),(25,'teterin@simicon.com','11f7334d98136f4e51e07e4a43c9e2d1a9a9e7dcf6a338392fafe45ecbdc76b87b7826d10004baffe2c9fc205c6c1d721990e1eae3b9feb08ecbeb3bb4cfa0d0','41c987ad1d0deb6a387e0571c02a76d438536718ee6250babd6d4747c5a9e441e5958607c232c447b6f4e1d8af6341c6a2356d70abfe0e7a624f43f181aa5b62','Eugeny',NULL,NULL,NULL,'','',2,1,1514458667,2,'::1',1514466339,1,1,1,8,'','',NULL,'','',0,'','','','','','','','',NULL,0,'');
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

-- Dump completed on 2018-01-16 15:54:45
