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
 * @abstract 
 */
abstract class OA_Dal_Maintenance_Distributed extends OA_Dal_Maintenance_Common
{
    private $aAggregateBuckets;
    private $aNonAggregateBuckets;

    /**
     * The class constructor method.
     */
    public function OA_Dal_Maintenance_Distributed()
    {
        parent::MAX_Dal_Common();

        $this->aAggregateBuckets = $this->getAggregateBuckets();
        $this->aNonAggregateBuckets = $this->getNonAggregateBuckets();
    }

    /**
     * A method to process all the buckets and copy data to the main database.
     *
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    public function processBuckets($oEnd)
    {
        foreach ($this->aAggregateBuckets as $sBucketName) {
            $this->_processBucket($sBucketName, $oEnd, true);
            
            // TODO: We shouldn't do this if the previous method fails.
            // Also we should check that it has successfully deleted.
            $this->_pruneBucket($sBucketName, $oEnd);
        }
        
        foreach ($this->aNonAggregateBuckets as $sBucketName) {
            $this->_processBucket($sBucketName, $oEnd, false);
            $this->_pruneBucket($sBucketName, $oEnd);
        }
    }

    abstract function _processBucket($sBucketName, $oEnd, $isAggregateBucket);

    /**
     * A method to prune a bucket of all records up to and
     * including the timestamp given.
     *
     * @param string $sBucketName The bucket to prune
     * @param Date   $oIntervalStart Prune until this interval_start (inclusive).
     */
    private function _pruneBucket($sBucketName, $oIntervalStart)
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
     * A method to retrieve the table content as a recordset.
     *
     * @param string $sTableName The bucket table to process
     * @param Date $oEnd A PEAR_Date instance, ending interval_start to process.
     * @return MySqlRecordSet A recordset of the results
     */
    protected function _getBucketTableContent($sTableName, $oEnd)
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
    
    private function getAggregateBuckets()
    {
        $aDeliveryComponents = OX_Component::getComponents('deliveryLog');
        foreach ($aDeliveryComponents as $oComponent) {
            $aBuckets[] = $oComponent->getBucketName();
        }
        return $aBuckets;
    }
    
    private function getNonAggregateBuckets()
    {
        return array();
    }

}
