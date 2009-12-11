<?php

/**
 * Predicate that always evaluate to TRUE
 */
class OX_Common_Predicate_True 
    implements OX_Common_Predicate
{
    function evaluate()
    {
        return true;
    }
}
