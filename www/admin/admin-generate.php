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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oHeader = new OA_Admin_UI_Model_PageHeaderModel($GLOBALS['strGenerateBannercode'], 'iconDirectSelectionLarge');
phpAds_PageHeader(null, $oHeader);
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    $sections = array("4.1", "4.3");
} else {
    $sections = array("4.1", "4.2", "4.3");
}
if (OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT)) {
    $sections[] = '4.4';
}
phpAds_ShowSections($sections);




/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$tabindex = 1;
$maxInvocation = new MAX_Admin_Invocation();
echo $maxInvocation->placeInvocationForm();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();


?>