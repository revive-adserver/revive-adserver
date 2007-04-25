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

require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Common/Task.php';

/**
 * A class for summarising raw data into the final tables, for the
 * Tracker module.
 *
 * @package    MaxMaintenance
 * @subpackage Statistics
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Statistics_Tracker_Task_SummariseFinal extends MAX_Maintenance_Statistics_Common_Task
{

    /**
     * The constructor method.
     *
     * @return MAX_Maintenance_Statistics_Tracker_Task_SummariseFinal
     */
    function MAX_Maintenance_Statistics_Tracker_Task_SummariseFinal()
    {
        parent::MAX_Maintenance_Statistics_Common_Task();
    }

    /**
     * The implementation of the MAX_Core_Task::run() method that performs
     * the task of this class.
     *
     * @TODO Implement, if required.
     */
    function run()
    {
        return;
    }

}

?>
