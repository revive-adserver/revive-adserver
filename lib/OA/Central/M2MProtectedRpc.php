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

require_once (dirname(__FILE__) . '/M2MTicketProviderImpl.php');

class OA_Central_M2MProtectedRpc
	extends OX_M2M_M2MProtectedRpc 
{
	/**
	 * @param OX_M2M_XmlRpcExecutor $serviceExecutor
	 * @param OX_M2M_M2MTicketProvider $m2mTicketProvider
	 */
	function __construct(&$serviceExecutor, &$m2mTicketProvider = null)
    {
    	if ($m2mTicketProvider == null) {
    		$m2mTicketProvider = new OA_Central_M2MTicketProviderImpl();
    	}
    	parent::__construct($serviceExecutor, $m2mTicketProvider);
    	$this->setAccountIdAndType(0, OA_ACCOUNT_ADMIN);
    }
	
	function setAccountId($accountId)
	{
		$this->getM2mTicketProvider()->getM2mService()->setAccountId($accountId);
	}
	
	function setAccountType($accountType)
	{
		$this->getM2mTicketProvider()->getM2mService()->setAccountType($accountType);
	}
	
	function setAccountIdAndType($accountId, $accountType)
	{
		$this->getM2mTicketProvider()->getM2mService()->setAccountId($accountId);
		$this->getM2mTicketProvider()->getM2mService()->setAccountType($accountType);
	}
}

?>
