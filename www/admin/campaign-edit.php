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
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/other/capping/lib-capping.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/OA/Admin/NumberFormat.php';

// Register input variables
phpAds_registerGlobalUnslashed(
     'start'
    ,'startSet'
    ,'anonymous'
    ,'campaignname'
    ,'clicks'
    ,'companion'
    ,'comments'
    ,'conversions'
    ,'end'
    ,'endSet'
    ,'move'
    ,'priority'
    ,'high_priority_value'
    ,'revenue'
    ,'revenue_type'
    ,'submit'
    ,'submit_status'
    ,'target_old'
    ,'target_type_old'
    ,'target_value'
    ,'target_type'
    ,'rd_impr_bkd'
    ,'rd_click_bkd'
    ,'rd_conv_bkd'
    ,'impressions'
    ,'weight_old'
    ,'weight'
    ,'clientid'
    ,'status'
    ,'status_old'
    ,'as_reject_reason'
    ,'an_status'
    ,'previousimpressions'
    ,'previousconversions'
    ,'previousclicks'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients',   $clientid);
OA_Permission::enforceAccessToObject('campaigns', $campaignid, true);

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
if (isset($submit)) {
	$expire = !empty($end) ? date('Y-m-d', strtotime($end)) : OA_Dal::noDateValue();
    $activate = !empty($start) ? date('Y-m-d', strtotime($start)) : OA_Dal::noDateValue();

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

    //correct and check revenue

    //correction revenue from other formats (23234,34 or 23 234,34 or 23.234,34)
    //to format acceptable by is_numeric (23234.34)
    $corrected_revenue = OA_Admin_NumberFormat::unformatNumber($revenue);
    if ( $corrected_revenue !== false ) {
        $revenue = $corrected_revenue;
        unset($corrected_revenue);
    }
    if (!empty($revenue) && !(is_numeric($revenue))) {
        // Suppress PEAR error handling to show this error only on top of HTML form
        PEAR::pushErrorHandling(null);
        $errors[] = PEAR::raiseError($GLOBALS['strErrorEditingCampaignRevenue']);
        PEAR::popErrorHandling();
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
        if (!isset($rd_impr_bkd) || $rd_impr_bkd != 'no') {
            $impressions = -1;
        }
        if (!isset($rd_click_bkd) || $rd_click_bkd != 'no') {
            $clicks = -1;
        }
        if (!isset($rd_conv_bkd) || $rd_conv_bkd != 'no') {
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
                    $target_type_variable = 'target_impression';
                    break;

                case 'limit_click':
                    $target_click = $target_value;
                    $target_type_variable = 'target_click';
                    break;

                case 'limit_conversion':
                    $target_conversion = $target_value;
                    $target_type_variable = 'target_conversion';
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

        if ($anonymous != 't') {
            $anonymous = 'f';
        }
        if ($companion != 1) {
            $companion = 0;
        }
        $new_campaign = $campaignid == 'null';

        if (empty($revenue) || ($revenue <= 0)) {
            // No revenue information, set to null
            $revenue = 'NULL';
            $revenue_type = 'NULL';
        }

        // Get the capping variables
        _initCappingVariables();

        $noDateValue = OA_Dal::noDateValue();
        if (!isset($noDateValue)) {
            $noDateValue = 0;
        }

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = $campaignname;
        $doCampaigns->clientid = $clientid;
        $doCampaigns->views = $impressions;
        $doCampaigns->clicks = $clicks;
        $doCampaigns->conversions = $conversions;
        $doCampaigns->expire = OA_Dal::isValidDate($expire) ? $expire : $noDateValue;
        $doCampaigns->activate = OA_Dal::isValidDate($activate) ? $activate : $noDateValue;
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
        // - campaign changes status (activated or deactivated) or
        // - the campaign is active and target/weight are changed
        //
        if (!$new_campaign) {
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignid);
            $status = $doCampaigns->status;
            switch(true) {
            case ((bool)$status != (bool)$status_old):
                // Run the Maintenance Priority Engine process
                OA_Maintenance_Priority::scheduleRun();
                break;
            case ($status == OA_ENTITY_STATUS_RUNNING):
                if ((!empty($target_type_variable) && ${$target_type_variable} != $target_old)
                    || (!empty($target_type) && $target_type_old != $target_type)
                    || $weight != $weight_old
                    || $clicks != $previousclicks
                    || $conversions != $previousconversions
                    || $impressions != $previousimpressions) {
                    // Run the Maintenance Priority Engine process
                    OA_Maintenance_Priority::scheduleRun();
                }
                break;
            }
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
        $group = 'campaign_'.$campaignid;
        $cache->clean($group);

        $oUI = new OA_Admin_UI();
        MAX_Admin_Redirect::redirect($oUI->getNextPage());
    }
}

if (isset($submit_status) && $campaignid) {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid       = $campaignid;
        $doCampaigns->as_reject_reason = $as_reject_reason;
        $doCampaigns->status           = $status;
        $doCampaigns->update();

        // Run the Maintenance Priority Engine process
        OA_Maintenance_Priority::scheduleRun();

        MAX_Admin_Redirect::redirect("campaign-edit.php?clientid=$clientid&campaignid=$campaignid");
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($campaignid != "") {
    // Initialise some parameters
    $pageName = basename($_SERVER['PHP_SELF']);
    $tabindex = 1;
    $agencyId = OA_Permission::getAgencyId();
    $aEntities = array('clientid' => $clientid, 'campaignid' => $campaignid);

    // Display navigation
    $aOtherAdvertisers = Admin_DA::getAdvertisers(array('agency_id' => $agencyId));
    $aOtherCampaigns = Admin_DA::getPlacements(array('advertiser_id' => $clientid));
    MAX_displayNavigationCampaign($pageName, $aOtherAdvertisers, $aOtherCampaigns, $aEntities);

    if ($submit && !empty($errors)) {
        // Message
        echo "<br>";
        echo "<div class='errormessage'><img class='errormessage' src='" . MAX::assetPath() . "/images/errormessage.gif' align='absmiddle'>";
        echo "<span class='tab-r'>{$GLOBALS['strErrorEditingCampaign']}</span><br><br>";
        foreach ($errors as $aError) {
            echo "{$GLOBALS['strUnableToChangeCampaign']} - " . $aError->message . "<br>";
        }
        echo "</div>";
    }
} else {
    $advertiser = phpAds_getClientDetails($clientid);
    $advertiserName = $advertiser['clientname'];
    $advertiserEditUrl = "advertiser-edit.php?clientid=$clientid";

   // New campaign
    phpAds_PageHeader("campaign-edit_new");
    MAX_displayInventoryBreadcrumbs(array(
                                        array("name" => $advertiserName, "url" => $advertiserEditUrl),
                                        array("name" => "")),
                                    "campaign", true);
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
    $row['status']                  = $doCampaigns->status;
    $row['an_status']               = $doCampaigns->an_status;
    $row['as_reject_reason']        = $doCampaigns->as_reject_reason;

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
    $row['revenue']             = OA_Admin_NumberFormat::formatNumber($data['revenue'], 4);
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
        $row['revenue'] = OA_Admin_NumberFormat::formatNumber(0, 4);
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
    $row["status"]         = (int)$status;
    $row["expire"]         = '';
    $row["activate"]       = '';
    $row["priority"]    = 0;
    $row["anonymous"]    = ($pref['gui_campaign_anonymous'] == 't') ? 't' : '';
    $row['revenue']     = OA_Admin_NumberFormat::formatNumber(0, 4);;
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
if ($row['status'] == OA_ENTITY_STATUS_RUNNING && OA_Dal::isValidDate($row['expire']) && $row['impressions'] > 0)
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
        $set = false;
    }
    else
    {
        $set = true;
    }

    if ($name == 'end')
        $caption = $strDontExpire;
    elseif ($name == 'start')
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
        echo "&nbsp;<label for='$immediate_id'>$caption</label>";
        echo "</td></tr><tr><td>";
        echo "<input type='radio' name='$set_id' id='$specific_id' value='t' onclick=\"phpAds_formDateClick('".$name."', true);\"".($set==true?' checked':'')." tabindex='".($tabindex++)."'>";
        echo "&nbsp;";

        if ($set) {
        $oDate = new Date($year .'-'. $month .'-'. $day);
        }
        $dateStr = is_null($oDate) ? '' : $oDate->format('%d %B %Y ');

        echo "
        <input class='date' name='{$name}' id='{$name}' type='text' value='$dateStr' tabindex='".$tabindex++."' onchange=\"phpAds_formDateCheck('".$name."');\"/>
        <input type='image' src='" . MAX::assetPath() . "/images/icon-calendar.gif' id='{$name}_button' align='absmiddle' border='0' tabindex='".$tabindex++."' />
        <script type='text/javascript'>
        <!--
        Calendar.setup({
            inputField : '{$name}',
            ifFormat   : '%d %B %Y',
            button     : '{$name}_button',
            align      : 'Bl',
            weekNumbers: false,
            firstDay   : " . ($GLOBALS['pref']['begin_of_week'] ? 1 : 0) . ",
            electric   : false
        })
        //-->
        </script>";

        if ($name == 'start') {
            echo "&nbsp;" . $strActivationDateComment;
        } elseif ($name == 'end') {
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

function phpAds_showStatusText($status, $an_status = 0) {
    global $strCampaignStatusRunning, $strCampaignStatusPaused, $strCampaignStatusAwaiting,
           $strCampaignStatusExpired, $strCampaignStatusApproval, $strCampaignStatusRejected;

        switch ($status) {
        	case OA_ENTITY_STATUS_PENDING:
        	    if ($an_status == OA_ENTITY_ADNETWORKS_STATUS_APPROVAL) {
            	    $class = 'sts sts-awaiting';
            	    $text  = $strCampaignStatusApproval;
        	    }

        	    if ($an_status == OA_ENTITY_ADNETWORKS_STATUS_REJECTED) {
            	    $class = 'sts sts-rejected';
            	    $text  = $strCampaignStatusRejected;
        	    }
        		break;
                	case OA_ENTITY_STATUS_RUNNING:
                	    $class = 'sts sts-accepted';
                	    $text  = $strCampaignStatusRunning;
                		break;
                	case OA_ENTITY_STATUS_PAUSED:
                	    $class = 'sts sts-paused';
                	    $text  = $strCampaignStatusPaused;
                		break;
                	case OA_ENTITY_STATUS_AWAITING:
                	    $class = 'sts not-started';
                	    $text  = $strCampaignStatusAwaiting;
                		break;
                	case OA_ENTITY_STATUS_EXPIRED:
                	    $class = 'sts sts-finished';
                	    $text  = $strCampaignStatusExpired;
                		break;
                	case OA_ENTITY_STATUS_APPROVAL:
                	    $class = 'sts sts-awaiting';
                	    $text  = $strCampaignStatusApproval;
                		break;
                	case OA_ENTITY_STATUS_REJECTED:
                	    $class = 'sts sts-rejected';
                	    $text  = $strCampaignStatusRejected;
                		break;
                }

                echo '<span class="'.$class.'">' . $text . '</span>';
}

function phpAds_showStatusRejected($reject_reason) {
    global $strReasonSiteNotLive, $strReasonBadCreative, $strReasonBadUrl,
            $strReasonBreakTerms, $strCampaignStatusRejected;

    switch ($reject_reason) {
    	case OA_ENTITY_ADVSIGNUP_REJECT_NOTLIVE:
    		$text = $strReasonSiteNotLive;
    		break;
    	case OA_ENTITY_ADVSIGNUP_REJECT_BADCREATIVE:
    		$text = $strReasonBadCreative;
    		break;
    	case OA_ENTITY_ADVSIGNUP_REJECT_BADURL:
    		$text = $strReasonBadUrl;
    		break;
    	case OA_ENTITY_ADVSIGNUP_REJECT_BREAKTERMS:
    		$text = $strReasonBreakTerms;
    		break;
    }

    echo $strCampaignStatusRejected . ": " . $text;
}

$tabindex = 1;

echo "<br /><br />";

if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) {
    echo "<form name='statusChangeForm' method='post' action='campaign-edit.php' >"."\n";
    echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) ? $campaignid : '')."'>"."\n";
    echo "<input type='hidden' name='clientid' value='".(isset($clientid) ? $clientid : '')."'>"."\n";
    ?>

        <tr>
            <td width="30">&nbsp;</td>
            <td width="200" valign="top"><?php echo $strStatus; ?></td>
            <td>
                <table>
                <tbody>
                <?php
                    if ($row['status'] == OA_ENTITY_STATUS_APPROVAL) {
                ?>
                <tr>
                    <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_RUNNING; ?>" name="status" id="sts_approve" tabindex='<?php echo ($tabindex++); ?>' /></td>
                    <td><label for="sts_approve"><?php echo $strCampaignApprove; ?></label></td>
                    <td><label for="sts_approve"> - <?php echo $strCampaignApproveDescription; ?></label></td>
                </tr>
                <tr>
                    <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_REJECTED; ?>" name="status" id="sts_reject" tabindex='<?php echo ($tabindex++); ?>' /></td>
                    <td><label for="sts_reject"><?php echo $strCampaignReject; ?></label></td>
                    <td><label for="sts_reject"> - <?php echo $strCampaignRejectDescription; ?></label></td>
                </tr>
                <?php
                    } elseif ($row['status'] == OA_ENTITY_STATUS_RUNNING) {
                ?>
                <tr>
                    <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_PAUSED; ?>" name="status" id="sts_pause" tabindex='<?php echo ($tabindex++); ?>' /></td>
                    <td><label for="sts_pause"><?php echo $strCampaignPause; ?></label></td>
                    <td><label for="sts_pause"> - <?php echo $strCampaignPauseDescription; ?></label></td>
                </tr>
                <?php
                    } elseif ($row['status'] == OA_ENTITY_STATUS_PAUSED) {
                ?>
                <tr>
                    <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_RUNNING; ?>" name="status" id="sts_restart" tabindex='<?php echo ($tabindex++); ?>' /></td>
                    <td><label for="sts_pause"><?php echo $strCampaignRestart; ?></label></td>
                    <td><label for="sts_pause"> - <?php echo $strCampaignRestartDescription; ?></label></td>
                </tr>
                <?php
                    } elseif ($row['status'] == OA_ENTITY_STATUS_REJECTED) {
                ?>
                <tr>
                    <td><?php phpAds_showStatusRejected($row['as_reject_reason']); ?></td>
                </tr>
                <?php
                    }
                ?>
                </tbody>
                </table>
            </td>
        </tr>

            <tr>
                <td width="30">&nbsp;</td>
                <td width="200" valign="top"><?php echo $strStatus; ?></td>
                <td>
                    <table>
                    <tbody>
                    <?php
                        if ($row['status'] == OA_ENTITY_STATUS_APPROVAL) {
                    ?>
                    <tr>
                        <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_RUNNING; ?>" name="status" id="sts_approve" tabindex='<?php echo ($tabindex++); ?>' /></td>
                        <td><label for="sts_approve"><?php echo $strCampaignApprove; ?></label></td>
                        <td><label for="sts_approve"> - <?php echo $strCampaignApproveDescription; ?></label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_REJECTED; ?>" name="status" id="sts_reject" tabindex='<?php echo ($tabindex++); ?>' /></td>
                        <td><label for="sts_reject"><?php echo $strCampaignReject; ?></label></td>
                        <td><label for="sts_reject"> - <?php echo $strCampaignRejectDescription; ?></label></td>
                    </tr>
                    <?php
                        } elseif ($row['status'] == OA_ENTITY_STATUS_RUNNING) {
                    ?>
                    <tr>
                        <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_PAUSED; ?>" name="status" id="sts_pause" tabindex='<?php echo ($tabindex++); ?>' /></td>
                        <td><label for="sts_pause"><?php echo $strCampaignPause; ?></label></td>
                        <td><label for="sts_pause"> - <?php echo $strCampaignPauseDescription; ?></label></td>
                    </tr>
                    <?php
                        } elseif ($row['status'] == OA_ENTITY_STATUS_PAUSED) {
                    ?>
                    <tr>
                        <td><input type="radio" value="<?php echo OA_ENTITY_STATUS_RUNNING; ?>" name="status" id="sts_restart" tabindex='<?php echo ($tabindex++); ?>' /></td>
                        <td><label for="sts_pause"><?php echo $strCampaignRestart; ?></label></td>
                        <td><label for="sts_pause"> - <?php echo $strCampaignRestartDescription; ?></label></td>
                    </tr>
                    <?php
                        } elseif ($row['status'] == OA_ENTITY_STATUS_REJECTED) {
                    ?>
                    <tr>
                        <td><?php phpAds_showStatusRejected($row['as_reject_reason']); ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                    </table>
                </td>
            </tr>

    <script type="text/javascript">
        <!--
            $(document).ready(function() {
                initCampaignStatus();
            });
        //-->
    </script>


        <tr id="rsn_row2" style="display:none;">
            <td width="30"></td>
            <td width="200" valign="top"><?php echo $strReasonForRejection; ?></td>
            <td>
                <select name="as_reject_reason">
                    <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_NOTLIVE; ?>"><?php echo $strReasonSiteNotLive; ?></option>
                    <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_BADCREATIVE; ?>"><?php echo $strReasonBadCreative; ?></option>
                    <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_BADURL; ?>"><?php echo $strReasonBadUrl; ?></option>
                    <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_BREAKTERMS; ?>"><?php echo $strReasonBreakTerms; ?></option>
                </select>
            </td>
        </tr>

            <tr id="rsn_row2" style="display:none;">
                <td width="30"></td>
                <td width="200" valign="top"><?php echo $strReasonForRejection; ?></td>
                <td>
                    <select name="as_reject_reason">
                        <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_NOTLIVE; ?>"><?php echo $strReasonSiteNotLive; ?></option>
                        <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_BADCREATIVE; ?>"><?php echo $strReasonBadCreative; ?></option>
                        <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_BADURL; ?>"><?php echo $strReasonBadUrl; ?></option>
                        <option value="<?php echo OA_ENTITY_ADVSIGNUP_REJECT_BREAKTERMS; ?>"><?php echo $strReasonBreakTerms; ?></option>
                    </select>
                </td>
            </tr>

            <tr>
                <td height="10" colspan="3">
                </td>
            </tr>
            <tr class="break" >
                <td colspan="3"></td>
            </tr>
         </tbody>
    </table>
    <div style="width:100%;text-align:left;padding: 15px 0px 0px 0px;margin-bottom: 50px;">
    <input value="Change status" name='submit_status' type="submit" {tabindex}>
    </div>

    <?php
    echo "</form>";
}
echo "<form name='clientform' method='post' action='campaign-edit.php' onSubmit='return (max_formValidate(this) && phpAds_priorityCheck(this) && phpAds_activeRangeCheck(this));'>"."\n";
echo "<input type='hidden' name='campaignid' value='".(isset($campaignid) ? $campaignid : '')."'>"."\n";
echo "<input type='hidden' name='clientid' value='".(isset($clientid) ? $clientid : '')."'>"."\n";
echo "<input type='hidden' name='expire' value='".(isset($row["expire"]) ? $row["expire"] : '')."'>"."\n";
echo "<input type='hidden' name='move' value='".(isset($move) ? $move : '')."'>"."\n";
echo "<input type='hidden' name='target_old' value='".(isset($row['target']) ? (int)$row['target'] : 0)."'>"."\n";
echo "<input type='hidden' name='target_type_old' value='".(isset($target_type) ? $target_type : '')."'>"."\n";
echo "<input type='hidden' name='weight_old' value='".(isset($row['weight']) ? (int)$row['weight'] : 0)."'>"."\n";
echo "<input type='hidden' name='status_old' value='".(isset($row['status']) ? (int)$row['status'] : 1)."'>"."\n";
echo "<input type='hidden' name='previousweight' value='".(isset($row["weight"]) ? $row["weight"] : '')."'>"."\n";
echo "<input type='hidden' name='previoustarget' value='".(isset($row["target"]) ? $row["target"] : '')."'>"."\n";
echo "<input type='hidden' name='previousactive' value='".(isset($row["active"]) ? $row["active"] : '')."'>"."\n";
echo "<input type='hidden' name='previousimpressions' value='".(isset($row["impressions"]) ? $row["impressions"] : '')."'>"."\n";
echo "<input type='hidden' name='previousclicks' value='".(isset($row["clicks"]) ? $row["clicks"] : '')."'>"."\n";
echo "<input type='hidden' name='previousconversions' value='".(isset($row["conversions"]) ? $row["conversions"] : '')."'>"."\n";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200'>".$strName."</td>"."\n";
echo "\t"."<td><input onBlur='phpAds_formPriorityUpdate(this.form);' class='flat' type='text' name='campaignname' size='35' style='width:350px;' value='".phpAds_htmlQuotes($row['campaignname'])."' tabindex='".($tabindex++)."'></td>"."\n";
echo "</tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><a name='inv-det' ></a><b>".$strInventoryDetails."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

if (isset($row['status']) && $row['status'] != OA_ENTITY_STATUS_RUNNING)
{
    $activate_ts = mktime(23, 59, 59, $row["activate_month"], $row["activate_dayofmonth"], $row["activate_year"]);
    $expire_ts = $row['expire_year'] ? mktime(23, 59, 59, $row["expire_month"], $row["expire_dayofmonth"], $row["expire_year"]) : 0;
    $inactivebecause = array();

    if ($row['impressions'] == 0) $inactivebecause[] =  $strNoMoreImpressions;
    if ($row['clicks'] == 0) $inactivebecause[] =  $strNoMoreClicks;
    if ($row['conversions'] == 0) $inactivebecause[] =  $strNoMoreConversions;
    if ($activate_ts > 0 && $activate_ts > time()) $inactivebecause[] =  $strBeforeActivate;
    if ($expire_ts > 0 && time() > $expire_ts) $inactivebecause[] =  $strAfterExpire;

    if ($row['priority'] == 0  && $row['weight'] == 0) $inactivebecause[] =  $strWeightIsNull;
    if ($row['priority'] > 0  && $target_value == 0) $inactivebecause[] =  $strTargetIsNull;

    echo "<tr>"."\n";
    echo "\t"."<td width='30' valign='top'>&nbsp;</td>"."\n";
    echo "\t"."<td colspan='2'><div class='errormessage'><img class='errormessage' src='" . MAX::assetPath() . "/images/info.gif' width='16' height='16' border='0' align='absmiddle'>".$strClientDeactivated." ".join(', ', $inactivebecause)."</div><br /></td>"."\n";
    echo "</tr>"."\n";
    echo "<tr><td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td></tr>"."\n";
}

echo "<tr><td colspan='3'>\n";

?>
  <tr>
    <td width='30'>&nbsp;</td>
    <td width='200'><?php echo $strImpressionsBooked ?></td>
		<td colspan="4">
		  <div>
		    <div style="float: left;margin-right:10px;">
		      <input type="radio" value="no" name="rd_impr_bkd" id="limitedimpressions" tabindex='<?php echo ($tabindex++); ?>' <?php echo ($row["impressions"] >= 0 ? 'checked' : '') ?> /><input class='flat' type='text' name='impressions' size='25'  value='<?php echo ($row["impressions"] >= 0 ? $row["impressions"] : '-') ?>' tabindex='<?php echo ($tabindex++); ?>'>
		    </div>
		    <div id="remainingImpressionsSection">
			    <span id='remainingImpressions' >Impressions remaining:<span id='remainingImpressionsCount'>2500</span></span><br/>
			    <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
					  <!--span id="openadsRemainingImpressions">OpenX impressions remaining: <span id='openadsRemainingImpressionsCount'>3000<!-- REAL DATA GOES HERE -></span>
					    <span class="link hide" help="help-openads-remaining-impressions" id="openadsRemainingImpressionsHelpLink"><img style="border: none; position: relative; top:5px;" src="<?php echo MAX::assetPath() ?>/images/help-book.gif" /></span>
			      </span-->
			     	<div class="hide" id="help-openads-remaining-impressions" style="height: auto; width: 290px;">
		          Campaign's remaining impressions number is too small to satisfy the number booked by advertiser. It means that the local remaining click number is lower than central remaining click number and you should increase the booked impressions by the missing value.
		       	</div>
	       	<?php } ?>
		    </div>
		  </div>
		  <div style="clear: both;"><input type="radio"  value="unl" name="rd_impr_bkd" id="unlimitedimpressions" tabindex='<?php echo ($tabindex++); ?>'><label for="unlimitedimpressions"><?php echo $strUnlimited; ?></label></div>
		</td>
  </tr>

  <tr>
    <td><img src='<?php echo MAX::assetPath() ?>/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='<?php echo MAX::assetPath() ?>/images/break-l.gif' height='1' width='200' vspace='6'></td>
  </tr>

  <tr>
    <td width='30'>&nbsp;</td>
    <td width='200'><?php echo $strClicksBooked; ?></td>
    <td colspan="4">
      <div>
        <div style="float: left;margin-right:10px;">
          <input type="radio" value="no" name="rd_click_bkd" id="limitedclicks" tabindex='<?php echo ($tabindex++); ?>' <?php echo ($row["clicks"] >= 0 ? 'checked' : '') ?> /><input class='flat' type='text' name='clicks' size='25'  value='<?php echo ($row["clicks"] >= 0 ? $row["clicks"] : '-') ?>' tabindex='<?php echo ($tabindex++); ?>'>
        </div>
        <div id="remainingClicksSection">
          <span  id='remainingClicks' >Clicks remaining:<span id='remainingClicksCount'>200</span></span><br/>
          <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
	          <!--span id="openadsRemainingClicks">OpenX clicks remaining: <span id='openadsRemainingClicksCount'>600<!-- REAL DATA GOES HERE -></span-->
	            <span class="link hide"	help="help-openads-remaining-clicks" id="openadsRemainingClicksHelpLink"><img style="border: none; position: relative; top:5px;" src="<?php echo MAX::assetPath() ?>/images/help-book.gif" /></span>
	          </span>
	         <div class="hide" id="help-openads-remaining-clicks" style="height: auto; width: 290px;">
	          Campaign's remaining clicks number is too small to satisfy the number booked by advertiser. It means that the local remaining click number is lower than central remaining click number and you should increase the booked clicks by the missing value.
	         </div>
          <?php } ?>
        </div>
      </div>
      <div style="clear: both;"><input type="radio"  value="unl" name="rd_click_bkd" id="unlimitedclicks" tabindex='<?php echo ($tabindex++); ?>'><label for="unlimitedclicks"><?php echo $strUnlimited; ?></label></div>
    </td>
  </tr>

  <?php
  // Conditionally display conversion tracking
  if ($conf['logging']['trackerImpressions']) {
  ?>
  <tr>
    <td><img src='<?php echo MAX::assetPath() ?>/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='<?php echo MAX::assetPath() ?>/images/break-l.gif' height='1' width='200' vspace='6'></td>
  </tr>

  <tr>
    <td width='30'>&nbsp;</td>
    <td width='200'><?php echo $strConversionsBooked; ?></td>
    <td colspan="4">
      <div>
        <div style="float: left;margin-right:10px;">
          <input type="radio" value="no" name="rd_conv_bkd" id="limitedconv" tabindex='<?php echo ($tabindex++); ?>' <?php echo ($row["conversions"] >= 0 ? 'checked' : '') ?> /><input class='flat' type='text' name='conversions' size='25'  value='<?php echo ($row["conversions"] >= 0 ? $row["conversions"] : '-') ?>' tabindex='<?php echo ($tabindex++); ?>'>
        </div>
        <div id="remainingConversionsSection">
          <span  id='remainingConversions' ><?php echo $strConversionsRemaining; ?>:<span id='remainingConversionsCount'><?php echo $row["conversionsRemaining"]; ?></span></span>
        </div>
      </div>
      <div style="clear: both;"><input type="radio"  value="unl" name="rd_conv_bkd" id="unlimitedconversions" tabindex='<?php echo ($tabindex++); ?>'><label for="unlimitedconversions"><?php echo $strUnlimited; ?></label></div>
    </td>
  </tr>
  <?php
  }
  ?>

