/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.1.40-log : Database - igeek_uchome
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`igeek_uchome` /*!40100 DEFAULT CHARACTER SET gbk */;

USE `igeek_uchome`;

/*Table structure for table `uchome__articleContent` */

DROP TABLE IF EXISTS `uchome__articleContent`;

CREATE TABLE `uchome__articleContent` (
  `articleId` bigint(11) NOT NULL COMMENT '文章编号',
  `content` text NOT NULL COMMENT '文章内容',
  `summary` text NOT NULL COMMENT '文章简介',
  PRIMARY KEY (`articleId`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__articleLog` */

DROP TABLE IF EXISTS `uchome__articleLog`;

CREATE TABLE `uchome__articleLog` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `articleId` int(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `articleTypeId` tinyint(2) NOT NULL COMMENT '文章分类ID',
  `uid` bigint(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `isRead` tinyint(2) DEFAULT '0' COMMENT '是否浏览',
  `isPublish` tinyint(2) DEFAULT '0' COMMENT '是否发布',
  `dateline` int(11) NOT NULL COMMENT '文章浏览日期',
  PRIMARY KEY (`id`),
  KEY `articleTypeId` (`articleTypeId`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=5459 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__articleTag` */

DROP TABLE IF EXISTS `uchome__articleTag`;

CREATE TABLE `uchome__articleTag` (
  `rid` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '对应ID',
  `tagId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '标签ID',
  `articleId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=808 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__articleTypes` */

DROP TABLE IF EXISTS `uchome__articleTypes`;

CREATE TABLE `uchome__articleTypes` (
  `articleTypeId` mediumint(8) NOT NULL COMMENT '文章类型ID',
  `articleTypeName` varchar(50) NOT NULL COMMENT '文章类型名称',
  `isAvailable` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否可用',
  `createTime` int(11) NOT NULL COMMENT '类型创建时间',
  `parentTypeId` mediumint(8) NOT NULL DEFAULT '0' COMMENT '文章类型的父类型',
  PRIMARY KEY (`articleTypeId`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__articles` */

DROP TABLE IF EXISTS `uchome__articles`;

CREATE TABLE `uchome__articles` (
  `articleId` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章编号',
  `bbsId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '论坛ID',
  `bbsTid` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '帖子TID',
  `title` varchar(200) NOT NULL COMMENT '文章标题',
  `sourceUrl` varchar(200) NOT NULL COMMENT '原文地址',
  `articleTypeId` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章类型编号',
  `authorId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `authorName` varchar(20) NOT NULL COMMENT '用户名',
  `sourceAuthor` varchar(20) NOT NULL COMMENT '原作者',
  `createTime` int(11) NOT NULL COMMENT '创建时间',
  `approveTime` int(11) NOT NULL COMMENT '审核通过时间',
  `publishTime` int(11) NOT NULL COMMENT '发布时间',
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章PV统计',
  `viewnum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章浏览次数',
  `replynum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章评论次数',
  `click_up` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章顶的次数',
  `click_down` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章踩的次数',
  `isImage` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '文章是否有配图',
  `isReleased` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '文章是否已发布',
  `isAvailable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '文章是否可用',
  `checkState` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章是否审核,1审核，0未审核，-1被退回',
  `isPush` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章是否推送到首页',
  `sortId` bigint(11) NOT NULL DEFAULT '0' COMMENT '文章排列顺序',
  PRIMARY KEY (`articleId`)
) ENGINE=MyISAM AUTO_INCREMENT=495 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__bbsRelate` */

DROP TABLE IF EXISTS `uchome__bbsRelate`;

CREATE TABLE `uchome__bbsRelate` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `bbsId` bigint(11) NOT NULL DEFAULT '0' COMMENT '论坛ID',
  `bbsName` varchar(20) NOT NULL COMMENT '论坛名称',
  `bbsUrl` varchar(200) NOT NULL COMMENT '论坛URL地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__checkmember` */

DROP TABLE IF EXISTS `uchome__checkmember`;

CREATE TABLE `uchome__checkmember` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL COMMENT '用户id',
  `username` varchar(40) NOT NULL COMMENT '用户名',
  `realname` varchar(40) NOT NULL COMMENT '真实姓名',
  `applytime` int(10) NOT NULL COMMENT '申请时间',
  `gender` tinyint(1) NOT NULL COMMENT '性别',
  `bday` date NOT NULL COMMENT '生日',
  `email` varchar(40) NOT NULL COMMENT '邮件',
  `checkstr` varchar(20) NOT NULL COMMENT '邮件验证字符串,为空即为验证通过',
  `bbsid` tinyint(4) NOT NULL COMMENT '论坛id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮件验证状态。0：没有验证，1通过验证',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=232 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__clicks` */

DROP TABLE IF EXISTS `uchome__clicks`;

CREATE TABLE `uchome__clicks` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `articleId` bigint(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `commentId` bigint(11) NOT NULL DEFAULT '0' COMMENT '评论ID',
  `authorId` bigint(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ip` varchar(20) NOT NULL COMMENT '用户IP',
  `up` tinyint(1) NOT NULL DEFAULT '0' COMMENT '顶次数',
  `down` tinyint(1) NOT NULL DEFAULT '0' COMMENT '踩次数',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '顶踩时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2010 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__comment` */

DROP TABLE IF EXISTS `uchome__comment`;

CREATE TABLE `uchome__comment` (
  `commentId` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `articleId` bigint(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `bbsId` bigint(11) NOT NULL DEFAULT '0' COMMENT '论坛ID ',
  `bbsTid` bigint(11) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `bbsPid` bigint(11) NOT NULL DEFAULT '0' COMMENT '回复ID',
  `message` text NOT NULL COMMENT '回复内容',
  `dateline` int(11) NOT NULL COMMENT '回复时间',
  `authorId` bigint(11) NOT NULL DEFAULT '0' COMMENT '回复人ID',
  `author` varchar(30) NOT NULL COMMENT '回复人姓名',
  `click_up` bigint(11) NOT NULL DEFAULT '0' COMMENT '评论顶的次数',
  `click_down` bigint(11) NOT NULL DEFAULT '0' COMMENT '评论踩的次数',
  `isSync` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否已经同步到论坛',
  PRIMARY KEY (`commentId`)
) ENGINE=MyISAM AUTO_INCREMENT=956 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__guide` */

DROP TABLE IF EXISTS `uchome__guide`;

CREATE TABLE `uchome__guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  `guide` int(1) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__helpLoginLog` */

DROP TABLE IF EXISTS `uchome__helpLoginLog`;

CREATE TABLE `uchome__helpLoginLog` (
  `uid` int(11) DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__mytag` */

DROP TABLE IF EXISTS `uchome__mytag`;

CREATE TABLE `uchome__mytag` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'TAG和用户关联ID',
  `tagId` bigint(11) NOT NULL DEFAULT '0' COMMENT 'TAG ID',
  `uid` bigint(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '关注时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__pics` */

DROP TABLE IF EXISTS `uchome__pics`;

CREATE TABLE `uchome__pics` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章配图ID',
  `articleId` bigint(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `src` varchar(100) NOT NULL COMMENT '图片链接地址',
  `picUrl` varchar(255) NOT NULL COMMENT '图片跳转URL地址',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '图片生效时间',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '图片文字说明',
  `orderId` tinyint(2) NOT NULL COMMENT '幻灯图排序.序号：1，2，3，4',
  `isRoll` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否幻灯图片',
  `isMain` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否文章头图。.0没有图片，1是配图，2是头图',
  `isAvailable` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__report` */

DROP TABLE IF EXISTS `uchome__report`;

CREATE TABLE `uchome__report` (
  `rid` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '举报ID',
  `replyId` bigint(11) NOT NULL DEFAULT '0' COMMENT '被举报评论ID',
  `ruid` bigint(11) NOT NULL DEFAULT '0' COMMENT '被举报用户ID',
  `suid` bigint(11) NOT NULL DEFAULT '0' COMMENT '举报用户ID',
  `reason` text NOT NULL COMMENT '举报原因',
  `isDone` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否处理',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '举报时间',
  `doneTime` int(11) NOT NULL DEFAULT '0' COMMENT '处理时间',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__tagLog` */

DROP TABLE IF EXISTS `uchome__tagLog`;

CREATE TABLE `uchome__tagLog` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `articleId` int(10) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `tagName` varchar(20) NOT NULL COMMENT 'TAG名称',
  `authorId` bigint(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '发表时间',
  `checkState` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=689 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__tags` */

DROP TABLE IF EXISTS `uchome__tags`;

CREATE TABLE `uchome__tags` (
  `tagId` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `tagName` varchar(50) NOT NULL COMMENT 'Tag标签名称',
  `createTime` int(11) NOT NULL COMMENT 'Tag的创建日期',
  `isSystag` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否为系统tag',
  `isAvailable` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0不可用，1可用',
  PRIMARY KEY (`tagId`)
) ENGINE=MyISAM AUTO_INCREMENT=418 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__usergroup` */

DROP TABLE IF EXISTS `uchome__usergroup`;

CREATE TABLE `uchome__usergroup` (
  `gid` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `groupname` varchar(20) DEFAULT NULL COMMENT '用户组名称',
  `system` tinyint(1) DEFAULT '0' COMMENT '''-1''站点管理组,''1''特殊用户组,''0''普通用户组',
  `managearticle` tinyint(1) DEFAULT '0' COMMENT '是否允许审核文章',
  `manageusergroup` tinyint(1) DEFAULT '0' COMMENT '是否有用户组管理权限',
  `managemember` tinyint(1) DEFAULT '0' COMMENT '是否允许管理用户空间及审核',
  `managetag` tinyint(1) DEFAULT '0' COMMENT '是否允许管理tag',
  `managepic` tinyint(1) DEFAULT '0' COMMENT '是否允许管理图片',
  `managestat` tinyint(1) DEFAULT '0' COMMENT '是否允许查看站点统计',
  `managelog` tinyint(1) DEFAULT '0' COMMENT '是否允许管理日志',
  `managereply` tinyint(1) DEFAULT '0' COMMENT '是否允许管理评论',
  `dateline` int(11) DEFAULT '0' COMMENT '建立时间',
  `lastmodifytime` int(11) DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome__views` */

DROP TABLE IF EXISTS `uchome__views`;

CREATE TABLE `uchome__views` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '文章浏览记录ID',
  `articleId` int(10) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `ip` varchar(20) NOT NULL COMMENT 'IP',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '记录时间',
  PRIMARY KEY (`id`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=53318 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_ad` */

DROP TABLE IF EXISTS `uchome_ad`;

CREATE TABLE `uchome_ad` (
  `adid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(50) NOT NULL DEFAULT '',
  `pagetype` varchar(20) NOT NULL DEFAULT '',
  `adcode` text NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_adminsession` */

DROP TABLE IF EXISTS `uchome_adminsession`;

CREATE TABLE `uchome_adminsession` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `errorcount` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MEMORY DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_album` */

DROP TABLE IF EXISTS `uchome_album`;

CREATE TABLE `uchome_album` (
  `albumid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `albumname` varchar(50) NOT NULL DEFAULT '',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `picnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pic` varchar(60) NOT NULL DEFAULT '',
  `picflag` tinyint(1) NOT NULL DEFAULT '0',
  `friend` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(10) NOT NULL DEFAULT '',
  `target_ids` text NOT NULL,
  PRIMARY KEY (`albumid`),
  KEY `uid` (`uid`,`updatetime`),
  KEY `updatetime` (`updatetime`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_appcreditlog` */

DROP TABLE IF EXISTS `uchome_appcreditlog`;

CREATE TABLE `uchome_appcreditlog` (
  `logid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `appid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `appname` varchar(60) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `credit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_blacklist` */

DROP TABLE IF EXISTS `uchome_blacklist`;

CREATE TABLE `uchome_blacklist` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`buid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_block` */

DROP TABLE IF EXISTS `uchome_block`;

CREATE TABLE `uchome_block` (
  `bid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `blockname` varchar(40) NOT NULL DEFAULT '',
  `blocksql` text NOT NULL,
  `cachename` varchar(30) NOT NULL DEFAULT '',
  `cachetime` smallint(6) unsigned NOT NULL DEFAULT '0',
  `startnum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `perpage` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `htmlcode` text NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_blog` */

DROP TABLE IF EXISTS `uchome_blog`;

CREATE TABLE `uchome_blog` (
  `blogid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `subject` char(80) NOT NULL DEFAULT '',
  `classid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `viewnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `replynum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `pic` char(120) NOT NULL DEFAULT '',
  `picflag` tinyint(1) NOT NULL DEFAULT '0',
  `noreply` tinyint(1) NOT NULL DEFAULT '0',
  `friend` tinyint(1) NOT NULL DEFAULT '0',
  `password` char(10) NOT NULL DEFAULT '',
  `click_1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_2` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_3` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_4` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_5` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`blogid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_blogfield` */

DROP TABLE IF EXISTS `uchome_blogfield`;

CREATE TABLE `uchome_blogfield` (
  `blogid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(255) NOT NULL DEFAULT '',
  `message` mediumtext NOT NULL,
  `postip` varchar(20) NOT NULL DEFAULT '',
  `related` text NOT NULL,
  `relatedtime` int(10) unsigned NOT NULL DEFAULT '0',
  `target_ids` text NOT NULL,
  `hotuser` text NOT NULL,
  `magiccolor` tinyint(6) NOT NULL DEFAULT '0',
  `magicpaper` tinyint(6) NOT NULL DEFAULT '0',
  `magiccall` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blogid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_cache` */

DROP TABLE IF EXISTS `uchome_cache`;

CREATE TABLE `uchome_cache` (
  `cachekey` varchar(16) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `mtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cachekey`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_class` */

DROP TABLE IF EXISTS `uchome_class`;

CREATE TABLE `uchome_class` (
  `classid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `classname` char(40) NOT NULL DEFAULT '',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`classid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_click` */

DROP TABLE IF EXISTS `uchome_click`;

CREATE TABLE `uchome_click` (
  `clickid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(100) NOT NULL DEFAULT '',
  `idtype` varchar(15) NOT NULL DEFAULT '',
  `displayorder` tinyint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`clickid`),
  KEY `idtype` (`idtype`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_clickuser` */

DROP TABLE IF EXISTS `uchome_clickuser`;

CREATE TABLE `uchome_clickuser` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `idtype` varchar(15) NOT NULL DEFAULT '',
  `clickid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `id` (`id`,`idtype`,`dateline`),
  KEY `uid` (`uid`,`idtype`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_comment` */

DROP TABLE IF EXISTS `uchome_comment`;

CREATE TABLE `uchome_comment` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `idtype` varchar(20) NOT NULL DEFAULT '',
  `authorid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `author` varchar(25) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `magicflicker` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `authorid` (`authorid`,`idtype`),
  KEY `id` (`id`,`idtype`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_config` */

DROP TABLE IF EXISTS `uchome_config`;

CREATE TABLE `uchome_config` (
  `var` varchar(30) NOT NULL DEFAULT '',
  `datavalue` text NOT NULL,
  PRIMARY KEY (`var`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_creditlog` */

DROP TABLE IF EXISTS `uchome_creditlog`;

CREATE TABLE `uchome_creditlog` (
  `clid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `rid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `total` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cyclenum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `credit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `experience` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  `user` text NOT NULL,
  `app` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`clid`),
  KEY `uid` (`uid`,`rid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_creditrule` */

DROP TABLE IF EXISTS `uchome_creditrule`;

CREATE TABLE `uchome_creditrule` (
  `rid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rulename` char(20) NOT NULL DEFAULT '',
  `action` char(20) NOT NULL DEFAULT '',
  `cycletype` tinyint(1) NOT NULL DEFAULT '0',
  `cycletime` int(10) NOT NULL DEFAULT '0',
  `rewardnum` tinyint(2) NOT NULL DEFAULT '1',
  `rewardtype` tinyint(1) NOT NULL DEFAULT '1',
  `norepeat` tinyint(1) NOT NULL DEFAULT '0',
  `credit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `experience` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `action` (`action`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_cron` */

DROP TABLE IF EXISTS `uchome_cron`;

CREATE TABLE `uchome_cron` (
  `cronid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('user','system') NOT NULL DEFAULT 'user',
  `name` char(50) NOT NULL DEFAULT '',
  `filename` char(50) NOT NULL DEFAULT '',
  `lastrun` int(10) unsigned NOT NULL DEFAULT '0',
  `nextrun` int(10) unsigned NOT NULL DEFAULT '0',
  `weekday` tinyint(1) NOT NULL DEFAULT '0',
  `day` tinyint(2) NOT NULL DEFAULT '0',
  `hour` tinyint(2) NOT NULL DEFAULT '0',
  `minute` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`cronid`),
  KEY `nextrun` (`available`,`nextrun`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_data` */

DROP TABLE IF EXISTS `uchome_data`;

CREATE TABLE `uchome_data` (
  `var` varchar(20) NOT NULL DEFAULT '',
  `datavalue` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`var`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_docomment` */

DROP TABLE IF EXISTS `uchome_docomment`;

CREATE TABLE `uchome_docomment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upid` int(10) unsigned NOT NULL DEFAULT '0',
  `doid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `grade` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `doid` (`doid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_doing` */

DROP TABLE IF EXISTS `uchome_doing`;

CREATE TABLE `uchome_doing` (
  `doid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `from` varchar(20) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `replynum` int(10) unsigned NOT NULL DEFAULT '0',
  `mood` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`doid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_event` */

DROP TABLE IF EXISTS `uchome_event`;

CREATE TABLE `uchome_event` (
  `eventid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `classid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `province` varchar(20) NOT NULL DEFAULT '',
  `city` varchar(20) NOT NULL DEFAULT '',
  `location` varchar(80) NOT NULL DEFAULT '',
  `poster` varchar(60) NOT NULL DEFAULT '',
  `thumb` tinyint(1) NOT NULL DEFAULT '0',
  `remote` tinyint(1) NOT NULL DEFAULT '0',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `public` tinyint(3) NOT NULL DEFAULT '0',
  `membernum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `follownum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `viewnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `grade` tinyint(3) NOT NULL DEFAULT '0',
  `recommendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `picnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `threadnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventid`),
  KEY `grade` (`grade`,`recommendtime`),
  KEY `membernum` (`membernum`),
  KEY `uid` (`uid`,`eventid`),
  KEY `tagid` (`tagid`,`eventid`),
  KEY `topicid` (`topicid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_eventclass` */

DROP TABLE IF EXISTS `uchome_eventclass`;

CREATE TABLE `uchome_eventclass` (
  `classid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(80) NOT NULL DEFAULT '',
  `poster` tinyint(1) NOT NULL DEFAULT '0',
  `template` text NOT NULL,
  `displayorder` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`classid`),
  UNIQUE KEY `classname` (`classname`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_eventfield` */

DROP TABLE IF EXISTS `uchome_eventfield`;

CREATE TABLE `uchome_eventfield` (
  `eventid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `detail` text NOT NULL,
  `template` varchar(255) NOT NULL DEFAULT '',
  `limitnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `verify` tinyint(1) NOT NULL DEFAULT '0',
  `allowpic` tinyint(1) NOT NULL DEFAULT '0',
  `allowpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowinvite` tinyint(1) NOT NULL DEFAULT '0',
  `allowfellow` tinyint(1) NOT NULL DEFAULT '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY (`eventid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_eventinvite` */

DROP TABLE IF EXISTS `uchome_eventinvite`;

CREATE TABLE `uchome_eventinvite` (
  `eventid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `touid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tousername` char(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventid`,`touid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_eventpic` */

DROP TABLE IF EXISTS `uchome_eventpic`;

CREATE TABLE `uchome_eventpic` (
  `picid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `eventid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`picid`),
  KEY `eventid` (`eventid`,`picid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_feed` */

DROP TABLE IF EXISTS `uchome_feed`;

CREATE TABLE `uchome_feed` (
  `feedid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(30) NOT NULL DEFAULT '',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `friend` tinyint(1) NOT NULL DEFAULT '0',
  `hash_template` varchar(32) NOT NULL DEFAULT '',
  `hash_data` varchar(32) NOT NULL DEFAULT '',
  `title_template` text NOT NULL,
  `title_data` text NOT NULL,
  `body_template` text NOT NULL,
  `body_data` text NOT NULL,
  `body_general` text NOT NULL,
  `image_1` varchar(255) NOT NULL DEFAULT '',
  `image_1_link` varchar(255) NOT NULL DEFAULT '',
  `image_2` varchar(255) NOT NULL DEFAULT '',
  `image_2_link` varchar(255) NOT NULL DEFAULT '',
  `image_3` varchar(255) NOT NULL DEFAULT '',
  `image_3_link` varchar(255) NOT NULL DEFAULT '',
  `image_4` varchar(255) NOT NULL DEFAULT '',
  `image_4_link` varchar(255) NOT NULL DEFAULT '',
  `target_ids` text NOT NULL,
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `idtype` varchar(15) NOT NULL DEFAULT '',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `_uid` bigint(11) NOT NULL COMMENT '文章被评论人的UID',
  PRIMARY KEY (`feedid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `dateline` (`dateline`),
  KEY `hot` (`hot`),
  KEY `id` (`id`,`idtype`)
) ENGINE=MyISAM AUTO_INCREMENT=1729 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_friend` */

DROP TABLE IF EXISTS `uchome_friend`;

CREATE TABLE `uchome_friend` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fusername` varchar(25) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `gid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `note` varchar(50) NOT NULL DEFAULT '',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fuid`),
  KEY `fuid` (`fuid`),
  KEY `status` (`uid`,`status`,`num`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_friendguide` */

DROP TABLE IF EXISTS `uchome_friendguide`;

CREATE TABLE `uchome_friendguide` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fusername` varchar(25) NOT NULL DEFAULT '',
  `num` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fuid`),
  KEY `uid` (`uid`,`num`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_friendlog` */

DROP TABLE IF EXISTS `uchome_friendlog`;

CREATE TABLE `uchome_friendlog` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `action` varchar(10) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fuid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_invite` */

DROP TABLE IF EXISTS `uchome_invite`;

CREATE TABLE `uchome_invite` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `code` varchar(20) NOT NULL DEFAULT '',
  `fuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fusername` varchar(25) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `appid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_log` */

DROP TABLE IF EXISTS `uchome_log`;

CREATE TABLE `uchome_log` (
  `logid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `idtype` char(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_magic` */

DROP TABLE IF EXISTS `uchome_magic`;

CREATE TABLE `uchome_magic` (
  `mid` varchar(15) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `forbiddengid` text NOT NULL,
  `charge` smallint(6) unsigned NOT NULL DEFAULT '0',
  `experience` smallint(6) unsigned NOT NULL DEFAULT '0',
  `provideperoid` int(10) unsigned NOT NULL DEFAULT '0',
  `providecount` smallint(6) unsigned NOT NULL DEFAULT '0',
  `useperoid` int(10) unsigned NOT NULL DEFAULT '0',
  `usecount` smallint(6) unsigned NOT NULL DEFAULT '0',
  `displayorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `custom` text NOT NULL,
  `close` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_magicinlog` */

DROP TABLE IF EXISTS `uchome_magicinlog`;

CREATE TABLE `uchome_magicinlog` (
  `logid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `mid` varchar(15) NOT NULL DEFAULT '',
  `count` smallint(6) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fromid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `credit` smallint(6) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `type` (`type`,`fromid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_magicstore` */

DROP TABLE IF EXISTS `uchome_magicstore`;

CREATE TABLE `uchome_magicstore` (
  `mid` varchar(15) NOT NULL DEFAULT '',
  `storage` smallint(6) unsigned NOT NULL DEFAULT '0',
  `lastprovide` int(10) unsigned NOT NULL DEFAULT '0',
  `sellcount` int(8) unsigned NOT NULL DEFAULT '0',
  `sellcredit` int(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_magicuselog` */

DROP TABLE IF EXISTS `uchome_magicuselog`;

CREATE TABLE `uchome_magicuselog` (
  `logid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `mid` varchar(15) NOT NULL DEFAULT '',
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `idtype` varchar(20) NOT NULL DEFAULT '',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `expire` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`),
  KEY `uid` (`uid`,`mid`),
  KEY `id` (`id`,`idtype`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_mailcron` */

DROP TABLE IF EXISTS `uchome_mailcron`;

CREATE TABLE `uchome_mailcron` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `touid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `sendtime` (`sendtime`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_mailqueue` */

DROP TABLE IF EXISTS `uchome_mailqueue`;

CREATE TABLE `uchome_mailqueue` (
  `qid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `mcid` (`cid`,`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_member` */

DROP TABLE IF EXISTS `uchome_member`;

CREATE TABLE `uchome_member` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_mtag` */

DROP TABLE IF EXISTS `uchome_mtag`;

CREATE TABLE `uchome_mtag` (
  `tagid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tagname` varchar(40) NOT NULL DEFAULT '',
  `fieldid` smallint(6) NOT NULL DEFAULT '0',
  `membernum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `threadnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `postnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `close` tinyint(1) NOT NULL DEFAULT '0',
  `announcement` text NOT NULL,
  `pic` varchar(150) NOT NULL DEFAULT '',
  `closeapply` tinyint(1) NOT NULL DEFAULT '0',
  `joinperm` tinyint(1) NOT NULL DEFAULT '0',
  `viewperm` tinyint(1) NOT NULL DEFAULT '0',
  `threadperm` tinyint(1) NOT NULL DEFAULT '0',
  `postperm` tinyint(1) NOT NULL DEFAULT '0',
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `moderator` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`tagid`),
  KEY `tagname` (`tagname`),
  KEY `threadnum` (`threadnum`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_mtaginvite` */

DROP TABLE IF EXISTS `uchome_mtaginvite`;

CREATE TABLE `uchome_mtaginvite` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fromusername` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_myapp` */

DROP TABLE IF EXISTS `uchome_myapp`;

CREATE TABLE `uchome_myapp` (
  `appid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `appname` varchar(60) NOT NULL DEFAULT '',
  `narrow` tinyint(1) NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `version` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `displaymethod` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`appid`),
  KEY `flag` (`flag`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_myinvite` */

DROP TABLE IF EXISTS `uchome_myinvite`;

CREATE TABLE `uchome_myinvite` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(100) NOT NULL DEFAULT '',
  `appid` mediumint(8) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `fromuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `touid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `myml` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `hash` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`),
  KEY `uid` (`touid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_notification` */

DROP TABLE IF EXISTS `uchome_notification`;

CREATE TABLE `uchome_notification` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT '',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `authorid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `author` varchar(25) NOT NULL DEFAULT '',
  `note` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`new`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_pic` */

DROP TABLE IF EXISTS `uchome_pic`;

CREATE TABLE `uchome_pic` (
  `picid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `albumid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `postip` varchar(20) NOT NULL DEFAULT '',
  `filename` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `filepath` varchar(60) NOT NULL DEFAULT '',
  `thumb` tinyint(1) NOT NULL DEFAULT '0',
  `remote` tinyint(1) NOT NULL DEFAULT '0',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `click_6` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_7` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_8` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_9` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_10` smallint(6) unsigned NOT NULL DEFAULT '0',
  `magicframe` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`picid`),
  KEY `albumid` (`albumid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_picfield` */

DROP TABLE IF EXISTS `uchome_picfield`;

CREATE TABLE `uchome_picfield` (
  `picid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY (`picid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_poke` */

DROP TABLE IF EXISTS `uchome_poke`;

CREATE TABLE `uchome_poke` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fromuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fromusername` varchar(25) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `iconid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`fromuid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_poll` */

DROP TABLE IF EXISTS `uchome_poll`;

CREATE TABLE `uchome_poll` (
  `pid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `subject` char(80) NOT NULL DEFAULT '',
  `voternum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `replynum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  `maxchoice` tinyint(3) NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `noreply` tinyint(1) NOT NULL DEFAULT '0',
  `credit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `percredit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `lastvote` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `voternum` (`voternum`),
  KEY `dateline` (`dateline`),
  KEY `lastvote` (`lastvote`),
  KEY `hot` (`hot`),
  KEY `percredit` (`percredit`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_pollfield` */

DROP TABLE IF EXISTS `uchome_pollfield`;

CREATE TABLE `uchome_pollfield` (
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `summary` text NOT NULL,
  `option` text NOT NULL,
  `invite` text NOT NULL,
  `hotuser` text NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_polloption` */

DROP TABLE IF EXISTS `uchome_polloption`;

CREATE TABLE `uchome_polloption` (
  `oid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `votenum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `option` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`oid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_polluser` */

DROP TABLE IF EXISTS `uchome_polluser`;

CREATE TABLE `uchome_polluser` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `option` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`pid`),
  KEY `pid` (`pid`,`dateline`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_post` */

DROP TABLE IF EXISTS `uchome_post`;

CREATE TABLE `uchome_post` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `pic` varchar(255) NOT NULL DEFAULT '',
  `isthread` tinyint(1) NOT NULL DEFAULT '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `tid` (`tid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_profield` */

DROP TABLE IF EXISTS `uchome_profield`;

CREATE TABLE `uchome_profield` (
  `fieldid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `formtype` varchar(20) NOT NULL DEFAULT '0',
  `inputnum` smallint(3) unsigned NOT NULL DEFAULT '0',
  `choice` text NOT NULL,
  `mtagminnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `manualmoderator` tinyint(1) NOT NULL DEFAULT '0',
  `manualmember` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_profilefield` */

DROP TABLE IF EXISTS `uchome_profilefield`;

CREATE TABLE `uchome_profilefield` (
  `fieldid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `formtype` varchar(20) NOT NULL DEFAULT '0',
  `maxsize` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `invisible` tinyint(1) NOT NULL DEFAULT '0',
  `allowsearch` tinyint(1) NOT NULL DEFAULT '0',
  `choice` text NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_report` */

DROP TABLE IF EXISTS `uchome_report`;

CREATE TABLE `uchome_report` (
  `rid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `idtype` varchar(15) NOT NULL DEFAULT '',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `num` smallint(6) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  `uids` text NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `id` (`id`,`idtype`,`num`,`dateline`),
  KEY `new` (`new`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_session` */

DROP TABLE IF EXISTS `uchome_session`;

CREATE TABLE `uchome_session` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `magichidden` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `lastactivity` (`lastactivity`),
  KEY `ip` (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_share` */

DROP TABLE IF EXISTS `uchome_share`;

CREATE TABLE `uchome_share` (
  `sid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT '',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `title_template` text NOT NULL,
  `body_template` text NOT NULL,
  `body_data` text NOT NULL,
  `body_general` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `image_link` varchar(255) NOT NULL DEFAULT '',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `hot` (`hot`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_show` */

DROP TABLE IF EXISTS `uchome_show`;

CREATE TABLE `uchome_show` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `credit` (`credit`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_space` */

DROP TABLE IF EXISTS `uchome_space`;

CREATE TABLE `uchome_space` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `groupid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `experience` int(10) NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `name` char(20) NOT NULL DEFAULT '',
  `namestatus` tinyint(1) NOT NULL DEFAULT '0',
  `videostatus` tinyint(1) NOT NULL DEFAULT '0',
  `domain` char(15) NOT NULL DEFAULT '',
  `friendnum` int(10) unsigned NOT NULL DEFAULT '0',
  `viewnum` int(10) unsigned NOT NULL DEFAULT '0',
  `notenum` int(10) unsigned NOT NULL DEFAULT '0',
  `addfriendnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `mtaginvitenum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `eventinvitenum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `myinvitenum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pokenum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `doingnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `blognum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `albumnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `threadnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pollnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `eventnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sharenum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastsearch` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  `lastsend` int(10) unsigned NOT NULL DEFAULT '0',
  `attachsize` int(10) unsigned NOT NULL DEFAULT '0',
  `addsize` int(10) unsigned NOT NULL DEFAULT '0',
  `addfriend` smallint(6) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `newpm` smallint(6) unsigned NOT NULL DEFAULT '0',
  `avatar` tinyint(1) NOT NULL DEFAULT '0',
  `regip` char(15) NOT NULL DEFAULT '',
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `mood` smallint(6) unsigned NOT NULL DEFAULT '0',
  `_isGeek` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否极客用户',
  `_articleNum` bigint(11) NOT NULL DEFAULT '0' COMMENT '极客发表文章的数量',
  `_viewNum` bigint(11) NOT NULL DEFAULT '0' COMMENT '极客阅读文章的数量',
  `_replyNum` bigint(11) NOT NULL DEFAULT '0' COMMENT '极客评论的数量',
  `_up` bigint(11) NOT NULL DEFAULT '0' COMMENT '极客顶的次数',
  `_down` bigint(11) NOT NULL DEFAULT '0' COMMENT '极客踩的次数',
  `_commentsNum` bigint(11) NOT NULL DEFAULT '0' COMMENT '极客用户文章被评论总数',
  `_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户是否被删除，1为未删除，-1为删除, -2为禁止用户发文章和评论',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `domain` (`domain`),
  KEY `ip` (`ip`),
  KEY `updatetime` (`updatetime`),
  KEY `mood` (`mood`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_spacefield` */

DROP TABLE IF EXISTS `uchome_spacefield`;

CREATE TABLE `uchome_spacefield` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '',
  `newemail` varchar(100) NOT NULL DEFAULT '',
  `emailcheck` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` varchar(40) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `msn` varchar(80) NOT NULL DEFAULT '',
  `msnrobot` varchar(15) NOT NULL DEFAULT '',
  `msncstatus` tinyint(1) NOT NULL DEFAULT '0',
  `videopic` varchar(32) NOT NULL DEFAULT '',
  `birthyear` smallint(6) unsigned NOT NULL DEFAULT '0',
  `birthmonth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `birthday` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `blood` varchar(5) NOT NULL DEFAULT '',
  `marry` tinyint(1) NOT NULL DEFAULT '0',
  `birthprovince` varchar(20) NOT NULL DEFAULT '',
  `birthcity` varchar(20) NOT NULL DEFAULT '',
  `resideprovince` varchar(20) NOT NULL DEFAULT '',
  `residecity` varchar(20) NOT NULL DEFAULT '',
  `note` text NOT NULL,
  `spacenote` text NOT NULL,
  `authstr` varchar(20) NOT NULL DEFAULT '',
  `theme` varchar(20) NOT NULL DEFAULT '',
  `nocss` tinyint(1) NOT NULL DEFAULT '0',
  `menunum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `css` text NOT NULL,
  `privacy` text NOT NULL,
  `friend` mediumtext NOT NULL,
  `feedfriend` mediumtext NOT NULL,
  `sendmail` text NOT NULL,
  `magicstar` tinyint(1) NOT NULL DEFAULT '0',
  `magicexpire` int(10) unsigned NOT NULL DEFAULT '0',
  `timeoffset` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_spaceinfo` */

DROP TABLE IF EXISTS `uchome_spaceinfo`;

CREATE TABLE `uchome_spaceinfo` (
  `infoid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT '',
  `subtype` varchar(20) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `subtitle` varchar(255) NOT NULL DEFAULT '',
  `friend` tinyint(1) NOT NULL DEFAULT '0',
  `startyear` smallint(6) unsigned NOT NULL DEFAULT '0',
  `endyear` smallint(6) unsigned NOT NULL DEFAULT '0',
  `startmonth` smallint(6) unsigned NOT NULL DEFAULT '0',
  `endmonth` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`infoid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=601 DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_spacelog` */

DROP TABLE IF EXISTS `uchome_spacelog`;

CREATE TABLE `uchome_spacelog` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `opuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `opusername` varchar(25) NOT NULL DEFAULT '',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_stat` */

DROP TABLE IF EXISTS `uchome_stat`;

CREATE TABLE `uchome_stat` (
  `daytime` int(10) unsigned NOT NULL DEFAULT '0',
  `login` smallint(6) unsigned NOT NULL DEFAULT '0',
  `register` smallint(6) unsigned NOT NULL DEFAULT '0',
  `invite` smallint(6) unsigned NOT NULL DEFAULT '0',
  `appinvite` smallint(6) unsigned NOT NULL DEFAULT '0',
  `doing` smallint(6) unsigned NOT NULL DEFAULT '0',
  `blog` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pic` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll` smallint(6) unsigned NOT NULL DEFAULT '0',
  `event` smallint(6) unsigned NOT NULL DEFAULT '0',
  `share` smallint(6) unsigned NOT NULL DEFAULT '0',
  `thread` smallint(6) unsigned NOT NULL DEFAULT '0',
  `docomment` smallint(6) unsigned NOT NULL DEFAULT '0',
  `blogcomment` smallint(6) unsigned NOT NULL DEFAULT '0',
  `piccomment` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pollcomment` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pollvote` smallint(6) unsigned NOT NULL DEFAULT '0',
  `eventcomment` smallint(6) unsigned NOT NULL DEFAULT '0',
  `eventjoin` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sharecomment` smallint(6) unsigned NOT NULL DEFAULT '0',
  `post` smallint(6) unsigned NOT NULL DEFAULT '0',
  `wall` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poke` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`daytime`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_statuser` */

DROP TABLE IF EXISTS `uchome_statuser`;

CREATE TABLE `uchome_statuser` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `daytime` int(10) unsigned NOT NULL DEFAULT '0',
  `type` char(20) NOT NULL DEFAULT '',
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_tag` */

DROP TABLE IF EXISTS `uchome_tag`;

CREATE TABLE `uchome_tag` (
  `tagid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tagname` char(30) NOT NULL DEFAULT '',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `blognum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `close` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tagid`),
  KEY `tagname` (`tagname`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_tagblog` */

DROP TABLE IF EXISTS `uchome_tagblog`;

CREATE TABLE `uchome_tagblog` (
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `blogid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tagid`,`blogid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_tagspace` */

DROP TABLE IF EXISTS `uchome_tagspace`;

CREATE TABLE `uchome_tagspace` (
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `grade` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tagid`,`uid`),
  KEY `grade` (`tagid`,`grade`),
  KEY `uid` (`uid`,`grade`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_task` */

DROP TABLE IF EXISTS `uchome_task`;

CREATE TABLE `uchome_task` (
  `taskid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `note` text NOT NULL,
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `maxnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `image` varchar(150) NOT NULL DEFAULT '',
  `filename` varchar(50) NOT NULL DEFAULT '',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `nexttime` int(10) unsigned NOT NULL DEFAULT '0',
  `nexttype` varchar(20) NOT NULL DEFAULT '',
  `credit` smallint(6) NOT NULL DEFAULT '0',
  `displayorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`taskid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_thread` */

DROP TABLE IF EXISTS `uchome_thread`;

CREATE TABLE `uchome_thread` (
  `tid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `eventid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` char(80) NOT NULL DEFAULT '',
  `magiccolor` tinyint(6) unsigned NOT NULL DEFAULT '0',
  `magicegg` tinyint(6) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `viewnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `replynum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastauthor` varchar(25) NOT NULL DEFAULT '',
  `lastauthorid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `digest` tinyint(1) NOT NULL DEFAULT '0',
  `hot` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `click_11` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_12` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_13` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_14` smallint(6) unsigned NOT NULL DEFAULT '0',
  `click_15` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `tagid` (`tagid`,`displayorder`,`lastpost`),
  KEY `uid` (`uid`,`lastpost`),
  KEY `lastpost` (`lastpost`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `eventid` (`eventid`,`lastpost`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_topic` */

DROP TABLE IF EXISTS `uchome_topic`;

CREATE TABLE `uchome_topic` (
  `topicid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `subject` varchar(80) NOT NULL DEFAULT '',
  `message` mediumtext NOT NULL,
  `jointype` varchar(255) NOT NULL DEFAULT '',
  `joingid` varchar(255) NOT NULL DEFAULT '',
  `pic` varchar(100) NOT NULL DEFAULT '',
  `thumb` tinyint(1) NOT NULL DEFAULT '0',
  `remote` tinyint(1) NOT NULL DEFAULT '0',
  `joinnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`topicid`),
  KEY `lastpost` (`lastpost`),
  KEY `joinnum` (`joinnum`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_topicuser` */

DROP TABLE IF EXISTS `uchome_topicuser`;

CREATE TABLE `uchome_topicuser` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `topicid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_userapp` */

DROP TABLE IF EXISTS `uchome_userapp`;

CREATE TABLE `uchome_userapp` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `appid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `appname` varchar(60) NOT NULL DEFAULT '',
  `privacy` tinyint(1) NOT NULL DEFAULT '0',
  `allowsidenav` tinyint(1) NOT NULL DEFAULT '0',
  `allowfeed` tinyint(1) NOT NULL DEFAULT '0',
  `allowprofilelink` tinyint(1) NOT NULL DEFAULT '0',
  `narrow` tinyint(1) NOT NULL DEFAULT '0',
  `menuorder` smallint(6) NOT NULL DEFAULT '0',
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`,`appid`),
  KEY `menuorder` (`uid`,`menuorder`),
  KEY `displayorder` (`uid`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_userappfield` */

DROP TABLE IF EXISTS `uchome_userappfield`;

CREATE TABLE `uchome_userappfield` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `appid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `profilelink` text NOT NULL,
  `myml` text NOT NULL,
  KEY `uid` (`uid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_userevent` */

DROP TABLE IF EXISTS `uchome_userevent`;

CREATE TABLE `uchome_userevent` (
  `eventid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(15) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `fellow` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `template` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`eventid`,`uid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `eventid` (`eventid`,`status`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_usergroup` */

DROP TABLE IF EXISTS `uchome_usergroup`;

CREATE TABLE `uchome_usergroup` (
  `gid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `grouptitle` varchar(20) NOT NULL DEFAULT '',
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `banvisit` tinyint(1) NOT NULL DEFAULT '0',
  `explower` int(10) NOT NULL DEFAULT '0',
  `maxfriendnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `maxattachsize` int(10) unsigned NOT NULL DEFAULT '0',
  `allowhtml` tinyint(1) NOT NULL DEFAULT '0',
  `allowcomment` tinyint(1) NOT NULL DEFAULT '0',
  `searchinterval` smallint(6) unsigned NOT NULL DEFAULT '0',
  `searchignore` tinyint(1) NOT NULL DEFAULT '0',
  `postinterval` smallint(6) unsigned NOT NULL DEFAULT '0',
  `spamignore` tinyint(1) NOT NULL DEFAULT '0',
  `videophotoignore` tinyint(1) NOT NULL DEFAULT '0',
  `allowblog` tinyint(1) NOT NULL DEFAULT '0',
  `allowdoing` tinyint(1) NOT NULL DEFAULT '0',
  `allowupload` tinyint(1) NOT NULL DEFAULT '0',
  `allowshare` tinyint(1) NOT NULL DEFAULT '0',
  `allowmtag` tinyint(1) NOT NULL DEFAULT '0',
  `allowthread` tinyint(1) NOT NULL DEFAULT '0',
  `allowpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowcss` tinyint(1) NOT NULL DEFAULT '0',
  `allowpoke` tinyint(1) NOT NULL DEFAULT '0',
  `allowfriend` tinyint(1) NOT NULL DEFAULT '0',
  `allowpoll` tinyint(1) NOT NULL DEFAULT '0',
  `allowclick` tinyint(1) NOT NULL DEFAULT '0',
  `allowevent` tinyint(1) NOT NULL DEFAULT '0',
  `allowmagic` tinyint(1) NOT NULL DEFAULT '0',
  `allowpm` tinyint(1) NOT NULL DEFAULT '0',
  `allowviewvideopic` tinyint(1) NOT NULL DEFAULT '0',
  `allowmyop` tinyint(1) NOT NULL DEFAULT '0',
  `allowtopic` tinyint(1) NOT NULL DEFAULT '0',
  `allowstat` tinyint(1) NOT NULL DEFAULT '0',
  `magicdiscount` tinyint(1) NOT NULL DEFAULT '0',
  `verifyevent` tinyint(1) NOT NULL DEFAULT '0',
  `edittrail` tinyint(1) NOT NULL DEFAULT '0',
  `domainlength` smallint(6) unsigned NOT NULL DEFAULT '0',
  `closeignore` tinyint(1) NOT NULL DEFAULT '0',
  `seccode` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(10) NOT NULL DEFAULT '',
  `icon` varchar(100) NOT NULL DEFAULT '',
  `manageconfig` tinyint(1) NOT NULL DEFAULT '0',
  `managenetwork` tinyint(1) NOT NULL DEFAULT '0',
  `manageprofilefield` tinyint(1) NOT NULL DEFAULT '0',
  `manageprofield` tinyint(1) NOT NULL DEFAULT '0',
  `manageusergroup` tinyint(1) NOT NULL DEFAULT '0',
  `managefeed` tinyint(1) NOT NULL DEFAULT '0',
  `manageshare` tinyint(1) NOT NULL DEFAULT '0',
  `managedoing` tinyint(1) NOT NULL DEFAULT '0',
  `manageblog` tinyint(1) NOT NULL DEFAULT '0',
  `managetag` tinyint(1) NOT NULL DEFAULT '0',
  `managetagtpl` tinyint(1) NOT NULL DEFAULT '0',
  `managealbum` tinyint(1) NOT NULL DEFAULT '0',
  `managecomment` tinyint(1) NOT NULL DEFAULT '0',
  `managemtag` tinyint(1) NOT NULL DEFAULT '0',
  `managethread` tinyint(1) NOT NULL DEFAULT '0',
  `manageevent` tinyint(1) NOT NULL DEFAULT '0',
  `manageeventclass` tinyint(1) NOT NULL DEFAULT '0',
  `managecensor` tinyint(1) NOT NULL DEFAULT '0',
  `managead` tinyint(1) NOT NULL DEFAULT '0',
  `managesitefeed` tinyint(1) NOT NULL DEFAULT '0',
  `managebackup` tinyint(1) NOT NULL DEFAULT '0',
  `manageblock` tinyint(1) NOT NULL DEFAULT '0',
  `managetemplate` tinyint(1) NOT NULL DEFAULT '0',
  `managestat` tinyint(1) NOT NULL DEFAULT '0',
  `managecache` tinyint(1) NOT NULL DEFAULT '0',
  `managecredit` tinyint(1) NOT NULL DEFAULT '0',
  `managecron` tinyint(1) NOT NULL DEFAULT '0',
  `managename` tinyint(1) NOT NULL DEFAULT '0',
  `manageapp` tinyint(1) NOT NULL DEFAULT '0',
  `managetask` tinyint(1) NOT NULL DEFAULT '0',
  `managereport` tinyint(1) NOT NULL DEFAULT '0',
  `managepoll` tinyint(1) NOT NULL DEFAULT '0',
  `manageclick` tinyint(1) NOT NULL DEFAULT '0',
  `managemagic` tinyint(1) NOT NULL DEFAULT '0',
  `managemagiclog` tinyint(1) NOT NULL DEFAULT '0',
  `managebatch` tinyint(1) NOT NULL DEFAULT '0',
  `managedelspace` tinyint(1) NOT NULL DEFAULT '0',
  `managetopic` tinyint(1) NOT NULL DEFAULT '0',
  `manageip` tinyint(1) NOT NULL DEFAULT '0',
  `managehotuser` tinyint(1) NOT NULL DEFAULT '0',
  `managedefaultuser` tinyint(1) NOT NULL DEFAULT '0',
  `managespacegroup` tinyint(1) NOT NULL DEFAULT '0',
  `managespaceinfo` tinyint(1) NOT NULL DEFAULT '0',
  `managespacecredit` tinyint(1) NOT NULL DEFAULT '0',
  `managespacenote` tinyint(1) NOT NULL DEFAULT '0',
  `managevideophoto` tinyint(1) NOT NULL DEFAULT '0',
  `managelog` tinyint(1) NOT NULL DEFAULT '0',
  `magicaward` text NOT NULL,
  `managereply` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_userlog` */

DROP TABLE IF EXISTS `uchome_userlog`;

CREATE TABLE `uchome_userlog` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `action` char(10) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_usermagic` */

DROP TABLE IF EXISTS `uchome_usermagic`;

CREATE TABLE `uchome_usermagic` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `mid` varchar(15) NOT NULL DEFAULT '',
  `count` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_usertask` */

DROP TABLE IF EXISTS `uchome_usertask`;

CREATE TABLE `uchome_usertask` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL DEFAULT '',
  `taskid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `credit` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `isignore` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`taskid`),
  KEY `isignore` (`isignore`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `uchome_visitor` */

DROP TABLE IF EXISTS `uchome_visitor`;

CREATE TABLE `uchome_visitor` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `vuid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `vusername` varchar(25) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`vuid`),
  KEY `dateline` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*Table structure for table `common_article_list` */

DROP TABLE IF EXISTS `common_article_list`;

/*!50001 DROP VIEW IF EXISTS `common_article_list` */;
/*!50001 DROP TABLE IF EXISTS `common_article_list` */;

/*!50001 CREATE TABLE `common_article_list` (
  `articleId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章编号',
  `authorId` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `authorName` varchar(20) NOT NULL COMMENT '用户名',
  `title` varchar(200) NOT NULL COMMENT '文章标题',
  `publishTime` int(11) NOT NULL COMMENT '发布时间',
  `viewnum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章浏览次数',
  `replynum` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章评论次数',
  `click_up` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章顶的次数',
  `click_down` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章踩的次数',
  `summary` text COMMENT '文章简介',
  `content` text COMMENT '文章内容',
  `articleTypeId` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章类型编号'
) ENGINE=MyISAM DEFAULT CHARSET=gbk */;

/*View structure for view common_article_list */

/*!50001 DROP TABLE IF EXISTS `common_article_list` */;
/*!50001 DROP VIEW IF EXISTS `common_article_list` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`ijeek`@`10.168.%.%` SQL SECURITY DEFINER VIEW `common_article_list` AS select `a`.`articleId` AS `articleId`,`a`.`authorId` AS `authorId`,`a`.`authorName` AS `authorName`,`a`.`title` AS `title`,`a`.`publishTime` AS `publishTime`,`a`.`viewnum` AS `viewnum`,`a`.`replynum` AS `replynum`,`a`.`click_up` AS `click_up`,`a`.`click_down` AS `click_down`,`ac`.`summary` AS `summary`,`ac`.`content` AS `content`,`a`.`articleTypeId` AS `articleTypeId` from (`uchome__articles` `a` left join `uchome__articleContent` `ac` on((`a`.`articleId` = `ac`.`articleId`))) where ((`a`.`isReleased` = 1) and (`a`.`isAvailable` = 1) and (`a`.`checkState` = 1) and (`a`.`isPush` = 1) and (`a`.`publishTime` <= 1293093594)) order by `a`.`publishTime` desc limit 0,9 */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
