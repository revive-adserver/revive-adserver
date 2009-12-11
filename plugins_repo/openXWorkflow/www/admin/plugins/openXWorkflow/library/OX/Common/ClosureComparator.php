<?php

class OX_Common_ClosureComparator
    implements OX_Common_Comparator 
{
    private $callback;
    
    function __construct($callback)
    {
        $this->callback = $callback;
    }
    
    public function compare($o1, $o2)
    {
        return call_user_func($this->callback, $o1, $o2);
    }
}

?>
