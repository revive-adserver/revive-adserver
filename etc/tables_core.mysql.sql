-- Note: ENUM() definitions in tables can NOT have a space after
-- the separating comma, or the table creation code will fail
-- silently! Similarly for multi-column PRIMARY KEYs!

CREATE TABLE IF NOT EXISTS acls (
  bannerid MEDIUMINT(9) NOT NULL DEFAULT '0',
  logical VARCHAR(3) NOT NULL DEFAULT 'and',
  type VARCHAR(32) NOT NULL DEFAULT '',
  comparison CHAR(2) NOT NULL DEFAULT '==',
  data TEXT NOT NULL,
  executionorder INT(10) UNSIGNED NOT NULL DEFAULT '0',
  UNIQUE KEY bannerid_executionorder (bannerid,executionorder),
  INDEX bannerid (bannerid)
);

CREATE TABLE IF NOT EXISTS acls_channel (
  channelid MEDIUMINT(9) NOT NULL DEFAULT '0',
  logical VARCHAR(3) NOT NULL DEFAULT 'and',
  type VARCHAR(32) NOT NULL DEFAULT '',
  comparison CHAR(2) NOT NULL DEFAULT '==',
  data TEXT NOT NULL,
  executionorder INT(10) UNSIGNED NOT NULL DEFAULT '0',
  UNIQUE KEY channelid_executionorder (channelid,executionorder),
  INDEX channelid (channelid)
);

CREATE TABLE IF NOT EXISTS ad_category_assoc (
  ad_category_assoc_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id INTEGER UNSIGNED NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (ad_category_assoc_id)
);

