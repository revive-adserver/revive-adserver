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

require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
//$oMessages initialized by runner OA_Upgrade::runPostUpgradeTask

$oMessages->logInfo('Recompiling Acls');
if (PEAR::isError($result)) {
    $oMessages->logError($result->getCode() . ': ' . $result->getMessage());
} else {
    $oMessages->logInfo('OK');
}
$oMessages->logInfo('Starting Acls Recompilation');
$upgradeTaskResult = MAX_AclReCompileAll(true);
if (PEAR::isError($upgradeTaskResult)) {
    $oMessages->logError($upgradeTaskResult->getCode() . ': ' . $upgradeTaskResult->getMessage());
}
$oMessages->logInfo('Acls Recompilation: ' . ($upgradeTaskResult ? 'Complete' : 'Failed'));
