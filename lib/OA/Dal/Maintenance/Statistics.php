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

require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Common.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The non-DB specific Data Abstraction Layer (DAL) class for the
 * Maintenance Statistics Engine (MSE).
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class OA_Dal_Maintenance_Statistics extends OA_Dal_Maintenance_Common
{

    /**
     * The class constructor method.
     */
    function OA_Dal_Maintenance_Statistics()
    {
        parent::OA_Dal_Maintenance_Common();
    }

    /**
     * A method to store the a maintenance satistics run report.
     *
     * @param String $report The report to be logged.
     */
    function setMaintenanceStatisticsRunReport($report)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $this->_getTablename('userlog');
        $query = "
            INSERT INTO
                {$tableName}
                (
                    timestamp,
                    usertype,
                    userid,
                    action,
                    object,
                    details
                )
            VALUES
                (
                    '".time()."',
                    '".phpAds_userMaintenance."',
                    0,
                    '".phpAds_actionBatchStatistics."',
                    0,
                    '".addslashes($report)."'
                )";
        OA::debug('Logging the maintenance statistics run report', PEAR_LOG_DEBUG);
        return $this->oDbh->exec($query);
    }

    /**
     * A method to store details on the last time that the maintenance satistics
     * process ran.
     *
     * @param Date $oStart The time that the maintenance statistics run started.
     * @param Date $oEnd The time that the maintenance statistics run ended.
     * @param Date $oUpdateTo The end of the last operation interval ID that
     *                        has been updated.
     * @param string $runTypeField Name of DB field to hold $type value.
     *                      currently 'adserver_run_type' or 'tracker_run_type'.
     * @param integer $type The type of statistics run performed.
     */
    function setMaintenanceStatisticsLastRunInfo($oStart, $oEnd, $oUpdateTo, $runTypeField, $type)
    {
        if (empty($runTypeField)) {
            return PEAR::raiseError('$runTypeField parameter requires a value.', MAX_ERROR_INVALIDARGS);
        }
        return $this->setProcessLastRunInfo($oStart, $oEnd, $oUpdateTo, 'log_maintenance_statistics', false, $runTypeField, $type);
    }

}

?>
