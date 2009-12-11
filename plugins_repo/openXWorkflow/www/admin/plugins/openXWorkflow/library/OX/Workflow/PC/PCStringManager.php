<?php

class OX_Workflow_PC_PCStringManager
{
    /** an instance of pc string downloader **/
    private static $_instance;

    
    private $aCachedStrings;    

    /**
     * Instance accessor
     *
     * @return OX_Workflow_UI_PC_PCStringManager
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }


    private function __construct()
    {
        $this->cache = new OA_Cache('pcStrings', 'openxWorkflow', 3600);
        $this->cache->setFileNameProtection(false); //want human readable names
    }


    /**
     * Helper method for string translations
     *
     * @param string $pageId a name of the page string comes from 
     * @param string $stringId identifier of the string  for the page
     * @return string a value of the string for a given page, or null i fthe string does not exist
     */
    public function getPCString($pageId, $stringId)
    {
        $aPageStrings = $this->retrieveCustomContent($pageId);
        
        if (empty($aPageStrings) || !isset($aPageStrings[$stringId])) {
            return null;
        }
        
        return $aPageStrings[$stringId];
    }


    protected function retrieveCustomContent($pageName)
    {
        $aStrings = $this->getCachedStrings();
        
        if (isset($aStrings[$pageName])) {
            return $aStrings[$pageName];
        }
        
        $result = false;
        try {
            $oWorkflowComponent = $this->getOxWorkflowComponent();
            //connect to pubconsole API and get the custom content for that page
            $customContentUrl = $this->buildPubconsoleApiUrl($oWorkflowComponent->getConfigValue('marketCustomContentUrl'));
            $oClient = $this->getHttpClient();
            $oClient->setUri($customContentUrl);
            $oClient->setParameterGet(array (
                    'pageName' => urlencode($pageName), 
                    'adminWebUrl' => urlencode(MAX::constructURL(MAX_URL_ADMIN, '')), 
                    'pcWebUrl' => urlencode($oWorkflowComponent->getConfigValue('marketHost')), 
                    'v' => $oWorkflowComponent->getPluginVersion(), 
                    'h' => "0"));
            
            $response = $oClient->request();
            if ($response->isSuccessful()) {
                $responseText = $response->getBody();
                $result = $this->parseCustomContent($responseText);
            }
        }
        catch (Exception $exc) {
            OA::debug('Error during retrieving custom content: (' . $exc->getCode() . ')' . $exc->getMessage());
        }
        
//        if ($result) {
           $aStrings[$pageName] = $result;
           $this->setCachedStrings($aStrings);
//        }        
        
        return $result;
    }

    
    /**
     * Returns an array of caches pc string. pageName is a key, and array of
     * stringId => value is a value for every page.
     * 
     * @return an associative array of strings
     */
    protected function getCachedStrings()
    {
        if ($this->aCachedStrings === null) { //if there's no copy retrieved yet
            $cached = $this->cache->load(); //check if there's cached copy
            if (!empty($cached)) { 
                $this->aCachedStrings = $cached;
            }
            else {
                $this->aCachedStrings = array(); //no cache just set to empty array
            }
        }
        
        
        return $this->aCachedStrings;
    }
    
    
    /**
     * Updates the caches strings to the given value.
     */
    protected function setCachedStrings($aStrings)
    {
        $this->aCachedStrings = $aStrings;
        $this->cache->save($aStrings);
    }
    

    /**
     * Returns an array with key to value for custom content
     *
     * @param string $responseText
     * @return an array key=>value when parsing ok, false otherwise
     */
    protected function parseCustomContent($responseText)
    {
        $xml2a = new OX_Workflow_XMLToArray();
        $aRoot = $xml2a->parse($responseText);
        $aContentStrings = array_shift($aRoot["_ELEMENTS"]);
        
        if ($aContentStrings['_NAME'] != 'contentStrings') {
            return false;
        }
        
        $aKeys = array ();
        foreach ($aContentStrings["_ELEMENTS"] as $aContentString) {
            $aKeys[$aContentString['_NAME']] = $aContentString['_DATA'];
        }
        
        return $aKeys;
    }


    /**
     * Builds an url to pubconsole either SSL or HTTP fallback, apends suffix if given
     *
     * @param string $suffix - with no leading slash
     * @return string pubconsole url with suffix if given
     */
    protected function buildPubconsoleApiUrl($suffix = null)
    {
        $oWorkflowComponent = $this->getOxWorkflowComponent();
        
        if (OX_oxMarket_Common_ConnectionUtils::isSSLAvailable()) {
            $pubconsoleLink = $oWorkflowComponent->getConfigValue('marketPcApiHost');
        }
        else {
            $pubconsoleLink = $oWorkflowComponent->getConfigValue('fallbackPcApiHost');
        }
        if (!empty($suffix)) {
            $pubconsoleLink = $pubconsoleLink . '/' . $suffix;
        }
        
        return $pubconsoleLink;
    }


    /**
     * Creates a client with proper attributes and settinngs (like cUrl handling etc)
     * already configured.
     * By default timeout is 30 secs and 5 redirects are allowed.
     *
     */
    protected function getHttpClient()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $curlAllowAnyCertificate = false;
        if (array_key_exists('curlAllowAnyCertificate', $aConf['openXWorkflow'])) {
            $curlAllowAnyCertificate = $aConf['openXWorkflow']['curlAllowAnyCertificate'];
        }
        $oClient = OX_Workflow_ConnectionUtils::factoryGetZendHttpClient($curlAllowAnyCertificate);
        $oClient->setConfig(array ('maxredirects' => 5, 
                'timeout' => 30));
        
        return $oClient;
    }


    /**
     * Returns openXWorkflow Plugin Component
     *
     * @return Plugins_admin_openXWorkflow_openXWorkflow
     */
    protected function getOxWorkflowComponent()
    {
        if ($this->oxWorkflowComponent == null) {
            $this->oxWorkflowComponent = OX_Component::factory('admin', 'openXWorkflow');
        }
        
        return $this->oxWorkflowComponent;
    }

}

