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

require_once MAX_PATH . '/lib/OX/Dal/Market/RegistrationClient.php';

/**
 * Class that allow test RegistrationClient 
 * by adding get/set pcApiClient methods
 */
class RegistrationTestClient extends OX_Dal_Market_RegistrationClient 
{
    public function getPcApiClient()
    {
        return $this->pcApiClient;        
    }
    
    public function setPcApiClient(OX_PC_API_SimpleClient $pcApiClient)
    {
        $this->pcApiClient = $pcApiClient;
    }
}