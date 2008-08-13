<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

require_once LIB_PATH . '/Admin/Redirect.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

phpAds_registerGlobal('action');

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("maintenance-index");
phpAds_MaintenanceSelection("acls");

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!empty($action) && ($action == 'Recompile')) {
    MAX_AclReCompileAll();
    echo "<strong>$strAllBannerChannelCompiled</strong><br />";
}

echo $strBannerChannelResult;
phpAds_ShowBreak();
// Check the ACLs in the database against the compiled limitation strings...

echo "<strong>". $strChannels .":</strong>";
phpAds_showBreak();

// Check all the channels...
increaseMemoryLimit($GLOBALS['_MAX']['REQUIRED_MEMORY']['MAINTENANCE']);

$dalChannel = OA_Dal::factoryDAL('channel');
$rsChannel = $dalChannel->getChannelsAndAffiliates();
$rsChannel->find();
$allChannelsValid = true;
while ($rsChannel->fetch() && $row = $rsChannel->toArray()) {
    if (!MAX_AclValidate('channel-acl.php', array('channelid' => $row['channelid']))) {
        $allChannelsValid = false;
        $affiliateName = (!empty($row['affiliatename'])) ? $row['affiliatename'] : $strUntitled;
        echo "<a href='channel-acl.php?affiliateid={$row['affiliateid']}&channelid={$row['channelid']}'>{$row['name']}</a><br />";
    }
}
if ($allChannelsValid) {
    echo $strChannelCompiledLimitationsValid;
}
phpAds_showBreak();

echo "<strong>$strBanners:</strong>";
phpAds_ShowBreak();

$dalBanners = OA_Dal::factoryDAL('banners');
$rsBanners = $dalBanners->getBannersCampaignsClients();
$rsBanners->find();

$allBannersValid = true;
while ($rsBanners->fetch() && $row = $rsBanners->toArray()) {
    if (!MAX_AclValidate('banner-acl.php', array('bannerid' => $row['bannerid']))) {
        $allBannersValid = false;
        $bannerName = (!empty($row['description'])) ? $row['description'] : $strUntitled;
        $campaignName = (!empty($row['campaignname'])) ? $row['campaignname'] : $strUntitled;
        $clientName = (!empty($row['clientname'])) ? $row['clientname'] : $strUntitled;
        echo "{$clientName} -> {$campaignName} -> <a href='banner-acl.php?clientid={$row['clientid']}&campaignid={$row['campaignid']}&bannerid={$row['bannerid']}'>{$bannerName}</a><br />";
    }
}
if ($allBannersValid) {
    echo $strBannerCompiledLimitationsValid;
}

if (!$allBannersValid || !$allChannelsValid) {
    phpAds_ShowBreak();
    echo "<br /><strong>". $strErrorsFound ."</strong><br /><br />";
    echo $strRepairCompiledLimitations;
    echo "<form action='{$_SERVER['PHP_SELF']}' METHOD='GET'>";
    echo "<input type='submit' name='action' value='$strRecompile' />";
    echo "</form>";
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
