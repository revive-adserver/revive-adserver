<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * This class is useful if you want to perform database-based tests.
 *
 * @package    OpenadsDB
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class DbTestCase extends UnitTestCase
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
        $this->oaTable->init(MAX_PATH . $schemaPath);
    }

    /**
     * Creates and truncates the tables in the list $aTables.
     *
     * @param array $aTables Names of the tables to be created.
     */
    function initTables($aTables)
    {
        foreach ($aTables as $table) {
            $this->oaTable->createTable($table);
            $this->oaTable->truncateTable($table);
        }
    }
    
    
    function getPrefix()
    {
        return $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }
}
?>
