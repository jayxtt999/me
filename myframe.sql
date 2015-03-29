/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : myframe

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-03-29 21:16:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `xtt_article`
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
INSERT INTO `xtt_article` VALUES ('1', '测试0000', '阿SA说', '<p><a id=\"ematt:22\" href=\"http://www.bailili.cn/content/uploadfile/201211/73381352854321.jpg\" target=\"_blank\"><img title=\"点击查看原图\" border=\"0\" alt=\"点击查看原图\" src=\"http://www.xietaotao.cn/content/uploadfile/201211/4f5ff581ac03122baf7eb057b7e0a0bd20121115095059.jpg\" width=\"315\" height=\"337\" /></a></p>\r\n<p>玛丽莲.梦露——36岁</p>\r\n<p>梦露虽有颠沛流离的童年，却从未放弃希望自己能成为大明星珍.哈露的梦想。戏里戏外都风情万种的梦露承受着拳击手丈夫的家庭暴力；在片场休息室里茫然无助的眼神被镁光灯偷偷的瞬间捕捉；被人追随惯的巨星也喜欢站在阳台惬意地观察来来往往的普通人。1963年，蹉跎青春经不起上帝的挥一挥手，没有带走任何一片“云彩”。难道追随珍.哈露的足迹注定将梦露神华戛然而止在36岁吗？</p>\r\n<p><a id=\"ematt:24\" href=\"http://www.bailili.cn/content/uploadfile/201211/5b0a1352855050.jpg\" target=\"_blank\"><img border=\"0\" alt=\"点击查看原图\" src=\"http://www.xietaotao.cn/content/uploadfile/201211/aa0f0814fad83c7066bba703e8b166bf20121115095103.jpg\" /></a></p>\r\n<p>伊丽莎白.肖特——22岁</p>\r\n<p>1947年的一个清晨，伊丽莎白.肖特被人发现惨死在公园里。从腹部开始已经横腰拦断变成了两截，四肢张开，被人鸡奸。这个年轻的二流演员先天发育不完整的性器官无法完成正常的性行为。一切源于歧视？追查真凶至今都未果，外界也先后有很多猜测，甚至有某知名导演表示知道真正的凶手，但出于自己的声望不愿站出来指正。现在的影迷也许不知道这个年轻的演员，但是很难忘根据这事件改编搬上大银幕的《黑色大丽花》。</p>\r\n<p><a id=\"ematt:25\" href=\"http://www.bailili.cn/content/uploadfile/201211/3b171352855202.jpg\" target=\"_blank\"><img border=\"0\" alt=\"点击查看原图\" src=\"http://www.xietaotao.cn/content/uploadfile/201211/8b1cfce5d06ecefd6ebeb732f50f4db620121115095106.jpg\" /></a></p>\r\n<p>卡罗尔.隆巴德</p>\r\n<p>她永远是好莱坞皇帝克拉克盖博一生中最爱的女人。1939年盖博不只是有《乱世佳人》，上帝也拍了卡罗尔.隆巴德与他做伴，天作之合往往好景不长，婚姻维持了3年后，还是以一场飞机失事带走了生来为喜剧而打造的女人。作为有5段婚姻，无数情人的风流影帝享年59岁回归了自己的真爱，葬在了她的身旁。时至今日，她的早逝并未让我们记住她是一个30年代在好莱坞最会表演的喜剧女演员，一切皆因她有位羡煞旁人的传奇丈夫。</p>\r\n<p><a id=\"ematt:26\" href=\"http://www.bailili.cn/content/uploadfile/201211/e0771352855612.jpg\" target=\"_blank\"><img title=\"点击查看原图\" border=\"0\" alt=\"点击查看原图\" src=\"http://www.xietaotao.cn/content/uploadfile/201211/7476bbbed48a977682540fee66c599eb20121115095107.jpg\" width=\"294\" height=\"368\" /></a></p>\r\n<p>卡罗尔.兰迪斯——29岁</p>\r\n<p>1919年1月1日这个注定不平凡的女人来到了人世。演技平平却天生丽质的卡罗尔.兰迪斯还是迅速蹿红跻身明星之列。据说盛行活泼热爱运动的她跑步速度很快，讽刺的是他的婚姻也是如此。4段婚姻失败加上与已婚人士关系的扑朔迷离，她放弃了大好前途以及像卓别林和某同性暧昧者此般情人，在1948年7月4日，正值老美沉浸在建国日当天的喜悦中，她选择用过量安眠药了结自己短暂又富戏剧性的一生。</p>\r\n<p>&nbsp;</p>\r\n<p>佩吉.安特维斯特——24岁</p>\r\n<p>30年代初的经济萧条迫使这个舞台剧演员只身转战好莱坞望改变窘境。在某部恶评如潮的电影中扮演了一个小角色，电影公司不得不将该片中断放映。而佩吉的命运也仿佛不见天日，没有得到那点微薄报酬使身无分文的她彻底失去了生存的勇气。用酒精麻醉自己后爬上永不熄灭的“HOLLYWOODLAND”（1939年“LAND”才被拿去），在“H”上纵身跃下。佩吉是“好莱坞”标志牌上轻生的第一人，希望她在天堂里能够好过点......</p>\r\n<p>&nbsp;</p>\r\n<p>本文转自《小资风尚》第二十九期</p>', 'http://www.me.me/Data/upload/image/article/1/yt_3165799a056f7b453ed86904513ca977.jpg', '2015-03-26 11:51:50', '1', '1', '100', '100', '1', '1', '1', '123456');

