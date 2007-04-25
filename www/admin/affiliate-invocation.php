<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
MAX_Permission::checkAccessToObject('affiliates', $affiliateid);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (isset($session['prefs']['affiliate-zones.php']['listorder'])) {
    $navorder = $session['prefs']['affiliate-zones.php']['listorder'];
} else {
    $navorder = '';
}
if (isset($session['prefs']['affiliate-zones.php']['orderdirection'])) {
    $navdirection = $session['prefs']['affiliate-zones.php']['orderdirection'];
} else {
    $navdirection = '';
}

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    // Get other affiliates
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $doAffiliates->addListOrderBy($navorder, $navdirection);
    if (phpAds_isUser(phpAds_Agency)) {
        $doAffiliates->agencyid = $agencyid;
    }
    $doAffiliates->find();
    while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
        phpAds_PageContext (
            phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
            "affiliate-invocation.php?affiliateid=".$row['affiliateid'],
            $affiliateid == $row['affiliateid']
        );
    }

    phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');
    phpAds_PageShortcut($strZoneHistory, 'stats.php?entity=zone&breakdown=history&affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-statistics.gif');
    phpAds_PageHeader("4.2.5");
    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.2.2", "4.2.3","4.2.4","4.2.5"));
} else {
    if (phpAds_isAllowed(MAX_AffiliateIsReallyAffiliate)) {
        phpAds_PageHeader('2');
    } else {
        $sections = array();
        $sections[] = "2.1";
        if (phpAds_isAllowed(MAX_AffiliateGenerateCode)) {
            $sections[] = "2.2";
        }
        phpAds_PageHeader('2.2');
        phpAds_ShowSections($sections);
    }
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Affiliate) && MAX_Permission::isAllowed(MAX_AffiliateIsReallyAffiliate)) {
    require_once MAX_PATH . '/lib/max/Admin/Invocation/Affiliate.php';
    $maxInvocation = new MAX_Admin_Invocation_Affiliate();
} else {
    require_once MAX_PATH . '/lib/max/Admin/Invocation/Publisher.php';
    $maxInvocation = new MAX_Admin_Invocation_Publisher();
}

$maxInvocation->placeInvocationForm();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();


?>
