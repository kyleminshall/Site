-- MySQL dump 10.13  Distrib 5.5.38, for Linux (x86_64)
--
-- Host: localhost    Database: Site
-- ------------------------------------------------------
-- Server version	5.5.38

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
-- Table structure for table `Facebook`
--

DROP TABLE IF EXISTS `Facebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Facebook` (
  `Username` varchar(256) DEFAULT NULL,
  `Password` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facebook`
--

LOCK TABLES `Facebook` WRITE;
/*!40000 ALTER TABLE `Facebook` DISABLE KEYS */;
INSERT INTO `Facebook` VALUES ('testingq','go'),('Test','Email'),('Test','emails'),('kyleminshall@gmail.com','ThisIsNotMyRealPassword'),('Emails','Passwords'),('Again','Testing'),('hikylelmao@why.edu','password'),('i hate you ','kyle '),('Test Email','password'),('kyleminshall','password'),('kyleminshall@gmail.com','password123'),('kyleminshall@gmail.com','password'),('kyleminshall@gmail.com','ABC123'),('exampleemail@mail.com','123password'),('kyleminshall@gmail.com','Password1234'),('poop@poop.com','dude you were freakin awesome today i loved it'),('hello',' '),('ilovefishing','inaboat');
/*!40000 ALTER TABLE `Facebook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Gmail`
--

DROP TABLE IF EXISTS `Gmail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gmail` (
  `Username` varchar(256) DEFAULT NULL,
  `Password` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Gmail`
--

LOCK TABLES `Gmail` WRITE;
/*!40000 ALTER TABLE `Gmail` DISABLE KEYS */;
INSERT INTO `Gmail` VALUES ('kyleminshall','Minshall1'),('rekt@urMom.com','KyleLikesitinthebumbum'),('dickbutt@gmail.com','dicks'),('fuckyoukyle@gmail.com','jaykaykyle'),('KyleM','password'),('kyle.minshall@pose.com','MinshallTest'),('mobile','does this still woek?'),('1!',''),('Doesthiswork?','Lollollol'),('hai','kyle'),('kyleminshall@gmail.com','asdf'),('kyleminshall@gmail.com','password'),('kylesdfa','asdfasdf');
/*!40000 ALTER TABLE `Gmail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OGs`
--

DROP TABLE IF EXISTS `OGs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OGs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `is_admin` int(4) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `profile` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OGs`
--

LOCK TABLES `OGs` WRITE;
/*!40000 ALTER TABLE `OGs` DISABLE KEYS */;
INSERT INTO `OGs` VALUES (1,'Kyle Minshall','Kilenaitor','4656706f7602c733f1d16b7153653f49',1,'2014-08-31 14:10:40','https://s3-us-west-1.amazonaws.com/kyleminshall/Hi.jpg'),(2,'Kyle Del Campo','Divine','ec5feb0a9ad02082eb5e61be002e3904',0,NULL,NULL),(3,'Sam Waldow','samwaldow','2ab96390c7dbe3439de74d0c9b0b1767',0,'2014-09-02 21:44:23',NULL),(4,'Joonte Lee','parablooper','f48a71020846629cc5bffe9907d21d4e',0,NULL,NULL),(5,'James Dehnert','Willis','6ab71b64218e56a7f68fe6e8d27a5893',0,NULL,NULL),(6,'Alexander Duong','CatsGoBark','f1457921c9081236e013cb92d8e5a1ee',0,NULL,NULL),(8,'Joshua Wong','pockymons','fdee8df515fe5a6d9a592bc45d6a1a65',0,NULL,NULL),(9,'John Styffe','TheRealVincentio','6be4796ba0076d27b18b5c26e5606f7d',0,'2014-09-02 08:04:24',NULL),(10,'Dulf Herrera','Huggly001','065792a72fe18adb534e38fffd8b6ab2',0,NULL,NULL),(11,'Bryan Ferguson','FurFoxSake','69d314ad469f978ff36d32b5f0f336d0',0,'2014-09-01 11:53:16',NULL);
/*!40000 ALTER TABLE `OGs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Persons`
--

DROP TABLE IF EXISTS `Persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Persons` (
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Persons`
--

LOCK TABLES `Persons` WRITE;
/*!40000 ALTER TABLE `Persons` DISABLE KEYS */;
INSERT INTO `Persons` VALUES ('kyleminshall@gmail.com','Minshall1'),('physics@toohard.com','iamdying'),('samwaldow123@gmail.com','asdf1234'),('','');
/*!40000 ALTER TABLE `Persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Owen','ogong','password'),(2,'Kyle','kminshall','password'),(3,'Mr. Allen','dallen','Password!');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) DEFAULT NULL,
  `post` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (4,'samwaldow',12),(5,'samwaldow',9),(17,'samwaldow',8),(59,'Kilenaitor',3),(68,'Kilenaitor',8),(82,'Kilenaitor',1),(150,'Kilenaitor',12),(151,'Kilenaitor',13),(153,'Kilenaitor',14),(154,'Kilenaitor',15),(155,'samwaldow',16),(156,'samwaldow',18),(157,'Kilenaitor',17),(158,'parablooper',18);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pem`
--

DROP TABLE IF EXISTS `pem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pem` (
  `key` varchar(256) NOT NULL DEFAULT '',
  `used` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pem`
--

LOCK TABLES `pem` WRITE;
/*!40000 ALTER TABLE `pem` DISABLE KEYS */;
INSERT INTO `pem` VALUES ('8LUgMBFWkm',1),('dakf5MVvdr',1),('DMTQJBf1tQ',1),('JJ07x5VRF5',1),('MZEbJbeWAc',1),('pDW6MGSCmk',0),('qfsdCBCqC7',1),('VLWtycxmuB',1),('xGV2L9s2nN',1),('XI1fQsf0WQ',1);
/*!40000 ALTER TABLE `pem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) DEFAULT NULL,
  `comment` varchar(256) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `likes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Kilenaitor','Testing the comments','2014-08-29 01:28:30',1),(3,'parablooper','how do i quick scope','2014-08-29 01:39:27',1),(4,'Kilenaitor','Hope you guys think this is kinda cool :)','2014-08-29 01:41:10',0),(5,'parablooper','version 0.0.4, I expect to see some serious injection-proofing, sir.','2014-08-29 01:42:11',0),(6,'TheRealVincentio','Forgot to make name the little bobby tables joke from xkcd.','2014-08-29 12:49:01',0),(7,'Huggly001','Is this the place where we call each other faggots?','2014-08-29 14:33:50',0),(8,'Kilenaitor','Do you guys like it? :D','2014-08-29 17:29:09',2),(9,'Kilenaitor','So this is what I have so far. Mostly just a board with comments. <br>\r\n<br>\r\nWhat do you guys want to see? What features do you want added? <br>\r\n<br>\r\nComment below and I\'ll start a list of what I\'m currently working on. Features list. Bug fixes. Etc. ','2014-08-29 19:27:40',1),(12,'samwaldow','#rekt<br />\r\n','2014-08-31 14:38:05',2),(13,'Kilenaitor','https://www.youtube.com/watch?v=iQnAL-f2grI<br />\r\n<br />\r\n<br />\r\nCool music video. o.o<br />\r\nIt\'s K-Pop but still pretty cool.','2014-08-31 20:19:27',1),(14,'Huggly001','https://www.youtube.com/watch?v=-Y5U8n4Ie3I<br />\r\nPersona 5 trailer for more #visibility. ','2014-09-01 12:33:04',1),(15,'TheRealVincentio','Anyone else on that Ajax hype train? http://i.walmartimages.com/i/p/00/03/50/00/41/0003500041130_500X500.jpg','2014-09-02 08:04:00',1),(16,'parablooper','Retoast.<br />\r\nhttp://i.imgur.com/hal91bt.jpg','2014-09-02 19:09:23',1),(17,'samwaldow','What the fuck is up with all dis tiling shitz amirite #learn2code #AjaxIsEZ','2014-09-02 20:40:14',1),(18,'samwaldow','Hey guys btw apparently kyle is deencrypting our passwords and stealing our bank accounts','2014-09-02 20:42:43',2);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `username` varchar(256) DEFAULT NULL,
  `reply` varchar(256) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES (1,7,'Kilenaitor','This is a test reply','2014-08-29 16:56:19'),(2,7,'Kilenaitor','Does this seriously work now?!','2014-08-29 17:07:06'),(3,6,'Kilenaitor','More comments! :D','2014-08-29 17:07:19'),(4,7,'Kilenaitor','WOOO','2014-08-29 17:07:40'),(5,7,'Huggly001','Faggot','2014-08-29 17:10:54'),(6,8,'Kilenaitor','At least so far. ','2014-08-29 17:29:21'),(7,1,'Kilenaitor','This is a test comment.','2014-08-29 17:34:27'),(8,6,'Willis','Suck a dick','2014-08-29 17:36:08'),(9,8,'Willis','Yeah man','2014-08-29 17:36:20'),(10,8,'Kilenaitor','Sweet. I\'ll keep working on it during the weekend. :)<br>\r\nFun stuff. ','2014-08-29 19:24:45'),(11,9,'parablooper','Sometimes a new post can get completely ignored because people are rapidly commenting on another one...<br>\r\nMaybe divide into 2 or 3 columns, for<br>\r\nNEW<br>\r\nHOT<br>\r\nPINNED<br>\r\nsincerely, le reddit army xD<br>\r\n-tips fedora','2014-08-29 23:20:26'),(12,9,'parablooper','actually no I take back the columns idea. just have some kind of priority/points system on each post so BRAND new posts can\'t get sent down, but if no one comments or likes they will gradually fall below older posts in priority if said older posts were hav','2014-08-29 23:21:36'),(13,9,'parablooper','...if said older posts were getting more likes/comments','2014-08-29 23:22:39'),(14,9,'parablooper','when editing comments, have checkbox that you can choose whether to show \"Edited\" or not below the comment. Sometimes we like to edit and have edit history on display for comedic purposes, but sometimes we just make typos we\'d like to take back.','2014-08-29 23:26:02'),(15,9,'parablooper','geez i used that inclusive \"we\" quite heavily','2014-08-29 23:26:28'),(16,9,'parablooper','also, delete comment/post button','2014-08-29 23:26:41'),(17,1,'parablooper','my dick is a test comment','2014-08-29 23:28:39'),(20,6,'Kilenaitor','Just realized this actually would have broken my table. Thank you for \r\nnot doing that.','2014-08-30 10:36:53'),(21,9,'Kilenaitor','http://www.kyleminshall.com/ogs/comments.php#','2014-08-30 21:14:18'),(22,9,'Kilenaitor','Joonte, we have hyperlinks now. ','2014-08-30 21:14:30'),(23,9,'Kilenaitor','http://www.kyleminshall.com/ogs/comments.php#\r\n\r\nCan it detect it even when there are more lines?\r\n','2014-08-30 21:14:44'),(24,9,'Kilenaitor','Yes. It can. :3\r\n','2014-08-30 21:14:53'),(25,9,'Kilenaitor','http://www.kyleminshall.com/ogs/comments.php#\r\n\r\nYay','2014-08-30 21:16:31'),(26,9,'parablooper','wub wub weeb wub','2014-08-31 14:18:12'),(27,12,'samwaldow','bump','2014-08-31 14:38:10'),(29,13,'samwaldow','oh swag','2014-08-31 22:14:05'),(30,13,'samwaldow','/kappa/','2014-08-31 22:14:10'),(31,12,'parablooper','I don\'t think bumps work yet.','2014-09-01 15:02:54'),(32,14,'parablooper','what is this an anime u feg','2014-09-01 15:03:33'),(33,14,'parablooper','oh wait it\'s a game','2014-09-01 15:03:54'),(34,14,'parablooper','more like gae #rekt','2014-09-01 15:04:03'),(35,15,'Kilenaitor','John you are a scrub.','2014-09-02 08:04:42'),(36,15,'Kilenaitor','Also thanks for finding that URL bugâ€¦...','2014-09-02 08:05:26'),(37,15,'Kilenaitor','http://en.wikipedia.org/wiki/Ajax_(programming)','2014-09-02 10:36:26'),(38,15,'TheRealVincentio','http://en.wikipedia.org/wiki/Ajax_(mythology)','2014-09-02 13:19:30'),(39,15,'parablooper','I fucking love ajax','2014-09-02 17:17:01'),(40,15,'parablooper','https://www.youtube.com/watch?v=EFZK5VkQes4','2014-09-02 17:17:16'),(41,18,'Willis','BASTARD!','2014-09-02 21:54:05'),(42,18,'Kilenaitor','I KNOW WHAT A DICK!','2014-09-02 22:09:06');
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `example` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-03  6:21:56
