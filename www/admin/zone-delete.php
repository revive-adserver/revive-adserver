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
$Id: zone-delete.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal ('returnurl');


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($zoneid) && $zoneid != '') {
    if (phpAds_isUser(phpAds_Affiliate)) {
        $result = phpAds_dbQuery("
            SELECT
                affiliateid
            FROM
                ".$conf['table']['prefix'].$conf['table']['zones']."
            WHERE
                zoneid = '$zoneid'
            ") or phpAds_sqlDie();
        $row = phpAds_dbFetchArray($result);
        
        if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"] || !phpAds_isAllowed(phpAds_DeleteZone)) {
            phpAds_PageHeader("1");
            phpAds_Die ($strAccessDenied, $strNotAdmin);
        } else {
            $affiliateid = $row["affiliateid"];
        }
    } elseif (phpAds_isUser(phpAds_Agency)) {
        $query = "SELECT z.affiliateid AS affiliateid".
            " FROM ".$conf['table']['prefix'].$conf['table']['zones']." AS z".
            ",".$conf['table']['prefix'].$conf['table']['affiliates']." AS a".
            " WHERE z.affiliateid = a.affiliateid".
            " AND a.agencyid=".phpAds_getUserID();
    
        $res = phpAds_dbQuery($query) or phpAds_sqlDie();
        if (phpAds_dbNumRows($res) == 0) {
            phpAds_PageHeader("2");
            phpAds_Die ($strAccessDenied, $strNotAdmin);
        }
    }
    
    // Reset append codes which called this zone
    if (phpAds_isUser(phpAds_Admin)) {
        $query = "SELECT zoneid,append".
            " FROM ".$conf['table']['prefix'].$conf['table']['zones'].
            " WHERE appendtype=".phpAds_ZoneAppendZone;
    } elseif (phpAds_isUser(phpAds_Agency)) {
        $query = "SELECT z.zoneid AS zoneid".
            ",z.append AS append".
            " FROM ".$conf['table']['prefix'].$conf['table']['zones']." AS z".
            ",".$conf['table']['prefix'].$conf['table']['affiliates']." AS a".
            " WHERE z.affiliateid = a.affiliateid".
            " AND a.agencyid=".phpAds_getUserID().
            " AND appendtype=".phpAds_ZoneAppendZone;
    }
    
    $res = phpAds_dbQuery($query)
        or phpAds_sqlDie();
    
    while ($row = phpAds_dbFetchArray($res)) {
        $append = phpAds_ZoneParseAppendCode($row['append']);

        if ($append[0]['zoneid'] == $zoneid) {
            phpAds_dbQuery("
                    UPDATE
                        ".$conf['table']['prefix'].$conf['table']['zones']."
                    SET
                        appendtype = ".phpAds_ZoneAppendRaw.",
                        append = '',
                        updated = '".date('Y-m-d H:i:s')."'
                    WHERE
                        zoneid =".$row['zoneid']."
                ");
        }
    }
    
    // Unlink all campaigns which are linked to this zone
    $res = phpAds_dbQuery("
        DELETE FROM
            {$conf['table']['prefix']}{$conf['table']['placement_zone_assoc']}
        WHERE
            zone_id={$zoneid}
    ") or phpAds_sqlDie();
    
    // Unlink all banners which are linked to this zone
    $res = phpAds_dbQuery("
        DELETE FROM
            {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
        WHERE
            zone_id={$zoneid}
    ") or phpAds_sqlDie();
    
    // Delete zone
    $res = phpAds_dbQuery("
        DELETE FROM
            ".$conf['table']['prefix'].$conf['table']['zones']."
        WHERE
            zoneid=$zoneid
        ") or phpAds_sqlDie();
}

if (!isset($returnurl) && $returnurl == '') {
    $returnurl = 'affiliate-zones.php';
}

Header("Location: ".$returnurl."?affiliateid=$affiliateid");

?>