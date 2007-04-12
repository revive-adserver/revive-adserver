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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_*Split class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_StarSplit extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_StarSplit()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests the getMaintenanceStatisticsLastRunInfo() method.
     */
    function testGetMaintenanceStatisticsLastRunInfo()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['operationInterval'] = 60;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Create the required tables
        $now = new Date();
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($date);
        // Insert ad impressions
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(10);
        $query = "
            INSERT INTO
                data_raw_ad_impression_". $now->format('%Y%m%d') ."
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (
                    1,
                    0,
                    1,
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(12);
        $now->setMinute(34);
        $now->setSecond(56);
        $query = "
            INSERT INTO
                data_raw_ad_impression_". $now->format('%Y%m%d') ."
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (
                    1,
                    0,
                    1,
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(11);
        $query = "
            INSERT INTO
                data_raw_ad_impression_". $now->format('%Y%m%d') ."
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (
                    1,
                    0,
                    1,
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(11);
        $now->setMinute(59);
        $now->setSecond(59);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, $now);
        // Insert an hourly (only) update
        $query = "
            INSERT INTO
                log_maintenance_statistics
                (
                    start_run,
                    end_run,
                    duration,
                    adserver_run_type,
                    updated_to
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-05-05 12:00:00',
            '2004-05-05 12:00:05',
            5,
            1,
            '2004-05-05 12:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 10:15:00',
            '2004-06-06 10:16:15',
            75,
            1,
            '2004-06-06 10:15:00'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert an operation interval (only) update
        $aData = array(
            '2004-05-05 12:00:00',
            '2004-05-05 12:00:05',
            5,
            0,
            '2004-05-05 12:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 10:16:00',
            '2004-06-06 10:16:15',
            15,
            0,
            '2004-06-06 10:16:00'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-06 10:16:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert a dual interval update
        $aData = array(
            '2004-06-07 01:15:00',
            '2004-06-07 01:16:15',
            75,
            2,
            '2004-06-07 01:15:00'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseRequests() method.
     */
    function testSummariseRequests()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $aRow = $dsa->summariseRequests($start, $end);
        $this->assertEqual($aRow, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Insert 3 ad requests
        $query = "
            INSERT INTO
                data_raw_ad_request_20040506
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            0,
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                data_raw_ad_request_20040606
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
        // Summarise where requests don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $aRow = $dsa->summariseRequests($start, $end);
        $this->assertEqual($aRow, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Summarise where one request exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $aRow = $dsa->summariseRequests($start, $end);
        $this->assertEqual($aRow, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        // Summarise where the other two requests exists
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $aRow = $dsa->summariseRequests($start, $end);
        $this->assertEqual($aRow, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request
            WHERE
                day = '2004-05-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_request
            WHERE
                day = '2004-06-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                requests AS requests
            FROM
                tmp_ad_request
            WHERE
                day = '2004-06-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['requests'], 2);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseImpressions() method.
     */
    function testSummariseImpressions()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $aRow = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($aRow, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Insert 3 ad impressions
        $query = "
            INSERT INTO
                data_raw_ad_impression_20040506
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            0,
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                data_raw_ad_impression_20040606
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
        // Summarise where impressions don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $aRow = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($aRow, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Summarise where one impression exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $aRow = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($aRow, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        // Summarise where the other two impression exists
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $aRow = $dsa->summariseImpressions($start, $end);
        $this->assertEqual($aRow, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression
            WHERE
                day = '2004-05-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_impression
            WHERE
                day = '2004-06-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                impressions AS impressions
            FROM
                tmp_ad_impression
            WHERE
                day = '2004-06-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['impressions'], 2);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseClicks() method.
     */
    function testSummariseClicks()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Create the required tables
        $now = new Date('2004-05-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $aRow = $dsa->summariseClicks($start, $end);
        $this->assertEqual($aRow, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Insert 3 ad clicks
        $query = "
            INSERT INTO
                data_raw_ad_click_20040506
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            0,
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                data_raw_ad_click_20040606
                (
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
        // Summarise where clicks don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $aRow = $dsa->summariseClicks($start, $end);
        $this->assertEqual($aRow, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Summarise where one click exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $aRow = $dsa->summariseClicks($start, $end);
        $this->assertEqual($aRow, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        // Summarise where the other two clicks exists
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $aRow = $dsa->summariseClicks($start, $end);
        $this->assertEqual($aRow, 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click
            WHERE
                day = '2004-05-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_click
            WHERE
                day = '2004-06-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                clicks AS clicks
            FROM
                tmp_ad_click
            WHERE
                day = '2004-06-06'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['clicks'], 2);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the summariseConnections() method.
     */
    function testSummariseConnections()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);

        // Insert some ads (banners), campaign trackers, ad
        // impressions, ad clicks, and tracker impressions
        $query = "
            INSERT INTO
                banners
                (
                    bannerid,
                    description,
                    campaignid,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            'Banner 1 - Campaign 1',
            1,
            '',
            '',
            '',
            '',
            '',
            ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            'Banner 2 - Campaign 1',
            1,
            '',
            '',
            '',
            '',
            '',
            ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            'Banner 3 - Campaign 2',
            2,
            '',
            '',
            '',
            '',
            '',
            ''
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            'Banner 4 - Campaign 2',
            2,
            '',
            '',
            '',
            '',
            '',
            ''
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                campaigns_trackers
                (
                    campaignid,
                    trackerid,
                    status,
                    viewwindow,
                    clickwindow
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            0,
            0,
            0
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            2,
            0,
            2592000,
            2592000
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            3,
            4,
            2592000,
            2592000
        );
        $rows = $st->execute($aData);
        $queryImpressions = "
            INSERT INTO
                data_raw_ad_impression_20040606
                (
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $queryClicks = "
            INSERT INTO
                data_raw_ad_click_20040606
                (
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'integer',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text'
        );
        $stImpressions = $oDbh->prepare($queryImpressions, $aTypes, MDB2_PREPARE_MANIP);
        $stClicks = $oDbh->prepare($queryClicks, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            'aa',
            0,
            '2004-06-06 18:22:10',
            1,
            0,
            0,
            'chan1',
            'en1',
            '127.0.0.1',
            'localhost1',
            'U1',
            0,
            'domain1',
            'page1',
            'query1',
            'referer1',
            'term1',
            'agent1',
            'linux1',
            'mozilla1'
        );
        $rows = $stImpressions->execute($aData);
        $rows = $stClicks->execute($aData);
        $aData = array(
            'aa',
            0,
            '2004-06-06 18:22:11',
            3,
            0,
            0,
            'chan3',
            'en3',
            '127.0.0.3',
            'localhost3',
            'U3',
            0,
            'domain3',
            'page3',
            'query3',
            'referer3',
            'term3',
            'agent3',
            'linux3',
            'mozilla3'
        );
        $rows = $stImpressions->execute($aData);
        $rows = $stClicks->execute($aData);
        $aData = array(
            'aa',
            0,
            '2004-06-06 18:22:12',
            4,
            0,
            0,
            'chan4',
            'en4',
            '127.0.0.4',
            'localhost4',
            'U4',
            0,
            'domain4',
            'page4',
            'query4',
            'referer4',
            'term4',
            'agent4',
            'linux4',
            'mozilla4'
        );
        $rows = $stImpressions->execute($aData);
        $rows = $stClicks->execute($aData);
        $queryImpressions = "
            INSERT INTO
                data_raw_ad_impression_20040506
                (
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $queryClicks = "
            INSERT INTO
                data_raw_ad_click_20040506
                (
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'integer',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text'
        );
        $stImpressions = $oDbh->prepare($queryImpressions, $aTypes, MDB2_PREPARE_MANIP);
        $stClicks = $oDbh->prepare($queryClicks, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            'aa',
            0,
            '2004-05-06 12:34:56',
            2,
            0,
            0,
            'chan2',
            'en2',
            '127.0.0.2',
            'localhost2',
            'U2',
            0,
            'domain2',
            'page2',
            'query2',
            'referer2',
            'term2',
            'agent2',
            'linux2',
            'mozilla2'
        );
        $rows = $stImpressions->execute($aData);
        $rows = $stClicks->execute($aData);
        $query = "
            INSERT INTO
                data_raw_tracker_impression_20040606
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    viewer_id,
                    date_time,
                    tracker_id
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'timestamp',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            'singleDB',
            'aa',
            '2004-06-06 18:22:15',
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            'singleDB',
            'aa',
            '2004-06-06 18:22:15',
            3
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            'singleDB',
            'aa',
            '2004-06-06 18:22:15',
            4
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                data_raw_tracker_impression_20040506
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    viewer_id,
                    date_time,
                    tracker_id
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'timestamp',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            2,
            'singleDB',
            'aa',
            '2004-05-06 12:35:00',
            2
        );
        $rows = $st->execute($aData);
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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-05-06 12:34:56');
        $this->assertEqual($aRow['connection_ad_id'], 2);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan2');
        $this->assertEqual($aRow['connection_language'], 'en2');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($aRow['connection_host_name'], 'localhost2');
        $this->assertEqual($aRow['connection_country'], 'U2');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain2');
        $this->assertEqual($aRow['connection_page'], 'page2');
        $this->assertEqual($aRow['connection_query'], 'query2');
        $this->assertEqual($aRow['connection_referer'], 'referer2');
        $this->assertEqual($aRow['connection_search_term'], 'term2');
        $this->assertEqual($aRow['connection_user_agent'], 'agent2');
        $this->assertEqual($aRow['connection_os'], 'linux2');
        $this->assertEqual($aRow['connection_browser'], 'mozilla2');
        $this->assertEqual($aRow['connection_action'], 0);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], 0);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-05-06 12:34:56');
        $this->assertEqual($aRow['connection_ad_id'], 2);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan2');
        $this->assertEqual($aRow['connection_language'], 'en2');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($aRow['connection_host_name'], 'localhost2');
        $this->assertEqual($aRow['connection_country'], 'U2');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain2');
        $this->assertEqual($aRow['connection_page'], 'page2');
        $this->assertEqual($aRow['connection_query'], 'query2');
        $this->assertEqual($aRow['connection_referer'], 'referer2');
        $this->assertEqual($aRow['connection_search_term'], 'term2');
        $this->assertEqual($aRow['connection_user_agent'], 'agent2');
        $this->assertEqual($aRow['connection_os'], 'linux2');
        $this->assertEqual($aRow['connection_browser'], 'mozilla2');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], 0);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        // Drop the temporary table
        $dsa->tempTables->dropTable('tmp_ad_connection');
        // Summarise where the other connections are
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection
            WHERE
                inside_window = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1
                AND connection_ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:11');
        $this->assertEqual($aRow['connection_ad_id'], 3);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['connection_host_name'], 'localhost3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['connection_referer'], 'referer3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1
                AND connection_ad_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:12');
        $this->assertEqual($aRow['connection_ad_id'], 4);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan4');
        $this->assertEqual($aRow['connection_language'], 'en4');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.4');
        $this->assertEqual($aRow['connection_host_name'], 'localhost4');
        $this->assertEqual($aRow['connection_country'], 'U4');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain4');
        $this->assertEqual($aRow['connection_page'], 'page4');
        $this->assertEqual($aRow['connection_query'], 'query4');
        $this->assertEqual($aRow['connection_referer'], 'referer4');
        $this->assertEqual($aRow['connection_search_term'], 'term4');
        $this->assertEqual($aRow['connection_user_agent'], 'agent4');
        $this->assertEqual($aRow['connection_os'], 'linux4');
        $this->assertEqual($aRow['connection_browser'], 'mozilla4');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0
                AND connection_ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:11');
        $this->assertEqual($aRow['connection_ad_id'], 3);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['connection_host_name'], 'localhost3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['connection_referer'], 'referer3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 0);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0
                AND connection_ad_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:12');
        $this->assertEqual($aRow['connection_ad_id'], 4);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan4');
        $this->assertEqual($aRow['connection_language'], 'en4');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.4');
        $this->assertEqual($aRow['connection_host_name'], 'localhost4');
        $this->assertEqual($aRow['connection_country'], 'U4');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain4');
        $this->assertEqual($aRow['connection_page'], 'page4');
        $this->assertEqual($aRow['connection_query'], 'query4');
        $this->assertEqual($aRow['connection_referer'], 'referer4');
        $this->assertEqual($aRow['connection_search_term'], 'term4');
        $this->assertEqual($aRow['connection_user_agent'], 'agent4');
        $this->assertEqual($aRow['connection_os'], 'linux4');
        $this->assertEqual($aRow['connection_browser'], 'mozilla4');
        $this->assertEqual($aRow['connection_action'], 0);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        // Drop the temporary table
        $dsa->tempTables->dropTable('tmp_ad_connection');
        // Test with the data present, but the tracker module uninstalled
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
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
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Re-create dropped tables
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_request');
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysqlSplit.php';
        // Insert the test data
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_VARIABLES);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_AD_CLICKS);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_ONE);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TWO);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_CONNECTIONS);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 1
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 1);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:15');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], 0);
        $this->assertEqual($aRow['inside_window'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.2'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.2');
        $this->assertEqual($aRow['viewer_id'], 'bb');
        $this->assertEqual($aRow['viewer_session_id'], 2);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:22:10');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-05 10:00:00');
        $this->assertEqual($aRow['tracker_id'], 2);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan2');
        $this->assertEqual($aRow['connection_channel'], 'chan2');
        $this->assertEqual($aRow['tracker_language'], 'ten2');
        $this->assertEqual($aRow['connection_language'], 'en2');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.2');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($aRow['tracker_host_name'], 'thost2');
        $this->assertEqual($aRow['connection_host_name'], 'host2');
        $this->assertEqual($aRow['tracker_country'], 'T2');
        $this->assertEqual($aRow['connection_country'], 'U2');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain2');
        $this->assertEqual($aRow['connection_domain'], 'domain2');
        $this->assertEqual($aRow['tracker_page'], 'tpage2');
        $this->assertEqual($aRow['connection_page'], 'page2');
        $this->assertEqual($aRow['tracker_query'], 'tquery2');
        $this->assertEqual($aRow['connection_query'], 'query2');
        $this->assertEqual($aRow['tracker_referer'], 'tref2');
        $this->assertEqual($aRow['connection_referer'], 'ref2');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm2');
        $this->assertEqual($aRow['connection_search_term'], 'term2');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent2');
        $this->assertEqual($aRow['connection_user_agent'], 'agent2');
        $this->assertEqual($aRow['tracker_os'], 'tlinux2');
        $this->assertEqual($aRow['connection_os'], 'linux2');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla2');
        $this->assertEqual($aRow['connection_browser'], 'mozilla2');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 4320);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 4);
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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 1);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertNull($aRow['value']);
        $query = "
            SELECT
                diavv.*
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']} AS diavv
            WHERE
                diavv.tracker_variable_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 3);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['table']['split'] = true;
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
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
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
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
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_VARIABLES);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_AD_CLICKS);
        $aRow = $oDbh->exec(SPLIT_SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the deleteOldData() method.
     */
    function testDeleteOldData()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

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
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_CAMPAIGNS_TRACKERS);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
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
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
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
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
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
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;
        $dsa = $oMDMSF->factory("AdServer");
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
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
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
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
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_ad_click', $now);
        $dsa->tables->createTable('data_raw_ad_impression', $now);
        $dsa->tables->createTable('data_raw_ad_request', $now);
        // Insert the test data
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_CLICKS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_IMPRESSIONS_TWO);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_ONE);
        $aRow = $oDbh->exec(SPLIT_DELETE_OLD_DATA_AD_REQUESTS_TWO);
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
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        TestEnv::restoreEnv();
    }

}

?>
