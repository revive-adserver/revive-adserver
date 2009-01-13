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
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * The logon XML-RPC service enables logon to the OpenX server.
 *
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
    function LogonXmlRpcService()
    {
        $this->BaseLogonService();
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
    function logon(&$oParams)
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
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    function logoff(&$oParams)
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