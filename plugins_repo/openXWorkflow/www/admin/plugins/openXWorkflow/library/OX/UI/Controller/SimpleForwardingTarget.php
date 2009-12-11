<?php

/**
 * 
 */
class OX_UI_Controller_SimpleForwardingTarget implements OX_UI_Controller_ForwardingTarget
{
    private $forward;
    private $canForward;
    
    public function __construct($action, $controller = null, $module = null, $params = array(),
        OX_Common_Predicate $canForward = null)
    {
        $this->forward = array('action' => $action);
        OX_Common_ArrayUtils::addIfNotNull($this->forward, 'controller', $controller);
        OX_Common_ArrayUtils::addIfNotNull($this->forward, 'module', $module);
        OX_Common_ArrayUtils::addIfNotNull($this->forward, 'params', $params);
        $this->canForward = $canForward;
    }
    
    
    public function getForwardingTarget()
    {
        return $this->forward;
    }
    
    
    public function canForward()
    {
        return !isset($this->canForward) || $this->canForward->evaluate();
    }
}
