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

// pgsql execution time before refactor: 42.287s
// pgsql execution time after refactor: s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_SaveHistory extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_SaveHistory()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests the saveHistory() method.
     */
    function testSaveHistory()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $aConf['maintenance']['operationInterval'] = 30;

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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Insert the test data
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)."
                (
                    date_time, operation_interval, operation_interval_id, interval_start, interval_end,
                    ad_id, creative_id, zone_id, impressions, clicks, conversions, total_basket_value
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
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
            'float'
        );
        $stDIA = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-06-06 18:00:00', 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 36, '2004-06-06 18:00:00', '2004-06-06 18:29:59', 2, 1, 1, 1, 1, 0, 0
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
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
            '2004-06-06 18:00:00', 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 37, '2004-06-06 18:30:00', '2004-06-06 18:59:59', 2, 1, 1, 1, 1, 0, 0
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true)."
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true)."
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
            '2004-06-06 18:00:00', 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 1, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 1, 2, 1, 1, 1, 1, 1
        );
        $rows = $stDIA->execute($aData);
        $aData = array(
            '2004-06-06 18:00:00', 30, 38, '2004-06-06 19:00:00', '2004-06-06 19:29:59', 2, 1, 1, 1, 1, 0, 0
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
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_summary_zone_impression_history'],true)."
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
        TestEnv::restoreEnv();
        TestEnv::restoreConfig();
    }
}

?>
