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
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OX/Plugin/Component.php';

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
    var $aBuckets;

    /**
     * The class constructor method.
     */
    function OA_Dal_Maintenance_Distributed()
    {
        parent::MAX_Dal_Common();

        $aConf = $GLOBALS['_MAX']['CONF'];
        
        $aDeliveryComponents = OX_Component::getComponents('deliveryLog');
        foreach ($aDeliveryComponents as $oComponent) {
            $this->aBuckets[] = $oComponent->getBucketName();
        }
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
            foreach ($this->aBuckets as $sTableName) {
                $oTableDate = $this->_getFirstRecordTimestamp($sTableName);
                if ($oTableDate && (!$oDate || $oDate->after(new Date($oTableDate)))) {
                    $oDate = new Date($oTableDate);
                }
            }

            return $oDate;
        }
    }

    /**
     * A method to process all the buckets and copy data to the main database.
     *
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    function processBuckets($oEnd)
    {
        foreach ($this->aBuckets as $sBucketName) {
            $this->_processBucket($sBucketName, $oEnd);
            
            // TODO: We shouldn't do this if the previous method fails.
            // Also we should check that it has successfully deleted.
            $this->_pruneBucket($sBucketName, $oEnd);
        }
    }

    /**
     * A private DB-Specific method to process a table and copy data to the main database.
     *
     * @param string $sTableName The table to process
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    function _processBucket($sBucketName, $oEnd)
    {
        OA::debug("Base class cannot be called directly", PEAR_LOG_ERR);
        exit;
    }

    /**
     * A method to prune a bucket of all records up to and
     * including the timestamp given.
     *
     * @param string $sBucketName The bucket to prune
     * @param Date   $oIntervalStart Prune until this interval_start (inclusive).
     */
    function _pruneBucket($sBucketName, $oIntervalStart)
    {
        OA::debug(' - Pruning '.$sBucketName.' until '.$oIntervalStart->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_INFO);

        $sTableName = $this->_getTablename($sBucketName);
        $query = "
              DELETE FROM
              {$sTableName}
              WHERE
                interval_start <= ".
                    DBC::makeLiteral($oIntervalStart->format('%Y-%m-%d %H:%M:%S'))."
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
                MIN(interval_start) AS date_time
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
     * @param string $sTableName The bucket table to process
     * @param Date $oEnd A PEAR_Date instance, ending interval_start to process.
     * @return MySqlRecordSet A recordset of the results
     */
    function _getBucketTableContent($sTableName, $oEnd)
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
