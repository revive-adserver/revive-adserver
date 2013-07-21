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

require_once dirname(__FILE__) . '/PearXmlRpcCustomClientException.php';

class OX_oxMarket_M2M_PearXmlRpcCustomClientExecutor
    implements OX_M2M_XmlRpcExecutor
{
    /**
     * @var XML_RPC_Client
     */
    private $rpcClient;
    private $prefix = "";

    public function getPrefix()
    {
        return $this->prefix;
    }


    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }


    function __construct(XML_RPC_Client $xmlRpcClient)
    {
        $this->rpcClient = $xmlRpcClient;
    }


    /**
     * Call method with params
     *
     * Any param that is not XML_RPC_Value will be encoded using XML_RPC_encode function
     *
     * @param string $methodName
     * @param array $params
     * @return XML_RPC_Response
     * @throws OX_oxMarket_M2M_PearXmlRpcCustomClientException
     *             on communication error or XMLRPC fault responses
     */
    function call($methodName, $params)
    {
        // prepare xmlrpc message
        // encode param to XML_RPC_value only if it is not already encoded
        $oXmlRpcMsg = new XML_RPC_Message($this->getPrefix() . $methodName);
        foreach ($params as $param) {
           if ($param instanceof XML_RPC_Value) {
               $oXmlRpcMsg->addParam($param);
           } else {
               $oXmlRpcMsg->addParam(XML_RPC_encode($param));
           }
        }

        // send message
        PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$this, 'pearErrorHandler'));
        $oResponse = $this->rpcClient->send($oXmlRpcMsg, $this->getTimeout());
        PEAR::popErrorHandling();
        if (!$oResponse) {
            throw new OX_oxMarket_M2M_PearXmlRpcCustomClientException(
                'Communication error: ' . $this->rpcClient->errstr);
        }
        if ($oResponse->faultCode()) {
            throw new OX_oxMarket_M2M_PearXmlRpcCustomClientException(
                $oResponse->faultString(), $oResponse->faultCode());
        }
        return XML_RPC_decode($oResponse->value());
    }

    /**
     * A method to handle PEAR errors.
     * Just throws exception created from PEAR_Error
     *
     * @param PEAR_Error $oError A PEAR_Error object.
     * @throws OX_oxMarket_M2M_PearXmlRpcCustomClientException
     */
    function pearErrorHandler($oError)
    {
        throw new OX_oxMarket_M2M_PearXmlRpcCustomClientException(
            $oError->getMessage(), $oError->getCode());
    }

    /**
     * Get timeout for XML-RPC calls based on max_execution_time and default_socket_timeout
     *
     * @return int
     */
    function getTimeout()
    {
        $executionTime = (int)ini_get('max_execution_time');
        $default_socket_timeout = (int)ini_get('default_socket_timeout');
        // Time margin for calls
        $timeMargin = 1;
        //use orginal executionTime if is set to 0 or isn't higher than timeMargin
        if ($executionTime-$timeMargin > 0) {
            $executionTime = min(array(($executionTime-$timeMargin),$default_socket_timeout));
        }
        return $executionTime;
    }
}

