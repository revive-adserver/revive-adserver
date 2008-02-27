<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

/**
 * Table Definition for data_summary_ad_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_zone_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'data_summary_ad_zone_assoc';      // table name
    var $data_summary_ad_zone_assoc_id;    // int(20)  not_null primary_key auto_increment
    var $operation_interval;              // int(10)  not_null unsigned
    var $operation_interval_id;           // int(10)  not_null unsigned
    var $interval_start;                  // datetime(19)  not_null multiple_key binary
    var $interval_end;                    // datetime(19)  not_null multiple_key binary
    var $ad_id;                           // int(10)  not_null multiple_key unsigned
    var $zone_id;                         // int(10)  not_null multiple_key unsigned
    var $required_impressions;            // int(10)  not_null unsigned
    var $requested_impressions;           // int(10)  not_null unsigned
    var $priority;                        // real(22)  not_null
    var $priority_factor;                 // real(22)  
    var $priority_factor_limited;         // int(6)  not_null
    var $past_zone_traffic_fraction;      // real(22)  
    var $created;                         // datetime(19)  not_null binary
    var $created_by;                      // int(10)  not_null unsigned
    var $expired;                         // datetime(19)  multiple_key binary
    var $expired_by;                      // int(10)  unsigned
    var $to_be_delivered;                 // int(1)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_ad_zone_assoc',$k,$v); }

    var $defaultValues = array(
                'priority_factor_limited' => 0,
                'to_be_delivered' => 1,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>