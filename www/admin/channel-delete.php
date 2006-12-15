<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: channel-delete.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';

// Register input variables
phpAds_registerGlobal ('returnurl', 'agencyid', 'channelid', 'affiliateid');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($channelid))
{
    if (phpAds_isUser(phpAds_Agency))
    {
        if($agencyid != phpAds_getUserID()) {
            $res = phpAds_dbQuery($query) or phpAds_sqlDie();
            if (phpAds_dbNumRows($res) == 0)
            {
                phpAds_PageHeader("2");
                phpAds_Die ($strAccessDenied, $strNotAdmin);
            }
        }
    }


    // Get all banner limitations which use this channel
    $res_channels = phpAds_dbQuery("
            SELECT *, FIND_IN_SET($channelid, data) FROM
                ".$conf['table']['prefix'].$conf['table']['acls']."
            WHERE
                type = 'channel'
                AND  FIND_IN_SET($channelid, data) > 0") or phpAds_sqlDie();

    while ($row = phpAds_dbFetchArray($res_channels))
    {
        // remove channel id from limitations
        $channelIds = explode(',', $row['data']);
        $channelIds = array_diff($channelIds, array($channelid));
        if(!empty($channelIds)) {
            phpAds_dbQuery("
                    UPDATE
                        ".$conf['table']['prefix'].$conf['table']['acls']."
                    SET
                        data ='".implode(',', $channelIds)."'
                    WHERE
                        bannerid=".$row['bannerid']."
                        AND executionorder=".$row['executionorder']."
                ") or phpAds_sqlDie();
        } else {
            phpAds_dbQuery("
                    DELETE FROM
                        ".$conf['table']['prefix'].$conf['table']['acls']."
                    WHERE
                        bannerid=".$row['bannerid']."
                        AND executionorder=".$row['executionorder']."
                ") or phpAds_sqlDie();
        }
        phpAds_compileBannerLimitation($row['bannerid']);
    }


    // Delete channel
    $res = phpAds_dbQuery("
        DELETE FROM
            ".$conf['table']['prefix'].$conf['table']['channel']."
        WHERE
            channelid=$channelid
        ") or phpAds_sqlDie();

    // Delete channel's acls
    $res = phpAds_dbQuery("
        DELETE FROM
            ".$conf['table']['prefix'].$conf['table']['acls_channel']."
        WHERE
            channelid=$channelid
        ") or phpAds_sqlDie();

    // Delete data from data_summary_channel_daily linked to this channel
    $res = phpAds_dbQuery("
        DELETE FROM
            ".$conf['table']['prefix'].$conf['table']['data_summary_channel_daily']."
        WHERE
            channel_id=$channelid
        ") or phpAds_sqlDie();

}

if (empty($returnurl)) {
    $returnurl = 'channel-index.php';
}

if (!empty($affiliateid)) {
    header("Location: {$returnurl}?affiliateid={$affiliateid}");
} else {
    header("Location: {$returnurl}?agencyid={$agencyid}");
}

?>
