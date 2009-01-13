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

require_once MAX_PATH . '/lib/OA/Central/Common.php';


/**
 * OAP binding to the M2M management API
 *
 */
class OA_Central_M2M extends OA_Central_Common
{
    var $accountId;
    var $accountType;
	
	/**
	 * @return unknown
	 */
	public function getAccountType() {
		return $this->accountType;
	}
	
	/**
	 * @param unknown_type $accountType
	 */
	public function setAccountType($accountType) {
		$this->accountType = $accountType;
	}
	/**
	 * @return unknown
	 */
	public function getAccountId() {
		return $this->accountId;
	}
	
	/**
	 * @param unknown_type $accountId
	 */
	public function setAccountId($accountId) {
		$this->accountId = $accountId;
	}
    /**
     * Class constructor
     *
     * @param string $accountId If null, the current account ID is used
     * @param string $accountType If null, the current account type is used
     * @return OA_Central_M2M
     */
    function OA_Central_M2M($accountId = null)
    {
        parent::OA_Central_Common();

        $currentId = OA_Permission::getAccountId();

        if (is_null($accountId)) {
            $this->accountId = $currentId;
        } else {
            $this->accountId = $accountId;
        }

        if ($this->accountId == $currentId) {
            $this->accountType = OA_Permission::getAccountType();
        } else {
            $doAccounts = OA_Dal::factoryDO('accounts');
            $doAccounts->account_id = $this->accountId;
            $doAccounts->find();

            if ($doAccounts->fetch()) {
                $this->accountType = $doAccounts->account_type;
            } else {
                Max::raiseError('Unexisting account ID', null, PEAR_ERROR_DIE);
            }
        }

        if ($this->accountType == OA_ACCOUNT_ADMIN) {
            $this->accountId = 0;
        }
    }

    /**
     * A method to connect the OAP platform and the account Id to OAC
     *
     * Note: The mapper method is always called using admin ID and type, just in case it needs
     *       M2M authorithation itself
     *
     * @return mixed The M2M password if OAP and it's account is correctly connected to OAC,
     *               PEAR_Error otherwise
     */
    function connectM2M()
    {
        // Perform backup
        $accountId   = $this->accountId;
        $accountType = $this->accountType;

        // Force Admin user
        $this->accountId   = 0;
        $this->accountType = OA_ACCOUNT_ADMIN;

        // Actual call
        $result = $this->oMapper->connectM2M($accountId, $accountType);

        // Restore
        $this->accountId   = $accountId;
        $this->accountType = $accountType;

        if (PEAR::isError($result)) {
            return $result;
        }

        // Store M2M password
        OA_Dal_Central_M2M::setM2MPassword($this->accountId, $result);
        if (isset($GLOBALS['OX_CLEAR_M2M_PASSWORD'][$this->accountId])) {
            unset($GLOBALS['OX_CLEAR_M2M_PASSWORD'][$this->accountId]);
        }

        return $result;
    }

    /**
     * A method to get an M2M Ticket for the dashboard
     *
     * @return string
     */
    function getM2MTicket()
    {
        $result = $this->oMapper->getM2MTicket();

        if (PEAR::isError($result)) {
            return $result;
        }

        // Store M2M ticket
        OA_Dal_Central_M2M::setM2MTicket($this->accountId, $result);

        return $result;
    }

}

?>
