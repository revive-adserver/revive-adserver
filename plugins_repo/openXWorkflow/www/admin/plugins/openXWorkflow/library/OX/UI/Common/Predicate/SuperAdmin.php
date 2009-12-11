<?php

/**
 * Evaluates to true if the currently logged in user is a super admin.
 */
class OX_UI_Common_Predicate_SuperAdmin implements OX_Common_Predicate
{
    function evaluate()
    {
        $user = OX_UI_Controller_Plugin_LoginPlugin::getLoggedUser();
        return !empty($user) && method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin();
    }
}