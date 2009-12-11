<?php

class OX_UI_Controller_Error extends Zend_Controller_Action
{


    public function errorAction()
    {
        $this->prepareErrorLayout();
        $errors = $this->_getParam('error_handler');
        
        if (OX_Common_Config::isProductionMode() 
            && (Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION == $errors->type
                || Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER == $errors->type)) {
            $this->_forward('error404'); //404 error        
        }
        //other 500 - error

        $this->view->pageTitle = 'Error has occurred';
        $this->getResponse()->setHttpResponseCode(500);
        $this->view->exception = $errors->exception;
        
        OX_Common_Log::error($errors->exception);
    }
    
    
    public function error404Action()
    {
        $this->prepareErrorLayout();
        $this->view->pageTitle = 'Page not found';
        $this->getResponse()->setHttpResponseCode(404);
    }    


    public function serviceNotActivatedAction()
    {
        $this->prepareErrorLayout();
        $this->view->pageTitle = 'Service not activated';
        $this->view->redirectUrl = urlencode(OX_UI_View_Helper_ActionUrl::actionUrl(
            'index', 'index', 'default', array(), true));
    }


    public function accessDeniedAction()
    {
        $this->prepareErrorLayout();
        $this->view->pageTitle = 'Access denied';
    }


    protected function prepareErrorLayout()
    {
        $this->_helper->layout->setLayout('layout-basic');
        $cssLinks = $this->getUrlBaseRelativeCssLinks();
        foreach ($cssLinks as $cssLink) {
            $this->view->headLink()->prependStylesheet($this->view->urlBase() . $cssLink);
        }
        
        $this->getResponse()->clearBody();
        $this->view->supportEmail = OX_Common_Config::instance('ui')->get('supportEmail');
    }


    /**
     * Returns an array of urlBase-relative CSS stylesheets to include on the error
     * pages, starting with a '/'. The default implementation returns an empty array.
     *
     * @return unknown
     */
    protected function getUrlBaseRelativeCssLinks()
    {
        return array ();
    }
}
