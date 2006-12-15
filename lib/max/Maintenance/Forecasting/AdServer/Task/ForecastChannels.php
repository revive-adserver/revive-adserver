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

require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task.php';
require_once 'Date.php';

/**
 * A class to perform forecasting of the number of requests, impressions, and/or
 * clicks for channels in the systems.
 *
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Forecasting_AdServer_Task_ForecastChannels extends MAX_Maintenance_Forecasting_AdServer_Task
{

    /**
     * The constructor method.
     */
    function MAX_Maintenance_Forecasting_AdServer_Task_ForecastChannels()
    {
        parent::MAX_Maintenance_Forecasting_AdServer_Task();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class.
     *
     * @TODO Not implemented. This needs to be done before the channel
     *       availability report can use
     *       MAX_Dal_Statistics::getChannelDailyInventoryForecastByChannelZoneIds()
     *       without the hack turned on.
     */
    function run()
    {
    }

}

?>
