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

define ('OA_SKIP_LOGIN', 1);

require_once '../../../../init.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

phpAds_SessionDataDestroy();

// Register input variables
phpAds_registerGlobalUnslashed ('id', 'action', 'email');

$authType = $GLOBALS['_MAX']['CONF']['authentication']['type'];
$oPlugin = &OX_Component::factoryByComponentIdentifier($authType);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$oTpl = new OA_Plugin_Template('sso-confirm.html','oxAuthCAS');
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
