-- MySQL dump 10.15  Distrib 10.0.27-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: wdo
-- ------------------------------------------------------
-- Server version	10.0.27-MariaDB-0+deb8u1

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
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adv`
--

LOCK TABLES `adv` WRITE;
/*!40000 ALTER TABLE `adv` DISABLE KEYS */;
INSERT INTO `adv` VALUES ('1d5cc43a17e24bb7e9c2ecc6082c8449',15,1,1,'Самый крутой фотограф!','Фотографирую фотографирую фотографирую',25,4,7,1504272565,1504272565,1,1504272565,1504273490),('40c75710f59cb7ff16cfe890f9db2f9d',1,5,25,'Букеты да','Самые свежие цветы',22,0,0,1503239552,1503239552,1,1503239552,1504611087),('438057a6c654a62df134b6590df872ba',1,8,20,'Автомобиль реклама','фывф',0,0,0,1504528305,1504528305,1,1504528305,1507126323),('4ade346485dde37ca96279e0a9861d69',1,1,2,'Самый лучший фотограф','Более 1000 работ!',0,2,6,1503231202,1503231202,1,1503231202,1504611090),('4e0c44f6643785bf022a3a538d4716aa',1,1,2,'idite naheeQQ','ya snimayuDDDD',0,1250,7,1503246627,1503246627,1,1503246627,1507123886),('ee600174cdb538be38a4598e897a5675',1,2,4,'Тестовое','Объявление для всех',22,250,30,1503231211,1503231211,1,1503231211,1507123881);
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
-- Table structure for table `attaches`
--

DROP TABLE IF EXISTS `attaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attaches` (
  `attach_id` varchar(32) NOT NULL,
  `attach_type` varchar(20) NOT NULL,
  `for_project_id` int(11) NOT NULL,
  `for_respond_id` int(11) NOT NULL,
  `for_portfolio_id` int(11) NOT NULL,
  `file_name` varchar(38) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
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
INSERT INTO `attaches` VALUES ('005fd490d0aedfda61b7cd107e36a7f8','image',0,0,24,'88e78601b78e5801021f79232ae8671a.jpeg','i8 (1).jpeg','',1504096400,15),('015dd6c9b6ff27a516bcee4cd5379d66','image',0,0,11,'20dbc795b892735f8910f87c79a091b5.jpeg','sea-bay-waterfront-beach-50594.jpeg','',1495026606,3),('04eb9bc0d7a50a5ee5d58a685ccb4330','image',0,0,27,'d0138240f89ecd66de7369d22c689f12.jpeg','4.jpeg','',1507203023,20),('07eba0014e77d499bef4dab647e866e0','image',0,0,9,'80c33a83fe62da6a2edd677113eb2110.jpg','pexels-photo (1).jpg','',1495026432,3),('0a3080ffb20ece4d5d7343613884e9fd','image',0,0,24,'5499f933f88ae5889ec0976f5d85c7fc.jpg','i5.jpg','',1504096400,15),('0c0a8e9d5478f744ea2537e0af7dce9c','image',0,0,26,'ca4f55591ca018b37772933ca28f53a3.jpeg','i21.jpeg','',1504790048,17),('0fb63097e1a6b5a5b3ad5f15fbcebe37','image',0,0,11,'57d78cc9142fc2be64f09c56e04a33fd.jpg','_89586487_istock_000063166549_medium.jpg','',1495026607,3),('10b743af457138bd9935092c1a0d876b','image',0,0,11,'388ed7b30950e4fea803565789c9112c.jpg','above-adventure-aerial-air.jpg','',1495026607,3),('12096b4edf112646924883b57550c906','image',0,0,9,'90aef3bae18288e51a829190d9682be7.jpg','potd-squirrel_3519920k.jpg','',1495026432,3),('1711826c74758e5434763abd0b4ee5f3','image',0,0,11,'e801e89c8d7582a05ad1af421e045e59.jpeg','pexels-photo-219833.jpeg','',1495026606,3),('1a54aea3024debe9fbb99a2ccb67b764','image',0,0,21,'e671a56186736de6d61cf9e937bc5f12.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495026723,3),('1e8ba4ff3e8d3a74a6c008e59a27f20d','image',0,0,24,'ca4d2f3017c90d09ddb2defa376ddc94.jpeg','i6.jpeg','',1504096400,15),('203de7e24e8e58825d197292043146a9','image',0,0,9,'f321b437f09cc6f39629f072be9eda3d.jpeg','horsehead-nebula-dark-nebula-constellation-orion-87646.jpeg','',1495026432,3),('2066377e41fe45b1eba1f7a1464cc3e9','image',0,0,9,'340b6fc5db0de60ebcb2b8dd79d24f91.jpeg','dog-cavalier-king-charles-spaniel-funny-pet-162167.jpeg','',1495026433,3),('212df83218f15c2cc652ee29bdfa0f55','image',0,0,24,'2738f85449de39b2f5edbd65fa860647.jpeg','i4.jpeg','',1504096400,15),('236ca9b857cdd6d2e542b3875ec248fb','image',34,0,0,'94f1ddc47daaf4caf33fd6b9b4d2cf0d.png','about-master-chat.png','',1500468295,2),('277d1a0539642d7cdb5fe9d3b0c2aa6f','image',34,0,0,'d2c95a4c9daa0e2823e9ce3337803138.png','about-safe-deal-icon.png','',1500468295,2),('2a25e39c63cae6571e1fbfab4392aa37','image',0,0,11,'f4141900baad12d5832a8ed02ad762f0.jpg','skyline-buildings-new-york-skyscrapers.jpg','',1495026606,3),('2d54a5f86c3bc341ccd62e158a0054c6','image',0,0,27,'de58aaca661d4468f141cb49ce81e211.jpeg','2.jpeg','',1507203023,20),('2d581d7c2341e7a17f5dde1e4173f1e9','image',0,0,11,'d0e6b3a8037ac46cfb06adbd2d657890.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495026606,3),('31229fef001ce02823d39d138b173cde','image',0,0,23,'5541a5ce4648e274ab9f23f3e9493ca0.jpg','pool-house.jpg','',1495625525,2),('33b081dbcb191b76d23fbd7d930b0907','image',0,0,24,'c03ab3b15808c718a3cbcf2f14a63dab.jpeg','i3.jpeg','',1504096400,15),('3510623c5b2a65105e2f36611963426e','image',35,0,0,'9ca13a3b3d2487a7c74e701a7aafbc3c.png','about-people.png','',1500469329,2),('36ae0e93b2653154de699c0cd4e63da4','image',0,0,11,'68c7ca63b8cd734aa448e4b7ff111b54.jpeg','pexels-photo-57812.jpeg','',1495026607,3),('3fa6ce53f2d7d5e34ac9a748965b1f94','image',0,0,25,'289b0fa31ad1d5055be449a32f277b6a.jpeg','i19.jpeg','',1504096702,15),('444b660b3edaf71923c8aee83a2a00d6','image',0,0,25,'e6e9964c57376fc90edbaf5c458b49dd.jpeg','i15.jpeg','',1504096702,15),('465fd37f0c16b1876e38028f1a59e128','video',0,0,10,'','','https://www.youtube.com/watch?v=qzMQza8xZCc',1495026547,3),('47f3c4e97a523f3188f0e5d38a4a69e6','document',35,0,0,'1d0bb4df1f6bfe76f3c2ef7f40836db9.pdf','example-abstract.pdf','',1500469329,2),('5428abcf36c423e5f8e3b2e763ccc4e2','image',0,0,21,'747389a2881cf9d6cd9b37ade7317d3f.jpg','birds.jpg','',1495039707,3),('5835c4b84e7d710a82a9d77f63fef99c','image',0,0,25,'03633d625c42365dde0c54c34c4ef49d.jpeg','i17.jpeg','',1504096702,15),('5a27fddb24d8b51c0cdcfae4e479ee9d','image',0,0,8,'3a26aa95594a3ea380167ab79fdfe48e.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495025792,3),('5b58e73a4d8f02e91df1d4487393b0c0','image',0,0,27,'f99c71f45bb9fecc88ccc44fd80bb74e.jpeg','3.jpeg','',1507203023,20),('60a3f83859e6ec65232d702cdc01d4a0','image',0,0,8,'2ecde21f78f1152cb256f97e2e7f25dc.jpeg','pexels-photo-57812.jpeg','',1495026323,3),('6121ed8b8d9ad902b7e53b2343bcb6cf','image',0,0,23,'a8134df344add8d4ce3574c85ca37d9e.jpg','foto-kottedzhej-s-bassejnom-11.jpg','',1495625525,2),('614055773cf5a880af45cb6732208d6b','image',0,0,9,'03ab1ec18e1c1de23be60c935f54da0f.jpeg','pexels-photo-129928.jpeg','',1495026432,3),('6285cac3fc7659158cbb24b4e7cfd235','image',0,0,11,'8d9f23400c2449c8a776791c292b59b8.jpg','potd-squirrel_3519920k.jpg','',1495026607,3),('6293e8204ff0459e1e754a4d3a00fb97','image',0,0,11,'e2fc7d084a503dcf6a45ca5b22cd059e.jpeg','pexels-photo-286330.jpeg','',1495026607,3),('654db6ed11e9e59b8dc1fe6f2feb8fc9','image',0,0,11,'d91b41ac4ee4fae1599595f6442d1add.jpg','pexels-photo-27714.jpg','',1495026607,3),('65c944ebf987094dbdced7a8f69474dd','image',0,0,8,'420be381e15d91e563924f6512dd1a6e.jpeg','','',1495022219,3),('6633656040ca5ea4426768cf1735c598','image',0,0,24,'a2b887e740fab9b3ae0f3d3df9a65b18.jpg','i7.jpg','',1504096400,15),('6675c836f087bd32bcf9ca8777717984','image',0,0,11,'1b6cb353793369e3497deac94511ff81.jpeg','horsehead-nebula-dark-nebula-constellation-orion-87646.jpeg','',1495026606,3),('676823c3cd471ece47fc482b7891a63c','image',0,0,8,'7743de4e2aa99fd66a1e4df1e08c7cf1.jpeg','pexels-photo-173383.jpeg','',1495026323,3),('68793ff74cb908560449845282c0f8c8','image',0,0,11,'2932a50cd1887ae3bcfb4b1daa7ec55b.jpeg','dog-cavalier-king-charles-spaniel-funny-pet-162167.jpeg','',1495026607,3),('68cc9fd628ed767d3de5cc4f0bcf8aca','image',0,0,8,'3c1285a90c9bc91510edc34d7196e4b8.jpeg','pexels-photo-132037.jpeg','',1495026323,3),('6db1830526a8b2560baa978aef1cf8b8','image',0,0,28,'a48aa94316dbda6e658b2907708f0ef2.jpeg','фризер.jpeg','',1507203563,21),('7038d9a8ab97b586f8de01a76509e05f','image',0,0,11,'43b77cad4cd9c9108ef9e4c45ba9cc13.jpg','maxresdefault.jpg','',1495026607,3),('70af5806a42ba3da6751ca3ec66c8ced','image',0,0,16,'9758dfedea9c4db1cc6bbd8c0eeb8c48.jpeg','pexels-photo-129928.jpeg','',1495039432,3),('7359cf3c95d761a3eed874f9326189ec','image',0,0,11,'2bca5d8ff973615fd339a1d23e8eac8a.jpg','pexels-photo (1).jpg','',1495026606,3),('73e79e3d4fa0bc5acfc83e70a84ab6be','image',0,0,9,'03ac792162b1839de84be885f5d88b05.jpeg','pexels-photo-186680.jpeg','',1495026432,3),('7734099cbdbffff8bca077bf301fa388','image',0,0,9,'b7cd5bb6c93d59a9d7b0a7ef18a397ee.jpg','skyline-buildings-new-york-skyscrapers.jpg','',1495026432,3),('795da808b0e3d2f0dd874d7a853082e4','image',0,0,9,'3c3ef2cc8641cf09d7795c1aade1db16.jpg','maxresdefault.jpg','',1495026432,3),('79a056272441271ec65af8f2bd46ee16','image',0,0,9,'57c414bcf412e6bf9e73627df8f74fe6.jpg','people-eiffel-tower-lights-night.jpg','',1495026433,3),('79d596b356e62210b3776dc28328631e','image',0,0,27,'86231bac340392e4372949b363cfb6fa.jpeg','1.jpeg','',1507203023,20),('7a3ac26422e5e5252cd297ceb864c734','image',0,0,11,'a4e21363eca61959597da4a14b658dd9.jpeg','mona-lisa-leonardo-da-vinci-la-gioconda-oil-painting-40997.jpeg','',1495026606,3),('7a54eccc6c1c2ed4bdba506f6a2d72c6','image',0,0,27,'7a9122cde5b990158f1396e512c12ff5.jpeg','i.jpeg','',1507203023,20),('7e09636af27a571e6f26e9a50f871a24','video',0,0,11,'','','https://www.youtube.com/watch?v=LNlw08wnFdM',1495026605,3),('7e8e12611032a788bfc483d03b96a2b0','image',0,0,25,'f7f86fecb62684eeddef303af3119f8e.jpg','i13.jpg','',1504096702,15),('81d2fc20d53ab32e536b7a0f96e395e8','image',0,0,28,'698d77bf610fa90d9c5fcfc8d18fc1bd.jpeg','1*O6prc-RQAtfLhMPXCopYXw.jpeg','',1507203563,21),('81ee9021dd2952c20c2e0c503ed15903','video',0,0,8,'','','https://www.youtube.com/watch?v=r00uCrDjOjE',1495026323,3),('8315dd97afc53d1eafe5497fd87c42e3','image',0,0,27,'30cc3e3a42efaa38bd949ccd5b892ebc.jpeg','5.jpeg','',1507203023,20),('83dc9357d4ed24d67b424ba5ccb63a28','image',0,0,9,'5248435effbc5052fa7cdf16224a9a99.jpeg','sea-bay-waterfront-beach-50594.jpeg','',1495026432,3),('876bd6ae39e4f789a2eaec5ce896be3b','image',0,0,20,'8ca79d804132337637d7936d954b8eb6.jpeg','pexels-photo-286330.jpeg','',1495035795,3),('8b166ab2371739ec885c3d4d024d4043','document',0,0,21,'d6be5a51bbf1cd36d89dd2d2b4f1fd4d.pdf','example-abstract.pdf','',1495098802,3),('8dcdc36bac55b6d5315cc803eefaea09','image',0,0,24,'a6d99c557d6de689e70be612bdd3dcb7.jpeg','i6 (1).jpeg','',1504096400,15),('8fb036bdab8a647ae93d80a9725d0fd6','image',0,0,9,'9d80584cb5ca99dd5ef2cb574c0b2c2f.jpeg','mona-lisa-leonardo-da-vinci-la-gioconda-oil-painting-40997.jpeg','',1495026432,3),('9323fa511824449235c82fa9a587ed13','video',35,0,0,'','','https://www.youtube.com/watch?v=AV71bbQreTc',1500469329,2),('95a63ebbb5496117e031d2210bc050cf','image',0,0,12,'0e16ac9058e33fa0f542859419f446ae.jpeg','pexels-photo-186680.jpeg','',1495027287,3),('95cb8aff149da6d895e17e2ab3e873c7','image',0,0,24,'fe341f3f2d5974e408da95e1c3ab0247.jpeg','i8.jpeg','',1504096400,15),('a0820b1e0c264694e1ee2241562e1f3a','image',0,0,23,'d265a2809a0a22ed520973bfd9505a6f.jpg','information_items_2065.jpg','',1495625525,2),('a1902134019b4729504e37362956f9bd','image',0,0,11,'0ed4a805c001bde984ade0a1ce9f9bc2.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495026605,3),('a3700596fe2e12e2da4e41972a9a88ac','image',0,0,24,'ccec66916b69a14b810c6b8baaf70b55.jpg','i9.jpg','',1504096400,15),('b0dde65b435554f3df061fcacc2eb592','image',0,0,25,'3f734290b27d4c750598eb364fd7c109.jpeg','i16.jpeg','',1504096702,15),('b152c4a1e3b5e30d9594a26f8792a1db','image',0,0,16,'eea992aa7db3b0c2104e72606592cb07.jpeg','mona-lisa-leonardo-da-vinci-la-gioconda-oil-painting-40997.jpeg','',1495027308,3),('b79a928a800a0b4d6ceb2842b775539c','image',0,0,25,'dde3964afb3bb73270990b80350154a2.jpeg','i18.jpeg','',1504096702,15),('bbf027da30e77cdf387628804ecc130c','image',0,0,8,'fff3aff6044247725b556e2ac7b47308.jpg','above-adventure-aerial-air.jpg','',1495026323,3),('bc8e10f70fcbaa690e91c3034b88c72a','image',0,0,9,'c6f63fbe06d32138c20635e009d77651.jpg','pexels-photo-27714.jpg','',1495026432,3),('bfd807edd1f1fd561ff6c4ea67e00b20','image',0,0,9,'badd5d2ee879bfb3eeaa2e191afd31f9.jpg','above-adventure-aerial-air.jpg','',1495026433,3),('bfe1e6e9d75c745a0cb79f14c437a925','image',0,0,26,'d90bd27ad6f5ea899938193262d89ba2.jpg','1297820106477.jpg','',1504790048,17),('c0471dd1192741971f911223fb7921e9','image',0,0,11,'d9376ad2644a530a7de432290427a730.jpg','people-eiffel-tower-lights-night.jpg','',1495026607,3),('c0e99300b7daa4a5eba8aa6cd4f3567f','image',0,0,9,'8449084f52a2bf30610a02ef5e60a62c.jpeg','pexels-photo-57812.jpeg','',1495026432,3),('c435520222bce2ccd06fd34419f564a8','image',0,0,9,'6cee2f746c8b244024b6d6dc0ce16663.jpg','_89586487_istock_000063166549_medium.jpg','',1495026433,3),('c7a0298ec026f227d8245b9eddd1f5ca','image',0,0,9,'48fb5b255690ff76b95c483a6c99ac7b.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495026432,3),('c7adf90d84a9a28f87b19cefb25fd0b6','image',0,0,25,'aac879bf4141442f391f0f1af07f7c75.jpeg','i13.jpeg','',1504096702,15),('c813a45978258addaa4d16f879418f3c','image',34,0,0,'4d2eb958db8426756b1bd13aa8511348.png','about-master-graph.png','',1500468295,2),('c8a917392cee0d50707ed56e9616092d','image',0,0,23,'d46ff381b93e364e4f64638852705940.jpg','1383896996_Luxury-home-Melbourne-Australia-99.jpg','',1495625525,2),('cab66418fd4716f078fde05783d1b143','image',0,0,9,'887b3206c0fa344c4d6ee6c7fe69e4ac.jpeg','pexels-photo-219833.jpeg','',1495026432,3),('cb7a26a75a280dc8f0978b39cebb0709','image',0,0,9,'098676f7b8dd308f9041cb25fcd08403.jpeg','pexels-photo-173383.jpeg','',1495026432,3),('ce1a75ab7fdc37c04404fa9bc5b4348a','image',0,0,28,'cc06ec290cd0357854b2949beb0fb742.jpg','PinkFloyd_Exhibition_Microsite_v04-background01.jpg','',1507203563,21),('cfe7dad331e4b536925cb3b2ba10a944','image',0,0,11,'3e0f8f979ceef7d0eeda01afd1ad637a.jpeg','pexels-photo-132037.jpeg','',1495026606,3),('d131531051d39601680b1a5bf2664c1c','image',0,0,8,'5666087218934c5cb1aaf704089aeff1.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495026323,3),('d28f2df95286185693c972ebf7067c2d','image',34,0,0,'6dd7b5c0f45a185078a29ecd4b0950f6.png','about-arbitrazh-icon.png','',1500468295,2),('d31190cb3557727507e062dbfc7846fb','image',0,0,25,'3cdc909ec8d810c074fa46b199f5af49.jpeg','i14.jpeg','',1504096702,15),('d3befb9c08682eded055569a912c0aab','image',0,0,9,'b75c9f35121d311a3571be49429ca103.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495026432,3),('d5fefbc2a4c0238fcb9f8b23ef7654be','image',0,0,28,'b54bd723b4a4afab85b7c3eb2a754946.jpg','prigotovlenie_zharenogo_morozhenogo_s_pomoshchyu_frizera.jpg','',1507203563,21),('e15635cd432fc72c313b653eb5847d14','image',0,0,29,'b016f4404f54d259075dfc28a91bd7cb.jpg','roses_good_morning-wallpaper-1600x900.jpg','',1507635695,1),('e4fe0fc1c7a0d9de7f3e266690d01720','image',0,0,11,'9bbbd5a4658c5ed7bcaf6527a9c8bf18.jpeg','pexels-photo-173383.jpeg','',1495026605,3),('e7081a9b112a642d296b9e28ddecd33f','image',0,0,9,'5b0952b46f06b143a54840c6229fe2fa.jpeg','pexels-photo-286330.jpeg','',1495026433,3),('e890af5535213a06249e3ee0da170355','image',0,0,24,'36dc268b3f7a2f93fcb10f6f87950875.jpeg','i.jpeg','',1504096400,15),('e9094e106060163b1795ffb2bcb4e4ef','image',0,0,24,'8b5f4af72b2a09771cff096bab58980b.jpeg','i2.jpeg','',1504096400,15),('eb10f8d50367d114fa20587108e09423','image',0,0,10,'f6efa3b0d1452c6f4a488d5bc7d05cff.jpg','people-eiffel-tower-lights-night.jpg','',1495026547,3),('eb78c16fe3e373059a841e566b4fd898','image',0,0,11,'d0ea0c47b0b062978a09d92f216b4a88.jpeg','pexels-photo-186680.jpeg','',1495026606,3),('ed28350ff33b7d4becec7fab44d7623d','image',70,0,0,'7e9bf8a75a05b82f5ebbef37c7fbb1e0.png','Selection_039.png','',1504620913,1),('ed80a8c2ae654c24de7a2a99e474a60f','image',0,0,25,'904a8ea145a7e7fabbf02559c4c14e33.jpeg','i12.jpeg','',1504096702,15),('f1e89ac7c0e42167bc955bf2f04edd16','image',0,0,8,'a1e30e8e72f5cbbc4594b6cc0fc34ee8.jpeg','','',1495022219,3),('f42078f277d7033664a2510feb67f7bb','image',0,0,8,'41636e065ce79886996213285482c622.jpg','_89586487_istock_000063166549_medium.jpg','',1495026323,3),('f84f52e2e58369eb1fcfea675ab43025','image',0,0,11,'1a48e73c151d0ff71ce6d7b78316d23a.jpg','pexels-photo.jpg','',1495026607,3),('f94ccd47ad92df81f2cba7e94bbf811e','image',0,0,23,'4e6d98ee629305b4eff7b806bf8662dd.jpg','101a6d35d617993ac79c957b7b022311.jpg','',1495625525,2),('f9943d4474af571682b3fc975600af06','image',70,0,0,'10126070b3725cd906d8f98c918a1190.png','Selection_038.png','',1504620913,1),('fe34154a0c8c4f86a0bbb5cfbb14dcfe','image',0,0,9,'05f94a7727e8b030b87d056918ee9a44.jpeg','pexels-photo-132037.jpeg','',1495026432,3),('ff8801420e91e6e87ef197903c192bdc','image',0,0,11,'c2fa20daa2e64af4ef348751eaf23ce1.jpeg','pexels-photo-129928.jpeg','',1495026605,3);
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
  `for_event_id` varchar(32) NOT NULL,
  PRIMARY KEY (`dialog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dialogs`
--

LOCK TABLES `dialogs` WRITE;
/*!40000 ALTER TABLE `dialogs` DISABLE KEYS */;
INSERT INTO `dialogs` VALUES ('0fc7e48ab75468a80a32b9595cd4b024','15','d52b85fbc44f177c819c539489a04f76'),('22191d465f6905de8a279a4064efeb42','15','5bdb695dc6e33841f616be6dfc5c3879'),('24967947b352036964bed31e592e8105','1,16',''),('2b4c9e5f0f0ac5e449bf9da0627feca7','16,17,15','d39776f90252c5325a202dc8dc2cde9e'),('38d57ca87af07b563cd404af051ce87d','2,3',''),('4a1409f09bcc2f082d8728360b9c2dca','15,2',''),('650daf5b0807ada3e205349e2d48e82f','1,3',''),('7b0847b4aa5e84b277b3148c9fc2a25b','1,15',''),('7bfa08ad3835e83e612b981e84a3f676','15','997ea17267919e5cf67680a6ffef02c8'),('8363df49b2aafa942cc515ee1b7ba19d','1','ea1769e18131c355612380df149acf34'),('c87954eaea3ed578ea5606c103e21aeb','1,2',''),('d93c28f1ce2bd5eb7c0185ab48a683c9','16','72740b7664199f45d2cb59b0a7b816ca'),('da8a9590b2940e162756f62d7830f810','1','6d145923d30f4511067f08768771416b'),('e54c2d911697def538a3090925a0dff6','1,1','');
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
INSERT INTO `login_attempts` VALUES ('admin@weedo.ru',1492265776,'127.0.0.1'),('admin@weedo.ru',1492265873,'127.0.0.1'),('admin@weedo.ru',1492265895,'127.0.0.1'),('admin@weedo.ru',1492265902,'127.0.0.1'),('admin@weedo.ru',1492265938,'127.0.0.1'),('admin@weedo.ru',1492265942,'127.0.0.1'),('admin@weedo.ru',1492265967,'127.0.0.1'),('admin@weedo.ru',1492266034,'127.0.0.1'),('admin@weedo.ru',1492266642,'127.0.0.1'),('admin@weedo.ru',1492266699,'127.0.0.1'),('admin@weedo.ru',1492266725,'127.0.0.1'),('admin@weedo.ru',1492266763,'127.0.0.1'),('admin@weedo.ru',1492274708,'127.0.0.1'),('admin@weedo.ru',1492274824,'127.0.0.1'),('admin@weedo.ru',1492274850,'127.0.0.1'),('admin@weedo.ru',1492274862,''),('admin@weedo.ru',1492274909,'127.0.0.1'),('admin@weedo.ru',1492275023,'127.0.0.1'),('admin@weedo.ru',1492275057,'127.0.0.1'),('admin@weedo.ru',1492276111,'127.0.0.1'),('admin@weedo.ru',1492276209,'127.0.0.1'),('admin@weedo.ru',1492276225,'127.0.0.1'),('admin@weedo.ru',1492295204,'127.0.0.1'),('admin@weedo.ru',1492295207,'127.0.0.1'),('admin@weedo.ru',1492295212,'127.0.0.1'),('admin@weedo.ru',1492295281,'127.0.0.1'),('admin@weedo.ru',1492295360,'127.0.0.1'),('admin@weedo.ru',1492295423,'127.0.0.1'),('admin@weedo.ru',1492295768,'127.0.0.1'),('admin@weedo.ru',1492295779,'127.0.0.1'),('admin@weedo.ru',1492295887,'127.0.0.1'),('admin@weedo.ru',1492448870,'127.0.0.1'),('admin@weedo.ru',1492448952,'127.0.0.1'),('admin@weedo.ru',1492543973,'127.0.0.1'),('admin@weedo.ru',1492543991,'127.0.0.1'),('admin@weedo.ru',1492544003,'127.0.0.1'),('admin@weedo.ru',1492544376,'127.0.0.1'),('admin@weedo.ru',1492544417,'127.0.0.1'),('demo',1492544485,'127.0.0.1'),('demo',1492544495,'127.0.0.1'),('demo',1492544560,'127.0.0.1'),('admin@weedo.ru',1492589386,'127.0.0.1'),('admin@weedo.ru',1492592296,'127.0.0.1'),('demo',1493035543,'127.0.0.1'),('demo',1493040247,'127.0.0.1'),('admin@weedo.ru',1493112480,'127.0.0.1'),('admin@weedo.ru',1493112972,'127.0.0.1'),('demo',1493113995,'127.0.0.1'),('demo',1493125409,'127.0.0.1'),('demo',1493126246,'127.0.0.1'),('manager',1493128466,'127.0.0.1'),('manager',1493128469,'127.0.0.1'),('manager',1493128472,'127.0.0.1'),('manager',1493128680,'127.0.0.1'),('demo',1493132994,'127.0.0.1'),('manager',1493134873,'127.0.0.1'),('demo',1493206793,'127.0.0.1'),('manager',1493224739,'127.0.0.1'),('demo',1493228001,'127.0.0.1'),('demo',1493228081,'127.0.0.1'),('demo',1493228106,'127.0.0.1'),('demo',1493228133,'127.0.0.1'),('demo',1493228164,'127.0.0.1'),('demo',1493228238,'127.0.0.1'),('admin@weedo.ru',1493228352,'127.0.0.1'),('demo',1493228417,'127.0.0.1'),('admin@weedo.ru',1493292417,'127.0.0.1'),('admin@weedo.ru',1493294151,'127.0.0.1'),('admin@weedo.ru',1493296784,'127.0.0.1'),('demo',1493381142,'127.0.0.1'),('demo',1493384772,'127.0.0.1'),('admin@weedo.ru',1493391694,'127.0.0.1'),('admin@weedo.ru',1493477371,'127.0.0.1'),('manager',1493480445,'127.0.0.1'),('admin@weedo.ru',1493539017,'127.0.0.1'),('demo',1493572081,'127.0.0.1'),('demo',1493572259,'127.0.0.1'),('admin@weedo.ru',1493717470,'127.0.0.1'),('demo',1493730517,'127.0.0.1'),('demo',1493735079,'127.0.0.1'),('admin@weedo.ru',1493736523,'127.0.0.1'),('manager',1493738479,'127.0.0.1'),('demo',1493828979,'127.0.0.1'),('admin@weedo.ru',1493880581,'127.0.0.1'),('manager',1493893103,'127.0.0.1'),('admin@weedo.ru',1493905679,'127.0.0.1'),('admin@weedo.ru',1493905705,'127.0.0.1'),('demo',1493905728,'127.0.0.1'),('demo',1494402033,'127.0.0.1'),('manager',1494402043,'127.0.0.1'),('demo',1494402126,'83.68.44.33'),('demo',1494410567,'83.68.44.33'),('demo',1494427267,'127.0.0.1'),('admin@weedo.ru',1494427276,'127.0.0.1'),('admin@weedo.ru',1494427551,'127.0.0.1'),('demo',1494427957,'127.0.0.1'),('admin@weedo.ru',1494582511,'127.0.0.1'),('demo',1494582564,'127.0.0.1'),('demo',1494592727,'127.0.0.1'),('demo',1494934854,'127.0.0.1'),('admin@weedo.ru',1495042605,'127.0.0.1'),('demo',1495098772,'127.0.0.1'),('demo',1495115418,'127.0.0.1'),('demo',1495116545,'127.0.0.1'),('demo',1495439296,'127.0.0.1'),('demo',1495472673,'127.0.0.1'),('admin@weedo.ru',1495539784,'127.0.0.1'),('manager',1495546996,'127.0.0.1'),('manager',1495547306,'127.0.0.1'),('admin@weedo.ru',1495615215,'127.0.0.1'),('demo',1495624389,'127.0.0.1'),('manager',1495624413,'127.0.0.1'),('admin@weedo.ru',1495630934,'127.0.0.1'),('admin@weedo.ru',1495799695,'127.0.0.1'),('admin@weedo.ru',1496048607,'127.0.0.1'),('demo',1496065858,'127.0.0.1'),('demo',1496078430,'127.0.0.1'),('admin@weedo.ru',1496134665,'127.0.0.1'),('admin@weedo.ru',1496134893,'127.0.0.1'),('admin@weedo.ru',1496136498,'127.0.0.1'),('demo',1496141129,'127.0.0.1'),('manager',1496141484,'127.0.0.1'),('manager',1496151654,'127.0.0.1'),('admin@weedo.ru',1496152426,'127.0.0.1'),('demo',1496238074,'83.68.44.33'),('admin@weedo.ru',1496238179,'127.0.0.1'),('demo',1496238491,'127.0.0.1'),('admin@weedo.ru',1496316567,'127.0.0.1'),('admin@weedo.ru',1496317212,'127.0.0.1'),('admin@weedo.ru',1496317444,'127.0.0.1'),('admin@weedo.ru',1496317497,'127.0.0.1'),('demo',1496317509,'127.0.0.1'),('demo',1496317536,'127.0.0.1'),('admin@weedo.ru',1496317553,'127.0.0.1'),('admin@weedo.ru',1496318232,'127.0.0.1'),('demo',1496319687,'127.0.0.1'),('demo',1496321140,'83.68.44.33'),('demo',1496321585,'83.68.44.33'),('manager',1496322686,'83.68.44.33'),('manager',1496323453,'127.0.0.1'),('demo',1496323646,'83.68.44.33'),('demo',1496325309,'83.68.44.33'),('manager',1496325734,'127.0.0.1'),('manager',1496330555,'127.0.0.1'),('demo',1496400121,'127.0.0.1'),('demo',1496407005,'83.68.44.33'),('admin@weedo.ru',1496409809,'127.0.0.1'),('admin@weedo.ru',1496594299,'::1'),('admin@weedo.ru',1496658501,'127.0.0.1'),('demo',1496659371,'127.0.0.1'),('admin@weedo.ru',1496677975,'127.0.0.1'),('admin@weedo.ru',1496678050,'127.0.0.1'),('demo',1496678888,'127.0.0.1'),('manager',1496678964,'127.0.0.1'),('admin@weedo.ru',1496679503,'127.0.0.1'),('admin@weedo.ru',1496680695,'127.0.0.1'),('admin@weedo.ru',1496680705,'127.0.0.1'),('admin@weedo.ru',1496680722,'127.0.0.1'),('admin@weedo.ru',1496767305,'127.0.0.1'),('admin@weedo.ru',1496767321,'127.0.0.1'),('admin@weedo.ru',1497000079,'127.0.0.1'),('admin@weedo.ru',1497456523,'127.0.0.1'),('admin@weedo.ru',1497456835,'127.0.0.1'),('admin@weedo.ru',1497456839,'127.0.0.1'),('admin@weedo.ru',1497515267,'127.0.0.1'),('admin@weedo.ru',1497515270,'127.0.0.1'),('admin@weedo.ru',1497515279,'127.0.0.1'),('admin@weedo.ru',1497515318,'127.0.0.1'),('admin@weedo.ru',1497515322,'127.0.0.1'),('admin@weedo.ru',1497515339,'127.0.0.1'),('admin@weedo.ru',1497516154,'127.0.0.1'),('admin@weedo.ru',1497599099,'127.0.0.1'),('teterin@simicon.com',1497885628,'127.0.0.1'),('teterin@simicon.com',1497885649,'127.0.0.1'),('roundcubez@gmail.com',1497885652,'127.0.0.1'),('teterin@simicon.com',1497886234,'127.0.0.1'),('teterin@simicon.com',1497886568,'127.0.0.1'),('teterin@simicon.com',1497886621,'127.0.0.1'),('teterin@simicon.com',1497886657,'127.0.0.1'),('teterin@simicon.com',1497886880,'127.0.0.1'),('teterin@simicon.com',1497886885,'127.0.0.1'),('teterin@simicon.com',1497887150,'127.0.0.1'),('teterin@simicon.com',1497887490,'127.0.0.1'),('teterin@simicon.com',1497887692,'127.0.0.1'),('teterin@simicon.com',1497951163,'127.0.0.1'),('admin@weedo.ru',1497952992,'127.0.0.1'),('admin@weedo.ru',1498031731,'127.0.0.1'),('admin@weedo.ru',1498031946,'127.0.0.1'),('admin@weedo.ru',1498032094,'127.0.0.1'),('admin@weedo.ru',1498034264,'127.0.0.1'),('admin@weedo.ru',1498034364,'127.0.0.1'),('admin@weedo.ru',1498034435,'127.0.0.1'),('admin@weedo.ru',1498035215,'127.0.0.1'),('admin@weedo.ru',1498035277,'127.0.0.1'),('admin@weedo.ru',1498035481,'127.0.0.1'),('admin@weedo.ru',1498035522,'127.0.0.1'),('admin@weedo.ru',1498045244,'127.0.0.1'),('admin@weedo.ru',1498045255,'127.0.0.1'),('admin@weedo.ru',1498045298,'127.0.0.1'),('admin@weedo.ru',1498045310,'127.0.0.1'),('admin@weedo.ru',1498045365,'127.0.0.1'),('admin@weedo.ru',1498045388,'127.0.0.1'),('admin@weedo.ru',1498045412,'127.0.0.1'),('manager@weedo.ru',1498047701,'127.0.0.1'),('admin@weedo.ru',1500283177,'127.0.0.1'),('admin@weedo.ru',1500369922,'127.0.0.1'),('admin@weedo.ru',1500467278,'127.0.0.1'),('manager@weedo.ru',1500467644,'127.0.0.1'),('jev.chern@gmail.com',1500473685,'83.68.44.33'),('jev.chern@gmail.com',1500557425,'83.68.44.33'),('manager@weedo.ru',1500558090,'127.0.0.1'),('manager@weedo.ru',1500651589,'127.0.0.1'),('admin@weedo.ru',1500653837,'127.0.0.1'),('admin@weedo.ru',1500887380,'127.0.0.1'),('manager@weedo.ru',1500887428,'127.0.0.1'),('admin@weedo.ru',1501083774,'127.0.0.1'),('admin@weedo.ru',1501154581,'85.143.184.138'),('admin@weedo.ru',1501248294,'127.0.0.1'),('admin@weedo.ru',1501690297,'127.0.0.1'),('admin@weedo.ru',1501690302,'127.0.0.1'),('admin@weedo.ru',1502284347,'127.0.0.1'),('admin@weedo.ru',1503067089,'127.0.0.1'),('admin@weedo.ru',1503130087,'::1'),('admin@weedo.ru',1503333491,'127.0.0.1'),('admin@weedo.ru',1503913617,'127.0.0.1'),('jev.chern@gmail.com',1503920115,'83.68.44.33'),('jev.chern@gmail.com',1503920130,'83.68.44.33'),('jev.chern@gmail.com',1503921191,'83.68.44.33'),('jev.chern@gmail.com',1503921327,'83.68.44.33'),('jev.chern@gmail.com',1503921338,'83.68.44.33'),('jev.chern@gmail.com',1503921346,'83.68.44.33'),('admin@weedo.ru',1503922970,'127.0.0.1'),('jev.chern@gmail.com',1503923174,'83.68.44.33'),('jev.chern@gmail.com',1503923179,'83.68.44.33'),('jev.chern@gmail.com',1503923195,'83.68.44.33'),('admin@weedo.ru',1503923288,'127.0.0.1'),('jev.chern@gmail.com',1504011646,'83.68.44.33'),('admin@weedo.ru',1504011957,'127.0.0.1'),('admin@weedo.ru',1504015493,'127.0.0.1'),('jev.chern@gmail.com',1504080061,'83.68.44.33'),('admin@weedo.ru',1504082100,'127.0.0.1'),('jev.chern@gmail.com',1504182258,'83.68.44.33'),('jev.chern@gmail.com',1504182262,'83.68.44.33'),('admin@weedo.ru',1504183796,'127.0.0.1'),('jev.chern@gmail.com',1504184324,'83.68.44.33'),('jev.chern@gmail.com',1504255960,'83.68.44.33'),('admin@weedo.ru',1504264600,'127.0.0.1'),('jev.chern@gmail.com',1504513009,'83.68.44.33'),('admin@weedo.ru',1504515727,'193.169.110.85'),('admin@weedo.ru',1504516157,'127.0.0.1'),('admin@weedo.ru',1504533370,'127.0.0.1'),('jev.chern@gmail.com',1504535221,'83.68.44.33'),('admin@weedo.ru',1504535275,'127.0.0.1'),('admin@weedo.ru',1504620440,'85.143.184.138'),('jev.chern@gmail.com',1504698657,'83.68.44.33'),('jev.chern@gmail.com',1504705006,'83.68.44.33'),('jev.chern@gmail.com',1504705141,'83.68.44.33'),('admin@weedo.ru',1504706032,'85.143.184.138'),('info@mskiso.ru',1504708387,'83.68.44.33'),('info@mskiso.ru',1504710139,'83.68.44.33'),('info@mskiso.ru',1504725470,'188.243.176.12'),('jev.chern@gmail.com',1504786226,'83.68.44.33'),('evgenya.chern@yandex.ru',1504788601,'83.68.44.33'),('evgenya.chern@yandex.ru',1504793205,'83.68.44.33'),('info@mskiso.ru',1504794429,'83.68.44.33'),('jev.chern@gmail.com',1504795107,'83.68.44.33'),('jev.chern@gmail.com',1504795700,'83.68.44.33'),('jev.chern@gmail.com',1504873147,'83.68.44.33'),('jev.chern@gmail.com',1504873157,'83.68.44.33'),('jev.chern@gmail.com',1506936437,'83.68.44.33'),('jev.chern@gmail.com',1506936448,'83.68.44.33'),('jev.chern@gmail.com',1507114891,'83.68.44.33'),('info@kokoso.ru',1507202002,'83.68.44.33'),('manager@mskiso.ru',1507202761,'83.68.44.33'),('manager3@mskiso.ru',1507203262,'83.68.44.33'),('jev.chern@gmail.com',1507204415,'83.68.44.33'),('manager7@mskiso.ru',1507204589,'83.68.44.33'),('jev.chern@gmail.com',1507204703,'83.68.44.33'),('info@mskiso.ru',1507204785,'83.68.44.33'),('manager3@mskiso.ru',1507204834,'83.68.44.33'),('admin@weedo.ru',1507483914,'188.242.136.98'),('admin@weedo.ru',1507556702,'85.143.184.138'),('jev.chern@gmail.com',1507559349,'83.68.44.33'),('jev.chern@gmail.com',1507634466,'83.68.44.33'),('manager@mskiso.ru',1507634795,'83.68.44.33'),('admin@weedo.ru',1507650729,'85.143.184.138'),('admin@weedo.ru',1507821499,'85.143.184.138'),('jev.chern@gmail.com',1507891002,'83.68.44.33'),('admin@weedo.ru',1508331555,'85.143.184.138'),('admin@weedo.ru',1508408924,'85.143.184.138'),('admin@weedo.ru',1508509372,'85.143.184.138'),('jev.chern@gmail.com',1509018175,'83.68.44.33'),('admin@weedo.ru',1509109851,'85.143.184.138'),('jev.chern@gmail.com',1509364173,'83.68.44.33'),('jev.chern@gmail.com',1509369730,'83.68.44.33'),('jev.chern@gmail.com',1509369734,'83.68.44.33'),('jev.chern@gmail.com',1511769144,'83.68.44.33'),('admin@weedo.ru',1512052092,'85.143.184.138');
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
  `readed` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES ('01b22704d1978b88086766644e3c6388','qwe',1493572104,'650daf5b0807ada3e205349e2d48e82f',3,1),('032c9115b177f6f191f10bc3aded0edf','fadsklj',1493299668,'650daf5b0807ada3e205349e2d48e82f',1,1),('035a51d31865cd5fc9260d21c73cafaf','47: from 3 to 2 035a51d31865cd5fc9260d21c73cafaf',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('03a30fb66850b27044c3361aa2396e36','2: from 3 to 2 03a30fb66850b27044c3361aa2396e36',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('03c250b12e1d1dddd58697fbb537ec8c','здарова',1493573082,'650daf5b0807ada3e205349e2d48e82f',1,1),('0419a17916c959d0a6dae2f9584fb2c4','52: from 3 to 2 0419a17916c959d0a6dae2f9584fb2c4',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('05575150d2bdfb06dbdee8849550946a','nnn',1493880278,'650daf5b0807ada3e205349e2d48e82f',3,1),('05b101472d95e17969d52865d9c9bfb8','33: from 1 to 2 05b101472d95e17969d52865d9c9bfb8',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('09ab4dc7faecff13364d81f3ea3a72ef','115: from 2 to 1 09ab4dc7faecff13364d81f3ea3a72ef',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('0ad826c0bc5f49885179a5cb3a54fc3d','&quot;как-то с фильтрами сливается... (пока не знаю менять кнопку или нет.. ) &quot;\n\nэто к чему относится ?',1496325938,'650daf5b0807ada3e205349e2d48e82f',1,1),('0b218ff0107fc6291c7541d464986d86','79: from 2 to 3 0b218ff0107fc6291c7541d464986d86',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('0c5ef5cee71e2fcda632c71e5276b34a','ZZZZZQ!@!',1493572980,'650daf5b0807ada3e205349e2d48e82f',1,1),('0efe1a39d58730217a50e2eb5abafaa5','108: from 1 to 3 0efe1a39d58730217a50e2eb5abafaa5',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('10c42815b2208e078ce76438aa9599e3','а',1493573496,'650daf5b0807ada3e205349e2d48e82f',3,1),('13dbd1965d88061a14f78964c6b52546','43: from 1 to 3 13dbd1965d88061a14f78964c6b52546',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('142805897f59db4bc028695452d503af','150: from 2 to 1 142805897f59db4bc028695452d503af',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('1437c32e79ad0f070ab250c999e7e575','YYYQQQ!!!!!',1498047711,'c87954eaea3ed578ea5606c103e21aeb',2,1),('16daf051738c72fba59ccf7d7b7aaa13','Общий чат для праздника: HNY !',1496333393,'267b7b49a4c51f9a57ae65dc48d1d74f',1,1),('1949f7c4c659098ae7a0b8fb4a57fafe','qqq',1493880273,'650daf5b0807ada3e205349e2d48e82f',3,1),('198cf020afe95cc762ff6a0285497c3d','136: from 1 to 2 198cf020afe95cc762ff6a0285497c3d',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1a99c32ecf9b99529553161f0ed65570','мммммм',1498047492,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1aa1f9228ac70c1c5e6a89e3603a5581','85: from 3 to 2 1aa1f9228ac70c1c5e6a89e3603a5581',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('1bf2376f6c17082341c5542abd73e675','137: from 3 to 1 1bf2376f6c17082341c5542abd73e675',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('1c2a6cc564c65f1e312f3f36fca010be','qwe',1493711924,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1c5bf543ee07a527abe4ff87a4e7af21','e',1493545886,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1c9463289b61a5d2926e5a6b6e7b723e','qq',1493879247,'650daf5b0807ada3e205349e2d48e82f',3,1),('1d378bd6d91d5d8c3337f1fd6f7dd8a8','103: from 3 to 2 1d378bd6d91d5d8c3337f1fd6f7dd8a8',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('1ede9670a0e8e7fc6d22d34803a6ce56','25: from 1 to 3 1ede9670a0e8e7fc6d22d34803a6ce56',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('20aa221664f693eb58e9ce8deeba51c6','176: from 1 to 2 20aa221664f693eb58e9ce8deeba51c6',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('235f2978d7b1677e8293333d620b3a5c','199: from 3 to 1 235f2978d7b1677e8293333d620b3a5c',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('256aa9cae88cfd85f515f045a9e579b8','Yo',1493881190,'650daf5b0807ada3e205349e2d48e82f',1,1),('270c7e44f37b4af9762d2f11be5a1793','цйу',1493573353,'650daf5b0807ada3e205349e2d48e82f',3,1),('298a0c090caed8866c0c32650daff7b2','fff',1493879082,'650daf5b0807ada3e205349e2d48e82f',3,1),('298acbf01938186827557120e2cddd72','w',1493545770,'c87954eaea3ed578ea5606c103e21aeb',1,1),('2996ad223d01e78a0264c434457064df','61: from 2 to 1 2996ad223d01e78a0264c434457064df',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('2b0871dd7a74f72ce17e3fa996bdefa9','23: from 3 to 1 2b0871dd7a74f72ce17e3fa996bdefa9',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('2bbd7d5efb3ffafe5dd7ce97ff09b9d8','58: from 2 to 3 2bbd7d5efb3ffafe5dd7ce97ff09b9d8',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('2c208e1802bb3ef104290b2e3f51eb85','qqq',1493879666,'650daf5b0807ada3e205349e2d48e82f',3,1),('2cfb8d115b50763e2a5646a4e9f4c883','129: from 1 to 3 2cfb8d115b50763e2a5646a4e9f4c883',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('2f932eb46b25fdac2c670bb03f79b388','zzz',1493881222,'650daf5b0807ada3e205349e2d48e82f',1,1),('2fd6a470a93882696e80d9de6264fb76','we',1496327817,'c87954eaea3ed578ea5606c103e21aeb',1,1),('3069efbbd0f53c9d0b840b960a5eb2fa','144: from 2 to 3 3069efbbd0f53c9d0b840b960a5eb2fa',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('31653a73d77f5f4ab7ffaffbff5d5ca7','148: from 3 to 1 31653a73d77f5f4ab7ffaffbff5d5ca7',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('317532b092f8cfded033eb69c61d17db','173: from 3 to 2 317532b092f8cfded033eb69c61d17db',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('31998f65fd383b98dd6d6d2dfda77ee0','98: from 3 to 1 31998f65fd383b98dd6d6d2dfda77ee0',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('329ac974beb047b58c51c16b90ecbbbb','28: from 3 to 2 329ac974beb047b58c51c16b90ecbbbb',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('3609fffd0588c784080c5a2aed36400b','11: from 3 to 1 3609fffd0588c784080c5a2aed36400b',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('3700f7b5b239dce37f3385ed93d8fe30','54: from 2 to 1 3700f7b5b239dce37f3385ed93d8fe30',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('37329aa146e91ddb1f85f4864bf8af77','111: from 2 to 3 37329aa146e91ddb1f85f4864bf8af77',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('39846aa138f5abe9fe11047d8e864051','ZZZZZZZZZ',1493572160,'650daf5b0807ada3e205349e2d48e82f',3,1),('3ae98efc0ec5d9f6ba775ae7aef1b2ba','168: from 3 to 1 3ae98efc0ec5d9f6ba775ae7aef1b2ba',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('3b9b2c09dea151832999908434b6ea56','93: from 1 to 2 3b9b2c09dea151832999908434b6ea56',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('3c46396e0d19de9091eab45746309643','Общий чат для праздника: Свадьба',1504794570,'2b4c9e5f0f0ac5e449bf9da0627feca7',16,1),('3d10426e0719c7a7b6acea4044e99b33','65: from 1 to 3 3d10426e0719c7a7b6acea4044e99b33',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('3f2fbdb2b9cf0d3873a674fd4aac7ac3','82: from 1 to 2 3f2fbdb2b9cf0d3873a674fd4aac7ac3',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('400cad23a1c35ece2ec4f6cf2b82dddf','143: from 2 to 3 400cad23a1c35ece2ec4f6cf2b82dddf',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('415218b28813730eb1a3ab04b16bc101','55: from 1 to 2 415218b28813730eb1a3ab04b16bc101',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('417e153f3698b775623956d7670ac5eb','197: from 3 to 1 417e153f3698b775623956d7670ac5eb',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('470be04477dc8995e1ccb98c63ecdc94','aa',1493879060,'650daf5b0807ada3e205349e2d48e82f',3,1),('47722eab960bcaeab7775ce5854a9d29','106: from 1 to 2 47722eab960bcaeab7775ce5854a9d29',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('49e290ccf23891e5324b5c6f1388c7bd','156: from 1 to 2 49e290ccf23891e5324b5c6f1388c7bd',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('4df02d1f11515691ac7ff77c5f8d8a03','Культура это хорошо',1496325823,'650daf5b0807ada3e205349e2d48e82f',1,1),('4e813435eb56ffaea3f5bd5d28557ddb','16: from 2 to 3 4e813435eb56ffaea3f5bd5d28557ddb',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('4f8c634731e3c0b121d2c628652495b8','привет3',1504795151,'2b4c9e5f0f0ac5e449bf9da0627feca7',15,1),('4faade94ed00c0bb84215c1b882c20fb','118: from 2 to 3 4faade94ed00c0bb84215c1b882c20fb',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('51a142d42ce5ba6323c40a7f611bec21','qwe',1493546163,'c87954eaea3ed578ea5606c103e21aeb',1,1),('522421a9eb737173b392e02945798b96','34: from 1 to 2 522421a9eb737173b392e02945798b96',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('52818e842aff9dcf18e71e550b7bb4da','41: from 1 to 3 52818e842aff9dcf18e71e550b7bb4da',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('5348dd7e1d0ee2bf52123aa51ebfb0a8','121: from 2 to 1 5348dd7e1d0ee2bf52123aa51ebfb0a8',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('53ddc3c4e4f9525cfeb34cfaadc6d295','7: from 2 to 1 53ddc3c4e4f9525cfeb34cfaadc6d295',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('5482059635c72b01a5ffe9fbefd330cb','asdasd',1493299668,'38d57ca87af07b563cd404af051ce87d',3,1),('572b7a01ed09fb5527eec2b006dcd082','31: from 1 to 3 572b7a01ed09fb5527eec2b006dcd082',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('577c31133b78b2c79fd99cd06c16e645','39: from 2 to 1 577c31133b78b2c79fd99cd06c16e645',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('57ca09189fc2d5a79753aa59d3b99de5','ww',1496327880,'c87954eaea3ed578ea5606c103e21aeb',1,1),('584fc10bb6c57de933148f359e504735','qq',1493545753,'c87954eaea3ed578ea5606c103e21aeb',1,1),('58ea6d309c6fe3680c16436f7fe6f536','35: from 1 to 2 58ea6d309c6fe3680c16436f7fe6f536',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('590e123ae52e93586ef099ade88c50c5','27: from 2 to 1 590e123ae52e93586ef099ade88c50c5',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('5925e4347fd1eae96b5396af3daf73a2','19: from 1 to 3 5925e4347fd1eae96b5396af3daf73a2',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('5985ab2efbe77151ae0cb2c77a665678','10: from 1 to 2 5985ab2efbe77151ae0cb2c77a665678',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('5d0771f053ae3990f8d8cd9377ac6716','аоптпал впрп ывурпквашеп влпралорп лачврпвыдаоывуша рвлпра',1504795080,'2b4c9e5f0f0ac5e449bf9da0627feca7',16,1),('5d34c0f976de823b794339df35e4f82b','139: from 3 to 2 5d34c0f976de823b794339df35e4f82b',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('5de83f59a6fe2d9d929f1992958e2bc9','fdsjhfsdh',1493882447,'650daf5b0807ada3e205349e2d48e82f',3,1),('5e49cfa069f65fe3aad643662217c95d','ту туруру трутруту',1493573556,'650daf5b0807ada3e205349e2d48e82f',1,1),('5f5dfbb5637592834d15c47874dfdbdb','dsa',1493493509,'c87954eaea3ed578ea5606c103e21aeb',1,1),('5ffd57a77f25439cb9ca664f9970c291','154: from 2 to 1 5ffd57a77f25439cb9ca664f9970c291',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('603a04504236ad4e22e2f8a5254c3144','57: from 3 to 2 603a04504236ad4e22e2f8a5254c3144',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('6054eca9c323da32a9a3766cb56b5c48','125: from 2 to 3 6054eca9c323da32a9a3766cb56b5c48',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('61067f4bea7909e1fa9d8b2242d7a86d','59: from 2 to 3 61067f4bea7909e1fa9d8b2242d7a86d',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('6130acb43c81a7509ba3fe8c57bcc212','5: from 2 to 1 6130acb43c81a7509ba3fe8c57bcc212',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('61799bea0ea184c9c46a42d3f6023d31','109: from 3 to 1 61799bea0ea184c9c46a42d3f6023d31',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('66b526a297dd9d108a27bf4e70d7172a','162: from 3 to 1 66b526a297dd9d108a27bf4e70d7172a',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('66c65c3446507f8e4c854c971bf7ba95','110: from 3 to 2 66c65c3446507f8e4c854c971bf7ba95',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('67c430675e905e9625cfa86a4171eb75','95: from 2 to 1 67c430675e905e9625cfa86a4171eb75',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('698fc78ce0f787f83f7dba0ef248ef1e','158: from 1 to 3 698fc78ce0f787f83f7dba0ef248ef1e',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('6ae5dd199f21f4e236776273bbf0e68c','138: from 3 to 2 6ae5dd199f21f4e236776273bbf0e68c',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('6af07808c5b91c329f73bfda674a7c43','20: from 2 to 1 6af07808c5b91c329f73bfda674a7c43',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('6af5b08ac76950233e13bcf069996733','ww',1496327790,'650daf5b0807ada3e205349e2d48e82f',1,1),('6b00652939163de509e37994b50fa867','GGG',1493712282,'c87954eaea3ed578ea5606c103e21aeb',1,1),('6b666539104d3f3409409ac508192871','155: from 2 to 1 6b666539104d3f3409409ac508192871',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('6e81a4fb2e648cf3d13075a11f4d5c32','161: from 1 to 3 6e81a4fb2e648cf3d13075a11f4d5c32',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('6f18eb87dca9e443a6fb976edc913e31','qweqw',1496327873,'c87954eaea3ed578ea5606c103e21aeb',1,1),('7040cde30342a72a5b1e3cf689e233e0','141: from 2 to 1 7040cde30342a72a5b1e3cf689e233e0',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('710c7dd5b95c5144035b124961a31ca4','www',1493493631,'c87954eaea3ed578ea5606c103e21aeb',1,1),('74ac1ca7f76fffdf8dd5beb9131755fa','14: from 2 to 1 74ac1ca7f76fffdf8dd5beb9131755fa',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('74cd7902498b978645d06e42ad4860e8','ggg',1493879491,'650daf5b0807ada3e205349e2d48e82f',3,1),('7763bdf208ddf96b8a5b1a6d5753192c','71: from 1 to 3 7763bdf208ddf96b8a5b1a6d5753192c',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('782122afdd8fcd7dc920d160bd681945','140: from 3 to 1 782122afdd8fcd7dc920d160bd681945',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('7899519d0fb83cf7bb27d31875b77229','24: from 1 to 2 7899519d0fb83cf7bb27d31875b77229',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('7960d6515c66b9dada46e182c3fa1ea2','Привет2',1504795066,'2b4c9e5f0f0ac5e449bf9da0627feca7',16,1),('798e76cd8656f69495734056a97d453c','hi',1493881165,'650daf5b0807ada3e205349e2d48e82f',3,1),('7aa85dc5ba4e00348e8c63a34e53af97','qweqweq',1493490695,'c87954eaea3ed578ea5606c103e21aeb',2,1),('7acaa7dbffb33dca6d91bbafb2b4362e','30: from 2 to 1 7acaa7dbffb33dca6d91bbafb2b4362e',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('7b909967e52569e4e824e39b1c42ed1f','46: from 2 to 1 7b909967e52569e4e824e39b1c42ed1f',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('7e100b68dbd67707df8134cb6ff1a0b8','sdasda',1493882249,'650daf5b0807ada3e205349e2d48e82f',3,1),('7e31a8ef4b60f501a4498fba80a0a228','3 from end',1492589945,'650daf5b0807ada3e205349e2d48e82f',1,1),('7f5f77484c84023731ecab2f0975e189','37: from 2 to 1 7f5f77484c84023731ecab2f0975e189',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('812d95c4b13cc8e7c34b7bc60a001a7b','хэй',1493573147,'650daf5b0807ada3e205349e2d48e82f',1,1),('81ab542032ee8188892b461d53b6859e','89: from 2 to 3 81ab542032ee8188892b461d53b6859e',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('81af9178174d74065c2f960376c1c996','73: from 1 to 2 81af9178174d74065c2f960376c1c996',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('81bc4dc91bfd9e23248a2be6c0c735d9','hi',1493881117,'650daf5b0807ada3e205349e2d48e82f',1,1),('829195ef0917d97186b890f2f11aff17','аопра впраг  ланршлп авлр',1504795157,'2b4c9e5f0f0ac5e449bf9da0627feca7',15,1),('830cf263e0b7a3683367b03f9e6a524f','29: from 2 to 1 830cf263e0b7a3683367b03f9e6a524f',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('846092e80ef020409f402464a9f80e6b','я не пишу матерных заметок исполнителям',1496325692,'650daf5b0807ada3e205349e2d48e82f',3,1),('846d69504460a97f9390c31870abf306','177: from 1 to 2 846d69504460a97f9390c31870abf306',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('8505170e8c46c6a587567530c4badcce','193: from 2 to 1 8505170e8c46c6a587567530c4badcce',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('858c5c4bc6a0f8e6af08d79fdf78f14a','c',1493545825,'c87954eaea3ed578ea5606c103e21aeb',1,1),('85fff3254602db44d9a74c88c10b52c1','aa',1494427696,'650daf5b0807ada3e205349e2d48e82f',1,1),('8608e0380800ddcf0ca58f8257909be3','200: from 2 to 1 8608e0380800ddcf0ca58f8257909be3',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('863e96413daa5f76d6e8a708c76ce44e','привет!',1493712426,'c87954eaea3ed578ea5606c103e21aeb',1,1),('8640eb4936cfca5eecdfaff1324be68d','!!',1496327827,'c87954eaea3ed578ea5606c103e21aeb',2,1),('886e9406db90a848070994b86e527669','парам пам пам!',1496333845,'267b7b49a4c51f9a57ae65dc48d1d74f',2,1),('8bf1951e9bff7a9cfd2d2476638aabfc','fff',1493880275,'650daf5b0807ada3e205349e2d48e82f',3,1),('8e73506ca01c511ab5f78d9393529136','Hi!',1493882223,'650daf5b0807ada3e205349e2d48e82f',1,1),('8eaf86c8499712153f39bdeb74d322e6','165: from 1 to 2 8eaf86c8499712153f39bdeb74d322e6',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('8eb716144c35fe7aa332374d36708e8a','ggg',1493879660,'650daf5b0807ada3e205349e2d48e82f',3,1),('8efe0f86cd3149a1a1eb548888712e4a','21: from 1 to 2 8efe0f86cd3149a1a1eb548888712e4a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('90dc289e27a9c221614619445f795286','YYZZZAAAAA!!!',1493882176,'650daf5b0807ada3e205349e2d48e82f',3,1),('90f1a1c9711eb6c58b29b5321641359e','164: from 3 to 2 90f1a1c9711eb6c58b29b5321641359e',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('951073f81b3adb68f59cebeb0eaceaf2','42: from 2 to 3 951073f81b3adb68f59cebeb0eaceaf2',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('957e4da4f951027bf379feca21593a87','q',1496327756,'c87954eaea3ed578ea5606c103e21aeb',2,1),('966a8a5704c916ef9c11de9d151cecac','44: from 1 to 2 966a8a5704c916ef9c11de9d151cecac',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('985f85f7d7ea7cc224eaa23538de97b8','160: from 2 to 3 985f85f7d7ea7cc224eaa23538de97b8',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('991645fcff36d3b06d5a6d14a7da4952','99: from 2 to 1 991645fcff36d3b06d5a6d14a7da4952',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('9a96fe1d2c131d1834fb6243e5c8e690','77: from 3 to 2 9a96fe1d2c131d1834fb6243e5c8e690',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('9c114bce59cbc693d32b5b654240220b','123',1493882455,'650daf5b0807ada3e205349e2d48e82f',3,1),('9dc91a70e18801a00c6cc4837b70ac41','Вот думаю, как быть',1493880297,'650daf5b0807ada3e205349e2d48e82f',3,1),('9f1c5b3c2c63eba26ed8b0ac6ccbe430','привет',1493573269,'650daf5b0807ada3e205349e2d48e82f',3,1),('9faa8754c2a30a51096685d6a661f5cf','53: from 3 to 2 9faa8754c2a30a51096685d6a661f5cf',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('9fdadbc0adf9efb9883b261f82153df5','qwe last',1492546217,'650daf5b0807ada3e205349e2d48e82f',1,1),('a08383baafb70294e667649557ec4bd8','75: from 1 to 3 a08383baafb70294e667649557ec4bd8',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('a20c1e3bf4f0d77af0c39709beafcb0c','163: from 2 to 3 a20c1e3bf4f0d77af0c39709beafcb0c',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('a25f7d6e33d95771fbea93c5e547daa8','149: from 1 to 3 a25f7d6e33d95771fbea93c5e547daa8',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('a2aee6823e9b62b6650a98919a93183a','e',1493493654,'c87954eaea3ed578ea5606c103e21aeb',1,1),('a3dd9bbf3be3423cb5cf2fb9374c614d','хеллоу\n\nайцоаыво',1496333729,'267b7b49a4c51f9a57ae65dc48d1d74f',1,1),('a4016031591dafe8ef622bd1a34c2f6f','49: from 1 to 3 a4016031591dafe8ef622bd1a34c2f6f',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('a4c535ecec15b3805a7e2f71cea2b0bb','fdsjhfsdh',1493882445,'650daf5b0807ada3e205349e2d48e82f',3,1),('a4c60b136af0bd46db9b055b07227d21','Привет!',1493573074,'650daf5b0807ada3e205349e2d48e82f',3,1),('a50cbb02e1a93329a33baa48355a9eb3','122: from 3 to 2 a50cbb02e1a93329a33baa48355a9eb3',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('a813400337d8901770764cd5d5bbc747','t',1493493701,'c87954eaea3ed578ea5606c103e21aeb',1,1),('aa2f5930a0afc93fbd5588fc167327ed','ZZZZZZZZZZZZZZZZ',1496327857,'c87954eaea3ed578ea5606c103e21aeb',1,1),('aaa9b203002cdef42997930c1d5a2b1d','120: from 1 to 2 aaa9b203002cdef42997930c1d5a2b1d',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('ab3392426a46ceb02037b6e42e98b409','104: from 1 to 2 ab3392426a46ceb02037b6e42e98b409',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('abc17b8d93de70e683357e5ce297f8d4','хай',1493573298,'650daf5b0807ada3e205349e2d48e82f',1,1),('ac3961be067791337a51ec393cfe3114','4: from 3 to 2 ac3961be067791337a51ec393cfe3114',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('ae219c648d383415aeac7a41383fdd81','Привет1',1504794619,'2b4c9e5f0f0ac5e449bf9da0627feca7',17,1),('ae24ad21c287076254626c851c2eabca','74: from 2 to 1 ae24ad21c287076254626c851c2eabca',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('b14d416a3c50be09cf6d74fd8189b557','4 from end',1492589994,'650daf5b0807ada3e205349e2d48e82f',1,1),('b308fd2a80fa6e7d2535f515444e0a27','ЙЙЙ!',1498047553,'c87954eaea3ed578ea5606c103e21aeb',1,1),('b3a11fa9f565ee62ea460954410bcb4c','112: from 3 to 1 b3a11fa9f565ee62ea460954410bcb4c',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('b420658ed188fccff7ddc4546323449e','167: from 2 to 3 b420658ed188fccff7ddc4546323449e',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('b446df0e82878efcc830e8f6ac852e58','Ааа, ну так это как всегда. Конечно быть...! :) &lt;script&gt;alert(123)&lt;/script&gt;',1493880787,'650daf5b0807ada3e205349e2d48e82f',1,1),('b44c5c919d156be3d4b76f5731790a43','38: from 2 to 1 b44c5c919d156be3d4b76f5731790a43',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('b754b5103a8b2ccf47739f71b78d9c17','Hi !',1493491526,'c87954eaea3ed578ea5606c103e21aeb',1,1),('b9ee24577af5f843efc63cd9cdae4df4','xxx',1493712114,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bb20125112039989496312444a31f077','88: from 1 to 2 bb20125112039989496312444a31f077',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bb38d70b694d1dc37a5a97fd50872b9b','asd',1493882248,'650daf5b0807ada3e205349e2d48e82f',3,1),('bb4fdc6b1f47ddadc8a67b5df6eb6d5a','12: from 1 to 2 bb4fdc6b1f47ddadc8a67b5df6eb6d5a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bd7855337111c646cbd75f9d5090cebc','36: from 2 to 1 bd7855337111c646cbd75f9d5090cebc',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('be7c137a666c2196d91d3689f1472a1d','194: from 1 to 2 be7c137a666c2196d91d3689f1472a1d',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bed90c013178a3d91cbed1bb800b07d8','183: from 1 to 3 bed90c013178a3d91cbed1bb800b07d8',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('bfdd79b220de6176b60dd16289399046','117: from 3 to 1 bfdd79b220de6176b60dd16289399046',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('c20d29f548905909fe568041a480b950','да ладно, норм.',1496325869,'650daf5b0807ada3e205349e2d48e82f',3,1),('c30cc12f54dfd611d53752b10ad59378','Y!',1493572746,'650daf5b0807ada3e205349e2d48e82f',3,1),('c4b319f175d14b74baed8dcd8ffbd2c6','107: from 1 to 2 c4b319f175d14b74baed8dcd8ffbd2c6',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('c60314aa23e5f22350f257be045b62a8','186: from 2 to 3 c60314aa23e5f22350f257be045b62a8',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('c7f9f98ae26de37ae491d1ba6f556706','Думаю, быть или не быть!',1493880763,'650daf5b0807ada3e205349e2d48e82f',3,1),('c7fbd4326ef839469154640a86c4fcfa','159: from 1 to 2 c7fbd4326ef839469154640a86c4fcfa',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('c89600240baf5612a3ef9dee021b8c75','151: from 1 to 3 c89600240baf5612a3ef9dee021b8c75',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('c8f95f95cd90b11bf617dd7df1b8775f','Hi !',1496333403,'267b7b49a4c51f9a57ae65dc48d1d74f',1,1),('c9001b2fd4019bc2bc51fcad19d3941a','yyy',1493493703,'c87954eaea3ed578ea5606c103e21aeb',1,1),('c922a78da9d635e75cbf9ffa2bc64b0b','first',1492590027,'650daf5b0807ada3e205349e2d48e82f',3,1),('c93925c4161a57dbd2226033e397a0e1','196: from 3 to 2 c93925c4161a57dbd2226033e397a0e1',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('ca0f4de6bccdeb42cf4e9cf065f3fa99','83: from 2 to 3 ca0f4de6bccdeb42cf4e9cf065f3fa99',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('ce83a79453d4b303d1eca581d6d508b3','QQQ',1493712150,'c87954eaea3ed578ea5606c103e21aeb',1,1),('cfa6a4fe85df876ecf9b64436a88b3b3','6: from 1 to 2 cfa6a4fe85df876ecf9b64436a88b3b3',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('d0a832607e678f4834991dc36bb3a197','105: from 2 to 1 d0a832607e678f4834991dc36bb3a197',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('d17a7156caaa9efca006da1e5381ab8d','eee',1493879584,'650daf5b0807ada3e205349e2d48e82f',3,1),('d1b11c486c034535fb309672ab9ca8da','GGG',1493572283,'650daf5b0807ada3e205349e2d48e82f',1,1),('d1faf3afd36158f70bcf734891e14a9f','114: from 3 to 2 d1faf3afd36158f70bcf734891e14a9f',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('d47da539cfae0dfb602572bd5ddc9d48','asdasd',1493882456,'650daf5b0807ada3e205349e2d48e82f',3,1),('d55ec3f2f94a2e33b9203e14f4e7e2c3','йцу',1493573686,'650daf5b0807ada3e205349e2d48e82f',3,1),('d5a2fe35d7f2be93de0b4a17c2e292cc','qqq',1493572972,'650daf5b0807ada3e205349e2d48e82f',1,1),('d725d2f89ec945de2dc99681dd4a0327','174: from 2 to 1 d725d2f89ec945de2dc99681dd4a0327',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('d76f6bbb46186ff04dad4e54d987c8fb','Hola',1493882233,'650daf5b0807ada3e205349e2d48e82f',3,1),('d78255d7d9943898469ee5aaaa42a1f2','ffff',1493573713,'650daf5b0807ada3e205349e2d48e82f',1,1),('d7e32578df1173c5227550a1b6375e53','132: from 1 to 2 d7e32578df1173c5227550a1b6375e53',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('d9826b19fba5acddea06781cd129fc67','cvbv',1496327891,'c87954eaea3ed578ea5606c103e21aeb',1,1),('da004fe93a9afb59413c3ccf28ac4367','Что случилось ?',1493880736,'650daf5b0807ada3e205349e2d48e82f',1,1),('dacd0646f8402e4237abac9a2a22d8b8','хер да маленько',1493573537,'650daf5b0807ada3e205349e2d48e82f',1,1),('daf427c644499b15fdde738b14816463','adad',1493882433,'650daf5b0807ada3e205349e2d48e82f',3,1),('db346fd766ed87249bc541ba9df764ab','ff',1493545858,'c87954eaea3ed578ea5606c103e21aeb',1,1),('dd921ce6ada61c75e2a22c109f971a54','195: from 1 to 3 dd921ce6ada61c75e2a22c109f971a54',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('ddacc7613875e6d5afe56328691d447f','169: from 1 to 2 ddacc7613875e6d5afe56328691d447f',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('dec5ff38dbe187378a5108c4154d6040','w',1493546142,'c87954eaea3ed578ea5606c103e21aeb',1,1),('ded19d9994bc3584b7149239dfc8799c','96: from 2 to 1 ded19d9994bc3584b7149239dfc8799c',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('dfb93c03c9824a3d45db079276526e3f','sdads',1493882435,'650daf5b0807ada3e205349e2d48e82f',3,1),('e120801503e2f800601f513779649418','qqq',1493493579,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e15392f95207eaddffcd6b55c26db459','TT',1493712332,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e19c08575c647dbc9d01a022305c533f','56: from 1 to 3 e19c08575c647dbc9d01a022305c533f',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('e21e327f2b46947d21cb891bcf6e4d95','185: from 1 to 2 e21e327f2b46947d21cb891bcf6e4d95',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e37f69cb940affc6908a943eb3894ac6','pre last',1492546532,'650daf5b0807ada3e205349e2d48e82f',3,1),('e7a84932fcaad1258b8c7620ad8abbe1','187: from 1 to 2 e7a84932fcaad1258b8c7620ad8abbe1',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e85bc246f2bcefd66f9bd760c77d86ba','fdsjhfsdh',1493882450,'650daf5b0807ada3e205349e2d48e82f',3,1),('e92e9c2e7b266d9f165bee783afa363c','60: from 2 to 1 e92e9c2e7b266d9f165bee783afa363c',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('e936be2b43c7d43b87f317af76a85a5e','198: from 1 to 3 e936be2b43c7d43b87f317af76a85a5e',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('e9e84f54dcc24e33cfdc9f5c5ae26b11','145: from 2 to 3 e9e84f54dcc24e33cfdc9f5c5ae26b11',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('ec30edde932e5a47a4e26fe9ce49c333','116: from 2 to 1 ec30edde932e5a47a4e26fe9ce49c333',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('ec8c7d1ae2f07776289d3d2f8ac8a101','eee',1493880000,'650daf5b0807ada3e205349e2d48e82f',3,1),('ee36de8295bf6e8902449f819c31e26f','191: from 1 to 3 ee36de8295bf6e8902449f819c31e26f',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('eeac24af06e6ce9e4e4db8f4e5996550','ППП',1493573449,'650daf5b0807ada3e205349e2d48e82f',3,1),('ef426ebaafee17c365facd0b37bcff61','q',1493566459,'c87954eaea3ed578ea5606c103e21aeb',1,1),('ef82e0ca38bff7ede56d77f9f8b5cd95','128: from 2 to 1 ef82e0ca38bff7ede56d77f9f8b5cd95',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('efff27bbe591b2d11bd9bc5ea9350783','йцу',1498047439,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f066322ed0530a5654f4bf0e09c34308','привет !',1493880292,'650daf5b0807ada3e205349e2d48e82f',3,1),('f0f32ec53d26baa43151cfa26b742661','81: from 2 to 3 f0f32ec53d26baa43151cfa26b742661',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f4aa1be4ef86cf5fdb972f35ad285f8c','124: from 1 to 2 f4aa1be4ef86cf5fdb972f35ad285f8c',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f529ecc180e308da063254358841cb6c','SSDD',1496327837,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f5689e2ebaa290e2c9f2bf3ff53f15d2','я не совсем понял',1496325924,'650daf5b0807ada3e205349e2d48e82f',1,1),('f56ea979c68e491395c948a12016d81b','9: from 2 to 3 f56ea979c68e491395c948a12016d81b',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f66374ea744c4a6db1b6c7bd20613d18','184: from 2 to 3 f66374ea744c4a6db1b6c7bd20613d18',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f6bf7bcc0a46117e34fae36662ecfa7f','r',1493493697,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f747797a08a16d40ac65ed23197f2d4c','63: from 2 to 3 f747797a08a16d40ac65ed23197f2d4c',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f78be00cc02b8bb124c11a5b74c60306','0: from 3 to 2 f78be00cc02b8bb124c11a5b74c60306',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('f913a088866a9f3e6ba418718b4f6ff5','170: from 1 to 3 f913a088866a9f3e6ba418718b4f6ff5',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('f9de5b44c13a1e69dd76c3d242e1972a','91: from 1 to 2 f9de5b44c13a1e69dd76c3d242e1972a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f9f16a56a0d4563afa12ab3885246f8a','126: from 2 to 1 f9f16a56a0d4563afa12ab3885246f8a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('facf7240adbc02ad8ed2e3dae04f2e78','192: from 3 to 2 facf7240adbc02ad8ed2e3dae04f2e78',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'safe 1','qqq',130,1496418410,3,1,1497023197,1497023197,1497023197,2,5,2,1,0,2,0,'',0),(5,'safe 2','www',110,1496419851,3,1,1497024499,1497024499,1497024499,2,6,2,1,0,3,0,'',0),(7,'safe 3','eee',200,1496420940,3,1,1497025706,1497025706,1497025706,3,10,2,1,0,4,0,'',0),(17,'safe vip','qqq',600,1496646724,6,1,1497250823,1497250823,1497250823,2,5,2,1,1,2,0,'',1496646724),(18,'safe test 1','qwe',175,1496659350,3,1,1497264083,1497264083,1497264083,1,3,2,1,0,3,0,'',0),(19,'111','qqq',500,1496666868,4,1,1497271658,1497271658,1497271658,1,1,2,0,0,1,0,'',0),(20,'222','444',444,1496666882,4,1,1497271671,1497271671,1497271671,2,6,2,1,0,2,0,'',0),(22,'333','333',333,1496666935,4,1,1497271686,1497271686,1497271686,3,9,2,1,1,4,0,'',1496666935),(23,'Ведущий на др','йцуй',1000,1496678905,4,3,1497283691,1497283691,1497283691,2,4,2,0,0,1,0,'',0),(25,'   Фотобудка       ','йцуйцуйявчвс',150,1496678941,4,3,1498856400,1498856400,1498856400,1,3,2,1,0,2,0,'',0),(27,'Теплоход','Тег <form> устанавливает форму на веб-странице. Форма предназначена для обмена данными между пользователем и сервером. Область применения форм не ограничена отправкой данных на сервер, с помощью клиентских скриптов можно получить доступ к любому элементу формы, изменять его и применять по своему усмотрению.\n\nДокумент может содержать любое количество форм, но одновременно на сервер может быть отправлена только одна форма. По этой причине данные форм должны быть независимы друг от друга.\n\nДля отправки формы на сервер используется кнопка Submit, того же можно добиться, если нажать клавишу Enter в пределах формы. Если кнопка Submit отсутствует в форме, клавиша Enter имитирует ее использование.\n\nКогда форма отправляется на сервер, управление данными передается программе, заданной атрибутом action тега <form>. Предварительно браузер подготавливает информацию в виде пары «имя=значение», где имя определяется атрибутом name тега <input>, а значение введено пользователем или установлено в поле формы по умолчанию. Если для отправки данных используется метод GET, то адресная строка может принимать следующий вид.',20000,1496678984,4,2,1497283766,1497283766,1497283766,3,10,2,0,0,1,0,'',0),(32,'Коттедж','счсимчсм',15000,1496679238,4,2,1497283801,1497560400,1498251599,3,9,2,0,1,5,0,'',1496679238),(33,'1123','qqq',2321321,1500467671,5,2,1501072451,1504126800,1504213199,2,5,2,0,0,2,0,'',0),(34,'QQQQQ','ffff',1111,1500468295,5,2,1501073072,1504990800,1506200399,2,6,2,0,0,1,0,'',0),(35,'QWEQWEQW','qweweqeqw',111,1500469329,5,2,1501074075,1504126800,1504213199,1,1,2,0,0,2,0,'',0),(39,'ведущий для 123','010110101010',2000,1500558002,5,15,1501162264,1501162264,1501162264,2,4,2,0,0,4,0,'997ea17267919e5cf67680a6ffef02c8',0),(40,'blocked user','qq',0,1500656839,4,2,1501261626,1501261626,1501261626,1,2,2,0,0,3,0,'',0),(42,'QQQQQ!!!!!!','HHHHHHH',500,1500887892,4,1,1501492676,1501492676,1501492676,1,3,2,1,0,5,0,'',0),(43,'фотосессия','фоточки фоточки',20000,1504189416,4,15,1506027600,1506027600,1506027600,1,1,2,0,0,2,0,'',0),(44,'Дом в лесу на сутки','тест тест тест',15000,1504190459,4,15,1506718800,1506718800,1506718800,3,9,2,0,1,2,0,'',1504190459),(45,'костюм Бэтмена','хочу пугать людей',2000,1504190536,4,15,1506718800,1506718800,1506718800,6,23,2,0,0,2,0,'',0),(46,'Костюм Бэтмена','Хочу пугать людей',2000,1504190594,4,15,1506718800,1506718800,1506718800,6,23,2,1,1,2,0,'',1504190594),(47,'Ноготки','ноготки',5000,1504257090,1,15,1513285200,1513285200,1513285200,7,15,2,1,0,4,0,'',0),(48,'Оркестр на юбилей','Духовой оркестр',30000,1504259372,4,15,1508965200,1508965200,1508965200,2,5,2,0,0,3,1,'',0),(49,'юбилей','Нужен лимузин на свабьбу',6000,1504259470,4,15,1508360400,1508360400,1508360400,8,19,2,1,0,2,0,'',0),(50,'свадебный торт','свадебный торт',5000,1504260405,4,15,1506718800,1506718800,1506718800,9,21,2,0,0,2,0,'',0),(51,'вечерний макияж','накрасить утром',2000,1504260469,4,15,1506027600,1506027600,1506027600,7,16,2,0,1,4,0,'',1504260469),(52,'Оформление зала','Оформление выставки',50000,1504261117,4,15,1511125200,1511125200,1511125200,5,25,2,0,0,2,0,'',0),(53,'обслуживание выездного банкета','банкет на озере',62000,1504262422,4,15,1511384400,1511384400,1511384400,9,22,2,0,1,6,0,'',1504262422),(55,'теплоход по неве','теплоход по неве',15000,1504270825,4,15,1511989200,1511989200,1511989200,3,10,2,0,1,5,0,'',1504270825),(56,'1212131','sa',111,1504598172,3,1,1505202955,1505202955,1505202955,3,9,2,0,1,5,0,'',1504598172),(57,'w13412','sadasdasd',23213,1504598191,1,1,1505202980,1505202980,1505202980,7,16,2,0,0,1,0,'',0),(58,'qweqweqw','zdfzs',222,1504598206,1,1,1505202995,1505202995,1505202995,5,25,2,0,0,1,0,'',0),(59,'EWR','zdfzs',2213,1504598233,4,1,1505203009,1505203009,1505203009,9,22,2,1,1,0,0,'',1504598233),(60,'111','aa',0,1504601397,4,1,1505206189,1505206189,1505206189,1,1,2,0,0,1,0,'',0),(61,'222','qq',0,1504601410,4,1,1505206200,1505206200,1505206200,1,2,2,0,0,1,0,'',0),(62,'333','ww',0,1504601422,4,1,1505206213,1505206213,1505206213,2,6,2,0,1,1,0,'',0),(63,'444','ee',0,1504601434,4,1,1505206225,1505206225,1505206225,2,5,2,0,0,1,0,'',0),(64,'555','rrr',0,1504601447,4,1,1505206237,1505206237,1505206237,2,4,2,1,0,1,0,'',0),(65,'666','ttt',0,1504601481,4,1,1505206270,1505206270,1505206270,3,7,2,0,1,1,0,'',0),(66,'777','yyy',0,1504601491,4,1,1505206283,1505206283,1505206283,3,8,2,0,0,1,0,'',0),(67,'888','uuu',0,1504601502,4,1,1505206293,1505206293,1505206293,3,9,2,0,0,2,0,'',0),(68,'999','iii',0,1504601514,2,1,1505206304,1505206304,1505206304,3,10,2,0,0,3,0,'',0),(69,'1010','ooo',0,1504601531,4,1,1505206318,1505206318,1505206318,5,25,2,0,0,1,0,'',0),(70,'Торт с мясом','ццц',1002,1504620913,1,1,1505225671,1505225671,1505225671,9,21,2,0,0,1,0,'',0),(71,'День рождения','Фотограф на два дня',10000,1504776273,3,16,1510520400,1510520400,1510520400,1,1,2,0,0,6,0,'72740b7664199f45d2cb59b0a7b816ca',0),(72,'День рождения','Ведущий',10000,1504776328,4,16,1510088400,1510088400,1510088400,2,4,2,0,0,1,0,'72740b7664199f45d2cb59b0a7b816ca',0),(73,'Оркестр на ДР','Оркестр на ДР',20000,1504776367,4,16,1511298000,1511298000,1511384399,2,5,2,0,0,3,0,'72740b7664199f45d2cb59b0a7b816ca',0),(74,'Аренда коттеджа на 2 дня','Аренда коттеджа на 2 дня',0,1504776448,1,16,1510002000,1510002000,1510002000,3,9,2,0,0,1,0,'72740b7664199f45d2cb59b0a7b816ca',0),(75,'Оформление цветами зала','Оформление цветами зала',0,1504776727,3,16,1511298000,1511298000,1511384399,5,25,2,0,0,3,0,'72740b7664199f45d2cb59b0a7b816ca',0),(76,'фотограф на свадьбу','крутой фотограф',5000,1504783302,3,16,1513630800,1513630800,1513630800,1,1,2,0,0,3,0,'d39776f90252c5325a202dc8dc2cde9e',0),(77,'Прическа невесты','Прическа невесты',5000,1504783439,3,16,1513803600,1513803600,1513976399,7,17,2,0,0,3,15,'d39776f90252c5325a202dc8dc2cde9e',0),(78,'тест 1000002','хочу в коттедж',5000,1507124350,1,15,1513112400,1514581200,1514667599,3,9,2,0,0,1,0,'d52b85fbc44f177c819c539489a04f76',0),(79,'тест 1003','все в лес',0,1507124497,1,15,1513198800,1514581200,1514667599,1,1,2,0,0,2,0,'d52b85fbc44f177c819c539489a04f76',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds`
