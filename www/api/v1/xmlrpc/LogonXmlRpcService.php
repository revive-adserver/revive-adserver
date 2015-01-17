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
require_once MAX_PATH . '/www/api/v1/common/BaseLogonService.php';

// Require the XML-RPC utilities.
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

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
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The logon method sends the username and password to log on to the service
     * and returns either a session ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    function logon($oParams)
    {
        $sessionId          = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$userName, &$password),
            array(true, true), $oParams, $oResponseWithError)) {

            return $oResponseWithError;
        }

        if($this->logonServiceImp->logon($userName, $password, $sessionId))
        {
            return XmlRpcUtils::stringTypeResponse($sessionId);
        }
        else
        {
            return XmlRpcUtils::generateError($this->logonServiceImp->getLastError());
        }
    }


    /**
     * The logoff method logs a user off from a service and ends the session
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message $oParams
     *
     * @return generated result (data or error)
     */
    function logoff($oParams)
    {
        $sessionId          = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0, $oResponseWithError)) {

            return  $oResponseWithError;
        }

        if($this->logonServiceImp->logoff($sessionId))
        {
            return XmlRpcUtils::booleanTypeResponse(true);
        }
        else
        {
            return XmlRpcUtils::generateError($this->logonServiceImp->getLastError());
        }
    }
}

/**
 * Initialise the XML-RPC server including the available methods and their signatures
 *
**/
$oLogonXmlRpcService = new LogonXmlRpcService();

$server = new XML_RPC_Server(
    array(
        'logon' => array(
            'function'  => array($oLogonXmlRpcService, 'logon'),
            'signature' => array(
                array('string', 'string', 'string')
            ),
            'docstring' => 'Logon method'
        ),

        'logoff' => array(
            'function'  => array($oLogonXmlRpcService, 'logoff'),
            'signature' => array(
                array('bool', 'string')
            ),
            'docstring' => 'Logoff method'
        ),
    ),
    1  // serviceNow
);

?>
