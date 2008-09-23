<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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

define ('OA_SKIP_LOGIN', 1);

require_once '../../init.php';
require_once MAX_PATH . '/www/admin/config.php';

phpAds_SessionDataDestroy();

// Register input variables
phpAds_registerGlobalUnslashed ('id', 'action', 'email');

$authType = $GLOBALS['_MAX']['CONF']['authentication']['type'];
$oPlugin = &OX_Component::factoryByComponentIdentifier($authType);
MAX_Plugin_Translation::registerInGlobalScope('authentication', 'oxAuthCAS');

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('sso-confirm.html');
$errors = array();

if (!empty($id)) 
{
    $doUsers = OA_Dal::factoryDO('users');
    $exist = $doUsers->loadByProperty('user_id', $id);
    if ($exist && $doUsers->email_address == $email) {
        $oTpl->assign('userName', $doUsers->contact_name);
        // todo: refactor to controller
        switch ($action) {
            case 'linked':
                $message = $oPlugin->translate('Your existing OpenX account was succesfully connected. You may use your existing credentials to sign-in.');
                break;
            case 'created':
                $message = $oPlugin->translate('Your OpenX account was succesfully created.');
                break;
        }
        $oTpl->assign('ssoMessage', $message);
    } else {
        $errors[] = $oPlugin->translate('Error: That user does not exist.');
    }
}
else
{
    $errors[] = $oPlugin->translate('Error: Wrong or missing parameters. That user does not exist.');
}

$oTpl->assign('errorMessage', implode('<br />', $errors));


phpAds_PageHeader(phpAds_Login);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
