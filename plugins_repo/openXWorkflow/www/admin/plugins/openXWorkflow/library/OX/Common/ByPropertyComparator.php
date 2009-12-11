<?php

class OX_Common_ByPropertyComparator
{
    private $property;
    
    
    function __construct($property)
    {
        $this->property = $property;
    }
    
    
    public function compare($o1, $o2)
    {
//        echo "Comparing ";
//        var_dump($o1);
//        echo " with ";
//        var_dump($o2);
//        echo "using property " . $this->property . "<BR>";
        $v1 = $o1[$this->property];
        $v2 = $o2[$this->property];
        if ($v1 < $v2) {
            return -1; 
        }
        if ($v1 == $v2) {
            return 0;
        }
        return 1;
    }
}
