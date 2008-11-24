<?php

class OX_M2M_tests_unit_DummyM2MService
	implements OX_M2M_XmlRpcExecutor
{
	private $passwords = array();
	public $tickets = array();
	private $counter = 0;
	public $callCounter = 0; 
	
	function call($methodName, $params)
	{
		$result = $this->call_($methodName, $params);
		OX_M2M_M2MProtectedRpc::dumpResult($this, $methodName, $params, $result);
		return $result;
	}
	
	
	function call_($methodName, $params)
	{
		$this->callCounter++;
		
		if (substr_count($methodName, "connectM2M") > 0) {
			$accountId = $params[1];
			$accountType = $params[2];
			
			if (accountType != "ADMIN") {
				if  ($this->passwords[$accountId]) {
					throw new Exception("Password already generated", 
						OX_M2M_XmlRpcErrorCodes::$PASSWORD_ALREADY_GENERATED);
				}
//				if (!in_array($params["m2mTicket"], $this->tickets)) {
//					throw new Exception("", OX_M2M_XmlRpcErrorCodes::$TICKET_EXPIRED);
//				}
			}
			$this->types[$accountId] = $accountType;
			$password = ("password" . ++$this->counter);
			return ($this->passwords[$accountId] = $password);
		}
		else if (substr_count($methodName, "getM2MTicket")) {
			return ($this->tickets[$params[0]["accountId"]] = ("ticket" . ++$this->counter));
		}
		return null;
	}
}

?>
