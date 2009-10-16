<?php

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