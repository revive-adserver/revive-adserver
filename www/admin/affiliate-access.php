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
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_TRAFFICKER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
$oHeaderModel = MAX_displayWebsiteBreadcrumbs($affiliateid);
if (!empty($affiliateid)) {
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        OA_Admin_Menu::setPublisherPageContext($affiliateid, 'affiliate-access.php');
        addPageTools($affiliateid);
        addWebsitePageTools($affiliateid);
        phpAds_PageHeader("4.2.7", $oHeaderModel);
        phpAds_ShowSections(array("4.2.2", "4.2.3","4.2.4","4.2.5","4.2.6","4.2.7"));
    } else {
        addPageTools($affiliateid);
        phpAds_PageHeader('2.3', $oHeaderModel);
        $sections = array('2.1');
        if (OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION)) {
            $sections[] = '2.2';
        }
        $sections[] = '2.3';
        phpAds_ShowSections($sections);
    }
}
else {
    phpAds_PageHeader("4.2.1", $oHeaderModel);
    phpAds_ShowSections(array("4.2.1"));
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-access.html');

// Ensure that any template variables for the authentication plugin are set
$oPlugin = OA_Auth::staticGetAuthPlugin();
$oPlugin->setTemplateVariables($oTpl);

$oTpl->assign('infomessage', OA_Session::getMessage());

$oTpl->assign('entityIdName', 'affiliateid');
$oTpl->assign('entityIdValue', $affiliateid);
$oTpl->assign('editPage', 'affiliate-user.php');
$oTpl->assign('unlinkPage', 'affiliate-user-unlink.php');


$doUsers = OA_Dal::factoryDO('users');
$oTpl->assign('users', array('aUsers' => $doUsers->getAccountUsersByEntity('affiliates', $affiliateid)));
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function addPageTools($affiliateid)
{
    addPageLinkTool($GLOBALS["strLinkUser_Key"], "affiliate-user-start.php?affiliateid=$affiliateid", "iconWebsiteUserAdd", $GLOBALS["keyLinkUser"] );
}

?>
