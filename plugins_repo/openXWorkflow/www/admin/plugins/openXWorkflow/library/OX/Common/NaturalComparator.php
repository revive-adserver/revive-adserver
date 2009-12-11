<?php

class OX_Common_NaturalComparator
    implements OX_Common_Comparator 
{
    public function compare($o1, $o2)
    {
        if ($o1 < $o2) {
            return -1; 
        }
        if ($o1 > $o2) {
            return 1;
        }
        return 0;
    }
    
    /**
     * @var OX_Common_NaturalComparator
     */
    public static $INSTANCE;
}

OX_Common_NaturalComparator::$INSTANCE = new OX_Common_NaturalComparator(); 

?>
