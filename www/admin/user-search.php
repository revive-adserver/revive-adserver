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
 * A script to provide a list of users for the user name autocomplete
 * function, used when linking users to accounts.
 *
 * Currently, the script takes two GET parameters:
 *   - "q"     -- The string user typed in the autocompleted input; and
 *   - "limit" -- The number of search results to be returned.
 *
 * Results of auto completion are limited to those users that are already
 * linked to accounts in the current account realm.
 *
 * @author     Stanislaw Osinski <stanislaw.osinski@openx.org>
 */

$q = strtolower($_GET["q"]);
$limit = strtolower($_GET["limit"]);
if (!$q) return;

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';

// Restrict access to accounts which are allowed to link other accounts
switch (OA_Permission::getAccountType()) {
    case OA_ACCOUNT_ADMIN:
        // There are no restrictions on users that are applied to the autocomplete
        // list, as the admin account can see all accounts and therefore users in
        // its realm
        $oDbh = &OA_DB::singleton();
        $query = $oDbh->quote('%'.$q.'%');
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->whereAdd('username LIKE ' . $query . ' OR email_address LIKE ' . $query);
        $doUsers->limit($limit);
        $doUsers->find();
        while ($doUsers->fetch()) {
            echo htmlspecialchars($doUsers->user_id) . '|' . htmlspecialchars($doUsers->email_address) . '|' . htmlspecialchars($doUsers->username)."\n";
        }
        break;

    case OA_ACCOUNT_MANAGER:
        // Check that they have the super account permission
        if (!OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT)) {
            break;
        }
        // A manager account can only "see" those users that are already linked to the
        // current account, and to the advertiser and trafficker accounts that are in the
        // current account's realm -- display only these users -- but also exclude any
        // user that is also linked to the admin account
        $aAdminUserIds = array();
        $aUserIds = array();
        $oDbh = &OA_DB::singleton();
        // Get the ID of all users linked to the admin account
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->account_id = $adminAccountId;
        $doAccount_user_assoc->find();
        while ($doAccount_user_assoc->fetch() > 0) {
            // Store the user info for later
            $aInfo = $doAccount_user_assoc->toArray();
            $aAdminUserIds[] = $aInfo['user_id'];
        }
        // Get the current manager account ID
        $currentAccountId = OA_Permission::getAccountId();
        // Select all of the users that are linked with the current manager account
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->account_id = $currentAccountId;
        $doAccount_user_assoc->find();
        while ($doAccount_user_assoc->fetch() > 0) {
            // Store the user info for later
            $aInfo = $doAccount_user_assoc->toArray();
            if (!in_array($aInfo['user_id'], $aAdminUserIds)) {
                $aUserIds[] = $aInfo['user_id'];
            }
        }
        // Translate the manager account ID into an agency ID
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->account_id = $currentAccountId;
        $doAgency->find();
        if ($doAgency->getRowCount() != 1) {
            break;
        }
        $doAgency->fetch();
        $aInfo = $doAgency->toArray();
        $agencyId = $aInfo['agencyid'];
        // Find all advertiser accounts in the current manager account's realm
        $aAdvertiserAccountIds = array();
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId;
        $doClients->find();
        while ($doClients->fetch()) {
            $aInfo = $doClients->toArray();
            $aAdvertiserAccountIds[] = $aInfo['account_id'];
        }
        if (count($aAdvertiserAccountIds) > 0) {
            // Obtain the information of users linked to the located account(s)
            $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
            foreach ($aAdvertiserAccountIds as $accountId) {
                $doAccount_user_assoc->whereAdd("account_id = $accountId", 'OR');
            }
            $doAccount_user_assoc->find();
            while ($doAccount_user_assoc->fetch() > 0) {
                // Store the user info for later
                $aInfo = $doAccount_user_assoc->toArray();
                if (!in_array($aInfo['user_id'], $aAdminUserIds)) {
                    $aUserIds[] = $aInfo['user_id'];
                }
            }
        }
        // Find all trafficker accounts in the current manager account's realm
        $aTraffickerAccountIds = array();
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId;
        $doAffiliates->find();
        while ($doAffiliates->fetch()) {
            $aInfo = $doAffiliates->toArray();
            $aTraffickerAccountIds[] = $aInfo['account_id'];
        }
        if (count($aTraffickerAccountIds) > 0) {
            // Obtain the information of users linked to the located account(s)
            $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
            foreach ($aTraffickerAccountIds as $accountId) {
                $doAccount_user_assoc->whereAdd("account_id = $accountId", 'OR');
            }
            $doAccount_user_assoc->find();
            while ($doAccount_user_assoc->fetch() > 0) {
                // Store the user info for later
                $aInfo = $doAccount_user_assoc->toArray();
                if (!in_array($aInfo['user_id'], $aAdminUserIds)) {
                    $aUserIds[] = $aInfo['user_id'];
                }
            }
        }
        // Convert any found user IDs into the correct format for display
        $aUserIds = array_unique($aUserIds);
        if (empty($aUserIds)) {
            break;
        }
        $query = $oDbh->quote('%'.$q.'%');
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->whereAdd('(username LIKE ' . $query . ' OR email_address LIKE ' . $query . ')');
        $doUsers->whereAdd('user_id IN (' . implode($aUserIds, ',') . ')');
        $doUsers->limit($limit);
        $doUsers->find();
        while ($doUsers->fetch()) {
            echo htmlspecialchars($doUsers->user_id) . '|' . htmlspecialchars($doUsers->email_address) . '|' . htmlspecialchars($doUsers->username)."\n";
        }
        break;

    case OA_ACCOUNT_ADVERTISER:
        // It would only be possible to display those users that are already linked to the
        // current advertiser account, as the realm of an advertiser account does not include
        // any other accounts - therefore, do not bother displaying any autocomplete information
        break;

    case OA_ACCOUNT_TRAFFICKER:
        // It would only be possible to display those users that are already linked to the
        // current trafficker account, as the realm of a trafficker account does not include
        // any other accounts - therefore, do not bother displaying any autocomplete information
        break;
}

?>