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
