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

// Register input variables
phpAds_registerGlobal('newaffiliateid', 'returnurl', 'duplicate');


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('channel', $channelid);

$affiliateid    = (int) $affiliateid;
$channelid      = (int) $channelid;

if (empty($returnurl)) {
    $returnurl = 'channel-edit.php';
}

// Security check
if (isset($channelid) && $channelid != '') {
    OA_Permission::checkSessionToken();

    if (isset($duplicate) && $duplicate == 'true') {

        //get channel old channel name
        $doChannel = OA_Dal::factoryDO('channel');
        if ($doChannel->get($channelid)) {
            $oldName = $doChannel->name;
        }
        // Duplicate the channel
        $newChannelId = OA_Dal::staticDuplicate('channel', $channelid);

        //get new name
        $doChannel = OA_Dal::factoryDO('channel');
        if ($doChannel->get($newChannelId)) {
            $newName = $doChannel->name;
        }
        // Queue confirmation message
        $translation = new OX_Translation();
        $oldChannelParams = (!$affiliateid)
            ? "channelid=$channelid"
            :   "affiliateid=$affiliateid&channelid=$channelid";

        $newChannelParams = (!$affiliateid)
            ? "?channelid=$newChannelId"
            : "?affiliateid=$affiliateid&channelid=$newChannelId";

        $translated_message = $translation->translate ( $GLOBALS['strChannelHasBeenDuplicated'],
            array(MAX::constructURL(MAX_URL_ADMIN, "channel-edit.php?".$oldChannelParams),
                htmlspecialchars($oldName),
                MAX::constructURL(MAX_URL_ADMIN, "channel-edit.php?".$newChannelParams),
                htmlspecialchars($newName))
        );
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);


        Header("Location: ".$returnurl.$newChannelParams);
        exit;

    }

}

Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&channelid=".$channelid);

?>
