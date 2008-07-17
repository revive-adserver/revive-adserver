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

// pgsql execution time before refactor: s
// pgsql execution time after refactor: s

// BROKEN : BAD MYSQL IN /lib/OA/Dal/Maintenance/Statistics/Common.php _summariseData()
/*
_doQuery: [Error message: Could not execute statement]
[Last executed query:
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
                        SELECT
                            tuilo.day AS day,
                            tuilo.hour AS hour,
                            tuilo.operation_interval AS operation_interval,
                            tuilo.operation_interval_id AS operation_interval_id,
                            tuilo.interval_start AS interval_start,
                            tuilo.interval_end AS interval_end,
                            tuilo.ad_id AS ad_id,
                            tuilo.creative_id AS creative_id,
                            tuilo.zone_id AS zone_id,
                            SUM(tuilo.impressions) AS impressions
                        FROM
                            tmp_union_ignore_log_once AS tuilo
                        GROUP BY
                            day, hour, operation_interval, operation_interval_id, interval_start, interval_end, ad_id, creative_id, zone_id]
[Native message: ERROR:  failed to find conversion function from "unknown" to text]
*/

// pgsql execution time before refactor: s
// pgsql execution time after refactor: s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_SummariseData extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_SummariseData()
    {
        $this->UnitTestCase();
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
        $oDbh =& OA_DB::singleton();
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($table,true)."
                (
                    viewer_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    date_time
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);

        // A single item in 2004-05-06 12:30:00 to 12:59:59
        $aData = array(
            'viewer1',
            1,
            0,
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);

        // All items from here are in 2004-06-06 18:00:00 to 18:29:29!

        // A duplicate item within the same second
        $aData = array(
            'viewer1',
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            'viewer1',
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);

        // An item from a viewer that's different to all the others
        $aData = array(
            'viewer2',
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);

        // An item with a different ad_id to all the others
        $aData = array(
            'viewer1',
            2,
            0,
            1,
            '2004-06-06 18:22:15'
        );
        $rows = $st->execute($aData);

        // An item that's less than 10 seconds after the first item in the group
        $aData = array(
            'viewer1',
            1,
            0,
            1,
            '2004-06-06 18:22:19'
        );
        $rows = $st->execute($aData);

        // An item that's more than 10 seconds after the first item in the group,
        // but less than 10 seconds since the most recent impression
        $aData = array(
            'viewer1',
            1,
            0,
            1,
            '2004-06-06 18:22:21'
        );
        $rows = $st->execute($aData);

        // Finally, an item much later on
        $aData = array(
            'viewer1',
            1,
            0,
            1,
            '2004-06-06 18:22:51'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests the _summariseData() method.
     */
    function test_summariseData()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Types to be tested
        $aType = array(
            'request'    => $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request'],
            'impression' => $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression'],
            'click'      => $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click'],
        );

        // Blocking times to test, these are fixed values based to work with
        // the times set in the _insertTestSummariseData() method above
        $aBLockingTimes = array(
            0 => 0,
            1 => 10
        );

        $oDbh =& OA_DB::singleton();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        foreach ($aBLockingTimes as $blockingTime) {
            foreach ($aType as $type => $table) {

                $aConf['maintenance']['operationInterval']  = 30;
                $aConf['maintenance']['blockAdImpressions'] = $blockingTime;
                $aConf['maintenance']['blockAdClicks']      = $blockingTime;

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
                        tmp_ad_{$type}
                    WHERE
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 0);
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 0);

                // Insert eight ad requests/impressions/clicks
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
                        tmp_ad_{$type}
                    WHERE
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 0);
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        ad_id = 2";
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
                        tmp_ad_{$type}
                    WHERE
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 1);
                $query = "
                    SELECT
                        $returnColumnName AS $returnColumnName
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow[$returnColumnName], 1);
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 0);
                $query = "
                    SELECT
                        $returnColumnName AS $returnColumnName
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow[$returnColumnName], 0);

                // Summarise where the other seven requests/impressions/clicks exist
                $start = new Date('2004-06-06 18:00:00');
                $end = new Date('2004-06-06 18:29:59');
                $rows = $dsa->_summariseData($start, $end, $type);
                $this->assertEqual($rows, 2);
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 1);
                $query = "
                    SELECT
                        $returnColumnName AS $returnColumnName
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow[$returnColumnName], 1);
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 0);
                $query = "
                    SELECT
                        $returnColumnName AS $returnColumnName
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow[$returnColumnName], 0);
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-05-06'
                        AND
                        date_time < '2004-05-07'
                        AND
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 1);
                $query = "
                    SELECT
                        $returnColumnName AS $returnColumnName
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-06-06'
                        AND
                        date_time < '2004-06-07'
                        AND
                        ad_id = 1";
                $aRow = $oDbh->queryRow($query);
                if ($type == 'request' || $blockingTime == 0) {
                    $this->assertEqual($aRow[$returnColumnName], 6);
                } else {
                    $this->assertEqual($aRow[$returnColumnName], 3);
                }
                $query = "
                    SELECT
                        COUNT(*) AS number
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-06-06'
                        AND
                        date_time < '2004-06-07'
                        AND
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow['number'], 1);
                $query = "
                    SELECT
                        $returnColumnName AS $returnColumnName
                    FROM
                        tmp_ad_{$type}
                    WHERE
                        date_time >= '2004-06-06'
                        AND
                        date_time < '2004-06-07'
                        AND
                        ad_id = 2";
                $aRow = $oDbh->queryRow($query);
                $this->assertEqual($aRow[$returnColumnName], 1);
                TestEnv::restoreEnv();
            }
        }
    }

}

?>
