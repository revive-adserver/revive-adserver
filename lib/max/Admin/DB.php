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
        return ['MYISAM' => 'MyISAM', 'BDB' => 'Berkeley DB', 'GEMINI' => 'NuSphere Gemini', 'INNODB' => 'InnoDB', ' ' => 'PostgreSQL'];
    }

    /**
     * Enter description here...
     *
     * @return array
     */
    public function getServerTypes()
    {
        return ['mysql' => 'mysql', 'mysqli' => 'mysqli'];
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
