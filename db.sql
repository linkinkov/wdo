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
INSERT INTO `attaches` VALUES ('000a4aa4bdc20136d1464fc2af764acd','document',6,0,0,'408a29779b6a1fd715545fa87692b0fc.xls','Расценки.xls','',1495022219,3),('015dd6c9b6ff27a516bcee4cd5379d66','image',0,0,11,'20dbc795b892735f8910f87c79a091b5.jpeg','sea-bay-waterfront-beach-50594.jpeg','',1495026606,3),('037e6bfa3bb1fe633af6b8ebfc3b5db4','image',0,12,0,'6927a397b034f0dfba93b300e3571e50.jpg','_89586487_istock_000063166549_medium.jpg','',1495548991,1),('06d7ce95cb9cdec2c10a3c6545993b30','image',6,0,0,'d9f06021fb6c9fa067b652c79e672361.jpg','birds.jpg','',1495040637,3),('07eba0014e77d499bef4dab647e866e0','image',0,0,9,'80c33a83fe62da6a2edd677113eb2110.jpg','pexels-photo (1).jpg','',1495026432,3),('0fb63097e1a6b5a5b3ad5f15fbcebe37','image',0,0,11,'57d78cc9142fc2be64f09c56e04a33fd.jpg','_89586487_istock_000063166549_medium.jpg','',1495026607,3),('10b743af457138bd9935092c1a0d876b','image',0,0,11,'388ed7b30950e4fea803565789c9112c.jpg','above-adventure-aerial-air.jpg','',1495026607,3),('12096b4edf112646924883b57550c906','image',0,0,9,'90aef3bae18288e51a829190d9682be7.jpg','potd-squirrel_3519920k.jpg','',1495026432,3),('13a41a3dba4d7056439e53723c454750','video',0,11,0,'','','https://www.youtube.com/watch?v=HxrRJDRezcI',1495098214,1),('1711826c74758e5434763abd0b4ee5f3','image',0,0,11,'e801e89c8d7582a05ad1af421e045e59.jpeg','pexels-photo-219833.jpeg','',1495026606,3),('1a54aea3024debe9fbb99a2ccb67b764','image',0,0,21,'e671a56186736de6d61cf9e937bc5f12.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495026723,3),('203de7e24e8e58825d197292043146a9','image',0,0,9,'f321b437f09cc6f39629f072be9eda3d.jpeg','horsehead-nebula-dark-nebula-constellation-orion-87646.jpeg','',1495026432,3),('2066377e41fe45b1eba1f7a1464cc3e9','image',0,0,9,'340b6fc5db0de60ebcb2b8dd79d24f91.jpeg','dog-cavalier-king-charles-spaniel-funny-pet-162167.jpeg','',1495026433,3),('2a25e39c63cae6571e1fbfab4392aa37','image',0,0,11,'f4141900baad12d5832a8ed02ad762f0.jpg','skyline-buildings-new-york-skyscrapers.jpg','',1495026606,3),('2d581d7c2341e7a17f5dde1e4173f1e9','image',0,0,11,'d0e6b3a8037ac46cfb06adbd2d657890.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495026606,3),('2e7e4a2e7b1066431ba0e4930b00c498','image',0,12,0,'43166bd787ad837acc8f308ee8dd335f.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495548990,1),('31229fef001ce02823d39d138b173cde','image',0,0,23,'5541a5ce4648e274ab9f23f3e9493ca0.jpg','pool-house.jpg','',1495625525,2),('3239cbd0ab1d3cd22a18410cc54166dd','document',6,0,0,'4c05c988b8848ab671ce3980fc3c2884.pdf','Буклет.pdf','',1495022219,3),('3408e45f420e1d50d49e834eb5245261','video',6,0,0,'','','https://www.youtube.com/watch?v=J__tNGdhZ-M',1495040637,3),('34e216de2ff0e72487825f26624bdb6c','video',0,12,0,'','','https://www.youtube.com/watch?v=yxS99dCQ7A8&spfreload=1',1495548990,1),('36ae0e93b2653154de699c0cd4e63da4','image',0,0,11,'68c7ca63b8cd734aa448e4b7ff111b54.jpeg','pexels-photo-57812.jpeg','',1495026607,3),('3aa2851a71662f4758825a827e9a210f','image',6,0,0,'c5728c3af525ffb7921cca703ec0c4ec.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495040637,3),('465fd37f0c16b1876e38028f1a59e128','video',0,0,10,'','','https://www.youtube.com/watch?v=qzMQza8xZCc',1495026547,3),('5428abcf36c423e5f8e3b2e763ccc4e2','image',0,0,21,'747389a2881cf9d6cd9b37ade7317d3f.jpg','birds.jpg','',1495039707,3),('57e1245c26d2270f90a029664daa423f','image',0,0,22,'3f62c562442ce9c0777c84f9774644e9.jpg','radius-restaurant-1200.jpg','',1495111859,1),('5a27fddb24d8b51c0cdcfae4e479ee9d','image',0,0,8,'3a26aa95594a3ea380167ab79fdfe48e.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495025792,3),('5b623b9a1499463305bb8104e9d2e992','image',6,0,0,'5b2a1413429b2f281bd744b8884dabc8.jpeg','pexels-photo-286330.jpeg','',1495040637,3),('5d5fdbe9a05c3138eb7b764f64a346ee','image',0,12,0,'aca6eccec64cce4296d67cd07693e5e3.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495548990,1),('60a3f83859e6ec65232d702cdc01d4a0','image',0,0,8,'2ecde21f78f1152cb256f97e2e7f25dc.jpeg','pexels-photo-57812.jpeg','',1495026323,3),('6121ed8b8d9ad902b7e53b2343bcb6cf','image',0,0,23,'a8134df344add8d4ce3574c85ca37d9e.jpg','foto-kottedzhej-s-bassejnom-11.jpg','',1495625525,2),('614055773cf5a880af45cb6732208d6b','image',0,0,9,'03ab1ec18e1c1de23be60c935f54da0f.jpeg','pexels-photo-129928.jpeg','',1495026432,3),('6285cac3fc7659158cbb24b4e7cfd235','image',0,0,11,'8d9f23400c2449c8a776791c292b59b8.jpg','potd-squirrel_3519920k.jpg','',1495026607,3),('6293e8204ff0459e1e754a4d3a00fb97','image',0,0,11,'e2fc7d084a503dcf6a45ca5b22cd059e.jpeg','pexels-photo-286330.jpeg','',1495026607,3),('654db6ed11e9e59b8dc1fe6f2feb8fc9','image',0,0,11,'d91b41ac4ee4fae1599595f6442d1add.jpg','pexels-photo-27714.jpg','',1495026607,3),('65c944ebf987094dbdced7a8f69474dd','image',0,0,8,'420be381e15d91e563924f6512dd1a6e.jpeg','','',1495022219,3),('6675c836f087bd32bcf9ca8777717984','image',0,0,11,'1b6cb353793369e3497deac94511ff81.jpeg','horsehead-nebula-dark-nebula-constellation-orion-87646.jpeg','',1495026606,3),('676823c3cd471ece47fc482b7891a63c','image',0,0,8,'7743de4e2aa99fd66a1e4df1e08c7cf1.jpeg','pexels-photo-173383.jpeg','',1495026323,3),('68793ff74cb908560449845282c0f8c8','image',0,0,11,'2932a50cd1887ae3bcfb4b1daa7ec55b.jpeg','dog-cavalier-king-charles-spaniel-funny-pet-162167.jpeg','',1495026607,3),('68cc9fd628ed767d3de5cc4f0bcf8aca','image',0,0,8,'3c1285a90c9bc91510edc34d7196e4b8.jpeg','pexels-photo-132037.jpeg','',1495026323,3),('7038d9a8ab97b586f8de01a76509e05f','image',0,0,11,'43b77cad4cd9c9108ef9e4c45ba9cc13.jpg','maxresdefault.jpg','',1495026607,3),('70af5806a42ba3da6751ca3ec66c8ced','image',0,0,16,'9758dfedea9c4db1cc6bbd8c0eeb8c48.jpeg','pexels-photo-129928.jpeg','',1495039432,3),('7359cf3c95d761a3eed874f9326189ec','image',0,0,11,'2bca5d8ff973615fd339a1d23e8eac8a.jpg','pexels-photo (1).jpg','',1495026606,3),('73e79e3d4fa0bc5acfc83e70a84ab6be','image',0,0,9,'03ac792162b1839de84be885f5d88b05.jpeg','pexels-photo-186680.jpeg','',1495026432,3),('7734099cbdbffff8bca077bf301fa388','image',0,0,9,'b7cd5bb6c93d59a9d7b0a7ef18a397ee.jpg','skyline-buildings-new-york-skyscrapers.jpg','',1495026432,3),('795da808b0e3d2f0dd874d7a853082e4','image',0,0,9,'3c3ef2cc8641cf09d7795c1aade1db16.jpg','maxresdefault.jpg','',1495026432,3),('79a056272441271ec65af8f2bd46ee16','image',0,0,9,'57c414bcf412e6bf9e73627df8f74fe6.jpg','people-eiffel-tower-lights-night.jpg','',1495026433,3),('7a3ac26422e5e5252cd297ceb864c734','image',0,0,11,'a4e21363eca61959597da4a14b658dd9.jpeg','mona-lisa-leonardo-da-vinci-la-gioconda-oil-painting-40997.jpeg','',1495026606,3),('7e09636af27a571e6f26e9a50f871a24','video',0,0,11,'','','https://www.youtube.com/watch?v=LNlw08wnFdM',1495026605,3),('81ee9021dd2952c20c2e0c503ed15903','video',0,0,8,'','','https://www.youtube.com/watch?v=r00uCrDjOjE',1495026323,3),('83dc9357d4ed24d67b424ba5ccb63a28','image',0,0,9,'5248435effbc5052fa7cdf16224a9a99.jpeg','sea-bay-waterfront-beach-50594.jpeg','',1495026432,3),('876bd6ae39e4f789a2eaec5ce896be3b','image',0,0,20,'8ca79d804132337637d7936d954b8eb6.jpeg','pexels-photo-286330.jpeg','',1495035795,3),('8b166ab2371739ec885c3d4d024d4043','document',0,0,21,'d6be5a51bbf1cd36d89dd2d2b4f1fd4d.pdf','example-abstract.pdf','',1495098802,3),('8de16040f352b0cee479d5d78cf93bb0','image',0,11,0,'e2f854f1fe0735acf17b9421d1a7b154.jpeg','sea-bay-waterfront-beach-50594.jpeg','',1495098215,1),('8ee90b5ee40e0780f1b1dcc5f9b565fa','image',0,12,0,'f9cfd6486f4ad863cb1e7dd0509faa7f.jpg','above-adventure-aerial-air.jpg','',1495548990,1),('8fb036bdab8a647ae93d80a9725d0fd6','image',0,0,9,'9d80584cb5ca99dd5ef2cb574c0b2c2f.jpeg','mona-lisa-leonardo-da-vinci-la-gioconda-oil-painting-40997.jpeg','',1495026432,3),('9226bf06c50377fff81eb7aa93e9110e','image',0,12,0,'81270b1da431030beed528c1428ecc5f.jpg','maxresdefault.jpg','',1495548990,1),('95a63ebbb5496117e031d2210bc050cf','image',0,0,12,'0e16ac9058e33fa0f542859419f446ae.jpeg','pexels-photo-186680.jpeg','',1495027287,3),('a0820b1e0c264694e1ee2241562e1f3a','image',0,0,23,'d265a2809a0a22ed520973bfd9505a6f.jpg','information_items_2065.jpg','',1495625525,2),('a1902134019b4729504e37362956f9bd','image',0,0,11,'0ed4a805c001bde984ade0a1ce9f9bc2.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495026605,3),('b102c9b4790b34d243e6d45533be676a','image',0,11,0,'56bf2387fe6090a8c121cb578332eccb.jpg','pexels-photo-27714.jpg','',1495098215,1),('b152c4a1e3b5e30d9594a26f8792a1db','image',0,0,16,'eea992aa7db3b0c2104e72606592cb07.jpeg','mona-lisa-leonardo-da-vinci-la-gioconda-oil-painting-40997.jpeg','',1495027308,3),('b57002bf1d56b2d242f3e9e9b09441cf','image',7,0,0,'01f83718c6abdd762f41e3b2a81c041f.jpg','radius-restaurant-1200.jpg','',1495539768,3),('bae4a32a822d157077eed87b48e5b889','image',0,12,0,'d566a67f5f40a31ee3c0e0819c579c5d.jpg','potd-squirrel_3519920k.jpg','',1495548990,1),('bbf027da30e77cdf387628804ecc130c','image',0,0,8,'fff3aff6044247725b556e2ac7b47308.jpg','above-adventure-aerial-air.jpg','',1495026323,3),('bc8e10f70fcbaa690e91c3034b88c72a','image',0,0,9,'c6f63fbe06d32138c20635e009d77651.jpg','pexels-photo-27714.jpg','',1495026432,3),('bfd807edd1f1fd561ff6c4ea67e00b20','image',0,0,9,'badd5d2ee879bfb3eeaa2e191afd31f9.jpg','above-adventure-aerial-air.jpg','',1495026433,3),('c0471dd1192741971f911223fb7921e9','image',0,0,11,'d9376ad2644a530a7de432290427a730.jpg','people-eiffel-tower-lights-night.jpg','',1495026607,3),('c0e99300b7daa4a5eba8aa6cd4f3567f','image',0,0,9,'8449084f52a2bf30610a02ef5e60a62c.jpeg','pexels-photo-57812.jpeg','',1495026432,3),('c435520222bce2ccd06fd34419f564a8','image',0,0,9,'6cee2f746c8b244024b6d6dc0ce16663.jpg','_89586487_istock_000063166549_medium.jpg','',1495026433,3),('c7a0298ec026f227d8245b9eddd1f5ca','image',0,0,9,'48fb5b255690ff76b95c483a6c99ac7b.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495026432,3),('c8a917392cee0d50707ed56e9616092d','image',0,0,23,'d46ff381b93e364e4f64638852705940.jpg','1383896996_Luxury-home-Melbourne-Australia-99.jpg','',1495625525,2),('cab66418fd4716f078fde05783d1b143','image',0,0,9,'887b3206c0fa344c4d6ee6c7fe69e4ac.jpeg','pexels-photo-219833.jpeg','',1495026432,3),('cb7a26a75a280dc8f0978b39cebb0709','image',0,0,9,'098676f7b8dd308f9041cb25fcd08403.jpeg','pexels-photo-173383.jpeg','',1495026432,3),('cfe7dad331e4b536925cb3b2ba10a944','image',0,0,11,'3e0f8f979ceef7d0eeda01afd1ad637a.jpeg','pexels-photo-132037.jpeg','',1495026606,3),('d131531051d39601680b1a5bf2664c1c','image',0,0,8,'5666087218934c5cb1aaf704089aeff1.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495026323,3),('d3befb9c08682eded055569a912c0aab','image',0,0,9,'b75c9f35121d311a3571be49429ca103.jpg','76225b3c2d672b5ddb6afc0bc5724488.jpg','',1495026432,3),('d42989f066ec7fb0a6e7a7c0b6ea79b3','image',0,12,0,'e1e9b1c80bb331c5650b001596996d43.jpeg','sea-bay-waterfront-beach-50594.jpeg','',1495548990,1),('d6fda5963b5db01474c07e586d196bc8','video',5,0,0,'','','https://youtu.be/RLYMIWrsahU',1494005463,1),('e4fe0fc1c7a0d9de7f3e266690d01720','image',0,0,11,'9bbbd5a4658c5ed7bcaf6527a9c8bf18.jpeg','pexels-photo-173383.jpeg','',1495026605,3),('e7081a9b112a642d296b9e28ddecd33f','image',0,0,9,'5b0952b46f06b143a54840c6229fe2fa.jpeg','pexels-photo-286330.jpeg','',1495026433,3),('e88438b83cdb9aa99b1414bdb9e66bc8','document',0,11,0,'0d003ce8ded51fa6ce37ce9f36ef365a.pdf','pdf-sample.pdf','',1495098215,1),('eb10f8d50367d114fa20587108e09423','image',0,0,10,'f6efa3b0d1452c6f4a488d5bc7d05cff.jpg','people-eiffel-tower-lights-night.jpg','',1495026547,3),('eb78c16fe3e373059a841e566b4fd898','image',0,0,11,'d0ea0c47b0b062978a09d92f216b4a88.jpeg','pexels-photo-186680.jpeg','',1495026606,3),('f07074cce631a3390ca1cfda886117e2','image',6,0,0,'30b127568204b2464a440bd4f14824e2.jpg','104322220_A_hummingbird_flies_in_the_sanctuary_El_Paraiso_de_los_Colibries_near_Cali_Colombia_July_2-xlarge_trans_NvBQzQNjv4Bq-agzfSZPbx5ewWKsm0lwAundorrfTn1S44nFm9akbNQ.jpg','',1495040637,3),('f1e89ac7c0e42167bc955bf2f04edd16','image',0,0,8,'a1e30e8e72f5cbbc4594b6cc0fc34ee8.jpeg','','',1495022219,3),('f42078f277d7033664a2510feb67f7bb','image',0,0,8,'41636e065ce79886996213285482c622.jpg','_89586487_istock_000063166549_medium.jpg','',1495026323,3),('f47bdcf4d905d272d18a7d4b1b998269','image',0,12,0,'fa2a564eb14b2ddb745f9f33cb64c20e.jpeg','pexels-photo-286330.jpeg','',1495548990,1),('f57df6a91c1323963c372f92c944cf17','image',0,12,0,'40eb656326d086b2752d20279323406b.jpg','birds.jpg','',1495548990,1),('f84f52e2e58369eb1fcfea675ab43025','image',0,0,11,'1a48e73c151d0ff71ce6d7b78316d23a.jpg','pexels-photo.jpg','',1495026607,3),('f94ccd47ad92df81f2cba7e94bbf811e','image',0,0,23,'4e6d98ee629305b4eff7b806bf8662dd.jpg','101a6d35d617993ac79c957b7b022311.jpg','',1495625525,2),('fe34154a0c8c4f86a0bbb5cfbb14dcfe','image',0,0,9,'05f94a7727e8b030b87d056918ee9a44.jpeg','pexels-photo-132037.jpeg','',1495026432,3),('ff3952374e1de68334b48b0ce1b183d8','document',0,12,0,'bbe111fe0a1db094258edb52161d795e.pdf','example-abstract.pdf','',1495548990,1),('ff8801420e91e6e87ef197903c192bdc','image',0,0,11,'c2fa20daa2e64af4ef348751eaf23ce1.jpeg','pexels-photo-129928.jpeg','',1495026605,3);
/*!40000 ALTER TABLE `attaches` ENABLE KEYS */;
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
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cats`
--

LOCK TABLES `cats` WRITE;
/*!40000 ALTER TABLE `cats` DISABLE KEYS */;
INSERT INTO `cats` VALUES (1,'Фото и видео','foto_i_video',0,0),(2,'Шоу-программа','shou-programma',0,0),(3,'Залы, рестораны','zaly,_restorany',0,0);
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
  PRIMARY KEY (`dialog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dialogs`
--

LOCK TABLES `dialogs` WRITE;
/*!40000 ALTER TABLE `dialogs` DISABLE KEYS */;
INSERT INTO `dialogs` VALUES ('38d57ca87af07b563cd404af051ce87d','2,3'),('650daf5b0807ada3e205349e2d48e82f','1,3'),('a7f0b88f22f4d67f7c3da225f9093d04','1,3,6,7'),('c87954eaea3ed578ea5606c103e21aeb','1,2');
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
INSERT INTO `login_attempts` VALUES ('admin@weedo.ru',1492265776,'127.0.0.1'),('admin@weedo.ru',1492265873,'127.0.0.1'),('admin@weedo.ru',1492265895,'127.0.0.1'),('admin@weedo.ru',1492265902,'127.0.0.1'),('admin@weedo.ru',1492265938,'127.0.0.1'),('admin@weedo.ru',1492265942,'127.0.0.1'),('admin@weedo.ru',1492265967,'127.0.0.1'),('admin@weedo.ru',1492266034,'127.0.0.1'),('admin@weedo.ru',1492266642,'127.0.0.1'),('admin@weedo.ru',1492266699,'127.0.0.1'),('admin@weedo.ru',1492266725,'127.0.0.1'),('admin@weedo.ru',1492266763,'127.0.0.1'),('admin@weedo.ru',1492274708,'127.0.0.1'),('admin@weedo.ru',1492274824,'127.0.0.1'),('admin@weedo.ru',1492274850,'127.0.0.1'),('admin@weedo.ru',1492274862,''),('admin@weedo.ru',1492274909,'127.0.0.1'),('admin@weedo.ru',1492275023,'127.0.0.1'),('admin@weedo.ru',1492275057,'127.0.0.1'),('admin@weedo.ru',1492276111,'127.0.0.1'),('admin@weedo.ru',1492276209,'127.0.0.1'),('admin@weedo.ru',1492276225,'127.0.0.1'),('admin@weedo.ru',1492295204,'127.0.0.1'),('admin@weedo.ru',1492295207,'127.0.0.1'),('admin@weedo.ru',1492295212,'127.0.0.1'),('admin@weedo.ru',1492295281,'127.0.0.1'),('admin@weedo.ru',1492295360,'127.0.0.1'),('admin@weedo.ru',1492295423,'127.0.0.1'),('admin@weedo.ru',1492295768,'127.0.0.1'),('admin@weedo.ru',1492295779,'127.0.0.1'),('admin@weedo.ru',1492295887,'127.0.0.1'),('admin@weedo.ru',1492448870,'127.0.0.1'),('admin@weedo.ru',1492448952,'127.0.0.1'),('admin@weedo.ru',1492543973,'127.0.0.1'),('admin@weedo.ru',1492543991,'127.0.0.1'),('admin@weedo.ru',1492544003,'127.0.0.1'),('admin@weedo.ru',1492544376,'127.0.0.1'),('admin@weedo.ru',1492544417,'127.0.0.1'),('demo',1492544485,'127.0.0.1'),('demo',1492544495,'127.0.0.1'),('demo',1492544560,'127.0.0.1'),('admin@weedo.ru',1492589386,'127.0.0.1'),('admin@weedo.ru',1492592296,'127.0.0.1'),('demo',1493035543,'127.0.0.1'),('demo',1493040247,'127.0.0.1'),('admin@weedo.ru',1493112480,'127.0.0.1'),('admin@weedo.ru',1493112972,'127.0.0.1'),('demo',1493113995,'127.0.0.1'),('demo',1493125409,'127.0.0.1'),('demo',1493126246,'127.0.0.1'),('manager',1493128466,'127.0.0.1'),('manager',1493128469,'127.0.0.1'),('manager',1493128472,'127.0.0.1'),('manager',1493128680,'127.0.0.1'),('demo',1493132994,'127.0.0.1'),('manager',1493134873,'127.0.0.1'),('demo',1493206793,'127.0.0.1'),('manager',1493224739,'127.0.0.1'),('demo',1493228001,'127.0.0.1'),('demo',1493228081,'127.0.0.1'),('demo',1493228106,'127.0.0.1'),('demo',1493228133,'127.0.0.1'),('demo',1493228164,'127.0.0.1'),('demo',1493228238,'127.0.0.1'),('admin@weedo.ru',1493228352,'127.0.0.1'),('demo',1493228417,'127.0.0.1'),('admin@weedo.ru',1493292417,'127.0.0.1'),('admin@weedo.ru',1493294151,'127.0.0.1'),('admin@weedo.ru',1493296784,'127.0.0.1'),('demo',1493381142,'127.0.0.1'),('demo',1493384772,'127.0.0.1'),('admin@weedo.ru',1493391694,'127.0.0.1'),('admin@weedo.ru',1493477371,'127.0.0.1'),('manager',1493480445,'127.0.0.1'),('admin@weedo.ru',1493539017,'127.0.0.1'),('demo',1493572081,'127.0.0.1'),('demo',1493572259,'127.0.0.1'),('admin@weedo.ru',1493717470,'127.0.0.1'),('demo',1493730517,'127.0.0.1'),('demo',1493735079,'127.0.0.1'),('admin@weedo.ru',1493736523,'127.0.0.1'),('manager',1493738479,'127.0.0.1'),('demo',1493828979,'127.0.0.1'),('admin@weedo.ru',1493880581,'127.0.0.1'),('manager',1493893103,'127.0.0.1'),('admin@weedo.ru',1493905679,'127.0.0.1'),('admin@weedo.ru',1493905705,'127.0.0.1'),('demo',1493905728,'127.0.0.1'),('demo',1494402033,'127.0.0.1'),('manager',1494402043,'127.0.0.1'),('demo',1494402126,'83.68.44.33'),('demo',1494410567,'83.68.44.33'),('demo',1494427267,'127.0.0.1'),('admin@weedo.ru',1494427276,'127.0.0.1'),('admin@weedo.ru',1494427551,'127.0.0.1'),('demo',1494427957,'127.0.0.1'),('admin@weedo.ru',1494582511,'127.0.0.1'),('demo',1494582564,'127.0.0.1'),('demo',1494592727,'127.0.0.1'),('demo',1494934854,'127.0.0.1'),('admin@weedo.ru',1495042605,'127.0.0.1'),('demo',1495098772,'127.0.0.1'),('demo',1495115418,'127.0.0.1'),('demo',1495116545,'127.0.0.1'),('demo',1495439296,'127.0.0.1'),('demo',1495472673,'127.0.0.1'),('admin@weedo.ru',1495539784,'127.0.0.1'),('manager',1495546996,'127.0.0.1'),('manager',1495547306,'127.0.0.1'),('admin@weedo.ru',1495615215,'127.0.0.1'),('demo',1495624389,'127.0.0.1'),('manager',1495624413,'127.0.0.1'),('admin@weedo.ru',1495630934,'127.0.0.1'),('admin@weedo.ru',1495799695,'127.0.0.1'),('admin@weedo.ru',1496048607,'127.0.0.1'),('demo',1496065858,'127.0.0.1'),('demo',1496078430,'127.0.0.1'),('admin@weedo.ru',1496088537,'::1'),('demo',1496093170,'::1'),('manager',1496093591,'::1');
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
INSERT INTO `messages` VALUES ('01b22704d1978b88086766644e3c6388','qwe',1493572104,'650daf5b0807ada3e205349e2d48e82f',3,1),('032c9115b177f6f191f10bc3aded0edf','fadsklj',1493299668,'650daf5b0807ada3e205349e2d48e82f',1,1),('035a51d31865cd5fc9260d21c73cafaf','47: from 3 to 2 035a51d31865cd5fc9260d21c73cafaf',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('03a30fb66850b27044c3361aa2396e36','2: from 3 to 2 03a30fb66850b27044c3361aa2396e36',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('03c250b12e1d1dddd58697fbb537ec8c','здарова',1493573082,'650daf5b0807ada3e205349e2d48e82f',1,1),('0419a17916c959d0a6dae2f9584fb2c4','52: from 3 to 2 0419a17916c959d0a6dae2f9584fb2c4',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('05575150d2bdfb06dbdee8849550946a','nnn',1493880278,'650daf5b0807ada3e205349e2d48e82f',3,1),('05b101472d95e17969d52865d9c9bfb8','33: from 1 to 2 05b101472d95e17969d52865d9c9bfb8',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('09ab4dc7faecff13364d81f3ea3a72ef','115: from 2 to 1 09ab4dc7faecff13364d81f3ea3a72ef',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('0b218ff0107fc6291c7541d464986d86','79: from 2 to 3 0b218ff0107fc6291c7541d464986d86',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('0c5ef5cee71e2fcda632c71e5276b34a','ZZZZZQ!@!',1493572980,'650daf5b0807ada3e205349e2d48e82f',1,1),('0efe1a39d58730217a50e2eb5abafaa5','108: from 1 to 3 0efe1a39d58730217a50e2eb5abafaa5',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('10c42815b2208e078ce76438aa9599e3','а',1493573496,'650daf5b0807ada3e205349e2d48e82f',3,1),('13dbd1965d88061a14f78964c6b52546','43: from 1 to 3 13dbd1965d88061a14f78964c6b52546',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('142805897f59db4bc028695452d503af','150: from 2 to 1 142805897f59db4bc028695452d503af',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('1949f7c4c659098ae7a0b8fb4a57fafe','qqq',1493880273,'650daf5b0807ada3e205349e2d48e82f',3,1),('198cf020afe95cc762ff6a0285497c3d','136: from 1 to 2 198cf020afe95cc762ff6a0285497c3d',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1aa1f9228ac70c1c5e6a89e3603a5581','85: from 3 to 2 1aa1f9228ac70c1c5e6a89e3603a5581',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('1bf2376f6c17082341c5542abd73e675','137: from 3 to 1 1bf2376f6c17082341c5542abd73e675',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('1c2a6cc564c65f1e312f3f36fca010be','qwe',1493711924,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1c5bf543ee07a527abe4ff87a4e7af21','e',1493545886,'c87954eaea3ed578ea5606c103e21aeb',1,1),('1c9463289b61a5d2926e5a6b6e7b723e','qq',1493879247,'650daf5b0807ada3e205349e2d48e82f',3,1),('1d378bd6d91d5d8c3337f1fd6f7dd8a8','103: from 3 to 2 1d378bd6d91d5d8c3337f1fd6f7dd8a8',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('1ede9670a0e8e7fc6d22d34803a6ce56','25: from 1 to 3 1ede9670a0e8e7fc6d22d34803a6ce56',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('20aa221664f693eb58e9ce8deeba51c6','176: from 1 to 2 20aa221664f693eb58e9ce8deeba51c6',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('235f2978d7b1677e8293333d620b3a5c','199: from 3 to 1 235f2978d7b1677e8293333d620b3a5c',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('256aa9cae88cfd85f515f045a9e579b8','Yo',1493881190,'650daf5b0807ada3e205349e2d48e82f',1,1),('270c7e44f37b4af9762d2f11be5a1793','цйу',1493573353,'650daf5b0807ada3e205349e2d48e82f',3,1),('298a0c090caed8866c0c32650daff7b2','fff',1493879082,'650daf5b0807ada3e205349e2d48e82f',3,1),('298acbf01938186827557120e2cddd72','w',1493545770,'c87954eaea3ed578ea5606c103e21aeb',1,1),('2996ad223d01e78a0264c434457064df','61: from 2 to 1 2996ad223d01e78a0264c434457064df',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('2b0871dd7a74f72ce17e3fa996bdefa9','23: from 3 to 1 2b0871dd7a74f72ce17e3fa996bdefa9',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('2bbd7d5efb3ffafe5dd7ce97ff09b9d8','58: from 2 to 3 2bbd7d5efb3ffafe5dd7ce97ff09b9d8',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('2c208e1802bb3ef104290b2e3f51eb85','qqq',1493879666,'650daf5b0807ada3e205349e2d48e82f',3,1),('2cfb8d115b50763e2a5646a4e9f4c883','129: from 1 to 3 2cfb8d115b50763e2a5646a4e9f4c883',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('2f932eb46b25fdac2c670bb03f79b388','zzz',1493881222,'650daf5b0807ada3e205349e2d48e82f',1,1),('3069efbbd0f53c9d0b840b960a5eb2fa','144: from 2 to 3 3069efbbd0f53c9d0b840b960a5eb2fa',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('31653a73d77f5f4ab7ffaffbff5d5ca7','148: from 3 to 1 31653a73d77f5f4ab7ffaffbff5d5ca7',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('317532b092f8cfded033eb69c61d17db','173: from 3 to 2 317532b092f8cfded033eb69c61d17db',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('31998f65fd383b98dd6d6d2dfda77ee0','98: from 3 to 1 31998f65fd383b98dd6d6d2dfda77ee0',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('329ac974beb047b58c51c16b90ecbbbb','28: from 3 to 2 329ac974beb047b58c51c16b90ecbbbb',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('3609fffd0588c784080c5a2aed36400b','11: from 3 to 1 3609fffd0588c784080c5a2aed36400b',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('3700f7b5b239dce37f3385ed93d8fe30','54: from 2 to 1 3700f7b5b239dce37f3385ed93d8fe30',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('37329aa146e91ddb1f85f4864bf8af77','111: from 2 to 3 37329aa146e91ddb1f85f4864bf8af77',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('39846aa138f5abe9fe11047d8e864051','ZZZZZZZZZ',1493572160,'650daf5b0807ada3e205349e2d48e82f',3,1),('3ae98efc0ec5d9f6ba775ae7aef1b2ba','168: from 3 to 1 3ae98efc0ec5d9f6ba775ae7aef1b2ba',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('3b9b2c09dea151832999908434b6ea56','93: from 1 to 2 3b9b2c09dea151832999908434b6ea56',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('3d10426e0719c7a7b6acea4044e99b33','65: from 1 to 3 3d10426e0719c7a7b6acea4044e99b33',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('3f2fbdb2b9cf0d3873a674fd4aac7ac3','82: from 1 to 2 3f2fbdb2b9cf0d3873a674fd4aac7ac3',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('400cad23a1c35ece2ec4f6cf2b82dddf','143: from 2 to 3 400cad23a1c35ece2ec4f6cf2b82dddf',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('415218b28813730eb1a3ab04b16bc101','55: from 1 to 2 415218b28813730eb1a3ab04b16bc101',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('417e153f3698b775623956d7670ac5eb','197: from 3 to 1 417e153f3698b775623956d7670ac5eb',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('470be04477dc8995e1ccb98c63ecdc94','aa',1493879060,'650daf5b0807ada3e205349e2d48e82f',3,1),('47722eab960bcaeab7775ce5854a9d29','106: from 1 to 2 47722eab960bcaeab7775ce5854a9d29',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('49e290ccf23891e5324b5c6f1388c7bd','156: from 1 to 2 49e290ccf23891e5324b5c6f1388c7bd',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('4e813435eb56ffaea3f5bd5d28557ddb','16: from 2 to 3 4e813435eb56ffaea3f5bd5d28557ddb',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('4faade94ed00c0bb84215c1b882c20fb','118: from 2 to 3 4faade94ed00c0bb84215c1b882c20fb',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('51a142d42ce5ba6323c40a7f611bec21','qwe',1493546163,'c87954eaea3ed578ea5606c103e21aeb',1,1),('522421a9eb737173b392e02945798b96','34: from 1 to 2 522421a9eb737173b392e02945798b96',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('52818e842aff9dcf18e71e550b7bb4da','41: from 1 to 3 52818e842aff9dcf18e71e550b7bb4da',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('5348dd7e1d0ee2bf52123aa51ebfb0a8','121: from 2 to 1 5348dd7e1d0ee2bf52123aa51ebfb0a8',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('53ddc3c4e4f9525cfeb34cfaadc6d295','7: from 2 to 1 53ddc3c4e4f9525cfeb34cfaadc6d295',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('5482059635c72b01a5ffe9fbefd330cb','asdasd',1493299668,'38d57ca87af07b563cd404af051ce87d',3,1),('572b7a01ed09fb5527eec2b006dcd082','31: from 1 to 3 572b7a01ed09fb5527eec2b006dcd082',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('577c31133b78b2c79fd99cd06c16e645','39: from 2 to 1 577c31133b78b2c79fd99cd06c16e645',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('584fc10bb6c57de933148f359e504735','qq',1493545753,'c87954eaea3ed578ea5606c103e21aeb',1,1),('58ea6d309c6fe3680c16436f7fe6f536','35: from 1 to 2 58ea6d309c6fe3680c16436f7fe6f536',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('590e123ae52e93586ef099ade88c50c5','27: from 2 to 1 590e123ae52e93586ef099ade88c50c5',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('5925e4347fd1eae96b5396af3daf73a2','19: from 1 to 3 5925e4347fd1eae96b5396af3daf73a2',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('5985ab2efbe77151ae0cb2c77a665678','10: from 1 to 2 5985ab2efbe77151ae0cb2c77a665678',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('5d34c0f976de823b794339df35e4f82b','139: from 3 to 2 5d34c0f976de823b794339df35e4f82b',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('5de83f59a6fe2d9d929f1992958e2bc9','fdsjhfsdh',1493882447,'650daf5b0807ada3e205349e2d48e82f',3,1),('5e49cfa069f65fe3aad643662217c95d','ту туруру трутруту',1493573556,'650daf5b0807ada3e205349e2d48e82f',1,1),('5f5dfbb5637592834d15c47874dfdbdb','dsa',1493493509,'c87954eaea3ed578ea5606c103e21aeb',1,1),('5ffd57a77f25439cb9ca664f9970c291','154: from 2 to 1 5ffd57a77f25439cb9ca664f9970c291',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('603a04504236ad4e22e2f8a5254c3144','57: from 3 to 2 603a04504236ad4e22e2f8a5254c3144',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('6054eca9c323da32a9a3766cb56b5c48','125: from 2 to 3 6054eca9c323da32a9a3766cb56b5c48',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('61067f4bea7909e1fa9d8b2242d7a86d','59: from 2 to 3 61067f4bea7909e1fa9d8b2242d7a86d',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('6130acb43c81a7509ba3fe8c57bcc212','5: from 2 to 1 6130acb43c81a7509ba3fe8c57bcc212',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('61799bea0ea184c9c46a42d3f6023d31','109: from 3 to 1 61799bea0ea184c9c46a42d3f6023d31',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('66b526a297dd9d108a27bf4e70d7172a','162: from 3 to 1 66b526a297dd9d108a27bf4e70d7172a',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('66c65c3446507f8e4c854c971bf7ba95','110: from 3 to 2 66c65c3446507f8e4c854c971bf7ba95',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('67c430675e905e9625cfa86a4171eb75','95: from 2 to 1 67c430675e905e9625cfa86a4171eb75',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('698fc78ce0f787f83f7dba0ef248ef1e','158: from 1 to 3 698fc78ce0f787f83f7dba0ef248ef1e',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('6ae5dd199f21f4e236776273bbf0e68c','138: from 3 to 2 6ae5dd199f21f4e236776273bbf0e68c',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('6af07808c5b91c329f73bfda674a7c43','20: from 2 to 1 6af07808c5b91c329f73bfda674a7c43',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('6b00652939163de509e37994b50fa867','GGG',1493712282,'c87954eaea3ed578ea5606c103e21aeb',1,1),('6b666539104d3f3409409ac508192871','155: from 2 to 1 6b666539104d3f3409409ac508192871',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('6e81a4fb2e648cf3d13075a11f4d5c32','161: from 1 to 3 6e81a4fb2e648cf3d13075a11f4d5c32',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('7040cde30342a72a5b1e3cf689e233e0','141: from 2 to 1 7040cde30342a72a5b1e3cf689e233e0',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('710c7dd5b95c5144035b124961a31ca4','www',1493493631,'c87954eaea3ed578ea5606c103e21aeb',1,1),('74ac1ca7f76fffdf8dd5beb9131755fa','14: from 2 to 1 74ac1ca7f76fffdf8dd5beb9131755fa',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('74cd7902498b978645d06e42ad4860e8','ggg',1493879491,'650daf5b0807ada3e205349e2d48e82f',3,1),('7763bdf208ddf96b8a5b1a6d5753192c','71: from 1 to 3 7763bdf208ddf96b8a5b1a6d5753192c',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('782122afdd8fcd7dc920d160bd681945','140: from 3 to 1 782122afdd8fcd7dc920d160bd681945',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('7899519d0fb83cf7bb27d31875b77229','24: from 1 to 2 7899519d0fb83cf7bb27d31875b77229',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('798e76cd8656f69495734056a97d453c','hi',1493881165,'650daf5b0807ada3e205349e2d48e82f',3,1),('7aa85dc5ba4e00348e8c63a34e53af97','qweqweq',1493490695,'c87954eaea3ed578ea5606c103e21aeb',2,1),('7acaa7dbffb33dca6d91bbafb2b4362e','30: from 2 to 1 7acaa7dbffb33dca6d91bbafb2b4362e',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('7b909967e52569e4e824e39b1c42ed1f','46: from 2 to 1 7b909967e52569e4e824e39b1c42ed1f',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('7e100b68dbd67707df8134cb6ff1a0b8','sdasda',1493882249,'650daf5b0807ada3e205349e2d48e82f',3,1),('7e31a8ef4b60f501a4498fba80a0a228','3 from end',1492589945,'650daf5b0807ada3e205349e2d48e82f',1,1),('7f5f77484c84023731ecab2f0975e189','37: from 2 to 1 7f5f77484c84023731ecab2f0975e189',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('812d95c4b13cc8e7c34b7bc60a001a7b','хэй',1493573147,'650daf5b0807ada3e205349e2d48e82f',1,1),('81ab542032ee8188892b461d53b6859e','89: from 2 to 3 81ab542032ee8188892b461d53b6859e',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('81af9178174d74065c2f960376c1c996','73: from 1 to 2 81af9178174d74065c2f960376c1c996',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('81bc4dc91bfd9e23248a2be6c0c735d9','hi',1493881117,'650daf5b0807ada3e205349e2d48e82f',1,1),('830cf263e0b7a3683367b03f9e6a524f','29: from 2 to 1 830cf263e0b7a3683367b03f9e6a524f',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('846d69504460a97f9390c31870abf306','177: from 1 to 2 846d69504460a97f9390c31870abf306',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('8505170e8c46c6a587567530c4badcce','193: from 2 to 1 8505170e8c46c6a587567530c4badcce',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('858c5c4bc6a0f8e6af08d79fdf78f14a','c',1493545825,'c87954eaea3ed578ea5606c103e21aeb',1,1),('85fff3254602db44d9a74c88c10b52c1','aa',1494427696,'650daf5b0807ada3e205349e2d48e82f',1,1),('8608e0380800ddcf0ca58f8257909be3','200: from 2 to 1 8608e0380800ddcf0ca58f8257909be3',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('863e96413daa5f76d6e8a708c76ce44e','привет!',1493712426,'c87954eaea3ed578ea5606c103e21aeb',1,1),('8bf1951e9bff7a9cfd2d2476638aabfc','fff',1493880275,'650daf5b0807ada3e205349e2d48e82f',3,1),('8e73506ca01c511ab5f78d9393529136','Hi!',1493882223,'650daf5b0807ada3e205349e2d48e82f',1,1),('8eaf86c8499712153f39bdeb74d322e6','165: from 1 to 2 8eaf86c8499712153f39bdeb74d322e6',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('8eb716144c35fe7aa332374d36708e8a','ggg',1493879660,'650daf5b0807ada3e205349e2d48e82f',3,1),('8efe0f86cd3149a1a1eb548888712e4a','21: from 1 to 2 8efe0f86cd3149a1a1eb548888712e4a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('90dc289e27a9c221614619445f795286','YYZZZAAAAA!!!',1493882176,'650daf5b0807ada3e205349e2d48e82f',3,1),('90f1a1c9711eb6c58b29b5321641359e','164: from 3 to 2 90f1a1c9711eb6c58b29b5321641359e',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('951073f81b3adb68f59cebeb0eaceaf2','42: from 2 to 3 951073f81b3adb68f59cebeb0eaceaf2',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('966a8a5704c916ef9c11de9d151cecac','44: from 1 to 2 966a8a5704c916ef9c11de9d151cecac',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('985f85f7d7ea7cc224eaa23538de97b8','160: from 2 to 3 985f85f7d7ea7cc224eaa23538de97b8',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('991645fcff36d3b06d5a6d14a7da4952','99: from 2 to 1 991645fcff36d3b06d5a6d14a7da4952',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('9a96fe1d2c131d1834fb6243e5c8e690','77: from 3 to 2 9a96fe1d2c131d1834fb6243e5c8e690',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('9c114bce59cbc693d32b5b654240220b','123',1493882455,'650daf5b0807ada3e205349e2d48e82f',3,1),('9dc91a70e18801a00c6cc4837b70ac41','Вот думаю, как быть',1493880297,'650daf5b0807ada3e205349e2d48e82f',3,1),('9f1c5b3c2c63eba26ed8b0ac6ccbe430','привет',1493573269,'650daf5b0807ada3e205349e2d48e82f',3,1),('9faa8754c2a30a51096685d6a661f5cf','53: from 3 to 2 9faa8754c2a30a51096685d6a661f5cf',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('9fdadbc0adf9efb9883b261f82153df5','qwe last',1492546217,'650daf5b0807ada3e205349e2d48e82f',1,1),('a08383baafb70294e667649557ec4bd8','75: from 1 to 3 a08383baafb70294e667649557ec4bd8',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('a20c1e3bf4f0d77af0c39709beafcb0c','163: from 2 to 3 a20c1e3bf4f0d77af0c39709beafcb0c',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('a25f7d6e33d95771fbea93c5e547daa8','149: from 1 to 3 a25f7d6e33d95771fbea93c5e547daa8',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('a2aee6823e9b62b6650a98919a93183a','e',1493493654,'c87954eaea3ed578ea5606c103e21aeb',1,1),('a4016031591dafe8ef622bd1a34c2f6f','49: from 1 to 3 a4016031591dafe8ef622bd1a34c2f6f',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('a4c535ecec15b3805a7e2f71cea2b0bb','fdsjhfsdh',1493882445,'650daf5b0807ada3e205349e2d48e82f',3,1),('a4c60b136af0bd46db9b055b07227d21','Привет!',1493573074,'650daf5b0807ada3e205349e2d48e82f',3,1),('a50cbb02e1a93329a33baa48355a9eb3','122: from 3 to 2 a50cbb02e1a93329a33baa48355a9eb3',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('a813400337d8901770764cd5d5bbc747','t',1493493701,'c87954eaea3ed578ea5606c103e21aeb',1,1),('aaa9b203002cdef42997930c1d5a2b1d','120: from 1 to 2 aaa9b203002cdef42997930c1d5a2b1d',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('ab3392426a46ceb02037b6e42e98b409','104: from 1 to 2 ab3392426a46ceb02037b6e42e98b409',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('abc17b8d93de70e683357e5ce297f8d4','хай',1493573298,'650daf5b0807ada3e205349e2d48e82f',1,1),('ac3961be067791337a51ec393cfe3114','4: from 3 to 2 ac3961be067791337a51ec393cfe3114',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('ae24ad21c287076254626c851c2eabca','74: from 2 to 1 ae24ad21c287076254626c851c2eabca',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('b14d416a3c50be09cf6d74fd8189b557','4 from end',1492589994,'650daf5b0807ada3e205349e2d48e82f',1,1),('b3a11fa9f565ee62ea460954410bcb4c','112: from 3 to 1 b3a11fa9f565ee62ea460954410bcb4c',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('b420658ed188fccff7ddc4546323449e','167: from 2 to 3 b420658ed188fccff7ddc4546323449e',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('b446df0e82878efcc830e8f6ac852e58','Ааа, ну так это как всегда. Конечно быть...! :) &lt;script&gt;alert(123)&lt;/script&gt;',1493880787,'650daf5b0807ada3e205349e2d48e82f',1,1),('b44c5c919d156be3d4b76f5731790a43','38: from 2 to 1 b44c5c919d156be3d4b76f5731790a43',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('b754b5103a8b2ccf47739f71b78d9c17','Hi !',1493491526,'c87954eaea3ed578ea5606c103e21aeb',1,1),('b9ee24577af5f843efc63cd9cdae4df4','xxx',1493712114,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bb20125112039989496312444a31f077','88: from 1 to 2 bb20125112039989496312444a31f077',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bb38d70b694d1dc37a5a97fd50872b9b','asd',1493882248,'650daf5b0807ada3e205349e2d48e82f',3,1),('bb4fdc6b1f47ddadc8a67b5df6eb6d5a','12: from 1 to 2 bb4fdc6b1f47ddadc8a67b5df6eb6d5a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bd7855337111c646cbd75f9d5090cebc','36: from 2 to 1 bd7855337111c646cbd75f9d5090cebc',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('be7c137a666c2196d91d3689f1472a1d','194: from 1 to 2 be7c137a666c2196d91d3689f1472a1d',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('bed90c013178a3d91cbed1bb800b07d8','183: from 1 to 3 bed90c013178a3d91cbed1bb800b07d8',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('bfdd79b220de6176b60dd16289399046','117: from 3 to 1 bfdd79b220de6176b60dd16289399046',1493311921,'650daf5b0807ada3e205349e2d48e82f',3,1),('c30cc12f54dfd611d53752b10ad59378','Y!',1493572746,'650daf5b0807ada3e205349e2d48e82f',3,1),('c4b319f175d14b74baed8dcd8ffbd2c6','107: from 1 to 2 c4b319f175d14b74baed8dcd8ffbd2c6',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('c60314aa23e5f22350f257be045b62a8','186: from 2 to 3 c60314aa23e5f22350f257be045b62a8',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('c7f9f98ae26de37ae491d1ba6f556706','Думаю, быть или не быть!',1493880763,'650daf5b0807ada3e205349e2d48e82f',3,1),('c7fbd4326ef839469154640a86c4fcfa','159: from 1 to 2 c7fbd4326ef839469154640a86c4fcfa',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('c89600240baf5612a3ef9dee021b8c75','151: from 1 to 3 c89600240baf5612a3ef9dee021b8c75',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('c9001b2fd4019bc2bc51fcad19d3941a','yyy',1493493703,'c87954eaea3ed578ea5606c103e21aeb',1,1),('c922a78da9d635e75cbf9ffa2bc64b0b','first',1492590027,'650daf5b0807ada3e205349e2d48e82f',3,1),('c93925c4161a57dbd2226033e397a0e1','196: from 3 to 2 c93925c4161a57dbd2226033e397a0e1',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('ca0f4de6bccdeb42cf4e9cf065f3fa99','83: from 2 to 3 ca0f4de6bccdeb42cf4e9cf065f3fa99',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('ce83a79453d4b303d1eca581d6d508b3','QQQ',1493712150,'c87954eaea3ed578ea5606c103e21aeb',1,1),('cfa6a4fe85df876ecf9b64436a88b3b3','6: from 1 to 2 cfa6a4fe85df876ecf9b64436a88b3b3',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('d0a832607e678f4834991dc36bb3a197','105: from 2 to 1 d0a832607e678f4834991dc36bb3a197',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('d17a7156caaa9efca006da1e5381ab8d','eee',1493879584,'650daf5b0807ada3e205349e2d48e82f',3,1),('d1b11c486c034535fb309672ab9ca8da','GGG',1493572283,'650daf5b0807ada3e205349e2d48e82f',1,1),('d1faf3afd36158f70bcf734891e14a9f','114: from 3 to 2 d1faf3afd36158f70bcf734891e14a9f',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('d47da539cfae0dfb602572bd5ddc9d48','asdasd',1493882456,'650daf5b0807ada3e205349e2d48e82f',3,1),('d55ec3f2f94a2e33b9203e14f4e7e2c3','йцу',1493573686,'650daf5b0807ada3e205349e2d48e82f',3,1),('d5a2fe35d7f2be93de0b4a17c2e292cc','qqq',1493572972,'650daf5b0807ada3e205349e2d48e82f',1,1),('d725d2f89ec945de2dc99681dd4a0327','174: from 2 to 1 d725d2f89ec945de2dc99681dd4a0327',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('d76f6bbb46186ff04dad4e54d987c8fb','Hola',1493882233,'650daf5b0807ada3e205349e2d48e82f',3,1),('d78255d7d9943898469ee5aaaa42a1f2','ffff',1493573713,'650daf5b0807ada3e205349e2d48e82f',1,1),('d7e32578df1173c5227550a1b6375e53','132: from 1 to 2 d7e32578df1173c5227550a1b6375e53',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('da004fe93a9afb59413c3ccf28ac4367','Что случилось ?',1493880736,'650daf5b0807ada3e205349e2d48e82f',1,1),('dacd0646f8402e4237abac9a2a22d8b8','хер да маленько',1493573537,'650daf5b0807ada3e205349e2d48e82f',1,1),('daf427c644499b15fdde738b14816463','adad',1493882433,'650daf5b0807ada3e205349e2d48e82f',3,1),('db346fd766ed87249bc541ba9df764ab','ff',1493545858,'c87954eaea3ed578ea5606c103e21aeb',1,1),('dd921ce6ada61c75e2a22c109f971a54','195: from 1 to 3 dd921ce6ada61c75e2a22c109f971a54',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('ddacc7613875e6d5afe56328691d447f','169: from 1 to 2 ddacc7613875e6d5afe56328691d447f',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('dec5ff38dbe187378a5108c4154d6040','w',1493546142,'c87954eaea3ed578ea5606c103e21aeb',1,1),('ded19d9994bc3584b7149239dfc8799c','96: from 2 to 1 ded19d9994bc3584b7149239dfc8799c',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('dfb93c03c9824a3d45db079276526e3f','sdads',1493882435,'650daf5b0807ada3e205349e2d48e82f',3,1),('e120801503e2f800601f513779649418','qqq',1493493579,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e15392f95207eaddffcd6b55c26db459','TT',1493712332,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e19c08575c647dbc9d01a022305c533f','56: from 1 to 3 e19c08575c647dbc9d01a022305c533f',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('e21e327f2b46947d21cb891bcf6e4d95','185: from 1 to 2 e21e327f2b46947d21cb891bcf6e4d95',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e37f69cb940affc6908a943eb3894ac6','pre last',1492546532,'650daf5b0807ada3e205349e2d48e82f',3,1),('e7a84932fcaad1258b8c7620ad8abbe1','187: from 1 to 2 e7a84932fcaad1258b8c7620ad8abbe1',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('e85bc246f2bcefd66f9bd760c77d86ba','fdsjhfsdh',1493882450,'650daf5b0807ada3e205349e2d48e82f',3,1),('e92e9c2e7b266d9f165bee783afa363c','60: from 2 to 1 e92e9c2e7b266d9f165bee783afa363c',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('e936be2b43c7d43b87f317af76a85a5e','198: from 1 to 3 e936be2b43c7d43b87f317af76a85a5e',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('e9e84f54dcc24e33cfdc9f5c5ae26b11','145: from 2 to 3 e9e84f54dcc24e33cfdc9f5c5ae26b11',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('ec30edde932e5a47a4e26fe9ce49c333','116: from 2 to 1 ec30edde932e5a47a4e26fe9ce49c333',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('ec8c7d1ae2f07776289d3d2f8ac8a101','eee',1493880000,'650daf5b0807ada3e205349e2d48e82f',3,1),('ee36de8295bf6e8902449f819c31e26f','191: from 1 to 3 ee36de8295bf6e8902449f819c31e26f',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('eeac24af06e6ce9e4e4db8f4e5996550','ППП',1493573449,'650daf5b0807ada3e205349e2d48e82f',3,1),('ef426ebaafee17c365facd0b37bcff61','q',1493566459,'c87954eaea3ed578ea5606c103e21aeb',1,1),('ef82e0ca38bff7ede56d77f9f8b5cd95','128: from 2 to 1 ef82e0ca38bff7ede56d77f9f8b5cd95',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('f066322ed0530a5654f4bf0e09c34308','привет !',1493880292,'650daf5b0807ada3e205349e2d48e82f',3,1),('f0f32ec53d26baa43151cfa26b742661','81: from 2 to 3 f0f32ec53d26baa43151cfa26b742661',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f4aa1be4ef86cf5fdb972f35ad285f8c','124: from 1 to 2 f4aa1be4ef86cf5fdb972f35ad285f8c',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f56ea979c68e491395c948a12016d81b','9: from 2 to 3 f56ea979c68e491395c948a12016d81b',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f66374ea744c4a6db1b6c7bd20613d18','184: from 2 to 3 f66374ea744c4a6db1b6c7bd20613d18',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f6bf7bcc0a46117e34fae36662ecfa7f','r',1493493697,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f747797a08a16d40ac65ed23197f2d4c','63: from 2 to 3 f747797a08a16d40ac65ed23197f2d4c',1493311921,'38d57ca87af07b563cd404af051ce87d',2,1),('f78be00cc02b8bb124c11a5b74c60306','0: from 3 to 2 f78be00cc02b8bb124c11a5b74c60306',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1),('f913a088866a9f3e6ba418718b4f6ff5','170: from 1 to 3 f913a088866a9f3e6ba418718b4f6ff5',1493311921,'650daf5b0807ada3e205349e2d48e82f',1,1),('f9de5b44c13a1e69dd76c3d242e1972a','91: from 1 to 2 f9de5b44c13a1e69dd76c3d242e1972a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',1,1),('f9f16a56a0d4563afa12ab3885246f8a','126: from 2 to 1 f9f16a56a0d4563afa12ab3885246f8a',1493311921,'c87954eaea3ed578ea5606c103e21aeb',2,1),('facf7240adbc02ad8ed2e3dae04f2e78','192: from 3 to 2 facf7240adbc02ad8ed2e3dae04f2e78',1493311921,'38d57ca87af07b563cd404af051ce87d',3,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (8,3,7,'VIP Кинотеатр','ад',1495022219,3,'f42078f277d7033664a2510feb67f7bb',2),(9,2,4,'1','2',1495026432,3,'cab66418fd4716f078fde05783d1b143',2),(10,1,2,'2','qqq\n\n\nasd\nas\n\n\n\n\nqweq\nw',1495026547,3,'eb10f8d50367d114fa20587108e09423',2),(11,1,3,'3','q',1495026605,3,'2d581d7c2341e7a17f5dde1e4173f1e9',2),(12,2,4,'4','4',1495026619,3,'95a63ebbb5496117e031d2210bc050cf',2),(13,2,5,'5','5',1495026625,3,'',1),(14,2,6,'6','6',1495026632,3,'',0),(15,3,7,'7','7',1495026638,3,'',0),(16,3,8,'83','854',1495026644,3,'70af5806a42ba3da6751ca3ec66c8ced',2),(17,3,9,'9','9',1495026649,3,'',1),(18,3,10,'10','10',1495026656,3,'',0),(19,2,4,'11','11',1495026666,3,'',0),(20,2,6,'12','12',1495026672,3,'',1),(21,3,10,'Птички','Всякие разные',1495026681,3,'5428abcf36c423e5f8e3b2e763ccc4e2',3),(22,3,8,'Ресторан твоей мечты','Внимательный персонал, профессиональный ведущий и восхитетельная кухня!',1495111859,1,'57e1245c26d2270f90a029664daa423f',1),(23,3,9,'Коттедж для вашего праздника','Смотрите сами!',1495625525,2,'6121ed8b8d9ad902b7e53b2343bcb6cf',1);
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
  `descr` varchar(255) NOT NULL,
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
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (3,'title test','ТЕСТОВЫЙ\nПРоЕгТ!\n\n&lt;script&gt;alert(1)&lt;/script&gt;',0,1493108975,4,1,1493713663,1493713663,1493713663,2,5,1,0,0,8,0,''),(4,'&lt;script&gt;alert(1)&lt;/script&gt;','ТЕСТОВЫЙ\nПРоЕгТ!\n\n&lt;script&gt;alert(1)&lt;/script&gt;\n\n@!&amp;!!&lt;script&gt;alert(&quot;xss&quot;);&lt;/script&gt;',0,1493110514,1,1,1498770000,1498770000,1498770000,2,6,2,0,0,10,0,''),(5,'test for spb','test from weedo company',8600,1493720263,1,1,1498770000,1498770000,1498770000,1,1,2,0,0,15,0,''),(6,'Test','Test project',600,1495040637,3,3,1498770000,1498770000,1498770000,1,1,2,1,1,9,0,''),(7,'Фотограф на свадьбу в Новогиреево','Фотограф на выезд в ресторан',5000,1495539768,3,3,1496178000,1496178000,1496178000,1,2,2,0,0,2,1,''),(8,'Ресторан для моего праздника','тест',8000,1496065774,3,1,1498770000,1498770000,1498770000,3,8,2,0,0,4,0,'796722fb15975876560de5d7ce0c87d7'),(10,'Фотобудка на мой праздник','фывйц',2500,1496075871,1,1,1496437200,1496437200,1496437200,1,3,2,0,0,4,0,'796722fb15975876560de5d7ce0c87d7'),(11,'Музыкант на мой праздник','ййцу',3700,1496078528,1,1,1496506567,1496506567,1496592967,2,5,2,0,0,3,0,'796722fb15975876560de5d7ce0c87d7'),(12,'Видеограф на мой праздник','йцывсмя',19000,1496088586,1,1,1496506567,1496506567,1496592967,1,2,2,0,0,3,0,'796722fb15975876560de5d7ce0c87d7');
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_responds`
--

LOCK TABLES `project_responds` WRITE;
/*!40000 ALTER TABLE `project_responds` DISABLE KEYS */;
INSERT INTO `project_responds` VALUES (1,3,3,1493127725,'test respond text',1598,1,0),(2,3,2,1493130799,'Сделаю быстрее и качественнее всех !',500,1,0),(3,3,2,1493132138,'фвфывфы',1561,1,0),(4,3,2,1493132215,'фвфывфы',1561,1,0),(5,3,2,1493132233,'фывфыв',223123,1,0),(6,3,2,1493132280,'фывфыв',223123,1,0),(7,3,2,1493132292,'й32131',2321,1,0),(8,3,2,1493132773,'йцу',123,2,1493136630),(9,3,2,1493132862,'вфвауфуцвафцкуфцу',8388607,3,1493136883),(10,5,3,1493829054,'Здравствуйте!\n\nПосмотрите наше портфолио, выпоняем аналогичные задания быстро и не дорого!',7000,1,0),(11,6,1,1495098214,'qweq',300,5,1495524506),(12,7,1,1495548990,'Готовы выполнить дешевле',7000,5,1495552146),(13,8,3,1496065870,'Я хочу!',5000,5,1496069036),(14,12,3,1496093546,'assq',23000,1,0),(15,11,3,1496093570,'asas',4500,1,0),(16,10,3,1496093582,'aaa',1300,1,0),(17,12,2,1496094013,'21500 zvonite',21500,1,0),(18,11,2,1496094042,'zvonite dogovorimsya',0,1,0),(19,10,2,1496094066,'privezu, zvonite',2000,1,0);
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
  PRIMARY KEY (`scenario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scenario_templates`
--

LOCK TABLES `scenario_templates` WRITE;
/*!40000 ALTER TABLE `scenario_templates` DISABLE KEYS */;
INSERT INTO `scenario_templates` VALUES (1,'Свадьба','1,3,5,8'),(2,'ULTIMATE SHOW','1,2,3,4,5,6,7'),(3,'День рождения','1,4,9');
/*!40000 ALTER TABLE `scenario_templates` ENABLE KEYS */;
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
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcats`
--

LOCK TABLES `subcats` WRITE;
/*!40000 ALTER TABLE `subcats` DISABLE KEYS */;
INSERT INTO `subcats` VALUES (1,1,'Фотографы','fotografy',0,0),(2,1,'Видеографы','videografy',0,0),(3,1,'Фотобудки','fotobudki',0,0),(4,2,'Ведущие','veduschie',0,0),(5,2,'Музыканты','muzykanty',0,0),(6,2,'Артисты','artisty',0,0),(7,3,'Банкетные залы','banketnye_zaly',0,0),(8,3,'Рестораны','restorany',0,0),(9,3,'Коттеджи','kottedzhi',0,0),(10,3,'Теплоходы','teplohody',0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_calendar`
--

LOCK TABLES `user_calendar` WRITE;
/*!40000 ALTER TABLE `user_calendar` DISABLE KEYS */;
INSERT INTO `user_calendar` VALUES (49,1,1493240400,1,0),(71,3,1493326800,1,0),(72,3,1493413200,1,0);
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
INSERT INTO `user_notes` VALUES ('',1,2,1492612086),('asd\n&lt;script&gt;alert(1234)&lt;/script&gt;\nqwe',1,3,1493118098),('пидр\n\nqwe',3,1,1493228471);
/*!40000 ALTER TABLE `user_notes` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_responds`
--

LOCK TABLES `user_responds` WRITE;
/*!40000 ALTER TABLE `user_responds` DISABLE KEYS */;
INSERT INTO `user_responds` VALUES (10,1,6,3,'qqqq',1495524506,7),(11,1,7,3,'Самый лучший фотограф!',1495552146,10),(12,3,8,1,'Good!',1496069036,9);
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
INSERT INTO `user_scenarios` VALUES ('796722fb15975876560de5d7ce0c87d7',1,1,'Мой праздник',23000,1496506567,1496592967,'3,5,8',0);
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
INSERT INTO `user_templates` VALUES (1,'Общие'),(2,'Администратор');
/*!40000 ALTER TABLE `user_templates` ENABLE KEYS */;
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
  `skype` varchar(75) NOT NULL,
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
  `timestamps` varchar(1024) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'GUEST','0-','0-','','GUEST','','','','',0,0,1492371605,1,'::1',0,0,3,1,0,'','','','','',0,'','','','0','0','0','0','0',0,''),(1,'admin@weedo.ru','4052a28f3e6dd1985e5a914959366a7c2928c7f24b9eb2735d020bd318de7eaae0f361c3e970c993302a2592ffe4296ff0c4be937b8ac6a40c53a88ffc93f050','390e7342f25f7547ad72477ed1c6109b08d204057710fe8807e57096b33fd8e80f200d5464413b3a73c565aee5b0eac02563e313e734492b0268c90bc40489ed','WEEDO COMPANY Z','Тетерин','Евгений','WEEDO COMPANY','79312553075','skype://stuff.r59',2,1,1492271605,2,'::1',1496096803,1,1,1,0,'http://vk.com/e.teterin','59.9843134170805 30.20952701568604','\0\0\0\0\0\0\0��g���M@\0\0��5>@','Halliluyah!!!','ХЗ!',-178426800,'','','','','','','','',1495626661,'eyJwcm9qZWN0c19yZWFkZWQiOltdfQ=='),(2,'manager','c4e47d8a39278de06599df99e7858b58478dbcc6e5e62d29c594af5b7213ca88bbfd88c1dd7181f37cd4fe5c3293fc3bd04fbcb74bd44a27cf30376554639822','848bd526cde43789fec3e8e6987959a4a5db37becd8a17d07804386fb52a84ab5595b07f2d00dae3b854a9692055b17f9329093457105b5ed0887543626d54f7','Manager 1','Менеджер 1','','Manager Company','','',2,1,1492171605,2,'::1',1496096921,1,1,1,0,'','60.047146433033355 30.133438110351566','\0\0\0\0\0\0\0+\0��N@\0\0\0)\">@','','Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! Делаем крутые фото мероприятий. Давайте скорее сотрудничать, а то потом не успеете! ',0,'','','','','','','','',1495626661,''),(3,'demo','2a04e3d3ff6353d201fd021ff9795b2a389de6ed973e40ce6357e669abd63b58b0f79482e58d0bfd2285bc6ecaba3c00c3169c53b6cc182331c5ff423c4cb282','e31c083c156a6014a56da3f6657a075ff39fefa38ab675e2c1593b724ac59d20c58c2f9840a8357b6e0df6c258f3ce8c0889099c3931b7b98eb933bc21a69b1f','Гранат и Компания!','Демо','','&lt;script&gt;alert(1)&lt;/script&gt;','','',2,1,1491971605,1,'::1',1496093583,1,1,1,0,'','59.96057488864537,30.370674133300785','','Лучшее световое шоу!','Лучшее световое шоу в России и странах СНГ!',580593600,'','','','','','','','',1496078477,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warnings`
--

DROP TABLE IF EXISTS `warnings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `for_project_id` int(11) NOT NULL,
  `for_respond_id` int(11) NOT NULL,
  `for_user_id` int(11) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warnings`
--

LOCK TABLES `warnings` WRITE;
/*!40000 ALTER TABLE `warnings` DISABLE KEYS */;
INSERT INTO `warnings` VALUES (1,104,0,0,'Систематическое нарушение правил. Блокировка создания проектов на 3 дня',1);
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

-- Dump completed on 2017-05-30  1:32:29
