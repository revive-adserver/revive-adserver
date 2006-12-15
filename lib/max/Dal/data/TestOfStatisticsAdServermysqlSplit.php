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
$Id$
*/

/**
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

define('SPLIT_LMS_HOUR', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, adserver_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 1, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:15:00\', \'2004-06-06 10:16:15\', 75, 1, \'2004-06-06 10:15:00\')');

define('SPLIT_LMS_OI', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, adserver_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 0, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:16:00\', \'2004-06-06 10:16:15\', 15, 0, \'2004-06-06 10:16:00\')');

define('SPLIT_LMS_DUAL', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, adserver_run_type, updated_to)
    VALUES
        (\'2004-06-07 01:15:00\', \'2004-06-07 01:16:15\', 75, 2, \'2004-06-07 01:15:00\')');



define('SPLIT_SUMMARISE_AD_REQUESTS_ONE', 'INSERT INTO
    data_raw_ad_request_20040506
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-05-06 12:34:56\')');

define('SPLIT_SUMMARISE_AD_REQUESTS_TWO', 'INSERT INTO
    data_raw_ad_request_20040606
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-06-06 18:22:10\'),
        (1, 1, \'2004-06-06 18:22:11\')');



define('SPLIT_SUMMARISE_AD_IMPRESSIONS_ONE', 'INSERT INTO
    data_raw_ad_impression_20040506
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-05-06 12:34:56\')');

define('SPLIT_SUMMARISE_AD_IMPRESSIONS_TWO', 'INSERT INTO
    data_raw_ad_impression_20040606
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-06-06 18:22:10\'),
        (1, 1, \'2004-06-06 18:22:11\')');



define('SPLIT_SUMMARISE_AD_CLICKS_ONE', 'INSERT INTO
    data_raw_ad_click_20040506
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-05-06 12:34:56\')');

define('SPLIT_SUMMARISE_AD_CLICKS_TWO', 'INSERT INTO
    data_raw_ad_click_20040606
        (ad_id, zone_id, date_time)
    VALUES
        (1, 1, \'2004-06-06 18:22:10\'),
        (1, 1, \'2004-06-06 18:22:11\')');



define('SPLIT_SUMMARISE_CONVERSIONS_BANNERS', 'INSERT INTO
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
define('SPLIT_SUMMARISE_CONVERSIONS_CAMPAIGNS_TRACKERS', 'INSERT INTO
    campaigns_trackers
        (campaignid, trackerid, status, viewwindow, clickwindow)
    VALUES
        (1, 1, 0, 0, 0),
        (1, 2, 0, 2592000, 2592000),
        (2, 3, 4, 2592000, 2592000)');

define('SPLIT_SUMMARISE_CONVERSIONS_AD_IMPRESSIONS_ONE', 'INSERT INTO
    data_raw_ad_impression_20040506
        (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id,
         channel, language, ip_address, host_name, country, https, domain, page,
         query, referer, search_term, user_agent, os, browser)
    VALUES
        (\'aa\', 0, \'2004-05-06 12:34:56\', 2, 0, 0, \'chan2\', \'en2\', \'127.0.0.2\', \'localhost2\',
         \'U2\', 0, \'domain2\', \'page2\', \'query2\', \'referer2\', \'term2\', \'agent2\', \'linux2\',
         \'mozilla2\')');

define('SPLIT_SUMMARISE_CONVERSIONS_AD_IMPRESSIONS_TWO', 'INSERT INTO
    data_raw_ad_impression_20040606
        (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id,
         channel, language, ip_address, host_name, country, https, domain, page,
         query, referer, search_term, user_agent, os, browser)
    VALUES
        (\'aa\', 0, \'2004-06-06 18:22:10\', 1, 0, 0, \'chan1\', \'en1\', \'127.0.0.1\', \'localhost1\',
         \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'referer1\', \'term1\', \'agent1\', \'linux1\',
         \'mozilla1\'),
        (\'aa\', 0, \'2004-06-06 18:22:11\', 3, 0, 0, \'chan3\', \'en3\', \'127.0.0.3\', \'localhost3\',
         \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'referer3\', \'term3\', \'agent3\', \'linux3\',
         \'mozilla3\'),
        (\'aa\', 0, \'2004-06-06 18:22:12\', 4, 0, 0, \'chan4\', \'en4\', \'127.0.0.4\', \'localhost4\',
         \'U4\', 0, \'domain4\', \'page4\', \'query4\', \'referer4\', \'term4\', \'agent4\', \'linux4\',
         \'mozilla4\')');

define('SPLIT_SUMMARISE_CONVERSIONS_AD_CLICKS_ONE', 'INSERT INTO
    data_raw_ad_click_20040506
        (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id,
         channel, language, ip_address, host_name, country, https, domain, page,
         query, referer, search_term, user_agent, os, browser)
    VALUES
        (\'aa\', 0, \'2004-05-06 12:34:56\', 2, 0, 0, \'chan2\', \'en2\', \'127.0.0.2\', \'localhost2\',
         \'U2\', 0, \'domain2\', \'page2\', \'query2\', \'referer2\', \'term2\', \'agent2\', \'linux2\',
         \'mozilla2\')');

define('SPLIT_SUMMARISE_CONVERSIONS_AD_CLICKS_TWO', 'INSERT INTO
    data_raw_ad_click_20040606
        (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id,
         channel, language, ip_address, host_name, country, https, domain, page,
         query, referer, search_term, user_agent, os, browser)
    VALUES
        (\'aa\', 0, \'2004-06-06 18:22:10\', 1, 0, 0, \'chan1\', \'en1\', \'127.0.0.1\', \'localhost1\',
         \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'referer1\', \'term1\', \'agent1\', \'linux1\',
         \'mozilla1\'),
        (\'aa\', 0, \'2004-06-06 18:22:11\', 3, 0, 0, \'chan3\', \'en3\', \'127.0.0.3\', \'localhost3\',
         \'U3\', 0, \'domain3\', \'page3\', \'query3\', \'referer3\', \'term3\', \'agent3\', \'linux3\',
         \'mozilla3\'),
        (\'aa\', 0, \'2004-06-06 18:22:12\', 4, 0, 0, \'chan4\', \'en4\', \'127.0.0.4\', \'localhost4\',
         \'U4\', 0, \'domain4\', \'page4\', \'query4\', \'referer4\', \'term4\', \'agent4\', \'linux4\',
         \'mozilla4\')');

define('SPLIT_SUMMARISE_CONVERSIONS_TRACKER_IMPRESSIONS_ONE', 'INSERT INTO
    data_raw_tracker_impression_20040506
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, date_time, tracker_id)
    VALUES
        (2, \'singleDB\', \'aa\', \'2004-05-06 12:35:00\', 2)');

define('SPLIT_SUMMARISE_CONVERSIONS_TRACKER_IMPRESSIONS_TWO', 'INSERT INTO
    data_raw_tracker_impression_20040606
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, date_time, tracker_id)
    VALUES
        (1, \'singleDB\', \'aa\', \'2004-06-06 18:22:15\', 1),
        (3, \'singleDB\', \'aa\', \'2004-06-06 18:22:15\', 3),
        (4, \'singleDB\', \'aa\', \'2004-06-06 18:22:15\', 4)');



define('SPLIT_SAVE_INTERMEDIATE_VARIABLES', 'INSERT INTO
    variables
        (variableid, trackerid, purpose)
    VALUES
        (1, 1, NULL),
        (2, 1, \'basket_value\'),
        (3, 2, NULL),
        (4, 2, \'basket_value\')');

define('SPLIT_SAVE_INTERMEDIATE_AD_CLICKS', 'INSERT INTO
    tmp_ad_click
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, clicks)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         2, 2, 2, 2)');

define('SPLIT_SAVE_INTERMEDIATE_AD_IMPRESSIONS', 'INSERT INTO
    tmp_ad_impression
        (day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
         ad_id, creative_id, zone_id, impressions)
    VALUES
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         1, 1, 1, 1),
        (\'2004-06-06\', 18, 30, 36, \'2004-06-06 18:00:00\', \'2004-06-06 18:29:59\',
         2, 2, 2, 2)');

define('SPLIT_SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS', 'INSERT INTO
    data_raw_tracker_impression_20040606
        (server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
         date_time, tracker_id, channel, language, ip_address, host_name, country,
         https, domain, page, query, referer, search_term, user_agent, os, browser)
    VALUES
        (1, \'127.0.0.1\', \'aa\', 1, \'2004-06-06 18:10:15\', 1, \'tchan1\', \'ten1\',
         \'t127.0.0.1\', \'thost1\', \'T1\', 1, \'tdomain1\', \'tpage1\', \'tquery1\',
         \'tref1\', \'tterm1\', \'tagent1\', \'tlinux1\', \'tmozilla1\'),
        (2, \'127.0.0.2\', \'bb\', 2, \'2004-06-06 18:22:10\', 2, \'tchan2\', \'ten2\',
         \'t127.0.0.2\', \'thost2\', \'T2\', 1, \'tdomain2\', \'tpage2\', \'tquery2\',
         \'tref2\', \'tterm2\', \'tagent2\', \'tlinux2\', \'tmozilla2\')');

define('SPLIT_SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_ONE', 'INSERT INTO
    data_raw_tracker_variable_value_20040606
        (server_raw_tracker_impression_id, server_raw_ip, tracker_variable_id, date_time, value)
    VALUES
        (1, \'127.0.0.1\', 1, \'2004-06-06 18:10:16\', \'1\'),
        (1, \'127.0.0.1\', 2, \'2004-06-06 18:10:17\', \'2\'),
        (2, \'127.0.0.2\', 3, \'2004-06-06 18:22:11\', NULL)');

define('SPLIT_SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TWO', 'INSERT INTO
    data_raw_tracker_variable_value_20040607
        (server_raw_tracker_impression_id, server_raw_ip, tracker_variable_id, date_time, value)
    VALUES
        (2, \'127.0.0.2\', 4, \'2004-06-07 18:22:12\', \'3\')');

define('SPLIT_SAVE_INTERMEDIATE_CONNECTIONS', 'INSERT INTO
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
        (1, \'127.0.0.1\', \'2004-06-06 18:10:15\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'aa\', 1, \'2004-06-06 18:00:00\', 1, 1, 1, \'chan1\', \'en1\',
         \'127.0.0.1\', \'host1\', \'U1\', 0, \'domain1\', \'page1\', \'query1\', \'ref1\',
         \'term1\', \'agent1\', \'linux1\', \'mozilla1\', 1, 259200, 0, 1, 0),
        (2, \'127.0.0.2\', \'2004-06-06 18:22:10\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'bb\', 2, \'2004-06-05 09:00:00\', 2, 2, 2, \'chan2\', \'en2\',
         \'127.0.0.2\', \'host2\', \'U2\', 0, \'domain2\', \'page2\', \'query2\', \'ref2\',
         \'term2\', \'agent2\', \'linux2\', \'mozilla2\', 1, 4320, 4, 1, 0),
        (2, \'127.0.0.2\', \'2004-06-06 18:22:10\', 30, 36, \'2004-06-06 18:00:00\',
         \'2004-06-06 18:29:59\',  \'bb\', 2, \'2004-06-05 10:00:00\', 2, 2, 2, \'chan2\', \'en2\',
         \'127.0.0.2\', \'host2\', \'U2\', 0, \'domain2\', \'page2\', \'query2\', \'ref2\',
         \'term2\', \'agent2\', \'linux2\', \'mozilla2\', 1, 4320, 4, 1, 0)');



define('SPLIT_DELETE_OLD_DATA_CAMPAIGNS_TRACKERS', 'INSERT INTO
    campaigns_trackers
        (viewwindow, clickwindow)
    VALUES
        (0, 60),
        (0, 3600)');

define('SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE', 'INSERT INTO
    data_raw_ad_click_20040605
        (date_time)
    VALUES
        (\'2004-06-05 18:00:00\'),
        (\'2004-06-05 17:59:59\'),
        (\'2004-06-05 17:00:00\'),
        (\'2004-06-05 16:59:59\'),
        (\'2004-06-05 16:00:00\'),
        (\'2004-06-05 15:59:59\')');

define('SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO', 'INSERT INTO
    data_raw_ad_click_20040606
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE', 'INSERT INTO
    data_raw_ad_impression_20040605
        (date_time)
    VALUES
        (\'2004-06-05 18:00:00\'),
        (\'2004-06-05 17:59:59\'),
        (\'2004-06-05 17:00:00\'),
        (\'2004-06-05 16:59:59\'),
        (\'2004-06-05 16:00:00\'),
        (\'2004-06-05 15:59:59\')');

define('SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO', 'INSERT INTO
    data_raw_ad_impression_20040606
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE', 'INSERT INTO
    data_raw_ad_request_20040605
        (date_time)
    VALUES
        (\'2004-06-05 18:00:00\'),
        (\'2004-06-05 17:59:59\'),
        (\'2004-06-05 17:00:00\'),
        (\'2004-06-05 16:59:59\'),
        (\'2004-06-05 16:00:00\'),
        (\'2004-06-05 15:59:59\')');

define('SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO', 'INSERT INTO
    data_raw_ad_request_20040606
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

?>
