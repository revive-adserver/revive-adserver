<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/DB/Table.php';

/**
 * A class for creating the core OpenX database tables.
 *
 * @package    OpenXDB
 * @subpackage Table
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_DB_Table_Core extends OA_DB_Table
{

    /**
     * The class constructor method.
     */
    function OA_DB_Table_Core()
    {
        parent::OA_DB_Table();
    }

    /**
     * A singleton method to create or return a single instance
     * of the {@link OA_DB_Table_Core} object.
     *
     * @static
     * @return OA_DB_Table_Core The created {@link OA_DB_Table_Core} object.
     */
    function &singleton()
    {
        $static =& $GLOBALS['_OA']['TABLES'][__CLASS__];
        if (!isset($static)) {
            $static = new OA_DB_Table_Core(); // Don't use a reference here!
            $static->init(MAX_PATH . '/etc/tables_core.xml');
        }
        return $static;
    }

    /**
     * A method to destroy the singleton, so it will be re-created later
     * if required.
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
