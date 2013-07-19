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

require_once '../../init.php';

require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';


OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

$userAccess = new OA_Admin_UI_UserAccess();
$userAccess->init();

function OA_headerUserNavigation()
{
    phpAds_PageHeader("4.4.2");
    phpAds_ShowSections(array("4.1", "4.3", "4.4", "4.4.2"));
}
$userAccess->setNavigationHeaderCallback('OA_headerUserNavigation');

$doAccounts = OA_Dal::factoryDO('accounts');
$userAccess->setAccountId($doAccounts->getAdminAccountId());
$userAccess->setPagePrefix('admin');
$userAccess->setBackUrl('admin-user-start.php');

$userAccess->process();

?>
