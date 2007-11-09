<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
 * Table Definition for audit
 */

define('OA_AUDIT_ACTION_INSERT',1);
define('OA_AUDIT_ACTION_UPDATE',2);
define('OA_AUDIT_ACTION_DELETE',3);

require_once 'DB_DataObjectCommon.php';

class DataObjects_Audit extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'audit';                           // table name
    public $auditid;                         // int(9)  not_null primary_key unsigned auto_increment
    public $actionid;                        // int(5)  not_null unsigned
    public $context;                         // string(255)  not_null
    public $contextid;                       // int(9)  not_null
    public $parentid;                        // int(9)  not_null
    public $userid;                          // int(9)  not_null
    public $username;                        // string(64)  not_null
    public $usertype;                        // int(4)  not_null
    public $details;                         // string(255)  not_null
    public $updated;                         // datetime(19)  not_null multiple_key binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Audit',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
