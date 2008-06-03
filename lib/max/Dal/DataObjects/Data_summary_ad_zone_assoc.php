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

    public $__table = 'data_summary_ad_zone_assoc';      // table name
    public $data_summary_ad_zone_assoc_id;    // int(20)  not_null primary_key auto_increment
    public $operation_interval;              // int(10)  not_null unsigned
    public $operation_interval_id;           // int(10)  not_null unsigned
    public $interval_start;                  // datetime(19)  not_null multiple_key binary
    public $interval_end;                    // datetime(19)  not_null multiple_key binary
    public $ad_id;                           // int(10)  not_null multiple_key unsigned
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $required_impressions;            // int(10)  not_null unsigned
    public $requested_impressions;           // int(10)  not_null unsigned
    public $priority;                        // real(22)  not_null
    public $priority_factor;                 // real(22)  
    public $priority_factor_limited;         // int(6)  not_null
    public $past_zone_traffic_fraction;      // real(22)  
    public $created;                         // datetime(19)  not_null binary
    public $created_by;                      // int(10)  not_null unsigned
    public $expired;                         // datetime(19)  multiple_key binary
    public $expired_by;                      // int(10)  unsigned
    public $to_be_delivered;                 // int(1)  not_null

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