CREATE TABLE IF NOT EXISTS ad_zone_assoc (
  ad_zone_assoc_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  zone_id MEDIUMINT(9) DEFAULT NULL,
  ad_id MEDIUMINT(9) DEFAULT NULL,
  priority DOUBLE NULL DEFAULT 0,
  link_type SMALLINT(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (ad_zone_assoc_id),
  INDEX zone_id (zone_id),
  INDEX ad_id (ad_id)
);

CREATE TABLE IF NOT EXISTS affiliates (
  affiliateid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  agencyid MEDIUMINT(9) NOT NULL DEFAULT '0',
  name VARCHAR(255) NOT NULL DEFAULT '',
  mnemonic VARCHAR(5) NOT NULL DEFAULT '',
  comments TEXT DEFAULT NULL,
  contact VARCHAR(255) DEFAULT NULL,
  email VARCHAR(64) NOT NULL DEFAULT '',
  website VARCHAR(255) DEFAULT NULL,
  username VARCHAR(64) DEFAULT NULL,
  password VARCHAR(64) DEFAULT NULL,
  permissions MEDIUMINT(9) DEFAULT NULL,
  language VARCHAR(64) DEFAULT NULL,
  publiczones ENUM('t','f') NOT NULL DEFAULT 'f',
  last_accepted_agency_agreement DATETIME DEFAULT NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (affiliateid),
  INDEX agencyid (agencyid)
);

CREATE TABLE IF NOT EXISTS affiliates_extra (
  affiliateid MEDIUMINT(9) NOT NULL,
  address TEXT,
  city VARCHAR(255),
  postcode VARCHAR(64),
  country VARCHAR(255),
  phone VARCHAR(64),
  fax VARCHAR(64),
  account_contact VARCHAR(255),
  payee_name VARCHAR(255),
  tax_id VARCHAR(64),
  mode_of_payment VARCHAR(64),
  currency VARCHAR(64),
  unique_users INT(11),
  unique_views INT(11),
  page_rank INT(11),
  category VARCHAR(255),
  help_file VARCHAR(255),
  PRIMARY KEY (affiliateid)
);

CREATE TABLE IF NOT EXISTS agency (
  agencyid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL DEFAULT '',
  contact VARCHAR(255) DEFAULT NULL,
  email VARCHAR(64) NOT NULL DEFAULT '',
  username VARCHAR(64) DEFAULT NULL,
  password VARCHAR(64) DEFAULT NULL,
  permissions MEDIUMINT(9) DEFAULT NULL,
  language VARCHAR(64) DEFAULT NULL,
  logout_url VARCHAR(255) DEFAULT '',
  active SMALLINT(1) DEFAULT 0,
  updated DATETIME NOT NULL,
  PRIMARY KEY (agencyid)
);

CREATE TABLE IF NOT EXISTS application_variable (
  name VARCHAR(255) NOT NULL DEFAULT '',
  value VARCHAR(255) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS banners (
  bannerid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  campaignid MEDIUMINT(9) NOT NULL DEFAULT '0',
  active ENUM('t','f') NOT NULL DEFAULT 't',
  contenttype ENUM('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') NOT NULL DEFAULT 'gif',
  pluginversion MEDIUMINT(9) NOT NULL DEFAULT '0',
  storagetype ENUM('sql','web','url','html','network','txt') NOT NULL DEFAULT 'sql',
  filename VARCHAR(255) NOT NULL DEFAULT '',
  imageurl VARCHAR(255) NOT NULL DEFAULT '',
  htmltemplate TEXT NOT NULL,
  htmlcache TEXT NOT NULL,
  width SMALLINT(6) NOT NULL DEFAULT '0',
  height SMALLINT(6) NOT NULL DEFAULT '0',
  weight TINYINT(4) NOT NULL DEFAULT '1',
  seq TINYINT(4) NOT NULL DEFAULT '0',
  target VARCHAR(16) NOT NULL DEFAULT '',
  url TEXT NOT NULL DEFAULT '',
  alt VARCHAR(255) NOT NULL DEFAULT '',
  status VARCHAR(255) NOT NULL DEFAULT '',
  bannertext TEXT NOT NULL,
  description VARCHAR(255) NOT NULL DEFAULT '',
  autohtml ENUM('t','f') NOT NULL DEFAULT 't',
  adserver VARCHAR(50) NOT NULL DEFAULT '',
  block INT(11) NOT NULL DEFAULT '0',
  capping INT(11) NOT NULL DEFAULT '0',
  session_capping INT(11) NOT NULL DEFAULT '0',
  compiledlimitation TEXT NOT NULL,
  acl_plugins TEXT DEFAULT '',
  append TEXT NOT NULL,
  appendtype TINYINT(4) NOT NULL DEFAULT '0',
  bannertype TINYINT(4) NOT NULL DEFAULT '0',
  alt_filename VARCHAR(255) NOT NULL DEFAULT '',
  alt_imageurl VARCHAR(255) NOT NULL DEFAULT '',
  alt_contenttype ENUM('gif','jpeg','png') NOT NULL DEFAULT 'gif',
  comments TEXT DEFAULT NULL,
  updated DATETIME NOT NULL,
  acls_updated datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (bannerid),
  INDEX campaignid (campaignid)
);

CREATE TABLE IF NOT EXISTS campaigns (
  campaignid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  campaignname VARCHAR(255) NOT NULL DEFAULT '',
  clientid MEDIUMINT(9) NOT NULL DEFAULT '0',
  views INT(11) DEFAULT '-1',
  clicks INT(11) DEFAULT '-1',
  conversions INT(11) DEFAULT '-1',
  expire DATE DEFAULT '0000-00-00',
  activate DATE DEFAULT '0000-00-00',
  active ENUM('t','f') NOT NULL DEFAULT 't',
  priority INT(11) NOT NULL DEFAULT '0',
  weight TINYINT(4) NOT NULL DEFAULT '1',
  target_impression INT(11) NOT NULL DEFAULT '0',
  target_click INT(11) NOT NULL DEFAULT '0',
  target_conversion INT(11) NOT NULL DEFAULT '0',
  anonymous ENUM('t','f') NOT NULL DEFAULT 'f',
  companion SMALLINT(1) DEFAULT '0',
  comments TEXT DEFAULT NULL,
  revenue DECIMAL(10,4) DEFAULT NULL,
  revenue_type SMALLINT DEFAULT NULL,
  updated DATETIME NOT NULL,
  block INT(11) NOT NULL DEFAULT '0',
  capping INT(11) NOT NULL DEFAULT '0',
  session_capping INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (campaignid),
  INDEX clientid (clientid)
);

CREATE TABLE IF NOT EXISTS campaigns_trackers (
  campaign_trackerid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  campaignid MEDIUMINT(9) NOT NULL DEFAULT '0',
  trackerid MEDIUMINT(9) NOT NULL DEFAULT '0',
  viewwindow MEDIUMINT(9) NOT NULL DEFAULT '0',
  clickwindow MEDIUMINT(9) NOT NULL DEFAULT '0',
  status SMALLINT(1) UNSIGNED NOT NULL DEFAULT '4',
  PRIMARY KEY (campaign_trackerid),
  INDEX campaignid (campaignid),
  INDEX trackerid (trackerid)
);

CREATE TABLE IF NOT EXISTS category (
  category_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NULL,
  PRIMARY KEY (category_id)
);

CREATE TABLE IF NOT EXISTS channel (
  channelid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  agencyid MEDIUMINT(9) NOT NULL DEFAULT '0',
  affiliateid MEDIUMINT(9) NOT NULL DEFAULT '0',
  name VARCHAR(255),
  description VARCHAR(255),
  compiledlimitation TEXT NOT NULL,
  acl_plugins TEXT DEFAULT '',
  active SMALLINT(1),
  comments TEXT DEFAULT NULL,
  updated DATETIME NOT NULL,
  acls_updated datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (channelid)
);

CREATE TABLE IF NOT EXISTS clients (
  clientid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  agencyid MEDIUMINT(9) NOT NULL DEFAULT '0',
  clientname VARCHAR(255) NOT NULL DEFAULT '',
  contact VARCHAR(255) DEFAULT NULL,
  email VARCHAR(64) NOT NULL DEFAULT '',
  clientusername VARCHAR(64) NOT NULL DEFAULT '',
  clientpassword VARCHAR(64) NOT NULL DEFAULT '',
  permissions MEDIUMINT(9) DEFAULT NULL,
  language VARCHAR(64) DEFAULT NULL,
  report ENUM('t','f') NOT NULL DEFAULT 't',
  reportinterval MEDIUMINT(9) NOT NULL DEFAULT '7',
  reportlastdate DATE NOT NULL DEFAULT '0000-00-00',
  reportdeactivate ENUM('t','f') NOT NULL DEFAULT 't',
  comments TEXT DEFAULT NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (clientid),
  INDEX agencyid (agencyid)
);

CREATE TABLE IF NOT EXISTS data_intermediate_ad (
  data_intermediate_ad_id BIGINT NOT NULL AUTO_INCREMENT,
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  requests INTEGER UNSIGNED NOT NULL DEFAULT 0,
  impressions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  clicks INTEGER UNSIGNED NOT NULL DEFAULT 0,
  conversions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  total_basket_value DECIMAL(10,4) NOT NULL DEFAULT 0,
  total_num_items INTEGER NOT NULL DEFAULT 0,
  updated DATETIME NOT NULL,
  PRIMARY KEY (data_intermediate_ad_id),
  INDEX data_intermediate_ad_day (day),
  INDEX data_intermediate_ad_operation_interval_id (operation_interval_id),
  INDEX data_intermediate_ad_ad_id (ad_id),
  INDEX data_intermediate_ad_zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_intermediate_ad_connection (
  data_intermediate_ad_connection_id BIGINT NOT NULL AUTO_INCREMENT,
  server_raw_ip VARCHAR(16) NOT NULL,
  server_raw_tracker_impression_id BIGINT NOT NULL,
  viewer_id VARCHAR(32) NULL,
  viewer_session_id VARCHAR(32) NULL,
  tracker_date_time DATETIME NOT NULL,
  connection_date_time DATETIME NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  tracker_channel VARCHAR(255) NULL,
  connection_channel VARCHAR(255) NULL,
  tracker_channel_ids VARCHAR(64) NULL,
  connection_channel_ids VARCHAR(64) NULL,
  tracker_language VARCHAR(13) NULL,
  connection_language VARCHAR(13) NULL,
  tracker_ip_address VARCHAR(16) NULL,
  connection_ip_address VARCHAR(16) NULL,
  tracker_host_name VARCHAR(255) NULL,
  connection_host_name VARCHAR(255) NULL,
  tracker_country CHAR(2) NULL,
  connection_country CHAR(2) NULL,
  tracker_https INTEGER UNSIGNED NULL,
  connection_https INTEGER UNSIGNED NULL,
  tracker_domain VARCHAR(255) NULL,
  connection_domain VARCHAR(255) NULL,
  tracker_page VARCHAR(255) NULL,
  connection_page VARCHAR(255) NULL,
  tracker_query VARCHAR(255) NULL,
  connection_query VARCHAR(255) NULL,
  tracker_referer VARCHAR(255) NULL,
  connection_referer VARCHAR(255) NULL,
  tracker_search_term VARCHAR(255) NULL,
  connection_search_term VARCHAR(255) NULL,
  tracker_user_agent VARCHAR(255) NULL,
  connection_user_agent VARCHAR(255) NULL,
  tracker_os VARCHAR(32) NULL,
  connection_os VARCHAR(32) NULL,
  tracker_browser VARCHAR(32) NULL,
  connection_browser VARCHAR(32) NULL,
  connection_action INTEGER UNSIGNED NULL,
  connection_window INTEGER UNSIGNED NULL,
  connection_status INTEGER UNSIGNED NOT NULL DEFAULT 4,
  inside_window TINYINT(1) NOT NULL DEFAULT '0',
  comments TEXT DEFAULT NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (data_intermediate_ad_connection_id),
  INDEX data_intermediate_ad_connection_tracker_date_time (tracker_date_time),
  INDEX data_intermediate_ad_connection_tracker_id (tracker_id),
  INDEX data_intermediate_ad_connection_ad_id (ad_id),
  INDEX data_intermediate_ad_connection_zone_id (zone_id),
  INDEX data_intermediate_ad_connection_viewer_id (viewer_id)
);

CREATE TABLE IF NOT EXISTS data_intermediate_ad_variable_value (
  data_intermediate_ad_variable_value_id BIGINT NOT NULL AUTO_INCREMENT,
  data_intermediate_ad_connection_id BIGINT NOT NULL,
  tracker_variable_id INTEGER NOT NULL,
  value VARCHAR(50) NULL,
  PRIMARY KEY (data_intermediate_ad_variable_value_id),
  INDEX data_intermediate_ad_connection_id (data_intermediate_ad_connection_id),
  INDEX data_intermediate_ad_variable_value_tracker_variable_id (tracker_variable_id),
  INDEX data_intermediate_ad_variable_value_tracker_value (value)
);

-- SPLIT TABLE data_raw_ad_click

CREATE TABLE IF NOT EXISTS data_raw_ad_click (
  viewer_id VARCHAR(32) NULL,
  viewer_session_id VARCHAR(32) NULL,
  date_time DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  channel VARCHAR(255) NULL,
  channel_ids VARCHAR(64) NULL,
  language VARCHAR(32) NULL,
  ip_address VARCHAR(16) NULL,
  host_name VARCHAR(255) NULL,
  country CHAR(2) NULL,
  https BOOL NULL,
  domain VARCHAR(255) NULL,
  page VARCHAR(255) NULL,
  query VARCHAR(255) NULL,
  referer VARCHAR(255) NULL,
  search_term VARCHAR(255) NULL,
  user_agent VARCHAR(255) NULL,
  os VARCHAR(32) NULL,
  browser VARCHAR(32) NULL,
  max_https BOOL NULL,
  geo_region VARCHAR(50) NULL,
  geo_city VARCHAR(50) NULL,
  geo_postal_code VARCHAR(10) NULL,
  geo_latitude decimal(8,4) NULL,
  geo_longitude decimal(8,4) NULL,
  geo_dma_code VARCHAR(50) NULL,
  geo_area_code VARCHAR(50) NULL,
  geo_organisation VARCHAR(50) NULL,
  geo_netspeed VARCHAR(20) NULL,
  geo_continent VARCHAR(13) NULL,
  INDEX data_raw_ad_click_viewer_id (viewer_id),
  INDEX data_raw_ad_click_date_time (date_time),
  INDEX data_raw_ad_click_ad_id (ad_id),
  INDEX data_raw_ad_click_zone_id (zone_id)
);

-- SPLIT TABLE data_raw_ad_impression

CREATE TABLE IF NOT EXISTS data_raw_ad_impression (
  viewer_id VARCHAR(32) NULL,
  viewer_session_id VARCHAR(32) NULL,
  date_time DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  channel VARCHAR(255) NULL,
  channel_ids VARCHAR(64) NULL,
  language VARCHAR(32) NULL,
  ip_address VARCHAR(16) NULL,
  host_name VARCHAR(255) NULL,
  country CHAR(2) NULL,
  https BOOL NULL,
  domain VARCHAR(255) NULL,
  page VARCHAR(255) NULL,
  query VARCHAR(255) NULL,
  referer VARCHAR(255) NULL,
  search_term VARCHAR(255) NULL,
  user_agent VARCHAR(255) NULL,
  os VARCHAR(32) NULL,
  browser VARCHAR(32) NULL,
  max_https BOOL NULL,
  geo_region VARCHAR(50) NULL,
  geo_city VARCHAR(50) NULL,
  geo_postal_code VARCHAR(10) NULL,
  geo_latitude decimal(8,4) NULL,
  geo_longitude decimal(8,4) NULL,
  geo_dma_code VARCHAR(50) NULL,
  geo_area_code VARCHAR(50) NULL,
  geo_organisation VARCHAR(50) NULL,
  geo_netspeed VARCHAR(20) NULL,
  geo_continent VARCHAR(13) NULL,
  INDEX data_raw_ad_impression_viewer_id (viewer_id),
  INDEX data_raw_ad_impression_date_time (date_time),
  INDEX data_raw_ad_impression_ad_id (ad_id),
  INDEX data_raw_ad_impression_zone_id (zone_id)
);

-- SPLIT TABLE data_raw_ad_request

CREATE TABLE IF NOT EXISTS data_raw_ad_request (
  viewer_id VARCHAR(32) NULL,
  viewer_session_id VARCHAR(32) NULL,
  date_time DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  channel VARCHAR(255) NULL,
  channel_ids VARCHAR(64) NULL,
  language VARCHAR(32) NULL,
  ip_address VARCHAR(16) NULL,
  host_name VARCHAR(255) NULL,
  country CHAR(2) NULL,
  https BOOL NULL,
  domain VARCHAR(255) NULL,
  page VARCHAR(255) NULL,
  query VARCHAR(255) NULL,
  referer VARCHAR(255) NULL,
  search_term VARCHAR(255) NULL,
  user_agent VARCHAR(255) NULL,
  os VARCHAR(32) NULL,
  browser VARCHAR(32) NULL,
  max_https BOOL NULL,
  geo_region VARCHAR(50) NULL,
  geo_city VARCHAR(50) NULL,
  geo_postal_code VARCHAR(10) NULL,
  geo_latitude DECIMAL(8,4) NULL,
  geo_longitude DECIMAL(8,4) NULL,
  geo_dma_code VARCHAR(50) NULL,
  geo_area_code VARCHAR(50) NULL,
  geo_organisation VARCHAR(50) NULL,
  geo_netspeed VARCHAR(20) NULL,
  geo_continent VARCHAR(13) NULL,
  INDEX data_raw_ad_request_viewer_id (viewer_id),
  INDEX data_raw_ad_request_date_time (date_time),
  INDEX data_raw_ad_request_ad_id (ad_id),
  INDEX data_raw_ad_request_zone_id (zone_id)
);

-- SPLIT TABLE data_raw_tracker_click

CREATE TABLE IF NOT EXISTS data_raw_tracker_click (
  viewer_id VARCHAR(32) NULL,
  viewer_session_id VARCHAR(32) NOT NULL,
  date_time DATETIME NOT NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  channel VARCHAR(255) NULL,
  channel_ids VARCHAR(64) NULL,
  language VARCHAR(32) NULL,
  ip_address VARCHAR(16) NULL,
  host_name VARCHAR(255) NULL,
  country CHAR(2) NULL,
  https BOOL NULL,
  domain VARCHAR(255) NULL,
  page VARCHAR(255) NULL,
  query VARCHAR(255) NULL,
  referer VARCHAR(255) NULL,
  search_term VARCHAR(255) NULL,
  user_agent VARCHAR(255) NULL,
  os VARCHAR(32) NULL,
  browser VARCHAR(32) NULL,
  max_https BOOL NULL,
  geo_region VARCHAR(50) NULL,
  geo_city VARCHAR(50) NULL,
  geo_postal_code VARCHAR(10) NULL,
  geo_latitude decimal(8,4) NULL,
  geo_longitude decimal(8,4) NULL,
  geo_dma_code VARCHAR(50) NULL,
  geo_area_code VARCHAR(50) NULL,
  geo_organisation VARCHAR(50) NULL,
  geo_netspeed VARCHAR(20) NULL,
  geo_continent VARCHAR(13) NULL,
  INDEX data_raw_tracker_click_viewer_id (viewer_id),
  INDEX data_raw_tracker_click_date_time (date_time)
);

-- SPLIT TABLE data_raw_tracker_impression

CREATE TABLE IF NOT EXISTS data_raw_tracker_impression (
  server_raw_tracker_impression_id BIGINT NOT NULL AUTO_INCREMENT,
  server_raw_ip VARCHAR(16) NOT NULL,
  viewer_id VARCHAR(32) NOT NULL,
  viewer_session_id VARCHAR(32) NULL,
  date_time DATETIME NOT NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  channel VARCHAR(255) NULL,
  channel_ids VARCHAR(64) NULL,
  language VARCHAR(32) NULL,
  ip_address VARCHAR(16) NULL,
  host_name VARCHAR(255) NULL,
  country CHAR(2) NULL,
  https INTEGER UNSIGNED NULL,
  domain VARCHAR(255) NULL,
  page VARCHAR(255) NULL,
  query VARCHAR(255) NULL,
  referer VARCHAR(255) NULL,
  search_term VARCHAR(255) NULL,
  user_agent VARCHAR(255) NULL,
  os VARCHAR(32) NULL,
  browser VARCHAR(32) NULL,
  max_https INTEGER UNSIGNED NULL,
  geo_region VARCHAR(50) NULL,
  geo_city VARCHAR(50) NULL,
  geo_postal_code VARCHAR(10) NULL,
  geo_latitude decimal(8,4) NULL,
  geo_longitude decimal(8,4) NULL,
  geo_dma_code VARCHAR(50) NULL,
  geo_area_code VARCHAR(50) NULL,
  geo_organisation VARCHAR(50) NULL,
  geo_netspeed VARCHAR(20) NULL,
  geo_continent VARCHAR(13) NULL,
  PRIMARY KEY (server_raw_tracker_impression_id,server_raw_ip),
  INDEX data_raw_tracker_impression_viewer_id (viewer_id),
  INDEX data_raw_tracker_impression_date_time (date_time)
);

-- SPLIT TABLE data_raw_tracker_variable_value

CREATE TABLE IF NOT EXISTS data_raw_tracker_variable_value (
  server_raw_tracker_impression_id BIGINT NOT NULL,
  server_raw_ip VARCHAR(16) NOT NULL,
  tracker_variable_id INTEGER NOT NULL,
  date_time DATETIME NULL,
  value VARCHAR(50) NULL,
  PRIMARY KEY (server_raw_tracker_impression_id,server_raw_ip,tracker_variable_id)
);

CREATE TABLE IF NOT EXISTS data_summary_ad_hourly (
  data_summary_ad_hourly_id BIGINT NOT NULL AUTO_INCREMENT,
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  creative_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  requests INTEGER UNSIGNED NOT NULL DEFAULT 0,
  impressions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  clicks INTEGER UNSIGNED NOT NULL DEFAULT 0,
  conversions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  total_basket_value DECIMAL(10,4) NULL,
  total_num_items INTEGER NULL,
  total_revenue DECIMAL(10,4) NULL,
  total_cost DECIMAL(10,4) NULL,
  total_techcost DECIMAL(10,4) NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (data_summary_ad_hourly_id),
  INDEX data_summary_ad_hourly_day (day),
  INDEX data_summary_ad_hourly_hour (hour),
  INDEX data_summary_ad_hourly_ad_id (ad_id),
  INDEX data_summary_ad_hourly_zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_ad_zone_assoc (
  data_summary_ad_zone_assoc_id BIGINT NOT NULL AUTO_INCREMENT,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  required_impressions INTEGER UNSIGNED NOT NULL,
  requested_impressions INTEGER UNSIGNED NOT NULL,
  priority DOUBLE NOT NULL,
  priority_factor DOUBLE NULL,
  priority_factor_limited SMALLINT NOT NULL DEFAULT 0,
  past_zone_traffic_fraction DOUBLE NULL,
  created DATETIME NOT NULL,
  created_by INTEGER UNSIGNED NOT NULL,
  expired DATETIME NULL,
  expired_by INTEGER UNSIGNED NULL,
  PRIMARY KEY (data_summary_ad_zone_assoc_id),
  INDEX data_summary_ad_zone_assoc_interval_start (interval_start),
  INDEX data_summary_ad_zone_assoc_interval_end (interval_end),
  INDEX data_summary_ad_zone_assoc_ad_id (ad_id),
  INDEX data_summary_ad_zone_assoc_zone_id (zone_id),
  INDEX expired (expired)
);

CREATE TABLE IF NOT EXISTS data_summary_channel_daily (
  data_summary_channel_daily_id BIGINT NOT NULL AUTO_INCREMENT,
  day DATE NOT NULL,
  channel_id INTEGER UNSIGNED NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  forecast_impressions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  actual_impressions INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (data_summary_channel_daily_id),
  INDEX data_summary_channel_daily_day (day),
  INDEX data_summary_channel_daily_channel_id (channel_id),
  INDEX data_summary_channel_daily_zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_impression_history (
  data_summary_zone_impression_history_id BIGINT NOT NULL AUTO_INCREMENT,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  forecast_impressions INTEGER UNSIGNED NULL,
  actual_impressions INTEGER UNSIGNED NULL,
  PRIMARY KEY (data_summary_zone_impression_history_id),
  INDEX data_summary_zone_impression_history_operation_interval_id (operation_interval_id),
  INDEX data_summary_zone_impression_history_zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_domain_page_daily (
  data_summary_zone_domain_page_daily_id BIGINT(20) NOT NULL auto_increment,
  day date NOT NULL DEFAULT '0000-00-00',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  domain VARCHAR(255) DEFAULT NULL,
  page VARCHAR(255) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_domain_page_daily_id),
  INDEX day (day),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_country_daily (
  data_summary_zone_country_daily_id bigint(20) NOT NULL auto_increment,
  day date NOT NULL DEFAULT '0000-00-00',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  country CHAR(2) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_country_daily_id),
  INDEX day (day),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_source_daily (
  data_summary_zone_source_daily_id bigint(20) NOT NULL auto_increment,
  day date NOT NULL DEFAULT '0000-00-00',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  source VARCHAR(255) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_source_daily_id),
  INDEX day (day),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_site_keyword_daily (
  data_summary_zone_site_keyword_daily_id bigint(20) NOT NULL auto_increment,
  day date NOT NULL DEFAULT '0000-00-00',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  site VARCHAR(255) DEFAULT NULL,
  keyword VARCHAR(255) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_site_keyword_daily_id),
  INDEX day (day),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_domain_page_monthly (
  data_summary_zone_domain_page_monthly_id bigint(20) NOT NULL auto_increment,
  yearmonth mediumint(6) NOT NULL DEFAULT '0',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  domain VARCHAR(255) DEFAULT NULL,
  page VARCHAR(255) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_domain_page_monthly_id),
  INDEX yearmonth (yearmonth),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_country_monthly (
  data_summary_zone_country_monthly_id bigint(20) NOT NULL auto_increment,
  yearmonth mediumint(6) NOT NULL DEFAULT '0',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  country CHAR(2) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_country_monthly_id),
  INDEX yearmonth (yearmonth),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_source_monthly (
  data_summary_zone_source_monthly_id bigint(20) NOT NULL auto_increment,
  yearmonth mediumint(6) NOT NULL DEFAULT '0',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  source VARCHAR(255) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_source_monthly_id),
  INDEX yearmonth (yearmonth),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_site_keyword_monthly (
  data_summary_zone_site_keyword_monthly_id bigint(20) NOT NULL auto_increment,
  yearmonth mediumint(6) NOT NULL DEFAULT '0',
  zone_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  site VARCHAR(255) DEFAULT NULL,
  keyword VARCHAR(255) DEFAULT NULL,
  impressions INT(10) UNSIGNED DEFAULT NULL,
  clicks INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (data_summary_zone_site_keyword_monthly_id),
  INDEX yearmonth (yearmonth),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_domain_page_forecast (
  data_summary_zone_domain_page_forecast_id BIGINT NOT NULL AUTO_INCREMENT,
  day_of_week SMALLINT NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  domain VARCHAR(255) NULL,
  page VARCHAR(255) NULL,
  impressions INTEGER UNSIGNED NULL,
  PRIMARY KEY (data_summary_zone_domain_page_forecast_id),
  INDEX day_of_week (day_of_week),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_country_forecast (
  data_summary_zone_country_forecast_id BIGINT NOT NULL AUTO_INCREMENT,
  day_of_week SMALLINT NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  country VARCHAR(2) NULL,
  impressions INTEGER UNSIGNED NULL,
  PRIMARY KEY (data_summary_zone_country_forecast_id),
  INDEX day_of_week (day_of_week),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_source_forecast (
  data_summary_zone_source_forecast_id BIGINT NOT NULL AUTO_INCREMENT,
  day_of_week SMALLINT NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  source VARCHAR(255) NULL,
  impressions INTEGER UNSIGNED NULL,
  PRIMARY KEY (data_summary_zone_source_forecast_id),
  INDEX day_of_week (day_of_week),
  INDEX zone_id (zone_id)
);

CREATE TABLE IF NOT EXISTS data_summary_zone_site_keyword_forecast (
  data_summary_zone_site_keyword_forecast_id BIGINT NOT NULL AUTO_INCREMENT,
  day_of_week SMALLINT NOT NULL,
  zone_id INTEGER UNSIGNED NOT NULL,
  site VARCHAR(255) NULL,
  keyword VARCHAR(255) NULL,
  impressions INTEGER UNSIGNED NULL,
  PRIMARY KEY (data_summary_zone_site_keyword_forecast_id),
  INDEX day_of_week (day_of_week),
  INDEX zone_id (zone_id)
);


CREATE TABLE IF NOT EXISTS images (
  filename VARCHAR(128) NOT NULL DEFAULT '',
  contents MEDIUMBLOB NOT NULL,
  t_stamp TIMESTAMP(14) NOT NULL,
  PRIMARY KEY (filename)
);

CREATE TABLE IF NOT EXISTS log_maintenance_forecasting (
  log_maintenance_forecasting_id INT NOT NULL AUTO_INCREMENT,
  start_run datetime NOT NULL,
  end_run datetime NOT NULL,
  operation_interval INT NOT NULL,
  duration INT NOT NULL,
  updated_to datetime NULL,
  PRIMARY KEY (log_maintenance_forecasting_id)
);

CREATE TABLE IF NOT EXISTS log_maintenance_priority (
  log_maintenance_priority_id INT NOT NULL AUTO_INCREMENT,
  start_run datetime NOT NULL,
  end_run datetime NOT NULL,
  operation_interval INT NOT NULL,
  duration INT NOT NULL,
  run_type TINYINT UNSIGNED NOT NULL,
  updated_to datetime NULL,
  PRIMARY KEY (log_maintenance_priority_id)
);

CREATE TABLE IF NOT EXISTS log_maintenance_statistics (
  log_maintenance_statistics_id INT NOT NULL AUTO_INCREMENT,
  start_run DATETIME NOT NULL,
  end_run DATETIME NOT NULL,
  duration INT NOT NULL,
  adserver_run_type INT(2) NULL,
  search_run_type INT(2) NULL,
  tracker_run_type INT(2) NULL,
  updated_to DATETIME NULL,
  PRIMARY KEY (log_maintenance_statistics_id)
);

CREATE TABLE IF NOT EXISTS password_recovery (
  user_type VARCHAR(64) NOT NULL,
  user_id INT(10) NOT NULL,
  recovery_id VARCHAR(64) NOT NULL,
  updated DATETIME NOT NULL,
  PRIMARY KEY (user_type, user_id),
  UNIQUE (recovery_id)
);

CREATE TABLE IF NOT EXISTS placement_zone_assoc (
  placement_zone_assoc_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  zone_id MEDIUMINT(9) DEFAULT NULL,
  placement_id MEDIUMINT(9) DEFAULT NULL,
  PRIMARY KEY (placement_zone_assoc_id),
  INDEX zone_id (zone_id),
  INDEX placement_id (placement_id)
);

CREATE TABLE IF NOT EXISTS plugins_channel_delivery_assoc (
  rule_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  domain_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
  rule_order TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (rule_id,domain_id),
  INDEX domain_id (domain_id),
  INDEX rule_id (rule_id),
  INDEX rule_order (rule_order)
);

CREATE TABLE IF NOT EXISTS plugins_channel_delivery_domains (
  domain_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  domain_name VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (domain_id),
  INDEX domain_name (domain_name(100))
);

CREATE TABLE IF NOT EXISTS plugins_channel_delivery_rules (
  rule_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  modifier VARCHAR(100) NOT NULL DEFAULT '',
  client VARCHAR(100) NOT NULL DEFAULT '',
  rule text NOT NULL,
  PRIMARY KEY (rule_id)
);

CREATE TABLE IF NOT EXISTS preference (
  agencyid MEDIUMINT(9) NOT NULL DEFAULT '0',
  config_version decimal(7,3) NOT NULL DEFAULT '0.000',
  my_header VARCHAR(255) DEFAULT NULL,
  my_footer VARCHAR(255) DEFAULT NULL,
  my_logo VARCHAR(255) DEFAULT NULL,
  language VARCHAR(32) DEFAULT 'english',
  name VARCHAR(32) DEFAULT NULL,
  company_name VARCHAR(255) DEFAULT 'mysite.com',
  override_gd_imageformat VARCHAR(4) DEFAULT NULL,
  begin_of_week TINYINT(2) DEFAULT '1',
  percentage_decimals TINYINT(2) DEFAULT '2',
  type_sql_allow ENUM('t','f') DEFAULT 't',
  type_url_allow ENUM('t','f') DEFAULT 't',
  type_web_allow ENUM('t','f') DEFAULT 'f',
  type_html_allow ENUM('t','f') DEFAULT 't',
  type_txt_allow ENUM('t','f') DEFAULT 't',
  banner_html_auto ENUM('t','f') DEFAULT 't',
  admin VARCHAR(64) DEFAULT 'phpadsuser',
  admin_pw VARCHAR(64) DEFAULT 'phpadspass',
  admin_fullname VARCHAR(255) DEFAULT 'Your Name',
  admin_email VARCHAR(64) DEFAULT 'your@email.com',
  warn_admin ENUM('t','f') DEFAULT 't',
  warn_agency ENUM('t','f') DEFAULT 't',
  warn_client ENUM('t','f') DEFAULT 't',
  warn_limit MEDIUMINT(9) NOT NULL DEFAULT '100',
  admin_email_headers VARCHAR(64) DEFAULT NULL,
  admin_novice ENUM('t','f') DEFAULT 't',
  default_banner_weight TINYINT(4) DEFAULT '1',
  default_campaign_weight TINYINT(4) DEFAULT '1',
  default_banner_url VARCHAR(255) DEFAULT NULL,
  default_banner_destination VARCHAR(255) DEFAULT NULL,
  client_welcome ENUM('t','f') DEFAULT 't',
  client_welcome_msg TEXT,
  publisher_welcome ENUM('t','f') DEFAULT 't',
  publisher_welcome_msg TEXT,
  content_gzip_compression ENUM('t','f') DEFAULT 'f',
  userlog_email ENUM('t','f') DEFAULT 't',
  gui_show_campaign_info ENUM('t','f') DEFAULT 't',
  gui_show_campaign_preview ENUM('t','f') DEFAULT 'f',
  gui_campaign_anonymous ENUM('t','f') DEFAULT 'f',
  gui_show_banner_info ENUM('t','f') DEFAULT 't',
  gui_show_banner_preview ENUM('t','f') DEFAULT 't',
  gui_show_banner_html ENUM('t','f') DEFAULT 'f',
  gui_show_matching ENUM('t','f') DEFAULT 't',
  gui_show_parents ENUM('t','f') DEFAULT 'f',
  gui_hide_inactive ENUM('t','f') DEFAULT 'f',
  gui_link_compact_limit INTEGER DEFAULT '50',
  gui_header_background_color VARCHAR(7) DEFAULT '',
  gui_header_foreground_color VARCHAR(7) DEFAULT '',
  gui_header_active_tab_color VARCHAR(7) DEFAULT '',
  gui_header_text_color VARCHAR(7) DEFAULT '',
  gui_invocation_3rdparty_default SMALLINT DEFAULT '0',
  qmail_patch ENUM('t','f') DEFAULT 'f',
  updates_enabled ENUM('t','f') DEFAULT 't',
  updates_cache TEXT,
  updates_timestamp INT(11) DEFAULT '0',
  updates_last_seen decimal(7,3),
  allow_invocation_plain ENUM('t','f') DEFAULT 'f',
  allow_invocation_plain_nocookies ENUM('t','f') DEFAULT 't',
  allow_invocation_js ENUM('t','f') DEFAULT 't',
  allow_invocation_frame ENUM('t','f') DEFAULT 'f',
  allow_invocation_xmlrpc ENUM('t','f') DEFAULT 'f',
  allow_invocation_local ENUM('t','f') DEFAULT 't',
  allow_invocation_interstitial ENUM('t','f') DEFAULT 't',
  allow_invocation_popup ENUM('t','f') DEFAULT 't',
  allow_invocation_clickonly ENUM('t','f') DEFAULT 't',
  auto_clean_tables ENUM('t','f') DEFAULT 'f',
  auto_clean_tables_interval TINYINT(2) DEFAULT '5',
  auto_clean_userlog ENUM('t','f') DEFAULT 'f',
  auto_clean_userlog_interval TINYINT(2) DEFAULT '5',
  auto_clean_tables_vacuum ENUM('t','f') DEFAULT 't',
  autotarget_factor float DEFAULT '-1',
  maintenance_timestamp INT(11) DEFAULT '0',
  compact_stats ENUM('t','f') DEFAULT 't',
  statslastday DATE NOT NULL DEFAULT '0000-00-00',
  statslasthour TINYINT(4) NOT NULL DEFAULT '0',
  default_tracker_status TINYINT(4) NOT NULL DEFAULT '1',
  default_tracker_type INT(10) UNSIGNED DEFAULT '1',
  default_tracker_linkcampaigns ENUM('t','f') NOT NULL DEFAULT 'f',
  publisher_agreement ENUM('t','f') DEFAULT 'f',
  publisher_agreement_text TEXT,
  publisher_payment_modes TEXT,
  publisher_currencies TEXT,
  publisher_categories TEXT,
  publisher_help_files TEXT,
  publisher_default_tax_id ENUM('t','f') DEFAULT 'f',
  publisher_default_approved ENUM('t','f') DEFAULT 'f',
  more_reports VARCHAR(1) DEFAULT NULL,
  gui_column_id TEXT,
  gui_column_requests TEXT,
  gui_column_impressions TEXT,
  gui_column_clicks TEXT,
  gui_column_ctr TEXT,
  gui_column_conversions TEXT,
  gui_column_conversions_pending TEXT,
  gui_column_sr_views TEXT,
  gui_column_sr_clicks TEXT,
  gui_column_revenue TEXT,
  gui_column_cost TEXT,
  gui_column_bv TEXT,
  gui_column_num_items TEXT,
  gui_column_revcpc TEXT,
  gui_column_costcpc TEXT,
  gui_column_technology_cost TEXT,
  gui_column_income TEXT,
  gui_column_income_margin TEXT,
  gui_column_profit TEXT,
  gui_column_margin TEXT,
  gui_column_erpm TEXT,
  gui_column_erpc TEXT,
  gui_column_erps TEXT,
  gui_column_eipm TEXT,
  gui_column_eipc TEXT,
  gui_column_eips TEXT,
  gui_column_ecpm TEXT,
  gui_column_ecpc TEXT,
  gui_column_ecps TEXT,
  gui_column_epps TEXT,
  instance_id VARCHAR(64),
  ad_clicks_sum int(11) DEFAULT '0' NOT NULL,
  ad_views_sum int(11) DEFAULT '0' NOT NULL,
  ad_clicks_per_second float DEFAULT '0' NOT NULL,
  ad_views_per_second float DEFAULT '0' NOT NULL,
  ad_cs_data_last_sent DATE NULL,   
  ad_cs_data_last_received DATE NULL,   
  PRIMARY KEY (agencyid)
);

CREATE TABLE IF NOT EXISTS preference_advertiser (
  advertiser_id INT(11) NOT NULL,
  preference VARCHAR(255) NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY (advertiser_id, preference)
);

CREATE TABLE IF NOT EXISTS preference_publisher (
  publisher_id INT(11) NOT NULL,
  preference VARCHAR(255) NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY (publisher_id, preference)
);

CREATE TABLE IF NOT EXISTS session (
  sessionid VARCHAR(32) NOT NULL DEFAULT '',
  sessiondata TEXT NOT NULL,
  lastused TIMESTAMP(14) NOT NULL,
  PRIMARY KEY (sessionid)
);

CREATE TABLE IF NOT EXISTS targetstats (
  day date NOT NULL DEFAULT '0000-00-00',
  campaignid MEDIUMINT(9) NOT NULL DEFAULT '0',
  target INT(11) NOT NULL DEFAULT '0',
  views INT(11) NOT NULL DEFAULT '0',
  modified TINYINT(4) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS trackers (
  trackerid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  trackername VARCHAR(255) NOT NULL DEFAULT '',
  description VARCHAR(255) NOT NULL DEFAULT '',
  clientid MEDIUMINT(9) NOT NULL DEFAULT '0',
  viewwindow MEDIUMINT(9) NOT NULL DEFAULT '0',
  clickwindow MEDIUMINT(9) NOT NULL DEFAULT '0',
  blockwindow MEDIUMINT(9) NOT NULL DEFAULT '0',
  status SMALLINT(1) UNSIGNED NOT NULL DEFAULT '4',
  type SMALLINT(1) UNSIGNED NOT NULL DEFAULT '1',
  linkcampaigns ENUM('t','f') NOT NULL DEFAULT 'f',
  variablemethod ENUM('default', 'js', 'dom', 'custom') NOT NULL DEFAULT 'default',
  appendcode TEXT NOT NULL DEFAULT '',
  updated DATETIME NOT NULL,
  PRIMARY KEY (trackerid),
  INDEX clientid (clientid)
);

CREATE TABLE IF NOT EXISTS tracker_append (
  tracker_append_id INT(11) NOT NULL AUTO_INCREMENT,
  tracker_id MEDIUMINT(9) NOT NULL DEFAULT '0',
  rank INT(11) NOT NULL DEFAULT '0',
  tagcode TEXT NOT NULL,
  paused ENUM('t','f') NOT NULL DEFAULT 'f',
  autotrack ENUM('t', 'f') NOT NULL DEFAULT 'f',
  PRIMARY KEY (tracker_append_id),
  KEY (tracker_id, rank)
);

CREATE TABLE IF NOT EXISTS userlog (
  userlogid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  timestamp INT(11) NOT NULL DEFAULT '0',
  usertype TINYINT(4) NOT NULL DEFAULT '0',
  userid MEDIUMINT(9) NOT NULL DEFAULT '0',
  action MEDIUMINT(9) NOT NULL DEFAULT '0',
  object MEDIUMINT(9) DEFAULT NULL,
  details MEDIUMTEXT,
  PRIMARY KEY (userlogid)
);

CREATE TABLE IF NOT EXISTS variables (
  variableid MEDIUMINT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  trackerid MEDIUMINT(9) NOT NULL DEFAULT '0',
  name VARCHAR(250) NOT NULL DEFAULT '',
  description VARCHAR(250) DEFAULT NULL,
  datatype ENUM('numeric','string', 'date') NOT NULL DEFAULT 'numeric',
  purpose ENUM('basket_value', 'num_items', 'post_code'),
  reject_if_empty SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
  is_unique INTEGER NOT NULL DEFAULT 0,
  unique_window INTEGER NOT NULL DEFAULT '0',
  variablecode VARCHAR(255) NOT NULL DEFAULT '',
  hidden ENUM('t','f') NOT NULL DEFAULT 'f',
  updated DATETIME NOT NULL,
  PRIMARY KEY (variableid),
  INDEX variables_is_unique (is_unique),
  INDEX trackerid (trackerid)
);

CREATE TABLE IF NOT EXISTS variable_publisher (
  variable_id INT(11) NOT NULL,
  publisher_id INT(11) NOT NULL,
  visible TINYINT(1) NOT NULL,
  PRIMARY KEY (variable_id, publisher_id)
);

CREATE TABLE IF NOT EXISTS zones (
  zoneid MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
  affiliateid MEDIUMINT(9) DEFAULT NULL,
  zonename VARCHAR(245) NOT NULL DEFAULT '',
  description VARCHAR(255) NOT NULL DEFAULT '',
  delivery SMALLINT(6) NOT NULL DEFAULT '0',
  zonetype SMALLINT(6) NOT NULL DEFAULT '0',
  category TEXT NOT NULL,
  width SMALLINT(6) NOT NULL DEFAULT '0',
  height SMALLINT(6) NOT NULL DEFAULT '0',
  ad_selection TEXT NOT NULL DEFAULT '',
  chain TEXT NOT NULL,
  prepend TEXT NOT NULL,
  append TEXT NOT NULL,
  appendtype TINYINT(4) NOT NULL DEFAULT '0',
  forceappend ENUM('t','f') DEFAULT 'f',
  inventory_forecast_type SMALLINT(6) NOT NULL DEFAULT '0',
  comments TEXT DEFAULT NULL,
  cost DECIMAL(10,4) DEFAULT NULL,
  cost_type SMALLINT DEFAULT NULL,
  cost_variable_id VARCHAR(255) DEFAULT NULL,
  technology_cost DECIMAL(10,4) DEFAULT NULL,
  technology_cost_type SMALLINT DEFAULT NULL,
  updated DATETIME NOT NULL,
  block INT(11) NOT NULL DEFAULT '0',
  capping INT(11) NOT NULL DEFAULT '0',
  session_capping INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (zoneid),
  INDEX zonenameid (zonename,zoneid),
  INDEX affiliateid (affiliateid)
);
