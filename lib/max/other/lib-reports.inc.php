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
$Id: lib-reports.inc.php 6005 2006-11-17 15:48:13Z andrew@m3.net $
*/

require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

function phpAds_SendMaintenanceReport($advertiserId, $first_unixtimestamp, $last_unixtimestamp, $update = true)
{
    MAX::debug('  Preparing advertiser report for advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
    global $conf, $phpAds_CharSet, $date_format, $strBanner, $strCampaign, $strImpressions,
           $strClicks, $strConversions, $strLinkedTo, $strMailSubject, $strMailHeader,
           $strMailBannerStats, $strMailFooter, $strMailReportPeriod, $strMailReportPeriodAll,
           $strLogErrorBanners, $strLogErrorClients, $strLogErrorViews, $strLogErrorClicks,
           $strLogErrorConversions, $strNoStatsForCampaign, $strNoViewLoggedInInterval,
           $strNoClickLoggedInInterval, $strNoCampaignLoggedInInterval, $strTotal,
           $strTotalThisPeriod;
    // Convert timestamps to SQL format
    $last_sqltimestamp  = date("YmdHis", $last_unixtimestamp);
    $first_sqltimestamp = date("YmdHis", $first_unixtimestamp);
    // Get Advertiser details
    $query = "
        SELECT
            clientid,
            clientname,
            contact,
            email,
            language,
            report,
            reportinterval,
            reportlastdate,
            UNIX_TIMESTAMP(reportlastdate) AS reportlastdate_t
        FROM
            {$conf['table']['prefix']}{$conf['table']['clients']}
        WHERE
            clientid = $advertiserId";
    MAX::debug('  Getting details of advertiser ID ' . $advertiserId . '.', PEAR_LOG_DEBUG);
    $rAdvertiserResult = phpAds_dbQuery($query);
    if (phpAds_dbNumRows($rAdvertiserResult) < 1) {
        MAX::debug('  Error obtaining details for advertiser ID ' . $advertiserId . '.', PEAR_LOG_ERR);
    } else {
        $aAdvertiserDetails = phpAds_dbFetchArray($rAdvertiserResult);
        $active_campaigns = false;
        $log = '';
        // Fetch all placements belonging to advertiser
        $query = "
            SELECT
                campaignid,
                campaignname,
                views,
                clicks,
                conversions,
                expire,
                UNIX_TIMESTAMP(expire) as expire_st,
                activate,
                UNIX_TIMESTAMP(activate) as activate_st,
                active
        FROM
            {$conf['table']['prefix']}{$conf['table']['campaigns']}
        WHERE
            clientid = {$aAdvertiserDetails['clientid']}";
        MAX::debug('    Getting details of all placements owned by advertiser ID ' . $aAdvertiserDetails['clientid'] . '.', PEAR_LOG_DEBUG);
        $rPlacementResult = phpAds_dbQuery($query);
        if (phpAds_dbNumRows($rPlacementResult) > 0) {
            while ($aPlacement = phpAds_dbFetchArray($rPlacementResult)) {
                // Fetch all ads in the placement
                $query = "
                    SELECT
                        bannerid,
                        campaignid,
                        URL,
                        active,
                        description,
                        alt
                    FROM
                        {$conf['table']['prefix']}{$conf['table']['banners']}
                    WHERE
                        campaignid = {$aPlacement['campaignid']}";
                MAX::debug('    Getting details of all ads owned by placement ID ' . $aPlacement['campaignid'] . '.', PEAR_LOG_DEBUG);
                $rAdResult = phpAds_dbQuery($query);
                if (phpAds_dbNumRows($rAdResult) > 0) {
                    $active_banners = false;
                    $log .= "\n".$strCampaign."  ".strip_tags(phpAds_buildName($aPlacement['campaignid'], $aPlacement['campaignname']))."\n";
                    $log .= "=======================================================\n\n";
                    while ($aAd = phpAds_dbFetchArray($rAdResult)) {
                        MAX::debug('    Preparing report details for ad ID ' . $aAd['bannerid'] . '.', PEAR_LOG_DEBUG);
                        $adviews = phpAds_totalViews($aAd['bannerid']);
                        $aAdvertiserDetails['views_used'] = $adviews;
                        $adclicks = phpAds_totalClicks($aAd['bannerid']);
                        $aPlacement['clicks_used'] = $adclicks;
                        $adconversions = phpAds_totalConversions($aAd['bannerid']);
                        $aPlacement['conversions_used'] = $adconversions;
                        if ($adviews > 0 || $adclicks > 0 || $adconversions > 0) {
                            $log .= $strBanner."  ".strip_tags(phpAds_buildBannerName ($aAd['bannerid'], $aAd['description'], $aAd['alt']))."\n";
                            $log .= $strLinkedTo.": ".$aAd['URL']."\n";
                            $log .= "-------------------------------------------------------\n";
                            $active_banner_stats = false;
                            if ($adviews > 0) {
                                $log .= $strImpressions.' ('.$strTotal.'):    '.$adviews."\n";
                                // Fetch all ad impressions belonging to the ad, grouped by day
                                $query = "
                                    SELECT
                                        SUM(impressions) as qnt,
                                        DATE_FORMAT(day, '$date_format') as t_stamp_f,
                                        TO_DAYS(day) AS the_day,
                                    FROM
                                        {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
                                    WHERE
                                        ad_id = {$aAd['bannerid']}
                                        AND
                                        impressions > 0
                                        AND
                                        UNIX_TIMESTAMP(day) >= $first_unixtimestamp
                                        AND
                                        UNIX_TIMESTAMP(day) < $last_unixtimestamp
                                    GROUP BY
                                        day
                                    ORDER BY
                                        day DESC";
                                MAX::debug('    Obtaining impressions for the report period for ad ID ' . $aAd['bannerid'] . '.', PEAR_LOG_DEBUG);
                                $rAdImpressionsResult = phpAds_dbQuery($query);
                                if (phpAds_dbNumRows($rAdImpressionsResult) > 0) {
                                    $total = 0;
                                    while ($row_adviews = phpAds_dbFetchArray($rAdImpressionsResult)) {
                                        $log .= "      ".$row_adviews['t_stamp_f'].":   ".$row_adviews['qnt']."\n";
                                        $total += $row_adviews['qnt'];
                                    }
                                    $log .= $strTotalThisPeriod.": ".$total."\n";
                                    $active_banner_stats = true;
                                } else {
                                    $log .= "      ".$strNoViewLoggedInInterval."\n";
                                }
                            }
                            if ($adclicks > 0) {
                                $log .= "\n".$strClicks." (".$strTotal."):   ".$adclicks."\n";
                                // Fetch all ad clicks belonging to the ad, grouped by day
                                $query = "
                                    SELECT
                                        SUM(clicks) as qnt,
                                        DATE_FORMAT(day, '$date_format') as t_stamp_f,
                                        TO_DAYS(day) AS the_day,
                                    FROM
                                        {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
                                    WHERE
                                        ad_id = {$aAd['bannerid']}
                                        AND
                                        clicks > 0
                                        AND
                                        UNIX_TIMESTAMP(day) >= $first_unixtimestamp
                                        AND
                                        UNIX_TIMESTAMP(day) < $last_unixtimestamp
                                    GROUP BY
                                        day
                                    ORDER BY
                                        day DESC";
                                MAX::debug('    Obtaining clicks for the report period for ad ID ' . $aAd['bannerid'] . '.', PEAR_LOG_DEBUG);
                                $rAdClicksResult = phpAds_dbQuery($query);
                                if (phpAds_dbNumRows($rAdClicksResult) > 0) {
                                    $total = 0;
                                    while ($row_adclicks = phpAds_dbFetchArray($rAdClicksResult)) {
                                        $log .= "      ".$row_adclicks['t_stamp_f'].":   ".$row_adclicks['qnt']."\n";
                                        $total += $row_adclicks['qnt'];
                                    }
                                    $log .= $strTotalThisPeriod.": ".$total."\n";
                                    $active_banner_stats = true;
                                } else {
                                    $log .= "      ".$strNoClickLoggedInInterval."\n";
                                }
                            }
                            if ($adconversions > 0) {
                                $log .= "\n".$strConversions." (".$strTotal."):   ".$adconversions."\n";
                                // Fetch all ad conversions belonging to the ad, grouped by day
                                $query = "
                                    SELECT
                                        SUM(conversions) as qnt,
                                        DATE_FORMAT(day, '$date_format') as t_stamp_f,
                                        TO_DAYS(day) AS the_day,
                                    FROM
                                        {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
                                    WHERE
                                        ad_id = {$aAd['bannerid']}
                                        AND
                                        conversions > 0
                                        AND
                                        UNIX_TIMESTAMP(day) >= $first_unixtimestamp
                                        AND
                                        UNIX_TIMESTAMP(day) < $last_unixtimestamp
                                    GROUP BY
                                        day
                                    ORDER BY
                                        day DESC";
                                MAX::debug('    Obtaining clicks for the report period for ad ID ' . $aAd['bannerid'] . '.', PEAR_LOG_DEBUG);
                                $rAdConcverionsResult = phpAds_dbQuery($query);
                                if (phpAds_dbNumRows($rAdConcverionsResult) > 0) {
                                    $total = 0;
                                    while ($row_adconversions = phpAds_dbFetchArray($rAdConcverionsResult)) {
                                        $log .= "      ".$row_adcconversions['t_stamp_f'].":   ".$row_adconversions['qnt']."\n";
                                        $total += $row_adconversions['qnt'];
                                    }
                                    $log .= $strTotalThisPeriod.": ".$total."\n";
                                    $active_banner_stats = true;
                                } else {
                                    $log .= "      ".$strNoConversionLoggedInInterval."\n";
                                }
                            }
                            $log .= "\n\n";
                            if ($active_banner_stats == true || ($active_banner_stats == false && $aPlacement['active'] == 't')) {
                                $active_banners = true;
                            }
                        }
                    }
                    if ($active_banners == true) {
                        $active_campaigns = true;
                    } else {
                        $log .= $strNoStatsForCampaign."\n\n\n";
                    }
                }
            }
        }
        // E-mail the report to the advertiser, if the report is prepared
        if ($aAdvertiserDetails["email"] != '' && $active_campaigns == true) {
            $subject  = $strMailSubject.": ".$aAdvertiserDetails["clientname"];
            $body    = "$strMailHeader\n";
            $body   .= "$strMailBannerStats\n";
            if ($first_unixtimestamp == 0) {
                $body   .= "$strMailReportPeriodAll\n\n";
            } else {
                $body   .= "$strMailReportPeriod\n\n";
            }
            $body   .= "$log\n";
            $body   .= "$strMailFooter";
            $body    = str_replace("{clientname}",    $aAdvertiserDetails['clientname'], $body);
            $body    = str_replace("{contact}",       $aAdvertiserDetails['contact'], $body);
            $body    = str_replace("{adminfullname}", $conf['admin_fullname'], $body);
            $body    = str_replace("{startdate}",     date(str_replace('%', '', $date_format), $first_unixtimestamp), $body);
            $body    = str_replace("{enddate}",       date(str_replace('%', '', $date_format), $last_unixtimestamp), $body);
            if (MAX::sendMail($aAdvertiserDetails['email'], $aAdvertiserDetails['contact'], $subject, $body)) {
                // Update last run
                if ($update == true) {
                    $query = "
                        UPDATE
                            {$conf['table']['prefix']}{$conf['table']['clients']}
                        SET
                            reportlastdate = NOW()
                        WHERE
                            clientid = {$aAdvertiserDetails['clientid']}";
                    MAX::debug('    Updating the date the report was last sent for advertiser ID ' . $aAdvertiserDetails['clientid'] . '.', PEAR_LOG_DEBUG);
                    $res_update = phpAds_dbQuery($query);
                }
            }
        }
    }
}

?>
