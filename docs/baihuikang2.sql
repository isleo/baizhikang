/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50634
Source Host           : localhost:3306
Source Database       : baihuikang

Target Server Type    : MYSQL
Target Server Version : 50634
File Encoding         : 65001

Date: 2016-11-20 14:06:05
*/

SET FOREIGN_KEY_CHECKS=0;


-- ----------------------------
-- Table structure for bzk_download
-- ----------------------------
DROP TABLE IF EXISTS `bzk_download`;
CREATE TABLE `bzk_download` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) NOT NULL COMMENT '操作系统',
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '版本号',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '下载地址',
  `createTime` int(10) DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- ----------------------------
-- Table structure for bzk_user_suggestion
-- ----------------------------
DROP TABLE IF EXISTS `bzk_user_suggestion`;
CREATE TABLE `bzk_user_suggestion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号码',
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '意见内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
