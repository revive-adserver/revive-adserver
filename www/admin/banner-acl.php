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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/other/capping/lib-capping.inc.php';

// Register input variables
phpAds_registerGlobalUnslashed('acl', 'action', 'submit');

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

// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabindex = 1;
$aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid, 'bannerid' => $bannerid);

if (!empty($action)) {
    $acl = MAX_AclAdjust($acl, $action);
} elseif (!empty($submit)) {
    $acl = (isset($acl)) ? $acl : array();

    // Only save when inputs are valid
    if (OX_AclCheckInputsFields($acl, $pageName) === true) {
        $aBannerPrev = MAX_cacheGetAd($bannerid, false);
        MAX_AclSave($acl, $aEntities);

        $block = _initCappingVariables($time, $cap, $session_capping);

        $values = array();
        $acls_updated = false;
        $now = OA::getNow();

        if ($aBannerPrev['block_ad'] <> $block) {
            $values['block'] = $block;
            $acls_updated = ($block == 0) ? true : $acls_updated;
        }
        if ($aBannerPrev['cap_ad'] <> $cap) {
            $values['capping'] = $cap;
            $acls_updated = ($cap == 0) ? true : $acls_updated;
        }
        if ($aBannerPrev['session_cap_ad'] <> $session_capping) {
            $values['session_capping'] = $session_capping;
            $acls_updated = ($session_capping == 0) ? true : $acls_updated;
        }
        if ($acls_updated) {
            $values['acls_updated'] = $now;
        }

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($bannerid);
        if (!empty($values)) {
            $values['updated'] = $now;
            $doBanners->setFrom($values);
            $doBanners->update();
				}

        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate ( $GLOBALS['strBannerAclHasBeenUpdated'], array(
            MAX::constructURL(MAX_URL_ADMIN, 'banner-edit.php?clientid=' .  $clientid . '&campaignid=' . $campaignid . '&bannerid=' . $bannerid),
            htmlspecialchars($doBanners->description)
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        header("Location: banner-acl.php?clientid={$clientid}&campaignid={$campaignid}&bannerid={$bannerid}");
        exit;
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
$entityId = OA_Permission::getEntityId();
if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    $entityType = 'advertiser_id';
} else {
    $entityType = 'agency_id';
}

// Display navigation
$aOtherCampaigns = Admin_DA::getPlacements(array($entityType => $entityId));
$aOtherBanners = Admin_DA::getAds(array('placement_id' => $campaignid), false);
// Setup a fake record for the "Apply to all" entry
$aOtherBanners[-1] = array('name' => '--' . $GLOBALS['strAllBannersInCampaign'] . '--', 'ad_id' => -1, 'placement_id' => $campaignid);
MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$aBanner = MAX_cacheGetAd($bannerid, false);

if (!isset($acl)) {
    $acl = Admin_DA::getDeliveryLimitations(array('ad_id' => $bannerid));
    // This array needs to be sorted by executionorder, this should ideally be done in SQL
    // When we move to DataObject this should be addressed
    ksort($acl);
}

$aParams = array('clientid' => $clientid, 'campaignid' => $campaignid, 'bannerid' => $bannerid);

MAX_displayAcls($acl, $aParams);

echo "
<table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>";

$aParams = array(
    'title' => $GLOBALS['strCampaign'],
    'titleLink' => "campaign-edit.php?clientid=$clientid&campaignid=$campaignid",
    'aText' => $GLOBALS['strCappingCampaign'],
    'aCappedObject' => $aBanner,
    'type' => 'Campaign'
);

$tabindex = _echoDeliveryCappingHtml($tabindex, $GLOBALS['strCappingBanner'], $aBanner, 'Ad', $aParams);

echo "
<tr><td height='1' colspan='6' bgcolor='#888888'>
<img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>

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
