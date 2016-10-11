/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ffwap

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-10-11 18:09:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pf_admin_login_log
-- ----------------------------
DROP TABLE IF EXISTS `pf_admin_login_log`;
CREATE TABLE `pf_admin_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pf_admin_login_log
-- ----------------------------
INSERT INTO `pf_admin_login_log` VALUES ('15', '64', '::1', '本机地址 ', '2016-09-29 13:47:04', '2016-09-29');
INSERT INTO `pf_admin_login_log` VALUES ('16', '64', '::1', '本机地址 ', '2016-09-29 13:57:26', '2016-09-29');
INSERT INTO `pf_admin_login_log` VALUES ('17', '64', '::1', '本机地址 ', '2016-09-29 15:06:30', '2016-09-29');
INSERT INTO `pf_admin_login_log` VALUES ('18', '64', '::1', '本机地址 ', '2016-09-29 15:13:08', '2016-09-29');
INSERT INTO `pf_admin_login_log` VALUES ('19', '64', '::1', '本机地址 ', '2016-09-29 17:15:10', '2016-09-29');
INSERT INTO `pf_admin_login_log` VALUES ('20', '64', '::1', '本机地址 ', '2016-09-29 17:27:38', '2016-09-29');
INSERT INTO `pf_admin_login_log` VALUES ('21', '64', '::1', '本机地址 ', '2016-09-30 09:11:50', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('22', '59', '::1', '本机地址 ', '2016-09-30 09:44:13', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('23', '64', '::1', '本机地址 ', '2016-09-30 11:21:10', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('24', '64', '::1', '本机地址 ', '2016-09-30 11:35:15', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('25', '64', '::1', '本机地址 ', '2016-09-30 12:00:08', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('26', '64', '::1', '本机地址 ', '2016-09-30 15:07:54', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('27', '64', '::1', '本机地址 ', '2016-09-30 15:11:41', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('28', '64', '::1', '本机地址 ', '2016-09-30 15:13:28', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('29', '64', '::1', '本机地址 ', '2016-09-30 15:14:26', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('30', '64', '127.0.0.1', '本机地址 ', '2016-09-30 15:20:52', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('31', '64', '::1', '本机地址 ', '2016-09-30 15:33:12', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('32', '59', '::1', '本机地址 ', '2016-09-30 17:18:29', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('33', '59', '::1', '本机地址 ', '2016-09-30 17:47:02', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('34', '64', '127.0.0.1', '本机地址 ', '2016-09-30 18:00:30', '2016-09-30');
INSERT INTO `pf_admin_login_log` VALUES ('35', '64', '::1', '本机地址 ', '2016-10-08 09:40:11', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('36', '64', '::1', '本机地址 ', '2016-10-08 09:42:55', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('37', '64', '127.0.0.1', '本机地址 ', '2016-10-08 14:01:43', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('38', '64', '::1', '本机地址 ', '2016-10-08 14:02:15', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('39', '64', '::1', '本机地址 ', '2016-10-08 14:03:29', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('40', '64', '127.0.0.1', '本机地址 ', '2016-10-08 14:03:43', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('41', '64', '127.0.0.1', '本机地址 ', '2016-10-08 14:14:24', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('42', '59', '127.0.0.1', '本机地址 ', '2016-10-08 14:36:32', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('43', '64', '127.0.0.1', '本机地址 ', '2016-10-08 14:57:37', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('44', '64', '127.0.0.1', '本机地址 ', '2016-10-08 15:04:07', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('45', '64', '::1', '本机地址 ', '2016-10-08 15:49:25', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('46', '64', '::1', '本机地址 ', '2016-10-08 15:49:30', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('47', '64', '::1', '本机地址 ', '2016-10-08 15:49:33', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('48', '64', '::1', '本机地址 ', '2016-10-08 15:50:47', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('49', '64', '::1', '本机地址 ', '2016-10-08 15:51:02', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('50', '64', '127.0.0.1', '本机地址 ', '2016-10-08 15:51:08', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('51', '64', '::1', '本机地址 ', '2016-10-08 15:53:43', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('52', '64', '::1', '本机地址 ', '2016-10-08 15:53:53', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('53', '64', '::1', '本机地址 ', '2016-10-08 16:04:18', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('54', '64', '::1', '本机地址 ', '2016-10-08 16:48:10', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('55', '64', '::1', '本机地址 ', '2016-10-08 17:27:43', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('56', '64', '::1', '本机地址 ', '2016-10-08 17:34:36', '2016-10-08');
INSERT INTO `pf_admin_login_log` VALUES ('57', '64', '::1', '本机地址 ', '2016-10-09 09:05:49', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('58', '64', '::1', '本机地址 ', '2016-10-09 09:05:55', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('59', '64', '::1', '本机地址 ', '2016-10-09 09:06:52', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('60', '64', '::1', '本机地址 ', '2016-10-09 09:11:51', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('61', '59', '::1', '本机地址 ', '2016-10-09 09:16:55', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('62', '59', '::1', '本机地址 ', '2016-10-09 09:17:41', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('63', '59', '::1', '本机地址 ', '2016-10-09 09:20:34', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('64', '64', '::1', '本机地址 ', '2016-10-09 09:20:43', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('65', '64', '::1', '本机地址 ', '2016-10-09 09:24:55', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('66', '64', '::1', '本机地址 ', '2016-10-09 09:24:58', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('67', '64', '::1', '本机地址 ', '2016-10-09 09:25:00', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('68', '64', '::1', '本机地址 ', '2016-10-09 09:25:03', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('69', '64', '::1', '本机地址 ', '2016-10-09 11:10:55', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('70', '64', '::1', '本机地址 ', '2016-10-09 11:14:08', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('71', '64', '::1', '本机地址 ', '2016-10-09 11:56:04', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('72', '64', '::1', '本机地址 ', '2016-10-09 12:01:22', '2016-10-09');
INSERT INTO `pf_admin_login_log` VALUES ('73', '64', '::1', '本机地址 ', '2016-10-10 09:43:42', '2016-10-10');
INSERT INTO `pf_admin_login_log` VALUES ('74', '64', '::1', '本机地址 ', '2016-10-10 11:01:59', '2016-10-10');
INSERT INTO `pf_admin_login_log` VALUES ('75', '64', '::1', '本机地址 ', '2016-10-10 15:26:46', '2016-10-10');
INSERT INTO `pf_admin_login_log` VALUES ('76', '64', '127.0.0.1', '本机地址 ', '2016-10-10 15:56:57', '2016-10-10');
INSERT INTO `pf_admin_login_log` VALUES ('77', '64', '::1', '本机地址 ', '2016-10-10 16:58:51', '2016-10-10');
INSERT INTO `pf_admin_login_log` VALUES ('78', '64', '::1', '本机地址 ', '2016-10-11 09:06:43', '2016-10-11');
INSERT INTO `pf_admin_login_log` VALUES ('79', '64', '::1', '本机地址 ', '2016-10-11 09:18:16', '2016-10-11');
INSERT INTO `pf_admin_login_log` VALUES ('80', '64', '::1', '本机地址 ', '2016-10-11 09:21:34', '2016-10-11');
INSERT INTO `pf_admin_login_log` VALUES ('81', '64', '::1', '本机地址 ', '2016-10-11 11:45:51', '2016-10-11');
INSERT INTO `pf_admin_login_log` VALUES ('82', '64', '::1', '本机地址 ', '2016-10-11 14:43:41', '2016-10-11');
INSERT INTO `pf_admin_login_log` VALUES ('83', '64', '::1', '本机地址 ', '2016-10-11 15:18:46', '2016-10-11');
