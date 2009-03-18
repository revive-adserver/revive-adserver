-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.51a-3ubuntu5.4-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema openx265canoo
--

-- CREATE DATABASE IF NOT EXISTS openx265canoo;
-- USE openx265canoo;

CREATE TABLE `ox_account_preference_assoc` (
  `account_id` mediumint(9) NOT NULL,
  `preference_id` mediumint(9) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`account_id`,`preference_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_account_preference_assoc` VALUES   (1,1,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,2,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,3,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,4,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,5,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,6,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,7,'100');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,8,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,9,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,10,'100');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,11,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,12,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,13,'100');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,14,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,15,'Europe/Warsaw');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,16,'4');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,17,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,18,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,19,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,20,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,21,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,22,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,23,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,24,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,25,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,26,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,27,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,28,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,29,'2');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,30,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,31,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,32,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,33,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,34,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,35,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,36,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,37,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,38,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,39,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,40,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,41,'2');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,42,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,43,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,44,'3');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,45,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,46,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,47,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,48,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,49,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,50,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,51,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,52,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,53,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,54,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,55,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,56,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,57,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,58,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,59,'4');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,60,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,61,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,62,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,63,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,64,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,65,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,66,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,67,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,68,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,69,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,70,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,71,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,72,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,73,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,74,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,75,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,76,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,77,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,78,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,79,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,80,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,81,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,82,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,83,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,84,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,85,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,86,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,87,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,88,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,89,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,90,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,91,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,92,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,93,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,94,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,95,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,96,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,97,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,98,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,99,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,100,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,101,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,102,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,103,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,104,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,105,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,106,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,107,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,108,'1');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,109,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,110,'5');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,111,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,112,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,113,'0');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,114,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,115,'');
