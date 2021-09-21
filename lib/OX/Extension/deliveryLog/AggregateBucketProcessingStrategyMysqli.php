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
 * The default OX_Extension_DeliveryLog_BucketProcessingStrategy for MySQL,
 * to migrate data from aggregate buckets from OpenX delivery (edge) servers,
 * as well as from any intermediate aggregation servers, to an upstream
 * aggregation server, or the upstream central database server.
 *
 * Should be used by any plugin component that uses the deliveryLog extension,
 * and that has aggregate bucket data that needs to be migrated when running
 * OpenX in distributed statistics mode.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 */
class OX_Extension_DeliveryLog_AggregateBucketProcessingStrategyMysqli implements OX_Extension_DeliveryLog_BucketProcessingStrategy
{
    /**
     * Process an aggregate-type bucket.  This is MySQL specific.
     *
     * @param Plugins_DeliveryLog $oBucket a reference to the using (context) object.
     * @param Date $oEnd A PEAR_Date instance, interval_start to process up to (inclusive).
     */
    public function processBucket($oBucket, $oEnd)
    {
        $sTableName = $oBucket->getBucketTableName();
        $oMainDbh = OA_DB_Distributed::singleton();

        if (PEAR::isError($oMainDbh)) {
            MAX::raiseError($oMainDbh, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        OA::debug('  - Processing the ' . $sTableName . ' table for data with operation interval start equal to or before ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName(), PEAR_LOG_INFO);

        // Select all rows with interval_start <= previous OI start.
        $rsData = $this->getBucketTableContent($sTableName, $oEnd);
        $rowCount = $rsData->getRowCount();

        OA::debug('  - ' . $rsData->getRowCount() . ' records found', PEAR_LOG_DEBUG);

        if ($rowCount) {
            // We can't do bulk inserts with ON DUPLICATE.
            $aExecQueries = [];
            if ($rsData->fetch()) {
                // Get first row
                $aRow = $rsData->toArray();
                // Prepare INSERT
                $sInsert = "INSERT INTO {$sTableName} (" . join(',', array_keys($aRow)) . ") VALUES ";
                // Add first row data
                $sRow = '(' . join(',', array_map([&$oMainDbh, 'quote'], $aRow)) . ')';
                $sOnDuplicate = ' ON DUPLICATE KEY UPDATE count = count + ' . $aRow['count'];
                // Add first insert
                $aExecQueries[] = $sInsert . $sRow . $sOnDuplicate;
                // Deal with the other rows
                while ($rsData->fetch()) {
                    $aRow = $rsData->toArray();
                    $sRow = '(' . join(',', array_map([&$oMainDbh, 'quote'], $aRow)) . ')';
                    $sOnDuplicate = ' ON DUPLICATE KEY UPDATE count = count + ' . $aRow['count'];
                    $aExecQueries[] = $sInsert . $sRow . $sOnDuplicate;
                }
            }

            if (count($aExecQueries)) {
                // Try to disable the binlog for the inserts so we don't
                // replicate back out over our logged data.
                PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
                $result = $oMainDbh->exec('SET SQL_LOG_BIN = 0');
                if (PEAR::isError($result)) {
                    OA::debug('Unable to disable the bin log, proceeding anyway.', PEAR_LOG_WARNING);
                }
                PEAR::staticPopErrorHandling();
                foreach ($aExecQueries as $execQuery) {
                    $result = $oMainDbh->exec($execQuery);
                    if (PEAR::isError($result)) {
                        MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                    }
                }
            }
        }
    }

    /**
     * A method to prune a bucket of all records up to and
     * including the timestamp given.
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
        $query = "
            DELETE FROM
                {$sTableName}
            WHERE
                interval_start <= " . DBC::makeLiteral($oEnd->format('%Y-%m-%d %H:%M:%S'));
        if (!is_null($oStart)) {
            $query .= "
                AND
                interval_start >= " . DBC::makeLiteral($oStart->format('%Y-%m-%d %H:%M:%S'));
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
                interval_start <= " . DBC::makeLiteral($oEnd->format('%Y-%m-%d %H:%M:%S'));
        $rsDataRaw = DBC::NewRecordSet($query);
        $rsDataRaw->find();

        return $rsDataRaw;
    }
}
