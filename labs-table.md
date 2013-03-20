CREATE TABLE `labs_user` (
  `userid` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(50) NOT NULL COMMENT '管理员名称',
  `userpassword` varchar(32) NOT NULL COMMENT '管理员密码',
  `userpower` int(1) unsigned NOT NULL COMMENT '管理员权限',
  `loginip` varchar(30) DEFAULT NULL COMMENT '登录IP',
  `lastlogintime` int(10) unsigned DEFAULT NULL COMMENT '最后登录时间',
  `logincount` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='管理员表';

CREATE TABLE `labs_setting` (
  `item` int(3) unsigned NOT NULL COMMENT 'settingID',
  `item_key` varchar(50) NOT NULL COMMENT 'setting键',
  `item_value` varchar(70) NOT NULL COMMENT 'setting值'
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='设置表';

CREATE TABLE `labs_application` (
 `id` int(3) unsigned NOT NULL AUTO_INCREMENT  COMMENT 'id',
 `name` varchar(70) NOT NULL COMMENT '名称',
 `url` varchar(170) NOT NULL COMMENT 'url',
 `author` varchar(70) NOT NULL COMMENT '作者',
 `phone` varchar(70) NOT NULL COMMENT '联系方式',
 `intro` varchar(300) DEFAULT NULL COMMENT '应用简介',
  `remarks` varchar(300) DEFAULT NULL COMMENT '备注',
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='应用表';

CREATE TABLE `labs_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `name`  varchar(70) NOT NULL COMMENT '；名字',
  `email`  varchar(70) NOT NULL COMMENT '；email',
  `posttime` int(10) unsigned NOT NULL COMMENT '；评论时间',
  `comment` varchar(300) DEFAULT NULL COMMENT '评论',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='评论表';


####hacker
create table news(
    id int not null auto_increment primary key,
    title varchar(70) not null,
    news text not null
);
create table users(
    id int not null auto_increment primary key,
    username varchar(70) not null,
    password varchar(70) not null
);

insert into news values('19920618','恭喜你通过第一关','下一关的地 址在<a href="./admin-auth/index.php">这里</a>');

insert into users values('1','suzie','123456');