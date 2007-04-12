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
