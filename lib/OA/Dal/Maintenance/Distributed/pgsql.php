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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Distributed.php';

/**
 * A DB specific base Data Abstraction Layer (DAL) class that provides
 * functionality for the Distributed Maintenance.
 *
 * @package    OpenXDal
 * @subpackage Maintenance
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Dal_Maintenance_Distributed_pgsql extends OA_Dal_Maintenance_Distributed
{
    /**
     * A private DB-Specific method to process a table and copy data to the main database.
     *
     * @todo Use a COPY query for bulk inserts
     *
     * @param string $sTableName The table to process
     * @param Date $oStart A PEAR_Date instance, starting timestamp
     * @param Date $oEnd A PEAR_Date instance, ending timestamp
     */
    function _processTable($sTableName, $oStart, $oEnd)
    {
        OA::debug(' - Copying '.$sTableName.' from '.$oStart->format('%Y-%m-%d %H:%M:%S').' to '.$oEnd->format('%Y-%m-%d %H:%M:%S'), PEAR_LOG_INFO);

        $sTableName = $this->_getTablename($sTableName);
        $oMainDbh =& OA_DB_Distributed::singleton();

        if (PEAR::isError($oMainDbh)) {
            MAX::raiseError($oMainDbh, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        $rsData =& $this->_getDataRawTableContent($sTableName, $oStart, $oEnd);
        $count = $rsData->getRowCount();

        OA::debug('   '.$rsData->getRowCount().' records found', PEAR_LOG_INFO);

        if ($count) {
            $oMainDbh->beginTransaction();
            $oMainDbh->exec("COPY {$sTableName} FROM stdin");

            // To use COPY we need to use the original PHP functions
            $pg = $oMainDbh->getConnection();

            $result = true;
            while ($result && $rsData->fetch()) {
                $aRow = $rsData->toArray();
                $sRow = join("\t", array_map(array(&$this, '_escapeForCopy'), $aRow))."\n";

                $result = pg_put_line($pg, $sRow);
            }

            if ($result) {
                pg_put_line($pg, "\\.\n");
                pg_end_copy($pg);

                $result = $oMainDbh->commit();
            } else {
                $result = new PEAR_Error('Database COPY failed');
            }

            if (PEAR::isError($result)) {
                if (PEAR::isError($result)) {
                    MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
                }
            }
        }
    }

    function _escapeForCopy($str)
    {
        if (is_null($str)) {
            return "\\N";
        }

        return preg_replace_callback('/([\x00-\x1F])/', 'sprintf("\\x5C%03o", $1)', $str);
    }
}

?>