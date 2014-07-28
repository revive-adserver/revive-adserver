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
require_once MAX_PATH . '/lib/max/Dal/Delivery.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['SCRIPT_NAME']);
$tabIndex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('affiliateid' => $affiliateid, 'zoneid' => $zoneid);

$aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
$aOtherZones = Admin_DA::getZones(array('publisher_id' => $affiliateid));
MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

function phpAds_showZoneBanners ($zoneId)
{
    $pref = $GLOBALS['_MAX']['PREF'];
    global $phpAds_TextDirection;
    global $strUntitled, $strName, $strID, $strWeight, $strShowBanner;
    global $strCampaignWeight, $strBannerWeight, $strProbability, $phpAds_TextAlignRight, $phpAds_TextAlignLeft;
    global $strRawQueryString, $strZoneProbListChain, $strZoneProbNullPri, $strZoneProbListChainLoop;
    global $strOverrideAds, $strHighAds, $strLowAds, $strECPMAds, $strLimitations, $strCapping, $strNoLimitations, $strPriority;

    MAX_Dal_Delivery_Include();
    $aZoneLinkedAds = OA_Dal_Delivery_getZoneLinkedAds($zoneId);

    if (empty($aZoneLinkedAds['xAds']) && empty($aZoneLinkedAds['ads']) &&  empty($aZoneLinkedAds['lAds']) &&  empty($aZoneLinkedAds['eAds'])) {
        echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
          echo "<tr height='25'><th align='$phpAds_TextAlignLeft' colspan='5'><strong>{$strZoneProbNullPri}</strong></th></tr>";
        echo "</table>";
    } else {
        $usedHighProbability = 0;
        echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
        // Override Advertisements
        if (!empty($aZoneLinkedAds['xAds'])) {
            echo "<tr height='25'><th align='$phpAds_TextAlignLeft' colspan='6'><strong>$strOverrideAds:</strong></th></tr>";
            echo "<tr height='25'>";
            echo "<td height='25' width='40%'>&nbsp;&nbsp;<b>".$strName."</b></td>";
            echo "<td height='25'><b>".$strID."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td height='25'>&nbsp;</td>";
            echo "<td height='25'>&nbsp;</td>";
            echo "<td height='25'><b>$strLimitations</b></td>";
            echo "<td height='25' align='".$phpAds_TextAlignRight."'>&nbsp;</td>";
            echo "</tr>";
            echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            $i = -1;
            foreach($aZoneLinkedAds['xAds'] as $adId => $aLinkedAd) {
                $i++;
                $name = phpAds_getBannerName ($adId, 60, false, true);
                echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>";
                echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                echo "<td height='25'>";
                echo "&nbsp;&nbsp;";
                // Banner icon
                if ($aLinkedAd['type'] == 'html') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'txt') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'url') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
                } else {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
                }
                // Name
                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    echo "<a href='banner-edit.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid=".$aLinkedAd['placement_id']."&bannerid=".$adId."'>".htmlspecialchars($name)."</a>";
                } else {
                    echo htmlspecialchars($name);
                }
                echo "</td>";
                echo "<td height='25'>".$adId."</td>";
                echo "<td height='25'>&nbsp;</td>";
                echo "<td height='25'>&nbsp;</td>";

                $capping = _isAdCapped($aLinkedAd);
                $limitations = _isAdLimited($aLinkedAd);

                echo "<td height='25'>";
                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    $linkStart = "<a href='banner-acl.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid={$aLinkedAd['placement_id']}&bannerid={$aLinkedAd['ad_id']}'>";
                    $linkEnd = "</a>";
                } else {
                    $linkStart = '';
                    $linkEnd = '';
                }
                if (!$capping && !$limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-no-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}<strong>$strNoLimitations</strong>{$linkEnd}";
                } elseif ($limitations && $capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations &amp; $strCapping{$linkEnd}";
                } elseif ($limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations{$linkEnd}";
                } elseif ($capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Capping' align='middle' border='0'>&nbsp;{$linkStart}$strCapping{$linkEnd}";
                }
                echo "</td>";

                // Show banner
                if ($aLinkedAd['type'] == 'txt') {
                    $width    = 300;
                    $height = 200;
                } else {
                    $width  = $aLinkedAd['width'] + 64;
                    $height = $aLinkedAd['bannertext'] ? $aLinkedAd['height'] + 90 : $aLinkedAd['height'] + 64;
                }
                echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
                echo "<img src='" . OX::assetPath() . "/images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;";
                echo "<a href='banner-htmlpreview.php?bannerid=".$adId."' target='_new' ";
                echo "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$adId."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
                echo $strShowBanner."</a>&nbsp;&nbsp;";
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            echo "<tr><td colspan='6'><br /><br /></td></tr>";
        }
        // High-Priority Advertisements
        if (!empty($aZoneLinkedAds['ads'])) {
            echo "<tr height='25'><th align='$phpAds_TextAlignLeft' colspan='6'><strong>$strHighAds:</strong></th></tr>";
            echo "<tr height='25'>";
            echo "<td height='25' width='40%'><b>&nbsp;&nbsp;".$strName."</b></td>";
            echo "<td height='25'><b>".$strID."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
            echo "<td height='25'><b>".$strProbability."</b></td>";
            echo "<td height='25'><b>$strPriority</b></td>";
            echo "<td height='25'><b>$strLimitations</b></td>";
            echo "<td height='25' align='".$phpAds_TextAlignRight."'>&nbsp;</td>";
            echo "</tr>";
            echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            for ($i=10;$i>0;$i--) {
                if (empty($aZoneLinkedAds['ads'][$i])) { continue; }
                foreach($aZoneLinkedAds['ads'][$i] as $adId => $aLinkedAd) {
                $name = phpAds_getBannerName ($adId, 60, false, true);
                echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>";
                echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                echo "<td height='25'>";
                echo "&nbsp;&nbsp;";
                // Banner icon
                if ($aLinkedAd['type'] == 'html') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'txt') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'url') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
                } else {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
                }
                // Name
                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    $isAdMarketAdvertiser = ($aLinkedAd['ext_bannertype'] == 'market-optin-banner');
                    if(!$isAdMarketAdvertiser) {
                        echo "<a href='banner-edit.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid=".$aLinkedAd['placement_id']."&bannerid=".$adId."'>";
                    }
                    echo htmlspecialchars($name);
                    if($isAdMarketAdvertiser) {
                        echo "</a>";
                    }
                }
                echo "</td>";
                echo "<td height='25'>".$adId."</td>";
                // Probability
                $probability = $aLinkedAd['priority'] * 100;
                $usedHighProbability += $aLinkedAd['priority'];
                $exactProbability = ($probability == 0) ? '0.00' : sprintf('%0.64f', $probability);
                $probability = ($probability > 100) ? 100 : $probability;
                echo "<td height='25'><acronym title='{$exactProbability}%'>".number_format($probability, $pref['ui_percentage_decimals'])."%</acronym></td>";

                // Priority
                echo "<td height='25'>{$aLinkedAd['campaign_priority']}/10</td>";

                $capping = _isAdCapped($aLinkedAd);
                $limitations = _isAdLimited($aLinkedAd);

                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    $linkStart = "<a href='banner-acl.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid={$aLinkedAd['placement_id']}&bannerid={$aLinkedAd['ad_id']}'>";
                    $linkEnd = "</a>";
                } else {
                    $linkStart = '';
                    $linkEnd = '';
                }

                echo "<td height='25'>";
                if (!$capping && !$limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-no-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strNoLimitations{$linkEnd}";
                } elseif ($limitations && $capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations &amp; $strCapping{$linkEnd}";
                } elseif ($limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations{$linkEnd}";
                } elseif ($capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Capping' align='middle' border='0'>&nbsp;{$linkStart}$strCapping{$linkEnd}";
                }
                echo "</td>";

                // Show banner
                if ($aLinkedAd['type'] == 'txt') {
                    $width    = 300;
                    $height = 200;
                } else {
                    $width  = $aLinkedAd['width'] + 64;
                    $height = $aLinkedAd['bannertext'] ? $aLinkedAd['height'] + 90 : $aLinkedAd['height'] + 64;
                }
                echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
                echo "<img src='" . OX::assetPath() . "/images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;";
                echo "<a href='banner-htmlpreview.php?bannerid=".$adId."' target='_new' ";
                echo "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$adId."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
                echo $strShowBanner."</a>&nbsp;&nbsp;";
                echo "</td>";
                echo "</tr>";
                }
            }
            echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            echo "<tr><td colspan='6'><br /><br /></td></tr>";
        }
        // eCPM Advertisements
        if (!empty($aZoneLinkedAds['eAds'])) {
            echo "<tr height='25'><th align='$phpAds_TextAlignLeft' colspan='6'><strong>$strECPMAds:</strong></th></tr>";
            echo "<tr height='25'>";
            echo "<td height='25' width='40%'><b>&nbsp;&nbsp;".$strName."</b></td>";
            echo "<td height='25'><b>".$strID."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
            echo "<td height='25'><b>".$strProbability."</b></td>";
            echo "<td height='25'><b>$strLimitations</b></td>";
            echo "<td height='25' align='".$phpAds_TextAlignRight."'>&nbsp;</td>";
            echo "</tr>";
            echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";

            $do = OA_Dal::factoryDO('Campaigns');
            foreach($aZoneLinkedAds['eAds'][DataObjects_Campaigns::PRIORITY_ECPM] as $adId => $aLinkedAd) {
                $name = phpAds_getBannerName ($adId, 60, false, true);
                echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>";
                echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                echo "<td height='25'>";
                echo "&nbsp;&nbsp;";
                // Banner icon
                if ($aLinkedAd['type'] == 'html') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'txt') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'url') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
                } else {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
                }
                // Name
                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    echo "<a href='banner-edit.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid=".$aLinkedAd['placement_id']."&bannerid=".$adId."'>".htmlspecialchars($name)."</a>";
                } else {
                    echo htmlspecialchars($name);
                }
                echo "</td>";
                echo "<td height='25'>".$adId."</td>";
                // Probability
                $probability = $aLinkedAd['priority'] * 100;
                $usedHighProbability += $aLinkedAd['priority'];
                $exactProbability = ($probability == 0) ? '0.00' : sprintf('%0.64f', $probability);
                echo "<td height='25'><acronym title='{$exactProbability}%'>".number_format($probability, $pref['ui_percentage_decimals'])."%</acronym></td>";

                $capping = _isAdCapped($aLinkedAd);
                $limitations = _isAdLimited($aLinkedAd);

                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    $linkStart = "<a href='banner-acl.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid={$aLinkedAd['placement_id']}&bannerid={$aLinkedAd['ad_id']}'>";
                    $linkEnd = "</a>";
                } else {
                    $linkStart = '';
                    $linkEnd = '';
                }

                echo "<td height='25'>";
                if (!$capping && !$limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-no-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strNoLimitations{$linkEnd}";
                } elseif ($limitations && $capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations &amp; $strCapping{$linkEnd}";
                } elseif ($limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations{$linkEnd}";
                } elseif ($capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Capping' align='middle' border='0'>&nbsp;{$linkStart}$strCapping{$linkEnd}";
                }
                echo "</td>";

                // Show banner
                if ($aLinkedAd['type'] == 'txt') {
                    $width    = 300;
                    $height = 200;
                } else {
                    $width  = $aLinkedAd['width'] + 64;
                    $height = $aLinkedAd['bannertext'] ? $aLinkedAd['height'] + 90 : $aLinkedAd['height'] + 64;
                }
                echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
                echo "<img src='" . OX::assetPath() . "/images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;";
                echo "<a href='banner-htmlpreview.php?bannerid=".$adId."' target='_new' ";
                echo "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$adId."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
                echo $strShowBanner."</a>&nbsp;&nbsp;";
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            echo "<tr><td colspan='5'><br /><br /></td></tr>";
        }
        // Low-Priority Advertisements
        if (!empty($aZoneLinkedAds['lAds'])) {
            echo "<tr height='25'><th align='$phpAds_TextAlignLeft' colspan='6'><strong>$strLowAds:</strong></th></tr>";
            echo "<tr height='25'>";
            echo "<td height='25' width='40%'><b>&nbsp;&nbsp;".$strName."</b></td>";
            echo "<td height='25'><b>".$strID."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
            echo "<td height='25'><b>".$strProbability."</b></td>";
            echo "<td height='25'><b>$strWeight</b></td>";
            echo "<td height='25'><b>$strLimitations</b></td>";
            echo "<td height='25' align='".$phpAds_TextAlignRight."'>&nbsp;</td>";
            echo "</tr>";
            echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            $ofPriority = (1 - $usedHighProbability) * 100;
            if ($ofPriority < 0) $ofPriority = 0;

            foreach($aZoneLinkedAds['lAds'] as $adId => $aLinkedAd) {
                $name = phpAds_getBannerName ($adId, 60, false, true);
                echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>";
                echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                echo "<td height='25'>";
                echo "&nbsp;&nbsp;";
                // Banner icon
                if ($aLinkedAd['type'] == 'html') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'txt') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-text.gif' align='absmiddle'>&nbsp;";
                } elseif ($aLinkedAd['type'] == 'url') {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
                } else {
                    echo "<img src='" . OX::assetPath() . "/images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
                }
                // Name
                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    echo "<a href='banner-edit.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid=".$aLinkedAd['placement_id']."&bannerid=".$adId."'>".htmlspecialchars($name)."</a>";
                } else {
                    echo htmlspecialchars($name);
                }
                echo "</td>";
                echo "<td height='25'>".$adId."</td>";
                // Probability
                $probability = $aLinkedAd['priority'] / $aZoneLinkedAds['priority']['lAds'] * 100;
                $realProbability = $probability * $ofPriority / 100;
                $exactProbability = sprintf("%0.64f", $realProbability);
                echo "<td height='25'><acronym title='{$exactProbability}'>".number_format($realProbability, $pref['ui_percentage_decimals'])."%</acronym> (".number_format($probability, $pref['ui_percentage_decimals'])."% of ".number_format($ofPriority, $pref['ui_percentage_decimals'])."%)</td>";

                // Weight
                $weight = $aLinkedAd['campaign_weight']*$aLinkedAd['weight'];
                echo "<td height='25'>{$weight}</td>";

                // Limitations
                $capping = _isAdCapped($aLinkedAd);
                $limitations = _isAdLimited($aLinkedAd);

                if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    $linkStart = "<a href='banner-acl.php?clientid=".phpAds_getCampaignParentClientID($aLinkedAd['placement_id'])."&campaignid={$aLinkedAd['placement_id']}&bannerid={$aLinkedAd['ad_id']}'>";
                    $linkEnd = "</a>";
                } else {
                    $linkStart = '';
                    $linkEnd = '';
                }

                echo "<td height='25'>";
                if (!$capping && !$limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-no-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strNoLimitations{$linkEnd}";
                } elseif ($limitations && $capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations &amp; $strCapping{$linkEnd}";
                } elseif ($limitations) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Limitations' align='middle' border='0'>&nbsp;{$linkStart}$strLimitations{$linkEnd}";
                } elseif ($capping) {
                    echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' alt='Capping' align='middle' border='0'>&nbsp;{$linkStart}$strCapping{$linkEnd}";
                }
                echo "</td>";

                // Show banner
                if ($aLinkedAd['type'] == 'txt') {
                    $width    = 300;
                    $height = 200;
                } else {
                    $width  = $aLinkedAd['width'] + 64;
                    $height = $aLinkedAd['bannertext'] ? $aLinkedAd['height'] + 90 : $aLinkedAd['height'] + 64;
                }
                echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
                echo "<img src='" . OX::assetPath() . "/images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;";
                echo "<a href='banner-htmlpreview.php?bannerid=".$adId."' target='_new' ";
                echo "onClick=\"return openWindow('banner-htmlpreview.php?bannerid=".$adId."', '', 'status=no,scrollbars=no,resizable=no,width=".$width.",height=".$height."');\">";
                echo $strShowBanner."</a>&nbsp;&nbsp;";
                echo "</td>";
                echo "</tr>";
            }
            echo "<tr height='1'><td colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        }
        echo "</table>";
        echo "<br /><br />";
    }

}

function _isAdCapped($aAd)
{
    return (
        empty($aAd['block_ad']) &&
        empty($aAd['block_campaign']) &&
        empty($aAd['cap_ad']) &&
        empty($aAd['cap_campaign']) &&
        empty($aAd['session_cap_ad']) &&
        empty($aAd['session_cap_campaign'])
    ) ? false : true;
}

function _isAdLimited($aAd)
{
    return ($aAd['compiledlimitation'] == '' or $aAd['compiledlimitation'] == 'true') ? false : true;
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (isset($zoneid) && $zoneid != '') {
    phpAds_showZoneBanners($zoneid);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();
