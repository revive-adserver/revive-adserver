<?php

/**
 * 
 */
interface OX_UI_Controller_ForwardingTarget
{
    /**
     * Returns module, controller, action and params to forward to.
     * 
     * @return array ('action' => action, 'controller' => controller, 
     *  'module' => module, 'params' => params). Params are optional
     */
    public function getForwardingTarget();
    
    /**
     * Forward will be preformed only if this method returns true.
     */
    public function canForward();
}
