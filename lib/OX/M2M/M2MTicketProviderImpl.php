<?php

require (dirname(__FILE__) . "/M2MTicketProvider.php");

class OX_M2M_M2MTicketProviderImpl
	implements OX_M2M_M2MTicketProvider
{
	/**
	 * @var OX_M2M_M2MService
	 */
	private $m2mService;
	
	/**
	 * @var OX_M2M_M2MDataProvider
	 */
	private $m2mDataProvider;
	
	private $accountId;
	private $accountType;
	
	/**
	 * @return unknown
	 */
	public function getAccountId() {
		return $this->accountId;
	}
	
	/**
	 * @return unknown
	 */
	public function getAccountType() {
		return $this->accountType;
	}
	
	/**
	 * @param unknown_type $accountId
	 */
	public function setAccountId($accountId) {
		$this->accountId = $accountId;
	}
	
	/**
	 * @param unknown_type $accountType
	 */
	public function setAccountType($accountType) {
		$this->accountType = $accountType;
	}
	function __construct(&$m2mService, &$m2mDataProvider, $accountId, $accountType)
	{
		if ($m2mService instanceof OX_M2M_M2MService) {
			$this->m2mService = $m2mService;
		} 
		else {
			$this->m2mService = new OX_M2M_M2MServiceImpl($m2mService, $m2mDataProvider);
		}
		$this->m2mDataProvider = $m2mDataProvider;
		$this->accountId = $accountId;
		$this->accountType = $accountType;
	}
	
	
	function getTicket($force)
	{
		if ($force) {
			return $this->m2mService->getM2MTicket($this->accountId, $this->accountType); 
		}
		$ticket = $this->m2mDataProvider->getM2MTicket($this->accountId);
		return $ticket ? $ticket : $this->getTicket(true); 
	}
}

?>
