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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/other/capping/lib-capping.inc.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-append.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal (
     'append'
    ,'appenddelivery'
    ,'forceappend'
    ,'inventory_forecast_type'
    ,'inventory_forecast_type_channel'
    ,'appendid'
    ,'appendsave'
    ,'appendtype'
    ,'chaintype'
    ,'chainwhat'
    ,'chainzone'
    ,'prepend'
    ,'submitbutton'
);


/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid);

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    OA_Permission::enforceAllowed(OA_PERM_ZONE_EDIT);
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submitbutton))
{
    if (!empty($zoneid))
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneid);

        // Determine chain
        if ($chaintype == '1' && $chainzone != '') {
            $chain = 'zone:'.$chainzone;
        } elseif ($chaintype == '2' && $chainwhat != '') {
            $chain = $chainwhat;
        } else {
            $chain = '';
        }
        $doZones->chain = $chain;

        if (!isset($prepend)) $prepend = '';
        $prepend = MAX_commonGetValueUnslashed('prepend');
        $doZones->prepend = $prepend;

        // Do not save append until not finished with zone appending, if present
        if (!empty($appendsave))
        {
            if (!isset($append)) $append = '';
            if (!isset($appendtype)) $appendtype = phpAds_ZoneAppendZone;
            if (!isset($appenddelivery)) $appenddelivery = phpAds_ZonePopup;
            if ($appendtype == phpAds_ZoneAppendZone)
            {
                $what = 'zone:'.(isset($appendid) ? $appendid : 0);

                if ($appenddelivery == phpAds_ZonePopup)
                    $codetype = 'popup';
                else
                {
                    $codetype = 'adlayer';
                    if (!isset($layerstyle)) $layerstyle = 'geocities';
                    include ('../libraries/layerstyles/'.$layerstyle.'/invocation.inc.php');
                }
                $maxInvocation = new MAX_Admin_Invocation();
                $invocationCode = $maxInvocation->generateInvocationCode($invocationTag = null);
                $append = $invocationCode;
                //Temporary fix - allow {source} for popup tags...
                $append = str_replace('%7Bsource%7D', '{source}', $append);
            } else {
                $append = MAX_commonGetValueUnslashed('append');
            }

            $doZones->append = $append;
            $doZones->appendtype = $appendtype;
        }

        if (isset($forceappend)) {
            $doZones->forceappend = $forceappend;
        }

        $inventory_forecast_type = 0;
        if (isset($inventory_forecast_type_channel)) $inventory_forecast_type += $inventory_forecast_type_channel;
        if (isset($inventory_forecast_type)) {
            $doZones->inventory_forecast_type = $inventory_forecast_type;
        }

		$block = _initCappingVariables($time, $cap, $session_capping);

		$doZones->block = $block;
		$doZones->capping = $cap;
		$doZones->session_capping = $session_capping;
		$doZones->update();

        // Rebuild Cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete('what=zone:'.$zoneid);

        // Do not redirect until not finished with zone appending, if present
        if (!empty($appendsave)) {
            if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
                if (OA_Permission::hasPermission(OA_PERM_ZONE_LINK)) {
                    MAX_Admin_Redirect::redirect('zone-include.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid);
                } else {
                    MAX_Admin_Redirect::redirect('zone-probability.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid);
                }
            } else {
                MAX_Admin_Redirect::redirect('zone-include.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid);
            }
        }
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabIndex = 1;
$agencyId = OA_Permission::getAgencyId();
$aEntities = array('affiliateid' => $affiliateid, 'zoneid' => $zoneid);

$aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
$aOtherZones = Admin_DA::getZones(array('publisher_id' => $affiliateid));
MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doZones = OA_Dal::factoryDO('zones');
if ($doZones->get($zoneid)) {
    $zone = $doZones->toArray();
}

$tabindex = 1;

if (ereg("^zone:([0-9]+)$", $zone['chain'], $regs))
    $chainzone = $regs[1];
else
    $chainzone = '';


echo "
<form name='zoneform' method='post' action='zone-advanced.php' onSubmit='return phpAds_formZoneAdvSubmit() && max_formValidate(this);'>
<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>
<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>
<br />
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<tr>
    <td>
        <table cellpadding='0' cellspacing='0' border='0' width='100%'>
        <tr height='25'>
            <td colspan='3'><b>$strChainSettings</b></td>
        </tr>
        <tr height='1'>
            <td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>
            <td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>
            <td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
        </tr>
        <tr height='10'>
            <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td width='30' valign='top'>&nbsp;</td>
            <td width='200' valign='top'>$strZoneNoDelivery</td>
            <td width='370'><input type='radio' id='chaintype-s' name='chaintype' value='0'".($zone['chain'] == '' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;<label for='chaintype-s'>$strZoneStopDelivery</label><br /><input type='radio' id='chaintype-z' name='chaintype' value='1'".($zone['chain'] != '' && $chainzone != '' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;<label for='chaintype-z'>$strZoneOtherZone</label><br /><br />";

if ($zone['delivery'] == phpAds_ZoneBanner) echo "<img src='" . OX::assetPath() . "/images/icon-zone.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZoneInterstitial) echo "<img src='" . OX::assetPath() . "/images/icon-interstitial.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZonePopup) echo "<img src='" . OX::assetPath() . "/images/icon-popup.gif' align='top'>";
if ($zone['delivery'] == phpAds_ZoneText) echo "<img src='" . OX::assetPath() . "/images/icon-textzone.gif' align='top'>";

echo "&nbsp;&nbsp;<select name='chainzone' style='width: 200;' onchange='phpAds_formSelectZone()' tabindex='".($tabindex++)."'>";

    // Get list of zones to link to
    $doZones = OA_Dal::factoryDO('zones');

    $allowothersizes = $zone['delivery'] == phpAds_ZoneInterstitial || $zone['delivery'] == phpAds_ZonePopup;
    if ($zone['width'] != -1 && !$allowothersizes) {
        $doZones->width = $zone['width'];
    }
    if ($zone['height'] != -1 && !$allowothersizes) {
        $doZones->height = $zone['height'];
    }
    $doZones->delivery = $zone['delivery'];
    $doZones->whereAdd('zoneid <> '.$zoneid);
    // Limit the list of zones to the appropriate list
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = OA_Permission::getAgencyId();
        $doZones->joinAdd($doAffiliates);
    } else {
        $doZones->whereAdd('affiliateid = ' . $affiliateid);
    }
    $doZones->find();

    while ($doZones->fetch() && $row = $doZones->toArray())
        if ($chainzone == $row['zoneid'])
            echo "<option value='".$row['zoneid']."' selected>".phpAds_buildZoneName($row['zoneid'], $row['zonename'])."</option>";
        else
            echo "<option value='".$row['zoneid']."'>".phpAds_buildZoneName($row['zoneid'], $row['zonename'])."</option>";

echo "</select></td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>
        </table>
    </td>
</tr>";

echo "
<tr>
<td>
<table cellpadding='0' cellspacing='0' border='0' width='100%'>";
$tabindex = _echoDeliveryCappingHtml($tabindex, $GLOBALS['strCappingZone'], $zone);
echo "</table>
    </td>
</tr>";

echo "
<tr>
    <td>
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr height='25'>
            <td colspan='3'><b>$strZoneForecasting</b></td>
        </tr>
        <tr height='1'>
            <td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>
            <td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>
            <td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
        </tr>
        <tr height='10'>
            <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200'>$strInventoryForecasting</td>
            <td width='100%'>
                <input type='checkbox' id='inventory_forecast_type_channel' name='inventory_forecast_type_channel' value='8'".($zone['inventory_forecast_type'] & 8 ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;$strChannel<br />
            </td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>
        </table>
    </td>
</tr>
";
if ($zone['delivery'] == phpAds_ZoneBanner)
{
    echo "
<tr>
    <td>
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr height='25'>
            <td colspan='3'><b>$strAppendSettings</b></td>
        </tr>
        <tr height='1'>
            <td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>
            <td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>
            <td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
        </tr>
        <tr height='10'>
            <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200'>$strZoneAppendNoBanner</td>
            <td width='100%'><input type='radio' id='forceappend-y' name='forceappend' value='t'".($zone['forceappend'] == 't' ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;<label for='forceappend-y'>{$GLOBALS['strYes']}</label><br /><input type='radio' id='forceappend-n' name='forceappend' value='f'".((!isset($zone['forceappend']) || $zone['forceappend'] == 'f') ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;<label for='forceappend-n'>{$GLOBALS['strNo']}</label></td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>";

        // Get available zones
        $available = array();

        // Get list of zones to link to
        $doZones = OA_Dal::factoryDO('zones');

        $allowothersizes = $zone['delivery'] == phpAds_ZoneInterstitial || $zone['delivery'] == phpAds_ZonePopup;
        if ($zone['width'] != -1 && !$allowothersizes) {
            $doZones->width = $zone['width'];
        }
        if ($zone['height'] != -1 && !$allowothersizes) {
            $doZones->height = $zone['height'];
        }
        $doZones->delivery = $zone['delivery'];
        $doZones->whereAdd('zoneid <> '.$zoneid);
        $doZones->find();

        $available = array(phpAds_ZonePopup => array(), phpAds_ZoneInterstitial => array());
        while ($doZones->fetch() && $row = $doZones->toArray())
            $available[$row['delivery']][$row['zoneid']] = phpAds_buildZoneName($row['zoneid'], $row['zonename']);


        // Determine appendtype
        if (isset($appendtype)) $zone['appendtype'] = $appendtype;

    // Appendtype choices
    echo "
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200' valign='top'> {$GLOBALS['strZoneAppendType']}</td>
            <td>
                <select name='appendtype' style='width: 200;' onchange='phpAds_formSelectAppendType()' tabindex='".($tabindex++)."'>
                <option value='".phpAds_ZoneAppendRaw."'".($zone['appendtype'] == phpAds_ZoneAppendRaw ? ' selected' : '').">{$GLOBALS['strZoneAppendHTMLCode']}</option>";

        if (count($available[phpAds_ZonePopup]) || count($available[phpAds_ZoneInterstitial]))
            echo "
                <option value='".phpAds_ZoneAppendZone."'".($zone['appendtype'] == phpAds_ZoneAppendZone ? ' selected' : '').">{$GLOBALS['strZoneAppendZoneSelection']}</option>";
        else
            $zone['appendtype'] = phpAds_ZoneAppendRaw;

    echo "
                </select>
            </td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>
        <tr height='1'>
            <td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>";

    if ($zone['appendtype'] == phpAds_ZoneAppendZone)
    {
        // Append zones

        // Read info from invocaton code
        if (!isset($appendid) || empty($appendid))
        {
            $appendvars = phpAds_ParseAppendCode($zone['append']);

            $appendid         = $appendvars[0]['zoneid'];
            $appenddelivery = $appendvars[0]['delivery'];

            if ($appenddelivery == phpAds_ZonePopup &&
                !count($available[phpAds_ZonePopup]))
            {
                $appenddelivery = phpAds_ZoneInterstitial;
            }
            elseif ($appenddelivery == phpAds_ZoneInterstitial &&
                    !count($available[phpAds_ZoneInterstitial]))
            {
                $appenddelivery = phpAds_ZonePopup;
            }
            else
            {
                // Add globals for lib-invocation
                foreach ($appendvars[1] as $k => $v)
                {
                    if ($k != 'n' && $k != 'what')
                        $GLOBALS[$k] = addslashes($v);
                }
            }
        }



        // Header
        echo "
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200' valign='top'>{$GLOBALS['strZoneAppendSelectZone']}</td>
            <td>
                <input type='hidden' name='appendsave' value='1'>
                <input type='hidden' name='appendid' value='$appendid'>
                <table cellpadding='0' cellspacing='0' border='0' width='100%'>
                <tr>
                    <td><input type='radio' name='appenddelivery' value='".phpAds_ZonePopup."'" . (count($available[phpAds_ZonePopup]) ? " onClick=\"phpAds_formSelectAppendDelivery(0)\"" : ' DISABLED') . ($appenddelivery == phpAds_ZonePopup ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td>
                    <td>{$GLOBALS['strPopup']}:</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width='100%'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

        if (count($available[phpAds_ZonePopup]))
            echo "<img src='" . OX::assetPath() . "/images/icon-popup.gif' align='top'>";
        else
            echo "<img src='" . OX::assetPath() . "/images/icon-popup-d.gif' align='top'>";

        echo "&nbsp;&nbsp;<select name='appendpopup' style='width: 200;' onchange='phpAds_formSelectAppendZone(0)'" . (count($available[phpAds_ZonePopup]) ? '' : ' DISABLED')." tabindex='".($tabindex++)."'>";

        while (list($k, $v) = each($available[phpAds_ZonePopup]))
        {
            if ($appendid == $k)
                echo "<option value='".$k."' selected>".$v."</option>";
            else
                echo "<option value='".$k."'>".$v."</option>";
        }

        echo "</select></td>
                </tr>
                <tr>
                    <td><input type='radio' name='appenddelivery' value='".phpAds_ZoneInterstitial."'" . (count($available[phpAds_ZoneInterstitial]) ? ' onClick="phpAds_formSelectAppendDelivery(1)"' : ' DISABLED') . ($appenddelivery == phpAds_ZoneInterstitial ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;</td>
                    <td>{$GLOBALS['strInterstitial']}:</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td width='100%'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

        if (count($available[phpAds_ZoneInterstitial]))
            echo "<img src='" . OX::assetPath() . "/images/icon-interstitial.gif' align='top'>";
        else
            echo "<img src='" . OX::assetPath() . "/images/icon-interstitial-d.gif' align='top'>";

        echo "&nbsp;&nbsp;<select name='appendinterstitial' style='width: 200;' ";
        echo "onchange='phpAds_formSelectAppendZone(1)'";
        echo (count($available[phpAds_ZoneInterstitial]) ? '' : ' DISABLED')." tabindex='".($tabindex++)."'>";

        while (list($k, $v) = each($available[phpAds_ZoneInterstitial]))
        {
            if ($appendid == $k)
                echo "<option value='".$k."' selected>".$v."</option>";
            else
                echo "<option value='".$k."'>".$v."</option>";
        }

        echo "</select></td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>
        <tr height='1'>
            <td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>
        </tr>
        <tr>
            <td height='10' colspan='3'>&nbsp;</td>
        </tr>";



        // It shouldn't be necessary to load zone attributes from db
        $extra = array('what' => '',
                       //'width' => $zone['width'],
                       //'height' => $zone['height'],
                       'delivery' => $appenddelivery,
                       //'website' => $affiliate['website'],
                       'zoneadvanced' => true
        );

        // Set codetype
        $codetype = $appenddelivery == 'popup' ? 'popup' : 'adlayer';
        $maxInvocation = new MAX_Admin_Invocation();
        echo $maxInvocation->placeInvocationForm($extra, true);

        echo "</td></tr>";
    }

    else
    {
        echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$strZoneAppend."</td><td>";
        echo "<input type='hidden' name='appendsave' value='1'>";
        echo "<textarea class='code' name='append' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['append'])."</textarea>";
        echo "</td></tr>";
    }

    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    echo "</table>";
}


// It isn't possible to append other banners to text zones, but
// it is possible to prepend and append regular HTML code for
// determining the layout of the text ad zone

elseif ($zone['delivery'] == phpAds_ZoneText )
{
    echo "
<br /><br /><br />
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<tr height='25'>
    <td colspan='3'><b>$strAppendSettings</b></td>
</tr>
<tr height='1'>
    <td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
</tr>
<tr>
    <td height='10' colspan='3'>&nbsp;</td>
</tr>
<tr>
    <td width='30'>&nbsp;</td>
    <td width='200'>Append even if no banner delivered</td>
    <td width='370'>
        <input type='radio' name='forceappend' value='t'".($zone['forceappend'] == 't' ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;{$GLOBALS['strYes']}<br />
        <input type='radio' name='forceappend' value='f'".((!isset($zone['forceappend']) || $zone['forceappend'] == 'f') ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;{$GLOBALS['strNo']}
    </td>
</tr>
<tr>
    <td height='10' colspan='3'>&nbsp;</td>
</tr>
<tr>
    <td width='30'>&nbsp;</td>
    <td width='200' valign='top'>$strZonePrependHTML</td>
    <td><textarea name='prepend' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['prepend'])."</textarea></td>
</tr>
<tr>
    <td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>
</tr>
<tr>
    <td width='30'>&nbsp;</td><td width='200' valign='top'>$strZoneAppendHTML</td>
    <td>
        <input type='hidden' name='appendsave' value='1'>
        <input type='hidden' name='appendtype' value='".phpAds_ZoneAppendRaw."'>
        <textarea name='append' rows='6' cols='55' style='width: 100%;' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['append'])."</textarea>
    </td>
</tr>
<tr>
    <td height='10' colspan='3'>&nbsp;</td>
</tr>
<tr height='1'>
    <td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
</tr>
</table>";
} else {
    echo "
</table>";
}

echo "
<br /><br />
<input type='submit' name='submitbutton' value='$strSaveChanges' tabindex='".($tabindex++)."'>
</form>";



/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/



?>

<script language='JavaScript'>
<!--
    function phpAds_formSelectZone()
    {
        document.zoneform.chaintype[0].checked = false;
        document.zoneform.chaintype[1].checked = true;
        document.zoneform.chaintype[2].checked = false;
    }

    function phpAds_formEditWhat()
    {
        if (event.keyCode != 9)
        {
            document.zoneform.chaintype[0].checked = false;
            document.zoneform.chaintype[1].checked = false;
            document.zoneform.chaintype[2].checked = true;
        }
    }

    function phpAds_formSelectAppendType()
    {
        if (document.zoneform.appendid)
            document.zoneform.appendid.value = '-1';
        document.zoneform.appendsave.value = '0';
        document.zoneform.submit();
    }

    function phpAds_formSelectAppendDelivery(type)
    {
        document.zoneform.appendid.value = '-1';
        document.zoneform.appendsave.value = '0';
        document.zoneform.submit();
    }


    function phpAds_formSelectAppendZone(type)
    {
        var x;

        if (document.zoneform.appenddelivery[type] &&
            !document.zoneform.appenddelivery[type].checked)
        {
            document.zoneform.appendid.value = '-1';
            document.zoneform.appendsave.value = '0';
            document.zoneform.submit();
        }
    }

    function phpAds_formZoneAdvSubmit()
    {
        if (document.zoneform.appenddelivery)
        {
            if (document.zoneform.appenddelivery[0].checked)
                x = document.zoneform.appendpopup;
            else
                x = document.zoneform.appendinterstitial;

            document.zoneform.appendid.value = x.options[x.selectedIndex].value;
        }

        return true;
    }

//-->
</script>

<?php

_echoDeliveryCappingJs();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>