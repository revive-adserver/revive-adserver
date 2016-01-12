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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics/Task.php';

/**
 * The MSE process task class that manages (enables/disables) campaigns, as
 * required, during the MSE run.
 *
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Statistics_Task_ManageCampaigns extends OX_Maintenance_Statistics_Task
{

    /**
     * The constructor method.
     *
     * @return OX_Maintenance_Statistics_Task_ManageCampaigns
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The implementation of the OA_Task::run() method that performs
     * the required task of activating/deactivating campaigns.
     */
    function run()
    {
        if ($this->oController->updateIntermediate) {
            $oServiceLocator =& OA_ServiceLocator::instance();
            $oDate =& $oServiceLocator->get('now');
            $oDal =& $oServiceLocator->get('OX_Dal_Maintenance_Statistics');
            $message = '- Managing (activating/deactivating) campaigns';
            $this->oController->report .= "$message.\n";
            OA::debug($message);
            $this->report .= $oDal->manageCampaigns($oDate);
        }
    }

}

?>