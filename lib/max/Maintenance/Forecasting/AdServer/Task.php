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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/core/Task.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Forecasting.php';

/**
 * A parent class, defining an interface for Maintenance Forecasting AdServer Task
 * objects, to be collected and run using the MAX_Core_Task_Runner class.
 *
 * @abstract
 * @package    MaxMaintenance
 * @subpackage Forecasting
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance_Forecasting_AdServer_Task extends MAX_Core_Task
{

    /**
     * Object of type MAX_Dal_Forecasting
     *
     * @var MAX_Dal_Forecasting
     */
    var $oDal;

    /**
     * A reference to the MAX_Maintenance_Forecasting_AdServer class
     * that is running the task.
     *
     * @var MAX_Maintenance_Forecasting_AdServer
     */
    var $oController;

    /**
     * The class constructor, to be used by classes implementing this class.
     */
    function MAX_Maintenance_Forecasting_AdServer_Task()
    {
        // Set the Data Access Layer object
        $this->oDal = &$this->_getDal();
        // Set the reference to the controlling class
        $oServiceLocator = &ServiceLocator::instance();
        $this->oController = &$oServiceLocator->get('Maintenance_Forecasting_Controller');
    }

    /**
     * A private method to create/register/return the
     * OA_Dal_Maintenance_Forecasting class.
     *
     * @access private
     * @return OA_Dal_Maintenance_Forecasting
     */
    function &_getDal()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Forecasting');
        if (!$oDal) {
            $oDal = new OA_Dal_Maintenance_Forecasting();
            $oServiceLocator->register('OA_Dal_Maintenance_Forecasting', $oDal);
        }
        return $oDal;
    }

}

?>
