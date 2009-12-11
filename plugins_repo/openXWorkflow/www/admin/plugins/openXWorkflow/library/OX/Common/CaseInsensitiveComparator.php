<?php

class OX_Common_CaseInsensitiveComparator
    implements OX_Common_Comparator 
{
    public function compare($o1, $o2)
    {
        return strcasecmp($o1, $o2);
    }
    
    public static $INSTANCE;
}

OX_Common_CaseInsensitiveComparator::$INSTANCE = new OX_Common_CaseInsensitiveComparator(); 

?>
