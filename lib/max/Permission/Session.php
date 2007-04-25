<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

class MAX_Permission_Session
{
    /**
     * If the $md5digest is empty, converts $sPassword to md5
     * and returns it. Otherwise, returns $md5digest.
     *
     * @param string $md5digest
     * @param string $sPassword
     * @return string
     */
    function getMd5FromPassword($md5digest, $sPassword)
    {
        if ($md5digest == '' && $sPassword != '') {
            return md5($sPassword);
        }
        return $md5digest;
    }
    
    
    /**
     * Starts new user session and redirects user to the login screen.
     * The $sMessage error message is displayed to the user.
     *
     * @param string $sMessage
     */
    function restartToLoginScreen($sMessage = '')
    {
        $_COOKIE['sessionID'] = phpAds_SessionStart();
        phpAds_LoginScreen($sMessage, $_COOKIE['sessionID']);
    }
    
    
    /**
     * Starts new user session and redirects to login screen with
     * a proper message if either the password or username is empty.
     *
     * @param string $md5digest
     * @param string $username
     */
    function restartIfUsernameOrPasswordEmpty($md5digest, $username)
    {
        global $strEnterBoth;
        if ($md5digest == '' || $md5digest == md5('') || $username  == '') {
            MAX_Permission_Session::restartToLoginScreen($strEnterBoth);
        }
    }
    
    
    /**
     * Restarts user session and redirects to login screen with a proper message
     * if the user has cookies disabled.
     */
    function restartIfCookiesDisabled()
    {
        global $strEnableCookies;
        if ($_COOKIE['sessionID'] != $_POST['phpAds_cookiecheck']) {
            MAX_Permission_Session::restartToLoginScreen($strEnableCookies);
        }
    }
}
?>