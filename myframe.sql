/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : myframe

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-08-03 22:28:58
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_article
-- ----------------------------
INSERT INTO `xtt_article` VALUES ('1', '测试0000', '<p>阿SA说adasdadadadasdasd</p>', '', 'http://www.me.me/Data/upload/image/20150721/1437469612.jpg', '2015-07-21 17:06:52', '1', '1', '100', '100', '1', '1', '1', '123456');

-- ----------------------------
-- Table structure for xtt_article_category
-- ----------------------------
DROP TABLE IF EXISTS `xtt_article_category`;
CREATE TABLE `xtt_article_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '分类名',
  `alias` varchar(255) DEFAULT NULL COMMENT '别名',
  `sort` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_article_category
-- ----------------------------
INSERT INTO `xtt_article_category` VALUES ('1', '测试11100000啊00221问问啊啊122', 'cs1', '11');
INSERT INTO `xtt_article_category` VALUES ('2', '测试2222222去223232啊223', 'cs2', '0');
INSERT INTO `xtt_article_category` VALUES ('3', '222测试333222223435412121', 'cs34', '12');
INSERT INTO `xtt_article_category` VALUES ('9', '2222', '222222', '22');
INSERT INTO `xtt_article_category` VALUES ('10', '2222', '222222', '22');
INSERT INTO `xtt_article_category` VALUES ('11', '4324', '42342', '232');

-- ----------------------------
-- Table structure for xtt_article_tag
-- ----------------------------
DROP TABLE IF EXISTS `xtt_article_tag`;
CREATE TABLE `xtt_article_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagname` varchar(256) DEFAULT NULL COMMENT '标签名',
  `gid` varchar(256) DEFAULT NULL COMMENT '日志id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_article_tag
-- ----------------------------
INSERT INTO `xtt_article_tag` VALUES ('11', '啊大大的', '1,1,1,1,1,1,1,1,1');
INSERT INTO `xtt_article_tag` VALUES ('12', '1231212', '1,1,1,1,1,1,1,1');
INSERT INTO `xtt_article_tag` VALUES ('13', '12121212', '1,1,1,1,1,1,1,1');
INSERT INTO `xtt_article_tag` VALUES ('14', '啊啊啊', null);

-- ----------------------------
-- Table structure for xtt_calendar
-- ----------------------------
DROP TABLE IF EXISTS `xtt_calendar`;
CREATE TABLE `xtt_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) DEFAULT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(20) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_calendar
-- ----------------------------
INSERT INTO `xtt_calendar` VALUES ('6', '111111111111112222222', '1435766400', '1435766400', '1', '#360', '1');
INSERT INTO `xtt_calendar` VALUES ('7', '222222222222222', '1436976000', '1437321600', '1', '#06c', '1');
INSERT INTO `xtt_calendar` VALUES ('10', '1111111111111', '1437667200', '-28800', '1', '#f30', '1');

-- ----------------------------
-- Table structure for xtt_comment
-- ----------------------------
DROP TABLE IF EXISTS `xtt_comment`;
CREATE TABLE `xtt_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `qq` varchar(256) NOT NULL,
  `crate_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL COMMENT '内容',
  `type` tinyint(1) NOT NULL COMMENT '文章评论/说说评论等',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `data` int(10) NOT NULL COMMENT '对应说说 /博文id',
  `ref_id` int(10) NOT NULL DEFAULT '0' COMMENT '引用id',
  `member_id` int(10) DEFAULT NULL COMMENT '用户（可为空）',
  `up` int(10) DEFAULT '0' COMMENT '顶',
  `ip` varchar(256) NOT NULL COMMENT 'ip',
  `down` int(10) DEFAULT '0' COMMENT '踩',
  `open` text COMMENT '为第三方评论（如友言）数据预留',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_comment
