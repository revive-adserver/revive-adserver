<?php

class OX_OXP_UI_Controller_Plugin_OxpSessionConfigure
    extends Zend_Controller_Plugin_Abstract
{
    private $OXP_SESSION_ID = 'sessionID';
    private $customSessionId;
    
    function __construct($customSessionId = null, $resetWithOXP = true)
    {
        $this->customSessionId = $customSessionId;
        $this->resetWithOxp = $resetWithOxp;
    }

    
    
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $sessionId = !empty($this->customSessionId) ? $this->customSessionId : $this->OXP_SESSION_ID;
        
        //if custom session id is used, and OXP session has been destroyed, remove custom cookie 
        if (!empty($this->customSessionId) && $this->resetWithOxp && !isset($_COOKIE[$this->OXP_SESSION_ID])) {
            unset($_COOKIE[$this->customSessionId]);
        }
        
        Zend_Session::setOptions(array('name' => $sessionId));
    }
}

