<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';
require_once MAX_PATH . '/lib/max/Admin/LegalAgreement.php';
require_once MAX_PATH . '/lib/max/Permission/User.php';
require_once MAX_PATH . '/lib/max/Permission/Session.php';

// Define client permissions bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_ModifyInfo", 1);
define ("phpAds_ModifyBanner", 2);
define ("phpAds_AddBanner", 4);
define ("phpAds_DisableBanner", 8);
define ("phpAds_ActivateBanner", 16);
define ("phpAds_ViewTargetingStats", 32);
define ("phpAds_EditConversions", 64);
define ("phpAds_CsvImport", 128);

// Define affiliate permissions bitwise, so 1, 2, 4, 8, 16, etc.
//     ("phpAds_ModifyInfo", 1)
define ("phpAds_LinkBanners", 2);
define ("phpAds_AddZone", 4);
define ("phpAds_DeleteZone", 8);
define ("phpAds_EditZone", 16);
define ("MAX_AffiliateGenerateCode", 32);
define ("MAX_AffiliateViewZoneStats", 64);
define ("MAX_AffiliateIsReallyAffiliate", 128);
define ("MAX_AffiliateViewOnlyApprPendConv", 256);

/*-------------------------------------------------------*/
/* Start or continue current session                     */
/*-------------------------------------------------------*/

function phpAds_Start()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $session;
    
    // XXX: Why not try loading session data when Max is not installed?  
    if ($conf['max']['installed']) {
        phpAds_SessionDataFetch();
    }
    if (!phpAds_isLoggedIn() || phpAds_SuppliedCredentials()) {
        // Required files
        include_once MAX_PATH . '/lib/max/language/Default.php';
        // Load the required language files
        Language_Default::load();
        // ???
        if (!defined('MAX_SKIP_LOGIN')) {
            phpAds_SessionDataRegister(phpAds_Login());
        } else {
            phpAds_SessionDataRegister(array(
                "usertype" => phpAds_Agency,
                "loggedin" => 'f',
                "agencyid" => 0,
                "username" => 'fake-session'
            ));
        }
    }
    // Overwrite certain preset preferences
    if (isset($session['language']) && $session['language'] != '' && $session['language'] != $pref['language']) {
        $GLOBALS['_MAX']['CONF']['max']['language'] = $session['language'];
    }

    if ($conf['max']['installed']) {
        // Show legal agreement (terms & conditions) if necessary
        $oLegalAgreement = new MAX_Admin_LegalAgreement();
        if ($oLegalAgreement->doesCurrentUserNeedToSeeAgreement()) {
            if (!defined('MAX_SKIP_LEGAL_AGREEMENT')) {
                header("Location: legal-agreement.php");
                exit;
            }
        }
    }
}

/*-------------------------------------------------------*/
/* Stop current session                                  */
/*-------------------------------------------------------*/

function phpAds_Logout()
{
    phpAds_SessionDataDestroy();
    $dalAgency = MAX_DB::factoryDAL('agency');
    header ("Location: " . $dalAgency->getLogoutUrl($GLOBALS['agencyid']));
}


/*-------------------------------------------------------*/
/* Check if user has permission to view this page        */
/*-------------------------------------------------------*/

function phpAds_checkAccess ($allowed)
{
    global $session;
    global $strNotAdmin, $strAccessDenied;
    if (!($allowed & $session['usertype'])) {
        // No permission to access this page!
        phpAds_PageHeader(0);
        phpAds_Die($strAccessDenied, $strNotAdmin);
    }
}

/*-------------------------------------------------------*/
/* Check if user is of a certain usertype                */
/*-------------------------------------------------------*/

function phpAds_isUser($allowed)
{
    global $session;
    if (isset($session['usertype'])) {
        return ($allowed & (int) $session['usertype']);
    } else {
        return false;
    }
}

/*-------------------------------------------------------*/
/* Check if user has clearance to do a certain task      */
/*-------------------------------------------------------*/

function phpAds_isAllowed ($allowed)
{
    global $session;
    return ($allowed & (int) $session['permissions']);
}

/*-------------------------------------------------------*/
/* Get the ID of the current user                        */
/*-------------------------------------------------------*/

function phpAds_getUserID ()
{
    global $session;
    return ($session['userid']);
}

/*-------------------------------------------------------*/
/* Get the ID of the current user name                   */
/*-------------------------------------------------------*/

function phpAds_getUserName ()
{
    global $session;
    return ($session['username']);
}

/*-------------------------------------------------------*/
/* Get the ID of the current user type                   */
/*-------------------------------------------------------*/

function phpAds_getUserType ()
{
    global $session;
    return ($session['usertype']);
}

/*-------------------------------------------------------*/
/* Get the ID of the current user                        */
/*-------------------------------------------------------*/

function phpAds_getAgencyID ()
{
    global $session;
    return ($session['agencyid']);
}

