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

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/OA/Email.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * Definitions of class constants.
 */
define('OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI',   0);
define('OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR', 1);
define('OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH', 2);

/**
 * The base Data Abstraction Layer (DAL) class for the Maintenance
 * Statistics Engine (MSE), containing all non-database specific
 * code. Database specific code for this DAL needs to be implemented
 * in a final class that extends this class, specific to the
 * appropriate database. As a result, always instantiate this class
 * via the factory class.
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
abstract class OX_Dal_Maintenance_Statistics extends MAX_Dal_Common
{

    /**
     * A sting that can be used in SQL to cast a value into a timestamp.
     *
     * For example, when using string timestamp literals to create a
     * temporary table, the datatype would be otherwise unknown.
     *
     *  INSERT INTO some_table
     *      timestamp_column
     *  VALUES
     *      (
     *          '2007-04-11 13:49:18'{$this->timestampCastSting}
     *      );
     *
     * @var string
     */
    var $timestampCastSting;

    /**
     * The class constructor method.
     */
    function OX_Dal_Maintenance_Statistics()
    {
        parent::MAX_Dal_Common();
    }

    /**
     * A method to perform the migration of logged bucket-based aggregate statistics
     * data from the bucket table(s) into a final statistics table.
     *
     * @param string $statisticsTableName The name of the statistics table the
     *                                    data is to be migrated to.
     * @param array $aMigrationMaps An array of arrays containing the details of the
     *                              bucket data to migrate into the statistics table.
     *                              See the Plugins_DeliveryLog::getStatisticsMigration()
     *                              method for details. May contain just one migration
     *                              set, or multiple sets.
     * @param array $aDates An array containing the PEAR Date objects representing the
     *                      start and end dates for the operation interval being migrated,
     *                      indexed by "start" and "end", respectively.
     * @param array $aExtras An array of extra values to insert into the statistics table,
     *                       indexed by column name.
     * @return mixed A PEAR_Error or MDB2_Error object on failure, otherwise, the number
     *               of rows of aggregate data that were migrated from the bucket table(s)
     *               to the statistics table.
     */
    function summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras = array())
    {
        // Perform basic checking of the parameters; assumes that $aMigrationDetails
        // has already been checked by the Plugins_DeliveryLog::testStatisticsMigration()
        // method
        foreach ($aMigrationMaps as $key => $aMigrationDetails) {
            if ($aMigrationDetails['method'] != 'aggregate') {
                $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '$key' having method '{$aMigrationDetails['method']}' != 'aggregate'.";
                $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
                return $oError;
            }
            if (count($aMigrationDetails['groupSource']) != count($aMigrationDetails['groupDestination'])) {
                $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '$key' having different number of 'groupSource' and 'groupDestination' columns.";
                $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
                return $oError;
            }
            if (count($aMigrationDetails['sumSource']) != count($aMigrationDetails['sumDestination'])) {
                $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '$key' having different number of 'sumSource' and 'sumDestination' columns.";
                $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
                return $oError;
            }
            if (count($aMigrationDetails['sumSource']) != count($aMigrationDetails['sumDefault'])) {
                $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '$key' having different number of 'sumSource' and 'sumDefault' columns.";
                $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
                return $oError;
            }
        }
        $aMigrationMapKeys = array_keys($aMigrationMaps);
        $masterMigrationMapKey = $aMigrationMapKeys[0];
        unset($aMigrationMapKeys[0]);
        foreach ($aMigrationMapKeys as $key) {
            if ($aMigrationMaps[$masterMigrationMapKey]['groupDestination'] != $aMigrationMaps[$key]['groupDestination']) {
                $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map indexes '$masterMigrationMapKey' and '$key' having different 'groupDestination' arrays.";
                $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
                return $oError;
            }
        }
        if (!is_a($aDates['start'], 'Date') || !is_a($aDates['end'], 'Date')) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid start/end date parameters -- not Date objects.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (!OX_OperationInterval::checkIntervalDates($aDates['start'], $aDates['end'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid start/end date parameters -- not operation interval bounds.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }

        // Ensure that tables exist before trying to run commands based on
        // plugin components
        $oTable = new OA_DB_Table();
        if (!$oTable->extistsTable($statisticsTableName)) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid statistics table '$statisticsTableName'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
            return $oError;
        }
        foreach ($aMigrationMaps as $key => $aMigrationDetails) {
            if (!$oTable->extistsTable($aMigrationDetails['bucketTable'])) {
                $message = "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '$key' having invalid bucket table '{$aMigrationDetails['bucketTable']}'.";
                $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
                return $oError;
            }
        }

        // Ensure that the groupSource, groupDestination, sumSource,
        // sumDestination and sumDefault arrays are all sorted by key
        foreach ($aMigrationMaps as $key => $aMigrationDetails) {
            ksort($aMigrationMaps[$key]['groupSource']);
            ksort($aMigrationMaps[$key]['groupDestination']);
            ksort($aMigrationMaps[$key]['sumSource']);
            ksort($aMigrationMaps[$key]['sumDestination']);
            ksort($aMigrationMaps[$key]['sumDefault']);
        }

        // Prepare the destination columns array, the select columns array,
        // the grouped columns array, the array of the order the summed
        // columns should be selected in and the array of the summed column
        // defaults
        $aDestinationColumns   = array();
        $aSelectColumns        = array();
        $aGroupedColumns       = array();
        $aSummedColumns        = array();
        $aSummedColumnDefaults = array();
        foreach ($aMigrationMaps[$masterMigrationMapKey]['groupDestination'] as $value) {
            $aDestinationColumns[] = $value;
            $aSelectColumns[]      = $value;
            $aGroupedColumns[]     = $this->oDbh->quoteIdentifier($value, true);
        }
        foreach ($aMigrationMaps as $aMigrationDetails) {
            foreach ($aMigrationDetails['sumDestination'] as $key => $value) {
                $aDestinationColumns[] = $value;
                $aSelectColumns[]      = 'SUM(' . $this->oDbh->quoteIdentifier($value, true) . ') AS ' . $this->oDbh->quoteIdentifier($value, true);
                $aSummedColumns[]      = $value;
                $aSummedColumnDefaults = $aMigrationDetails['sumDefault'][$key];
            }
        }

        // Prepare the array of select statements for each bucket source,
        // and test each one (if required) to ensure that there is at least
        // some raw data to migrate (otherwise, any "extra" columns/values
        // that are included will cause the migration SQL to fail)
        $dataExists    = false;
        $aUnionSelects = array();
        foreach ($aMigrationMaps as $aMigrationDetails) {
            // Prepare the array of select statements for the bucket source
            $aSelectColumnStatements = array();
            foreach ($aMigrationDetails['groupDestination'] as $key => $value) {
                $aSelectColumnStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['groupSource'][$key], true) . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
            }
            foreach ($aSummedColumns as $value) {
                $key = array_search($value, $aMigrationDetails['sumDestination']);
                if ($key === false) {
                    $aSelectColumnStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['sumDefault'][$key], true) . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
                } else {
                    $aSelectColumnStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['sumSource'][$key], true) . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
                }
            }
            // Prepare the query to select the data from the bucket source
            $query = "
                SELECT
                    " . implode(', ', $aSelectColumnStatements) . "
                FROM
                    " . $this->oDbh->quoteIdentifier($aMigrationDetails['bucketTable'], true) . "
                WHERE
                    " . $this->oDbh->quoteIdentifier($aMigrationDetails['dateTimeColumn'], true) . " >= " . $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                    AND
                    " . $this->oDbh->quoteIdentifier($aMigrationDetails['dateTimeColumn'], true) . " <= " . $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
            $aUnionSelects[] = $query;
            // Is a test for data required?
            if ($dataExists == false) {
                // Prevent any strange database error from causing execution to halt
                // by overriding the error handler, run the query, and return the
                // MDB2_Error object, if required
                PEAR::pushErrorHandling(null);
                $rsResult = $this->oDbh->query($query);
                PEAR::popErrorHandling();
                if (PEAR::isError($rsResult)) {
                    return $rsResult;
                }
                // Was any data found?
                if ($rsResult->numRows() > 0) {
                    $dataExists = true;
                }
            }
        }

        if ($dataExists == false) {
            return 0;
        }

        // Add any extra columns/values to the destaination columns array, if required
        if (!empty($aExtras) && is_array($aExtras)) {
            foreach ($aExtras as $key => $value) {
                $aDestinationColumns[] = $this->oDbh->quoteIdentifier($key, true);
                if (is_numeric($value) || preg_match("/^['|\"]\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}['|\"]" . $this->timestampCastSting . "/", $value)) {
                    $aSelectColumns[]  = $value . ' AS ' . $this->oDbh->quoteIdentifier($key, true);
                } else {
                    $aSelectColumns[]  = $this->oDbh->quoteIdentifier($value, true) . ' AS ' . $this->oDbh->quoteIdentifier($key, true);
                }
            }
        }

        // Prepare the query to migrate the raw data
        $query = "
            INSERT INTO
                " . $this->oDbh->quoteIdentifier($statisticsTableName, true) . "
                (" . implode(', ', $aDestinationColumns) . ")
            SELECT
                " . implode(', ', $aSelectColumns) . "
            FROM
                (" . implode(' UNION ALL ', $aUnionSelects) . "
                ) AS virtual_table
            GROUP BY
                " . implode(', ', $aGroupedColumns) . "
        ";

        // Prevent any strange database error from causing execution to halt
        // by overriding the error handler, run the query, and return the
        // result (either the number or rows affected, or an MDB2_Error
        // object on query/database error)
        PEAR::pushErrorHandling(null);
        $result = $this->oDbh->exec($query);
        PEAR::popErrorHandling();
        return $result;
    }

    /**
     * A method to perform the migration of logged bucket-based raw statistics
     * data from the bucket table(s) into a final statistics table.
     *
     * @param string $statisticsTableName The name of the statistics table the
     *                                    data is to be migrated to.
     * @param array $aMigrationDetails An array containing the details of the
     *                                 bucket data to migrate into the statistics
     *                                 table. See the
     *                                 Plugins_DeliveryLog::getStatisticsMigration()
     *                                 method for details.
     * @param array $aDates An array containing the PEAR Date objects representing the
     *                      start and end dates for the operation interval being migrated,
     *                      indexed by "start" and "end", respectively.
     * @return mixed A PEAR_Error or MDB2_Error object on failure, otherwise, the number
     *               of rows of raw data that were migrated from the bucket table to the
     *               statistics table.
     */
    function summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates)
    {
        // Perform basic checking of the parameters; assumes that $aMigrationDetails
        // has already been checked by the Plugins_DeliveryLog::testStatisticsMigration()
        // method
        if ($aMigrationDetails['method'] != 'raw') {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with migration map method '{$aMigrationDetails['method']}' != 'raw'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (count($aMigrationDetails['source']) != count($aMigrationDetails['destination'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with different number of 'source' and 'destination' columns.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (count($aMigrationDetails['extrasDestination']) != count($aMigrationDetails['extrasValue'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with different number of 'extrasDestination' and 'extrasValue' columns.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (!is_a($aDates['start'], 'Date') || !is_a($aDates['end'], 'Date')) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid start/end date parameters -- not Date objects.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (!OX_OperationInterval::checkIntervalDates($aDates['start'], $aDates['end'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid start/end date parameters -- not operation interval bounds.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }

        // Ensure that tables exist before trying to run commands based on
        // plugin components
        $oTable = new OA_DB_Table();
        if (!$oTable->extistsTable($statisticsTableName)) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid statistics table '$statisticsTableName'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
            return $oError;
        }
        if (!$oTable->extistsTable($aMigrationDetails['bucketTable'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid bucket table '{$aMigrationDetails['bucketTable']}'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
            return $oError;
        }

        // Ensure that the source, destination, extrasDestination and extrasValue
        // arrays are all sorted by key
        ksort($aMigrationDetails['source']);
        ksort($aMigrationDetails['destination']);
        ksort($aMigrationDetails['extrasDestination']);
        ksort($aMigrationDetails['extrasValue']);

        // Prepare the destination columns array
        $aDestinationColumns = array();
        foreach ($aMigrationDetails['destination'] as $value) {
            $aDestinationColumns[] = $this->oDbh->quoteIdentifier($value, true);
        }
        foreach ($aMigrationDetails['extrasDestination'] as $value) {
            $aDestinationColumns[] = $this->oDbh->quoteIdentifier($value, true);
        }

        // Prepare the select column statements array
        $aSelectColumnStatements = array();
        foreach ($aMigrationDetails['destination'] as $key => $value) {
            $aSelectColumnStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['source'][$key], true) . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
        }
        foreach ($aMigrationDetails['extrasDestination'] as $key => $value) {
            if (is_numeric($aMigrationDetails['extrasValue'][$key])) {
                $aSelectColumnStatements[] = $aMigrationDetails['extrasValue'][$key] . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
            } else {
                $aSelectColumnStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['extrasValue'][$key], true) . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
            }
        }

        // Prepare the query to migrate the raw data
        $query = "
            INSERT INTO
                " . $this->oDbh->quoteIdentifier($statisticsTableName, true) . "
                (" . implode(', ', $aDestinationColumns) . ")
            SELECT
                " . implode(', ', $aSelectColumnStatements) . "
            FROM
                " . $this->oDbh->quoteIdentifier($aMigrationDetails['bucketTable'], true) . "
            WHERE
                " . $this->oDbh->quoteIdentifier($aMigrationDetails['dateTimeColumn'], true) . " >= " . $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND
                " . $this->oDbh->quoteIdentifier($aMigrationDetails['dateTimeColumn'], true) . " <= " . $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp');

        // Prevent any strange database error from causing execution to halt
        // by overriding the error handler, run the query, and return the
        // result (either the number or rows affected, or an MDB2_Error
        // object on query/database error)
        PEAR::pushErrorHandling(null);
        $result = $this->oDbh->exec($query);
        PEAR::popErrorHandling();
        return $result;
    }

    /**
     * A method to perform the migration of logged bucket-based supplementary
     * raw statistics data from the bucket table(s) into a final statistics table.
     *
     * @param string $statisticsTableName The name of the statistics table the
     *                                    data is to be migrated to.
     * @param array $aMigrationDetails An array containing the details of the
     *                                 bucket data to migrate into the statistics
     *                                 table. See the
     *                                 Plugins_DeliveryLog::getStatisticsMigration()
     *                                 method for details.
     * @param array $aDates An array containing the PEAR Date objects representing the
     *                      start and end dates for the operation interval being migrated,
     *                      indexed by "start" and "end", respectively.
     * @return mixed A PEAR_Error or MDB2_Error object on failure, otherwise, the number
     *               of rows of raw data that were migrated from the bucket table to the
     *               statistics table.
     */
    function summariseBucketsRawSupplementary($statisticsTableName, $aMigrationDetails, $aDates)
    {
        // Perform basic checking of the parameters; assumes that $aMigrationDetails
        // has already been checked by the Plugins_DeliveryLog::testStatisticsMigration()
        // method
        if ($aMigrationDetails['method'] != 'rawSupplementary') {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with migration map method '{$aMigrationDetails['method']}' != 'rawSupplementary'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (count($aMigrationDetails['masterTablePrimaryKeys']) != count($aMigrationDetails['bucketTablePrimaryKeys'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with different number of 'masterTablePrimaryKeys' and 'bucketTablePrimaryKeys' columns.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (count($aMigrationDetails['masterTableKeys']) != count($aMigrationDetails['bucketTableKeys'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with different number of 'masterTableKeys' and 'bucketTableKeys' columns.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (count($aMigrationDetails['source']) != count($aMigrationDetails['destination'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with different number of 'source' and 'destination' columns.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (!is_a($aDates['start'], 'Date') || !is_a($aDates['end'], 'Date')) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with invalid start/end date parameters -- not Date objects.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }
        if (!OX_OperationInterval::checkIntervalDates($aDates['start'], $aDates['end'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with invalid start/end date parameters -- not operation interval bounds.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDARGS);
            return $oError;
        }

        // Ensure that tables exist before trying to run commands based on
        // plugin components
        $oTable = new OA_DB_Table();
        if (!$oTable->extistsTable($statisticsTableName)) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with invalid statistics table '$statisticsTableName'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
            return $oError;
        }
        if (!$oTable->extistsTable($aMigrationDetails['masterTable'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with invalid master table '{$aMigrationDetails['masterTable']}'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
            return $oError;
        }
        if (!$oTable->extistsTable($aMigrationDetails['bucketTable'])) {
            $message = "OX_Dal_Maintenance_Statistics::summariseBucketsRawSupplementary() called with invalid bucket table '{$aMigrationDetails['bucketTable']}'.";
            $oError = new PEAR_Error($message, MAX_ERROR_INVALIDREQUEST);
            return $oError;
        }

        // Prepare the previously migrated raw data statistics table columns array
        $aMasterColumns = array();
        foreach ($aMigrationDetails['masterTablePrimaryKeys'] as $value) {
            $aMasterColumns[] = $this->oDbh->quoteIdentifier($value, true);
        }
        foreach ($aMigrationDetails['masterTableKeys'] as $value) {
            $aMasterColumns[] = $this->oDbh->quoteIdentifier($value, true);
        }

        // Prepare the query to locate the data in columns in the statistics
        // table which contains the previously migrated raw bucket data,
        // which will then be used to locate the supplementary raw data and
        // also to ensure that when this supplementary raw data is migrated
        // to its statistics table, the supplementary raw data can be
        // connected with the previously migrated raw data
        $query = "
            SELECT
                " . implode(', ', $aMasterColumns) . "
            FROM
                " . $this->oDbh->quoteIdentifier($aMigrationDetails['masterTable'], true) . "
            WHERE
                " . $this->oDbh->quoteIdentifier($aMigrationDetails['masterDateTimeColumn'], true) . " >= " . $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND
                " . $this->oDbh->quoteIdentifier($aMigrationDetails['masterDateTimeColumn'], true) . " <= " . $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp');

        // Prevent any strange database error from causing execution to halt
        // by overriding the error handler, run the query, and return the
        // MDB2_Error object, if required
        PEAR::pushErrorHandling(null);
        $rsResult = $this->oDbh->query($query);
        PEAR::popErrorHandling();
        if (PEAR::isError($rsResult)) {
            return $rsResult;
        }

        // Were any rows found for previously migrated summarised raw data?
        if ($rsResult->numRows() == 0) {
            return 0;
        }

        // Ensure that the required arrays are sorted by key
        ksort($aMigrationDetails['masterTableKeys']);
        ksort($aMigrationDetails['bucketTableKeys']);
        ksort($aMigrationDetails['source']);
        ksort($aMigrationDetails['destination']);

        // Prepare the destination columns array
        $aDestinationColumns = array();
        foreach ($aMigrationDetails['bucketTablePrimaryKeys'] as $value) {
            $aDestinationColumns[] = $this->oDbh->quoteIdentifier($value, true);
        }
        foreach ($aMigrationDetails['destination'] as $value) {
            $aDestinationColumns[] = $this->oDbh->quoteIdentifier($value, true);
        }

        $counter = 0;
        while ($aRow = $rsResult->fetchRow()) {
            // Prepare the select column statements array
            $aSelectColumnStatements = array();
            foreach ($aMigrationDetails['bucketTablePrimaryKeys'] as $value) {
                $aSelectColumnStatements[] = $this->oDbh->quote($aRow[$value], 'text') . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
            }
            foreach ($aMigrationDetails['destination'] as $key => $value) {
                $aSelectColumnStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['source'][$key], true) . ' AS ' . $this->oDbh->quoteIdentifier($value, true);
            }

            // Prepare the where statementes array
            $aWhereStatements = array();
            foreach ($aMigrationDetails['masterTableKeys'] as $key => $value) {
                $aWhereStatements[] = $this->oDbh->quoteIdentifier($aMigrationDetails['bucketTableKeys'][$key], true) . ' = ' . $this->oDbh->quote($aRow[$value], 'text');
            }

            // Prepare the query to migrate the supplementary raw data from bucket
            // table to the statistics table
            $query = "
                INSERT INTO
                    " . $this->oDbh->quoteIdentifier($statisticsTableName, true) . "
                    (" . implode(', ', $aDestinationColumns) . ")
                SELECT
                    " . implode(', ', $aSelectColumnStatements) . "
                FROM
                    " . $this->oDbh->quoteIdentifier($aMigrationDetails['bucketTable'], true) . "
                WHERE
                    " . implode(' AND ', $aWhereStatements);

            // Prevent any strange database error from causing execution to halt
            // by overriding the error handler, run the query, and return the
            // result (either the number or rows affected, or an MDB2_Error
            // object on query/database error)
            PEAR::pushErrorHandling(null);
            $result = $this->oDbh->exec($query);
            PEAR::popErrorHandling();
            if (PEAR::isError($result)) {
                return $result;
            }
            $counter += $result;
        }
        return $counter;
    }

    /**
     * A method to migrate any old style raw requests into new style, bucket-based
     * requests, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function migrateRawRequests($oStart, $oEnd)
    {
        // Perform the default action for migration of raw requests...
        return $this->_migrateRawData($oStart, $oEnd, 'request');
    }

    /**
     * A method to migrate any old style raw impressions into new style, bucket-based
     * impressions, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function migrateRawImpressions($oStart, $oEnd)
    {
        // Perform the default action for migration of raw impressions...
        return $this->_migrateRawData($oStart, $oEnd, 'impression');
    }

    /**
     * A method to migrate any old style raw clicks into new style, bucket-based
     * clicks, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    function migrateRawClicks($oStart, $oEnd)
    {
        // Perform the default action for migration of raw clicks...
        return $this->_migrateRawData($oStart, $oEnd, 'click');
    }

    /**
     * A private method to migrate any old style raw data into new style, bucket-based
     * data, in the event of the requirement to process any such data on upgrade
     * to (or beyond) OpenX 2.8.
     *
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     * @param string $type The type of raw data to migration; one of "request",
     *                     "impression" or "click".
     */
    private function _migrateRawData($oStart, $oEnd, $type)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Prepare the raw data table name
        $rawTable = $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_' . $type];
        // Prepare the bucket table name
        $bucketTable = $aConf['table']['prefix'] . 'data_bkt_';
        if ($type == 'request') {
            $bucketTable .= 'r';
        } else if ($type == 'impression') {
            $bucketTable .= 'm';
        } else if ($type == 'click') {
            $bucketTable .= 'c';
        } else {
            // Invalid call!
            MAX::raiseError('   - Invalid call to raw to bucket data migration! Aborting', MAX_ERROR_INVALIDCALL, PEAR_ERROR_DIE);
        }
        // Select the summarised raw data from the table, and insert it
        // into the data bucket table
        $query = $this->_getMigrateRawDataSQL($bucketTable, $rawTable, $oStart, $oEnd);
        $rsResult = $this->oDbh->query($query);
        if (PEAR::isError($rsResult)) {
            return MAX::raiseError($rsResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

    /**
     * A private, abstract method that must be implemented by each database-specific
     * child class to return the SQL code required to migrate any old style raw data
     * into new style, bucket-based data, in the event of the requirement to process
     * any such data on upgrade to (or beyond) OpenX 2.8.
     *
     * @abstract
     * @param string $bucketTable The bucket table to migrate the data into.
     * @param string $rawTable The raw table to migrate the data from.
     * @param PEAR::Date $oStart The start date of the operation interval to migrate.
     * @param PEAR::Date $oEnd The end date of the operation interval to migrate.
     */
    abstract function _getMigrateRawDataSQL($bucketTable, $rawTable, $oStart, $oEnd);

    /**
     * A method to manage the migration of conversions from the final conversion
     * tables to the old-style intermediate table.
     *
     * @TODO Deprecate, when conversion data is no longer required in the
     *       old format intermediate and summary tables.
     *
     * @param PEAR::Date $oStart The start date/time to migrate from.
     * @param PEAR::Date $oEnd   The end date/time to migrate to.
     */
    function manageConversions($oStart, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // The custom IF function in PgSQL is not suitable for this query, we need explicit use of CASE
        if ($this->oDbh->dbsyntax == 'pgsql') {
            $sqlBasketValue = "CASE WHEN v.purpose = 'basket_value' AND diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED ." THEN diavv.value::numeric ELSE 0 END";
            $sqlNumItems = "CASE WHEN v.purpose = 'num_items' AND diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED ." THEN diavv.value::integer ELSE 0 END";
        } else {
            $sqlBasketValue = "IF(v.purpose = 'basket_value' AND diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED .", diavv.value, 0)";
            $sqlNumItems = "IF(v.purpose = 'num_items' AND diac.connection_status = ". MAX_CONNECTION_STATUS_APPROVED .", diavv.value, 0)";
        }
        // Prepare the query to obtain all of the conversions, and their associated total number
        // of items and total basket values (where they exist), ready for update/insertion into
        // the data_intermediate_ad table
        $query = "
            SELECT
                DATE_FORMAT(diac.tracker_date_time, '%Y-%m-%d %H:00:00'){$this->timestampCastString} AS date_f,
                diac.ad_id AS ad_id,
                diac.zone_id AS zone_id,
                COUNT(DISTINCT(diac.data_intermediate_ad_connection_id)) AS conversions,
                SUM({$sqlBasketValue}) AS total_basket_value,
                SUM({$sqlNumItems}) AS total_num_items
            FROM
                " . $this->oDbh->quoteIdentifier($aConf['table']['prefix'] . 'data_intermediate_ad_connection', true) . " AS diac
            LEFT JOIN
                " . $this->oDbh->quoteIdentifier($aConf['table']['prefix'] . 'data_intermediate_ad_variable_value', true) . " AS diavv
            USING
                (
                    data_intermediate_ad_connection_id
                )
            LEFT JOIN
                " . $this->oDbh->quoteIdentifier($aConf['table']['prefix'] . 'variables', true) . " AS v
            ON
                (
                    diavv.tracker_variable_id = v.variableid
                    AND v.purpose IN ('basket_value', 'num_items')
                )
            WHERE
                diac.connection_status = " . MAX_CONNECTION_STATUS_APPROVED . "
                AND diac.inside_window = 1
                AND diac.tracker_date_time >= ". $this->oDbh->quote($oStart->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
                AND diac.tracker_date_time <= ". $this->oDbh->quote($oEnd->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . "
            GROUP BY
                diac.data_intermediate_ad_connection_id,
                date_f,
                diac.ad_id,
                diac.zone_id";
        OA::debug('- Selecting conversion data for migration to the "old style" intermediate table for ', PEAR_LOG_DEBUG);
        OA::debug('  conversion in the range ' . $oStart->format('%Y-%m-%d %H:%M:%S') . ' ' . $oStart->tz->getShortName() . ' to ' . $oEnd->format('%Y-%m-%d %H:%M:%S') . ' ' . $oEnd->tz->getShortName(), PEAR_LOG_DEBUG);
        $rsResult = $this->oDbh->query($query);
        if (PEAR::isError($rsResult)) {
            return MAX::raiseError($rsResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        while ($aRow = $rsResult->fetchRow()) {
            // Prepare the update query
            $query = "
                UPDATE
                    " . $this->oDbh->quoteIdentifier($aConf['table']['prefix'] . 'data_intermediate_ad', true) . "
                SET
                    conversions = conversions + " . $this->oDbh->quote($aRow['conversions'], 'integer') . ",
                    total_basket_value = total_basket_value + " . $this->oDbh->quote($aRow['total_basket_value'], 'float') . ",
                    total_num_items = total_num_items + " . $this->oDbh->quote($aRow['total_num_items'], 'integer') . "
                WHERE
                    date_time = " . $this->oDbh->quote($aRow['date_f'], 'timestamp') . "
                    AND ad_id = " . $this->oDbh->quote($aRow['ad_id'], 'integer') . "
                    AND zone_id = " . $this->oDbh->quote($aRow['zone_id'], 'integer');
            $rsUpdateResult = $this->oDbh->exec($query);
            if (PEAR::isError($rsUpdateResult)) {
                return MAX::raiseError($rsUpdateResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
            if ($rsUpdateResult == 0) {
                // Could not perform the update - try an insert instead
                $oDate = new Date($aRow['date_f']);
                $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
                $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                $query = "
                    INSERT INTO
                        " . $this->oDbh->quoteIdentifier($aConf['table']['prefix'] . 'data_intermediate_ad', true) . "
                        (
                            date_time,
                            operation_interval,
                            operation_interval_id,
                            interval_start,
                            interval_end,
                            ad_id,
                            creative_id,
                            zone_id,
                            conversions,
                            total_basket_value,
                            total_num_items
                        )
                    VALUES
                        (
                            " . $this->oDbh->quote($aRow['date_f'], 'timestamp') . ",
                            " . $this->oDbh->quote($aConf['maintenance']['operationInterval'], 'integer') . ",
                            " . $this->oDbh->quote($operationIntervalId, 'integer') . ",
                            " . $this->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . ",
                            " . $this->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . ",
                            " . $this->oDbh->quote($aRow['ad_id'], 'integer') . ",
                            0,
                            " . $this->oDbh->quote($aRow['zone_id'], 'integer') . ",
                            " . $this->oDbh->quote($aRow['conversions'], 'integer') . ",
                            " . $this->oDbh->quote($aRow['total_basket_value'], 'float') . ",
                            " . $this->oDbh->quote($aRow['total_num_items'], 'integer') . "
                        )";
                $rsInsertResult = $this->oDbh->exec($query);
            }
        }
    }

    /**
     * A method to update the summary table from the intermediate tables.
     *
     * @param PEAR::Date $oStartDate The start date/time to update from.
     * @param PEAR::Date $oEndDate   The end date/time to update to.
     * @param array $aActions        An array of data types to summarise. Contains
     *                               two array, the first containing the data types,
     *                               and the second containing the connection type
     *                               values associated with those data types, if
     *                               appropriate. For example:
     *          array(
     *              'types'       => array(
     *                                  0 => 'request',
     *                                  1 => 'impression',
     *                                  2 => 'click'
     *                               ),
     *              'connections' => array(
     *                                  1 => MAX_CONNECTION_AD_IMPRESSION,
     *                                  2 => MAX_CONNECTION_AD_CLICK
     *                               )
     *          )
     *                               Note that the order of the items must match
     *                               the order of the items in the database tables
     *                               (e.g. in data_intermediate_ad and
     *                               data_summary_ad_hourly for the above example).
     * @param string $fromTable      The name of the intermediate table to summarise
     *                               from (e.g. 'data_intermediate_ad').
     * @param string $toTable        The name of the summary table to summarise to
     *                               (e.g. 'data_summary_ad_hourly').
     */
    function saveSummary($oStartDate, $oEndDate, $aActions, $fromTable, $toTable)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Check that there are types to summarise
        if (empty($aActions['types']) || empty($aActions['connections'])) {
            return;
        }
        // How many days does the start/end period span?
        $days = Date_Calc::dateDiff($oStartDate->getDay(),
                                    $oStartDate->getMonth(),
                                    $oStartDate->getYear(),
                                    $oEndDate->getDay(),
                                    $oEndDate->getMonth(),
                                    $oEndDate->getYear());
        if ($days == 0) {
            // Save the data
            $this->_saveSummary($oStartDate, $oEndDate, $aActions, $fromTable, $toTable);
        } else {
            // Save each day's data separately
            for ($counter = 0; $counter <= $days; $counter++) {
                if ($counter == 0) {
                    // This is the first day
                    $oInternalStartDate = new Date();
                    $oInternalStartDate->copy($oStartDate);
                    $oInternalEndDate = new Date($oStartDate->format('%Y-%m-%d') . ' 23:59:59');
                } elseif ($counter == $days) {
                    // This is the last day
                    $oInternalStartDate = new Date($oEndDate->format('%Y-%m-%d') . ' 00:00:00');
                    $oInternalEndDate = new Date();
                    $oInternalEndDate->copy($oEndDate);
                } else {
                    // This is a day in the middle
                    $oDayDate = new Date();
                    $oDayDate->copy($oStartDate);
                    $oDayDate->addSeconds(SECONDS_PER_DAY * $counter);
                    $oInternalStartDate = new Date($oDayDate->format('%Y-%m-%d') . ' 00:00:00');
                    $oInternalEndDate = new Date($oDayDate->format('%Y-%m-%d') . ' 23:59:59');
                }
                $this->_saveSummary($oInternalStartDate, $oInternalEndDate, $aActions, $fromTable, $toTable);
            }
        }
    }

    /**
     * A private method to update the summary table from the intermediate tables.
     * Can only be used for start and end dates that are in the same day.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date/time to update from.
     * @param PEAR::Date $oEndDate   The end date/time to update to.
     * @param array $aActions        An array of action types to summarise. Contains
     *                               two array, the first containing the data types,
     *                               and the second containing the connection type
     *                               values associated with those data types, if
     *                               appropriate. For example:
     *          array(
     *              'types'       => array(
     *                                  0 => 'request',
     *                                  1 => 'impression',
     *                                  2 => 'click'
     *                               ),
     *              'connections' => array(
     *                                  1 => MAX_CONNECTION_AD_IMPRESSION,
     *                                  2 => MAX_CONNECTION_AD_CLICK
     *                               )
     *          )
     *                             Note that the order of the items must match
     *                             the order of the items in the database tables
     *                             (e.g. in data_intermediate_ad and
     *                             data_summary_ad_hourly for the above example).
     * @param string $fromTable    The name of the intermediate table to summarise
     *                             from (e.g. 'data_intermediate_ad').
     * @param string $toTable      The name of the summary table to summarise to
     *                             (e.g. 'data_summary_ad_hourly').
     */
    function _saveSummary($oStartDate, $oEndDate, $aActions, $fromTable, $toTable)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
            MAX::raiseError('_saveSummary called with dates not on the same day.', null, PEAR_ERROR_DIE);
        }
        $finalFromTable = $aConf['table']['prefix'] . $aConf['table'][$fromTable];
        $finalToTable   = $aConf['table']['prefix'] . $aConf['table'][$toTable];
        $query = "
            INSERT INTO
                ".$this->oDbh->quoteIdentifier($finalToTable,true)."
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,";
        foreach ($aActions['types'] as $type) {
            $query .= "
                    {$type}s,";
        }
        $query .= "
                    conversions,
                    total_basket_value,
                    total_num_items,
                    updated
                )
            SELECT
                DATE_FORMAT(date_time, '%Y-%m-%d %H:00:00'){$this->timestampCastString} AS hour_date_time,
                ad_id AS ad_id,
                creative_id AS creative_id,
                zone_id AS zone_id,";
        foreach ($aActions['types'] as $type) {
            $query .= "
                SUM({$type}s) AS {$type}s,";
        }
        $query .= "
                SUM(conversions) AS conversions,
                SUM(total_basket_value) AS total_basket_value,
                SUM(total_num_items) AS total_num_items,
                '".date('Y-m-d H:i:s')."'
            FROM
                ".$this->oDbh->quoteIdentifier($finalFromTable,true)."
            WHERE
                date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp')."
                AND date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp')."
            GROUP BY
                hour_date_time, ad_id, creative_id, zone_id";
        // Prepare the message about what's about to happen
        $message = '- Summarising the ad ' . implode('s, ', $aActions['types']) . 's and conversions';
        $message .= " from the $finalFromTable table";
        OA::debug($message, PEAR_LOG_DEBUG);
        $message = "  into the $finalToTable table, for data" .
                    ' between ' . $oStartDate->format('%Y-%m-%d') . ' ' . $oStartDate->format('%H') . ':00:00 ' . $oStartDate->tz->getShortName() .
                    ' and ' . $oStartDate->format('%Y-%m-%d') . ' ' . $oEndDate->format('%H') . ':59:59 ' . $oStartDate->tz->getShortName() . '.';
        OA::debug($message, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $message = '- Summarised ' . $rows . ' rows of ' . implode('s, ', $aActions['types']) . 's and conversions';
        $message .= '.';
        OA::debug($message, PEAR_LOG_DEBUG);
        // Update the recently summarised data with basic financial information
        $this->_saveSummaryUpdateWithFinanceInfo($oStartDate, $oEndDate, $toTable);
    }

    /**
     * A method to set basic financial information in a summary table,
     * on the basis of campaign and zone financial information.
     *
     * @access private
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate   The end date of records that need updating.
     * @param string $table          The name of the summary table to update with financial
     *                               information (e.g. 'data_summary_ad_hourly').
     */
    function _saveSummaryUpdateWithFinanceInfo($oStartDate, $oEndDate, $table)
    {
        OA::debug('- Selecting unique ad IDs during this OI', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
            MAX::raiseError('_saveSummaryUpdateWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
        }

        $indexHint = '';
        if($aConf['database']['type'] == 'mysql'
            && $table == 'data_summary_ad_hourly') {
            $indexHint = ' FORCE INDEX('.$aConf['table']['prefix'].'data_summary_ad_hourly_date_time) ';
        }
        // Obtain a list of unique ad IDs from the summary table
        $query = "
            SELECT DISTINCT
                ad_id AS ad_id
            FROM
                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table'][$table],true)."
                $indexHint
            WHERE
                date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                AND date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        $rsResult = $this->oDbh->query($query);
        if (PEAR::isError($rsResult)) {
            return MAX::raiseError($rsResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $aAdIds = array();
        while ($aRow = $rsResult->fetchRow()) {
            $aAdIds[] = $aRow['ad_id'];
        }
        // Get the finance information for the ads found
        $aAdFinanceInfo = $this->_saveSummaryGetAdFinanceInfo($aAdIds);
        // Update the recently summarised data with basic financial information
        if ($aAdFinanceInfo !== false) {
            $this->_saveSummaryUpdateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $table);
        }
    }

    /**
     * A method to obtain the finance information for a given set of ad IDs.
     *
     * @access private
     * @param array $aAdIds An array of ad IDs for which the finance information is needed.
     * @return mixed An array of arrays, each containing the ad_id, campaign_id, advertiser_id,
     *               revenue and revenue_type of those ads required, where the financial
     *               information exists. Advertiser and campaign ID are needed for monthly
     *               tenancy only, otherwise it would be impossible to split the revenue correctly.
     *               False is returned if none of the ads requested have finance information set.
     */
    function _saveSummaryGetAdFinanceInfo($aAdIds)
    {
        OA::debug('- Select ad finance information for '.count($aAdIds).' ads', PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (empty($aAdIds)) {
            return false;
        }
        $query = "
            SELECT
                a.bannerid AS ad_id,
                a.campaignid AS campaign_id,
                c.clientid AS advertiser_id,
                c.revenue AS revenue,
                c.revenue_type AS revenue_type
            FROM
                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['campaigns'],true)." AS c,
                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)." AS a
            WHERE
                a.bannerid IN (" . $this->oDbh->escape(implode(', ', $aAdIds)) . ")
                AND a.campaignid = c.campaignid
                AND c.revenue IS NOT NULL
                AND c.revenue_type IS NOT NULL";
        $rsResult = $this->oDbh->query($query);
        if (PEAR::isError($rsResult)) {
            MAX::raiseError($rsResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            return false;
        }
        $aResult = array();
        while ($aRow = $rsResult->fetchRow()) {
            $aResult[] = $aRow;
        }
        if (!empty($aResult)) {
            return $aResult;
        }
        return false;
    }

    /**
     * A method to set the basic financial information in a summary table,
     * on the basis of given ad financial information.
     *
     * @access private
     * @param array $aAdFinanceInfo  An array of arrays, each with the ad_id, revenue and
     *                               revenue_type information for the ads that need updating.
     * @param PEAR::Date $oStartDate The start date of records that need updating.
     * @param PEAR::Date $oEndDate   The end date of records that need updating.
     * @param string $table          The name of the summary table to update with financial
     *                               information (e.g. 'data_summary_ad_hourly').
     *
     * Note: The method looks for a special variable in the service locator, called
     *       "aAdFinanceMappings". If found, and an array, the contents of the array
     *       are used to determine the column name that should be used when calculating
     *       the finance information in the SQL statement, for the appropriate revenue
     *       type. If not found, the default mapping is used:
     *       array(
     *           MAX_FINANCE_CPM => impressions,
     *           MAX_FINANCE_CPC => clicks,
     *           MAX_FINANCE_CPA => conversions
     *       )
     *
     * Note: The method looks for a special variable in the service locator, called
     *       "aAdFinanceLimitTypes". If found, and an array, the contents of the array
     *       are tested to see if the revenue type set for the ad ID to be updated is
     *       in the array. If it is not, then the finance information is not set for
     *       the ad.
     *
     * @TODO Update to deal with monthly tenancy.
     */
    function _saveSummaryUpdateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $table)
    {
        OA::debug('- Starting update finance information for ads', PEAR_LOG_DEBUG);

        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($oStartDate->format('%H') != 0 || $oEndDate->format('%H') != 23) {
            if ($oStartDate->format('%Y-%m-%d') != $oEndDate->format('%Y-%m-%d')) {
                MAX::raiseError('_saveSummaryUpdateAdsWithFinanceInfo called with dates not on the same day.', null, PEAR_ERROR_DIE);
            }
        }
        $oServiceLocator =& OA_ServiceLocator::instance();
        // Prepare the revenue type to column name mapping array
        $aAdFinanceMappings =& $oServiceLocator->get('aAdFinanceMappings');
        if (($aAdFinanceMappings === false) || (!array($aAdFinanceMappings)) || (empty($aAdFinanceMappings))) {
            $aAdFinanceMappings = array(
                MAX_FINANCE_CPM => 'impressions',
                MAX_FINANCE_CPC => 'clicks',
                MAX_FINANCE_CPA => 'conversions'
            );
        }
        $countQueries = 0;
        // Try to get the $aAdFinanceLimitTypes array
        $aAdFinanceLimitTypes =& $oServiceLocator->get('aAdFinanceLimitTypes');
        foreach ($aAdFinanceInfo as $aInfo) {
            $query = '';
            $setInfo = true;
            // Test to see if the finance information should NOT be set for this ad
            if ($aAdFinanceLimitTypes !== false) {
                if (is_array($aAdFinanceLimitTypes) && (!empty($aAdFinanceLimitTypes))) {
                    // Try to find the ad's revenue type in the array
                    if (!in_array($aInfo['revenue_type'], $aAdFinanceLimitTypes)) {
                        // It's not in the array, don't set the finance info
                        $setInfo = false;
                    }
                }
            }
            // Prepare the SQL query to set the revenue information, if required
            if ($setInfo) {
                switch ($aInfo['revenue_type']) {
                    case MAX_FINANCE_CPM:
                        $query = "
                            UPDATE
                                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table'][$table],true)."
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPM]} * {$aInfo['revenue']} / 1000,
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                                AND date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
                        break;
                    case MAX_FINANCE_CPC:
                        $query = "
                            UPDATE
                                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table'][$table],true)."
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPC]} * {$aInfo['revenue']},
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                                AND date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
                        break;
                    case MAX_FINANCE_CPA:
                        $query = "
                            UPDATE
                                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table'][$table],true)."
                            SET
                                total_revenue = {$aAdFinanceMappings[MAX_FINANCE_CPA]} * {$aInfo['revenue']},
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                                AND date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
                        break;
                    case MAX_FINANCE_MT:
                        $query = "
                            UPDATE
                                ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table'][$table],true)."
                            SET
                                total_revenue = ".$this->getMtRevenue($aInfo, $oStartDate, $oEndDate, $table).",
                                updated = '". OA::getNow() ."'
                            WHERE
                                ad_id = {$aInfo['ad_id']}
                                AND date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                                AND date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
                        break;
                }
            }
            if (!empty($query)) {
                $rows = $this->oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
                $countQueries++;
            }
        }
        OA::debug('- Updated finance information for '. $countQueries .' ads', PEAR_LOG_DEBUG);
    }

    /**
     * A method to get the hourly revenuo of a monthly tenancy campaign
     *
     * Monthly tenancy calculation sponsored by www.admost.nl
     *
     * @param array $aInfo The finance information, as returned by _saveSummaryGetAdFinanceInfo
     * @param Date $oStartDate
     * @param Date $oEndDate
     * @param string $table
     * @return double
     */
    function getMtRevenue($aInfo, $oStartDate, $oEndDate, $table)
    {
        OA::debug(sprintf("  - Calculating MT revenue for banner [id%d] between %s and %s:",
            $aInfo['ad_id'],
            $oStartDate->format('%Y-%m-%d %H:%M:%S %Z'),
            $oEndDate->format('%Y-%m-%d %H:%M:%S %Z')
        ), PEAR_LOG_DEBUG);
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oMonthStart = new Date($oStartDate);

        // Set timezone
        if (!empty($aInfo['advertiser_id'])) {
            $doClient = OA_Dal::staticGetDO('clients', $aInfo['advertiser_id']);
            $aAdvertiserPrefs = OA_Preferences::loadAccountPreferences($doClient->account_id, true);
            if (!empty($aAdvertiserPrefs['timezone'])) {
                $oMonthStart->convertTZbyID($aAdvertiserPrefs['timezone']);
            }
        }

        // Get ad/zone combinations for the campaign
        if (!isset($this->aMtRevenueCache[$aInfo['campaign_id']])) {
            $query = "
                SELECT
                    COUNT(*) as cnt
                FROM
                    ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table'][$table],true)." d JOIN
                    ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)." a ON (a.bannerid = d.ad_id)
                WHERE
                    a.campaignid = {$aInfo['campaign_id']}
                    AND d.date_time >= ". $this->oDbh->quote($oStartDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') ."
                    AND d.date_time <= ". $this->oDbh->quote($oEndDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');

            $this->aMtRevenueCache[$aInfo['campaign_id']] = $this->oDbh->query($query)->fetchOne();
        }

        $oMonthStart->setDay(1);
        $oMonthStart->setHour(0);
        $oMonthStart->setMinute(0);
        $oMonthStart->setSecond(0);

        OA::debug(sprintf("    - Month start: %s",
            $oMonthStart->format('%Y-%m-%d %H:%M:%S %Z')
        ), PEAR_LOG_DEBUG);

        $daysInMonth = $oMonthStart->getDaysInMonth();

        OA::debug(sprintf("    - Days in month: %d",
            $daysInMonth
        ), PEAR_LOG_DEBUG);

        $oMonthEnd = new Date($oMonthStart);
        $oMonthEnd->setDay($daysInMonth);
        $oMonthEnd = $oMonthEnd->getNextDay();
        $oMonthEnd->setTZ($oMonthStart->tz);

        OA::debug(sprintf("    - Month end: %s",
            $oMonthEnd->format('%Y-%m-%d %H:%M:%S %Z')
        ), PEAR_LOG_DEBUG);

        $oDiff = new Date_Span();
        $oDiff->setFromDateDiff($oMonthEnd, $oMonthStart);
        $hoursPerMonth = ceil($oDiff->toHours());

        OA::debug(sprintf("    - Hours per month: %d",
            $hoursPerMonth
        ), PEAR_LOG_DEBUG);

        $oDiff = new Date_Span();
        $oDiff->setFromDateDiff($oEndDate, $oStartDate);
        $hoursPerInterval = ceil($oDiff->toHours());

        OA::debug(sprintf("    - Hours per interval: %d",
            $hoursPerInterval
        ), PEAR_LOG_DEBUG);

        $adZoneCombinations = $this->aMtRevenueCache[$aInfo['campaign_id']];

        OA::debug(sprintf("    - Ad/zone/OI combinations for campaign [id%d]: %d",
            $aInfo['campaign_id'],
            $this->aMtRevenueCache[$aInfo['campaign_id']]
        ), PEAR_LOG_DEBUG);

        $result = $aInfo['revenue'] / $hoursPerMonth * $hoursPerInterval / $adZoneCombinations;

        OA::debug(sprintf("    - Result: %0.4f",
            $result
        ), PEAR_LOG_DEBUG);

        return $result;
    }

    /**
     * A method to activate/deactivate campaigns, based on the date and/or the inventory
     * requirements (impressions, clicks and/or conversions). Also sends email reports
     * for any campaigns that are activated/deactivated, as well as sending email reports
     * for any campaigns that are likely to expire in the near future.
     *
     * @param Date $oDate The current date/time.
     * @return string Report on the campaigns activated/deactivated.
     */
    function manageCampaigns($oDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oEmail = &$oServiceLocator->get('OA_Email');
        if ($oEmail === false) {
            $oEmail = new OA_Email();
            $oServiceLocator->register('OA_Email', $oEmail);
        }
        $report = "\n";
        // Select all campaigns in the system, where:
        //    The campaign is ACTIVE and:
        //    - The end date stored for the campaign is not null; or
        //    - The campaign has a lifetime impression, click or conversion
        //      target set.
        //
        //    That is:
        //    - It is possible for the active campaign to be automatically
        //      stopped, as it has a valid end date. (No limitations are
        //      applied to those campaigns tested, as the ME may not have
        //      run for a while, and if so, even campaigns with an end date
        //      of many, many weeks ago should be tested to ensure they are
        //      [belatedly] halted.)
        //    - It is possible for the active campaign to be automatically
        //      stopped, as it has at leaast one lifetime target that could
        //      have been reached.
        //
        //    The campaign is INACTIVE and:
        //    - The start date stored for the campaign is not null; and
        //    - The weight is greater than zero; and
        //    - The end date stored for the campaign is either null, or is
        //      greater than "today" less one day.
        //
        //    That is:
        //    - It is possible for the inactive campaign to be automatically
        //      started, as it has a valid start date. (No limitations are
        //      applied to those campaigns tested, as the ME may not have run
        //      for a while, and if so, even campaigns with an activation date
        //      of many, many weeks ago should be tested to ensure they are
        //      [belatedy] enabled.)
        //    - The campaign is not in a permanently inactive state, as a
        //      result of the weight being less then one, which means that
        //      it cannot be activated.
        //    - The test to start the campaign is unlikely to fail on account
        //      of the end date.
        $prefix = $this->getTablePrefix();
        $oNowDate = new Date($oDate);
        $oNowDate->toUTC();

        $query = "
            SELECT
                cl.clientid AS advertiser_id,
                cl.account_id AS advertiser_account_id,
                cl.agencyid AS agency_id,
                cl.contact AS contact,
                cl.email AS email,
                cl.reportdeactivate AS send_activate_deactivate_email,
                ca.campaignid AS campaign_id,
                ca.campaignname AS campaign_name,
                ca.views AS targetimpressions,
                ca.clicks AS targetclicks,
                ca.conversions AS targetconversions,
                ca.status AS status,
                ca.activate_time AS start,
                ca.expire_time AS end
            FROM
                {$prefix}campaigns AS ca,
                {$prefix}clients AS cl
            WHERE
                ca.clientid = cl.clientid
                AND
                ((
                    ca.status = ".$this->oDbh->quote(OA_ENTITY_STATUS_RUNNING, 'integer')." AND
                    (
                        ca.expire_time IS NOT NULL
                        OR
                        (
                            ca.views > 0
                            OR
                            ca.clicks > 0
                            OR
                            ca.conversions > 0
                        )
                    )
                ) OR (
                    ca.status = ".$this->oDbh->quote(OA_ENTITY_STATUS_AWAITING, 'integer')." AND
                    (
                        ca.activate_time <= " . $this->oDbh->quote($oNowDate->getDate(DATE_FORMAT_ISO), 'timestamp') . "
                        AND
                        (
                            ca.weight > 0
                            OR
                            ca.priority > 0
                        )
                        AND
                        (
                            ca.expire_time >= " . $this->oDbh->quote($oNowDate->getDate(DATE_FORMAT_ISO), 'timestamp') . "
                            OR
                            ca.expire_time IS NULL
                        )
                    )
                ))
            ORDER BY
                advertiser_id";
        OA::debug('- Requesting campaigns to test for activation/deactivation', PEAR_LOG_DEBUG);
        $rsResult = $this->oDbh->query($query);
        if (PEAR::isError($rsResult)) {
            return MAX::raiseError($rsResult, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        OA::debug('- Found ' . $rsResult->numRows() . ' campaigns to test for activation/deactivation', PEAR_LOG_DEBUG);
        while ($aCampaign = $rsResult->fetchRow()) {
            if ($aCampaign['status'] == OA_ENTITY_STATUS_RUNNING) {
                // The campaign is currently running, look at the campaign
                $disableReason = 0;
                $canExpireSoon = false;
                if (($aCampaign['targetimpressions'] > 0) ||
                    ($aCampaign['targetclicks'] > 0) ||
                    ($aCampaign['targetconversions'] > 0)) {
                    OA::debug('  - Selecting impressions, clicks and conversions for this running campaign ID = '.$aCampaign['campaign_id'], PEAR_LOG_DEBUG);
                    // The campaign has an impression, click and/or conversion target,
                    // so get the sum total statistics for the campaign
                    $query = "
                        SELECT
                            SUM(dia.impressions) AS impressions,
                            SUM(dia.clicks) AS clicks,
                            SUM(dia.conversions) AS conversions
                        FROM
                            ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)." AS dia,
                            ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)." AS b
                        WHERE
                            dia.ad_id = b.bannerid
                            AND b.campaignid = {$aCampaign['campaign_id']}";
                    $rsResultInner = $this->oDbh->query($query);
                    $valuesRow = $rsResultInner->fetchRow();
                    if ((isset($valuesRow['impressions'])) || (!is_null($valuesRow['clicks'])) || (!is_null($valuesRow['conversions']))) {
                        // There were impressions, clicks and/or conversions for this
                        // campaign, so find out if campaign targets have been passed
                        if (!isset($valuesRow['impressions'])) {
                            // No impressions
                            $valuesRow['impressions'] = 0;
                        }
                        if (!isset($valuesRow['clicks'])) {
                            // No clicks
                            $valuesRow['clicks'] = 0;
                        }
                        if (!isset($valuesRow['conversions'])) {
                            // No conversions
                            $valuesRow['conversions'] = 0;
                        }
                        if ($aCampaign['targetimpressions'] > 0) {
                            if ($aCampaign['targetimpressions'] <= $valuesRow['impressions']) {
                                // The campaign has an impressions target, and this has been
                                // passed, so update and disable the campaign
                                $disableReason |= OX_CAMPAIGN_DISABLED_IMPRESSIONS;
                            }
                        }
                        if ($aCampaign['targetclicks'] > 0) {
                            if ($aCampaign['targetclicks'] <= $valuesRow['clicks']) {
                                // The campaign has a click target, and this has been
                                // passed, so update and disable the campaign
                                $disableReason |= OX_CAMPAIGN_DISABLED_CLICKS;
                            }
                        }
                        if ($aCampaign['targetconversions'] > 0) {
                            if ($aCampaign['targetconversions'] <= $valuesRow['conversions']) {
                                // The campaign has a target limitation, and this has been
                                // passed, so update and disable the campaign
                                $disableReason |= OX_CAMPAIGN_DISABLED_CONVERSIONS;
                            }
                        }
                        if ($disableReason) {
                            // One of the campaign targets was exceeded, so disable
                            $message = '  - Exceeded a campaign quota: Deactivating campaign ID ' .
                                       "{$aCampaign['campaign_id']}: {$aCampaign['campaign_name']}";
                            OA::debug($message, PEAR_LOG_INFO);
                            $report .= $message . "\n";
                            $doCampaigns = OA_Dal::factoryDO('campaigns');
                            $doCampaigns->campaignid = $aCampaign['campaign_id'];
                            $doCampaigns->find();
                            $doCampaigns->fetch();
                            $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
                            $result = $doCampaigns->update();
                            if ($result == false) {
                                return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                            }
                            phpAds_userlogSetUser(phpAds_userMaintenance);
                            phpAds_userlogAdd(phpAds_actionDeactiveCampaign, $aCampaign['campaign_id']);
                        } else {
                            // The campaign didn't have a diable reason,
                            // it *might* possibly be diabled "soon"...
                            $canExpireSoon = true;
                        }
                    }
                }
                // Does the campaign need to be disabled due to the date?
                if (!empty($aCampaign['end'])) {
                    // The campaign has a valid end date, stored in in UTC
                    $oEndDate = new Date($aCampaign['end']);
                    $oEndDate->setTZByID('UTC');
                    if ($oDate->after($oEndDate)) {
                        // The end date has been passed; disable the campaign
                        $disableReason |= OX_CAMPAIGN_DISABLED_DATE;
                        $message = "  - Passed campaign end time of '" . $oEndDate->getDate() . " UTC" .
                                   "': Deactivating campaign ID {$aCampaign['campaign_id']}: {$aCampaign['campaign_name']}";
                        OA::debug($message, PEAR_LOG_INFO);
                        $report .= $message . "\n";
                        $doCampaigns = OA_Dal::factoryDO('campaigns');
                        $doCampaigns->campaignid = $aCampaign['campaign_id'];
                        $doCampaigns->find();
                        $doCampaigns->fetch();
                        $doCampaigns->status = OA_ENTITY_STATUS_EXPIRED;
                        $result = $doCampaigns->update();
                        if ($result == false) {
                            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                        }
                        phpAds_userlogSetUser(phpAds_userMaintenance);
                        phpAds_userlogAdd(phpAds_actionDeactiveCampaign, $aCampaign['campaign_id']);
                    } else {
                        // The campaign wasn't disabled based on the end
                        // date, to it *might* possibly be disabled "soon"...
                        $canExpireSoon = true;
                    }
                }
                if ($disableReason) {
                    // The campaign was disabled, so send the appropriate
                    // message to the campaign's contact
                    $query = "
                        SELECT
                            bannerid AS advertisement_id,
                            description AS description,
                            alt AS alt,
                            url AS url
                        FROM
                            ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)."
                        WHERE
                            campaignid = {$aCampaign['campaign_id']}";
                    OA::debug("  - Getting the advertisements for campaign ID {$aCampaign['campaign_id']}", PEAR_LOG_DEBUG);
                    $rsResultAdvertisement = $this->oDbh->query($query);
                    if (PEAR::isError($rsResultAdvertisement)) {
                        return MAX::raiseError($rsResultAdvertisement, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                    }
                    while ($advertisementRow = $rsResultAdvertisement->fetchRow()) {
                        $advertisements[$advertisementRow['advertisement_id']] = array(
                            $advertisementRow['description'],
                            $advertisementRow['alt'],
                            $advertisementRow['url']
                        );
                    }
                    if ($aCampaign['send_activate_deactivate_email'] == 't') {
                        OA::debug("  - Sending campaign deactivated email ", PEAR_LOG_DEBUG);
                        $oEmail->sendCampaignActivatedDeactivatedEmail($aCampaign['campaign_id'], $disableReason);

                        // Also send campaignDeliveryEmail for the campaign we just deactivated.
                        $doClients = OA_Dal::staticGetDO('clients', $aCampaign['advertiser_id']);
                        $aAdvertiser = $doClients->toArray();
                        OA::debug("  - Sending campaign delivery email ", PEAR_LOG_DEBUG);
                        $oStart = new Date($aAdvertiser['reportlastdate']);
                        $oEnd = new Date($oDate);
                        // Set end date to tomorrow so we get stats for today.
                        $oEnd->addSpan(new Date_Span('1-0-0-0'));
                        $oEmail->sendCampaignDeliveryEmail($aAdvertiser, $oStart, $oEnd, $aCampaign['campaign_id']);
                    }
                } else if ($canExpireSoon) {
                    // The campaign has NOT been deactivated - test to see if it will
                    // be deactivated "soon", and send email(s) warning of this as required
                    OA::debug("  - Sending campaign 'soon deactivated' email ", PEAR_LOG_DEBUG);
                    $oEmail->sendCampaignImpendingExpiryEmail($oDate, $aCampaign['campaign_id']);
                }
            } elseif (!empty($aCampaign['start'])) {
                // The campaign is awaiting activation and has a valid start date, stored in UTC
                $oStartDate = new Date($aCampaign['start']);
                $oStartDate->setTZByID('UTC');
                // Find out if there are any impression, click or conversion targets for
                // the campaign (i.e. if the target values are > 0)
                $remainingImpressions = 0;
                $remainingClicks      = 0;
                $remainingConversions = 0;
                if (($aCampaign['targetimpressions'] > 0) ||
                    ($aCampaign['targetclicks'] > 0) ||
                    ($aCampaign['targetconversions'] > 0)) {
                    OA::debug("  - The campaign ID ".$aCampaign['campaign_id']." has an impression, click and/or conversion target, requesting impressions so far", PEAR_LOG_DEBUG);
                    $query = "
                        SELECT
                            SUM(dia.impressions) AS impressions,
                            SUM(dia.clicks) AS clicks,
                            SUM(dia.conversions) AS conversions
                        FROM
                            ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad'],true)." AS dia,
                            ".$this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['banners'],true)." AS b
                        WHERE
                            dia.ad_id = b.bannerid
                            AND b.campaignid = {$aCampaign['campaign_id']}";
                    $rsResultInner = $this->oDbh->query($query);
                    $valuesRow = $rsResultInner->fetchRow();
                    // Set the remaining impressions, clicks and conversions for the campaign
                    $remainingImpressions = $aCampaign['targetimpressions'] - $valuesRow['impressions'];
                    $remainingClicks      = $aCampaign['targetclicks']      - $valuesRow['clicks'];
                    $remainingConversions = $aCampaign['targetconversions'] - $valuesRow['conversions'];
                }
                // In order for the campaign to be activated, need to test:
                // 1) That there is no impression target (<= 0), or, if there is an impression target (> 0),
                //    then there must be remaining impressions to deliver (> 0); and
                // 2) That there is no click target (<= 0), or, if there is a click target (> 0),
                //    then there must be remaining clicks to deliver (> 0); and
                // 3) That there is no conversion target (<= 0), or, if there is a conversion target (> 0),
                //    then there must be remaining conversions to deliver (> 0)
                if ((($aCampaign['targetimpressions'] <= 0) || (($aCampaign['targetimpressions'] > 0) && ($remainingImpressions > 0))) &&
                    (($aCampaign['targetclicks']      <= 0) || (($aCampaign['targetclicks']      > 0) && ($remainingClicks      > 0))) &&
                    (($aCampaign['targetconversions'] <= 0) || (($aCampaign['targetconversions'] > 0) && ($remainingConversions > 0)))) {
                    $message = "- Passed campaign start time of '" . $oStartDate->getDate() . " UTC" .
                               "': Activating campaign ID {$aCampaign['campaign_id']}: {$aCampaign['campaign_name']}";
                    OA::debug($message, PEAR_LOG_INFO);
                    $report .= $message . "\n";
                    $doCampaigns = OA_Dal::factoryDO('campaigns');
                    $doCampaigns->campaignid = $aCampaign['campaign_id'];
                    $doCampaigns->find();
                    $doCampaigns->fetch();
                    $doCampaigns->status = OA_ENTITY_STATUS_RUNNING;
                    $result = $doCampaigns->update();
                    if ($result == false) {
                        return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                    }
                    phpAds_userlogSetUser(phpAds_userMaintenance);
                    phpAds_userlogAdd(phpAds_actionActiveCampaign, $aCampaign['campaign_id']);
                    if ($aCampaign['send_activate_deactivate_email'] == 't') {
                        OA::debug("  - Sending activation email for campaign ID ". $aCampaign['campaign_id'], PEAR_LOG_DEBUG);
                        $oEmail->sendCampaignActivatedDeactivatedEmail($aCampaign['campaign_id']);
                    }
                }
            }
        }
    }
}

?>
