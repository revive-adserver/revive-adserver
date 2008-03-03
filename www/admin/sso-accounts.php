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

define ('OA_SKIP_LOGIN', 1);

require_once '../../init.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/plugins/authentication/cas/Controller/ConfirmAccount.php';

phpAds_SessionDataDestroy();
phpAds_SessionStart();

// Register input variables
$request = phpAds_registerGlobalUnslashed ('action', 'ssoid', 'email', 'vh', 'ssoexistinguser',
    'ssoexistingpassword', 'ssonewuser', 'ssonewpassword', 'ssonewpassword2',
    'email', 'proposedusername');


$oController = new OA_Controller_SSO_ConfirmAccount();
$oController->process($request);

require_once MAX_PATH . '/lib/OA/Admin/Template.php';
$oTpl = new OA_Admin_Template('sso-start.html');
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

phpAds_PageHeader("1");
$oTpl->display();
phpAds_PageFooter();

?>
