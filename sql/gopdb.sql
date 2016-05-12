/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.6.23-log : Database - pmdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `last_ip_addr` varchar(16) NOT NULL,
  `last_login_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3180 DEFAULT CHARSET=utf8;

/*Table structure for table `consumers` */

DROP TABLE IF EXISTS `consumers`;

CREATE TABLE `consumers` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '平台名称',
  `code` varchar(30) NOT NULL COMMENT '平台代号',
  `desc` text NOT NULL COMMENT '平台描述',
  `create_at` int(10) NOT NULL,
  `key` varchar(100) NOT NULL,
  `server_ids` text COMMENT '平台服务器列表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `log_action` */

DROP TABLE IF EXISTS `log_action`;

CREATE TABLE `log_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `player_id` int(10) unsigned NOT NULL,
  `mark` text NOT NULL,
  `created_at` varchar(20) NOT NULL,
  `server_id` int(10) NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  `uniqid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqid` (`uniqid`),
  KEY `gid` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=155003 DEFAULT CHARSET=utf8;

/*Table structure for table `log_cost` */

DROP TABLE IF EXISTS `log_cost`;

CREATE TABLE `log_cost` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `type` varchar(100) NOT NULL,
  `num` int(10) unsigned NOT NULL,
  `left_num` int(10) unsigned NOT NULL,
  `uniqid` varchar(100) NOT NULL,
  `server_id` int(10) unsigned NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  `date` varchar(10) NOT NULL,
  `created_at` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqid` (`uniqid`),
  KEY `gid` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21950 DEFAULT CHARSET=utf8;

/*Table structure for table `log_goods` */

DROP TABLE IF EXISTS `log_goods`;

CREATE TABLE `log_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `goods_id` int(10) NOT NULL,
  `count` int(10) NOT NULL,
  `server_id` int(10) NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  `created_at` varchar(20) NOT NULL,
  `uniqid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqid` (`uniqid`),
  KEY `gid` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1726 DEFAULT CHARSET=utf8;

/*Table structure for table `log_login` */

DROP TABLE IF EXISTS `log_login`;

CREATE TABLE `log_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `date` varchar(10) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `ip` varchar(30) NOT NULL,
  `server_id` int(10) unsigned NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  `uniqid` varchar(100) NOT NULL,
  `created_at` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_uniqid` (`uniqid`),
  KEY `idx_gid` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9074 DEFAULT CHARSET=utf8;

/*Table structure for table `log_online` */

DROP TABLE IF EXISTS `log_online`;

CREATE TABLE `log_online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(10) NOT NULL,
  `hour` varchar(10) NOT NULL,
  `num` int(10) unsigned NOT NULL DEFAULT '0',
  `server_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` varchar(20) NOT NULL,
  `uniqid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqid` (`uniqid`),
  KEY `date` (`date`),
  KEY `server_id` (`server_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41881 DEFAULT CHARSET=utf8;

/*Table structure for table `log_packet` */

DROP TABLE IF EXISTS `log_packet`;

CREATE TABLE `log_packet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmd` int(4) NOT NULL,
  `data` text NOT NULL,
  `created_at` varchar(20) NOT NULL,
  `server_id` int(11) unsigned NOT NULL,
  `player_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=165627 DEFAULT CHARSET=utf8;

/*Table structure for table `log_pay` */

DROP TABLE IF EXISTS `log_pay`;

CREATE TABLE `log_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(10) unsigned NOT NULL,
  `server_id` int(10) unsigned NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `transaction_id` varchar(32) NOT NULL,
  `amount` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `num` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date` varchar(10) NOT NULL,
  `mark` text NOT NULL,
  `resp` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5895 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `log_stats` */

DROP TABLE IF EXISTS `log_stats`;

CREATE TABLE `log_stats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) NOT NULL,
  `type` varchar(30) NOT NULL,
  `num` int(10) NOT NULL,
  `server_id` int(10) NOT NULL,
  `crc` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_date` (`date`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7376 DEFAULT CHARSET=utf8;

/*Table structure for table `mail` */

DROP TABLE IF EXISTS `mail`;

CREATE TABLE `mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `role_ids` text NOT NULL,
  `server_ids` text NOT NULL,
  `goods_ids` text NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `s_time` int(10) unsigned NOT NULL,
  `e_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `notice_login` */

DROP TABLE IF EXISTS `notice_login`;

CREATE TABLE `notice_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '公告内容',
  `uid` int(10) unsigned NOT NULL COMMENT '创建者',
  `s_time` int(10) unsigned NOT NULL COMMENT '开始时间',
  `e_time` int(10) unsigned NOT NULL COMMENT '结束时间',
  `created_at` int(10) unsigned NOT NULL COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL COMMENT '状态',
  `server_ids` text NOT NULL COMMENT '服务器列表 0所有',
  `sort` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `notice_msg` */

DROP TABLE IF EXISTS `notice_msg`;

CREATE TABLE `notice_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_time` int(10) unsigned NOT NULL,
  `e_time` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `interval` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `server_ids` text NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `sort` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Table structure for table `player` */

DROP TABLE IF EXISTS `player`;

CREATE TABLE `player` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `server_id` int(10) unsigned NOT NULL DEFAULT '0',
  `consumer_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_ip_addr` varchar(16) NOT NULL,
  `last_login_time` int(10) NOT NULL,
  `date` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10192 DEFAULT CHARSET=utf8;

/*Table structure for table `servers` */

DROP TABLE IF EXISTS `servers`;

CREATE TABLE `servers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `no` int(10) unsigned NOT NULL COMMENT '服务器编号',
  `name` varchar(100) NOT NULL,
  `host` varchar(100) NOT NULL,
  `port` int(10) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `create_at` int(10) unsigned NOT NULL,
  `sort` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_no` (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '运营商登录名称',
  `nickname` varchar(30) NOT NULL COMMENT '运营商显示名称',
  `password` varchar(100) NOT NULL COMMENT '运营商登录密码',
  `consumer_ids` varchar(255) NOT NULL,
  `group_id` smallint(5) unsigned NOT NULL COMMENT '权限组ID',
  `create_at` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '权限组名称',
  `flag` text NOT NULL COMMENT '权限组范围 json存贮  能访问的api接口名称',
  `desc` text COMMENT '描述',
  `consumer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


