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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';

// Define defaults
$clientCache = [];
$campaignCache = [];
$bannerCache = [];
$zoneCache = [];
$affiliateCache = [];

/*-------------------------------------------------------*/
/* Limit a string to a number of characters              */
/*-------------------------------------------------------*/

function phpAds_breakString($str, $maxLen, $append = "...")
{
    return strlen($str) > $maxLen
        ? rtrim(substr($str, 0, $maxLen - strlen($append))) . $append
        : $str;
}

/*-------------------------------------------------------*/
/* Build the client name from ID and name                */
/*-------------------------------------------------------*/

function phpAds_buildName($id, $name)
{
    return ("<span dir='" . $GLOBALS['phpAds_TextDirection'] . "'>[id$id]</span> " . htmlspecialchars($name));
}

/*-------------------------------------------------------*/
/* Fetch the client name from the database               */
/*-------------------------------------------------------*/

function phpAds_getClientName($clientid)
{
    global $strUntitled;
    if ($clientid != '' && $clientid != 0) {
        $client_details = phpAds_getClientDetails($clientid);
        return (phpAds_BuildName($clientid, $client_details['clientname']));
    } else {
        global $strUntitled;
        return ($strUntitled);
    }
}

/*-------------------------------------------------------*/
/* Fetch the campaign name from the database             */
/*-------------------------------------------------------*/

function phpAds_getCampaignName($campaignid, $check_blind = false)
{
    // Andrew replaced $strUntitled with '' as $strUntitled
    // doesn't appear to be defined anywhere!
    //$campaign_name = $strUntitled;
    $campaign_name = '';
    if ($campaignid != '' && $campaignid != 0) {
        $campaign_details = phpAds_getCampaignDetails($campaignid);
        if ($check_blind && ($campaign_details['anonymous'] == 't')) {
            $campaign_name = $GLOBALS['strHiddenCampaign'] . ' ' . $campaign_details['campaignid'];
        } else {
            $campaign_name = phpAds_BuildName($campaignid, $campaign_details['campaignname']);
        }
    }
    return $campaign_name;
    /*
    if ($campaignid != '' && $campaignid != 0)
    {
        $campaign_details = phpAds_getCampaignDetails($campaignid);
        return (phpAds_BuildName ($campaignid, $campaign_details['campaignname']));
    }
    else
        return ($strUntitled);
    */
}

/*-------------------------------------------------------*/
/* Fetch the ID of the parent of a campaign              */
/*-------------------------------------------------------*/

function phpAds_getCampaignParentClientID($campaignid)
{
    $campaign_details = phpAds_getCampaignDetails($campaignid);
    return $campaign_details['clientid'];
}

/*-------------------------------------------------------*/
/* Fetch the ID of the parent of a tracker               */
/*-------------------------------------------------------*/

function phpAds_getTrackerParentClientID($trackerid)
{
    $tracker_details = phpAds_getTrackerDetails($trackerid);
    return $tracker_details['clientid'];
}

/*-------------------------------------------------------*/
/* Fetch the name of the parent of a campaign            */
/*-------------------------------------------------------*/

function phpAds_getParentClientName($campaignid)
{
    $campaign_details = phpAds_getCampaignDetails($campaignid);
    return phpAds_getClientName($campaign_details['clientid']);
}

/*-------------------------------------------------------*/
/* Build the banner name from ID, Description and Alt    */
/*-------------------------------------------------------*/

function phpAds_buildBannerName($bannerid, $description = '', $alt = '', $limit = 30, $use_html = true)
{
    global $strUntitled;
    $name = '';
    if ($description != "") {
        $name .= $description;
    } elseif ($alt != "") {
        $name .= $alt;
    } else {
        $name .= $strUntitled;
    }
    if (strlen($name) > $limit) {
        $name = phpAds_breakString($name, $limit);
    }
    if ($bannerid != '') {
        $name = $use_html ? "<span dir='" . $GLOBALS['phpAds_TextDirection'] . "'>[id$bannerid]</span> " . htmlspecialchars($name) : "[id$bannerid] " . htmlspecialchars($name);
    } else {
        $name = htmlspecialchars($name);
    }
    return $name;
}

/*-------------------------------------------------------*/
/* Fetch the banner name from the database               */
/*-------------------------------------------------------*/

