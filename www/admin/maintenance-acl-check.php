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
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';


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
OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('maintenance'));

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
    echo "<form action='' METHOD='GET'>";
    echo "<input type='submit' name='action' value='$strRecompile' />";
    echo "</form>";
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
