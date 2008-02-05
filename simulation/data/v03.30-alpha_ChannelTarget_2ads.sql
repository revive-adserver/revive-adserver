-- phpMyAdmin SQL Dump
-- version 2.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2006 at 04:12 PM
-- Server version: 5.0.22
-- PHP Version: 5.1.6
--
-- Database: max03trunk
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

TRUNCATE TABLE acls;
INSERT INTO acls (bannerid, logical, type, comparison, data, executionorder) VALUES (2, 'and', 'Site:Channel', '==', '2', 0);

TRUNCATE TABLE acls_channel;
INSERT INTO acls_channel (channelid, logical, type, comparison, data, executionorder) VALUES (2, 'and', 'Site:Pageurl', '=~', 'www.example.com', 0);

TRUNCATE TABLE ad_zone_assoc;
INSERT INTO ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type) VALUES (3, 0, 2, 0, 0),
(4, 1, 2, 0.5, 1),
(5, 0, 3, 0, 0),
(6, 1, 3, 0.5, 1);

TRUNCATE TABLE affiliates;
INSERT INTO affiliates (affiliateid, agencyid, name, mnemonic, comments, contact, email, website, username, password, permissions, language, publiczones, last_accepted_agency_agreement, updated) VALUES (1, 0, 'RunOfSite_Publisher', 'ROS', '', 'Monique Szpak', 'monique@m3.net', 'http://www.openx.org', 'publisher', '52aded165360352a0f5857571d96d68f', 383, '', 'f', '2000-01-01 00:00:00', '2006-11-10 11:15:51');

TRUNCATE TABLE affiliates_extra;
INSERT INTO affiliates_extra (affiliateid, address, city, postcode, country, phone, fax, account_contact, payee_name, tax_id, mode_of_payment, currency, unique_users, unique_views, page_rank, category, help_file) VALUES (1, '', '', '', '', '', '', '', '', '', 'Cheque by post', 'GBP', 0, 0, 0, '', '');


TRUNCATE TABLE banners;
INSERT INTO banners (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannertext, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, acl_plugins, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, comments, updated, acls_updated) VALUES (2, 2, 't', '', 0, 'html', '', '', 'this is a test', 'this is a test', 468, 60, 1, 0, '_blank', '', '', '', '', '', 't', '', 0, 0, 0, '(MAX_checkSite_Channel(''2'', ''=='', $source))', 'Site:Channel', '', 0, 0, '', '', '', '', '2006-11-10 14:00:10', '2006-11-10 11:19:56'),
(3, 3, 't', '', 0, 'html', '', '', 'TEST 2', 'TEST 2', 468, 60, 1, 0, '_blank', '', '', '', '', '', 't', '', 0, 0, 0, '', NULL, '', 0, 0, '', '', '', '', '2006-11-10 15:44:34', '2000-01-01 00:00:00');

TRUNCATE TABLE campaigns;
INSERT INTO campaigns (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active, priority, weight, target_impression, target_click, target_conversion, anonymous, companion, comments, revenue, revenue_type, updated) VALUES (2, 'ROS Test Advertiser - Default Campaign', 1, 23000, -1, -1, '2000-01-01', '2000-01-01', 't', 10, 0, 100, 0, 0, 'f', 0, '', 0.0000, 0, '2006-11-10 15:43:10'),
(3, 'ROS Test Advertiser - Default Campaign2', 1, 23000, -1, -1, '2000-01-01', '2000-01-01', 't', 10, 0, 100, 0, 0, 'f', 0, '', 0.0000, 0, '2006-11-10 15:44:01');

TRUNCATE TABLE channel;
INSERT INTO channel (channelid, agencyid, affiliateid, name, description, compiledlimitation, acl_plugins, active, comments, acls_updated) VALUES (1, 0, 1, 'Test Channel - page url', '', 'true', '', 1, '', '2000-01-01 00:00:00'),
(2, 0, 0, 'test 2 channel - page url', '', 'MAX_checkSite_Pageurl(''www.example.com'', ''=~'')', 'Site:Pageurl', 1, '', '2006-11-10 11:19:18');

TRUNCATE TABLE clients;
INSERT INTO clients (clientid, agencyid, clientname, contact, email, clientusername, clientpassword, permissions, language, report, reportinterval, reportlastdate, reportdeactivate, comments, updated) VALUES (1, 0, 'ROS Test Advertiser', 'Monique Szpak', 'monique@m3.net', '', '', 0, '', 'f', 7, '2006-11-06', 't', '', '2006-11-06 11:54:51');

