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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/www/admin/config.php';

// Register input variables
$auditId = MAX_getStoredValue('auditId', 0);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_ADVERTISER, OA_PERM_USER_LOG_ACCESS);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_TRAFFICKER, OA_PERM_USER_LOG_ACCESS);
OA_Permission::enforceAccessToObject('audit', $auditId);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader('userlog-index');
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "Preferences" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4"));
    phpAds_UserlogSelection("index");
}
else if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show the "Account Preferences", "User Log" and "Channel Management" sections of the "Preferences" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.7"));
}
else if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    phpAds_ShowSections(array("5.1", "5.2", "5.4"));
}


//  initialize parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);

$oTpl = new OA_Admin_Template('userlog-audit-detailed.html');

$oAudit = new OA_Dll_Audit();
$aAuditDetail = $oAudit->getAuditDetail($auditId);

$oTpl->assign('aAuditDetail', $aAuditDetail);

$oTpl->display();

phpAds_PageFooter();

?>
