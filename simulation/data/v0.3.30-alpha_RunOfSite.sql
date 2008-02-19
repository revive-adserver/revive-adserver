-- Host: localhost
-- Generation Time: Nov 06, 2006 at 12:31 PM
-- Server version: 5.0.22
-- PHP Version: 5.1.6
--
-- v0.3.30-alpha RoS Publisher with 1 banner and no impression history
-- impressions=1000
-- revenue=£10
-- priority lvl=High(5)
-- distribution=100(per day)
-- [priority] instantUpdate = 1 so priority was calced immediately
--
TRUNCATE TABLE data_intermediate_ad;
TRUNCATE TABLE data_intermediate_ad_connection;
TRUNCATE TABLE data_intermediate_ad_variable_value;
TRUNCATE TABLE data_raw_ad_click;
TRUNCATE TABLE data_raw_ad_impression;
TRUNCATE TABLE data_raw_ad_request;
TRUNCATE TABLE data_raw_tracker_click;
TRUNCATE TABLE data_raw_tracker_impression;
TRUNCATE TABLE data_raw_tracker_variable_value;
TRUNCATE TABLE data_summary_ad_hourly;
TRUNCATE TABLE data_summary_ad_zone_assoc;
TRUNCATE TABLE data_summary_channel_daily;
TRUNCATE TABLE data_summary_zone_country_daily;
TRUNCATE TABLE data_summary_zone_country_forecast;
TRUNCATE TABLE data_summary_zone_country_monthly;
TRUNCATE TABLE data_summary_zone_domain_page_daily;
TRUNCATE TABLE data_summary_zone_domain_page_forecast;
TRUNCATE TABLE data_summary_zone_domain_page_monthly;
TRUNCATE TABLE data_summary_zone_impression_history;
TRUNCATE TABLE data_summary_zone_site_keyword_daily;
TRUNCATE TABLE data_summary_zone_site_keyword_forecast;
TRUNCATE TABLE data_summary_zone_site_keyword_monthly;
TRUNCATE TABLE data_summary_zone_source_daily;
TRUNCATE TABLE data_summary_zone_source_forecast;
TRUNCATE TABLE data_summary_zone_source_monthly;
TRUNCATE TABLE log_maintenance_forecasting;
TRUNCATE TABLE log_maintenance_priority;
TRUNCATE TABLE log_maintenance_statistics;

INSERT INTO log_maintenance_statistics (log_maintenance_statistics_id, start_run, end_run, duration, adserver_run_type, search_run_type, tracker_run_type, updated_to) VALUES (1, '2000-01-01 01:01:00', '2000-01-01 01:00:00', 0, 2, NULL, NULL, '2000-01-01 01:00:00');

TRUNCATE TABLE ad_zone_assoc;
INSERT INTO ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type) VALUES (1, 0, 1, 0, 0);
INSERT INTO ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type) VALUES (2, 1, 1, 0.8, 1);
TRUNCATE TABLE affiliates;
INSERT INTO affiliates (affiliateid, agencyid, name, mnemonic, comments, contact, email, website, username, password, permissions, language, publiczones, last_accepted_agency_agreement, updated) VALUES (1, 0, 'RunOfSite_Publisher', 'ROS', '', 'Monique Szpak', 'monique@m3.net', 'http://www.openx.org', NULL, '', 0, '', 'f', NULL, '2006-11-06 11:49:36');
TRUNCATE TABLE  affiliates_extra;
INSERT INTO affiliates_extra (affiliateid, address, city, postcode, country, phone, fax, account_contact, payee_name, tax_id, mode_of_payment, currency, unique_users, unique_views, page_rank, category, help_file) VALUES (1, '', '', '', '', '', '', '', '', '', 'Cheque by post', 'GBP', 0, 0, 0, '', '');
TRUNCATE TABLE  banners;
INSERT INTO banners (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannertext, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, acl_plugins, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, comments, updated, acls_updated) VALUES (1, 1, 't', '', 0, 'html', '', '', 'ROS Publisher Banner No. 1', 'ROS Publisher Banner No. 1', 468, 60, 1, 0, '_blank', 'http://m3.net', '', '', '', 'HTML Banner 1', 't', '', 0, 0, 0, '', NULL, '', 0, 0, '', '', '', '', '2006-11-06 12:00:21', '2000-01-01 00:00:00');
TRUNCATE TABLE  campaigns;
INSERT INTO campaigns (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active, priority, weight, target_impression, target_click, target_conversion, anonymous, companion, comments, revenue, revenue_type, updated) VALUES (1, 'ROS Test Advertiser - Default Campaign', 1, 1000, -1, -1, '2000-01-01', '2000-01-01', 't', 5, 0, 100, 0, 0, 'f', 0, '', 10.0000, 1, '2006-11-06 11:57:30');
TRUNCATE TABLE  clients;
INSERT INTO clients (clientid, agencyid, clientname, contact, email, clientusername, clientpassword, permissions, language, report, reportinterval, reportlastdate, reportdeactivate, comments, updated) VALUES (1, 0, 'ROS Test Advertiser', 'Monique Szpak', 'monique@m3.net', '', '', 0, '', 'f', 7, '2006-11-06', 't', '', '2006-11-06 11:54:51');
TRUNCATE TABLE log_maintenance_priority;
INSERT INTO log_maintenance_priority (log_maintenance_priority_id, start_run, end_run, operation_interval, duration, run_type, updated_to) VALUES (1, '2006-11-06 12:00:21', '2006-11-06 12:00:21', 60, 0, 0, '2006-11-06 12:59:59');
INSERT INTO log_maintenance_priority (log_maintenance_priority_id, start_run, end_run, operation_interval, duration, run_type, updated_to) VALUES (2, '2006-11-06 12:00:21', '2006-11-06 12:00:21', 60, 0, 1, NULL);
INSERT INTO log_maintenance_priority (log_maintenance_priority_id, start_run, end_run, operation_interval, duration, run_type, updated_to) VALUES (3, '2006-11-06 12:00:55', '2006-11-06 12:00:56', 60, 1, 0, '2006-11-06 12:59:59');
INSERT INTO log_maintenance_priority (log_maintenance_priority_id, start_run, end_run, operation_interval, duration, run_type, updated_to) VALUES (4, '2006-11-06 12:00:56', '2006-11-06 12:00:56', 60, 0, 1, NULL);
TRUNCATE TABLE zones;
INSERT INTO zones (zoneid, affiliateid, zonename, description, delivery, zonetype, category, width, height, ad_selection, chain, prepend, append, appendtype, forceappend, inventory_forecast_type, comments, cost, cost_type, cost_variable_id, technology_cost, technology_cost_type, updated, block, capping, session_capping) VALUES (1, 1, 'RunOfSite_Publisher - 468 x 60', 'RoS Banner', 0, 3, '', 468, 60, '', '', '', '', 0, 'f', 0, '', 0.0000, 0, NULL, NULL, NULL, '2006-11-06 11:51:49', 0, 0, 0);