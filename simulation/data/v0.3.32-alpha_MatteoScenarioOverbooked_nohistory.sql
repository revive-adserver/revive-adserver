


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

TRUNCATE TABLE ad_zone_assoc;
INSERT INTO ad_zone_assoc (ad_zone_assoc_id, zone_id, ad_id, priority, link_type) VALUES
(10, 2, 4, 0, 1),
(2, 0, 2, 0, 0),
(3, 0, 3, 0, 0),
(4, 0, 4, 0, 0),
(9, 2, 3, 0, 1),
(6, 1, 2, 0, 1),
(7, 1, 3, 0, 1),
(8, 1, 4, 0, 1);

TRUNCATE TABLE affiliates;
INSERT INTO affiliates (affiliateid, agencyid, name, mnemonic, comments, contact, email, website, username, password, permissions, language, publiczones, last_accepted_agency_agreement, updated) VALUES
(1, 0, 'Matteo', '', '', 'Matteo', 'matteo@beccati.com', 'http://beccati.com', '', '', 0, '', 'f', '2000-01-01 00:00:00', '2007-02-06 16:54:38');

TRUNCATE TABLE application_variable;
INSERT INTO application_variable (name, value) VALUES
('max_version', 'v0.3.32-alpha');

TRUNCATE TABLE banners;
INSERT INTO banners (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannertext, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, acl_plugins, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, comments, updated, acls_updated) VALUES
(2, 2, 't', 'txt', 0, 'txt', '', '', '', '', 0, 0, 1, 0, '', 'http://beccati.com/', '', '', 'High (7) 600 impressions target', 'High (7) 600 impressions target', 'f', '', 0, 0, 0, '', NULL, '', 0, 0, '', '', '', '', '2007-02-09 12:45:00', '2000-01-01 00:00:00'),
(3, 3, 't', 'txt', 0, 'txt', '', '', '', '', 0, 0, 1, 0, '', 'http://beccati.com/', '', '', 'High (5) 600 impressions target', 'High (5) 600 impressions target', 'f', '', 0, 0, 0, 'true', '', '', 0, 0, '', '', '', '', '2007-02-09 12:46:04', '2007-02-09 12:46:13'),
(4, 4, 't', 'txt', 0, 'txt', '', '', '', '', 0, 0, 1, 0, '', 'http://beccati.com/', '', '', 'Low pri', 'Low pri', 'f', '', 0, 0, 0, '', NULL, '', 0, 0, '', '', '', '', '2007-02-06 16:54:03', '2000-01-01 00:00:00');

TRUNCATE TABLE campaigns;
INSERT INTO campaigns (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active, priority, weight, target_impression, target_click, target_conversion, anonymous, companion, comments, revenue, revenue_type, updated, block, capping, session_capping) VALUES
(2, 'Matteo - High (7) 600 impressions target', 1, -1, -1, -1, '2000-01-01', '2000-01-01', 't', 7, 0, 600, 0, 0, 'f', 0, '', 0.0000, 0, '2007-02-09 12:45:26', 0, 0, 0),
(3, 'Matteo - High (5) 600 impressions target', 1, -1, -1, -1, '2000-01-01', '2000-01-01', 't', 5, 0, 600, 0, 0, 'f', 0, '', 0.0000, 0, '2007-02-09 12:45:50', 0, 0, 0),
(4, 'Matteo - Low pri', 1, -1, -1, -1, '2000-01-01', '2000-01-01', 't', 0, 1, 0, 0, 0, 'f', 0, '', 0.0000, 0, '2007-02-09 12:46:39', 0, 0, 0);

TRUNCATE TABLE clients;
INSERT INTO clients (clientid, agencyid, clientname, contact, email, clientusername, clientpassword, permissions, language, report, reportinterval, reportlastdate, reportdeactivate, comments, updated) VALUES
(1, 0, 'Matteo', 'Matteo', 'matteo@beccati.com', '', '', 0, '', 'f', 7, '2007-02-06', 't', '', '2007-02-06 16:48:58');

TRUNCATE TABLE placement_zone_assoc;
INSERT INTO placement_zone_assoc (placement_zone_assoc_id, zone_id, placement_id) VALUES
(5, 2, 3),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(6, 2, 4);

