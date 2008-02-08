<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

define('SSO_USER_NOT_EXISTS',  701);
define('SSO_INVALID_PASSWORD', 702);
define('SSO_EMAIL_EXISTS',     703);
define('SSO_INVALID_VER_HASH', 704);

/**
 * CAS authentication XML-RPC client
 *
 * @package    OpenadsPlugin
 * @subpackage Authentication
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 * @abstract
 */
class OaCasXmlRpc
{
    /**
     * Returns sso Id of the user with matching email address
     *
     * @param string $email
     * @return integer
     */
    function getUserIdByEmail($email)
    {
        return 1;
    }

    /**
     * Creates partial account for user and sends activation email.
     * @param $userEmail email of new user
     * @param $emailFrom sender email address of activation email
     * @param $emailSubject subject of activation email
     * @param $emailContent content of activation email, should contain
     * ${verificationHash} token, which will be replaced by verification hash
     * generated for created account.
     * @return integer  Id of new partial account
     */
    function createPartialSsoAccount($userEmail, $emailFrom,
        $emailSubject, $emailContent)
    {
        return 1;
    }
    
    /**
     * Creates account for user and sends activation email.
     * @param $userName User name
     * @param $md5Password md5 of password
     * @param $userEmail email of new user
     * @param $emailFrom sender email address of activation email
     * @param $emailSubject subject of activation email
     * @param $emailContent content of activation email, should contain
     * ${verificationHash} token, which will be replaced by verification hash
     * generated for created account.
     * @return  Id of new SSO account
     */
    function createSsoAccount($userName, $md5Password, $userEmail, $emailFrom,
        $emailSubject, $emailContent)
    {
        return 1;
    }
    
    /**
     * Mark account as confirmed - indicated that user confirmed his email address
     * @param string $verificationHash
     * @param string $email
     * @return boolean
     */
    function confirmEmail($verificationHash, $email)
    {
        return true;
    }
    
    /**
     * Changes user password. Method contacts SSO webservices, validate existing user's
     * password and changes the password to a new one
     * @param integer $ssoUserId
     * @param string $newPassword
     * @param string $oldPassword
     * @return boolean
     */
    function changePassword($ssoUserId, $newPassword, $oldPassword)
    {
        return true;
    }
    
    /**
     * Checks if password of sso user with $ssoUserId is valid.
     *
     * @param integer $ssoUserId
     * @param string $passwordHash
     * @return boolean
     */
    function checkUsernameMd5Password($ssoUserId, $passwordHash)
    {
        return true;
    }
}

?>