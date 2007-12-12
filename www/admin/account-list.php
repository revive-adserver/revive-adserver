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
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/www/admin/config.php';


if (!empty($_GET['account_id'])) {
    OA_Permission::enforceAccess($_GET['account_id']);

    OA_Permission::switchAccount($_GET['account_id']);
    header("Location: index.php");
    exit;
}


phpAds_PageHeader("0");

show();

phpAds_PageFooter();

function show()
{
    $oGacl = OA_Permission_Gacl::factory();

    $aAxos = $oGacl->get_object('ACCOUNTS', 1, 'AXO');

    $userId = OA_Permission::getUserId();

    $aAccounts = array();
    foreach ($aAxos as $id) {
        $aAxo = $oGacl->get_object_data($id, 'AXO');
        if ($oGacl->acl_check('ACCOUNT', 'ACCESS', 'USERS', $userId, 'ACCOUNTS', $aAxo[0][1])) {
            $aAccounts[$aAxo[0][1]] = $aAxo[0][3];
        }
    }

    $accountId = OA_Permission::getAccountId();

    echo "<ul>";
    foreach ($aAccounts as $id => $name) {
        if ($id == $accountId) {
            $start = '<b>';
            $end   = '</b>';
        } else {
            $start = '<a href="?account_id='.htmlspecialchars($id).'">';
            $end   = '</a>';
        }

        echo "<li>{$start}".htmlspecialchars($name)."{$end}</li>";
    }
    echo "</ul>";
}

?>
