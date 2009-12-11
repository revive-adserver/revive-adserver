<?php

class OX_Common_ToMethodTransfromer
    implements OX_Common_Transformer 
{
    private $methodName;
    
    function __construct($methodName)
    {
        $this->methodName = $methodName;
    }
    
    
    function transform($o1)
    {
        return $o1 != null ? call_user_func(array($o1, $this->methodName)) : null;
    }
}

?>
