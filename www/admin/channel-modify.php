<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 Openads Limited                                   |
| For contact details, see: http://www.openx.org/                           |
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

// Register input variables
phpAds_registerGlobal('newaffiliateid', 'returnurl', 'duplicate');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('channel', $channelid);

$affiliateid    = (int) $affiliateid;
$channelid      = (int) $channelid;

if (empty($returnurl)) {
    $returnurl = 'channel-acl.php';
}

// Security check
if (isset($channelid) && $channelid != '') {
    if (isset($duplicate) && $duplicate == 'true') {
        // Duplicate the channel
        $newChannelId = OA_Dal::staticDuplicate('channel', $channelid);
        $params = (!$affiliateid)
            ? "?channelid=".$newChannelId
            : "?affiliateid=".$affiliateid."&channelid=".$newChannelId;
        Header("Location: ".$returnurl.$params);
        exit;

    }

}

Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&channelid=".$channelid);

?>
