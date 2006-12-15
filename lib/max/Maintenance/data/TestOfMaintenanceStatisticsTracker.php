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
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

define('TRACKER_FULL_TEST_TRACKER_IMPRESSIONS', "INSERT INTO
        max_data_raw_tracker_impression
    ( server_raw_tracker_impression_id , server_raw_ip , viewer_id , viewer_session_id , date_time , tracker_id , channel , language , ip_address , host_name , country , https , domain , page , query , referer , search_term , user_agent , os , browser , max_https ) 
    VALUES
        (1,'singleDB','7030ec9e03911a66006cba951848e454','','2004-11-26 12:10:42',1,NULL,'en-us,en;q=0.5',
         '127.0.0.1','','',0,'localhost','/test.html','','','',
         'Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0)");

define('TRACKER_FULL_TEST_TRACKER_VARIABLE_VALUES', "INSERT INTO
        max_data_raw_tracker_variable_value
    VALUES
        (1,'singleDB',1,'2004-11-26 12:10:42',42)");

define('TRACKER_FULL_TEST_TRACKER_CLICK', "INSERT INTO
        max_data_raw_tracker_click
    ( `viewer_id` , `viewer_session_id` , `date_time` , `tracker_id` , `channel` , `language` , `ip_address` , `host_name` , `country` , `https` , `domain` , `page` , `query` , `referer` , `search_term` , `user_agent` , `os` , `browser` , `max_https` ) 
    VALUES
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',4,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',5,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',5,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',5,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',5,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',4,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',3,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',5,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',6,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0)");

?>
