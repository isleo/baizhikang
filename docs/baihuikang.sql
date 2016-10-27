/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50634
Source Host           : localhost:3306
Source Database       : baihuikang

Target Server Type    : MYSQL
Target Server Version : 50634
File Encoding         : 65001

Date: 2016-10-27 22:44:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bzk_user_info
-- ----------------------------
DROP TABLE IF EXISTS `bzk_user_info`;
CREATE TABLE `bzk_user_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别',
  `weight` decimal(5,2) unsigned DEFAULT NULL COMMENT '体重',
  `height` decimal(5,2) unsigned DEFAULT NULL COMMENT '身高',
  `age` int(11) unsigned DEFAULT NULL COMMENT '年龄',
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'qq',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '家庭地址',
  `loginTime` int(10) unsigned DEFAULT NULL COMMENT '登录时间',
  `createTime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `updateTime` int(10) unsigned DEFAULT NULL COMMENT '更新时间 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