INSERT INTO `ox_account_preference_assoc` VALUES   (1,116,'0');
CREATE TABLE `ox_account_user_assoc` (
  `account_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `linked` datetime NOT NULL,
  PRIMARY KEY  (`account_id`,`user_id`),
  KEY `ox_account_user_assoc_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_account_user_assoc` VALUES   (1,1,'2009-03-18 17:52:20');
INSERT INTO `ox_account_user_assoc` VALUES   (2,1,'2009-03-18 17:52:20');
CREATE TABLE `ox_account_user_permission_assoc` (
  `account_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `permission_id` mediumint(9) NOT NULL,
  `is_allowed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`account_id`,`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_accounts` (
  `account_id` mediumint(9) NOT NULL auto_increment,
  `account_type` varchar(16) NOT NULL default '',
  `account_name` varchar(255) default NULL,
  `m2m_password` varchar(32) default NULL,
  `m2m_ticket` varchar(32) default NULL,
  PRIMARY KEY  (`account_id`),
  KEY `ox_accounts_account_type` (`account_type`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO `ox_accounts` VALUES   (1,'ADMIN','Administrator account','P*f*a#VobPzhoyTSQvW8r#Gei',NULL);
INSERT INTO `ox_accounts` VALUES   (2,'MANAGER','Default manager','x)=b@R)(u*%rf+OTFOwPAL_jP','w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo');
INSERT INTO `ox_accounts` VALUES   (3,'ADVERTISER','Advertiser 1',NULL,NULL);
INSERT INTO `ox_accounts` VALUES   (4,'TRAFFICKER','Agency Publisher 1',NULL,NULL);
CREATE TABLE `ox_acls` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `ox_acls_bannerid_executionorder` (`bannerid`,`executionorder`),
  KEY `ox_acls_bannerid` (`bannerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_acls_channel` (
  `channelid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `ox_acls_channel_channelid_executionorder` (`channelid`,`executionorder`),
  KEY `ox_acls_channel_channelid` (`channelid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_ad_category_assoc` (
  `ad_category_assoc_id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ad_category_assoc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_ad_zone_assoc` (
  `ad_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `ad_id` mediumint(9) default NULL,
  `priority` double default '0',
  `link_type` smallint(6) NOT NULL default '1',
  `priority_factor` double default '0',
  `to_be_delivered` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ad_zone_assoc_id`),
  KEY `ox_ad_zone_assoc_zone_id` (`zone_id`),
  KEY `ox_ad_zone_assoc_ad_id` (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
INSERT INTO `ox_ad_zone_assoc` VALUES   (1,0,1,1,0,1670960,1);
INSERT INTO `ox_ad_zone_assoc` VALUES   (2,1,1,0.9,1,100,1);
INSERT INTO `ox_ad_zone_assoc` VALUES   (3,0,2,0,0,1,1);
INSERT INTO `ox_ad_zone_assoc` VALUES   (4,1,2,0,1,1,1);
INSERT INTO `ox_ad_zone_assoc` VALUES   (5,2,1,0.9,1,100,1);
INSERT INTO `ox_ad_zone_assoc` VALUES   (6,0,3,0,0,0,1);
INSERT INTO `ox_ad_zone_assoc` VALUES   (7,2,3,0,1,0,1);
CREATE TABLE `ox_affiliates` (
  `affiliateid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `mnemonic` varchar(5) NOT NULL default '',
  `comments` text,
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `website` varchar(255) default NULL,
  `updated` datetime NOT NULL,
  `an_website_id` int(11) default NULL,
  `oac_country_code` char(2) NOT NULL default '',
  `oac_language_id` int(11) default NULL,
  `oac_category_id` int(11) default NULL,
  `as_website_id` int(11) default NULL,
  `account_id` mediumint(9) default NULL,
  PRIMARY KEY  (`affiliateid`),
  UNIQUE KEY `ox_affiliates_account_id` (`account_id`),
  KEY `ox_affiliates_agencyid` (`agencyid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
INSERT INTO `ox_affiliates` VALUES   (1,1,'Agency Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://fornax.net','2007-05-15 13:41:40',NULL,'',NULL,NULL,NULL,1);
INSERT INTO `ox_affiliates` VALUES   (2,1,'Agency Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://fornax.net','2009-03-18 16:54:24',NULL,'',0,0,0,4);
CREATE TABLE `ox_affiliates_extra` (
  `affiliateid` mediumint(9) NOT NULL,
  `address` text,
  `city` varchar(255) default NULL,
  `postcode` varchar(64) default NULL,
  `country` varchar(255) default NULL,
  `phone` varchar(64) default NULL,
  `fax` varchar(64) default NULL,
  `account_contact` varchar(255) default NULL,
  `payee_name` varchar(255) default NULL,
  `tax_id` varchar(64) default NULL,
  `mode_of_payment` varchar(64) default NULL,
  `currency` varchar(64) default NULL,
  `unique_users` int(11) default NULL,
  `unique_views` int(11) default NULL,
  `page_rank` int(11) default NULL,
  `category` varchar(255) default NULL,
  `help_file` varchar(255) default NULL,
  PRIMARY KEY  (`affiliateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_agency` (
  `agencyid` mediumint(9) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `logout_url` varchar(255) default NULL,
  `active` smallint(1) default '0',
  `updated` datetime NOT NULL,
  `account_id` mediumint(9) default NULL,
  PRIMARY KEY  (`agencyid`),
  UNIQUE KEY `ox_agency_account_id` (`account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `ox_agency` VALUES   (1,'Default manager',NULL,'',NULL,1,'2009-03-18 16:52:20',2);
CREATE TABLE `ox_application_variable` (
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_application_variable` VALUES   ('tables_core','583');
INSERT INTO `ox_application_variable` VALUES   ('oa_version','2.6.5');
INSERT INTO `ox_application_variable` VALUES   ('platform_hash','09c0cda77354316a29f6ea6bdac38f55bf3a41be');
INSERT INTO `ox_application_variable` VALUES   ('sync_last_run','2009-03-18 16:57:58');
INSERT INTO `ox_application_variable` VALUES   ('sync_cache','b:0;');
INSERT INTO `ox_application_variable` VALUES   ('sync_timestamp','1237395478');
INSERT INTO `ox_application_variable` VALUES   ('admin_account_id','1');
INSERT INTO `ox_application_variable` VALUES   ('maintenance_timestamp','1237395477');
CREATE TABLE `ox_audit` (
  `auditid` mediumint(9) NOT NULL auto_increment,
  `actionid` mediumint(9) NOT NULL,
  `context` varchar(255) NOT NULL default '',
  `contextid` mediumint(9) default NULL,
  `parentid` mediumint(9) default NULL,
  `details` text NOT NULL,
  `userid` mediumint(9) NOT NULL default '0',
  `username` varchar(64) default NULL,
  `usertype` tinyint(4) NOT NULL default '0',
  `updated` datetime default NULL,
  `account_id` mediumint(9) NOT NULL,
  `advertiser_account_id` mediumint(9) default NULL,
  `website_account_id` mediumint(9) default NULL,
  PRIMARY KEY  (`auditid`),
  KEY `ox_audit_parentid_contextid` (`parentid`,`contextid`),
  KEY `ox_audit_updated` (`updated`),
  KEY `ox_audit_usertype` (`usertype`),
  KEY `ox_audit_username` (`username`),
  KEY `ox_audit_context_actionid` (`context`,`actionid`),
  KEY `ox_audit_account_id` (`account_id`),
  KEY `ox_audit_advertiser_account_id` (`advertiser_account_id`),
  KEY `ox_audit_website_account_id` (`website_account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=273 DEFAULT CHARSET=utf8;
INSERT INTO `ox_audit` VALUES   (1,1,'accounts',1,NULL,'a:4:{s:10:\"account_id\";i:1;s:12:\"account_type\";s:5:\"ADMIN\";s:12:\"account_name\";s:21:\"Administrator account\";s:8:\"key_desc\";s:21:\"Administrator account\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (2,1,'accounts',2,NULL,'a:4:{s:10:\"account_id\";i:2;s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:8:\"key_desc\";s:15:\"Default manager\";}',0,'Installer',0,'2009-03-18 16:52:20',2,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (3,1,'agency',1,NULL,'a:9:{s:8:\"agencyid\";i:1;s:4:\"name\";s:15:\"Default manager\";s:7:\"contact\";s:4:\"null\";s:5:\"email\";s:4:\"null\";s:10:\"logout_url\";s:4:\"null\";s:6:\"active\";i:1;s:7:\"updated\";s:19:\"2009-03-18 16:52:20\";s:10:\"account_id\";i:2;s:8:\"key_desc\";s:15:\"Default manager\";}',0,'Installer',0,'2009-03-18 16:52:20',2,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (4,1,'users',1,NULL,'a:14:{s:7:\"user_id\";i:1;s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"password\";s:6:\"******\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";i:2;s:8:\"comments\";s:0:\"\";s:6:\"active\";s:4:\"null\";s:11:\"sso_user_id\";i:0;s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:4:\"null\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"key_desc\";s:5:\"openx\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (5,1,'account_user_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:7:\"user_id\";i:1;s:6:\"linked\";s:19:\"2009-03-18 17:52:20\";s:8:\"key_desc\";s:21:\"Account #1 -> User #1\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (6,1,'account_user_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:2;s:7:\"user_id\";i:1;s:6:\"linked\";s:19:\"2009-03-18 17:52:20\";s:8:\"key_desc\";s:21:\"Account #2 -> User #1\";}',0,'Installer',0,'2009-03-18 16:52:20',2,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (7,1,'preferences',1,NULL,'a:4:{s:13:\"preference_id\";i:1;s:15:\"preference_name\";s:24:\"default_banner_image_url\";s:12:\"account_type\";s:10:\"TRAFFICKER\";s:8:\"key_desc\";s:24:\"default_banner_image_url\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (8,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:1;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #1\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (9,1,'preferences',2,NULL,'a:4:{s:13:\"preference_id\";i:2;s:15:\"preference_name\";s:30:\"default_banner_destination_url\";s:12:\"account_type\";s:10:\"TRAFFICKER\";s:8:\"key_desc\";s:30:\"default_banner_destination_url\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (10,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:2;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #2\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (11,1,'preferences',3,NULL,'a:4:{s:13:\"preference_id\";i:3;s:15:\"preference_name\";s:42:\"auto_alter_html_banners_for_click_tracking\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:42:\"auto_alter_html_banners_for_click_tracking\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (12,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:3;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #3\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (13,1,'preferences',4,NULL,'a:4:{s:13:\"preference_id\";i:4;s:15:\"preference_name\";s:21:\"default_banner_weight\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:21:\"default_banner_weight\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (14,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:4;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #4\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (15,1,'preferences',5,NULL,'a:4:{s:13:\"preference_id\";i:5;s:15:\"preference_name\";s:23:\"default_campaign_weight\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:23:\"default_campaign_weight\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (16,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:5;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #5\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (17,1,'preferences',6,NULL,'a:4:{s:13:\"preference_id\";i:6;s:15:\"preference_name\";s:16:\"warn_email_admin\";s:12:\"account_type\";s:5:\"ADMIN\";s:8:\"key_desc\";s:16:\"warn_email_admin\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (18,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:6;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #6\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (19,1,'preferences',7,NULL,'a:4:{s:13:\"preference_id\";i:7;s:15:\"preference_name\";s:33:\"warn_email_admin_impression_limit\";s:12:\"account_type\";s:5:\"ADMIN\";s:8:\"key_desc\";s:33:\"warn_email_admin_impression_limit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (20,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:7;s:5:\"value\";s:3:\"100\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #7\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (21,1,'preferences',8,NULL,'a:4:{s:13:\"preference_id\";i:8;s:15:\"preference_name\";s:26:\"warn_email_admin_day_limit\";s:12:\"account_type\";s:5:\"ADMIN\";s:8:\"key_desc\";s:26:\"warn_email_admin_day_limit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (22,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:8;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #8\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (23,1,'preferences',9,NULL,'a:4:{s:13:\"preference_id\";i:9;s:15:\"preference_name\";s:18:\"warn_email_manager\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:18:\"warn_email_manager\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (24,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:9;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:27:\"Account #1 -> Preference #9\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (25,1,'preferences',10,NULL,'a:4:{s:13:\"preference_id\";i:10;s:15:\"preference_name\";s:35:\"warn_email_manager_impression_limit\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:35:\"warn_email_manager_impression_limit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (26,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:10;s:5:\"value\";s:3:\"100\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #10\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (27,1,'preferences',11,NULL,'a:4:{s:13:\"preference_id\";i:11;s:15:\"preference_name\";s:28:\"warn_email_manager_day_limit\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:28:\"warn_email_manager_day_limit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (28,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:11;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #11\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (29,1,'preferences',12,NULL,'a:4:{s:13:\"preference_id\";i:12;s:15:\"preference_name\";s:21:\"warn_email_advertiser\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:21:\"warn_email_advertiser\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (30,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:12;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #12\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (31,1,'preferences',13,NULL,'a:4:{s:13:\"preference_id\";i:13;s:15:\"preference_name\";s:38:\"warn_email_advertiser_impression_limit\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:38:\"warn_email_advertiser_impression_limit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (32,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:13;s:5:\"value\";s:3:\"100\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #13\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (33,1,'preferences',14,NULL,'a:4:{s:13:\"preference_id\";i:14;s:15:\"preference_name\";s:31:\"warn_email_advertiser_day_limit\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:31:\"warn_email_advertiser_day_limit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (34,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:14;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #14\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (35,1,'preferences',15,NULL,'a:4:{s:13:\"preference_id\";i:15;s:15:\"preference_name\";s:8:\"timezone\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:8:\"timezone\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (36,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:15;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #15\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (37,1,'preferences',16,NULL,'a:4:{s:13:\"preference_id\";i:16;s:15:\"preference_name\";s:22:\"tracker_default_status\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:22:\"tracker_default_status\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (38,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:16;s:5:\"value\";s:1:\"4\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #16\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (39,1,'preferences',17,NULL,'a:4:{s:13:\"preference_id\";i:17;s:15:\"preference_name\";s:20:\"tracker_default_type\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:20:\"tracker_default_type\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (40,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:17;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #17\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (41,1,'preferences',18,NULL,'a:4:{s:13:\"preference_id\";i:18;s:15:\"preference_name\";s:22:\"tracker_link_campaigns\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:22:\"tracker_link_campaigns\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (42,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:18;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #18\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (43,1,'preferences',19,NULL,'a:4:{s:13:\"preference_id\";i:19;s:15:\"preference_name\";s:21:\"ui_show_campaign_info\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:21:\"ui_show_campaign_info\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (44,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:19;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #19\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (45,1,'preferences',20,NULL,'a:4:{s:13:\"preference_id\";i:20;s:15:\"preference_name\";s:19:\"ui_show_banner_info\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:19:\"ui_show_banner_info\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (46,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:20;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #20\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (47,1,'preferences',21,NULL,'a:4:{s:13:\"preference_id\";i:21;s:15:\"preference_name\";s:24:\"ui_show_campaign_preview\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:24:\"ui_show_campaign_preview\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (48,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:21;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #21\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (49,1,'preferences',22,NULL,'a:4:{s:13:\"preference_id\";i:22;s:15:\"preference_name\";s:19:\"ui_show_banner_html\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:19:\"ui_show_banner_html\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (50,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:22;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #22\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (51,1,'preferences',23,NULL,'a:4:{s:13:\"preference_id\";i:23;s:15:\"preference_name\";s:22:\"ui_show_banner_preview\";s:12:\"account_type\";s:10:\"ADVERTISER\";s:8:\"key_desc\";s:22:\"ui_show_banner_preview\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (52,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:23;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #23\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (53,1,'preferences',24,NULL,'a:4:{s:13:\"preference_id\";i:24;s:15:\"preference_name\";s:16:\"ui_hide_inactive\";s:12:\"account_type\";s:0:\"\";s:8:\"key_desc\";s:16:\"ui_hide_inactive\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (54,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:24;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #24\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (55,1,'preferences',25,NULL,'a:4:{s:13:\"preference_id\";i:25;s:15:\"preference_name\";s:24:\"ui_show_matching_banners\";s:12:\"account_type\";s:10:\"TRAFFICKER\";s:8:\"key_desc\";s:24:\"ui_show_matching_banners\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (56,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:25;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #25\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (57,1,'preferences',26,NULL,'a:4:{s:13:\"preference_id\";i:26;s:15:\"preference_name\";s:32:\"ui_show_matching_banners_parents\";s:12:\"account_type\";s:10:\"TRAFFICKER\";s:8:\"key_desc\";s:32:\"ui_show_matching_banners_parents\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (58,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:26;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #26\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (59,1,'preferences',27,NULL,'a:4:{s:13:\"preference_id\";i:27;s:15:\"preference_name\";s:14:\"ui_novice_user\";s:12:\"account_type\";s:0:\"\";s:8:\"key_desc\";s:14:\"ui_novice_user\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (60,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:27;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #27\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (61,1,'preferences',28,NULL,'a:4:{s:13:\"preference_id\";i:28;s:15:\"preference_name\";s:17:\"ui_week_start_day\";s:12:\"account_type\";s:0:\"\";s:8:\"key_desc\";s:17:\"ui_week_start_day\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (62,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:28;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #28\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (63,1,'preferences',29,NULL,'a:4:{s:13:\"preference_id\";i:29;s:15:\"preference_name\";s:22:\"ui_percentage_decimals\";s:12:\"account_type\";s:0:\"\";s:8:\"key_desc\";s:22:\"ui_percentage_decimals\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (64,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:29;s:5:\"value\";s:1:\"2\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #29\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (65,1,'preferences',30,NULL,'a:4:{s:13:\"preference_id\";i:30;s:15:\"preference_name\";s:12:\"ui_column_id\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:12:\"ui_column_id\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (66,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:30;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #30\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (67,1,'preferences',31,NULL,'a:4:{s:13:\"preference_id\";i:31;s:15:\"preference_name\";s:18:\"ui_column_id_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:18:\"ui_column_id_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (68,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:31;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #31\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (69,1,'preferences',32,NULL,'a:4:{s:13:\"preference_id\";i:32;s:15:\"preference_name\";s:17:\"ui_column_id_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:17:\"ui_column_id_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (70,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:32;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #32\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (71,1,'preferences',33,NULL,'a:4:{s:13:\"preference_id\";i:33;s:15:\"preference_name\";s:18:\"ui_column_requests\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:18:\"ui_column_requests\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (72,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:33;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #33\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (73,1,'preferences',34,NULL,'a:4:{s:13:\"preference_id\";i:34;s:15:\"preference_name\";s:24:\"ui_column_requests_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:24:\"ui_column_requests_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (74,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:34;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #34\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (75,1,'preferences',35,NULL,'a:4:{s:13:\"preference_id\";i:35;s:15:\"preference_name\";s:23:\"ui_column_requests_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:23:\"ui_column_requests_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (76,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:35;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #35\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (77,1,'preferences',36,NULL,'a:4:{s:13:\"preference_id\";i:36;s:15:\"preference_name\";s:21:\"ui_column_impressions\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_impressions\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (78,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:36;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #36\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (79,1,'preferences',37,NULL,'a:4:{s:13:\"preference_id\";i:37;s:15:\"preference_name\";s:27:\"ui_column_impressions_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:27:\"ui_column_impressions_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (80,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:37;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #37\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (81,1,'preferences',38,NULL,'a:4:{s:13:\"preference_id\";i:38;s:15:\"preference_name\";s:26:\"ui_column_impressions_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:26:\"ui_column_impressions_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (82,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:38;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #38\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (83,1,'preferences',39,NULL,'a:4:{s:13:\"preference_id\";i:39;s:15:\"preference_name\";s:16:\"ui_column_clicks\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:16:\"ui_column_clicks\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (84,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:39;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #39\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (85,1,'preferences',40,NULL,'a:4:{s:13:\"preference_id\";i:40;s:15:\"preference_name\";s:22:\"ui_column_clicks_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_clicks_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (86,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:40;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #40\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (87,1,'preferences',41,NULL,'a:4:{s:13:\"preference_id\";i:41;s:15:\"preference_name\";s:21:\"ui_column_clicks_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_clicks_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (88,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:41;s:5:\"value\";s:1:\"2\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #41\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (89,1,'preferences',42,NULL,'a:4:{s:13:\"preference_id\";i:42;s:15:\"preference_name\";s:13:\"ui_column_ctr\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:13:\"ui_column_ctr\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (90,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:42;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #42\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (91,1,'preferences',43,NULL,'a:4:{s:13:\"preference_id\";i:43;s:15:\"preference_name\";s:19:\"ui_column_ctr_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_ctr_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (92,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:43;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #43\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (93,1,'preferences',44,NULL,'a:4:{s:13:\"preference_id\";i:44;s:15:\"preference_name\";s:18:\"ui_column_ctr_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:18:\"ui_column_ctr_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (94,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:44;s:5:\"value\";s:1:\"3\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #44\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (95,1,'preferences',45,NULL,'a:4:{s:13:\"preference_id\";i:45;s:15:\"preference_name\";s:21:\"ui_column_conversions\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_conversions\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (96,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:45;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #45\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (97,1,'preferences',46,NULL,'a:4:{s:13:\"preference_id\";i:46;s:15:\"preference_name\";s:27:\"ui_column_conversions_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:27:\"ui_column_conversions_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (98,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:46;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #46\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (99,1,'preferences',47,NULL,'a:4:{s:13:\"preference_id\";i:47;s:15:\"preference_name\";s:26:\"ui_column_conversions_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:26:\"ui_column_conversions_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (100,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:47;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #47\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (101,1,'preferences',48,NULL,'a:4:{s:13:\"preference_id\";i:48;s:15:\"preference_name\";s:29:\"ui_column_conversions_pending\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:29:\"ui_column_conversions_pending\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (102,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:48;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #48\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (103,1,'preferences',49,NULL,'a:4:{s:13:\"preference_id\";i:49;s:15:\"preference_name\";s:35:\"ui_column_conversions_pending_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:35:\"ui_column_conversions_pending_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (104,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:49;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #49\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (105,1,'preferences',50,NULL,'a:4:{s:13:\"preference_id\";i:50;s:15:\"preference_name\";s:34:\"ui_column_conversions_pending_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:34:\"ui_column_conversions_pending_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (106,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:50;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #50\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (107,1,'preferences',51,NULL,'a:4:{s:13:\"preference_id\";i:51;s:15:\"preference_name\";s:18:\"ui_column_sr_views\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:18:\"ui_column_sr_views\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (108,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:51;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #51\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (109,1,'preferences',52,NULL,'a:4:{s:13:\"preference_id\";i:52;s:15:\"preference_name\";s:24:\"ui_column_sr_views_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:24:\"ui_column_sr_views_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (110,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:52;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #52\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (111,1,'preferences',53,NULL,'a:4:{s:13:\"preference_id\";i:53;s:15:\"preference_name\";s:23:\"ui_column_sr_views_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:23:\"ui_column_sr_views_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (112,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:53;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #53\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (113,1,'preferences',54,NULL,'a:4:{s:13:\"preference_id\";i:54;s:15:\"preference_name\";s:19:\"ui_column_sr_clicks\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_sr_clicks\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (114,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:54;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #54\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (115,1,'preferences',55,NULL,'a:4:{s:13:\"preference_id\";i:55;s:15:\"preference_name\";s:25:\"ui_column_sr_clicks_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:25:\"ui_column_sr_clicks_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (116,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:55;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #55\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (117,1,'preferences',56,NULL,'a:4:{s:13:\"preference_id\";i:56;s:15:\"preference_name\";s:24:\"ui_column_sr_clicks_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:24:\"ui_column_sr_clicks_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (118,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:56;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #56\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (119,1,'preferences',57,NULL,'a:4:{s:13:\"preference_id\";i:57;s:15:\"preference_name\";s:17:\"ui_column_revenue\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:17:\"ui_column_revenue\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (120,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:57;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #57\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (121,1,'preferences',58,NULL,'a:4:{s:13:\"preference_id\";i:58;s:15:\"preference_name\";s:23:\"ui_column_revenue_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:23:\"ui_column_revenue_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (122,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:58;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #58\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (123,1,'preferences',59,NULL,'a:4:{s:13:\"preference_id\";i:59;s:15:\"preference_name\";s:22:\"ui_column_revenue_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_revenue_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (124,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:59;s:5:\"value\";s:1:\"4\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #59\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (125,1,'preferences',60,NULL,'a:4:{s:13:\"preference_id\";i:60;s:15:\"preference_name\";s:14:\"ui_column_cost\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_cost\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (126,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:60;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #60\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (127,1,'preferences',61,NULL,'a:4:{s:13:\"preference_id\";i:61;s:15:\"preference_name\";s:20:\"ui_column_cost_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_cost_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (128,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:61;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #61\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (129,1,'preferences',62,NULL,'a:4:{s:13:\"preference_id\";i:62;s:15:\"preference_name\";s:19:\"ui_column_cost_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_cost_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (130,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:62;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #62\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (131,1,'preferences',63,NULL,'a:4:{s:13:\"preference_id\";i:63;s:15:\"preference_name\";s:12:\"ui_column_bv\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:12:\"ui_column_bv\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (132,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:63;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #63\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (133,1,'preferences',64,NULL,'a:4:{s:13:\"preference_id\";i:64;s:15:\"preference_name\";s:18:\"ui_column_bv_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:18:\"ui_column_bv_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (134,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:64;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #64\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (135,1,'preferences',65,NULL,'a:4:{s:13:\"preference_id\";i:65;s:15:\"preference_name\";s:17:\"ui_column_bv_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:17:\"ui_column_bv_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (136,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:65;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #65\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (137,1,'preferences',66,NULL,'a:4:{s:13:\"preference_id\";i:66;s:15:\"preference_name\";s:19:\"ui_column_num_items\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_num_items\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (138,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:66;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #66\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (139,1,'preferences',67,NULL,'a:4:{s:13:\"preference_id\";i:67;s:15:\"preference_name\";s:25:\"ui_column_num_items_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:25:\"ui_column_num_items_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (140,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:67;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #67\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (141,1,'preferences',68,NULL,'a:4:{s:13:\"preference_id\";i:68;s:15:\"preference_name\";s:24:\"ui_column_num_items_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:24:\"ui_column_num_items_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (142,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:68;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #68\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (143,1,'preferences',69,NULL,'a:4:{s:13:\"preference_id\";i:69;s:15:\"preference_name\";s:16:\"ui_column_revcpc\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:16:\"ui_column_revcpc\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (144,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:69;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #69\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (145,1,'preferences',70,NULL,'a:4:{s:13:\"preference_id\";i:70;s:15:\"preference_name\";s:22:\"ui_column_revcpc_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_revcpc_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (146,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:70;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #70\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (147,1,'preferences',71,NULL,'a:4:{s:13:\"preference_id\";i:71;s:15:\"preference_name\";s:21:\"ui_column_revcpc_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_revcpc_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (148,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:71;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #71\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (149,1,'preferences',72,NULL,'a:4:{s:13:\"preference_id\";i:72;s:15:\"preference_name\";s:17:\"ui_column_costcpc\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:17:\"ui_column_costcpc\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (150,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:72;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #72\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (151,1,'preferences',73,NULL,'a:4:{s:13:\"preference_id\";i:73;s:15:\"preference_name\";s:23:\"ui_column_costcpc_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:23:\"ui_column_costcpc_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (152,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:73;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #73\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (153,1,'preferences',74,NULL,'a:4:{s:13:\"preference_id\";i:74;s:15:\"preference_name\";s:22:\"ui_column_costcpc_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_costcpc_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (154,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:74;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #74\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (155,1,'preferences',75,NULL,'a:4:{s:13:\"preference_id\";i:75;s:15:\"preference_name\";s:25:\"ui_column_technology_cost\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:25:\"ui_column_technology_cost\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (156,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:75;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #75\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (157,1,'preferences',76,NULL,'a:4:{s:13:\"preference_id\";i:76;s:15:\"preference_name\";s:31:\"ui_column_technology_cost_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:31:\"ui_column_technology_cost_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (158,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:76;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #76\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (159,1,'preferences',77,NULL,'a:4:{s:13:\"preference_id\";i:77;s:15:\"preference_name\";s:30:\"ui_column_technology_cost_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:30:\"ui_column_technology_cost_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (160,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:77;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #77\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (161,1,'preferences',78,NULL,'a:4:{s:13:\"preference_id\";i:78;s:15:\"preference_name\";s:16:\"ui_column_income\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:16:\"ui_column_income\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (162,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:78;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #78\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (163,1,'preferences',79,NULL,'a:4:{s:13:\"preference_id\";i:79;s:15:\"preference_name\";s:22:\"ui_column_income_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_income_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (164,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:79;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #79\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (165,1,'preferences',80,NULL,'a:4:{s:13:\"preference_id\";i:80;s:15:\"preference_name\";s:21:\"ui_column_income_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_income_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (166,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:80;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #80\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (167,1,'preferences',81,NULL,'a:4:{s:13:\"preference_id\";i:81;s:15:\"preference_name\";s:23:\"ui_column_income_margin\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:23:\"ui_column_income_margin\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (168,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:81;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #81\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (169,1,'preferences',82,NULL,'a:4:{s:13:\"preference_id\";i:82;s:15:\"preference_name\";s:29:\"ui_column_income_margin_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:29:\"ui_column_income_margin_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (170,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:82;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #82\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (171,1,'preferences',83,NULL,'a:4:{s:13:\"preference_id\";i:83;s:15:\"preference_name\";s:28:\"ui_column_income_margin_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:28:\"ui_column_income_margin_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (172,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:83;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #83\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (173,1,'preferences',84,NULL,'a:4:{s:13:\"preference_id\";i:84;s:15:\"preference_name\";s:16:\"ui_column_profit\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:16:\"ui_column_profit\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (174,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:84;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #84\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (175,1,'preferences',85,NULL,'a:4:{s:13:\"preference_id\";i:85;s:15:\"preference_name\";s:22:\"ui_column_profit_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_profit_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (176,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:85;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #85\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (177,1,'preferences',86,NULL,'a:4:{s:13:\"preference_id\";i:86;s:15:\"preference_name\";s:21:\"ui_column_profit_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_profit_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (178,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:86;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #86\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (179,1,'preferences',87,NULL,'a:4:{s:13:\"preference_id\";i:87;s:15:\"preference_name\";s:16:\"ui_column_margin\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:16:\"ui_column_margin\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (180,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:87;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #87\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (181,1,'preferences',88,NULL,'a:4:{s:13:\"preference_id\";i:88;s:15:\"preference_name\";s:22:\"ui_column_margin_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:22:\"ui_column_margin_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (182,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:88;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #88\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (183,1,'preferences',89,NULL,'a:4:{s:13:\"preference_id\";i:89;s:15:\"preference_name\";s:21:\"ui_column_margin_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:21:\"ui_column_margin_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (184,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:89;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #89\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (185,1,'preferences',90,NULL,'a:4:{s:13:\"preference_id\";i:90;s:15:\"preference_name\";s:14:\"ui_column_erpm\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_erpm\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (186,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:90;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #90\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (187,1,'preferences',91,NULL,'a:4:{s:13:\"preference_id\";i:91;s:15:\"preference_name\";s:20:\"ui_column_erpm_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_erpm_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (188,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:91;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #91\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (189,1,'preferences',92,NULL,'a:4:{s:13:\"preference_id\";i:92;s:15:\"preference_name\";s:19:\"ui_column_erpm_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_erpm_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (190,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:92;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #92\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (191,1,'preferences',93,NULL,'a:4:{s:13:\"preference_id\";i:93;s:15:\"preference_name\";s:14:\"ui_column_erpc\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_erpc\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (192,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:93;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #93\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (193,1,'preferences',94,NULL,'a:4:{s:13:\"preference_id\";i:94;s:15:\"preference_name\";s:20:\"ui_column_erpc_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_erpc_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (194,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:94;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #94\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (195,1,'preferences',95,NULL,'a:4:{s:13:\"preference_id\";i:95;s:15:\"preference_name\";s:19:\"ui_column_erpc_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_erpc_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (196,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:95;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #95\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (197,1,'preferences',96,NULL,'a:4:{s:13:\"preference_id\";i:96;s:15:\"preference_name\";s:14:\"ui_column_erps\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_erps\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (198,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:96;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #96\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (199,1,'preferences',97,NULL,'a:4:{s:13:\"preference_id\";i:97;s:15:\"preference_name\";s:20:\"ui_column_erps_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_erps_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (200,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:97;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #97\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (201,1,'preferences',98,NULL,'a:4:{s:13:\"preference_id\";i:98;s:15:\"preference_name\";s:19:\"ui_column_erps_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_erps_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (202,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:98;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #98\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (203,1,'preferences',99,NULL,'a:4:{s:13:\"preference_id\";i:99;s:15:\"preference_name\";s:14:\"ui_column_eipm\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_eipm\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (204,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:99;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:28:\"Account #1 -> Preference #99\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (205,1,'preferences',100,NULL,'a:4:{s:13:\"preference_id\";i:100;s:15:\"preference_name\";s:20:\"ui_column_eipm_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_eipm_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (206,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:100;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #100\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (207,1,'preferences',101,NULL,'a:4:{s:13:\"preference_id\";i:101;s:15:\"preference_name\";s:19:\"ui_column_eipm_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_eipm_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (208,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:101;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #101\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (209,1,'preferences',102,NULL,'a:4:{s:13:\"preference_id\";i:102;s:15:\"preference_name\";s:14:\"ui_column_eipc\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_eipc\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (210,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:102;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #102\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (211,1,'preferences',103,NULL,'a:4:{s:13:\"preference_id\";i:103;s:15:\"preference_name\";s:20:\"ui_column_eipc_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_eipc_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (212,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:103;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #103\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (213,1,'preferences',104,NULL,'a:4:{s:13:\"preference_id\";i:104;s:15:\"preference_name\";s:19:\"ui_column_eipc_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_eipc_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (214,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:104;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #104\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (215,1,'preferences',105,NULL,'a:4:{s:13:\"preference_id\";i:105;s:15:\"preference_name\";s:14:\"ui_column_eips\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_eips\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (216,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:105;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #105\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (217,1,'preferences',106,NULL,'a:4:{s:13:\"preference_id\";i:106;s:15:\"preference_name\";s:20:\"ui_column_eips_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_eips_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (218,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:106;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #106\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (219,1,'preferences',107,NULL,'a:4:{s:13:\"preference_id\";i:107;s:15:\"preference_name\";s:19:\"ui_column_eips_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_eips_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (220,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:107;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #107\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (221,1,'preferences',108,NULL,'a:4:{s:13:\"preference_id\";i:108;s:15:\"preference_name\";s:14:\"ui_column_ecpm\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_ecpm\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (222,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:108;s:5:\"value\";s:1:\"1\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #108\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (223,1,'preferences',109,NULL,'a:4:{s:13:\"preference_id\";i:109;s:15:\"preference_name\";s:20:\"ui_column_ecpm_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_ecpm_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (224,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:109;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #109\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (225,1,'preferences',110,NULL,'a:4:{s:13:\"preference_id\";i:110;s:15:\"preference_name\";s:19:\"ui_column_ecpm_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_ecpm_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (226,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:110;s:5:\"value\";s:1:\"5\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #110\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (227,1,'preferences',111,NULL,'a:4:{s:13:\"preference_id\";i:111;s:15:\"preference_name\";s:14:\"ui_column_ecpc\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_ecpc\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (228,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:111;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #111\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (229,1,'preferences',112,NULL,'a:4:{s:13:\"preference_id\";i:112;s:15:\"preference_name\";s:20:\"ui_column_ecpc_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_ecpc_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (230,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:112;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #112\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (231,1,'preferences',113,NULL,'a:4:{s:13:\"preference_id\";i:113;s:15:\"preference_name\";s:19:\"ui_column_ecpc_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_ecpc_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (232,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:113;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #113\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (233,1,'preferences',114,NULL,'a:4:{s:13:\"preference_id\";i:114;s:15:\"preference_name\";s:14:\"ui_column_ecps\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:14:\"ui_column_ecps\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (234,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:114;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #114\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (235,1,'preferences',115,NULL,'a:4:{s:13:\"preference_id\";i:115;s:15:\"preference_name\";s:20:\"ui_column_ecps_label\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:20:\"ui_column_ecps_label\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (236,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:115;s:5:\"value\";s:0:\"\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #115\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (237,1,'preferences',116,NULL,'a:4:{s:13:\"preference_id\";i:116;s:15:\"preference_name\";s:19:\"ui_column_ecps_rank\";s:12:\"account_type\";s:7:\"MANAGER\";s:8:\"key_desc\";s:19:\"ui_column_ecps_rank\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (238,1,'account_preference_assoc',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:13:\"preference_id\";i:116;s:5:\"value\";s:1:\"0\";s:8:\"key_desc\";s:29:\"Account #1 -> Preference #116\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (239,2,'account_preference_assoc',0,NULL,'a:2:{s:5:\"value\";a:2:{s:3:\"was\";s:0:\"\";s:2:\"is\";s:13:\"Europe/Warsaw\";}s:8:\"key_desc\";s:28:\"Account #1 -> Preference #15\";}',0,'Installer',0,'2009-03-18 16:52:20',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (240,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";N;s:2:\"is\";s:19:\"2009-03-18 16:52:22\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:52:22',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (241,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:52:22\";s:2:\"is\";s:19:\"2009-03-18 16:53:01\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:53:01',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (242,1,'accounts',3,NULL,'a:4:{s:10:\"account_id\";i:3;s:12:\"account_type\";s:10:\"ADVERTISER\";s:12:\"account_name\";s:12:\"Advertiser 1\";s:8:\"key_desc\";s:12:\"Advertiser 1\";}',1,'openx',0,'2009-03-18 16:53:26',1,3,NULL);
INSERT INTO `ox_audit` VALUES   (243,1,'clients',1,NULL,'a:17:{s:8:\"clientid\";i:1;s:8:\"agencyid\";i:1;s:10:\"clientname\";s:12:\"Advertiser 1\";s:7:\"contact\";s:10:\"advertiser\";s:5:\"email\";s:19:\"example@example.com\";s:6:\"report\";s:1:\"f\";s:14:\"reportinterval\";i:7;s:14:\"reportlastdate\";s:10:\"2009-03-18\";s:16:\"reportdeactivate\";s:1:\"t\";s:8:\"comments\";s:0:\"\";s:7:\"updated\";s:19:\"2009-03-18 16:53:26\";s:12:\"lb_reporting\";s:4:\"null\";s:15:\"an_adnetwork_id\";i:0;s:16:\"as_advertiser_id\";i:0;s:10:\"account_id\";i:3;s:21:\"advertiser_limitation\";s:5:\"false\";s:8:\"key_desc\";s:12:\"Advertiser 1\";}',1,'openx',0,'2009-03-18 16:53:26',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (244,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:53:01\";s:2:\"is\";s:19:\"2009-03-18 16:53:27\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:53:27',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (245,1,'campaigns',1,NULL,'a:30:{s:10:\"campaignid\";i:1;s:12:\"campaignname\";s:31:\"Advertiser 1 - Default Campaign\";s:8:\"clientid\";i:1;s:5:\"views\";i:-1;s:6:\"clicks\";i:-1;s:11:\"conversions\";i:-1;s:6:\"expire\";s:10:\"2007-07-01\";s:8:\"activate\";s:10:\"0000-00-00\";s:8:\"priority\";i:0;s:6:\"weight\";i:1;s:17:\"target_impression\";i:0;s:12:\"target_click\";i:0;s:17:\"target_conversion\";i:0;s:9:\"anonymous\";s:1:\"f\";s:9:\"companion\";i:0;s:8:\"comments\";s:0:\"\";s:7:\"revenue\";i:0;s:12:\"revenue_type\";i:0;s:7:\"updated\";s:19:\"2009-03-18 16:53:38\";s:5:\"block\";i:0;s:7:\"capping\";i:0;s:15:\"session_capping\";i:0;s:14:\"an_campaign_id\";i:0;s:14:\"as_campaign_id\";i:0;s:6:\"status\";i:3;s:9:\"an_status\";i:0;s:16:\"as_reject_reason\";i:0;s:12:\"hosted_views\";i:0;s:13:\"hosted_clicks\";i:0;s:8:\"key_desc\";s:31:\"Advertiser 1 - Default Campaign\";}',1,'openx',0,'2009-03-18 16:53:38',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (246,1,'campaigns',2,NULL,'a:30:{s:10:\"campaignid\";i:2;s:12:\"campaignname\";s:13:\"test campaign\";s:8:\"clientid\";i:1;s:5:\"views\";i:-1;s:6:\"clicks\";i:-1;s:11:\"conversions\";i:-1;s:6:\"expire\";s:10:\"0000-00-00\";s:8:\"activate\";s:10:\"0000-00-00\";s:8:\"priority\";i:0;s:6:\"weight\";i:1;s:17:\"target_impression\";i:0;s:12:\"target_click\";i:0;s:17:\"target_conversion\";i:0;s:9:\"anonymous\";s:1:\"f\";s:9:\"companion\";i:0;s:8:\"comments\";s:0:\"\";s:7:\"revenue\";i:0;s:12:\"revenue_type\";i:0;s:7:\"updated\";s:19:\"2009-03-18 16:53:39\";s:5:\"block\";i:0;s:7:\"capping\";i:0;s:15:\"session_capping\";i:0;s:14:\"an_campaign_id\";i:0;s:14:\"as_campaign_id\";i:0;s:6:\"status\";i:0;s:9:\"an_status\";i:0;s:16:\"as_reject_reason\";i:0;s:12:\"hosted_views\";i:0;s:13:\"hosted_clicks\";i:0;s:8:\"key_desc\";s:13:\"test campaign\";}',1,'openx',0,'2009-03-18 16:53:39',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (247,1,'campaigns',3,NULL,'a:30:{s:10:\"campaignid\";i:3;s:12:\"campaignname\";s:16:\"campaign 2 (gif)\";s:8:\"clientid\";i:1;s:5:\"views\";i:-1;s:6:\"clicks\";i:-1;s:11:\"conversions\";i:-1;s:6:\"expire\";s:10:\"0000-00-00\";s:8:\"activate\";s:10:\"0000-00-00\";s:8:\"priority\";i:0;s:6:\"weight\";i:1;s:17:\"target_impression\";i:0;s:12:\"target_click\";i:0;s:17:\"target_conversion\";i:0;s:9:\"anonymous\";s:1:\"f\";s:9:\"companion\";i:0;s:8:\"comments\";s:0:\"\";s:7:\"revenue\";i:0;s:12:\"revenue_type\";i:0;s:7:\"updated\";s:19:\"2009-03-18 16:53:40\";s:5:\"block\";i:0;s:7:\"capping\";i:0;s:15:\"session_capping\";i:0;s:14:\"an_campaign_id\";i:0;s:14:\"as_campaign_id\";i:0;s:6:\"status\";i:0;s:9:\"an_status\";i:0;s:16:\"as_reject_reason\";i:0;s:12:\"hosted_views\";i:0;s:13:\"hosted_clicks\";i:0;s:8:\"key_desc\";s:16:\"campaign 2 (gif)\";}',1,'openx',0,'2009-03-18 16:53:40',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (248,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:53:27\";s:2:\"is\";s:19:\"2009-03-18 16:53:41\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:53:41',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (249,1,'images',0,NULL,'a:4:{s:8:\"filename\";s:4:\"null\";s:8:\"contents\";s:11:\"Binary data\";s:7:\"t_stamp\";s:4:\"null\";s:8:\"key_desc\";s:10:\"468x60.gif\";}',1,'openx',0,'2009-03-18 16:54:08',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (250,1,'banners',3,NULL,'a:44:{s:8:\"bannerid\";i:3;s:10:\"campaignid\";i:3;s:11:\"contenttype\";s:3:\"gif\";s:13:\"pluginversion\";i:0;s:11:\"storagetype\";s:3:\"sql\";s:8:\"filename\";s:10:\"468x60.gif\";s:8:\"imageurl\";s:0:\"\";s:12:\"htmltemplate\";s:0:\"\";s:9:\"htmlcache\";s:0:\"\";s:5:\"width\";i:468;s:6:\"height\";i:60;s:6:\"weight\";i:1;s:3:\"seq\";i:0;s:6:\"target\";s:0:\"\";s:3:\"url\";s:28:\"https://developer.openx.org/\";s:3:\"alt\";s:8:\"alt text\";s:10:\"statustext\";s:0:\"\";s:10:\"bannertext\";s:0:\"\";s:11:\"description\";s:17:\"sample gif banner\";s:8:\"autohtml\";s:1:\"f\";s:8:\"adserver\";s:0:\"\";s:5:\"block\";i:0;s:7:\"capping\";i:0;s:15:\"session_capping\";i:0;s:18:\"compiledlimitation\";s:0:\"\";s:11:\"acl_plugins\";s:0:\"\";s:6:\"append\";s:0:\"\";s:10:\"appendtype\";i:0;s:10:\"bannertype\";i:0;s:12:\"alt_filename\";s:0:\"\";s:12:\"alt_imageurl\";s:4:\"null\";s:15:\"alt_contenttype\";s:0:\"\";s:8:\"comments\";s:0:\"\";s:7:\"updated\";s:19:\"2009-03-18 16:54:08\";s:12:\"acls_updated\";s:4:\"null\";s:7:\"keyword\";s:0:\"\";s:11:\"transparent\";s:4:\"null\";s:10:\"parameters\";s:2:\"N;\";s:12:\"an_banner_id\";i:0;s:12:\"as_banner_id\";i:0;s:6:\"status\";i:0;s:16:\"ad_direct_status\";i:0;s:29:\"ad_direct_rejection_reason_id\";i:0;s:8:\"key_desc\";s:17:\"sample gif banner\";}',1,'openx',0,'2009-03-18 16:54:08',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (251,1,'ad_zone_assoc',6,NULL,'a:8:{s:16:\"ad_zone_assoc_id\";i:6;s:7:\"zone_id\";i:0;s:5:\"ad_id\";i:3;s:8:\"priority\";i:0;s:9:\"link_type\";i:0;s:15:\"priority_factor\";i:0;s:15:\"to_be_delivered\";s:4:\"null\";s:8:\"key_desc\";s:16:\"Ad #3 -> Zone #0\";}',1,'openx',0,'2009-03-18 16:54:08',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (252,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:53:41\";s:2:\"is\";s:19:\"2009-03-18 16:54:08\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:54:09',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (253,1,'accounts',4,NULL,'a:4:{s:10:\"account_id\";i:4;s:12:\"account_type\";s:10:\"TRAFFICKER\";s:12:\"account_name\";s:18:\"Agency Publisher 1\";s:8:\"key_desc\";s:18:\"Agency Publisher 1\";}',1,'openx',0,'2009-03-18 16:54:24',1,NULL,4);
INSERT INTO `ox_audit` VALUES   (254,1,'affiliates',2,NULL,'a:16:{s:11:\"affiliateid\";i:2;s:8:\"agencyid\";i:1;s:4:\"name\";s:18:\"Agency Publisher 1\";s:8:\"mnemonic\";s:4:\"null\";s:8:\"comments\";s:0:\"\";s:7:\"contact\";s:11:\"Andrew Hill\";s:5:\"email\";s:23:\"andrew.hill@openads.org\";s:7:\"website\";s:17:\"http://fornax.net\";s:7:\"updated\";s:19:\"2009-03-18 16:54:24\";s:13:\"an_website_id\";i:0;s:16:\"oac_country_code\";s:0:\"\";s:15:\"oac_language_id\";i:0;s:15:\"oac_category_id\";i:0;s:13:\"as_website_id\";i:0;s:10:\"account_id\";i:4;s:8:\"key_desc\";s:18:\"Agency Publisher 1\";}',1,'openx',0,'2009-03-18 16:54:24',2,NULL,4);
INSERT INTO `ox_audit` VALUES   (255,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:54:08\";s:2:\"is\";s:19:\"2009-03-18 16:54:25\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:54:25',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (256,1,'zones',1,NULL,'a:32:{s:6:\"zoneid\";i:1;s:11:\"affiliateid\";i:1;s:8:\"zonename\";s:21:\"Publisher 1 - Default\";s:11:\"description\";s:0:\"\";s:8:\"delivery\";i:0;s:8:\"zonetype\";i:3;s:8:\"category\";s:0:\"\";s:5:\"width\";i:468;s:6:\"height\";i:60;s:12:\"ad_selection\";s:0:\"\";s:5:\"chain\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:10:\"appendtype\";i:0;s:11:\"forceappend\";s:4:\"null\";s:23:\"inventory_forecast_type\";i:0;s:8:\"comments\";s:0:\"\";s:4:\"cost\";i:0;s:9:\"cost_type\";i:0;s:16:\"cost_variable_id\";s:4:\"null\";s:15:\"technology_cost\";i:0;s:20:\"technology_cost_type\";i:0;s:7:\"updated\";s:19:\"2009-03-18 16:54:42\";s:5:\"block\";i:0;s:7:\"capping\";i:0;s:15:\"session_capping\";i:0;s:4:\"what\";s:0:\"\";s:10:\"as_zone_id\";i:0;s:15:\"is_in_ad_direct\";s:4:\"null\";s:4:\"rate\";i:0;s:7:\"pricing\";s:4:\"null\";s:8:\"key_desc\";s:21:\"Publisher 1 - Default\";}',1,'openx',0,'2009-03-18 16:54:42',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (257,1,'zones',2,NULL,'a:32:{s:6:\"zoneid\";i:2;s:11:\"affiliateid\";i:1;s:8:\"zonename\";s:28:\"Agency Publisher 1 - Default\";s:11:\"description\";s:0:\"\";s:8:\"delivery\";i:0;s:8:\"zonetype\";i:3;s:8:\"category\";s:0:\"\";s:5:\"width\";i:468;s:6:\"height\";i:60;s:12:\"ad_selection\";s:0:\"\";s:5:\"chain\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:10:\"appendtype\";i:0;s:11:\"forceappend\";s:4:\"null\";s:23:\"inventory_forecast_type\";i:0;s:8:\"comments\";s:0:\"\";s:4:\"cost\";i:0;s:9:\"cost_type\";i:0;s:16:\"cost_variable_id\";s:4:\"null\";s:15:\"technology_cost\";i:0;s:20:\"technology_cost_type\";i:0;s:7:\"updated\";s:19:\"2009-03-18 16:54:43\";s:5:\"block\";i:0;s:7:\"capping\";i:0;s:15:\"session_capping\";i:0;s:4:\"what\";s:0:\"\";s:10:\"as_zone_id\";i:0;s:15:\"is_in_ad_direct\";s:4:\"null\";s:4:\"rate\";i:0;s:7:\"pricing\";s:4:\"null\";s:8:\"key_desc\";s:28:\"Agency Publisher 1 - Default\";}',1,'openx',0,'2009-03-18 16:54:43',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (258,2,'zones',2,NULL,'a:2:{s:8:\"key_desc\";s:28:\"Agency Publisher 1 - Default\";s:11:\"affiliateid\";s:1:\"1\";}',1,'openx',0,'2009-03-18 16:54:44',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (259,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:54:25\";s:2:\"is\";s:19:\"2009-03-18 16:54:45\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:54:45',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (260,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:54:45\";s:2:\"is\";s:19:\"2009-03-18 16:55:01\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:55:01',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (261,1,'placement_zone_assoc',4,NULL,'a:4:{s:23:\"placement_zone_assoc_id\";i:4;s:7:\"zone_id\";i:2;s:12:\"placement_id\";i:1;s:8:\"key_desc\";s:22:\"Campaign #1 -> Zone #2\";}',1,'openx',0,'2009-03-18 16:55:23',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (262,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:55:01\";s:2:\"is\";s:19:\"2009-03-18 16:55:25\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:55:25',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (263,1,'trackers',1,NULL,'a:14:{s:9:\"trackerid\";i:1;s:11:\"trackername\";s:14:\"Sample Tracker\";s:11:\"description\";s:0:\"\";s:8:\"clientid\";i:1;s:10:\"viewwindow\";i:3;s:11:\"clickwindow\";i:3;s:11:\"blockwindow\";i:0;s:6:\"status\";s:1:\"4\";s:4:\"type\";s:4:\"true\";s:13:\"linkcampaigns\";s:1:\"f\";s:14:\"variablemethod\";s:4:\"null\";s:10:\"appendcode\";s:0:\"\";s:7:\"updated\";s:19:\"2009-03-18 16:55:40\";s:8:\"key_desc\";s:14:\"Sample Tracker\";}',1,'openx',0,'2009-03-18 16:55:41',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (264,2,'trackers',1,NULL,'a:3:{s:14:\"variablemethod\";a:2:{s:3:\"was\";s:7:\"default\";s:2:\"is\";s:2:\"js\";}s:8:\"key_desc\";s:14:\"Sample Tracker\";s:8:\"clientid\";s:1:\"1\";}',1,'openx',0,'2009-03-18 16:55:43',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (265,1,'variables',1,NULL,'a:13:{s:10:\"variableid\";i:1;s:9:\"trackerid\";i:1;s:4:\"name\";s:3:\"boo\";s:11:\"description\";s:13:\"Sample number\";s:8:\"datatype\";s:7:\"numeric\";s:7:\"purpose\";s:4:\"NULL\";s:15:\"reject_if_empty\";s:0:\"\";s:9:\"is_unique\";i:0;s:13:\"unique_window\";i:0;s:12:\"variablecode\";s:27:\"var boo = \\\'%%BOO_VALUE%%\\\'\";s:6:\"hidden\";s:1:\"f\";s:7:\"updated\";s:19:\"2009-03-18 16:55:43\";s:8:\"key_desc\";s:3:\"boo\";}',1,'openx',0,'2009-03-18 16:55:43',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (266,1,'variables',2,NULL,'a:13:{s:10:\"variableid\";i:2;s:9:\"trackerid\";i:1;s:4:\"name\";s:3:\"foo\";s:11:\"description\";s:13:\"Sample string\";s:8:\"datatype\";s:6:\"string\";s:7:\"purpose\";s:4:\"NULL\";s:15:\"reject_if_empty\";s:0:\"\";s:9:\"is_unique\";i:0;s:13:\"unique_window\";i:0;s:12:\"variablecode\";s:27:\"var foo = \\\'%%FOO_VALUE%%\\\'\";s:6:\"hidden\";s:1:\"f\";s:7:\"updated\";s:19:\"2009-03-18 16:55:43\";s:8:\"key_desc\";s:3:\"foo\";}',1,'openx',0,'2009-03-18 16:55:43',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (267,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:55:25\";s:2:\"is\";s:19:\"2009-03-18 16:55:46\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:55:46',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (268,3,'campaigns_trackers',1,NULL,'a:7:{s:18:\"campaign_trackerid\";i:1;s:10:\"campaignid\";i:3;s:9:\"trackerid\";i:1;s:10:\"viewwindow\";i:3;s:11:\"clickwindow\";i:3;s:6:\"status\";s:1:\"4\";s:8:\"key_desc\";s:25:\"Campaign #3 -> Tracker #1\";}',1,'openx',0,'2009-03-18 16:56:11',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (269,1,'campaigns_trackers',2,NULL,'a:7:{s:18:\"campaign_trackerid\";i:2;s:10:\"campaignid\";i:3;s:9:\"trackerid\";i:1;s:10:\"viewwindow\";i:3;s:11:\"clickwindow\";i:3;s:6:\"status\";s:1:\"4\";s:8:\"key_desc\";s:25:\"Campaign #3 -> Tracker #1\";}',1,'openx',0,'2009-03-18 16:56:11',2,3,NULL);
INSERT INTO `ox_audit` VALUES   (270,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:55:46\";s:2:\"is\";s:19:\"2009-03-18 16:56:12\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:56:12',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (271,1,'channel',1,NULL,'a:12:{s:9:\"channelid\";i:1;s:8:\"agencyid\";i:1;s:11:\"affiliateid\";i:1;s:4:\"name\";s:20:\"Test Admin Channel 2\";s:11:\"description\";s:0:\"\";s:18:\"compiledlimitation\";s:4:\"true\";s:11:\"acl_plugins\";s:4:\"true\";s:6:\"active\";i:1;s:8:\"comments\";s:0:\"\";s:7:\"updated\";s:4:\"null\";s:12:\"acls_updated\";s:4:\"null\";s:8:\"key_desc\";s:20:\"Test Admin Channel 2\";}',1,'openx',0,'2009-03-18 16:56:47',1,NULL,NULL);
INSERT INTO `ox_audit` VALUES   (272,2,'users',1,NULL,'a:2:{s:15:\"date_last_login\";a:2:{s:3:\"was\";s:19:\"2009-03-18 16:56:12\";s:2:\"is\";s:19:\"2009-03-18 16:58:25\";}s:8:\"key_desc\";N;}',0,NULL,0,'2009-03-18 16:58:25',1,NULL,NULL);
CREATE TABLE `ox_banners` (
  `bannerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `contenttype` enum('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') NOT NULL default 'gif',
  `pluginversion` mediumint(9) NOT NULL default '0',
  `storagetype` enum('sql','web','url','html','network','txt') NOT NULL default 'sql',
  `filename` varchar(255) NOT NULL default '',
  `imageurl` varchar(255) NOT NULL default '',
  `htmltemplate` text NOT NULL,
  `htmlcache` text NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `weight` tinyint(4) NOT NULL default '1',
  `seq` tinyint(4) NOT NULL default '0',
  `target` varchar(16) NOT NULL default '',
  `url` text NOT NULL,
  `alt` varchar(255) NOT NULL default '',
  `statustext` varchar(255) NOT NULL default '',
  `bannertext` text NOT NULL,
  `description` varchar(255) NOT NULL default '',
  `autohtml` enum('t','f') NOT NULL default 't',
  `adserver` varchar(50) NOT NULL default '',
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `compiledlimitation` text NOT NULL,
  `acl_plugins` text,
  `append` text NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `bannertype` tinyint(4) NOT NULL default '0',
  `alt_filename` varchar(255) NOT NULL default '',
  `alt_imageurl` varchar(255) NOT NULL default '',
  `alt_contenttype` enum('gif','jpeg','png') NOT NULL default 'gif',
  `comments` text,
  `updated` datetime NOT NULL,
  `acls_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `keyword` varchar(255) NOT NULL default '',
  `transparent` tinyint(1) NOT NULL default '0',
  `parameters` text,
  `an_banner_id` int(11) default NULL,
  `as_banner_id` int(11) default NULL,
  `status` int(11) NOT NULL default '0',
  `ad_direct_status` tinyint(4) NOT NULL default '0',
  `ad_direct_rejection_reason_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`bannerid`),
  KEY `ox_banners_campaignid` (`campaignid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO `ox_banners` VALUES   (1,1,'html',0,'html','','','Test HTML Banner!\r\n','Test HTML Banner!\r\n',468,60,1,0,'','','','','','Test HTML Banner!','t','',0,0,0,'(MAX_checkSite_Channel(\\\'7\\\', \\\'=~\\\'))','Site:Channel','',0,0,'','','gif','','2008-04-28 11:20:31','2008-04-28 11:20:31','',0,'N;',NULL,NULL,0,0,0);
INSERT INTO `ox_banners` VALUES   (2,2,'html',0,'html','','','html test banner','<a href=\"{clickurl}\" target=\"{target}\">html test banner</a>',468,60,1,0,'','https://developer.openx.org/','','','','test banner','t','max',0,0,0,'',NULL,'',0,0,'','','gif','','2008-04-28 11:53:30','0000-00-00 00:00:00','',0,'N;',NULL,NULL,0,0,0);
INSERT INTO `ox_banners` VALUES   (3,3,'gif',0,'sql','468x60.gif','','','',468,60,1,0,'','https://developer.openx.org/','alt text','','','sample gif banner','f','',0,0,0,'',NULL,'',0,0,'','','','','2009-03-18 16:54:08','0000-00-00 00:00:00','',0,'N;',NULL,NULL,0,0,0);
CREATE TABLE `ox_campaigns` (
  `campaignid` mediumint(9) NOT NULL auto_increment,
  `campaignname` varchar(255) NOT NULL default '',
  `clientid` mediumint(9) NOT NULL default '0',
  `views` int(11) default '-1',
  `clicks` int(11) default '-1',
  `conversions` int(11) default '-1',
  `expire` date default '0000-00-00',
  `activate` date default '0000-00-00',
  `priority` int(11) NOT NULL default '0',
  `weight` tinyint(4) NOT NULL default '1',
  `target_impression` int(11) NOT NULL default '0',
  `target_click` int(11) NOT NULL default '0',
  `target_conversion` int(11) NOT NULL default '0',
  `anonymous` enum('t','f') NOT NULL default 'f',
  `companion` smallint(1) default '0',
  `comments` text,
  `revenue` decimal(10,4) default NULL,
  `revenue_type` smallint(6) default NULL,
  `updated` datetime NOT NULL,
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `an_campaign_id` int(11) default NULL,
  `as_campaign_id` int(11) default NULL,
  `status` int(11) NOT NULL default '0',
  `an_status` int(11) NOT NULL default '0',
  `as_reject_reason` int(11) NOT NULL default '0',
  `hosted_views` int(11) NOT NULL default '0',
  `hosted_clicks` int(11) NOT NULL default '0',
  PRIMARY KEY  (`campaignid`),
  KEY `ox_campaigns_clientid` (`clientid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO `ox_campaigns` VALUES   (1,'Advertiser 1 - Default Campaign',1,-1,-1,-1,'2007-07-01','0000-00-00',0,1,0,0,0,'f',0,'',NULL,NULL,'2009-03-18 16:53:38',0,0,0,NULL,NULL,3,0,0,0,0);
INSERT INTO `ox_campaigns` VALUES   (2,'test campaign',1,-1,-1,-1,'0000-00-00','0000-00-00',0,1,0,0,0,'f',0,'',NULL,NULL,'2009-03-18 16:53:39',0,0,0,NULL,NULL,0,0,0,0,0);
INSERT INTO `ox_campaigns` VALUES   (3,'campaign 2 (gif)',1,-1,-1,-1,'0000-00-00','0000-00-00',0,1,0,0,0,'f',0,'',NULL,NULL,'2009-03-18 16:53:40',0,0,0,NULL,NULL,0,0,0,0,0);
CREATE TABLE `ox_campaigns_trackers` (
  `campaign_trackerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `trackerid` mediumint(9) NOT NULL default '0',
  `viewwindow` mediumint(9) NOT NULL default '0',
  `clickwindow` mediumint(9) NOT NULL default '0',
  `status` smallint(1) unsigned NOT NULL default '4',
  PRIMARY KEY  (`campaign_trackerid`),
  KEY `ox_campaigns_trackers_campaignid` (`campaignid`),
  KEY `ox_campaigns_trackers_trackerid` (`trackerid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
INSERT INTO `ox_campaigns_trackers` VALUES   (2,3,1,3,3,4);
CREATE TABLE `ox_category` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_channel` (
  `channelid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `affiliateid` mediumint(9) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `compiledlimitation` text NOT NULL,
  `acl_plugins` text,
  `active` smallint(1) default NULL,
  `comments` text,
  `updated` datetime NOT NULL,
  `acls_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`channelid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `ox_channel` VALUES   (1,1,1,'Test Admin Channel 2','','true','true',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00');
CREATE TABLE `ox_clients` (
  `clientid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `clientname` varchar(255) NOT NULL default '',
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `report` enum('t','f') NOT NULL default 't',
  `reportinterval` mediumint(9) NOT NULL default '7',
  `reportlastdate` date NOT NULL default '0000-00-00',
  `reportdeactivate` enum('t','f') NOT NULL default 't',
  `comments` text,
  `updated` datetime NOT NULL,
  `lb_reporting` tinyint(1) NOT NULL default '0',
  `an_adnetwork_id` int(11) default NULL,
  `as_advertiser_id` int(11) default NULL,
  `account_id` mediumint(9) default NULL,
  `advertiser_limitation` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`clientid`),
  UNIQUE KEY `ox_clients_account_id` (`account_id`),
  KEY `ox_clients_agencyid` (`agencyid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `ox_clients` VALUES   (1,1,'Advertiser 1','advertiser','example@example.com','f',7,'2009-03-18','t','','2009-03-18 16:53:26',0,NULL,NULL,3,0);
CREATE TABLE `ox_data_intermediate_ad` (
  `data_intermediate_ad_id` bigint(20) NOT NULL auto_increment,
  `date_time` datetime NOT NULL,
  `operation_interval` int(10) unsigned NOT NULL,
  `operation_interval_id` int(10) unsigned NOT NULL,
  `interval_start` datetime NOT NULL,
  `interval_end` datetime NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `creative_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `requests` int(10) unsigned NOT NULL default '0',
  `impressions` int(10) unsigned NOT NULL default '0',
  `clicks` int(10) unsigned NOT NULL default '0',
  `conversions` int(10) unsigned NOT NULL default '0',
  `total_basket_value` decimal(10,4) NOT NULL default '0.0000',
  `total_num_items` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`data_intermediate_ad_id`),
  KEY `ox_data_intermediate_ad_ad_id_date_time` (`ad_id`,`date_time`),
  KEY `ox_data_intermediate_ad_zone_id_date_time` (`zone_id`,`date_time`),
  KEY `ox_data_intermediate_ad_date_time` (`date_time`),
  KEY `ox_data_intermediate_ad_interval_start` (`interval_start`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_intermediate_ad_connection` (
  `data_intermediate_ad_connection_id` bigint(20) NOT NULL auto_increment,
  `server_raw_ip` varchar(16) NOT NULL default '',
  `server_raw_tracker_impression_id` bigint(20) NOT NULL,
  `viewer_id` varchar(32) default NULL,
  `viewer_session_id` varchar(32) default NULL,
  `tracker_date_time` datetime NOT NULL,
  `connection_date_time` datetime default NULL,
  `tracker_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `creative_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `tracker_channel` varchar(255) default NULL,
  `connection_channel` varchar(255) default NULL,
  `tracker_channel_ids` varchar(64) default NULL,
  `connection_channel_ids` varchar(64) default NULL,
  `tracker_language` varchar(13) default NULL,
  `connection_language` varchar(13) default NULL,
  `tracker_ip_address` varchar(16) default NULL,
  `connection_ip_address` varchar(16) default NULL,
  `tracker_host_name` varchar(255) default NULL,
  `connection_host_name` varchar(255) default NULL,
  `tracker_country` char(2) default NULL,
  `connection_country` char(2) default NULL,
  `tracker_https` int(10) unsigned default NULL,
  `connection_https` int(10) unsigned default NULL,
  `tracker_domain` varchar(255) default NULL,
  `connection_domain` varchar(255) default NULL,
  `tracker_page` varchar(255) default NULL,
  `connection_page` varchar(255) default NULL,
  `tracker_query` varchar(255) default NULL,
  `connection_query` varchar(255) default NULL,
  `tracker_referer` varchar(255) default NULL,
  `connection_referer` varchar(255) default NULL,
  `tracker_search_term` varchar(255) default NULL,
  `connection_search_term` varchar(255) default NULL,
  `tracker_user_agent` varchar(255) default NULL,
  `connection_user_agent` varchar(255) default NULL,
  `tracker_os` varchar(32) default NULL,
  `connection_os` varchar(32) default NULL,
  `tracker_browser` varchar(32) default NULL,
  `connection_browser` varchar(32) default NULL,
  `connection_action` int(10) unsigned default NULL,
  `connection_window` int(10) unsigned default NULL,
  `connection_status` int(10) unsigned NOT NULL default '4',
  `inside_window` tinyint(1) NOT NULL default '0',
  `comments` text,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`data_intermediate_ad_connection_id`),
  KEY `ox_data_intermediate_ad_connection_tracker_date_time` (`tracker_date_time`),
  KEY `ox_data_intermediate_ad_connection_tracker_id` (`tracker_id`),
  KEY `ox_data_intermediate_ad_connection_ad_id` (`ad_id`),
  KEY `ox_data_intermediate_ad_connection_zone_id` (`zone_id`),
  KEY `ox_data_intermediate_ad_connection_viewer_id` (`viewer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_intermediate_ad_variable_value` (
  `data_intermediate_ad_variable_value_id` bigint(20) NOT NULL auto_increment,
  `data_intermediate_ad_connection_id` bigint(20) NOT NULL,
  `tracker_variable_id` int(11) NOT NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`data_intermediate_ad_variable_value_id`),
  KEY `ox_data_intermediate_ad_variable_value_data_intermediate_ad_con` (`data_intermediate_ad_connection_id`),
  KEY `ox_data_intermediate_ad_variable_value_tracker_variable_id` (`tracker_variable_id`),
  KEY `ox_data_intermediate_ad_variable_value_tracker_value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_raw_ad_click` (
  `viewer_id` varchar(32) default NULL,
  `viewer_session_id` varchar(32) default NULL,
  `date_time` datetime NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `creative_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `channel` varchar(255) default NULL,
  `channel_ids` varchar(64) default NULL,
  `language` varchar(32) default NULL,
  `ip_address` varchar(16) default NULL,
  `host_name` varchar(255) default NULL,
  `country` char(2) default NULL,
  `https` tinyint(1) default NULL,
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `query` varchar(255) default NULL,
  `referer` varchar(255) default NULL,
  `search_term` varchar(255) default NULL,
  `user_agent` varchar(255) default NULL,
  `os` varchar(32) default NULL,
  `browser` varchar(32) default NULL,
  `max_https` tinyint(1) default NULL,
  `geo_region` varchar(50) default NULL,
  `geo_city` varchar(50) default NULL,
  `geo_postal_code` varchar(10) default NULL,
  `geo_latitude` decimal(8,4) default NULL,
  `geo_longitude` decimal(8,4) default NULL,
  `geo_dma_code` varchar(50) default NULL,
  `geo_area_code` varchar(50) default NULL,
  `geo_organisation` varchar(50) default NULL,
  `geo_netspeed` varchar(20) default NULL,
  `geo_continent` varchar(13) default NULL,
  KEY `ox_data_raw_ad_click_viewer_id` (`viewer_id`),
  KEY `ox_data_raw_ad_click_date_time` (`date_time`),
  KEY `ox_data_raw_ad_click_ad_id` (`ad_id`),
  KEY `ox_data_raw_ad_click_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_raw_ad_impression` (
  `viewer_id` varchar(32) default NULL,
  `viewer_session_id` varchar(32) default NULL,
  `date_time` datetime NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `creative_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `channel` varchar(255) default NULL,
  `channel_ids` varchar(64) default NULL,
  `language` varchar(32) default NULL,
  `ip_address` varchar(16) default NULL,
  `host_name` varchar(255) default NULL,
  `country` char(2) default NULL,
  `https` tinyint(1) default NULL,
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `query` varchar(255) default NULL,
  `referer` varchar(255) default NULL,
  `search_term` varchar(255) default NULL,
  `user_agent` varchar(255) default NULL,
  `os` varchar(32) default NULL,
  `browser` varchar(32) default NULL,
  `max_https` tinyint(1) default NULL,
  `geo_region` varchar(50) default NULL,
  `geo_city` varchar(50) default NULL,
  `geo_postal_code` varchar(10) default NULL,
  `geo_latitude` decimal(8,4) default NULL,
  `geo_longitude` decimal(8,4) default NULL,
  `geo_dma_code` varchar(50) default NULL,
  `geo_area_code` varchar(50) default NULL,
  `geo_organisation` varchar(50) default NULL,
  `geo_netspeed` varchar(20) default NULL,
  `geo_continent` varchar(13) default NULL,
  KEY `ox_data_raw_ad_impression_viewer_id` (`viewer_id`),
  KEY `ox_data_raw_ad_impression_date_time` (`date_time`),
  KEY `ox_data_raw_ad_impression_ad_id` (`ad_id`),
  KEY `ox_data_raw_ad_impression_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_data_raw_ad_impression` VALUES   ('__9e386bbb422a331a0b396cc6c8b528','','2009-03-18 16:58:23',1,0,1,NULL,NULL,'en-us,en;q=0.5','85.221.229.114','85.221.229.114','',NULL,NULL,NULL,NULL,NULL,'',NULL,'','',1,'','','','0.0000','0.0000','','','','','');
CREATE TABLE `ox_data_raw_ad_request` (
  `viewer_id` varchar(32) default NULL,
  `viewer_session_id` varchar(32) default NULL,
  `date_time` datetime NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `creative_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `channel` varchar(255) default NULL,
  `channel_ids` varchar(64) default NULL,
  `language` varchar(32) default NULL,
  `ip_address` varchar(16) default NULL,
  `host_name` varchar(255) default NULL,
  `https` tinyint(1) default NULL,
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `query` varchar(255) default NULL,
  `referer` varchar(255) default NULL,
  `search_term` varchar(255) default NULL,
  `user_agent` varchar(255) default NULL,
  `os` varchar(32) default NULL,
  `browser` varchar(32) default NULL,
  `max_https` tinyint(1) default NULL,
  KEY `ox_data_raw_ad_request_viewer_id` (`viewer_id`),
  KEY `ox_data_raw_ad_request_date_time` (`date_time`),
  KEY `ox_data_raw_ad_request_ad_id` (`ad_id`),
  KEY `ox_data_raw_ad_request_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_raw_tracker_impression` (
  `server_raw_tracker_impression_id` bigint(20) NOT NULL auto_increment,
  `server_raw_ip` varchar(16) NOT NULL default '',
  `viewer_id` varchar(32) NOT NULL default '',
  `viewer_session_id` varchar(32) default NULL,
  `date_time` datetime NOT NULL,
  `tracker_id` int(10) unsigned NOT NULL,
  `channel` varchar(255) default NULL,
  `channel_ids` varchar(64) default NULL,
  `language` varchar(32) default NULL,
  `ip_address` varchar(16) default NULL,
  `host_name` varchar(255) default NULL,
  `country` char(2) default NULL,
  `https` int(10) unsigned default NULL,
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `query` varchar(255) default NULL,
  `referer` varchar(255) default NULL,
  `search_term` varchar(255) default NULL,
  `user_agent` varchar(255) default NULL,
  `os` varchar(32) default NULL,
  `browser` varchar(32) default NULL,
  `max_https` int(10) unsigned default NULL,
  `geo_region` varchar(50) default NULL,
  `geo_city` varchar(50) default NULL,
  `geo_postal_code` varchar(10) default NULL,
  `geo_latitude` decimal(8,4) default NULL,
  `geo_longitude` decimal(8,4) default NULL,
  `geo_dma_code` varchar(50) default NULL,
  `geo_area_code` varchar(50) default NULL,
  `geo_organisation` varchar(50) default NULL,
  `geo_netspeed` varchar(20) default NULL,
  `geo_continent` varchar(13) default NULL,
  PRIMARY KEY  (`server_raw_tracker_impression_id`,`server_raw_ip`),
  KEY `ox_data_raw_tracker_impression_viewer_id` (`viewer_id`),
  KEY `ox_data_raw_tracker_impression_date_time` (`date_time`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
INSERT INTO `ox_data_raw_tracker_impression` VALUES   (7,'singleDB','__9e386bbb422a331a0b396cc6c8b528','','2009-03-18 16:58:25',1,'','','en-us,en;q=0.5','85.221.229.114','85.221.229.114','',0,'','','','','','Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1','','',1,'','','','0.0000','0.0000','','','','','');
INSERT INTO `ox_data_raw_tracker_impression` VALUES   (8,'singleDB','__9e386bbb422a331a0b396cc6c8b528','','2009-03-18 16:58:25',1,'','','en-us,en;q=0.5','85.221.229.114','85.221.229.114','',0,'','','','','','Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1','','',1,'','','','0.0000','0.0000','','','','','');
CREATE TABLE `ox_data_raw_tracker_variable_value` (
  `server_raw_tracker_impression_id` bigint(20) NOT NULL,
  `server_raw_ip` varchar(16) NOT NULL default '',
  `tracker_variable_id` int(11) NOT NULL,
  `date_time` datetime default NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`server_raw_tracker_impression_id`,`server_raw_ip`,`tracker_variable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_data_raw_tracker_variable_value` VALUES   (7,'singleDB',1,'2009-03-18 16:58:25','123');
INSERT INTO `ox_data_raw_tracker_variable_value` VALUES   (7,'singleDB',2,'2009-03-18 16:58:25','test_string');
CREATE TABLE `ox_data_summary_ad_hourly` (
  `data_summary_ad_hourly_id` bigint(20) NOT NULL auto_increment,
  `date_time` datetime NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `creative_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `requests` int(10) unsigned NOT NULL default '0',
  `impressions` int(10) unsigned NOT NULL default '0',
  `clicks` int(10) unsigned NOT NULL default '0',
  `conversions` int(10) unsigned NOT NULL default '0',
  `total_basket_value` decimal(10,4) default NULL,
  `total_num_items` int(11) default NULL,
  `total_revenue` decimal(10,4) default NULL,
  `total_cost` decimal(10,4) default NULL,
  `total_techcost` decimal(10,4) default NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`data_summary_ad_hourly_id`),
  KEY `ox_data_summary_ad_hourly_date_time` (`date_time`),
  KEY `ox_data_summary_ad_hourly_ad_id_date_time` (`ad_id`,`date_time`),
  KEY `ox_data_summary_ad_hourly_zone_id_date_time` (`zone_id`,`date_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_summary_ad_zone_assoc` (
  `data_summary_ad_zone_assoc_id` bigint(20) NOT NULL auto_increment,
  `operation_interval` int(10) unsigned NOT NULL,
  `operation_interval_id` int(10) unsigned NOT NULL,
  `interval_start` datetime NOT NULL,
  `interval_end` datetime NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `required_impressions` int(10) unsigned NOT NULL,
  `requested_impressions` int(10) unsigned NOT NULL,
  `priority` double NOT NULL,
  `priority_factor` double default NULL,
  `priority_factor_limited` smallint(6) NOT NULL default '0',
  `past_zone_traffic_fraction` double default NULL,
  `created` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `expired` datetime default NULL,
  `expired_by` int(10) unsigned default NULL,
  `to_be_delivered` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`data_summary_ad_zone_assoc_id`),
  KEY `ox_data_summary_ad_zone_assoc_interval_start` (`interval_start`),
  KEY `ox_data_summary_ad_zone_assoc_interval_end` (`interval_end`),
  KEY `ox_data_summary_ad_zone_assoc_ad_id` (`ad_id`),
  KEY `ox_data_summary_ad_zone_assoc_zone_id` (`zone_id`),
  KEY `ox_data_summary_ad_zone_assoc_expired` (`expired`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_summary_channel_daily` (
  `data_summary_channel_daily_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `forecast_impressions` int(10) unsigned NOT NULL default '0',
  `actual_impressions` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`data_summary_channel_daily_id`),
  KEY `ox_data_summary_channel_daily_day` (`day`),
  KEY `ox_data_summary_channel_daily_channel_id` (`channel_id`),
  KEY `ox_data_summary_channel_daily_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_data_summary_zone_impression_history` (
  `data_summary_zone_impression_history_id` bigint(20) NOT NULL auto_increment,
  `operation_interval` int(10) unsigned NOT NULL,
  `operation_interval_id` int(10) unsigned NOT NULL,
  `interval_start` datetime NOT NULL,
  `interval_end` datetime NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `forecast_impressions` int(10) unsigned default NULL,
  `actual_impressions` int(10) unsigned default NULL,
  `est` smallint(6) default NULL,
  PRIMARY KEY  (`data_summary_zone_impression_history_id`),
  KEY `ox_data_summary_zone_impression_history_operation_interval_id` (`operation_interval_id`),
  KEY `ox_data_summary_zone_impression_history_zone_id` (`zone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=505 DEFAULT CHARSET=utf8;
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (1,60,89,'2009-03-11 17:00:00','2009-03-11 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (2,60,90,'2009-03-11 18:00:00','2009-03-11 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (3,60,91,'2009-03-11 19:00:00','2009-03-11 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (4,60,92,'2009-03-11 20:00:00','2009-03-11 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (5,60,93,'2009-03-11 21:00:00','2009-03-11 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (6,60,94,'2009-03-11 22:00:00','2009-03-11 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (7,60,95,'2009-03-11 23:00:00','2009-03-11 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (8,60,96,'2009-03-12 00:00:00','2009-03-12 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (9,60,97,'2009-03-12 01:00:00','2009-03-12 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (10,60,98,'2009-03-12 02:00:00','2009-03-12 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (11,60,99,'2009-03-12 03:00:00','2009-03-12 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (12,60,100,'2009-03-12 04:00:00','2009-03-12 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (13,60,101,'2009-03-12 05:00:00','2009-03-12 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (14,60,102,'2009-03-12 06:00:00','2009-03-12 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (15,60,103,'2009-03-12 07:00:00','2009-03-12 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (16,60,104,'2009-03-12 08:00:00','2009-03-12 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (17,60,105,'2009-03-12 09:00:00','2009-03-12 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (18,60,106,'2009-03-12 10:00:00','2009-03-12 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (19,60,107,'2009-03-12 11:00:00','2009-03-12 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (20,60,108,'2009-03-12 12:00:00','2009-03-12 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (21,60,109,'2009-03-12 13:00:00','2009-03-12 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (22,60,110,'2009-03-12 14:00:00','2009-03-12 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (23,60,111,'2009-03-12 15:00:00','2009-03-12 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (24,60,112,'2009-03-12 16:00:00','2009-03-12 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (25,60,113,'2009-03-12 17:00:00','2009-03-12 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (26,60,114,'2009-03-12 18:00:00','2009-03-12 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (27,60,115,'2009-03-12 19:00:00','2009-03-12 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (28,60,116,'2009-03-12 20:00:00','2009-03-12 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (29,60,117,'2009-03-12 21:00:00','2009-03-12 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (30,60,118,'2009-03-12 22:00:00','2009-03-12 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (31,60,119,'2009-03-12 23:00:00','2009-03-12 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (32,60,120,'2009-03-13 00:00:00','2009-03-13 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (33,60,121,'2009-03-13 01:00:00','2009-03-13 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (34,60,122,'2009-03-13 02:00:00','2009-03-13 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (35,60,123,'2009-03-13 03:00:00','2009-03-13 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (36,60,124,'2009-03-13 04:00:00','2009-03-13 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (37,60,125,'2009-03-13 05:00:00','2009-03-13 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (38,60,126,'2009-03-13 06:00:00','2009-03-13 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (39,60,127,'2009-03-13 07:00:00','2009-03-13 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (40,60,128,'2009-03-13 08:00:00','2009-03-13 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (41,60,129,'2009-03-13 09:00:00','2009-03-13 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (42,60,130,'2009-03-13 10:00:00','2009-03-13 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (43,60,131,'2009-03-13 11:00:00','2009-03-13 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (44,60,132,'2009-03-13 12:00:00','2009-03-13 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (45,60,133,'2009-03-13 13:00:00','2009-03-13 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (46,60,134,'2009-03-13 14:00:00','2009-03-13 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (47,60,135,'2009-03-13 15:00:00','2009-03-13 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (48,60,136,'2009-03-13 16:00:00','2009-03-13 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (49,60,137,'2009-03-13 17:00:00','2009-03-13 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (50,60,138,'2009-03-13 18:00:00','2009-03-13 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (51,60,139,'2009-03-13 19:00:00','2009-03-13 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (52,60,140,'2009-03-13 20:00:00','2009-03-13 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (53,60,141,'2009-03-13 21:00:00','2009-03-13 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (54,60,142,'2009-03-13 22:00:00','2009-03-13 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (55,60,143,'2009-03-13 23:00:00','2009-03-13 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (56,60,144,'2009-03-14 00:00:00','2009-03-14 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (57,60,145,'2009-03-14 01:00:00','2009-03-14 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (58,60,146,'2009-03-14 02:00:00','2009-03-14 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (59,60,147,'2009-03-14 03:00:00','2009-03-14 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (60,60,148,'2009-03-14 04:00:00','2009-03-14 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (61,60,149,'2009-03-14 05:00:00','2009-03-14 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (62,60,150,'2009-03-14 06:00:00','2009-03-14 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (63,60,151,'2009-03-14 07:00:00','2009-03-14 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (64,60,152,'2009-03-14 08:00:00','2009-03-14 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (65,60,153,'2009-03-14 09:00:00','2009-03-14 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (66,60,154,'2009-03-14 10:00:00','2009-03-14 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (67,60,155,'2009-03-14 11:00:00','2009-03-14 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (68,60,156,'2009-03-14 12:00:00','2009-03-14 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (69,60,157,'2009-03-14 13:00:00','2009-03-14 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (70,60,158,'2009-03-14 14:00:00','2009-03-14 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (71,60,159,'2009-03-14 15:00:00','2009-03-14 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (72,60,160,'2009-03-14 16:00:00','2009-03-14 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (73,60,161,'2009-03-14 17:00:00','2009-03-14 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (74,60,162,'2009-03-14 18:00:00','2009-03-14 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (75,60,163,'2009-03-14 19:00:00','2009-03-14 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (76,60,164,'2009-03-14 20:00:00','2009-03-14 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (77,60,165,'2009-03-14 21:00:00','2009-03-14 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (78,60,166,'2009-03-14 22:00:00','2009-03-14 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (79,60,167,'2009-03-14 23:00:00','2009-03-14 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (80,60,0,'2009-03-15 00:00:00','2009-03-15 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (81,60,1,'2009-03-15 01:00:00','2009-03-15 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (82,60,2,'2009-03-15 02:00:00','2009-03-15 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (83,60,3,'2009-03-15 03:00:00','2009-03-15 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (84,60,4,'2009-03-15 04:00:00','2009-03-15 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (85,60,5,'2009-03-15 05:00:00','2009-03-15 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (86,60,6,'2009-03-15 06:00:00','2009-03-15 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (87,60,7,'2009-03-15 07:00:00','2009-03-15 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (88,60,8,'2009-03-15 08:00:00','2009-03-15 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (89,60,9,'2009-03-15 09:00:00','2009-03-15 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (90,60,10,'2009-03-15 10:00:00','2009-03-15 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (91,60,11,'2009-03-15 11:00:00','2009-03-15 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (92,60,12,'2009-03-15 12:00:00','2009-03-15 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (93,60,13,'2009-03-15 13:00:00','2009-03-15 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (94,60,14,'2009-03-15 14:00:00','2009-03-15 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (95,60,15,'2009-03-15 15:00:00','2009-03-15 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (96,60,16,'2009-03-15 16:00:00','2009-03-15 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (97,60,17,'2009-03-15 17:00:00','2009-03-15 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (98,60,18,'2009-03-15 18:00:00','2009-03-15 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (99,60,19,'2009-03-15 19:00:00','2009-03-15 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (100,60,20,'2009-03-15 20:00:00','2009-03-15 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (101,60,21,'2009-03-15 21:00:00','2009-03-15 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (102,60,22,'2009-03-15 22:00:00','2009-03-15 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (103,60,23,'2009-03-15 23:00:00','2009-03-15 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (104,60,24,'2009-03-16 00:00:00','2009-03-16 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (105,60,25,'2009-03-16 01:00:00','2009-03-16 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (106,60,26,'2009-03-16 02:00:00','2009-03-16 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (107,60,27,'2009-03-16 03:00:00','2009-03-16 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (108,60,28,'2009-03-16 04:00:00','2009-03-16 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (109,60,29,'2009-03-16 05:00:00','2009-03-16 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (110,60,30,'2009-03-16 06:00:00','2009-03-16 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (111,60,31,'2009-03-16 07:00:00','2009-03-16 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (112,60,32,'2009-03-16 08:00:00','2009-03-16 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (113,60,33,'2009-03-16 09:00:00','2009-03-16 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (114,60,34,'2009-03-16 10:00:00','2009-03-16 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (115,60,35,'2009-03-16 11:00:00','2009-03-16 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (116,60,36,'2009-03-16 12:00:00','2009-03-16 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (117,60,37,'2009-03-16 13:00:00','2009-03-16 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (118,60,38,'2009-03-16 14:00:00','2009-03-16 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (119,60,39,'2009-03-16 15:00:00','2009-03-16 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (120,60,40,'2009-03-16 16:00:00','2009-03-16 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (121,60,41,'2009-03-16 17:00:00','2009-03-16 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (122,60,42,'2009-03-16 18:00:00','2009-03-16 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (123,60,43,'2009-03-16 19:00:00','2009-03-16 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (124,60,44,'2009-03-16 20:00:00','2009-03-16 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (125,60,45,'2009-03-16 21:00:00','2009-03-16 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (126,60,46,'2009-03-16 22:00:00','2009-03-16 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (127,60,47,'2009-03-16 23:00:00','2009-03-16 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (128,60,48,'2009-03-17 00:00:00','2009-03-17 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (129,60,49,'2009-03-17 01:00:00','2009-03-17 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (130,60,50,'2009-03-17 02:00:00','2009-03-17 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (131,60,51,'2009-03-17 03:00:00','2009-03-17 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (132,60,52,'2009-03-17 04:00:00','2009-03-17 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (133,60,53,'2009-03-17 05:00:00','2009-03-17 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (134,60,54,'2009-03-17 06:00:00','2009-03-17 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (135,60,55,'2009-03-17 07:00:00','2009-03-17 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (136,60,56,'2009-03-17 08:00:00','2009-03-17 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (137,60,57,'2009-03-17 09:00:00','2009-03-17 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (138,60,58,'2009-03-17 10:00:00','2009-03-17 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (139,60,59,'2009-03-17 11:00:00','2009-03-17 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (140,60,60,'2009-03-17 12:00:00','2009-03-17 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (141,60,61,'2009-03-17 13:00:00','2009-03-17 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (142,60,62,'2009-03-17 14:00:00','2009-03-17 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (143,60,63,'2009-03-17 15:00:00','2009-03-17 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (144,60,64,'2009-03-17 16:00:00','2009-03-17 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (145,60,65,'2009-03-17 17:00:00','2009-03-17 17:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (146,60,66,'2009-03-17 18:00:00','2009-03-17 18:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (147,60,67,'2009-03-17 19:00:00','2009-03-17 19:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (148,60,68,'2009-03-17 20:00:00','2009-03-17 20:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (149,60,69,'2009-03-17 21:00:00','2009-03-17 21:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (150,60,70,'2009-03-17 22:00:00','2009-03-17 22:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (151,60,71,'2009-03-17 23:00:00','2009-03-17 23:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (152,60,72,'2009-03-18 00:00:00','2009-03-18 00:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (153,60,73,'2009-03-18 01:00:00','2009-03-18 01:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (154,60,74,'2009-03-18 02:00:00','2009-03-18 02:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (155,60,75,'2009-03-18 03:00:00','2009-03-18 03:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (156,60,76,'2009-03-18 04:00:00','2009-03-18 04:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (157,60,77,'2009-03-18 05:00:00','2009-03-18 05:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (158,60,78,'2009-03-18 06:00:00','2009-03-18 06:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (159,60,79,'2009-03-18 07:00:00','2009-03-18 07:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (160,60,80,'2009-03-18 08:00:00','2009-03-18 08:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (161,60,81,'2009-03-18 09:00:00','2009-03-18 09:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (162,60,82,'2009-03-18 10:00:00','2009-03-18 10:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (163,60,83,'2009-03-18 11:00:00','2009-03-18 11:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (164,60,84,'2009-03-18 12:00:00','2009-03-18 12:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (165,60,85,'2009-03-18 13:00:00','2009-03-18 13:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (166,60,86,'2009-03-18 14:00:00','2009-03-18 14:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (167,60,87,'2009-03-18 15:00:00','2009-03-18 15:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (168,60,88,'2009-03-18 16:00:00','2009-03-18 16:59:59',0,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (169,60,89,'2009-03-11 17:00:00','2009-03-11 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (170,60,90,'2009-03-11 18:00:00','2009-03-11 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (171,60,91,'2009-03-11 19:00:00','2009-03-11 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (172,60,92,'2009-03-11 20:00:00','2009-03-11 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (173,60,93,'2009-03-11 21:00:00','2009-03-11 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (174,60,94,'2009-03-11 22:00:00','2009-03-11 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (175,60,95,'2009-03-11 23:00:00','2009-03-11 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (176,60,96,'2009-03-12 00:00:00','2009-03-12 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (177,60,97,'2009-03-12 01:00:00','2009-03-12 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (178,60,98,'2009-03-12 02:00:00','2009-03-12 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (179,60,99,'2009-03-12 03:00:00','2009-03-12 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (180,60,100,'2009-03-12 04:00:00','2009-03-12 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (181,60,101,'2009-03-12 05:00:00','2009-03-12 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (182,60,102,'2009-03-12 06:00:00','2009-03-12 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (183,60,103,'2009-03-12 07:00:00','2009-03-12 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (184,60,104,'2009-03-12 08:00:00','2009-03-12 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (185,60,105,'2009-03-12 09:00:00','2009-03-12 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (186,60,106,'2009-03-12 10:00:00','2009-03-12 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (187,60,107,'2009-03-12 11:00:00','2009-03-12 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (188,60,108,'2009-03-12 12:00:00','2009-03-12 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (189,60,109,'2009-03-12 13:00:00','2009-03-12 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (190,60,110,'2009-03-12 14:00:00','2009-03-12 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (191,60,111,'2009-03-12 15:00:00','2009-03-12 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (192,60,112,'2009-03-12 16:00:00','2009-03-12 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (193,60,113,'2009-03-12 17:00:00','2009-03-12 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (194,60,114,'2009-03-12 18:00:00','2009-03-12 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (195,60,115,'2009-03-12 19:00:00','2009-03-12 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (196,60,116,'2009-03-12 20:00:00','2009-03-12 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (197,60,117,'2009-03-12 21:00:00','2009-03-12 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (198,60,118,'2009-03-12 22:00:00','2009-03-12 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (199,60,119,'2009-03-12 23:00:00','2009-03-12 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (200,60,120,'2009-03-13 00:00:00','2009-03-13 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (201,60,121,'2009-03-13 01:00:00','2009-03-13 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (202,60,122,'2009-03-13 02:00:00','2009-03-13 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (203,60,123,'2009-03-13 03:00:00','2009-03-13 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (204,60,124,'2009-03-13 04:00:00','2009-03-13 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (205,60,125,'2009-03-13 05:00:00','2009-03-13 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (206,60,126,'2009-03-13 06:00:00','2009-03-13 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (207,60,127,'2009-03-13 07:00:00','2009-03-13 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (208,60,128,'2009-03-13 08:00:00','2009-03-13 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (209,60,129,'2009-03-13 09:00:00','2009-03-13 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (210,60,130,'2009-03-13 10:00:00','2009-03-13 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (211,60,131,'2009-03-13 11:00:00','2009-03-13 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (212,60,132,'2009-03-13 12:00:00','2009-03-13 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (213,60,133,'2009-03-13 13:00:00','2009-03-13 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (214,60,134,'2009-03-13 14:00:00','2009-03-13 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (215,60,135,'2009-03-13 15:00:00','2009-03-13 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (216,60,136,'2009-03-13 16:00:00','2009-03-13 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (217,60,137,'2009-03-13 17:00:00','2009-03-13 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (218,60,138,'2009-03-13 18:00:00','2009-03-13 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (219,60,139,'2009-03-13 19:00:00','2009-03-13 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (220,60,140,'2009-03-13 20:00:00','2009-03-13 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (221,60,141,'2009-03-13 21:00:00','2009-03-13 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (222,60,142,'2009-03-13 22:00:00','2009-03-13 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (223,60,143,'2009-03-13 23:00:00','2009-03-13 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (224,60,144,'2009-03-14 00:00:00','2009-03-14 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (225,60,145,'2009-03-14 01:00:00','2009-03-14 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (226,60,146,'2009-03-14 02:00:00','2009-03-14 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (227,60,147,'2009-03-14 03:00:00','2009-03-14 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (228,60,148,'2009-03-14 04:00:00','2009-03-14 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (229,60,149,'2009-03-14 05:00:00','2009-03-14 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (230,60,150,'2009-03-14 06:00:00','2009-03-14 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (231,60,151,'2009-03-14 07:00:00','2009-03-14 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (232,60,152,'2009-03-14 08:00:00','2009-03-14 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (233,60,153,'2009-03-14 09:00:00','2009-03-14 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (234,60,154,'2009-03-14 10:00:00','2009-03-14 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (235,60,155,'2009-03-14 11:00:00','2009-03-14 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (236,60,156,'2009-03-14 12:00:00','2009-03-14 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (237,60,157,'2009-03-14 13:00:00','2009-03-14 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (238,60,158,'2009-03-14 14:00:00','2009-03-14 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (239,60,159,'2009-03-14 15:00:00','2009-03-14 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (240,60,160,'2009-03-14 16:00:00','2009-03-14 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (241,60,161,'2009-03-14 17:00:00','2009-03-14 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (242,60,162,'2009-03-14 18:00:00','2009-03-14 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (243,60,163,'2009-03-14 19:00:00','2009-03-14 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (244,60,164,'2009-03-14 20:00:00','2009-03-14 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (245,60,165,'2009-03-14 21:00:00','2009-03-14 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (246,60,166,'2009-03-14 22:00:00','2009-03-14 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (247,60,167,'2009-03-14 23:00:00','2009-03-14 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (248,60,0,'2009-03-15 00:00:00','2009-03-15 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (249,60,1,'2009-03-15 01:00:00','2009-03-15 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (250,60,2,'2009-03-15 02:00:00','2009-03-15 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (251,60,3,'2009-03-15 03:00:00','2009-03-15 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (252,60,4,'2009-03-15 04:00:00','2009-03-15 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (253,60,5,'2009-03-15 05:00:00','2009-03-15 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (254,60,6,'2009-03-15 06:00:00','2009-03-15 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (255,60,7,'2009-03-15 07:00:00','2009-03-15 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (256,60,8,'2009-03-15 08:00:00','2009-03-15 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (257,60,9,'2009-03-15 09:00:00','2009-03-15 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (258,60,10,'2009-03-15 10:00:00','2009-03-15 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (259,60,11,'2009-03-15 11:00:00','2009-03-15 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (260,60,12,'2009-03-15 12:00:00','2009-03-15 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (261,60,13,'2009-03-15 13:00:00','2009-03-15 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (262,60,14,'2009-03-15 14:00:00','2009-03-15 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (263,60,15,'2009-03-15 15:00:00','2009-03-15 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (264,60,16,'2009-03-15 16:00:00','2009-03-15 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (265,60,17,'2009-03-15 17:00:00','2009-03-15 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (266,60,18,'2009-03-15 18:00:00','2009-03-15 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (267,60,19,'2009-03-15 19:00:00','2009-03-15 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (268,60,20,'2009-03-15 20:00:00','2009-03-15 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (269,60,21,'2009-03-15 21:00:00','2009-03-15 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (270,60,22,'2009-03-15 22:00:00','2009-03-15 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (271,60,23,'2009-03-15 23:00:00','2009-03-15 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (272,60,24,'2009-03-16 00:00:00','2009-03-16 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (273,60,25,'2009-03-16 01:00:00','2009-03-16 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (274,60,26,'2009-03-16 02:00:00','2009-03-16 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (275,60,27,'2009-03-16 03:00:00','2009-03-16 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (276,60,28,'2009-03-16 04:00:00','2009-03-16 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (277,60,29,'2009-03-16 05:00:00','2009-03-16 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (278,60,30,'2009-03-16 06:00:00','2009-03-16 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (279,60,31,'2009-03-16 07:00:00','2009-03-16 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (280,60,32,'2009-03-16 08:00:00','2009-03-16 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (281,60,33,'2009-03-16 09:00:00','2009-03-16 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (282,60,34,'2009-03-16 10:00:00','2009-03-16 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (283,60,35,'2009-03-16 11:00:00','2009-03-16 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (284,60,36,'2009-03-16 12:00:00','2009-03-16 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (285,60,37,'2009-03-16 13:00:00','2009-03-16 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (286,60,38,'2009-03-16 14:00:00','2009-03-16 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (287,60,39,'2009-03-16 15:00:00','2009-03-16 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (288,60,40,'2009-03-16 16:00:00','2009-03-16 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (289,60,41,'2009-03-16 17:00:00','2009-03-16 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (290,60,42,'2009-03-16 18:00:00','2009-03-16 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (291,60,43,'2009-03-16 19:00:00','2009-03-16 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (292,60,44,'2009-03-16 20:00:00','2009-03-16 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (293,60,45,'2009-03-16 21:00:00','2009-03-16 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (294,60,46,'2009-03-16 22:00:00','2009-03-16 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (295,60,47,'2009-03-16 23:00:00','2009-03-16 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (296,60,48,'2009-03-17 00:00:00','2009-03-17 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (297,60,49,'2009-03-17 01:00:00','2009-03-17 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (298,60,50,'2009-03-17 02:00:00','2009-03-17 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (299,60,51,'2009-03-17 03:00:00','2009-03-17 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (300,60,52,'2009-03-17 04:00:00','2009-03-17 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (301,60,53,'2009-03-17 05:00:00','2009-03-17 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (302,60,54,'2009-03-17 06:00:00','2009-03-17 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (303,60,55,'2009-03-17 07:00:00','2009-03-17 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (304,60,56,'2009-03-17 08:00:00','2009-03-17 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (305,60,57,'2009-03-17 09:00:00','2009-03-17 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (306,60,58,'2009-03-17 10:00:00','2009-03-17 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (307,60,59,'2009-03-17 11:00:00','2009-03-17 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (308,60,60,'2009-03-17 12:00:00','2009-03-17 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (309,60,61,'2009-03-17 13:00:00','2009-03-17 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (310,60,62,'2009-03-17 14:00:00','2009-03-17 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (311,60,63,'2009-03-17 15:00:00','2009-03-17 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (312,60,64,'2009-03-17 16:00:00','2009-03-17 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (313,60,65,'2009-03-17 17:00:00','2009-03-17 17:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (314,60,66,'2009-03-17 18:00:00','2009-03-17 18:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (315,60,67,'2009-03-17 19:00:00','2009-03-17 19:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (316,60,68,'2009-03-17 20:00:00','2009-03-17 20:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (317,60,69,'2009-03-17 21:00:00','2009-03-17 21:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (318,60,70,'2009-03-17 22:00:00','2009-03-17 22:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (319,60,71,'2009-03-17 23:00:00','2009-03-17 23:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (320,60,72,'2009-03-18 00:00:00','2009-03-18 00:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (321,60,73,'2009-03-18 01:00:00','2009-03-18 01:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (322,60,74,'2009-03-18 02:00:00','2009-03-18 02:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (323,60,75,'2009-03-18 03:00:00','2009-03-18 03:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (324,60,76,'2009-03-18 04:00:00','2009-03-18 04:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (325,60,77,'2009-03-18 05:00:00','2009-03-18 05:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (326,60,78,'2009-03-18 06:00:00','2009-03-18 06:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (327,60,79,'2009-03-18 07:00:00','2009-03-18 07:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (328,60,80,'2009-03-18 08:00:00','2009-03-18 08:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (329,60,81,'2009-03-18 09:00:00','2009-03-18 09:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (330,60,82,'2009-03-18 10:00:00','2009-03-18 10:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (331,60,83,'2009-03-18 11:00:00','2009-03-18 11:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (332,60,84,'2009-03-18 12:00:00','2009-03-18 12:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (333,60,85,'2009-03-18 13:00:00','2009-03-18 13:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (334,60,86,'2009-03-18 14:00:00','2009-03-18 14:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (335,60,87,'2009-03-18 15:00:00','2009-03-18 15:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (336,60,88,'2009-03-18 16:00:00','2009-03-18 16:59:59',1,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (337,60,89,'2009-03-11 17:00:00','2009-03-11 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (338,60,90,'2009-03-11 18:00:00','2009-03-11 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (339,60,91,'2009-03-11 19:00:00','2009-03-11 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (340,60,92,'2009-03-11 20:00:00','2009-03-11 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (341,60,93,'2009-03-11 21:00:00','2009-03-11 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (342,60,94,'2009-03-11 22:00:00','2009-03-11 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (343,60,95,'2009-03-11 23:00:00','2009-03-11 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (344,60,96,'2009-03-12 00:00:00','2009-03-12 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (345,60,97,'2009-03-12 01:00:00','2009-03-12 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (346,60,98,'2009-03-12 02:00:00','2009-03-12 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (347,60,99,'2009-03-12 03:00:00','2009-03-12 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (348,60,100,'2009-03-12 04:00:00','2009-03-12 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (349,60,101,'2009-03-12 05:00:00','2009-03-12 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (350,60,102,'2009-03-12 06:00:00','2009-03-12 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (351,60,103,'2009-03-12 07:00:00','2009-03-12 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (352,60,104,'2009-03-12 08:00:00','2009-03-12 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (353,60,105,'2009-03-12 09:00:00','2009-03-12 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (354,60,106,'2009-03-12 10:00:00','2009-03-12 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (355,60,107,'2009-03-12 11:00:00','2009-03-12 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (356,60,108,'2009-03-12 12:00:00','2009-03-12 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (357,60,109,'2009-03-12 13:00:00','2009-03-12 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (358,60,110,'2009-03-12 14:00:00','2009-03-12 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (359,60,111,'2009-03-12 15:00:00','2009-03-12 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (360,60,112,'2009-03-12 16:00:00','2009-03-12 16:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (361,60,113,'2009-03-12 17:00:00','2009-03-12 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (362,60,114,'2009-03-12 18:00:00','2009-03-12 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (363,60,115,'2009-03-12 19:00:00','2009-03-12 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (364,60,116,'2009-03-12 20:00:00','2009-03-12 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (365,60,117,'2009-03-12 21:00:00','2009-03-12 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (366,60,118,'2009-03-12 22:00:00','2009-03-12 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (367,60,119,'2009-03-12 23:00:00','2009-03-12 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (368,60,120,'2009-03-13 00:00:00','2009-03-13 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (369,60,121,'2009-03-13 01:00:00','2009-03-13 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (370,60,122,'2009-03-13 02:00:00','2009-03-13 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (371,60,123,'2009-03-13 03:00:00','2009-03-13 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (372,60,124,'2009-03-13 04:00:00','2009-03-13 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (373,60,125,'2009-03-13 05:00:00','2009-03-13 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (374,60,126,'2009-03-13 06:00:00','2009-03-13 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (375,60,127,'2009-03-13 07:00:00','2009-03-13 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (376,60,128,'2009-03-13 08:00:00','2009-03-13 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (377,60,129,'2009-03-13 09:00:00','2009-03-13 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (378,60,130,'2009-03-13 10:00:00','2009-03-13 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (379,60,131,'2009-03-13 11:00:00','2009-03-13 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (380,60,132,'2009-03-13 12:00:00','2009-03-13 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (381,60,133,'2009-03-13 13:00:00','2009-03-13 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (382,60,134,'2009-03-13 14:00:00','2009-03-13 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (383,60,135,'2009-03-13 15:00:00','2009-03-13 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (384,60,136,'2009-03-13 16:00:00','2009-03-13 16:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (385,60,137,'2009-03-13 17:00:00','2009-03-13 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (386,60,138,'2009-03-13 18:00:00','2009-03-13 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (387,60,139,'2009-03-13 19:00:00','2009-03-13 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (388,60,140,'2009-03-13 20:00:00','2009-03-13 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (389,60,141,'2009-03-13 21:00:00','2009-03-13 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (390,60,142,'2009-03-13 22:00:00','2009-03-13 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (391,60,143,'2009-03-13 23:00:00','2009-03-13 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (392,60,144,'2009-03-14 00:00:00','2009-03-14 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (393,60,145,'2009-03-14 01:00:00','2009-03-14 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (394,60,146,'2009-03-14 02:00:00','2009-03-14 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (395,60,147,'2009-03-14 03:00:00','2009-03-14 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (396,60,148,'2009-03-14 04:00:00','2009-03-14 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (397,60,149,'2009-03-14 05:00:00','2009-03-14 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (398,60,150,'2009-03-14 06:00:00','2009-03-14 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (399,60,151,'2009-03-14 07:00:00','2009-03-14 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (400,60,152,'2009-03-14 08:00:00','2009-03-14 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (401,60,153,'2009-03-14 09:00:00','2009-03-14 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (402,60,154,'2009-03-14 10:00:00','2009-03-14 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (403,60,155,'2009-03-14 11:00:00','2009-03-14 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (404,60,156,'2009-03-14 12:00:00','2009-03-14 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (405,60,157,'2009-03-14 13:00:00','2009-03-14 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (406,60,158,'2009-03-14 14:00:00','2009-03-14 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (407,60,159,'2009-03-14 15:00:00','2009-03-14 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (408,60,160,'2009-03-14 16:00:00','2009-03-14 16:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (409,60,161,'2009-03-14 17:00:00','2009-03-14 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (410,60,162,'2009-03-14 18:00:00','2009-03-14 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (411,60,163,'2009-03-14 19:00:00','2009-03-14 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (412,60,164,'2009-03-14 20:00:00','2009-03-14 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (413,60,165,'2009-03-14 21:00:00','2009-03-14 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (414,60,166,'2009-03-14 22:00:00','2009-03-14 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (415,60,167,'2009-03-14 23:00:00','2009-03-14 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (416,60,0,'2009-03-15 00:00:00','2009-03-15 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (417,60,1,'2009-03-15 01:00:00','2009-03-15 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (418,60,2,'2009-03-15 02:00:00','2009-03-15 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (419,60,3,'2009-03-15 03:00:00','2009-03-15 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (420,60,4,'2009-03-15 04:00:00','2009-03-15 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (421,60,5,'2009-03-15 05:00:00','2009-03-15 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (422,60,6,'2009-03-15 06:00:00','2009-03-15 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (423,60,7,'2009-03-15 07:00:00','2009-03-15 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (424,60,8,'2009-03-15 08:00:00','2009-03-15 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (425,60,9,'2009-03-15 09:00:00','2009-03-15 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (426,60,10,'2009-03-15 10:00:00','2009-03-15 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (427,60,11,'2009-03-15 11:00:00','2009-03-15 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (428,60,12,'2009-03-15 12:00:00','2009-03-15 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (429,60,13,'2009-03-15 13:00:00','2009-03-15 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (430,60,14,'2009-03-15 14:00:00','2009-03-15 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (431,60,15,'2009-03-15 15:00:00','2009-03-15 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (432,60,16,'2009-03-15 16:00:00','2009-03-15 16:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (433,60,17,'2009-03-15 17:00:00','2009-03-15 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (434,60,18,'2009-03-15 18:00:00','2009-03-15 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (435,60,19,'2009-03-15 19:00:00','2009-03-15 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (436,60,20,'2009-03-15 20:00:00','2009-03-15 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (437,60,21,'2009-03-15 21:00:00','2009-03-15 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (438,60,22,'2009-03-15 22:00:00','2009-03-15 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (439,60,23,'2009-03-15 23:00:00','2009-03-15 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (440,60,24,'2009-03-16 00:00:00','2009-03-16 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (441,60,25,'2009-03-16 01:00:00','2009-03-16 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (442,60,26,'2009-03-16 02:00:00','2009-03-16 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (443,60,27,'2009-03-16 03:00:00','2009-03-16 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (444,60,28,'2009-03-16 04:00:00','2009-03-16 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (445,60,29,'2009-03-16 05:00:00','2009-03-16 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (446,60,30,'2009-03-16 06:00:00','2009-03-16 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (447,60,31,'2009-03-16 07:00:00','2009-03-16 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (448,60,32,'2009-03-16 08:00:00','2009-03-16 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (449,60,33,'2009-03-16 09:00:00','2009-03-16 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (450,60,34,'2009-03-16 10:00:00','2009-03-16 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (451,60,35,'2009-03-16 11:00:00','2009-03-16 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (452,60,36,'2009-03-16 12:00:00','2009-03-16 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (453,60,37,'2009-03-16 13:00:00','2009-03-16 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (454,60,38,'2009-03-16 14:00:00','2009-03-16 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (455,60,39,'2009-03-16 15:00:00','2009-03-16 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (456,60,40,'2009-03-16 16:00:00','2009-03-16 16:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (457,60,41,'2009-03-16 17:00:00','2009-03-16 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (458,60,42,'2009-03-16 18:00:00','2009-03-16 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (459,60,43,'2009-03-16 19:00:00','2009-03-16 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (460,60,44,'2009-03-16 20:00:00','2009-03-16 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (461,60,45,'2009-03-16 21:00:00','2009-03-16 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (462,60,46,'2009-03-16 22:00:00','2009-03-16 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (463,60,47,'2009-03-16 23:00:00','2009-03-16 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (464,60,48,'2009-03-17 00:00:00','2009-03-17 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (465,60,49,'2009-03-17 01:00:00','2009-03-17 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (466,60,50,'2009-03-17 02:00:00','2009-03-17 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (467,60,51,'2009-03-17 03:00:00','2009-03-17 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (468,60,52,'2009-03-17 04:00:00','2009-03-17 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (469,60,53,'2009-03-17 05:00:00','2009-03-17 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (470,60,54,'2009-03-17 06:00:00','2009-03-17 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (471,60,55,'2009-03-17 07:00:00','2009-03-17 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (472,60,56,'2009-03-17 08:00:00','2009-03-17 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (473,60,57,'2009-03-17 09:00:00','2009-03-17 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (474,60,58,'2009-03-17 10:00:00','2009-03-17 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (475,60,59,'2009-03-17 11:00:00','2009-03-17 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (476,60,60,'2009-03-17 12:00:00','2009-03-17 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (477,60,61,'2009-03-17 13:00:00','2009-03-17 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (478,60,62,'2009-03-17 14:00:00','2009-03-17 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (479,60,63,'2009-03-17 15:00:00','2009-03-17 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (480,60,64,'2009-03-17 16:00:00','2009-03-17 16:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (481,60,65,'2009-03-17 17:00:00','2009-03-17 17:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (482,60,66,'2009-03-17 18:00:00','2009-03-17 18:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (483,60,67,'2009-03-17 19:00:00','2009-03-17 19:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (484,60,68,'2009-03-17 20:00:00','2009-03-17 20:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (485,60,69,'2009-03-17 21:00:00','2009-03-17 21:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (486,60,70,'2009-03-17 22:00:00','2009-03-17 22:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (487,60,71,'2009-03-17 23:00:00','2009-03-17 23:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (488,60,72,'2009-03-18 00:00:00','2009-03-18 00:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (489,60,73,'2009-03-18 01:00:00','2009-03-18 01:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (490,60,74,'2009-03-18 02:00:00','2009-03-18 02:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (491,60,75,'2009-03-18 03:00:00','2009-03-18 03:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (492,60,76,'2009-03-18 04:00:00','2009-03-18 04:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (493,60,77,'2009-03-18 05:00:00','2009-03-18 05:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (494,60,78,'2009-03-18 06:00:00','2009-03-18 06:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (495,60,79,'2009-03-18 07:00:00','2009-03-18 07:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (496,60,80,'2009-03-18 08:00:00','2009-03-18 08:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (497,60,81,'2009-03-18 09:00:00','2009-03-18 09:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (498,60,82,'2009-03-18 10:00:00','2009-03-18 10:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (499,60,83,'2009-03-18 11:00:00','2009-03-18 11:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (500,60,84,'2009-03-18 12:00:00','2009-03-18 12:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (501,60,85,'2009-03-18 13:00:00','2009-03-18 13:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (502,60,86,'2009-03-18 14:00:00','2009-03-18 14:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (503,60,87,'2009-03-18 15:00:00','2009-03-18 15:59:59',2,1000,NULL,1);
INSERT INTO `ox_data_summary_zone_impression_history` VALUES   (504,60,88,'2009-03-18 16:00:00','2009-03-18 16:59:59',2,1000,NULL,1);
CREATE TABLE `ox_database_action` (
  `database_action_id` int(10) unsigned NOT NULL auto_increment,
  `upgrade_action_id` int(10) unsigned default '0',
  `schema_name` varchar(64) default NULL,
  `version` int(11) NOT NULL,
  `timing` int(2) NOT NULL,
  `action` int(2) NOT NULL,
  `info1` varchar(255) default NULL,
  `info2` varchar(255) default NULL,
  `tablename` varchar(64) default NULL,
  `tablename_backup` varchar(64) default NULL,
  `table_backup_schema` text,
  `updated` datetime default NULL,
  PRIMARY KEY  (`database_action_id`),
  KEY `ox_database_action_upgrade_action_id` (`upgrade_action_id`,`database_action_id`),
  KEY `ox_database_action_schema_version_timing_action` (`schema_name`,`version`,`timing`,`action`),
  KEY `ox_database_action_updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_images` (
  `filename` varchar(128) NOT NULL default '',
  `contents` longblob NOT NULL,
  `t_stamp` datetime default NULL,
  PRIMARY KEY  (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_images` VALUES   ('468x60.gif',0x474946383961D4013C00F70000000000800000008000808000000080800080008080808080C0C0C0FF000000FF00FFFF000000FFFF00FF00FFFFFFFFFF0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000330000660000990000CC0000FF0033000033330033660033990033CC0033FF0066000066330066660066990066CC0066FF0099000099330099660099990099CC0099FF00CC0000CC3300CC6600CC9900CCCC00CCFF00FF0000FF3300FF6600FF9900FFCC00FFFF3300003300333300663300993300CC3300FF3333003333333333663333993333CC3333FF3366003366333366663366993366CC3366FF3399003399333399663399993399CC3399FF33CC0033CC3333CC6633CC9933CCCC33CCFF33FF0033FF3333FF6633FF9933FFCC33FFFF6600006600336600666600996600CC6600FF6633006633336633666633996633CC6633FF6666006666336666666666996666CC6666FF6699006699336699666699996699CC6699FF66CC0066CC3366CC6666CC9966CCCC66CCFF66FF0066FF3366FF6666FF9966FFCC66FFFF9900009900339900669900999900CC9900FF9933009933339933669933999933CC9933FF9966009966339966669966999966CC9966FF9999009999339999669999999999CC9999FF99CC0099CC3399CC6699CC9999CCCC99CCFF99FF0099FF3399FF6699FF9999FFCC99FFFFCC0000CC0033CC0066CC0099CC00CCCC00FFCC3300CC3333CC3366CC3399CC33CCCC33FFCC6600CC6633CC6666CC6699CC66CCCC66FFCC9900CC9933CC9966CC9999CC99CCCC99FFCCCC00CCCC33CCCC66CCCC99CCCCCCCCCCFFCCFF00CCFF33CCFF66CCFF99CCFFCCCCFFFFFF0000FF0033FF0066FF0099FF00CCFF00FFFF3300FF3333FF3366FF3399FF33CCFF33FFFF6600FF6633FF6666FF6699FF66CCFF66FFFF9900FF9933FF9966FF9999FF99CCFF99FFFFCC00FFCC33FFCC66FFCC99FFCCCCFFCCFFFFFF00FFFF33FFFF66FFFF99FFFFCCFFFFFF21F90401000010002C00000000D4013C000008FF007FE4104870A0C182080F2A4CC870A1C386101F4A8C4871A2C58A182F6ACCC871A3C78E203F8A0C4972A4C992284FAA4CB8B265CA972E63C29C29B326CD9B3673E2DCA95327CF9F3D810A0D4A74A8D1A2488F2A459AB4E9D2A74EA3429D2AB52A55A557AD6ACDCA75ABD7AE60BFB6141BB62CD9B366D3A25D3B53AD5BB670DFCA8D4B176ADDBB73F3E2DDABB7EF43BF80F90A0E4C787054C38513235EACB8F146C790194B8E4CF9EEE4CB953363DECC55B367CEA03F8B5619BAF4E8D3A6534344CD5AB5EBD68E5FCB863DBB765FDAB86DEBCE9D75B76FDEBF83FF044E5CB8F1E2258F2B47BEBC3941E6D09D4B2F3EBD7AF4EBB3B16BB7CE5D73F7EFDBC333BA164F1EBC79BDE7D3975F8F96BD7BF5F0A9C69FFFBE7E51FBF8E9EBA7B9BF7FFEFF230128A07F044654E08103263890820C22D89F830D46189F841442689E851566689D861C62D89C871D86289C882482A89B8925A6F89A8A2CA2589A8B2DC688998C34C2B8988D35E6C8978E3CE248978F3D06D91E90440AF95691481A39A4924C26C95493503A399C945446795495585A1994965C666992975D86F91898648A195299689A39A69A6CA299E69B6D3214279C740A54E79D6C0604003B,'2009-03-18 16:54:08');
CREATE TABLE `ox_lb_local` (
  `last_run` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_log_maintenance_forecasting` (
  `log_maintenance_forecasting_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_forecasting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_log_maintenance_priority` (
  `log_maintenance_priority_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `run_type` tinyint(3) unsigned NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_priority_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
INSERT INTO `ox_log_maintenance_priority` VALUES   (1,'2009-03-18 16:57:58','2009-03-18 16:57:59',60,1,0,'2009-03-18 16:59:59');
INSERT INTO `ox_log_maintenance_priority` VALUES   (2,'2009-03-18 16:57:59','2009-03-18 16:57:59',60,0,1,NULL);
CREATE TABLE `ox_log_maintenance_statistics` (
  `log_maintenance_statistics_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `adserver_run_type` int(2) default NULL,
  `search_run_type` int(2) default NULL,
  `tracker_run_type` int(2) default NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_statistics_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_password_recovery` (
  `user_type` varchar(64) NOT NULL default '',
  `user_id` int(10) NOT NULL,
  `recovery_id` varchar(64) NOT NULL default '',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`user_type`,`user_id`),
  UNIQUE KEY `ox_password_recovery_recovery_id` (`recovery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_placement_zone_assoc` (
  `placement_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `placement_id` mediumint(9) default NULL,
  PRIMARY KEY  (`placement_zone_assoc_id`),
  KEY `ox_placement_zone_assoc_zone_id` (`zone_id`),
  KEY `ox_placement_zone_assoc_placement_id` (`placement_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO `ox_placement_zone_assoc` VALUES   (1,1,1);
INSERT INTO `ox_placement_zone_assoc` VALUES   (2,1,2);
INSERT INTO `ox_placement_zone_assoc` VALUES   (3,2,3);
INSERT INTO `ox_placement_zone_assoc` VALUES   (4,2,1);
CREATE TABLE `ox_plugins_channel_delivery_assoc` (
  `rule_id` int(10) unsigned NOT NULL default '0',
  `domain_id` int(10) unsigned NOT NULL default '0',
  `rule_order` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`rule_id`,`domain_id`),
  KEY `ox_plugins_channel_delivery_assoc_domain_id` (`domain_id`),
  KEY `ox_plugins_channel_delivery_assoc_rule_id` (`rule_id`),
  KEY `ox_plugins_channel_delivery_assoc_rule_order` (`rule_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_plugins_channel_delivery_domains` (
  `domain_id` int(10) unsigned NOT NULL auto_increment,
  `domain_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`domain_id`),
  KEY `ox_plugins_channel_delivery_domains_domain_name` (`domain_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_plugins_channel_delivery_rules` (
  `rule_id` int(10) unsigned NOT NULL auto_increment,
  `modifier` varchar(100) NOT NULL default '',
  `client` varchar(100) NOT NULL default '',
  `rule` text NOT NULL,
  PRIMARY KEY  (`rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_preferences` (
  `preference_id` mediumint(9) NOT NULL auto_increment,
  `preference_name` varchar(64) NOT NULL default '',
  `account_type` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`preference_id`),
  UNIQUE KEY `ox_preferences_preference_name` (`preference_name`),
  KEY `ox_preferences_account_type` (`account_type`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
INSERT INTO `ox_preferences` VALUES   (1,'default_banner_image_url','TRAFFICKER');
INSERT INTO `ox_preferences` VALUES   (2,'default_banner_destination_url','TRAFFICKER');
INSERT INTO `ox_preferences` VALUES   (3,'auto_alter_html_banners_for_click_tracking','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (4,'default_banner_weight','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (5,'default_campaign_weight','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (6,'warn_email_admin','ADMIN');
INSERT INTO `ox_preferences` VALUES   (7,'warn_email_admin_impression_limit','ADMIN');
INSERT INTO `ox_preferences` VALUES   (8,'warn_email_admin_day_limit','ADMIN');
INSERT INTO `ox_preferences` VALUES   (9,'warn_email_manager','MANAGER');
INSERT INTO `ox_preferences` VALUES   (10,'warn_email_manager_impression_limit','MANAGER');
INSERT INTO `ox_preferences` VALUES   (11,'warn_email_manager_day_limit','MANAGER');
INSERT INTO `ox_preferences` VALUES   (12,'warn_email_advertiser','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (13,'warn_email_advertiser_impression_limit','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (14,'warn_email_advertiser_day_limit','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (15,'timezone','MANAGER');
INSERT INTO `ox_preferences` VALUES   (16,'tracker_default_status','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (17,'tracker_default_type','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (18,'tracker_link_campaigns','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (19,'ui_show_campaign_info','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (20,'ui_show_banner_info','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (21,'ui_show_campaign_preview','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (22,'ui_show_banner_html','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (23,'ui_show_banner_preview','ADVERTISER');
INSERT INTO `ox_preferences` VALUES   (24,'ui_hide_inactive','');
INSERT INTO `ox_preferences` VALUES   (25,'ui_show_matching_banners','TRAFFICKER');
INSERT INTO `ox_preferences` VALUES   (26,'ui_show_matching_banners_parents','TRAFFICKER');
INSERT INTO `ox_preferences` VALUES   (27,'ui_novice_user','');
INSERT INTO `ox_preferences` VALUES   (28,'ui_week_start_day','');
INSERT INTO `ox_preferences` VALUES   (29,'ui_percentage_decimals','');
INSERT INTO `ox_preferences` VALUES   (30,'ui_column_id','MANAGER');
INSERT INTO `ox_preferences` VALUES   (31,'ui_column_id_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (32,'ui_column_id_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (33,'ui_column_requests','MANAGER');
INSERT INTO `ox_preferences` VALUES   (34,'ui_column_requests_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (35,'ui_column_requests_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (36,'ui_column_impressions','MANAGER');
INSERT INTO `ox_preferences` VALUES   (37,'ui_column_impressions_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (38,'ui_column_impressions_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (39,'ui_column_clicks','MANAGER');
INSERT INTO `ox_preferences` VALUES   (40,'ui_column_clicks_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (41,'ui_column_clicks_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (42,'ui_column_ctr','MANAGER');
INSERT INTO `ox_preferences` VALUES   (43,'ui_column_ctr_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (44,'ui_column_ctr_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (45,'ui_column_conversions','MANAGER');
INSERT INTO `ox_preferences` VALUES   (46,'ui_column_conversions_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (47,'ui_column_conversions_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (48,'ui_column_conversions_pending','MANAGER');
INSERT INTO `ox_preferences` VALUES   (49,'ui_column_conversions_pending_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (50,'ui_column_conversions_pending_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (51,'ui_column_sr_views','MANAGER');
INSERT INTO `ox_preferences` VALUES   (52,'ui_column_sr_views_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (53,'ui_column_sr_views_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (54,'ui_column_sr_clicks','MANAGER');
INSERT INTO `ox_preferences` VALUES   (55,'ui_column_sr_clicks_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (56,'ui_column_sr_clicks_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (57,'ui_column_revenue','MANAGER');
INSERT INTO `ox_preferences` VALUES   (58,'ui_column_revenue_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (59,'ui_column_revenue_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (60,'ui_column_cost','MANAGER');
INSERT INTO `ox_preferences` VALUES   (61,'ui_column_cost_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (62,'ui_column_cost_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (63,'ui_column_bv','MANAGER');
INSERT INTO `ox_preferences` VALUES   (64,'ui_column_bv_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (65,'ui_column_bv_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (66,'ui_column_num_items','MANAGER');
INSERT INTO `ox_preferences` VALUES   (67,'ui_column_num_items_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (68,'ui_column_num_items_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (69,'ui_column_revcpc','MANAGER');
INSERT INTO `ox_preferences` VALUES   (70,'ui_column_revcpc_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (71,'ui_column_revcpc_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (72,'ui_column_costcpc','MANAGER');
INSERT INTO `ox_preferences` VALUES   (73,'ui_column_costcpc_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (74,'ui_column_costcpc_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (75,'ui_column_technology_cost','MANAGER');
INSERT INTO `ox_preferences` VALUES   (76,'ui_column_technology_cost_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (77,'ui_column_technology_cost_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (78,'ui_column_income','MANAGER');
INSERT INTO `ox_preferences` VALUES   (79,'ui_column_income_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (80,'ui_column_income_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (81,'ui_column_income_margin','MANAGER');
INSERT INTO `ox_preferences` VALUES   (82,'ui_column_income_margin_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (83,'ui_column_income_margin_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (84,'ui_column_profit','MANAGER');
INSERT INTO `ox_preferences` VALUES   (85,'ui_column_profit_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (86,'ui_column_profit_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (87,'ui_column_margin','MANAGER');
INSERT INTO `ox_preferences` VALUES   (88,'ui_column_margin_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (89,'ui_column_margin_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (90,'ui_column_erpm','MANAGER');
INSERT INTO `ox_preferences` VALUES   (91,'ui_column_erpm_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (92,'ui_column_erpm_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (93,'ui_column_erpc','MANAGER');
INSERT INTO `ox_preferences` VALUES   (94,'ui_column_erpc_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (95,'ui_column_erpc_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (96,'ui_column_erps','MANAGER');
INSERT INTO `ox_preferences` VALUES   (97,'ui_column_erps_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (98,'ui_column_erps_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (99,'ui_column_eipm','MANAGER');
INSERT INTO `ox_preferences` VALUES   (100,'ui_column_eipm_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (101,'ui_column_eipm_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (102,'ui_column_eipc','MANAGER');
INSERT INTO `ox_preferences` VALUES   (103,'ui_column_eipc_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (104,'ui_column_eipc_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (105,'ui_column_eips','MANAGER');
INSERT INTO `ox_preferences` VALUES   (106,'ui_column_eips_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (107,'ui_column_eips_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (108,'ui_column_ecpm','MANAGER');
INSERT INTO `ox_preferences` VALUES   (109,'ui_column_ecpm_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (110,'ui_column_ecpm_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (111,'ui_column_ecpc','MANAGER');
INSERT INTO `ox_preferences` VALUES   (112,'ui_column_ecpc_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (113,'ui_column_ecpc_rank','MANAGER');
INSERT INTO `ox_preferences` VALUES   (114,'ui_column_ecps','MANAGER');
INSERT INTO `ox_preferences` VALUES   (115,'ui_column_ecps_label','MANAGER');
INSERT INTO `ox_preferences` VALUES   (116,'ui_column_ecps_rank','MANAGER');
CREATE TABLE `ox_session` (
  `sessionid` varchar(32) NOT NULL default '',
  `sessiondata` text NOT NULL,
  `lastused` datetime default NULL,
  PRIMARY KEY  (`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ox_session` VALUES   ('phpads49c126c4c2f721.71089415','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:15:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:0:\"\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:10:\"account_id\";s:1:\"1\";s:6:\"linked\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:0:\"\";s:10:\"m2m_ticket\";s:0:\"\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}}','2009-03-18 16:52:21');
INSERT INTO `ox_session` VALUES   ('phpads49c126ed370bf7.00060612','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:53:01\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}}','2009-03-18 16:53:26');
INSERT INTO `ox_session` VALUES   ('phpads49c12706e632d8.70293105','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:53:27\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:2:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:17:\"campaign-zone.php\";a:2:{s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";}}}','2009-03-18 16:53:40');
INSERT INTO `ox_session` VALUES   ('phpads49c127151479f0.61577856','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:53:41\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:1:{s:7:\"clients\";a:1:{i:1;a:2:{s:6:\"expand\";b:1;s:9:\"campaigns\";a:3:{i:1;a:1:{s:6:\"expand\";b:1;}i:3;a:1:{s:6:\"expand\";b:1;}i:2;a:1:{s:6:\"expand\";b:1;}}}}}}}}','2009-03-18 16:54:08');
INSERT INTO `ox_session` VALUES   ('phpads49c127309cdb09.33292340','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:54:08\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:3:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}s:19:\"affiliate-zones.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}}}','2009-03-18 16:54:24');
INSERT INTO `ox_session` VALUES   ('phpads49c12741020d37.97267478','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:54:25\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:3:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}s:16:\"zone-include.php\";a:6:{s:12:\"hideinactive\";b:0;s:11:\"showbanners\";b:1;s:13:\"showcampaigns\";b:0;s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";s:4:\"view\";s:9:\"placement\";}}}','2009-03-18 16:54:44');
INSERT INTO `ox_session` VALUES   ('phpads49c12754cdac84.28160801','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:54:45\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:3:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:2:\",1\";}s:16:\"zone-include.php\";a:6:{s:12:\"hideinactive\";b:0;s:11:\"showbanners\";b:1;s:13:\"showcampaigns\";b:0;s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";s:4:\"view\";s:9:\"placement\";}}}','2009-03-18 16:55:00');
INSERT INTO `ox_session` VALUES   ('phpads49c12764cc96c5.12722541','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:55:01\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:3:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:1:{s:7:\"clients\";a:1:{i:1;a:1:{s:6:\"expand\";b:1;}}}}s:17:\"campaign-zone.php\";a:2:{s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";}s:20:\"campaign-banners.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}}}','2009-03-18 16:55:24');
INSERT INTO `ox_session` VALUES   ('phpads49c1277d29a8f9.43088627','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:55:25\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:4:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-campaigns.php\";a:3:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-variables.php\";a:1:{s:9:\"trackerid\";s:1:\"1\";}}}','2009-03-18 16:55:45');
INSERT INTO `ox_session` VALUES   ('phpads49c12791b0e293.60566447','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:55:46\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:4:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-campaigns.php\";a:3:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-variables.php\";a:2:{s:9:\"variables\";a:2:{i:0;a:14:{s:10:\"variableid\";s:1:\"1\";s:9:\"trackerid\";s:1:\"1\";s:4:\"name\";s:3:\"boo\";s:11:\"description\";s:13:\"Sample number\";s:8:\"datatype\";s:7:\"numeric\";s:7:\"purpose\";s:0:\"\";s:15:\"reject_if_empty\";s:1:\"0\";s:9:\"is_unique\";s:1:\"0\";s:13:\"unique_window\";s:1:\"0\";s:12:\"variablecode\";s:21:\"\\\\\\\'%%BOO_VALUE%%\\\\\\\'\";s:6:\"hidden\";s:1:\"f\";s:7:\"updated\";s:19:\"2009-03-18 16:55:43\";s:17:\"publisher_visible\";a:0:{}s:16:\"publisher_hidden\";a:0:{}}i:1;a:14:{s:10:\"variableid\";s:1:\"2\";s:9:\"trackerid\";s:1:\"1\";s:4:\"name\";s:3:\"foo\";s:11:\"description\";s:13:\"Sample string\";s:8:\"datatype\";s:6:\"string\";s:7:\"purpose\";s:0:\"\";s:15:\"reject_if_empty\";s:1:\"0\";s:9:\"is_unique\";s:1:\"0\";s:13:\"unique_window\";s:1:\"0\";s:12:\"variablecode\";s:21:\"\\\\\\\'%%FOO_VALUE%%\\\\\\\'\";s:6:\"hidden\";s:1:\"f\";s:7:\"updated\";s:19:\"2009-03-18 16:55:43\";s:17:\"publisher_visible\";a:0:{}s:16:\"publisher_hidden\";a:0:{}}}s:9:\"trackerid\";s:1:\"1\";}}}','2009-03-18 16:56:11');
INSERT INTO `ox_session` VALUES   ('phpads49c127ac045b29.64255708','a:2:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:56:12\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}s:5:\"prefs\";a:2:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}}','2009-03-18 16:56:48');
INSERT INTO `ox_session` VALUES   ('phpads49c12831a664a4.12878222','a:1:{s:4:\"user\";O:18:\"OA_Permission_User\":2:{s:5:\"aUser\";a:13:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:13:\"Administrator\";s:13:\"email_address\";s:15:\"test@openx.test\";s:8:\"username\";s:5:\"openx\";s:8:\"language\";s:2:\"en\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:11:\"sso_user_id\";s:0:\"\";s:12:\"date_created\";s:19:\"2009-03-18 17:52:20\";s:15:\"date_last_login\";s:19:\"2009-03-18 16:58:25\";s:13:\"email_updated\";s:19:\"2009-03-18 17:52:20\";s:8:\"is_admin\";b:1;}s:8:\"aAccount\";a:7:{s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";s:12:\"m2m_password\";s:25:\"x)=b@R)(u*%rf+OTFOwPAL_jP\";s:10:\"m2m_ticket\";s:30:\"w8+OMf(L^2u!CjOZYjhW3+=kgx=0qo\";s:9:\"entity_id\";s:1:\"1\";s:9:\"agency_id\";s:1:\"1\";}}}','2009-03-18 16:58:36');
CREATE TABLE `ox_targetstats` (
  `day` date NOT NULL default '0000-00-00',
  `campaignid` mediumint(9) NOT NULL default '0',
  `target` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `modified` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_tracker_append` (
  `tracker_append_id` int(11) NOT NULL auto_increment,
  `tracker_id` mediumint(9) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `tagcode` text NOT NULL,
  `paused` enum('t','f') NOT NULL default 'f',
  `autotrack` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`tracker_append_id`),
  KEY `ox_tracker_append_tracker_id` (`tracker_id`,`rank`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_trackers` (
  `trackerid` mediumint(9) NOT NULL auto_increment,
  `trackername` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `clientid` mediumint(9) NOT NULL default '0',
  `viewwindow` mediumint(9) NOT NULL default '0',
  `clickwindow` mediumint(9) NOT NULL default '0',
  `blockwindow` mediumint(9) NOT NULL default '0',
  `status` smallint(1) unsigned NOT NULL default '4',
  `type` smallint(1) unsigned NOT NULL default '1',
  `linkcampaigns` enum('t','f') NOT NULL default 'f',
  `variablemethod` enum('default','js','dom','custom') NOT NULL default 'default',
  `appendcode` text NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`trackerid`),
  KEY `ox_trackers_clientid` (`clientid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `ox_trackers` VALUES   (1,'Sample Tracker','',1,3,3,0,4,1,'f','js','','2009-03-18 16:55:43');
CREATE TABLE `ox_upgrade_action` (
  `upgrade_action_id` int(10) unsigned NOT NULL auto_increment,
  `upgrade_name` varchar(128) default NULL,
  `version_to` varchar(64) NOT NULL default '',
  `version_from` varchar(64) default NULL,
  `action` int(2) NOT NULL,
  `description` varchar(255) default NULL,
  `logfile` varchar(128) default NULL,
  `confbackup` varchar(128) default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`upgrade_action_id`),
  KEY `ox_upgrade_action_updated` (`updated`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `ox_upgrade_action` VALUES   (1,'install_2.6.5','2.6.5','0',1,'UPGRADE_COMPLETE','install.log',NULL,'2009-03-18 17:52:16');
CREATE TABLE `ox_userlog` (
  `userlogid` mediumint(9) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL default '0',
  `usertype` tinyint(4) NOT NULL default '0',
  `userid` mediumint(9) NOT NULL default '0',
  `action` mediumint(9) NOT NULL default '0',
  `object` mediumint(9) default NULL,
  `details` mediumtext,
  PRIMARY KEY  (`userlogid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_users` (
  `user_id` mediumint(9) NOT NULL auto_increment,
  `contact_name` varchar(255) NOT NULL default '',
  `email_address` varchar(64) NOT NULL default '',
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `language` varchar(5) default NULL,
  `default_account_id` mediumint(9) default NULL,
  `comments` text,
  `active` tinyint(1) NOT NULL default '1',
  `sso_user_id` int(11) default NULL,
  `date_created` datetime default NULL,
  `date_last_login` datetime default NULL,
  `email_updated` datetime default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `ox_users_username` (`username`),
  UNIQUE KEY `ox_users_sso_user_id` (`sso_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `ox_users` VALUES   (1,'Administrator','test@openx.test','openx','7a89a595cfc6cb85480202a143e37d2e','en',2,NULL,1,NULL,'2009-03-18 17:52:20','2009-03-18 16:58:25','2009-03-18 17:52:20');
CREATE TABLE `ox_variable_publisher` (
  `variable_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`variable_id`,`publisher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `ox_variables` (
  `variableid` mediumint(9) unsigned NOT NULL auto_increment,
  `trackerid` mediumint(9) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `description` varchar(250) default NULL,
  `datatype` enum('numeric','string','date') NOT NULL default 'numeric',
  `purpose` enum('basket_value','num_items','post_code') default NULL,
  `reject_if_empty` smallint(1) unsigned NOT NULL default '0',
  `is_unique` int(11) NOT NULL default '0',
  `unique_window` int(11) NOT NULL default '0',
  `variablecode` varchar(255) NOT NULL default '',
  `hidden` enum('t','f') NOT NULL default 'f',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`variableid`),
  KEY `ox_variables_is_unique` (`is_unique`),
  KEY `ox_variables_trackerid` (`trackerid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
INSERT INTO `ox_variables` VALUES   (1,1,'boo','Sample number','numeric',NULL,0,0,0,'var boo = \\\'%%BOO_VALUE%%\\\'','f','2009-03-18 16:55:43');
INSERT INTO `ox_variables` VALUES   (2,1,'foo','Sample string','string',NULL,0,0,0,'var foo = \\\'%%FOO_VALUE%%\\\'','f','2009-03-18 16:55:43');
CREATE TABLE `ox_zones` (
  `zoneid` mediumint(9) NOT NULL auto_increment,
  `affiliateid` mediumint(9) default NULL,
  `zonename` varchar(245) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `delivery` smallint(6) NOT NULL default '0',
  `zonetype` smallint(6) NOT NULL default '0',
  `category` text NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `ad_selection` text NOT NULL,
  `chain` text NOT NULL,
  `prepend` text NOT NULL,
  `append` text NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `forceappend` enum('t','f') default 'f',
  `inventory_forecast_type` smallint(6) NOT NULL default '0',
  `comments` text,
  `cost` decimal(10,4) default NULL,
  `cost_type` smallint(6) default NULL,
  `cost_variable_id` varchar(255) default NULL,
  `technology_cost` decimal(10,4) default NULL,
  `technology_cost_type` smallint(6) default NULL,
  `updated` datetime NOT NULL,
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `what` text NOT NULL,
  `as_zone_id` int(11) default NULL,
  `is_in_ad_direct` tinyint(1) NOT NULL default '0',
  `rate` decimal(19,2) default NULL,
  `pricing` varchar(50) NOT NULL default 'CPM',
  PRIMARY KEY  (`zoneid`),
  KEY `ox_zones_zonenameid` (`zonename`,`zoneid`),
  KEY `ox_zones_affiliateid` (`affiliateid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
INSERT INTO `ox_zones` VALUES   (1,1,'Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,NULL,NULL,NULL,'2009-03-18 16:54:42',0,0,0,'',NULL,0,NULL,'CPM');
INSERT INTO `ox_zones` VALUES   (2,1,'Agency Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,NULL,NULL,NULL,'2009-03-18 16:54:44',0,0,0,'',NULL,0,NULL,'CPM');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
