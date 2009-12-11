<?php

/**
 * A common implementation of a controller for switching accounts as a super admin. For
 * the templates for this component, please see 
 */
abstract class OX_UI_Controller_Admin_AccountSwitch extends OX_UI_Controller_ContentPage
{
    const SUPER_ADMIN_ACCOUNT_NAME = 'Super Admin Account';


    public function indexAction()
    {
        $this->_forward("work-as");
    }


    public function switchToAction()
    {
        $account = $this->performSwitch();
        $this->_forward("work-as");
        $accountName = !empty($account) ? $account->getName() : self::SUPER_ADMIN_ACCOUNT_NAME;
        $this->setPageLocalMessage(array (
                'text' => 'Since now working as <b>' . $accountName . '</b>', 
                'type' => 'confirm'));
    }


    /**
     * Used only for web tests. Note that here, we also need to set userId to some user
     * of the account we've just switched to. Otherwise, we'd get unauthorized access 
     * exceptions -- the new account doesn't have the right to read the user of the 
     * previously active account. This is not required on the regular switcher (with UI)
     * because it's only available to super admin users and these users have right
     * to read any other user and account.
     */
    public function switchToInternalAction()
    {
        $account = $this->performSwitch();
        if ($account && count($account->getUsers()) > 0) {
            $userId = OX_Common_ArrayUtils::first($account->getUsers())->getId();
            OX_UI_Controller_Plugin_LoginPlugin::setLoggedUserId($userId);
        }
        else {
            $userId = $this->getRequest()->getParam('userId');
            if (!empty($userId)) {
                OX_UI_Controller_Plugin_LoginPlugin::setLoggedUserId($userId);
            }
        }
        
        $this->noViewScript('Switched to accountId = ' . 
            ($account ? $account->getId() : 'null') . (isset($userId) ? ', userId = ' . $userId : ''), 
            true);
    }


    private function performSwitch()
    {
        // Clear stored entity ids
        Zend_Session::namespaceUnset("navigation");
        
        $accountId = $this->_request->getParam("accountId");
        
        OX_Doctrine_auth_AuthorizationUtils::setAuthorizationEnabled(false);
        $account = $this->getAccount($accountId);
        OX_UI_Controller_Plugin_LoginPlugin::setLoggedAccount($account);
        OX_Doctrine_auth_AuthorizationUtils::setAuthorizationEnabled(true);
        
        return $account;
    }


    public function workAsAction()
    {
        $this->addHeader("Switch Account", "Advertiser");
        
        // Disable authorization for a moment
        OX_Doctrine_auth_AuthorizationUtils::setAuthorizationEnabled(false);
        $accounts = $this->getAccounts();
        OX_Doctrine_auth_AuthorizationUtils::setAuthorizationEnabled(true);
        
        $superAdmin = new DummyAccount(null, self::SUPER_ADMIN_ACCOUNT_NAME);
        $accountsArray = array ($superAdmin);
        foreach ($accounts as $account) {
            $accountsArray[] = $account;
        }
        
        $this->view->accounts = $accountsArray;
        
        $account = $this->loggedAccount;
        if (isset($account)) {
            $this->view->loggedAccountId = $this->loggedAccount->getId();
        }
        
        $this->setViewScript('admin/work-as.html');
    }
    
    protected abstract function getAccounts();
    
    protected abstract function getAccount($accountId);
}

class DummyAccount
{
    private $id;
    private $name;
    
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

	public function getId()
    {
        return $this->id;
    }
}