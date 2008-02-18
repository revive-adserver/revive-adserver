-- MySQL dump 10.11
--
-- Host: localhost    Database: oa_canoo
-- ------------------------------------------------------
-- Server version	5.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `oa_account_preference_assoc`
--

DROP TABLE IF EXISTS `oa_account_preference_assoc`;
CREATE TABLE `oa_account_preference_assoc` (
  `account_id` mediumint(9) NOT NULL,
  `preference_id` mediumint(9) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`account_id`,`preference_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_account_preference_assoc`
--

LOCK TABLES `oa_account_preference_assoc` WRITE;
/*!40000 ALTER TABLE `oa_account_preference_assoc` DISABLE KEYS */;
INSERT INTO `oa_account_preference_assoc` VALUES (1,1,'english'),(1,2,'0'),(1,3,'2'),(1,4,'t'),(1,5,'t'),(1,6,'t'),(1,7,'100'),(1,8,'1'),(1,9,'t'),(1,10,'1'),(1,11,'1'),(1,12,''),(1,13,''),(1,14,'t'),(1,15,'t'),(1,16,'t'),(1,17,'t'),(1,18,'t'),(1,19,'t'),(1,20,'t'),(1,21,'t'),(1,22,'1'),(1,23,'1'),(1,24,'f'),(1,25,'t'),(1,26,''),(1,27,'0'),(1,28,'t'),(1,29,''),(1,30,'0'),(1,31,'t'),(1,32,''),(1,33,'0'),(1,34,'t'),(1,35,''),(1,36,'0'),(1,37,'t'),(1,38,''),(1,39,'0'),(1,40,'t'),(1,41,''),(1,42,'0'),(1,43,'t'),(1,44,''),(1,45,'0'),(1,46,'t'),(1,47,''),(1,48,'0'),(1,49,'t'),(1,50,''),(1,51,'0'),(1,52,'t'),(1,53,''),(1,54,'0'),(1,55,'t'),(1,56,''),(1,57,'0'),(1,58,'t'),(1,59,''),(1,60,'0'),(1,61,'t'),(1,62,''),(1,63,'0'),(1,64,'t'),(1,65,''),(1,66,'0'),(1,67,'t'),(1,68,''),(1,69,'0'),(1,70,'t'),(1,71,''),(1,72,'0'),(1,73,'t'),(1,74,''),(1,75,'0'),(1,76,'t'),(1,77,''),(1,78,'0'),(1,79,'t'),(1,80,''),(1,81,'0'),(1,82,'t'),(1,83,''),(1,84,'0'),(1,85,'t'),(1,86,''),(1,87,'0'),(1,88,'t'),(1,89,''),(1,90,'0'),(1,91,'t'),(1,92,''),(1,93,'0'),(1,94,'t'),(1,95,''),(1,96,'0'),(1,97,'t'),(1,98,''),(1,99,'0'),(1,100,'t'),(1,101,''),(1,102,'0'),(1,103,'t'),(1,104,''),(1,105,'0'),(1,106,'t'),(1,107,''),(1,108,'0'),(1,109,'t'),(1,110,''),(1,111,'0'),(1,112,'t'),(1,113,''),(1,114,'0');
/*!40000 ALTER TABLE `oa_account_preference_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_account_user_assoc`
--

DROP TABLE IF EXISTS `oa_account_user_assoc`;
CREATE TABLE `oa_account_user_assoc` (
  `account_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `linked` datetime NOT NULL,
  PRIMARY KEY  (`account_id`,`user_id`),
  KEY `oa_account_user_assoc_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_account_user_assoc`
--

LOCK TABLES `oa_account_user_assoc` WRITE;
/*!40000 ALTER TABLE `oa_account_user_assoc` DISABLE KEYS */;
INSERT INTO `oa_account_user_assoc` VALUES (1,1,'2008-01-11 14:45:32'),(2,1,'2008-01-11 14:45:32'),(3,2,'2008-01-11 14:45:32'),(4,3,'2008-01-11 14:45:32'),(5,4,'2008-01-11 14:45:32');
/*!40000 ALTER TABLE `oa_account_user_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_account_user_permission_assoc`
--

DROP TABLE IF EXISTS `oa_account_user_permission_assoc`;
CREATE TABLE `oa_account_user_permission_assoc` (
  `account_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `permission_id` mediumint(9) NOT NULL,
  `is_allowed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`account_id`,`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_account_user_permission_assoc`
--

LOCK TABLES `oa_account_user_permission_assoc` WRITE;
/*!40000 ALTER TABLE `oa_account_user_permission_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_account_user_permission_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_accounts`
--

DROP TABLE IF EXISTS `oa_accounts`;
CREATE TABLE `oa_accounts` (
  `account_id` mediumint(9) NOT NULL auto_increment,
  `account_type` varchar(16) NOT NULL default '',
  `account_name` varchar(255) default NULL,
  PRIMARY KEY  (`account_id`),
  KEY `oa_accounts_account_type` (`account_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_accounts`
--

LOCK TABLES `oa_accounts` WRITE;
/*!40000 ALTER TABLE `oa_accounts` DISABLE KEYS */;
INSERT INTO `oa_accounts` VALUES (1,'ADMIN','Administrator'),(2,'MANAGER','Default manager'),(3,'MANAGER','Test Agency'),(4,'ADVERTISER','Advertiser 1'),(5,'TRAFFICKER','Publisher 1'),(6,'TRAFFICKER','Agency Publisher 1');
/*!40000 ALTER TABLE `oa_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_acls`
--

DROP TABLE IF EXISTS `oa_acls`;
CREATE TABLE `oa_acls` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `bannerid_executionorder` (`bannerid`,`executionorder`),
  KEY `bannerid` (`bannerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_acls`
--

LOCK TABLES `oa_acls` WRITE;
/*!40000 ALTER TABLE `oa_acls` DISABLE KEYS */;
INSERT INTO `oa_acls` VALUES (1,'and','Site:Channel','=~','7',0);
/*!40000 ALTER TABLE `oa_acls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_acls_channel`
--

DROP TABLE IF EXISTS `oa_acls_channel`;
CREATE TABLE `oa_acls_channel` (
  `channelid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `channelid_executionorder` (`channelid`,`executionorder`),
  KEY `channelid` (`channelid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_acls_channel`
--

LOCK TABLES `oa_acls_channel` WRITE;
/*!40000 ALTER TABLE `oa_acls_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_acls_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_ad_category_assoc`
--

DROP TABLE IF EXISTS `oa_ad_category_assoc`;
CREATE TABLE `oa_ad_category_assoc` (
  `ad_category_assoc_id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ad_category_assoc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_ad_category_assoc`
--

LOCK TABLES `oa_ad_category_assoc` WRITE;
/*!40000 ALTER TABLE `oa_ad_category_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_ad_category_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_ad_zone_assoc`
--

DROP TABLE IF EXISTS `oa_ad_zone_assoc`;
CREATE TABLE `oa_ad_zone_assoc` (
  `ad_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `ad_id` mediumint(9) default NULL,
  `priority` double default '0',
  `link_type` smallint(6) NOT NULL default '1',
  `priority_factor` double default '0',
  `to_be_delivered` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ad_zone_assoc_id`),
  KEY `ad_zone_assoc_zone_id` (`zone_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_ad_zone_assoc`
--

LOCK TABLES `oa_ad_zone_assoc` WRITE;
/*!40000 ALTER TABLE `oa_ad_zone_assoc` DISABLE KEYS */;
INSERT INTO `oa_ad_zone_assoc` VALUES (1,0,1,1,0,1670960,1),(2,1,1,0.9,1,100,1),(3,0,2,0,0,1,1),(4,1,2,0,1,1,1),(5,2,1,0.9,1,100,1),(6,0,3,0,0,0,1),(7,1,3,0,1,1,1);
/*!40000 ALTER TABLE `oa_ad_zone_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_affiliates`
--

DROP TABLE IF EXISTS `oa_affiliates`;
CREATE TABLE `oa_affiliates` (
  `affiliateid` mediumint(9) NOT NULL auto_increment,
  `agencyid` mediumint(9) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `mnemonic` varchar(5) NOT NULL default '',
  `comments` text,
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `website` varchar(255) default NULL,
  `updated` datetime default NULL,
  `an_website_id` int(11) default NULL,
  `oac_country_code` char(2) NOT NULL default '',
  `oac_language_id` int(11) default NULL,
  `oac_category_id` int(11) default NULL,
  `as_website_id` int(11) default NULL,
  `account_id` mediumint(9) default NULL,
  PRIMARY KEY  (`affiliateid`),
  UNIQUE KEY `oa_affiliates_account_id` (`account_id`),
  KEY `oa_affiliates_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_affiliates`
--

LOCK TABLES `oa_affiliates` WRITE;
/*!40000 ALTER TABLE `oa_affiliates` DISABLE KEYS */;
INSERT INTO `oa_affiliates` VALUES (1,2,'Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://www.fornax.net/blog/','2007-05-15 13:29:57',NULL,'',NULL,NULL,NULL,5),(2,1,'Agency Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://fornax.net','2007-05-15 13:41:40',NULL,'',NULL,NULL,NULL,6);
/*!40000 ALTER TABLE `oa_affiliates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_affiliates_extra`
--

DROP TABLE IF EXISTS `oa_affiliates_extra`;
CREATE TABLE `oa_affiliates_extra` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_affiliates_extra`
--

LOCK TABLES `oa_affiliates_extra` WRITE;
/*!40000 ALTER TABLE `oa_affiliates_extra` DISABLE KEYS */;
INSERT INTO `oa_affiliates_extra` VALUES (1,'','','','','','','','','','Cheque by post','GBP',0,0,0,'',''),(2,'','','','','','','','','','Cheque by post','GBP',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `oa_affiliates_extra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_agency`
--

DROP TABLE IF EXISTS `oa_agency`;
CREATE TABLE `oa_agency` (
  `agencyid` mediumint(9) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `logout_url` varchar(255) default NULL,
  `active` smallint(1) default '0',
  `updated` datetime NOT NULL,
  `account_id` mediumint(9) default NULL,
  PRIMARY KEY  (`agencyid`),
  UNIQUE KEY `oa_agency_account_id` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_agency`
--

LOCK TABLES `oa_agency` WRITE;
/*!40000 ALTER TABLE `oa_agency` DISABLE KEYS */;
INSERT INTO `oa_agency` VALUES (1,'Test Agency','Andrew Hill','andrew.hill@openads.org','',0,'2007-05-15 12:54:16',3),(2,'Default manager',NULL,'andrew.hill@openads.org',NULL,1,'0000-00-00 00:00:00',2);
/*!40000 ALTER TABLE `oa_agency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_application_variable`
--

DROP TABLE IF EXISTS `oa_application_variable`;
CREATE TABLE `oa_application_variable` (
  `name` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_application_variable`
--

LOCK TABLES `oa_application_variable` WRITE;
/*!40000 ALTER TABLE `oa_application_variable` DISABLE KEYS */;
INSERT INTO `oa_application_variable` VALUES ('admin_account_id','1'),('oa_version','2.5.48-dev'),('platform_hash','39adcaa8840247618ff928521ba95397770c5b67'),('sync_cache','b:0;'),('sync_last_run','2008-01-11 14:47:04'),('sync_timestamp','1200062824'),('tables_core','546');
/*!40000 ALTER TABLE `oa_application_variable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_audit`
--

DROP TABLE IF EXISTS `oa_audit`;
CREATE TABLE `oa_audit` (
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
  PRIMARY KEY  (`auditid`),
  KEY `oa_audit_parentid_contextid` (`parentid`,`contextid`),
  KEY `oa_audit_updated` (`updated`),
  KEY `oa_audit_usertype` (`usertype`),
  KEY `oa_audit_username` (`username`),
  KEY `oa_audit_context_actionid` (`context`,`actionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_audit`
--

LOCK TABLES `oa_audit` WRITE;
/*!40000 ALTER TABLE `oa_audit` DISABLE KEYS */;
INSERT INTO `oa_audit` VALUES (1,1,'Account User Association',0,NULL,'a:4:{s:10:\"account_id\";i:1;s:7:\"user_id\";i:1;s:6:\"linked\";s:19:\"2008-01-11 14:45:32\";s:8:\"key_desc\";s:21:\"Account #1 -> User #1\";}',0,'admin',0,'2008-01-11 14:45:32'),(2,1,'Account User Association',0,NULL,'a:4:{s:10:\"account_id\";i:2;s:7:\"user_id\";i:1;s:6:\"linked\";s:19:\"2008-01-11 14:45:32\";s:8:\"key_desc\";s:21:\"Account #2 -> User #1\";}',0,'admin',0,'2008-01-11 14:45:32'),(3,1,'Account User Association',0,NULL,'a:4:{s:10:\"account_id\";i:3;s:7:\"user_id\";i:2;s:6:\"linked\";s:19:\"2008-01-11 14:45:32\";s:8:\"key_desc\";s:21:\"Account #3 -> User #2\";}',0,'admin',0,'2008-01-11 14:45:32'),(4,1,'Account User Association',0,NULL,'a:4:{s:10:\"account_id\";i:4;s:7:\"user_id\";i:3;s:6:\"linked\";s:19:\"2008-01-11 14:45:32\";s:8:\"key_desc\";s:21:\"Account #4 -> User #3\";}',0,'admin',0,'2008-01-11 14:45:32'),(5,1,'Account User Association',0,NULL,'a:4:{s:10:\"account_id\";i:5;s:7:\"user_id\";i:4;s:6:\"linked\";s:19:\"2008-01-11 14:45:32\";s:8:\"key_desc\";s:21:\"Account #5 -> User #4\";}',0,'admin',0,'2008-01-11 14:45:32');
/*!40000 ALTER TABLE `oa_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_banners`
--

DROP TABLE IF EXISTS `oa_banners`;
CREATE TABLE `oa_banners` (
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
  `status` int(11) NOT NULL default '0',
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
  PRIMARY KEY  (`bannerid`),
  KEY `oa_banners_campaignid` (`campaignid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_banners`
--

LOCK TABLES `oa_banners` WRITE;
/*!40000 ALTER TABLE `oa_banners` DISABLE KEYS */;
INSERT INTO `oa_banners` VALUES (1,1,'html',0,'html','','','Test HTML Banner!','Test HTML Banner!',468,60,1,0,'','','','',0,'','','t','',0,0,0,'(MAX_checkSite_Channel(\'7\', \'=~\'))','Site:Channel','',0,0,'','','gif','','2007-08-29 14:38:32','2007-05-15 15:01:43','',0,'N;',NULL,NULL),(2,2,'html',0,'html','','','html test banner','<a href=\"{clickurl}\" target=\"{target}\">html test banner</a>',468,60,1,0,'','http://www.example.com','','',0,'','test banner','t','max',0,0,0,'','','',0,0,'','','gif','','2007-08-29 14:38:32','0000-00-00 00:00:00','',0,'N;',NULL,NULL),(3,3,'gif',0,'sql','468x60.gif','','','',468,60,1,0,'','http://www.example.com','alt text','',0,'','sample gif banner','f','',0,0,0,'','','',0,0,'','','gif','','2007-08-29 14:38:32','0000-00-00 00:00:00','',0,'N;',NULL,NULL);
/*!40000 ALTER TABLE `oa_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_campaigns`
--

DROP TABLE IF EXISTS `oa_campaigns`;
CREATE TABLE `oa_campaigns` (
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
  PRIMARY KEY  (`campaignid`),
  KEY `oa_campaigns_clientid` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_campaigns`
--

LOCK TABLES `oa_campaigns` WRITE;
/*!40000 ALTER TABLE `oa_campaigns` DISABLE KEYS */;
INSERT INTO `oa_campaigns` VALUES (1,'Advertiser 1 - Default Campaign',1,100000000,-1,-1,'2007-07-01','0000-00-00',10,0,0,0,0,'f',0,'',NULL,NULL,'2007-05-15 09:54:06',0,0,0,NULL,NULL,0,0),(2,'test campaign',1,-1,-1,-1,'0000-00-00','0000-00-00',-1,1,0,0,0,'t',0,'',NULL,NULL,'2007-05-16 12:55:24',0,0,0,NULL,NULL,0,0),(3,'campaign 2 (gif)',1,-1,-1,-1,'0000-00-00','0000-00-00',0,1,0,0,0,'t',0,'',NULL,NULL,'2007-05-17 13:14:43',0,0,0,NULL,NULL,0,0);
/*!40000 ALTER TABLE `oa_campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_campaigns_trackers`
--

DROP TABLE IF EXISTS `oa_campaigns_trackers`;
CREATE TABLE `oa_campaigns_trackers` (
  `campaign_trackerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `trackerid` mediumint(9) NOT NULL default '0',
  `viewwindow` mediumint(9) NOT NULL default '0',
  `clickwindow` mediumint(9) NOT NULL default '0',
  `status` smallint(1) unsigned NOT NULL default '4',
  PRIMARY KEY  (`campaign_trackerid`),
  KEY `campaigns_trackers_campaignid` (`campaignid`),
  KEY `campaigns_trackers_trackerid` (`trackerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_campaigns_trackers`
--

LOCK TABLES `oa_campaigns_trackers` WRITE;
/*!40000 ALTER TABLE `oa_campaigns_trackers` DISABLE KEYS */;
INSERT INTO `oa_campaigns_trackers` VALUES (1,3,1,3,3,4);
/*!40000 ALTER TABLE `oa_campaigns_trackers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_category`
--

DROP TABLE IF EXISTS `oa_category`;
CREATE TABLE `oa_category` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_category`
--

LOCK TABLES `oa_category` WRITE;
/*!40000 ALTER TABLE `oa_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_channel`
--

DROP TABLE IF EXISTS `oa_channel`;
CREATE TABLE `oa_channel` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_channel`
--

LOCK TABLES `oa_channel` WRITE;
/*!40000 ALTER TABLE `oa_channel` DISABLE KEYS */;
INSERT INTO `oa_channel` VALUES (7,2,0,'Test Admin Channel 2','','true','true',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `oa_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_clients`
--

DROP TABLE IF EXISTS `oa_clients`;
CREATE TABLE `oa_clients` (
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
  PRIMARY KEY  (`clientid`),
  UNIQUE KEY `oa_clients_account_id` (`account_id`),
  KEY `oa_clients_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_clients`
--

LOCK TABLES `oa_clients` WRITE;
/*!40000 ALTER TABLE `oa_clients` DISABLE KEYS */;
INSERT INTO `oa_clients` VALUES (1,2,'Advertiser 1','advertiser','example@example.com','f',7,'2007-04-27','t','','2007-05-16 12:54:09',2,NULL,NULL,4);
/*!40000 ALTER TABLE `oa_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_intermediate_ad`
--

DROP TABLE IF EXISTS `oa_data_intermediate_ad`;
CREATE TABLE `oa_data_intermediate_ad` (
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
  KEY `oa_data_intermediate_ad_ad_id_date_time` (`ad_id`,`date_time`),
  KEY `oa_data_intermediate_ad_zone_id_date_time` (`zone_id`,`date_time`),
  KEY `oa_data_intermediate_ad_date_time` (`date_time`),
  KEY `oa_data_intermediate_ad_interval_start` (`interval_start`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_intermediate_ad`
--

LOCK TABLES `oa_data_intermediate_ad` WRITE;
/*!40000 ALTER TABLE `oa_data_intermediate_ad` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_intermediate_ad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_intermediate_ad_connection`
--

DROP TABLE IF EXISTS `oa_data_intermediate_ad_connection`;
CREATE TABLE `oa_data_intermediate_ad_connection` (
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
  KEY `data_intermediate_ad_connection_tracker_date_time` (`tracker_date_time`),
  KEY `data_intermediate_ad_connection_tracker_id` (`tracker_id`),
  KEY `data_intermediate_ad_connection_ad_id` (`ad_id`),
  KEY `data_intermediate_ad_connection_zone_id` (`zone_id`),
  KEY `data_intermediate_ad_connection_viewer_id` (`viewer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_intermediate_ad_connection`
--

LOCK TABLES `oa_data_intermediate_ad_connection` WRITE;
/*!40000 ALTER TABLE `oa_data_intermediate_ad_connection` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_intermediate_ad_connection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_intermediate_ad_variable_value`
--

DROP TABLE IF EXISTS `oa_data_intermediate_ad_variable_value`;
CREATE TABLE `oa_data_intermediate_ad_variable_value` (
  `data_intermediate_ad_variable_value_id` bigint(20) NOT NULL auto_increment,
  `data_intermediate_ad_connection_id` bigint(20) NOT NULL,
  `tracker_variable_id` int(11) NOT NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`data_intermediate_ad_variable_value_id`),
  KEY `data_intermediate_ad_connection_id` (`data_intermediate_ad_connection_id`),
  KEY `data_intermediate_ad_variable_value_tracker_variable_id` (`tracker_variable_id`),
  KEY `data_intermediate_ad_variable_value_tracker_value` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_intermediate_ad_variable_value`
--

LOCK TABLES `oa_data_intermediate_ad_variable_value` WRITE;
/*!40000 ALTER TABLE `oa_data_intermediate_ad_variable_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_intermediate_ad_variable_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_raw_ad_click`
--

DROP TABLE IF EXISTS `oa_data_raw_ad_click`;
CREATE TABLE `oa_data_raw_ad_click` (
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
  KEY `data_raw_ad_click_viewer_id` (`viewer_id`),
  KEY `data_raw_ad_click_date_time` (`date_time`),
  KEY `data_raw_ad_click_ad_id` (`ad_id`),
  KEY `data_raw_ad_click_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_ad_click`
--

LOCK TABLES `oa_data_raw_ad_click` WRITE;
/*!40000 ALTER TABLE `oa_data_raw_ad_click` DISABLE KEYS */;
INSERT INTO `oa_data_raw_ad_click` VALUES ('1d0b8f22878ee21edac4d01eeb8793bd','','2007-08-29 15:19:19',2,0,0,NULL,NULL,'','127.0.0.1','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,'','Mozilla/4.0 (compatible; MSIE 6.0b; Windows 98)','','',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `oa_data_raw_ad_click` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_raw_ad_impression`
--

DROP TABLE IF EXISTS `oa_data_raw_ad_impression`;
CREATE TABLE `oa_data_raw_ad_impression` (
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
  KEY `data_raw_ad_impression_viewer_id` (`viewer_id`),
  KEY `data_raw_ad_impression_date_time` (`date_time`),
  KEY `data_raw_ad_impression_ad_id` (`ad_id`),
  KEY `data_raw_ad_impression_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_ad_impression`
--

LOCK TABLES `oa_data_raw_ad_impression` WRITE;
/*!40000 ALTER TABLE `oa_data_raw_ad_impression` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_raw_ad_impression` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_raw_ad_request`
--

DROP TABLE IF EXISTS `oa_data_raw_ad_request`;
CREATE TABLE `oa_data_raw_ad_request` (
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
  KEY `oa_data_raw_ad_request_viewer_id` (`viewer_id`),
  KEY `oa_data_raw_ad_request_date_time` (`date_time`),
  KEY `oa_data_raw_ad_request_ad_id` (`ad_id`),
  KEY `oa_data_raw_ad_request_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_ad_request`
--

LOCK TABLES `oa_data_raw_ad_request` WRITE;
/*!40000 ALTER TABLE `oa_data_raw_ad_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_raw_ad_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_raw_tracker_impression`
--

DROP TABLE IF EXISTS `oa_data_raw_tracker_impression`;
CREATE TABLE `oa_data_raw_tracker_impression` (
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
  KEY `data_raw_tracker_impression_viewer_id` (`viewer_id`),
  KEY `data_raw_tracker_impression_date_time` (`date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_tracker_impression`
--

LOCK TABLES `oa_data_raw_tracker_impression` WRITE;
/*!40000 ALTER TABLE `oa_data_raw_tracker_impression` DISABLE KEYS */;
INSERT INTO `oa_data_raw_tracker_impression` VALUES (1,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:13:26',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(2,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:13:37',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(3,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:23:06',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(4,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:23:07',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(5,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:24:37',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(6,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:25:53',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','','');
/*!40000 ALTER TABLE `oa_data_raw_tracker_impression` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_raw_tracker_variable_value`
--

DROP TABLE IF EXISTS `oa_data_raw_tracker_variable_value`;
CREATE TABLE `oa_data_raw_tracker_variable_value` (
  `server_raw_tracker_impression_id` bigint(20) NOT NULL,
  `server_raw_ip` varchar(16) NOT NULL default '',
  `tracker_variable_id` int(11) NOT NULL,
  `date_time` datetime default NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`server_raw_tracker_impression_id`,`server_raw_ip`,`tracker_variable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_tracker_variable_value`
--

LOCK TABLES `oa_data_raw_tracker_variable_value` WRITE;
/*!40000 ALTER TABLE `oa_data_raw_tracker_variable_value` DISABLE KEYS */;
INSERT INTO `oa_data_raw_tracker_variable_value` VALUES (1,'singleDB',1,'2007-06-01 15:13:26','123'),(1,'singleDB',2,'2007-06-01 15:13:26','test123'),(2,'singleDB',1,'2007-06-01 15:13:37','123'),(2,'singleDB',2,'2007-06-01 15:13:37','test123'),(3,'singleDB',1,'2007-06-01 15:23:06','123'),(3,'singleDB',2,'2007-06-01 15:23:06','test123'),(4,'singleDB',1,'2007-06-01 15:23:07','123'),(4,'singleDB',2,'2007-06-01 15:23:07','test123'),(5,'singleDB',1,'2007-06-01 15:25:09','123'),(5,'singleDB',2,'2007-06-01 15:25:09','test123'),(6,'singleDB',1,'2007-06-01 15:25:53','123'),(6,'singleDB',2,'2007-06-01 15:25:53','test123');
/*!40000 ALTER TABLE `oa_data_raw_tracker_variable_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_summary_ad_hourly`
--

DROP TABLE IF EXISTS `oa_data_summary_ad_hourly`;
CREATE TABLE `oa_data_summary_ad_hourly` (
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
  KEY `oa_data_summary_ad_hourly_date_time` (`date_time`),
  KEY `oa_data_summary_ad_hourly_ad_id_date_time` (`ad_id`,`date_time`),
  KEY `oa_data_summary_ad_hourly_zone_id_date_time` (`zone_id`,`date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_summary_ad_hourly`
--

LOCK TABLES `oa_data_summary_ad_hourly` WRITE;
/*!40000 ALTER TABLE `oa_data_summary_ad_hourly` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_summary_ad_hourly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_summary_ad_zone_assoc`
--

DROP TABLE IF EXISTS `oa_data_summary_ad_zone_assoc`;
CREATE TABLE `oa_data_summary_ad_zone_assoc` (
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
  KEY `data_summary_ad_zone_assoc_interval_start` (`interval_start`),
  KEY `data_summary_ad_zone_assoc_interval_end` (`interval_end`),
  KEY `data_summary_ad_zone_assoc_ad_id` (`ad_id`),
  KEY `data_summary_ad_zone_assoc_zone_id` (`zone_id`),
  KEY `expired` (`expired`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_summary_ad_zone_assoc`
--

LOCK TABLES `oa_data_summary_ad_zone_assoc` WRITE;
/*!40000 ALTER TABLE `oa_data_summary_ad_zone_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_summary_ad_zone_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_summary_channel_daily`
--

DROP TABLE IF EXISTS `oa_data_summary_channel_daily`;
CREATE TABLE `oa_data_summary_channel_daily` (
  `data_summary_channel_daily_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `forecast_impressions` int(10) unsigned NOT NULL default '0',
  `actual_impressions` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`data_summary_channel_daily_id`),
  KEY `data_summary_channel_daily_day` (`day`),
  KEY `data_summary_channel_daily_channel_id` (`channel_id`),
  KEY `data_summary_channel_daily_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_summary_channel_daily`
--

LOCK TABLES `oa_data_summary_channel_daily` WRITE;
/*!40000 ALTER TABLE `oa_data_summary_channel_daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_summary_channel_daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_data_summary_zone_impression_history`
--

DROP TABLE IF EXISTS `oa_data_summary_zone_impression_history`;
CREATE TABLE `oa_data_summary_zone_impression_history` (
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
  KEY `data_summary_zone_impression_history_operation_interval_id` (`operation_interval_id`),
  KEY `data_summary_zone_impression_history_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_summary_zone_impression_history`
--

LOCK TABLES `oa_data_summary_zone_impression_history` WRITE;
/*!40000 ALTER TABLE `oa_data_summary_zone_impression_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_data_summary_zone_impression_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_images`
--

DROP TABLE IF EXISTS `oa_images`;
CREATE TABLE `oa_images` (
  `filename` varchar(128) NOT NULL default '',
  `contents` longblob NOT NULL,
  `t_stamp` datetime default NULL,
  PRIMARY KEY  (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_images`
--

LOCK TABLES `oa_images` WRITE;
/*!40000 ALTER TABLE `oa_images` DISABLE KEYS */;
INSERT INTO `oa_images` VALUES ('468x60.gif','GIF89a�<\0�\0\0uuu���DDD�����?��000���   eee���UUU������\0\0\0!�\0\0\0\0\0,\0\0\0\0�<\0\0���I��8�?�`(�di�h��l�p,�tm�x��|�?��cH\nP�\"�(\nB��X6�\r��JZ�P��$�Q�z�nW\Z��$0���?$���\0bnuqz\'	B�C	����.�s\"	�x���x\0���E�$\0�������A�#\n��C������D�!~�?�?���q�\n�w?�?������6���v��E���>�#�C.p�`S�8t\0QR�5xs��?(����A�D\"�0\\<�N�?R���$?81le��d(S�[4�\0 @@��E2���I(\0�P��0�\0�s0�?d��a�Y�����\0�\"$�\\	}�?�H��\\h���g��t��^�{,;��2��<�T	�5P�\Z�hk^S�\04��	��@6?\'��a8�\0.�?y-��S�F�e+8j7���<��?CG�Q�w?V���J�!��\0Kw?A�n6�E���}C��_il \"�5H�l���\00 \0s��/�l��e!����u���k@��t�x�PmX�i@�@��ur��C��BV�I�!���$�� [�B�fP8�O?\0��7��-�i?�9�F�0�y�+���D����ei�n��\nG��AahZ���=�X�$�B�3f(qu9b�Z��.���A\Z*j���(�wTp\0Q���\"(�H}YI�C�y�j�9�*��?�t\0�B��,\nr*z������\r�\0}�e@��r?\Z�v?z�N��M@�W�jp����&?�^p,r�t�\ZlJ\n~��d�T\0�c�>?�\0�b=��kqz\n���p�� �q�8�����?��?\Z��4�gWP.�q��I\0$O�����;�l�����5Wm��CH�30Q�z�\\��Z���]?A?mm5�[�6�ig��\"�4\0c����v��Ml�o[-�\0��l/����\rK\0$np�(��\rK���?�(R]x�X�&���\0g`������2@���nW?�n���!u���.j?�~zU��.��<Q�~�v��<�s�����+��9����?�O??�D�����=��/[z��smT� ��\Z��c�+\Z��\n�l�������[[�&0���l>x�\Z(��D@��@�A��]���-�$�!N�{?B�	�?x�\\L�#��~~�a��*\Z*�������U�aK]�J�/���w� ��C\r\\?��W�?F��1Y�? e-���s\0�^F(#�qtt@%�x��Z�I�X��%����DC2��*�Nf�a�4�\"\'��?H�wM�@����q}�t�P����CR@6(_(EY�G�?K�)X�)b\0���O��J8l�.�4J�<&����0?�I �3�\r65�M�(�\0f�&5{��n��c+��J xS�)R�;;P���\"?:�S�}X@V��3#5O�B���z��\r 4�&\n�U��t\rt��Y�9�Q*���-�y�?\"�#��N:�	}��URA�q����hD%;�J`�E8L��j�|n vC�`\ZH�4��9@S��?zu�^��!P8K��k�1� ?%���%��.�x�,�X�=����TT�d`�g?zE.�#>IH�]%G��s�_�Z5o>�s�S�Zl�RC���J5�8��Cc��6K�M\0�?l�,�� ]�\0�Cj;\0(4\0B�*�:?gv�G�E�msF�Z\n,b��lGg��S���6�Z�Y%?)LN���Lw���MpaQ$dN�z�ZR�;?� Qd=?�	v@���U�(�f��EUQ�^���[�X=p�?�I�K�\\:?I�	��N��`�AXy�8%`Gl-�}�-�UW��,�u�-�N�\0#��h]/<�NtXSUa�,}��v�1�x�?e�P��\r����.m.o��,s�[?���d��	�[A`�2(c)�%%�f0?|��:?g6�?N�\n���F;\Z\0\0;','2007-05-17 12:01:02');
/*!40000 ALTER TABLE `oa_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_lb_local`
--

DROP TABLE IF EXISTS `oa_lb_local`;
CREATE TABLE `oa_lb_local` (
  `last_run` int(11) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_lb_local`
--

LOCK TABLES `oa_lb_local` WRITE;
/*!40000 ALTER TABLE `oa_lb_local` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_lb_local` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_log_maintenance_forecasting`
--

DROP TABLE IF EXISTS `oa_log_maintenance_forecasting`;
CREATE TABLE `oa_log_maintenance_forecasting` (
  `log_maintenance_forecasting_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_forecasting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_log_maintenance_forecasting`
--

LOCK TABLES `oa_log_maintenance_forecasting` WRITE;
/*!40000 ALTER TABLE `oa_log_maintenance_forecasting` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_log_maintenance_forecasting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_log_maintenance_priority`
--

DROP TABLE IF EXISTS `oa_log_maintenance_priority`;
CREATE TABLE `oa_log_maintenance_priority` (
  `log_maintenance_priority_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `run_type` tinyint(3) unsigned NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_priority_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_log_maintenance_priority`
--

LOCK TABLES `oa_log_maintenance_priority` WRITE;
/*!40000 ALTER TABLE `oa_log_maintenance_priority` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_log_maintenance_priority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_log_maintenance_statistics`
--

DROP TABLE IF EXISTS `oa_log_maintenance_statistics`;
CREATE TABLE `oa_log_maintenance_statistics` (
  `log_maintenance_statistics_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `adserver_run_type` int(2) default NULL,
  `search_run_type` int(2) default NULL,
  `tracker_run_type` int(2) default NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_statistics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_log_maintenance_statistics`
--

LOCK TABLES `oa_log_maintenance_statistics` WRITE;
/*!40000 ALTER TABLE `oa_log_maintenance_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_log_maintenance_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_password_recovery`
--

DROP TABLE IF EXISTS `oa_password_recovery`;
CREATE TABLE `oa_password_recovery` (
  `user_type` varchar(64) NOT NULL default '',
  `user_id` int(10) NOT NULL,
  `recovery_id` varchar(64) NOT NULL default '',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`user_type`,`user_id`),
  UNIQUE KEY `recovery_id` (`recovery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_password_recovery`
--

LOCK TABLES `oa_password_recovery` WRITE;
/*!40000 ALTER TABLE `oa_password_recovery` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_password_recovery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_placement_zone_assoc`
--

DROP TABLE IF EXISTS `oa_placement_zone_assoc`;
CREATE TABLE `oa_placement_zone_assoc` (
  `placement_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `placement_id` mediumint(9) default NULL,
  PRIMARY KEY  (`placement_zone_assoc_id`),
  KEY `placement_zone_assoc_zone_id` (`zone_id`),
  KEY `placement_id` (`placement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_placement_zone_assoc`
--

LOCK TABLES `oa_placement_zone_assoc` WRITE;
/*!40000 ALTER TABLE `oa_placement_zone_assoc` DISABLE KEYS */;
INSERT INTO `oa_placement_zone_assoc` VALUES (1,1,1),(2,1,2),(3,2,3);
/*!40000 ALTER TABLE `oa_placement_zone_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_plugins_channel_delivery_assoc`
--

DROP TABLE IF EXISTS `oa_plugins_channel_delivery_assoc`;
CREATE TABLE `oa_plugins_channel_delivery_assoc` (
  `rule_id` int(10) unsigned NOT NULL default '0',
  `domain_id` int(10) unsigned NOT NULL default '0',
  `rule_order` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`rule_id`,`domain_id`),
  KEY `domain_id` (`domain_id`),
  KEY `rule_id` (`rule_id`),
  KEY `rule_order` (`rule_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_plugins_channel_delivery_assoc`
--

LOCK TABLES `oa_plugins_channel_delivery_assoc` WRITE;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_assoc` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_assoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_plugins_channel_delivery_domains`
--

DROP TABLE IF EXISTS `oa_plugins_channel_delivery_domains`;
CREATE TABLE `oa_plugins_channel_delivery_domains` (
  `domain_id` int(10) unsigned NOT NULL auto_increment,
  `domain_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`domain_id`),
  KEY `domain_name` (`domain_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_plugins_channel_delivery_domains`
--

LOCK TABLES `oa_plugins_channel_delivery_domains` WRITE;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_domains` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_plugins_channel_delivery_rules`
--

DROP TABLE IF EXISTS `oa_plugins_channel_delivery_rules`;
CREATE TABLE `oa_plugins_channel_delivery_rules` (
  `rule_id` int(10) unsigned NOT NULL auto_increment,
  `modifier` varchar(100) NOT NULL default '',
  `client` varchar(100) NOT NULL default '',
  `rule` text NOT NULL,
  PRIMARY KEY  (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_plugins_channel_delivery_rules`
--

LOCK TABLES `oa_plugins_channel_delivery_rules` WRITE;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_preference_advertiser`
--

DROP TABLE IF EXISTS `oa_preference_advertiser`;
CREATE TABLE `oa_preference_advertiser` (
  `advertiser_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`advertiser_id`,`preference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_preference_advertiser`
--

LOCK TABLES `oa_preference_advertiser` WRITE;
/*!40000 ALTER TABLE `oa_preference_advertiser` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_preference_advertiser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_preference_publisher`
--

DROP TABLE IF EXISTS `oa_preference_publisher`;
CREATE TABLE `oa_preference_publisher` (
  `publisher_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`publisher_id`,`preference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_preference_publisher`
--

LOCK TABLES `oa_preference_publisher` WRITE;
/*!40000 ALTER TABLE `oa_preference_publisher` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_preference_publisher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_preferences`
--

DROP TABLE IF EXISTS `oa_preferences`;
CREATE TABLE `oa_preferences` (
  `preference_id` mediumint(9) NOT NULL auto_increment,
  `preference_name` varchar(64) NOT NULL default '',
  `account_type` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`preference_id`),
  UNIQUE KEY `oa_preferences_preference_name` (`preference_name`),
  KEY `oa_preferences_account_type` (`account_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_preferences`
--

LOCK TABLES `oa_preferences` WRITE;
/*!40000 ALTER TABLE `oa_preferences` DISABLE KEYS */;
INSERT INTO `oa_preferences` VALUES (1,'language','ADMIN'),(2,'ui_week_start_day','ADMIN'),(3,'ui_percentage_decimals','ADMIN'),(4,'warn_admin','ADMIN'),(5,'warn_email_manager','ADMIN'),(6,'warn_email_advertiser','ADMIN'),(7,'warn_email_admin_impression_limit','ADMIN'),(8,'warn_email_admin_day_limit','ADMIN'),(9,'ui_novice_user','ADMIN'),(10,'default_banner_weight','ADMIN'),(11,'default_campaign_weight','ADMIN'),(12,'default_banner_image_url','ADMIN'),(13,'default_banner_destination_url','ADMIN'),(14,'ui_show_campaign_info','ADMIN'),(15,'ui_show_campaign_preview','ADMIN'),(16,'ui_show_banner_info','ADMIN'),(17,'ui_show_banner_preview','ADMIN'),(18,'ui_show_banner_html','ADMIN'),(19,'ui_show_matching_banners','ADMIN'),(20,'ui_show_matching_banners_parents','ADMIN'),(21,'ui_hide_inactive','ADMIN'),(22,'tracker_default_status','ADMIN'),(23,'tracker_default_type','ADMIN'),(24,'tracker_link_campaigns','ADMIN'),(25,'ui_column_id','ADMIN'),(26,'ui_column_id_label','ADMIN'),(27,'ui_column_id_rank','ADMIN'),(28,'ui_column_requests','ADMIN'),(29,'ui_column_requests_label','ADMIN'),(30,'ui_column_requests_rank','ADMIN'),(31,'ui_column_impressions','ADMIN'),(32,'ui_column_impressions_label','ADMIN'),(33,'ui_column_impressions_rank','ADMIN'),(34,'ui_column_clicks','ADMIN'),(35,'ui_column_clicks_label','ADMIN'),(36,'ui_column_clicks_rank','ADMIN'),(37,'ui_column_ctr','ADMIN'),(38,'ui_column_ctr_label','ADMIN'),(39,'ui_column_ctr_rank','ADMIN'),(40,'ui_column_conversions','ADMIN'),(41,'ui_column_conversions_label','ADMIN'),(42,'ui_column_conversions_rank','ADMIN'),(43,'ui_column_conversions_pending','ADMIN'),(44,'ui_column_conversions_pending_label','ADMIN'),(45,'ui_column_conversions_pending_rank','ADMIN'),(46,'ui_column_sr_views','ADMIN'),(47,'ui_column_sr_views_label','ADMIN'),(48,'ui_column_sr_views_rank','ADMIN'),(49,'ui_column_sr_clicks','ADMIN'),(50,'ui_column_sr_clicks_label','ADMIN'),(51,'ui_column_sr_clicks_rank','ADMIN'),(52,'ui_column_revenue','ADMIN'),(53,'ui_column_revenue_label','ADMIN'),(54,'ui_column_revenue_rank','ADMIN'),(55,'ui_column_cost','ADMIN'),(56,'ui_column_cost_label','ADMIN'),(57,'ui_column_cost_rank','ADMIN'),(58,'ui_column_bv','ADMIN'),(59,'ui_column_bv_label','ADMIN'),(60,'ui_column_bv_rank','ADMIN'),(61,'ui_column_num_items','ADMIN'),(62,'ui_column_num_items_label','ADMIN'),(63,'ui_column_num_items_rank','ADMIN'),(64,'ui_column_revcpc','ADMIN'),(65,'ui_column_revcpc_label','ADMIN'),(66,'ui_column_revcpc_rank','ADMIN'),(67,'ui_column_costcpc','ADMIN'),(68,'ui_column_costcpc_label','ADMIN'),(69,'ui_column_costcpc_rank','ADMIN'),(70,'ui_column_technology_cost','ADMIN'),(71,'ui_column_technology_cost_label','ADMIN'),(72,'ui_column_technology_cost_rank','ADMIN'),(73,'ui_column_income','ADMIN'),(74,'ui_column_income_label','ADMIN'),(75,'ui_column_income_rank','ADMIN'),(76,'ui_column_income_margin','ADMIN'),(77,'ui_column_income_margin_label','ADMIN'),(78,'ui_column_income_margin_rank','ADMIN'),(79,'ui_column_profit','ADMIN'),(80,'ui_column_profit_label','ADMIN'),(81,'ui_column_profit_rank','ADMIN'),(82,'ui_column_margin','ADMIN'),(83,'ui_column_margin_label','ADMIN'),(84,'ui_column_margin_rank','ADMIN'),(85,'ui_column_erpm','ADMIN'),(86,'ui_column_erpm_label','ADMIN'),(87,'ui_column_erpm_rank','ADMIN'),(88,'ui_column_erpc','ADMIN'),(89,'ui_column_erpc_label','ADMIN'),(90,'ui_column_erpc_rank','ADMIN'),(91,'ui_column_erps','ADMIN'),(92,'ui_column_erps_label','ADMIN'),(93,'ui_column_erps_rank','ADMIN'),(94,'ui_column_eipm','ADMIN'),(95,'ui_column_eipm_label','ADMIN'),(96,'ui_column_eipm_rank','ADMIN'),(97,'ui_column_eipc','ADMIN'),(98,'ui_column_eipc_label','ADMIN'),(99,'ui_column_eipc_rank','ADMIN'),(100,'ui_column_eips','ADMIN'),(101,'ui_column_eips_label','ADMIN'),(102,'ui_column_eips_rank','ADMIN'),(103,'ui_column_ecpm','ADMIN'),(104,'ui_column_ecpm_label','ADMIN'),(105,'ui_column_ecpm_rank','ADMIN'),(106,'ui_column_ecpc','ADMIN'),(107,'ui_column_ecpc_label','ADMIN'),(108,'ui_column_ecpc_rank','ADMIN'),(109,'ui_column_ecps','ADMIN'),(110,'ui_column_ecps_label','ADMIN'),(111,'ui_column_ecps_rank','ADMIN'),(112,'ui_column_epps','ADMIN'),(113,'ui_column_epps_label','ADMIN'),(114,'ui_column_epps_rank','ADMIN');
/*!40000 ALTER TABLE `oa_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_session`
--

DROP TABLE IF EXISTS `oa_session`;
CREATE TABLE `oa_session` (
  `sessionid` varchar(32) NOT NULL default '',
  `sessiondata` longblob NOT NULL,
  `lastused` datetime default NULL,
  PRIMARY KEY  (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_session`
--

LOCK TABLES `oa_session` WRITE;
/*!40000 ALTER TABLE `oa_session` DISABLE KEYS */;
INSERT INTO `oa_session` VALUES ('phpads465c3580ef7ff1.90755088','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:8:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:7:\"GLOBALS\";a:3:{s:13:\"period_preset\";s:5:\"today\";s:12:\"period_start\";s:10:\"2007-06-01\";s:10:\"period_end\";s:10:\"2007-06-01\";}s:9:\"stats.php\";a:5:{s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";s:10:\"startlevel\";i:0;s:5:\"nodes\";s:0:\"\";s:12:\"hideinactive\";b:1;}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}s:24:\"advertiser-campaigns.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-campaigns.php\";a:3:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-variables.php\";a:1:{s:9:\"trackerid\";s:1:\"1\";}}s:12:\"update_check\";b:0;}','2007-06-01 15:09:52'),('phpads465d96668fc721.60249221','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:3:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:24:\"advertiser-campaigns.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}}s:12:\"update_check\";b:0;}','2007-06-01 17:15:27'),('phpads4666d2619a15a3.52419402','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}s:12:\"update_check\";b:0;}','2007-06-06 16:27:35'),('phpads468a364daaa084.23126755','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:2:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:12:\"update_check\";b:0;}','2007-07-03 14:48:40'),('phpads46d44deed3dd40.69179106','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}s:15:\"maint_update_js\";b:1;}','2007-08-30 11:06:32'),('phpads47877c12cd8115.03124044','a:3:{s:4:\"user\";O:18:\"oa_permission_user\":2:{s:5:\"aUser\";a:10:{s:7:\"user_id\";s:1:\"1\";s:12:\"contact_name\";s:11:\"Andrew Hill\";s:13:\"email_address\";s:23:\"andrew.hill@openads.org\";s:8:\"username\";s:5:\"admin\";s:18:\"default_account_id\";s:1:\"2\";s:8:\"comments\";s:0:\"\";s:6:\"active\";s:1:\"1\";s:10:\"account_id\";s:1:\"2\";s:12:\"account_type\";s:7:\"MANAGER\";s:12:\"account_name\";s:15:\"Default manager\";}s:8:\"aAccount\";a:5:{s:10:\"account_id\";s:1:\"1\";s:12:\"account_type\";s:5:\"ADMIN\";s:12:\"account_name\";s:13:\"Administrator\";s:9:\"entity_id\";i:0;s:9:\"agency_id\";i:0;}}s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}s:15:\"maint_update_js\";b:1;}','2008-01-11 14:47:54');
/*!40000 ALTER TABLE `oa_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_targetstats`
--

DROP TABLE IF EXISTS `oa_targetstats`;
CREATE TABLE `oa_targetstats` (
  `day` date NOT NULL default '0000-00-00',
  `campaignid` mediumint(9) NOT NULL default '0',
  `target` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `modified` tinyint(4) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_targetstats`
--

LOCK TABLES `oa_targetstats` WRITE;
/*!40000 ALTER TABLE `oa_targetstats` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_targetstats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_tracker_append`
--

DROP TABLE IF EXISTS `oa_tracker_append`;
CREATE TABLE `oa_tracker_append` (
  `tracker_append_id` int(11) NOT NULL auto_increment,
  `tracker_id` mediumint(9) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `tagcode` text NOT NULL,
  `paused` enum('t','f') NOT NULL default 'f',
  `autotrack` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`tracker_append_id`),
  KEY `tracker_id` (`tracker_id`,`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_tracker_append`
--

LOCK TABLES `oa_tracker_append` WRITE;
/*!40000 ALTER TABLE `oa_tracker_append` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_tracker_append` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_trackers`
--

DROP TABLE IF EXISTS `oa_trackers`;
CREATE TABLE `oa_trackers` (
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
  KEY `trackers_clientid` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_trackers`
--

LOCK TABLES `oa_trackers` WRITE;
/*!40000 ALTER TABLE `oa_trackers` DISABLE KEYS */;
INSERT INTO `oa_trackers` VALUES (1,'Sample Tracker','',1,3,3,0,4,1,'f','js','','2007-06-01 15:09:47');
/*!40000 ALTER TABLE `oa_trackers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_userlog`
--

DROP TABLE IF EXISTS `oa_userlog`;
CREATE TABLE `oa_userlog` (
  `userlogid` mediumint(9) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL default '0',
  `usertype` tinyint(4) NOT NULL default '0',
  `userid` mediumint(9) NOT NULL default '0',
  `action` mediumint(9) NOT NULL default '0',
  `object` mediumint(9) default NULL,
  `details` longblob,
  PRIMARY KEY  (`userlogid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_userlog`
--

LOCK TABLES `oa_userlog` WRITE;
/*!40000 ALTER TABLE `oa_userlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_userlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_users`
--

DROP TABLE IF EXISTS `oa_users`;
CREATE TABLE `oa_users` (
  `user_id` mediumint(9) NOT NULL auto_increment,
  `contact_name` varchar(255) NOT NULL default '',
  `email_address` varchar(64) NOT NULL default '',
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `default_account_id` mediumint(9) default NULL,
  `comments` text,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `oa_users_username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_users`
--

LOCK TABLES `oa_users` WRITE;
/*!40000 ALTER TABLE `oa_users` DISABLE KEYS */;
INSERT INTO `oa_users` VALUES (1,'Andrew Hill','andrew.hill@openads.org','admin','5f4dcc3b5aa765d61d8327deb882cf99',2,NULL,1),(2,'Andrew Hill','andrew.hill@openads.org','agency','5f4dcc3b5aa765d61d8327deb882cf99',3,NULL,1),(3,'advertiser','example@example.com','advertiser1','fe1f4b7940d69cf3eb289fad37c3ae40',4,NULL,1),(4,'Andrew Hill','andrew.hill@openads.org','publisher','5f4dcc3b5aa765d61d8327deb882cf99',5,NULL,1);
/*!40000 ALTER TABLE `oa_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_variable_publisher`
--

DROP TABLE IF EXISTS `oa_variable_publisher`;
CREATE TABLE `oa_variable_publisher` (
  `variable_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`variable_id`,`publisher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_variable_publisher`
--

LOCK TABLES `oa_variable_publisher` WRITE;
/*!40000 ALTER TABLE `oa_variable_publisher` DISABLE KEYS */;
/*!40000 ALTER TABLE `oa_variable_publisher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_variables`
--

DROP TABLE IF EXISTS `oa_variables`;
CREATE TABLE `oa_variables` (
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
  KEY `variables_is_unique` (`is_unique`),
  KEY `variables_trackerid` (`trackerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_variables`
--

LOCK TABLES `oa_variables` WRITE;
/*!40000 ALTER TABLE `oa_variables` DISABLE KEYS */;
INSERT INTO `oa_variables` VALUES (1,1,'boo','Sample number','numeric',NULL,0,0,0,'var boo = \\\'%%BOO_VALUE%%\\\'','f','2007-06-01 15:09:47'),(2,1,'foo','Sample string','string',NULL,0,0,0,'var foo = \\\'%%FOO_VALUE%%\\\'','f','2007-06-01 15:09:47');
/*!40000 ALTER TABLE `oa_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oa_zones`
--

DROP TABLE IF EXISTS `oa_zones`;
CREATE TABLE `oa_zones` (
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
  PRIMARY KEY  (`zoneid`),
  KEY `oa_zones_zonenameid` (`zonename`,`zoneid`),
  KEY `oa_zones_affiliateid` (`affiliateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_zones`
--

LOCK TABLES `oa_zones` WRITE;
/*!40000 ALTER TABLE `oa_zones` DISABLE KEYS */;
INSERT INTO `oa_zones` VALUES (1,1,'Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,'',NULL,NULL,'2007-04-27 15:37:19',0,0,0,'',NULL),(2,2,'Agency Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,'',NULL,NULL,'2007-05-15 13:41:44',0,0,0,'',NULL);
/*!40000 ALTER TABLE `oa_zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-01-11 14:51:41
