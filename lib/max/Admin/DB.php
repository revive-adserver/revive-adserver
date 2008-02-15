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

// Required files
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';

class Max_Admin_DB
{
    /**
     * Checks the table type is supported
     *
     * @param string $type  the name of the MySQL storage engine type.
     * @return boolean  true if the server supports the table type.
     */
    function tableTypeIsSupported($type)
    {
        // Assume MySQL always supports MyISAM table types
        if ($type == 'MYISAM') {
            return true;
        } else {
            $oDbh =& OA_DB::singleton();
            $rc = $oDbh->query('SHOW VARIABLES');
            while ($row = $rc->fetchRow(DB_FETCHMODE_ORDERED)) {
                if ($type == 'BDB' && $row[0] == 'have_bdb' && $row[1] == 'YES') {
                    return true;
                }
                if ($type == 'GEMINI' && $row[0] == 'have_gemini' && $row[1] == 'YES') {
                    return true;
                }
                if ($type == 'INNODB' && $row[0] == 'have_innodb' && $row[1] == 'YES') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Gets the table types
     *
     * @return array  list of supported table types.
     */
    function getTableTypes()
    {
        $types['MYISAM'] = 'MyISAM';
        $types['BDB'] = 'Berkeley DB';
        $types['GEMINI'] = 'NuSphere Gemini';
        $types['INNODB'] = 'InnoDB';
        $types[' '] = 'PostgreSQL';
        return $types;
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    function getServerTypes()
    {
        // These values must be the same as used for the
        // data access layer file names!
        $types['mysql'] = 'mysql';
        //$types['pgsql'] = 'pgsql';
        return $types;
    }

    /**
     * Enter description here...
     *
     * @param array $installvars
     * @return boolean
     */
    function checkDatabaseExists($installvars)
    {
        $oDbh =& OA_DB::singleton();
        $oTable = OA_DB_Table_Core::singleton();
        $aTables = OA_DB_Table::listOATablesCaseSensitive();
        $result = false;
        foreach ($oTable->tables as $k => $v) {
            if (is_array($aTables) && in_array($installvars['table_prefix'] . $k, $aTables)) {
                // Table exists
                $result = true;
                break;
            }
        }
        return $result;
    }
}

?>