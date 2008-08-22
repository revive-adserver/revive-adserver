-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.51a-3ubuntu5.1-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema openx2011pr1mysqlto26x
--

-- CREATE DATABASE IF NOT EXISTS openx2011pr1mysqlto26x;
-- USE openx2011pr1mysqlto26x;

CREATE TABLE `ox_acls` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `logical` set('and','or') NOT NULL,
  `type` varchar(16) NOT NULL,
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `bannerid_executionorder` (`bannerid`,`executionorder`),
  KEY `bannerid` (`bannerid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_adclicks` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `zoneid` mediumint(9) NOT NULL default '0',
  `t_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `host` varchar(255) NOT NULL,
  `source` varchar(50) NOT NULL,
  `country` char(2) NOT NULL,
  KEY `bannerid_date` (`bannerid`,`t_stamp`),
  KEY `date` (`t_stamp`),
  KEY `zoneid` (`zoneid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_adstats` (
  `views` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `day` date NOT NULL default '0000-00-00',
  `hour` tinyint(4) NOT NULL default '0',
  `bannerid` smallint(6) NOT NULL default '0',
  `zoneid` smallint(6) NOT NULL default '0',
  `source` varchar(50) NOT NULL,
  PRIMARY KEY  (`day`,`hour`,`bannerid`,`zoneid`,`source`),
  KEY `bannerid_day` (`bannerid`,`day`),
  KEY `zoneid` (`zoneid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_adviews` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `zoneid` mediumint(9) NOT NULL default '0',
  `t_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `host` varchar(255) NOT NULL,
  `source` varchar(50) NOT NULL,
  `country` char(2) NOT NULL,
  KEY `bannerid_date` (`bannerid`,`t_stamp`),
  KEY `date` (`t_stamp`),
  KEY `zoneid` (`zoneid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_affiliates` (
  `affiliateid` mediumint(9) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL,
  `website` varchar(255) default NULL,
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `publiczones` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`affiliateid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `ox_affiliates` (`affiliateid`,`name`,`contact`,`email`,`website`,`username`,`password`,`permissions`,`language`,`publiczones`) VALUES 
 (1,'Agency Publisher 1','Andrew Hill','andrew.hill@openads.org','http://fornax.net','publisher','52aded165360352a0f5857571d96d68f',31,'','f');
CREATE TABLE `ox_banners` (
  `bannerid` mediumint(9) NOT NULL auto_increment,
  `clientid` mediumint(9) NOT NULL default '0',
  `active` enum('t','f') NOT NULL default 't',
  `priority` int(11) NOT NULL default '0',
  `contenttype` enum('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') NOT NULL default 'gif',
  `pluginversion` mediumint(9) NOT NULL default '0',
  `storagetype` enum('sql','web','url','html','network','txt') NOT NULL default 'sql',
  `filename` varchar(255) NOT NULL,
  `imageurl` varchar(255) NOT NULL,
  `htmltemplate` blob NOT NULL,
  `htmlcache` blob NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `weight` tinyint(4) NOT NULL default '1',
  `seq` tinyint(4) NOT NULL default '0',
  `target` varchar(24) NOT NULL,
  `url` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `bannertext` blob NOT NULL,
  `description` varchar(255) NOT NULL,
  `autohtml` enum('t','f') NOT NULL default 't',
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `compiledlimitation` blob NOT NULL,
  `append` blob NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `bannertype` tinyint(4) NOT NULL default '0',
  `transparent` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`bannerid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO `ox_banners` (`bannerid`,`clientid`,`active`,`priority`,`contenttype`,`pluginversion`,`storagetype`,`filename`,`imageurl`,`htmltemplate`,`htmlcache`,`width`,`height`,`weight`,`seq`,`target`,`url`,`alt`,`status`,`keyword`,`bannertext`,`description`,`autohtml`,`block`,`capping`,`compiledlimitation`,`append`,`appendtype`,`bannertype`,`transparent`) VALUES 
 (1,2,'t',0,'html',0,'html','','',0x546573742048544D4C2042616E6E657221,0x546573742048544D4C2042616E6E657221,468,60,1,0,'','','','','','','Test HTML Banner!','t',0,0,0x74727565,'',0,0,'f'),
 (2,3,'t',1,'html',0,'html','','',0x68746D6C20746573742062616E6E6572,0x3C6120687265663D277B75726C5F7072656669787D2F6164636C69636B2E7068703F62616E6E657269643D7B62616E6E657269647D26616D703B7A6F6E6569643D7B7A6F6E6569647D26616D703B736F757263653D7B736F757263657D26616D703B69736D61703D27207461726765743D277B7461726765747D273E68746D6C20746573742062616E6E65723C2F613E,468,60,1,0,'','https://developer.openx.org/','','','','','test banner','t',0,0,0x74727565,'',0,0,'f'),
 (3,4,'t',1,'gif',0,'sql','468x60.gif','{url_prefix}/adimage.php?filename=468x60.gif&amp;contenttype=gif',0x5B74617267657475726C5D3C6120687265663D277B74617267657475726C7D27207461726765743D277B7461726765747D275B7374617475735D206F6E4D6F7573654F7665723D2273656C662E7374617475733D277B7374617475737D273B2072657475726E20747275653B22206F6E4D6F7573654F75743D2273656C662E7374617475733D27273B72657475726E20747275653B225B2F7374617475735D3E5B2F74617267657475726C5D3C696D67207372633D277B696D61676575726C7D272077696474683D277B77696474687D27206865696768743D277B6865696768747D2720616C743D277B616C747D27207469746C653D277B616C747D2720626F726465723D2730275B6E6F75726C5D5B7374617475735D206F6E4D6F7573654F7665723D2273656C662E7374617475733D277B7374617475737D273B2072657475726E20747275653B22206F6E4D6F7573654F75743D2273656C662E7374617475733D27273B72657475726E20747275653B225B2F7374617475735D5B2F6E6F75726C5D3E5B74617267657475726C5D3C2F613E5B2F74617267657475726C5D5B62616E6E6572746578745D3C62723E5B74617267657475726C5D3C6120687265663D277B74617267657475726C7D27207461726765743D277B7461726765747D275B7374617475735D206F6E4D6F7573654F7665723D2273656C662E7374617475733D277B7374617475737D273B2072657475726E20747275653B22206F6E4D6F7573654F75743D2273656C662E7374617475733D27273B72657475726E20747275653B225B2F7374617475735D3E5B2F74617267657475726C5D7B62616E6E6572746578747D5B74617267657475726C5D3C2F613E5B2F74617267657475726C5D5B2F62616E6E6572746578745D,0x3C6120687265663D277B75726C5F7072656669787D2F6164636C69636B2E7068703F62616E6E657269643D7B62616E6E657269647D26616D703B7A6F6E6569643D7B7A6F6E6569647D26616D703B736F757263653D7B736F757263657D26616D703B646573743D6874747073253341253246253246646576656C6F7065722E6F70656E782E6F726725324627207461726765743D277B7461726765747D273E3C696D67207372633D277B75726C5F7072656669787D2F6164696D6167652E7068703F66696C656E616D653D3436387836302E67696626616D703B636F6E74656E74747970653D676966272077696474683D2734363827206865696768743D2736302720616C743D27616C74207465787427207469746C653D27616C7420746578742720626F726465723D2730273E3C2F613E,468,60,1,0,'','https://developer.openx.org/','alt text','','','','sample gif banner','t',0,0,0x74727565,'',0,0,'f');
CREATE TABLE `ox_cache` (
  `cacheid` varchar(255) NOT NULL,
  `content` blob NOT NULL,
  PRIMARY KEY  (`cacheid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_clients` (
  `clientid` mediumint(9) NOT NULL auto_increment,
  `clientname` varchar(255) NOT NULL,
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL,
  `views` int(11) default NULL,
  `clicks` int(11) default NULL,
  `clientusername` varchar(64) NOT NULL,
  `clientpassword` varchar(64) NOT NULL,
  `expire` date default '0000-00-00',
  `activate` date default '0000-00-00',
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `active` enum('t','f') NOT NULL default 't',
  `weight` tinyint(4) NOT NULL default '1',
  `target` int(11) NOT NULL default '0',
  `parent` mediumint(9) NOT NULL default '0',
  `report` enum('t','f') NOT NULL default 't',
  `reportinterval` mediumint(9) NOT NULL default '7',
  `reportlastdate` date NOT NULL default '0000-00-00',
  `reportdeactivate` enum('t','f') NOT NULL default 't',
  PRIMARY KEY  (`clientid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
INSERT INTO `ox_clients` (`clientid`,`clientname`,`contact`,`email`,`views`,`clicks`,`clientusername`,`clientpassword`,`expire`,`activate`,`permissions`,`language`,`active`,`weight`,`target`,`parent`,`report`,`reportinterval`,`reportlastdate`,`reportdeactivate`) VALUES 
 (1,'Advertiser 1','advertiser','example@example.com',NULL,NULL,'advertiser','02452e3484c42211b1c2884ad9b60c93','0000-00-00','0000-00-00',25,'','t',1,0,0,'t',7,'2008-08-05','t'),
 (2,'Advertiser 1 - Default Campaign',NULL,'',-1,-1,'','','2008-07-01','0000-00-00',NULL,NULL,'f',1,0,1,'t',7,'0000-00-00','t'),
 (3,'test campaign',NULL,'',-1,-1,'','','0000-00-00','0000-00-00',NULL,NULL,'t',1,0,1,'t',7,'0000-00-00','t'),
 (4,'campaign 2 (gif)',NULL,'',-1,-1,'','','0000-00-00','0000-00-00',NULL,NULL,'t',1,0,1,'t',7,'0000-00-00','t');
CREATE TABLE `ox_config` (
  `configid` tinyint(2) NOT NULL default '0',
  `config_version` decimal(7,3) NOT NULL default '0.000',
  `instance_id` varchar(64) NOT NULL default '',
  `table_border_color` varchar(7) NOT NULL default '#000099',
  `table_back_color` varchar(7) NOT NULL default '#CCCCCC',
  `table_back_color_alternative` varchar(7) NOT NULL default '#F7F7F7',
  `main_back_color` varchar(7) NOT NULL default '#FFFFFF',
  `my_header` varchar(255) NOT NULL default '',
  `my_footer` varchar(255) NOT NULL default '',
  `language` varchar(32) NOT NULL default 'english',
  `name` varchar(32) NOT NULL default '',
  `company_name` varchar(255) NOT NULL default 'mysite.com',
  `override_gd_imageformat` varchar(4) NOT NULL default '',
  `begin_of_week` tinyint(2) NOT NULL default '1',
  `percentage_decimals` tinyint(2) NOT NULL default '2',
  `type_sql_allow` enum('t','f') NOT NULL default 't',
  `type_url_allow` enum('t','f') NOT NULL default 't',
  `type_web_allow` enum('t','f') NOT NULL default 'f',
  `type_html_allow` enum('t','f') NOT NULL default 't',
  `type_txt_allow` enum('t','f') NOT NULL default 't',
  `type_web_mode` tinyint(2) NOT NULL default '0',
  `type_web_dir` varchar(255) NOT NULL default '',
  `type_web_ftp` varchar(255) NOT NULL default '',
  `type_web_url` varchar(255) NOT NULL default '',
  `admin` varchar(64) NOT NULL default 'phpadsuser',
  `admin_pw` varchar(64) NOT NULL default 'phpadspass',
  `admin_fullname` varchar(255) NOT NULL default 'Your Name',
  `admin_email` varchar(64) NOT NULL default 'your@email.com',
  `admin_email_headers` varchar(64) NOT NULL default '',
  `admin_novice` enum('t','f') NOT NULL default 't',
  `default_banner_weight` tinyint(4) NOT NULL default '1',
  `default_campaign_weight` tinyint(4) NOT NULL default '1',
  `client_welcome` enum('t','f') NOT NULL default 't',
  `client_welcome_msg` text NOT NULL,
  `content_gzip_compression` enum('t','f') NOT NULL default 'f',
  `userlog_email` enum('t','f') NOT NULL default 't',
  `userlog_priority` enum('t','f') NOT NULL default 't',
  `userlog_autoclean` enum('t','f') NOT NULL default 't',
  `gui_show_campaign_info` enum('t','f') NOT NULL default 't',
  `gui_show_campaign_preview` enum('t','f') NOT NULL default 'f',
  `gui_show_banner_info` enum('t','f') NOT NULL default 't',
  `gui_show_banner_preview` enum('t','f') NOT NULL default 't',
  `gui_show_banner_html` enum('t','f') NOT NULL default 'f',
  `gui_show_matching` enum('t','f') NOT NULL default 't',
  `gui_show_parents` enum('t','f') NOT NULL default 'f',
  `gui_hide_inactive` enum('t','f') NOT NULL default 'f',
  `gui_link_compact_limit` int(11) NOT NULL default '50',
  `qmail_patch` enum('t','f') NOT NULL default 'f',
  `updates_enabled` enum('t','f') NOT NULL default 't',
  `updates_last_seen` decimal(7,3) NOT NULL default '0.000',
  `updates_cache` text NOT NULL,
  `updates_timestamp` int(11) NOT NULL default '0',
  `updates_dev_builds` enum('t','f') NOT NULL default 'f',
  `allow_invocation_plain` enum('t','f') NOT NULL default 'f',
  `allow_invocation_js` enum('t','f') NOT NULL default 't',
  `allow_invocation_frame` enum('t','f') NOT NULL default 'f',
  `allow_invocation_xmlrpc` enum('t','f') NOT NULL default 'f',
  `allow_invocation_local` enum('t','f') NOT NULL default 't',
  `allow_invocation_interstitial` enum('t','f') NOT NULL default 't',
  `allow_invocation_popup` enum('t','f') NOT NULL default 't',
  `auto_clean_tables` enum('t','f') NOT NULL default 'f',
  `auto_clean_tables_interval` tinyint(2) NOT NULL default '5',
  `auto_clean_userlog` enum('t','f') NOT NULL default 'f',
  `auto_clean_userlog_interval` tinyint(2) NOT NULL default '5',
  `auto_clean_tables_vacuum` enum('t','f') NOT NULL default 't',
  `autotarget_factor` float NOT NULL default '-1',
  `maintenance_timestamp` int(11) NOT NULL default '0',
  `maintenance_cron_timestamp` int(11) NOT NULL default '0',
  PRIMARY KEY  (`configid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_config` (`configid`,`config_version`,`instance_id`,`table_border_color`,`table_back_color`,`table_back_color_alternative`,`main_back_color`,`my_header`,`my_footer`,`language`,`name`,`company_name`,`override_gd_imageformat`,`begin_of_week`,`percentage_decimals`,`type_sql_allow`,`type_url_allow`,`type_web_allow`,`type_html_allow`,`type_txt_allow`,`type_web_mode`,`type_web_dir`,`type_web_ftp`,`type_web_url`,`admin`,`admin_pw`,`admin_fullname`,`admin_email`,`admin_email_headers`,`admin_novice`,`default_banner_weight`,`default_campaign_weight`,`client_welcome`,`client_welcome_msg`,`content_gzip_compression`,`userlog_email`,`userlog_priority`,`userlog_autoclean`,`gui_show_campaign_info`,`gui_show_campaign_preview`,`gui_show_banner_info`,`gui_show_banner_preview`,`gui_show_banner_html`,`gui_show_matching`,`gui_show_parents`,`gui_hide_inactive`,`gui_link_compact_limit`,`qmail_patch`,`updates_enabled`,`updates_last_seen`,`updates_cache`,`updates_timestamp`,`updates_dev_builds`,`allow_invocation_plain`,`allow_invocation_js`,`allow_invocation_frame`,`allow_invocation_xmlrpc`,`allow_invocation_local`,`allow_invocation_interstitial`,`allow_invocation_popup`,`auto_clean_tables`,`auto_clean_tables_interval`,`auto_clean_userlog`,`auto_clean_userlog_interval`,`auto_clean_tables_vacuum`,`autotarget_factor`,`maintenance_timestamp`,`maintenance_cron_timestamp`) VALUES 
 (0,'200.314','8f4a5eaa398d86a302d8a31cb899ed420ad6c7c8','#000099','#CCCCCC','#F7F7F7','#FFFFFF','','','english','','openx ltd.','',1,2,'t','t','f','t','t',0,'','','','openx','7a89a595cfc6cb85480202a143e37d2e','openx','test@open.org','','t',1,1,'t','','f','t','t','t','t','f','t','t','f','t','f','f',50,'f','t','2408.400','a:7:{s:12:\"product_name\";s:5:\"OpenX\";s:14:\"config_version\";s:8:\"2408.400\";s:15:\"config_readable\";s:5:\"2.4.8\";s:12:\"security_fix\";i:1;s:11:\"description\";s:766:\"<p>The OpenX team has released a security update to our open source ad server. We strongly encourage all users to upgrade to avoid this issue.</p>\n<p>This release (v2.4.8) resolves a vulnerability in the delivery system. In addition, this release includes 13 bug fixes and enhancements relating to password recovery, tracker invocation tags and geotargeting.</p>\n<p>Find out more in the OpenX 2.4.8 <a href=\"http://www.openx.org/docs/2.4/release-notes/openx-2.4.8?utm_source=openx&utm_medium=alert&utm_campaign=upgrade\" target=\"_blank\"> release notes </a>. </p>\n<p>Note: The <a href=\"http://blog.openx.org/07/openx-26-has-arrived-with-some-exciting-new-features/\" target=\"_blank\">new version of OpenX (v2.6) announced today </a> also resolves this vulnerability.</p>\";s:7:\"url_zip\";s:133:\"http://www.openx.org/support/release-archive/download?filename=openx-2.4.8.zip&utm_source=openx&utm_medium=alert&utm_campaign=upgrade\";s:7:\"url_tgz\";s:136:\"http://www.openx.org/support/release-archive/download?filename=openx-2.4.8.tar.gz&utm_source=openx&utm_medium=alert&utm_campaign=upgrade\";}',1218642652,'f','f','t','f','f','t','t','t','f',5,'f',5,'t',-1,0,0);
CREATE TABLE `ox_images` (
  `filename` varchar(128) NOT NULL,
  `contents` mediumblob NOT NULL,
  `t_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_images` (`filename`,`contents`,`t_stamp`) VALUES 
 ('468x60.gif',0x474946383961D4013C00F70000000000800000008000808000000080800080008080808080C0C0C0FF000000FF00FFFF000000FFFF00FF00FFFFFFFFFF0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000330000660000990000CC0000FF0033000033330033660033990033CC0033FF0066000066330066660066990066CC0066FF0099000099330099660099990099CC0099FF00CC0000CC3300CC6600CC9900CCCC00CCFF00FF0000FF3300FF6600FF9900FFCC00FFFF3300003300333300663300993300CC3300FF3333003333333333663333993333CC3333FF3366003366333366663366993366CC3366FF3399003399333399663399993399CC3399FF33CC0033CC3333CC6633CC9933CCCC33CCFF33FF0033FF3333FF6633FF9933FFCC33FFFF6600006600336600666600996600CC6600FF6633006633336633666633996633CC6633FF6666006666336666666666996666CC6666FF6699006699336699666699996699CC6699FF66CC0066CC3366CC6666CC9966CCCC66CCFF66FF0066FF3366FF6666FF9966FFCC66FFFF9900009900339900669900999900CC9900FF9933009933339933669933999933CC9933FF9966009966339966669966999966CC9966FF9999009999339999669999999999CC9999FF99CC0099CC3399CC6699CC9999CCCC99CCFF99FF0099FF3399FF6699FF9999FFCC99FFFFCC0000CC0033CC0066CC0099CC00CCCC00FFCC3300CC3333CC3366CC3399CC33CCCC33FFCC6600CC6633CC6666CC6699CC66CCCC66FFCC9900CC9933CC9966CC9999CC99CCCC99FFCCCC00CCCC33CCCC66CCCC99CCCCCCCCCCFFCCFF00CCFF33CCFF66CCFF99CCFFCCCCFFFFFF0000FF0033FF0066FF0099FF00CCFF00FFFF3300FF3333FF3366FF3399FF33CCFF33FFFF6600FF6633FF6666FF6699FF66CCFF66FFFF9900FF9933FF9966FF9999FF99CCFF99FFFFCC00FFCC33FFCC66FFCC99FFCCCCFFCCFFFFFF00FFFF33FFFF66FFFF99FFFFCCFFFFFF21F90401000010002C00000000D4013C000008FF007FE4104870A0C182080F2A4CC870A1C386101F4A8C4871A2C58A182F6ACCC871A3C78E203F8A0C4972A4C992284FAA4CB8B265CA972E63C29C29B326CD9B3673E2DCA95327CF9F3D810A0D4A74A8D1A2488F2A459AB4E9D2A74EA3429D2AB52A55A557AD6ACDCA75ABD7AE60BFB6141BB62CD9B366D3A25D3B53AD5BB670DFCA8D4B176ADDBB73F3E2DDABB7EF43BF80F90A0E4C787054C38513235EACB8F146C790194B8E4CF9EEE4CB953363DECC55B367CEA03F8B5619BAF4E8D3A6534344CD5AB5EBD68E5FCB863DBB765FDAB86DEBCE9D75B76FDEBF83FF044E5CB8F1E2258F2B47BEBC3941E6D09D4B2F3EBD7AF4EBB3B16BB7CE5D73F7EFDBC333BA164F1EBC79BDE7D3975F8F96BD7BF5F0A9C69FFFBE7E51FBF8E9EBA7B9BF7FFEFF230128A07F044654E08103263890820C22D89F830D46189F841442689E851566689D861C62D89C871D86289C882482A89B8925A6F89A8A2CA2589A8B2DC688998C34C2B8988D35E6C8978E3CE248978F3D06D91E90440AF95691481A39A4924C26C95493503A399C945446795495585A1994965C666992975D86F91898648A195299689A39A69A6CA299E69B6D3214279C740A54E79D6C0604003B,'2008-08-06 16:04:27');
CREATE TABLE `ox_session` (
  `sessionid` varchar(32) NOT NULL,
  `sessiondata` blob NOT NULL,
  `lastused` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_session` (`sessionid`,`sessiondata`,`lastused`) VALUES 
 ('1aeee8fb6bbcc34c59a9be6f23e0cd60',0x613A353A7B733A383A227573657274797065223B693A313B733A383A226C6F67676564696E223B733A313A2274223B733A383A22757365726E616D65223B733A353A226F70656E78223B733A353A227072656673223B613A313A7B733A31363A22636C69656E742D696E6465782E706870223B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A373A22312C322C342C33223B7D7D733A31353A226D61696E745F7570646174655F6A73223B623A313B7D,'2008-08-13 13:09:37'),
 ('357155f1330534ff9e413373df1fd002',0x613A353A7B733A383A227573657274797065223B693A313B733A383A226C6F67676564696E223B733A313A2274223B733A383A22757365726E616D65223B733A353A226F70656E78223B733A353A227072656673223B613A313A7B733A31363A22636C69656E742D696E6465782E706870223B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A373A22312C322C342C33223B7D7D733A31353A226D61696E745F7570646174655F6A73223B623A313B7D,'2008-08-13 18:03:54');
CREATE TABLE `ox_targetstats` (
  `day` date NOT NULL default '0000-00-00',
  `clientid` smallint(6) NOT NULL default '0',
  `target` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `modified` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`day`,`clientid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_userlog` (
  `userlogid` mediumint(9) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL default '0',
  `usertype` tinyint(4) NOT NULL default '0',
  `userid` mediumint(9) NOT NULL default '0',
  `action` mediumint(9) NOT NULL default '0',
  `object` mediumint(9) default NULL,
  `details` blob,
  PRIMARY KEY  (`userlogid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_zones` (
  `zoneid` mediumint(9) NOT NULL auto_increment,
  `affiliateid` mediumint(9) default NULL,
  `zonename` varchar(245) NOT NULL,
  `description` varchar(255) NOT NULL,
  `delivery` smallint(6) NOT NULL default '0',
  `zonetype` smallint(6) NOT NULL default '0',
  `what` blob NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `chain` blob NOT NULL,
  `prepend` blob NOT NULL,
  `append` blob NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`zoneid`),
  KEY `zonenameid` (`zonename`,`zoneid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `ox_zones` (`zoneid`,`affiliateid`,`zonename`,`description`,`delivery`,`zonetype`,`what`,`width`,`height`,`chain`,`prepend`,`append`,`appendtype`) VALUES 
 (1,1,'Publisher 1 - Default','',0,3,0x636C69656E7469643A322C636C69656E7469643A33,468,60,'','','',3),
 (2,1,'Agency Publisher 1 - Default','',0,3,0x636C69656E7469643A322C636C69656E7469643A34,468,60,'','','',3);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
