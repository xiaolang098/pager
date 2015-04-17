CREATE TABLE `member` (
 `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
 `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
 `password` varchar(32) NOT NULL DEFAULT '',
 `name` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
 `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称 ',
 `lastlogin` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录的时间',
 `ip` varchar(20) NOT NULL DEFAULT '' COMMENT '登录ip地址',
 `portrait` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
 `portrait_s` varchar(150) NOT NULL DEFAULT '' COMMENT '小头像',
 `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '域名',
 `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户类型',
 `isactive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否激活',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=gbk