--

LOCK TABLES `project_responds` WRITE;
/*!40000 ALTER TABLE `project_responds` DISABLE KEYS */;
INSERT INTO `project_responds` VALUES (1,1,3,1496418440,'ййй',0,5,1496418577),(2,5,3,1496419898,'ццц',145,5,1496419923),(3,7,3,1496420960,'ууу',250,5,1496422569),(4,18,3,1496659386,'qqq',225,5,1496660348),(5,56,15,1504786255,'2000',2000,5,1504801163),(6,68,15,1504786294,'2000',2000,3,1504801092),(7,71,15,1504786334,'2000',2000,5,1504797067),(8,77,15,1504786534,'5000',5000,5,1504795598),(9,71,17,1504793292,'test test test',5000,1,0),(10,76,17,1504793362,'fdhgngvnv ghgfh hdfgd sdsad fg',3000,5,1504795559),(11,75,15,1504796607,'цветы цветы цветы',80000,5,1504796721);
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
INSERT INTO `project_responds_statuses` VALUES (1,'Опубликован'),(2,'Отказано пользователем'),(3,'Выбран исполнителем'),(4,'Заблокирован'),(5,'Выполнен');
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
INSERT INTO `settings` VALUES ('vip_cost',250);
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
-- Table structure for table `userStates`
--

