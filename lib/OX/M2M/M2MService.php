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

interface OX_M2M_M2MService
{
    function getM2MTicket($accountId, $accountType);
    
    
    function reconnectM2M($accountId, $accountType);
    
    
    function connectM2M($accountId, $accountType);
}

?>