-- ----------------------------
-- Table structure for `xtt_article_category`
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
-- Table structure for `xtt_article_tag`
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
-- Table structure for `xtt_comment`
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xtt_comment
-- ----------------------------
INSERT INTO `xtt_comment` VALUES ('1', '张三', '154894476', '2015-03-27 11:42:11', '测试', '1', '1', '1', '0', null, '1', '', '1', null);
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

-- ----------------------------
-- Table structure for `xtt_common_menu`
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
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8 COMMENT='栏目菜单';

-- ----------------------------
-- Records of xtt_common_menu
-- ----------------------------
INSERT INTO `xtt_common_menu` VALUES ('1', '主栏目', '122', '2014-04-21 17:55:58', 'admin', 'index', 'index', 'http://www.me.me/index.php?m=admin&c=index&a=index', '1', '1', '1', '0', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('2', '栏目列表', '阿达说的', '2014-04-21 18:25:09', 'admin', 'menu', 'index', 'www.baidu.com', '10', '1', '100', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('3', '配置列表', '', '2014-06-03 16:50:19', 'admin', 'config', 'index', '/admin/common_config/index', '0', '1', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('4', '会员登陆', '会员登陆', '2015-02-11 09:59:27', 'member', 'login', 'index', 'www.baidu.com', '1', '0', '1', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('5', '会员列表', '会员管理', '2015-02-11 10:30:08', 'admin', 'member', 'list', null, '0', '1', '1', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('200', '主页', '主页', '2015-03-18 16:42:17', 'home', 'index', 'index', '', '2', '1', '', '1', '0', '1');
INSERT INTO `xtt_common_menu` VALUES ('210', '栏目列表添加', '', '2014-09-28 11:43:54', 'admin', 'common_menu', 'add', '', '0', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('211', '栏目列表编辑', '', '2014-09-28 11:44:22', 'admin', 'menu', 'edit', '', '0', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('212', '栏目列表删除', '', '2014-09-28 11:44:40', 'admin', 'common_menu', 'del', '', '0', '0', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('213', '日志管理', '日志管理', '2015-02-28 10:47:15', 'admin', 'article', 'list', '', '1', '1', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('214', '添加日志', '添加日志', '2015-02-28 16:06:42', 'admin', 'article', 'add', '', '1', '0', '1', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('215', '编辑日志', '编辑日志', '2015-02-28 16:07:12', 'admin', 'article', 'edit', '', '1', '0', '', '1', '0', '0');
INSERT INTO `xtt_common_menu` VALUES ('216', 'Blog', '博文', '2015-03-18 16:42:17', 'home', 'blog', 'index', '', '1', '1', '', '1', '0', '1');
INSERT INTO `xtt_common_menu` VALUES ('217', '说说管理', '说说管理', null, 'admin', 'twitter', 'index', '', '1', '1', '', '1', '1', '0');
INSERT INTO `xtt_common_menu` VALUES ('218', '博文详情', '博文详情', null, 'home', 'blog', 'show', '', '1', '1', '', '1', '0', '0');

-- ----------------------------
-- Table structure for `xtt_config`
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
INSERT INTO `xtt_config` VALUES ('8', 'footer_info', '2014 © Metronic by keenthemes.<a href=\\\"http://user.qzone.qq.com/435024179/infocenter\\\"target=\\\"_blank\\\" >访问我的QQ空间</a><script type=\\\"text/javascript\\\" src=\\\"http://tajs.qq.com/stats?sId=16270255\\\"  charset=\\\"UTF8\\\"></script>');
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
-- Table structure for `xtt_member_info`
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
INSERT INTO `xtt_member_info` VALUES ('1', 'admin', '8225e882a7d7a83c036e4784bc707267', '435024179@qq.com', 'http://192.168.1.104/Data/upload/image/avatar/1/yt_6c97b038825a6687d5826e1e97daa22f.JPG', '2015-03-21 21:36:12', '1', '职业', '兴趣爱好', '男', '用户说明', '昵称', '1');

-- ----------------------------
-- Table structure for `xtt_member_login_log`
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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

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

-- ----------------------------
-- Table structure for `xtt_twitter`
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
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

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
