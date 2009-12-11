<?php

/**
 * Evaluates to true if there is currently some account to work in. This can be either
 * the logged in user's account or an account a super admin is working as.
 */
class OX_UI_Common_Predicate_AccountAvailable extends OX_UI_Common_Predicate_LoggedAccountBasedPredicate
{
    function evaluateForAccount($account)
    {
        return !empty($account);
    }
}