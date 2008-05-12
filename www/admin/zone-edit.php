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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Admin/NumberFormat.php';

// Register input variables
phpAds_registerGlobalUnslashed(
    'zonename',
    'description',
    'delivery',
    'sizetype',
    'size',
    'width',
    'height',
    'submit',
    'cost',
    'cost_type',
    'technology_cost',
    'technology_cost_type',
    'cost_variable_id',
    'cost_variable_id_mult',
    'comments'
);

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);
OA_Permission::enforceAccessToObject('zones', $zoneid, true);

if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    if (!empty($zoneid)) {
        OA_Permission::enforceAllowed(OA_PERM_ZONE_EDIT);
    } else {
        OA_Permission::enforceAllowed(OA_PERM_ZONE_ADD);
    }
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit))
{
    if ($delivery == phpAds_ZoneText)
    {
        $width = 0;
        $height = 0;
    }
    else
    {
        if ($sizetype == 'custom')
        {
            if (isset($width) && $width == '*') $width = -1;
            if (isset($height) && $height == '*') $height = -1;
        }
        else
        {
            list ($width, $height) = explode ('x', $size);
        }
    }

    //correction cost and technology_cost from other formats (23234,34 or 23 234,34 or 23.234,34)
    //to format acceptable by is_numeric (23234.34)
    $corrected_cost = OA_Admin_NumberFormat::unformatNumber($cost);
    if ( $corrected_cost !== false ) {
        $cost = $corrected_cost;
        unset($corrected_cost);
    }
    if (!empty($cost) && !(is_numeric($cost))) {
        // Suppress PEAR error handling to show this error only on top of HTML form
        PEAR::pushErrorHandling(null);
        $errors[] = PEAR::raiseError($GLOBALS['strErrorEditingZoneCost']);
        PEAR::popErrorHandling();
    }
    
    $corrected_technology_cost = OA_Admin_NumberFormat::unformatNumber($technology_cost);
    if ( $corrected_technology_cost !== false ) {
        $technology_cost = $corrected_technology_cost;
        unset($corrected_technology_cost);
    }
    if (!empty($technology_cost) && !(is_numeric($technology_cost))) {
        // Suppress PEAR error handling to show this error only on top of HTML form
        PEAR::pushErrorHandling(null);
        $errors[] = PEAR::raiseError($GLOBALS['strErrorEditingZoneTechnologyCost']);
        PEAR::popErrorHandling();
    }
    
    if (empty($errors)) {
        
        if (!(is_numeric($cost)) || ($cost <= 0)) {
            // No cost information, set to null
            $cost = 'NULL';
            $cost_type = 'NULL';
        }
    
        if (!(is_numeric($technology_cost)) || ($technology_cost <= 0)) {
            // No cost information, set to null
            $technology_cost = 'NULL';
            $technology_cost_type = 'NULL';
        }
    
        if ($cost_type == MAX_FINANCE_VARSUM && is_array($cost_variable_id_mult)) {
            $cost_variable_id = 0;
            foreach ($cost_variable_id_mult as $val) {
                if ($cost_variable_id) {
                    $cost_variable_id .= "," . $val;
                } else {
                    $cost_variable_id = $val;
                }
            }
        }
    
        // Edit
        if (!empty($zoneid))
        {
            // before we commit any changes to db, store whether the size has changed
            $aZone = Admin_DA::getZone($zoneid);
            $size_changed = ($width != $aZone['width'] || $height != $aZone['height']) ? true : false;
            $type_changed = ($delivery != $aZone['delivery']) ? true : false;
    
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->zonename = $zonename;
            $doZones->description = $description;
            $doZones->width = $width;
            $doZones->height = $height;
            $doZones->comments = $comments;
            $doZones->cost = $cost;
            $doZones->cost_type = $cost_type;
            if ($cost_type == MAX_FINANCE_ANYVAR || $cost_type == MAX_FINANCE_VARSUM) {
                $doZones->cost_variable_id = $cost_variable_id;
            }
            $doZones->technology_cost = $technology_cost;
            $doZones->technology_cost_type = $technology_cost_type;
            $doZones->delivery = $delivery;
            if ($delivery != phpAds_ZoneText && $delivery != phpAds_ZoneBanner) {
                $doZones->append = '';
            }
            if ($delivery != phpAds_ZoneText) {
                $doZones->prepend = '';
            }
            $doZones->zoneid = $zoneid;
            $doZones->update();
    
            // Ad  Networks
            $doPublisher = OA_Dal::factoryDO('affiliates');
            $doPublisher->get($affiliateid);
            $anWebsiteId = $doPublisher->as_website_id;
            if ($anWebsiteId) {
            	$oAdNetworks = new OA_Central_AdNetworks();
                $doZones->get($zoneid);
    			$oAdNetworks->updateZone($doZones, $anWebsiteId);
            }
    
            // Reset append codes which called this zone
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->appendtype = phpAds_ZoneAppendZone;
    
            if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
            {
                $doZones->addReferenceFilter('agency', OA_Permission::getEntityId());
            }
            elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER))
            {
                  $doZones->addReferenceFilter('affiliates', OA_Permission::getEntityId());
            }
            $doZones->find();
    
            while ($doZones->fetch() && $row = $doZones->toArray())
            {
                $append = phpAds_ZoneParseAppendCode($row['append']);
    
                if ($append[0]['zoneid'] == $zoneid)
                {
                    $doZonesClone = clone($doZones);
                    $doZonesClone->appendtype = phpAds_ZoneAppendRaw;
                    $doZonesClone->append = '';
                    $doZonesClone->update();
                }
            }
    
            if ($type_changed && $delivery == MAX_ZoneEmail) {
                // Unlink all campaigns/banners linked to this zone
                $aPlacementZones = Admin_DA::getPlacementZones(array('zone_id' => $zoneid), true, 'placement_id');
                if (!empty($aPlacementZones)) {
                    foreach ($aPlacementZones as $placementId => $aPlacementZone) {
                        Admin_DA::deletePlacementZones(array('zone_id' => $zoneid, 'placement_id' => $placementId));
                    }
                }
                $aAdZones = Admin_DA::getAdZones(array('zone_id' => $zoneid), false, 'ad_id');
                if (!empty($aAdZones)) {
                    foreach ($aAdZones as $adId => $aAdZone) {
                        Admin_DA::deleteAdZones(array('zone_id' => $zoneid, 'ad_id' => $adId));
                    }
                }
            } else if ($size_changed) {
                $aZone = Admin_DA::getZone($zoneid);
    
                // Loop through all appended banners and make sure that they still fit...
                $aAds = Admin_DA::getAdZones(array('zone_id' => $zoneid), false, 'ad_id');
                if (!empty($aAds)) {
                 foreach ($aAds as $adId => $aAd) {
                    $aAd = Admin_DA::getAd($adId);
                        if ( (($aZone['type'] == phpAds_ZoneText) && ($aAd['type'] != 'txt'))
                        || (($aAd['width'] != $aZone['width']) && ($aZone['width'] > -1))
                        || (($aAd['height'] != $aZone['height']) && ($aZone['height'] > -1)) ) {
                            Admin_DA::deleteAdZones(array('zone_id' => $zoneid, 'ad_id' => $adId));
                        }
                    }
                }
    
                // Check if any campaigns linked to this zone have ads that now fit.
                // If so, link them to the zone.
                $aPlacementZones = Admin_DA::getPlacementZones(array('zone_id' => $zoneid), true);
                if (!empty($aPlacementZones)) {
                    foreach($aPlacementZones as $aPlacementZone) {
                    // get ads in this campaign
                    $aAds = Admin_DA::getAds(array('placement_id' => $aPlacementZone['placement_id']), true);
                        foreach ($aAds as $adId => $aAd) {
                            Admin_DA::addAdZone(array('zone_id' => $zoneid, 'ad_id' => $adId));
                        }
                    }
                }
            }
    
        }
        // Add
        else
        {
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $affiliateid;
            $doZones->zonename = $zonename;
            $doZones->zonetype = phpAds_ZoneCampaign;
            $doZones->description = $description;
            $doZones->comments = $comments;
            $doZones->width = $width;
            $doZones->height = $height;
            $doZones->delivery = $delivery;
            $doZones->cost = $cost;
            $doZones->cost_type = $cost_type;
            $doZones->technology_cost = $technology_cost;
            $doZones->technology_cost_type = $technology_cost_type;
            if ($cost_type == MAX_FINANCE_ANYVAR || $cost_type == MAX_FINANCE_VARSUM) {
                $doZones->cost_variable_id = $cost_variable_id;
            }
    
            // The following fields are NOT NULL but do not get values set in the form.
            // Should these fields be changed to NULL in the schema or should they have a default value?
            $doZones->category = '';
            $doZones->ad_selection = '';
            $doZones->chain = '';
            $doZones->prepend = '';
            $doZones->append = '';
    
            $zoneid = $doZones->insert();
    
            // Ad  Networks
            $doPublisher = OA_Dal::factoryDO('affiliates');
            $doPublisher->get($affiliateid);
            $anWebsiteId = $doPublisher->as_website_id;
            if ($anWebsiteId) {
            	$oAdNetworks = new OA_Central_AdNetworks();
    			$oAdNetworks->updateZone($doZones, $anWebsiteId);
            }
        }
    
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            if (OA_Permission::hasPermission(OA_PERM_ZONE_LINK)) {
                MAX_Admin_Redirect::redirect("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid");
            } else {
                MAX_Admin_Redirect::redirect("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid");
            }
        } else {
            MAX_Admin_Redirect::redirect("zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid");
        }
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

    $pageName = basename($_SERVER['PHP_SELF']);
    $tabIndex = 1;
    $agencyId = OA_Permission::getAgencyId();
    $aEntities = array('affiliateid' => $affiliateid, 'zoneid' => $zoneid);

    $aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
    $aOtherZones = Admin_DA::getZones(array('publisher_id' => $affiliateid));
    MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);
    
    //show errors
    if ($submit && !empty($errors)) {
        // Message
        echo "<br>";
        echo "<div class='errormessage'><img class='errormessage' src='" . MAX::assetPath() . "/images/errormessage.gif' align='absmiddle'>";
        echo "<span class='tab-r'>{$GLOBALS['strErrorEditingZone']}</span><br><br>";
        foreach ($errors as $aError) {
            echo "{$GLOBALS['strUnableToChangeZone']} - " . $aError->message . "<br>";
        }
        echo "</div>";
    }


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$zoneName = '';
if (!empty($zoneid)) {
    $doZones = OA_Dal::factoryDO('zones');
    $doZones->zoneid = $zoneid;
    if ($doZones->find() && $doZones->fetch()) {
        $zone = $doZones->toArray();
    }

    if ($zone['width'] == -1) $zone['width'] = '*';
    if ($zone['height'] == -1) $zone['height'] = '*';

    // Set the default financial information
    if (!isset($zone['cost'])) {
        $zone['cost'] = '0.0000';
    } else {
        $zone['cost'] = OA_Admin_NumberFormat::formatNumber($zone['cost'], 4);
    }
    if (isset($zone['technology_cost'])) {
        $zone['technology_cost'] = OA_Admin_NumberFormat::formatNumber($zone['technology_cost'], 4);
    }

    $zoneName = $zone['zonename'];
} else {
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $doAffiliates->affiliateid = $affiliateid;

    if ($doAffiliates->find() && $doAffiliates->fetch() && $affiliate = $doAffiliates->toArray())
        $zone["zonename"] = $affiliate['name'].' - ';
    else
        $zone["zonename"] = '';

    $zone['zonename']        .= $strDefault;
    $zone['description']     = '';
    $zone['width']             = '468';
    $zone['height']         = '60';
    $zone['delivery']        = phpAds_ZoneBanner;
    $zone['cost']           = OA_Admin_NumberFormat::formatNumber(0, 4);;
    $zone['cost_type']      = null;
    $zone['technology_cost'] = null;
    $zone['technology_cost_type'] = null;
    $zone['cost_variable_id'] = null;
    $zone['comments'] = null;
    $cost_variable_id = null;
}

