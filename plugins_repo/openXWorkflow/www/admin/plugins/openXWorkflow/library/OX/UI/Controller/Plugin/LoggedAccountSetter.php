<?php

/**
 * Setts the logged account to the controller's 'loggedAccount' field and to the 
 * 'loggedAccount' view variable.
 */
class OX_UI_Controller_Plugin_LoggedAccountSetter extends OX_UI_Controller_Plugin
{
    public function postInit(OX_UI_Controller_Default $controller)
    {
        $controller->loggedUser = OX_UI_Controller_Plugin_LoginPlugin::getLoggedUser();
        $controller->view->loggedUser = $controller->loggedUser;

        // Please note that the account here may not always belong to the logged-in
        // user. This may happen if the user is a super admin and she performed
        // as switch to work as some arbitrary account.
        $controller->loggedAccount = OX_UI_Controller_Plugin_LoginPlugin::getLoggedAccount();
        $controller->view->loggedAccount = $controller->loggedAccount;
    }
}
