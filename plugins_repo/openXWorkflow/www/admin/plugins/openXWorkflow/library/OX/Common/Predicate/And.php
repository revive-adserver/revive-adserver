<?php

class OX_Common_Predicate_And implements OX_Common_Predicate
{
    private $predicates;
    
    public function __construct(array $predicates)
    {
        $this->predicates = $predicates;
    }
    
    function evaluate()
    {
        foreach ($this->predicates as $predicate) {
            if (!$predicate->evaluate()) {
                return false;
            }
        }
        return true;
    }
}
