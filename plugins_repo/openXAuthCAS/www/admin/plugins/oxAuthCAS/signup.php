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
require_once MAX_PATH . '/plugins/authentication/oxAuthCAS/Controller/Signup.php';

phpAds_SessionDataDestroy();
phpAds_SessionStart();

$request = phpAds_registerGlobalUnslashed ('action', 'firstName', 'lastName', 
    'websiteURL', 'email', 'emailConfirm', 'impressions', 'phone', 'mailingList',
    'ssoAccountMode', 'ssoUsername', 'ssoPassword', 
    'newSsoUsername', 'newSsoPassword', 'newSsoConfirmPassword', 
    'captcha'
);        

$oController = new OA_Controller_SSO_Signup();
$oController->process($request);

$oTpl = new OA_Plugin_Template('signup.html','oxAuthCAS');
$oController->assignModelToView($oTpl);
$oTpl->assign('errorMessage', implode('<br />', $oController->getErrors()));
$oPlugin = &$oController->getCasPlugin();

phpAds_PageHeader(phpAds_Login);
$oTpl->display();
phpAds_PageFooter();

?>
