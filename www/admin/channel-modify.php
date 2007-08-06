<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

// Register input variables
phpAds_registerGlobal('newaffiliateid', 'returnurl', 'duplicate');

$affiliateid    = (int) $affiliateid;
$agencyid       = (int) $agencyid;
$channelid      = (int) $channelid;

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);
if (isset($channelid) && $channelid != '') {

    MAX_Permission::checkAccessToObject('channel', $channelid);

    if (isset($newaffiliateid) && $newaffiliateid != '') {
        // A agency cannot move a channel
        if (phpAds_isUser(phpAds_Agency)) {
            phpAds_Die($strAccessDenied, $strNotAdmin);
        }
        // Move the channel to the new Publisher/Affiliate
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->get($channelid);
        $doChannel->affiliateid = $newaffiliateid;
        $doChannel->update();
        Header("Location: ".$returnurl."?affiliateid=".$newaffiliateid."&channelid=".$channelid);
        exit;

    } elseif (isset($duplicate) && $duplicate == 'true') {
        // Duplicate the channel
        $newChannelId = OA_Dal::staticDuplicate('channel', $channelid);
        $params = (!$affiliateid)
            ? "?agencyid=".$agencyid."&channelid=".$newChannelId
            : "?affiliateid=".$affiliateid."&channelid=".$newChannelId;
        Header("Location: ".$returnurl.$params);
        exit;

    }

}

Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&channelid=".$channelid);

?>
