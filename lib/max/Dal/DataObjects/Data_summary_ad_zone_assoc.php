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

/**
 * Table Definition for data_summary_ad_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_zone_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_ad_zone_assoc';      // table name
    public $data_summary_ad_zone_assoc_id;    // BIGINT(20) => openads_bigint => 129 
    public $operation_interval;              // INT(10) => openads_int => 129 
    public $operation_interval_id;           // INT(10) => openads_int => 129 
    public $interval_start;                  // DATETIME() => openads_datetime => 142 
    public $interval_end;                    // DATETIME() => openads_datetime => 142 
    public $ad_id;                           // INT(10) => openads_int => 129 
    public $zone_id;                         // INT(10) => openads_int => 129 
    public $required_impressions;            // INT(10) => openads_int => 129 
    public $requested_impressions;           // INT(10) => openads_int => 129 
    public $priority;                        // DOUBLE() => openads_double => 129 
    public $priority_factor;                 // DOUBLE() => openads_double => 1 
    public $priority_factor_limited;         // SMALLINT(6) => openads_smallint => 129 
    public $past_zone_traffic_fraction;      // DOUBLE() => openads_double => 1 
    public $created;                         // DATETIME() => openads_datetime => 142 
    public $created_by;                      // INT(10) => openads_int => 129 
    public $expired;                         // DATETIME() => openads_datetime => 14 
    public $expired_by;                      // INT(10) => openads_int => 1 
    public $to_be_delivered;                 // TINYINT(1) => openads_tinyint => 145 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_ad_zone_assoc',$k,$v); }

    var $defaultValues = array(
                'interval_start' => '%NO_DATE_TIME%',
                'interval_end' => '%NO_DATE_TIME%',
                'priority_factor_limited' => 0,
                'created' => '%NO_DATE_TIME%',
                'to_be_delivered' => 1,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>