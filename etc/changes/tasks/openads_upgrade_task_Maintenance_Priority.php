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

//$oMessages initialized by runner OA_Upgrade::runPostUpgradeTask
if (!class_exists('OA_Maintenance_Priority'))
{
    require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
}

$oMessages->logInfo('Starting Maintenance Prioritisation');
$upgradeTaskResult  = OA_Maintenance_Priority::run();
if (PEAR::isError($upgradeTaskResult)) {
    $oMessages->logError($upgradeTaskResult->getCode().': '.$upgradeTaskResult->getMessage());
}
$oMessages->logInfo('Maintenance Prioritisation: '.($upgradeTaskResult ? 'Complete' : 'Failed'));

?>