function phpAds_getBannerName($bannerid, $limit = 30, $id = true, $checkanonymous = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $bannerCache;
    if (isset($bannerCache[$bannerid]) && is_array($bannerCache[$bannerid])) {
        $row = $bannerCache[$bannerid];
    } else {
        $doBanners = OA_Dal::staticGetDO('banners', $bannerid);
        $row = $doBanners->toArray();
        if ($checkanonymous) {
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $row['campaignid']);
            $row['anonymous'] = $doCampaigns->anonymous;
            if ((OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) || OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) && MAX_isAnonymous($row['anonymous'])) {
                $row['description'] = $GLOBALS['strHiddenAd'] . ' ' . $bannerid;
            }
        }
        $bannerCache[$bannerid] = $row;
    }

    if ($id) {
        return (phpAds_buildBannerName($bannerid, $row['description'], $row['alt'], $limit));
    } else {
        return (phpAds_buildBannerName('', $row['description'], $row['alt'], $limit));
    }
}

/*-------------------------------------------------------*/
/* Build the zone name from ID and name                  */
/*-------------------------------------------------------*/

function phpAds_buildZoneName($zoneid, $zonename)
{
    return ("<span dir='" . $GLOBALS['phpAds_TextDirection'] . "'>[id$zoneid]</span> " . htmlspecialchars($zonename));
}

/*-------------------------------------------------------*/
/* Fetch the zone name from the database                 */
/*-------------------------------------------------------*/

function phpAds_getZoneName($zoneid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $zoneCache;
    global $strUntitled;
    if ($zoneid != '' && $zoneid != 0) {
        if (isset($zoneCache[$zoneid]) && is_array($zoneCache[$zoneid])) {
            $row = $zoneCache[$zoneid];
        } else {
            $doZones = OA_Dal::staticGetDO('zones', $zoneid);
            $zoneCache[$zoneid] = $doZones->toArray();
        }
        return (phpAds_BuildZoneName($zoneid, $row['zonename']));
    } else {
        return ($strUntitled);
    }
}

/*-------------------------------------------------------*/
/* Build the affiliate name from ID and name             */
/*-------------------------------------------------------*/

function phpAds_buildAffiliateName($affiliateid, $name)
{
    return ("<span dir='" . $GLOBALS['phpAds_TextDirection'] . "'>[id$affiliateid]</span> " . htmlspecialchars($name));
}

/*-------------------------------------------------------*/
/* Fetch the affiliate name from the database            */
/*-------------------------------------------------------*/

function phpAds_getAffiliateName($affiliateid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $affiliateCache;
    global $strUntitled;
    if ($affiliateid != '' && $affiliateid != 0) {
        if (isset($affiliateCache[$affiliateid]) && is_array($affiliateCache[$affiliateid])) {
            $row = $affiliateCache[$affiliateid];
        } else {
            $doAffiliates = OA_Dal::staticGetDO('affiliates', $affiliateid);
            $row = $doAffiliates->toArray();
            $affiliateCache[$affiliateid] = $row;
        }
        return (phpAds_BuildAffiliateName($affiliateid, $row['name']));
    } else {
        return ($strUntitled);
    }
}

/*-------------------------------------------------------*/
/* Build the HTML needed to display a banner             */
/*-------------------------------------------------------*/

function phpAds_buildBannerCode($bannerid, $fullpreview = false)
{
    include_once MAX_PATH . '/lib/max/Delivery/adRender.php';
    $aBanner = Admin_DA::getAd($bannerid);
    $aBanner['storagetype'] = $aBanner['type'];
    $aBanner['bannerid'] = $aBanner['ad_id'];
    $bannerCode = MAX_adRender($aBanner, 0, '', '', '', true, '', false, false);
    return $bannerCode;
}

/*-------------------------------------------------------*/
/* Build Click-Thru ratio                                */
/*-------------------------------------------------------*/

function phpAds_buildCTR($views, $clicks)
{
    return phpAds_formatPercentage(phpAds_buildRatio($clicks, $views));
}

function phpAds_buildRatio($numerator, $denominator)
{
    // Strip any non-digit characters from numbers
    $numerator = preg_replace('/[^0-9]/', '', $numerator);
    $denominator = preg_replace('/[^0-9]/', '', $denominator);
    return ($denominator == 0 ? 0 : $numerator / $denominator);
}