TRUNCATE TABLE placement_zone_assoc;
INSERT INTO placement_zone_assoc (placement_zone_assoc_id, zone_id, placement_id) VALUES (1, 1, 2);

TRUNCATE TABLE preference;
INSERT INTO preference (agencyid, config_version, my_header, my_footer, my_logo, language, name, company_name, override_gd_imageformat, begin_of_week, percentage_decimals, type_sql_allow, type_url_allow, type_web_allow, type_html_allow, type_txt_allow, banner_html_auto, admin, admin_pw, admin_fullname, admin_email, warn_admin, warn_agency, warn_client, warn_limit, admin_email_headers, admin_novice, default_banner_weight, default_campaign_weight, default_banner_url, default_banner_destination, client_welcome, client_welcome_msg, publisher_welcome, publisher_welcome_msg, content_gzip_compression, userlog_email, gui_show_campaign_info, gui_show_campaign_preview, gui_campaign_anonymous, gui_show_banner_info, gui_show_banner_preview, gui_show_banner_html, gui_show_matching, gui_show_parents, gui_hide_inactive, gui_link_compact_limit, gui_header_background_color, gui_header_foreground_color, gui_header_active_tab_color, gui_header_text_color, gui_invocation_3rdparty_default, qmail_patch, updates_enabled, updates_cache, updates_timestamp, updates_last_seen, allow_invocation_plain, allow_invocation_plain_nocookies, allow_invocation_js, allow_invocation_frame, allow_invocation_xmlrpc, allow_invocation_local, allow_invocation_interstitial, allow_invocation_popup, allow_invocation_clickonly, auto_clean_tables, auto_clean_tables_interval, auto_clean_userlog, auto_clean_userlog_interval, auto_clean_tables_vacuum, autotarget_factor, maintenance_timestamp, compact_stats, statslastday, statslasthour, default_tracker_status, default_tracker_type, default_tracker_linkcampaigns, publisher_agreement, publisher_agreement_text, publisher_payment_modes, publisher_currencies, publisher_categories, publisher_help_files, publisher_default_tax_id, publisher_default_approved, more_reports, gui_column_id, gui_column_requests, gui_column_impressions, gui_column_clicks, gui_column_ctr, gui_column_conversions, gui_column_conversions_pending, gui_column_sr_views, gui_column_sr_clicks, gui_column_revenue, gui_column_cost, gui_column_bv, gui_column_num_items, gui_column_revcpc, gui_column_costcpc, gui_column_technology_cost, gui_column_income, gui_column_income_margin, gui_column_profit, gui_column_margin, gui_column_erpm, gui_column_erpc, gui_column_erps, gui_column_eipm, gui_column_eipc, gui_column_eips, gui_column_ecpm, gui_column_ecpc, gui_column_ecps, gui_column_epps, instance_id) VALUES (0, 0.300, NULL, NULL, NULL, 'english', NULL, 'mysite.com', NULL, 1, 2, 't', 't', 'f', 't', 't', 't', 'root', '21232f297a57a5a743894a0e4a801fc3', 'Your Name', 'your@email.com', 't', 't', 't', 100, NULL, 't', 1, 1, NULL, NULL, 't', NULL, 't', NULL, 'f', 't', 't', 'f', 'f', 't', 't', 'f', 't', 'f', 'f', 50, '', '', '', '', 0, 'f', 't', NULL, 0, NULL, 'f', 't', 't', 'f', 'f', 't', 't', 't', 't', 'f', 5, 'f', 5, 't', -1, 1163156815, 't', '2000-01-01', 0, 1, 1, 'f', 'f', NULL, NULL, NULL, NULL, NULL, 'f', 'f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

TRUNCATE TABLE zones;
INSERT INTO zones (zoneid, affiliateid, zonename, description, delivery, zonetype, category, width, height, ad_selection, chain, prepend, append, appendtype, forceappend, inventory_forecast_type, comments, cost, cost_type, cost_variable_id, technology_cost, technology_cost_type, updated, block, capping, session_capping) VALUES (1, 1, 'RunOfSite_Publisher - 468 x 60', 'RoS Banner', 0, 3, '', 468, 60, '', '', '', '', 0, 'f', 0, '', 0.0000, 0, NULL, NULL, NULL, '2006-11-06 11:51:49', 0, 0, 0);