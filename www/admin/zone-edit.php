<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/html.php';

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
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
MAX_Permission::checkIsAllowed(phpAds_AddZone);
if (!empty($zoneid)) {
    MAX_Permission::checkAccessToObject('zones', $zoneid);
} else {
    if (phpAds_isUser(phpAds_Affiliate)) {
        $affiliateid = phpAds_getUserID();
    }
    MAX_Permission::checkAccessToObject('affiliates', $affiliateid);
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
        
        $doZones = MAX_DB::factoryDO('zones');
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
        
        // Reset append codes which called this zone
        $doZones = MAX_DB::factoryDO('zones');
        $doZones->appendtype = phpAds_ZoneAppendZone;
        
        if (phpAds_isUser(phpAds_Agency))
        {
            $doZones->addReferenceFilter('agency', phpAds_getUserID());
        }
        elseif (phpAds_isUser(phpAds_Affiliate))
        {
              $doZones->addReferenceFilter('affiliates', phpAds_getUserID());
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

        if ($size_changed) {
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
        $doZones = MAX_DB::factoryDO('zones');
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
        $zoneid = $doZones->insert();
    }
    
    if (phpAds_isUser(phpAds_Affiliate)) {
        if (phpAds_isAllowed(phpAds_LinkBanners)) {
            MAX_Admin_Redirect::redirect("zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid");
        } else {
            MAX_Admin_Redirect::redirect("zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid");
        }
    } else {
        MAX_Admin_Redirect::redirect("zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid");
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

    $pageName = basename($_SERVER['PHP_SELF']);
    $tabIndex = 1;
    $agencyId = phpAds_getAgencyID();
    $aEntities = array('affiliateid' => $affiliateid, 'zoneid' => $zoneid);

    $aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
    $aOtherZones = Admin_DA::getZones(array('publisher_id' => $affiliateid));
    MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$zoneName = '';
if (!empty($zoneid)) {
    $doZones = MAX_DB::factoryDO('zones');
    $doZones->zoneid = $zoneid;
    if ($doZones->find() && $doZones->fetch()) {
        $zone = $doZones->toArray();
    }

    if ($zone['width'] == -1) $zone['width'] = '*';
    if ($zone['height'] == -1) $zone['height'] = '*';

    // Set the default financial information
    if (!isset($zone['cost'])) {
        $zone['cost'] = '0.0000';
    }
    
    $zoneName = $zone['zonename'];
} else {
    $doAffiliates = MAX_DB::factoryDO('affiliates');
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
    $zone['cost']           = '0.0000';
    $zone['cost_type']      = null;
    $zone['technology_cost'] = null;
    $zone['technology_cost_type'] = null;
    $zone['cost_variable_id'] = null;
    $zone['comments'] = null;
    $cost_variable_id = null;
}

$tabindex = 1;


echo "<form name='zoneform' method='post' action='zone-edit.php' onSubmit='return max_formValidate(this);'>";
echo "<input type='hidden' name='zoneid' value='".(isset($zoneid) && $zoneid != '' ? $zoneid : '')."'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";

echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='zonename' size='35' style='width:350px;' value='".phpAds_htmlQuotes($zone['zonename'])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strDescription."</td><td>";
echo "<input class='flat' size='35' type='text' name='description' style='width:350px;' value='".phpAds_htmlQuotes($zone["description"])."' tabindex='".($tabindex++)."'></td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'><br />".$strZoneType."</td><td><table>";
echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZoneBanner."'".($zone['delivery'] == phpAds_ZoneBanner ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;".$strBannerButtonRectangle."</td></tr>";

if ($pref['allow_invocation_interstitial'] || $zone['delivery'] == phpAds_ZoneInterstitial)
{
    echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZoneInterstitial."'".($zone['delivery'] == phpAds_ZoneInterstitial ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
    echo "&nbsp;<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;".$strInterstitial."</td></tr>";
}

if ($pref['allow_invocation_popup'] || $zone['delivery'] == phpAds_ZonePopup)
{
    echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZonePopup."'".($zone['delivery'] == phpAds_ZonePopup ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
    echo "&nbsp;<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;".$strPopup."</td></tr>";
}

echo "<tr><td><input type='radio' name='delivery' value='".phpAds_ZoneText."'".($zone['delivery'] == phpAds_ZoneText ? ' CHECKED' : '')." onClick='phpAds_formDisableSize();' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;".$strTextAdZone."</td></tr>";

echo "<tr><td><input type='radio' name='delivery' value='".MAX_ZoneEmail."'".($zone['delivery'] == MAX_ZoneEmail ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='images/icon-zone-email.gif' align='absmiddle'>&nbsp;".$strEmailAdZone."</td></tr>";

echo "<tr><td><input type='radio' name='delivery' value='".MAX_ZoneClick."'".($zone['delivery'] == MAX_ZoneClick ? ' CHECKED' : '')." onClick='phpAds_formEnableSize();' tabindex='".($tabindex++)."'>";
echo "&nbsp;<img src='images/icon-zone-click.gif' align='absmiddle'>&nbsp;".$strZoneClick."</td></tr>";

echo "</table></td></tr>";


if ($zone['delivery'] == phpAds_ZoneText)
{
    $sizedisabled = ' disabled';
    $zone['width'] = '*';
    $zone['height'] = '*';
}
else
    $sizedisabled = '';

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'><br />".$strSize."</td><td>";

$exists = phpAds_sizeExists ($zone['width'], $zone['height']);

echo "<table><tr><td>";
echo "<input type='radio' name='sizetype' value='default'".($exists ? ' CHECKED' : '').$sizedisabled." tabindex='".($tabindex++)."'>&nbsp;";
echo "<select name='size' onchange='phpAds_formSelectSize(this)'".$sizedisabled." tabindex='".($tabindex++)."'>";

foreach (array_keys($phpAds_IAB) as $key)
{
    if ($phpAds_IAB[$key]['width'] == $zone['width'] &&
        $phpAds_IAB[$key]['height'] == $zone['height'])
        echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."' selected>".$key."</option>";
    else
        echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."'>".$key."</option>";
}

echo "<option value='-'".(!$exists ? ' SELECTED' : '').">Custom</option>";
echo "</select>";

echo "</td></tr><tr><td>";

echo "<input type='radio' name='sizetype' value='custom'".(!$exists ? ' CHECKED' : '').$sizedisabled." onclick='phpAds_formEditSize()' tabindex='".($tabindex++)."'>&nbsp;";
echo $strWidth.": <input class='flat' size='5' type='text' name='width' value='".(isset($zone["width"]) ? $zone["width"] : '')."'".$sizedisabled." onkeydown='phpAds_formEditSize()' onBlur='max_formValidateElement(this);' tabindex='".($tabindex++)."'>";
echo "&nbsp;&nbsp;&nbsp;";
echo $strHeight.": <input class='flat' size='5' type='text' name='height' value='".(isset($zone["height"]) ? $zone["height"] : '')."'".$sizedisabled." onkeydown='phpAds_formEditSize()' onBlur='max_formValidateElement(this);' tabindex='".($tabindex++)."'>";
echo "</td></tr></table>";
echo "</td></tr>";

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

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
echo "  <option value='".MAX_FINANCE_RS."' ".(($zone['cost_type'] == MAX_FINANCE_RS) ? ' SELECTED ' : '').">". '% Revenue split' ."</option>";
echo "  <option value='".MAX_FINANCE_BV."' ".(($zone['cost_type'] == MAX_FINANCE_BV) ? ' SELECTED ' : '').">". '% Basket value' ."</option>";
echo "  <option value='".MAX_FINANCE_AI."' ".(($zone['cost_type'] == MAX_FINANCE_AI) ? ' SELECTED ' : '').">". 'Amount per item' ."</option>";
echo "  <option value='".MAX_FINANCE_ANYVAR."' ".(($zone['cost_type'] == MAX_FINANCE_ANYVAR) ? ' SELECTED ' : '').">". '% Custom variable' ."</option>";
echo "  <option value='".MAX_FINANCE_VARSUM."' ".(($zone['cost_type'] == MAX_FINANCE_VARSUM) ? ' SELECTED ' : '').">". '% Sum of variables' ."</option>";
echo "</select>";
echo "&nbsp;&nbsp;";

$dalVariables = MAX_DB::factoryDAL('variables');
$rsVariables = $dalVariables->getTrackerVariables($zoneid, $affiliateid, phpAds_isUser(phpAds_Affiliate));
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
            htmlentities(empty($v['tracker_description']) ? $v['tracker_name'] : $v['tracker_description']).
            ": ".
            htmlentities(empty($v['variable_description']) ? $v['variable_name'] : $v['variable_description']).
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
            htmlentities(empty($v['tracker_description']) ? $v['tracker_name'] : $v['tracker_description']).
            ": ".
            htmlentities(empty($v['variable_description']) ? $v['variable_name'] : $v['variable_description']).
        "</option>";
    }
}

echo "</select>";

echo "</td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strTechnologyCost."</td>";
echo "<td>";
echo "&nbsp;&nbsp;<input type='text' name='technology_cost' size='10' value='{$zone["technology_cost"]}' tabindex='".($tabindex++)."'>&nbsp;";
echo "&nbsp;&nbsp;";
echo "<select name='technology_cost_type' id='technology_cost_type'>";
echo "  <option value='".MAX_FINANCE_CPM."' ".(($zone['technology_cost_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
echo "  <option value='".MAX_FINANCE_CPC."' ".(($zone['technology_cost_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
echo "  <option value='".MAX_FINANCE_RS."' ".(($zone['technology_cost_type'] == MAX_FINANCE_RS) ? ' SELECTED ' : '').">". '% Revenue split' ."</option>";
echo "</select>";
echo "&nbsp;&nbsp;";

echo "</td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strComments."</td>";
echo "<td><textarea class='code' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".htmlentities($zone['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='".(isset($zoneid) && $zoneid != '' ? $strSaveChanges : $strNext.' >')."' tabindex='".($tabindex++)."'>";
echo "</form>";



/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique affiliate
$doZones = MAX_DB::factoryDO('zones');
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
        var p = document.getElementById('cost_variable_id');
        var p2 = document.getElementById('cost_variable_id_mult');
        
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
