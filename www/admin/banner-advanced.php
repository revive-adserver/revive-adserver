<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-append.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

// Load plugins
$invPlugins = &MAX_Plugin::getPlugins('inventoryProperties');
foreach($invPlugins as $pluginKey => $plugin) {
    if ($plugin->getType() != 'banner-advanced') {
        unset($invPlugins[$pluginKey]);
    }
}

// Register input variables
phpAds_registerGlobalUnslashed('append', 'submitbutton', 'appendtype', 'appendid', 'appenddelivery', 'appendsave');

// Register input variables for plugins
foreach ($invPlugins as $plugin) {
    call_user_func_array('phpAds_registerGlobal', $plugin->getGlobalVars());
}


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid);
OA_Permission::enforceAccessToObject('banners',   $bannerid);


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submitbutton)) {
    if (isset($bannerid) && $bannerid != '') {
        $sqlupdate = array();
        // Do not save append until not finished with appending, if present
        if (isset($appendsave) && $appendsave) {
            // Determine append type
            if (!isset($append)) $append = '';
            if (!isset($appendtype)) $appendtype = phpAds_ZoneAppendZone;
            if (!isset($appenddelivery)) $appenddelivery = phpAds_ZonePopup;

            // Generate invocation code
            if ($appendtype == phpAds_ZoneAppendZone) {
                $what = 'zone:'.(isset($appendid) ? $appendid : 0);

                if ($appenddelivery == phpAds_ZonePopup) {
                    $codetype = 'popup';
                } else {
                    $codetype = 'adlayer';
                    if (!isset($layerstyle)) $layerstyle = 'geocities';
                    include_once MAX_PATH . '/lib/max/layerstyles/'.$layerstyle.'/invocation.inc.php';
                }
                $maxInvocation = new MAX_Admin_Invocation();
                $invocationCode = $maxInvocation->generateInvocationCode($invocationTag = null);
                $append = addslashes($invocationCode);
            }

            // Update banner
            $sqlupdate['append'] = $append;
            $sqlupdate['appendtype'] = $appendtype;

            // Add variables from plugins
            foreach ($invPlugins as $plugin) {
                foreach ($plugin->prepareVariables() as $k => $v) {
                    $sqlupdate[$k] = $v;
                }
            }

            $doBanners = OA_Dal::factoryDO('banners');
            $doBanners->get($bannerid);
            $doBanners->setFrom($sqlupdate);
            $doBanners->update();
        }

        // Do not redirect until not finished with zone appending, if present
        if (!isset($appendsave) || $appendsave) {
            header ("Location: banner-advanced.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid);
            exit;
        }
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
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

if ($banner['type'] != 'txt' || count($invPlugins)){
    // Header
    echo "<form name='appendform' method='post' action='banner-advanced.php' onSubmit='return phpAds_formSubmit() && max_formValidate(this);'>";
    echo "<input type='hidden' name='clientid' value='".(isset($clientid) && $clientid != '' ? $clientid : '')."'>";
    echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) && $campaignid != '' ? $campaignid : '')."'>";
    echo "<input type='hidden' name='bannerid' value='".(isset($bannerid) && $bannerid != '' ? $bannerid : '')."'>";
}

if ($banner['type'] != 'txt') {
    echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><td height='25' colspan='3'><b>".$strAppendSettings."</b></td></tr>";
    echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
    echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
    echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    // Get available zones
    $available = array();

    // Get list of public publishers
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $doAffiliates->publiczones = 't';
    $doAffiliates->find();
    while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
        $available[] = "affiliateid = '{$row['affiliateid']}'";
    }
    $available = implode ($available, ' OR ');

    // Get public zones
    $doZones = OA_Dal::factoryDO('zones');
    $doZones->selectAdd();
    $doZones->selectAdd('zoneid, zonename, delivery');
    $doZones->whereAdd('delivery = ' . phpAds_ZonePopup);
    $doZones->whereAdd('delivery = ' . phpAds_ZoneInterstitial, 'OR');
    $available ? $doZones->whereAdd($available) : null;
    $doZones->orderBy('zoneid');
    $doZones->find();

    $available = array(phpAds_ZonePopup => array(), phpAds_ZoneInterstitial => array());
    while ($doZones->fetch() && $row = $doZones->toArray()) {
        $available[$row['delivery']][$row['zoneid']] = phpAds_buildZoneName($row['zoneid'], $row['zonename']);
    }

    // Determine appendtype
    if (isset($appendtype)) {
        $banner['appendtype'] = $appendtype;
    }

    // Appendtype choices
    echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$GLOBALS['strZoneAppendType']."</td><td>";
    echo "<select name='appendtype' style='width: 200;' onchange='phpAds_formSelectAppendType()' tabindex='".($tabindex++)."'>";
    echo "<option value='".phpAds_ZoneAppendRaw."'".($banner['appendtype'] == phpAds_ZoneAppendRaw ? ' selected' : '').">".$GLOBALS['strZoneAppendHTMLCode']."</option>";

    if (count($available[phpAds_ZonePopup]) || count($available[phpAds_ZoneInterstitial])) {
        echo "<option value='".phpAds_ZoneAppendZone."'".($banner['appendtype'] == phpAds_ZoneAppendZone ? ' selected' : '').">".$GLOBALS['strZoneAppendZoneSelection']."</option>";
    } else {
        $banner['appendtype'] = phpAds_ZoneAppendRaw;
    }
    echo "</select></td></tr>";

    // Line
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    if ($banner['appendtype'] == phpAds_ZoneAppendZone) {
        // Append zones
        // Read info from invocation code
        if (!isset($appendid) || empty($appendid)) {
            $appendvars = phpAds_ParseAppendCode($banner['append']);

            $appendid         = $appendvars[0]['zoneid'];
            $appenddelivery = $appendvars[0]['delivery'];

            if ($appenddelivery == phpAds_ZonePopup && !count($available[phpAds_ZonePopup])) {
                $appenddelivery = phpAds_ZoneInterstitial;
            } elseif ($appenddelivery == phpAds_ZoneInterstitial && !count($available[phpAds_ZoneInterstitial])) {
                $appenddelivery = phpAds_ZonePopup;
            } else {
                // Add globals for lib-invocation
                foreach ($appendvars[1] as $k => $v) {
                    if ($k != 'n' && $k != 'what') {
                        $GLOBALS[$k] = addslashes($v);
                    }
                }
            }
        }

        // Header
        echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$GLOBALS['strZoneAppendSelectZone']."</td><td>";
        echo "<input type='hidden' name='appendsave' value='1'>";
        echo "<input type='hidden' name='appendid' value='".$appendid."'>";
        echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>";

        // Popup
        echo "<tr><td><input type='radio' id='appenddelivery' name='appenddelivery' value='".phpAds_ZonePopup."'";
        echo (count($available[phpAds_ZonePopup]) ? ' onClick="phpAds_formSelectAppendDelivery(0)"' : ' DISABLED');
        echo ($appenddelivery == phpAds_ZonePopup ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td><td>";
        echo $GLOBALS['strPopup'].":</td></tr>";
        echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

        if (count($available[phpAds_ZonePopup])) {
            echo "<img src='images/icon-popup.gif' align='top'>";
        } else {
            echo "<img src='images/icon-popup-d.gif' align='top'>";
        }

        echo "&nbsp;&nbsp;<select name='appendpopup' style='width: 200;' ";
        echo "onchange='phpAds_formSelectAppendZone(0)'";
        echo (count($available[phpAds_ZonePopup]) ? '' : ' DISABLED')." tabindex='".($tabindex++)."'>";

        foreach ($available[phpAds_Zone] as $k => $v) {
            if ($appendid == $k) {
                echo "<option value='".$k."' selected>".$v."</option>";
            } else {
                echo "<option value='".$k."'>".$v."</option>";
            }
        }
        echo "</select></td></tr>";

        // Interstitial
        echo "<tr><td><input type='radio' id='appenddelivery' name='appenddelivery' value='".phpAds_ZoneInterstitial."'";
        echo (count($available[phpAds_ZoneInterstitial]) ? ' onClick="phpAds_formSelectAppendDelivery(1)"' : ' DISABLED');
        echo ($appenddelivery == phpAds_ZoneInterstitial ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td><td>";
        echo $GLOBALS['strInterstitial'].":</td></tr>";
        echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

        if (count($available[phpAds_ZoneInterstitial])) {
            echo "<img src='images/icon-interstitial.gif' align='top'>";
        } else {
            echo "<img src='images/icon-interstitial-d.gif' align='top'>";
        }
        echo "&nbsp;&nbsp;<select name='appendinterstitial' style='width: 200;' ";
        echo "onchange='phpAds_formSelectAppendZone(1)'";
        echo (count($available[phpAds_ZoneInterstitial]) ? '' : ' DISABLED')." tabindex='".($tabindex++)."'>";

        foreach ($available[phpAds_ZoneInterstitial] as $k => $v) {
            if ($appendid == $k) {
                echo "<option value='".$k."' selected>".$v."</option>";
            } else {
                echo "<option value='".$k."'>".$v."</option>";
            }
        }
        echo "</select></td></tr>";

        // Line
        echo "</table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        // It shouldn't be necessary to load zone attributes from db
        $extra = array(
            'what' => '',
            //'width' => $zone['width'],
            //'height' => $zone['height'],
            'delivery' => $appenddelivery,
            //'website' => $affiliate['website'],
            'zoneadvanced' => true
        );

        // Invocation options
        $codetype = $appenddelivery == 'popup' ? 'popup' : 'adlayer';
        $maxInvocation = new MAX_Admin_Invocation();
        echo $maxInvocation->placeInvocationForm($extra, true);
        echo "</td></tr>";
    } else {
        // Regular HTML append
        echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppend."</td><td>";
        echo "<input type='hidden' name='appendsave' value='1'>";
        echo "<textarea class='code' name='append' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($banner['append'])."</textarea>";
        echo "</td></tr>";
    }

    // Footer
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
    echo "</table><br />";
} else {
    echo "<br /><br /><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
    echo $strAppendTextAdNotPossible;
    echo "</div>";
    echo "<input type='hidden' name='append' value=''>";
    echo "<input type='hidden' name='appendtype' value='".phpAds_ZoneAppendRaw."'>";
    echo "<input type='hidden' name='appendsave' value='1'>";
}

// Display plugin properties
foreach ($invPlugins as $plugin) {
    $plugin->display($tabindex, $banner);
}

if ($banner['type'] != 'txt' || count($invPlugins)){
    echo "<br /><input type='submit' name='submitbutton' value='".$strSaveChanges."' tabindex='".($tabindex++)."'>";
    echo "</form>";
}

/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

?>

<script language='JavaScript'>
<!--

    function phpAds_formSelectAppendType()
    {
        if (document.appendform.appendid) {
            document.appendform.appendid.value = '-1';
        }
        document.appendform.appendsave.value = '0';
        document.appendform.submit();
    }

    function phpAds_formSelectAppendDelivery(type)
    {
        document.appendform.appendid.value = '-1';
        document.appendform.appendsave.value = '0';
        document.appendform.submit();
    }

    function phpAds_formSelectAppendZone(type)
    {
        var x;

        if (document.appendform.appenddelivery[type] && !document.appendform.appenddelivery[type].checked) {
            document.appendform.appendid.value = '-1';
            document.appendform.appendsave.value = '0';
            document.appendform.submit();
        }
    }

    function phpAds_formSubmit()
    {
        if (document.appendform.appenddelivery) {
            if (document.appendform.appenddelivery[0].checked) {
                x = document.appendform.appendpopup;
            } else {
                x = document.appendform.appendinterstitial;
            }
            document.appendform.appendid.value = x.options[x.selectedIndex].value;
        }
        return true;
    }
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>