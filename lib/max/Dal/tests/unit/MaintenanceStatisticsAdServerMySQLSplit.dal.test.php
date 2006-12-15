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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/AdServer/mysqlSplit.php';

/**
 * A class for testing the MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfMaxDalMaintenanceStatisticsAdServermysqlSplit extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMaxDalMaintenanceStatisticsAdServermysqlSplit()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that the singleton() method only ever returns one class instance.
     */
    function xtestSingleton()
    {
        $first = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $second = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $this->assertIdentical($first, $second);
    }

    /**
     * Tests the getMaintenanceStatisticsLastRunInfo() method.
     */
    function testGetMaintenanceStatisticsLastRunInfo()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['operationInterval'] = 60;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the required tables
        $now = new Date();
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertNull($date);
        // Insert ad impressions
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(10);
        $query = "
            INSERT INTO
                data_raw_ad_impression_". $now->format('%Y%m%d') ."
                (
                    date_time
                )
            VALUES
                (
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $result = $dbh->query($query);
        $now->setHour(12);
        $now->setMinute(34);
        $now->setSecond(56);
        $query = "
            INSERT INTO
                data_raw_ad_impression_". $now->format('%Y%m%d') ."
                (
                    date_time
                )
            VALUES
                (
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $result = $dbh->query($query);
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(11);
        $query = "
            INSERT INTO
                data_raw_ad_impression_". $now->format('%Y%m%d') ."
                (
                    date_time
                )
            VALUES
                (
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $result = $dbh->query($query);
        $now->setHour(11);
        $now->setMinute(59);
        $now->setSecond(59);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, $now);
        // Get the data for the tests
        include_once MAX_PATH. '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert an hourly (only) update
        $result = $dbh->query(SPLIT_LMS_HOUR);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert an operation interval (only) update
        $result = $dbh->query(SPLIT_LMS_OI);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-06 10:16:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert a dual interval update
        $result = $dbh->query(SPLIT_LMS_DUAL);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseRequests() method.
     */
    function testSummariseRequests()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $rows = $dsa->summariseRequests($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert 3 ad requests
        $result = $dbh->query(SPLIT_SUMMARISE_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_SUMMARISE_AD_REQUESTS_TWO);
        // Summarise where requests don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $rows = $dsa->summariseRequests($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Summarise where one request exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $rows = $dsa->summariseRequests($start, $end);
        $this->assertEqual($rows, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        // Summarise where the other two requests exists
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseRequests($start, $end);
        $this->assertEqual($rows, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request
            WHERE
                day = '2004-05-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request
            WHERE
                day = '2004-06-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                requests AS requests
            FROM
                tmp_ad_request
            WHERE
                day = '2004-06-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['requests'], 2);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseImpressions() method.
     */
    function testSummariseImpressions()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $rows = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert 3 ad impressions
        $result = $dbh->query(SPLIT_SUMMARISE_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_SUMMARISE_AD_IMPRESSIONS_TWO);
        // Summarise where impressions don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $rows = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Summarise where one impression exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $rows = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($rows, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        // Summarise where the other two impression exists
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($rows, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression
            WHERE
                day = '2004-05-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression
            WHERE
                day = '2004-06-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                impressions AS impressions
            FROM
                tmp_ad_impression
            WHERE
                day = '2004-06-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['impressions'], 2);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseClicks() method.
     */
    function testSummariseClicks()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $rows = $dsa->summariseClicks($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert 3 ad clicks
        $result = $dbh->query(SPLIT_SUMMARISE_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_SUMMARISE_AD_CLICKS_TWO);
        // Summarise where clicks don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $rows = $dsa->summariseClicks($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Summarise where one click exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $rows = $dsa->summariseClicks($start, $end);
        $this->assertEqual($rows, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        // Summarise where the other two clicks exists
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseClicks($start, $end);
        $this->assertEqual($rows, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click
            WHERE
                day = '2004-05-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click
            WHERE
                day = '2004-06-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                clicks AS clicks
            FROM
                tmp_ad_click
            WHERE
                day = '2004-06-06'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['clicks'], 2);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseConnections() method.
     */
    function testSummariseConnections()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $conf['modules']['Tracker'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert some ads (banners), campaign trackers, ad
        // impressions, ad clicks, and tracker impressions
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_BANNERS);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_CAMPAIGNS_TRACKERS);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_TRACKER_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_SUMMARISE_CONVERSIONS_TRACKER_IMPRESSIONS_TWO);
        // Summarise where tracker impressions don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Summarise where just one tracker impression exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 2);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($row['connection_viewer_id'], 'aa');
        $this->assertEqual($row['connection_viewer_session_id'], 0);
        $this->assertEqual($row['connection_date_time'], '2004-05-06 12:34:56');
        $this->assertEqual($row['connection_ad_id'], 2);
        $this->assertEqual($row['connection_creative_id'], 0);
        $this->assertEqual($row['connection_zone_id'], 0);
        $this->assertEqual($row['connection_channel'], 'chan2');
        $this->assertEqual($row['connection_language'], 'en2');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($row['connection_host_name'], 'localhost2');
        $this->assertEqual($row['connection_country'], 'U2');
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['connection_domain'], 'domain2');
        $this->assertEqual($row['connection_page'], 'page2');
        $this->assertEqual($row['connection_query'], 'query2');
        $this->assertEqual($row['connection_referer'], 'referer2');
        $this->assertEqual($row['connection_search_term'], 'term2');
        $this->assertEqual($row['connection_user_agent'], 'agent2');
        $this->assertEqual($row['connection_os'], 'linux2');
        $this->assertEqual($row['connection_browser'], 'mozilla2');
        $this->assertEqual($row['connection_action'], 0);
        $this->assertEqual($row['connection_window'], 2592000);
        $this->assertEqual($row['connection_status'], 0);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($row['connection_viewer_id'], 'aa');
        $this->assertEqual($row['connection_viewer_session_id'], 0);
        $this->assertEqual($row['connection_date_time'], '2004-05-06 12:34:56');
        $this->assertEqual($row['connection_ad_id'], 2);
        $this->assertEqual($row['connection_creative_id'], 0);
        $this->assertEqual($row['connection_zone_id'], 0);
        $this->assertEqual($row['connection_channel'], 'chan2');
        $this->assertEqual($row['connection_language'], 'en2');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($row['connection_host_name'], 'localhost2');
        $this->assertEqual($row['connection_country'], 'U2');
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['connection_domain'], 'domain2');
        $this->assertEqual($row['connection_page'], 'page2');
        $this->assertEqual($row['connection_query'], 'query2');
        $this->assertEqual($row['connection_referer'], 'referer2');
        $this->assertEqual($row['connection_search_term'], 'term2');
        $this->assertEqual($row['connection_user_agent'], 'agent2');
        $this->assertEqual($row['connection_os'], 'linux2');
        $this->assertEqual($row['connection_browser'], 'mozilla2');
        $this->assertEqual($row['connection_action'], 1);
        $this->assertEqual($row['connection_window'], 2592000);
        $this->assertEqual($row['connection_status'], 0);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        // Drop the temporary table
        $dsa->tempTables->dropTempTable('tmp_ad_connection');
        // Summarise where the other connections are
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 4);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 4);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1
                AND connection_ad_id = 3";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($row['connection_viewer_id'], 'aa');
        $this->assertEqual($row['connection_viewer_session_id'], 0);
        $this->assertEqual($row['connection_date_time'], '2004-06-06 18:22:11');
        $this->assertEqual($row['connection_ad_id'], 3);
        $this->assertEqual($row['connection_creative_id'], 0);
        $this->assertEqual($row['connection_zone_id'], 0);
        $this->assertEqual($row['connection_channel'], 'chan3');
        $this->assertEqual($row['connection_language'], 'en3');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($row['connection_host_name'], 'localhost3');
        $this->assertEqual($row['connection_country'], 'U3');
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['connection_domain'], 'domain3');
        $this->assertEqual($row['connection_page'], 'page3');
        $this->assertEqual($row['connection_query'], 'query3');
        $this->assertEqual($row['connection_referer'], 'referer3');
        $this->assertEqual($row['connection_search_term'], 'term3');
        $this->assertEqual($row['connection_user_agent'], 'agent3');
        $this->assertEqual($row['connection_os'], 'linux3');
        $this->assertEqual($row['connection_browser'], 'mozilla3');
        $this->assertEqual($row['connection_action'], 1);
        $this->assertEqual($row['connection_window'], 2592000);
        $this->assertEqual($row['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1
                AND connection_ad_id = 4";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($row['connection_viewer_id'], 'aa');
        $this->assertEqual($row['connection_viewer_session_id'], 0);
        $this->assertEqual($row['connection_date_time'], '2004-06-06 18:22:12');
        $this->assertEqual($row['connection_ad_id'], 4);
        $this->assertEqual($row['connection_creative_id'], 0);
        $this->assertEqual($row['connection_zone_id'], 0);
        $this->assertEqual($row['connection_channel'], 'chan4');
        $this->assertEqual($row['connection_language'], 'en4');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.4');
        $this->assertEqual($row['connection_host_name'], 'localhost4');
        $this->assertEqual($row['connection_country'], 'U4');
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['connection_domain'], 'domain4');
        $this->assertEqual($row['connection_page'], 'page4');
        $this->assertEqual($row['connection_query'], 'query4');
        $this->assertEqual($row['connection_referer'], 'referer4');
        $this->assertEqual($row['connection_search_term'], 'term4');
        $this->assertEqual($row['connection_user_agent'], 'agent4');
        $this->assertEqual($row['connection_os'], 'linux4');
        $this->assertEqual($row['connection_browser'], 'mozilla4');
        $this->assertEqual($row['connection_action'], 1);
        $this->assertEqual($row['connection_window'], 2592000);
        $this->assertEqual($row['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 4);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0
                AND connection_ad_id = 3";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($row['connection_viewer_id'], 'aa');
        $this->assertEqual($row['connection_viewer_session_id'], 0);
        $this->assertEqual($row['connection_date_time'], '2004-06-06 18:22:11');
        $this->assertEqual($row['connection_ad_id'], 3);
        $this->assertEqual($row['connection_creative_id'], 0);
        $this->assertEqual($row['connection_zone_id'], 0);
        $this->assertEqual($row['connection_channel'], 'chan3');
        $this->assertEqual($row['connection_language'], 'en3');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($row['connection_host_name'], 'localhost3');
        $this->assertEqual($row['connection_country'], 'U3');
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['connection_domain'], 'domain3');
        $this->assertEqual($row['connection_page'], 'page3');
        $this->assertEqual($row['connection_query'], 'query3');
        $this->assertEqual($row['connection_referer'], 'referer3');
        $this->assertEqual($row['connection_search_term'], 'term3');
        $this->assertEqual($row['connection_user_agent'], 'agent3');
        $this->assertEqual($row['connection_os'], 'linux3');
        $this->assertEqual($row['connection_browser'], 'mozilla3');
        $this->assertEqual($row['connection_action'], 0);
        $this->assertEqual($row['connection_window'], 2592000);
        $this->assertEqual($row['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0
                AND connection_ad_id = 4";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($row['connection_viewer_id'], 'aa');
        $this->assertEqual($row['connection_viewer_session_id'], 0);
        $this->assertEqual($row['connection_date_time'], '2004-06-06 18:22:12');
        $this->assertEqual($row['connection_ad_id'], 4);
        $this->assertEqual($row['connection_creative_id'], 0);
        $this->assertEqual($row['connection_zone_id'], 0);
        $this->assertEqual($row['connection_channel'], 'chan4');
        $this->assertEqual($row['connection_language'], 'en4');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.4');
        $this->assertEqual($row['connection_host_name'], 'localhost4');
        $this->assertEqual($row['connection_country'], 'U4');
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['connection_domain'], 'domain4');
        $this->assertEqual($row['connection_page'], 'page4');
        $this->assertEqual($row['connection_query'], 'query4');
        $this->assertEqual($row['connection_referer'], 'referer4');
        $this->assertEqual($row['connection_search_term'], 'term4');
        $this->assertEqual($row['connection_user_agent'], 'agent4');
        $this->assertEqual($row['connection_os'], 'linux4');
        $this->assertEqual($row['connection_browser'], 'mozilla4');
        $this->assertEqual($row['connection_action'], 0);
        $this->assertEqual($row['connection_window'], 2592000);
        $this->assertEqual($row['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        // Drop the temporary table
        $dsa->tempTables->dropTempTable('tmp_ad_connection');
        // Test with the data present, but the tracker module uninstalled
        $conf['modules']['Tracker'] = false;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Summarise where the other connections are
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 0);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the saveIntermediate() method.
     */
    function testSaveIntermediate()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $conf['modules']['Tracker'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the required tables
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_request');
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        $now = new Date('2004-06-07');
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $aTypes = array(
            'types' => array(
                0 => 'request',
                1 => 'impression',
                2 => 'click'
            ),
            'connections' => array(
                1 => MAX_CONNECTION_AD_IMPRESSION,
                2 => MAX_CONNECTION_AD_CLICK
            )
        );
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Re-create dropped tables
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_request');
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert the test data
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_VARIABLES);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_AD_CLICKS);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_ONE);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TWO);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_CONNECTIONS);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 1
                AND server_raw_ip = '127.0.0.1'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 1);
        $this->assertEqual($row['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($row['viewer_id'], 'aa');
        $this->assertEqual($row['viewer_session_id'], 1);
        $this->assertEqual($row['tracker_date_time'], '2004-06-06 18:10:15');
        $this->assertEqual($row['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($row['tracker_id'], 1);
        $this->assertEqual($row['ad_id'], 1);
        $this->assertEqual($row['creative_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['tracker_channel'], 'tchan1');
        $this->assertEqual($row['connection_channel'], 'chan1');
        $this->assertEqual($row['tracker_language'], 'ten1');
        $this->assertEqual($row['connection_language'], 'en1');
        $this->assertEqual($row['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($row['tracker_host_name'], 'thost1');
        $this->assertEqual($row['connection_host_name'], 'host1');
        $this->assertEqual($row['tracker_country'], 'T1');
        $this->assertEqual($row['connection_country'], 'U1');
        $this->assertEqual($row['tracker_https'], 1);
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['tracker_domain'], 'tdomain1');
        $this->assertEqual($row['connection_domain'], 'domain1');
        $this->assertEqual($row['tracker_page'], 'tpage1');
        $this->assertEqual($row['connection_page'], 'page1');
        $this->assertEqual($row['tracker_query'], 'tquery1');
        $this->assertEqual($row['connection_query'], 'query1');
        $this->assertEqual($row['tracker_referer'], 'tref1');
        $this->assertEqual($row['connection_referer'], 'ref1');
        $this->assertEqual($row['tracker_search_term'], 'tterm1');
        $this->assertEqual($row['connection_search_term'], 'term1');
        $this->assertEqual($row['tracker_user_agent'], 'tagent1');
        $this->assertEqual($row['connection_user_agent'], 'agent1');
        $this->assertEqual($row['tracker_os'], 'tlinux1');
        $this->assertEqual($row['connection_os'], 'linux1');
        $this->assertEqual($row['tracker_browser'], 'tmozilla1');
        $this->assertEqual($row['connection_browser'], 'mozilla1');
        $this->assertEqual($row['connection_action'], 1);
        $this->assertEqual($row['connection_window'], 259200);
        $this->assertEqual($row['connection_status'], 0);
        $this->assertEqual($row['inside_window'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.2'";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($row['server_raw_ip'], '127.0.0.2');
        $this->assertEqual($row['viewer_id'], 'bb');
        $this->assertEqual($row['viewer_session_id'], 2);
        $this->assertEqual($row['tracker_date_time'], '2004-06-06 18:22:10');
        $this->assertEqual($row['connection_date_time'], '2004-06-05 10:00:00');
        $this->assertEqual($row['tracker_id'], 2);
        $this->assertEqual($row['ad_id'], 2);
        $this->assertEqual($row['creative_id'], 2);
        $this->assertEqual($row['zone_id'], 2);
        $this->assertEqual($row['tracker_channel'], 'tchan2');
        $this->assertEqual($row['connection_channel'], 'chan2');
        $this->assertEqual($row['tracker_language'], 'ten2');
        $this->assertEqual($row['connection_language'], 'en2');
        $this->assertEqual($row['tracker_ip_address'], 't127.0.0.2');
        $this->assertEqual($row['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($row['tracker_host_name'], 'thost2');
        $this->assertEqual($row['connection_host_name'], 'host2');
        $this->assertEqual($row['tracker_country'], 'T2');
        $this->assertEqual($row['connection_country'], 'U2');
        $this->assertEqual($row['tracker_https'], 1);
        $this->assertEqual($row['connection_https'], 0);
        $this->assertEqual($row['tracker_domain'], 'tdomain2');
        $this->assertEqual($row['connection_domain'], 'domain2');
        $this->assertEqual($row['tracker_page'], 'tpage2');
        $this->assertEqual($row['connection_page'], 'page2');
        $this->assertEqual($row['tracker_query'], 'tquery2');
        $this->assertEqual($row['connection_query'], 'query2');
        $this->assertEqual($row['tracker_referer'], 'tref2');
        $this->assertEqual($row['connection_referer'], 'ref2');
        $this->assertEqual($row['tracker_search_term'], 'tterm2');
        $this->assertEqual($row['connection_search_term'], 'term2');
        $this->assertEqual($row['tracker_user_agent'], 'tagent2');
        $this->assertEqual($row['connection_user_agent'], 'agent2');
        $this->assertEqual($row['tracker_os'], 'tlinux2');
        $this->assertEqual($row['connection_os'], 'linux2');
        $this->assertEqual($row['tracker_browser'], 'tmozilla2');
        $this->assertEqual($row['connection_browser'], 'mozilla2');
        $this->assertEqual($row['connection_action'], 1);
        $this->assertEqual($row['connection_window'], 4320);
        $this->assertEqual($row['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($row['inside_window'], 1);
        $this->assertEqual($row['latest'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 4);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv,
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']} AS diac
            WHERE
                diac.server_raw_tracker_impression_id = 1
                AND diac.server_raw_ip = '127.0.0.1'
                AND diac.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 2);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['value'], 1);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv,
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']} AS diac
            WHERE
                diac.server_raw_tracker_impression_id = 2
                AND diac.server_raw_ip = '127.0.0.2'
                AND diac.data_intermediate_ad_connection_id = diavv.data_intermediate_ad_connection_id";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 2);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 3";
        $row = $dbh->getRow($query);
        $this->assertNull($row['value']);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 4";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['value'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['day'], '2004-06-06');
        $this->assertEqual($row['hour'], 18);
        $this->assertEqual($row['operation_interval'], 30);
        $this->assertEqual($row['operation_interval_id'], 36);
        $this->assertEqual($row['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($row['creative_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['impressions'], 1);
        $this->assertEqual($row['clicks'], 1);
        $this->assertEqual($row['conversions'], 0);
        $this->assertEqual($row['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['day'], '2004-06-06');
        $this->assertEqual($row['hour'], 18);
        $this->assertEqual($row['operation_interval'], 30);
        $this->assertEqual($row['operation_interval_id'], 36);
        $this->assertEqual($row['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($row['creative_id'], 2);
        $this->assertEqual($row['zone_id'], 2);
        $this->assertEqual($row['impressions'], 2);
        $this->assertEqual($row['clicks'], 2);
        $this->assertEqual($row['conversions'], 1);
        $this->assertEqual($row['total_basket_value'], 3);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $conf['modules']['Tracker'] = false;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        // Create the (minimum set of) required tables
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_request');
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 0);
        // Re-create dropped tables
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_request');
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        $now = new Date('2004-06-07');
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        // Insert the test data
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_VARIABLES);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_AD_CLICKS);
        $result = $dbh->query(SPLIT_SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['day'], '2004-06-06');
        $this->assertEqual($row['hour'], 18);
        $this->assertEqual($row['operation_interval'], 30);
        $this->assertEqual($row['operation_interval_id'], 36);
        $this->assertEqual($row['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($row['creative_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['impressions'], 1);
        $this->assertEqual($row['clicks'], 1);
        $this->assertEqual($row['conversions'], 0);
        $this->assertEqual($row['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['day'], '2004-06-06');
        $this->assertEqual($row['hour'], 18);
        $this->assertEqual($row['operation_interval'], 30);
        $this->assertEqual($row['operation_interval_id'], 36);
        $this->assertEqual($row['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($row['creative_id'], 2);
        $this->assertEqual($row['zone_id'], 2);
        $this->assertEqual($row['impressions'], 2);
        $this->assertEqual($row['clicks'], 2);
        $this->assertEqual($row['conversions'], 0);
        $this->assertEqual($row['total_basket_value'], 0);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the deleteOldData() method.
     */
    function testDeleteOldData()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert the test data
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_CAMPAIGNS_TRACKERS);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 18:00:00');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = new MAX_Dal_Maintenance_Statistics_AdServer_mysqlSplit();
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $result = $dbh->query(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 18:00:00');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $result = $dbh->query($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($result, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        TestEnv::restoreEnv();
    }

}

?>
