<?php

/**
 * A controller plugin that builds the menu structure and registers it in Zend_Registry.
 */
abstract class OX_UI_Controller_Plugin_AbstractMenuBuilder extends Zend_Controller_Plugin_Abstract
{
    public final function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        OX_UI_Menu::setInRegistry($this->buildMenu());
    }
    
    /**
     * Builds the menu structure for the application.
     *
     * @return OX_UI_Menu
     */
    public abstract function buildMenu();
}