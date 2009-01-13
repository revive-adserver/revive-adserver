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
