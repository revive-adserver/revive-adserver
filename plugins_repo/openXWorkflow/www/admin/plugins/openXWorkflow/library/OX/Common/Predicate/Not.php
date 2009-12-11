<?php

/**
 * Negates the results of the provided predicate.
 */
class OX_Common_Predicate_Not implements OX_Common_Predicate
{
    private $predicate;
    
    public function __construct(OX_Common_Predicate $predicate)
    {
        $this->predicate = $predicate;
    }
    
    function evaluate()
    {
        return !$this->predicate->evaluate();
    }
}
