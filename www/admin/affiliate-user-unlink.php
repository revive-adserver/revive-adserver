<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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


// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';

// Register input variables
phpAds_registerGlobal ('login', 'returnurl');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::checkAccessToObject('affiliates', $affiliateid);
$accountId = OA_Permission::getAccountIdForEntity('affiliates', $affiliateid);
$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);
OA_Permission::enforceAccess($accountId, $userid);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($affiliateid) && !empty($userid))
{
	$doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
	$doAccount_user_assoc->account_id = $accountId;
	$doAccount_user_assoc->user_id = $userid;
	$doAccount_user_assoc->delete();
	
	$doUsers = OA_Dal::staticGetDO('users', $userid);
	// delete user account if he is not linked anymore to any account
	if ($doUsers->countLinkedAccounts() == 0) {
	    $doUsers->delete();
	}
}

if (empty($returnurl)) {
	$returnurl = 'affiliate-access.php?affiliateid='.$affiliateid;
}

Header("Location: ".$returnurl);

?>