/*
Navicat MySQL Data Transfer

Source Server         : ffwap
Source Server Version : 50173
Source Host           : 122.225.96.74:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2016-09-28 13:38:32
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
  `group_role` tinyint(2) NOT NULL DEFAULT '0',
  `user_role` tinyint(1) NOT NULL DEFAULT '1',
  `role_type` tinyint(2) NOT NULL DEFAULT '3',
  `qq` varchar(30) CHARACTER SET utf8 NOT NULL,
  `tel` int(25) NOT NULL DEFAULT '0' COMMENT 'telphone',
  `mobile` int(25) NOT NULL,
  `user_touch` text CHARACTER SET utf8 NOT NULL,
  `area_limits` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`user_account`),
  KEY `service` (`user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=gbk COMMENT='管理员表';

-- ----------------------------
-- Records of pf_admins
-- ----------------------------
INSERT INTO `pf_admins` VALUES ('3', 'aiyu', '778669', '易特', '易特', '195d91be1e3ba6f1c857d46f24c5a454', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '2431297189', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('42', 'zongxiaopeng', '778669', '宗先生', '宗先生', '7fce8943a3e23c0c03604c028753beab', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '712099856', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('43', 'sw-wjq', '778669', '吴佳倩', '易特', 'd06d532eafc15db34f828a262643d75f', '9', '2016-07-20 16:10:59', '0', '1', '4', '1', '319035183', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|200-0,1,2,3,4,5,6,7,8,9,10,11,12,13|201-0,1,2,3,4,5,6|202-0,1,2,3,4,5|203-0,1,2|222-0,1,2,3,4,5,6|223-0,1,2,3|224-0|300-0,1,2,3,4,5|301-0,1,2,3,4,5,6,7,8,9,10,11,12|302-0,1|303-0|304-0,1,2,3|400-0|401-0|402-0|403-0|410-0,1,2,3,4|500-0|501-0|502-0|504-0,1,2', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('45', 'yujie', '778669', '余杰', '余杰', '7a9a8bfb69d41c7d6d103184625e00f6', '0', '0000-00-00 00:00:00', '1', '1', '2', '3', '712099853', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('46', 'lvyunfeng', '778669', '吕先生', '吕先生', '6d3d86f8e6fb0694fa1835eefbb99240', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '2606421289', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('47', 'yangyongxiang', '778669', '杨先生', '杨先生', '72453960f5e4f509334beec9d58ac376', '0', '0000-00-00 00:00:00', '0', '1', '8', '3', '3217617774', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('48', 'heguiying', '778669', '何小姐', '何小姐', '13ea859db790bfddeef3440ec6c00366', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '2259760348', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('49', 'chuzhaojie', '778669', '储先生', '储先生', 'ed2b1f468c5f915f3f1cf75d7068baae', '1', '2016-07-13 16:02:48', '0', '1', '3', '3', '712099859', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|600-0,1,2,3|601-0,1,2,3,4,5|602-0|603-0,1,2', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('50', 'tosellers2008', '778669', '老板', '老板', '20eeea3a8426b5b867f621efc34fc620', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '319035177', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('51', 'caicai', '778669', '蔡小姐', '蔡小姐', 'ed2b1f468c5f915f3f1cf75d7068baae', '3', '2016-06-30 18:15:53', '0', '1', '3', '3', '319035174', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|600-0,1,2,3|601-0,1,2,3,4,5|602-0|603-0,1', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('52', 'lijingchi', '778669', '晶池', '晶池', '7a78f935fae936f34b5bf80eca7f1a58', '0', '0000-00-00 00:00:00', '0', '1', '2', '3', '712099851', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('53', 'lulingling', '778669', '玲玲', '玲玲', '00833b27989d7ec3803c7692e366b4df', '0', '0000-00-00 00:00:00', '0', '1', '2', '3', '319035189', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('54', 'zhangyun', '778669', '张赟', '张赟', '9f1cc10c28e4c342a869ccb3171add7b', '0', '0000-00-00 00:00:00', '0', '1', '2', '3', '712099852', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('55', 'liwenping', '778669', '文平', '文平', '834affc3d4f5173e986ef9689e13d1c9', '0', '0000-00-00 00:00:00', '1', '1', '2', '3', '319035191', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('56', 'panchao', '778669', '潘超', '潘超', 'bd4785555f278940ca4abdd827941c35', '11', '2016-07-14 19:14:35', '0', '1', '2', '1', '799170159', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|200-0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15|201-0,1,2,3,4,5,6|202-0,1,2,3|222-0|223-0|400-0|401-0|402-0|403-0|501-0|502-0|701-0|702-0|703-0|704-0,1,2,3,4|705-0,1,2,3,4,5,6|706-0,1,2,3,4', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('57', 'honggenmei', '778669', '阿妹', '阿妹', '560e4bcf4f14a051ebe8eee03bb0293f', '1', '2016-07-15 18:00:27', '0', '1', '2', '3', '712099849', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('58', 'libaojie', '778669', '保杰', '保杰', 'ed2b1f468c5f915f3f1cf75d7068baae', '10', '2016-07-14 10:00:14', '0', '1', '2', '3', '319035193', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|200-0,6,7,8,9,10,11,12,13,14,15|201-0,1,2,4,5,6|223-0|400-0|401-0|402-0|403-0|501-0|701-0|702-0|703-0|704-0,1,2,3,4|705-0,1,2,3,4,5,6|706-0,1,2,3,4', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('59', 'zhouhao', '778669', '周先生', '周先生', '334930f6237bf19668609cf3673fe3f5', '5', '2016-07-20 15:11:02', '0', '1', '3', '3', '2147483647', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|300-0,1,2,4|301-0,1,2,3,4,5,6,7,8,9,10,11|302-0|303-0|400-0|401-0|402-0|403-0|500-0|600-0,1,2,3,4,5,6|601-0,1', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('60', 'etecdq', '778669', '财务', '财务', '79a551f46df54c1a84e92c9b8bd3fb4e', '0', '0000-00-00 00:00:00', '0', '1', '5', '3', '3274553874', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('61', 'qsw745', '778669', 'qsw', 'qsw', '17118794eb239972455dd63f843b6f23', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '1111', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('62', 'wuxiaomei', '778669', '吴小姐', '吴小姐', '45d94e227e99a45039db1b7b6475885b', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '712099857', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('63', 'sw-suying', '778669', '易特', '易特', '6a695cd067411b88fbe7b1ce59c149a7', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '11', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('64', 'alex', '778669', '仇波', '仇波', '08ab59358efbb47868a93bd0d617ae5c', '32', '2016-07-27 09:19:13', '0', '1', '-1', '3', '514438556', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('66', 'yangxueren', '778669', '易特', '易特', '0973ac389e3980ea59a311273b33cc82', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '319035181', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('68', 'zhaoyuqi', '778669', '玉琪', '玉琪', 'f2b22976ec8586e21d86e99d443eacde', '0', '0000-00-00 00:00:00', '0', '1', '2', '3', '319035192', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('69', 'xmjj', '778669', '许明佳', '许明佳', 'c0e5379a7de4d8fce9fb7dbc18b0c8fd', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '1123213', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('70', 'xianeng', '778669', '季夏能', '季夏能', 'e5276f33264875a6c49c6c65dceca215', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '33333333', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('71', 'sw-wujing', '778669', '易特', '易特', '11853fdad15dc44959a82d218ad76dae', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '11', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('73', 'chenjian', '778669', '陈剑', '陈剑', '25f9e794323b453885f5181f1b624d0b', '0', '0000-00-00 00:00:00', '0', '1', '2', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('74', 'xubin', '778669', '徐总', 'xubin', '3206bd98b43c6afb8dd97a2a1e6b6f2b', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0|200-0,1,2,3,4,5|201-0,1,2,3,4,5,6|222-0,1,2,3,4,5,6|223-0,1,2,3|300-0,1,2,3,4,5|301-0,1,2,3,4,5,6,7,8,9,10,11|302-0,1|303-0|304-0,1,2,3|400-0|401-0|402-0|403-0|410-0,1,2,3|500-0|501-0|502-0|503-0,1,2|504-0|600-0,1,2,3,4,5,6|601-0,1|701-0|702-0|703-0|704-0,1,2,3,4|705-0,1,2,3,4,5,6|706-0,1,2,3,4|1600-0,1,2,3,4,5', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('75', 'xizhao', '778669', '夕照', '夕照', '4a888e9faffe02b9717fbdc25b47584c', '0', '0000-00-00 00:00:00', '0', '3', '2', '3', '1741882840', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('76', 'nanping', '778669', '南屏', '南屏', '1ef778d4b58c592e379dfb24aec02d46', '0', '0000-00-00 00:00:00', '0', '3', '2', '3', '1005343080', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('77', 'qingyu', '778669', '晴雨', '晴雨', 'fb00d74bd868945557bd3f6f52004242', '0', '0000-00-00 00:00:00', '0', '3', '2', '3', '2690950312', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('78', 'licrazy', '778669', '李总', '李总', 'ce9641e89304833d220ed6482d15e6a1', '0', '0000-00-00 00:00:00', '0', '2', '0', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('80', 'wanglili', '778669', '汪莉莉', '汪莉莉', '6fbb917e1873f9693bbf7595864e9c85', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '1846816527', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('81', 'huangsheng', '778669', '黄胜', '黄胜', '21e7f4ea9b773045b4a0fef86fe3b4d2', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '712099873', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('82', 'furongxia', '778669', '付荣霞', '付荣霞', 'd299534a2c503c4bcec3494846133bb6', '0', '0000-00-00 00:00:00', '0', '2', '3', '3', '2647567411', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('83', 'hufeilong', '778669', '胡飞龙', '胡飞龙', '7fce8943a3e23c0c03604c028753beab', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '712099872', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('84', 'wangshan', '778669', '王闪', '王闪', 'df5e7993c199a78e79df711fb50e1d6b', '0', '0000-00-00 00:00:00', '0', '1', '3', '3', '712099871', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('85', 'huangzhenhua', '778669', '黄振华', '黄振华', 'd925cd8e2b99dddfb8894611bcb8510c', '0', '0000-00-00 00:00:00', '0', '2', '2', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('86', 'chenshuanglin', '778669', '小林', '小林', 'a614991c3df075d58fb684e85f1c06c6', '0', '0000-00-00 00:00:00', '0', '2', '2', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('87', 'lengwei', '778669', '冷炜', '冷炜', '7918977882c90a983fef223ed1c944d6', '0', '0000-00-00 00:00:00', '0', '2', '2', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('88', 'wangtingting', '778669', '婷婷', '婷婷', 'b6d6386b72b1829d58cc650652ee4d36', '0', '0000-00-00 00:00:00', '0', '2', '2', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('89', 'zhilin', '778669', '志林', '志林', 'ed2b1f468c5f915f3f1cf75d7068baae', '15', '2016-07-15 09:42:24', '0', '1', '-1', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('90', 'sw-fbs', '778669', '冯柏松', '冯柏松', 'c49545b61103d6ecd5ea0a8f710ee3a7', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('91', 'yexueqiu', '778669', '叶学秋', '叶学秋', '78c742721e0ea947c539fa44c74f8ef3', '0', '0000-00-00 00:00:00', '0', '2', '3', '3', '2259682499', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('92', 'zhangtingting', '778669', '麦恩', '麦恩', '7b8f89294fd9622b958c53eb7658d36d', '0', '0000-00-00 00:00:00', '0', '2', '2', '3', '712099869', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('93', 'zhoucheng', '778669', '周城', '周城', 'c4af508c6ef1619e755d14fc6d29e1d4', '0', '0000-00-00 00:00:00', '0', '2', '2', '3', '712099860', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
INSERT INTO `pf_admins` VALUES ('94', 'xumingjia', '778669', '许明佳', '许明佳', 'de7322e4b1fa88209680f4522d1227eb', '0', '0000-00-00 00:00:00', '0', '1', '0', '3', '123456', '2147483647', '2147483647', '01-0|02-0|03-0|04-0', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36');
