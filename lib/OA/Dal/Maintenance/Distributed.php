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
require_once MAX_PATH . '/lib/max/OperationInterval.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';

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

    /**
     * The class constructor method.
     */
    function OA_Dal_Maintenance_Distributed()
    {
        parent::MAX_Dal_Common();

        $this->doLbLocal = OA_Dal::factoryDO('lb_local');
    }

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

    function getMaintenanceDistributedLastRunInfo()
    {
		$doLbLocal = OA_Dal::factoryDO('lb_local');
		$doLbLocal->find();

		if ($doLbLocal->fetch()) {
		    return new Date((int)$doLbLocal->last_run);
		} else {
		    $oDateImp   = $this->_getFirstRecordTimestamp('data_raw_ad_impression');
		    $oDateClick = $this->_getFirstRecordTimestamp('data_raw_ad_click');

		    if (!is_null($oDateImp)) {
		        if (!is_null($oDateClick)) {
		            if ($oDateClick->before(new Date($oDateImp))) {
		                return $oDateClick;
		            }
		        }

		        return $oDateImp;
		    }

		    return new Date('2000-01-01');
		}
    }

    function processTable($sTableName, $oStart, $oEnd)
    {
        $prefix = $this->getTablePrefix();
        $oMainDbh =& OA_DB_Distributed::singleton();

        $rsData =& $this->_getDataRawTableContent($sTableName, $oStart, $oEnd);
        $oStatement = null;
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
            }
            $oStatement->execute(array_values($aRow));
        }
    }

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
            return null;
        }

        return new Date($sTimestamp);
    }

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