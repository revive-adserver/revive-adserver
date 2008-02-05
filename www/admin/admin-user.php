<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

// Register input variables
phpAds_registerGlobalUnslashed ('login', 'passwd', 'link', 'contact_name', 
    'email_address', 'permissions', 'submit');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);
$doAccounts = OA_Dal::factoryDO('accounts');
$accountId = $doAccounts->getAdminAccountId();
$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);

$aErrors = array();
if (!empty($submit)) {
    if (!OA_Permission::userNameExists($login)) {
        $aErrors = OA_Admin_UI_UserAccess::validateUsersData($login, $passwd);
    }
    if (empty($aErrors)) {
        $userid = OA_Admin_UI_UserAccess::saveUser($login, $passwd, $contact_name,
            $email_address, $accountId);
        OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions);
        MAX_Admin_Redirect::redirect("admin-access.php");
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.4.2");
phpAds_ShowSections(array("4.1", "4.3", "4.4", "4.4.2"));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('admin-user.html');
$oTpl->assign('action', 'admin-user.php');
$oTpl->assign('backUrl', 'admin-user-start.php');
$oTpl->assign('method', 'POST');
$oTpl->assign('aErrors', $aErrors);

// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false;
$oTpl->assign('hosted', $HOSTED);
$oTpl->assign('existingUser', !empty($userid));
$oTpl->assign('editMode', !$link);

$doUsers = OA_Dal::staticGetDO('users', $userid);
$userData = array();
if ($doUsers) {
    $userData = $doUsers->toArray();
} else {
    $userData['username'] = $login;
    $userData['contact_name'] = $contact_name;
    $userData['email_address'] = $email_address;
}

$oTpl->assign('fields', array(
    array(
        'title'  => $strUserDetails,
        'fields' => OA_Admin_UI_UserAccess::getUserDetailsFields($userData)
    )
 )
);

$aHiddenFields = OA_Admin_UI_UserAccess::getHiddenFields($login, $link);
$oTpl->assign('hiddenFields', $aHiddenFields);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
