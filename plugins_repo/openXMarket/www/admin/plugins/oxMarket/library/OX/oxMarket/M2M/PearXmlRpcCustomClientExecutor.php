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
        $oResponse = $this->rpcClient->send($oXmlRpcMsg);
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
}

?>