/*-------------------------------------------------------*/
/* Get the help file of the current user                 */
/*-------------------------------------------------------*/

function phpAds_getHelpFile ()
{
    global $session;
    
    if (!empty($session['help_file'])) {
        return $session['help_file'];
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        return 'http://docs.m3.net/';
    }

    return false;
}

/*-------------------------------------------------------*/
/* Private functions                                     */
/*-------------------------------------------------------*/


function phpAds_Login()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $strPasswordWrong;
    if (phpAds_SuppliedCredentials()) {
        $username  = MAX_commonGetPostValueUnslashed('username');
        $password  = MAX_commonGetPostValueUnslashed('password');
        $md5digest = MAX_commonGetPostValueUnslashed('phpAds_md5');
        
        $md5digest = Session::getMd5FromPassword($md5digest, $password);
        
        Session::restartIfUsernameOrPasswordEmpty($md5digest, $username);
        
        Session::restartIfCookiesDisabled();
        
        if (phpAds_isAdmin($username, $md5digest)) {
            return User::getAAdminData($username);
        } elseif ($doUser = User::findAndGetDoUser($username, $md5digest)) {
            return $doUser->getAUserData();
        } else {
            // Password is not correct or user is not known
            // Set the session ID now, some server do not support setting a cookie during a redirect
            Session::restartToLoginScreen($strPasswordWrong);
        }
    } else {
        if (!$conf['max']['installed']) {
            // We are trying to install, grant access...
            return User::getAAdminData('admin');
        }
        // Set the session ID now, some servers do not support setting a cookie during a redirect.
        Session::restartToLoginScreen();
    }
}

function phpAds_IsLoggedIn()
{
    global $session;
    return (isset($session['loggedin']) ? ($session['loggedin'] == "t") : false);
}

function phpAds_SuppliedCredentials()
{
    return (isset($_POST['username']) &&
            isset($_POST['password']) &&
            isset($_POST['phpAds_md5']));
}

function phpAds_isAdmin($username, $md5)
{
    $pref = $GLOBALS['_MAX']['PREF'];
    if (($username == $pref['admin']) && ($md5 == $pref['admin_pw'])) {
        return true;
    }
    if (($username == $pref['admin']) && ($md5 == md5($pref['admin_pw']) && defined('phpAds_updating'))) {
        return true;
    }
    return false;
}

function phpAds_LoginScreen($message='', $sessionID=0, $inLineLogin = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    global $strUsername, $strPassword, $strLogin, $strWelcomeTo, $strEnterUsername, $strNoAdminInteface, $strForgotPassword;
    if (!$inLineLogin) {
        phpAds_PageHeader(phpAds_Login);
    }
    if ($conf['max']['uiEnabled'] == true)
    { 
        echo "<br />";
        echo "<form name='login' method='post' action='".basename($_SERVER['PHP_SELF']);
        echo (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ? '?'.htmlentities($_SERVER['QUERY_STRING']) : '')."'>";
        echo "<input type='hidden' name='phpAds_cookiecheck' value='".$_COOKIE['sessionID']."'>";
        echo "<input type='hidden' name='phpAds_md5' value=''>";
        echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr>";
        echo "<td width='80' valign='bottom'><img src='images/login-welcome.gif'>&nbsp;&nbsp;</td>";
        echo "<td width='100%' valign='bottom'>";
        echo "<span class='tab-s'>".$strWelcomeTo." ".(isset($pref['name']) && $pref['name'] != '' ? $pref['name'] : MAX_PRODUCT_NAME)."</span><br />";
        echo "<span class='install'>".$strEnterUsername."</span><br />";
        if ($message != "") {
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
            echo "<span class='tab-r'>$message</span></div>";
        } else {
            echo "<img src='images/break-el.gif' width='400' height='1' vspace='8'>";
        }
        echo "</td></tr><tr><td>&nbsp;</td><td>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr height='24'><td>".$strUsername.":&nbsp;</td><td><input class='flat' type='text' name='username' id='username' tabindex=1></td></tr>";
        echo "<tr height='24'><td>".$strPassword.":&nbsp;</td><td><input class='flat' type='password' name='password' id='password' tabindex=2></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' name='login' id='login' value='".$strLogin."'></td></tr>";
        echo "</table>";
        echo "<img src='images/break-el.gif' width='400' height='1' vspace='8'><br>";
        echo "<a href='password-recovery.php'>".$strForgotPassword."</a>";
        echo "</td></tr></table>";
        echo "</form>";
        echo "<script language='JavaScript'>";
        ?>
<!--
        login_focus();
//-->
        <?php
        echo "</script>";
    } else {
        phpAds_ShowBreak();
        echo "<br /><img src='images/info.gif' align='absmiddle'>&nbsp;";
        echo $strNoAdminInteface;
    }
    phpAds_PageFooter();
    exit;
}

?>
