<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once '../../init.php';

require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

require_once LIB_PATH . '/Admin/Redirect.php';

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
