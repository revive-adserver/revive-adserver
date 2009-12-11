<?php

class OX_Common_TransformedComparator
{
    private $transformer;
    private $comparator;
    
    
    function __construct($transformer, $comparator)
    {
        $this->transformer = $transformer;
        $this->comparator = OX_Common_ComparatorUtils::asComparator($comparator);
    }
    
    
    public function compare($o1, $o2)
    {
        $t1 = $this->transformer->transform($o1);
        $t2 = $this->transformer->transform($o2);
        return $this->comparator->compare($t1, $t2);
    }
}