DROP TABLE IF EXISTS `userStates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userStates` (
  `state_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `stateName` varchar(255) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userStates`
--

LOCK TABLES `userStates` WRITE;
/*!40000 ALTER TABLE `userStates` DISABLE KEYS */;
INSERT INTO `userStates` VALUES (1,'Активен'),(2,'Не активирован'),(3,'Заблокирован'),(4,'Удалён');
/*!40000 ALTER TABLE `userStates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userTemplates`
--

DROP TABLE IF EXISTS `userTemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userTemplates` (
  `template_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `templateName` varchar(255) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userTemplates`
--

LOCK TABLES `userTemplates` WRITE;
/*!40000 ALTER TABLE `userTemplates` DISABLE KEYS */;
INSERT INTO `userTemplates` VALUES (1,'Общие'),(2,'Администратор');
/*!40000 ALTER TABLE `userTemplates` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_calendar`
--

LOCK TABLES `user_calendar` WRITE;
/*!40000 ALTER TABLE `user_calendar` DISABLE KEYS */;
INSERT INTO `user_calendar` VALUES (9,3,1497264083,0,0),(10,3,1497264083,0,0),(11,15,1504645200,1,0),(12,15,1504731600,1,0),(13,15,1504818000,1,0),(14,15,1504904400,1,0),(15,15,1505422800,1,0),(16,15,1505509200,1,0),(17,15,1506027600,1,0),(18,15,1506114000,1,0),(21,17,1513630800,0,0),(22,17,1513630800,0,0),(29,15,1505202955,0,0),(30,15,1505202955,0,0);
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
INSERT INTO `user_notes` VALUES ('',1,2,1492612086),('',1,3,1496322497),('пидр\n\nqwe',3,1,1493228471),('гут!',15,3,1507126258);
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
INSERT INTO `user_readed_log` VALUES (1,'project_respond',1),(1,'project_respond',2),(1,'project_respond',3),(1,'project_respond',4),(1,'project_respond',5),(1,'project_respond',6),(1,'user_respond',6),(1,'user_respond',7),(1,'user_respond',8),(1,'user_respond',9),(1,'warning',6),(2,'warning',2),(2,'warning',3),(2,'warning',4),(2,'warning',7),(3,'project_respond',1),(3,'project_respond',2),(3,'project_respond',3),(3,'project_respond',4),(3,'user_respond',1),(3,'user_respond',2),(3,'user_respond',3),(3,'user_respond',4),(15,'project_respond',5),(15,'project_respond',6),(15,'project_respond',7),(15,'project_respond',8),(15,'project_respond',9),(15,'project_respond',11),(15,'user_respond',6),(15,'user_respond',7),(15,'user_respond',8),(15,'user_respond',9),(15,'warning',5),(16,'project_respond',7),(16,'project_respond',8),(16,'project_respond',9),(16,'project_respond',10),(16,'project_respond',11),(17,'project_respond',5),(17,'project_respond',7),(17,'project_respond',9);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_responds`
--

LOCK TABLES `user_responds` WRITE;
/*!40000 ALTER TABLE `user_responds` DISABLE KEYS */;
INSERT INTO `user_responds` VALUES (1,3,1,1,'qqq',1496418577,10),(2,3,5,1,'www',1496419923,10),(3,3,7,1,'eee',1496422569,10),(4,3,18,1,'qweasd',1496660348,9),(5,17,76,16,'ок',1504795559,9),(6,15,77,16,'так себе',1504795598,6),(7,15,75,16,'завяло всё',1504796721,4),(8,15,71,16,'гут!',1504797067,7),(9,15,56,1,'Отлично',1504801163,10);
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
  `balance` mediumint(7) NOT NULL,
  PRIMARY KEY (`wallet_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_wallets`
--

LOCK TABLES `user_wallets` WRITE;
/*!40000 ALTER TABLE `user_wallets` DISABLE KEYS */;
INSERT INTO `user_wallets` VALUES ('17c03c1e79d2db017ea9f156230e43f6',15,0),('2c3722e3571dc3c7f45760cf94999ad9',17,0),('3541e16430b0dc449a3ceecb3fa5e122',22,0),('44e22e8b54546672144205bbefa8d58c',19,0),('4a049e3e38588d4c6692df204b8fb215',1,16460),('57cb17194f4fb310043ccf6c946d916a',14,0),('69657e51bdc1543235f9bfd89f3a14e8',3,600),('7b385a53660e62b841295bff498012f6',13,0),('84dc334e2367beffe5d6dfbc832f57ba',2,7700),('95efe3906b6b47e67acb98aa895c759a',21,0),('a6d30552d02a32033b41bd338e9f2905',20,0),('eb8cd59184ce977e9cdc62a21e3b8419',16,0),('fefcaa60360f0125b80d0fcf2646ec57',8,0);
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
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `telegram` varchar(75) NOT NULL,
  `city_id` int(4) NOT NULL,
  `country_id` int(11) NOT NULL,
  `registered` int(10) NOT NULL,
  `type_id` tinyint(1) NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `last_login` int(10) NOT NULL,
  `as_performer` tinyint(1) NOT NULL,
  `status_id` smallint(1) NOT NULL,
  `template_id` smallint(5) NOT NULL,
  `rating` int(11) NOT NULL,
  `site` varchar(255) NOT NULL,
  `gps` varchar(255) NOT NULL,
  `gps_point` point NOT NULL,
  `signature` varchar(140) NOT NULL,
  `rezume` varchar(2048) NOT NULL,
  `birthday` int(10) NOT NULL,
  `rek_last_name` varchar(100) NOT NULL,
  `rek_first_name` varchar(100) NOT NULL,
  `rek_second_name` varchar(100) NOT NULL,
  `rek_inn` varchar(32) NOT NULL,
  `rek_ogrnip` varchar(32) NOT NULL,
  `rek_ras_schet` varchar(32) NOT NULL,
  `rek_kor_schet` varchar(32) NOT NULL,
  `rek_bik` varchar(32) NOT NULL,
  `ts_project_responds` int(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'GUEST','0-','0-','','GUEST','','','','',0,0,1492371605,1,'::1',0,0,3,1,0,'','','','','',0,'','','','0','0','0','0','0',0),(1,'admin@weedo.ru','4052a28f3e6dd1985e5a914959366a7c2928c7f24b9eb2735d020bd318de7eaae0f361c3e970c993302a2592ffe4296ff0c4be937b8ac6a40c53a88ffc93f050','390e7342f25f7547ad72477ed1c6109b08d204057710fe8807e57096b33fd8e80f200d5464413b3a73c565aee5b0eac02563e313e734492b0268c90bc40489ed','WEEDO COMPANY Z','Тетерин','Евгений','WEEDO COMPANY','79312553075','t.me/e.teterin',2,1,1492271605,2,'85.143.184.138',1512052884,1,1,2,0,'','59.9843134170805,30.20952701568604','\0\0\0\0\0\0\0��g���M@\0\0��5>@','Halliluyah!!!','ХЗ!',-178426800,'','','','','','','','',1503503305),(2,'manager@weedo.ru','c4e47d8a39278de06599df99e7858b58478dbcc6e5e62d29c594af5b7213ca88bbfd88c1dd7181f37cd4fe5c3293fc3bd04fbcb74bd44a27cf30376554639822','848bd526cde43789fec3e8e6987959a4a5db37becd8a17d07804386fb52a84ab5595b07f2d00dae3b854a9692055b17f9329093457105b5ed0887543626d54f7','Manager 1','Менеджер 1','','Manager Company','','',2,1,1492171605,2,'127.0.0.1',1500888063,1,1,1,0,'','60.047146433033355 30.133438110351566','\0\0\0\0\0\0\0+\0��N@\0\0\0)\">@','','Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! ',0,'','','','','','','','',1496333789),(3,'demo','2a04e3d3ff6353d201fd021ff9795b2a389de6ed973e40ce6357e669abd63b58b0f79482e58d0bfd2285bc6ecaba3c00c3169c53b6cc182331c5ff423c4cb282','e31c083c156a6014a56da3f6657a075ff39fefa38ab675e2c1593b724ac59d20c58c2f9840a8357b6e0df6c258f3ce8c0889099c3931b7b98eb933bc21a69b1f','Гранат и Компания!','Демо','','&lt;script&gt;alert(1)&lt;/script&gt;','','',2,1,1491971605,1,'127.0.0.1',1496678957,1,3,1,0,'','59.96057488864537,30.370674133300785','','Лучшее световое шоу!','Лучшее световое шоу в России и странах СНГ!',580593600,'','','','','','','','',1496678955),(15,'jev.chern@gmail.com','c31f8225edbc213a2eb4cf89e9540c62e670f3cb7b17835a84e06ca80dffbc7c5ae3e887ff52b05b7b2fc7c4831f111580d60bc308d4e8377e93ba98c1deca04','696f39f8a3bd8c242f4fcd9c111f8768ccb454941902cdae3c1906fbcd2994c256fb5cbfe793e1d92bb21d3713b97f77a580b9d01241beffa5c57d99bb59a978','Женя','','','','','',2,1,1500473128,2,'83.68.44.33',1511769237,1,1,2,0,'','59.92750007133506,30.314712524414066','\0\0\0\0\0\0\0���R��M@\0\0\0�P>@','','тест тест тест',489873600,'','','','','','','','',1504102364),(16,'info@mskiso.ru','ed58e330db7c97502d51cad6ffd2f673c9bb9023d8c58646ab594a8f7f62ef4bc29fc61d4fad5ca726dbfecbfe3eb40fb199bf100e9e55c684f3ba73c693c4fe','0074385ee6e2c6c1267c851c1877903d39718e81dd80d6a6141fa2206e061446d19cc1e98f713279c9a4785bc44cffaa07d677ee7c5c2cf05f641b43ab32bed8','Анна Попова','','','','','',2,1,1504708313,1,'83.68.44.33',1507204806,0,1,1,0,'','','','','',632005200,'','','','','','','','',0),(17,'evgenya.chern@yandex.ru','57a5864a3d75a9732d77f7f26b282930906f11d4b0464a3de1ee6cf9b942c61fcd17584626528dbd974664e8a62287faf82658675fe1ea35f0fa4b19917cf22c','d3766f37bfcc56af03a2aefb9176bbfcf7f565c1110cce02fe114fcdb20d885b5ed04c97ff0aac57caba4d40ac93c580b137876be3bc25130bb4109fff673398','Евгения','','','','','',2,1,1504788569,2,'83.68.44.33',1504795363,1,1,1,0,'','59.934360698501514,30.358657836914066','\0\0\0\0\0\0\0�]�!��M@\0\0\0�[>@','','',412462800,'','','','','','','','',0),(19,'info@kokoso.ru','df1ac600dcca3b9d8a24fecc6ea868a648fcd6d04c449e6af71523b595b8a2a7318179974873d91f316380ff540e47949eee2bb8f716b3bc674a478d4c7660b8','607ebe9f2d90d22881690bf10261cfea66900f46f3253b081aee06432914065c5325a9811e34c848ea3dddc3f2a359f7484c7c32bcce69a3f8b944036b767107','info','','','','','',2,1,1507130198,1,'83.68.44.33',1507202171,0,1,1,0,'','','','','',0,'','','','','','','','',0),(20,'manager@mskiso.ru','5840b9f0f69c47be8abd3d31a365f290d61214c5033b646f3b096e92e8f5486f8c88231c14e776d647a64009d495739346df140e4d5e8ded058c5f14d97327b5','3476e9f4dfa21b706ecf17dd035d624cf0bbaeecfbde18f02bb6fc37b2995c2ffc3cebd53921fae8e6501bfa7b9885d28f3fe8b76c730345acc422df282e68a5','Vika','','','','','',2,1,1507202268,2,'83.68.44.33',1507638016,1,1,1,0,'','59.96238950144212 30.36291500553489','\0\0\0\0\0\0\0�ZE�/�M@\0p��\\>@','','',0,'','','','','','','','',0),(21,'manager3@mskiso.ru','c2ba0077b38f57255ba64a3a984ca3d786f521ced0ac467c3676ec54c25a36b4569c6c72abe15249d2529bf816eb295ee55e20e670286d493681bb25a940ce7c','97d92c7e33e86541e0d28e19c1b07e14917365bd97322b97f88574308666014bc396d0ac268f42dd5324bdfab7a8fe2b1e1f3a07acf91c81ab9284c12ae573a2','Katya','','','','','',2,1,1507202332,2,'83.68.44.33',1507204852,0,1,1,0,'','59.915100933921515,30.30400085030124','\0\0\0\0\0\0\0��\"�M@\0���M>@','','',0,'','','','','','','','',0),(22,'manager7@mskiso.ru','76e51ec415941d0fb58385de6b845cf8d901ca5cca7ebe4878f400975dd917c4cb1819014dc72a4472d353fcee9a9a1b3aca4d1eae98af83b798f335fe123459','ec6ef9335f3e2f89310e702c81ca96f1eeba3ab790cfd26aecb23736858a92fb519a641eee3c5879db8eb083b489eb1c10ccaec47d3c1e628d304e25118721ba','ОЛЕНЬ','','','','','',2,1,1507204523,2,'83.68.44.33',1507204668,0,1,1,0,'','','','','',0,'','','','','','','','',0);
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
  `descr` varchar(255) NOT NULL,
  `for_project_id` int(11) NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
INSERT INTO `wallet_transactions` VALUES ('0869d60cd0418bd8e610b178e157269a','','4a049e3e38588d4c6692df204b8fb215','HOLD',300,1504598172,'Удержание средств за платный проект',56),('10b52da48f9c8442525659d5278bd6a0','357cfb14d0637e9d8b44ce774e8c4f34','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',50,1496422569,'Дополнительное списание сверх бюджета в проекте',7),('267be1502cfdcbdd2cc7537c5770ca27','','4a049e3e38588d4c6692df204b8fb215','PAYMENT',1000,1496422529,'Пополнение кошелька',0),('2f8815417d237787c772bd66a3b188e5','','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',110,1496419851,'Списание средств за безопасную сделку',5),('357cfb14d0637e9d8b44ce774e8c4f34','','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',200,1496420940,'Списание средств за безопасную сделку',7),('3791d67f83e9c91a65c6af5d95876736','','4a049e3e38588d4c6692df204b8fb215','HOLD',300,1504598233,'Удержание средств за платный проект',59),('4ec4451e728be2ae064d1e2b60a85860','','4a049e3e38588d4c6692df204b8fb215','HOLD',333,1496666935,'Удержание средств за безопасную сделку',22),('699410c7da937bead9bcf06c8ab85a37','','4a049e3e38588d4c6692df204b8fb215','HOLD',300,1496666935,'Удержание средств за платный проект',22),('7903f3b68361f7aa0bd950fb06a4a652','','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',130,1496418410,'Списание средств за безопасную сделку',1),('799580ba26af16732e5e86719f16fb42','','69657e51bdc1543235f9bfd89f3a14e8','HOLD',150,1496678941,'Удержание средств за безопасную сделку',25),('7f03ec3c70bd74fc3100a3aa8ad7e469','','4a049e3e38588d4c6692df204b8fb215','HOLD',500,1500887892,'Удержание средств за безопасную сделку',42),('80362f931108798e2fe9496218e6198b','','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',175,1496659350,'Списание средств за безопасную сделку',18),('85f85f807fb3291e1440ec120ba173c2','','4a049e3e38588d4c6692df204b8fb215','HOLD',600,1496646724,'Удержание средств за безопасную сделку',17),('92cf8b5eab07413b258747c2ec8d7748','','4a049e3e38588d4c6692df204b8fb215','PAYMENT',500,1496414073,'Пополнение кошелька',0),('af25392c50d0139b5eedb794c8cb3969','','84dc334e2367beffe5d6dfbc832f57ba','PAYMENT',8000,1496679231,'Payment wallet',0),('b376f832366f2c870c259082d23c24d2','','4a049e3e38588d4c6692df204b8fb215','PAYMENT',20000,1496666930,'Payment',0),('bf3f40baefc0480eda02336841a65fa2','','84dc334e2367beffe5d6dfbc832f57ba','HOLD',300,1496679238,'Удержание средств за платный проект',32),('c613afb940232082205bf6b17f14e1a4','80362f931108798e2fe9496218e6198b','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',50,1496660348,'Дополнительное списание сверх бюджета в проекте',18),('cb95ef0a19a30e76be3b3ec749d7ecaf','2f8815417d237787c772bd66a3b188e5','69657e51bdc1543235f9bfd89f3a14e8','PAYMENT',145,1496419923,'Зачисление средств за исполненную заявку',5),('cf89d55b2ed2e5fa6d76e701a6d1c3a6','357cfb14d0637e9d8b44ce774e8c4f34','69657e51bdc1543235f9bfd89f3a14e8','PAYMENT',250,1496422569,'Зачисление средств за исполненную заявку',7),('d0886c28b48bfd43e8ecc2077d2d93d6','','4a049e3e38588d4c6692df204b8fb215','PAYMENT',1000,1496659326,'Пополнение',0),('d5055708504d03a80bb4302293740312','80362f931108798e2fe9496218e6198b','69657e51bdc1543235f9bfd89f3a14e8','PAYMENT',225,1496660348,'Зачисление средств за исполненную заявку',18),('de5df301e8601227b9bb2897bf63648e','2f8815417d237787c772bd66a3b188e5','4a049e3e38588d4c6692df204b8fb215','WITHDRAWAL',35,1496419923,'Дополнительное списание сверх бюджета в проекте',5),('e90956ad4d2201a3fd1c4e8f230d9f9c','','4a049e3e38588d4c6692df204b8fb215','HOLD',2213,1504598233,'Удержание средств за безопасную сделку',59),('ecff36ab0dfc073ec410180213530008','','4a049e3e38588d4c6692df204b8fb215','HOLD',444,1496666882,'Удержание средств за безопасную сделку',20),('f328d9ce685d67f21e1b67a40cc8ea81','','4a049e3e38588d4c6692df204b8fb215','HOLD',300,1496646724,'Удержание средств за платный проект',17),('f6a11d857a0759e289864b83e884cce0','7903f3b68361f7aa0bd950fb06a4a652','69657e51bdc1543235f9bfd89f3a14e8','PAYMENT',130,1496418577,'Зачисление средств в рамках проекта: safe 1',1);
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warnings`
--

LOCK TABLES `warnings` WRITE;
/*!40000 ALTER TABLE `warnings` DISABLE KEYS */;
INSERT INTO `warnings` VALUES (2,33,0,2,'test block project',1,1500450755),(3,34,0,2,'qqq',1,1500653876),(4,35,0,2,'BFDSGG',1,1500654307),(5,39,0,15,'Заблокировано потому что',1,1500654372),(6,22,0,1,'йййуЯЯ',1,1500654529),(7,34,0,2,'йййуЯЯ',1,1500656095);
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

-- Dump completed on 2017-12-04 19:59:26
