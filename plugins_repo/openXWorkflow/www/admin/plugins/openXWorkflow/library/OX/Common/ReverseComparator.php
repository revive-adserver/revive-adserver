<?php

class OX_Common_ReverseComparator
    implements OX_Common_Comparator 
{
	private $comparator;
	
	public function __construct($comparator)
	{
		$this->comparator = $comparator;
	}
	
	
    public function compare($o1, $o2)
    {
        return -$this->comparator->compare($o1, $o2);
    }
    
    public static $INSTANCE;
}

OX_Common_ReverseComparator::$INSTANCE = 
	new OX_Common_ReverseComparator(OX_Common_NaturalComparator::$INSTANCE); 

?>
