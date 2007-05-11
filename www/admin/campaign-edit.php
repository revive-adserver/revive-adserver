<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/capping/lib-capping.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once 'Date.php';

// Register input variables
phpAds_registerGlobalUnslashed(
     'activateDay'
    ,'activateMonth'
    ,'activateSet'
    ,'activateYear'
    ,'active_old'
    ,'anonymous'
    ,'campaignname'
    ,'clicks'
    ,'companion'
    ,'comments'
    ,'conversions'
    ,'expire'
    ,'expireDay'
    ,'expireMonth'
    ,'expireSet'
    ,'expireYear'
    ,'move'
    ,'priority'
    ,'high_priority_value'
    ,'revenue'
    ,'revenue_type'
    ,'submit'
    ,'target_old'
    ,'target_value'
    ,'target_type'
    ,'unlimitedclicks'
    ,'unlimitedconversions'
    ,'unlimitedimpressions'
    ,'impressions'
    ,'weight_old'
    ,'weight'
    ,'clientid'
);

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency);
MAX_Permission::checkAccessToObject('clients', $clientid);

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit)) {
    $expire = OA_Dal::sqlDate($expireSet == 't', $expireYear, $expireMonth, $expireDay);
    $activate = OA_Dal::sqlDate($activateSet == 't', $activateYear, $activateMonth, $activateDay);

    // If ID is not set, it should be a null-value for the auto_increment
    if (empty($campaignid)) {
        $campaignid = "null";
    } else {
        require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
        $oldCampaign = Admin_DA::getPlacement($campaignid);
        $oldCampaignAdZoneAssocs = Admin_DA::getAdZones(array('placement_id' => $campaignid));
        $errors = array();
        foreach ($oldCampaignAdZoneAssocs as $adZoneAssocId => $adZoneAssoc) {
            $aZone = Admin_DA::getZone($adZoneAssoc['zone_id']);
            if ($aZone['type'] == MAX_ZoneEmail) {
                $thisLink = Admin_DA::_checkEmailZoneAdAssoc($aZone, $campaignid, $activate, $expire);
                if (PEAR::isError($thisLink)) {
                    $errors[] = $thisLink;
                    break;
                }
            }
        }
    }

    if (empty($errors)) {
        // Set expired
        if ($impressions == '-') {
            $impressions = 0;
        }
        if ($clicks == '-') {
            $clicks = 0;
        }
        if ($conversions == '-') {
            $conversions = 0;
        }
        // Set unlimited
        if (isset($unlimitedimpressions) && strtolower ($unlimitedimpressions) == "on") {
            $impressions = -1;
        }
        if (isset($unlimitedclicks) && strtolower ($unlimitedclicks) == "on") {
            $clicks = -1;
        }
        if (isset($unlimitedconversions) && strtolower ($unlimitedconversions) == "on") {
            $conversions = -1;
        }
        if ($priority > 0) {
            // Set target
            $target_impression = 0;
            $target_click      = 0;
            $target_conversion = 0;
            if ((isset($target_value)) && ($target_value != '-')) {
                switch ($target_type) {
                case 'limit_impression':
                    $target_impression = $target_value;
                    break;

                case 'limit_click':
                    $target_click = $target_value;
                    break;

                case 'limit_conversion':
                    $target_conversion = $target_value;
                    break;
                }
            }
            if (isset($high_priority_value)) {
                $priority = $high_priority_value;
            }
            $weight = 0;
        } else {
            // Set weight
            if (isset($weight)) {
                if ($weight == '-') {
                    $weight = 0;
                } elseif ($weight == '') {
                    $weight = 0;
                }
            } else {
                $weight = 0;
            }
            $target_impression = 0;
            $target_click      = 0;
            $target_conversion = 0;
        }
        $active = "t";
        if ($impressions == 0 || $clicks == 0 || $conversions == 0) {
            $active = "f";
        }
        if ($activateDay != '-' && $activateMonth != '-' && $activateYear != '-') {
            if (time() < mktime(0, 0, 0, $activateMonth, $activateDay, $activateYear)) {
                $active = "f";
            }
        }
        if ($expireDay != '-' && $expireMonth != '-' && $expireYear != '-') {
            if (time() > mktime(23, 59, 59, $expireMonth, $expireDay, $expireYear)) {
                $active = "f";
            }
        }
        // Set campaign inactive if weight and target are both null and autotargeting is disabled
        if ($active == 't' && !(($target_impression > 0 || $target_click > 0 || $target_conversion > 0) || $weight > 0 || (OA_Dal::isValidDate($expire) && ($impressions > 0 || $clicks > 0 || $conversions > 0)))) {
            $active = 'f';
        }
        if ($anonymous != 't') {
            $anonymous = 'f';
        }
        if ($companion != 1) {
            $companion = 0;
        }
        $new_campaign = $campaignid == 'null';

        if (!(is_numeric($revenue)) || ($revenue <= 0)) {
            // No revenue information, set to null
            $revenue = 'NULL';
            $revenue_type = 'NULL';
        }

        // Get the capping variables
        _initCappingVariables();

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = $campaignname;
        $doCampaigns->clientid = $clientid;
        $doCampaigns->views = $impressions;
        $doCampaigns->clicks = $clicks;
        $doCampaigns->conversions = $conversions;
        $doCampaigns->expire = $expire;
        $doCampaigns->activate = $activate;
        $doCampaigns->active = $active;
        $doCampaigns->priority = $priority;
        $doCampaigns->weight = $weight;
        $doCampaigns->target_impression = $target_impression;
        $doCampaigns->target_click = $target_click;
        $doCampaigns->target_conversion = $target_conversion;
        $doCampaigns->anonymous = $anonymous;
        $doCampaigns->companion = $companion;
        $doCampaigns->comments = $comments;
        $doCampaigns->revenue = $revenue;
        $doCampaigns->revenue_type = $revenue_type;
        $doCampaigns->block = $block;
        $doCampaigns->capping = $cap;
        $doCampaigns->session_capping = $session_capping;
        $doCampaigns->updated = OA::getNow();

        if (!empty($campaignid) && $campaignid != "null") {
            $doCampaigns->campaignid = $campaignid;
            $doCampaigns->update();
        } else {
            $campaignid = $doCampaigns->insert();
        }

        if (isset($move) && $move == 't') {
            // We are moving a client to a campaign
            // Update banners
            $dalBanners = OA_Dal::factoryDAL('banners');
            $dalBanners->moveBannerToCampaign($bannerId, $campaignid);
            // Force priority recalculation
            $new_campaign = false;
        }

        // Recalculate priority only when editing a campaign
        // or moving banners into a newly created, and when:
        //
        // - campaing changes status (activated or deactivated) or
        // - the campaign is active and target/weight are changed
        //
        if (!$new_campaign && ($active != $active_old || ($active == 't' && ($target_impression != $target_old || $weight != $weight_old)))) {
            // Run the Maintenance Priority Engine process
            MAX_Maintenance_Priority::run();
        }

        // Rebuild cache
        // include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();

        // Delete channel forecasting cache
        include_once 'Cache/Lite.php';
        $options = array(
            'cacheDir' => MAX_CACHE,
        );
        $cache = new Cache_Lite($options);
        $group = 'campaing_'.$campaignid;
        $cache->clean($group);

        MAX_Admin_Redirect::redirect("campaign-zone.php?clientid=$clientid&campaignid=$campaignid");
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($campaignid != "") {
    if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'])) {
        $navorder = $session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'];
    } else {
        $navorder = '';
    }

    if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'])) {
        $navdirection = $session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'];
    } else {
        $navdirection = '';
    }

    // Initialise some parameters
    $pageName = basename($_SERVER['PHP_SELF']);
    $tabindex = 1;
    $agencyId = phpAds_getAgencyID();
    $aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid);

    // Display navigation
    $aOtherAdvertisers = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
    $aOtherCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $clientid));
    MAX_displayNavigationCampaign($pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);

    if ($submit && !empty($errors)) {
        // Message
        echo "<br>";
        echo "<div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
        echo "<span class='tab-r'>{$GLOBALS['strErrorEditingCampaign']}</span><br><br>";
        foreach ($errors as $aError) {
            echo "{$GLOBALS['strUnableToChangeCampaign']} - " . $aError->message . "<br>";
        }
        echo "</div>";
    }
} else {
    if (isset($move) && $move == 't') {
        // Convert client to campaign
        phpAds_PageHeader("4.1.3.2");
        echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
        echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
        phpAds_ShowSections(array("4.1.3.2"));
    } else {
        // New campaign
        phpAds_PageHeader("4.1.3.1");
        echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
        echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
        echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
        phpAds_ShowSections(array("4.1.3.1"));
    }
}

