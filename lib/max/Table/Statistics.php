<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/Table.php';

/**
 * A class for creating the temporary Max database tables required
 * for performing the maintenance statistics functions.
 *
 * @package    MaxDal
 * @subpackage Table
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Table_Statistics extends MAX_Table
{
    
    /**
     * The class constructor method.
     */
    function MAX_Table_Statistics()
    {
        parent::MAX_Table();
    }
    
    /**
     * A singleton method to create or return a single instance
     * of the {@link MAX_Table_Statistics} object.
     *
     * @static
     * @param string $dbType The database type. Default value is taken from the parsed
     *                       Max config file.
     * @return {@link MAX_Table_Statistics} The created {@link MAX_Table_Statistics} object.
     */
    function &singleton($dbType = null)
    {
        if (is_null($dbType)) {
            $dbType = $GLOBALS['_MAX']['CONF']['database']['type'];
        }
        $static = &$GLOBALS['_MAX']['TABLES'][__CLASS__][$dbType];
        if (!isset($static)) {
            $static = new MAX_Table_Statistics(); // No reference here!
            $static->init(MAX_PATH . '/etc/tables_temporary_statistics.' . $dbType . '.sql');
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
        unset($GLOBALS['_MAX']['TABLES'][__CLASS__]);
    }
    
}

?>
