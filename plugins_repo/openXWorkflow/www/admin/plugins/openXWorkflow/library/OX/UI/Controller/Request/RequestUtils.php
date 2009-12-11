<?php

class OX_UI_Controller_Request_RequestUtils
{   
    /**
     * Retrieves only user specified parameter ommiting action, module, controller names.
     * It will also use GET/POST parameters (consistent with request getParams() of Zend_Controller_Request_Http )
     *
     * @return array
     */
    public static function getNonFrameworkParams(Zend_Controller_Request_Abstract $oRequest)
    {
        $aEnvParams = array(
            $oRequest->getModuleKey() => '', 
            $oRequest->getControllerKey() => '',
            $oRequest->getActionKey() => '');
            
        return array_diff_key($oRequest->getParams(), $aEnvParams);
    }
    
    
    /**
     * Checks if current request module/controller is in the given
     * actions array. If $matchAction is set, exact module/controller/action
     * triplet must be present in $aActions array.
     * 
     * Please note that if eg. cureent request will be:
     * publisher/account/list
     * 
     * and action matching is disabled, the function will return true only if
     * it finds 'publisher/account' entry. It will not match to eg.
     * 'publisher/account/edit' entry.
     *  
     *
     * @param Zend_Controller_Request_Abstract $oRequest
     * @param boolean true if given request module/controller is in the $aActions array, if $matchAction is set
     * action is also checked
     */
    public static function matches(Zend_Controller_Request_Abstract $oRequest, $aActions, $matchAction = false)
    {
        $module = $oRequest->getModuleName();
        $controller = $oRequest->getControllerName();
        $action = $oRequest->getActionName();
        $allowPartial = !$matchAction;
        
        foreach ($aActions as $aAction) {
            if ($aAction['module'] == $module && $aAction['controller'] == $controller 
                && ($allowPartial && !isset($aAction['action']) 
                	||  isset($aAction['action']) && $aAction['action'] == $action)) {
                return true;
            }
        }
        
        return false;
    }
}

?>