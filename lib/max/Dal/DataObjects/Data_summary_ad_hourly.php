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
 * Table Definition for data_summary_ad_hourly
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_hourly extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_ad_hourly';          // table name
    public $data_summary_ad_hourly_id;       // int(20)  not_null primary_key auto_increment
    public $date_time;                       // datetime(19)  not_null multiple_key binary
    public $ad_id;                           // int(10)  not_null multiple_key unsigned
    public $creative_id;                     // int(10)  not_null unsigned
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $requests;                        // int(10)  not_null unsigned
    public $impressions;                     // int(10)  not_null unsigned
    public $clicks;                          // int(10)  not_null unsigned
    public $conversions;                     // int(10)  not_null unsigned
    public $total_basket_value;              // real(12)  
    public $total_num_items;                 // int(11)  
    public $total_revenue;                   // real(12)  
    public $total_cost;                      // real(12)  
    public $total_techcost;                  // real(12)  
    public $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_ad_hourly',$k,$v); }

    var $defaultValues = array(
                'requests' => 0,
                'impressions' => 0,
                'clicks' => 0,
                'conversions' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>