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

// Register input variables
phpAds_registerGlobalUnslashed ('info', 'ssoid', 'verification', 'ssoexistinguser',
    'ssoexistingpassword', 'ssonewuser', 'ssonewpassword', 'ssonewpassword2',
    'ssonewemail', 'proposedusername');

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
pageHeader();

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

if ($ssoid != '' && $verification != '') 
{
    $hideCreate = true;
    $hideLink = true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if ($info == 'link') 
        {
            if ($ssoexistinguser != '' && $ssoexistingpassword != '') 
            {
                if (/* getAccountIdByUsernamePassword($ssoexistinguser, $ssoexistingpassword) */ false) 
                {
                    // TO DO: handle data
        
                    // redirect somewhere else
                    header ("Location: index.php");
                }
            }
            
            $oTpl->assign('errorLinkFailed', true);
            $hideLink = false;
        }
        
        if ($info == 'create') 
        {
            if ($ssonewuser != '' && $ssonewpassword != '') 
            {
                $oCentral = &new OA_Central_Cas();
                $ret = $oCentral->completePartialAccount($ssoid, $ssonewuser, md5($ssonewpassword), $verification);
                if ($ret)
                {
                    // todo - set a message for a next page
                    // redirect somewhere else
                    header ("Location: index.php");
                }
            }
            
            $oTpl->assign('errorCreateFailed', true);
            $hideCreate = false;
        }
    }
    else 
    {
        if (! /* confirmEmail($ssoid, $verification) */ true) 
        {
            // ssoid and verification could not be confirmed => no matching account 
            $oTpl->assign('errorNoMatchingAccount', true);
        }
        
        // TO DO: Retrieve the proper e-mail address
        $ssonewemail = 'niels@creatype.nl';
    }
}
else
{
    // ssoid and verification not provided => no matching account 
    $oTpl->assign('errorNoMatchingAccount', true);
}

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
            'name'      => 'ssonewemail',
            'disabled'  => true,
            'label'     => 'Email',
            'value'     => $ssonewemail
        ),
        array(
            'name'      => 'ssonewuser',
            'id'        => 'ssonewuser',
            'label'     => 'Desired user name',
            'clientValid' => 'required:true',
            'title'     => 'Enter desired user name',
            'value'     => $ssonewuser
        ),
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
$oTpl->assign('verification', $verification);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
