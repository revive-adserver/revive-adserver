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

interface OX_M2M_M2MTicketProvider
{
	/**
	 * @param boolean $force true means that ticket should be regenerated, false means 
	 * that old ticket can be used if present
	 */
	function getTicket($force);
}

?>
