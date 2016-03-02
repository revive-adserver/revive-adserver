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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Dal/Inventory/Trackers.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

phpAds_registerGlobal('action');

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("maintenance-index");
phpAds_MaintenanceSelection("appendcodes");

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Init DAL
$tr = new MAX_Dal_Inventory_Trackers();

if (!empty($action) && ($action == 'Recompile')) {
    OA_Permission::checkSessionToken();

    $tr->recompileAppendCodes();
    echo "<strong>$strAppendCodesRecompiled<br />";
}

echo $strAppendCodesResult;
phpAds_ShowBreak();
// Check the append codes in the database against the compiled appendcode strings...

echo "<strong>$strTrackers:</strong>";
phpAds_showBreak();

// Check all the trackers...
$diffs = $tr->checkCompiledAppendCodes();

foreach ($diffs as $v) {
    echo "<a href='client-trackers.php?clientid={$v['clientid']}&trackerid={$v['trackerid']}'>{$v['trackername']}</a><br />";
}

if ($allTrackersValid = !count($diffs)) {
    echo $strAppendCodesValid;
}
phpAds_showBreak();

if (!$allTrackersValid) {
    phpAds_ShowBreak();
    echo "<br /><strong>$strErrorsFound</strong><br /><br />";
    echo "$strRepairAppenedCodes<br />";
    echo "<form action='' METHOD='GET'>";
    echo "<input type='hidden' name='token' value='".htmlspecialchars(phpAds_SessionGetToken(), ENT_QUOTES)."' />";
    echo "<input type='submit' name='action' value='$strRecompile' />";
    echo "</form>";
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
