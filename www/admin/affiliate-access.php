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
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
MAX_Permission::checkIsAllowed(phpAds_ModifyInfo);
MAX_Permission::checkAccessToObject('affiliates', $affiliateid);

// Initialise Ad  Networks
$oAdNetworks = new OA_Central_AdNetworks();

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Affiliate)) {
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $affiliateid = phpAds_getUserID();
    $doAffiliates->get($affiliateid);
    $agencyid = $doAffiliates->agencyid;
} elseif (phpAds_isUser(phpAds_Agency)) {
    $agencyid = phpAds_getUserID();
} else {
    $agencyid = 0;
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($affiliateid != "") {
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
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
        if (phpAds_isUser(phpAds_Agency)) {
            $doAffiliates->agencyid = $agencyid;
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
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
        if (MAX_Permission::isAllowed(MAX_AffiliateIsReallyAffiliate)) {
            phpAds_PageHeader('4');
        } else {
            $sections = array();
            $sections[] = "4.1";
            if (MAX_Permission::isAllowed(phpAds_ModifyInfo)) {
                $sections[] = "4.7";
            }
            phpAds_PageHeader('4.7');
            phpAds_ShowSections($sections);
        }
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

$oTpl->assign('error', $oPublisherDll->_errorMessage);

$oTpl->assign('affiliateid', $affiliateid);
$oTpl->assign('move', $move);

$oTpl->assign('users', array(
  'aUsers'  => array (
                  array  (
                     'name' => 'John Smith',
                     'email' => 'john@smith.com',
                     'login' => 'johns',
                     'dateLinked' => '20/12/2007',
                     'toDelete' => true // TODO: indicates whether the user is linked to his last entity, and unlinkin will result in user being deleted
                  ),

                  array  (
                     'name' => 'Andy Test',
                     'email' => 'andy@test.com',
                     'login' => 'andyt',
                     'dateLinked' => '20/05/2007',
                     'toDelete' => false // TODO: indicates whether the user is linked to his last entity, and unlinkin will result in user being deleted
                  )
               )
  )
);

//var_dump($oTpl);
//die();
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
