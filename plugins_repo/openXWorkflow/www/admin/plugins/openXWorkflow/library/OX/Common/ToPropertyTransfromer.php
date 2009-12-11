<?php

class OX_Common_ToPropertyTransfromer
    implements OX_Common_Transformer 
{
    private $property;
    
    function __construct($property)
    {
        $this->property = $property;
    }
    
    
    function transform($o1)
    {
        return $o1[$this->property];
    }
}

?>
