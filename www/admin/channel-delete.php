<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';

// Register input variables
phpAds_registerGlobal ('returnurl', 'agencyid', 'channelid', 'affiliateid');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($channelid)) {
    $ids = explode(',', $channelid);
    while (list(,$channelid) = each($ids)) {

        // Security check
        OA_Permission::enforceAccessToObject('channel', $channelid);
    
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->channelid = $channelid;
        if ($doChannel->get($channelid)) {
           $aChannel = $doChannel->toArray();
        }
    
        $doChannel->delete();
    }
    
    // Queue confirmation message
    $translation = new OX_Translation ();
    
    if (count($ids) == 1) {
        $translated_message = $translation->translate ($GLOBALS['strChannelHasBeenDeleted'], array(
            htmlspecialchars($aChannel['name'])
        ));
    } else {
        $translated_message = $translation->translate ($GLOBALS['strChannelsHaveBeenDeleted']);
    }

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
}


if (!empty($affiliateid)) {
    if (empty($returnurl)) {
        $returnurl = 'affiliate-channels.php';
    }
    header("Location: {$returnurl}?affiliateid={$affiliateid}");
} else {
    if (empty($returnurl)) {
        $returnurl = 'channel-index.php';
    }
    header("Location: {$returnurl}");
}

?>
