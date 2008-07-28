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

require_once MAX_PATH . '/extensions/deliveryLog/BucketProcessingStrategy.php';
require_once MAX_PATH . '/lib/OA/DB/Distributed.php';
//require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Distributed/mysql.php';

class Plugins_DeliveryLog_AggregateBucketProcessingStrategy
    implements Plugins_DeliveryLog_BucketProcessingStrategy
{
    /**
     * Process an aggregate-type bucket.  This is MySQL specific.
     *
     * @param Plugins_DeliveryLog_LogCommon a reference to the using (context) object.
     * @param Date $oEnd A PEAR_Date instance, interval_start to process up to (inclusive).
     */
    public function processBucket($oBucket, $oEnd)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $sTableName = $oBucket->getTableBucketName();
        $oMainDbh =& OA_DB_Distributed::singleton();

        if (PEAR::isError($oMainDbh)) {
            MAX::raiseError($oMainDbh, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        // Select all rows with interval_start <= previous OI start.
        $rsData =& $this->getBucketTableContent($sTableName, $oEnd);
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
                    // Disable the binlog for the inserts so we don't 
                    // replicate back out over our logged data.
                    $result = $oMainDbh->exec('SET SQL_LOG_BIN = 0');
                    if (PEAR::isError($result)) {
                        MAX::raiseError('Unable to disable the bin log - will not insert stats.', MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
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
    
    /**
     * A method to retrieve the table content as a recordset.
     *
     * @param string $sTableName The bucket table to process
     * @param Date $oEnd A PEAR_Date instance, ending interval_start to process.
     * @return MySqlRecordSet A recordset of the results
     */
    private function getBucketTableContent($sTableName, $oEnd)
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

?>