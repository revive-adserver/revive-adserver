<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * Helper methods for user switching
 */
class OA_Admin_UI_AccountSwitch
{
    const MAX_ACCOUNTS_IN_GROUP = 10;
    const MAX_ACCOUNTS_IN_SEARCH = 20;
    
    public static function assignModel(OA_Admin_Template $template, $query = '')
    {
        $accounts = OA_Permission::getLinkedAccounts(true, true);
        $remainingCounts = array ();
        
        // Prepare recently used accountName
        $recentlyUsed = array();
        global $session;
        if (empty($query) && !empty($session['recentlyUsedAccounts'])) {
            $allAcountsNoGroups = array();
            foreach ($accounts as $k => $v) {
                foreach($accounts[$k] as $accountId => $accountName) {
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
        }
        else {
            $adminAccounts = array ();
        }
        
        foreach ($accounts as $k => $v) {
            $workingFor = sprintf($GLOBALS['strWorkingFor'], ucfirst(strtolower($k)));
            $accounts[$workingFor] = self::filterByNameAndLimit($v, $query, $remainingCounts, $workingFor);
            if (count($accounts[$workingFor]) == 0) {
                unset($accounts[$workingFor]);
            }
            
            unset($accounts[$k]);
        }
        
        // Prepend recently used to the results
        if (!empty($recentlyUsed)) {
            $accounts = array_merge(array($GLOBALS['strRecentlyUsed'] => $recentlyUsed), $accounts);
        }
        
        $template->assign('adminAccounts', $adminAccounts);
        $template->assign('otherAccounts', $accounts);
        $template->assign('remainingCounts', $remainingCounts);
        $template->assign('query', $query);
        $template->assign('noAccountsMessage', sprintf($GLOBALS['strNoAccountWithXInNameFound'], $query));
        $template->assign('currentAccountId', OA_Permission::getAccountId());
    }

    public static function addToRecentlyUsedAccounts($accountId)
    {
        global $session;
        if (empty($session['recentlyUsedAccounts']))
        {
            $session['recentlyUsedAccounts']['a' . $accountId] = $accountId;
        } else {
            $session['recentlyUsedAccounts'] = array_merge(array('a' . $accountId => $accountId), 
                $session['recentlyUsedAccounts']);
        }
        phpAds_SessionDataStore();
    }

    private static function filterByNameAndLimit($accounts, $q, &$remainingCounts, 
            $remainingCountsKey)
    {
        $result = array ();
        $added = 0;
        $limit = empty($q) ? self::MAX_ACCOUNTS_IN_GROUP : self::MAX_ACCOUNTS_IN_SEARCH;
        foreach ($accounts as $id => $name) {
            if (empty($q) || stripos($name, $q) !== false) {
                if (++$added < $limit) {
                    $result[$id] = $name;
                }
            }
        }
        
        if ($added > $limit) {
            $remainingCounts[$remainingCountsKey] = sprintf($GLOBALS['strAndXMore'], ($added - $limit));
        }
        
        return $result;
    }
}
