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
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Common.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Distributed.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A non-DB specific base Data Abstraction Layer (DAL) class that provides
 * functionality for the Distributed Maintenance.
 *
 * @package    OpenXDal
 * @subpackage Maintenance
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Dal_Maintenance_Distributed extends OA_Dal_Maintenance_Common
{
    var $aTables;

    /**
     * The class constructor method.
     */
    function OA_Dal_Maintenance_Distributed()
    {
        parent::MAX_Dal_Common();

        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->aTables = array(
            $aConf['table']['data_raw_ad_request'],
            $aConf['table']['data_raw_ad_impression'],
            $aConf['table']['data_raw_ad_click'],
            $aConf['table']['data_raw_tracker_impression'],
            $aConf['table']['data_raw_tracker_variable_value'],
        );
    }

    /**
     * A method to store details on the last time that the distributed maintenance
     * process ran.
     *
     * @param Date $oDate a PEAR_Date instance
     */
    function setMaintenanceDistributedLastRunInfo($oDate)
    {
        $doLbLocal = OA_Dal::factoryDO('lb_local');
        $doLbLocal->whereAdd('1=1');
        $doLbLocal->last_run = $oDate->getTime();
        $iRows = $doLbLocal->update(DB_DATAOBJECT_WHEREADD_ONLY);
        if (!$iRows) {
            $doLbLocal->insert();
        }
    }

    /**
     * A method to retrieve details on the last time that the distributed maintenance
     * process ran.
     *
     * @return mixed A PEAR_Date instance or false if there is no need to run distributed maintenance
     */
    function getMaintenanceDistributedLastRunInfo()
    {
        $doLbLocal = OA_Dal::factoryDO('lb_local');
        $doLbLocal->find();

        if ($doLbLocal->fetch()) {
            return new Date((int)$doLbLocal->last_run);
        } else {
            $oDate = false;
            foreach ($this->aTables as $sTableName) {
                $oTableDate = $this->_getFirstRecordTimestamp($sTableName);
                if ($oTableDate && (!$oDate || $oDate->after(new Date($oTableDate)))) {
                    $oDate = new Date($oTableDate);
                }
            }

            return $oDate;
        }
    }

    /**
     * A method to process all the tables and copy data to the main database.
     *
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    function processTables($oStart, $oEnd)
    {
        foreach ($this->aTables as $sTableName) {
            $this->_processTable($sTableName, $oStart, $oEnd);
            $this->_pruneTable($sTableName, $oStart);
        }
    }

    /**
     * A private DB-Specific method to process a table and copy data to the main database.
     *
     * @param string $sTableName The table to process
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    function _processTable($sTableName, $oStart, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A method to prune a raw table, based on the config settings
     *
     * @param string $sTableName The table to prune
     * @param Date   $oTimeStamp Prune until this timestamp
     */
    function _pruneTable($sTableName, $oTimestamp)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (empty($aConf['lb']['compactStats'])) {
            return;
        }

        $oTimestamp->subtractSeconds((int)$aConf['lb']['compactStatsGrace']);

        OA::debug(' - Pruning '.$sTableName.' until '.$oTimestamp->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_INFO);

        $sTableName = $this->_getTablename($sTableName);
        $query = "
              DELETE FROM
              {$sTableName}
              WHERE
                date_time < ".
                    DBC::makeLiteral($oTimestamp->format('%Y-%m-%d %H:%M:%S'))."
            ";

        return $this->oDbh->exec($query);
    }

    /**
     * A method to get the timestamp of the first record, if any.
     *
     * @param string $sTableName The table to check for
     * @return mixed a PEAR_Date object or false if the table is empty
     */
    function _getFirstRecordTimestamp($sTableName)
    {
        $sTableName = $this->_getTablename($sTableName);
        $query = "
              SELECT
                MIN(date_time) AS date_time
              FROM
                {$sTableName}
            ";

        $sTimestamp = $this->oDbh->getOne($query);

        if (PEAR::isError($sTimestamp) || empty($sTimestamp)) {
            return false;
        }

        return new Date($sTimestamp);
    }

    /**
     * A method to retrieve the table content as a recordset.
     *
     * @param string $sTableName The table to process
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     * @return MySqlRecordSet A recordset of the results
     */
    function _getDataRawTableContent($sTableName, $oStart, $oEnd)
    {
        $oEnd->subtractSeconds(1);

        $query = "
              SELECT
                *
              FROM
                {$sTableName}
              WHERE
                date_time BETWEEN ".
                    DBC::makeLiteral($oStart->format('%Y-%m-%d %H:%M:%S'))." AND ".
                    DBC::makeLiteral($oEnd->format('%Y-%m-%d %H:%M:%S'))."
            ";

        $rsDataRaw = DBC::NewRecordSet($query);
        $rsDataRaw->find();

        return $rsDataRaw;
    }

}
