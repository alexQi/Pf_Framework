/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ffwap

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-10-13 16:16:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pf_admins
-- ----------------------------
DROP TABLE IF EXISTS `pf_admins`;
CREATE TABLE `pf_admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL DEFAULT '',
  `nick_name` varchar(50) NOT NULL,
  `true_name` varchar(120) NOT NULL,
  `user_role` tinyint(1) NOT NULL DEFAULT '1' COMMENT '部门 (市场 研发 人事)',
  `role_type` int(4) NOT NULL DEFAULT '3' COMMENT '角色  （总经理，经理，员工）',
  `group_role` tinyint(2) NOT NULL DEFAULT '0' COMMENT '子公司',
  `is_closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `area_limits` text NOT NULL,
  `user_touch` text NOT NULL,
  `qq` varchar(30) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `token` varchar(11) NOT NULL DEFAULT '514438556',
  `last_time` datetime NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`user_account`),
  KEY `service` (`user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

-- ----------------------------
-- Records of pf_admins
-- ----------------------------
INSERT INTO `pf_admins` VALUES ('1', 'alex', '08ab59358efbb47868a93bd0d617ae5c', 'alex', '仇波', '-1', '1000', '1', '0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36', '11-0|12-0|101-0,1,2,3,4,5|102-0', '514438556', '18368182313', '1', '514438556', '2016-10-13 16:07:39');
INSERT INTO `pf_admins` VALUES ('2', 'libaojie', '08ab59358efbb47868a93bd0d617ae5c', '保杰', '李保杰', '2', '3', '1', '0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36', '11-0|12-0|101-0,1,2,3,4,5|102-0', '319035193', '18368180040', '0', '514438556', '2016-10-12 10:39:38');
INSERT INTO `pf_admins` VALUES ('3', 'zhouhao', '08ab59358efbb47868a93bd0d617ae5c', '浩浩', '周浩', '3', '3', '1', '0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36', '11-0|12-0|101-0,1,2,3,4,5|102-0', '2147483647', '18368180113', '0', '514438556', '2016-10-09 09:20:34');
