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
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,ANSI_QUOTES' */;


--
-- Create schema maxv0129rc
--

-- CREATE DATABASE IF NOT EXISTS maxv0129rc;
-- USE maxv0129rc;
CREATE TABLE "ox_acls" (
  "bannerid" mediumint(9) NOT NULL default '0',
  "logical" set('and','or') NOT NULL default '',
  "type" varchar(16) NOT NULL default '',
  "comparison" char(2) NOT NULL default '==',
  "data" text NOT NULL,
  "executionorder" int(10) unsigned NOT NULL default '0',
  UNIQUE KEY "bannerid_executionorder" ("bannerid","executionorder"),
  KEY "bannerid" ("bannerid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_adclicks" (
  "userid" varchar(32) NOT NULL default '',
  "bannerid" mediumint(9) NOT NULL default '0',
  "zoneid" mediumint(9) NOT NULL default '0',
  "t_stamp" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  "host" varchar(255) NOT NULL default '',
  "source" varchar(50) NOT NULL default '',
  "country" char(2) NOT NULL default '',
  KEY "date" ("t_stamp"),
  KEY "userid" ("userid"),
  KEY "bannerid" ("bannerid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_adconversions" (
  "conversionid" bigint(20) unsigned NOT NULL auto_increment,
  "local_conversionid" bigint(20) unsigned NOT NULL default '0',
  "dbserver_ip" varchar(16) NOT NULL default '',
  "userid" varchar(32) NOT NULL default '',
  "trackerid" mediumint(9) NOT NULL default '0',
  "t_stamp" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  "host" varchar(255) NOT NULL default '',
  "country" char(2) NOT NULL default '',
  "conversionlogid" mediumint(9) NOT NULL default '0',
  PRIMARY KEY  ("conversionid"),
  KEY "userid" ("userid"),
  KEY "date" ("t_stamp"),
  KEY "trackerid" ("trackerid"),
  KEY "local_conversionid" ("local_conversionid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_adstats" (
  "views" int(11) NOT NULL default '0',
  "clicks" int(11) NOT NULL default '0',
  "conversions" int(11) NOT NULL default '0',
  "day" date NOT NULL default '0000-00-00',
  "hour" tinyint(4) NOT NULL default '0',
  "bannerid" mediumint(9) NOT NULL default '0',
  "zoneid" mediumint(9) NOT NULL default '0',
  KEY "day" ("day"),
  KEY "bannerid" ("bannerid"),
  KEY "zoneid" ("zoneid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_adviews" (
  "userid" varchar(32) NOT NULL default '',
  "bannerid" mediumint(9) NOT NULL default '0',
  "zoneid" mediumint(9) NOT NULL default '0',
  "t_stamp" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  "host" varchar(255) NOT NULL default '',
  "source" varchar(50) NOT NULL default '',
  "country" char(2) NOT NULL default '',
  KEY "date" ("t_stamp"),
  KEY "userid" ("userid"),
  KEY "bannerid" ("bannerid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_affiliates" (
  "affiliateid" mediumint(9) NOT NULL auto_increment,
  "agencyid" mediumint(9) NOT NULL default '0',
  "name" varchar(255) NOT NULL default '',
  "mnemonic" varchar(5) NOT NULL default '',
  "contact" varchar(255) default NULL,
  "email" varchar(64) NOT NULL default '',
  "website" varchar(255) default NULL,
  "username" varchar(64) default NULL,
  "password" varchar(64) default NULL,
  "permissions" mediumint(9) default NULL,
  "language" varchar(64) default NULL,
  "publiczones" enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  ("affiliateid")
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO "ox_affiliates" ("affiliateid","agencyid","name","mnemonic","contact","email","website","username","password","permissions","language","publiczones") VALUES 
  (1,0,'Agency Publisher 1','Agenc','Andrew Hill','andrew.hill@openads.org','http://fornax.net',NULL,'',31,'','f');
CREATE TABLE "ox_agency" (
  "agencyid" mediumint(9) NOT NULL auto_increment,
  "name" varchar(255) NOT NULL default '',
  "contact" varchar(255) default NULL,
  "email" varchar(64) NOT NULL default '',
  "username" varchar(64) default NULL,
  "password" varchar(64) default NULL,
  "permissions" mediumint(9) default NULL,
  "language" varchar(64) default NULL,
  PRIMARY KEY  ("agencyid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_application_variable" (
  "name" varchar(255) NOT NULL default '',
  "value" varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO "ox_application_variable" ("name","value") VALUES 
  ('max_version','v0.1.29-rc');
CREATE TABLE "ox_banners" (
  "bannerid" mediumint(9) NOT NULL auto_increment,
  "campaignid" mediumint(9) NOT NULL default '0',
  "active" enum('t','f') NOT NULL default 't',
  "priority" int(11) NOT NULL default '0',
  "contenttype" enum('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') NOT NULL default 'gif',
  "pluginversion" mediumint(9) NOT NULL default '0',
  "storagetype" enum('sql','web','url','html','network','txt') NOT NULL default 'sql',
  "filename" varchar(255) NOT NULL default '',
  "imageurl" varchar(255) NOT NULL default '',
  "htmltemplate" text NOT NULL,
  "htmlcache" text NOT NULL,
  "width" smallint(6) NOT NULL default '0',
  "height" smallint(6) NOT NULL default '0',
  "weight" tinyint(4) NOT NULL default '1',
  "seq" tinyint(4) NOT NULL default '0',
  "target" varchar(16) NOT NULL default '',
  "url" text NOT NULL,
  "alt" varchar(255) NOT NULL default '',
  "status" varchar(255) NOT NULL default '',
  "keyword" varchar(255) NOT NULL default '',
  "bannertext" text NOT NULL,
  "description" varchar(255) NOT NULL default '',
  "autohtml" enum('t','f') NOT NULL default 't',
  "adserver" varchar(50) NOT NULL default '',
  "block" int(11) NOT NULL default '0',
  "capping" int(11) NOT NULL default '0',
  "session_capping" int(11) NOT NULL default '0',
  "compiledlimitation" text NOT NULL,
  "append" text NOT NULL,
  "appendtype" tinyint(4) NOT NULL default '0',
  "bannertype" tinyint(4) NOT NULL default '0',
  "alt_filename" varchar(255) NOT NULL default '',
  "alt_imageurl" varchar(255) NOT NULL default '',
  "alt_contenttype" enum('gif','jpeg','png') NOT NULL default 'gif',
  PRIMARY KEY  ("bannerid"),
  KEY "campaignid" ("campaignid")
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO "ox_banners" ("bannerid","campaignid","active","priority","contenttype","pluginversion","storagetype","filename","imageurl","htmltemplate","htmlcache","width","height","weight","seq","target","url","alt","status","keyword","bannertext","description","autohtml","adserver","block","capping","session_capping","compiledlimitation","append","appendtype","bannertype","alt_filename","alt_imageurl","alt_contenttype") VALUES 
  (1,1,'t',0,'',0,'html','','','Test HTML Banner!','Test HTML Banner!',468,60,1,0,'','','','','','','Test HTML Banner!','f','',0,0,0,'','',0,0,'','','');
INSERT INTO "ox_banners" ("bannerid","campaignid","active","priority","contenttype","pluginversion","storagetype","filename","imageurl","htmltemplate","htmlcache","width","height","weight","seq","target","url","alt","status","keyword","bannertext","description","autohtml","adserver","block","capping","session_capping","compiledlimitation","append","appendtype","bannertype","alt_filename","alt_imageurl","alt_contenttype") VALUES 
  (2,2,'t',1,'',0,'html','','','html test banner','html test banner',468,60,1,0,'','https://developer.openx.org/','','','','','test banner','t','max',0,0,0,'','',0,0,'','','');
INSERT INTO "ox_banners" ("bannerid","campaignid","active","priority","contenttype","pluginversion","storagetype","filename","imageurl","htmltemplate","htmlcache","width","height","weight","seq","target","url","alt","status","keyword","bannertext","description","autohtml","adserver","block","capping","session_capping","compiledlimitation","append","appendtype","bannertype","alt_filename","alt_imageurl","alt_contenttype") VALUES 
  (3,3,'t',1,'gif',0,'sql','468x60.gif','','','',468,60,1,0,'','https://developer.openx.org/','alt text','','','','sample gif banner','f','',0,0,0,'','',0,0,'','','');
CREATE TABLE "ox_cache" (
  "cacheid" varchar(255) NOT NULL default '',
  "content" blob NOT NULL,
  PRIMARY KEY  ("cacheid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_campaigns" (
  "campaignid" mediumint(9) NOT NULL auto_increment,
  "campaignname" varchar(255) NOT NULL default '',
  "clientid" mediumint(9) NOT NULL default '0',
  "views" int(11) default '-1',
  "clicks" int(11) default '-1',
  "conversions" int(11) default '-1',
  "expire" date default '0000-00-00',
  "activate" date default '0000-00-00',
  "active" enum('t','f') NOT NULL default 't',
  "priority" enum('h','m','l') NOT NULL default 'l',
  "weight" tinyint(4) NOT NULL default '1',
  "target" int(11) NOT NULL default '0',
  "optimise" enum('t','f') NOT NULL default 'f',
  "anonymous" enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  ("campaignid")
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO "ox_campaigns" ("campaignid","campaignname","clientid","views","clicks","conversions","expire","activate","active","priority","weight","target","optimise","anonymous") VALUES 
  (1,'Advertiser 1 - Default Campaign',1,-1,-1,-1,'2008-07-01','0000-00-00','f','l',1,0,'f','f');
INSERT INTO "ox_campaigns" ("campaignid","campaignname","clientid","views","clicks","conversions","expire","activate","active","priority","weight","target","optimise","anonymous") VALUES 
  (2,'test campaign',1,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,'f','f');
INSERT INTO "ox_campaigns" ("campaignid","campaignname","clientid","views","clicks","conversions","expire","activate","active","priority","weight","target","optimise","anonymous") VALUES 
  (3,'campaign 2 (gif)',1,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,'f','f');
CREATE TABLE "ox_campaigns_trackers" (
  "campaign_trackerid" mediumint(9) NOT NULL auto_increment,
  "campaignid" mediumint(9) NOT NULL default '0',
  "trackerid" mediumint(9) NOT NULL default '0',
  "logstats" enum('y','n') NOT NULL default 'y',
  "viewwindow" mediumint(9) NOT NULL default '0',
  "clickwindow" mediumint(9) NOT NULL default '0',
  PRIMARY KEY  ("campaign_trackerid"),
  KEY "campaignid" ("campaignid"),
  KEY "trackerid" ("trackerid")
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO "ox_campaigns_trackers" ("campaign_trackerid","campaignid","trackerid","logstats","viewwindow","clickwindow") VALUES 
  (1,3,1,'n',3,3);
CREATE TABLE "ox_clients" (
  "clientid" mediumint(9) NOT NULL auto_increment,
  "agencyid" mediumint(9) NOT NULL default '0',
  "clientname" varchar(255) NOT NULL default '',
  "contact" varchar(255) default NULL,
  "email" varchar(64) NOT NULL default '',
  "clientusername" varchar(64) NOT NULL default '',
  "clientpassword" varchar(64) NOT NULL default '',
  "permissions" mediumint(9) default NULL,
  "language" varchar(64) default NULL,
  "report" enum('t','f') NOT NULL default 't',
  "reportinterval" mediumint(9) NOT NULL default '7',
  "reportlastdate" date NOT NULL default '0000-00-00',
  "reportdeactivate" enum('t','f') NOT NULL default 't',
  PRIMARY KEY  ("clientid")
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO "ox_clients" ("clientid","agencyid","clientname","contact","email","clientusername","clientpassword","permissions","language","report","reportinterval","reportlastdate","reportdeactivate") VALUES 
  (1,0,'Advertiser 1','advertiser','example@example.com','','',59,'','t',7,'2008-09-22','t');
CREATE TABLE "ox_config" (
  "agencyid" mediumint(9) NOT NULL default '0',
  "config_version" decimal(7,3) NOT NULL default '0.000',
  "table_border_color" varchar(7) default '#000099',
  "table_back_color" varchar(7) default '#CCCCCC',
  "table_back_color_alternative" varchar(7) default '#F7F7F7',
  "main_back_color" varchar(7) default '#FFFFFF',
  "my_header" varchar(255) default NULL,
  "my_footer" varchar(255) default NULL,
  "language" varchar(32) default 'english',
  "name" varchar(32) default NULL,
  "company_name" varchar(255) default 'mysite.com',
  "override_gd_imageformat" varchar(4) default NULL,
  "begin_of_week" tinyint(2) default '1',
  "percentage_decimals" tinyint(2) default '2',
  "type_sql_allow" enum('t','f') default 't',
  "type_url_allow" enum('t','f') default 't',
  "type_web_allow" enum('t','f') default 'f',
  "type_html_allow" enum('t','f') default 't',
  "type_txt_allow" enum('t','f') default 't',
  "type_web_mode" tinyint(2) default '0',
  "type_web_dir" varchar(255) default NULL,
  "type_web_ftp" varchar(255) default NULL,
  "type_web_url" varchar(255) default NULL,
  "admin" varchar(64) default 'phpadsuser',
  "admin_pw" varchar(64) default 'phpadspass',
  "admin_fullname" varchar(255) default 'Your Name',
  "admin_email" varchar(64) default 'your@email.com',
  "warn_admin" enum('t','f') default 't',
  "warn_agency" enum('t','f') default 't',
  "warn_client" enum('t','f') default 't',
  "warn_limit" mediumint(9) NOT NULL default '0',
  "admin_email_headers" varchar(64) default NULL,
  "admin_novice" enum('t','f') default 't',
  "default_banner_weight" tinyint(4) default '1',
  "default_campaign_weight" tinyint(4) default '1',
  "client_welcome" enum('t','f') default 't',
  "client_welcome_msg" text,
  "content_gzip_compression" enum('t','f') default 'f',
  "userlog_email" enum('t','f') default 't',
  "userlog_priority" enum('t','f') default 't',
  "userlog_autoclean" enum('t','f') default 't',
  "gui_show_campaign_info" enum('t','f') default 't',
  "gui_show_campaign_preview" enum('t','f') default 'f',
  "gui_show_banner_info" enum('t','f') default 't',
  "gui_show_banner_preview" enum('t','f') default 't',
  "gui_show_banner_html" enum('t','f') default 'f',
  "gui_show_matching" enum('t','f') default 't',
  "gui_show_parents" enum('t','f') default 'f',
  "gui_hide_inactive" enum('t','f') default 'f',
  "gui_link_compact_limit" int(11) default '50',
  "qmail_patch" enum('t','f') default 'f',
  "updates_frequency" tinyint(2) default '7',
  "updates_timestamp" int(11) default '0',
  "updates_last_seen" decimal(7,3) default '0.000',
  "allow_invocation_plain" enum('t','f') default 'f',
  "allow_invocation_plain_nocookies" enum('t','f') default 't',
  "allow_invocation_js" enum('t','f') default 't',
  "allow_invocation_frame" enum('t','f') default 'f',
  "allow_invocation_xmlrpc" enum('t','f') default 'f',
  "allow_invocation_local" enum('t','f') default 't',
  "allow_invocation_interstitial" enum('t','f') default 't',
  "allow_invocation_popup" enum('t','f') default 't',
  "auto_clean_tables" enum('t','f') default 'f',
  "auto_clean_tables_interval" tinyint(2) default '5',
  "auto_clean_userlog" enum('t','f') default 'f',
  "auto_clean_userlog_interval" tinyint(2) default '5',
  "auto_clean_tables_vacuum" enum('t','f') default 't',
  "autotarget_factor" float default '-1',
  "maintenance_timestamp" int(11) default '0',
  "compact_stats" enum('t','f') default 't',
  "statslastday" date NOT NULL default '0000-00-00',
  "statslasthour" tinyint(4) NOT NULL default '0',
  PRIMARY KEY  ("agencyid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO "ox_config" ("agencyid","config_version","table_border_color","table_back_color","table_back_color_alternative","main_back_color","my_header","my_footer","language","name","company_name","override_gd_imageformat","begin_of_week","percentage_decimals","type_sql_allow","type_url_allow","type_web_allow","type_html_allow","type_txt_allow","type_web_mode","type_web_dir","type_web_ftp","type_web_url","admin","admin_pw","admin_fullname","admin_email","warn_admin","warn_agency","warn_client","warn_limit","admin_email_headers","admin_novice","default_banner_weight","default_campaign_weight","client_welcome","client_welcome_msg","content_gzip_compression","userlog_email","userlog_priority","userlog_autoclean","gui_show_campaign_info","gui_show_campaign_preview","gui_show_banner_info","gui_show_banner_preview","gui_show_banner_html","gui_show_matching","gui_show_parents","gui_hide_inactive","gui_link_compact_limit","qmail_patch","updates_frequency","updates_timestamp","updates_last_seen","allow_invocation_plain","allow_invocation_plain_nocookies","allow_invocation_js","allow_invocation_frame","allow_invocation_xmlrpc","allow_invocation_local","allow_invocation_interstitial","allow_invocation_popup","auto_clean_tables","auto_clean_tables_interval","auto_clean_userlog","auto_clean_userlog_interval","auto_clean_tables_vacuum","autotarget_factor","maintenance_timestamp","compact_stats","statslastday","statslasthour") VALUES 
  (0,'0.100','#000099','#CCCCCC','#F7F7F7','#FFFFFF',NULL,NULL,'english',NULL,'mysite.com',NULL,1,2,'t','t','f','t','t',0,NULL,NULL,NULL,'openx','7a89a595cfc6cb85480202a143e37d2e','Your Name','your@email.com','t','t','t',0,NULL,'t',1,1,'t',NULL,'f','t','t','t','t','f','t','t','f','t','f','f',50,'f',7,0,'0.000','f','t','t','f','f','t','t','t','f',5,'f',5,'t',-1,1222071011,'t','0000-00-00',0);
CREATE TABLE "ox_conversionlog" (
  "conversionlogid" mediumint(9) NOT NULL auto_increment,
  "conversionid" bigint(20) unsigned NOT NULL default '0',
  "campaignid" mediumint(9) NOT NULL default '0',
  "trackerid" mediumint(9) NOT NULL default '0',
  "userid" varchar(32) NOT NULL default '',
  "t_stamp" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  "host" varchar(255) NOT NULL default '',
  "country" char(2) NOT NULL default '',
  "cnv_logstats" enum('y','n') default 'n',
  "cnv_clickwindow" mediumint(9) NOT NULL default '0',
  "cnv_viewwindow" mediumint(9) NOT NULL default '0',
  "cnv_latest" smallint(6) default NULL,
  "action" enum('view','click') default NULL,
  "action_bannerid" mediumint(9) NOT NULL default '0',
  "action_zoneid" mediumint(9) NOT NULL default '0',
  "action_t_stamp" timestamp NOT NULL default '0000-00-00 00:00:00',
  "action_host" varchar(255) NOT NULL default '',
  "action_source" varchar(50) NOT NULL default '',
  "action_country" char(2) NOT NULL default '',
  PRIMARY KEY  ("conversionlogid"),
  KEY "t_stamp" ("t_stamp")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_images" (
  "filename" varchar(128) NOT NULL default '',
  "contents" mediumblob NOT NULL,
  "t_stamp" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  ("filename")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO "ox_images" ("filename","contents","t_stamp") VALUES 
  ('468x60.gif',0x474946383961D4013C00F70000000000800000008000808000000080800080008080808080C0C0C0FF000000FF00FFFF000000FFFF00FF00FFFFFFFFFF0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000330000660000990000CC0000FF0033000033330033660033990033CC0033FF0066000066330066660066990066CC0066FF0099000099330099660099990099CC0099FF00CC0000CC3300CC6600CC9900CCCC00CCFF00FF0000FF3300FF6600FF9900FFCC00FFFF3300003300333300663300993300CC3300FF3333003333333333663333993333CC3333FF3366003366333366663366993366CC3366FF3399003399333399663399993399CC3399FF33CC0033CC3333CC6633CC9933CCCC33CCFF33FF0033FF3333FF6633FF9933FFCC33FFFF6600006600336600666600996600CC6600FF6633006633336633666633996633CC6633FF6666006666336666666666996666CC6666FF6699006699336699666699996699CC6699FF66CC0066CC3366CC6666CC9966CCCC66CCFF66FF0066FF3366FF6666FF9966FFCC66FFFF9900009900339900669900999900CC9900FF9933009933339933669933999933CC9933FF9966009966339966669966999966CC9966FF9999009999339999669999999999CC9999FF99CC0099CC3399CC6699CC9999CCCC99CCFF99FF0099FF3399FF6699FF9999FFCC99FFFFCC0000CC0033CC0066CC0099CC00CCCC00FFCC3300CC3333CC3366CC3399CC33CCCC33FFCC6600CC6633CC6666CC6699CC66CCCC66FFCC9900CC9933CC9966CC9999CC99CCCC99FFCCCC00CCCC33CCCC66CCCC99CCCCCCCCCCFFCCFF00CCFF33CCFF66CCFF99CCFFCCCCFFFFFF0000FF0033FF0066FF0099FF00CCFF00FFFF3300FF3333FF3366FF3399FF33CCFF33FFFF6600FF6633FF6666FF6699FF66CCFF66FFFF9900FF9933FF9966FF9999FF99CCFF99FFFFCC00FFCC33FFCC66FFCC99FFCCCCFFCCFFFFFF00FFFF33FFFF66FFFF99FFFFCCFFFFFF21F90401000010002C00000000D4013C000008FF007FE4104870A0C182080F2A4CC870A1C386101F4A8C4871A2C58A182F6ACCC871A3C78E203F8A0C4972A4C992284FAA4CB8B265CA972E63C29C29B326CD9B3673E2DCA95327CF9F3D810A0D4A74A8D1A2488F2A459AB4E9D2A74EA3429D2AB52A55A557AD6ACDCA75ABD7AE60BFB6141BB62CD9B366D3A25D3B53AD5BB670DFCA8D4B176ADDBB73F3E2DDABB7EF43BF80F90A0E4C787054C38513235EACB8F146C790194B8E4CF9EEE4CB953363DECC55B367CEA03F8B5619BAF4E8D3A6534344CD5AB5EBD68E5FCB863DBB765FDAB86DEBCE9D75B76FDEBF83FF044E5CB8F1E2258F2B47BEBC3941E6D09D4B2F3EBD7AF4EBB3B16BB7CE5D73F7EFDBC333BA164F1EBC79BDE7D3975F8F96BD7BF5F0A9C69FFFBE7E51FBF8E9EBA7B9BF7FFEFF230128A07F044654E08103263890820C22D89F830D46189F841442689E851566689D861C62D89C871D86289C882482A89B8925A6F89A8A2CA2589A8B2DC688998C34C2B8988D35E6C8978E3CE248978F3D06D91E90440AF95691481A39A4924C26C95493503A399C945446795495585A1994965C666992975D86F91898648A195299689A39A69A6CA299E69B6D3214279C740A54E79D6C0604003B,'2008-09-22 10:20:04');
CREATE TABLE "ox_log_maintenance" (
  "log_maintenance_id" int(11) NOT NULL auto_increment,
  "start_run" datetime default NULL,
  "end_run" datetime default NULL,
  "duration" int(11) default NULL,
  PRIMARY KEY  ("log_maintenance_id")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_session" (
  "sessionid" varchar(32) NOT NULL default '',
  "sessiondata" blob NOT NULL,
  "lastused" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  ("sessionid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO "ox_session" ("sessionid","sessiondata","lastused") VALUES 
  ('phpads48d7524d243d67.92573462',0x613A363A7B733A383A227573657274797065223B693A313B733A383A226C6F67676564696E223B733A313A2274223B733A383A226167656E63796964223B693A303B733A383A22757365726E616D65223B733A353A226F70656E78223B733A31323A227570646174655F636865636B223B623A303B733A353A227072656673223B613A373A7B733A32303A22616476657274697365722D696E6465782E706870223B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B613A313A7B733A373A22636C69656E7473223B613A313A7B693A313B613A313A7B733A363A22657870616E64223B623A313B7D7D7D7D733A32303A2263616D706169676E2D62616E6E6572732E706870223B613A333A7B693A313B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A303A22223B7D693A323B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A303A22223B7D693A333B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A303A22223B7D7D733A32333A22616476657274697365722D747261636B6572732E706870223B613A323A7B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B7D733A32313A22747261636B65722D63616D706169676E732E706870223B613A333A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B7D733A31393A22616666696C696174652D696E6465782E706870223B613A333A7B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A323A222C31223B7D733A31363A227A6F6E652D696E636C7564652E706870223B613A333A7B733A31323A2268696465696E616374697665223B623A303B733A31313A2273686F7762616E6E657273223B623A313B733A31333A2273686F7763616D706169676E73223B623A303B7D733A31363A226167656E63792D696E6465782E706870223B613A343A7B733A31323A2268696465696E616374697665223B623A303B733A393A226C6973746F72646572223B733A303A22223B733A31343A226F72646572646972656374696F6E223B733A303A22223B733A353A226E6F646573223B733A303A22223B7D7D7D,'2008-09-22 11:37:44');
CREATE TABLE "ox_targetstats" (
  "day" date NOT NULL default '0000-00-00',
  "campaignid" mediumint(9) NOT NULL default '0',
  "target" int(11) NOT NULL default '0',
  "views" int(11) NOT NULL default '0',
  "modified" tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_trackers" (
  "trackerid" mediumint(9) NOT NULL auto_increment,
  "trackername" varchar(255) NOT NULL default '',
  "description" varchar(255) NOT NULL default '',
  "clientid" mediumint(9) NOT NULL default '0',
  "viewwindow" mediumint(9) NOT NULL default '0',
  "clickwindow" mediumint(9) NOT NULL default '0',
  "blockwindow" mediumint(9) NOT NULL default '0',
  PRIMARY KEY  ("trackerid")
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO "ox_trackers" ("trackerid","trackername","description","clientid","viewwindow","clickwindow","blockwindow") VALUES 
  (1,'Sample Tracker','',1,3,3,0);
CREATE TABLE "ox_userlog" (
  "userlogid" mediumint(9) NOT NULL auto_increment,
  "timestamp" int(11) NOT NULL default '0',
  "usertype" tinyint(4) NOT NULL default '0',
  "userid" mediumint(9) NOT NULL default '0',
  "action" mediumint(9) NOT NULL default '0',
  "object" mediumint(9) default NULL,
  "details" text,
  PRIMARY KEY  ("userlogid")
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
CREATE TABLE "ox_variables" (
  "variableid" mediumint(9) unsigned NOT NULL auto_increment,
  "trackerid" varchar(32) NOT NULL default '',
  "name" varchar(250) NOT NULL default '',
  "description" varchar(250) default NULL,
  "variabletype" enum('js','qs') NOT NULL default 'js',
  "datatype" enum('int','string') NOT NULL default 'int',
  PRIMARY KEY  ("variableid")
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO "ox_variables" ("variableid","trackerid","name","description","variabletype","datatype") VALUES 
  (1,'1','foo','Sample string','js','string');
INSERT INTO "ox_variables" ("variableid","trackerid","name","description","variabletype","datatype") VALUES 
  (2,'1','boo','Sample number','js','int');
CREATE TABLE "ox_variablevalues" (
  "valueid" bigint(20) unsigned NOT NULL auto_increment,
  "t_stamp" timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  "variableid" mediumint(9) NOT NULL default '0',
  "value" varchar(50) default NULL,
  "local_conversionid" bigint(20) unsigned NOT NULL default '0',
  "dbserver_ip" varchar(16) NOT NULL default '',
  "conversionid" bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  ("valueid"),
  KEY "local_conversionid" ("local_conversionid"),
  KEY "conversionid" ("conversionid")
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE "ox_zones" (
  "zoneid" mediumint(9) NOT NULL auto_increment,
  "affiliateid" mediumint(9) default NULL,
  "zonename" varchar(245) NOT NULL default '',
  "description" varchar(255) NOT NULL default '',
  "delivery" smallint(6) NOT NULL default '0',
  "zonetype" smallint(6) NOT NULL default '0',
  "what" blob NOT NULL,
  "width" smallint(6) NOT NULL default '0',
  "height" smallint(6) NOT NULL default '0',
  "chain" blob NOT NULL,
  "prepend" blob NOT NULL,
  "append" blob NOT NULL,
  "appendtype" tinyint(4) NOT NULL default '0',
  "forceappend" enum('t','f') default 'f',
  PRIMARY KEY  ("zoneid"),
  KEY "zonenameid" ("zonename","zoneid")
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO "ox_zones" ("zoneid","affiliateid","zonename","description","delivery","zonetype","what","width","height","chain","prepend","append","appendtype","forceappend") VALUES 
  (1,1,'Publisher 1 - Default','',0,3,0x63616D706169676E69643A312C63616D706169676E69643A32,468,60,'','','',0,'f');
INSERT INTO "ox_zones" ("zoneid","affiliateid","zonename","description","delivery","zonetype","what","width","height","chain","prepend","append","appendtype","forceappend") VALUES 
  (2,1,'Agency Publisher 1 - Default','',0,3,0x63616D706169676E69643A312C63616D706169676E69643A33,468,60,'','','',0,'f');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
