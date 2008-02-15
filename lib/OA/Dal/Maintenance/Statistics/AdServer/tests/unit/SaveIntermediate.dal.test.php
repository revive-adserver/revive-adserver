<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';

// BROKEN
// pgsql execution time before refactor: 53.061s
// pgsql execution time after refactor: s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_SaveIntermediate extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_SaveIntermediate()
    {
        $this->UnitTestCase();
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
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Test 1
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();

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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $aRow = $oDbh->queryRow($query);

        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 2
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 3
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 4
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 5
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 6
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariable();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariable();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $this->_insertTestSaveIntermediateVariableValue();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariableAsBasket();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariableAsBasket();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $this->_insertTestSaveIntermediateVariableValue();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_impression'],true)."
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
        $tmpTable = $oDbh->quoteIdentifier('tmp_ad_connection',true);
        $query = "
            INSERT INTO
                {$tmpTable}
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_variable_value'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 9);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 12);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 37);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 8);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 1);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 8";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 9";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 10";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 11";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 5);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 12";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['date_time'], '2004-06-06 18:00:00');
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
     * A private method to insert request test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateRequestData()
    {
        $oDbh =& OA_DB::singleton();
        $tmpTable = $oDbh->quoteIdentifier('tmp_ad_request',true);
        $query = "
            INSERT INTO
            {$tmpTable}
                (
                    date_time,
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
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
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
            '2004-06-06 18:00:00',
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
            '2004-06-06 18:00:00',
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
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier('tmp_ad_impression',true)."
                (
                    date_time,
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
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
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
            '2004-06-06 18:00:00',
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
            '2004-06-06 18:00:00',
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
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier('tmp_ad_click',true)."
                (
                    date_time,
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
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
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
            '2004-06-06 18:00:00',
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
            '2004-06-06 18:00:00',
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
            '2004-06-06 18:00:00',
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
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_impression'],true)."
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
                ".$oDbh->quoteIdentifier('tmp_ad_connection',true)."
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
    function _insertTestSaveIntermediateVariableAsBasket()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
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
     * A private method to insert a variable as test data for the saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateVariable()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
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
     * A private method to insert two variable values as test data for the
     * saveIntermediate() test.
     *
     * @access private
     */
    function _insertTestSaveIntermediateVariableValue()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_variable_value'],true)."
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


// OLD_ METHODS START HERE


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
    function OLD_testSaveIntermediate()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Test 1
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();

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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $aRow = $oDbh->queryRow($query);

        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 2
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 3
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 4
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 5
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 6
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariable();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariable();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $this->_insertTestSaveIntermediateVariableValue();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariableAsBasket();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $this->_insertTestSaveIntermediateVariableAsBasket();
        $this->_insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection();
        $this->_insertTestSaveIntermediateVariableValue();
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aActionTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
        $aConf['maintenance']['operationInterval'] = 30;
        $oDbh =& OA_DB::singleton();
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_impression'],true)."
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
        $tmpTable = $oDbh->quoteIdentifier('tmp_ad_connection',true);
        $query = "
            INSERT INTO
                {$tmpTable}
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_variable_value'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 9);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 12);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 37);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 8);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 1);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 8";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 9";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 10";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 11";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 5);
        $query = "
            SELECT
                value
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
            WHERE
                tracker_variable_id = 12";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
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
     * A private method to insert request test data for the saveIntermediate() test.
     *
     * @access private
     */
    function OLD__insertTestSaveIntermediateRequestData()
    {
        $oDbh =& OA_DB::singleton();
        $tmpTable = $oDbh->quoteIdentifier('tmp_ad_request',true);
        $query = "
            INSERT INTO
            {$tmpTable}
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
    function OLD__insertTestSaveIntermediateImpressionData()
    {
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier('tmp_ad_impression',true)."
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
    function OLD__insertTestSaveIntermediateClickData()
    {
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier('tmp_ad_click',true)."
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
    function OLD__insertTestSaveIntermediateTrackerImpressionAndTmpAdConnection()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_impression'],true)."
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
                ".$oDbh->quoteIdentifier('tmp_ad_connection',true)."
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
    function OLD__insertTestSaveIntermediateVariableAsBasket()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
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
     * A private method to insert a variable as test data for the saveIntermediate() test.
     *
     * @access private
     */
    function OLD__insertTestSaveIntermediateVariable()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
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
     * A private method to insert two variable values as test data for the
     * saveIntermediate() test.
     *
     * @access private
     */
    function OLD__insertTestSaveIntermediateVariableValue()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_raw_tracker_variable_value'],true)."
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

}

?>
