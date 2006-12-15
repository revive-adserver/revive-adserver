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
$Id: TestOfStatisticsTrackermysql.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

/**
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

define('TOT_DATA_RAW_TRACKER_IMPRESSIONS', 'INSERT INTO
    data_raw_tracker_impression
        (date_time)
    VALUES
        (\'2004-06-06 18:22:10\'),
        (\'2004-05-06 12:34:56\'),
        (\'2004-06-06 18:22:11\')');

define('TOT_LMS_HOUR', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, tracker_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 1, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:15:00\', \'2004-06-06 10:16:15\', 75, 1, \'2004-06-06 10:15:00\')');

define('TOT_LMS_OI', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, tracker_run_type, updated_to)
    VALUES
        (\'2004-05-05 12:00:00\', \'2004-05-05 12:00:05\', 5, 0, \'2004-05-05 12:00:00\'),
        (\'2004-06-06 10:16:00\', \'2004-06-06 10:16:15\', 15, 0, \'2004-06-06 10:16:00\')');

define('TOT_LMS_DUAL', 'INSERT INTO
    log_maintenance_statistics
        (start_run, end_run, duration, tracker_run_type, updated_to)
    VALUES
        (\'2004-06-07 01:15:00\', \'2004-06-07 01:16:15\', 75, 2, \'2004-06-07 01:15:00\')');



define('TOT_DELETE_OLD_DATA_TRACKER_CLICKS', 'INSERT INTO
    data_raw_tracker_click
        (date_time)
    VALUES
        (\'2004-06-06 18:00:00\'),
        (\'2004-06-06 17:59:59\'),
        (\'2004-06-06 17:00:00\'),
        (\'2004-06-06 16:59:59\'),
        (\'2004-06-06 16:00:00\'),
        (\'2004-06-06 15:59:59\')');

define('TOT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS', 'INSERT INTO
    data_raw_tracker_impression
        (server_raw_tracker_impression_id, date_time)
    VALUES
        (1, \'2004-06-06 18:00:00\'),
        (2, \'2004-06-06 17:59:59\'),
        (3, \'2004-06-06 17:00:00\'),
        (4, \'2004-06-06 16:59:59\'),
        (5, \'2004-06-06 16:00:00\'),
        (6, \'2004-06-06 15:59:59\')');

define('TOT_DELETE_OLD_DATA_TRACKER_VARIABLE_VALUES', 'INSERT INTO
    data_raw_tracker_variable_value
        (server_raw_tracker_impression_id, date_time)
    VALUES
        (1, \'2004-06-06 18:00:00\'),
        (2, \'2004-06-06 17:59:59\'),
        (3, \'2004-06-06 17:00:00\'),
        (4, \'2004-06-06 16:59:59\'),
        (5, \'2004-06-06 16:00:00\'),
        (6, \'2004-06-06 15:59:59\')');

?>
