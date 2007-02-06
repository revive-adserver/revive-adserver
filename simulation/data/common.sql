-- Host: localhost
-- Generation Time: Nov 27, 2006 at 14:31 PM
-- Server version: 5.0.22
-- PHP Version: 5.1.6

-- single login root:root

TRUNCATE TABLE `preference`;

INSERT INTO `preference` (`agencyid`, `config_version`, `my_header`, `my_footer`, `my_logo`, `language`, `name`, `company_name`, `override_gd_imageformat`, `begin_of_week`, `percentage_decimals`, `type_sql_allow`, `type_url_allow`, `type_web_allow`, `type_html_allow`, `type_txt_allow`, `banner_html_auto`, `admin`, `admin_pw`, `admin_fullname`, `admin_email`, `warn_admin`, `warn_agency`, `warn_client`, `warn_limit`, `admin_email_headers`, `admin_novice`, `default_banner_weight`, `default_campaign_weight`, `default_banner_url`, `default_banner_destination`, `client_welcome`, `client_welcome_msg`, `publisher_welcome`, `publisher_welcome_msg`, `content_gzip_compression`, `userlog_email`, `gui_show_campaign_info`, `gui_show_campaign_preview`, `gui_campaign_anonymous`, `gui_show_banner_info`, `gui_show_banner_preview`, `gui_show_banner_html`, `gui_show_matching`, `gui_show_parents`, `gui_hide_inactive`, `gui_link_compact_limit`, `gui_header_background_color`, `gui_header_foreground_color`, `gui_header_active_tab_color`, `gui_header_text_color`, `gui_invocation_3rdparty_default`, `qmail_patch`, `updates_enabled`, `updates_cache`, `updates_timestamp`, `updates_last_seen`, `allow_invocation_plain`, `allow_invocation_plain_nocookies`, `allow_invocation_js`, `allow_invocation_frame`, `allow_invocation_xmlrpc`, `allow_invocation_local`, `allow_invocation_interstitial`, `allow_invocation_popup`, `allow_invocation_clickonly`, `auto_clean_tables`, `auto_clean_tables_interval`, `auto_clean_userlog`, `auto_clean_userlog_interval`, `auto_clean_tables_vacuum`, `autotarget_factor`, `maintenance_timestamp`, `compact_stats`, `statslastday`, `statslasthour`, `default_tracker_status`, `default_tracker_type`, `default_tracker_linkcampaigns`, `publisher_agreement`, `publisher_agreement_text`, `publisher_payment_modes`, `publisher_currencies`, `publisher_categories`, `publisher_help_files`, `publisher_default_tax_id`, `publisher_default_approved`, `more_reports`, `gui_column_id`, `gui_column_requests`, `gui_column_impressions`, `gui_column_clicks`, `gui_column_ctr`, `gui_column_conversions`, `gui_column_conversions_pending`, `gui_column_sr_views`, `gui_column_sr_clicks`, `gui_column_revenue`, `gui_column_cost`, `gui_column_bv`, `gui_column_num_items`, `gui_column_revcpc`, `gui_column_costcpc`, `gui_column_technology_cost`, `gui_column_income`, `gui_column_income_margin`, `gui_column_profit`, `gui_column_margin`, `gui_column_erpm`, `gui_column_erpc`, `gui_column_erps`, `gui_column_eipm`, `gui_column_eipc`, `gui_column_eips`, `gui_column_ecpm`, `gui_column_ecpc`, `gui_column_ecps`, `gui_column_epps`, `instance_id`) VALUES (0, 0.300, NULL, NULL, NULL, 'english', NULL, 'mysite.com', NULL, 1, 2, 't', 't', 'f', 't', 't', 't', 'root', '63a9f0ea7bb98050796b649e85481845', 'Your Name', 'your@email.com', 't', 't', 't', 100, NULL, 't', 1, 1, NULL, NULL, 't', NULL, 't', NULL, 'f', 't', 't', 'f', 'f', 't', 't', 'f', 't', 'f', 'f', 50, '', '', '', '', 0, 'f', 't', NULL, 0, NULL, 'f', 't', 't', 'f', 'f', 't', 't', 't', 't', 'f', 5, 'f', 5, 't', -1, 1164623336, 't', '0000-00-00', 0, 1, 1, 'f', 'f', NULL, NULL, NULL, NULL, NULL, 'f', 'f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c5d74c4f0bf0a426b20874faaa14be1cb15542f1');

