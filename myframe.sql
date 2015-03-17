/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myframe

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-03-17 17:45:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xtt_article
-- ----------------------------
DROP TABLE IF EXISTS `xtt_article`;
CREATE TABLE `xtt_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `excerpt` longtext COMMENT '摘要',
  `thumbnail` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `member_id` int(10) NOT NULL COMMENT '作者',
  `category` int(10) NOT NULL COMMENT '分类',
  `comment_num` tinyint(10) DEFAULT '0' COMMENT '评论数量',
  `view_num` tinyint(10) DEFAULT '0' COMMENT '查看数量',
  `istop` tinyint(1) DEFAULT '0' COMMENT '置顶',
  `allow_comment` tinyint(4) DEFAULT '0' COMMENT '允许评论',
  `status` tinyint(1) DEFAULT '1',
  `password` varchar(32) DEFAULT NULL COMMENT '日志密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_article
-- ----------------------------
INSERT INTO `xtt_article` VALUES ('1', '测试0000', '<p>测试1111</p>', '<p>测试222</p>', 'http://www.me.me/Data/upload/image/article/1/yt_3165799a056f7b453ed86904513ca977.jpg', '2015-03-16 17:29:18', '1', '1', '100', '100', '1', '1', '1', '123');
INSERT INTO `xtt_article` VALUES ('2', null, null, null, null, null, '0', '0', '0', '0', '0', '0', '1', null);

-- ----------------------------
-- Table structure for xtt_article_category
-- ----------------------------
DROP TABLE IF EXISTS `xtt_article_category`;
CREATE TABLE `xtt_article_category` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '分类名',
  `alias` varchar(255) DEFAULT NULL COMMENT '别名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_article_category
-- ----------------------------
INSERT INTO `xtt_article_category` VALUES ('1', '测试111', 'cs1');
INSERT INTO `xtt_article_category` VALUES ('2', '测试222', 'cs2');
INSERT INTO `xtt_article_category` VALUES ('3', '测试333', 'cs3');

-- ----------------------------
-- Table structure for xtt_article_tag
-- ----------------------------
DROP TABLE IF EXISTS `xtt_article_tag`;
CREATE TABLE `xtt_article_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagname` varchar(256) DEFAULT NULL COMMENT '标签名',
  `gid` varchar(256) DEFAULT NULL COMMENT '日志id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_article_tag
-- ----------------------------
INSERT INTO `xtt_article_tag` VALUES ('11', '啊大大的', '1,1,1,1,1');
INSERT INTO `xtt_article_tag` VALUES ('12', '1231212', '1,1,1,1');
INSERT INTO `xtt_article_tag` VALUES ('13', '12121212', '1,1,1,1');

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
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8 COMMENT='栏目菜单';

-- ----------------------------
-- Records of xtt_common_menu
-- ----------------------------
INSERT INTO `xtt_common_menu` VALUES ('1', '主栏目', '122', '2014-04-21 17:55:58', 'admin', 'index', 'index', 'http://www.me.me/index.php?m=admin&c=index&a=index', '1', '1', '1', '0', '1');
INSERT INTO `xtt_common_menu` VALUES ('2', '栏目列表', '阿达说的', '2014-04-21 18:25:09', 'admin', 'menu', 'index', 'www.baidu.com', '10', '1', '100', '1', '1');
INSERT INTO `xtt_common_menu` VALUES ('3', '配置列表', '', '2014-06-03 16:50:19', 'admin', 'config', 'index', '/admin/common_config/index', '0', '1', '', '1', '1');
INSERT INTO `xtt_common_menu` VALUES ('4', '会员登陆', '会员登陆', '2015-02-11 09:59:27', 'member', 'login', 'index', 'www.baidu.com', '1', '0', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('5', '会员列表', '会员管理', '2015-02-11 10:30:08', 'admin', 'member', 'list', null, '0', '1', '1', '1', '1');
INSERT INTO `xtt_common_menu` VALUES ('210', '栏目列表添加', '', '2014-09-28 11:43:54', 'admin', 'common_menu', 'add', '', '0', '0', '', '1', '1');
INSERT INTO `xtt_common_menu` VALUES ('211', '栏目列表编辑', '', '2014-09-28 11:44:22', 'admin', 'menu', 'edit', '', '0', '0', '', '1', '1');
INSERT INTO `xtt_common_menu` VALUES ('212', '栏目列表删除', '', '2014-09-28 11:44:40', 'admin', 'common_menu', 'del', '', '0', '0', '', '1', '1');
INSERT INTO `xtt_common_menu` VALUES ('213', '日志管理', '日志管理', '2015-02-28 10:47:15', 'admin', 'article', 'list', '', '1', '1', '', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('214', '添加日志', '添加日志', '2015-02-28 16:06:42', 'admin', 'article', 'add', '', '1', '0', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('215', '编辑日志', '编辑日志', '2015-02-28 16:07:12', 'admin', 'article', 'edit', '', '1', '0', '', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('216', 'Blog', '博文', null, 'home', 'blog', 'index', '', '1', '1', '', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('217', '主页', '主页', '0000-00-00 00:00:00', 'home', 'index', 'index', '', '1', '1', '', '1', '0');

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
INSERT INTO `xtt_config` VALUES ('8', 'footer_info', '2014 © Metronic by keenthemes.<a href=\\\"http://user.qzone.qq.com/435024179/infocenter\\\"target=\\\"_blank\\\" >访问我的QQ空间</a>\r\n<script type=\\\"text/javascript\\\" src=\\\"http://tajs.qq.com/stats?sId=16270255\\\" charset=\\\"UTF-8\\\"></script>\r\n');
INSERT INTO `xtt_config` VALUES ('9', 'show_log_num', '10');
INSERT INTO `xtt_config` VALUES ('10', 'timezone', '8');
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

-- ----------------------------
-- Table structure for xtt_member_info
-- ----------------------------
DROP TABLE IF EXISTS `xtt_member_info`;
CREATE TABLE `xtt_member_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(45) DEFAULT NULL COMMENT '用户名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `profession` varchar(255) DEFAULT NULL COMMENT '职业',
  `favorite` varchar(255) DEFAULT NULL COMMENT '兴趣爱好',
  `sex` enum('男','女','其它') DEFAULT NULL COMMENT '性别',
  `userinfo` text COMMENT '用户说明',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `role` tinyint(255) NOT NULL DEFAULT '2' COMMENT '用户组（1 管理员 2 普通 ）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_member_info
