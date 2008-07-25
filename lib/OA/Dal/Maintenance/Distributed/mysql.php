<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Distributed.php';

/**
 * A DB specific base Data Abstraction Layer (DAL) class that provides
 * functionality for the Distributed Maintenance.
 *
 * @package    OpenXDal
 * @subpackage Maintenance
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Dal_Maintenance_Distributed_mysql extends OA_Dal_Maintenance_Distributed
{
    /**
     * A private DB-Specific method to process a bucket table and copy data to the main database.
     *
     * @param string $sBucketName The bucket to process
     * @param Date $oEnd A PEAR_Date instance, interval_start to process up to (inclusive).
     */
    function _processBucket($sBucketName, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $sTableName = $this->_getTablename($sBucketName);
        $oMainDbh =& OA_DB_Distributed::singleton();

        if (PEAR::isError($oMainDbh)) {
            MAX::raiseError($oMainDbh, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        // Select all rows with interval_start <= previous OI start.
        $rsData =& $this->_getBucketTableContent($sTableName, $oEnd);
        $count = $rsData->getRowCount();

        OA::debug('   '.$rsData->getRowCount().' records found', PEAR_LOG_INFO);

        if ($count) {
            $aRow = $oMainDbh->queryRow("SHOW VARIABLES LIKE 'max_allowed_packet'");
            $packetSize = !empty($aRow['value']) ? $aRow['value'] : 0;

            $i = 0;
            while ($rsData->fetch()) {
                $aRow = $rsData->toArray();
                $sRow = '('.join(',', array_map(array(&$oMainDbh, 'quote'), $aRow)).')';
                $sOnDuplicate = ' ON DUPLICATE KEY UPDATE count = count + ' . $aRow['count'];

                if (!$i) {
                    $sInsert    = "INSERT INTO {$sTableName} (".join(',', array_keys($aRow)).") VALUES ";
                    $query      = '';
                    $aExecQueries = array();
                }

                if (!$query) {
                    $query = $sInsert.$sRow;
                // Leave 4 bytes headroom for max_allowed_packet
                } elseif (strlen($query) + strlen($sRow) + 4 < $packetSize) {
                    $query .= ','.$sRow;
                } else {
                    $aExecQueries[] = $query . $sOnDuplicate;
                    $query = $sInsert.$sRow;
                }

                if (++$i >= $count || strlen($query) >= $packetSize) {
                    $aExecQueries[] = $query . $sOnDuplicate;
                    $query     = '';
                }

                if (count($aExecQueries)) {
                    // Disable the binlog for the inserts
                    if ($aConf['lb']['hasSuper']) {
                        $result = $oMainDbh->exec('SET SQL_LOG_BIN = 0');
                        if (PEAR::isError($result)) {
                            OA::debug(' - Unable to disable the bin log', PEAR_LOG_DEBUG);
                        }
                    }
                    foreach ($aExecQueries as $execQuery) {
                        $result = $oMainDbh->exec($execQuery);
                        if (PEAR::isError($result)) {
                            if (PEAR::isError($result)) {
                                MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                            }
                        }
                    }

                    $aExecQueries = array();
                }
            }
        }
    }
}

?>
