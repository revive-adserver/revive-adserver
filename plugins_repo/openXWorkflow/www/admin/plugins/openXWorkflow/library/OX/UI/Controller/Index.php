<?php

/**
 * Common functionality for the Index controller in the default module. It implements
 * two actions required to handle SSO-based login/logout. No controllers other than the
 * index controller in the default module should extend this base controller.
 */
class OX_UI_Controller_Index extends OX_UI_Controller_Default
{
    public function logoutAction()
    {
        $this->_helper->layout->disableLayout();
        $this->view->noViewScript();
        
        OX_UI_Controller_Plugin_LoginPlugin::logout($this->_response, 
            $this->getRequest()->getParam('redirectUrl'));
    }
}
