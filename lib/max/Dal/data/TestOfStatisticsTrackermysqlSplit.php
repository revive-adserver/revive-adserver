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
$Id: TestOfStatisticsTrackermysqlSplit.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

/**
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

define('TOT_SPLIT_LMS_HOUR', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, tracker_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 1, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:15:00\', \'2004-06-06 10:16:15\', 75, 1, \'2004-06-06 10:15:00\')');

define('TOT_SPLIT_LMS_OI', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, tracker_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 0, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:16:00\', \'2004-06-06 10:16:15\', 15, 0, \'2004-06-06 10:16:00\')');

define('TOT_SPLIT_LMS_DUAL', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, tracker_run_type, updated_to)
    VALUES
        (\'2004-06-07 01:15:00\', \'2004-06-07 01:16:15\', 75, 2, \'2004-06-07 01:15:00\')');



define('TOT_SPLIT_DELETE_OLD_DATA_TRACKER_CLICKS_ONE', 'INSERT INTO
    data_raw_tracker_click_20040605
        (date_time)
    VALUES
        (\'2004-06-05 18:00:00\'),
        (\'2004-06-05 17:59:59\'),
        (\'2004-06-05 17:00:00\'),
        (\'2004-06-05 16:59:59\'),
        (\'2004-06-05 16:00:00\'),
        (\'2004-06-05 15:59:59\')');

define('TOT_SPLIT_DELETE_OLD_DATA_TRACKER_CLICKS_TWO', 'INSERT INTO
    data_raw_tracker_click_20040606
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('TOT_SPLIT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS_ONE', 'INSERT INTO
    data_raw_tracker_impression_20040605
        (server_raw_tracker_impression_id, date_time)
    VALUES
        (1, \'2004-06-05 18:00:00\'),
        (2, \'2004-06-05 17:59:59\'),
        (3, \'2004-06-05 17:00:00\'),
        (4, \'2004-06-05 16:59:59\'),
        (5, \'2004-06-05 16:00:00\'),
        (6, \'2004-06-05 15:59:59\')');

define('TOT_SPLIT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS_TWO', 'INSERT INTO
    data_raw_tracker_impression_20040606
        (server_raw_tracker_impression_id, date_time)
    VALUES
        (7, \'2004-06-06 18:00:00\'),
        (8, \'2004-06-06 17:59:59\'),
        (9, \'2004-06-06 17:00:00\'),
        (10, \'2004-06-06 16:59:59\'),
        (11, \'2004-06-06 16:00:00\'),
        (12, \'2004-06-06 15:59:59\')');

define('TOT_SPLIT_DELETE_OLD_DATA_TRACKER_REQUESTS_ONE', 'INSERT INTO
    data_raw_tracker_variable_value_20040605
        (server_raw_tracker_impression_id, date_time)
    VALUES
        (1, \'2004-06-05 18:00:00\'),
        (2, \'2004-06-05 17:59:59\'),
        (3, \'2004-06-05 17:00:00\'),
        (4, \'2004-06-05 16:59:59\'),
        (5, \'2004-06-05 16:00:00\'),
        (6, \'2004-06-05 15:59:59\')');

define('TOT_SPLIT_DELETE_OLD_DATA_TRACKER_REQUESTS_TWO', 'INSERT INTO
    data_raw_tracker_variable_value_20040606
        (server_raw_tracker_impression_id, date_time)
    VALUES
        (7, \'2004-06-06 18:00:00\'),
        (8, \'2004-06-06 17:59:59\'),
        (9, \'2004-06-06 17:00:00\'),
        (10, \'2004-06-06 16:59:59\'),
        (11, \'2004-06-06 16:00:00\'),
        (12, \'2004-06-06 15:59:59\')');

?>
