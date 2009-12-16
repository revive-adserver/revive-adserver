<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

/**
 * @package    OpenX
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 * The user XML-RPC service enables XML-RPC communication with the user object.
 *
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BaseUserService.
require_once MAX_PATH . '/www/api/v2/common/BaseUserService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

// Require the UserInfo helper class.
require_once MAX_PATH . '/lib/OA/Dll/User.php';

/**
 * The UserXmlRpcService class extends the BaseUserService class.
 *
 */
class UserXmlRpcService extends BaseUserService
{
    /**
     * The UserXmlRpcService constructor calls the base service constructor
     * to initialise the service.
     *
     */
    function UserXmlRpcService()
    {
        $this->BaseUserService();
    }

    /**
     * The addUser method adds details for a new user to the user
     * object and returns either the user ID or an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function addUser(&$oParams)
    {
        $sessionId          = null;
        $oUserInfo    = new OA_Dll_UserInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oUserInfo, $oParams,
                1, array('userName', 'contactName',
                    'emailAddress', 'username', 'password',
                    'defaultAccountId', 'active'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->addUser($sessionId, $oUserInfo)) {
            return XmlRpcUtils::integerTypeResponse($oUserInfo->userId);
        } else {
            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    /**
     * The modifyUser method changes the details for an existing user
     * or returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function modifyUser(&$oParams)
    {

        $sessionId          = null;
        $oUserInfo    = new OA_Dll_UserInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oUserInfo, $oParams,
                1, array('userId', 'userName', 'contactName',
                    'emailAddress', 'username', 'password',
                    'defaultAccountId', 'active'),
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->modifyUser($sessionId, $oUserInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }

    }

    /**
     * The deleteUser method either deletes an existing user or
     * returns an error message.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function deleteUser(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$userId),
            array(true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->deleteUser($sessionId, $userId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    /**
     * The getUser method returns either information about an user or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getUser(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$userId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oUser = null;
        if ($this->_oUserServiceImp->getUser($sessionId,
                $userId, $oUser)) {

            return XmlRpcUtils::getEntityResponse($oUser);
        } else {

            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    /**
     * The getUserList method returns a list of users
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getUserList(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId),
                array(true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aUserList = null;
        if ($this->_oUserServiceImp->getUserList($sessionId, $aUserList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aUserList);
        } else {

            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    /**
     * The getUserListByAccountId method returns a list of users
     * for an account, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function getUserListByAccountId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$accountId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aUserList = null;
        if ($this->_oUserServiceImp->getUserListByAccountId($sessionId,
                                            $accountId, $aUserList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aUserList);
        } else {

            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    function updateSsoUserId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$oldSsoUserId, &$newSsoUserId),
            array(true, true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->updateSsoUserId($sessionId, $oldSsoUserId, $newSsoUserId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    function updateUserEmailBySsoId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$ssoUserId, &$email),
            array(true, true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->updateUserEmailBySsoId($sessionId, $ssoUserId, $email)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    function linkUserToAdvertiserAccount($oParams)
    {
        $sessionId = null;
        $userId = null;
        $advertiserAccountId = null;
        $aPermissions = array();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$userId, &$advertiserAccountId),
            array(true, true, true), $oParams, $oResponseWithError) ||
            !XmlRpcUtils::getNotRequiredNonScalarValue($aPermissions, $oParams, 3,
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->linkUserToAdvertiserAccount($sessionId, $userId,
                $advertiserAccountId, $aPermissions)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    function linkUserToTraffickerAccount($oParams)
    {
        $sessionId = null;
        $userId = null;
        $traffickerAccountId = null;
        $aPermissions = array();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$userId, &$traffickerAccountId),
            array(true, true, true), $oParams, $oResponseWithError) ||
            !XmlRpcUtils::getNotRequiredNonScalarValue($aPermissions, $oParams, 3,
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->linkUserToTraffickerAccount($sessionId, $userId,
                $traffickerAccountId, $aPermissions)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

    function linkUserToManagerAccount($oParams)
    {
        $sessionId = null;
        $userId = null;
        $managerAccountId = null;
        $aPermissions = array();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$userId, &$managerAccountId),
            array(true, true, true), $oParams, $oResponseWithError) ||
            !XmlRpcUtils::getNotRequiredNonScalarValue($aPermissions, $oParams, 3,
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oUserServiceImp->linkUserToManagerAccount($sessionId, $userId,
                $managerAccountId, $aPermissions)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oUserServiceImp->getLastError());
        }
    }

}

?>
