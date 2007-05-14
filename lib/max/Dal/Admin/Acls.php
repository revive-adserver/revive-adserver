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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Acls extends MAX_Dal_Common
{
    var $table = 'acls';

	/**
     * @param $findInSet string  Data to look after (eg 13)
     * @param $type string       Data type (eg Site:Channel)
     *
     * @return RecordSet
     * @access public
     */
    function getAclsByDataValueType($findInSet, $type)
    {
        $findInSet = "FIND_IN_SET(".DBC::makeLiteral($findInSet).", data)";
        $prefix = $this->getTablePrefix();
    	$query = "
            SELECT
                *,
                $findInSet
            FROM
                {$prefix}acls
            WHERE
                type = ".DBC::makeLiteral($type)."
                AND $findInSet > 0
        ";

        return DBC::NewRecordSet($query);
    }
}

?>