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

phpAds_SessionDataDestroy();

// Register input variables
phpAds_registerGlobalUnslashed ('info', 'ssoid', 'email', 'vh', 'ssoexistinguser',
    'ssoexistingpassword', 'ssonewuser', 'ssonewpassword', 'ssonewpassword2',
    'email', 'proposedusername');

if ($proposedusername != '') 
{
    echo /* checkForDuplicates($proposedusername) */ strlen($proposedusername) > 4 ? 'available': 'notavailable';
    exit;
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
function pageHeader()
{
    $nav = array ("1" => array("password-recovery.php" => $GLOBALS['strPasswordRecovery']));

    $GLOBALS['OA_Navigation'] = array(
        OA_ACCOUNT_ADMIN      => $nav,
        OA_ACCOUNT_MANAGER    => $nav,
        OA_ACCOUNT_ADVERTISER => $nav,
        OA_ACCOUNT_TRAFFICKER => $nav
    );

    phpAds_PageHeader("1");

    echo "<br><br>"; // todo - move to template
}

class SsoAccounts {
    var $aValidationErrors = array();
    
    function process()
    {
        
    }
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('sso-start.html');
$oCentral = &new OA_Central_Cas();
$errors = array();

if ($email != '' && $vh != '') 
{
    $hideCreate = true;
    $hideLink = true;
    
    // check that $email and $vh are correct, it needs to be done in every call
    $ssoid = $oCentral->confirmEmail($vh, $email);
    $confirmed = $ssoid && !PEAR::isError($ssoid);
    if (PEAR::isError($ssoid)) {
        $errors[] = 'Server error: '.$ssoid->getMessage();
    }
    
    $doUsers = OA_Dal::factoryDO('users');
    if (!$doUsers->loadByProperty('email_address', $email)) {
        $confirmed = false;
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
                        $url = "sso-accounts.php?action=confirmation&userName=test";
                        header ("Location: " . $url);
                        exit();
                    } else {
                        // @todolang - move to translation files
                        $errors[] = 'Error while updating an account. Please try again.';
                    }
                } else {
                    // @todolang - move to translation files
                    $errors[] = 'Your username or password are not correct. Please try again.';
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
                    // todo - set a message for a next page
                    $url = "sso-accounts.php?action=confirmation&userName=test";
                    header ("Location: " . $url);
                    exit();
                }
            }
            
            $oTpl->assign('errorCreateFailed', true);
            $hideCreate = false;
        }
    }
    else 
    {
        if (!$confirmed)
        {
            // ssoid and verification could not be confirmed => no matching account 
            // @todolang - move string to translation
            $errors[] = "Error. There is no matching user. Check if your link is correct or contact your OpenX administrator.";
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
        'title'     => 'Please enter username and password of your OpenX account',
        'fields'    => array(
            array(
                'name'      => 'ssoexistinguser',
                'label'     => 'User name',
                'value'     => $ssoexistinguser,
                'title'     => 'Enter user name',
                'clientValid' => 'required:true'
            ),
            array(
                'name'      => 'ssoexistingpassword',
                'type'        => 'password',
                'label'     => 'Password',
                'value'     => '',
                'title'     => 'Enter password',
                'clientValid' => 'required:true'
            )
        )
    ),
));

$oTpl->assign('hideCreate', $hideCreate);
$oTpl->assign('fieldsCreate', array(
array(
    'title'     => 'Enter details for your new OpenX account',
    'fields'    => array(
        array(
            'name'      => 'email',
            'disabled'  => true,
            'label'     => 'Email',
            'value'     => $email
        ),
        array(
            'id'        => 'ssonewuser',
            'type'      => 'custom',
            'template'  => 'user-availability-check',
            'label'     => 'Desired user name',
            'title'     => 'Enter desired user name',
            'value'     => $ssonewuser
        ),           
        /*
        array(
            'name'      => 'ssonewuser',
            'id'        => 'ssonewuser',
            'label'     => 'Desired user name',
            'clientValid' => 'required:true',
            'title'     => 'Enter desired user name',
            'value'     => $ssonewuser
        ),*/
        array(
            'name'      => 'ssonewpassword',
            'id'         => 'ssonewpassword',
            'type'        => 'password',
            'clientValid' => 'required:true',
            'title'     => 'Enter password',
            'label'     => 'Password',
            'value'     => ''
        ),
        array(
            'name'      => 'ssonewpassword2',
            'id'        => 'ssonewpassword2',
            'type'        => 'password',
            'clientValid' => "required:true,equalTo:'#ssonewpassword'",
            'label'     => 'Re-enter password',
            'title'     => 'Re-enter the same password',
            'value'     => ''
        )
    )
)
));

$oTpl->assign('ssoid', $ssoid);
$oTpl->assign('email', $email);
$oTpl->assign('vh', $vh);

pageHeader();

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
