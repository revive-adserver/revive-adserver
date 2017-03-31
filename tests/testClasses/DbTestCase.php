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

require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * This class is useful if you want to perform database-based tests.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
abstract class DbTestCase extends UnitTestCase
{
    /**
     * Use this variable to carry DDL operations.
     *
     * @var OA_DB_Table
     */
    var $oaTable;

    /**
     * Initializes the $oaTable with the default db schema
     * ('/etc/tables_core.xml').
     * @see #initOaTable()
     */
    function setUp()
    {
        $this->initOaTable('/etc/tables_core.xml');
    }

    /**
     * Truncates all the tables in the database.
     */
    function tearDown()
    {
        $this->oaTable->truncateAllTables();
    }

    /**
     * Initializes the $oaTable with the schema specified by $schemaPath.
     * The $schemaPath is a path to the schema relative to the max installation
     * directory, e.g. '/etc/tables_core.xml'.
     *
     * @param unknown_type $schemaPath
     */
    function initOaTable($schemaPath)
    {
        $this->oaTable = new OA_DB_Table();
        $result = $this->oaTable->init(MAX_PATH . $schemaPath);
        if (PEAR::isError($result))
        {
            return false;
        }
        return true;
    }

    /**
     * Creates and truncates the tables in the list $aTables.
     *
     * @param array $aTables Names of the tables to be created.
     */
    function initTables($aTables)
    {
        foreach ($aTables as $table)
        {
            $result = $this->oaTable->createTable($table);
            if (PEAR::isError($result))
            {
                return false;
            }
            $result = $this->oaTable->truncateTable($table);
            if (PEAR::isError($result))
            {
                return false;
            }
        }
        return true;
    }


    function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }
}
?>
