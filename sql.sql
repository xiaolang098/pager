CREATE TABLE `member` (
 `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '�û�id',
 `email` varchar(30) NOT NULL DEFAULT '' COMMENT '����',
 `password` varchar(32) NOT NULL DEFAULT '',
 `name` varchar(50) NOT NULL DEFAULT '' COMMENT '��ʵ����',
 `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '�û��ǳ� ',
 `lastlogin` int(11) NOT NULL DEFAULT '0' COMMENT '����¼��ʱ��',
 `ip` varchar(20) NOT NULL DEFAULT '' COMMENT '��¼ip��ַ',
 `portrait` varchar(150) NOT NULL DEFAULT '' COMMENT 'ͷ��',
 `portrait_s` varchar(150) NOT NULL DEFAULT '' COMMENT 'Сͷ��',
 `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '����',
 `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '�û�����',
 `isactive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '�Ƿ񼤻�',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=gbk