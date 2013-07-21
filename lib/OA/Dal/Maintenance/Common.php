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

require_once MAX_PATH . '/lib/OA.php';

require_once LIB_PATH . '/OperationInterval.php';

/**
 * A non-DB specific base Data Abstraction Layer (DAL) class that provides
 * functionality that is common to all of the Maintenance DALs.
 *
 * @package    OpenXDal
 * @subpackage Maintenance
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Dal_Maintenance_Common extends MAX_Dal_Common
{

    /**
     * The class constructor method.
     */
    function OA_Dal_Maintenance_Common()
    {
        parent::MAX_Dal_Common();
    }

    /**
     * A method to store data about the times that various Maintenance
     * processes ran.
     *
     * @param Date $oStart The time that the script run started.
     * @param Date $oEnd The time that the script run ended.
     * @param mixed $oUpdateTo PEAR::Date representing the end of the last
     *                         operation interval ID that has been updated,
     *                         or NULL, in the case that this information
     *                         does not actually apply, and only the
     *                         start/end dates of the process run are
     *                         relevant.
     * @param string $tableName The name of the log_matinenance_* table to log into.
     *                          Must NOT be a complete table name, ie. no prefix.
     * @param boolean $setOperationInterval Should the operation intverval value be
     *                                      logged, or not?
     * @param string $runTypeField Optional name of DB field to hold $type value.
     * @param integer $type Optional type of process run performed.
     */
    function setProcessLastRunInfo($oStart, $oEnd, $oUpdateTo, $tableName, $setOperationInterval, $runTypeField = null, $type = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Test input values $oStart and $oEnd are dates
        if (!is_a($oStart, 'Date') || !is_a($oEnd, 'Date')) {
            return false;
        }
        // Test $oUpdateTo is a date, or null
        if (!is_a($oUpdateTo, 'Date')) {
            if (!is_null($oUpdateTo)) {
                return false;
            }
        }
        // Test $setOperationInterval value is a boolean
        if (!is_bool($setOperationInterval)) {
            return false;
        }
        // Prepare the duraction to log from the start and end dates
        $oDuration = new Date_Span();
        $oStartDateCopy = new Date();
        $oStartDateCopy->copy($oStart);
        $oEndDateCopy = new Date();
        $oEndDateCopy->copy($oEnd);
        $oDuration->setFromDateDiff($oStartDateCopy, $oEndDateCopy);
        // Prepare the logging query
        $tableName = $this->_getTablename($tableName);
        $query = "
            INSERT INTO
                {$tableName}
                (
                    start_run,
                    end_run,";
        if ($setOperationInterval) {
            $query .= "
                    operation_interval,";
        }
        $query .= "
                    duration";
        if (!is_null($runTypeField) && !is_null($type)) {
            $query .= ",
                    $runTypeField";
        }
        if (!is_null($oUpdateTo)) {
            $query .= ",
                    updated_to";
        }
        $query .= "
                )
            VALUES
                (
                    '".$oStart->format('%Y-%m-%d %H:%M:%S')."',
                    '".$oEnd->format('%Y-%m-%d %H:%M:%S')."',";
        if ($setOperationInterval) {
            $query .= "
                    {$aConf['maintenance']['operationInterval']},";
        }
        $query .= "
                    ".$oDuration->toSeconds();
        if (!is_null($runTypeField) && !is_null($type)) {
            $query .= ",
                    $type";
        }
        if (!is_null($oUpdateTo)) {
            $query .= ",
                    '".$oUpdateTo->format('%Y-%m-%d %H:%M:%S')."'";
        }
        $query .= "
                )";
        OA::debug('- Logging maintenance process run information into ' . $tableName, PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return false;
        } else {
            return $rows;
        }
    }

    /**
     * A method to return data about the times that various Maintenance
     * processes ran.
     *
     * @param string $tableName The name of the log_maintenance_* table to get data from.
     *                          Must be a complete table name, including prefix, if
     *                          required.
     * @param array  $aAdditionalFields An array of strings, representing any additional
     *                                  data fields to return, along with the default
     *                                  'updated_to' field.
     * @param string $whereClause Optional string, containing a valid SQL WHERE clause,
     *                            if this is required to limit the results of the log data
     *                            before ordering and returning.
     * @param string $orderBy Optional string to specify the DB field used to sort the data
     *                        into DESCENDING order, before selecting the first value. Default
     *                        is 'start_run'.
     * @param array $aAlternateInfo Optional array containing two fields, 'tableName', which
     *                              is a string of the name of a raw table which will be searched
     *                              for the earliest date/time, in the event that no valid
     *                              'updated_to' field could be found in the main table, and 'type',
     *                              which is a string of either value 'oi' or 'hour'. The returned
     *                              'updated_to' value will either be the end of the operation
     *                              interval (if 'type' is 'oi') or the end of the hour (if 'type'
     *                              is 'hour') prior to any date/time found in the alternate raw
     *                              table. Note that if the alternate raw table is used, then ONLY
     *                              the 'updated_to' value is returned - any $aAdditionalFields
     *                              values will be ignored.
     * @return mixed False on error, null no no result, otherwise, an array containing the
     *               'updated_to' field, which represents the time that the Maintenance
     *               process last completed updating data until, as well as any additional
     *               fields (see $aAdditionalFields parameter), unless the alternate raw table
     *               was used (see $alternateRawTableName parameter).
     */
    function getProcessLastRunInfo($tableName, $aAdditionalFields = array(), $whereClause = null, $orderBy = 'start_run', $aAlternateInfo = array())
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        // Test input values $aAdditionalFields and $aAlternateInfo are arrays
        if (!is_array($aAdditionalFields) || !is_array($aAlternateInfo)) {
            return false;
        }
        $query = "
            SELECT
                updated_to";
        if (!empty($aAdditionalFields)) {
            $query .= ', ' . implode(', ', $aAdditionalFields);
        }
        $tableName = $this->_getTablename($tableName);
        $query .= "
            FROM
                $tableName";
        if (!is_null($whereClause)) {
            $query .= "
                $whereClause";
        }
        $query .= "
            ORDER BY $orderBy DESC
            LIMIT 1";
        OA::debug('- Obtaining maintenance process run information from ' . $tableName, PEAR_LOG_DEBUG);
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return false;
        }
        $aResult = $rc->fetchRow();
        if (!is_null($aResult)) {
            // The process run information was found, return.
            return $aResult;
        }
        if (!empty($aAlternateInfo['tableName']) && !empty($aAlternateInfo['type'])) {
            // No result was found above, and an alternate raw table was specified,
            // so search the raw table to see if a valid result can be generated
            // on the basis of the earliest raw data value
            $tableName = $this->_getTablename($aAlternateInfo['tableName']);
            $query = "
                SELECT
                    date_time AS date
                FROM
                    {$tableName}
                ORDER BY date ASC
                LIMIT 1";
            OA::debug('- Maintenance process run information not found - trying to get data from ' . $aAlternateInfo['tableName'], PEAR_LOG_DEBUG);
            $rc = $this->oDbh->query($query);
            if (PEAR::isError($rc)) {
                return false;
            }
            if ($rc->numRows() > 0) {
                // A raw data result was found - convert it to the end of the previous
                // operation interval, or hour
                $aResult = $rc->fetchRow();
                $oDate = new Date($aResult['date']);
                if ($aAlternateInfo['type'] == 'oi') {
                    $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                    $oResultDate = $aDates['start'];
                } else if ($aAlternateInfo['type'] == 'hour') {
                    $oResultDate = new Date($oDate->format('%Y-%m-%d %H:00:00'));
                }
                $oResultDate->subtractSeconds(1);
                return array('updated_to' => $oResultDate->format('%Y-%m-%d %H:%M:%S'));
            }
        }
        // No result found, return null
        return null;
    }

    /**
     * A method to return the time that the maintenance statistics scripts
     * were last run, and the type of update that was done at the time.
     *
     * @return array An array containing the time that represents the time
     *               that the maintenance statistics were last updated to,
     *               index as "updated_to", and the type of update done,
     *               indexed as "adserver_run_type".
     *
     * Note that this method is in the OA_Dal_Maintenance_Common class, and
     * not the OA_Dal_Maintenance_Statistics class, because it is used by
     * the Maintenance Statistics, Maintenance Priority AND the Maintenance
     * Forecasting engines.
     */
    function getMaintenanceStatisticsLastRunInfo()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['log_maintenance_statistics'];
        return $this->getProcessLastRunInfo($table, array('adserver_run_type'));
    }

    /**
     * A method to return all of the individual delivery limitations associated
     * with either an ad, or with a channel.
     *
     * @param integer $id Either the ad ID, or the channel ID.
     * @param string $type One of "ad", or "channel".
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the delivery limitations associated
     *               with the ad/channel, in the following format:
     *                   array(
     *                      [0] => array(
     *                          [key]              => 3
     *                          ['logical']        => "and"
     *                          ['type']           => "Time:Date"
     *                          ['comparison']     => "!="
     *                          ['data']           => "2005-05-25"
     *                          ['executionorder'] => 0
     *                      )
     *                      [1] => array(
     *                          [key]              => 3
     *                          ['logical']        => "and"
     *                          ['type']           => "Geo:Country"
     *                          ['comparison']     => "=="
     *                          ['data']           => "GB"
     *                          ['executionorder'] => 1
     *                      )
     * where "key" is either "ad_id" or "channel_id", depending on the $type.
     * The array is sorted in "executionorder".
     *
     * Note that this method is in the OA_Dal_Maintenance_Common class,
     * because both the Maintenance Priorty and the Maintenance Forecasting
     * engines use this class.
     *
     * @TODO Investigate if this method could be replaced by becoming a wrapper
     *       method to the {@link Admin_DA} class, or similar...
     *
     * @TODO Re-locate this method into the Entities DAL class!
     */
    function getAllDeliveryLimitationsByTypeId($id, $type)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if ($type == 'ad') {
            $table = 'acls';
            $key = 'bannerid';
            $keyAs = 'ad_id';
        } else if ($type == 'channel') {
            $table = 'acls_channel';
            $key = 'channelid';
            $keyAs = 'ad_id';
        } else {
            return null;
        }
        $tableName = $this->_getTablename($table);
        $query = "
            SELECT
                $key AS $keyAs,
                logical,
                type,
                comparison,
                data,
                executionorder
            FROM
                $tableName
            WHERE
                $key = $id
            ORDER BY executionorder";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow;
        }
        return $aResult;
    }

}

?>