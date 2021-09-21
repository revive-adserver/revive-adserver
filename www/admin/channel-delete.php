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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';

// Register input variables
phpAds_registerGlobal('returnurl', 'agencyid', 'channelid', 'affiliateid');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

// CVE-2013-5954 - see OA_Permission::checkSessionToken() method for details
OA_Permission::checkSessionToken();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($channelid)) {
    $ids = explode(',', $channelid);
    foreach ($ids as $channelid) {
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
    $translation = new OX_Translation();

    if (count($ids) == 1) {
        $translated_message = $translation->translate($GLOBALS['strChannelHasBeenDeleted'], [
            htmlspecialchars($aChannel['name'])
        ]);
    } else {
        $translated_message = $translation->translate($GLOBALS['strChannelsHaveBeenDeleted']);
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
