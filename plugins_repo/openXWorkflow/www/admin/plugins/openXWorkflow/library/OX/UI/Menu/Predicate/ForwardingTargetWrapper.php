<?php

class OX_UI_Menu_Predicate_ForwardingTargetWrapper 
    implements OX_Common_Predicate, OX_UI_Controller_ForwardingTarget
{
    private $predicate;
    private $forwardingTarget;


    function __construct(OX_Common_Predicate $predicate, 
        OX_UI_Controller_ForwardingTarget $forwardingTarget)
    {
        $this->predicate = $predicate;
        $this->forwardingTarget = $forwardingTarget;
    }


    public function evaluate()
    {
        return $this->predicate->evaluate();
    }


    public function getForwardingTarget()
    {
        return $this->forwardingTarget->getForwardingTarget();
    }
    
    
    public function canForward()
    {
        return $this->forwardingTarget->canForward();
    }
}
