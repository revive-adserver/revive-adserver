<?php

/**
 * A number of factory methods for operating on predicates.
 */
final class OX_Common_Predicates
{
    public static function andOf()
    {
        $predicates = func_get_args();
        return new OX_Common_Predicate_And($predicates);
    }
    
    public static function notOf(OX_Common_Predicate $predicate)
    {
        return new OX_Common_Predicate_Not($predicate);
    }
}
