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

require_once MAX_PATH.'/lib/OA.php';
require_once MAX_PATH.'/lib/OA/XmlRpcClient.php';
require_once MAX_PATH.'/lib/OA/Central.php';
require_once MAX_PATH.'/lib/OA/Sync.php';

require_once 'Date.php';


define('OA_DAL_CENTRAL_PROTOCOL_VERSION', 5);

define('OA_DAL_CENTRAL_AUTH_NONE',    0);
define('OA_DAL_CENTRAL_AUTH_SSO',     1);
define('OA_DAL_CENTRAL_AUTH_CAPTCHA', 2);
define('OA_DAL_CENTRAL_AUTH_M2M',     4);


/**
 * OAP to OAC communication class
 *
 */
class OA_Dal_Central_Rpc
{
    /**
     * @var OA_XML_RPC_Client
     */
    var $oXml;

    /**
     * @var array
     */
    var $_conf;

    /**
     * SSO username
     *
     * @var string
     */
    var $ssoUsername;

    /**
     * SSO password hash
     *
     * @var string
     */
    var $ssoPassword;

    /**
     * @var int
     */
    var $m2mAccountId;

    /**
     * @var OA_Central_M2M
     */
    var $oCentral;

    /**
     * Class constructor
     *
     * @todo M2M password retireval
     *
     * @param OA_Central_Common Caller class
     * @param array $aConf
     * @return OA_Dal_Central_Rpc
     */
    function OA_Dal_Central_Rpc(&$oCentral, $aConf = null)
    {
        if (!isset($aConf)) {
            $this->_conf = $GLOBALS['_MAX']['CONF']['oacXmlRpc'];
        } else {
            $this->_conf = $aConf;
        }

        $this->oXml = new OA_XML_RPC_Client(
            $this->_conf['path'],
            "{$this->_conf['protocol']}://{$this->_conf['host']}",
            $this->_conf['port']
        );

        // Store the caller object, if is or extends OA_Central_M2M
        if (is_a($oCentral, 'OA_Central_M2M')) {
            $this->oCentral = &$oCentral;
        }

        $this->ssoUsername = OA_Dal_ApplicationVariables::get('sso_admin');
        $this->ssoPassword = OA_Dal_ApplicationVariables::get('sso_password');
    }

