<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/Task.php';

/**
 * A parent class, defining an interface for Maintenance Priority AdServer Task
 * objects, to be collected and run using the OA_Task_Runner class.
 *
 * @abstract
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Demian Turner <demian@m3.net>
 */
class OA_Maintenance_Priority_AdServer_Task extends OA_Task
{

    /**
     * Object of type OA_Dal_Maintenance_Priority
     *
     * @var OA_Dal_Maintenance_Priority
     */
    var $oDal;

    /**
     * The class constructor, to be used by classes implementing this class.
     */
    function OA_Maintenance_Priority_AdServer_Task()
    {
        $this->oDal =& $this->_getDal();
    }

    /**
     * A method to create, register and return the Maintenance Priority DAL.
     *
     * @access private
     * @return object OA_Dal_Maintenance_Priority
     */
    function &_getDal()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDal =& $oServiceLocator->get('OA_Dal_Maintenance_Priority');
        if (!$oDal) {
            $oDal = new OA_Dal_Maintenance_Priority();
            $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);
        }
        return $oDal;
    }

    /**
     * Method to create/register/return the Maintenance Priority table class.
     *
     * @access private
     * @return OA_DB_Table_Priority
     */
    function &_getMaxTablePriorityObj()
    {
        $dbType = strtolower($GLOBALS['_MAX']['CONF']['database']['type']);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oTable = $oServiceLocator->get('OA_DB_Table_Priority');
        if (!$oTable) {
            $oTable =& OA_DB_Table_Priority::singleton();
            $oServiceLocator->register('OA_DB_Table_Priority', $oTable);
        }
        return $oTable;
    }

}

?>