-- ----------------------------
INSERT INTO `xtt_comment` VALUES ('1', '张三', '154894476', '2015-03-30 22:22:28', '测试', '1', '1', '1', '0', null, '2', '', '1', null);
INSERT INTO `xtt_comment` VALUES ('2', '李四', '154894476', '2015-03-27 11:42:08', '测试2', '1', '1', '1', '0', null, '7', '', '2', null);
INSERT INTO `xtt_comment` VALUES ('3', '王五', '154894476', '2015-03-27 11:42:13', '测试3', '1', '1', '1', '1', null, '1', '', '1', '');
INSERT INTO `xtt_comment` VALUES ('4', '赵六', '154894476', '2015-03-27 11:42:09', '测试4', '1', '1', '1', '2', null, '3', '', '1', null);
INSERT INTO `xtt_comment` VALUES ('5', '111111', '111111', '2015-03-27 14:04:10', '11111', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('6', '陈楠', '899565484', '2015-03-27 14:07:37', '测试啊啊啊', '1', '1', '1', '0', null, '1', '', '2', null);
INSERT INTO `xtt_comment` VALUES ('7', '12121212', '2147483647', '2015-03-27 14:12:00', '啊大大的', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('8', '啊啊啊', '2147483647', '2015-03-27 14:23:01', '阿达大大', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('9', '陈楠22', '545544445', '2015-03-27 14:30:15', '你叫陈楠', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('10', '陈楠22', '545544445', '2015-03-27 14:30:18', '你叫陈楠', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('11', '陈楠22', '545544445', '2015-03-27 14:30:25', '你叫陈楠', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('12', '12121', '584545125', '2015-03-27 14:43:30', '啊大大的', '1', '1', '1', '10', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('13', '傻逼', '956595412', '2015-03-27 14:46:52', '阿达达傻逼', '1', '1', '1', '12', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('14', 'asdadad', '2147483647', '2015-03-27 15:48:58', '啊大大的', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('15', '呵呵', '2147483647', '2015-03-27 15:49:18', '爱的发啊发', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('16', '啊啊啊啊', '2147483647', '2015-03-27 15:51:14', '啊事实上事实上身上试试是谁是谁', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('17', '阿SA说', '2147483647', '2015-03-27 15:54:33', '啊啊啊啊啊啊啊啊啊', '1', '1', '1', '0', null, '2', '', '2', null);
INSERT INTO `xtt_comment` VALUES ('18', '啊啊啊啊啊', '2147483647', '2015-03-27 16:07:17', '2147483647', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('19', '啊啊啊啊啊啊啊', '1121212121', '2015-03-27 16:28:54', '11111111', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('20', '啊啊啊啊啊啊啊啊啊', '2147483647', '2015-03-27 16:29:55', '14141414', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('21', '哈哈哈', '2147483647', '2015-03-27 16:35:49', '阿萨发发', '1', '1', '1', '20', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('22', '啊啊啊啊啊', '121211452', '2015-03-27 16:36:11', '阿萨发发', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('23', '啊啊发发', '1412412414', '2015-03-27 16:38:21', '141412412', '1', '1', '1', '21', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('24', '啊啊发发', '1412412414', '2015-03-27 16:38:42', '141412412', '1', '1', '1', '21', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('25', '啊啊飒飒是', '45455', '2015-03-27 17:08:29', '121212', '1', '1', '1', '21', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('26', '啊飒飒是', '121212', '2015-03-27 17:10:43', '12a121af2af', '1', '1', '1', '22', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('27', '啊飒飒是', '2147483647', '2015-03-27 17:17:46', '阿萨发发', '1', '1', '1', '22', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('28', '啊啊大大', '1245666221', '2015-03-27 17:29:13', '阿萨发发舒服', '1', '1', '1', '26', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('29', '啊啊啊啊', '5454545', '2015-03-27 17:44:51', '1212122', '1', '1', '1', '27', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('30', '阿达打法', '566121212', '2015-03-27 17:45:09', '1按时发发发', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('31', 'comment_needchinese', '12424243', '2015-03-29 20:35:56', 'comment_needchinese', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('32', '啊盛大速度', '123124124', '2015-03-29 20:39:34', '2147483647', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('33', '23423423', '423423423', '2015-03-29 20:41:30', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('34', '', '', '2015-03-29 20:42:31', '', '1', '1', '0', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('35', '23423423', '423423423', '2015-03-29 20:42:35', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('36', '23423423', '423423423', '2015-03-29 20:42:41', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('37', '23423423', '423423423', '2015-03-29 20:42:50', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('38', '23423423', '423423423', '2015-03-29 20:43:33', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('39', '23423423', '423423423', '2015-03-29 20:45:30', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('40', '23423423', '423423423', '2015-03-29 20:45:50', '4234234', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('41', '啊盛大速度', '2147483647', '2015-03-29 20:47:01', '2147483647', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('42', '啊盛大速度', '123123412', '2015-03-29 20:48:22', '412412', '1', '1', '1', '0', null, '0', '', '0', null);
INSERT INTO `xtt_comment` VALUES ('43', '啊啊', '1341414', '2015-03-30 14:04:48', '阿达说的', '1', '1', '1', '0', null, '0', '127.0.0.1', '0', null);
INSERT INTO `xtt_comment` VALUES ('44', '阿达说的', '2131321', '2015-03-30 14:04:56', '34141确实是', '1', '1', '1', '0', null, '0', '127.0.0.1', '0', null);
INSERT INTO `xtt_comment` VALUES ('45', '2131313', '1231312', '2015-03-30 14:06:39', '啊事实上事实上身上', '1', '1', '1', '0', null, '0', '127.0.0.1', '0', null);
INSERT INTO `xtt_comment` VALUES ('46', '1313131312', '131313', '2015-03-30 22:35:44', '啊事实上事实上身上', '2', '1', '36', '0', null, '0', '127.0.0.1', '0', null);

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
  `is_nav` tinyint(1) DEFAULT '0' COMMENT '是否为导航',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8 COMMENT='栏目菜单';

-- ----------------------------
-- Records of xtt_common_menu
-- ----------------------------
INSERT INTO `xtt_common_menu` VALUES ('1', '主栏目', '122', '2014-04-21 17:55:58', 'admin', 'index', 'index', 'http://www.me.me/index.php?m=admin&c=index&a=index', '1', '1', '1', '0', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('2', '栏目列表', '阿达说的', '2014-04-21 18:25:09', 'admin', 'menu', 'index', 'www.baidu.com', '10', '1', 'icon-list', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('3', '配置列表', '配置列表', '2014-06-03 16:50:19', 'admin', 'config', 'index', '/admin/common_config/index', '1', '1', 'icon-speedometer', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('4', '会员登陆', '会员登陆', '2015-02-11 09:59:27', 'member', 'login', 'index', 'www.baidu.com', '1', '0', '1', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('200', '主页', '主页', '2015-03-18 16:42:17', 'home', 'index', 'index', '', '2', '1', '', '1', '0', '1');
INSERT INTO `xtt_common_menu` VALUES ('210', '栏目列表添加', '', '2014-09-28 11:43:54', 'admin', 'common_menu', 'add', '', '0', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('211', '栏目列表编辑', '', '2014-09-28 11:44:22', 'admin', 'menu', 'edit', '', '0', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('212', '栏目列表删除', '', '2014-09-28 11:44:40', 'admin', 'common_menu', 'del', '', '0', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('213', '日志管理', '日志管理', '2015-02-28 10:47:15', 'admin', 'article', 'list', '', '1', '1', 'icon-note', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('214', '添加日志', '添加日志', '2015-02-28 16:06:42', 'admin', 'article', 'add', '', '1', '0', '1', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('215', '编辑日志', '编辑日志', '2015-02-28 16:07:12', 'admin', 'article', 'edit', '', '1', '0', '', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('216', 'Blog', '博文', '2015-03-18 16:42:17', 'home', 'blog', 'index', '', '1', '1', '', '1', '0', '1');
INSERT INTO `xtt_common_menu` VALUES ('217', '说说管理', '说说管理', null, 'admin', 'twitter', 'index', '', '1', '1', 'icon-pencil', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('218', '博文详情', '博文详情', null, 'home', 'blog', 'show', '', '1', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('219', 'Twitter', '说说', null, 'home', 'twitter', 'index', '', '1', '1', '', '1', '0', '1');
INSERT INTO `xtt_common_menu` VALUES ('220', '分类管理', 'category', null, 'admin', 'category', 'index', '', '1', '1', 'icon-grid', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('221', '标签管理', '文章标签管理', null, 'admin', 'tags', 'index', '', '1', '1', 'icon-pin', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('222', '侧边栏管理', '侧边栏管理', null, 'admin', 'sidebar', 'index', '', '1', '1', 'icon-paper-plane', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('223', '链接管理', '链接管理', null, 'admin', 'link', 'index', '', '1', '1', 'icon-link', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('224', '插件管理', '插件管理', null, 'admin', 'plug', 'index', '', '1', '1', 'icon-puzzle', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('225', '插件配置', '插件配置', '2015-05-11 14:39:17', 'admin', 'plug', 'setting', '', '1', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('226', '个人资料', '个人资料', null, 'admin', 'user', 'profile', '', '1', '1', 'icon-user', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('227', '钩子管理', '钩子管理', null, 'admin', 'hook', 'index', '', '1', '1', 'icon-anchor', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('228', '编辑钩子', '编辑钩子', null, 'admin', 'hook', 'edit', '', '1', '0', '', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('229', '模板管理', '模板管理', null, 'admin', 'template', 'index', 'www.me.me/index.php?m=admin&c=template&a=index', '1', '1', 'icon-magic-wand', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('230', 'calendar', 'calendar', null, 'admin', 'calendar', 'index', 'http://www.me.me/index.php?m=admin&c=calendar&a=index', '1', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('231', '用户管理', '用户管理', null, 'admin', 'member', 'index', 'http://www.me.me/index.php?m=admin&c=member&a=index', '1', '1', 'icon-users', '1', '1', '0');

-- ----------------------------
-- Table structure for xtt_config
-- ----------------------------
DROP TABLE IF EXISTS `xtt_config`;
CREATE TABLE `xtt_config` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` text,
  PRIMARY KEY (`option_id`),
  KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_config
-- ----------------------------
INSERT INTO `xtt_config` VALUES ('1', 'blogname', 'Naix_TAo');
INSERT INTO `xtt_config` VALUES ('2', 'bloginfo', '谢滔滔 博客 435024179');
INSERT INTO `xtt_config` VALUES ('3', 'site_title', 'Hello Mr. Memory ');
INSERT INTO `xtt_config` VALUES ('4', 'site_description', '谢滔滔_、博客_、435024179');
INSERT INTO `xtt_config` VALUES ('5', 'site_key', '谢滔滔_、博客_、435024179');
INSERT INTO `xtt_config` VALUES ('6', 'blogurl', 'http://www.me.me');
INSERT INTO `xtt_config` VALUES ('7', 'icp', '123456');
INSERT INTO `xtt_config` VALUES ('8', 'footer_info', '2014 © Metronic by keenthemes.<a href=\\\"http://user.qzone.qq.com/435024179/infocenter\\\"target=\\\"_blank\\\" >访问我的QQ空间</a>');
INSERT INTO `xtt_config` VALUES ('9', 'show_log_num', '10');
INSERT INTO `xtt_config` VALUES ('10', 'timezone', '8');
INSERT INTO `xtt_config` VALUES ('13', 'istwitter', '1');
INSERT INTO `xtt_config` VALUES ('14', 'istreply', '1');
INSERT INTO `xtt_config` VALUES ('16', 'iscomment', '1');
INSERT INTO `xtt_config` VALUES ('17', 'ischkcomment', '1');
INSERT INTO `xtt_config` VALUES ('18', 'comment_code', '0');
INSERT INTO `xtt_config` VALUES ('19', 'isgravatar', '0');
INSERT INTO `xtt_config` VALUES ('20', 'comment_needchinese', '1');
INSERT INTO `xtt_config` VALUES ('21', 'index_twnum', '10');
INSERT INTO `xtt_config` VALUES ('22', 'comment_interval', '15');
INSERT INTO `xtt_config` VALUES ('23', 'comment_paging', '1');
INSERT INTO `xtt_config` VALUES ('24', 'comment_pnum', '8');
INSERT INTO `xtt_config` VALUES ('26', 'timezone', '8');
INSERT INTO `xtt_config` VALUES ('25', 'index_lognum', '10');
INSERT INTO `xtt_config` VALUES ('27', 'login_code', '1');
INSERT INTO `xtt_config` VALUES ('30', 'comment_order', 'asc');

-- ----------------------------
-- Table structure for xtt_hook
-- ----------------------------
DROP TABLE IF EXISTS `xtt_hook`;
CREATE TABLE `xtt_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text COMMENT '描述',
  `type` enum('type','controller') NOT NULL DEFAULT 'controller' COMMENT '类型 1可diy挂载点 2 系统挂载点',
  `crate_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `plugs` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of xtt_hook
-- ----------------------------
INSERT INTO `xtt_hook` VALUES ('1', 'tempHead', '页面头部拓展', 'controller', '2015-06-26 11:06:47', 'headtest', '1');
INSERT INTO `xtt_hook` VALUES ('2', 'tempFoot', '页面尾部拓展', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('3', 'addLog', '添加博文拓展', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('4', 'saveLog', '保存博文拓展', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('5', 'delLog', '删除博文拓展', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('6', 'relatedLog', '阅读博文拓展', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('7', 'commentPost', '发表评论扩展点（写入评论前）', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('8', 'commentSaved', '发表评论扩展点（写入评论后）', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('9', 'navbar', '导航拓展', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('10', 'documentDetailAfter', '文档末尾拓展', 'controller', '0000-00-00 00:00:00', 'test222,tes3333', '1');
INSERT INTO `xtt_hook` VALUES ('11', 'appBegin', '应用程序开始', 'controller', '0000-00-00 00:00:00', '', '1');
INSERT INTO `xtt_hook` VALUES ('12', 'appEnd', '应用程序结束', 'controller', '0000-00-00 00:00:00', 'Trace', '1');
INSERT INTO `xtt_hook` VALUES ('13', 'documentComment', '评论区', 'controller', '2015-06-23 23:37:29', 'socialComment', '1');

-- ----------------------------
-- Table structure for xtt_link
-- ----------------------------
DROP TABLE IF EXISTS `xtt_link`;
CREATE TABLE `xtt_link` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `info` varchar(256) DEFAULT NULL,
  `src` varchar(256) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_link
-- ----------------------------
INSERT INTO `xtt_link` VALUES ('1', '测试0000试试1', '10', '我是测试链接', 'http://www.baidu.com收拾收拾ss', '1');
INSERT INTO `xtt_link` VALUES ('2', 'hao123', '111', null, 'www.hao123.com', '0');
INSERT INTO `xtt_link` VALUES ('3', 'hao123', '111', null, 'www.hao123.com', '0');
INSERT INTO `xtt_link` VALUES ('4', 'hao123', '111', null, 'www.hao123.com', '0');
INSERT INTO `xtt_link` VALUES ('5', 'hao123', '111', null, 'www.hao123.com', '0');
INSERT INTO `xtt_link` VALUES ('7', '啊啊啊啊啊啊啊啊', '121212', null, '啊S', '0');
INSERT INTO `xtt_link` VALUES ('8', '啊啊啊啊啊啊啊啊', '121212', null, '啊S', '0');

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
INSERT INTO `xtt_member_info` VALUES ('1', 'admin', '8225e882a7d7a83c036e4784bc707267', '435024179@qq.com', 'http://www.me.me/Data/upload/image/avatar/1/yt_eda9c647b006dd8ee95fdfa9b4c767cb.jpg', '2015-07-03 16:56:47', '1', '职业', '兴趣爱好', '男', '用户说明', '赫本啊啊22223', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

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
INSERT INTO `xtt_member_login_log` VALUES ('32', '1270', '2015-03-18 16:24:11', '1');
INSERT INTO `xtt_member_login_log` VALUES ('33', '1270', '2015-03-20 10:01:36', '1');
INSERT INTO `xtt_member_login_log` VALUES ('34', '1270', '2015-03-20 10:06:50', '1');
INSERT INTO `xtt_member_login_log` VALUES ('35', '192168', '2015-03-21 20:57:24', '1');
INSERT INTO `xtt_member_login_log` VALUES ('36', '1270', '2015-03-21 21:05:39', '1');
INSERT INTO `xtt_member_login_log` VALUES ('37', '1270', '2015-03-21 21:08:23', '1');
INSERT INTO `xtt_member_login_log` VALUES ('38', '1270', '2015-03-21 21:09:50', '1');
INSERT INTO `xtt_member_login_log` VALUES ('39', '1270', '2015-03-21 21:18:48', '1');
INSERT INTO `xtt_member_login_log` VALUES ('40', '1270', '2015-03-21 21:19:15', '1');
INSERT INTO `xtt_member_login_log` VALUES ('41', '1270', '2015-03-21 21:19:39', '1');
INSERT INTO `xtt_member_login_log` VALUES ('42', '1270', '2015-03-22 12:26:46', '1');
INSERT INTO `xtt_member_login_log` VALUES ('43', '1270', '2015-03-22 12:29:25', '1');
INSERT INTO `xtt_member_login_log` VALUES ('44', '1270', '2015-03-22 12:29:53', '1');
INSERT INTO `xtt_member_login_log` VALUES ('45', '1270', '2015-03-22 12:31:41', '1');
INSERT INTO `xtt_member_login_log` VALUES ('46', '1270', '2015-03-22 12:33:15', '1');
INSERT INTO `xtt_member_login_log` VALUES ('47', '1270', '2015-03-22 12:37:54', '1');
INSERT INTO `xtt_member_login_log` VALUES ('48', '1270', '2015-03-22 13:12:38', '1');
INSERT INTO `xtt_member_login_log` VALUES ('49', '1270', '2015-03-22 20:15:28', '1');
INSERT INTO `xtt_member_login_log` VALUES ('50', '1270', '2015-03-24 15:14:08', '1');
INSERT INTO `xtt_member_login_log` VALUES ('51', '1270', '2015-03-25 11:43:04', '1');
INSERT INTO `xtt_member_login_log` VALUES ('52', '1270', '2015-03-27 12:59:59', '1');
INSERT INTO `xtt_member_login_log` VALUES ('53', '1270', '2015-03-29 18:35:23', '1');
INSERT INTO `xtt_member_login_log` VALUES ('54', '1270', '2015-03-29 19:25:44', '1');
INSERT INTO `xtt_member_login_log` VALUES ('55', '1270', '2015-03-29 21:05:53', '1');
INSERT INTO `xtt_member_login_log` VALUES ('56', '1270', '2015-03-30 13:24:31', '1');
INSERT INTO `xtt_member_login_log` VALUES ('57', '1270', '2015-03-30 21:46:02', '1');
INSERT INTO `xtt_member_login_log` VALUES ('58', '1270', '2015-04-02 14:23:14', '1');
INSERT INTO `xtt_member_login_log` VALUES ('59', '1270', '2015-04-21 14:28:15', '1');
INSERT INTO `xtt_member_login_log` VALUES ('60', '1270', '2015-04-21 15:17:42', '1');
INSERT INTO `xtt_member_login_log` VALUES ('61', '1270', '2015-04-22 09:21:40', '1');
INSERT INTO `xtt_member_login_log` VALUES ('62', '1270', '2015-04-23 15:42:56', '1');
INSERT INTO `xtt_member_login_log` VALUES ('63', '1270', '2015-04-24 09:31:19', '1');
INSERT INTO `xtt_member_login_log` VALUES ('64', '1270', '2015-04-27 09:13:48', '1');
INSERT INTO `xtt_member_login_log` VALUES ('65', '1270', '2015-04-27 09:31:53', '1');
INSERT INTO `xtt_member_login_log` VALUES ('66', '1270', '2015-04-28 09:11:23', '1');
INSERT INTO `xtt_member_login_log` VALUES ('67', '1270', '2015-04-29 16:41:48', '1');
INSERT INTO `xtt_member_login_log` VALUES ('68', '1270', '2015-04-30 09:54:19', '1');
INSERT INTO `xtt_member_login_log` VALUES ('69', '1270', '2015-05-04 15:13:26', '1');
INSERT INTO `xtt_member_login_log` VALUES ('70', '1270', '2015-05-04 15:37:42', '1');
INSERT INTO `xtt_member_login_log` VALUES ('71', '1270', '2015-05-05 16:28:29', '1');
INSERT INTO `xtt_member_login_log` VALUES ('72', '1270', '2015-05-06 11:13:48', '1');
INSERT INTO `xtt_member_login_log` VALUES ('73', '1270', '2015-05-07 10:23:48', '1');
INSERT INTO `xtt_member_login_log` VALUES ('74', '1270', '2015-05-08 09:16:08', '1');
INSERT INTO `xtt_member_login_log` VALUES ('75', '1270', '2015-05-11 09:16:03', '1');
INSERT INTO `xtt_member_login_log` VALUES ('76', '1270', '2015-05-11 14:42:46', '1');
INSERT INTO `xtt_member_login_log` VALUES ('77', '1270', '2015-05-12 14:21:06', '1');
INSERT INTO `xtt_member_login_log` VALUES ('78', '1270', '2015-05-16 13:47:56', '1');
INSERT INTO `xtt_member_login_log` VALUES ('79', '1270', '2015-05-18 14:56:24', '1');
INSERT INTO `xtt_member_login_log` VALUES ('80', '1270', '2015-05-19 09:14:42', '1');
INSERT INTO `xtt_member_login_log` VALUES ('81', '1270', '2015-06-24 21:38:23', '1');
INSERT INTO `xtt_member_login_log` VALUES ('82', '1270', '2015-06-27 11:25:39', '1');
INSERT INTO `xtt_member_login_log` VALUES ('83', '1270', '2015-06-30 14:40:27', '1');
INSERT INTO `xtt_member_login_log` VALUES ('84', '1270', '2015-07-01 11:23:16', '1');
INSERT INTO `xtt_member_login_log` VALUES ('85', '1270', '2015-07-02 15:05:32', '1');
INSERT INTO `xtt_member_login_log` VALUES ('86', '1270', '2015-07-03 09:25:46', '1');
INSERT INTO `xtt_member_login_log` VALUES ('87', '1270', '2015-07-03 11:04:09', '1');
INSERT INTO `xtt_member_login_log` VALUES ('88', '1270', '2015-07-03 16:48:12', '1');
INSERT INTO `xtt_member_login_log` VALUES ('89', '1270', '2015-07-20 17:17:19', '1');
INSERT INTO `xtt_member_login_log` VALUES ('90', '1270', '2015-07-21 10:12:09', '1');
INSERT INTO `xtt_member_login_log` VALUES ('91', '1270', '2015-07-21 17:25:13', '1');
INSERT INTO `xtt_member_login_log` VALUES ('92', '1270', '2015-07-21 17:45:06', '1');
INSERT INTO `xtt_member_login_log` VALUES ('93', '1270', '2015-07-21 17:46:22', '1');
INSERT INTO `xtt_member_login_log` VALUES ('94', '1270', '2015-07-21 17:53:00', '1');
INSERT INTO `xtt_member_login_log` VALUES ('95', '1270', '2015-07-21 17:55:09', '1');
INSERT INTO `xtt_member_login_log` VALUES ('96', '1270', '2015-07-21 17:56:52', '1');
INSERT INTO `xtt_member_login_log` VALUES ('97', '1270', '2015-07-21 17:59:01', '1');
INSERT INTO `xtt_member_login_log` VALUES ('98', '1270', '2015-07-21 18:00:10', '1');
INSERT INTO `xtt_member_login_log` VALUES ('99', '1270', '2015-07-21 18:02:42', '1');
INSERT INTO `xtt_member_login_log` VALUES ('100', '1270', '2015-07-23 09:23:15', '1');
INSERT INTO `xtt_member_login_log` VALUES ('101', '1270', '2015-07-24 09:36:26', '1');
INSERT INTO `xtt_member_login_log` VALUES ('102', '1270', '2015-07-28 16:49:20', '1');
INSERT INTO `xtt_member_login_log` VALUES ('103', '1270', '2015-07-28 21:51:33', '1');
INSERT INTO `xtt_member_login_log` VALUES ('104', '1270', '2015-08-01 10:35:26', '1');
INSERT INTO `xtt_member_login_log` VALUES ('105', '1270', '2015-08-01 20:11:39', '1');
INSERT INTO `xtt_member_login_log` VALUES ('106', '1270', '2015-08-02 10:37:23', '1');
INSERT INTO `xtt_member_login_log` VALUES ('107', '1270', '2015-08-03 21:59:35', '1');

-- ----------------------------
-- Table structure for xtt_plugs
-- ----------------------------
DROP TABLE IF EXISTS `xtt_plugs`;
CREATE TABLE `xtt_plugs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `crate_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '安装时间',
  `has_adminlist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有后台操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='插件表';

-- ----------------------------
-- Records of xtt_plugs
-- ----------------------------
INSERT INTO `xtt_plugs` VALUES ('1', 'test', '测试', '我只是一个测试', '0', null, 'xtt', '1.0', '2015-05-06 11:57:17', '0');
INSERT INTO `xtt_plugs` VALUES ('13', 'test222', '插件测试222', '插件测试222', '0', '{\"comment_type\":\"1\",\"comment_uid_youyan\":\"\",\"comment_short_name_duoshuo\":\"\",\"comment_data_list_duoshuo\":\"\"}', 'xietaotao', '1.0', '2015-05-08 14:10:26', '0');
INSERT INTO `xtt_plugs` VALUES ('18', 'trace', 'Trace追踪', '来自于Thinkphp', '1', '', 'Thinkphp', '1.0', '2015-05-08 15:21:41', '0');
INSERT INTO `xtt_plugs` VALUES ('21', 'headtest', 'tempHead插件测试', '插件测试', '0', '', 'xietaotao', '1.0', '2015-05-19 17:27:35', '0');
INSERT INTO `xtt_plugs` VALUES ('22', 'socialcomment', '通用社交化评论', '集成了各种社交化评论插件，轻松集成到系统中。', '1', '{\"comment_type\":\"2\",\"comment_uid_youyan\":\"2017124\",\"comment_short_name_duoshuo\":\"164483642\",\"comment_form_pos_duoshuo\":\"top\",\"comment_data_list_duoshuo\":\"10\",\"comment_data_order_duoshuo\":\"desc\"}', 'thinkphp', '0.1', '2015-06-23 23:45:30', '0');

-- ----------------------------
-- Table structure for xtt_sidebar
-- ----------------------------
DROP TABLE IF EXISTS `xtt_sidebar`;
CREATE TABLE `xtt_sidebar` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL COMMENT '标题',
  `data` varchar(518) DEFAULT NULL COMMENT '数据',
  `group` varchar(128) DEFAULT NULL COMMENT '用户组 system or diy',
  `show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `sort` tinyint(4) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_sidebar
-- ----------------------------
INSERT INTO `xtt_sidebar` VALUES ('1', 'blogger', 'blogger', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:7:\"blogger\";}}', 'system', '1', '2');
INSERT INTO `xtt_sidebar` VALUES ('2', '日历', 'calendar', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:6:\"日历\";}}', 'system', '1', '0');
INSERT INTO `xtt_sidebar` VALUES ('3', '最新说说', 'newtwitter', 'a:2:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:12:\"最新说说\";}i:1;a:2:{s:5:\"title\";s:27:\"首页显示最新说说数\";s:4:\"data\";s:1:\"5\";}}', 'system', '1', '3');
INSERT INTO `xtt_sidebar` VALUES ('4', '标签', 'tags', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:6:\"标签\";}}', 'system', '1', '8');
INSERT INTO `xtt_sidebar` VALUES ('5', '分类', 'category', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:6:\"分类\";}}', 'system', '1', '4');
INSERT INTO `xtt_sidebar` VALUES ('6', '存档', 'archive', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:6:\"存档\";}}', 'system', '1', '5');
INSERT INTO `xtt_sidebar` VALUES ('7', '链接', 'link', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:6:\"链接\";}}', 'system', '1', '6');
INSERT INTO `xtt_sidebar` VALUES ('8', '搜索', 'search', 'a:1:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:6:\"搜索\";}}', 'system', '1', '1');
INSERT INTO `xtt_sidebar` VALUES ('9', '最新评论', 'newcomment', 'a:3:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:12:\"最新评论\";}i:1;a:2:{s:5:\"title\";s:21:\"首页最新评论数\";s:4:\"data\";s:2:\"10\";}i:2;a:2:{s:5:\"title\";s:27:\"新近评论截取字节数\";s:4:\"data\";s:2:\"20\";}}', 'system', '1', '9');
INSERT INTO `xtt_sidebar` VALUES ('10', '最新日志', 'newblog', 'a:2:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:12:\"最新日志\";}i:1;a:2:{s:5:\"title\";s:27:\"首页显示最新日志数\";s:4:\"data\";s:2:\"10\";}}', 'system', '1', '10');
INSERT INTO `xtt_sidebar` VALUES ('11', '热门日志', 'hotblog', 'a:2:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:12:\"热门日志\";}i:1;a:2:{s:5:\"title\";s:27:\"首页显示热门日志数\";s:4:\"data\";s:2:\"10\";}}', 'system', '1', '7');
INSERT INTO `xtt_sidebar` VALUES ('12', '随机日志', 'randblog', 'a:2:{i:0;a:2:{s:5:\"title\";s:6:\"标题\";s:4:\"data\";s:12:\"随机日志\";}i:1;a:2:{s:5:\"title\";s:27:\"首页显示随机日志数\";s:4:\"data\";s:2:\"10\";}}', 'system', '1', '11');

-- ----------------------------
-- Table structure for xtt_template
-- ----------------------------
DROP TABLE IF EXISTS `xtt_template`;
CREATE TABLE `xtt_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL COMMENT '名字',
  `status` int(1) DEFAULT '0' COMMENT '是否选定',
  `crate_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `version` varchar(256) DEFAULT NULL COMMENT '版本',
  `author` varchar(256) DEFAULT NULL COMMENT '作者',
  `descriptor` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_template
-- ----------------------------
INSERT INTO `xtt_template` VALUES ('1', 'default', '1', '2015-07-03 15:43:52', '1.0', 'reserved', '默认', null);
INSERT INTO `xtt_template` VALUES ('4', 'lipop', '0', '2015-07-03 15:43:52', 'V1.0', 'xietaotao', '', '');

-- ----------------------------
-- Table structure for xtt_twitter
-- ----------------------------
DROP TABLE IF EXISTS `xtt_twitter`;
CREATE TABLE `xtt_twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  `author` int(10) NOT NULL DEFAULT '1',
  `crate_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `replynum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author` (`author`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_twitter
-- ----------------------------
INSERT INTO `xtt_twitter` VALUES ('10', '源码不能乱下载....', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('11', '老师再水也体谅下，都是混口饭吃，不容易啊', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('5', '最近情绪大起大落，也终于觉得，人在失落的时候是最冷静的。 所以有句话叫，化悲痛为力量', 'content/uploadfile/201210/thum-c3461349883618.jpg', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('7', '坑爹的就业培训', null, '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('8', '有意见可以说，乐意接受，你不说谁知道呢？', null, '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('9', '代号“兔子”', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('12', '腾讯下次5块钱你就别通知我了，害我白高兴。', 'content/uploadfile/201210/thum-b8641350574015.png', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('13', '我无法一一言明。 \r\n\r\n就算这同样的夜景， \r\n有人看到的是灯火璀璨， \r\n有人看到的无非更落寞。 \r\n\r\n这话矫情， \r\n可我相信， \r\n总有那么一刻你会明白， \r\n它真实着。 \r\n\r\n我信平和多于激烈， \r\n我觉着一切都归于淡， \r\n就像我们父母的现在， \r\n平平静静，淡淡然然', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('14', '手贱又刷机。刷你妹哦', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('17', '让改变发生吧', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('18', '希望不要跟市场营销的抢饭碗', null, '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('19', '尼玛哦', 'content/uploadfile/201211/thum-e9b91352032226.png', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('23', '明天招聘会，求工作', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('22', '要开始忙碌了吧', null, '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('24', '小菜鸟', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('25', '看不懂，傻眼了。', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('27', '我见不得你骗我', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('28', '再见--张震岳', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('29', '传说中的世界末日在12月21日就要到了，如果这天真的是世界末日，你还有什么心理话没说呢？有什么愿望还没有实现呢？此刻！大声的喊出来吧，还犹豫什么？虽说末日要来了，我还是要说：“2013年，我会做的更好，活的更精彩', '', '1', '2015-03-20 13:56:27', '1', '1');
INSERT INTO `xtt_twitter` VALUES ('36', '跨一步，一步很短，但很宽。跨过去，或璀璨，或萧条。这都只是一种心态罢了', '', '1', '2015-03-20 13:56:27', '0', '1');
INSERT INTO `xtt_twitter` VALUES ('37', 'test<br><br>', '', '1', '2015-06-26 14:09:12', '0', '1');
