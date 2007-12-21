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

$oAdNetworks = new OA_Central_AdNetworks();
$agencyid = OA_Permission::getAgencyId();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.2.7.1");
echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
phpAds_ShowSections(array("4.2.7.1"));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-user-start.html');
$oTpl->assign('action', 'affiliate-user.php');
$oTpl->assign('method', 'GET');

// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false; 
$oTpl->assign('hosted', $HOSTED);

$oTpl->assign('error', $oPublisherDll->_errorMessage);

$oTpl->assign('affiliateid', $affiliateid);

// TODO: this bit should probably be refactored to a library -- it looks it should
// be the same for publishers, advertisers, agencies and admins. Alternatively,
// maybe one PHP page (with a parameter identitfying the entity) could handle
// the "start" page of user linking?
if ($HOSTED) {
   $oTpl->assign('fields', array(
       array(
           'title'     => "E-mail",
           'fields'    => array(
               array(
                   'name'      => 'email',
                   'label'     => $strEmailToLink,
                   'value'     => '',
                   'id'        => 'user-key'
               )
           )
       )
   ));
}
else
{
   $oTpl->assign('fields', array(
       array(
           'title'     => $strUsername,
           'fields'    => array(
               array(
                   'name'      => 'login',
                   'label'     => $strUsernameToLink,
                   'value'     => '',
                   'id'        => 'user-key'
               ),
           )
       ),
   ));
}


//var_dump($oTpl);
//die();
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
