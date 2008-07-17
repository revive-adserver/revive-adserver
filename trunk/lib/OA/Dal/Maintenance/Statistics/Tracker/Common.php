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
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Common.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the Tracker module.
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Dal_Maintenance_Statistics_Tracker_Common extends OA_Dal_Maintenance_Statistics_Common
{

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_Common::OA_Dal_Maintenance_Statistics_Common()
     */
    function OA_Dal_Maintenance_Statistics_Tracker_Common()
    {
        parent::OA_Dal_Maintenance_Statistics_Common();
    }

    /**
     * A method to find the last time that maintenance statistics was run.
     *
     * @param integer $type The update type that occurred - that is,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI if the update was
     *                      done on the basis of the operation interval,
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR if the update
     *                      was done on the basis of the hour, or
     *                      OA_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH if the update
     *                      was done on the basis of both the operation
     *                      interval and the hour.
     * @param Date $oNow An optional Date, used to specify the "current time", and
     *                   to limit the method to only look for past maintenance
     *                   statistics runs before this date. Normally only used
     *                   to assist with re-generation of statistics in the event
     *                   of faulty raw tables.
     * @return Date A Date representing the date up to which the statistics
     *              have been summarised, for the specified update type, or
     *              the appropriate date based on raw data if maintenance
     *              statistics has never been run for the OpenX module before.
     *              Returns null if no raw data is available.
     */
    function getMaintenanceStatisticsLastRunInfo($type, $oNow = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['data_raw_tracker_impression'];
        return $this->_getMaintenanceStatisticsLastRunInfo($type, "Tracker", $table, $oNow);
    }

    /**
     * A method to delete old (ie. summarised) raw data.
     *
     * @param Date $oSummarisedTo The date/time up to which data have been summarised (i.e. data up
     *                            to and including this date (minus any compact_stats_grace window)
     *                            will be deleted).
     * @return integer The number of rows deleted.
     */
    function deleteOldData($oSummarisedTo)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDeleteDate = $oSummarisedTo;
        if ($aConf['maintenance']['compactStatsGrace'] > 0) {
            $oDeleteDate->subtractSeconds((int) $aConf['maintenance']['compactStatsGrace']);
        }
        $resultRows = 0;
        // Delete the tracker impressions
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_tracker_impression'];
        $query = "
            DELETE FROM
                ".$this->oDbh->quoteIdentifier($table,true)."
            WHERE
                date_time <= " . $this->oDbh->quote($oDeleteDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        OA::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') tracker impressions from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        // Delete the tracker variable values
        $table = $aConf['table']['prefix'] .
                 $aConf['table']['data_raw_tracker_variable_value'];
        $query = "
            DELETE FROM
                ".$this->oDbh->quoteIdentifier($table,true)."
            WHERE
                date_time <= " . $this->oDbh->quote($oDeleteDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp');
        OA::debug("Deleting summarised (earlier than '" . $oDeleteDate->format('%Y-%m-%d %H:%M:%S') .
                   "') tracker variable values from the $table table", PEAR_LOG_DEBUG);
        $rows = $this->oDbh->exec($query);
        if (PEAR::isError($rows)) {
            return MAX::raiseError($rows, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
        $resultRows += $rows;
        return $resultRows;
    }

}

?>
