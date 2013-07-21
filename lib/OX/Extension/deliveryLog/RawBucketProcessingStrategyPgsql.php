<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategy.php';
require_once MAX_PATH . '/lib/OA/DB/Distributed.php';
require_once MAX_PATH . '/lib/wact/db/db.inc.php';

/**
 * The default OX_Extension_DeliveryLog_BucketProcessingStrategy for PgSQL,
 * to migrate data from non-aggregate (i.e. raw) buckets from OpenX delivery
 * (edge) servers, as well as from any intermediate aggregation servers, to
 * an upstream aggregation server, or the upstream central database server.
 *
 * Should be used by any plugin component that uses the deliveryLog extension,
 * and that has non-aggregate bucket data that needs to be migrated when running
 * OpenX in distributed statistics mode.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 * @author     David Keen <david.keen@openx.org>
 */
class OX_Extension_DeliveryLog_RawBucketProcessingStrategyPgsql implements OX_Extension_DeliveryLog_BucketProcessingStrategy
{

    /**
     * Process a raw-type bucket.
     *
     * @param Plugins_DeliveryLog a reference to the using (context) object.
     * @param Date $oEnd A PEAR_Date instance, interval_start to process up to (inclusive).
     */
    public function processBucket($oBucket, $oEnd)
    {
        $sTableName = $oBucket->getBucketTableName();
        $oMainDbh =& OA_DB_Distributed::singleton();

        if (PEAR::isError($oMainDbh)) {
            MAX::raiseError($oMainDbh, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        OA::debug('  - Processing the ' . $sTableName . ' table for data with operation interval start equal to or before ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName(), PEAR_LOG_INFO);

        // As this is raw data being processed, data will not be logged based on the operation interval,
        // but based on the time the raw data was collected. Adjust the $oEnd value accordingly...
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oEnd);

        OA::debug('    - The ' . $sTableName . ' table is a raw data table. Data logged in real-time, not operation intervals.', PEAR_LOG_INFO);
        OA::debug('    - Accordingly, processing of the ' . $sTableName . ' table will be performed based on data that has a logged date equal to', PEAR_LOG_INFO);
        OA::debug('      or before ' . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aDates['end']->tz->getShortName(), PEAR_LOG_INFO);

        // Select all rows with interval_start <= previous OI start.
        $rsData =& $this->getBucketTableContent($sTableName, $aDates['end']);
        $count = $rsData->getRowCount();

        OA::debug('  - '.$rsData->getRowCount().' records found', PEAR_LOG_DEBUG);


        if ($count) {
            $packetSize = 16777216; // 16 MB hardcoded (there's no max limit)

            $i = 0;
            while ($rsData->fetch()) {
                $aRow = $rsData->toArray();
                $sRow = '('.join(',', array_map(array(&$oMainDbh, 'quote'), $aRow)).')';

                if (!$i) {
                    $sInsert    = "INSERT INTO {$sTableName} (".join(',', array_keys($aRow)).") VALUES ";
                    $query      = '';
                    $aExecQueries = array();
                }

                if (!$query) {
                    $query = $sInsert.$sRow;
                // Leave 4 bytes headroom for max_allowed_packet
                } elseif (strlen($query) + strlen($sRow) + 4 < $packetSize) {
                    $query .= ','.$sRow;
                } else {
                    $aExecQueries[] = $query;
                    $query = $sInsert.$sRow;
                }

                if (++$i >= $count || strlen($query) >= $packetSize) {
                    $aExecQueries[] = $query;
                    $query     = '';
                }

                if (count($aExecQueries)) {
                    foreach ($aExecQueries as $execQuery) {
                        $result = $oMainDbh->exec($execQuery);
                            if (PEAR::isError($result)) {
                                MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                            }
                    }

                    $aExecQueries = array();
                }
            }
        }
    }

     /**
     * A method to prune a bucket of all records up to and
     * including the time given.
     *
     * @param Date $oEnd   Prune until this interval_start (inclusive).
     * @param Date $oStart Only prune before this interval_start date (inclusive)
     *                     as well. Optional.
     * @return mixed Either the number of rows pruned, or an MDB2_Error objet.
     */
    public function pruneBucket($oBucket, $oEnd, $oStart = null)
    {
        $sTableName = $oBucket->getBucketTableName();
        if (!is_null($oStart)) {
            OA::debug('  - Pruning the ' . $sTableName . ' table for data with operation interval start between ' . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() . ' and ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName(), PEAR_LOG_DEBUG);
        } else {
            OA::debug('  - Pruning the ' . $sTableName . ' table for all data with operation interval start equal to or before ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName(), PEAR_LOG_DEBUG);
        }

        // As this is raw data being processed, data will not be logged based on the operation interval,
        // but based on the time the raw data was collected. Adjust the $oEnd value accordingly...
        if (!is_null($oStart)) {
            $aStartDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart);
        }
        $aEndDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oEnd);

        OA::debug('    - The ' . $sTableName . ' table is a raw data table. Data logged in real-time, not operation intervals.', PEAR_LOG_INFO);
        if (!is_null($oStart)) {
            OA::debug('    - Accordingly, pruning of the ' . $sTableName . ' table will be performed based on data that has a logged date between ', PEAR_LOG_INFO);
            OA::debug('      ' . $aStartDates['start']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aStartDates['start']->tz->getShortName() . ' and ' . $aEndDates['end']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aEndDates['end']->tz->getShortName(), PEAR_LOG_INFO);
        } else {
            OA::debug('    - Accordingly, pruning of the ' . $sTableName . ' table will be performed based on data that has a logged date equal to', PEAR_LOG_INFO);
            OA::debug('      or before ' . $aEndDates['end']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aEndDates['end']->tz->getShortName(), PEAR_LOG_INFO);
        }

        $query = "
            DELETE FROM
                {$sTableName}
            WHERE
                date_time <= " . DBC::makeLiteral($aEndDates['end']->format('%Y-%m-%d %H:%M:%S'));
        if (!is_null($oStart)) {
            $query .= "
                AND
                date_time >= " . DBC::makeLiteral($aStartDates['start']->format('%Y-%m-%d %H:%M:%S'));
        }
        $oDbh = OA_DB::singleton();
        return $oDbh->exec($query);
    }

    /**
     * A method to retrieve the table content as a recordset.
     *
     * @param string $sTableName The bucket table to process
     * @param Date $oEnd A PEAR_Date instance, ending interval_start to process.
     * @return MySqlRecordSet A recordset of the results
     */
    private function getBucketTableContent($sTableName, $oEnd)
    {
        $query = "
            SELECT
                *
            FROM
                {$sTableName}
            WHERE
                date_time <= " . DBC::makeLiteral($oEnd->format('%Y-%m-%d %H:%M:%S'));
        $rsDataRaw = DBC::NewRecordSet($query);
        $rsDataRaw->find();
        return $rsDataRaw;
    }
}

?>