DROP TABLE IF EXISTS `data_intermediate_ad_arrival`;
CREATE TABLE IF NOT EXISTS `data_intermediate_ad_arrival` (
  data_intermediate_ad_arrival_id BIGINT NOT NULL AUTO_INCREMENT,
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  arrivals INTEGER UNSIGNED NOT NULL DEFAULT 0,
  conversions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  total_basket_value DECIMAL(10,4) NOT NULL DEFAULT 0,
  total_num_items INTEGER UNSIGNED NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (data_intermediate_ad_arrival_id),
  INDEX data_intermediate_ad_arrival_day (day),
  INDEX data_intermediate_ad_arrival_operation_interval_id (operation_interval_id),
  INDEX data_intermediate_ad_arrival_ad_id (ad_id),
  INDEX data_intermediate_ad_arrival_zone_id (zone_id)
);

DROP TABLE IF EXISTS `data_summary_ad_arrival_hourly`;
CREATE TABLE IF NOT EXISTS `data_summary_ad_arrival_hourly` (
  data_summary_ad_arrival_hourly_id BIGINT NOT NULL AUTO_INCREMENT,
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  arrivals INTEGER UNSIGNED NOT NULL DEFAULT 0,
  conversions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  total_basket_value DECIMAL(10,4) NULL,
  total_num_items INTEGER UNSIGNED NULL,
  total_revenue DECIMAL(10,4) NULL,
  total_cost DECIMAL(10,4) NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (data_summary_ad_arrival_hourly_id),
  INDEX data_summary_ad_arrival_hourly_day (day),
  INDEX data_summary_ad_arrival_hourly_hour (hour),
  INDEX data_summary_ad_arrival_hourly_ad_id (ad_id),
  INDEX data_summary_ad_arrival_hourly_zone_id (zone_id)
) TYPE=InnoDB;;

-- Behold the raw arrival table format!
DROP TABLE IF EXISTS `data_raw_ad_arrival`;
CREATE TABLE IF NOT EXISTS `data_raw_ad_arrival` (
  `viewer_id` varchar(32) default NULL,
  `viewer_session_id` varchar(32) default NULL,
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ad_id` int(10) unsigned NOT NULL default '0',
  `creative_id` int(10) unsigned NOT NULL default '0',
  `zone_id` int(10) unsigned NOT NULL default '0',
  `channel` varchar(51) default NULL,
  channel_ids VARCHAR(64) NULL,
  `language` varchar(32) default NULL,
  `ip_address` varchar(16) default NULL,
  `host_name` text,
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
  INDEX data_raw_ad_arrival_viewer_id (viewer_id),
  INDEX data_raw_ad_arrival_date_time (date_time),
  INDEX data_raw_ad_arrival_ad_id (ad_id),
  INDEX data_raw_ad_arrival_zone_id (zone_id)
) TYPE=InnoDB;

ALTER TABLE `campaigns_trackers` ADD COLUMN arrivalwindow mediumint(9) NOT NULL DEFAULT 0 AFTER trackerid;
ALTER TABLE `trackers` ADD COLUMN arrivalwindow MEDIUMINT(9) NOT NULL DEFAULT 0 AFTER clientid;

-- ADD 0.3.23 columns
ALTER TABLE `preference` ADD COLUMN gui_column_arrivals TEXT;
ALTER TABLE `preference` ADD COLUMN gui_column_sr_arrivals TEXT;

-- ADD 0.3.26 columns
ALTER TABLE `banners` ADD arrival_capable ENUM('t', 'f') NOT NULL DEFAULT 'f' AFTER comments;

-- ADD 0.3.27 columns
ALTER TABLE `preference` ADD COLUMN default_banner_arrival_capable ENUM('t', 'f') NOT NULL DEFAULT 'f';