$tabindex = 1;

if (!empty($zoneid)) {
    // Only display the notices when *changing* a zone, not for new zones
    echo "<div class='errormessage' id='warning_change_zone_type' style='display:none'> <img class='errormessage' src='" . MAX::assetPath() . "/images/errormessage.gif' align='absmiddle' />";
    echo "<span class='tab-r'> {$GLOBALS['strWarning']}:</span><br />";
    echo "{$GLOBALS['strWarnChangeZoneType']}";
    echo "</div>";

    echo "<div class='errormessage' id='warning_change_zone_size' style='display:none'> <img class='errormessage' src='" . MAX::assetPath() . "/images/warning.gif' align='absmiddle' />";
    echo "<span class='tab-s'> {$GLOBALS['strNotice']}:</span><br />";
    echo "{$GLOBALS['strWarnChangeZoneSize']}";
    echo "</div>";
}

echo "<form name='zoneform' method='post' action='zone-edit.php' onSubmit='return max_formValidate(this);'>";
echo "<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";

echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='zonename' size='35' style='width:350px;' value='".phpAds_htmlQuotes($zone['zonename'])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strDescription."</td><td>";
echo "<input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($zone["description"])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'><br />".$strZoneType."</td><td><table>";
echo "<tr><td><input type='radio' id='delivery-b' name='delivery' value='".phpAds_ZoneBanner."'".($zone['delivery'] == phpAds_ZoneBanner ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' onChange='oa_hide(\"warning_change_zone_type\");' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='" . MAX::assetPath() . "/images/icon-zone.gif' align='absmiddle'>&nbsp;<label for='delivery-b'>".$strBannerButtonRectangle."</label></td></tr>";

if ($conf['allowedTags']['adlayer'] || $zone['delivery'] == phpAds_ZoneInterstitial)
{
    echo "<tr><td><input type='radio' id='delivery-i' name='delivery' value='".phpAds_ZoneInterstitial."'".($zone['delivery'] == phpAds_ZoneInterstitial ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' onChange='oa_hide(\"warning_change_zone_type\");' tabindex='".($tabindex++)."'>";
    echo "&nbsp;<img src='" . MAX::assetPath() . "/images/icon-interstitial.gif' align='absmiddle'>&nbsp;<label for='delivery-i'>".$strInterstitial."</label></td></tr>";
}

if ($conf['allowedTags']['popup'] || $zone['delivery'] == phpAds_ZonePopup)
{
    echo "<tr><td><input type='radio' id='delivery-p' name='delivery' value='".phpAds_ZonePopup."'".($zone['delivery'] == phpAds_ZonePopup ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' onChange='oa_hide(\"warning_change_zone_type\");' tabindex='".($tabindex++)."'>";
    echo "&nbsp;<img src='" . MAX::assetPath() . "/images/icon-popup.gif' align='absmiddle'>&nbsp;<label for='delivery-p'>".$strPopup."</label></td></tr>";
}

echo "<tr><td><input type='radio' id='delivery-t' name='delivery' value='".phpAds_ZoneText."'".($zone['delivery'] == phpAds_ZoneText ? ' CHECKED' : '')." onClick='phpAds_formDisableSize();' " . (($zone['delivery'] != phpAds_ZoneText) ? "onChange='oa_show(\"warning_change_zone_type\");'" : "onChange='oa_hide(\"warning_change_zone_type\");'") . " tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='" . MAX::assetPath() . "/images/icon-textzone.gif' align='absmiddle'>&nbsp;<label for='delivery-t'>".$strTextAdZone."</label></td></tr>";

echo "<tr><td><input type='radio' id='delivery-e' name='delivery' value='".MAX_ZoneEmail."'".($zone['delivery'] == MAX_ZoneEmail ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' " . (($zone['delivery'] != MAX_ZoneEmail) ? "onChange='oa_show(\"warning_change_zone_type\");'" : "onChange='oa_hide(\"warning_change_zone_type\");'") . " tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='" . MAX::assetPath() . "/images/icon-zone-email.gif' align='absmiddle'>&nbsp;<label for='delivery-e'>".$strEmailAdZone."</label></td></tr>";

//echo "<tr><td><input type='radio' name='delivery' value='".MAX_ZoneClick."'".($zone['delivery'] == MAX_ZoneClick ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
//echo "&nbsp;<img src='" . MAX::assetPath() . "/images/icon-zone-click.gif' align='absmiddle'>&nbsp;".$strZoneClick."</td></tr>";

echo "</table></td></tr>";


if ($zone['delivery'] == phpAds_ZoneText)
{
    $sizedisabled = ' disabled';
    $zone['width'] = '*';
    $zone['height'] = '*';
}
else
    $sizedisabled = '';

echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'><br />".$strSize."</td><td>";

$exists = phpAds_sizeExists ($zone['width'], $zone['height']);

echo "<table><tr><td>";
echo "<input type='radio' name='sizetype' value='default'".($exists ? ' CHECKED' : '').$sizedisabled." tabindex='".($tabindex++)."'>&nbsp;";
echo "<select name='size' onchange='phpAds_formSelectSize(this); oa_sizeChangeUpdateMessage(\"warning_change_zone_size\");'".$sizedisabled." tabindex='".($tabindex++)."'>";

foreach (array_keys($phpAds_IAB) as $key)
{
    if ($phpAds_IAB[$key]['width'] == $zone['width'] &&
        $phpAds_IAB[$key]['height'] == $zone['height'])
        echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."' selected>".$GLOBALS['strIab'][$key]."</option>";
    else
        echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."'>".$GLOBALS['strIab'][$key]."</option>";
}

echo "<option value='-'".(!$exists ? ' SELECTED' : '').">Custom</option>";
echo "</select>";

echo "</td></tr><tr><td>";

echo "<input type='radio' name='sizetype' value='custom'".(!$exists ? ' CHECKED' : '').$sizedisabled." onclick='phpAds_formEditSize()'  tabindex='".($tabindex++)."'>&nbsp;";
echo $strWidth.": <input class='flat' size='5' type='text' name='width' value='".(isset($zone["width"]) ? $zone["width"] : '')."'".$sizedisabled." onkeydown='phpAds_formEditSize()' onBlur='max_formValidateElement(this);' onChange='oa_sizeChangeUpdateMessage(\"warning_change_zone_size\");' tabindex='".($tabindex++)."'>";
echo "&nbsp;&nbsp;&nbsp;";
echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".(isset($zone["height"]) ? $zone["height"] : '')."'".$sizedisabled." onkeydown='phpAds_formEditSize()' onBlur='max_formValidateElement(this);' onChange='oa_sizeChangeUpdateMessage(\"warning_change_zone_size\");' tabindex='".($tabindex++)."'>";
echo "</td></tr></table>";
echo "</td></tr>";

echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strCostInfo."</td>";
echo "<td>";
echo "&nbsp;&nbsp;<input type='text' name='cost' size='10' value='{$zone["cost"]}' tabindex='".($tabindex++)."'>&nbsp;";
echo "&nbsp;&nbsp;";
echo "<select name='cost_type' id='cost_type' onchange='m3_updateFinance()'>";
echo "  <option value='".MAX_FINANCE_CPM."' ".(($zone['cost_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
echo "  <option value='".MAX_FINANCE_CPC."' ".(($zone['cost_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
echo "  <option value='".MAX_FINANCE_CPA."' ".(($zone['cost_type'] == MAX_FINANCE_CPA) ? ' SELECTED ' : '').">$strFinanceCPA</option>";
echo "  <option value='".MAX_FINANCE_MT."' ".(($zone['cost_type'] == MAX_FINANCE_MT) ? ' SELECTED ' : '').">$strFinanceMT</option>";
echo "  <option value='".MAX_FINANCE_RS."' ".(($zone['cost_type'] == MAX_FINANCE_RS) ? ' SELECTED ' : '').">$strPercentRevenueSplit</option>";
echo "  <option value='".MAX_FINANCE_BV."' ".(($zone['cost_type'] == MAX_FINANCE_BV) ? ' SELECTED ' : '')."> $strPercentBasketValue</option>";
echo "  <option value='".MAX_FINANCE_AI."' ".(($zone['cost_type'] == MAX_FINANCE_AI) ? ' SELECTED ' : '').">$strAmountPerItem</option>";
echo "  <option value='".MAX_FINANCE_ANYVAR."' ".(($zone['cost_type'] == MAX_FINANCE_ANYVAR) ? ' SELECTED ' : '').">$strPercentCustomVariable</option>";
echo "  <option value='".MAX_FINANCE_VARSUM."' ".(($zone['cost_type'] == MAX_FINANCE_VARSUM) ? ' SELECTED ' : '').">$strPercentSumVariables</option>";
echo "</select>";
echo "&nbsp;&nbsp;";
echo "<span id='cost_cpm_description' style='margin-left: 7px;'>per single impression<span>";

$dalVariables = OA_Dal::factoryDAL('variables');
$rsVariables = $dalVariables->getTrackerVariables($zoneid, $affiliateid, OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER));
$rsVariables->find();

$res_tracker_variables = array();
if (!$rsVariables->getRowCount()) {
    $res_noresults = true;
} else {
    $res_noresults = false;
    $i = 0;
    while ($rsVariables->fetch() && $row = $rsVariables->toArray()) {
        $res_tracker_variables[$i]['variable_id'] = $row['variable_id'];
        $res_tracker_variables[$i]['tracker_name'] = $row['tracker_name'];
        $res_tracker_variables[$i]['variable_name'] = $row['variable_name'];
        $res_tracker_variables[$i]['tracker_description'] = $row['tracker_description'];
        $res_tracker_variables[$i]['variable_description'] = $row['variable_description'];
        $i++;
    }
}

echo "<select name='cost_variable_id' id='cost_variable_id'>";

if ($res_noresults) {
    echo "<option value=''>-- No linked tracker --</option>";
} else {
    foreach ($res_tracker_variables as $k=>$v) {
        echo "<option value='{$v['variable_id']}' ".(($zone['cost_variable_id'] == $v['variable_id']) ? ' SELECTED ' : '').">".
            "[id".$v['tracker_id']."] ".
            htmlspecialchars(empty($v['tracker_description']) ? $v['tracker_name'] : $v['tracker_description']).
            ": ".
            htmlspecialchars(empty($v['variable_description']) ? $v['variable_name'] : $v['variable_description']).
        "</option>";
    }
}

echo "</select>";

if (strpos($zone['cost_variable_id'], ',')) {
    $cost_variable_ids = explode(',', $zone['cost_variable_id']);
} else {
    $cost_variable_ids = array($zone['cost_variable_id']);
}

echo "<select name='cost_variable_id_mult[]' id='cost_variable_id_mult' multiple='multiple' size='3'>";

if ($res_noresults) {
    echo "<option value=''>-- No linked tracker --</option>";
} else {
    foreach ($res_tracker_variables as $k=>$v) {
        echo "<option value='{$v['variable_id']}' ".(in_array($v['variable_id'], $cost_variable_ids) ? ' SELECTED ' : '').">".
            "[id".$v['tracker_id']."] ".
            htmlspecialchars(empty($v['tracker_description']) ? $v['tracker_name'] : $v['tracker_description']).
            ": ".
            htmlspecialchars(empty($v['variable_description']) ? $v['variable_name'] : $v['variable_description']).
        "</option>";
    }
}

echo "</select>";

echo "</td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strTechnologyCost."</td>";
echo "<td>";
echo "&nbsp;&nbsp;<input type='text' name='technology_cost' size='10' value='{$zone["technology_cost"]}' tabindex='".($tabindex++)."'>&nbsp;";
echo "&nbsp;&nbsp;";
echo "<select name='technology_cost_type' id='technology_cost_type' onchange='m3_updateFinance()'>";
echo "  <option value='".MAX_FINANCE_CPM."' ".(($zone['technology_cost_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
echo "  <option value='".MAX_FINANCE_CPC."' ".(($zone['technology_cost_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
echo "  <option value='".MAX_FINANCE_RS."' ".(($zone['technology_cost_type'] == MAX_FINANCE_RS) ? ' SELECTED ' : '').">$strPercentRevenueSplit</option>";
echo "</select>";
echo "&nbsp;&nbsp;";
echo "<span id='technology_cost_cpm_description' style='margin-left: 7px;'>per single impression<span>";

echo "</td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strComments."</td>";
echo "<td><textarea class='flat' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".htmlspecialchars($zone['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='".(isset($zoneid) && $zoneid != '' ? $strSaveChanges : $strNext.' >')."' tabindex='".($tabindex++)."'>";
echo "</form>";



/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique affiliate
$doZones = OA_Dal::factoryDO('zones');
$doZones->affiliateid = $affiliateid;
$unique_names = $doZones->getUniqueValuesFromColumn('zonename', $zoneName);

//$unique_names = array();
//
//$res = phpAds_dbQuery("SELECT * FROM ".$conf['table']['prefix'].$conf['table']['zones']." WHERE affiliateid = '".$affiliateid."' AND zoneid != '".$zoneid."'");
//while ($row = phpAds_dbFetchArray($res))
//    $unique_names[] = $row['zonename'];

?>

<script language='JavaScript'>
<!--
    <?php

    if (isset($zone["height"])) {
        echo "document.zoneHeight ='" .$zone["height"]. "';\n";
    }
    if (isset($zone["width"])) {
        echo "document.zoneWidth ='" .$zone["width"]. "';\n";
    }

    ?>


    max_formSetRequirements('zonename', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetRequirements('width', '<?php echo addslashes($strWidth); ?>', true, 'number*');
    max_formSetRequirements('height', '<?php echo addslashes($strHeight); ?>', true, 'number*');

    max_formSetUnique('zonename', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');


    function phpAds_formSelectSize(o)
    {
        // Get size from select
        size   = o.options[o.selectedIndex].value;

        if (size != '-')
        {
            // Get width and height
            sarray = size.split('x');
            height = sarray.pop();
            width  = sarray.pop();

            // Set width and height
            document.zoneform.width.value = width;
            document.zoneform.height.value = height;

            // Set radio
            document.zoneform.sizetype[0].checked = true;
            document.zoneform.sizetype[1].checked = false;
        }
        else
        {
            document.zoneform.sizetype[0].checked = false;
            document.zoneform.sizetype[1].checked = true;
        }
    }

    function phpAds_formEditSize()
    {
        document.zoneform.sizetype[0].checked = false;
        document.zoneform.sizetype[1].checked = true;
        document.zoneform.size.selectedIndex = document.zoneform.size.options.length - 1;
    }

    function phpAds_formDisableSize()
    {
        document.zoneform.sizetype[0].disabled = true;
        document.zoneform.sizetype[1].disabled = true;
        document.zoneform.width.disabled = true;
        document.zoneform.height.disabled = true;
        document.zoneform.size.disabled = true;
    }

    function phpAds_formEnableSize()
    {
        document.zoneform.sizetype[0].disabled = false;
        document.zoneform.sizetype[1].disabled = false;
        document.zoneform.width.disabled = false;
        document.zoneform.height.disabled = false;
        document.zoneform.size.disabled = false;
    }

    function m3_updateFinance()
    {
        var o = document.getElementById('cost_type');
        var o2 = document.getElementById('technology_cost_type');
        var p = document.getElementById('cost_variable_id');
        var p2 = document.getElementById('cost_variable_id_mult');
        var cost_cpm_desc = document.getElementById('cost_cpm_description');
        var cost_cpm_desc2 = document.getElementById('technology_cost_cpm_description');

        if ( o.options[o.selectedIndex].value == <?php echo MAX_FINANCE_ANYVAR; ?>) {
            p.style.display = '';
            p2.style.display = 'none';
        } else if (o.options[o.selectedIndex].value == <?php echo MAX_FINANCE_VARSUM; ?>) {
            p.style.display = 'none';
            p2.style.display = '';
        } else {
            p.style.display = 'none';
            p2.style.display = 'none';
        }

        if ( o.options[o.selectedIndex].value == <?php echo MAX_FINANCE_CPM; ?>) {
            cost_cpm_desc.style.display = 'block';
        } else {
            cost_cpm_desc.style.display = 'none';
        }
        if ( o2.options[o2.selectedIndex].value == <?php echo MAX_FINANCE_CPM; ?>) {
            cost_cpm_desc2.style.display = 'block';
        } else {
            cost_cpm_desc2.style.display = 'none';
        }
    }

    function oa_sizeChangeUpdateMessage(id)
    {
        if (document.zoneWidth != document.zoneform.width.value ||
            document.zoneHeight !=  document.zoneform.height.value) {
                oa_show(id);

        } else if (document.zoneWidth == document.zoneform.width.value &&
                   document.zoneHeight ==  document.zoneform.height.value) {
            oa_hide(id);
        }
    }

    function oa_show(id)
    {
        var obj = findObj(id);
        if (obj) { obj.style.display = 'block'; }
    }
    function oa_hide(id)
    {
        var obj = findObj(id);
        if (obj) { obj.style.display = 'none'; }
    }
    m3_updateFinance();

//-->
</script>

<?php



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
