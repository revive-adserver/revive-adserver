CREATE TEMPORARY TABLE IF NOT EXISTS tmp_ad_request (
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NULL,
  creative_id INTEGER UNSIGNED NULL,
  zone_id INTEGER UNSIGNED NULL,
  requests INTEGER UNSIGNED NULL DEFAULT 0
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_ad_impression (
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NULL,
  creative_id INTEGER UNSIGNED NULL,
  zone_id INTEGER UNSIGNED NULL,
  impressions INTEGER UNSIGNED NULL DEFAULT 0
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_ad_click (
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ad_id INTEGER UNSIGNED NULL,
  creative_id INTEGER UNSIGNED NULL,
  zone_id INTEGER UNSIGNED NULL,
  clicks INTEGER UNSIGNED NULL DEFAULT 0
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_tracker_impression_ad_impression_connection (
  server_raw_tracker_impression_id BIGINT NOT NULL,
  server_raw_ip VARCHAR(16) NOT NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  campaign_id INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  viewer_id VARCHAR(32) NOT NULL,
  date_time DATETIME NOT NULL,
  connection_action INTEGER UNSIGNED NOT NULL,
  connection_window INTEGER UNSIGNED NOT NULL,
  connection_status INTEGER UNSIGNED NOT NULL
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_tracker_impression_ad_impression_connection_cookieless (
  server_raw_tracker_impression_id BIGINT NOT NULL,
  server_raw_ip VARCHAR(16) NOT NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  campaign_id INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ip_address VARCHAR(16) NOT NULL,
  user_agent VARCHAR(255) NOT NULL,
  date_time DATETIME NOT NULL,
  connection_action INTEGER UNSIGNED NOT NULL,
  connection_window INTEGER UNSIGNED NOT NULL,
  connection_status INTEGER UNSIGNED NOT NULL,
  INDEX ip_address (ip_address),
  INDEX user_agent (user_agent)
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_tracker_impression_ad_click_connection (
  server_raw_tracker_impression_id BIGINT NOT NULL,
  server_raw_ip VARCHAR(16) NOT NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  campaign_id INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  viewer_id VARCHAR(32) NOT NULL,
  date_time DATETIME NOT NULL,
  connection_action INTEGER UNSIGNED NOT NULL,
  connection_window INTEGER UNSIGNED NOT NULL,
  connection_status INTEGER UNSIGNED NOT NULL
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_tracker_impression_ad_click_connection_cookieless (
  server_raw_tracker_impression_id BIGINT NOT NULL,
  server_raw_ip VARCHAR(16) NOT NULL,
  tracker_id INTEGER UNSIGNED NOT NULL,
  campaign_id INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NOT NULL,
  operation_interval_id INTEGER UNSIGNED NOT NULL,
  interval_start DATETIME NOT NULL,
  interval_end DATETIME NOT NULL,
  ip_address VARCHAR(16) NOT NULL,
  user_agent VARCHAR(255) NOT NULL,
  date_time DATETIME NOT NULL,
  connection_action INTEGER UNSIGNED NOT NULL,
  connection_window INTEGER UNSIGNED NOT NULL,
  connection_status INTEGER UNSIGNED NOT NULL,
  INDEX ip_address (ip_address),
  INDEX user_agent (user_agent)
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_ad_connection (
  server_raw_tracker_impression_id BIGINT NOT NULL,
  server_raw_ip VARCHAR(16) NOT NULL,
  date_time DATETIME NULL,
  operation_interval INTEGER UNSIGNED NULL,
  operation_interval_id INTEGER UNSIGNED NULL,
  interval_start DATETIME NULL,
  interval_end DATETIME NULL,
  connection_viewer_id VARCHAR(32) NULL,
  connection_viewer_session_id VARCHAR(32) NULL,
  connection_date_time DATETIME NULL,
  connection_ad_id INTEGER UNSIGNED NULL,
  connection_creative_id INTEGER UNSIGNED NULL,
  connection_zone_id INTEGER UNSIGNED NULL,
  connection_channel VARCHAR(51) NULL,
  connection_language VARCHAR(32) NULL,
  connection_ip_address VARCHAR(16) NULL,
  connection_host_name TEXT NULL,
  connection_country CHAR(2) NULL,
  connection_https INTEGER UNSIGNED NULL,
  connection_domain VARCHAR(255) NULL,
  connection_page VARCHAR(255) NULL,
  connection_query VARCHAR(255) NULL,
  connection_referer VARCHAR(255) NULL,
  connection_search_term VARCHAR(255) NULL,
  connection_user_agent VARCHAR(255) NULL,
  connection_os VARCHAR(32) NULL,
  connection_browser VARCHAR(32) NULL,
  connection_action INTEGER UNSIGNED NULL,
  connection_window INTEGER UNSIGNED NULL,
  connection_status INTEGER UNSIGNED NOT NULL,
  inside_window TINYINT(1) NOT NULL,
  latest INTEGER UNSIGNED NULL DEFAULT 0
);

CREATE TEMPORARY TABLE IF NOT EXISTS tmp_conversions (
  data_intermediate_ad_connection_id BIGINT NOT NULL,
  day DATE NOT NULL,
  hour INTEGER UNSIGNED NOT NULL,
  operation_interval INTEGER UNSIGNED NULL,
  operation_interval_id INTEGER UNSIGNED NULL,
  interval_start DATETIME NULL,
  interval_end DATETIME NULL,
  ad_id INTEGER UNSIGNED NULL,
  creative_id INTEGER UNSIGNED NULL,
  zone_id INTEGER UNSIGNED NULL,
  basket_value DECIMAL(10,4) NULL,
  num_items DECIMAL(10,4) NULL
);