-- ----------------------------
INSERT INTO `xtt_member_info` VALUES ('1', 'admin', '8225e882a7d7a83c036e4784bc707267', '435024179@qq.com', 'http://www.me.me/Data/upload/image/avatar/1/yt_2f90e65580f021c16c1c17f106402f45.jpg', '2015-03-16 11:40:39', '1', '职业', '兴趣爱好', '男', '用户说明', '昵称', '1');

-- ----------------------------
-- Table structure for xtt_member_login_log
-- ----------------------------
DROP TABLE IF EXISTS `xtt_member_login_log`;
CREATE TABLE `xtt_member_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` int(10) unsigned DEFAULT NULL COMMENT 'login ip',
  `create_time` timestamp NULL DEFAULT NULL COMMENT 'login time',
  `member_id` int(10) unsigned DEFAULT NULL COMMENT 'login member',
  PRIMARY KEY (`id`),
  KEY `member_fk_idx` (`member_id`),
  CONSTRAINT `member_fk` FOREIGN KEY (`member_id`) REFERENCES `xtt_member_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_member_login_log
-- ----------------------------
INSERT INTO `xtt_member_login_log` VALUES ('1', '1270', '2015-02-12 15:20:13', '1');
INSERT INTO `xtt_member_login_log` VALUES ('2', '1270', '2015-02-13 09:45:29', '1');
INSERT INTO `xtt_member_login_log` VALUES ('3', '1270', '2015-02-28 08:55:05', '1');
INSERT INTO `xtt_member_login_log` VALUES ('4', '1270', '2015-03-01 09:22:28', '1');
INSERT INTO `xtt_member_login_log` VALUES ('5', '1270', '2015-03-01 10:13:39', '1');
INSERT INTO `xtt_member_login_log` VALUES ('6', '1270', '2015-03-02 09:14:17', '1');
INSERT INTO `xtt_member_login_log` VALUES ('7', '1270', '2015-03-02 11:58:27', '1');
INSERT INTO `xtt_member_login_log` VALUES ('8', '1270', '2015-03-03 14:33:23', '1');
INSERT INTO `xtt_member_login_log` VALUES ('9', '1270', '2015-03-04 17:00:06', '1');
INSERT INTO `xtt_member_login_log` VALUES ('10', '1270', '2015-03-04 17:50:00', '1');
INSERT INTO `xtt_member_login_log` VALUES ('11', '1270', '2015-03-05 09:32:31', '1');
INSERT INTO `xtt_member_login_log` VALUES ('12', '1270', '2015-03-05 14:10:42', '1');
INSERT INTO `xtt_member_login_log` VALUES ('13', '1270', '2015-03-05 14:15:47', '1');
INSERT INTO `xtt_member_login_log` VALUES ('14', '1270', '2015-03-05 14:31:13', '1');
INSERT INTO `xtt_member_login_log` VALUES ('15', '1270', '2015-03-06 08:53:34', '1');
INSERT INTO `xtt_member_login_log` VALUES ('16', '1270', '2015-03-06 09:45:49', '1');
INSERT INTO `xtt_member_login_log` VALUES ('17', '1270', '2015-03-06 09:50:29', '1');
INSERT INTO `xtt_member_login_log` VALUES ('18', '1270', '2015-03-06 13:08:42', '1');
INSERT INTO `xtt_member_login_log` VALUES ('19', '1270', '2015-03-06 13:11:03', '1');
INSERT INTO `xtt_member_login_log` VALUES ('20', '1270', '2015-03-10 09:41:33', '1');
INSERT INTO `xtt_member_login_log` VALUES ('21', '1270', '2015-03-10 09:41:46', '1');
INSERT INTO `xtt_member_login_log` VALUES ('22', '1270', '2015-03-10 10:26:09', '1');
INSERT INTO `xtt_member_login_log` VALUES ('23', '1270', '2015-03-11 09:24:47', '1');
INSERT INTO `xtt_member_login_log` VALUES ('24', '1270', '2015-03-11 09:33:45', '1');
INSERT INTO `xtt_member_login_log` VALUES ('25', '1270', '2015-03-12 10:00:45', '1');
INSERT INTO `xtt_member_login_log` VALUES ('26', '1270', '2015-03-12 10:22:56', '1');
INSERT INTO `xtt_member_login_log` VALUES ('27', '1270', '2015-03-13 10:44:50', '1');
INSERT INTO `xtt_member_login_log` VALUES ('28', '1270', '2015-03-16 10:41:22', '1');
INSERT INTO `xtt_member_login_log` VALUES ('29', '1270', '2015-03-16 10:43:48', '1');
INSERT INTO `xtt_member_login_log` VALUES ('30', '1270', '2015-03-16 11:03:02', '1');
INSERT INTO `xtt_member_login_log` VALUES ('31', '1270', '2015-03-17 09:07:31', '1');
