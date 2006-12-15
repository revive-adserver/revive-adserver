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
$Id: banner-acl.php 6131 2006-11-29 11:57:30Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/other/capping/lib-capping.inc.php';

// Register input variables
phpAds_registerGlobal ('acl', 'action', 'submit');


// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
$agencyId = phpAds_getAgencyID();
$aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid, 'bannerid' => $bannerid);

if (!MAX_checkAd($clientid, $campaignid, $bannerid)) {
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

if (!empty($action)) {
    $acl = MAX_AclAdjust($acl, $action);
} elseif (!empty($submit)) {
    $aBannerPrev = MAX_cacheGetAd($bannerid, false);
    $acl = (isset($acl)) ? $acl : array();
    MAX_AclSave($acl, $aEntities);

    _initCappingVariables();

	// If the capping/blocking values have been changed - update the values
	if (($aBannerPrev['block'] <> $block) || ($aBannerPrev['capping'] <> $cap) || ($aBannerPrev['session_capping'] <> $session_capping)) {
	    $values = array();
	    $acls_updated = false;
	    $now = date('Y-m-d H:i:s');
        
	    if ($aBannerPrev['block'] <> $block) {
	        $values[] = "block={$block}";
	        $acls_updated = ($block == 0) ? true : $acls_updated;
	    }
	    if ($aBannerPrev['capping'] <> $cap) {
	        $values[] = "capping={$cap}";
	        $acls_updated = ($cap == 0) ? true : $acls_updated;
	    }
	    if ($aBannerPrev['session_capping'] <> $session_capping) {
	        $values[] = "session_capping={$session_capping}";
	        $acls_updated = ($session_capping == 0) ? true : $acls_updated;
	    }
	    if ($acls_updated) {
	        $values[] = "acls_updated='{$now}'";
	    }
	    
	    if (!empty($values)) {
	        $values[] = "updated='{$now}'";
	        $res = phpAds_dbQuery("
	           UPDATE
	               {$conf['table']['prefix']}{$conf['table']['banners']}
               SET
                   " . implode(', ', $values) . "
               WHERE
                   bannerid = {$bannerid}
            ") or phpAds_sqlDie();
	    }
	}
    header("Location: banner-zone.php?clientid={$clientid}&campaignid={$campaignid}&bannerid={$bannerid}");
    exit;
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Display navigation
$aOtherCampaigns = Admin_DA::getPlacements(array('agency_id' => $agencyId));
$aOtherBanners = Admin_DA::getAds(array('placement_id' => $campaignid), false);
MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$aBanner = MAX_cacheGetAd($bannerid, false);

if (isset($acl)) {
    $acl = MAX_aclAStripslashed($acl);
} else {
    $acl = Admin_DA::getDeliveryLimitations(array('ad_id' => $bannerid));
}

$aParams = array('clientid' => $clientid, 'campaignid' => $campaignid, 'bannerid' => $bannerid);

MAX_displayAcls($acl, $aParams);

echo "
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>";

$tabindex = _echoDeliveryCappingHtml($tabindex, $GLOBALS['strCappingBanner'], $aBanner);

echo "
<tr><td height='1' colspan='3' bgcolor='#888888'>
<img src='images/break.gif' height='1' width='100%'></td></tr>

</table>
<br /><br /><br />
<input type='submit' name='submit' value='{$GLOBALS['strSaveChanges']}' tabindex='".($tabindex++)."'>

</form>";


/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/
?>
<?php

_echoDeliveryCappingJs();

phpAds_PageFooter();

?>
