<?php

/**
 * A default implementation of OX_UI_Controller_Plugin_LoginListener. It excludes
 * the common logout action from authenticated actions, and also forwards the request
 * to a common page when the service is not activated for the logged in user.
 */
class OX_UI_Controller_Plugin_DefaultLoginListener implements OX_UI_Controller_Plugin_LoginListener
{
    private static $NO_ACCOUNT_ACTION = array ('action' => 'service-not-activated', 
            'controller' => 'error', 
            'module' => 'default');
    private $aExcludedActions;


    public function __construct(array $customExcludedActions = array())
    {
        $this->aExcludedActions = array_merge(array (
                self::$NO_ACCOUNT_ACTION, 
                array (
                        'action' => 'access-denied', 
                        'controller' => 'error', 
                        'module' => 'default'), 
                array (
                        'action' => 'accept-account', 
                        'controller' => 'sso', 
                        'module' => 'default'), 
                array (
                        'action' => 'confirm-account', 
                        'controller' => 'sso', 
                        'module' => 'default'), 
                array (
                        'action' => 'logout', 
                        'controller' => 'index', 
                        'module' => 'default')), $customExcludedActions);
    }


    function afterAuthenticated(Zend_Controller_Request_Abstract $request, 
            Zend_Controller_Response_Abstract $response, 
            $authenticatedUser)
    {
        if ($authenticatedUser) {
            $account = $authenticatedUser->getAccount();
            return !empty($account) || 
                (method_exists($authenticatedUser, 'isSuperAdmin') &&
                    $authenticatedUser->isSuperAdmin());
        }
        else {
            // Credentials correct, but no corresponding user or account found.
            // Redirect to an information page, and do not log in.
            $request->setActionName(self::$NO_ACCOUNT_ACTION['action']);
            $request->setControllerName(self::$NO_ACCOUNT_ACTION['controller']);
            $request->setModuleName(self::$NO_ACCOUNT_ACTION['module']);
            
            $userId = '';
            if ($authenticatedUser && method_exists($authenticatedUser, 'getId')) 
            {
                $userId = $authenticatedUser->getId();
            }
            OX_Common_Log::info('No account found for userId: ' . $userId);
                        
            return false;
        }
    }


    public function shouldAuthenticate(Zend_Controller_Request_Abstract $request)
    {
        // Check the default list, if excluded, do not authenticate
        if (OX_UI_Controller_Request_RequestUtils::matches($request, $this->aExcludedActions)) {
            return false;
        }
        
        // Check information from menuing system
        $section = OX_UI_Menu::getFromRegistry()->getSectionForRequest($request);
        if ($section) {
            return $section->isLoginRequired();
        }
        
        return true;
    }


    function beforeAuthenticatedRedirect(Zend_Controller_Request_Abstract $request, 
            $authenticatedUser)
    {
    }


    function afterAuthenticationRetrieved(Zend_Controller_Request_Abstract $request, 
            Zend_Controller_Response_Abstract $response)
    {
    }
}