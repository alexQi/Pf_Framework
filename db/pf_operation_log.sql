/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ffwap

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-10-13 11:55:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pf_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `pf_operation_log`;
CREATE TABLE `pf_operation_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL COMMENT '管理员类型1系统2网站主3广告主',
  `table` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT '操作类型 新增 修改 删除',
  `content` varchar(100) NOT NULL COMMENT '网站管理员',
  `admin_id` varchar(11) NOT NULL COMMENT '站点id',
  `update_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15327 DEFAULT CHARSET=utf8 COMMENT='会员操作日志';

-- ----------------------------
-- Records of pf_operation_log
-- ----------------------------
