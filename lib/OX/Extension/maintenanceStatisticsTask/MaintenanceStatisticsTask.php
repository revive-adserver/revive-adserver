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
require_once LIB_PATH . '/Plugin/Component.php';

/**
 * Plugins_MaintenanceStatisticsTask is an abstract class for every maintenanceStatisticsTask plugin
 *
 * @package    OpenXPlugin
 * @subpackage MaintenaceStatisticsTask
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 * @abstract
 */
abstract class Plugins_MaintenanceStatisticsTask extends OX_Component
{
    /**
     * Constructor method
     */
    function __construct($extension, $group, $component) {
    }

    /**
     * Method returns OX_Maintenance_Statistics_Task 
     * to run in the Maintenance Statistics Engine
     * Implements hook 'addMaintenanceStatisticsTask'
     * 
     * @abstract 
     * @return OX_Maintenance_Statistics_Task
     */
    abstract function addMaintenanceStatisticsTask();
}

?>
