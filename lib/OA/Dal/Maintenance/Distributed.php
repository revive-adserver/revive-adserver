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
    /** hash of component name => component object */
    private $aBuckets;

    /**
     * The class constructor method.
     */
    public function OA_Dal_Maintenance_Distributed()
    {
        parent::MAX_Dal_Common();

        $this->aBuckets = $this->getBuckets();
    }

    /**
     * A method to process all the buckets and copy data to the main database.
     *
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    public function processBuckets($oEnd)
    {
        foreach ($this->aBuckets as $sBucketName => $oBucketClass) {
            $oBucketClass->processBucket($oEnd);
            
            // TODO: We shouldn't do this if the previous method fails.
            // Also we should check that it has successfully deleted.
            $this->pruneBucket($oBucketClass->getTableBucketName(), $oEnd);
        }
    }

    /**
     * A method to prune a bucket of all records up to and
     * including the timestamp given.
     *
     * @param string $sBucketName The bucket table name to prune
     * @param Date   $oIntervalStart Prune until this interval_start (inclusive).
     */
    public function pruneBucket($sBucketName, $oIntervalStart)
    {
        OA::debug(' - Pruning '.$sBucketName.' until '.$oIntervalStart->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_INFO);

        $query = "
              DELETE FROM
              {$sBucketName}
              WHERE
                interval_start <= ".
                    DBC::makeLiteral($oIntervalStart->format('%Y-%m-%d %H:%M:%S'))."
            ";

        return $this->oDbh->exec($query);
    }

    
    /**
     *
     * @return array
     */
    private function getBuckets()
    {
        return OX_Component::getComponents('deliveryLog');
    }
}
