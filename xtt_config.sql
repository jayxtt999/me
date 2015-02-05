/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myframe

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-02-05 17:48:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xtt_config
-- ----------------------------
DROP TABLE IF EXISTS `xtt_config`;
CREATE TABLE `xtt_config` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext NOT NULL,
  PRIMARY KEY (`option_id`),
  KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_config
-- ----------------------------
INSERT INTO `xtt_config` VALUES ('1', 'blogname', 'Naix_TAo');
INSERT INTO `xtt_config` VALUES ('2', 'bloginfo', '谢滔滔 博客 435024179');
INSERT INTO `xtt_config` VALUES ('3', 'site_title', 'Hello Mr. Memory ');
INSERT INTO `xtt_config` VALUES ('4', 'site_description', '谢滔滔_、博客_、435024179');
INSERT INTO `xtt_config` VALUES ('5', 'site_key', '谢滔滔_、博客_、435024179');
INSERT INTO `xtt_config` VALUES ('6', 'blogurl', 'http://www.xtt.me/');
INSERT INTO `xtt_config` VALUES ('7', 'icp', '');
INSERT INTO `xtt_config` VALUES ('8', 'footer_info', '<a href=\"http://user.qzone.qq.com/435024179/infocenter \"target=\"_blank\" >访问我的QQ空间</a>\r\n<script type=\"text/javascript\" src=\"http://tajs.qq.com/stats?sId=16270255\" charset=\"UTF-8\"></script>\r\n');
INSERT INTO `xtt_config` VALUES ('9', 'show_log\n_num', '10');
INSERT INTO `xtt_config` VALUES ('10', 'timezone', '1');
INSERT INTO `xtt_config` VALUES ('13', 'istwitter', '1');
INSERT INTO `xtt_config` VALUES ('14', 'istreply', '1');
INSERT INTO `xtt_config` VALUES ('16', 'iscomment', '1');
INSERT INTO `xtt_config` VALUES ('17', 'ischkcomment', '1');
INSERT INTO `xtt_config` VALUES ('18', 'comment_code', '1');
INSERT INTO `xtt_config` VALUES ('19', 'isgravatar', '0');
INSERT INTO `xtt_config` VALUES ('20', 'comment_needchinese', '0');
INSERT INTO `xtt_config` VALUES ('21', 'index_twnum', '10');
INSERT INTO `xtt_config` VALUES ('22', 'comment_interval', '15');
INSERT INTO `xtt_config` VALUES ('23', 'comment_paging', '1');
INSERT INTO `xtt_config` VALUES ('24', 'comment_pnum', '8');
INSERT INTO `xtt_config` VALUES ('26', 'timezone', '8');
INSERT INTO `xtt_config` VALUES ('25', 'index_lognum', '10');
INSERT INTO `xtt_config` VALUES ('27', 'login_code', '1');
