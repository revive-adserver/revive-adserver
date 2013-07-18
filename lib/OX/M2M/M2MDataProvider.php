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

/**
 * Dal methods for storing and retrieving M2M data.
 *
 */
interface OX_M2M_M2MDataProvider
{
    /**
     * A method to retrieve the M2M password for an account
     *
     * @param int $accountId
     * @return mixed The password, or false if there is no password stored
     */
    function getM2MPassword($accountId);

    /**
     * A method to store the M2M password for an account
     *
     * @param int $accountId
     * @param string $m2mPassword
     * @return bool
     */
    function setM2MPassword($accountId, $m2mPassword);

    /**
     * A method to retrieve the M2M ticket for an account
     *
     * @param int $accountId
     * @return mixed The ticket, or false if there is no ticket stored
     */
    function getM2MTicket($accountId);
    
	/**
     * A method to store the M2M ticket for an account
     *
     * @param int $accountId
     * @param string $m2mTicket
     * @return bool
     */
    function setM2MTicket($accountId, $m2mTicket);
    
    function getPlatformHash();
	
	function getAdminAccountId();
	function getAdminAccountType();
}

?>