    /**
     * A method to perform a call to the OAC XML-RPC server
     *
     * @param string $methodName The RPC method name
     * @param int    $authType   Type of required authentication, see constants
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function call($methodName, $authType, $aParams = null, $recursionLevel = 0)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];

        $oMsg = new XML_RPC_Message('oac.'.$methodName);

        $aHeader = array(
            'protocolVersion' => OA_DAL_CENTRAL_PROTOCOL_VERSION,
            'ph'              => OA_Dal_ApplicationVariables::get('platform_hash')
        );

        if ($authType & OA_DAL_CENTRAL_AUTH_M2M) {
            if (empty($this->oCentral)) {
                MAX::raiseError('M2M authentication used with a non M2M-enabled OA_Central object');
            }

            $aHeader['accountId'] = (int)$this->oCentral->accountId;
            $aHeader['m2mPassword'] = OA_Dal_Central_M2M::getM2MPassword($this->oCentral->accountId);

            if (empty($aHeader['m2mPassword'])) {
                // No password stored, connect!
                $result = $this->oCentral->connectM2M();

                if (PEAR::isError($result)) {
                    return $result;
                }

                $aHeader['m2mPassword'] = $result;
            }
        }
        if ($authType & OA_DAL_CENTRAL_AUTH_SSO) {
            $aHeader['ssoUsername'] = $this->ssoUsername;
            $aHeader['ssoPassword'] = $this->ssoPassword;
        }
        if ($authType & OA_DAL_CENTRAL_AUTH_CAPTCHA) {
            $aHeader['ssoCaptcha']  = isset($_REQUEST['captcha-value']) ? $_REQUEST['captcha-value'] : '';
            $aHeader['ssoCaptchaRandom']  = isset($_REQUEST['captcha-random']) ? $_REQUEST['captcha-random'] : '';
        }

        $oMsg->addParam(XML_RPC_encode($aHeader));

        if (is_array($aParams)) {
            foreach ($aParams as $oParam) {
                $oMsg->addParam($oParam);
            }
        }

        OA::disableErrorHandling();
        $oResponse = $this->oXml->send($oMsg, OAC_RPC_TIMEOUT);
        OA::enableErrorHandling();

        if (!$oResponse) {
            return new PEAR_Error('XML-RPC connection error', 800);
        }

        if ($oResponse->faultCode() || $oResponse->faultString()) {
            // Deal with particular response codes at Rpc level, avoiding endless recursion
            if (!$recursionLevel) {
                switch ($oResponse->faultCode()) {

                    case OA_CENTRAL_ERROR_PLATFORM_DOES_NOT_EXIST:
                        OA::disableErrorHandling();
                        $oSync = new OA_Sync();
                        $oSync->checkForUpdates();
                        OA::enableErrorHandling();
                        return $this->call($methodName, $authType, $aParams, ++$recursionLevel);

                    case OA_CENTRAL_ERROR_ERROR_NOT_AUTHORIZED:
                        if (!($authType & OA_DAL_CENTRAL_AUTH_M2M)) {
                            break;
                        } else {
                            // Go with OA_CENTRAL_ERROR_M2M_PASSWORD_INVALID
                        }

                    case OA_CENTRAL_ERROR_M2M_PASSWORD_INVALID:
                        // OAP was asked to connect the account to get a password
                        // Clear the password and retry
                        OA_Dal_Central_M2M::setM2MPassword($this->oCentral->accountId, '');
                        return $this->call($methodName, $authType, $aParams, ++$recursionLevel);

                    case OA_CENTRAL_ERROR_M2M_PASSWORD_EXPIRED:
                        $result = $this->_reconnectM2M();
                        if (PEAR::isError($result)) {
                            return $result;
                        }
                        return $this->call($methodName, $authType, $aParams, ++$recursionLevel);
                }
            }

            return new PEAR_Error($oResponse->faultString(), $oResponse->faultCode());
        }

        return XML_RPC_decode($oResponse->value());
    }

    /**
     * Wrapper to the call method using no authentication
     *
     * @see call()
     *
     * @param string $methodName The RPC method name
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function callNoAuth($methodName, $aParams = null)
    {
        return $this->call($methodName, OA_DAL_CENTRAL_AUTH_NONE, $aParams);
    }

    /**
     * Wrapper to the call method using M2M authentication
     *
     * @see call()
     *
     * @param string $methodName The RPC method name
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function callM2M($methodName, $aParams = null)
    {
        return $this->call($methodName, OA_DAL_CENTRAL_AUTH_M2M, $aParams);
    }

    /**
     * Wrapper to the call method using SSO authentication
     *
     * @see call()
     *
     * @param string $methodName The RPC method name
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function callSso($methodName, $aParams = null)
    {
        return $this->call($methodName, OA_DAL_CENTRAL_AUTH_SSO, $aParams);
    }

    /**
     * Wrapper to the call method using Capthca authentication
     *
     * @see call()
     *
     * @param string $methodName The RPC method name
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function callCaptcha($methodName, $aParams = null)
    {
        return $this->call($methodName, OA_DAL_CENTRAL_AUTH_CAPTCHA, $aParams);
    }

    /**
     * Wrapper to the call method using M2M + Capthca authentication
     *
     * @see call()
     *
     * @param string $methodName The RPC method name
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function callCaptchaM2M($methodName, $aParams = null)
    {
        return $this->call($methodName, OA_DAL_CENTRAL_AUTH_M2M | OA_DAL_CENTRAL_AUTH_CAPTCHA, $aParams);
    }

    /**
     * Wrapper to the call method using SSO + Capthca authentication
     *
     * @see call()
     *
     * @param string $methodName The RPC method name
     * @param array  $aParams    Array of XML_RPC_Values
     * @return mixed The returned value or PEAR_Error on error
     */
    function callCaptchaSso($methodName, $aParams = null)
    {
        return $this->call($methodName, OA_DAL_CENTRAL_AUTH_SSO | OA_DAL_CENTRAL_AUTH_CAPTCHA, $aParams);
    }

    /**
     * A private method to call the reconnectM2M method and store the new password
     *
     * @return mixed True on success, PEAR_Error otherwise
     */
    function _reconnectM2M()
    {
        $result = $this->callM2M('reconnectM2M');
        if (PEAR::isError($result)) {
            return $result;
        }

        OA_Dal_Central_M2M::setM2MPassword($this->oCentral->accountId, $result);

        return true;
    }

}



?>
