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

phpAds_registerGlobalUnslashed('codetype');

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();

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
            MAX_buildName($row['affiliateid'], $row['name']),
            "affiliate-invocation.php?affiliateid=" . $row['affiliateid'],
            $affiliateid == $row['affiliateid']
        );
    }
    addWebsitePageTools($affiliateid);
    phpAds_PageHeader("4.2.5", $oHeaderModel);
} else {
    $sections = [];
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
