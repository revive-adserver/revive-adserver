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

/**
 * A class used for creating simple custom queries.
 *
 * @package    OpenadsDB
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class OA_DB_Sql
{
    /**
     * Generates INSERT INTO... command. Assumes that $aValues contains
     * a list of pairs column => value. Escapes values as necessary and adds
     * '' for strings.
     *
     * @param string $table
     * @param array $aValues
     * @return string
     */
	function sqlForInsert($table, $aValues)
	{
	    foreach($aValues as $column => $value) {
	        $aValues[$column] = DBC::makeLiteral($value);
	    }
        $sColumns = implode(",", array_keys($aValues));
        $sValues = implode(",", $aValues);
        return "INSERT INTO $table ($sColumns) VALUES ($sValues)";
	}
}

?>