if ($campaignid != "" || (isset($move) && $move == 't')) {
    // Edit or Convert
    // Fetch exisiting settings
    // Parent setting for converting, campaign settings for editing
    if ($campaignid != "") {
        $ID = $campaignid;
    }
    if (isset($move) && $move == 't') {
        if (isset($clientid) && $clientid != "") {
            $ID = $clientid;
        }
    }

    // Get the campaign data from the campaign table, and store in $row
    $doCampaigns = OA_Dal::factoryDO('campaigns');
    $doCampaigns->selectAdd("views AS impressions");
    $doCampaigns->get($ID);
    $data = $doCampaigns->toArray();

    $row['campaignname']        = $data['campaignname'];
    $row['impressions']         = $data['impressions'];
    $row['clicks']              = $data['clicks'];
    $row['conversions']         = $data['conversions'];
    $row['expire']              = $data['expire'];
    if (OA_Dal::isValidDate($data['expire'])) {
        $oExpireDate                = new Date($data['expire']);
        $row['expire_f']            = $oExpireDate->format($date_format);
        $row['expire_dayofmonth']   = $oExpireDate->format('%d');
        $row['expire_month']        = $oExpireDate->format('%m');
        $row['expire_year']         = $oExpireDate->format('%Y');
    }
    $row['active']              = $data['active'];
    if (OA_Dal::isValidDate($data['activate'])) {
        $oActivateDate              = new Date($data['activate']);
        $row['activate_f']          = $oActivateDate->format($date_format);
        $row['activate_dayofmonth'] = $oActivateDate->format('%d');
        $row['activate_month']      = $oActivateDate->format('%m');
        $row['activate_year']       = $oActivateDate->format('%Y');
    }
    $row['priority']            = $data['priority'];
    $row['weight']              = $data['weight'];
    $row['target_impression']   = $data['target_impression'];
    $row['target_click']        = $data['target_click'];
    $row['target_conversion']   = $data['target_conversion'];
    $row['anonymous']           = $data['anonymous'];
    $row['companion']           = $data['companion'];
    $row['comments']            = $data['comments'];
    $row['revenue']             = $data['revenue'];
    $row['revenue_type']        = $data['revenue_type'];
    $row['block']               = $data['block'];
    $row['capping']             = $data['capping'];
    $row['session_capping']     = $data['session_capping'];
    $row['impressionsRemaining'] = '';
    $row['clicksRemaining'] = '';
    $row['conversionsRemaining'] = '';

    $row['impressionsRemaining'] = '';
    $row['clicksRemaining']      = '';
    $row['conversionsRemaining'] = '';

    // Get the campagin data from the data_intermediate_ad table, and store in $row
    if (($row['impressions'] >= 0) || ($row['clicks'] >= 0) || ($row['conversions'] >= 0)) {
        $dalData_intermediate_ad = OA_Dal::factoryDAL('data_intermediate_ad');
        $record = $dalData_intermediate_ad->getDeliveredByCampaign($campaignid);
        $data = $record->toArray();

        $row['impressionsRemaining'] = ($row['impressions']) ? ($row['impressions'] - $data['impressions_delivered']) : '';
        $row['clicksRemaining']      = ($row['clicks']) ? ($row['clicks'] - $data['clicks_delivered']) : '';
        $row['conversionsRemaining'] = ($row['conversions']) ? ($row['conversions'] - $data['conversions_delivered']) : '';
    }


    // Get the value to be used in the target_value field
    if ($row['target_impression'] > 0) {
        $row['target'] = $row['target_impression'];
        $target_type = 'target_impression';
        $target_value = $row['target_impression'];
    } elseif ($row['target_click'] > 0) {
        $row['target'] = $row['target_click'];
        $target_type = 'target_click';
        $target_value = $row['target_click'];
    } elseif ($row['target_conversion'] > 0) {
        $row['target'] = $row['target_conversion'];
        $target_type = 'target_conversion';
        $target_value = $row['target_conversion'];
    } else {
        $row['target'] = '-';
        $target_type = 'target_impression';
        $target_value = 0;
    }

    if ($row['target'] > 0) {
        $row['weight'] = '-';
    } else {
        $row['target'] = '-';
    }

    // Set default activation settings
    if (!isset($row["activate_dayofmonth"])) {
        $row["activate_dayofmonth"] = 0;
    }
    if (!isset($row["activate_month"])) {
        $row["activate_month"] = 0;
    }
    if (!isset($row["activate_year"])) {
        $row["activate_year"] = 0;
    }
    if (!isset($row["activate_f"])) {
        $row["activate_f"] = "-";
    }

    // Set default expiration settings
    if (!isset($row["expire_dayofmonth"])) {
        $row["expire_dayofmonth"] = 0;
    }
    if (!isset($row["expire_month"])) {
        $row["expire_month"] = 0;
    }
    if (!isset($row["expire_year"])) {
        $row["expire_year"] = 0;
    }
    if (!isset($row["expire_f"])) {
        $row["expire_f"] = "-";
    }

    // Set the default financial information
    if (!isset($row['revenue'])) {
        $row['revenue'] = '0.0000';
    }

} else {
    // New campaign
    $doClients = OA_Dal::factoryDO('clients');
    $doClients->clientid = $clientid;
    $client = $doClients->toArray();

    if ($doClients->find() && $doClients->fetch() && $client = $doClients->toArray()) {
        $row['campaignname'] = $client['clientname'].' - ';
    } else {
        $row["campaignname"] = '';
    }

    $row["campaignname"] .= $strDefault." ".$strCampaign;
    $row["impressions"] = '';
    $row["clicks"]         = '';
    $row["conversions"] = '';
    $row["active"]         = '';
    $row["expire"]         = '';
    $row["priority"]    = 0;
    $row["anonymous"]    = ($pref['gui_campaign_anonymous'] == 't') ? 't' : '';
    $row['revenue']     = '0.0000';
    $row['revenue_type']     = null;
    $row['target']     = null;
    $row['impressionsRemaining']     = null;
    $row['clicksRemaining']     = null;
    $row['conversionsRemaining']     = null;
    $row['companion']     = null;
    $row['block']     = null;
    $row['capping']     = null;
    $row['session_capping']     = null;
    $row['comments']     = null;
    $row['expire'] = null;
    $target_type = null;
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (!isset($row['impressions']) || (isset($row['impressions']) && $row['impressions'] == ""))
    $row["impressions"] = -1;
if (!isset($row['clicks']) || (isset($row['clicks']) && $row['clicks'] == ""))
    $row["clicks"] = -1;
if (!isset($row['conversions']) || (isset($row['conversions']) && $row['conversions'] == ""))
    $row["conversions"] = -1;
if (!isset($row['priority']) || (isset($row['priority']) && $row['priority'] == ""))
    $row["priority"] = 5;

if ($row['active'] == 't' && OA_Dal::isValidDate($row['expire']) && $row['impressions'] > 0)
    $delivery = 'auto';
elseif ($row['target'] > 0)
    $delivery = 'manual';
else
    $delivery = 'none';


function phpAds_showDateEdit($name, $day=0, $month=0, $year=0, $edit=true)
{
    global $strMonth, $strDontExpire, $strActivateNow, $tabindex;
    global $strActivationDateComment, $strExpirationDateComment;

    if ($day == 0 && $month == 0 && $year == 0)
    {
        $day = '-';
        $month = '-';
        $year = '-';
        $set = false;
    }
    else
    {
        $set = true;
    }

    if ($name == 'expire')
        $caption = $strDontExpire;
    elseif ($name == 'activate')
        $caption = $strActivateNow;

    if ($edit)
    {
        $set_id = $name . 'Set';
        $immediate_id = $set_id . '_immediate';
        $specific_id = $set_id . '_specific';
        $day_id = $name . 'Day';
        $month_id = $name . 'Month';
        $year_id = $name . 'Year';

        echo "<table><tr><td>";
        echo "<input type='radio' name='$set_id' id='$immediate_id' value='f' onclick=\"phpAds_formDateClick('".$name."', false);\"".($set==false?' checked':'')." tabindex='".($tabindex++)."'>";
        echo "&nbsp;$caption";
        echo "</td></tr><tr><td>";
        echo "<input type='radio' name='$set_id' id='$specific_id' value='t' onclick=\"phpAds_formDateClick('".$name."', true);\"".($set==true?' checked':'')." tabindex='".($tabindex++)."'>";
        echo "&nbsp;";

        echo "<select name='" . $day_id. "' id='" . $day_id . "' onchange=\"phpAds_formDateCheck('".$name."');\" tabindex='".($tabindex++)."'>\n";
        echo "<option value='-'".($day=='-' ? ' selected' : '').">-</option>\n";
        for ($i=1;$i<=31;$i++)
            echo "<option value='$i'".($day==$i ? ' selected' : '').">$i</option>\n";
        echo "</select>&nbsp;\n";

        echo "<select name='" . $month_id. "' id='" . $month_id . "' onchange=\"phpAds_formDateCheck('".$name."');\" tabindex='".($tabindex++)."'>\n";
        echo "<option value='-'".($month=='-' ? ' selected' : '').">-</option>\n";
        for ($i=1;$i<=12;$i++)
            echo "<option value='$i'".($month==$i ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
        echo "</select>&nbsp;\n";

        if ($year != '-')
            $start = $year < date('Y') ? $year : date('Y');
        else
            $start = date('Y');

        echo "<select name='" . $year_id. "' id='" . $year_id . "' onchange=\"phpAds_formDateCheck('".$name."');\" tabindex='".($tabindex++)."'>\n";
        echo "<option value='-'".($year=='-' ? ' selected' : '').">-</option>\n";
        for ($i=$start;$i<=($start+4);$i++)
            echo "<option value='$i'".($year==$i ? ' selected' : '').">$i</option>\n";
        echo "</select>\n";
        if ($name == 'activate') {
            echo "&nbsp;" . $strActivationDateComment;
        } elseif ($name == 'expire') {
            echo "&nbsp;" . $strExpirationDateComment;
        }
        echo "</td></tr></table>";
    }
    else
    {
        if ($set == true)
        {
            echo $day." ".$strMonth[$month-1]." ".$year;
        }
        else
        {
            echo $caption;
        }
    }
}

$tabindex = 1;

echo "<br /><br />";
echo "<form name='clientform' method='post' action='campaign-edit.php' onSubmit='return (max_formValidate(this) && phpAds_priorityCheck(this) && phpAds_activeRangeCheck(this));'>"."\n";
echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) ? $campaignid : '')."'>"."\n";
echo "<input type='hidden' name='clientid' value='".(isset($clientid) ? $clientid : '')."'>"."\n";
echo "<input type='hidden' name='expire' value='".(isset($row["expire"]) ? $row["expire"] : '')."'>"."\n";
echo "<input type='hidden' name='move' value='".(isset($move) ? $move : '')."'>"."\n";
echo "<input type='hidden' name='target_old' value='".(isset($row['target']) ? (int)$row['target'] : 0)."'>"."\n";
echo "<input type='hidden' name='weight_old' value='".(isset($row['weight']) ? (int)$row['weight'] : 0)."'>"."\n";
echo "<input type='hidden' name='active_old' value='".(isset($row['active']) && $row['active'] == 't' ? 't' : 'f')."'>"."\n";
echo "<input type='hidden' name='previousweight' value='".(isset($row["weight"]) ? $row["weight"] : '')."'>"."\n";
echo "<input type='hidden' name='previoustarget' value='".(isset($row["target"]) ? $row["target"] : '')."'>"."\n";
echo "<input type='hidden' name='previousactive' value='".(isset($row["active"]) ? $row["active"] : '')."'>"."\n";
echo "<input type='hidden' name='previousimpressions' value='".(isset($row["impressions"]) ? $row["impressions"] : '')."'>"."\n";
echo "<input type='hidden' name='previousclicks' value='".(isset($row["clicks"]) ? $row["clicks"] : '')."'>"."\n";
echo "<input type='hidden' name='previousconversions' value='".(isset($row["conversions"]) ? $row["conversions"] : '')."'>"."\n";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200'>".$strName."</td>"."\n";
echo "\t"."<td><input onBlur='phpAds_formPriorityUpdate(this.form);' class='flat' type='text' name='campaignname' size='35' style='width:350px;' value='".phpAds_htmlQuotes($row['campaignname'])."' tabindex='".($tabindex++)."'></td>"."\n";
echo "</tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr><td height='25' colspan='3'><b>".$strInventoryDetails."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

