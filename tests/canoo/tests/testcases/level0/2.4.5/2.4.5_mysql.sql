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
-- Create schema openx245mysqlcanooto26x
--

-- CREATE DATABASE IF NOT EXISTS openx245mysqlcanooto26x;
-- USE openx245mysqlcanooto26x;
CREATE TABLE `ox_acls` (
  `bannerid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `bannerid_executionorder` (`bannerid`,`executionorder`),
  KEY `bannerid` (`bannerid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_acls_channel` (
  `channelid` mediumint(9) NOT NULL default '0',
  `logical` varchar(3) NOT NULL default 'and',
  `type` varchar(32) NOT NULL default '',
  `comparison` char(2) NOT NULL default '==',
  `data` text NOT NULL,
  `executionorder` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `channelid_executionorder` (`channelid`,`executionorder`),
  KEY `channelid` (`channelid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_ad_category_assoc` (
  `ad_category_assoc_id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ad_category_assoc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_ad_zone_assoc` (
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
INSERT INTO `ox_ad_zone_assoc` (`ad_zone_assoc_id`,`zone_id`,`ad_id`,`priority`,`link_type`,`priority_factor`,`to_be_delivered`) VALUES 
 (1,0,1,0,0,0,1),
 (2,0,2,0,0,0,1),
 (3,0,3,0,0,0,1),
 (4,2,1,0,1,0,1),
 (5,2,3,0,1,0,1),
 (6,1,1,0,1,0,1),
 (7,1,2,0,1,0,1);
CREATE TABLE `ox_affiliates` (
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
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`affiliateid`),
  KEY `affiliates_agencyid` (`agencyid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `ox_affiliates` (`affiliateid`,`agencyid`,`name`,`mnemonic`,`comments`,`contact`,`email`,`website`,`username`,`password`,`permissions`,`language`,`publiczones`,`last_accepted_agency_agreement`,`updated`) VALUES 
 (1,0,'Agency Publisher 1','Agenc','','Andrew Hill','andrew.hill@openads.org','http://fornax.net',NULL,'',127,NULL,'t',NULL,'2008-08-06 10:01:13');
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_affiliates_extra` (`affiliateid`,`address`,`city`,`postcode`,`country`,`phone`,`fax`,`account_contact`,`payee_name`,`tax_id`,`mode_of_payment`,`currency`,`unique_users`,`unique_views`,`page_rank`,`category`,`help_file`) VALUES 
 (1,'','','','','','','','','','Cheque by post','GBP',0,0,0,NULL,NULL);
CREATE TABLE `ox_agency` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_application_variable` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_application_variable` (`name`,`value`) VALUES 
 ('tables_core','515'),
 ('oa_version','2.4.5');
CREATE TABLE `ox_banners` (
  `bannerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `active` enum('t','f') NOT NULL default 't',
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
  `status` varchar(255) NOT NULL default '',
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
  PRIMARY KEY  (`bannerid`),
  KEY `banners_campaignid` (`campaignid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO `ox_banners` (`bannerid`,`campaignid`,`active`,`contenttype`,`pluginversion`,`storagetype`,`filename`,`imageurl`,`htmltemplate`,`htmlcache`,`width`,`height`,`weight`,`seq`,`target`,`url`,`alt`,`status`,`bannertext`,`description`,`autohtml`,`adserver`,`block`,`capping`,`session_capping`,`compiledlimitation`,`acl_plugins`,`append`,`appendtype`,`bannertype`,`alt_filename`,`alt_imageurl`,`alt_contenttype`,`comments`,`updated`,`acls_updated`,`keyword`,`transparent`,`parameters`) VALUES 
 (1,1,'t','',0,'html','','','Test HTML Banner!','Test HTML Banner!',468,60,1,0,'','','','','','Test HTML Banner!','t','',0,0,0,'',NULL,'',0,0,'','','','','2008-08-06 09:54:55','0000-00-00 00:00:00','',0,'N;'),
 (2,2,'t','',0,'html','','','html test banner','<a href=\"{clickurl}\" target=\"{target}\">html test banner</a>',468,60,1,0,'','https://developer.openx.org/','','','','test banner','t','max',0,0,0,'',NULL,'',0,0,'','','','','2008-08-06 09:56:32','0000-00-00 00:00:00','',0,'N;'),
 (3,3,'t','gif',0,'sql','468x60.gif','','','',468,60,1,0,'','https://developer.openx.org/','alt text','','','sample gif banner','f','',0,0,0,'',NULL,'',0,0,'','','','','2008-08-06 09:57:57','0000-00-00 00:00:00','',0,'N;');
CREATE TABLE `ox_campaigns` (
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
INSERT INTO `ox_campaigns` (`campaignid`,`campaignname`,`clientid`,`views`,`clicks`,`conversions`,`expire`,`activate`,`active`,`priority`,`weight`,`target_impression`,`target_click`,`target_conversion`,`anonymous`,`companion`,`comments`,`revenue`,`revenue_type`,`updated`,`block`,`capping`,`session_capping`) VALUES 
 (1,'Advertiser 1 - Default Campaign',1,-1,-1,-1,'2008-07-01','0000-00-00','f',0,1,0,0,0,'f',0,'',NULL,NULL,'2008-08-06 09:46:06',0,0,0),
 (2,'test campaign',1,-1,-1,-1,'0000-00-00','0000-00-00','t',0,1,0,0,0,'f',0,'',NULL,NULL,'2008-08-06 09:53:12',0,0,0),
 (3,'campaign 2 (gif)',1,-1,-1,-1,'0000-00-00','0000-00-00','t',0,1,0,0,0,'f',0,'',NULL,NULL,'2008-08-06 09:53:49',0,0,0);
CREATE TABLE `ox_campaigns_trackers` (
  `campaign_trackerid` mediumint(9) NOT NULL auto_increment,
  `campaignid` mediumint(9) NOT NULL default '0',
  `trackerid` mediumint(9) NOT NULL default '0',
  `viewwindow` mediumint(9) NOT NULL default '0',
  `clickwindow` mediumint(9) NOT NULL default '0',
  `status` smallint(1) unsigned NOT NULL default '4',
  PRIMARY KEY  (`campaign_trackerid`),
  KEY `campaigns_trackers_campaignid` (`campaignid`),
  KEY `campaigns_trackers_trackerid` (`trackerid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `ox_campaigns_trackers` (`campaign_trackerid`,`campaignid`,`trackerid`,`viewwindow`,`clickwindow`,`status`) VALUES 
 (1,3,1,3,3,1);
CREATE TABLE `ox_category` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_clients` (
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
  `updated` datetime NOT NULL,
  `lb_reporting` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`clientid`),
  KEY `clients_agencyid` (`agencyid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `ox_clients` (`clientid`,`agencyid`,`clientname`,`contact`,`email`,`clientusername`,`clientpassword`,`permissions`,`language`,`report`,`reportinterval`,`reportlastdate`,`reportdeactivate`,`comments`,`updated`,`lb_reporting`) VALUES 
 (1,0,'Advertiser 1','advertiser','example@example.com','','',187,'','f',7,'2008-08-06','t','','2008-08-06 09:45:16',0);
CREATE TABLE `ox_data_intermediate_ad` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `data_intermediate_ad_connection_tracker_date_time` (`tracker_date_time`),
  KEY `data_intermediate_ad_connection_tracker_id` (`tracker_id`),
  KEY `data_intermediate_ad_connection_ad_id` (`ad_id`),
  KEY `data_intermediate_ad_connection_zone_id` (`zone_id`),
  KEY `data_intermediate_ad_connection_viewer_id` (`viewer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_intermediate_ad_variable_value` (
  `data_intermediate_ad_variable_value_id` bigint(20) NOT NULL auto_increment,
  `data_intermediate_ad_connection_id` bigint(20) NOT NULL,
  `tracker_variable_id` int(11) NOT NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`data_intermediate_ad_variable_value_id`),
  KEY `data_intermediate_ad_connection_id` (`data_intermediate_ad_connection_id`),
  KEY `data_intermediate_ad_variable_value_tracker_variable_id` (`tracker_variable_id`),
  KEY `data_intermediate_ad_variable_value_tracker_value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `data_raw_ad_click_viewer_id` (`viewer_id`),
  KEY `data_raw_ad_click_date_time` (`date_time`),
  KEY `data_raw_ad_click_ad_id` (`ad_id`),
  KEY `data_raw_ad_click_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `data_raw_ad_impression_viewer_id` (`viewer_id`),
  KEY `data_raw_ad_impression_date_time` (`date_time`),
  KEY `data_raw_ad_impression_ad_id` (`ad_id`),
  KEY `data_raw_ad_impression_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_raw_tracker_click` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `data_raw_tracker_impression_viewer_id` (`viewer_id`),
  KEY `data_raw_tracker_impression_date_time` (`date_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_raw_tracker_variable_value` (
  `server_raw_tracker_impression_id` bigint(20) NOT NULL,
  `server_raw_ip` varchar(16) NOT NULL default '',
  `tracker_variable_id` int(11) NOT NULL,
  `date_time` datetime default NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`server_raw_tracker_impression_id`,`server_raw_ip`,`tracker_variable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_ad_hourly` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `data_summary_ad_zone_assoc_interval_start` (`interval_start`),
  KEY `data_summary_ad_zone_assoc_interval_end` (`interval_end`),
  KEY `data_summary_ad_zone_assoc_ad_id` (`ad_id`),
  KEY `data_summary_ad_zone_assoc_zone_id` (`zone_id`),
  KEY `expired` (`expired`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_channel_daily` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_country_daily` (
  `data_summary_zone_country_daily_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL default '0000-00-00',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `country` char(2) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_country_daily_id`),
  KEY `data_summary_zone_country_daily_day` (`day`),
  KEY `data_summary_zone_country_daily_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_country_forecast` (
  `data_summary_zone_country_forecast_id` bigint(20) NOT NULL auto_increment,
  `day_of_week` smallint(6) NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `country` varchar(2) default NULL,
  `impressions` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_country_forecast_id`),
  KEY `data_summary_zone_country_forecast_day_of_week` (`day_of_week`),
  KEY `data_summary_zone_country_forecast_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_country_monthly` (
  `data_summary_zone_country_monthly_id` bigint(20) NOT NULL auto_increment,
  `yearmonth` mediumint(6) NOT NULL default '0',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `country` char(2) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_country_monthly_id`),
  KEY `data_summary_zone_country_monthly_yearmonth` (`yearmonth`),
  KEY `data_summary_zone_country_monthly_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_domain_page_daily` (
  `data_summary_zone_domain_page_daily_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL default '0000-00-00',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_domain_page_daily_id`),
  KEY `data_summary_zone_domain_page_daily_day` (`day`),
  KEY `data_summary_zone_domain_page_daily_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_domain_page_forecast` (
  `data_summary_zone_domain_page_forecast_id` bigint(20) NOT NULL auto_increment,
  `day_of_week` smallint(6) NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_domain_page_forecast_id`),
  KEY `data_summary_zone_domain_page_forecast_day_of_week` (`day_of_week`),
  KEY `data_summary_zone_domain_page_forecast_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_domain_page_monthly` (
  `data_summary_zone_domain_page_monthly_id` bigint(20) NOT NULL auto_increment,
  `yearmonth` mediumint(6) NOT NULL default '0',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `domain` varchar(255) default NULL,
  `page` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_domain_page_monthly_id`),
  KEY `data_summary_zone_domain_page_monthly_yearmonth` (`yearmonth`),
  KEY `data_summary_zone_domain_page_monthly_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_impression_history` (
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
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (1,60,82,'2008-07-30 10:00:00','2008-07-30 10:59:59',0,10,NULL),
 (2,60,83,'2008-07-30 11:00:00','2008-07-30 11:59:59',0,10,NULL),
 (3,60,84,'2008-07-30 12:00:00','2008-07-30 12:59:59',0,10,NULL),
 (4,60,85,'2008-07-30 13:00:00','2008-07-30 13:59:59',0,10,NULL),
 (5,60,86,'2008-07-30 14:00:00','2008-07-30 14:59:59',0,10,NULL),
 (6,60,87,'2008-07-30 15:00:00','2008-07-30 15:59:59',0,10,NULL),
 (7,60,88,'2008-07-30 16:00:00','2008-07-30 16:59:59',0,10,NULL),
 (8,60,89,'2008-07-30 17:00:00','2008-07-30 17:59:59',0,10,NULL),
 (9,60,90,'2008-07-30 18:00:00','2008-07-30 18:59:59',0,10,NULL),
 (10,60,91,'2008-07-30 19:00:00','2008-07-30 19:59:59',0,10,NULL),
 (11,60,92,'2008-07-30 20:00:00','2008-07-30 20:59:59',0,10,NULL),
 (12,60,93,'2008-07-30 21:00:00','2008-07-30 21:59:59',0,10,NULL),
 (13,60,94,'2008-07-30 22:00:00','2008-07-30 22:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (14,60,95,'2008-07-30 23:00:00','2008-07-30 23:59:59',0,10,NULL),
 (15,60,96,'2008-07-31 00:00:00','2008-07-31 00:59:59',0,10,NULL),
 (16,60,97,'2008-07-31 01:00:00','2008-07-31 01:59:59',0,10,NULL),
 (17,60,98,'2008-07-31 02:00:00','2008-07-31 02:59:59',0,10,NULL),
 (18,60,99,'2008-07-31 03:00:00','2008-07-31 03:59:59',0,10,NULL),
 (19,60,100,'2008-07-31 04:00:00','2008-07-31 04:59:59',0,10,NULL),
 (20,60,101,'2008-07-31 05:00:00','2008-07-31 05:59:59',0,10,NULL),
 (21,60,102,'2008-07-31 06:00:00','2008-07-31 06:59:59',0,10,NULL),
 (22,60,103,'2008-07-31 07:00:00','2008-07-31 07:59:59',0,10,NULL),
 (23,60,104,'2008-07-31 08:00:00','2008-07-31 08:59:59',0,10,NULL),
 (24,60,105,'2008-07-31 09:00:00','2008-07-31 09:59:59',0,10,NULL),
 (25,60,106,'2008-07-31 10:00:00','2008-07-31 10:59:59',0,10,NULL),
 (26,60,107,'2008-07-31 11:00:00','2008-07-31 11:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (27,60,108,'2008-07-31 12:00:00','2008-07-31 12:59:59',0,10,NULL),
 (28,60,109,'2008-07-31 13:00:00','2008-07-31 13:59:59',0,10,NULL),
 (29,60,110,'2008-07-31 14:00:00','2008-07-31 14:59:59',0,10,NULL),
 (30,60,111,'2008-07-31 15:00:00','2008-07-31 15:59:59',0,10,NULL),
 (31,60,112,'2008-07-31 16:00:00','2008-07-31 16:59:59',0,10,NULL),
 (32,60,113,'2008-07-31 17:00:00','2008-07-31 17:59:59',0,10,NULL),
 (33,60,114,'2008-07-31 18:00:00','2008-07-31 18:59:59',0,10,NULL),
 (34,60,115,'2008-07-31 19:00:00','2008-07-31 19:59:59',0,10,NULL),
 (35,60,116,'2008-07-31 20:00:00','2008-07-31 20:59:59',0,10,NULL),
 (36,60,117,'2008-07-31 21:00:00','2008-07-31 21:59:59',0,10,NULL),
 (37,60,118,'2008-07-31 22:00:00','2008-07-31 22:59:59',0,10,NULL),
 (38,60,119,'2008-07-31 23:00:00','2008-07-31 23:59:59',0,10,NULL),
 (39,60,120,'2008-08-01 00:00:00','2008-08-01 00:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (40,60,121,'2008-08-01 01:00:00','2008-08-01 01:59:59',0,10,NULL),
 (41,60,122,'2008-08-01 02:00:00','2008-08-01 02:59:59',0,10,NULL),
 (42,60,123,'2008-08-01 03:00:00','2008-08-01 03:59:59',0,10,NULL),
 (43,60,124,'2008-08-01 04:00:00','2008-08-01 04:59:59',0,10,NULL),
 (44,60,125,'2008-08-01 05:00:00','2008-08-01 05:59:59',0,10,NULL),
 (45,60,126,'2008-08-01 06:00:00','2008-08-01 06:59:59',0,10,NULL),
 (46,60,127,'2008-08-01 07:00:00','2008-08-01 07:59:59',0,10,NULL),
 (47,60,128,'2008-08-01 08:00:00','2008-08-01 08:59:59',0,10,NULL),
 (48,60,129,'2008-08-01 09:00:00','2008-08-01 09:59:59',0,10,NULL),
 (49,60,130,'2008-08-01 10:00:00','2008-08-01 10:59:59',0,10,NULL),
 (50,60,131,'2008-08-01 11:00:00','2008-08-01 11:59:59',0,10,NULL),
 (51,60,132,'2008-08-01 12:00:00','2008-08-01 12:59:59',0,10,NULL),
 (52,60,133,'2008-08-01 13:00:00','2008-08-01 13:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (53,60,134,'2008-08-01 14:00:00','2008-08-01 14:59:59',0,10,NULL),
 (54,60,135,'2008-08-01 15:00:00','2008-08-01 15:59:59',0,10,NULL),
 (55,60,136,'2008-08-01 16:00:00','2008-08-01 16:59:59',0,10,NULL),
 (56,60,137,'2008-08-01 17:00:00','2008-08-01 17:59:59',0,10,NULL),
 (57,60,138,'2008-08-01 18:00:00','2008-08-01 18:59:59',0,10,NULL),
 (58,60,139,'2008-08-01 19:00:00','2008-08-01 19:59:59',0,10,NULL),
 (59,60,140,'2008-08-01 20:00:00','2008-08-01 20:59:59',0,10,NULL),
 (60,60,141,'2008-08-01 21:00:00','2008-08-01 21:59:59',0,10,NULL),
 (61,60,142,'2008-08-01 22:00:00','2008-08-01 22:59:59',0,10,NULL),
 (62,60,143,'2008-08-01 23:00:00','2008-08-01 23:59:59',0,10,NULL),
 (63,60,144,'2008-08-02 00:00:00','2008-08-02 00:59:59',0,10,NULL),
 (64,60,145,'2008-08-02 01:00:00','2008-08-02 01:59:59',0,10,NULL),
 (65,60,146,'2008-08-02 02:00:00','2008-08-02 02:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (66,60,147,'2008-08-02 03:00:00','2008-08-02 03:59:59',0,10,NULL),
 (67,60,148,'2008-08-02 04:00:00','2008-08-02 04:59:59',0,10,NULL),
 (68,60,149,'2008-08-02 05:00:00','2008-08-02 05:59:59',0,10,NULL),
 (69,60,150,'2008-08-02 06:00:00','2008-08-02 06:59:59',0,10,NULL),
 (70,60,151,'2008-08-02 07:00:00','2008-08-02 07:59:59',0,10,NULL),
 (71,60,152,'2008-08-02 08:00:00','2008-08-02 08:59:59',0,10,NULL),
 (72,60,153,'2008-08-02 09:00:00','2008-08-02 09:59:59',0,10,NULL),
 (73,60,154,'2008-08-02 10:00:00','2008-08-02 10:59:59',0,10,NULL),
 (74,60,155,'2008-08-02 11:00:00','2008-08-02 11:59:59',0,10,NULL),
 (75,60,156,'2008-08-02 12:00:00','2008-08-02 12:59:59',0,10,NULL),
 (76,60,157,'2008-08-02 13:00:00','2008-08-02 13:59:59',0,10,NULL),
 (77,60,158,'2008-08-02 14:00:00','2008-08-02 14:59:59',0,10,NULL),
 (78,60,159,'2008-08-02 15:00:00','2008-08-02 15:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (79,60,160,'2008-08-02 16:00:00','2008-08-02 16:59:59',0,10,NULL),
 (80,60,161,'2008-08-02 17:00:00','2008-08-02 17:59:59',0,10,NULL),
 (81,60,162,'2008-08-02 18:00:00','2008-08-02 18:59:59',0,10,NULL),
 (82,60,163,'2008-08-02 19:00:00','2008-08-02 19:59:59',0,10,NULL),
 (83,60,164,'2008-08-02 20:00:00','2008-08-02 20:59:59',0,10,NULL),
 (84,60,165,'2008-08-02 21:00:00','2008-08-02 21:59:59',0,10,NULL),
 (85,60,166,'2008-08-02 22:00:00','2008-08-02 22:59:59',0,10,NULL),
 (86,60,167,'2008-08-02 23:00:00','2008-08-02 23:59:59',0,10,NULL),
 (87,60,0,'2008-08-03 00:00:00','2008-08-03 00:59:59',0,10,NULL),
 (88,60,1,'2008-08-03 01:00:00','2008-08-03 01:59:59',0,10,NULL),
 (89,60,2,'2008-08-03 02:00:00','2008-08-03 02:59:59',0,10,NULL),
 (90,60,3,'2008-08-03 03:00:00','2008-08-03 03:59:59',0,10,NULL),
 (91,60,4,'2008-08-03 04:00:00','2008-08-03 04:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (92,60,5,'2008-08-03 05:00:00','2008-08-03 05:59:59',0,10,NULL),
 (93,60,6,'2008-08-03 06:00:00','2008-08-03 06:59:59',0,10,NULL),
 (94,60,7,'2008-08-03 07:00:00','2008-08-03 07:59:59',0,10,NULL),
 (95,60,8,'2008-08-03 08:00:00','2008-08-03 08:59:59',0,10,NULL),
 (96,60,9,'2008-08-03 09:00:00','2008-08-03 09:59:59',0,10,NULL),
 (97,60,10,'2008-08-03 10:00:00','2008-08-03 10:59:59',0,10,NULL),
 (98,60,11,'2008-08-03 11:00:00','2008-08-03 11:59:59',0,10,NULL),
 (99,60,12,'2008-08-03 12:00:00','2008-08-03 12:59:59',0,10,NULL),
 (100,60,13,'2008-08-03 13:00:00','2008-08-03 13:59:59',0,10,NULL),
 (101,60,14,'2008-08-03 14:00:00','2008-08-03 14:59:59',0,10,NULL),
 (102,60,15,'2008-08-03 15:00:00','2008-08-03 15:59:59',0,10,NULL),
 (103,60,16,'2008-08-03 16:00:00','2008-08-03 16:59:59',0,10,NULL),
 (104,60,17,'2008-08-03 17:00:00','2008-08-03 17:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (105,60,18,'2008-08-03 18:00:00','2008-08-03 18:59:59',0,10,NULL),
 (106,60,19,'2008-08-03 19:00:00','2008-08-03 19:59:59',0,10,NULL),
 (107,60,20,'2008-08-03 20:00:00','2008-08-03 20:59:59',0,10,NULL),
 (108,60,21,'2008-08-03 21:00:00','2008-08-03 21:59:59',0,10,NULL),
 (109,60,22,'2008-08-03 22:00:00','2008-08-03 22:59:59',0,10,NULL),
 (110,60,23,'2008-08-03 23:00:00','2008-08-03 23:59:59',0,10,NULL),
 (111,60,24,'2008-08-04 00:00:00','2008-08-04 00:59:59',0,10,NULL),
 (112,60,25,'2008-08-04 01:00:00','2008-08-04 01:59:59',0,10,NULL),
 (113,60,26,'2008-08-04 02:00:00','2008-08-04 02:59:59',0,10,NULL),
 (114,60,27,'2008-08-04 03:00:00','2008-08-04 03:59:59',0,10,NULL),
 (115,60,28,'2008-08-04 04:00:00','2008-08-04 04:59:59',0,10,NULL),
 (116,60,29,'2008-08-04 05:00:00','2008-08-04 05:59:59',0,10,NULL),
 (117,60,30,'2008-08-04 06:00:00','2008-08-04 06:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (118,60,31,'2008-08-04 07:00:00','2008-08-04 07:59:59',0,10,NULL),
 (119,60,32,'2008-08-04 08:00:00','2008-08-04 08:59:59',0,10,NULL),
 (120,60,33,'2008-08-04 09:00:00','2008-08-04 09:59:59',0,10,NULL),
 (121,60,34,'2008-08-04 10:00:00','2008-08-04 10:59:59',0,10,NULL),
 (122,60,35,'2008-08-04 11:00:00','2008-08-04 11:59:59',0,10,NULL),
 (123,60,36,'2008-08-04 12:00:00','2008-08-04 12:59:59',0,10,NULL),
 (124,60,37,'2008-08-04 13:00:00','2008-08-04 13:59:59',0,10,NULL),
 (125,60,38,'2008-08-04 14:00:00','2008-08-04 14:59:59',0,10,NULL),
 (126,60,39,'2008-08-04 15:00:00','2008-08-04 15:59:59',0,10,NULL),
 (127,60,40,'2008-08-04 16:00:00','2008-08-04 16:59:59',0,10,NULL),
 (128,60,41,'2008-08-04 17:00:00','2008-08-04 17:59:59',0,10,NULL),
 (129,60,42,'2008-08-04 18:00:00','2008-08-04 18:59:59',0,10,NULL),
 (130,60,43,'2008-08-04 19:00:00','2008-08-04 19:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (131,60,44,'2008-08-04 20:00:00','2008-08-04 20:59:59',0,10,NULL),
 (132,60,45,'2008-08-04 21:00:00','2008-08-04 21:59:59',0,10,NULL),
 (133,60,46,'2008-08-04 22:00:00','2008-08-04 22:59:59',0,10,NULL),
 (134,60,47,'2008-08-04 23:00:00','2008-08-04 23:59:59',0,10,NULL),
 (135,60,48,'2008-08-05 00:00:00','2008-08-05 00:59:59',0,10,NULL),
 (136,60,49,'2008-08-05 01:00:00','2008-08-05 01:59:59',0,10,NULL),
 (137,60,50,'2008-08-05 02:00:00','2008-08-05 02:59:59',0,10,NULL),
 (138,60,51,'2008-08-05 03:00:00','2008-08-05 03:59:59',0,10,NULL),
 (139,60,52,'2008-08-05 04:00:00','2008-08-05 04:59:59',0,10,NULL),
 (140,60,53,'2008-08-05 05:00:00','2008-08-05 05:59:59',0,10,NULL),
 (141,60,54,'2008-08-05 06:00:00','2008-08-05 06:59:59',0,10,NULL),
 (142,60,55,'2008-08-05 07:00:00','2008-08-05 07:59:59',0,10,NULL),
 (143,60,56,'2008-08-05 08:00:00','2008-08-05 08:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (144,60,57,'2008-08-05 09:00:00','2008-08-05 09:59:59',0,10,NULL),
 (145,60,58,'2008-08-05 10:00:00','2008-08-05 10:59:59',0,10,NULL),
 (146,60,59,'2008-08-05 11:00:00','2008-08-05 11:59:59',0,10,NULL),
 (147,60,60,'2008-08-05 12:00:00','2008-08-05 12:59:59',0,10,NULL),
 (148,60,61,'2008-08-05 13:00:00','2008-08-05 13:59:59',0,10,NULL),
 (149,60,62,'2008-08-05 14:00:00','2008-08-05 14:59:59',0,10,NULL),
 (150,60,63,'2008-08-05 15:00:00','2008-08-05 15:59:59',0,10,NULL),
 (151,60,64,'2008-08-05 16:00:00','2008-08-05 16:59:59',0,10,NULL),
 (152,60,65,'2008-08-05 17:00:00','2008-08-05 17:59:59',0,10,NULL),
 (153,60,66,'2008-08-05 18:00:00','2008-08-05 18:59:59',0,10,NULL),
 (154,60,67,'2008-08-05 19:00:00','2008-08-05 19:59:59',0,10,NULL),
 (155,60,68,'2008-08-05 20:00:00','2008-08-05 20:59:59',0,10,NULL),
 (156,60,69,'2008-08-05 21:00:00','2008-08-05 21:59:59',0,10,NULL);
INSERT INTO `ox_data_summary_zone_impression_history` (`data_summary_zone_impression_history_id`,`operation_interval`,`operation_interval_id`,`interval_start`,`interval_end`,`zone_id`,`forecast_impressions`,`actual_impressions`) VALUES 
 (157,60,70,'2008-08-05 22:00:00','2008-08-05 22:59:59',0,10,NULL),
 (158,60,71,'2008-08-05 23:00:00','2008-08-05 23:59:59',0,10,NULL),
 (159,60,72,'2008-08-06 00:00:00','2008-08-06 00:59:59',0,10,NULL),
 (160,60,73,'2008-08-06 01:00:00','2008-08-06 01:59:59',0,10,NULL),
 (161,60,74,'2008-08-06 02:00:00','2008-08-06 02:59:59',0,10,NULL),
 (162,60,75,'2008-08-06 03:00:00','2008-08-06 03:59:59',0,10,NULL),
 (163,60,76,'2008-08-06 04:00:00','2008-08-06 04:59:59',0,10,NULL),
 (164,60,77,'2008-08-06 05:00:00','2008-08-06 05:59:59',0,10,NULL),
 (165,60,78,'2008-08-06 06:00:00','2008-08-06 06:59:59',0,10,NULL),
 (166,60,79,'2008-08-06 07:00:00','2008-08-06 07:59:59',0,10,NULL),
 (167,60,80,'2008-08-06 08:00:00','2008-08-06 08:59:59',0,10,NULL),
 (168,60,81,'2008-08-06 09:00:00','2008-08-06 09:59:59',0,10,NULL);
CREATE TABLE `ox_data_summary_zone_site_keyword_daily` (
  `data_summary_zone_site_keyword_daily_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL default '0000-00-00',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `site` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_site_keyword_daily_id`),
  KEY `data_summary_zone_site_keyword_daily_day` (`day`),
  KEY `data_summary_zone_site_keyword_daily_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_site_keyword_forecast` (
  `data_summary_zone_site_keyword_forecast_id` bigint(20) NOT NULL auto_increment,
  `day_of_week` smallint(6) NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `site` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_site_keyword_forecast_id`),
  KEY `data_summary_zone_site_keyword_forecast_day_of_week` (`day_of_week`),
  KEY `data_summary_zone_site_keyword_forecast_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_site_keyword_monthly` (
  `data_summary_zone_site_keyword_monthly_id` bigint(20) NOT NULL auto_increment,
  `yearmonth` mediumint(6) NOT NULL default '0',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `site` varchar(255) default NULL,
  `keyword` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_site_keyword_monthly_id`),
  KEY `data_summary_zone_site_keyword_monthly_yearmonth` (`yearmonth`),
  KEY `data_summary_zone_site_keyword_monthly_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_source_daily` (
  `data_summary_zone_source_daily_id` bigint(20) NOT NULL auto_increment,
  `day` date NOT NULL default '0000-00-00',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `source` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_source_daily_id`),
  KEY `data_summary_zone_source_daily_day` (`day`),
  KEY `data_summary_zone_source_daily_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_source_forecast` (
  `data_summary_zone_source_forecast_id` bigint(20) NOT NULL auto_increment,
  `day_of_week` smallint(6) NOT NULL,
  `zone_id` int(10) unsigned NOT NULL,
  `source` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_source_forecast_id`),
  KEY `data_summary_zone_source_forecast_day_of_week` (`day_of_week`),
  KEY `data_summary_zone_source_forecast_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_data_summary_zone_source_monthly` (
  `data_summary_zone_source_monthly_id` bigint(20) NOT NULL auto_increment,
  `yearmonth` mediumint(6) NOT NULL default '0',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `source` varchar(255) default NULL,
  `impressions` int(10) unsigned default NULL,
  `clicks` int(10) unsigned default NULL,
  PRIMARY KEY  (`data_summary_zone_source_monthly_id`),
  KEY `data_summary_zone_source_monthly_yearmonth` (`yearmonth`),
  KEY `data_summary_zone_source_monthly_zone_id` (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `database_action_upgrade_action_id` (`upgrade_action_id`,`database_action_id`),
  KEY `database_action_schema_version_timing_action` (`schema_name`,`version`,`timing`,`action`),
  KEY `database_action_updated` (`updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_images` (
  `filename` varchar(128) NOT NULL default '',
  `contents` longblob NOT NULL,
  `t_stamp` datetime default NULL,
  PRIMARY KEY  (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_images` (`filename`,`contents`,`t_stamp`) VALUES 
 ('468x60.gif',0x474946383961D4013C00F70000000000800000008000808000000080800080008080808080C0C0C0FF000000FF00FFFF000000FFFF00FF00FFFFFFFFFF0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000330000660000990000CC0000FF0033000033330033660033990033CC0033FF0066000066330066660066990066CC0066FF0099000099330099660099990099CC0099FF00CC0000CC3300CC6600CC9900CCCC00CCFF00FF0000FF3300FF6600FF9900FFCC00FFFF3300003300333300663300993300CC3300FF3333003333333333663333993333CC3333FF3366003366333366663366993366CC3366FF3399003399333399663399993399CC3399FF33CC0033CC3333CC6633CC9933CCCC33CCFF33FF0033FF3333FF6633FF9933FFCC33FFFF6600006600336600666600996600CC6600FF6633006633336633666633996633CC6633FF6666006666336666666666996666CC6666FF6699006699336699666699996699CC6699FF66CC0066CC3366CC6666CC9966CCCC66CCFF66FF0066FF3366FF6666FF9966FFCC66FFFF9900009900339900669900999900CC9900FF9933009933339933669933999933CC9933FF9966009966339966669966999966CC9966FF9999009999339999669999999999CC9999FF99CC0099CC3399CC6699CC9999CCCC99CCFF99FF0099FF3399FF6699FF9999FFCC99FFFFCC0000CC0033CC0066CC0099CC00CCCC00FFCC3300CC3333CC3366CC3399CC33CCCC33FFCC6600CC6633CC6666CC6699CC66CCCC66FFCC9900CC9933CC9966CC9999CC99CCCC99FFCCCC00CCCC33CCCC66CCCC99CCCCCCCCCCFFCCFF00CCFF33CCFF66CCFF99CCFFCCCCFFFFFF0000FF0033FF0066FF0099FF00CCFF00FFFF3300FF3333FF3366FF3399FF33CCFF33FFFF6600FF6633FF6666FF6699FF66CCFF66FFFF9900FF9933FF9966FF9999FF99CCFF99FFFFCC00FFCC33FFCC66FFCC99FFCCCCFFCCFFFFFF00FFFF33FFFF66FFFF99FFFFCCFFFFFF21F90401000010002C00000000D4013C000008FF007FE4104870A0C182080F2A4CC870A1C386101F4A8C4871A2C58A182F6ACCC871A3C78E203F8A0C4972A4C992284FAA4CB8B265CA972E63C29C29B326CD9B3673E2DCA95327CF9F3D810A0D4A74A8D1A2488F2A459AB4E9D2A74EA3429D2AB52A55A557AD6ACDCA75ABD7AE60BFB6141BB62CD9B366D3A25D3B53AD5BB670DFCA8D4B176ADDBB73F3E2DDABB7EF43BF80F90A0E4C787054C38513235EACB8F146C790194B8E4CF9EEE4CB953363DECC55B367CEA03F8B5619BAF4E8D3A6534344CD5AB5EBD68E5FCB863DBB765FDAB86DEBCE9D75B76FDEBF83FF044E5CB8F1E2258F2B47BEBC3941E6D09D4B2F3EBD7AF4EBB3B16BB7CE5D73F7EFDBC333BA164F1EBC79BDE7D3975F8F96BD7BF5F0A9C69FFFBE7E51FBF8E9EBA7B9BF7FFEFF230128A07F044654E08103263890820C22D89F830D46189F841442689E851566689D861C62D89C871D86289C882482A89B8925A6F89A8A2CA2589A8B2DC688998C34C2B8988D35E6C8978E3CE248978F3D06D91E90440AF95691481A39A4924C26C95493503A399C945446795495585A1994965C666992975D86F91898648A195299689A39A69A6CA299E69B6D3214279C740A54E79D6C0604003B,'2008-08-06 09:57:57');
CREATE TABLE `ox_lb_local` (
  `last_run` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_log_maintenance_forecasting` (
  `log_maintenance_forecasting_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_forecasting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_log_maintenance_priority` (
  `log_maintenance_priority_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `run_type` tinyint(3) unsigned NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_priority_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
INSERT INTO `ox_log_maintenance_priority` (`log_maintenance_priority_id`,`start_run`,`end_run`,`operation_interval`,`duration`,`run_type`,`updated_to`) VALUES 
 (1,'2008-08-06 09:54:55','2008-08-06 09:54:56',60,1,0,'2008-08-06 09:59:59'),
 (2,'2008-08-06 09:54:56','2008-08-06 09:54:56',60,0,1,NULL),
 (3,'2008-08-06 09:56:32','2008-08-06 09:56:32',60,0,0,'2008-08-06 09:59:59'),
 (4,'2008-08-06 09:56:32','2008-08-06 09:56:32',60,0,1,NULL),
 (5,'2008-08-06 09:57:57','2008-08-06 09:57:58',60,1,0,'2008-08-06 09:59:59'),
 (6,'2008-08-06 09:57:58','2008-08-06 09:57:58',60,0,1,NULL);
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_password_recovery` (
  `user_type` varchar(64) NOT NULL default '',
  `user_id` int(10) NOT NULL,
  `recovery_id` varchar(64) NOT NULL default '',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`user_type`,`user_id`),
  UNIQUE KEY `recovery_id` (`recovery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_placement_zone_assoc` (
  `placement_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `placement_id` mediumint(9) default NULL,
  PRIMARY KEY  (`placement_zone_assoc_id`),
  KEY `placement_zone_assoc_zone_id` (`zone_id`),
  KEY `placement_id` (`placement_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
INSERT INTO `ox_placement_zone_assoc` (`placement_zone_assoc_id`,`zone_id`,`placement_id`) VALUES 
 (1,2,1),
 (2,2,3),
 (3,1,1),
 (4,1,2);
CREATE TABLE `ox_plugins_channel_delivery_assoc` (
  `rule_id` int(10) unsigned NOT NULL default '0',
  `domain_id` int(10) unsigned NOT NULL default '0',
  `rule_order` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`rule_id`,`domain_id`),
  KEY `domain_id` (`domain_id`),
  KEY `rule_id` (`rule_id`),
  KEY `rule_order` (`rule_order`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_plugins_channel_delivery_domains` (
  `domain_id` int(10) unsigned NOT NULL auto_increment,
  `domain_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`domain_id`),
  KEY `domain_name` (`domain_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_plugins_channel_delivery_rules` (
  `rule_id` int(10) unsigned NOT NULL auto_increment,
  `modifier` varchar(100) NOT NULL default '',
  `client` varchar(100) NOT NULL default '',
  `rule` text NOT NULL,
  PRIMARY KEY  (`rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_preference` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_preference` (`agencyid`,`config_version`,`my_header`,`my_footer`,`my_logo`,`language`,`name`,`company_name`,`override_gd_imageformat`,`begin_of_week`,`percentage_decimals`,`type_sql_allow`,`type_url_allow`,`type_web_allow`,`type_html_allow`,`type_txt_allow`,`banner_html_auto`,`admin`,`admin_pw`,`admin_fullname`,`admin_email`,`warn_admin`,`warn_agency`,`warn_client`,`warn_limit`,`admin_email_headers`,`admin_novice`,`default_banner_weight`,`default_campaign_weight`,`default_banner_url`,`default_banner_destination`,`client_welcome`,`client_welcome_msg`,`publisher_welcome`,`publisher_welcome_msg`,`content_gzip_compression`,`userlog_email`,`gui_show_campaign_info`,`gui_show_campaign_preview`,`gui_campaign_anonymous`,`gui_show_banner_info`,`gui_show_banner_preview`,`gui_show_banner_html`,`gui_show_matching`,`gui_show_parents`,`gui_hide_inactive`,`gui_link_compact_limit`,`gui_header_background_color`,`gui_header_foreground_color`,`gui_header_active_tab_color`,`gui_header_text_color`,`gui_invocation_3rdparty_default`,`qmail_patch`,`updates_enabled`,`updates_cache`,`updates_timestamp`,`updates_last_seen`,`allow_invocation_plain`,`allow_invocation_plain_nocookies`,`allow_invocation_js`,`allow_invocation_frame`,`allow_invocation_xmlrpc`,`allow_invocation_local`,`allow_invocation_interstitial`,`allow_invocation_popup`,`allow_invocation_clickonly`,`auto_clean_tables`,`auto_clean_tables_interval`,`auto_clean_userlog`,`auto_clean_userlog_interval`,`auto_clean_tables_vacuum`,`autotarget_factor`,`maintenance_timestamp`,`compact_stats`,`statslastday`,`statslasthour`,`default_tracker_status`,`default_tracker_type`,`default_tracker_linkcampaigns`,`publisher_agreement`,`publisher_agreement_text`,`publisher_payment_modes`,`publisher_currencies`,`publisher_categories`,`publisher_help_files`,`publisher_default_tax_id`,`publisher_default_approved`,`more_reports`,`gui_column_id`,`gui_column_requests`,`gui_column_impressions`,`gui_column_clicks`,`gui_column_ctr`,`gui_column_conversions`,`gui_column_conversions_pending`,`gui_column_sr_views`,`gui_column_sr_clicks`,`gui_column_revenue`,`gui_column_cost`,`gui_column_bv`,`gui_column_num_items`,`gui_column_revcpc`,`gui_column_costcpc`,`gui_column_technology_cost`,`gui_column_income`,`gui_column_income_margin`,`gui_column_profit`,`gui_column_margin`,`gui_column_erpm`,`gui_column_erpc`,`gui_column_erps`,`gui_column_eipm`,`gui_column_eipc`,`gui_column_eips`,`gui_column_ecpm`,`gui_column_ecpc`,`gui_column_ecps`,`gui_column_epps`,`instance_id`,`maintenance_cron_timestamp`,`warn_limit_days`) VALUES 
 (0,'0.000',NULL,NULL,NULL,'english',NULL,'mysite.com',NULL,1,2,'t','t','f','t','t','t','openx','7a89a595cfc6cb85480202a143e37d2e','Your Name','admin@admin.admin','t','t','t',100,NULL,'t',1,1,NULL,NULL,'t',NULL,'t',NULL,'f','t','t','f','f','t','t','f','t','f','f',50,NULL,NULL,NULL,NULL,'','f','t','a:7:{s:12:\"product_name\";s:5:\"OpenX\";s:14:\"config_version\";s:8:\"2408.400\";s:15:\"config_readable\";s:5:\"2.4.8\";s:12:\"security_fix\";i:1;s:11:\"description\";s:766:\"<p>The OpenX team has released a security update to our open source ad server. We strongly encourage all users to upgrade to avoid this issue.</p>\n<p>This release (v2.4.8) resolves a vulnerability in the delivery system. In addition, this release includes 13 bug fixes and enhancements relating to password recovery, tracker invocation tags and geotargeting.</p>\n<p>Find out more in the OpenX 2.4.8 <a href=\"http://www.openx.org/docs/2.4/release-notes/openx-2.4.8?utm_source=openx&utm_medium=alert&utm_campaign=upgrade\" target=\"_blank\"> release notes </a>. </p>\n<p>Note: The <a href=\"http://blog.openx.org/07/openx-26-has-arrived-with-some-exciting-new-features/\" target=\"_blank\">new version of OpenX (v2.6) announced today </a> also resolves this vulnerability.</p>\";s:7:\"url_zip\";s:133:\"http://www.openx.org/support/release-archive/download?filename=openx-2.4.8.zip&utm_source=openx&utm_medium=alert&utm_campaign=upgrade\";s:7:\"url_tgz\";s:136:\"http://www.openx.org/support/release-archive/download?filename=openx-2.4.8.tar.gz&utm_source=openx&utm_medium=alert&utm_campaign=upgrade\";}',1218008590,'2408.400','f','t','t','f','f','t','t','t','t','f',5,'f',5,'t',-1,0,'t','0000-00-00',0,1,1,'f','f',NULL,NULL,NULL,NULL,NULL,'f','f',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a1f59036ba2dbc55fb5ffe02e813064664b8a294',NULL,1);
CREATE TABLE `ox_preference_advertiser` (
  `advertiser_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`advertiser_id`,`preference`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_preference_publisher` (
  `publisher_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`publisher_id`,`preference`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_session` (
  `sessionid` varchar(32) NOT NULL default '',
  `sessiondata` text NOT NULL,
  `lastused` datetime default NULL,
  PRIMARY KEY  (`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `ox_session` (`sessionid`,`sessiondata`,`lastused`) VALUES 
 ('61197518d48de085d30a53bc2f5d2bc3','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"openx\";s:5:\"prefs\";a:1:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:0:{}}}s:15:\"maint_update_js\";b:1;}','2008-08-06 09:43:49'),
 ('f2adf09781512a88e7919fef07fcf667','a:6:{s:8:\"usertype\";i:1;s:8:\"loggedin\";s:1:\"t\";s:8:\"agencyid\";i:0;s:8:\"username\";s:5:\"openx\";s:5:\"prefs\";a:9:{s:20:\"advertiser-index.php\";a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";a:1:{s:7:\"clients\";a:1:{i:1;a:2:{s:6:\"expand\";b:1;s:9:\"campaigns\";a:3:{i:1;a:1:{s:6:\"expand\";b:1;}i:3;a:1:{s:6:\"expand\";b:1;}i:2;a:1:{s:6:\"expand\";b:1;}}}}}}s:17:\"campaign-zone.php\";a:2:{s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";}s:24:\"advertiser-campaigns.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:20:\"campaign-banners.php\";a:1:{i:1;a:4:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:0:\"\";}}s:19:\"affiliate-index.php\";a:3:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";s:5:\"nodes\";s:1:\"1\";}s:23:\"advertiser-trackers.php\";a:2:{s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-campaigns.php\";a:3:{s:12:\"hideinactive\";b:0;s:9:\"listorder\";s:0:\"\";s:14:\"orderdirection\";s:0:\"\";}s:21:\"tracker-variables.php\";a:1:{s:9:\"trackerid\";s:1:\"1\";}s:16:\"zone-include.php\";a:6:{s:12:\"hideinactive\";b:0;s:11:\"showbanners\";b:1;s:13:\"showcampaigns\";b:0;s:9:\"listorder\";s:4:\"name\";s:14:\"orderdirection\";s:2:\"up\";s:4:\"view\";s:9:\"placement\";}}s:15:\"maint_update_js\";b:1;}','2008-08-06 11:11:15');
CREATE TABLE `ox_targetstats` (
  `day` date NOT NULL default '0000-00-00',
  `campaignid` mediumint(9) NOT NULL default '0',
  `target` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `modified` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_tracker_append` (
  `tracker_append_id` int(11) NOT NULL auto_increment,
  `tracker_id` mediumint(9) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `tagcode` text NOT NULL,
  `paused` enum('t','f') NOT NULL default 'f',
  `autotrack` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`tracker_append_id`),
  KEY `tracker_id` (`tracker_id`,`rank`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `trackers_clientid` (`clientid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `ox_trackers` (`trackerid`,`trackername`,`description`,`clientid`,`viewwindow`,`clickwindow`,`blockwindow`,`status`,`type`,`linkcampaigns`,`variablemethod`,`appendcode`,`updated`) VALUES 
 (1,'Sample Tracker','',1,0,0,0,1,1,'f','js','','2008-08-06 11:09:14');
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
  KEY `upgrade_action_updated` (`updated`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `ox_upgrade_action` (`upgrade_action_id`,`upgrade_name`,`version_to`,`version_from`,`action`,`description`,`logfile`,`confbackup`,`updated`) VALUES 
 (1,'install_2.4.5','2.4.5','0',1,'UPGRADE COMPLETE','install.log',NULL,'2008-08-06 09:42:39');
CREATE TABLE `ox_userlog` (
  `userlogid` mediumint(9) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL default '0',
  `usertype` tinyint(4) NOT NULL default '0',
  `userid` mediumint(9) NOT NULL default '0',
  `action` mediumint(9) NOT NULL default '0',
  `object` mediumint(9) default NULL,
  `details` mediumtext,
  PRIMARY KEY  (`userlogid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `ox_variable_publisher` (
  `variable_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`variable_id`,`publisher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  KEY `variables_is_unique` (`is_unique`),
  KEY `variables_trackerid` (`trackerid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `ox_variables` (`variableid`,`trackerid`,`name`,`description`,`datatype`,`purpose`,`reject_if_empty`,`is_unique`,`unique_window`,`variablecode`,`hidden`,`updated`) VALUES 
 (1,1,'boo','Sample number','numeric',NULL,0,0,0,'var boo = \\\'%%BOO_VALUE%%\\\'','f','2008-08-06 11:09:14'),
 (2,1,'foo','Sample string','string',NULL,0,0,0,'var foo = \\\'%%FOO_VALUE%%\\\'','f','2008-08-06 11:09:14');
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
  PRIMARY KEY  (`zoneid`),
  KEY `zonenameid` (`zonename`,`zoneid`),
  KEY `affiliateid` (`affiliateid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `ox_zones` (`zoneid`,`affiliateid`,`zonename`,`description`,`delivery`,`zonetype`,`category`,`width`,`height`,`ad_selection`,`chain`,`prepend`,`append`,`appendtype`,`forceappend`,`inventory_forecast_type`,`comments`,`cost`,`cost_type`,`cost_variable_id`,`technology_cost`,`technology_cost_type`,`updated`,`block`,`capping`,`session_capping`,`what`) VALUES 
 (1,1,'Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,NULL,NULL,NULL,'2008-08-06 10:18:18',0,0,0,''),
 (2,1,'Agency Publisher 1 - Default','',0,3,'',468,60,'','','','',0,'f',0,'',NULL,NULL,NULL,NULL,NULL,'2008-08-06 10:19:47',0,0,0,'');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
