<?php

/**
 * A plugin that can be registered with the OX_UI_Controller_Default.
 * Order of the methods:
 * - postInit - called once at controller creation
 * - preDispatch - called when Controller preDispatch method is called
 * - beforeRender - called just before rendering occurs from controller's postDispatch method
 */
abstract class OX_UI_Controller_Plugin
{
    public function postInit(OX_UI_Controller_Default $controller)
    {
    }
    
    public function preDispatch(OX_UI_Controller_Default $controller)
    {
    }
    
    public function beforeRender(OX_UI_Controller_Default $controller)
    {
    }
}
