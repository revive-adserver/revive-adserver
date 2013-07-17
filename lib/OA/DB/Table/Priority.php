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

require_once MAX_PATH . '/lib/OA/DB/Table.php';

/**
 * A class for creating the temporary OpenX database tables required
 * for performing the Maintenance Priority Engine (MPE) tasks.
 *
 * @package    OpenXDB
 * @subpackage Table
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_DB_Table_Priority extends OA_DB_Table
{

    /**
     * The class constructor method.
     */
    function OA_DB_Table_Priority()
    {
        parent::OA_DB_Table();
        $this->temporary = true;
    }

    /**
     * A singleton method to create or return a single instance
     * of the {@link OA_DB_Table_Priority} object.
     *
     * @static
     * @return OA_DB_Table_Priority The created {@link OA_DB_Table_Priority} object.
     */
    function &singleton()
    {
        $static =& $GLOBALS['_OA']['TABLES'][__CLASS__];
        if (!isset($static)) {
            $static = new OA_DB_Table_Priority(); // Don't use a reference here!
            $static->init(MAX_PATH . '/etc/tables_temp_priority.xml');
        }
        return $static;
    }

    /**
     * A method to destroy the singleton(s), so it (they) will
     * be re-created later if required.
     *
     * @static
     */
    function destroy()
    {
        if (isset($GLOBALS['_OA']['TABLES'][__CLASS__])) {
            unset($GLOBALS['_OA']['TABLES'][__CLASS__]);
        }
    }

}

?>
