-- MySQL dump 10.13  Distrib 5.6.33, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: baizhikang
-- ------------------------------------------------------
-- Server version	5.6.33-0ubuntu0.14.04.1

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
-- Table structure for table `bzk_device_info_log`
--

DROP TABLE IF EXISTS `bzk_device_info_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bzk_device_info_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `deviceName` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '设备名',
  `userId` int(11) unsigned NOT NULL COMMENT '用户id',
  `disconnectFre` int(11) unsigned DEFAULT '0' COMMENT '断开次数',
  `sensitivityFre` int(11) unsigned DEFAULT '0' COMMENT '灵敏度报警',
  `moveFre` int(11) unsigned DEFAULT '0' COMMENT '移动报警',
  `disappearFre` int(11) unsigned DEFAULT '0' COMMENT '防丢报警',
  `linkTime` int(10) unsigned DEFAULT NULL COMMENT '连接时间',
  `createTime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updateTime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bzk_device_info_log`
--

LOCK TABLES `bzk_device_info_log` WRITE;
/*!40000 ALTER TABLE `bzk_device_info_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `bzk_device_info_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bzk_user_info`
--

DROP TABLE IF EXISTS `bzk_user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bzk_user_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `nickname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '昵称',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别',
  `weight` decimal(5,2) unsigned DEFAULT NULL COMMENT '体重',
  `height` decimal(5,2) unsigned DEFAULT NULL COMMENT '身高',
  `birthTime` int(10) unsigned DEFAULT NULL COMMENT '出生时间',
  `age` int(11) unsigned DEFAULT NULL COMMENT '年龄',
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'qq',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '家庭地址',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片地址',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '用户黑白名单',
  `loginTime` int(10) unsigned DEFAULT NULL COMMENT '登录时间',
  `createTime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updateTime` int(10) unsigned DEFAULT NULL COMMENT '更新时间 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bzk_user_info`
--

LOCK TABLES `bzk_user_info` WRITE;
/*!40000 ALTER TABLE `bzk_user_info` DISABLE KEYS */;
INSERT INTO `bzk_user_info` VALUES (2,'13922722914','14e1b600b1fd579f47433b88e8d85291',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1479140683,1478877328,NULL);
/*!40000 ALTER TABLE `bzk_user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bzk_user_relationship`
--

DROP TABLE IF EXISTS `bzk_user_relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bzk_user_relationship` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userId` int(11) unsigned NOT NULL COMMENT '用户id',
  `relationId` int(11) unsigned NOT NULL COMMENT '关联账号id',
  `createTime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updateTime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bzk_user_relationship`
--

LOCK TABLES `bzk_user_relationship` WRITE;
/*!40000 ALTER TABLE `bzk_user_relationship` DISABLE KEYS */;
/*!40000 ALTER TABLE `bzk_user_relationship` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-15  5:47:44
