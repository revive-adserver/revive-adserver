<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id:$
*/

/**
 * @package    Openads
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * A file to description Logon XmlRpcService class.
 *
 */

// Require the initialisation file
require_once '../../../../init.php';

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseLogonService.php';

// XmlRpc utils
require_once MAX_PATH . '/www/api/v1/common/XmlRpcUtils.php';

class LogonXmlRpcService extends BaseLogonService
{
    function LogonXmlRpcService()
    {
        $this->BaseLogonService();
    }
    
    /**
     *  Logon user.
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
     *  Logoff user.
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