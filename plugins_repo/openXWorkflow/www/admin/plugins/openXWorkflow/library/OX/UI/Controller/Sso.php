<?php

abstract class OX_UI_Controller_Sso extends OX_UI_Controller_ContentPage
{
    const EMAIL_PARAM = 'email';
    const VERIFICATION_HASH_PARAM = 'vh';
    
    public function acceptAccountAction()
    {
        $oSsoManager = $this->getSsoManager();
        $oForm = new OX_UI_Form_Sso_Account($this->getRequest());
        $this->view->form = $oForm;
        $this->addHeader('Complete your ' . OX_Common_Config::instance('application')->get('name') . ' registration');
        $this->setHideEmptyThirdLevelTools();
        
        // Make sure we have e-mail and verification hash
        $email = $this->getRequest()->getParam(self::EMAIL_PARAM);
        $verificationHash = $this->getRequest()->getParam(self::VERIFICATION_HASH_PARAM);
        if (empty($email) || empty($verificationHash)) {
            throw new Exception('Invalid account activation link');
        }
        
        if ($this->getRequest()->isPost()) {
            if ($oForm->isValid($_POST)) {
                try {
                    if ($oForm->isUsingExistingAccount()) {
                        $oEventsListener = 
                            new OX_AC_Cas_PartialAccountEventsListener();
                        $oSsoManager->associateWithExistingSsoAccount(
                            $oForm->getExistingUsername(),
                            $oForm->getExistingPassword(),
                            $email,
                            $verificationHash,
                            $oEventsListener);
                    } 
                    else {
                        $oSsoManager->finishPartialSsoAccountCreation(
                                $oForm->getNewUsername(),
                                $oForm->getNewUserPassword(),
                                $email,
                                $verificationHash);
                    }
                    $this->redirect('confirm-account');
                } 
                catch (OX_Cas_CasException $ex) {
                    $oForm->setFormErrorMessage($ex->getMessage());
                }
            }
        }
        else {
            $oSsoManager->checkEmail($verificationHash, $email);
        }
    }
    
    public function confirmAccountAction()
    {
        $this->addHeader(OX_Common_Config::instance('application')->get('name') . ' registration complete');
        $this->setHideEmptyThirdLevelTools();
    }

    public function getSsoManager()
    {
        $sso_url .= OX_UI_View_Helper_ActionUrl::actionUrl($this->getAcceptAccountActionName(), 
            $this->getAcceptAccountControllerName(),
            $this->getAcceptAccountModuleName(), array(), true);
        
        $oConfigXmlRpc = OX_Common_Config::instance('xmlrpc');
        $oConfigSso = OX_Common_Config::instance('sso');
        return new OX_Cas_WebService_SsoManager(
            $oConfigXmlRpc->get('protocol'),
            $oConfigXmlRpc->get('host'),
            $oConfigXmlRpc->get('port'),
            $oConfigXmlRpc->get('path'),
            $oConfigSso->get('emailFrom'),
            $sso_url,
            $this->getEmailViewScriptPath());
    }  
    
    protected function getAcceptAccountActionName()
    {
        return 'accept-account';
    }
    
    protected function getAcceptAccountControllerName()
    {
        return 'sso';
    }
    
    protected function getAcceptAccountModuleName()
    {
        return 'default';
    }
    
    protected function getEmailViewScriptPath()
    {
        return LIB_PATH . '/OX/UI/View/scripts/sso/create-account-email.html';
    }
}
