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

require_once MAX_PATH . '/www/admin/lib-banner-cache.inc.php';
//$oMessages initialized by runner OA_Upgrade::runPostUpgradeTask

$oMessages->logInfo('Starting Banner Cache Recompilation');
$upgradeTaskResult = processBanners(true);
if (PEAR::isError($upgradeTaskResult)) {
    $oMessages->logError($upgradeTaskResult->getCode() . ': ' . $upgradeTaskResult->getMessage());
}
$upgradeTaskError[] = ' Banner Cache Recompilation: ' . ($upgradeTaskResult ? 'Complete' : 'Failed');
