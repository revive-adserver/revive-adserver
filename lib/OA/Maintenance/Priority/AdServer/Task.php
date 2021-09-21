<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
 */
class OA_Maintenance_Priority_AdServer_Task extends OA_Task
{
    /**
     * Object of type OA_Dal_Maintenance_Priority
     *
     * @var OA_Dal_Maintenance_Priority
     */
    public $oDal;

    /**
     * The class constructor, to be used by classes implementing this class.
     */
    public function __construct()
    {
        $this->oDal = $this->_getDal();
    }

    /**
     * A method to create, register and return the Maintenance Priority DAL.
     *
     * @access private
     * @return object OA_Dal_Maintenance_Priority
     */
    public function &_getDal()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
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
    public function &_getMaxTablePriorityObj()
    {
        $dbType = strtolower($GLOBALS['_MAX']['CONF']['database']['type']);
        $oServiceLocator = OA_ServiceLocator::instance();
        $oTable = $oServiceLocator->get('OA_DB_Table_Priority');
        if (!$oTable) {
            $oTable = &OA_DB_Table_Priority::singleton();
            $oServiceLocator->register('OA_DB_Table_Priority', $oTable);
        }
        return $oTable;
    }
}