function phpAds_formatPercentage($number, $decimals = -1)
{
    $pref = $GLOBALS['_MAX']['PREF'];
    global $phpAds_DecimalPoint, $phpAds_ThousandsSeperator;
    if ($decimals < 0) {
        $decimals = $pref['ui_percentage_decimals'];
    }
    return number_format($number * 100, $decimals, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator) . '%';
}

function phpAds_buildRatioPercentage($numerator, $denominator)
{
    return phpAds_formatPercentage(phpAds_buildRatio($numerator, $denominator));
}

function phpAds_formatNumber($number, $decimals = 0)
{
    global $phpAds_ThousandsSeperator, $phpAds_DecimalPoint;
    if (!strcmp($number, '-')) {
        return '-';
    }
    return number_format($number, $decimals, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator);
}

/*-------------------------------------------------------*/
/* Get overview statistics                                 */
/*-------------------------------------------------------*/

function phpAds_totalStats($column, $bannerid, $timeconstraint = "")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $where = "";
    if (!empty($bannerid)) {
        $where = "ad_id = '$bannerid'";
    }
    if (!empty($timeconstraint)) {
        if (!empty($bannerid)) {
            $where .= " AND ";
        }
        if ($timeconstraint == "month") {
            $begin = date('Ymd', mktime(0, 0, 0, date('m'), 1, date('Y')));
            $end = date('Ymd', mktime(0, 0, 0, date('m') + 1, 1, date('Y')));
            $where .= "day >= $begin AND day < $end";
        } elseif ($timeconstraint == "week") {
            $begin = date('Ymd', mktime(0, 0, 0, date('m'), date('d') - 6, date('Y')));
            $end = date('Ymd', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')));
            $where .= "day >= $begin AND day < $end";
        } else {
            $begin = date('Ymd', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
            $where .= "day = $begin";
        }
    }
    $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
    $doDataSummaryAdHourly->selectAdd();
    $doDataSummaryAdHourly->selectAdd("SUM($column) AS qnt");
    if (!empty($where)) {
        $doDataSummaryAdHourly->whereadd($where);
    }
    $doDataSummaryAdHourly->find(true);

    if ($doDataSummaryAdHourly->qnt) {
        return $doDataSummaryAdHourly->qnt;
    } else {
        return 0;
    }
}

function phpAds_totalClicks($bannerid = "", $timeconstraint = "")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    return phpAds_totalStats("clicks", $bannerid, $timeconstraint);
}

function phpAds_totalConversions($bannerid = "", $timeconstraint = "")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    return phpAds_totalStats("conversions", $bannerid, $timeconstraint);
}

function phpAds_totalViews($bannerid = "", $timeconstraint = "")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    return phpAds_totalStats("impressions", $bannerid, $timeconstraint);
}

function phpAds_htmlQuotes($string)
{
    return htmlspecialchars($string, ENT_QUOTES);
}

/**
 * @todo Consider using PEAR Cache::Lite instead of globals for caching
 */
function phpAds_getClientDetails($clientid)
{
    global $clientCache;

    if (isset($clientCache[$clientid]) && is_array($clientCache[$clientid])) {
        $client_details = $clientCache[$clientid];
    } else {
        $dalClients = OA_Dal::factoryDAL('clients');
        $client_details = $dalClients->getAdvertiserDetails($clientid);
        $clientCache[$clientid] = $client_details;
    }
    return ($client_details);
}

function phpAds_getCampaignDetails($campaignid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $campaignCache;
    if (isset($campaignCache[$campaignid]) && is_array($campaignCache[$campaignid])) {
        $row = $campaignCache[$campaignid];
    } else {
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignid);
        $row = $doCampaigns->toArray();
        $campaignCache[$campaignid] = $row;
    }
    return ($row);
}

function phpAds_getTrackerDetails($trackerid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    global $trackerCache;
    if (isset($trackerCache[$trackerid]) && is_array($trackerCache[$trackerid])) {
        $row = $trackerCache[$trackerid];
    } else {
        $doTrackers = OA_Dal::staticGetDO('trackers', $trackerid);
        $row = $doTrackers->toArray();
        $trackerCache[$trackerid] = $row;
    }
    return ($row);
}
