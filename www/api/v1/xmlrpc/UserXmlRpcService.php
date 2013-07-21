<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
require_once MAX_PATH . '/www/api/v1/common/BaseUserService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

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
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function addUser($oParams)
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
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function modifyUser($oParams)
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
     * @param  XML_RPC_Message $oParams
     *
     * @return XML_RPC_Response  data or error
     */
    function deleteUser($oParams)
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
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    function getUser($oParams) {
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
     * The getUserListByAccountId method returns a list of users
     * for an account, or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    function getUserListByAccountId($oParams) {
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

    function updateSsoUserId($oParams) {
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

    function updateUserEmailBySsoId($oParams) {
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

}

/**
 * Initialise the XML-RPC server including the available methods and their signatures.
 *
**/
$oUserXmlRpcService = new UserXmlRpcService();

$server = new XML_RPC_Server(
    array(
        'addUser' => array(
            'function'  => array($oUserXmlRpcService, 'addUser'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Add user'
        ),

        'modifyUser' => array(
            'function'  => array($oUserXmlRpcService, 'modifyUser'),
            'signature' => array(
                array('int', 'string', 'struct')
            ),
            'docstring' => 'Modify user information'
        ),

        'deleteUser' => array(
            'function'  => array($oUserXmlRpcService, 'deleteUser'),
            'signature' => array(
                array('int', 'string', 'int')
            ),
            'docstring' => 'Delete user'
        ),

        'getUser' => array(
            'function'  => array($oUserXmlRpcService, 'getUser'),
            'signature' => array(
                array('struct', 'string', 'int')
            ),
            'docstring' => 'Get User Information'
        ),

        'getUserListByAccountId' => array(
            'function'  => array($oUserXmlRpcService, 'getUserListByAccountId'),
            'signature' => array(
                array('array', 'string', 'int')
            ),
            'docstring' => 'Get User List By Account Id'
        ),

        'updateSsoUserId' => array(
            'function'  => array($oUserXmlRpcService, 'updateSsoUserId'),
            'signature' => array(
                array('array', 'string', 'int', 'int')
            ),
            'docstring' => 'Change the SSO User ID field'
        ),

        'updateUserEmailBySsoId' => array(
            'function'  => array($oUserXmlRpcService, 'updateUserEmailBySsoId'),
            'signature' => array(
                array('array', 'string', 'int', 'string')
            ),
            'docstring' => 'Change users email for the user who match the SSO User ID'
        ),
    ),

    1  // serviceNow
);

?>
