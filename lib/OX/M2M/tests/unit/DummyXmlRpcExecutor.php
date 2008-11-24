<?php

require (dirname(__FILE__) . "/../../XmlRpcExecutor.php");
require (dirname(__FILE__) . "/../../XmlRpcErrorCodes.php");

class OX_M2M_tests_unit_DummyXmlRpcExecutor
	implements OX_M2M_XmlRpcExecutor 
{
	public $m2mService;
	
	function call($methodName, $params)
	{
		$ticket = $params[0]["m2mTicket"];
		if (!in_array($ticket, $this->m2mService->tickets)) {
			throw new Exception("", OX_M2M_XmlRpcErrorCodes::$TICKET_EXPIRED);
		}
		$result = $params[1] * 2;
		return $result;
	}
}
	
?>
