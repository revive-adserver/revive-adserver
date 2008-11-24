<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
