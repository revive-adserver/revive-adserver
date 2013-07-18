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
require_once MAX_PATH . '/plugins/authentication/oxAuthCAS/Controller/ConfirmAccount.php';

phpAds_SessionDataDestroy();
phpAds_SessionStart();

// Register input variables
$request = phpAds_registerGlobalUnslashed ('action', 'ssoid', 'email', 'vh', 'ssoexistinguser',
    'ssoexistingpassword', 'ssonewuser', 'ssonewpassword', 'ssonewpassword2',
    'email', 'proposedusername');


$oController = new OA_Controller_SSO_ConfirmAccount();
$oController->process($request);

$oTpl = new OA_Plugin_Template('sso-start.html','oxAuthCAS');

$oController->assignModelToView($oTpl);
$oPlugin = &$oController->getCasPlugin();

/**
 * In later refactoring phase following template related code should
 * be moved to external ModelView class as well.
 */
$oTpl->assign('errorMessage', implode('<br />', $oController->getErrors()));
$oTpl->assign('fieldsLink', array(
    array(
        'title'     => $oPlugin->translate('Please enter username and password of your OpenX account'),
        'fields'    => array(
            array(
                'name'      => 'ssoexistinguser',
                'label'     => $oPlugin->translate('User name'),
                'value'     => $ssoexistinguser,
                'title'     => $oPlugin->translate('Enter user name'),
                'clientValid' => 'required:true'
            ),
            array(
                'name'      => 'ssoexistingpassword',
                'type'        => 'password',
                'label'     => $oPlugin->translate('Password'),
                'value'     => '',
                'title'     => $oPlugin->translate('Enter password'),
                'clientValid' => 'required:true'
            )
        )
    ),
));

$oTpl->assign('fieldsCreate', array(
array(
    'title'     => $oPlugin->translate('Enter details for your new OpenX account'),
    'fields'    => array(
        array(
            'name'      => 'email',
            'disabled'  => true,
            'label'     => $oPlugin->translate('Email'),
            'value'     => $email
        ),
        array(
            'name'        => 'ssonewuser',
            'id'        => 'ssonewuser',
            'type'      => 'custom',
            'template'  => 'user-availability-check',
            'label'     => $oPlugin->translate('Desired user name'),
            'title'     => $oPlugin->translate('Enter desired user name'),
            'value'     => $ssonewuser
        ),
        array(
            'name'      => 'ssonewpassword',
            'id'         => 'ssonewpassword',
            'type'        => 'password',
            'clientValid' => 'required:true',
            'title'     => $oPlugin->translate('Enter password'),
            'label'     => $oPlugin->translate('Password'),
            'value'     => ''
        ),
        array(
            'name'      => 'ssonewpassword2',
            'id'        => 'ssonewpassword2',
            'type'        => 'password',
            'clientValid' => "required:true,equalTo:'#ssonewpassword'",
            'label'     => $oPlugin->translate('Re-enter password'),
            'title'     => $oPlugin->translate('Re-enter the same password'),
            'value'     => ''
        )
    )
)
));

$oTpl->assign('ssoid', $ssoid);
$oTpl->assign('email', $email);
$oTpl->assign('vh', $vh);

phpAds_PageHeader(phpAds_Login);
$oTpl->display();
phpAds_PageFooter();

?>
