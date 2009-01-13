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
 * Table Definition for log_maintenance_forecasting
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Log_maintenance_forecasting extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'log_maintenance_forecasting';     // table name
    public $log_maintenance_forecasting_id;    // INT(11) => openads_int => 129 
    public $start_run;                       // DATETIME() => openads_datetime => 142 
    public $end_run;                         // DATETIME() => openads_datetime => 142 
    public $operation_interval;              // INT(11) => openads_int => 129 
    public $duration;                        // INT(11) => openads_int => 129 
    public $updated_to;                      // DATETIME() => openads_datetime => 14 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Log_maintenance_forecasting',$k,$v); }

    var $defaultValues = array(
                'start_run' => '%NO_DATE_TIME%',
                'end_run' => '%NO_DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>