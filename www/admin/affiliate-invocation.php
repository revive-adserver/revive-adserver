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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OA_Permission::enforceAllowed(OA_PERM_ZONE_INVOCATION);
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
$oHeaderModel = MAX_displayWebsiteBreadcrumbs($affiliateid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Get other affiliates
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $doAffiliates->addSessionListOrderBy('affiliate-zones.php');
    $doAffiliates->agencyid = $agencyid;
    $doAffiliates->find();
    while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
        phpAds_PageContext(
            MAX_buildName ($row['affiliateid'], $row['name']),
            "affiliate-invocation.php?affiliateid=".$row['affiliateid'],
            $affiliateid == $row['affiliateid']
        );
    }
    addWebsitePageTools($affiliateid);
    phpAds_PageHeader("4.2.5", $oHeaderModel);
} else {
    $sections = array();
    $sections[] = "2.1";
    if (OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION)) {
        $sections[] = "2.2";
    }
    phpAds_PageHeader('2.2', $oHeaderModel);
    phpAds_ShowSections($sections);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/max/Admin/Invocation/Publisher.php';
$maxInvocation = new MAX_Admin_Invocation_Publisher();

$maxInvocation->placeInvocationForm();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();


?>
