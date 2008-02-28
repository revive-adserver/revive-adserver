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

require_once MAX_PATH . '/lib/OA/Central/M2M.php';
require_once MAX_PATH . '/plugins/authentication/cas/Central/RpcMapper.php';

/**
 * CAS authentication XML-RPC client
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 * @abstract
 */
class OA_Central_Cas extends OA_Central_M2M
{
    function OA_Central_Cas()
    {
        // Always use the admin account ID
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
        parent::OA_Central_M2M($adminAccountId);

        $this->oMapper = &new OA_Central_RpcMapper_Cas($this);
    }

    /**
     * Returns sso Id of the user with matching email address
     *
     * @param string $email
     * @return integer
     */
    function getAccountId($email)
    {
        return $this->oMapper->getAccountId($email);
    }

    /**
     * Creates partial account for user and sends activation email.
     *
     * @param $userEmail email of new user
     * @param $emailFrom sender email address of activation email
     * @param $emailSubject subject of activation email
     * @param $emailContent content of activation email, should contain
     * ${verificationHash} token, which will be replaced by verification hash
     * generated for created account.
     * @return integer  Id of new partial account
     */
    function createPartialAccount($userEmail, $emailFrom, $emailSubject, $emailContent)
    {
        return $this->oMapper->createPartialAccount($userEmail, $emailFrom, $emailSubject, $emailContent);
    }
    
    /**
     * Completes the creation of partial account
     * @param $accountId email of new user
     * @param $login sender email address of activation email
     * @param $md5Password subject of activation email
     * @param $verificationHash content of activation email, should contain
     * @return boolean|PEAR_Error  True on success else false
     */
    function completePartialAccount($accountId, $login, $md5Password, $verificationHash)
    {
        return $this->oMapper->completePartialAccount($accountId, $login, $md5Password, $verificationHash);
    }

    /**
     * Creates account for user and sends activation email.
     *
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
    function createAccount($userName, $md5Password, $userEmail, $emailFrom, $emailSubject, $emailContent)
    {
        return $this->oMapper->createAccount($userName, $md5Password, $userEmail, $emailFrom, $emailSubject, $emailContent);
    }

    /**
     * Changes user password. Method contacts SSO webservices, validate existing user's
     * password and changes the password to a new one
     *
     * @param integer $ssoUserId
     * @param string $newPassword
     * @param string $oldPassword
     * @return boolean
     */
    function changePassword($ssoUserId, $newPassword, $oldPassword)
    {
        return $this->oMapper->changePassword($ssoUserId, $newPassword, $oldPassword);
    }

    /**
     * Checks if password of sso user with $ssoUserId is valid.
     *
     * @param string $username
     * @param string $passwordHash
     * @return boolean
     */
    function checkUsernameMd5Password($username, $passwordHash)
    {
        return $this->oMapper->checkUsernameMd5Password($username, $passwordHash);
    }

    /**
     * Mark account as confirmed - indicated that user confirmed his email address
     *
     * @param string $verificationHash
     * @param string $email
     * @return integer
     */
    function confirmEmail($verificationHash, $email)
    {
        $ret = $this->oMapper->confirmEmail($verificationHash, $email);
        if (PEAR::isError($ret)) {
            if ($ret->getCode() == OA_CENTRAL_ERROR_SSO_EMAIL_ALREADY_VERIFIED) {
                return true;
            }
        }
        return $ret;
    }


    /**
     * Check if verification hash is correct for the email
     * And returns sso account Id
     *
     * @param string $verificationHash
     * @param string $email
     * @return integer
     */
    function checkEmail($verificationHash, $email)
    {
        return $this->oMapper->checkEmail($verificationHash, $email);
    }

    /**
     * Changes user email. Method contacts SSO webservices, validate existing user's
     * password and changes the email to a new one
     *
     * @param integer $ssoUserId
     * @param string $emailAddress
     * @param string $md5password
     * @return boolean
     */
    function changeEmail($ssoUserId, $emailAddress, $md5password)
    {
        return $this->oMapper->changeEmail($ssoUserId, $emailAddress, $md5password);
    }

    /**
     * Deletes a partial account from the sso database.
     *
     * @param integer $ssoAccountId
     * @param string $verificationHash
     * @return boolean
     */
    function rejectPartialAccount($ssoAccountId, $verificationHash)
    {
        return $this->oMapper->rejectPartialAccount($ssoAccountId, $verificationHash);
    }

    /**
     * Returns the sso account Id of matching user name/password. If there is
     * no matching user the Pear_error is returned instead with error code:
     * OA_CENTRAL_ERROR_SSO_USER_NOT_EXISTS
     *
     * @param string $userName
     * @param string $md5password
     * @return boolean
     */
    function getAccountIdByUsernamePassword($userName, $md5password)
    {
        return $this->oMapper->getAccountIdByUsernamePassword($userName, $md5password);
    }

    /**
     * Checks if userName is available.
     *
     * @param string $userName
     * @return boolean  True if user name is available, else false
     */
    function isUserNameAvailable($userName)
    {
        return $this->oMapper->isUserNameAvailable($userName);
    }

}

?>