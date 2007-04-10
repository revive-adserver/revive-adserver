<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Distributed.php';
require_once MAX_PATH . '/lib/OA/Dal.php';

require_once 'Date.php';


/**
 * A non-DB specific base Data Abstraction Layer (DAL) class that provides
 * functionality for the Distributed Maintenance.
 *
 * @package    OpenadsDal
 * @subpackage Maintenance
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class OA_Dal_Maintenance_Distributed extends MAX_Dal_Common
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
            $aConf['table']['data_raw_tracker_click'],
            $aConf['table']['data_raw_tracker_variable_value'],
        );
    }

    /**
     * A method to store details on the last time that the distributed maintenance
     * process ran.
     *
     * @param object $oDate a PEAR_Date instance
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
            foreach ($aTables as $sTableName) {
                $oTableDate = $this->_getFirstRecordTimestamp($sTableName);
                if (($oDate) || ($oTableDate && $oDate->after(new Date($oTableDate)))) {
                    $oDate = new Date($oTableDate);
                }
            }

            return $oDate;
        }
    }

    /**
     * A method to process all the tables and copy data to the main database.
     *
     * @param object $oStart A PEAR_Date instance, starting timestamp
     * @param object $oEnd A PEAR_Date instance, ending timestamp
     */
    function processTables($oStart, $oEnd)
    {
        foreach ($this->aTables as $sTableName) {
            $this->_processTable($sTableName, $oStart, $oEnd);
        }
    }

    /**
     * A private method to process a table and copy data to the main database.
     *
     * @param string $sTableName The table to process
     * @param object $oStart A PEAR_Date instance, starting timestamp
     * @param object $oEnd A PEAR_Date instance, ending timestamp
     */
    function _processTable($sTableName, $oStart, $oEnd)
    {
        OA::debug(' - Copying '.$TableName.' from '.$oStart->format('%Y-%m-%d %H:%M:%S').' to '.$oEnd->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_INFO);

        $prefix = $this->getTablePrefix();
        $oMainDbh =& OA_DB_Distributed::singleton();

        if (PEAR::isError($oMainDbh)) {
            MAX::raiseError($oMainDbh, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        $rsData =& $this->_getDataRawTableContent($sTableName, $oStart, $oEnd);
        $oStatement = null;

        OA::debug('   '.$rsData->getRowCount().' records found', PEAR_LOG_INFO);

        while ($rsData->fetch()) {
            $aRow = $rsData->toArray();
            if (is_null($oStatement)) {
                $aFields = array();
                $aValues = array();
                foreach (array_keys($aRow) as $sFieldName) {
                    $aFields[] = $oMainDbh->quoteIdentifier($sFieldName);
                    $aBindings[] = '?';
                }
                $oStatement = $oMainDbh->prepare("
                    INSERT INTO
                        {$prefix}{$sTableName} (".
                            join(', ', $aFields).
                        ") VALUES (".
                            join(', ', $aBindings)."
                        )", null, MDB2_PREPARE_MANIP);
                if (PEAR::isError($oStatement)) {
                    MAX::raiseError($oStatement, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            }
            $oInsert = $oStatement->execute(array_values($aRow));
            if (PEAR::isError($oInsert)) {
                MAX::raiseError($oInsert, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }
        }
    }

    /**
     * A method to get the timestamp of the first record, if any.
     *
     * @param string $sTableName The table to check for
     * @return mixed a PEAR_Date object or false if the table is empty
     */
    function _getFirstRecordTimestamp($sTableName)
    {
        $prefix = $this->getTablePrefix();
        $query = "
              SELECT
                MIN(date_time) AS date_time
              FROM
                {$prefix}$sTableName
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
     * @param object $oStart A PEAR_Date instance, starting timestamp
     * @param object $oEnd A PEAR_Date instance, ending timestamp
     * @return object A recordset of the results
     */
    function _getDataRawTableContent($sTableName, $oStart, $oEnd)
    {
        $oEnd->subtractSeconds(1);

        $prefix = $this->getTablePrefix();
        $query = "
              SELECT
                *
              FROM
                {$prefix}$sTableName
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
