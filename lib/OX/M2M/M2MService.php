<?php

interface OX_M2M_M2MService
{
    function getM2MTicket($accountId, $accountType);
    
    
    function reconnectM2M($accountId, $accountType);
    
    
    function connectM2M($accountId, $accountType);
}

?>