<?php
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strContractDetails."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td><td width='200' valign='top'>".$strActivationDate."</td>"."\n";
echo "\t"."<td>";
phpAds_showDateEdit('start', isset($row["activate_dayofmonth"]) ? $row["activate_dayofmonth"] : 0,
                                   isset($row["activate_month"]) ? $row["activate_month"] : 0,
                                isset($row["activate_year"]) ? $row["activate_year"] : 0);
echo "</td>"."\n";
echo "</tr>"."\n";
echo "<tr>"."\n";
echo "\t"."<td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td><td width='200' valign='top'>".$strExpirationDate."</td>"."\n";
echo "\t"."<td>";
phpAds_showDateEdit('end', isset($row["expire_dayofmonth"]) ? $row["expire_dayofmonth"] : 0,
                              isset($row["expire_month"]) ? $row["expire_month"] : 0,
                              isset($row["expire_year"]) ? $row["expire_year"] : 0);
echo "</td>"."\n";
echo "</tr>"."\n";
echo "<tr>"."\n";
echo "\t"."<td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "<td width='30'>&nbsp;</td><td width='200'>".$strRevenueInfo."</td>"."\n";
echo "<td>";
echo "&nbsp;&nbsp;<input type='text' name='revenue' size='10' value='{$row["revenue"]}' tabindex='".($tabindex++)."'>&nbsp;";
echo "&nbsp;&nbsp;";
echo "<select name='revenue_type' tabindex='".($tabindex++)."'>";
echo "  <option value='".MAX_FINANCE_CPM."' ".(($row['revenue_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
echo "  <option value='".MAX_FINANCE_CPC."' ".(($row['revenue_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
// Conditionally display conversion tracking
if ($conf['logging']['trackerImpressions']) {
  echo "  <option value='".MAX_FINANCE_CPA."' ".(($row['revenue_type'] == MAX_FINANCE_CPA) ? ' SELECTED ' : '').">$strFinanceCPA</option>";
}
echo "  <option value='".MAX_FINANCE_MT."' ".(($row['revenue_type'] == MAX_FINANCE_MT) ? ' SELECTED ' : '').">$strFinanceMT</option>";
echo "</select>";
echo "</td>"."\n";
echo "</tr>"."\n";
?>

<!--tr>
  <td><img width="100%" height="1" src="<?php echo MAX::assetPath() ?>/images/spacer.gif"/></td>
  <td colspan="2"><img width="200" vspace="6" height="1" src="<?php echo MAX::assetPath() ?>/images/break-l.gif"/></td>
</tr>

<tr>
    <td width="30"></td>
    <td width="200" valign="top">Total revenue</td>
    <td>REVENUE VALUE GOES HERE</td>
</tr-->
<?php
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr><td height='25' colspan='3'><b>".$strPriorityInformation."</b></td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200' valign='top'>".$strPriorityLevel."</td>"."\n";
echo "\t"."<td>"."\n";
echo "\t\t"."<table>"."\n";

echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' id='priority-e' name='priority' value='-1'".($row['priority'] == '-1' ? ' checked' : '')." onClick=\"phpAds_formPriorityRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'><label for='priority-e'>".$strExclusive."</label></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityExclusive."</td>"."\n";
echo "\t\t"."</tr>"."\n";


echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' id='priority-h' name='priority' value='2'".(($row['priority'] > '0' && $campaignid != '') ? ' checked' : '')." onClick=\"phpAds_formPriorityRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'> <select name='high_priority_value'>";
// If is a low priority campaign or a exclusive priority campaign show the disabled High Priority Level as 5
if ($row['priority'] == '0') {
	$lowPriority = true;
	$row['priority'] = 5;
} elseif ($row['priority'] == '-1') {
	$row['priority'] = 5;
}
for ($i = 10; $i >= 1; $i--) {
    echo "<option value='$i'".($row['priority'] == $i ? 'SELECTED' : '').">$strHigh ($i)</option>";
}
echo "</select></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityHigh."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t\t"."<td valign='top'><input type='radio' id='priority-l' name='priority' value='0'".(($lowPriority || $campaignid == '') ? ' checked' : '')." onClick=\"phpAds_formPriorityRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'><label for='priority-l'>".$strLow."</label></td>"."\n";
echo "\t\t\t"."<td valign='top'>".$strPriorityLow."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t"."</table>"."\n";
echo "\t"."</td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
echo "</tr>";

echo "<tr>"."\n";
echo "\t"."<td width='30'>&nbsp;</td>"."\n";
echo "\t"."<td width='200' valign='top'>".$strPriorityTargeting    ."</td>"."\n";
echo "\t"."<td>"."\n";
echo "\t\t"."<table>"."\n";
echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' id='delivery-a' name='delivery' value='auto'".($delivery == 'auto' ? ' checked' : '')." onClick=\"phpAds_formDeliveryRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'><label for='delivery-a'>".$strPriorityAutoTargeting."</label></td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' name='delivery' value='manual'".($delivery == 'manual' ? ' checked' : '')." onClick=\"phpAds_formDeliveryRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'> <select name='target_type'>";
echo "<option value='limit_impression' ".(($target_type == 'target_impression') ? ' SELECTED ' : ''). ">$strImpressions</option>";
echo "<option value='limit_click' ".(($target_type == 'target_click') ? ' SELECTED ' : '').">$strClicks</option>";
// Conditionally display conversion tracking
if ($conf['logging']['trackerImpressions']) {
  echo "<option value='limit_conversion' ".(($target_type == 'target_conversion') ? ' SELECTED ' : '').">$strConversions</option>";
}
echo "</select> $strTo <input onBlur='phpAds_formPriorityUpdate(this.form);' class='flat' type='text' name='target_value' size='7' value='".(!empty($target_value) ? $target_value : '-')."' tabindex='".($tabindex++)."'> ".$strTargetPerDay."</td>"."\n";
echo "\t\t"."</tr>"."\n";

echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<td valign='top'><input type='radio' id='delivery-n' name='delivery' value='none'".($delivery == 'none' ? ' checked' : '')." onClick=\"phpAds_formDeliveryRadioClick(this);\" tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t\t"."<td valign='top'><label for='delivery-n'>".$strCampaignWeight."</label>: <input onBlur='phpAds_formPriorityUpdate(this.form);' class='flat' type='text' name='weight' size='7' value='".(isset($row["weight"]) ? $row["weight"] : $pref['default_campaign_weight'])."' tabindex='".($tabindex++)."'></td>"."\n";
echo "\t\t"."</tr>"."\n";
echo "\t\t"."</table>"."\n";
echo "\t"."</td>"."\n";
echo "</tr>"."\n";

echo "<tr>"."\n";
echo "\t"."<td><img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>"."\n";
echo "\t"."<td colspan='2'><img src='" . MAX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>"."\n";
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
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr><td width='30'>&nbsp;</td>";
echo "<td width='200'>".$strComments."</td>";

echo "<td><textarea class='flat' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".htmlspecialchars($row['comments'])."</textarea></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
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
<script language='javascript' type='text/javascript' src='<?php echo MAX::assetPath() ?>/js/datecheck.js'></script>
<script language='javascript' type='text/javascript' src='numberFormat.js.php?lang=<?php echo $GLOBALS['_MAX']['PREF']['language'] ?>'></script>
<script language='JavaScript'>
<!--
  $(document).ready(function() {
    phpAds_formUnlimitedCheck('unlimitedimpressions', 'impressions');
    phpAds_formUnlimitedCheck('unlimitedclicks', 'clicks');
    <?php
    // Conditionally display conversion tracking
    if ($conf['logging']['trackerImpressions']) {
    ?>
    phpAds_formUnlimitedCheck('unlimitedconversions', 'conversions');
    <?php
    }
    ?>
    $(":input[name='rd_impr_bkd']").click(function() { phpAds_formUnlimitedClick('unlimitedimpressions', 'impressions', 'openadsRemainingImpressions'); return true; });
    $(":input[name='rd_click_bkd']").click(function() { phpAds_formUnlimitedClick('unlimitedclicks', 'clicks', 'openadsRemainingClicks'); return true;});
    $(":input[name='rd_conv_bkd']").click(function() { phpAds_formUnlimitedClick('unlimitedconversions', 'conversions'); return true;});
    initBookedInput($(":input[name='impressions']"));
    initBookedInput($(":input[name='clicks']"));
    initBookedInput($(":input[name='conversions']"));
  });

    function initBookedInput($input)
    {
      $input
        .focus(function() {
          max_formUnFormat(this.form, this.name);
          })
        .keypress(maskNonNumeric)
        .keyup(function() {
          max_formBookedUpdate(this.form);
          })
        .blur(function() {
          max_formFormat(this.form, this.name);
          max_formBookedUpdate(this.form);
          });
    }

    max_formSetRequirements('campaignname', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetRequirements('impressions', '<?php echo addslashes($strImpressionsBooked); ?>', false, 'formattedNumber');
    max_formSetRequirements('clicks', '<?php echo addslashes($strClicksBooked); ?>', false, 'formattedNumber');
    max_formSetRequirements('conversions', '<?php echo addslashes($strConversionsBooked); ?>', false, 'formattedNumber');
    max_formSetRequirements('weight', '<?php echo addslashes($strCampaignWeight); ?>', false, 'wholeNumber-');
    max_formSetRequirements('target_value', '<?php echo addslashes($strTargetPerDay); ?>', false, 'wholeNumber-');
    max_formSetUnique('campaignname', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');

    var previous_target = '';
    var previous_weight = '';
    var previous_priority = '';

    var impressions_delivered = <?php echo (isset($data['impressions_delivered'])) ? $data['impressions_delivered'] : 0; ?>;
    var clicks_delivered = <?php echo (isset($data['clicks_delivered'])) ? $data['clicks_delivered'] : 0; ?>;
    var conversions_delivered = <?php echo (isset($data['conversions_delivered'])) ? $data['conversions_delivered'] : 0; ?>;

    <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
      var centralImpressionsRemaining = 3000; // REAL DATA GOES HERE
      var centralClicksRemaining = 600; //REAL DATA GOES HERE
    <?php } ?>

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

    <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
		  function insufficientNumberCheck(remainingLocalCount, remainingCentralCount, remainingCentralId)
		  {
		    var $remainingCentral = $("#" + remainingCentralId);
		    if ($remainingCentral.lenght == 0) {
		     return;
		    }

	      markInsufficient(remainingLocalCount < remainingCentralCount, remainingCentralId);
		  }


		  function markInsufficient(insufficient, remainingCentralId)
		  {
	      var $remainingCentral = $("#" + remainingCentralId);
	      var $remainingCentralHelpLink = $("#" + remainingCentralId + "HelpLink");

	      if (insufficient) {
	        $remainingCentral.addClass("sts-insufficient");
	        $remainingCentralHelpLink.show().css("display", "inline");
	      }
	      else {
	        $remainingCentral.removeClass("sts-insufficient");
	        $remainingCentralHelpLink.hide();
	      }
		  }
    <?php } ?>

	  function hasUnlimitedValue(input)
	  {
	   return (input.value == '-') || (input.value == 0)
	  }


	  function setUnlimitedValue(input)
	  {
	   input.value = "-";
	  }

    function phpAds_formDateClick(o, value)
    {
        var date = eval ("document.clientform." + o + ".value");
        if (value == false) {
            eval ("document.clientform." + o + ".value = ''");
        }
        if (value == true && date == '') {
            eval ("document.clientform." + o + "Set[0].checked = true");
        }
        if (o == 'end') {
            phpAds_formPriorityUpdate(document.clientform);
        }
    }

    function phpAds_formDateCheck(o)
    {
        var date = eval ("document.clientform." + o + ".value");
        if (date == '') {
            eval ("document.clientform." + o + "Set[0].checked = true");
        } else {
            eval ("document.clientform." + o + "Set[1].checked = true");
        }
        if (o == 'end') {
            phpAds_formPriorityUpdate(document.clientform);
        }
    }

    function phpAds_activeRangeCheck(form)
    {
        var activeDate;
        var expireDate;
        var activation_enabled = isDateSetActive('start', form);
        var expiry_enabled = isDateSetActive('end', form);
        // No sense in comparing inactive values
        if (activation_enabled) {
            activateDate = newDateFromNamedFields(document, form, 'start');
            if (!activateDate) {
                alert('The start date of this campaign is not a valid date');
                return false;
            }
        }
        if(expiry_enabled) {
            expireDate = newDateFromNamedFields(document, form, 'end');
            if (!expireDate) {
                alert('The end date of this campaign is not a valid date');
                return false;
            }
        }
        if (activation_enabled && expiry_enabled) {
            if (!isDateEqual(activateDate, expireDate) && isDateBefore(expireDate, activateDate)) {
                alert('The selected dates for this campaign are invalid\n(Campaign ends before it starts!).\n');
                return false;
            }
        }
        return true;
    }

    function phpAds_formUnlimitedClick(oc,oe, remainingCentralId)
    {
        e = findObj(oe);
        c = findObj(oc);
        if (c.checked == true) {
            setUnlimitedValue(e);
            e.disabled = true;

            <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
	            //remove any "insufficient" error indicators
			        if (remainingCentralId != undefined && remainingCentralId != "") {
			          markInsufficient(false, remainingCentralId);
			        }
		        <?php } ?>
        } else {
            e.value = "";
            e.disabled = false;
            e.focus();
        }
        // Update check
        max_formBookedUpdate(e.form);
    }


    function phpAds_formUnlimitedCheck(oc,oe)
    {
        e = findObj(oe);
        c = findObj(oc);
        if (hasUnlimitedValue(e)) {
            c.checked = true;
            e.disabled = true;
        } else {
            c.checked = false;
            e.disabled = false;
        }
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

    function phpAds_setRemainingVisibility(elementId, visible) {
    	var $elem = $("#" + elementId);

        if (visibility) {
        	$elem.show();
        } else {
            $elem.hide();
        }
    }


    function max_formUnFormat(f, type)
    {
        if (type == 'impressions') {
            if (f.impressions.value != '-' && f.impressions.value != '') {
                f.impressions.value = max_formattedNumberStringToFloat(f.impressions.value);
            } else {
                f.impressions.value = '';
            }
        }

        if (type == 'clicks') {
            if (f.clicks.value != '-' && f.clicks.value != '') {
                f.clicks.value = max_formattedNumberStringToFloat(f.clicks.value);
            } else {
                f.clicks.value = '';
            }
        }
        <?php
        // Conditionally display conversion tracking
        if ($conf['logging']['trackerImpressions']) {
        ?>
        if (type == 'conversions') {
            if (f.conversions.value != '-' && f.conversions.value != '') {
                f.conversions.value = max_formattedNumberStringToFloat(f.conversions.value);
            } else {
                f.conversions.value = '';
            }
        }
        <?php
        }
        ?>
    }

    function max_formFormat(f, type)
    {
        if (type == 'impressions') {
            if ((f.impressions.value == '') || (f.impressions.value == 0)) {
                f.impressions.value = '-';
            }
            if (f.impressions.value != '-') {
                f.impressions.value = max_formatNumberIgnoreDecimals(f.impressions.value);
            }
        }
        if (type == 'clicks') {
            if ((f.clicks.value == '') || (f.clicks.value == 0)) {
                f.clicks.value = '-';
            }
            if (f.clicks.value != '-') {
                f.clicks.value = max_formatNumberIgnoreDecimals(f.clicks.value);
            }
        }
        <?php
        // Conditionally display conversion tracking
        if ($conf['logging']['trackerImpressions']) {
        ?>
        if (type == 'conversions') {
            if ((f.conversions.value == '') || (f.conversions.value == 0)) {
                f.conversions.value = '-';
            }
            if (f.conversions.value != '-') {
                f.conversions.value = max_formatNumberIgnoreDecimals(f.conversions.value);
            }
        }
        <?php
        }
        ?>
    }

    function max_formBookedUpdate(f)
    {
        // Update remaining impressions/click/conversions
        if (max_formattedNumberStringToFloat(f.impressions.value) >= 0) {
            var remaining = max_formattedNumberStringToFloat(f.impressions.value) - impressions_delivered;
            document.getElementById('remainingImpressionsCount').innerHTML = max_formatNumberIgnoreDecimals(remaining);
            <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
              insufficientNumberCheck(remaining, centralImpressionsRemaining, 'openadsRemainingImpressions');
            <?php } ?>
            visibility = true;
        } else {
            visibility = false;
        }
        phpAds_setRemainingVisibility('remainingImpressions', visibility);

        if (max_formattedNumberStringToFloat(f.clicks.value) >= 0) {
            var remaining = max_formattedNumberStringToFloat(f.clicks.value) - clicks_delivered;
            document.getElementById('remainingClicksCount').innerHTML = max_formatNumberIgnoreDecimals(remaining);
            <?php if (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) { ?>
              insufficientNumberCheck(remaining, centralClicksRemaining, 'openadsRemainingClicks');
            <?php } ?>
            visibility = true;
        } else {
            visibility = false;
        }
        phpAds_setRemainingVisibility('remainingClicks', visibility);

        <?php
        // Conditionally display conversion tracking
        if ($conf['logging']['trackerImpressions']) {
        ?>
        if (max_formattedNumberStringToFloat(f.conversions.value) >= 0) {
            var remaining = max_formattedNumberStringToFloat(f.conversions.value) - conversions_delivered;
            document.getElementById('remainingConversionsCount').innerHTML = max_formatNumberIgnoreDecimals(remaining);
            visibility = true;
        } else {
            visibility = false;
        }
        <?php
        }
        ?>
        phpAds_setRemainingVisibility('remainingConversions', visibility);

        phpAds_formPriorityUpdate(f);
    }

    function phpAds_formPriorityUpdate(f)
    {
        // Check to see if autotargeting is available. Autotargeting is
        // available when there is an expiration date and one of a set
        // number of target impressions, clicks or conversions
        var autotarget_available =  ( !(f.endSet[0].checked == true) &&
                                      (
                                        (!( isNaN(max_formattedNumberStringToFloat(f.impressions.value)) || (f.impressions.value == '') || (f.unlimitedimpressions.checked == true)))
                                        || (!( isNaN(max_formattedNumberStringToFloat(f.clicks.value))      || (f.clicks.value == '')      || (f.unlimitedclicks.checked == true)))
                                        <?php
                                        // Conditionally display conversion tracking
                                        if ($conf['logging']['trackerImpressions']) {
                                        ?>
                                        || (!( isNaN(max_formattedNumberStringToFloat(f.conversions.value)) || (f.conversions.value == '') || (f.unlimitedconversions.checked == true)))
                                        <?php
                                        }
                                        ?>
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
