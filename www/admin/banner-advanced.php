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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Dal.php';

// Register input variables
phpAds_registerGlobalUnslashed('prepend', 'append', 'submitbutton');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);
OA_Permission::enforceAccessToObject('banners',   $bannerid);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid] = $campaignid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submitbutton)) {
    OA_Permission::checkSessionToken();

    // Update banner
    $doBanners = OA_Dal::factoryDO('banners');
    $doBanners->get($bannerid);
    $doBanners->prepend = $prepend;
    $doBanners->append  = $append;
    $doBanners->update();

    // Queue confirmation message
    $translation = new OX_Translation();
    $translated_message = $translation->translate($GLOBALS['strBannerAdvancedHasBeenUpdated'], array(
        MAX::constructURL(MAX_URL_ADMIN, 'banner-edit.php?clientid=' .  $clientid . '&campaignid=' . $campaignid . '&bannerid=' . $bannerid),
        htmlspecialchars($doBanners->description)
    ));

    OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

    header ("Location: banner-advanced.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid);
    exit;
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabindex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid, 'bannerid' => $bannerid);

// Display navigation
$aOtherCampaigns = Admin_DA::getPlacements(array('agency_id' => $agencyId));
$aOtherBanners = Admin_DA::getAds(array('placement_id' => $campaignid), false);
MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doBanners = OA_Dal::factoryDO('banners');
$doBanners->selectAdd('storagetype AS type');
$doBanners->bannerid = $bannerid;
if ($doBanners->find(true)) {
    $banner = $doBanners->toArray();
}

$tabindex = 1;

    echo "<form name='appendform' method='post' action='banner-advanced.php' onSubmit='return phpAds_formSubmit() && max_formValidate(this);'>";
    echo "<input type='hidden' name='clientid' value='".(isset($clientid) && $clientid != '' ? $clientid : '')."'>";
    echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) && $campaignid != '' ? $campaignid : '')."'>";
    echo "<input type='hidden' name='bannerid' value='".(isset($bannerid) && $bannerid != '' ? $bannerid : '')."'>";
    echo "<input type='hidden' name='token' value='".htmlspecialchars(phpAds_SessionGetToken(), ENT_QUOTES)."'>";

    echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><td height='25' colspan='3'><b>".$strAppendSettings."</b></td></tr>";
    echo "<tr height='1'><td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
    echo "<td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
    echo "<td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strBannerPrependHTML."</td><td>";
    echo "<textarea class='code' name='prepend' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($banner['prepend'])."</textarea>";
    echo "</td></tr>";

    echo "<tr><td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
    echo "<td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strBannerAppendHTML."</td><td>";
    echo "<textarea class='code' name='append' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($banner['append'])."</textarea>";
    echo "</td></tr>";

    // Footer
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    echo "</table><br />";

    echo "<br /><input type='submit' name='submitbutton' value='".$strSaveChanges."' tabindex='".($tabindex++)."'>";
    echo "</form>";

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>