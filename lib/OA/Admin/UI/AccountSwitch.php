<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Helper methods for user switching
 */
class OA_Admin_UI_AccountSwitch
{
    public const MAX_ACCOUNTS_IN_GROUP = 10;
    public const MAX_ACCOUNTS_IN_SEARCH = 20;
    
    public static function assignModel(OA_Admin_Template $template, $query = '')
    {
        $accounts = OA_Permission::getLinkedAccounts(true, true);
        $remainingCounts = [];
        
        // Prepare recently used accountName
        $recentlyUsed = [];
        global $session;
        if (empty($query) && !empty($session['recentlyUsedAccounts'])) {
            $allAcountsNoGroups = [];
            foreach (array_keys($accounts) as $k) {
                foreach ($accounts[$k] as $accountId => $accountName) {
                    $allAcountsNoGroups[$accountId] = $accountName;
                }
            }
            
            $recentlyUsedAccountIds = $session['recentlyUsedAccounts'];
            $added = 0;
            foreach ($recentlyUsedAccountIds as $k => $recentlyUserAccountId) {
                if (++$added > self::MAX_ACCOUNTS_IN_GROUP) {
                    break;
                }
                $recentlyUsed[$recentlyUserAccountId] = $allAcountsNoGroups[$recentlyUserAccountId];
            }
        }
        
        // Prepare admin accounts
        if (isset($accounts[OA_ACCOUNT_ADMIN])) {
            $adminAccounts = self::filterByNameAndLimit($accounts[OA_ACCOUNT_ADMIN], $query, $remainingCounts, OA_ACCOUNT_ADMIN);
            unset($accounts[OA_ACCOUNT_ADMIN]);
        } else {
            $adminAccounts = [];
        }
        
        $showSearchAndRecent = false;
        foreach ($accounts as $k => $v) {
            $workingFor = sprintf($GLOBALS['strWorkingFor'], ucfirst(strtolower($k)));
            $accounts[$workingFor] = self::filterByNameAndLimit($v, $query, $remainingCounts, $workingFor);
            $count = count($accounts[$workingFor]);
            if ($count == 0) {
                unset($accounts[$workingFor]);
            }
            $showSearchAndRecent |= isset($remainingCounts[$workingFor]);
            
            unset($accounts[$k]);
        }
        
        // Prepend recently used to the results
        if (!empty($recentlyUsed) && $showSearchAndRecent) {
            $accounts = array_merge([$GLOBALS['strRecentlyUsed'] => $recentlyUsed], $accounts);
        }
        
        $template->assign('adminAccounts', $adminAccounts);
        $template->assign('otherAccounts', $accounts);
        $template->assign('remainingCounts', $remainingCounts);
        $template->assign('query', $query);
        $template->assign('noAccountsMessage', sprintf($GLOBALS['strNoAccountWithXInNameFound'], $query));
        $template->assign('currentAccountId', OA_Permission::getAccountId());
        $template->assign('showSearchAndRecent', $showSearchAndRecent);
    }

    public static function addToRecentlyUsedAccounts($accountId)
    {
        global $session;
        if (empty($session['recentlyUsedAccounts'])) {
            $session['recentlyUsedAccounts']['a' . $accountId] = $accountId;
        } else {
            $session['recentlyUsedAccounts'] = array_merge(
                ['a' . $accountId => $accountId],
                $session['recentlyUsedAccounts']
            );
        }
        phpAds_SessionDataStore();
    }

    private static function filterByNameAndLimit(
        $accounts,
        $q,
        &$remainingCounts,
        $remainingCountsKey
    ) {
        $result = [];
        $added = 0;
        $limit = empty($q) ? self::MAX_ACCOUNTS_IN_GROUP : self::MAX_ACCOUNTS_IN_SEARCH;
        foreach ($accounts as $id => $name) {
            if ((empty($q) || stripos($name, $q) !== false) && $added++ < $limit) {
                $result[$id] = $name;
            }
        }
        
        if ($added > $limit) {
            $remainingCounts[$remainingCountsKey] = sprintf($GLOBALS['strAndXMore'], ($added - $limit));
        }
        
        return $result;
    }
}
