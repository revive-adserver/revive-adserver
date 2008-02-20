<?php

/**
 * This script provides lists of users for the user name autocomplete
 * used in the first screen of user linking.
 *
 * Currently, the script takes two parameters:
 *   * "q" -- the string user typed in the autocompleted input
 *   * "limit" -- the number of search results to be returned
 *
 * See the code at the bottom for the searching "algorithm". In case of
 * questions, ask (Staszek).
 *
 * I'm assuming more parameters will need to be passed here (e.g. entity/logged
 * user id to select only those users the currently logged user
 * has the right to view). Please let me (Staszek) know, and I'll help to
 * add the parameters on the client side (Javascript) side.
 */

$q = strtolower($_GET["q"]);
$limit = strtolower($_GET["limit"]);
if (!$q) return;

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';

// Restrict access to only accounts which are allowed to link other accounts
switch (OA_Permission::getAccountType()) {
    case OA_ACCOUNT_TRAFFICKER:
        OA_Permission::enforceAccountPermission(OA_ACCOUNT_TRAFFICKER, OA_PERM_SUPER_ACCOUNT);
    break;
    case OA_ACCOUNT_ADVERTISER:
        OA_Permission::enforceAccountPermission(OA_ACCOUNT_ADVERTISER, OA_PERM_SUPER_ACCOUNT);
    break;
}

$oDbh = &OA_DB::singleton();
$query = $oDbh->quote('%'.$q.'%');
$doUsers = OA_Dal::factoryDO('users');
$doUsers->whereAdd('username LIKE '.$query . ' OR email_address LIKE '.$query);
$doUsers->limit($limit);
$doUsers->find();
while ($doUsers->fetch()) {
    echo $doUsers->user_id . '|' . $doUsers->email_address . '|' . $doUsers->username."\n";
}

?>
