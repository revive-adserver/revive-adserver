<?php

/**
 * Returns true if the application is not run in production mode.
 */
class OX_UI_Menu_Predicate_DeveloperMode implements OX_Common_Predicate
{
    public function evaluate()
    {
        return !OX_Common_Config::isProductionMode();
    }
}
