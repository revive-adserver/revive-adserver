<?php

class OX_Common_ComparatorUtils
{
    public static function byPropertyComparator($prop, $comparator)
    {
        return new OX_Common_TransformedComparator(new OX_Common_ToPropertyTransfromer($prop), $comparator);
    }
    
    
    public static function asComparator($comparator)
    {
        if (!$comparator) {
            return OX_Common_NaturalComparator::$INSTANCE;
        }
        if ($comparator instanceof OX_Common_Comparator) {
            return $comparator;
        }
        return new OX_Common_ClosureComparator($comparator);
    }
}
