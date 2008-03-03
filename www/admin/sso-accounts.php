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
require_once MAX_PATH . '/plugins/authentication/cas/Central/Cas.php';
require_once MAX_PATH . '/lib/OA/Session.php';

phpAds_SessionDataDestroy();
phpAds_SessionStart();

// Register input variables
phpAds_registerGlobalUnslashed ('info', 'ssoid', 'email', 'vh', 'ssoexistinguser',
    'ssoexistingpassword', 'ssonewuser', 'ssonewpassword', 'ssonewpassword2',
    'email', 'proposedusername');

$oCentral = &new OA_Central_Cas();
$oPlugin = &MAX_Plugin::factory('authentication', 'cas');
MAX_Plugin_Translation::registerInGlobalScope('authentication', 'cas');

if ($proposedusername != '') 
{
    // @todo - add validation here before passing username to xml-rpc call
    // waiting here for a product decision on minimum length of username
    $ret = $oCentral->isUserNameAvailable($proposedusername);
    // @todo - add a possibility to return error message here
    // the JavaScript code needs to be modified first
    echo ($ret && !PEAR::isError($ret)) ? 'available': 'notavailable';
    exit;
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('sso-start.html');
$errors = array();
$urlConfirm = "sso-confirm.php?id=";

if ($email != '' && $vh != '') 
{
    $hideCreate = true;
    $hideLink = true;
    
    // check that $email and $vh are correct, it needs to be done in every call
    $ssoid = $oCentral->checkEmail($vh, $email);
    $confirmed = $ssoid && !PEAR::isError($ssoid);
    if (PEAR::isError($ssoid)) {
        $errors[] = $oPlugin->translate('Error: ').$ssoid->getMessage();
    }
    
    $doUsers = OA_Dal::factoryDO('users');
    if (!$doUsers->loadByProperty('email_address', $email)) {
        $confirmed = false;
    } else {
        $oTpl->assign('userName', $doUsers->contact_name);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $confirmed) 
    {
        if ($info == 'link') 
        {
            if ($ssoexistinguser != '' && $ssoexistingpassword != '') 
            {
                $md5Password = md5($ssoexistingpassword);
                $ssoAccountId = $oCentral->getAccountIdByUsernamePassword($ssoexistinguser, $md5Password);
                if ($ssoAccountId && !PEAR::isError($ssoAccountId)) {
                    $accountEmail = $oCentral->getAccountEmail($ssoAccountId);
                }
                if ($accountEmail && !PEAR::isError($accountEmail)) 
                {
                    $doUsers->sso_user_id = $ssoAccountId;
                    $doUsers->email_address = $accountEmail;
                    $ret = $doUsers->update();
                    if ($ret !== false && !PEAR::isError($ret)) {
                        $oCentral->rejectPartialAccount($ssoid, $vh);
                        OA_Session::setMessage(
                            $oPlugin->translate('Your existing OpenX account was succesfully connected. You may use your existing credentials to sign-in.'));
                        $url = $urlConfirm . $doUsers->user_id;
                        header ("Location: " . $url);
                        exit();
                    } else {
                        $errors[] = $oPlugin->translate('Error while updating an account. Please try again.');
                    }
                } else {
                        $errors[] = $oPlugin->translate('Your username or password are not correct. Please try again.');
                }
            }
            $hideLink = false;
        }
        
        if ($info == 'create') 
        {
            if ($ssonewuser != '' && $ssonewpassword != '') 
            {
                $ret = $oCentral->completePartialAccount($ssoid, $ssonewuser,
                    md5($ssonewpassword), $vh);
                if ($ret && !PEAR::isError($ret))
                {
                    OA_Session::setMessage(
                            $oPlugin->translate('Your OpenX account was succesfully created. You may now sign-in.'));
                    $url = $urlConfirm . $doUsers->user_id;
                    header ("Location: " . $url);
                    exit();
                } elseif (PEAR::isError($ret)) {
                    $errors[] = $oPlugin->translate('Error: ') . $ret->getMessage();
                }
            }
            
            $oTpl->assign('errorCreateFailed', $oPlugin->translate('Could not create your new OpenX account. Please try again.'));
            $hideCreate = false;
        }
    }
    else 
    {
        if (!$confirmed)
        {
            $errors[] = $oPlugin->translate("Error: There is no matching user. Check if your link is correct or contact your OpenX administrator.");
            $oTpl->assign('errorNoMatchingAccount', true);
        }
    }
}
else
{
    // ssoid and verification not provided => no matching account 
    $oTpl->assign('errorNoMatchingAccount', true);
}

$oTpl->assign('errorMessage', implode('<br />', $errors));
$oTpl->assign('hideLink', $hideLink);
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

$oTpl->assign('hideCreate', $hideCreate);
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

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
