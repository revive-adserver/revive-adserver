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

require_once MAX_PATH . '/lib/openads/Table.php';

/**
 * A class for creating the core Openads database tables.
 *
 * @package    OpenadsDal
 * @subpackage Table
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Openads_Table_Core extends Openads_Table
{

    /**
     * The class constructor method.
     */
    function Openads_Table_Core()
    {
        parent::Openads_Table();
    }

    /**
     * A singleton method to create or return a single instance
     * of the {@link Openads_Table_Core} object.
     *
     * @static
     * @return Openads_Table_Core The created {@link Openads_Table_Core} object.
     */
    function &singleton()
    {
        $static = &$GLOBALS['_OPENADS']['TABLES'][__CLASS__];
        if (!isset($static)) {
            $static = new Openads_Table_Core(); // Don't use a reference here!
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
        if (isset($GLOBALS['_OPENADS']['TABLES'][__CLASS__])) {
            unset($GLOBALS['_OPENADS']['TABLES'][__CLASS__]);
        }
    }

}

?>
