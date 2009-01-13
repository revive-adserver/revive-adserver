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