if (isset($row['active']) && $row['active'] == 'f')
{
    $expire_ts = mktime(23, 59, 59, $row["expire_month"], $row["expire_dayofmonth"], $row["expire_year"]);
    $inactivebecause = array();

    if ($row['impressions'] == 0) $inactivebecause[] =  $strNoMoreImpressions;
    if ($row['clicks'] == 0) $inactivebecause[] =  $strNoMoreClicks;
    if ($row['conversions'] == 0) $inactivebecause[] =  $strNoMoreConversions;
    if (time() < mktime(0, 0, 0, $row["activate_month"], $row["activate_dayofmonth"], $row["activate_year"])) $inactivebecause[] =  $strBeforeActivate;
    if (time() > $expire_ts && $expire_ts > 0) $inactivebecause[] =  $strAfterExpire;
    if ($row['target'] == 0  && $row['weight'] == 0) $inactivebecause[] =  $strWeightIsNull;

    echo "<tr>"."\n";
    echo "\t"."<td width='30' valign='top'>&nbsp;</td>"."\n";
    echo "\t"."<td colspan='2'><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>".$strClientDeactivated." ".join(', ', $inactivebecause)."</div><br /></td>"."\n";
    echo "</tr>"."\n";
    echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td></tr>"."\n";
}

echo "<tr><td colspan='3'>\n";
echo "  <table>\n";
echo "    <tr>\n";
echo "      <td width='30'>&nbsp;</td>\n";
echo "      <td width='200'>".$strImpressionsBooked."</td>\n";
echo "      <td>&nbsp;&nbsp;<input class='flat' type='text' name='impressions' size='25' value='".($row["impressions"] >= 0 ? $row["impressions"] : '-')."' onFocus=\"max_formUnFormat(this.form, 'impressions');\" onKeyUp=\"phpAds_formUnlimitedCheck('unlimitedimpressions', 'impressions');\" onBlur=\"max_formFormat(this.form, 'impressions'); max_formBookedUpdate(this.form);\" tabindex='".($tabindex++)."'>&nbsp;";
echo "          <input type='checkbox' name='unlimitedimpressions'".($row["impressions"] == -1 ? " CHECKED" : '')." onClick=\"phpAds_formUnlimitedClick('unlimitedimpressions', 'impressions');\" tabindex='".($tabindex++)."'>&nbsp;".$strUnlimited."</td>\n";
echo "      <td width='50'>&nbsp;</td>\n";
echo "      <td width='200'><div id='remainingImpressionsTitle' style='visibility: hidden;'>$strImpressionsRemaining</div></td>";
echo "      <td><div id='remainingImpressionsCount' style='visibility: hidden;'>".$row["impressionsRemaining"]."</div></td>\n";

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td><img src='images/spacer.gif' height='1' width='100%'></td>\n";
echo "      <td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td width='30'>&nbsp;</td>\n";
echo "      <td width='200'>".$strClicksBooked."</td>\n";
echo "      <td>&nbsp;&nbsp;<input class='flat' type='text' name='clicks' size='25' value='".($row["clicks"] >= 0 ? $row["clicks"] : '-')."' onFocus=\"max_formUnFormat(this.form, 'clicks');\" onKeyUp=\"phpAds_formUnlimitedCheck('unlimitedclicks', 'clicks');\" onBlur=\"max_formFormat(this.form, 'clicks'); max_formBookedUpdate(this.form);\" tabindex='".($tabindex++)."'>&nbsp;";
echo "          <input type='checkbox' name='unlimitedclicks'".($row["clicks"] == -1 ? " CHECKED" : '')." onClick=\"phpAds_formUnlimitedClick('unlimitedclicks', 'clicks');\" tabindex='".($tabindex++)."'>&nbsp;".$strUnlimited."</td>\n";
echo "      <td width='50'>&nbsp;</td>\n";
echo "      <td width='200'><div id='remainingClicksTitle' style='visibility: hidden;'>$strClicksRemaining</div></td>";
echo "      <td><div id='remainingClicksCount' style='visibility: hidden;'>".$row["clicksRemaining"]."</div></td>\n";

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td><img src='images/spacer.gif' height='1' width='100%'></td>\n";
echo "      <td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td width='30'>&nbsp;</td>\n";
echo "      <td width='200'>".$strConversionsBooked."</td>\n";
echo "      <td>&nbsp;&nbsp;<input class='flat' type='text' name='conversions' size='25' value='".($row["conversions"] >= 0 ? $row["conversions"] : '-')."' onFocus=\"max_formUnFormat(this.form, 'conversions');\" onKeyUp=\"phpAds_formUnlimitedCheck('unlimitedconversions', 'conversions');\" onBlur=\"max_formFormat(this.form, 'conversions'); max_formBookedUpdate(this.form);\" tabindex='".($tabindex++)."'>&nbsp;";
echo "          <input type='checkbox' name='unlimitedconversions'".($row["conversions"] == -1 ? " CHECKED" : '')." onClick=\"phpAds_formUnlimitedClick('unlimitedconversions', 'conversions');\" tabindex='".($tabindex++)."'>&nbsp;".$strUnlimited."</td>\n";
echo "      <td width='50'>&nbsp;</td>\n";
echo "      <td width='200'><div id='remainingConversionsTitle' style='visibility: hidden;'>$strConversionsRemaining</div></td>";
echo "      <td><div id='remainingConversionsCount' style='visibility: hidden;'>".$row["conversionsRemaining"]."</div></td>\n";

