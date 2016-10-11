/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ffwap

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-10-11 18:09:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pf_admins
-- ----------------------------
DROP TABLE IF EXISTS `pf_admins`;
CREATE TABLE `pf_admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account` varchar(50) CHARACTER SET utf8 NOT NULL,
  `token` varchar(11) CHARACTER SET utf8 NOT NULL DEFAULT '514438556',
  `true_name` varchar(120) CHARACTER SET utf8 NOT NULL,
  `nick_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL,
  `is_closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_role` tinyint(2) NOT NULL DEFAULT '0' COMMENT '子公司',
  `user_role` tinyint(1) NOT NULL DEFAULT '1' COMMENT '部门 (市场 研发 人事)',
  `role_type` tinyint(2) NOT NULL DEFAULT '3' COMMENT '角色  （总经理，经理，员工）',
  `qq` varchar(30) CHARACTER SET utf8 NOT NULL,
  `tel` int(25) NOT NULL DEFAULT '0' COMMENT 'telphone',
  `mobile` int(25) NOT NULL,
  `user_touch` text CHARACTER SET utf8 NOT NULL,
  `area_limits` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`user_account`),
  KEY `service` (`user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=gbk COMMENT='管理员表';

-- ----------------------------
-- Records of pf_admins
-- ----------------------------
INSERT INTO `pf_admins` VALUES ('58', 'libaojie', '778669', '李保杰', '保杰', '08ab59358efbb47868a93bd0d617ae5c', '0', '2016-07-01 10:00:14', '0', '1', '2', '3', '319035193', '2147483647', '2147483647', '11-0|12-0|101-0,1,2,3,4,5|102-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('59', 'zhouhao', '778669', '周浩', '浩浩', '08ab59358efbb47868a93bd0d617ae5c', '0', '2016-10-09 09:20:34', '0', '1', '3', '3', '2147483647', '2147483647', '2147483647', '11-0|12-0|101-0,1,2,3,4,5|102-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('64', 'alex', '778669', '仇波', 'alex', '08ab59358efbb47868a93bd0d617ae5c', '5', '2016-10-11 15:18:46', '0', '1', '2', '3', '514438556', '2147483647', '2147483647', '11-0|12-0|101-0,1,2,3,4,5|102-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
