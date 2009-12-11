<?php

/**
 * Generates the log out for the application.
 */
class OX_UI_View_Helper_LogoutUrl
{
    public function logoutUrl()
    {
        return OX_UI_View_Helper_ActionUrl::actionUrl('logout', 'index', 'default');
    }
}
