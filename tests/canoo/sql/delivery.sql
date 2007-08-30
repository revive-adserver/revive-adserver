-- MySQL dump 10.10
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


/*!40000 ALTER TABLE `oa_acls` DISABLE KEYS */;
LOCK TABLES `oa_acls` WRITE;
INSERT INTO `oa_acls` VALUES (1,'and','Site:Channel','=~','7',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_acls` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_acls_channel` DISABLE KEYS */;
LOCK TABLES `oa_acls_channel` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_acls_channel` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_ad_category_assoc` DISABLE KEYS */;
LOCK TABLES `oa_ad_category_assoc` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_ad_category_assoc` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_ad_zone_assoc` DISABLE KEYS */;
LOCK TABLES `oa_ad_zone_assoc` WRITE;
INSERT INTO `oa_ad_zone_assoc` VALUES (1,0,1,1,0,1670960,1),(2,1,1,0.9,1,100,1),(3,0,2,0,0,1,1),(4,1,2,0,1,1,1),(5,2,1,0.9,1,100,1),(6,0,3,0,0,0,1),(7,1,3,0,1,1,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_ad_zone_assoc` ENABLE KEYS */;

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
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `publiczones` enum('t','f') NOT NULL default 'f',
  `last_accepted_agency_agreement` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`affiliateid`),
  KEY `affiliates_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_affiliates`
--


/*!40000 ALTER TABLE `oa_affiliates` DISABLE KEYS */;
LOCK TABLES `oa_affiliates` WRITE;
INSERT INTO `oa_affiliates` VALUES (1,0,'Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://www.fornax.net/blog/','publisher','5f4dcc3b5aa765d61d8327deb882cf99',0,'','f',NULL,'2007-05-15 13:29:57'),(2,1,'Agency Publisher 1','','','Andrew Hill','andrew.hill@openads.org','http://fornax.net',NULL,'',0,NULL,'f',NULL,'2007-05-15 13:41:40');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_affiliates` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_affiliates_extra` DISABLE KEYS */;
LOCK TABLES `oa_affiliates_extra` WRITE;
INSERT INTO `oa_affiliates_extra` VALUES (1,'','','','','','','','','','Cheque by post','GBP',0,0,0,'',''),(2,'','','','','','','','','','Cheque by post','GBP',0,0,0,NULL,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_affiliates_extra` ENABLE KEYS */;

--
-- Table structure for table `oa_agency`
--

DROP TABLE IF EXISTS `oa_agency`;
CREATE TABLE `oa_agency` (
  `agencyid` mediumint(9) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) default NULL,
  `email` varchar(64) NOT NULL default '',
  `username` varchar(64) default NULL,
  `password` varchar(64) default NULL,
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `logout_url` varchar(255) default NULL,
  `active` smallint(1) default '0',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_agency`
--


/*!40000 ALTER TABLE `oa_agency` DISABLE KEYS */;
LOCK TABLES `oa_agency` WRITE;
INSERT INTO `oa_agency` VALUES (1,'Test Agency','Andrew Hill','andrew.hill@openads.org','agency','5f4dcc3b5aa765d61d8327deb882cf99',0,'','',0,'2007-05-15 12:54:16');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_agency` ENABLE KEYS */;

--
-- Table structure for table `oa_application_variable`
--

DROP TABLE IF EXISTS `oa_application_variable`;
CREATE TABLE `oa_application_variable` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_application_variable`
--


/*!40000 ALTER TABLE `oa_application_variable` DISABLE KEYS */;
LOCK TABLES `oa_application_variable` WRITE;
INSERT INTO `oa_application_variable` VALUES ('tables_core','516'),('oa_version','2.5.1-dev'),('platform_hash','39adcaa8840247618ff928521ba95397770c5b67');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_application_variable` ENABLE KEYS */;

--
-- Table structure for table `oa_banners`
--

DROP TABLE IF EXISTS `oa_banners`;
CREATE TABLE `oa_banners` (
  `bannerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `active` enum('t','f') NOT NULL default 't',
  `contenttype` enum('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') NOT NULL default 'gif',
  `pluginversion` mediumint(9) NOT NULL default '0',
  `storagetype` enum('sql','web','url','html','network','txt') NOT NULL default 'sql',
  `filename` varchar(255) NOT NULL default '',
  `imageurl` varchar(255) NOT NULL default '',
  `htmltemplate` longblob NOT NULL,
  `htmlcache` longblob NOT NULL,
  `width` smallint(6) NOT NULL default '0',
  `height` smallint(6) NOT NULL default '0',
  `weight` tinyint(4) NOT NULL default '1',
  `seq` tinyint(4) NOT NULL default '0',
  `target` varchar(16) NOT NULL default '',
  `url` text NOT NULL,
  `alt` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `bannertext` longblob NOT NULL,
  `description` varchar(255) NOT NULL default '',
  `autohtml` enum('t','f') NOT NULL default 't',
  `adserver` varchar(50) NOT NULL default '',
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `compiledlimitation` longblob NOT NULL,
  `acl_plugins` text NOT NULL,
  `append` longblob NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `bannertype` tinyint(4) NOT NULL default '0',
  `alt_filename` varchar(255) NOT NULL default '',
  `alt_imageurl` varchar(255) NOT NULL default '',
  `alt_contenttype` enum('gif','jpg','png') NOT NULL default 'gif',
  `comments` text,
  `updated` datetime default NULL,
  `acls_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `keyword` varchar(255) NOT NULL default '',
  `transparent` tinyint(4) NOT NULL default '0',
  `parameters` text NOT NULL,
  PRIMARY KEY  (`bannerid`),
  KEY `banners_campaignid` (`campaignid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_banners`
--


/*!40000 ALTER TABLE `oa_banners` DISABLE KEYS */;
LOCK TABLES `oa_banners` WRITE;
INSERT INTO `oa_banners` VALUES (1,1,'t','html',0,'html','','','Test HTML Banner!','Test HTML Banner!',468,60,1,0,'','','','','','','t','',0,0,0,'(MAX_checkSite_Channel(\'7\', \'=~\'))','Site:Channel','',0,0,'','','gif','','2007-08-29 14:38:32','2007-05-15 15:01:43','',0,'N;'),(2,2,'t','html',0,'html','','','html test banner','<a href=\"{clickurl}\" target=\"{target}\">html test banner</a>',468,60,1,0,'','http://www.example.com','','','','test banner','t','',0,0,0,'','','',0,0,'','','gif','','2007-08-29 14:38:32','0000-00-00 00:00:00','',0,'N;'),(3,3,'t','gif',0,'sql','468x60.gif','','','',468,60,1,0,'','http://www.example.com','alt text','','','sample gif banner','f','',0,0,0,'','','',0,0,'','','gif','','2007-08-29 14:38:32','0000-00-00 00:00:00','',0,'N;');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_banners` ENABLE KEYS */;

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
  `active` enum('t','f') NOT NULL default 't',
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
  PRIMARY KEY  (`campaignid`),
  KEY `campaigns_clientid` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_campaigns`
--


/*!40000 ALTER TABLE `oa_campaigns` DISABLE KEYS */;
LOCK TABLES `oa_campaigns` WRITE;
INSERT INTO `oa_campaigns` VALUES (1,'Advertiser 1 - Default Campaign',1,100000000,-1,-1,'2007-07-01','0000-00-00','t',10,0,0,0,0,'f',0,'',NULL,NULL,'2007-05-15 09:54:06',0,0,0),(2,'test campaign',1,-1,-1,-1,'0000-00-00','0000-00-00','t',-1,1,0,0,0,'t',0,'',NULL,NULL,'2007-05-16 12:55:24',0,0,0),(3,'campaign 2 (gif)',1,-1,-1,-1,'0000-00-00','0000-00-00','t',0,1,0,0,0,'t',0,'',NULL,NULL,'2007-05-17 13:14:43',0,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_campaigns` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_campaigns_trackers` DISABLE KEYS */;
LOCK TABLES `oa_campaigns_trackers` WRITE;
INSERT INTO `oa_campaigns_trackers` VALUES (1,3,1,3,3,4);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_campaigns_trackers` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_category` DISABLE KEYS */;
LOCK TABLES `oa_category` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_category` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_channel` DISABLE KEYS */;
LOCK TABLES `oa_channel` WRITE;
INSERT INTO `oa_channel` VALUES (7,0,0,'Test Admin Channel 2','','true','true',1,'','0000-00-00 00:00:00','0000-00-00 00:00:00');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_channel` ENABLE KEYS */;

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
  `clientusername` varchar(64) NOT NULL default '',
  `clientpassword` varchar(64) NOT NULL default '',
  `permissions` mediumint(9) default NULL,
  `language` varchar(64) default NULL,
  `report` enum('t','f') NOT NULL default 't',
  `reportinterval` mediumint(9) NOT NULL default '7',
  `reportlastdate` date NOT NULL default '0000-00-00',
  `reportdeactivate` enum('t','f') NOT NULL default 't',
  `comments` text,
  `updated` datetime default NULL,
  `lb_reporting` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`clientid`),
  KEY `clients_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_clients`
--


/*!40000 ALTER TABLE `oa_clients` DISABLE KEYS */;
LOCK TABLES `oa_clients` WRITE;
INSERT INTO `oa_clients` VALUES (1,0,'Advertiser 1','advertiser','example@example.com','advertiser1','fe1f4b7940d69cf3eb289fad37c3ae40',0,'','f',7,'2007-04-27','t','','2007-05-16 12:54:09','f');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_clients` ENABLE KEYS */;

--
-- Table structure for table `oa_data_intermediate_ad`
--

DROP TABLE IF EXISTS `oa_data_intermediate_ad`;
CREATE TABLE `oa_data_intermediate_ad` (
  `data_intermediate_ad_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL,
  `hour` int(10) unsigned NOT NULL,
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
  KEY `data_intermediate_ad_day` (`day`),
  KEY `data_intermediate_ad_operation_interval_id` (`operation_interval_id`),
  KEY `data_intermediate_ad_ad_id` (`ad_id`),
  KEY `data_intermediate_ad_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_intermediate_ad`
--


/*!40000 ALTER TABLE `oa_data_intermediate_ad` DISABLE KEYS */;
LOCK TABLES `oa_data_intermediate_ad` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_intermediate_ad` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_intermediate_ad_connection` DISABLE KEYS */;
LOCK TABLES `oa_data_intermediate_ad_connection` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_intermediate_ad_connection` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_intermediate_ad_variable_value` DISABLE KEYS */;
LOCK TABLES `oa_data_intermediate_ad_variable_value` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_intermediate_ad_variable_value` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_raw_ad_click` DISABLE KEYS */;
LOCK TABLES `oa_data_raw_ad_click` WRITE;
INSERT INTO `oa_data_raw_ad_click` VALUES ('1d0b8f22878ee21edac4d01eeb8793bd','','2007-08-29 15:19:19',2,0,0,NULL,NULL,'','127.0.0.1','127.0.0.1',NULL,NULL,NULL,NULL,NULL,NULL,'','Mozilla/4.0 (compatible; MSIE 6.0b; Windows 98)','','',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_raw_ad_click` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_raw_ad_impression` DISABLE KEYS */;
LOCK TABLES `oa_data_raw_ad_impression` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_raw_ad_impression` ENABLE KEYS */;

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
  KEY `data_raw_ad_request_viewer_id` (`viewer_id`),
  KEY `data_raw_ad_request_date_time` (`date_time`),
  KEY `data_raw_ad_request_ad_id` (`ad_id`),
  KEY `data_raw_ad_request_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_ad_request`
--


/*!40000 ALTER TABLE `oa_data_raw_ad_request` DISABLE KEYS */;
LOCK TABLES `oa_data_raw_ad_request` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_raw_ad_request` ENABLE KEYS */;

--
-- Table structure for table `oa_data_raw_tracker_click`
--

DROP TABLE IF EXISTS `oa_data_raw_tracker_click`;
CREATE TABLE `oa_data_raw_tracker_click` (
  `viewer_id` varchar(32) default NULL,
  `viewer_session_id` varchar(32) NOT NULL default '',
  `date_time` datetime NOT NULL,
  `tracker_id` int(10) unsigned NOT NULL,
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
  KEY `data_raw_tracker_click_viewer_id` (`viewer_id`),
  KEY `data_raw_tracker_click_date_time` (`date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_raw_tracker_click`
--


/*!40000 ALTER TABLE `oa_data_raw_tracker_click` DISABLE KEYS */;
LOCK TABLES `oa_data_raw_tracker_click` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_raw_tracker_click` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_raw_tracker_impression` DISABLE KEYS */;
LOCK TABLES `oa_data_raw_tracker_impression` WRITE;
INSERT INTO `oa_data_raw_tracker_impression` VALUES (1,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:13:26',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(2,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:13:37',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(3,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:23:06',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(4,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:23:07',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(5,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:24:37',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','',''),(6,'singleDB','6e8928c9063f85e75c8a457b42f50257','','2007-06-01 15:25:53',1,'','','en-us,en;q=0.5','127.0.0.1','127.0.0.1','',0,'','','','','','Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11','','',0,'','','','0.0000','0.0000','','','','','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_raw_tracker_impression` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_raw_tracker_variable_value` DISABLE KEYS */;
LOCK TABLES `oa_data_raw_tracker_variable_value` WRITE;
INSERT INTO `oa_data_raw_tracker_variable_value` VALUES (1,'singleDB',1,'2007-06-01 15:13:26','123'),(1,'singleDB',2,'2007-06-01 15:13:26','test123'),(2,'singleDB',1,'2007-06-01 15:13:37','123'),(2,'singleDB',2,'2007-06-01 15:13:37','test123'),(3,'singleDB',1,'2007-06-01 15:23:06','123'),(3,'singleDB',2,'2007-06-01 15:23:06','test123'),(4,'singleDB',1,'2007-06-01 15:23:07','123'),(4,'singleDB',2,'2007-06-01 15:23:07','test123'),(5,'singleDB',1,'2007-06-01 15:25:09','123'),(5,'singleDB',2,'2007-06-01 15:25:09','test123'),(6,'singleDB',1,'2007-06-01 15:25:53','123'),(6,'singleDB',2,'2007-06-01 15:25:53','test123');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_raw_tracker_variable_value` ENABLE KEYS */;

--
-- Table structure for table `oa_data_summary_ad_hourly`
--

DROP TABLE IF EXISTS `oa_data_summary_ad_hourly`;
CREATE TABLE `oa_data_summary_ad_hourly` (
  `data_summary_ad_hourly_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL,
  `hour` int(10) unsigned NOT NULL,
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
  KEY `data_summary_ad_hourly_day` (`day`),
  KEY `data_summary_ad_hourly_hour` (`hour`),
  KEY `data_summary_ad_hourly_ad_id` (`ad_id`),
  KEY `data_summary_ad_hourly_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_summary_ad_hourly`
--


/*!40000 ALTER TABLE `oa_data_summary_ad_hourly` DISABLE KEYS */;
LOCK TABLES `oa_data_summary_ad_hourly` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_summary_ad_hourly` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_summary_ad_zone_assoc` DISABLE KEYS */;
LOCK TABLES `oa_data_summary_ad_zone_assoc` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_summary_ad_zone_assoc` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_data_summary_channel_daily` DISABLE KEYS */;
LOCK TABLES `oa_data_summary_channel_daily` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_summary_channel_daily` ENABLE KEYS */;

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
  PRIMARY KEY  (`data_summary_zone_impression_history_id`),
  KEY `data_summary_zone_impression_history_operation_interval_id` (`operation_interval_id`),
  KEY `data_summary_zone_impression_history_zone_id` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_data_summary_zone_impression_history`
--


/*!40000 ALTER TABLE `oa_data_summary_zone_impression_history` DISABLE KEYS */;
LOCK TABLES `oa_data_summary_zone_impression_history` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_data_summary_zone_impression_history` ENABLE KEYS */;

--
-- Table structure for table `oa_database_action`
--

DROP TABLE IF EXISTS `oa_database_action`;
CREATE TABLE `oa_database_action` (
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
  KEY `database_action_upgrade_action_id` (`upgrade_action_id`,`database_action_id`),
  KEY `database_action_schema_version_timing_action` (`schema_name`,`version`,`timing`,`action`),
  KEY `database_action_updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_database_action`
--


/*!40000 ALTER TABLE `oa_database_action` DISABLE KEYS */;
LOCK TABLES `oa_database_action` WRITE;
INSERT INTO `oa_database_action` VALUES (1,1,'tables_core',516,0,10,'UPGRADE STARTED',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20'),(2,1,'tables_core',516,0,40,'BACKUP UNNECESSARY',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20'),(3,1,'tables_core',516,0,60,'UPGRADE SUCCEEDED',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20'),(4,1,'tables_core',516,1,10,'UPGRADE STARTED',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20'),(5,1,'tables_core',516,1,20,'BACKUP STARTED',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20'),(6,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_country_daily','z_625015862981b344','a:2:{s:6:\"fields\";a:6:{s:34:\"data_summary_zone_country_daily_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:3:\"day\";a:5:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:4:\"date\";s:7:\"default\";s:10:\"0000-00-00\";s:4:\"type\";s:12:\"openads_date\";s:8:\"mdb2type\";s:12:\"openads_date\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:7:\"country\";a:6:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:4:\"char\";s:6:\"length\";s:1:\"2\";s:7:\"default\";N;s:4:\"type\";s:12:\"openads_char\";s:8:\"mdb2type\";s:12:\"openads_char\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:35:\"data_summary_zone_country_daily_day\";a:1:{s:6:\"fields\";a:1:{s:3:\"day\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:39:\"data_summary_zone_country_daily_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:36:\"data_summary_zone_country_daily_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:34:\"data_summary_zone_country_daily_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(7,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_country_forecast','z_a4aeea003f0c5148','a:2:{s:6:\"fields\";a:5:{s:37:\"data_summary_zone_country_forecast_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:11:\"day_of_week\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:8:\"smallint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:0:\"\";s:4:\"type\";s:16:\"openads_smallint\";s:8:\"mdb2type\";s:16:\"openads_smallint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:0:\"\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:7:\"country\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:1:\"2\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:46:\"data_summary_zone_country_forecast_day_of_week\";a:1:{s:6:\"fields\";a:1:{s:11:\"day_of_week\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:42:\"data_summary_zone_country_forecast_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:39:\"data_summary_zone_country_forecast_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:37:\"data_summary_zone_country_forecast_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(8,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_country_monthly','z_002cc0f7c6553837','a:2:{s:6:\"fields\";a:6:{s:36:\"data_summary_zone_country_monthly_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:9:\"yearmonth\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:9:\"mediumint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:1:\"0\";s:4:\"type\";s:17:\"openads_mediumint\";s:8:\"mdb2type\";s:17:\"openads_mediumint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:7:\"country\";a:6:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:4:\"char\";s:6:\"length\";s:1:\"2\";s:7:\"default\";N;s:4:\"type\";s:12:\"openads_char\";s:8:\"mdb2type\";s:12:\"openads_char\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:43:\"data_summary_zone_country_monthly_yearmonth\";a:1:{s:6:\"fields\";a:1:{s:9:\"yearmonth\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:41:\"data_summary_zone_country_monthly_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:38:\"data_summary_zone_country_monthly_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:36:\"data_summary_zone_country_monthly_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(9,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_domain_page_daily','z_a121ecd0d9bd87c9','a:2:{s:6:\"fields\";a:7:{s:38:\"data_summary_zone_domain_page_daily_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:3:\"day\";a:5:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:4:\"date\";s:7:\"default\";s:10:\"0000-00-00\";s:4:\"type\";s:12:\"openads_date\";s:8:\"mdb2type\";s:12:\"openads_date\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"domain\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:4:\"page\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:39:\"data_summary_zone_domain_page_daily_day\";a:1:{s:6:\"fields\";a:1:{s:3:\"day\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:43:\"data_summary_zone_domain_page_daily_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:40:\"data_summary_zone_domain_page_daily_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:38:\"data_summary_zone_domain_page_daily_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(10,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_domain_page_forecast','z_2ee3a39f42a4561b','a:2:{s:6:\"fields\";a:6:{s:41:\"data_summary_zone_domain_page_forecast_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:11:\"day_of_week\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:8:\"smallint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:0:\"\";s:4:\"type\";s:16:\"openads_smallint\";s:8:\"mdb2type\";s:16:\"openads_smallint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:0:\"\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"domain\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:4:\"page\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:50:\"data_summary_zone_domain_page_forecast_day_of_week\";a:1:{s:6:\"fields\";a:1:{s:11:\"day_of_week\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:46:\"data_summary_zone_domain_page_forecast_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:43:\"data_summary_zone_domain_page_forecast_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:41:\"data_summary_zone_domain_page_forecast_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(11,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_domain_page_monthly','z_28acb3ec69ccdab8','a:2:{s:6:\"fields\";a:7:{s:40:\"data_summary_zone_domain_page_monthly_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:9:\"yearmonth\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:9:\"mediumint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:1:\"0\";s:4:\"type\";s:17:\"openads_mediumint\";s:8:\"mdb2type\";s:17:\"openads_mediumint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"domain\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:4:\"page\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:47:\"data_summary_zone_domain_page_monthly_yearmonth\";a:1:{s:6:\"fields\";a:1:{s:9:\"yearmonth\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:45:\"data_summary_zone_domain_page_monthly_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:42:\"data_summary_zone_domain_page_monthly_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:40:\"data_summary_zone_domain_page_monthly_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(12,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_site_keyword_daily','z_35f9fdcf51eac964','a:2:{s:6:\"fields\";a:7:{s:39:\"data_summary_zone_site_keyword_daily_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:3:\"day\";a:5:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:4:\"date\";s:7:\"default\";s:10:\"0000-00-00\";s:4:\"type\";s:12:\"openads_date\";s:8:\"mdb2type\";s:12:\"openads_date\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:4:\"site\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:7:\"keyword\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:40:\"data_summary_zone_site_keyword_daily_day\";a:1:{s:6:\"fields\";a:1:{s:3:\"day\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:44:\"data_summary_zone_site_keyword_daily_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:41:\"data_summary_zone_site_keyword_daily_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:39:\"data_summary_zone_site_keyword_daily_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(13,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_site_keyword_forecast','z_e2483eb008f13e7c','a:2:{s:6:\"fields\";a:6:{s:42:\"data_summary_zone_site_keyword_forecast_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:11:\"day_of_week\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:8:\"smallint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:0:\"\";s:4:\"type\";s:16:\"openads_smallint\";s:8:\"mdb2type\";s:16:\"openads_smallint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:0:\"\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:4:\"site\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:7:\"keyword\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:51:\"data_summary_zone_site_keyword_forecast_day_of_week\";a:1:{s:6:\"fields\";a:1:{s:11:\"day_of_week\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:47:\"data_summary_zone_site_keyword_forecast_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:44:\"data_summary_zone_site_keyword_forecast_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:42:\"data_summary_zone_site_keyword_forecast_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(14,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_site_keyword_monthly','z_8f460958e301fcdc','a:2:{s:6:\"fields\";a:7:{s:41:\"data_summary_zone_site_keyword_monthly_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:9:\"yearmonth\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:9:\"mediumint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:1:\"0\";s:4:\"type\";s:17:\"openads_mediumint\";s:8:\"mdb2type\";s:17:\"openads_mediumint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:4:\"site\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:7:\"keyword\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:48:\"data_summary_zone_site_keyword_monthly_yearmonth\";a:1:{s:6:\"fields\";a:1:{s:9:\"yearmonth\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:46:\"data_summary_zone_site_keyword_monthly_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:43:\"data_summary_zone_site_keyword_monthly_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:41:\"data_summary_zone_site_keyword_monthly_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(15,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_source_daily','z_f7f09afd22821fd8','a:2:{s:6:\"fields\";a:6:{s:33:\"data_summary_zone_source_daily_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:3:\"day\";a:5:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:4:\"date\";s:7:\"default\";s:10:\"0000-00-00\";s:4:\"type\";s:12:\"openads_date\";s:8:\"mdb2type\";s:12:\"openads_date\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"source\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:34:\"data_summary_zone_source_daily_day\";a:1:{s:6:\"fields\";a:1:{s:3:\"day\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:38:\"data_summary_zone_source_daily_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:35:\"data_summary_zone_source_daily_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:33:\"data_summary_zone_source_daily_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(16,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_source_forecast','z_96c74a4850beb288','a:2:{s:6:\"fields\";a:5:{s:36:\"data_summary_zone_source_forecast_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:11:\"day_of_week\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:8:\"smallint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:0:\"\";s:4:\"type\";s:16:\"openads_smallint\";s:8:\"mdb2type\";s:16:\"openads_smallint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:0:\"\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"source\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:45:\"data_summary_zone_source_forecast_day_of_week\";a:1:{s:6:\"fields\";a:1:{s:11:\"day_of_week\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:41:\"data_summary_zone_source_forecast_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:38:\"data_summary_zone_source_forecast_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:36:\"data_summary_zone_source_forecast_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(17,1,'tables_core',516,1,30,'copied table','cleaned by user','data_summary_zone_source_monthly','z_b1e06bdbc4c119e1','a:2:{s:6:\"fields\";a:6:{s:35:\"data_summary_zone_source_monthly_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:6:\"bigint\";s:6:\"length\";s:2:\"20\";s:7:\"default\";i:0;s:13:\"autoincrement\";b:1;s:4:\"type\";s:14:\"openads_bigint\";s:8:\"mdb2type\";s:14:\"openads_bigint\";}s:9:\"yearmonth\";a:6:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:9:\"mediumint\";s:6:\"length\";s:1:\"6\";s:7:\"default\";s:1:\"0\";s:4:\"type\";s:17:\"openads_mediumint\";s:8:\"mdb2type\";s:17:\"openads_mediumint\";}s:7:\"zone_id\";a:7:{s:7:\"notnull\";b:1;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";s:1:\"0\";s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"source\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:7:\"varchar\";s:6:\"length\";s:3:\"255\";s:5:\"fixed\";b:0;s:7:\"default\";N;s:4:\"type\";s:15:\"openads_varchar\";s:8:\"mdb2type\";s:15:\"openads_varchar\";}s:11:\"impressions\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}s:6:\"clicks\";a:7:{s:7:\"notnull\";b:0;s:10:\"nativetype\";s:3:\"int\";s:6:\"length\";s:2:\"10\";s:8:\"unsigned\";b:1;s:7:\"default\";N;s:4:\"type\";s:11:\"openads_int\";s:8:\"mdb2type\";s:11:\"openads_int\";}}s:7:\"indexes\";a:3:{s:42:\"data_summary_zone_source_monthly_yearmonth\";a:1:{s:6:\"fields\";a:1:{s:9:\"yearmonth\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:40:\"data_summary_zone_source_monthly_zone_id\";a:1:{s:6:\"fields\";a:1:{s:7:\"zone_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}s:37:\"data_summary_zone_source_monthly_pkey\";a:2:{s:7:\"primary\";b:1;s:6:\"fields\";a:1:{s:35:\"data_summary_zone_source_monthly_id\";a:2:{s:5:\"order\";i:1;s:7:\"sorting\";s:9:\"ascending\";}}}}}','2007-08-29 14:38:20'),(18,1,'tables_core',516,1,40,'BACKUP COMPLETE',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20'),(19,1,'tables_core',516,1,60,'UPGRADE SUCCEEDED',NULL,NULL,NULL,NULL,'2007-08-29 14:38:20');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_database_action` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_images` DISABLE KEYS */;
LOCK TABLES `oa_images` WRITE;
INSERT INTO `oa_images` VALUES ('468x60.gif','GIF89aù<\0ù\0\0uuuùùùDDDùùùùù?ùù000ùùù   eeeùùùUUUùùùùùù\0\0\0!ù\0\0\0\0\0,\0\0\0\0ù<\0\0ùùùIùù8ù?ù`(ùdiùhùùlùp,ùtmùxùù|ù?ùùcH\nPù\"ù(\nBùùX6ù\rùùJZùPùù$ùQùzùnW\Zùù$0ùùù?$ùùù\0bnuqz\'	BùC	ùùùù.ùs\"	ùxùùùx\0ùùùEù$\0ùùùùùùùAù#\nùùCùùùùùùDù!~ù?ù?ùùùqù\nùw?ù?ùùùùùù6ùùùvùùEùùù>ù#ùC.pù`Sù8t\0QRù5xsùù?(ùùùùAùD\"ù0\\<ùNù?Rùùù$?81leùùd(Sù[4ù\0 @@ùùE2ùùùI(\0ùPùù0ù\0ùs0ù?dùùaùYùùùùù\0ù\"$ù\\	}ù?ùHùù\\hùùùgùùtùù^ù{,;ùù2ùù<ùT	ù5Pù\Zùhk^Sù\04ùù	ùù@6?\'ùùa8ù\0.ù?y-ùùSùFùe+8j7ùùù<ùù?CGùQùw?VùùùJù!ùù\0Kw?Aùn6ùEùùù}Cùù_il \"ù5Hùlùùù\00 \0sùù/ùlùùe!ùùùùuùùùk@ùùtùxùPmXùi@ù@ùùurùùCùùBVùIù!ùùù$ùù [ùBùfP8ùO?\0ùù7ùù-ùi?ù9ùFù0ùyù+ùùùDùùùùeiùnùù\nGùùAahZùùù=ùXù$ùBù3f(qu9bùZùù.ùùùA\Z*jùùù(ùwTp\0Qùùù\"(ùH}YIùCùyùjù9ù*ùù?ùt\0ùBùù,\nr*zùùùùùù\rù\0}ùe@ùùr?\Zùv?zùNùùM@ùWùjpùùùù&?ù^p,rùtù\ZlJ\n~ùùdùT\0ùcù>?ù\0ùb=ùùkqz\nùùùpùù ùqù8ùùùùù?ùù?\Zùù4ùgWP.ùqùùI\0$Oùùùùù;ùlùùùùù5WmùùCHù30Qùzù\\ùùZùùù]?A?mm5ù[ù6ùigùù\"ù4\0cùùùùvùùMlùo[-ù\0ùùl/ùùùù\rK\0$npù(ùù\rKùùù?ù(R]xùXù&ùùù\0g`ùùùùùù2@ùùùnW?ùnùùù!uùùù.j?ù~zUùù.ùù<Qù~ùvùù<ùsùùùùù+ùù9ùùùù?ùO??ùDùùùùù=ùù/[zùùsmTù ùù\Zùùcù+\Zùù\nùlùùùùùùù[[ù&0ùùùl>xù\Z(ùùD@ùù@ùAùù]ùùù-ù$ù!Nù{?Bù	ù?xù\\Lù#ùù~~ùaùù*\Z*ùùùùùùùUùaK]ùJù/ùùùwù ùùC\r\\?ùùWù?Fùù1Yù? e-ùùùs\0ù^F(#ùqtt@%ùxùùZùIùXùù%ùùùùDC2ùù*ùNfùaù4ù\"\'ùù?HùwMù@ùùùùq}ùtùPùùùùCR@6(_(EYùGù?Kù)Xù)b\0ùùùOùùJ8lù.ù4Jù<&ùùùù0?ùI ù3ù\r65ùMù(ù\0fù&5{ùùnùùc+ùùJ xSù)Rù;;Pùùù\"?:ùSù}X@Vùù3#5OùBùùùzùù\r 4ù&\nùUùùt\rtùùYù9ùQ*ùùù-ùyù?\"ù#ùùN:ù	}ùùURAùqùùùùhD%;ùJ`ùE8Lùùjù|n vCù`\ZHù4ùù9@Sùù?zuù^ùù!P8Kùùkù1ù ?%ùùù%ùù.ùxù,ùXù=ùùùùTTùd`ùg?zE.ù#>IHù]%Gùùsù_ùZ5o>ùsùSùZlùRCùùùJ5ù8ùùCcùù6KùM\0ù?lù,ùù ]ù\0ùCj;\0(4\0Bù*ù:?gvùGùEùmsFùZ\n,bùùlGgùùSùùù6ùZùY%?)LNùùùLwùùùMpaQ$dNùzùZRù;?ù Qd=?ù	v@ùùùUù(ùfùùEUQù^ùùù[ùX=pù?ùIùKù\\:?Iù	ùùNùù`ùAXyù8%`Gl-ù}ù-ùUWùù,ùuù-ùNù\0#ùùh]/<ùNtXSUaù,}ùùvù1ùxù?eùPùù\rùùùù.m.oùù,sù[?ùùùdùù	ù[A`ù2(c)ù%%ùf0?|ùù:?g6ù?Nù\nùùùF;\Z\0\0;','2007-05-17 12:01:02');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_images` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_lb_local` DISABLE KEYS */;
LOCK TABLES `oa_lb_local` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_lb_local` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_log_maintenance_forecasting` DISABLE KEYS */;
LOCK TABLES `oa_log_maintenance_forecasting` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_log_maintenance_forecasting` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_log_maintenance_priority` DISABLE KEYS */;
LOCK TABLES `oa_log_maintenance_priority` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_log_maintenance_priority` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_log_maintenance_statistics` DISABLE KEYS */;
LOCK TABLES `oa_log_maintenance_statistics` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_log_maintenance_statistics` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_password_recovery` DISABLE KEYS */;
LOCK TABLES `oa_password_recovery` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_password_recovery` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_placement_zone_assoc` DISABLE KEYS */;
LOCK TABLES `oa_placement_zone_assoc` WRITE;
INSERT INTO `oa_placement_zone_assoc` VALUES (1,1,1),(2,1,2),(3,2,3);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_placement_zone_assoc` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_plugins_channel_delivery_assoc` DISABLE KEYS */;
LOCK TABLES `oa_plugins_channel_delivery_assoc` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_assoc` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_plugins_channel_delivery_domains` DISABLE KEYS */;
LOCK TABLES `oa_plugins_channel_delivery_domains` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_domains` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_plugins_channel_delivery_rules` DISABLE KEYS */;
LOCK TABLES `oa_plugins_channel_delivery_rules` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_plugins_channel_delivery_rules` ENABLE KEYS */;

--
-- Table structure for table `oa_preference`
--

DROP TABLE IF EXISTS `oa_preference`;
CREATE TABLE `oa_preference` (
  `agencyid` mediumint(9) NOT NULL default '0',
  `config_version` decimal(7,3) NOT NULL default '0.000',
  `my_header` varchar(255) default NULL,
  `my_footer` varchar(255) default NULL,
  `my_logo` varchar(255) default NULL,
  `language` varchar(32) default 'english',
  `name` varchar(32) default NULL,
  `company_name` varchar(255) default 'mysite.com',
  `override_gd_imageformat` varchar(4) default NULL,
  `begin_of_week` tinyint(2) default '1',
  `percentage_decimals` tinyint(2) default '2',
  `type_sql_allow` enum('t','f') default 't',
  `type_url_allow` enum('t','f') default 't',
  `type_web_allow` enum('t','f') default 'f',
  `type_html_allow` enum('t','f') default 't',
  `type_txt_allow` enum('t','f') default 't',
  `banner_html_auto` enum('t','f') default 't',
  `admin` varchar(64) default 'phpadsuser',
  `admin_pw` varchar(64) default 'phpadspass',
  `admin_fullname` varchar(255) default 'Your Name',
  `admin_email` varchar(64) default 'your@email.com',
  `warn_admin` enum('t','f') default 't',
  `warn_agency` enum('t','f') default 't',
  `warn_client` enum('t','f') default 't',
  `warn_limit` mediumint(9) NOT NULL default '100',
  `admin_email_headers` varchar(64) default NULL,
  `admin_novice` enum('t','f') default 't',
  `default_banner_weight` tinyint(4) default '1',
  `default_campaign_weight` tinyint(4) default '1',
  `default_banner_url` varchar(255) default NULL,
  `default_banner_destination` varchar(255) default NULL,
  `client_welcome` enum('t','f') default 't',
  `client_welcome_msg` text,
  `publisher_welcome` enum('t','f') default 't',
  `publisher_welcome_msg` text,
  `content_gzip_compression` enum('t','f') default 'f',
  `userlog_email` enum('t','f') default 't',
  `gui_show_campaign_info` enum('t','f') default 't',
  `gui_show_campaign_preview` enum('t','f') default 'f',
  `gui_campaign_anonymous` enum('t','f') default 'f',
  `gui_show_banner_info` enum('t','f') default 't',
  `gui_show_banner_preview` enum('t','f') default 't',
  `gui_show_banner_html` enum('t','f') default 'f',
  `gui_show_matching` enum('t','f') default 't',
  `gui_show_parents` enum('t','f') default 'f',
  `gui_hide_inactive` enum('t','f') default 'f',
  `gui_link_compact_limit` int(11) default '50',
  `gui_header_background_color` varchar(7) default NULL,
  `gui_header_foreground_color` varchar(7) default NULL,
  `gui_header_active_tab_color` varchar(7) default NULL,
  `gui_header_text_color` varchar(7) default NULL,
  `gui_invocation_3rdparty_default` varchar(50) NOT NULL default '',
  `qmail_patch` enum('t','f') default 'f',
  `updates_enabled` enum('t','f') default 't',
  `updates_cache` text,
  `updates_timestamp` int(11) default '0',
  `updates_last_seen` decimal(7,3) default NULL,
  `allow_invocation_plain` enum('t','f') default 'f',
  `allow_invocation_plain_nocookies` enum('t','f') default 't',
  `allow_invocation_js` enum('t','f') default 't',
  `allow_invocation_frame` enum('t','f') default 'f',
  `allow_invocation_xmlrpc` enum('t','f') default 'f',
  `allow_invocation_local` enum('t','f') default 't',
  `allow_invocation_interstitial` enum('t','f') default 't',
  `allow_invocation_popup` enum('t','f') default 't',
  `allow_invocation_clickonly` enum('t','f') default 't',
  `auto_clean_tables` enum('t','f') default 'f',
  `auto_clean_tables_interval` tinyint(2) default '5',
  `auto_clean_userlog` enum('t','f') default 'f',
  `auto_clean_userlog_interval` tinyint(2) default '5',
  `auto_clean_tables_vacuum` enum('t','f') default 't',
  `autotarget_factor` float default '-1',
  `maintenance_timestamp` int(11) default '0',
  `compact_stats` enum('t','f') default 't',
  `statslastday` date NOT NULL default '0000-00-00',
  `statslasthour` tinyint(4) NOT NULL default '0',
  `default_tracker_status` tinyint(4) NOT NULL default '1',
  `default_tracker_type` int(10) unsigned default '1',
  `default_tracker_linkcampaigns` enum('t','f') NOT NULL default 'f',
  `publisher_agreement` enum('t','f') default 'f',
  `publisher_agreement_text` text,
  `publisher_payment_modes` text,
  `publisher_currencies` text,
  `publisher_categories` text,
  `publisher_help_files` text,
  `publisher_default_tax_id` enum('t','f') default 'f',
  `publisher_default_approved` enum('t','f') default 'f',
  `more_reports` varchar(1) default NULL,
  `gui_column_id` text,
  `gui_column_requests` text,
  `gui_column_impressions` text,
  `gui_column_clicks` text,
  `gui_column_ctr` text,
  `gui_column_conversions` text,
  `gui_column_conversions_pending` text,
  `gui_column_sr_views` text,
  `gui_column_sr_clicks` text,
  `gui_column_revenue` text,
  `gui_column_cost` text,
  `gui_column_bv` text,
  `gui_column_num_items` text,
  `gui_column_revcpc` text,
  `gui_column_costcpc` text,
  `gui_column_technology_cost` text,
  `gui_column_income` text,
  `gui_column_income_margin` text,
  `gui_column_profit` text,
  `gui_column_margin` text,
  `gui_column_erpm` text,
  `gui_column_erpc` text,
  `gui_column_erps` text,
  `gui_column_eipm` text,
  `gui_column_eipc` text,
  `gui_column_eips` text,
  `gui_column_ecpm` text,
  `gui_column_ecpc` text,
  `gui_column_ecps` text,
  `gui_column_epps` text,
  `instance_id` varchar(64) default NULL,
  `maintenance_cron_timestamp` int(11) default NULL,
  `warn_limit_days` smallint(6) NOT NULL default '1',
  PRIMARY KEY  (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_preference`
--


/*!40000 ALTER TABLE `oa_preference` DISABLE KEYS */;
LOCK TABLES `oa_preference` WRITE;
INSERT INTO `oa_preference` VALUES (0,'0.000',NULL,NULL,NULL,'english',NULL,'www.openads.org',NULL,0,2,'t','t','f','t','t','t','admin','5f4dcc3b5aa765d61d8327deb882cf99','Andrew Hill','andrew.hill@openads.org','t','t','t',100,NULL,'t',1,1,NULL,NULL,'t',NULL,'t',NULL,'f','t','t','t','t','t','t','t','t','t','t',50,NULL,NULL,NULL,NULL,'0','f','t','b:0;',1188468357,'0.000','f','t','t','f','f','t','t','t','t','f',5,'f',5,'t',-1,1180706838,'t','0000-00-00',0,1,1,'f','f',NULL,'','','','','t','t',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1),(1,'0.000',NULL,NULL,NULL,'','Test Agency','www.openads.org',NULL,0,2,'t','t','f','t','t','t','admin','5f4dcc3b5aa765d61d8327deb882cf99','Andrew Hill','andrew.hill@openads.org','t','t','t',100,NULL,'t',1,1,NULL,NULL,'t',NULL,'t',NULL,'f','t','t','t','t','t','t','t','t','t','t',50,NULL,NULL,NULL,NULL,'0','f','t',NULL,0,NULL,'f','t','t','f','f','t','t','t','t','f',5,'f',5,'t',-1,1180706838,'t','0000-00-00',0,1,1,'f','f',NULL,'','','','','t','t',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1179299106,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_preference` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_preference_advertiser` DISABLE KEYS */;
LOCK TABLES `oa_preference_advertiser` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_preference_advertiser` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_preference_publisher` DISABLE KEYS */;
LOCK TABLES `oa_preference_publisher` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_preference_publisher` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_session` DISABLE KEYS */;
LOCK TABLES `oa_session` WRITE;
INSERT INTO `oa_session` VALUES ('phpads465c3580ef7ff1.90755088','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:8:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:7:\"GLOBALS\";a:3:{s:13:\"period_preset\";s:5:\"today\";s:12:\"period_start\";s:10:\"2007-06-01\";s:10:\"period_end\";s:10:\"2007-06-01\";}s:9:\"stats.php\";a:5:{s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";s:10:\"startlevel\";i:0;s:5:\"nodes\";s:0:\"\";s:12:\"hideinactive\";b:1;}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}s:24:\"advertiser-campaigns.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-campaigns.php\";a:3:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-variables.php\";a:1:{s:9:\"trackerid\";s:1:\"1\";}}s:12:\"update_check\";b:0;}','2007-06-01 15:09:52'),('phpads465d96668fc721.60249221','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:3:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:24:\"advertiser-campaigns.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}}s:12:\"update_check\";b:0;}','2007-06-01 17:15:27'),('phpads4666d2619a15a3.52419402','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}s:12:\"update_check\";b:0;}','2007-06-06 16:27:35'),('phpads468a364daaa084.23126755','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:2:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:12:\"update_check\";b:0;}','2007-07-03 14:48:40'),('phpads46d44deed3dd40.69179106','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"admin\";s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:1;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}s:15:\"maint_update_js\";b:1;}','2007-08-30 11:06:32');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_session` ENABLE KEYS */;

--
-- Table structure for table `oa_targetstats`
--

DROP TABLE IF EXISTS `oa_targetstats`;
CREATE TABLE `oa_targetstats` (
  `day` date NOT NULL default '0000-00-00',
  `campaignid` mediumint(9) NOT NULL default '0',
  `target` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `modified` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`day`,`campaignid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_targetstats`
--


/*!40000 ALTER TABLE `oa_targetstats` DISABLE KEYS */;
LOCK TABLES `oa_targetstats` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_targetstats` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_tracker_append` DISABLE KEYS */;
LOCK TABLES `oa_tracker_append` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_tracker_append` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_trackers` DISABLE KEYS */;
LOCK TABLES `oa_trackers` WRITE;
INSERT INTO `oa_trackers` VALUES (1,'Sample Tracker','',1,3,3,0,4,1,'f','js','','2007-06-01 15:09:47');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_trackers` ENABLE KEYS */;

--
-- Table structure for table `oa_upgrade_action`
--

DROP TABLE IF EXISTS `oa_upgrade_action`;
CREATE TABLE `oa_upgrade_action` (
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
  KEY `upgrade_action_updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_upgrade_action`
--


/*!40000 ALTER TABLE `oa_upgrade_action` DISABLE KEYS */;
LOCK TABLES `oa_upgrade_action` WRITE;
INSERT INTO `oa_upgrade_action` VALUES (1,'openads_upgrade_2.5.1.xml','2.5.1','2.3.39-beta',1,'UPGRADE COMPLETE','cleaned by user','file not found','2007-08-29 14:38:20'),(2,'openads_version_stamp_2.5.1-dev','2.5.1-dev','2.5.1',1,'UPGRADE COMPLETE','cleaned by user','cleaned by user','2007-08-29 14:38:21');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_upgrade_action` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_userlog` DISABLE KEYS */;
LOCK TABLES `oa_userlog` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_userlog` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_variable_publisher` DISABLE KEYS */;
LOCK TABLES `oa_variable_publisher` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_variable_publisher` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `oa_variables` DISABLE KEYS */;
LOCK TABLES `oa_variables` WRITE;
INSERT INTO `oa_variables` VALUES (1,1,'boo','Sample number','numeric',NULL,0,0,0,'var boo = \\\'%%BOO_VALUE%%\\\'','f','2007-06-01 15:09:47'),(2,1,'foo','Sample string','string',NULL,0,0,0,'var foo = \\\'%%FOO_VALUE%%\\\'','f','2007-06-01 15:09:47');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_variables` ENABLE KEYS */;

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
  `chain` longblob NOT NULL,
  `prepend` longblob NOT NULL,
  `append` longblob NOT NULL,
  `appendtype` tinyint(4) NOT NULL default '0',
  `forceappend` enum('t','f') default 'f',
  `inventory_forecast_type` smallint(6) NOT NULL default '0',
  `comments` text,
  `cost` decimal(10,4) default NULL,
  `cost_type` smallint(6) default NULL,
  `cost_variable_id` varchar(255) NOT NULL default '',
  `technology_cost` decimal(10,4) default NULL,
  `technology_cost_type` smallint(6) default NULL,
  `updated` datetime default NULL,
  `block` int(11) NOT NULL default '0',
  `capping` int(11) NOT NULL default '0',
  `session_capping` int(11) NOT NULL default '0',
  `what` longblob NOT NULL,
  PRIMARY KEY  (`zoneid`),
  KEY `zonenameid` (`zonename`,`zoneid`),
  KEY `affiliateid` (`affiliateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oa_zones`
--


/*!40000 ALTER TABLE `oa_zones` DISABLE KEYS */;
LOCK TABLES `oa_zones` WRITE;
INSERT INTO `oa_zones` VALUES (1,1,'Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,'',NULL,NULL,'2007-04-27 15:37:19',0,0,0,''),(2,2,'Agency Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,'',NULL,NULL,'2007-05-15 13:41:44',0,0,0,'');
UNLOCK TABLES;
/*!40000 ALTER TABLE `oa_zones` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

