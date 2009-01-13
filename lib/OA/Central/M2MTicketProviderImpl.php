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
