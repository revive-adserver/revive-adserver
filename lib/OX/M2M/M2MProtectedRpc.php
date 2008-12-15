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

/**
 * OAP to OAC communication class
 *
 */
class OX_M2M_M2MProtectedRpc
{
	/**
	 * @var OX_M2M_XmlRpcExecutor
	 */
    protected $serviceExecutor;
    
	/**
	 * @var OX_M2M_M2MTicketProvider
	 */
    protected $m2mTicketProvider;
	
	/**
	 * @return OX_M2M_M2MTicketProvider
	 */
	public function getM2mTicketProvider() {
		return $this->m2mTicketProvider;
	}
	
	/**
	 * @param OX_M2M_M2MTicketProvider $m2mTicketProvider
	 */
	public function setM2mTicketProvider($m2mTicketProvider) {
		$this->m2mTicketProvider = $m2mTicketProvider;
	}
	/**
	 * @param OX_M2M_XmlRpcExecutor $serviceExecutor
	 * @param OX_M2M_M2MTicketProvider $m2mTicketProvider
	 */
    function __construct(&$serviceExecutor, &$m2mTicketProvider)
    {
    	$this->serviceExecutor = &$serviceExecutor;
    	$this->m2mTicketProvider = &$m2mTicketProvider;
    }
	
    function call($methodName, $params = null)
    {
    	try {
    		OX_M2M_M2MProtectedRpc::dumpCall($this->serviceExecutor, $methodName, $params);
    		
    		$fullParams = $this->addCredentials($params);
    		$result = $this->serviceExecutor->call($methodName, $fullParams);
    		
    		OX_M2M_M2MProtectedRpc::dumpResult($this->serviceExecutor, $methodName, $params, $result);
    		
    		return $result;
    	}
    	catch (Exception $e) {
    		//echo "<BR><BR>" . $e->getTraceAsString() . "<BR><BR>";
    		if ($e->getCode() == OX_M2M_XmlRpcErrorCodes::$TICKET_EXPIRED) {
    			$this->m2mTicketProvider->getTicket(true);
    			return $this->call($methodName, $params);
    		}
			throw $e;
    	}
    }
	
    /**
     * Adds credenials to parameters array. Should not modify array passed as parameter. 
     * @param array $params parameters of RPC function call
     * @return unknown
     */
    public function addCredentials($params)
    {
    	$credentials = array("m2mTicket" => $this->m2mTicketProvider->getTicket(false));
    	return array_merge(array($credentials), $params);
    }
    
	
	function setParam(&$arr, $name, $value)
	{
		if ($value !== null) {
			$arr[$name] = $value;
		}
	}
	
	
	static function dumpCall($this_, $methodName, $params, $pre = "Calling ", $post = "")
	{
//    	echo $pre . get_class($this_) . "." . $methodName . "( "; 
//    	var_dump($params);
//    	echo ")" . $post ."<BR>";
	}
	
	static function dumpResult($this_, $methodName, $params, $result)
	{
    	self::dumpCall($this_, $methodName, $params, "Returning", " = " . $result);
	}
}

?>
