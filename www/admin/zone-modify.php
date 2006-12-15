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
$Id: zone-modify.php 4351 2006-03-06 18:05:36Z matteo@beccati.com $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal('newaffiliateid', 'returnurl', 'duplicate');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (!MAX_checkZone($affiliateid, $zoneid)) {
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($zoneid) && $zoneid != '') {
    if (isset($newaffiliateid) && $newaffiliateid != '') {
        // Move the zone
        // Needs to ensure that the publisher the zone is being moved to is
        // owned by the agency, if an agency is logged in.
        if (phpAds_isUser(phpAds_Agency)) {
            MAX_checkPublisher($newaffiliateid);
        } 
        
        // Move the zone to the new Publisher/Affiliate
        $res = phpAds_dbQuery("
            UPDATE
                ".$conf['table']['prefix'].$conf['table']['zones']."
            SET
                affiliateid = '".$newaffiliateid."',
                updated = '".date('Y-m-d H:i:s')."'
            WHERE
                zoneid = '".$zoneid."'
            ") or phpAds_sqlDie();
        
        Header ("Location: ".$returnurl."?affiliateid=".$newaffiliateid."&zoneid=".$zoneid);
        exit;
        
    } elseif (isset($duplicate) && $duplicate == 'true') {
        // Duplicate the zone
        
        $res = phpAds_dbQuery("
			SELECT
		   		*
			FROM
				".$conf['table']['prefix'].$conf['table']['zones']."
			WHERE
				zoneid = '".$zoneid."'
		") or phpAds_sqlDie();
        
        if ($row = phpAds_dbFetchArray($res)) {
            // Get names
            if (ereg("^(.*) \([0-9]+\)$", $row['zonename'], $regs)) {
                $basename = $regs[1];
            } else {
                $basename = $row['zonename'];
            }
            
            $names = array();
            
            $res = phpAds_dbQuery("
				SELECT
			   		*
				FROM
					".$conf['table']['prefix'].$conf['table']['zones']."
			") or phpAds_sqlDie();
            
            while ($name = phpAds_dbFetchArray($res)) {
                $names[] = $name['zonename'];
            }
            
            // Get unique name
            $i = 2;
            
            while (in_array($basename.' ('.$i.')', $names)) {
                $i++;
            }
            
            $row['zonename'] = $basename.' ('.$i.')';
            
            
            // Remove bannerid
            unset($row['zoneid']);
            
            $values = array();
            
            if(isset($row['updated'])) {
                unset($row['updated']);
            }
            while (list($name, $value) = each($row)) {
                $values[] = $name." = '".addslashes($value)."'";
            }
            
            $res = phpAds_dbQuery("
		   		INSERT INTO
		   			".$conf['table']['prefix'].$conf['table']['zones']."
				SET
					".implode(", ", $values).",
					updated = '".date('Y-m-d H:i:s')."'
	   		") or phpAds_sqlDie();
            
            $new_zoneid = phpAds_dbInsertID();
            
            Header ("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$new_zoneid);
            exit;
        }
    }
}

Header("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$zoneid);

?>
