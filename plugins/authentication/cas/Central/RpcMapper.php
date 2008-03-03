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

require_once MAX_PATH . '/lib/OA/Central/RpcMapper.php';

/**
 * CAS authentication XML-RPC client mapper
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 * @abstract
 */
class OA_Central_RpcMapper_Cas extends OA_Central_RpcMapper
{
    function OA_Central_RpcMapper_Cas(&$oCentral)
    {
        $this->oRpc =& new OA_Dal_Central_Rpc($oCentral);
    }

    /**
     * Returns sso Id of the user with matching email address
     *
     * @param string $email
     * @return integer
     */
    function getAccountId($email)
    {
        return $this->oRpc->callM2M('getAccountId', array(
            new XML_RPC_Value($email, 'string')
        ));
    }

    /**
     * Returns email of sso account which matches the sso user id
     *
     * @param integer $ssoAccountId
     * @return string
     */
    function getAccountEmail($ssoAccountId)
    {
        return $this->oRpc->callM2M('getAccountEmail', array(
            new XML_RPC_Value($ssoAccountId, 'int')
        ));
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
    function createPartialAccount($userEmail, $emailFrom, $emailSubject, $emailContent)
    {
        $this->oRpc->setRemoveExtraLines(false);
        return $this->oRpc->callM2M('createPartialAccount', array(
            new XML_RPC_Value($userEmail, 'string'),
            new XML_RPC_Value($emailFrom, 'string'),
            new XML_RPC_Value($emailSubject, 'string'),
            new XML_RPC_Value($emailContent, 'string')
        ));
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
        return $this->oRpc->callM2M('completePartialAccount', array(
            new XML_RPC_Value($accountId, 'int'),
            new XML_RPC_Value($login, 'string'),
            new XML_RPC_Value($md5Password, 'string'),
            new XML_RPC_Value($verificationHash, 'string')
        ));
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
        return $this->oRpc->callM2M('createAccount', array(
            new XML_RPC_Value($userName, 'string'),
            new XML_RPC_Value($md5Password, 'string'),
            new XML_RPC_Value($userEmail, 'string'),
            new XML_RPC_Value($emailFrom, 'string'),
            new XML_RPC_Value($emailSubject, 'string'),
            new XML_RPC_Value($emailContent, 'string')
        ));
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
        return $this->oRpc->callM2M('changePassword', array(
            new XML_RPC_Value($ssoUserId, 'int'),
            new XML_RPC_Value($newPassword, 'string'),
            new XML_RPC_Value($oldPassword, 'string')
        ));
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
        return $this->oRpc->callM2M('checkUsernameMd5Password', array(
            new XML_RPC_Value($username, 'string'),
            new XML_RPC_Value($passwordHash, 'string')
        ));
    }

    /**
     * Mark account as confirmed - indicated that user confirmed his email address
     *
     * @param string $verificationHash
     * @param string $email
     * @return boolean
     */
    function confirmEmail($verificationHash, $email)
    {
        return $this->oRpc->callM2M('confirmEmail', array(
            new XML_RPC_Value($verificationHash, 'string'),
            new XML_RPC_Value($email, 'string')
        ));
    }

    /**
     * Check if verification hash is correct for the email
     * And returns sso account Id
     *
     * @param string $verificationHash
     * @param string $email
     * @return integer  Account Id
     */
    function checkEmail($verificationHash, $email)
    {
        return $this->oRpc->callM2M('checkEmail', array(
            new XML_RPC_Value($verificationHash, 'string'),
            new XML_RPC_Value($email, 'string')
        ));
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
        return $this->oRpc->callM2M('changeEmail', array(
            new XML_RPC_Value($ssoUserId, 'int'),
            new XML_RPC_Value($emailAddress, 'string'),
            new XML_RPC_Value($md5password, 'string')
        ));
    }
    
    /**
     * Returns the sso account Id of matching user name/password.
     *
     * @param string $userName
     * @param string $md5password
     * @return boolean
     */
    function getAccountIdByUsernamePassword($userName, $md5password)
    {
        return $this->oRpc->callM2M('getAccountIdByUsernamePassword', array(
            new XML_RPC_Value($userName, 'string'),
            new XML_RPC_Value($md5password, 'string')
        ));
    }
    
    /**
     * Deletes a partial account from the sso database.
     *
     * @param integer $ssoAccountId
     * @param string $verificationHash
     * @return boolean True if account was deleted or PEAR_Error on error
     */
    function rejectPartialAccount($ssoAccountId, $verificationHash)
    {
        return $this->oRpc->callM2M('rejectPartialAccount', array(
            new XML_RPC_Value($ssoAccountId, 'int'),
            new XML_RPC_Value($verificationHash, 'string')
        ));
    }
    
    /**
     * Checks if such userName is available
     *
     * @param string $userName
     * @return boolean True if such userName is available, else false
     */
    function isUserNameAvailable($userName)
    {
        return $this->oRpc->callM2M('isUserNameAvailable', array(
            new XML_RPC_Value($userName, 'string')
        ));
    }
    
    /**
     * Sets a "remove_extra_lines" RPC Client option.
     * By default it is set to true. It cause some problems when multiline data is send through XML-RPC.
     * For example when email body are sent.
     * 
     * Forwards a call to OA_Dal_Central_Rpc
     *
     * @param boolean $option
     */
    function setRemoveExtraLines($option = true)
    {
        $this->oRpc->setRemoveExtraLines($option);
    }

}

?>