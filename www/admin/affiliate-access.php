<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
$Id: affiliate-edit.php 12839 2007-11-27 16:32:39Z bernard.lange@openads.org $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

// Register input variables
phpAds_registerGlobalUnslashed ('move', 'name', 'website', 'contact', 'email', 'language', 'adnetworks', 'advsignup',
                               'errormessage', 'affiliateusername', 'affiliatepassword', 'affiliatepermissions', 'submit',
                               'publiczones_old', 'pwold', 'pw', 'pw2', 'formId', 'category', 'country', 'language');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::checkAccessToObject('affiliates', $affiliateid);

// Initialise Ad  Networks
$oAdNetworks = new OA_Central_AdNetworks();

$agencyid = OA_Permission::getAgencyId();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($affiliateid != "") {
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        if (isset($session['prefs']['affiliate-index.php']['listorder'])) {
            $navorder = $session['prefs']['affiliate-index.php']['listorder'];
        } else {
            $navorder = '';
        }
        if (isset($session['prefs']['affiliate-index.php']['orderdirection'])) {
            $navdirection = $session['prefs']['affiliate-index.php']['orderdirection'];
        } else {
            $navdirection = '';
        }
        // Get other affiliates

        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $doAffiliates->agencyid = $agencyid;
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $doAffiliates->affiliateid = $affiliateid;
        }
        $doAffiliates->addListOrderBy($navorder, $navdirection);
        $doAffiliates->find();
        while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
            phpAds_PageContext(
                phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
                "affiliate-edit.php?affiliateid=".$row['affiliateid'],
                $affiliateid == $row['affiliateid']
            );
        }
        phpAds_PageShortcut($strAffiliateHistory, 'stats.php?entity=affiliate&breakdown=history&affiliateid='.$affiliateid, 'images/icon-statistics.gif');
        phpAds_PageHeader("4.2.7");
        echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
        phpAds_ShowSections(array("4.2.2", "4.2.3","4.2.4","4.2.5","4.2.6","4.2.7"));
    } else {
        $sections = array('4.1', '4.7');
        phpAds_ShowSections($sections);
    }
    // Do not get this information if the page
    // is the result of an error message
    if (!isset($affiliate)) {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($affiliateid)) {
            $affiliate = $doAffiliates->toArray();
        }

        // Set password to default value
        if ($affiliate['password'] != '') {
            $affiliate['password'] = '********';
        }
    }
} else {
    phpAds_PageHeader("4.2.1");
    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.2.1"));
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-access.html');

// TODOPERM - assign info messages here
$oTpl->assign('infomessage', '');

$oTpl->assign('error', $oPublisherDll->_errorMessage);

$oTpl->assign('affiliateid', $affiliateid);
$oTpl->assign('move', $move);

$doUsers = OA_Dal::factoryDO('users');
$doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
$doAccount_user_assoc->account_id =
    OA_Permission::getAccountIdForEntity('affiliates', $affiliateid);
$doUsers->joinAdd($doAccount_user_assoc);
$doUsers->find();
$aUsers = array();
while($doUsers->fetch()) {
    $aUsers[$doUsers->user_id] = $doUsers->toArray();
    // is user linked to his last account
    $aUsers[$doUsers->user_id]['toDelete'] = ($doUsers->countLinkedAccounts() == 1);
}
$oTpl->assign('users', array('aUsers' => $aUsers));

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
