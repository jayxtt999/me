/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myframe

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-02-10 17:45:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xtt_common_menu
-- ----------------------------
DROP TABLE IF EXISTS `xtt_common_menu`;
CREATE TABLE `xtt_common_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT '菜单名字',
  `desc` varchar(45) DEFAULT NULL COMMENT '菜单描述',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `module_name` varchar(45) DEFAULT NULL COMMENT '模块名',
  `controller_name` varchar(45) DEFAULT NULL COMMENT '控制器名',
  `action_name` varchar(45) DEFAULT NULL COMMENT '动作名',
  `url` varchar(255) DEFAULT NULL COMMENT '指定url, 在路由做了url处理的话需要设置该字段',
  `sort` tinyint(4) DEFAULT '0' COMMENT '栏目排序',
  `is_display` tinyint(1) DEFAULT NULL COMMENT '菜单栏目是否显示',
  `icon` varchar(45) DEFAULT NULL COMMENT 'icon标签class',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0' COMMENT '权限控制',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=utf8 COMMENT='栏目菜单';

-- ----------------------------
-- Records of xtt_common_menu
-- ----------------------------
INSERT INTO `xtt_common_menu` VALUES ('38', '主栏目', '122', '2014-04-21 17:55:58', 'admin', 'index', 'index', 'http://www.me.me/index.php?m=admin&c=index&a=index', '1', '1', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('39', '栏目列表', '阿达说的', '2014-04-21 18:25:09', 'admin', 'menu', 'index', 'www.baidu.com', '10', '1', '100', '38', '0');
INSERT INTO `xtt_common_menu` VALUES ('56', '配置列表', '', '2014-06-03 16:50:19', 'admin', 'config', 'index', '/admin/common_config/index', '0', '1', '', '38', '0');
INSERT INTO `xtt_common_menu` VALUES ('210', '栏目列表添加', '', '2014-09-28 11:43:54', 'admin', 'common_menu', 'add', '', '0', '0', '', '38', '0');
INSERT INTO `xtt_common_menu` VALUES ('211', '栏目列表编辑', '', '2014-09-28 11:44:22', 'admin', 'menu', 'edit', '', '0', '0', '', '38', '0');
INSERT INTO `xtt_common_menu` VALUES ('212', '栏目列表删除', '', '2014-09-28 11:44:40', 'admin', 'common_menu', 'del', '', '0', '0', '', '38', '0');

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
INSERT INTO `xtt_config` VALUES ('6', 'blogurl', 'http://www.me.me');
INSERT INTO `xtt_config` VALUES ('7', 'icp', '');
INSERT INTO `xtt_config` VALUES ('8', 'footer_info', '2014 &copy; Metronic by keenthemes.<a href=\"http://user.qzone.qq.com/435024179/infocenter \"target=\"_blank\" >访问我的QQ空间</a>\r\n<script type=\"text/javascript\" src=\"http://tajs.qq.com/stats?sId=16270255\" charset=\"UTF-8\"></script>\r\n');
INSERT INTO `xtt_config` VALUES ('9', 'show_log_num', '10');
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
