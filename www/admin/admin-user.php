<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

$oPlugin = OA_Auth::staticGetAuthPlugin();
$userid = $oPlugin->getMatchingUserId($email_address, $login);
$userExists = !empty($userid);

$aErrors = array();
if (!empty($submit)) {
    if (!$userExists) {
        $aErrors = $oPlugin->validateUsersData($login, $passwd, $email_address);
    }
    if (empty($aErrors)) {
        $userid = $oPlugin->saveUser($login, $passwd, $contact_name,
            $email_address, $accountId);
        if ($userid) {
            OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions);
            MAX_Admin_Redirect::redirect("admin-access.php");
        } else {
            $aErrors = $oPlugin->getErrors();
        }
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

// Add variables required by the current authentication plugin
$oPlugin = OA_Auth::staticGetAuthPlugin();
$oPlugin->setTemplateVariables($oTpl);

// indicates whether the user exists (otherwise, a new user will be created or invitation sent)
$oTpl->assign('existingUser', !empty($userid));

// indicates whether the form is in editing user properties mode
// (linked from the "Permissions" link in the User Access table)
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
        'fields' => $oPlugin->getUserDetailsFields($userData)
    )
 )
);

$aHiddenFields = OA_Admin_UI_UserAccess::getHiddenFields($userData, $link);
$oTpl->assign('hiddenFields', $aHiddenFields);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