TRUNCATE TABLE preference;
INSERT INTO preference (agencyid, config_version, my_header, my_footer, my_logo, language, name, company_name, override_gd_imageformat, begin_of_week, percentage_decimals, type_sql_allow, type_url_allow, type_web_allow, type_html_allow, type_txt_allow, banner_html_auto, admin, admin_pw, admin_fullname, admin_email, warn_admin, warn_agency, warn_client, warn_limit, admin_email_headers, admin_novice, default_banner_weight, default_campaign_weight, default_banner_url, default_banner_destination, client_welcome, client_welcome_msg, publisher_welcome, publisher_welcome_msg, content_gzip_compression, userlog_email, gui_show_campaign_info, gui_show_campaign_preview, gui_campaign_anonymous, gui_show_banner_info, gui_show_banner_preview, gui_show_banner_html, gui_show_matching, gui_show_parents, gui_hide_inactive, gui_link_compact_limit, gui_header_background_color, gui_header_foreground_color, gui_header_active_tab_color, gui_header_text_color, gui_invocation_3rdparty_default, qmail_patch, updates_enabled, updates_cache, updates_timestamp, updates_last_seen, allow_invocation_plain, allow_invocation_plain_nocookies, allow_invocation_js, allow_invocation_frame, allow_invocation_xmlrpc, allow_invocation_local, allow_invocation_interstitial, allow_invocation_popup, allow_invocation_clickonly, auto_clean_tables, auto_clean_tables_interval, auto_clean_userlog, auto_clean_userlog_interval, auto_clean_tables_vacuum, autotarget_factor, maintenance_timestamp, compact_stats, statslastday, statslasthour, default_tracker_status, default_tracker_type, default_tracker_linkcampaigns, publisher_agreement, publisher_agreement_text, publisher_payment_modes, publisher_currencies, publisher_categories, publisher_help_files, publisher_default_tax_id, publisher_default_approved, more_reports, gui_column_id, gui_column_requests, gui_column_impressions, gui_column_clicks, gui_column_ctr, gui_column_conversions, gui_column_conversions_pending, gui_column_sr_views, gui_column_sr_clicks, gui_column_revenue, gui_column_cost, gui_column_bv, gui_column_num_items, gui_column_revcpc, gui_column_costcpc, gui_column_technology_cost, gui_column_income, gui_column_income_margin, gui_column_profit, gui_column_margin, gui_column_erpm, gui_column_erpc, gui_column_erps, gui_column_eipm, gui_column_eipc, gui_column_eips, gui_column_ecpm, gui_column_ecpc, gui_column_ecps, gui_column_epps, instance_id) VALUES
(0, 0.300, NULL, NULL, NULL, 'english', NULL, 'mysite.com', NULL, 1, 2, 't', 't', 'f', 't', 't', 't', 'matteo', '6f8f57715090da2632453988d9a1501b', 'Your Name', 'your@email.com', 't', 't', 't', 100, NULL, 't', 1, 1, NULL, NULL, 't', NULL, 't', NULL, 'f', 't', 't', 'f', 'f', 't', 't', 'f', 't', 'f', 'f', 50, '', '', '', '', 0, 'f', 't', NULL, 0, NULL, 'f', 't', 't', 'f', 'f', 't', 't', 't', 't', 'f', 5, 'f', 5, 't', -1, 1171021456, 't', '2000-01-01', 0, 1, 1, 'f', 'f', NULL, NULL, NULL, NULL, NULL, 'f', 'f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f23cf2a81b87869793d1385d119f805d6c60c87c');

TRUNCATE TABLE zones;
INSERT INTO zones (zoneid, affiliateid, zonename, description, delivery, zonetype, category, width, height, ad_selection, chain, prepend, append, appendtype, forceappend, inventory_forecast_type, comments, cost, cost_type, cost_variable_id, technology_cost, technology_cost_type, updated, block, capping, session_capping) VALUES
(1, 1, 'Matteo - Default', '', 3, 3, '', 0, 0, '', '', '', '', 0, 'f', 0, '', 0.0000, 0, NULL, NULL, NULL, '2007-02-06 16:54:44', 0, 0, 0),
(2, 1, 'Matteo - Zone 2', '', 3, 3, '', 0, 0, '', '', '', '', 0, 'f', 0, '', 0.0000, 0, NULL, 0.0000, NULL, '2007-02-09 12:47:11', 0, 0, 0);
