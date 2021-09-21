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
 *
 * The logon XML-RPC service enables logon to the OpenX server.
 */

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the base class, BaseLogonService.
require_once MAX_PATH . '/www/api/v2/common/BaseLogonService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';

/**
 * The LogonXmlRpcService class extends the BaseLogonService class.
 *
 */
class LogonXmlRpcService extends BaseLogonService
{
    /**
     * The LogonXmlRpcService constructor calls the base service constructor to
     * initialise the service.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The logon method sends the username and password to log on to the service
     * and returns either a session ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function logon(&$oParams)
    {
        $sessionId = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(
            [&$userName, &$password],
            [true, true],
            $oParams,
            $oResponseWithError
        )) {
            return $oResponseWithError;
        }

        if ($this->logonServiceImp->logon($userName, $password, $sessionId)) {
            return XmlRpcUtils::stringTypeResponse($sessionId);
        } else {
            return XmlRpcUtils::generateError($this->logonServiceImp->getLastError());
        }
    }


    /**
     * The logoff method logs a user off from a service and ends the session
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function logoff(&$oParams)
    {
        $sessionId = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0, $oResponseWithError)) {
            return  $oResponseWithError;
        }

        if ($this->logonServiceImp->logoff($sessionId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->logonServiceImp->getLastError());
        }
    }
}
