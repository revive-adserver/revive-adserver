<?php

/**
 * A controller plugin that handles logging in through SSO.
 */
class OX_UI_Controller_Plugin_LoginPlugin extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var OX_Cas_AbstractCasManager
     */
    private $casManager;
    
    /**
     * @var OX_UI_Controller_Plugin_LoginPluginDao
     */
    private $dao;
    
    /**
     * @var OX_UI_Controller_Plugin_LoginListener
     */
    private $loginListener;
    
    /**
     * An instance of User that is currently logged in or null. Note that we keep track
     * of both the user and account to implement a Super Admin user working on behalf
     * of some account. 
     * 
     * In other words, it may happen that:
     * 
     * * $user is not null and $account is not null and is the $user's account
     * * $user is not null and is a super admin and $account is null
     * * $user is not null and is a super admin and $account is not null and is any account 
     */
    private $user;
    
    /**
     * An instance of Account on behalf of which the application is acting. May not
     * correspond to the $user, see above for more details.
     */
    private $account;


    public function __construct(OX_Cas_AbstractCasManager $casManager, 
            OX_UI_Controller_Plugin_LoginPluginDao $dao, 
            OX_UI_Controller_Plugin_LoginListener $loginListener)
    {
        $this->casManager = $casManager;
        $this->dao = $dao;
        $this->loginListener = $loginListener;
    }


    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $userId = self::getSessionUserId();
        if (!$userId) {
            if (!OX_Common_Config::isProductionMode() && $this->getFakeLoginUserId()) {
                // For the ease of testing and development we can use a hardcoded id
                $userId = self::getFakeLoginUserId();
                self::setLoggedUserId($userId);
                if (!empty($this->user)) {
                    self::setLoggedAccount($this->user->getAccount());
                }
            }
            else {
                if ($this->loginListener->shouldAuthenticate($request)) {
                    // Proper SSO login procedure
                    $authenticated = $this->casManager->authenticate();
                    if ($authenticated) {
                        $user = $this->dao->getUserBySsoId($this->casManager->getSsoUserId());
                        
                        if ($this->loginListener->afterAuthenticated($this->_request, $this->_response, $user)) {
                            // Allowed to log-in, set user id in session
                            self::setLoggedUserId($user->getId());
                            
                            // By default we set this user's account id in session.
                            // Later on, this account may be changed to something else
                            // if the user has the right to do so.
                            self::setLoggedAccount($user->getAccount());
                        }
                        else {
                            // Not allowed to log-in, destroy the whole session
                            Zend_Session::destroy(true, OX_Common_Config::isProductionMode());
                        }
                        
                        // Redirect to the same url, but without the SSO ticket parameter
                        if (!$this->_response->isRedirect()) {
                            $this->loginListener->beforeAuthenticatedRedirect($request, $user);
                            OX_UI_Controller_Default::redirectRemovingParams($request, 
                                $this->_response, array('ticket'));
                        }
                        OX_UI_Controller_Default::fixRedirect($this->_request);
                        return;
                    }
                    else {
                        $this->_response->setRedirect($this->casManager->getServerLoginUrl());
                        OX_UI_Controller_Default::fixRedirect($this->_request);
                    }
                    return;
                }
            }
        }
        else {
            $this->setUserId($userId);
            $this->setAccountId(self::getSessionAccountId());
            $this->loginListener->afterAuthenticationRetrieved($request, $this->_response);
        }
    }


    public static function logout(Zend_Controller_Response_Http $response, 
            $redirectUrl = null)
    {
        if (OX_Common_Config::isProductionMode()) {
            $instance = self::getInstance();
            if (isset($instance)) {
                $instance->casManager->logout($redirectUrl);
            }
        }
        Zend_Session::destroy(true, OX_Common_Config::isProductionMode());
    }


    /**
     * @return OX_UI_Controller_Plugin_LoginPlugin
     */
    public static function getInstance()
    {
        return Zend_Controller_Front::getInstance()->getPlugin('OX_UI_Controller_Plugin_LoginPlugin');
    }


    public static function getLoggedUser()
    {
        $instance = self::getInstance();
        return $instance ? $instance->user : null;
    }


    public static function getLoggedAccount()
    {
        $instance = self::getInstance();
        return $instance ? $instance->account : null;
    }


    public static function setLoggedAccount($account)
    {
        $store = new Zend_Session_Namespace("login");
        if (!empty($account)) {
            $store->loggedAccountId = $account->getId();
            self::getInstance()->setAccount($account);
        }
        else {
            unset($store->loggedAccountId);
            self::getInstance()->setAccount(null);
        }
    }

    public static function setLoggedUserId($loggedUserId)
    {
        $store = new Zend_Session_Namespace("login");
        $store->loggedUserId = $loggedUserId;
        self::getInstance()->setUserId($loggedUserId);
    }

    
    private static function getSessionUserId()
    {
        $store = new Zend_Session_Namespace("login");
        if (isset($store->loggedUserId)) {
            return $store->loggedUserId;
        }
        else {
            return null;
        }
    }

    
    private static function getSessionAccountId()
    {
        $store = new Zend_Session_Namespace("login");
        if (isset($store->loggedAccountId)) {
            return $store->loggedAccountId;
        }
        else {
            return null;
        }
    }


    private function setUserId($userId)
    {
        $this->user = $this->dao->getUserById($userId);
    }

    
    private function setAccountId($accountId)
    {
        $this->setAccount($this->dao->getAccountById($accountId));
    }
    
    
    private function setAccount($account)
    {
        OX_Doctrine_auth_AuthorizationUtils::setAuthorizationEnabled(false);
        if (!empty($account)) {
            OX_Doctrine_auth_AuthorizationUtils::setLoggedAccount($account);
        }
        else {
            OX_Doctrine_auth_AuthorizationUtils::setLoggedAccount(null);
        }
        OX_Doctrine_auth_AuthorizationUtils::setAuthorizationEnabled(true);
        $this->account = $account;
    }


    /**
     * This method should be private, but to handle requests for menu structure, we
     * need to have an ability to temporarily 'log-in' a user based on the request
     * parameter. This method would set the user id for us, but only for the scope
     * of the current request.
     */
    public function setTemporaryUserIdAndAccount($userId)
    {
        if ($userId) {
            $this->setUserId($userId);
            if ($this->user && $this->user->getAccount()) {
                $this->setAccount($this->user->getAccount());
            }
        }
        else {
            $this->setAccount(null);
        }
    }
    

    private function getFakeLoginUserId()
    {
        return OX_Common_Config::instance('application')->get('webtestUserId');
    }
}