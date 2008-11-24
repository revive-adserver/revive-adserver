<?php

require (dirname(__FILE__) . "/../../M2MDataProvider.php");

class OX_M2M_tests_unit_DummyM2MDataProvider 
	implements OX_M2M_M2MDataProvider 
{
	public $accountId;
	private $passwords = array();
	private $tickets = array();
	private $platformHash = "hash";
	
	public function getPlatformHash()
	{
		return $this->platformHash;
	}
	
	public function setPlatformHash($platformHash)
	{
		$this->platformHash = $platformHash;
	}
	
	function getM2MPassword($accountId)
    {
    	return $this->passwords[$accountId];
    }
    

    function setM2MPassword($accountId, $m2mPassword)
    {
    	$this->passwords[$accountId] = $m2mPassword;
    }

    function getM2MTicket($accountId)
    {
    	return $this->tickets[$accountId];
    }

    function getM2MAccountType($accountId)
    {
    	return ($accountId == $this->getAdminAccountId()) ? "ADMIN" : "MANAGER";
    }
    
    function setM2MTicket($accountId, $m2mTicket)
    {
    	$this->tickets[$accountId] = $m2mTicket;
    }
    
	function getAccountId()
	{
		return $this->accountId;
	}

	
	function getAdminAccountId()
	{
		return 0;
	}
	
	function getAdminAccountType()
	{
		return "ADMIN";
	}
	
	function getProtocolVersion()
	{
		return 4;
	}
	
	function getMethodPrefix()
	{
		return "oac.";
	}
}

?>
