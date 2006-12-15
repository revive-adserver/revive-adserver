<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: TestOfStatisticsAdServermysql.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

/**
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

define('DATA_RAW_AD_IMPRESSIONS', 'INSERT INTO
    data_raw_ad_impression
        (date_time)
    VALUES
        (\'2004-06-06 18:22:10\'),
        (\'2004-05-06 12:34:56\'),
        (\'2004-06-06 18:22:11\')');

define('LMS_HOUR', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, adserver_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 1, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:15:00\', \'2004-06-06 10:16:15\', 75, 1, \'2004-06-06 10:15:00\')');

define('LMS_OI', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, adserver_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 0, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:16:00\', \'2004-06-06 10:16:15\', 15, 0, \'2004-06-06 10:16:00\')');

define('LMS_DUAL', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, adserver_run_type, updated_to)
    VALUES
        (\'2004-06-07 01:15:00\', \'2004-06-07 01:16:15\', 75, 2, \'2004-06-07 01:15:00\')');



define('SUMMARISE_AD_REQUESTS', 'INSERT INTO
    data_raw_ad_request
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-06-06 18:22:10\'),
        (1, 1, \'2004-05-06 12:34:56\'),
        (1, 1, \'2004-06-06 18:22:11\')');



define('SUMMARISE_AD_IMPRESSIONS', 'INSERT INTO
    data_raw_ad_impression
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-06-06 18:22:10\'),
        (1, 1, \'2004-05-06 12:34:56\'),
        (1, 1, \'2004-06-06 18:22:11\')');



define('SUMMARISE_AD_CLICKS', 'INSERT INTO
    data_raw_ad_click
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-06-06 18:22:10\'),
        (1, 1, \'2004-05-06 12:34:56\'),
        (1, 1, \'2004-06-06 18:22:11\')');



define('SUMMARISE_CONVERSIONS_BANNERS', 'INSERT INTO
    banners
        (bannerid, description, campaignid)
    VALUES
        (1, \'Banner 1 - Campaign 1\', 1),
        (2, \'Banner 2 - Campaign 1\', 1),
        (3, \'Banner 3 - Campaign 2\', 2),
        (4, \'Banner 4 - Campaign 2\', 2)');

// Campaign 1 <-> Tracker 1, with impressions/click windows  0/0  days, not conversions
// Campaign 1 <-> Tracker 2, with impressions/click windows 30/30 days, not conversions
// Campaign 2 <-> Tracker 3, with impressions/click windows 30/30 days, are conversions
define('SUMMARISE_CONVERSIONS_CAMPAIGNS_TRACKERS', 'INSERT INTO
    campaigns_trackers
        (campaignid, trackerid, status, viewwindow, clickwindow)
    VALUES
        (1, 1, 0, 0, 0),
        (1, 2, 0, 2592000, 2592000),
        (2, 3, 4, 2592000, 2592000)');

define('SUMMARISE_CONVERSIONS_AD_IMPRESSIONS', 'INSERT INTO
    data_raw_ad_impression
        (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id,
         channel, language, ip_address, host_name, country, https, domain, page,
         query, referer, search_term, user_agent, os, browser)
    VALUES
        (\'aa\', 0, \'2004-06-06 18:22:10\', 1, 0, 0, \'chan1\', \'en1\', \'127.0.0.1\', \'localhost1\',
         \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'referer1\', \'term1\', \'agent1\', \'linux1\',
         \'mozilla1\'),
        (\'aa\', 0, \'2004-05-06 12:34:56\', 2, 0, 0, \'chan2\', \'en2\', \'127.0.0.2\', \'localhost2\',
         \'U2\', 0, \'domain2\', \'page2\', \'query2\', \'referer2\', \'term2\', \'agent2\', \'linux2\',
         \'mozilla2\'),
        (\'aa\', 0, \'2004-06-06 18:22:11\', 3, 0, 0, \'chan3\', \'en3\', \'127.0.0.3\', \'localhost3\',
         \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'referer3\', \'term3\', \'agent3\', \'linux3\',
         \'mozilla3\'),
        (\'aa\', 0, \'2004-06-06 18:22:12\', 4, 0, 0, \'chan4\', \'en4\', \'127.0.0.4\', \'localhost4\',
         \'U4\', 0, \'domain4\', \'page4\', \'query4\', \'referer4\', \'term4\', \'agent4\', \'linux4\',
         \'mozilla4\')');

define('SUMMARISE_CONVERSIONS_AD_CLICKS', 'INSERT INTO
    data_raw_ad_click
        (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id,
         channel, language, ip_address, host_name, country, https, domain, page,
         query, referer, search_term, user_agent, os, browser)
    VALUES
        (\'aa\', 0, \'2004-06-06 18:22:10\', 1, 0, 0, \'chan1\', \'en1\', \'127.0.0.1\', \'localhost1\',
         \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'referer1\', \'term1\', \'agent1\', \'linux1\',
         \'mozilla1\'),
        (\'aa\', 0, \'2004-05-06 12:34:56\', 2, 0, 0, \'chan2\', \'en2\', \'127.0.0.2\', \'localhost2\',
         \'U2\', 0, \'domain2\', \'page2\', \'query2\', \'referer2\', \'term2\', \'agent2\', \'linux2\',
         \'mozilla2\'),
        (\'aa\', 0, \'2004-06-06 18:22:11\', 3, 0, 0, \'chan3\', \'en3\', \'127.0.0.3\', \'localhost3\',
         \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'referer3\', \'term3\', \'agent3\', \'linux3\',
         \'mozilla3\'),
        (\'aa\', 0, \'2004-06-06 18:22:12\', 4, 0, 0, \'chan4\', \'en4\', \'127.0.0.4\', \'localhost4\',
         \'U4\', 0, \'domain4\', \'page4\', \'query4\', \'referer4\', \'term4\', \'agent4\', \'linux4\',
         \'mozilla4\')');

define('SUMMARISE_CONVERSIONS_TRACKER_IMPRESSIONS', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, date_time, tracker_id)
    VALUES
        (1, \'singleDB\', \'aa\', \'2004-06-06 18:22:15\', 1),
        (2, \'singleDB\', \'aa\', \'2004-05-06 12:35:00\', 2),
        (3, \'singleDB\', \'aa\', \'2004-06-06 18:22:15\', 3),
        (4, \'singleDB\', \'aa\', \'2004-06-06 18:22:15\', 4)');



define('SAVE_INTERMEDIATE_AD_REQUESTS', 'INSERT INTO
    tmp_ad_request
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, requests)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         2, 2, 2, 2)');

define('SAVE_INTERMEDIATE_AD_IMPRESSIONS', 'INSERT INTO
    tmp_ad_impression
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         2, 2, 2, 2)');

define('SAVE_INTERMEDIATE_AD_CLICKS', 'INSERT INTO
    tmp_ad_click
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, clicks)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         2, 2, 2, 2),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         3, 3, 3, 1)');

define('SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_6', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:30\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\')');

define('SAVE_INTERMEDIATE_CONNECTIONS_TEST_6', 'INSERT INTO
    tmp_ad_connection
        (server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
         operation_interval_id, interval_start, interval_end, connection_viewer_id,
         connection_viewer_session_id, connection_date_time, connection_ad_id,
         connection_creative_id, connection_zone_id, connection_channel, connection_language,
         connection_ip_address, connection_host_name, connection_country, connection_https,
         connection_domain, connection_page, connection_query, connection_referer,
         connection_search_term, connection_user_agent, connection_os, connection_browser,
         connection_action, connection_window, connection_status, inside_window, latest)
    VALUES
        (2, \'127.0.0.1\', \'2004-06-06 18:10:30\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0)');

define('SAVE_INTERMEDIATE_VARIABLES_TEST_7', 'INSERT INTO
    variables
        (variableid, trackerid)
    VALUES
        (1, 1)');

define('SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_7', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:30\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\')');

define('SAVE_INTERMEDIATE_CONNECTIONS_TEST_7', 'INSERT INTO
    tmp_ad_connection
        (server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
         operation_interval_id, interval_start, interval_end, connection_viewer_id,
         connection_viewer_session_id, connection_date_time, connection_ad_id,
         connection_creative_id, connection_zone_id, connection_channel, connection_language,
         connection_ip_address, connection_host_name, connection_country, connection_https,
         connection_domain, connection_page, connection_query, connection_referer,
         connection_search_term, connection_user_agent, connection_os, connection_browser,
         connection_action, connection_window, connection_status, inside_window, latest)
    VALUES
        (2, \'127.0.0.1\', \'2004-06-06 18:10:30\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0)');

define('SAVE_INTERMEDIATE_VARIABLES_TEST_8', 'INSERT INTO
    variables
        (variableid, trackerid)
    VALUES
        (1, 1)');

define('SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_8', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:30\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\')');

define('SAVE_INTERMEDIATE_CONNECTIONS_TEST_8', 'INSERT INTO
    tmp_ad_connection
        (server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
         operation_interval_id, interval_start, interval_end, connection_viewer_id,
         connection_viewer_session_id, connection_date_time, connection_ad_id,
         connection_creative_id, connection_zone_id, connection_channel, connection_language,
         connection_ip_address, connection_host_name, connection_country, connection_https,
         connection_domain, connection_page, connection_query, connection_referer,
         connection_search_term, connection_user_agent, connection_os, connection_browser,
         connection_action, connection_window, connection_status, inside_window, latest)
    VALUES
        (2, \'127.0.0.1\', \'2004-06-06 18:10:30\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0)');

define('SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TEST_8', 'INSERT INTO
    data_raw_tracker_variable_value
        (server_raw_tracker_impression_id, server_raw_ip, tracker_variable_id, date_time, value)
    VALUES
        (1, \'127.0.0.1\', 1, \'2004-06-06 18:10:16\', \'1\'),
        (2, \'127.0.0.1\', 1, \'2004-06-06 18:10:31\', \'2\')');

define('SAVE_INTERMEDIATE_VARIABLES_TEST_9', 'INSERT INTO
    variables
        (variableid, trackerid, purpose)
    VALUES
        (1, 1, \'basket_value\')');

define('SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_9', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:30\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\')');

define('SAVE_INTERMEDIATE_CONNECTIONS_TEST_9', 'INSERT INTO
    tmp_ad_connection
        (server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
         operation_interval_id, interval_start, interval_end, connection_viewer_id,
         connection_viewer_session_id, connection_date_time, connection_ad_id,
         connection_creative_id, connection_zone_id, connection_channel, connection_language,
         connection_ip_address, connection_host_name, connection_country, connection_https,
         connection_domain, connection_page, connection_query, connection_referer,
         connection_search_term, connection_user_agent, connection_os, connection_browser,
         connection_action, connection_window, connection_status, inside_window, latest)
    VALUES
        (2, \'127.0.0.1\', \'2004-06-06 18:10:30\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0)');

define('SAVE_INTERMEDIATE_VARIABLES_TEST_10', 'INSERT INTO
    variables
        (variableid, trackerid, purpose)
    VALUES
        (1, 1, \'basket_value\')');

define('SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_10', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:30\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\')');

define('SAVE_INTERMEDIATE_CONNECTIONS_TEST_10', 'INSERT INTO
    tmp_ad_connection
        (server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
         operation_interval_id, interval_start, interval_end, connection_viewer_id,
         connection_viewer_session_id, connection_date_time, connection_ad_id,
         connection_creative_id, connection_zone_id, connection_channel, connection_language,
         connection_ip_address, connection_host_name, connection_country, connection_https,
         connection_domain, connection_page, connection_query, connection_referer,
         connection_search_term, connection_user_agent, connection_os, connection_browser,
         connection_action, connection_window, connection_status, inside_window, latest)
    VALUES
        (2, \'127.0.0.1\', \'2004-06-06 18:10:30\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0)');

define('SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TEST_10', 'INSERT INTO
    data_raw_tracker_variable_value
        (server_raw_tracker_impression_id, server_raw_ip, tracker_variable_id, date_time, value)
    VALUES
        (1, \'127.0.0.1\', 1, \'2004-06-06 18:10:16\', \'1\'),
        (2, \'127.0.0.1\', 1, \'2004-06-06 18:10:31\', \'2\')');

// Tracker 1: 1x Non-Basket Non-Items Variable
// Tracker 2: 1x Basket Variable
// Tracker 3: 2x Non-Basket Non-Items Variables
// Tracker 4: 1x Non-Basket Variable & 1x Basket Variable
// Tracker 5: 2x Basket Variables
// Tracker 6: 1x Basket Variable & 1x Items Variable
// Tracker 7: 2x Items Variables
define('SAVE_INTERMEDIATE_VARIABLES_TEST_11', 'INSERT INTO
    variables
        (variableid, trackerid, purpose)
    VALUES
        ( 1, 1, NULL),
        ( 2, 2, \'basket_value\'),
        ( 3, 3, NULL),
        ( 4, 3, NULL),
        ( 5, 4, NULL),
        ( 6, 4, \'basket_value\'),
        ( 7, 5, \'basket_value\'),
        ( 8, 5, \'basket_value\'),
        ( 9, 6, \'basket_value\'),
        (10, 6, \'num_items\'),
        (11, 7, \'num_items\'),
        (12, 7, \'num_items\')');

define('SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_11', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 20, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:30\', 20, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (3, \'127.0.0.3\', \'cc\', 3, \'2004-06-06 18:10:33\', 1, \'tchan3\', \'ten3\',
         \'t127.0.0.3\', \'thost3\', \'T3\', 1, \'tdomain3\', \'tpage3\', \'tquery3\',
         \'tref3\', \'tterm3\', \'tagent3\', \'tlinux3\', \'tmozilla3\'),
        (4, \'127.0.0.3\', \'cc\', 3, \'2004-06-06 18:10:33\', 2, \'tchan3\', \'ten3\',
         \'t127.0.0.3\', \'thost3\', \'T3\', 1, \'tdomain3\', \'tpage3\', \'tquery3\',
         \'tref3\', \'tterm3\', \'tagent3\', \'tlinux3\', \'tmozilla3\'),
        (5, \'127.0.0.3\', \'cc\', 3, \'2004-06-06 18:10:33\', 2, \'tchan3\', \'ten3\',
         \'t127.0.0.3\', \'thost3\', \'T3\', 1, \'tdomain3\', \'tpage3\', \'tquery3\',
         \'tref3\', \'tterm3\', \'tagent3\', \'tlinux3\', \'tmozilla3\'),
        (6, \'127.0.0.6\', \'ff\', 6, \'2004-06-06 18:10:36\', 3, \'tchan6\', \'ten6\',
         \'t127.0.0.6\', \'thost6\', \'T6\', 1, \'tdomain6\', \'tpage6\', \'tquery6\',
         \'tref6\', \'tterm6\', \'tagent6\', \'tlinux6\', \'tmozilla6\'),
        (7, \'127.0.0.6\', \'ff\', 6, \'2004-06-06 18:10:36\', 4, \'tchan6\', \'ten6\',
         \'t127.0.0.6\', \'thost6\', \'T6\', 1, \'tdomain6\', \'tpage6\', \'tquery6\',
         \'tref6\', \'tterm6\', \'tagent6\', \'tlinux6\', \'tmozilla6\'),
        (8, \'127.0.0.8\', \'gg\', 8, \'2004-06-06 18:10:38\', 5, \'tchan8\', \'ten8\',
         \'t127.0.0.8\', \'thost8\', \'T8\', 1, \'tdomain8\', \'tpage8\', \'tquery8\',
         \'tref8\', \'tterm8\', \'tagent8\', \'tlinux8\', \'tmozilla8\'),
        (9, \'127.0.0.9\', \'hh\', 9, \'2004-06-06 18:10:39\', 6, \'tchan9\', \'ten9\',
         \'t127.0.0.9\', \'thost9\', \'T9\', 1, \'tdomain9\', \'tpage9\', \'tquery9\',
         \'tref9\', \'tterm9\', \'tagent9\', \'tlinux9\', \'tmozilla9\'),
        (10, \'127.0.0.10\', \'ii\', 10, \'2004-06-06 18:10:40\', 7, \'tchan10\', \'ten10\',
         \'t127.0.0.10\', \'thost10\', \'T1\', 1, \'tdomain10\', \'tpage10\', \'tquery10\',
         \'tref10\', \'tterm10\', \'tagent10\', \'tlinux10\', \'tmozilla10\')');

define('SAVE_INTERMEDIATE_CONNECTIONS_TEST_11', 'INSERT INTO
    tmp_ad_connection
        (server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
         operation_interval_id, interval_start, interval_end, connection_viewer_id,
         connection_viewer_session_id, connection_date_time, connection_ad_id,
         connection_creative_id, connection_zone_id, connection_channel, connection_language,
         connection_ip_address, connection_host_name, connection_country, connection_https,
         connection_domain, connection_page, connection_query, connection_referer,
         connection_search_term, connection_user_agent, connection_os, connection_browser,
         connection_action, connection_window, connection_status, inside_window, latest)
    VALUES
        (2, \'127.0.0.1\', \'2004-06-06 18:10:30\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (3, \'127.0.0.3\', \'2004-06-06 18:10:33\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'cc\', 3, \'2004-06-06 18:00:34\', 2, 2, 2, \'chan3\', \'en3\',
         \'127.0.0.3\', \'host3\', \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'ref3\',
         \'term3\', \'agent3\', \'linux3\', \'mozilla3\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (4, \'127.0.0.3\', \'2004-06-06 18:10:33\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'cc\', 3, \'2004-06-06 18:00:34\', 2, 2, 2, \'chan3\', \'en3\',
         \'127.0.0.3\', \'host3\', \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'ref3\',
         \'term3\', \'agent3\', \'linux3\', \'mozilla3\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (5, \'127.0.0.3\', \'2004-06-06 18:10:33\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'cc\', 3, \'2004-06-06 18:00:34\', 2, 2, 2, \'chan3\', \'en3\',
         \'127.0.0.3\', \'host3\', \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'ref3\',
         \'term3\', \'agent3\', \'linux3\', \'mozilla3\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (6, \'127.0.0.6\', \'2004-06-06 18:10:36\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'ff\', 6, \'2004-06-06 18:00:36\', 3, 3, 3, \'chan6\', \'en6\',
         \'127.0.0.6\', \'host6\', \'U6\', 0, \'domain6\', \'page6\', \'query6\', \'ref6\',
         \'term6\', \'agent6\', \'linux6\', \'mozilla6\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (7, \'127.0.0.6\', \'2004-06-06 18:10:36\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'ff\', 6, \'2004-06-06 18:00:36\', 3, 3, 3, \'chan6\', \'en6\',
         \'127.0.0.6\', \'host6\', \'U6\', 0, \'domain6\', \'page6\', \'query6\', \'ref6\',
         \'term6\', \'agent6\', \'linux6\', \'mozilla6\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (8, \'127.0.0.8\', \'2004-06-06 18:10:38\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'gg\', 8, \'2004-06-06 18:00:38\', 1, 1, 1, \'chan8\', \'en8\',
         \'127.0.0.8\', \'host8\', \'U8\', 0, \'domain8\', \'page8\', \'query8\', \'ref8\',
         \'term8\', \'agent8\', \'linux8\', \'mozilla8\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (9, \'127.0.0.9\', \'2004-06-06 18:10:39\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'hh\', 9, \'2004-06-06 18:00:39\', 1, 1, 1, \'chan9\', \'en9\',
         \'127.0.0.9\', \'host9\', \'U9\', 0, \'domain9\', \'page9\', \'query9\', \'ref9\',
         \'term9\', \'agent9\', \'linux9\', \'mozilla9\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0),
        (10, \'127.0.0.10\', \'2004-06-06 18:10:40\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'ii\', 10, \'2004-06-06 18:00:40\', 1, 1, 1, \'chan10\', \'en10\',
         \'127.0.0.10\', \'host10\', \'U1\', 0, \'domain10\', \'page10\', \'query10\', \'ref10\',
         \'term10\', \'agent10\', \'linux10\', \'mozilla10\', 1, 259200, ' . MAX_CONNECTION_STATUS_APPROVED . ', 1, 0)');

define('SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TEST_11', 'INSERT INTO
    data_raw_tracker_variable_value
        (server_raw_tracker_impression_id, server_raw_ip, tracker_variable_id, date_time, value)
    VALUES
        (3, \'127.0.0.3\', 1, \'2004-06-06 18:10:34\', \'37\'),
        (4, \'127.0.0.3\', 2, \'2004-06-06 18:10:34\', \'8\'),
        (6, \'127.0.0.6\', 3, \'2004-06-06 18:10:37\', \'10\'),
        (6, \'127.0.0.6\', 4, \'2004-06-06 18:10:37\', \'11\'),
        (7, \'127.0.0.6\', 5, \'2004-06-06 18:10:37\', \'10\'),
        (7, \'127.0.0.6\', 6, \'2004-06-06 18:10:37\', \'11\'),
        (8, \'127.0.0.8\', 7, \'2004-06-06 18:10:39\', \'1\'),
        (8, \'127.0.0.8\', 8, \'2004-06-06 18:10:39\', \'2\'),
        (9, \'127.0.0.9\', 9, \'2004-06-06 18:10:39\', \'10\'),
        (9, \'127.0.0.9\', 10, \'2004-06-06 18:10:39\', \'2\'),
        (10, \'127.0.0.10\', 11, \'2004-06-06 18:10:40\', \'5\'),
        (10, \'127.0.0.10\', 12, \'2004-06-06 18:10:40\', \'2\')');



define('SAVE_SUMMARY_PLACEMENT', 'INSERT INTO
    campaigns
        (campaignid, revenue, revenue_type)
    VALUES
        (1, 5000, ' . MAX_FINANCE_CPM . '),
        (2, 2, ' . MAX_FINANCE_CPC . '),
        (3, 4, ' . MAX_FINANCE_CPA . ')');

define('SAVE_SUMMARY_AD', 'INSERT INTO
    banners
        (bannerid, campaignid)
    VALUES
        (1, 1),
        (2, 2),
        (3, 3),
        (4, 3)');

define('SAVE_SUMMARY_ZONE', 'INSERT INTO
    zones
        (zoneid, cost, cost_type)
    VALUES
        (1, 20, ' . MAX_FINANCE_CPM . '),
        (2, 1, ' . MAX_FINANCE_CPC . '),
        (3, 2, ' . MAX_FINANCE_CPA . '),
        (4, 50, ' . MAX_FINANCE_RS . '),
        (5, 5, ' . MAX_FINANCE_BV . '),
        (6, 0.5, ' . MAX_FINANCE_AI . ')');

define('SAVE_SUMMARY_INTERMEDIATE_AD', 'INSERT INTO
    data_intermediate_ad
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value, total_num_items)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 1, 1, 1, 1, 1, 1, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 2, 1, 1, 1, 1, 1, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 2, 1, 1, 1, 1, 1, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 2, 1, 1, 1, 1, 0, 0, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 3, 1, 2, 1, 1, 0, 0, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 4, 1, 3, 1, 1, 5, 0, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 4, 1, 4, 1, 1, 5, 0, 0),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 4, 1, 5, 1, 1, 5, 100, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 4, 1, 6, 1, 1, 5, 100, 3)');

define('SAVE_SUMMARY_INTERMEDIATE_AD_MULTIDAY', 'INSERT INTO
    data_intermediate_ad
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 1, 1, 1, 1, 1, 1),
        (\'2004-06-07\', 18, 30, 36, \'2004-06-07 18:00:00\', \'2004-06-07 18:29:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-07\', 18, 30, 36, \'2004-06-07 18:00:00\', \'2004-06-07 18:29:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-08\', 18, 30, 36, \'2004-06-08 18:00:00\', \'2004-06-08 18:29:59\', 2, 1, 1, 1, 1, 0, 0)');




define('SAVE_HISTORY_INTERMEDIATE_AD', 'INSERT INTO
    data_intermediate_ad
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 1, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\', 2, 1, 1, 1, 1, 0, 0)');

define('SAVE_HISTORY_INTERMEDIATE_AD_NEXT', 'INSERT INTO
    data_intermediate_ad
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value)
    VALUES
        (\'2004-06-06\', 18, 30, 37, \'2004-06-06 18:30:00\', \'2004-06-06 18:59:59\', 1, 1, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 37, \'2004-06-06 18:30:00\', \'2004-06-06 18:59:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 37, \'2004-06-06 18:30:00\', \'2004-06-06 18:59:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 37, \'2004-06-06 18:30:00\', \'2004-06-06 18:59:59\', 2, 1, 1, 1, 1, 0, 0)');

define('SAVE_HISTORY_INTERMEDIATE_HISTORY_DUPES', 'INSERT INTO
    data_summary_zone_impression_history
        (operation_interval, operation_interval_id, interval_start, interval_end, zone_id, actual_impressions)
    VALUES
        (30, 38, \'2004-06-06 19:00:00\', \'2004-06-06 19:29:59\', 1, 0)');

define('SAVE_HISTORY_INTERMEDIATE_AD_DUPES', 'INSERT INTO
    data_intermediate_ad
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value)
    VALUES
        (\'2004-06-06\', 18, 30, 38, \'2004-06-06 19:00:00\', \'2004-06-06 19:29:59\', 1, 1, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 38, \'2004-06-06 19:00:00\', \'2004-06-06 19:29:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 38, \'2004-06-06 19:00:00\', \'2004-06-06 19:29:59\', 1, 2, 1, 1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 38, \'2004-06-06 19:00:00\', \'2004-06-06 19:29:59\', 2, 1, 1, 1, 1, 0, 0)');



define('MANAGE_CAMPAIGNS_CAMPAIGNS', 'INSERT INTO
    campaigns
        (campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active)
    VALUES
        (1, \'Test Campaign 1\', 1, -1, -1, -1, \'0000-00-00\', \'0000-00-00\', \'t\'),
        (2, \'Test Campaign 2\', 1, 10, -1, -1, \'0000-00-00\', \'0000-00-00\', \'t\'),
        (3, \'Test Campaign 3\', 1, -1, 10, -1, \'0000-00-00\', \'0000-00-00\', \'t\'),
        (4, \'Test Campaign 4\', 1, -1, -1, 10, \'0000-00-00\', \'0000-00-00\', \'t\'),
        (5, \'Test Campaign 5\', 1, 10, 10, 10, \'0000-00-00\', \'0000-00-00\', \'t\'),
        (6, \'Test Campaign 6\', 1, -1, -1, -1, \'2004-06-06\', \'0000-00-00\', \'t\'),
        (7, \'Test Campaign 7\', 1, -1, -1, -1, \'0000-00-00\', \'2004-06-06\', \'f\')');

define('MANAGE_CAMPAIGNS_CLIENTS', 'INSERT INTO
    clients
        (clientid, contact, email)
    VALUES
        (1, \'Test Contact\', \'postmaster@localhost\')');

define('MANAGE_CAMPAIGNS_BANNERS', 'INSERT INTO
    banners
        (bannerid, campaignid)
    VALUES
        (1, 1),
        (2, 2),
        (3, 2),
        (4, 2),
        (5, 3),
        (6, 4),
        (7, 5),
        (8, 6),
        (9, 7)');

define('MANAGE_CAMPAIGNS_INTERMEDIATE_AD', 'INSERT INTO
    data_intermediate_ad
        (interval_start, interval_end, ad_id, impressions, clicks, conversions)
    VALUES
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 1, 1, 1, 1),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 2, 1, 1, 1),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 3, 1, 0, 0),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 4, 8, 0, 0),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 5, 1000, 5, 1000),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 6, 1000, 1000, 1000),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 7, 2, 4, 6),
        (\'2004-06-06 17:00:00\', \'2004-06-06 17:59:59\', 8, 2, 4, 6)');



define('DELETE_OLD_DATA_CAMPAIGNS_TRACKERS', 'INSERT INTO
    campaigns_trackers
        (viewwindow, clickwindow)
    VALUES
        (0, 60),
        (0, 3600)');

define('DELETE_OLD_DATA_AD_CLICKS', 'INSERT INTO
    data_raw_ad_click
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('DELETE_OLD_DATA_AD_IMPRESSIONS', 'INSERT INTO
    data_raw_ad_impression
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('DELETE_OLD_DATA_AD_REQUESTS', 'INSERT INTO
    data_raw_ad_request
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('SAVE_SUMMARY_INTERMEDIATE_AD', "INSERT INTO
    data_intermediate_ad_connection
        (data_intermediate_ad_connection_id, server_raw_ip, server_raw_tracker_impression_id,
        viewer_id, viewer_session_id, tracker_date_time, connection_date_time, tracker_id,
         ad_id, creative_id, zone_id, tracker_channel, connection_channel, tracker_language,
         connection_language, tracker_ip_address, connection_ip_address, tracker_host_name,
         connection_host_name, tracker_country, connection_country, tracker_https, connection_https,
         tracker_domain, connection_domain, tracker_page, connection_page, tracker_query,
         connection_query, tracker_referer, connection_referer, tracker_search_term, connection_search_term,
         tracker_user_agent, connection_user_agent, tracker_os, connection_os, tracker_browser,
         connection_browser, connection_action, connection_window, connection_status)
     VALUES
        (1, 'singleDB', 1, '357826bf941721cb697a032a3d31a969', '', '2005-09-05 20:18:18', '2005-09-05 20:18:04', 1, 1, 0, 1, '', '', 'en-us,en;q=0.', 'en-us,en;q=0.', '127.0.0.1', '127.0.0.1', '127.0.0.1', '127.0.0.1', '', '', 0, 0, 'chris2.unanimis.co.uk', 'chris2.unanimis.co.uk', '/dedupConversions/www/track1.html', '/dedupConversions/www/zone.html', '', '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', '', '', '', '', 1, 1209600, 4),
        (2, 'singleDB', 1, '357826bf941721cb697a032a3d31a969', '', '2005-09-05 20:18:18', '2005-09-05 20:18:04', 1, 1, 0, 1, '', '', 'en-us,en;q=0.', 'en-us,en;q=0.', '127.0.0.1', '127.0.0.1', '127.0.0.1', '127.0.0.1', '', '', 0, 0, 'chris2.unanimis.co.uk', 'chris2.unanimis.co.uk', '/dedupConversions/www/track1.html', '/dedupConversions/www/zone.html', '', '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', '', '', '', '', 1, 1209600, 4),
        (3, 'singleDB', 1, '357826bf941721cb697a032a3d31a969', '', '2005-09-05 20:18:18', '2005-09-05 20:18:04', 1, 1, 0, 1, '', '', 'en-us,en;q=0.', 'en-us,en;q=0.', '127.0.0.1', '127.0.0.1', '127.0.0.1', '127.0.0.1', '', '', 0, 0, 'chris2.unanimis.co.uk', 'chris2.unanimis.co.uk', '/dedupConversions/www/track1.html', '/dedupConversions/www/zone.html', '', '', '', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', '', '', '', '', 1, 1209600, 4)
    ");

define('SAVE_SUMMARY_INTERMEDIATE_AD', "INSERT INTO
    `data_intermediate_ad_variable_value`
        (`data_intermediate_ad_variable_value_id`, `data_intermediate_ad_connection_id`, `tracker_variable_id`, `value`)
     VALUES
        (1, 1, 1, '123'),
        (1, 2, 1, '123'),
        (1, 3, 1, '123')
    ");

?>
