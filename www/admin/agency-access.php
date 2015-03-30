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
require_once MAX_PATH . '/lib/RV/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_MANAGER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('agency', $agencyid);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
if ($agencyid != '') {
    addPageTools($agencyid);
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    	OA_Admin_Menu::setAgencyPageContext($agencyid, 'agency-edit.php');
    	$doAgency = OA_Dal::staticGetDO('agency', $agencyid);
        MAX_displayInventoryBreadcrumbs(array(array("name" => $doAgency->name)), "agency");
    	phpAds_PageHeader("4.1.3");
    	phpAds_ShowSections(array("4.1.2", "4.1.3"));
    } else {
        phpAds_PageHeader('4.4');
        phpAds_ShowSections(array("4.1", "4.2", "4.3", "4.4"));
    }
} else {
	MAX_displayInventoryBreadcrumbs(array(array("name" => phpAds_getClientName($agencyid))), "agency");
	phpAds_PageHeader("4.1.1");
	phpAds_ShowSections(array("4.1.1"));
}
$tabindex = 1;


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('agency-access.html');

// Ensure that any template variables for the authentication plugin are set
$oPlugin = OA_Auth::staticGetAuthPlugin();
$oPlugin->setTemplateVariables($oTpl);

$oTpl->assign('infomessage', OA_Session::getMessage());

$oTpl->assign('entityIdName', 'agencyid');
$oTpl->assign('entityIdValue', $agencyid);
$oTpl->assign('editPage', 'agency-user.php');
$oTpl->assign('unlinkPage', 'agency-user-unlink.php');

$doUsers = OA_Dal::factoryDO('users');
$oTpl->assign('users', array('aUsers' => $doUsers->getAccountUsersByEntity('agency', $agencyid)));
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function addPageTools($agencyId)
{
    addPageLinkTool($GLOBALS["strLinkUser_Key"], "agency-user-start.php?agencyid={$agencyId}", "iconAdvertiserAdd", $GLOBALS["strAddNew"] );
}


?>
