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
 * Table Definition for ad_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Ad_zone_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ad_zone_assoc';                   // table name
    var $ad_zone_assoc_id;                // int(9)  not_null primary_key auto_increment
    var $zone_id;                         // int(9)  multiple_key
    var $ad_id;                           // int(9)  multiple_key
    var $priority;                        // real(22)  
    var $link_type;                       // int(6)  not_null
    var $priority_factor;                 // real(22)  
    var $to_be_delivered;                 // int(1)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ad_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>