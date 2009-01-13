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

require (dirname(__FILE__) . "/AbstractService.php");
require (dirname(__FILE__) . "/M2MService.php");

class OX_M2M_M2MServiceImpl 
	extends OX_M2M_AbstractService  
	implements OX_M2M_M2MService
{
	/**
	 * @var OX_M2M_M2MServiceExecutor
	 */
	private $serviceExecutor;
	
	/**
	 * @var OX_M2M_M2MDataProvider
	 */
	private $m2mDataProvider;
	
	function __construct(&$serviceExecutor, &$m2mDataProvider)
	{
		$this->serviceExecutor = $serviceExecutor;
		$this->m2mDataProvider = $m2mDataProvider;
	}
	
	
	function getM2MTicket($accountId, $accountType)
	{
		$ticket = $this->call_("getM2MTicket", array(), $accountId, $accountType,
			$this->getFullCredentials($accountId, $accountType));
		$this->m2mDataProvider->setM2MTicket($accountId, $ticket);
		return $ticket;
	}
	
	
	function reconnectM2M($accountId, $accountType)
	{
		$password = $this->call_("reconnectM2M", array(), $accountId, $accountType);
		$this->m2mDataProvider->setM2MPassword($accountId, $password);
		return $password;
	}
	
	
	function connectM2M($accountId, $accountType)
	{
		$adminId = $this->m2mDataProvider->getAdminAccountId();
		if ($adminId == $accountId) {
			$credentials = $this->getNoPasswordCredentials($adminId);
		}
		$password = $this->call_("connectM2M", array ($accountId, $accountType), 
			$adminId, $this->m2mDataProvider->getAdminAccountType() ,$credentials);
		$this->m2mDataProvider->setM2MPassword($accountId, $password);
		return $password;
	}
	
	
	function getFullCredentials($accountId, $accountType)
	{    	
		return array("ph" => $this->m2mDataProvider->getPlatformHash(),
				     "accountId" => $accountId,
				     "m2mPassword" => $this->getM2MPassword_($accountId, $accountType));
	}
	
	
	function getNoPasswordCredentials($accountId)
	{    	
    	return array("ph" => $this->m2mDataProvider->getPlatformHash(),
				     "accountId" => $accountId);
	}
	
	
    function getCredentialsParam($accountId, $accountType)
    {
    	return array("ph" => $this->m2mDataProvider->getPlatformHash(),
    				 "m2mTicket" => $this->getM2MTicket_($accountId, $accountType));
	}
	
	
	function getM2MPassword_($accountId, $accountType)
	{
    	$password = $this->m2mDataProvider->getM2MPassword($accountId);
    	return $password ? $password : $this->connectM2M($accountId, $accountType);
	}
	
	
	function getM2MTicket_($accountId, $accountType)
	{
    	$ticket = $this->m2mDataProvider->getM2MTicket($accountId);
    	return $ticket ? $ticket : $this->getM2MTicket($accountId, $accountType); 
	}
	
	
	private $counter = 0;
	
    function call_($methodName, $params, $accountId, $accountType, $credentials = null)
    {
    	try {
    		if ($credentials === null) {
    			$credentials = $this->getCredentialsParam($accountId, $accountType);
    		}

    		OX_M2M_M2MProtectedRpc::dumpCall($this->serviceExecutor, $methodName, $params);
    		
    		$fullParams = array_merge(array($credentials), $params);
    		$result = $this->serviceExecutor->call($methodName, $fullParams);
    		
    		OX_M2M_M2MProtectedRpc::dumpResult($this->serviceExecutor, $methodName, $params, $result);
    		return $result;
    	}
    	catch (Exception $e) {
    		//echo "<BR><BR>" . $e->getTraceAsString() . "<BR><BR>";
    		if ($e->getCode() == OX_M2M_XmlRpcErrorCodes::$TICKET_EXPIRED) {
    			$this->getM2MTicket($accountId, $accountType);
    		}
    		else if ($e->getCode() == OX_M2M_XmlRpcErrorCodes::$PASSWORD_EXPIRED) {
    			$this->reconnectM2M($accountId, $accountType);
    		}
    		else if ($e->getCode() == OX_M2M_XmlRpcErrorCodes::$PASSWORD_INVALID
    			&& $accountId != $this->m2mDataProvider->getAdminAccountId()) {
				//if password invalid try regenerate using admin password 
    			$this->connectM2M($accountId, $accountType);
    		}
    		else {
    			throw $e;
    		}
    		return $this->call_($methodName, $params, $accountId, $accountType);
    	}
    }
}

?>
