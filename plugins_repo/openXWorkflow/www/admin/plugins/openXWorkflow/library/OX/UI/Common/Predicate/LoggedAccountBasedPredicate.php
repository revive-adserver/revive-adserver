<?php

/**
 * A base class for predicates based on the currently logged account. There is no specific
 * interface assumed for the object representing the underlying account.
 */
abstract class OX_UI_Common_Predicate_LoggedAccountBasedPredicate implements OX_Common_Predicate 
{
    function evaluate()
    {
        $account = OX_UI_Controller_Plugin_LoginPlugin::getLoggedAccount();
        return isset($account) && $this->evaluateForAccount($account);
    }
    
    /**
     * Evaluates the predicate for a specific account. Called only when the logged 
     * account is not null.
     *
     * @param $account
     * @return predicate value
     */
    abstract function evaluateForAccount($account);
}