echo "    </tr>\n";
echo "  </table>\n";
echo "</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strContractDetails."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td><td width='200' valign='top'>".$strActivationDate."</td>"."\n";
echo "\t"."<td>";
phpAds_showDateEdit('activate', isset($row["activate_dayofmonth"]) ? $row["activate_dayofmonth"] : 0,
                                   isset($row["activate_month"]) ? $row["activate_month"] : 0,
                                isset($row["activate_year"]) ? $row["activate_year"] : 0);
echo "</td>"."\n";
echo "</tr>"."\n";
echo "<tr>"."\n";
echo "\t"."<td><img src='images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td><td width='200' valign='top'>".$strExpirationDate."</td>"."\n";
echo "\t"."<td>";
phpAds_showDateEdit('expire', isset($row["expire_dayofmonth"]) ? $row["expire_dayofmonth"] : 0,
                              isset($row["expire_month"]) ? $row["expire_month"] : 0,
                              isset($row["expire_year"]) ? $row["expire_year"] : 0);
echo "</td>"."\n";
echo "</tr>"."\n";
echo "<tr>"."\n";
echo "\t"."<td><img src='images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "<td width='30'>&nbsp;</td><td width='200'>".$strRevenueInfo."</td>"."\n";
echo "<td>";
echo "&nbsp;&nbsp;<input type='text' name='revenue' size='10' value='{$row["revenue"]}' tabindex='".($tabindex++)."'>&nbsp;";
echo "&nbsp;&nbsp;";
echo "<select name='revenue_type'>";
echo "  <option value='".MAX_FINANCE_CPM."' ".(($row['revenue_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
echo "  <option value='".MAX_FINANCE_CPC."' ".(($row['revenue_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
echo "  <option value='".MAX_FINANCE_CPA."' ".(($row['revenue_type'] == MAX_FINANCE_CPA) ? ' SELECTED ' : '').">$strFinanceCPA</option>";
echo "  <option value='".MAX_FINANCE_MT."' ".(($row['revenue_type'] == MAX_FINANCE_MT) ? ' SELECTED ' : '').">$strFinanceMT</option>";
echo "</select>";
echo "</td>"."\n";
echo "</tr>"."\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strPriorityInformation."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200' valign='top'>".$strPriorityLevel."</td>"."\n";
echo "\t"."<td>"."\n";
echo "\t\t"."<table>"."\n";

echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' name='priority' value='-1'".($row['priority'] == '-1' ? ' checked' : '')." onClick=\"phpAds_formPriorityRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strExclusive."</td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityExclusive."</td>"."\n";
echo "\t\t"."</tr>"."\n";


echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' name='priority' value='2'".(($row['priority'] > '0' && $campaignid != '') ? ' checked' : '')." onClick=\"phpAds_formPriorityRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'> <select name='high_priority_value'>";
for ($i = 10; $i >= 1; $i--) {
    echo "<option value='$i'".($row['priority'] == $i ? 'SELECTED' : '').">$strHigh ($i)</option>";
}
echo "</select></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityHigh."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t\t"."<td valign='top'><input type='radio' name='priority' value='0'".(($row['priority'] == '0' || $campaignid == '') ? ' checked' : '')." onClick=\"phpAds_formPriorityRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strLow."</td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityLow."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t"."</table>"."\n";
echo "\t"."</td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td><img src='images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200' valign='top'>".$strPriorityTargeting    ."</td>"."\n";
echo "\t"."<td>"."\n";
echo "\t\t"."<table>"."\n";
echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' name='delivery' value='auto'".($delivery == 'auto' ? ' checked' : '')." onClick=\"phpAds_formDeliveryRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityAutoTargeting."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' name='delivery' value='manual'".($delivery == 'manual' ? ' checked' : '')." onClick=\"phpAds_formDeliveryRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'> <select name='target_type'>";
echo "<option value='limit_impression' ".(($target_type == 'target_impression') ? ' SELECTED ' : ''). ">$strImpressions</option>";
echo "<option value='limit_click' ".(($target_type == 'target_click') ? ' SELECTED ' : '').">$strClicks</option>";
echo "<option value='limit_conversion' ".(($target_type == 'target_conversion') ? ' SELECTED ' : '').">$strConversions</option>";
echo "</select> $strTo <input onBlur='phpAds_formPriorityUpdate(this.form);' class='flat' type='text' name='target_value' size='7' value='".(!empty($target_value) ? $target_value : '-')."' tabindex='".($tabindex++)."'> ".$strTargetPerDay."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' name='delivery' value='none'".($delivery == 'none' ? ' checked' : '')." onClick=\"phpAds_formDeliveryRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strCampaignWeight.": <input onBlur='phpAds_formPriorityUpdate(this.form);' class='flat' type='text' name='weight' size='7' value='".(isset($row["weight"]) ? $row["weight"] : $pref['default_campaign_weight'])."' tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t"."</tr>"."\n";
echo "\t\t"."</table>"."\n";
echo "\t"."</td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td><img src='images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200' valign='top'>".$strPriorityOptimisation."</td>"."\n";
echo "\t"."<td>"."\n";
echo "\t\t"."<table>"."\n";
echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='checkbox' name='anonymous' value='t'".($row['anonymous'] == 't' ? ' checked' : '')." tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strAnonymous."</td>"."\n";
echo "\t\t"."</tr>"."\n";
echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='checkbox' name='companion' value='1'".($row['companion'] == '1' ? ' checked' : '')." tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strCompanionPositioning."</td>"."\n";
echo "\t\t"."</tr>"."\n";
echo "\t\t"."</table>"."\n";
echo "\t"."</td>"."\n";
echo "</tr>"."\n";

echo "</td>"."\n";
echo "</tr>"."\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td colspan='3'><table cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
$tabindex = _echoDeliveryCappingHtml($tabindex, $GLOBALS['strCappingCampaign'], $row);
echo "</table></td></tr>\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strMiscellaneous."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strComments."</td>";

echo "<td><textarea class='code' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".htmlentities($row['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "</table>"."\n";

echo "<br /><br />"."\n";
echo "<input type='submit' name='submit' value='".$strSaveChanges."' tabindex='".($tabindex++)."'>"."\n";

echo "</form>"."\n";


/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique campaignname
$doCampaigns = OA_Dal::factoryDO('campaigns');
$doCampaigns->clientid = $clientid;
$unique_names = $doCampaigns->getUniqueValuesFromColumn('campaignname', $row['campaignname']);
?>
<script language='javascript' type='text/javascript' src='js/datecheck.js'></script>
<script language='javascript' type='text/javascript' src='js/numberFormat.php'></script>
<script language='JavaScript'>
<!--
    max_formSetRequirements('campaignname', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetRequirements('impressions', '<?php echo addslashes($strImpressionsBooked); ?>', false, 'formattedNumber');
    max_formSetRequirements('clicks', '<?php echo addslashes($strClicksBooked); ?>', false, 'formattedNumber');
    max_formSetRequirements('conversions', '<?php echo addslashes($strConversionsBooked); ?>', false, 'formattedNumber');
    max_formSetRequirements('weight', '<?php echo addslashes($strCampaignWeight); ?>', false, 'number');
    max_formSetRequirements('target_value', '<?php echo addslashes($strTargetPerDay); ?>', false, 'number+');
    max_formSetUnique('campaignname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');

    var previous_target = '';
    var previous_weight = '';
    var previous_priority = '';

    var impressions_delivered = <?php echo (isset($data['impressions_delivered'])) ? $data['impressions_delivered'] : 0; ?>;
    var clicks_delivered = <?php echo (isset($data['clicks_delivered'])) ? $data['clicks_delivered'] : 0; ?>;
    var conversions_delivered = <?php echo (isset($data['conversions_delivered'])) ? $data['conversions_delivered'] : 0; ?>;

    function phpAds_priorityCheck(f)
    {
        if (f.delivery[1].checked && !parseInt(f.target_value.value)) {
            return confirm ('<?php echo str_replace("\n", '\n', addslashes($strCampaignWarningNoTarget)); ?>');
        }
        if (f.delivery[2].checked && !parseInt(f.weight.value)) {
            return confirm ('<?php echo str_replace("\n", '\n', addslashes($strCampaignWarningNoWeight)); ?>');
        }
        return true;
    }

    function phpAds_formDateClick(o, value)
    {
        day = eval ("document.clientform." + o + "Day.value");
        month = eval ("document.clientform." + o + "Month.value");
        year = eval ("document.clientform." + o + "Year.value");
        if (value == false) {
            eval ("document.clientform." + o + "Day.selectedIndex = 0");
            eval ("document.clientform." + o + "Month.selectedIndex = 0");
            eval ("document.clientform." + o + "Year.selectedIndex = 0");
        }
        if (value == true && (day=='-' || month=='-' || year=='-')) {
            eval ("document.clientform." + o + "Set[0].checked = true");
        }
        if (o == 'expire') {
            phpAds_formPriorityUpdate(document.clientform);
        }
    }

    function phpAds_formDateCheck(o)
    {
        day = eval ("document.clientform." + o + "Day.value");
        month = eval ("document.clientform." + o + "Month.value");
        year = eval ("document.clientform." + o + "Year.value");
        if (day=='-' || month=='-' || year=='-') {
            eval ("document.clientform." + o + "Set[0].checked = true");
        } else {
            eval ("document.clientform." + o + "Set[1].checked = true");
        }
        if (o == 'expire') {
            phpAds_formPriorityUpdate(document.clientform);
        }
    }

    function phpAds_activeRangeCheck(form)
    {
        var activeDate;
        var expireDate;
        var activation_enabled = isDateSetActive('activate', form);
        var expiry_enabled = isDateSetActive('expire', form);
        // No sense in comparing inactive values
        if ((activation_enabled && expiry_enabled)) {
            activateDate = newDateFromNamedFields(document, form, 'activate');
            expireDate = newDateFromNamedFields(document, form, 'expire');
            if (!activateDate) {
                alert('The start date of this campaign is not a valid date');
                return false;
            }
            if (!expireDate) {
                alert('The end date of this campaign is not a valid date');
                return false;
            }
            if (!isDateEqual(activateDate, expireDate) && isDateBefore(expireDate, activateDate)) {
                alert('The selected dates for this campaign are invalid\n(Campaign ends before it starts!).\n');
                return false;
            }
        }
        return true;
    }

    function phpAds_formUnlimitedClick(oc,oe)
    {
        e = findObj(oe);
        c = findObj(oc);
        if (c.checked == true) {
            e.value = "-";
        } else {
            e.value = "";
            e.focus();
        }
        // Update check
        max_formBookedUpdate(e.form);
    }

    function phpAds_enableRadioButton(field_name, field_value, enabled)
    {
        var radio_group = findObj(field_name);
        for (var i = 0; i < radio_group.length; i++) {
            if (radio_group[i].value == field_value) {
                radio_group[i].disabled = !enabled;
                break;
            }
        }
    }

    function phpAds_enableSelect(field_name, enabled)
    {
        var obj = findObj(field_name);
        obj.disabled = !enabled;
    }

    function phpAds_enableTextField(field_name, previous_field, enabled)
    {
        var obj = findObj(field_name);
        if (enabled) {
            if (obj.disabled) {
                obj.value = previous_field;
                obj.disabled = !enabled;
            }
        } else {
            if (!obj.disabled) {
                previous_field = obj.value;
                obj.value = '-';
                obj.disabled = true;
            }
        }
        return previous_field;
    }

    function phpAds_formPriorityRadioClick(rd)
    {
        phpAds_formPriorityUpdate(rd.form);
    }

    function phpAds_formDeliveryRadioClick(rd)
    {
        phpAds_formPriorityUpdate(rd.form);
        if (rd.value == '1') {
            f.target_value.select();
            f.target_value.focus();
        } else if (rd.value == '0') {
            f.weight.select();
            f.weight.focus();
        }
    }

    function phpAds_formUnlimitedCheck(oc,oe)
    {
        e = findObj(oe);
        c = findObj(oc);
        if ((e.value == '-') || (e.value == 0)) {
            c.checked = true;
        } else {
            c.checked = false;
        }
        max_formBookedUpdate(e.form);
    }

    function phpAds_setRemainingVisibility(elementName, visibility) {
        if (visibility) {
            visible = 'visible';
        } else {
            visible = 'hidden';
        }
        document.getElementById(elementName).style.visibility = visible;
    }


    function max_formUnFormat(f, type)
    {
        if (type == 'impressions') {
            if (f.impressions.value != '-') {
                f.impressions.value = max_formattedNumberStringToFloat(f.impressions.value);
            } else {
                f.impressions.value = '';
            }
        }
        if (type == 'clicks') {
            if (f.clicks.value != '-') {
                f.clicks.value = max_formattedNumberStringToFloat(f.clicks.value);
            } else {
                f.clicks.value = '';
            }
        }
        if (type == 'conversions') {
            if (f.conversions.value != '-') {
                f.conversions.value = max_formattedNumberStringToFloat(f.conversions.value);
            } else {
                f.conversions.value = '';
            }
        }
    }

    function max_formFormat(f, type)
    {
        if (type == 'impressions') {
            if ((f.impressions.value == '') || (f.impressions.value == 0)) {
                f.impressions.value = '-';
            }
            if (f.impressions.value != '-') {
                f.impressions.value = max_formatNumberIngnoreDecimals(f.impressions.value);
            }
        }
        if (type == 'clicks') {
            if ((f.clicks.value == '') || (f.clicks.value == 0)) {
                f.clicks.value = '-';
            }
            if (f.clicks.value != '-') {
                f.clicks.value = max_formatNumberIngnoreDecimals(f.clicks.value);
            }
        }
        if (type == 'conversions') {
            if ((f.conversions.value == '') || (f.conversions.value == 0)) {
                f.conversions.value = '-';
            }
            if (f.conversions.value != '-') {
                f.conversions.value = max_formatNumberIngnoreDecimals(f.conversions.value);
            }
        }
    }

    function max_formBookedUpdate(f)
    {
        // Update remaining impressions/click/conversions
        if (max_formattedNumberStringToFloat(f.impressions.value) >= 0) {
            var remaining = max_formattedNumberStringToFloat(f.impressions.value) - impressions_delivered;
            document.getElementById('remainingImpressionsCount').innerHTML = max_formatNumberIngnoreDecimals(remaining);
            visibility = true;
        } else {
            visibility = false;
        }
        phpAds_setRemainingVisibility('remainingImpressionsCount', visibility);
        phpAds_setRemainingVisibility('remainingImpressionsTitle', visibility);

        if (max_formattedNumberStringToFloat(f.clicks.value) >= 0) {
            var remaining = max_formattedNumberStringToFloat(f.clicks.value) - clicks_delivered;
            document.getElementById('remainingClicksCount').innerHTML = max_formatNumberIngnoreDecimals(remaining);
            visibility = true;
        } else {
            visibility = false;
        }
        phpAds_setRemainingVisibility('remainingClicksCount', visibility);
        phpAds_setRemainingVisibility('remainingClicksTitle', visibility);

        if (max_formattedNumberStringToFloat(f.conversions.value) >= 0) {
            var remaining = max_formattedNumberStringToFloat(f.conversions.value) - conversions_delivered;
            document.getElementById('remainingConversionsCount').innerHTML = max_formatNumberIngnoreDecimals(remaining);
            visibility = true;
        } else {
            visibility = false;
        }
        phpAds_setRemainingVisibility('remainingConversionsCount', visibility);
        phpAds_setRemainingVisibility('remainingConversionsTitle', visibility);
        phpAds_formPriorityUpdate(f);
    }

    function phpAds_formPriorityUpdate(f)
    {
        // Check to see if autotargeting is available. Autotargeting is
        // available when there is an expiration date and one of a set
        // number of target impressions, clicks or conversions
        var autotarget_available =  ( !(f.expireSet[0].checked == true) &&
                                      (
                                        (!( isNaN(max_formattedNumberStringToFloat(f.impressions.value)) || (f.impressions.value == '') || (f.unlimitedimpressions.checked == true))) ||
                                        (!( isNaN(max_formattedNumberStringToFloat(f.clicks.value))      || (f.clicks.value == '')      || (f.unlimitedclicks.checked == true))) ||
                                        (!( isNaN(max_formattedNumberStringToFloat(f.conversions.value)) || (f.conversions.value == '') || (f.unlimitedconversions.checked == true)))
                                      )
                                    );
        // When autotargeting is available, only High-Priority
        // campaigns possible; disable Low and Exclusive campaign
        // buttons, and check the High-Priorty campaign button
        f.priority[0].disabled = autotarget_available;
        f.priority[1].disabled = false;
        if (autotarget_available) {
            f.priority[1].checked = true;
        }
        f.priority[2].disabled = autotarget_available;
        // If an Exclusive campaign
        if (!f.priority[0].disabled && f.priority[0].checked) {
            phpAds_enableRadioButton('delivery', 'auto', false);
            phpAds_enableRadioButton('delivery', 'manual', false);
            phpAds_enableRadioButton('delivery', 'none', true);
            phpAds_enableSelect('high_priority_value', false);
            phpAds_enableSelect('target_type', false);
        }
        // If a High-Priority campaign
        if (!f.priority[1].disabled && f.priority[1].checked) {
            phpAds_enableRadioButton('delivery', 'auto', autotarget_available);
            phpAds_enableRadioButton('delivery', 'manual', !autotarget_available);
            phpAds_enableRadioButton('delivery', 'none', false);
            phpAds_enableSelect('high_priority_value', true);
            phpAds_enableSelect('target_type', !autotarget_available);
        }
        // If a Low-Priority campaign
        if (!f.priority[2].disabled && f.priority[2].checked) {
            phpAds_enableRadioButton('delivery', 'auto', false);
            phpAds_enableRadioButton('delivery', 'manual', false);
            phpAds_enableRadioButton('delivery', 'none', true);
            phpAds_enableSelect('high_priority_value', false);
            phpAds_enableSelect('target_type', false);
        }
        // If a checked priority radio button has been disabled
        if ( (f.priority[0].checked && f.priority[0].disabled) ||
             (f.priority[1].checked && f.priority[1].disabled) ||
             (f.priority[2].checked && f.priority[2].disabled) ) {
            // Try to set the right radio button
            if (!f.priority[0].disabled) {
                f.priority[0].checked = true;
            } else if (!f.priority[1].disabled) {
                f.priority[1].checked = true;
            } else if (!f.priority[2].disabled) {
                f.priority[2].checked = true;
            }
        }
        // If a checked distribution radio button has been disabled
        if ( (f.delivery[0].checked && f.delivery[0].disabled) ||
             (f.delivery[1].checked && f.delivery[1].disabled) ||
             (f.delivery[2].checked && f.delivery[2].disabled) ) {
            // Try to set the right radio button
            if (!f.delivery[0].disabled) {
                f.delivery[0].checked = true;
            } else if (!f.delivery[1].disabled) {
                f.delivery[1].checked = true;
            } else if (!f.delivery[2].disabled) {
                f.delivery[2].checked = true;
                // As selecting the weight-based distribution, set
                // the weight to a default of 1, if not already set
                if ((previous_weight == '-') || (previous_weight == 0)) {
                    previous_weight = 1;
                }
            }
        }
        // Only enable target/weight if their radio buttons are checked.
        var len = f.delivery.length;
        for (var i = 0; i < f.delivery.length; i++) {
            if (!f.delivery[i].disabled && f.delivery[i].checked) {
                if (f.delivery[i].value == 'auto') {
                    previous_target = phpAds_enableTextField('target_value', previous_target, false);
                    previous_weight = phpAds_enableTextField('weight', previous_weight, false);
                } else if (f.delivery[i].value == 'manual') {
                    previous_target = phpAds_enableTextField('target_value', previous_target, true);
                    previous_weight = phpAds_enableTextField('weight', previous_weight, false);
                } else if (f.delivery[i].value == 'none') {
                    previous_target = phpAds_enableTextField('target_value', previous_target, false);
                    previous_weight = phpAds_enableTextField('weight', previous_weight, true);
                }
                break;
            }
        }
    }

    // Format the target numbers on page load
    max_formFormat(document.clientform, 'impressions');
    max_formFormat(document.clientform, 'clicks');
    max_formFormat(document.clientform, 'conversions');

    // Display remaining target data on page load
    max_formBookedUpdate(document.clientform);

//-->
</script>

<?php

_echoDeliveryCappingJs();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

_echoDeliveryCappingJs();

phpAds_PageFooter();

?>
