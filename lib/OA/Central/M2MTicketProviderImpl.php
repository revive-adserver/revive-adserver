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

require_once (dirname ( __FILE__ ) . "../../../OX/M2M/M2MTicketProvider.php");
require_once (LIB_PATH . "/../OA/Dal/Central/M2M.php");
require_once (LIB_PATH . "/../OA/Central/M2M.php");

class OA_Central_M2MTicketProviderImpl
	implements OX_M2M_M2MTicketProvider
{
	/**
	 * @var OA_Dal_Central_M2M
	 */
	private $m2mDal;
	
	/**
	 * @var OA_Central_M2M
	 */
	private $m2mService;
	
	/**
	 * @return OA_Central_M2M
	 */
	public function getM2mService() {
		return $this->m2mService;
	}
	
	/**
	 * @param OA_Central_M2M $m2mService
	 */
	public function setM2mService($m2mService) {
		$this->m2mService = $m2mService;
	}
	/**
	 * @return OA_Dal_Central_M2M
	 */
	public function getM2mDal() {
		return $this->m2mDal;
	}
	
	/**
	 * @param OA_Dal_Central_M2M $m2mDal
	 */
	public function setM2mDal($m2mDal) {
		$this->m2mDal = $m2mDal;
	}
	/**
	 * @param OA_Dal_Central_M2M $m2mDal
	 * @param OA_Central_M2M $m2mService
	 */
	function __construct(&$m2mDal = null, &$m2mService = null)
	{
		$this->m2mDal = $m2mDal ? $m2mDal : new OA_Dal_Central_M2M ( );
		$this->m2mService = $m2mService ? $m2mService : new OA_Central_M2M ( );
	}
	
	
	function getTicket($force)
	{
		if ($force) {
			$result = $this->m2mService->getM2MTicket();
			if (PEAR::isError($result)) {
				throw new Exception($result->getMessage(), $result->getCode());
			}
		}
		$ticket = $this->m2mDal->getM2MTicket($this->m2mService->accountId);
		return $ticket ? $ticket : $this->getTicket(true);
	}
}

?>
