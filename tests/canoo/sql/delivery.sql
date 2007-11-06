-- phpMyAdmin SQL Dump
-- version 2.8.0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 05, 2007 at 02:54 PM
-- Server version: 5.0.22
-- PHP Version: 4.4.7
-- 
-- Database: `oap_canoo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_acls`
-- 

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

INSERT INTO `oa_acls` (`bannerid`, `logical`, `type`, `comparison`, `data`, `executionorder`) VALUES (1, 'and', 'Site:Channel', '=~', '7', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_acls_channel`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_ad_category_assoc`
-- 

CREATE TABLE `oa_ad_category_assoc` (
  `ad_category_assoc_id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL,
  `ad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ad_category_assoc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_ad_category_assoc`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_ad_zone_assoc`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `oa_ad_zone_assoc`
-- 

INSERT INTO `oa_ad_zone_assoc` (`ad_zone_assoc_id`, `zone_id`, `ad_id`, `priority`, `link_type`, `priority_factor`, `to_be_delivered`) VALUES (1, 0, 1, 1, 0, 1670960, 1),
(2, 1, 1, 0.9, 1, 100, 1),
(3, 0, 2, 0, 0, 1, 1),
(4, 1, 2, 0, 1, 1, 1),
(5, 2, 1, 0.9, 1, 100, 1),
(6, 0, 3, 0, 0, 0, 1),
(7, 1, 3, 0, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_affiliates`
-- 

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
  `oac_website_id` int(11) default NULL,
  `oac_country_code` char(2) NOT NULL default '',
  `oac_language_id` int(11) default NULL,
  `oac_category_id` int(11) default NULL,
  PRIMARY KEY  (`affiliateid`),
  KEY `affiliates_agencyid` (`agencyid`),
  KEY `oa_affiliates_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `oa_affiliates`
-- 

INSERT INTO `oa_affiliates` (`affiliateid`, `agencyid`, `name`, `mnemonic`, `comments`, `contact`, `email`, `website`, `username`, `password`, `permissions`, `language`, `publiczones`, `last_accepted_agency_agreement`, `updated`, `oac_website_id`, `oac_country_code`, `oac_language_id`, `oac_category_id`) VALUES (1, 0, 'Publisher 1', '', '', 'Andrew Hill', 'andrew.hill@openads.org', 'http://www.fornax.net/blog/', 'publisher', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '', 'f', NULL, '2007-05-15 13:29:57', NULL, '', NULL, NULL),
(2, 1, 'Agency Publisher 1', '', '', 'Andrew Hill', 'andrew.hill@openads.org', 'http://fornax.net', NULL, '', 0, NULL, 'f', NULL, '2007-05-15 13:41:40', NULL, '', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_affiliates_extra`
-- 

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

INSERT INTO `oa_affiliates_extra` (`affiliateid`, `address`, `city`, `postcode`, `country`, `phone`, `fax`, `account_contact`, `payee_name`, `tax_id`, `mode_of_payment`, `currency`, `unique_users`, `unique_views`, `page_rank`, `category`, `help_file`) VALUES (1, '', '', '', '', '', '', '', '', '', 'Cheque by post', 'GBP', 0, 0, 0, '', ''),
(2, '', '', '', '', '', '', '', '', '', 'Cheque by post', 'GBP', 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_agency`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `oa_agency`
-- 

INSERT INTO `oa_agency` (`agencyid`, `name`, `contact`, `email`, `username`, `password`, `permissions`, `language`, `logout_url`, `active`, `updated`) VALUES (1, 'Test Agency', 'Andrew Hill', 'andrew.hill@openads.org', 'agency', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '', '', 0, '2007-05-15 12:54:16');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_application_variable`
-- 

CREATE TABLE `oa_application_variable` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_application_variable`
-- 

INSERT INTO `oa_application_variable` (`name`, `value`) VALUES ('oa_version', '2.5.1-dev'),
('platform_hash', '39adcaa8840247618ff928521ba95397770c5b67'),
('tables_core', '516');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_banners`
-- 

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
  `oac_banner_id` int(11) default NULL,
  PRIMARY KEY  (`bannerid`),
  KEY `banners_campaignid` (`campaignid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `oa_banners`
-- 

INSERT INTO `oa_banners` (`bannerid`, `campaignid`, `active`, `contenttype`, `pluginversion`, `storagetype`, `filename`, `imageurl`, `htmltemplate`, `htmlcache`, `width`, `height`, `weight`, `seq`, `target`, `url`, `alt`, `status`, `bannertext`, `description`, `autohtml`, `adserver`, `block`, `capping`, `session_capping`, `compiledlimitation`, `acl_plugins`, `append`, `appendtype`, `bannertype`, `alt_filename`, `alt_imageurl`, `alt_contenttype`, `comments`, `updated`, `acls_updated`, `keyword`, `transparent`, `parameters`, `oac_banner_id`) VALUES (1, 1, 't', 'html', 0, 'html', '', '', 0x546573742048544d4c2042616e6e657221, 0x546573742048544d4c2042616e6e657221, 468, 60, 1, 0, '', '', '', '', '', '', 't', '', 0, 0, 0, 0x284d41585f636865636b536974655f4368616e6e656c282737272c20273d7e272929, 'Site:Channel', '', 0, 0, '', '', 'gif', '', '2007-08-29 14:38:32', '2007-05-15 15:01:43', '', 0, 'N;', NULL),
(2, 2, 't', 'html', 0, 'html', '', '', 0x68746d6c20746573742062616e6e6572, 0x3c6120687265663d227b636c69636b75726c7d22207461726765743d227b7461726765747d223e68746d6c20746573742062616e6e65723c2f613e, 468, 60, 1, 0, '', 'http://www.example.com', '', '', '', 'test banner', 't', '', 0, 0, 0, '', '', '', 0, 0, '', '', 'gif', '', '2007-08-29 14:38:32', '0000-00-00 00:00:00', '', 0, 'N;', NULL),
(3, 3, 't', 'gif', 0, 'sql', '468x60.gif', '', '', '', 468, 60, 1, 0, '', 'http://www.example.com', 'alt text', '', '', 'sample gif banner', 'f', '', 0, 0, 0, '', '', '', 0, 0, '', '', 'gif', '', '2007-08-29 14:38:32', '0000-00-00 00:00:00', '', 0, 'N;', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_campaigns`
-- 

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
  `oac_campaign_id` int(11) default NULL,
  PRIMARY KEY  (`campaignid`),
  KEY `campaigns_clientid` (`clientid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `oa_campaigns`
-- 

INSERT INTO `oa_campaigns` (`campaignid`, `campaignname`, `clientid`, `views`, `clicks`, `conversions`, `expire`, `activate`, `active`, `priority`, `weight`, `target_impression`, `target_click`, `target_conversion`, `anonymous`, `companion`, `comments`, `revenue`, `revenue_type`, `updated`, `block`, `capping`, `session_capping`, `oac_campaign_id`) VALUES (1, 'Advertiser 1 - Default Campaign', 1, 100000000, -1, -1, '2007-07-01', '0000-00-00', 't', 10, 0, 0, 0, 0, 'f', 0, '', NULL, NULL, '2007-05-15 09:54:06', 0, 0, 0, NULL),
(2, 'test campaign', 1, -1, -1, -1, '0000-00-00', '0000-00-00', 't', -1, 1, 0, 0, 0, 't', 0, '', NULL, NULL, '2007-05-16 12:55:24', 0, 0, 0, NULL),
(3, 'campaign 2 (gif)', 1, -1, -1, -1, '0000-00-00', '0000-00-00', 't', 0, 1, 0, 0, 0, 't', 0, '', NULL, NULL, '2007-05-17 13:14:43', 0, 0, 0, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_campaigns_trackers`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `oa_campaigns_trackers`
-- 

INSERT INTO `oa_campaigns_trackers` (`campaign_trackerid`, `campaignid`, `trackerid`, `viewwindow`, `clickwindow`, `status`) VALUES (1, 3, 1, 3, 3, 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_category`
-- 

CREATE TABLE `oa_category` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_category`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_channel`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `oa_channel`
-- 

INSERT INTO `oa_channel` (`channelid`, `agencyid`, `affiliateid`, `name`, `description`, `compiledlimitation`, `acl_plugins`, `active`, `comments`, `updated`, `acls_updated`) VALUES (7, 0, 0, 'Test Admin Channel 2', '', 'true', 'true', 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_clients`
-- 

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
  `oac_adnetwork_id` int(11) default NULL,
  PRIMARY KEY  (`clientid`),
  KEY `clients_agencyid` (`agencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `oa_clients`
-- 

INSERT INTO `oa_clients` (`clientid`, `agencyid`, `clientname`, `contact`, `email`, `clientusername`, `clientpassword`, `permissions`, `language`, `report`, `reportinterval`, `reportlastdate`, `reportdeactivate`, `comments`, `updated`, `lb_reporting`, `oac_adnetwork_id`) VALUES (1, 0, 'Advertiser 1', 'advertiser', 'example@example.com', 'advertiser1', 'fe1f4b7940d69cf3eb289fad37c3ae40', 0, '', 'f', 7, '2007-04-27', 't', '', '2007-05-16 12:54:09', 'f', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_intermediate_ad`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_intermediate_ad`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_intermediate_ad_connection`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_intermediate_ad_connection`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_intermediate_ad_variable_value`
-- 

CREATE TABLE `oa_data_intermediate_ad_variable_value` (
  `data_intermediate_ad_variable_value_id` bigint(20) NOT NULL auto_increment,
  `data_intermediate_ad_connection_id` bigint(20) NOT NULL,
  `tracker_variable_id` int(11) NOT NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`data_intermediate_ad_variable_value_id`),
  KEY `data_intermediate_ad_connection_id` (`data_intermediate_ad_connection_id`),
  KEY `data_intermediate_ad_variable_value_tracker_variable_id` (`tracker_variable_id`),
  KEY `data_intermediate_ad_variable_value_tracker_value` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_intermediate_ad_variable_value`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_raw_ad_click`
-- 

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

INSERT INTO `oa_data_raw_ad_click` (`viewer_id`, `viewer_session_id`, `date_time`, `ad_id`, `creative_id`, `zone_id`, `channel`, `channel_ids`, `language`, `ip_address`, `host_name`, `country`, `https`, `domain`, `page`, `query`, `referer`, `search_term`, `user_agent`, `os`, `browser`, `max_https`, `geo_region`, `geo_city`, `geo_postal_code`, `geo_latitude`, `geo_longitude`, `geo_dma_code`, `geo_area_code`, `geo_organisation`, `geo_netspeed`, `geo_continent`) VALUES ('1d0b8f22878ee21edac4d01eeb8793bd', '', '2007-08-29 15:19:19', 2, 0, 0, NULL, NULL, '', '127.0.0.1', '127.0.0.1', NULL, NULL, NULL, NULL, NULL, NULL, '', 'Mozilla/4.0 (compatible; MSIE 6.0b; Windows 98)', '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_raw_ad_impression`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_raw_ad_request`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_raw_tracker_impression`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `oa_data_raw_tracker_impression`
-- 

INSERT INTO `oa_data_raw_tracker_impression` (`server_raw_tracker_impression_id`, `server_raw_ip`, `viewer_id`, `viewer_session_id`, `date_time`, `tracker_id`, `channel`, `channel_ids`, `language`, `ip_address`, `host_name`, `country`, `https`, `domain`, `page`, `query`, `referer`, `search_term`, `user_agent`, `os`, `browser`, `max_https`, `geo_region`, `geo_city`, `geo_postal_code`, `geo_latitude`, `geo_longitude`, `geo_dma_code`, `geo_area_code`, `geo_organisation`, `geo_netspeed`, `geo_continent`) VALUES (1, 'singleDB', '6e8928c9063f85e75c8a457b42f50257', '', '2007-06-01 15:13:26', 1, '', '', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', '', 0, '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11', '', '', 0, '', '', '', '0.0000', '0.0000', '', '', '', '', ''),
(2, 'singleDB', '6e8928c9063f85e75c8a457b42f50257', '', '2007-06-01 15:13:37', 1, '', '', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', '', 0, '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11', '', '', 0, '', '', '', '0.0000', '0.0000', '', '', '', '', ''),
(3, 'singleDB', '6e8928c9063f85e75c8a457b42f50257', '', '2007-06-01 15:23:06', 1, '', '', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', '', 0, '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11', '', '', 0, '', '', '', '0.0000', '0.0000', '', '', '', '', ''),
(4, 'singleDB', '6e8928c9063f85e75c8a457b42f50257', '', '2007-06-01 15:23:07', 1, '', '', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', '', 0, '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11', '', '', 0, '', '', '', '0.0000', '0.0000', '', '', '', '', ''),
(5, 'singleDB', '6e8928c9063f85e75c8a457b42f50257', '', '2007-06-01 15:24:37', 1, '', '', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', '', 0, '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11', '', '', 0, '', '', '', '0.0000', '0.0000', '', '', '', '', ''),
(6, 'singleDB', '6e8928c9063f85e75c8a457b42f50257', '', '2007-06-01 15:25:53', 1, '', '', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', '', 0, '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.11) Gecko/20070312 Firefox/1.5.0.11', '', '', 0, '', '', '', '0.0000', '0.0000', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_raw_tracker_variable_value`
-- 

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

INSERT INTO `oa_data_raw_tracker_variable_value` (`server_raw_tracker_impression_id`, `server_raw_ip`, `tracker_variable_id`, `date_time`, `value`) VALUES (1, 'singleDB', 1, '2007-06-01 15:13:26', '123'),
(1, 'singleDB', 2, '2007-06-01 15:13:26', 'test123'),
(2, 'singleDB', 1, '2007-06-01 15:13:37', '123'),
(2, 'singleDB', 2, '2007-06-01 15:13:37', 'test123'),
(3, 'singleDB', 1, '2007-06-01 15:23:06', '123'),
(3, 'singleDB', 2, '2007-06-01 15:23:06', 'test123'),
(4, 'singleDB', 1, '2007-06-01 15:23:07', '123'),
(4, 'singleDB', 2, '2007-06-01 15:23:07', 'test123'),
(5, 'singleDB', 1, '2007-06-01 15:25:09', '123'),
(5, 'singleDB', 2, '2007-06-01 15:25:09', 'test123'),
(6, 'singleDB', 1, '2007-06-01 15:25:53', '123'),
(6, 'singleDB', 2, '2007-06-01 15:25:53', 'test123');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_summary_ad_hourly`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_summary_ad_hourly`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_summary_ad_zone_assoc`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_summary_ad_zone_assoc`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_summary_channel_daily`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_summary_channel_daily`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_data_summary_zone_impression_history`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_data_summary_zone_impression_history`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_database_action`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- 
-- Dumping data for table `oa_database_action`
-- 

INSERT INTO `oa_database_action` (`database_action_id`, `upgrade_action_id`, `schema_name`, `version`, `timing`, `action`, `info1`, `info2`, `tablename`, `tablename_backup`, `table_backup_schema`, `updated`) VALUES (1, 1, 'tables_core', 516, 0, 10, 'UPGRADE STARTED', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20'),
(2, 1, 'tables_core', 516, 0, 40, 'BACKUP UNNECESSARY', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20'),
(3, 1, 'tables_core', 516, 0, 60, 'UPGRADE SUCCEEDED', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20'),
(4, 1, 'tables_core', 516, 1, 10, 'UPGRADE STARTED', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20'),
(5, 1, 'tables_core', 516, 1, 20, 'BACKUP STARTED', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20'),
(6, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_country_daily', 'z_625015862981b344', 'a:2:{s:6:"fields";a:6:{s:34:"data_summary_zone_country_daily_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:3:"day";a:5:{s:7:"notnull";b:1;s:10:"nativetype";s:4:"date";s:7:"default";s:10:"0000-00-00";s:4:"type";s:12:"openads_date";s:8:"mdb2type";s:12:"openads_date";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:7:"country";a:6:{s:7:"notnull";b:0;s:10:"nativetype";s:4:"char";s:6:"length";s:1:"2";s:7:"default";N;s:4:"type";s:12:"openads_char";s:8:"mdb2type";s:12:"openads_char";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:35:"data_summary_zone_country_daily_day";a:1:{s:6:"fields";a:1:{s:3:"day";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:39:"data_summary_zone_country_daily_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:36:"data_summary_zone_country_daily_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:34:"data_summary_zone_country_daily_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(7, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_country_forecast', 'z_a4aeea003f0c5148', 'a:2:{s:6:"fields";a:5:{s:37:"data_summary_zone_country_forecast_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:11:"day_of_week";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:8:"smallint";s:6:"length";s:1:"6";s:7:"default";s:0:"";s:4:"type";s:16:"openads_smallint";s:8:"mdb2type";s:16:"openads_smallint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:0:"";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:7:"country";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:1:"2";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:46:"data_summary_zone_country_forecast_day_of_week";a:1:{s:6:"fields";a:1:{s:11:"day_of_week";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:42:"data_summary_zone_country_forecast_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:39:"data_summary_zone_country_forecast_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:37:"data_summary_zone_country_forecast_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(8, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_country_monthly', 'z_002cc0f7c6553837', 'a:2:{s:6:"fields";a:6:{s:36:"data_summary_zone_country_monthly_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:9:"yearmonth";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:9:"mediumint";s:6:"length";s:1:"6";s:7:"default";s:1:"0";s:4:"type";s:17:"openads_mediumint";s:8:"mdb2type";s:17:"openads_mediumint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:7:"country";a:6:{s:7:"notnull";b:0;s:10:"nativetype";s:4:"char";s:6:"length";s:1:"2";s:7:"default";N;s:4:"type";s:12:"openads_char";s:8:"mdb2type";s:12:"openads_char";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:43:"data_summary_zone_country_monthly_yearmonth";a:1:{s:6:"fields";a:1:{s:9:"yearmonth";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:41:"data_summary_zone_country_monthly_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:38:"data_summary_zone_country_monthly_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:36:"data_summary_zone_country_monthly_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(9, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_domain_page_daily', 'z_a121ecd0d9bd87c9', 'a:2:{s:6:"fields";a:7:{s:38:"data_summary_zone_domain_page_daily_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:3:"day";a:5:{s:7:"notnull";b:1;s:10:"nativetype";s:4:"date";s:7:"default";s:10:"0000-00-00";s:4:"type";s:12:"openads_date";s:8:"mdb2type";s:12:"openads_date";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"domain";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:4:"page";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:39:"data_summary_zone_domain_page_daily_day";a:1:{s:6:"fields";a:1:{s:3:"day";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:43:"data_summary_zone_domain_page_daily_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:40:"data_summary_zone_domain_page_daily_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:38:"data_summary_zone_domain_page_daily_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(10, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_domain_page_forecast', 'z_2ee3a39f42a4561b', 'a:2:{s:6:"fields";a:6:{s:41:"data_summary_zone_domain_page_forecast_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:11:"day_of_week";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:8:"smallint";s:6:"length";s:1:"6";s:7:"default";s:0:"";s:4:"type";s:16:"openads_smallint";s:8:"mdb2type";s:16:"openads_smallint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:0:"";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"domain";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:4:"page";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:50:"data_summary_zone_domain_page_forecast_day_of_week";a:1:{s:6:"fields";a:1:{s:11:"day_of_week";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:46:"data_summary_zone_domain_page_forecast_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:43:"data_summary_zone_domain_page_forecast_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:41:"data_summary_zone_domain_page_forecast_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(11, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_domain_page_monthly', 'z_28acb3ec69ccdab8', 'a:2:{s:6:"fields";a:7:{s:40:"data_summary_zone_domain_page_monthly_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:9:"yearmonth";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:9:"mediumint";s:6:"length";s:1:"6";s:7:"default";s:1:"0";s:4:"type";s:17:"openads_mediumint";s:8:"mdb2type";s:17:"openads_mediumint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"domain";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:4:"page";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:47:"data_summary_zone_domain_page_monthly_yearmonth";a:1:{s:6:"fields";a:1:{s:9:"yearmonth";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:45:"data_summary_zone_domain_page_monthly_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:42:"data_summary_zone_domain_page_monthly_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:40:"data_summary_zone_domain_page_monthly_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(12, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_site_keyword_daily', 'z_35f9fdcf51eac964', 'a:2:{s:6:"fields";a:7:{s:39:"data_summary_zone_site_keyword_daily_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:3:"day";a:5:{s:7:"notnull";b:1;s:10:"nativetype";s:4:"date";s:7:"default";s:10:"0000-00-00";s:4:"type";s:12:"openads_date";s:8:"mdb2type";s:12:"openads_date";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:4:"site";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:7:"keyword";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:40:"data_summary_zone_site_keyword_daily_day";a:1:{s:6:"fields";a:1:{s:3:"day";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:44:"data_summary_zone_site_keyword_daily_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:41:"data_summary_zone_site_keyword_daily_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:39:"data_summary_zone_site_keyword_daily_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(13, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_site_keyword_forecast', 'z_e2483eb008f13e7c', 'a:2:{s:6:"fields";a:6:{s:42:"data_summary_zone_site_keyword_forecast_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:11:"day_of_week";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:8:"smallint";s:6:"length";s:1:"6";s:7:"default";s:0:"";s:4:"type";s:16:"openads_smallint";s:8:"mdb2type";s:16:"openads_smallint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:0:"";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:4:"site";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:7:"keyword";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:51:"data_summary_zone_site_keyword_forecast_day_of_week";a:1:{s:6:"fields";a:1:{s:11:"day_of_week";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:47:"data_summary_zone_site_keyword_forecast_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:44:"data_summary_zone_site_keyword_forecast_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:42:"data_summary_zone_site_keyword_forecast_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(14, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_site_keyword_monthly', 'z_8f460958e301fcdc', 'a:2:{s:6:"fields";a:7:{s:41:"data_summary_zone_site_keyword_monthly_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:9:"yearmonth";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:9:"mediumint";s:6:"length";s:1:"6";s:7:"default";s:1:"0";s:4:"type";s:17:"openads_mediumint";s:8:"mdb2type";s:17:"openads_mediumint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:4:"site";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:7:"keyword";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:48:"data_summary_zone_site_keyword_monthly_yearmonth";a:1:{s:6:"fields";a:1:{s:9:"yearmonth";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:46:"data_summary_zone_site_keyword_monthly_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:43:"data_summary_zone_site_keyword_monthly_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:41:"data_summary_zone_site_keyword_monthly_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(15, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_source_daily', 'z_f7f09afd22821fd8', 'a:2:{s:6:"fields";a:6:{s:33:"data_summary_zone_source_daily_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:3:"day";a:5:{s:7:"notnull";b:1;s:10:"nativetype";s:4:"date";s:7:"default";s:10:"0000-00-00";s:4:"type";s:12:"openads_date";s:8:"mdb2type";s:12:"openads_date";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"source";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:34:"data_summary_zone_source_daily_day";a:1:{s:6:"fields";a:1:{s:3:"day";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:38:"data_summary_zone_source_daily_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:35:"data_summary_zone_source_daily_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:33:"data_summary_zone_source_daily_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(16, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_source_forecast', 'z_96c74a4850beb288', 'a:2:{s:6:"fields";a:5:{s:36:"data_summary_zone_source_forecast_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:11:"day_of_week";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:8:"smallint";s:6:"length";s:1:"6";s:7:"default";s:0:"";s:4:"type";s:16:"openads_smallint";s:8:"mdb2type";s:16:"openads_smallint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:0:"";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"source";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:45:"data_summary_zone_source_forecast_day_of_week";a:1:{s:6:"fields";a:1:{s:11:"day_of_week";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:41:"data_summary_zone_source_forecast_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:38:"data_summary_zone_source_forecast_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:36:"data_summary_zone_source_forecast_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(17, 1, 'tables_core', 516, 1, 30, 'copied table', 'cleaned by user', 'data_summary_zone_source_monthly', 'z_b1e06bdbc4c119e1', 'a:2:{s:6:"fields";a:6:{s:35:"data_summary_zone_source_monthly_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:6:"bigint";s:6:"length";s:2:"20";s:7:"default";i:0;s:13:"autoincrement";b:1;s:4:"type";s:14:"openads_bigint";s:8:"mdb2type";s:14:"openads_bigint";}s:9:"yearmonth";a:6:{s:7:"notnull";b:1;s:10:"nativetype";s:9:"mediumint";s:6:"length";s:1:"6";s:7:"default";s:1:"0";s:4:"type";s:17:"openads_mediumint";s:8:"mdb2type";s:17:"openads_mediumint";}s:7:"zone_id";a:7:{s:7:"notnull";b:1;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";s:1:"0";s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"source";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:7:"varchar";s:6:"length";s:3:"255";s:5:"fixed";b:0;s:7:"default";N;s:4:"type";s:15:"openads_varchar";s:8:"mdb2type";s:15:"openads_varchar";}s:11:"impressions";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}s:6:"clicks";a:7:{s:7:"notnull";b:0;s:10:"nativetype";s:3:"int";s:6:"length";s:2:"10";s:8:"unsigned";b:1;s:7:"default";N;s:4:"type";s:11:"openads_int";s:8:"mdb2type";s:11:"openads_int";}}s:7:"indexes";a:3:{s:42:"data_summary_zone_source_monthly_yearmonth";a:1:{s:6:"fields";a:1:{s:9:"yearmonth";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:40:"data_summary_zone_source_monthly_zone_id";a:1:{s:6:"fields";a:1:{s:7:"zone_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}s:37:"data_summary_zone_source_monthly_pkey";a:2:{s:7:"primary";b:1;s:6:"fields";a:1:{s:35:"data_summary_zone_source_monthly_id";a:2:{s:5:"order";i:1;s:7:"sorting";s:9:"ascending";}}}}}', '2007-08-29 14:38:20'),
(18, 1, 'tables_core', 516, 1, 40, 'BACKUP COMPLETE', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20'),
(19, 1, 'tables_core', 516, 1, 60, 'UPGRADE SUCCEEDED', NULL, NULL, NULL, NULL, '2007-08-29 14:38:20');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_images`
-- 

CREATE TABLE `oa_images` (
  `filename` varchar(128) NOT NULL default '',
  `contents` longblob NOT NULL,
  `t_stamp` datetime default NULL,
  PRIMARY KEY  (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_images`
-- 

INSERT INTO `oa_images` (`filename`, `contents`, `t_stamp`) VALUES ('468x60.gif', 0x4749463839619d013c009d00007575759d9d9d4444449d9d9d1010109d9d3f9d9d3030309d9d9d2020206565659d9d9d5555559d9d9d9d9d9d000000219d0400000000002c000000009d013c0000049d9d9d499d9d389d3f9d60289d64699d689d9d6c9d702c9d746d9d789d9d7c9d3f9d9d63481c0a50049d229d28060c0a429d9d58369d0d9d9d4a5a9d509d9d240e9d519d7a9d6e571a9d9d24309d9d9d3f249d9d9d0800626e1d757f717a270906429d4306099d9d9d9d2e0c9d732209019d780b9d1e9d9d7803009d179d9d459d24009d9d0e9d9d9d9d9d16419d230a9d9d43059d1b0c9d9d9d149d9d449d21047e9d3f9d3f9d7f9d1f0b9d719d1b0a9d773f9d3f9d1904059d0e039d9d9d9d369d9d9d1d769d1c079d45069d9d9d053e9d23170e9d432e709d0301601f11539d38740051529d153578739d0f9d3f289d9d1d9d9d419d44229d305c3c9d4e9d3f0e529d1b9d9d243f38316c1c659d02019d7f06640128539d5b349d04002040409d9d45329d9d9d4928009d509d1c9d309d10020300169d7314309d3f1312649d9d619d1f59139d9d199d9d9d009d04060222249d0e5c097d9d3f9d489d9d5c68139d9d049d67059d7f149d749d9d5e9d7b2c3b9d9d06321e9d1702139d3c9d54099d0e35509d1a9d686b1d5e539d00349d9d099d9d4015361b3f279d9d61389d00192e179d3f792d9d9d1c53189d07469d652b386a379d9d9d3c9d9d3f1d4302479d519d773f569d9d1c9d1f4a9d219d9d004b771f3f419d6e369d459d9d9d7d439d9d5f697f6c201e229d35489d6c9d9d9d1d070030200073181c9d9d062f9d6c9d9d65219d189d9d9d759d0c9d9d6b409d9d74129d789d0b506d589d6916409d409d9d75729d9d439d9d42569d499d211e9d9d9d240f9d159d205b1b109d429d6650389d054f3f009d9d379d9d2d049d07693f9d399d469d1d309d79079d2b9d9d019d449d9d9d039d6569069d6e9d019d0a479d9d416168165a9d9d9d3d9d587f9d249d429d33661028717539621d9d025a9d1f9d2e9d9d019d411a2a6a0c9d9d9d289d77547000519d059d9d1622289d487d5949079d43179d799d6a9d399d2a9d9d3f9d74009d03429d9d2c0a722a7a9d9d069d9d9d029d0d9d007d9d6515409d049d723f1a9d763f7a169d4e9d9d4d409d579d6a709d039d9d9d263f049d5e702c729d749d1f1a6c4a0a7e9d9d649d54009d639d3e3f9d009d623d9d9d6b71087a0a9d9d059d1e709d9d1f2003109d719d38019d9d9d9d9d3f9d9d1f3f1a9d9d349d1514671b57502e021f9d719d0607149d4900244f9d9d169d9d9d053b9d6c9d069d9d9d9d35576d9d9d43489d330530519d7a9d5c9d9d5a019d9d199d5d3f413f6d6d359d195b9d369d69679d9d229d3400639d9d9d9d769d9d4d6c9d6f5b2d9d00189d9d6c2f059d9d9d049d0d4b00246e709d289d9d0d4b9d9d9d123f9d28525d789d589d269d9d179d020067609d9d9d9d9d9d32409d9d9d6e573f9d6e9d9d9d21759d9d9d2e6a3f9d7e7a559d029d2e9d0f9d3c519d1c7e9d769d0c9d3c019d170f739d9d0b9d9d9d2b9d9d399d9d9d9d023f039d4f3f3f9d449d9d9d9d9d3d9d9d2f5b7a9d9d736d549d209d9d1a1c9d9d0e639d2b1a9d1c9d0a9d6c089d9d9d9d9d9d081d9d5b5b9d26309d9d9d6c3e16789d031a289d9d4419409d9d409d410e9d9d5d9d9d9d062d9d249d214e039d7b3f429d099d3f789d5c064c9d23109d9d7e7e9d61069d9d2a1a2a9d9d9d1f9d9d9d9d1b559d614b5d9d4a9d2f119d9d9d770e9d20059d9d430d5c3f9d9d579d3f469d9d31599d3f0420652d9d9d039d73009d5e4628239d710374744019259d78150b9d9d5a9d499d589d9d259d029d9d9d03441802081143329d9d072a9d1d4e669d619d349d22279d9d3f489d774d9d409d9d9d9d717d9d749d509d039d9d9d435240361d285f2845599d479d3f4b9d0229589d2962009d9d9d084f9d9d07080c4a386c9d2e9d344a9d3c269d9d9d9d30053f9d49209d339d0d36359d4d9d289d00669d26357b9d070b9d6e9d9d632b9d9d4a2078539d29529d3b3b509d9d019d02223f3a9d539d7d584056109d9d3323354f0f019d0f429d9d9d7a9d9d0d20349d260a159d18559d9d740d749d9d59059d1807399d512a9d9d9d2d9d799d3f229d239d9d054e3a9d097d9d9d1f5552419d719d039d9d107f9d684425103b9d4a609d45384c9d9d6a9d7c6e207611439d10601a48079d349d9d3940539d9d3f7a759d5e9d9d2150384b9d9d6b9d319d16203f259d9d9d0317259d9d2e9d15789d2c9d58159d3d9d9d9d9d5454029d6460069d673f7a450c2e9d233e49489d5d25479d9d739d5f9d5a356f3e9d739d539d5a6c9d520318439d7f9d9d4a17359d38089d9d43639d9d36084b9d4d009d3f6c9d2c9d9d205d9d009d4316066a3b0028340500429d2a9d3a013f67769d479d459d6d730b469d5a0a2c629d9d6c47679d079d531b9d9d9d369d5a9d1d59253f294c4e9d9d9d4c779d9d9d4d70615124644e9d7a9d5a08529d3b3f9d20511d643d3f0b049d0976409d9d9d55179d289d12661f9d9d455551109d5e9d9d9d5b9d583d709d3f9d499d4b9d5c3a3f499d0f099d9d4e9d9d609d4158799d382560476c06182d9d7d9d2d9d55579d9d112c9d759d2d9d4e0c9d00239d9d16685d2f3c1b9d4e74585355619d2c7d0c9d0b9d76147f9d319d780c9d3f659d1c509d9d0d9d9d189d9d032e6d2e6f9d9d1f2c739d5b1f3f9d9d9d649d019d099d5b410214609d322863290c9d2525189d66303f057c9d9d3a3f67361b9d3f4e9d0a9d179d9d463b1a061100003b, '2007-05-17 12:01:02');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_lb_local`
-- 

CREATE TABLE `oa_lb_local` (
  `last_run` int(11) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_lb_local`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_log_maintenance_forecasting`
-- 

CREATE TABLE `oa_log_maintenance_forecasting` (
  `log_maintenance_forecasting_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_forecasting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_log_maintenance_forecasting`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_log_maintenance_priority`
-- 

CREATE TABLE `oa_log_maintenance_priority` (
  `log_maintenance_priority_id` int(11) NOT NULL auto_increment,
  `start_run` datetime NOT NULL,
  `end_run` datetime NOT NULL,
  `operation_interval` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `run_type` tinyint(3) unsigned NOT NULL,
  `updated_to` datetime default NULL,
  PRIMARY KEY  (`log_maintenance_priority_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_log_maintenance_priority`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_log_maintenance_statistics`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_log_maintenance_statistics`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_password_recovery`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_placement_zone_assoc`
-- 

CREATE TABLE `oa_placement_zone_assoc` (
  `placement_zone_assoc_id` mediumint(9) NOT NULL auto_increment,
  `zone_id` mediumint(9) default NULL,
  `placement_id` mediumint(9) default NULL,
  PRIMARY KEY  (`placement_zone_assoc_id`),
  KEY `placement_zone_assoc_zone_id` (`zone_id`),
  KEY `placement_id` (`placement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `oa_placement_zone_assoc`
-- 

INSERT INTO `oa_placement_zone_assoc` (`placement_zone_assoc_id`, `zone_id`, `placement_id`) VALUES (1, 1, 1),
(2, 1, 2),
(3, 2, 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_plugins_channel_delivery_assoc`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_plugins_channel_delivery_domains`
-- 

CREATE TABLE `oa_plugins_channel_delivery_domains` (
  `domain_id` int(10) unsigned NOT NULL auto_increment,
  `domain_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`domain_id`),
  KEY `domain_name` (`domain_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_plugins_channel_delivery_domains`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_plugins_channel_delivery_rules`
-- 

CREATE TABLE `oa_plugins_channel_delivery_rules` (
  `rule_id` int(10) unsigned NOT NULL auto_increment,
  `modifier` varchar(100) NOT NULL default '',
  `client` varchar(100) NOT NULL default '',
  `rule` text NOT NULL,
  PRIMARY KEY  (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_plugins_channel_delivery_rules`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_preference`
-- 

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

INSERT INTO `oa_preference` (`agencyid`, `config_version`, `my_header`, `my_footer`, `my_logo`, `language`, `name`, `company_name`, `override_gd_imageformat`, `begin_of_week`, `percentage_decimals`, `type_sql_allow`, `type_url_allow`, `type_web_allow`, `type_html_allow`, `type_txt_allow`, `banner_html_auto`, `admin`, `admin_pw`, `admin_fullname`, `admin_email`, `warn_admin`, `warn_agency`, `warn_client`, `warn_limit`, `admin_email_headers`, `admin_novice`, `default_banner_weight`, `default_campaign_weight`, `default_banner_url`, `default_banner_destination`, `client_welcome`, `client_welcome_msg`, `publisher_welcome`, `publisher_welcome_msg`, `content_gzip_compression`, `userlog_email`, `gui_show_campaign_info`, `gui_show_campaign_preview`, `gui_campaign_anonymous`, `gui_show_banner_info`, `gui_show_banner_preview`, `gui_show_banner_html`, `gui_show_matching`, `gui_show_parents`, `gui_hide_inactive`, `gui_link_compact_limit`, `gui_header_background_color`, `gui_header_foreground_color`, `gui_header_active_tab_color`, `gui_header_text_color`, `gui_invocation_3rdparty_default`, `qmail_patch`, `updates_enabled`, `updates_cache`, `updates_timestamp`, `updates_last_seen`, `allow_invocation_plain`, `allow_invocation_plain_nocookies`, `allow_invocation_js`, `allow_invocation_frame`, `allow_invocation_xmlrpc`, `allow_invocation_local`, `allow_invocation_interstitial`, `allow_invocation_popup`, `allow_invocation_clickonly`, `auto_clean_tables`, `auto_clean_tables_interval`, `auto_clean_userlog`, `auto_clean_userlog_interval`, `auto_clean_tables_vacuum`, `autotarget_factor`, `maintenance_timestamp`, `compact_stats`, `statslastday`, `statslasthour`, `default_tracker_status`, `default_tracker_type`, `default_tracker_linkcampaigns`, `publisher_agreement`, `publisher_agreement_text`, `publisher_payment_modes`, `publisher_currencies`, `publisher_categories`, `publisher_help_files`, `publisher_default_tax_id`, `publisher_default_approved`, `more_reports`, `gui_column_id`, `gui_column_requests`, `gui_column_impressions`, `gui_column_clicks`, `gui_column_ctr`, `gui_column_conversions`, `gui_column_conversions_pending`, `gui_column_sr_views`, `gui_column_sr_clicks`, `gui_column_revenue`, `gui_column_cost`, `gui_column_bv`, `gui_column_num_items`, `gui_column_revcpc`, `gui_column_costcpc`, `gui_column_technology_cost`, `gui_column_income`, `gui_column_income_margin`, `gui_column_profit`, `gui_column_margin`, `gui_column_erpm`, `gui_column_erpc`, `gui_column_erps`, `gui_column_eipm`, `gui_column_eipc`, `gui_column_eips`, `gui_column_ecpm`, `gui_column_ecpc`, `gui_column_ecps`, `gui_column_epps`, `instance_id`, `maintenance_cron_timestamp`, `warn_limit_days`) VALUES (0, '0.000', NULL, NULL, NULL, 'english', NULL, 'www.openads.org', NULL, 0, 2, 't', 't', 'f', 't', 't', 't', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Andrew Hill', 'andrew.hill@openads.org', 't', 't', 't', 100, NULL, 't', 1, 1, NULL, NULL, 't', NULL, 't', NULL, 'f', 't', 't', 't', 't', 't', 't', 't', 't', 't', 't', 50, NULL, NULL, NULL, NULL, '0', 'f', 't', 'b:0;', 1188468357, '0.000', 'f', 't', 't', 'f', 'f', 't', 't', 't', 't', 'f', 5, 'f', 5, 't', -1, 1180706838, 't', '0000-00-00', 0, 1, 1, 'f', 'f', NULL, '', '', '', '', 't', 't', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1),
(1, '0.000', NULL, NULL, NULL, '', 'Test Agency', 'www.openads.org', NULL, 0, 2, 't', 't', 'f', 't', 't', 't', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Andrew Hill', 'andrew.hill@openads.org', 't', 't', 't', 100, NULL, 't', 1, 1, NULL, NULL, 't', NULL, 't', NULL, 'f', 't', 't', 't', 't', 't', 't', 't', 't', 't', 't', 50, NULL, NULL, NULL, NULL, '0', 'f', 't', NULL, 0, NULL, 'f', 't', 't', 'f', 'f', 't', 't', 't', 't', 'f', 5, 'f', 5, 't', -1, 1180706838, 't', '0000-00-00', 0, 1, 1, 'f', 'f', NULL, '', '', '', '', 't', 't', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1179299106, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_preference_advertiser`
-- 

CREATE TABLE `oa_preference_advertiser` (
  `advertiser_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`advertiser_id`,`preference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_preference_advertiser`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_preference_publisher`
-- 

CREATE TABLE `oa_preference_publisher` (
  `publisher_id` int(11) NOT NULL,
  `preference` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`publisher_id`,`preference`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_preference_publisher`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_session`
-- 

CREATE TABLE `oa_session` (
  `sessionid` varchar(32) NOT NULL default '',
  `sessiondata` longblob NOT NULL,
  `lastused` datetime default NULL,
  PRIMARY KEY  (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_session`
-- 

INSERT INTO `oa_session` (`sessionid`, `sessiondata`, `lastused`) VALUES ('phpads465c3580ef7ff1.90755088', 0x613a363a7b733a383a227573657274797065223b693a313b733a383a226c6f67676564696e223b733a313a2274223b733a383a226167656e63796964223b693a303b733a383a22757365726e616d65223b733a353a2261646d696e223b733a353a227072656673223b613a383a7b733a32303a22616476657274697365722d696e6465782e706870223b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b613a303a7b7d7d733a373a22474c4f42414c53223b613a333a7b733a31333a22706572696f645f707265736574223b733a353a22746f646179223b733a31323a22706572696f645f7374617274223b733a31303a22323030372d30362d3031223b733a31303a22706572696f645f656e64223b733a31303a22323030372d30362d3031223b7d733a393a2273746174732e706870223b613a353a7b733a393a226c6973746f72646572223b733a343a226e616d65223b733a31343a226f72646572646972656374696f6e223b733a323a227570223b733a31303a2273746172746c6576656c223b693a303b733a353a226e6f646573223b733a303a22223b733a31323a2268696465696e616374697665223b623a313b7d733a31393a22616666696c696174652d696e6465782e706870223b613a333a7b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b733a303a22223b7d733a32343a22616476657274697365722d63616d706169676e732e706870223b613a313a7b693a313b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b733a303a22223b7d7d733a32333a22616476657274697365722d747261636b6572732e706870223b613a323a7b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b7d733a32313a22747261636b65722d63616d706169676e732e706870223b613a333a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b7d733a32313a22747261636b65722d7661726961626c65732e706870223b613a313a7b733a393a22747261636b65726964223b733a313a2231223b7d7d733a31323a227570646174655f636865636b223b623a303b7d, '2007-06-01 15:09:52'),
('phpads465d96668fc721.60249221', 0x613a363a7b733a383a227573657274797065223b693a313b733a383a226c6f67676564696e223b733a313a2274223b733a383a226167656e63796964223b693a303b733a383a22757365726e616d65223b733a353a2261646d696e223b733a353a227072656673223b613a333a7b733a32303a22616476657274697365722d696e6465782e706870223b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b613a303a7b7d7d733a32343a22616476657274697365722d63616d706169676e732e706870223b613a313a7b693a313b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b733a303a22223b7d7d733a32333a22616476657274697365722d747261636b6572732e706870223b613a323a7b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b7d7d733a31323a227570646174655f636865636b223b623a303b7d, '2007-06-01 17:15:27'),
('phpads4666d2619a15a3.52419402', 0x613a363a7b733a383a227573657274797065223b693a313b733a383a226c6f67676564696e223b733a313a2274223b733a383a226167656e63796964223b693a303b733a383a22757365726e616d65223b733a353a2261646d696e223b733a353a227072656673223b613a313a7b733a32303a22616476657274697365722d696e6465782e706870223b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b613a303a7b7d7d7d733a31323a227570646174655f636865636b223b623a303b7d, '2007-06-06 16:27:35'),
('phpads468a364daaa084.23126755', 0x613a363a7b733a383a227573657274797065223b693a313b733a383a226c6f67676564696e223b733a313a2274223b733a383a226167656e63796964223b693a303b733a383a22757365726e616d65223b733a353a2261646d696e223b733a353a227072656673223b613a323a7b733a32303a22616476657274697365722d696e6465782e706870223b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b613a303a7b7d7d733a31393a22616666696c696174652d696e6465782e706870223b613a333a7b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b733a303a22223b7d7d733a31323a227570646174655f636865636b223b623a303b7d, '2007-07-03 14:48:40'),
('phpads46d44deed3dd40.69179106', 0x613a363a7b733a383a227573657274797065223b693a313b733a383a226c6f67676564696e223b733a313a2274223b733a383a226167656e63796964223b693a303b733a383a22757365726e616d65223b733a353a2261646d696e223b733a353a227072656673223b613a313a7b733a32303a22616476657274697365722d696e6465782e706870223b613a343a7b733a31323a2268696465696e616374697665223b623a313b733a393a226c6973746f72646572223b733a303a22223b733a31343a226f72646572646972656374696f6e223b733a303a22223b733a353a226e6f646573223b613a303a7b7d7d7d733a31353a226d61696e745f7570646174655f6a73223b623a313b7d, '2007-08-30 11:06:32');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_targetstats`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_tracker_append`
-- 

CREATE TABLE `oa_tracker_append` (
  `tracker_append_id` int(11) NOT NULL auto_increment,
  `tracker_id` mediumint(9) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  `tagcode` text NOT NULL,
  `paused` enum('t','f') NOT NULL default 'f',
  `autotrack` enum('t','f') NOT NULL default 'f',
  PRIMARY KEY  (`tracker_append_id`),
  KEY `tracker_id` (`tracker_id`,`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_tracker_append`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_trackers`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `oa_trackers`
-- 

INSERT INTO `oa_trackers` (`trackerid`, `trackername`, `description`, `clientid`, `viewwindow`, `clickwindow`, `blockwindow`, `status`, `type`, `linkcampaigns`, `variablemethod`, `appendcode`, `updated`) VALUES (1, 'Sample Tracker', '', 1, 3, 3, 0, 4, 1, 'f', 'js', '', '2007-06-01 15:09:47');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_upgrade_action`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `oa_upgrade_action`
-- 

INSERT INTO `oa_upgrade_action` (`upgrade_action_id`, `upgrade_name`, `version_to`, `version_from`, `action`, `description`, `logfile`, `confbackup`, `updated`) VALUES (1, 'openads_upgrade_2.5.1.xml', '2.5.1', '2.3.39-beta', 1, 'UPGRADE COMPLETE', 'cleaned by user', 'file not found', '2007-08-29 14:38:20'),
(2, 'openads_version_stamp_2.5.1-dev', '2.5.1-dev', '2.5.1', 1, 'UPGRADE COMPLETE', 'cleaned by user', 'cleaned by user', '2007-08-29 14:38:21');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_userlog`
-- 

CREATE TABLE `oa_userlog` (
  `userlogid` mediumint(9) NOT NULL auto_increment,
  `timestamp` int(11) NOT NULL default '0',
  `usertype` tinyint(4) NOT NULL default '0',
  `userid` mediumint(9) NOT NULL default '0',
  `action` mediumint(9) NOT NULL default '0',
  `object` mediumint(9) default NULL,
  `details` longblob,
  PRIMARY KEY  (`userlogid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `oa_userlog`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_variable_publisher`
-- 

CREATE TABLE `oa_variable_publisher` (
  `variable_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`variable_id`,`publisher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `oa_variable_publisher`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `oa_variables`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `oa_variables`
-- 

INSERT INTO `oa_variables` (`variableid`, `trackerid`, `name`, `description`, `datatype`, `purpose`, `reject_if_empty`, `is_unique`, `unique_window`, `variablecode`, `hidden`, `updated`) VALUES (1, 1, 'boo', 'Sample number', 'numeric', NULL, 0, 0, 0, 'var boo = \\''%%BOO_VALUE%%\\''', 'f', '2007-06-01 15:09:47'),
(2, 1, 'foo', 'Sample string', 'string', NULL, 0, 0, 0, 'var foo = \\''%%FOO_VALUE%%\\''', 'f', '2007-06-01 15:09:47');

-- --------------------------------------------------------

-- 
-- Table structure for table `oa_zones`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `oa_zones`
-- 

INSERT INTO `oa_zones` (`zoneid`, `affiliateid`, `zonename`, `description`, `delivery`, `zonetype`, `category`, `width`, `height`, `ad_selection`, `chain`, `prepend`, `append`, `appendtype`, `forceappend`, `inventory_forecast_type`, `comments`, `cost`, `cost_type`, `cost_variable_id`, `technology_cost`, `technology_cost_type`, `updated`, `block`, `capping`, `session_capping`, `what`) VALUES (1, 1, 'Publisher 1 - Default', '', 0, 3, '', 468, 60, '', '', '', '', 0, 'f', 0, '', NULL, NULL, '', NULL, NULL, '2007-04-27 15:37:19', 0, 0, 0, ''),
(2, 2, 'Agency Publisher 1 - Default', '', 0, 3, '', 468, 60, '', '', '', '', 0, 'f', 0, '', NULL, NULL, '', NULL, NULL, '2007-05-15 13:41:44', 0, 0, 0, '');
