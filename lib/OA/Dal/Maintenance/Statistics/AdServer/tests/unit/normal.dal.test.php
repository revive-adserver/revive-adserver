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
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_Star extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_Star()
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
        $conf['maintenance']['operationInterval'] = 60;
        $conf['table']['split'] = false;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($date);
        TestEnv::startTransaction();
        // Insert ad impressions
        $query = "
            INSERT INTO
                data_raw_ad_impression
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
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
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
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
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
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * A private method to insert test requests, impressions or clicks
     * for testing the summarisation of these via the _summariseData()
     * method.
     *
     * @param string $table The table name to insert into (ie. one of
     *                      "data_raw_ad_request", "data_raw_ad_impression"
     *                      or "data_raw_ad_click".
     */
    function _insertTestSummariseData($table)
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                $table
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
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests the _summariseData() method.
     */
    function test_summariseData()
    {
        // Types to be tested
        $aType = array(
            'request'    => 'data_raw_ad_request',
            'impression' => 'data_raw_ad_impression',
            'click'      => 'data_raw_ad_click',
        );

        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = false;
        $conf['maintenance']['operationInterval'] = 30;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        foreach ($aType as $type => $table) {
            $returnColumnName = $type . 's';
            // Test with no data
            $start = new Date('2004-06-06 12:00:00');
            $end = new Date('2004-06-06 12:29:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 0);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 0);
            TestEnv::startTransaction();
            // Insert 3 ad requests/impressions/clicks
            $this->_insertTestSummariseData($table);
            // Summarise where requests/impressions/clicks don't exist
            $start = new Date('2004-05-06 12:00:00');
            $end = new Date('2004-05-06 12:29:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 0);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 0);
            // Summarise where one request/impression/click exists
            $start = new Date('2004-05-06 12:30:00');
            $end = new Date('2004-05-06 12:59:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 1);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 1);
            // Summarise where the other two requests/impressions/clicks exist
            $start = new Date('2004-06-06 18:00:00');
            $end = new Date('2004-06-06 18:29:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 1);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}
                WHERE
                    day = '2004-05-06'";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 1);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}
                WHERE
                    day = '2004-06-06'";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 1);
            $query = "
                SELECT
                    $returnColumnName AS $returnColumnName
                FROM
                    tmp_ad_{$type}
                WHERE
                    day = '2004-06-06'";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow[$returnColumnName], 2);
            TestEnv::rollbackTransaction();
        }
        TestEnv::restoreConfig();
    }

    /**
     * Tests the summariseRequests() method.
     *
     * @TODO Not implemented...
     */
    function testSummariseRequests()
    {

    }

    /**
     * Tests the summariseImpressions() method.
     *
     * @TODO Not implemented...
     */
    function testSummariseImpressions()
    {

    }

    /**
     * Tests the summariseClicks() method.
     *
     * @TODO Not implemented...
     */
    function testSummariseClicks()
    {

    }

    /**
     * Tests the summariseConnections() method.
     */
    function testSummariseConnections()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

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

        TestEnv::startTransaction();
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
                data_raw_ad_impression
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
                data_raw_ad_click
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
        $query = "
            INSERT INTO
                data_raw_tracker_impression
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
            2,
            'singleDB',
            'aa',
            '2004-05-06 12:35:00',
            2
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
     * A method to perform testing of the _saveIntermediateDeduplicateConversions() method.
     *
     * Test 0:  Test with no conversions.
     *
     * Test 1:  Test with one conversion, no variable values, and ensure that
     *              the conversion status remains as "approved".
     * Test 2:  Test with two conversions, no variable values, and ensure that
     *              the conversion statuses remain as "approved".
     *
     * Test 3:  Test with one conversion, one variable value (not unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 4:  Test with one conversion, one variable value (not unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 5:  Test with one conversion, one variable value (not unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 6:  Test with two conversions, one variable value (not unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 7:  Test with two conversions, one variable value (not unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 8:  Test with two conversions, one variable value (not unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 9:  Test with two conversions, one variable value (not unique, empty string, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 10:  Test with two conversions, one variable value (not unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 11: Test with two conversions, one variable value (not unique, real value, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 12: Test with one conversion, one variable value (unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 13: Test with one conversion, one variable value (unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 14: Test with one conversion, one variable value (unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 15: Test with two conversions, one variable value (unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     *              (NOTE: This is a special case! Although the two variable values are
     *                     the "same", we don't de-duplicate, because, well, how can you
     *                     de-dupe on nothing?)
     *
     * Test 16: Test with two conversions, one variable value (unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 17: Test with two conversions, one variable value (unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 18: Test with two conversions, one variable value (unique, empty string, empty string),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 19: Test with two conversions, one variable value (unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 20: Test with two conversions, one variable value (unique, different real values),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 21: Test with two conversions, one variable value (unique, equal real values),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 22: Test with duplicate conversions in different hours, both within the
     *              unique window of the original, within the unique window of a duplicate
     *              (only), and outside of the unique window.
     *
     */
    function test_saveIntermediateDeduplicateConversions()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        // Test 0
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 0);
        TestEnv::rollbackTransaction();

        // Test 1
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 2
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 3
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 4
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 5
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 6
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 7
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 8
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 9
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 10
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 11
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 12
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 13
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 14
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 15
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 16
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 17
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 18
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        TestEnv::rollbackTransaction();

        // Test 19
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 20
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value1'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value2'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 21
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        TestEnv::rollbackTransaction();

        // Test 22
        TestEnv::startTransaction();
        // Prepare the variable values for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    2,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    3,
                    2,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    1,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:15:00, from a click on ad ID 7, zone ID 8, at 12:14,
        // using tracker ID 2 (one variable value)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    3,
                    2,
                    3,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both conversions have NOT been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        // Insert a connection at 13:05:00, from a click on ad ID 5, zone ID 6, at 13:04,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    3,
                    'singleDB',
                    3,
                    'viewerid3',
                    '2005-09-05 13:05:00',
                    '2005-09-05 13:04:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    4,
                    3,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    5,
                    3,
                    2,
                    'test unique different'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 13:06:00, from a click on ad ID 5, zone ID 6, at 13:05,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    4,
                    'singleDB',
                    4,
                    'viewerid3',
                    '2005-09-05 13:06:00',
                    '2005-09-05 13:05:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    6,
                    4,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    7,
                    4,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 13:00:00');
        $oEndDate   = new Date('2005-09-07 13:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 3);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        // Insert a connection at 14:05:00, from a click on ad ID 5, zone ID 6, at 14:04,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    5,
                    'singleDB',
                    5,
                    'viewerid3',
                    '2005-09-05 14:05:00',
                    '2005-09-05 14:04:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    8,
                    5,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    9,
                    5,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 14:15:00, from a click on ad ID 7, zone ID 8, at 14:14,
        // using tracker ID 2 (one variable value)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    6,
                    'singleDB',
                    6,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    10,
                    6,
                    3,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 14:00:00');
        $oEndDate   = new Date('2005-09-07 14:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 6);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 4');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');

        TestEnv::rollbackTransaction();
    }

    /**
     * A private method to insert request test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateRequestData()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                tmp_ad_request
                (
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            1,
            1,
            1,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            2,
            2,
            2,
            2
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert impression test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateImpressionData()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                tmp_ad_impression
                (
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id,
                    impressions
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            1,
            1,
            1,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            2,
            2,
            2,
            2
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert click test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateClickData()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                tmp_ad_click
                (
                    day,
                    hour,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    creative_id,
                    zone_id,
                    clicks
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            1,
            1,
            1,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            2,
            2,
            2,
            2
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06',
            18,
            30,
            36,
            '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',
            3,
            3,
            3,
            1
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert two tracker impressions and a temporary ad
     * connection as test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                data_raw_tracker_impression
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    tracker_id,
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
            'integer',
            'text',
            'text',
            'integer',
            'timestamp',
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
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            '127.0.0.1',
            'aa',
            1,
            '2004-06-06 18:10:15',
            1,
            'tchan1',
            'ten1',
            't127.0.0.1',
            'thost1',
            'T1',
            1,
            'tdomain1',
            'tpage1',
            'tquery1',
            'tref1',
            'tterm1',
            'tagent1',
            'tlinux1',
            'tmozilla1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            '127.0.0.1',
            'aa',
            1,
            '2004-06-06 18:10:30',
            1,
            'tchan1',
            'ten1',
            't127.0.0.1',
            'thost1',
            'T1',
            1,
            'tdomain1',
            'tpage1',
            'tquery1',
            'tref1',
            'tterm1',
            'tagent1',
            'tlinux1',
            'tmozilla1'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                tmp_ad_connection
                (
                    server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
                    operation_interval_id, interval_start, interval_end, connection_viewer_id,
                    connection_viewer_session_id, connection_date_time, connection_ad_id,
                    connection_creative_id, connection_zone_id, connection_channel, connection_language,
                    connection_ip_address, connection_host_name, connection_country, connection_https,
                    connection_domain, connection_page, connection_query, connection_referer,
                    connection_search_term, connection_user_agent, connection_os, connection_browser,
                    connection_action, connection_window, connection_status, inside_window, latest
                )
            VALUES
                (
                    2, '127.0.0.1', '2004-06-06 18:10:30', 30, 36, '2004-06-06 18:00:00',
                    '2004-06-06 18:29:59',  'aa', 1, '2004-06-06 18:00:00', 1, 1, 1, 'chan1', 'en1',
                    '127.0.0.1', 'host1', 'U1', 0, 'domain1', 'page1', 'query1', 'ref1',
                    'term1', 'agent1', 'linux1', 'mozilla1', 1, 259200,
                    " . MAX_CONNECTION_STATUS_APPROVED . ", 1, 0
                )";
        $rows = $oDbh->exec($query);
    }

    /**
     * A private method to insert a variable as test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermedaiteVariable()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                variables
                (
                    variableid,
                    trackerid
                )
            VALUES
                (
                    1,
                    1
                )";
        $rows = $oDbh->exec($query);
    }

    /**
     * A private method to insert a variable as test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermedaiteVariableAsBasket()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                variables
                (
                    variableid,
                    trackerid,
                    purpose
                )
            VALUES
                (
                    1,
                    1,
                    'basket_value'
                )";
        $rows = $oDbh->exec($query);
    }

    /**
     * A private method to insert two variable values as test data for the
     * saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermedaiteVariableValue()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                data_raw_tracker_variable_value
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    tracker_variable_id,
                    date_time,
                    value
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'integer',
            'timestamp',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            '127.0.0.1',
            1,
            '2004-06-06 18:10:16',
            '1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            '127.0.0.1',
            1,
            '2004-06-06 18:10:31',
            '2'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests the saveIntermediate() method.
     *
     * Requirements:
     * Test 1: Test with no data.
     * Test 2: Test with ad requests only.
     * Test 3: Test with ad impressions only.
     * Test 4: Test with ad clicks only.
     * Test 5: Test with ad requests, impressions and clicks.
     * Test 6: Test with tracker impressions only, where there are no
     *         associated variable values.
     * Test 7: Test with tracker impressions only, where there is an
     *         associated (non-baseket value) variable value that has NOT
     *         been collected.
     * Test 8: Test with tracker impressions only, where there is an
     *         associated (non-baseket value) variable value that HAS
     *         been collected.
     * Test 9: Test with tracker impressions only, where there is an
     *         associated (baseket value) variable value that has NOT
     *         been collected.
     * Test 10: Test with tracker impressions only, where there is an
     *          associated (baseket value) variable value that HAS
     *          been collected.
     * Test 11: Test with a combination of ad requests, impressions, clicks,
     *          and tracker impressions, with combinations of different
     *          types of variable values attached.
     */
    function testSaveIntermediate()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test 1
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $aActionTypes = array(
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
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $aRow = $oDbh->queryRow($query);

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
        TestEnv::restoreEnv();

        // Test 2
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateRequestData();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 1);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 2);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
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
        TestEnv::restoreEnv();

        // Test 3
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateImpressionData();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 0);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
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
        TestEnv::restoreEnv();

        // Test 4
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateClickData();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
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
        TestEnv::restoreEnv();

        // Test 5
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateRequestData();
        $this->_insertTestSaveIntermediateImpressionData();
        $this->_insertTestSaveIntermediateClickData();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 1);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 2);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
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
        TestEnv::restoreEnv();

        // Test 6
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
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
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
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
        $this->assertEqual($aRow['number'], 1);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 7
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermedaiteVariable();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
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
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
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
        $this->assertEqual($aRow['number'], 1);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 8
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermedaiteVariable();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $this->_insertTestSaveIntermedaiteVariableValue();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
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
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 9
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermedaiteVariableAsBasket();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
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
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
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
        $this->assertEqual($aRow['number'], 1);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 10
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermedaiteVariableAsBasket();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $this->_insertTestSaveIntermedaiteVariableValue();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
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
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 2);
        TestEnv::restoreEnv();

        // Test 11
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateRequestData();
        $this->_insertTestSaveIntermediateImpressionData();
        $this->_insertTestSaveIntermediateClickData();
        $query = "
            INSERT INTO
                variables
                (
                    variableid,
                    trackerid,
                    purpose
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            NULL
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            2,
            'basket_value'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            3,
            NULL
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            3,
            NULL
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            4,
            NULL
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,
            4,
            'basket_value'
        );
        $rows = $st->execute($aData);
        $aData = array(
            7,
            5,
            'basket_value'
        );
        $rows = $st->execute($aData);
        $aData = array(
            8,
            5,
            'basket_value'
        );
        $rows = $st->execute($aData);
        $aData = array(
            9,
            6,
            'basket_value'
        );
        $rows = $st->execute($aData);
        $aData = array(
            10,
            6,
            'num_items'
        );
        $rows = $st->execute($aData);
        $aData = array(
            11,
            7,
            'num_items'
        );
        $rows = $st->execute($aData);
        $aData = array(
            12,
            7,
            'num_items'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                data_raw_tracker_impression
                (
                    server_raw_tracker_impression_id, server_raw_ip, viewer_id, viewer_session_id,
                    date_time, tracker_id, channel, language, ip_address, host_name, country,
                    https, domain, page, query, referer, search_term, user_agent, os, browser
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'integer',
            'timestamp',
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
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, '127.0.0.1', 'aa', 1, '2004-06-06 18:10:15', 20, 'tchan1', 'ten1',
            't127.0.0.1', 'thost1', 'T1', 1, 'tdomain1', 'tpage1', 'tquery1',
            'tref1', 'tterm1', 'tagent1', 'tlinux1', 'tmozilla1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, '127.0.0.1', 'aa', 1, '2004-06-06 18:10:30', 20, 'tchan1', 'ten1',
            't127.0.0.1', 'thost1', 'T1', 1, 'tdomain1', 'tpage1', 'tquery1',
            'tref1', 'tterm1', 'tagent1', 'tlinux1', 'tmozilla1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, '127.0.0.3', 'cc', 3, '2004-06-06 18:10:33', 1, 'tchan3', 'ten3',
            't127.0.0.3', 'thost3', 'T3', 1, 'tdomain3', 'tpage3', 'tquery3',
            'tref3', 'tterm3', 'tagent3', 'tlinux3', 'tmozilla3'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, '127.0.0.3', 'cc', 3, '2004-06-06 18:10:33', 2, 'tchan3', 'ten3',
            't127.0.0.3', 'thost3', 'T3', 1, 'tdomain3', 'tpage3', 'tquery3',
            'tref3', 'tterm3', 'tagent3', 'tlinux3', 'tmozilla3'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, '127.0.0.3', 'cc', 3, '2004-06-06 18:10:33', 2, 'tchan3', 'ten3',
            't127.0.0.3', 'thost3', 'T3', 1, 'tdomain3', 'tpage3', 'tquery3',
            'tref3', 'tterm3', 'tagent3', 'tlinux3', 'tmozilla3'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, '127.0.0.6', 'ff', 6, '2004-06-06 18:10:36', 3, 'tchan6', 'ten6',
            't127.0.0.6', 'thost6', 'T6', 1, 'tdomain6', 'tpage6', 'tquery6',
            'tref6', 'tterm6', 'tagent6', 'tlinux6', 'tmozilla6'
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, '127.0.0.6', 'ff', 6, '2004-06-06 18:10:36', 4, 'tchan6', 'ten6',
            't127.0.0.6', 'thost6', 'T6', 1, 'tdomain6', 'tpage6', 'tquery6',
            'tref6', 'tterm6', 'tagent6', 'tlinux6', 'tmozilla6'
        );
        $rows = $st->execute($aData);
        $aData = array(
            8, '127.0.0.8', 'gg', 8, '2004-06-06 18:10:38', 5, 'tchan8', 'ten8',
            't127.0.0.8', 'thost8', 'T8', 1, 'tdomain8', 'tpage8', 'tquery8',
            'tref8', 'tterm8', 'tagent8', 'tlinux8', 'tmozilla8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            9, '127.0.0.9', 'hh', 9, '2004-06-06 18:10:39', 6, 'tchan9', 'ten9',
            't127.0.0.9', 'thost9', 'T9', 1, 'tdomain9', 'tpage9', 'tquery9',
            'tref9', 'tterm9', 'tagent9', 'tlinux9', 'tmozilla9'
        );
        $rows = $st->execute($aData);
        $aData = array(
            10, '127.0.0.10', 'ii', 10, '2004-06-06 18:10:40', 7, 'tchan10', 'ten10',
            't127.0.0.10', 'thost10', 'T1', 1, 'tdomain10', 'tpage10', 'tquery10',
            'tref10', 'tterm10', 'tagent10', 'tlinux10', 'tmozilla10'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                tmp_ad_connection
                (
                    server_raw_tracker_impression_id, server_raw_ip, date_time, operation_interval,
                    operation_interval_id, interval_start, interval_end, connection_viewer_id,
                    connection_viewer_session_id, connection_date_time, connection_ad_id,
                    connection_creative_id, connection_zone_id, connection_channel, connection_language,
                    connection_ip_address, connection_host_name, connection_country, connection_https,
                    connection_domain, connection_page, connection_query, connection_referer,
                    connection_search_term, connection_user_agent, connection_os, connection_browser,
                    connection_action, connection_window, connection_status, inside_window, latest
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'timestamp',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
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
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            2, '127.0.0.1', '2004-06-06 18:10:30', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'aa', 1, '2004-06-06 18:00:00', 1, 1, 1, 'chan1', 'en1',
            '127.0.0.1', 'host1', 'U1', 0, 'domain1', 'page1', 'query1', 'ref1',
            'term1', 'agent1', 'linux1', 'mozilla1', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, '127.0.0.3', '2004-06-06 18:10:33', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'cc', 3, '2004-06-06 18:00:34', 2, 2, 2, 'chan3', 'en3',
            '127.0.0.3', 'host3', 'U3', 0, 'domain3', 'page3', 'query3', 'ref3',
            'term3', 'agent3', 'linux3', 'mozilla3', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, '127.0.0.3', '2004-06-06 18:10:33', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'cc', 3, '2004-06-06 18:00:34', 2, 2, 2, 'chan3', 'en3',
            '127.0.0.3', 'host3', 'U3', 0, 'domain3', 'page3', 'query3', 'ref3',
            'term3', 'agent3', 'linux3', 'mozilla3', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, '127.0.0.3', '2004-06-06 18:10:33', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'cc', 3, '2004-06-06 18:00:34', 2, 2, 2, 'chan3', 'en3',
            '127.0.0.3', 'host3', 'U3', 0, 'domain3', 'page3', 'query3', 'ref3',
            'term3', 'agent3', 'linux3', 'mozilla3', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, '127.0.0.6', '2004-06-06 18:10:36', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'ff', 6, '2004-06-06 18:00:36', 3, 3, 3, 'chan6', 'en6',
            '127.0.0.6', 'host6', 'U6', 0, 'domain6', 'page6', 'query6', 'ref6',
            'term6', 'agent6', 'linux6', 'mozilla6', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, '127.0.0.6', '2004-06-06 18:10:36', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'ff', 6, '2004-06-06 18:00:36', 3, 3, 3, 'chan6', 'en6',
            '127.0.0.6', 'host6', 'U6', 0, 'domain6', 'page6', 'query6', 'ref6',
            'term6', 'agent6', 'linux6', 'mozilla6', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            8, '127.0.0.8', '2004-06-06 18:10:38', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'gg', 8, '2004-06-06 18:00:38', 1, 1, 1, 'chan8', 'en8',
            '127.0.0.8', 'host8', 'U8', 0, 'domain8', 'page8', 'query8', 'ref8',
            'term8', 'agent8', 'linux8', 'mozilla8', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            9, '127.0.0.9', '2004-06-06 18:10:39', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'hh', 9, '2004-06-06 18:00:39', 1, 1, 1, 'chan9', 'en9',
            '127.0.0.9', 'host9', 'U9', 0, 'domain9', 'page9', 'query9', 'ref9',
            'term9', 'agent9', 'linux9', 'mozilla9', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            10, '127.0.0.10', '2004-06-06 18:10:40', 30, 36, '2004-06-06 18:00:00',
            '2004-06-06 18:29:59',  'ii', 10, '2004-06-06 18:00:40', 1, 1, 1, 'chan10', 'en10',
            '127.0.0.10', 'host10', 'U1', 0, 'domain10', 'page10', 'query10', 'ref10',
            'term10', 'agent10', 'linux10', 'mozilla10', 1, 259200, MAX_CONNECTION_STATUS_APPROVED, 1, 0
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                data_raw_tracker_variable_value
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    tracker_variable_id,
                    date_time,
                    value
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'integer',
            'timestamp',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            3, '127.0.0.3', 1, '2004-06-06 18:10:34', '37'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, '127.0.0.3', 2, '2004-06-06 18:10:34', '8'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, '127.0.0.6', 3, '2004-06-06 18:10:37', '10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, '127.0.0.6', 4, '2004-06-06 18:10:37', '11'
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, '127.0.0.6', 5, '2004-06-06 18:10:37', '10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, '127.0.0.6', 6, '2004-06-06 18:10:37', '11'
        );
        $rows = $st->execute($aData);
        $aData = array(
            8, '127.0.0.8', 7, '2004-06-06 18:10:39', '1'
        );
        $rows = $st->execute($aData);
        $aData = array(
            8, '127.0.0.8', 8, '2004-06-06 18:10:39', '2'
        );
        $rows = $st->execute($aData);
        $aData = array(
            9, '127.0.0.9', 9, '2004-06-06 18:10:39', '10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            9, '127.0.0.9', 10, '2004-06-06 18:10:39', '2'
        );
        $rows = $st->execute($aData);
        $aData = array(
            10, '127.0.0.10', 11, '2004-06-06 18:10:40', '5'
        );
        $rows = $st->execute($aData);
        $aData = array(
            10, '127.0.0.10', 12, '2004-06-06 18:10:40', '2'
        );
        $rows = $st->execute($aData);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 9);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 20);
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
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 3
                AND server_raw_ip = '127.0.0.3'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.3');
        $this->assertEqual($aRow['viewer_id'], 'cc');
        $this->assertEqual($aRow['viewer_session_id'], 3);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:33');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:34');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan3');
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['tracker_language'], 'ten3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['tracker_host_name'], 'thost3');
        $this->assertEqual($aRow['connection_host_name'], 'host3');
        $this->assertEqual($aRow['tracker_country'], 'T3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain3');
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['tracker_page'], 'tpage3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['tracker_query'], 'tquery3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['tracker_referer'], 'tref3');
        $this->assertEqual($aRow['connection_referer'], 'ref3');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['tracker_os'], 'tlinux3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 4
                AND server_raw_ip = '127.0.0.3'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 4);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.3');
        $this->assertEqual($aRow['viewer_id'], 'cc');
        $this->assertEqual($aRow['viewer_session_id'], 3);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:33');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:34');
        $this->assertEqual($aRow['tracker_id'], 2);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan3');
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['tracker_language'], 'ten3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['tracker_host_name'], 'thost3');
        $this->assertEqual($aRow['connection_host_name'], 'host3');
        $this->assertEqual($aRow['tracker_country'], 'T3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain3');
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['tracker_page'], 'tpage3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['tracker_query'], 'tquery3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['tracker_referer'], 'tref3');
        $this->assertEqual($aRow['connection_referer'], 'ref3');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['tracker_os'], 'tlinux3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 5
                AND server_raw_ip = '127.0.0.3'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 5);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.3');
        $this->assertEqual($aRow['viewer_id'], 'cc');
        $this->assertEqual($aRow['viewer_session_id'], 3);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:33');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:34');
        $this->assertEqual($aRow['tracker_id'], 2);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan3');
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['tracker_language'], 'ten3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['tracker_host_name'], 'thost3');
        $this->assertEqual($aRow['connection_host_name'], 'host3');
        $this->assertEqual($aRow['tracker_country'], 'T3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain3');
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['tracker_page'], 'tpage3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['tracker_query'], 'tquery3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['tracker_referer'], 'tref3');
        $this->assertEqual($aRow['connection_referer'], 'ref3');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['tracker_os'], 'tlinux3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 6
                AND server_raw_ip = '127.0.0.6'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 6);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.6');
        $this->assertEqual($aRow['viewer_id'], 'ff');
        $this->assertEqual($aRow['viewer_session_id'], 6);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:36');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:36');
        $this->assertEqual($aRow['tracker_id'], 3);
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['tracker_channel'], 'tchan6');
        $this->assertEqual($aRow['connection_channel'], 'chan6');
        $this->assertEqual($aRow['tracker_language'], 'ten6');
        $this->assertEqual($aRow['connection_language'], 'en6');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.6');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.6');
        $this->assertEqual($aRow['tracker_host_name'], 'thost6');
        $this->assertEqual($aRow['connection_host_name'], 'host6');
        $this->assertEqual($aRow['tracker_country'], 'T6');
        $this->assertEqual($aRow['connection_country'], 'U6');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain6');
        $this->assertEqual($aRow['connection_domain'], 'domain6');
        $this->assertEqual($aRow['tracker_page'], 'tpage6');
        $this->assertEqual($aRow['connection_page'], 'page6');
        $this->assertEqual($aRow['tracker_query'], 'tquery6');
        $this->assertEqual($aRow['connection_query'], 'query6');
        $this->assertEqual($aRow['tracker_referer'], 'tref6');
        $this->assertEqual($aRow['connection_referer'], 'ref6');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm6');
        $this->assertEqual($aRow['connection_search_term'], 'term6');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent6');
        $this->assertEqual($aRow['connection_user_agent'], 'agent6');
        $this->assertEqual($aRow['tracker_os'], 'tlinux6');
        $this->assertEqual($aRow['connection_os'], 'linux6');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla6');
        $this->assertEqual($aRow['connection_browser'], 'mozilla6');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 7
                AND server_raw_ip = '127.0.0.6'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 7);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.6');
        $this->assertEqual($aRow['viewer_id'], 'ff');
        $this->assertEqual($aRow['viewer_session_id'], 6);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:36');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:36');
        $this->assertEqual($aRow['tracker_id'], 4);
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['tracker_channel'], 'tchan6');
        $this->assertEqual($aRow['connection_channel'], 'chan6');
        $this->assertEqual($aRow['tracker_language'], 'ten6');
        $this->assertEqual($aRow['connection_language'], 'en6');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.6');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.6');
        $this->assertEqual($aRow['tracker_host_name'], 'thost6');
        $this->assertEqual($aRow['connection_host_name'], 'host6');
        $this->assertEqual($aRow['tracker_country'], 'T6');
        $this->assertEqual($aRow['connection_country'], 'U6');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain6');
        $this->assertEqual($aRow['connection_domain'], 'domain6');
        $this->assertEqual($aRow['tracker_page'], 'tpage6');
        $this->assertEqual($aRow['connection_page'], 'page6');
        $this->assertEqual($aRow['tracker_query'], 'tquery6');
        $this->assertEqual($aRow['connection_query'], 'query6');
        $this->assertEqual($aRow['tracker_referer'], 'tref6');
        $this->assertEqual($aRow['connection_referer'], 'ref6');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm6');
        $this->assertEqual($aRow['connection_search_term'], 'term6');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent6');
        $this->assertEqual($aRow['connection_user_agent'], 'agent6');
        $this->assertEqual($aRow['tracker_os'], 'tlinux6');
        $this->assertEqual($aRow['connection_os'], 'linux6');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla6');
        $this->assertEqual($aRow['connection_browser'], 'mozilla6');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 8
                AND server_raw_ip = '127.0.0.8'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 8);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.8');
        $this->assertEqual($aRow['viewer_id'], 'gg');
        $this->assertEqual($aRow['viewer_session_id'], 8);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:38');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:38');
        $this->assertEqual($aRow['tracker_id'], 5);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan8');
        $this->assertEqual($aRow['connection_channel'], 'chan8');
        $this->assertEqual($aRow['tracker_language'], 'ten8');
        $this->assertEqual($aRow['connection_language'], 'en8');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.8');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.8');
        $this->assertEqual($aRow['tracker_host_name'], 'thost8');
        $this->assertEqual($aRow['connection_host_name'], 'host8');
        $this->assertEqual($aRow['tracker_country'], 'T8');
        $this->assertEqual($aRow['connection_country'], 'U8');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain8');
        $this->assertEqual($aRow['connection_domain'], 'domain8');
        $this->assertEqual($aRow['tracker_page'], 'tpage8');
        $this->assertEqual($aRow['connection_page'], 'page8');
        $this->assertEqual($aRow['tracker_query'], 'tquery8');
        $this->assertEqual($aRow['connection_query'], 'query8');
        $this->assertEqual($aRow['tracker_referer'], 'tref8');
        $this->assertEqual($aRow['connection_referer'], 'ref8');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm8');
        $this->assertEqual($aRow['connection_search_term'], 'term8');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent8');
        $this->assertEqual($aRow['connection_user_agent'], 'agent8');
        $this->assertEqual($aRow['tracker_os'], 'tlinux8');
        $this->assertEqual($aRow['connection_os'], 'linux8');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla8');
        $this->assertEqual($aRow['connection_browser'], 'mozilla8');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 9
                AND server_raw_ip = '127.0.0.9'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 9);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.9');
        $this->assertEqual($aRow['viewer_id'], 'hh');
        $this->assertEqual($aRow['viewer_session_id'], 9);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:39');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:39');
        $this->assertEqual($aRow['tracker_id'], 6);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan9');
        $this->assertEqual($aRow['connection_channel'], 'chan9');
        $this->assertEqual($aRow['tracker_language'], 'ten9');
        $this->assertEqual($aRow['connection_language'], 'en9');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.9');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.9');
        $this->assertEqual($aRow['tracker_host_name'], 'thost9');
        $this->assertEqual($aRow['connection_host_name'], 'host9');
        $this->assertEqual($aRow['tracker_country'], 'T9');
        $this->assertEqual($aRow['connection_country'], 'U9');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain9');
        $this->assertEqual($aRow['connection_domain'], 'domain9');
        $this->assertEqual($aRow['tracker_page'], 'tpage9');
        $this->assertEqual($aRow['connection_page'], 'page9');
        $this->assertEqual($aRow['tracker_query'], 'tquery9');
        $this->assertEqual($aRow['connection_query'], 'query9');
        $this->assertEqual($aRow['tracker_referer'], 'tref9');
        $this->assertEqual($aRow['connection_referer'], 'ref9');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm9');
        $this->assertEqual($aRow['connection_search_term'], 'term9');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent9');
        $this->assertEqual($aRow['connection_user_agent'], 'agent9');
        $this->assertEqual($aRow['tracker_os'], 'tlinux9');
        $this->assertEqual($aRow['connection_os'], 'linux9');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla9');
        $this->assertEqual($aRow['connection_browser'], 'mozilla9');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 10
                AND server_raw_ip = '127.0.0.10'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 10);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.10');
        $this->assertEqual($aRow['viewer_id'], 'ii');
        $this->assertEqual($aRow['viewer_session_id'], 10);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:40');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:40');
        $this->assertEqual($aRow['tracker_id'], 7);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan10');
        $this->assertEqual($aRow['connection_channel'], 'chan10');
        $this->assertEqual($aRow['tracker_language'], 'ten10');
        $this->assertEqual($aRow['connection_language'], 'en10');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.10');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.10');
        $this->assertEqual($aRow['tracker_host_name'], 'thost10');
        $this->assertEqual($aRow['connection_host_name'], 'host10');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain10');
        $this->assertEqual($aRow['connection_domain'], 'domain10');
        $this->assertEqual($aRow['tracker_page'], 'tpage10');
        $this->assertEqual($aRow['connection_page'], 'page10');
        $this->assertEqual($aRow['tracker_query'], 'tquery10');
        $this->assertEqual($aRow['connection_query'], 'query10');
        $this->assertEqual($aRow['tracker_referer'], 'tref10');
        $this->assertEqual($aRow['connection_referer'], 'ref10');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm10');
        $this->assertEqual($aRow['connection_search_term'], 'term10');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent10');
        $this->assertEqual($aRow['connection_user_agent'], 'agent10');
        $this->assertEqual($aRow['tracker_os'], 'tlinux10');
        $this->assertEqual($aRow['connection_os'], 'linux10');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla10');
        $this->assertEqual($aRow['connection_browser'], 'mozilla10');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 12);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 37);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 8);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 1);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 8";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 9";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 10";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 11";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 5);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 12";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 4);
        $this->assertEqual($aRow['total_basket_value'], 13);
        $this->assertEqual($aRow['total_num_items'], 9);
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
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 2);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 3);
        $this->assertEqual($aRow['total_basket_value'], 8);
        $this->assertEqual($aRow['total_num_items'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 2);
        $this->assertEqual($aRow['total_basket_value'], 11);
        $this->assertEqual($aRow['total_num_items'], 0);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the saveHistory() method.
     */
    function testSaveHistory()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end   = new Date('2004-06-06 12:29:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::startTransaction();
        // Insert the test data
        $query = "
            INSERT INTO
                data_intermediate_ad
                (
                    day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
                    ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $stDIA = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 2, 1, 1, 1, 1, 0, 0
        );
        $rows = $stDIA->execute($aData);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end   = new Date('2004-06-06 18:29:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 4);
        // Insert more test data
        $aData = array(
            '2004-06-06', 18, 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 2, 1, 1, 1, 1, 0, 0
        );
        $rows = $stDIA->execute($aData);
        // Test
        $start = new Date('2004-06-06 18:30:00');
        $end   = new Date('2004-06-06 18:59:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval_id = 37";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 37);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:30:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 4);
        // Insert some predicted values into the data_summary_zone_impression_history table
        $query = "
            INSERT INTO
                data_summary_zone_impression_history
                (
                    operation_interval, operation_interval_id, interval_start, interval_end, zone_id, actual_impressions
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 0
        );
        $rows = $st->execute($aData);
        // Test
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval_id = 38";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 38);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 19:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 19:29:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 0);
        // Insert more test data
        $aData = array(
            '2004-06-06', 18, 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 2, 1, 1, 1, 1, 0, 0
        );
        $rows = $stDIA->execute($aData);
        // Test
        $start = new Date('2004-06-06 19:00:00');
        $end   = new Date('2004-06-06 19:29:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval_id = 38";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 38);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 19:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 19:29:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 4);
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * A private method to insert placements as test data for the
     * saveSummary() test.
     *
     * @access private
     */
    function _insertTestSaveSummaryPlacement()
    {
        $oDbh = & OA_DB::singleton();
        $query = "
            INSERT INTO
                campaigns
                (
                    campaignid,
                    revenue,
                    revenue_type
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 5000, MAX_FINANCE_CPM
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 2, MAX_FINANCE_CPC
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 4, MAX_FINANCE_CPA
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert ads as test data for the
     * saveSummary() test.
     *
     * @access private
     */
    function _insertTestSaveSummaryAd()
    {
        $oDbh = & OA_DB::singleton();
        $query = "
            INSERT INTO
                banners
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (?, ?)";
        $aTypes = array(
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 2
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 3
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, 3
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert zones as test data for the
     * saveSummary() test.
     *
     * @access private
     */
    function _insertTestSaveSummaryZone()
    {
        $oDbh = & OA_DB::singleton();
        $query = "
            INSERT INTO
                zones
                (
                    zoneid, cost, cost_type
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'float',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 20, MAX_FINANCE_CPM
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 1, MAX_FINANCE_CPC
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 2, MAX_FINANCE_CPA
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, 50, MAX_FINANCE_RS
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, 5, MAX_FINANCE_BV
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, 0.5, MAX_FINANCE_AI
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests the saveSummary() method.
     *
     * Requirements:
     * Test 1: Test with no data.
     * Test 2: Test a single day summarisation.
     * Test 3: Test multi-day summarisation.
     */
    function testSaveSummary()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test 1
        $start = new Date('2004-06-06 12:00:00');
        $end   = new Date('2004-06-06 12:29:59');
        $aActionTypes = array(
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
        $dsa->saveSummary($start, $end, $aActionTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);

        // Test 2
        TestEnv::startTransaction();
        // Insert the test data
        $this->_insertTestSaveSummaryPlacement();
        $this->_insertTestSaveSummaryAd();
        $this->_insertTestSaveSummaryZone();
        $query = "
            INSERT INTO
                data_intermediate_ad
                (
                    day, hour, operation_interval, operation_interval_id, interval_start, interval_end,
                    ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value, total_num_items
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 1, 1, 1, 1, 1, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 2, 1, 1, 1, 1, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 2, 1, 1, 1, 1, 1, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 2, 1, 1, 1, 1, 0, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 3, 1, 2, 1, 1, 0, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 4, 1, 3, 1, 1, 5, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 4, 1, 4, 1, 1, 5, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 4, 1, 5, 1, 1, 5, 100, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 4, 1, 6, 1, 1, 5, 100, 3
        );
        $rows = $st->execute($aData);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end   = new Date('2004-06-06 18:29:59');
        $dsa->saveSummary($start, $end, $aActionTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 8);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 1);
        $this->assertEqual($aRow['total_revenue'], 5);
        $this->assertEqual($aRow['total_cost'], 0.02);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 2);
        $this->assertEqual($aRow['total_basket_value'], 2);
        $this->assertEqual($aRow['total_revenue'], 10);
        $this->assertEqual($aRow['total_cost'], 0.04);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 2);
        $this->assertEqual($aRow['total_cost'], 0.02);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 0);
        $this->assertEqual($aRow['total_cost'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 4
            ORDER BY
                zone_id";
        $rc = $oDbh->query($query);
        $this->assertEqual($rc->numRows(), 4);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 10);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 10);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 5);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 100);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 5);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 6);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 100);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 1.5);
        TestEnv::rollbackTransaction();

        // Test 3
        TestEnv::startTransaction();
        // Insert the test data
        $this->_insertTestSaveSummaryPlacement();
        $this->_insertTestSaveSummaryAd();
        $this->_insertTestSaveSummaryZone();
        $aData = array(
            '2004-06-06', 18, 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-07', 18, 30, 36, '2004-06-07 18:00:00', '2004-06-07 18:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-07', 18, 30, 36, '2004-06-07 18:00:00', '2004-06-07 18:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-08', 18, 30, 36, '2004-06-08 18:00:00', '2004-06-08 18:29:59', 2, 1, 1, 1, 1, 0, 0
        );
        $rows = $st->execute($aData);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end   = new Date('2004-06-08 18:29:59');
        $dsa->saveSummary($start, $end, $aActionTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 1);
        $this->assertEqual($aRow['total_revenue'], 5);
        $this->assertEqual($aRow['total_cost'], 0.02);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-07');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 2);
        $this->assertEqual($aRow['total_basket_value'], 2);
        $this->assertEqual($aRow['total_revenue'], 10);
        $this->assertEqual($aRow['total_cost'], 0.04);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-08');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 2);
        $this->assertEqual($aRow['total_cost'], 0.02);
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * Tests the manageCampaigns() method.
     */
    function testManageCampaigns()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 60;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $oDate = new Date();
        TestEnv::startTransaction();
        // Insert the base test data
        $query = "
            INSERT INTO
                campaigns
                (
                    campaignid, campaignname, clientid, views, clicks, conversions, expire, activate, active
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 'Test Campaign 1', 1, -1, -1, -1, '0000-00-00', '0000-00-00', 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 'Test Campaign 2', 1, 10, -1, -1, '0000-00-00', '0000-00-00', 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 'Test Campaign 3', 1, -1, 10, -1, '0000-00-00', '0000-00-00', 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, 'Test Campaign 4', 1, -1, -1, 10, '0000-00-00', '0000-00-00', 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, 'Test Campaign 5', 1, 10, 10, 10, '0000-00-00', '0000-00-00', 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, 'Test Campaign 6', 1, -1, -1, -1, '2004-06-06', '0000-00-00', 't'
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, 'Test Campaign 7', 1, -1, -1, -1, '0000-00-00', '2004-06-06', 'f'
        );
        $rows = $st->execute($aData);
        $query = "
            INSERT INTO
                clients
                (
                    clientid, contact, email
                )
            VALUES
                (
                    1, 'Test Contact', 'postmaster@localhost'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                banners
                (
                    bannerid, campaignid
                )
            VALUES
                (?, ?)";
        $aTypes = array(
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            2, 2
        );
        $rows = $st->execute($aData);
        $aData = array(
            3, 2
        );
        $rows = $st->execute($aData);
        $aData = array(
            4, 2
        );
        $rows = $st->execute($aData);
        $aData = array(
            5, 3
        );
        $rows = $st->execute($aData);
        $aData = array(
            6, 4
        );
        $rows = $st->execute($aData);
        $aData = array(
            7, 5
        );
        $rows = $st->execute($aData);
        $aData = array(
            8, 6
        );
        $rows = $st->execute($aData);
        $aData = array(
            9, 7
        );
        $rows = $st->execute($aData);
        // Test with no summarised data
        $report = $dsa->manageCampaigns($oDate);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        // Insert the summary test data - Part 1
        $query = "
            INSERT INTO
                data_intermediate_ad
                (
                    interval_start, interval_end, ad_id, impressions, clicks, conversions
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 1, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 2, 1, 1, 1
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 3, 1, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 4, 8, 0, 0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 5, 1000, 5, 1000
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 6, 1000, 1000, 1000
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 7, 2, 4, 6
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00', '2004-06-06 17:59:59', 8, 2, 4, 6
        );
        $rows = $st->execute($aData);
        // Test with summarised data
        $report = $dsa->manageCampaigns($oDate);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        TestEnv::rollbackTransaction();
        // Final test to ensure that placements expired as a result of limitations met are
        // not re-activated in the event that their expiration date has not yet been reached
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                campaigns
                    (
                        campaignid,
                        campaignname,
                        clientid,
                        views,
                        clicks,
                        conversions,
                        expire,
                        activate,
                        active
                    )
                VALUES
                    (
                        1,
                        'Test Campaign 1',
                        1,
                        10,
                        -1,
                        -1,
                        '2005-12-09',
                        '2005-12-07',
                        'f'
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                clients
                    (
                        clientid,
                        contact,
                        email
                    )
                VALUES
                    (
                        1,
                        'Test Contact',
                        'postmaster@localhost'
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                banners
                    (
                        bannerid,
                        campaignid
                    )
                VALUES
                    (
                        1,
                        1
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                data_intermediate_ad
                    (
                        interval_start,
                        interval_end,
                        ad_id,
                        impressions,
                        clicks,
                        conversions
                    )
                VALUES
                    (
                        '2005-12-08 00:00:00',
                        '2004-12-08 00:59:59',
                        1,
                        100,
                        1,
                        0
                     )";
        $rows = $oDbh->exec($query);
        $oDate = &new Date('2005-12-08 01:00:01');
        $report = $dsa->manageCampaigns($oDate);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2005-12-09');
        $this->assertEqual($aRow['activate'], '2005-12-07');
        $this->assertEqual($aRow['active'], 'f');
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * A private method to insert campaign trackers links as test data for the
     * deleteOldData() test.
     *
     * @access private
     */
    function _insertTestDeleteOldDataCampaignsTrackers()
    {
        $oDbh = & OA_DB::singleton();
        $query = "
            INSERT INTO
                campaigns_trackers
                (
                    viewwindow,
                    clickwindow
                )
            VALUES
                (?, ?)";


        $aTypes = array(
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            0, 60
        );
        $rows = $st->execute($aData);
        $aData = array(
            0, 3600
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert ad requests/impressions/clicks as test
     * data for the deleteOldData() test.
     *
     * @access private
     */
    function _insertTestDeleteOldDataAdItems($table)
    {
        $oDbh = & OA_DB::singleton();
        $query = "
            INSERT INTO
                $table
                (
                    date_time
                )
            VALUES
                (?)";
        $aTypes = array(
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests the deleteOldData() method.
     */
    function testDeleteOldData()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        TestEnv::startTransaction();
        // Insert the test data
        $this->_insertTestDeleteOldDataCampaignsTrackers();
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_request');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_impression');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_click');
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::rollbackTransaction();
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        TestEnv::startTransaction();
        // Insert the test data
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_request');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_impression');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_click');
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::rollbackTransaction();
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;
        $dsa = $oMDMSF->factory("AdServer");
        TestEnv::startTransaction();
        // Insert the test data
        $this->_insertTestDeleteOldDataCampaignsTrackers();
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_request');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_impression');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_click');
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::rollbackTransaction();
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        TestEnv::startTransaction();
        // Insert the test data
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_request');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_impression');
        $this->_insertTestDeleteOldDataAdItems('data_raw_ad_click');
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

}

?>
