<?php

/**
 * Represents a generic predicate that can evaluate to true or false values.
 */
interface OX_Common_Predicate
{
    /**
     * Evaluates this predicate and returns true or false.
     */
    function evaluate();
}
