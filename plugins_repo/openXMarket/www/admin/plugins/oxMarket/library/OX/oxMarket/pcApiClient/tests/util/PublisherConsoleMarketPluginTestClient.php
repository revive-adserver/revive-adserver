<?php

/**
 * Class that add setPublisherConsoleClient functionality
 * to allow mockup PublisherConsoleClient
 *
 */
class PublisherConsoleMarketPluginTestClient 
    extends Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient 
{
    function setPublisherConsoleClient($oPubConsoleClient) 
    {
        $this->pc_api_client = &$oPubConsoleClient;
    }
    
    // Make getDictionaryData public for tests
    public function getDictionaryData($dictionaryName, $apiMethod)
    {
        return parent::getDictionaryData($dictionaryName, $apiMethod);
    }
}