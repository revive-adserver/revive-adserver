<?php

class ErrorController extends OX_UI_Controller_Error
{
    protected function getUrlBaseRelativeCssLinks()
    {
        return array ('/assets/pc/css/custom.css');
    }


    public function errorAction()    
    {
        parent::errorAction();
        
        $error = $this->_getParam('error_handler');
        if (get_class($error->exception) == 'OX_PC_Common_Exception_MarketWebsiteNotFoundException') {
            $this->_forward('website-not-found');
        }
    }
    
    
    public function accountMismatchAction()
    {
        $expectedUserThoriumAccountId = $this->getRequest()->getParam('pa');
        $this->prepareErrorLayout();
        $this->view->pageTitle = 'Account mismatch';
        $this->view->redirectUrl = urlencode(OX_UI_View_Helper_ActionUrl::actionUrl('index', 'index', 'default', array (
                'pa' => $expectedUserThoriumAccountId), true));
    }


    public function loginCookieMissingAction()
    {
        $pa = $this->getRequest()->getParam('pa');
        
        $this->prepareErrorLayout();
        $this->view->pageTitle = 'Failed to log in';
        $this->view->returnUrl = $this->getRequest()->getParam(OX_PC_UI_Controller_Plugin_OxpThoriumPluginLoginListener::RETURN_URL_PARAMETER_NAME);
        
        $this->view->pa = $pa;
        $this->view->redirectUrl = urlencode(OX_UI_View_Helper_ActionUrl::actionUrl('index', 'index', 'default', array (
                'pa' => $pa), true));
    }
    
    
    public function websiteNotFoundAction()
    {
        $this->view->pageTitle = 'Website not found';
    }
}
