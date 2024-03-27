<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
    public function tableTypeIsSupported($type)
    {
        // Assume MySQL always supports MyISAM table types
        return $type == 'MYISAM';
    }

    /**
     * Gets the table types
     *
     * @return array  list of supported table types.
     */
    public function getTableTypes()
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
    public function getServerTypes()
    {
        // These values must be the same as used for the
        // data access layer file names!
        $types['mysql'] = 'mysql';
        $types['mysqli'] = 'mysqli';
        //$types['pgsql'] = 'pgsql';
        return $types;
    }

    /**
     * Enter description here...
     *
     * @param array $installvars
     * @return boolean
     */
    public function checkDatabaseExists($installvars)
    {
        $oDbh = OA_DB::singleton();
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
