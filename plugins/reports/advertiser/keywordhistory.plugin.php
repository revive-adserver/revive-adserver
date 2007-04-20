<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';

class Plugins_Reports_Advertiser_Keywordhistory extends Plugins_Reports {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            "plugin-name"            => MAX_Plugin_Translation::translate('Keyword Campaign History Report', $this->module, $this->package),
            "plugin-description"    => MAX_Plugin_Translation::translate('A detailed breakdown of a keyword campaign, including conversion tracking data', $this->module, $this->package),
            'plugin-category'     => 'advertiser',
            'plugin-category-name'    => MAX_Plugin_Translation::translate('Advertiser Reports', $this->module, $this->package),
            "plugin-author"      => "Andrew",
            "plugin-export"      => "csv",
            "plugin-authorize"   => phpAds_Admin+phpAds_Agency+phpAds_Client,
            'plugin-import'         => $this->getDefaults()
        );

        $this->saveDefaults();

        return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strCampaign, $strStartDate, $strEndDate, $strDelimiter;

        $default_campaign = isset($session['prefs']['GLOBALS']['report_campaign']) ? $session['prefs']['GLOBALS']['report_campaign'] : '';
        $default_start_date  = isset($session['prefs']['GLOBALS']['report_start_date']) ? $session['prefs']['GLOBALS']['report_start_date'] : date("Y/m/d",mktime (0,0,0,date("m"),date("d")-7,date("Y")));
        $default_end_date  = isset($session['prefs']['GLOBALS']['report_end_date']) ? $session['prefs']['GLOBALS']['report_end_date'] : date("Y/m/d",mktime (0,0,0,date("m"),date("d")-1,date("Y")));
        $default_delimiter  = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';

        $aImport = array (
            'campaign' => array (
                'title'         => MAX_Plugin_Translation::translate($strCampaign, $this->module, $this->package),
                'type'          => 'campaignid-dropdown',
                'default'       => $default_campaign
            ),
            'start_date'    => array (
                'title'         => MAX_Plugin_Translation::translate($strStartDate, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 10,
                'default'       => $default_start_date
            ),
            'end_date'        => array (
                'title'         => MAX_Plugin_Translation::translate($strEndDate, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 10,
                'default'       => $default_end_date
            ),
            'delimiter'        => array (
                'title'         => MAX_Plugin_Translation::translate($strDelimiter, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 1,
                'default'       => $default_delimiter
            )
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['campaign'])) {
            $session['prefs']['GLOBALS']['report_campaign'] = $_REQUEST['campaign'];
        }
        if (isset($_REQUEST['start_date'])) {
            $session['prefs']['GLOBALS']['report_start_date'] = $_REQUEST['start_date'];
        }
        if (isset($_REQUEST['end_date'])) {
            $session['prefs']['GLOBALS']['report_end_date'] = $_REQUEST['end_date'];
        }
        if (isset($_REQUEST['delimiter'])) {
            $session['prefs']['GLOBALS']['report_delimiter'] = $_REQUEST['delimiter'];
        }
        phpAds_SessionDataStore();
    }

    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/

    function execute($campaignid, $start, $end, $delimiter=",")
    {
        $conf = & $GLOBALS['_MAX']['CONF'];
        global $strCampaign;

        // Format the start and end dates
        $dbStart = date("Ymd000000", strtotime($start));
        $dbEnd   = date("Ymd235959", strtotime($end));
        $start = date("Y/m/d", strtotime($start));
        $end   = date("Y/m/d", strtotime($end));

        // Print the content header
        $reportName = 'm3 Keyword Campaign History Report from ' . date('Y-M-d', strtotime($start)) . ' to ' . date('Y-M-d', strtotime($end)) . '.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

        // Build the array containing the required statistics

        // Get trackers linked to this campaign, to avoid doing this over and over...
        // (The campaign is supplied as a parameter to the function)
        $resTrackers = phpAds_dbQuery("
                SELECT
                    c.trackerid,
                    t.trackername
                FROM
                    ".$conf['table']['prefix'].$conf['table']['campaigns_trackers']." as c,
                    ".$conf['table']['prefix'].$conf['table']['trackers']." as t
                WHERE
                    c.campaignid = '".$campaignid."'
                    AND c.trackerid = t.trackerid"
        );

        // Store the trackers linked to this campaign, so they can be used :-)
        while ($rowTrackers = phpAds_dbFetchArray($resTrackers)) {
            $trackers[$rowTrackers['trackerid']]['name'] = $rowTrackers["trackername"];
        }

        // Get banner IDs for this campaign
        $resBanners = phpAds_dbQuery("
    				SELECT
    					bannerid,
    					description,
    					active
    				FROM
    					".$conf['table']['prefix'].$conf['table']['banners']."
    				WHERE
    					campaignid = '".$campaignid."'"
        );

        // Initialise the index of banners, and a counter for
        // the number of hidden banners
        $bannerIndex   = 0;
        $bannersHidden = 0;

        // For each banner ID...
        while ($rowBanners = phpAds_dbFetchArray($resBanners)) {

             // Store the banner ID and name in the next $bannerIndex branch
            $stats[$bannerIndex]['id']   = $rowBanners['bannerid'];

            // mask banner name if anonymous campaign
            $campaign_details = Admin_DA::getPlacement($campaignid);
            $campaignAnonymous = $campaign_details['anonymous'] == 't' ? true : false;
      	    $rowBanners['description'] = MAX_getAdName($row['description'], null, null, $campaignAnonymous, $rowBanners['bannerid']);

            $stats[$bannerIndex]['name'] = $rowBanners['description'];

            // Is banner active?
            if ($rowBanners['active'] == 't') {
                $stats[$bannerIndex]['active'] = true;
            } else {
                $stats[$bannerIndex]['active'] = false;
                $bannersHidden++;
            }

            // Check whether total cost is set for this banner
            $key = 'total_cost' . $stats[$bannerIndex]['id'];
            if (isset($HTTP_POST_VARS[$key])) {
                $stats[$bannerIndex]['totalCost'] = $HTTP_POST_VARS[$key];
            } else {
                $stats[$bannerIndex]['totalCost'] = 0;
            }

            // Select all the clicks for the current banner, and
            // group them by source (keyword)
            $resClicks = phpAds_dbQuery("
    					SELECT
    						ad_id AS bannerid,
    						page as keywords,
    						count(page) as clicks
    					FROM
    						".$conf['table']['prefix'].$conf['table']['data_raw_ad_click']."
    					WHERE
    						bannerid = ".$stats[$bannerIndex]['id']."
    						AND date_time >= '".$dbStart."'
    						AND date_time <  '".$dbEnd."'
    					GROUP BY
    						page"
            );

            // Initialise the index of the keyword
            $keywordIndex = 0;

            while ($rowClicks = phpAds_dbFetchArray($resClicks)) {

                // Store the source (keyword) name and resulting clicks
                // for the banner
                $stats[$bannerIndex]['keywords'][$keywordIndex]['name']   = "    ".$rowClicks['keywords'];
                $stats[$bannerIndex]['keywords'][$keywordIndex]['clicks'] =        $rowClicks['clicks'];

                // Add the tracker details for the campaign to the stats array,
                // in a 'trackers' index for the current banner
                foreach ($trackers as $key => $value) {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['trackers'][$key]['name'] = $value['name'];
                }

                // Get the conversions for the current banner and keyword
                // where the conversions are limited to 'cnv_latest=1', ensuring
                // that the conversion has resulted from the current banner
                // being the last banner shown to a user
                $select = "SELECT
    								c.conversionid,
                                    c.cnv_logstats,
                                    c.trackerid,
                                    v.value
    							FROM
    								".$conf['table']['prefix'].$conf['table']['conversionlog']." as c
                                LEFT JOIN
                                    ".$conf['table']['prefix'].$conf['table']['variablevalues']." as v
                                ON
                                    c.conversionid = v.conversionid
    							WHERE
    								c.action_bannerid = ".$stats[$bannerIndex]['id']."
    								AND c.action_source = '".$rowClicks['keywords']."'
    								AND c.t_stamp >= '".$dbStart."'
    								AND c.t_stamp <  '".$dbEnd."'
    								AND c.cnv_latest = 1";

                $resConversions = phpAds_dbQuery($select);

                // Set the number of sale and non-sale conversions, and the total value
                // of the conversions for this banner/keyword combination to zero
                $stats[$bannerIndex]['keywords'][$keywordIndex]['sales']       = 0;
                $stats[$bannerIndex]['keywords'][$keywordIndex]['conversions'] = 0;
                $stats[$bannerIndex]['keywords'][$keywordIndex]['totalValue']  = 0;

                // For each conversion...
                while ($rowConversions = phpAds_dbFetchArray($resConversions)) {

                    // If the conversion was a sale (ie. not a non-sale conversion)...
                    if ($rowConversions['cnv_logstats'] == 'y') {
                        // Log the sale for the current banner/keyword
                        $stats[$bannerIndex]['keywords'][$keywordIndex]['sales']++;
                        // Update the total value, if applicable
                        if (isset($rowConversions['value'])) {
                            $stats[$bannerIndex]['keywords'][$keywordIndex]['totalValue'] += $rowConversions['value'];
                        }
                    }

                    // Log the conversion for the current banner/keyword, regardless
                    // of it being a sale or otherwise...
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['conversions']++;
                    if (!isset($stats[$bannerIndex]['keywords'][$keywordIndex]['trackers'][$rowConversions['trackerid']]['conversions'])) {
                        $stats[$bannerIndex]['keywords'][$keywordIndex]['trackers'][$rowConversions['trackerid']]['conversions'] = 0;
                    }
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['trackers'][$rowConversions['trackerid']]['conversions']++;
                }

                // Calculate the statistics for this banner/keyword combination
                if ($stats[$bannerIndex]['keywords'][$keywordIndex]['clicks'] > 0) {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['cpc']          = $stats[$bannerIndex]['keywords'][$keywordIndex]['totalCost'] / $stats[$bannerIndex]['keywords'][$keywordIndex]['clicks'];
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['cpc']          = phpAds_formatPercentage($stats[$bannerIndex]['keywords'][$keywordIndex]['cpc'], 2);
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['sr']           = $stats[$bannerIndex]['keywords'][$keywordIndex]['sales'] / $stats[$bannerIndex]['keywords'][$keywordIndex]['clicks'];
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['sr']           = phpAds_formatPercentage($stats[$bannerIndex]['keywords'][$keywordIndex]['sr'], 2);
                } else {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['cpc']          = 0;
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['sr']           = 0;
                }
                if ($stats[$bannerIndex]['keywords'][$keywordIndex]['conversions'] > 0) {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['cpco']         = $stats[$bannerIndex]['keywords'][$keywordIndex]['totalCost'] / $stats[$bannerIndex]['keywords'][$keywordIndex]['conversions'];
                } else {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['cpco']         = 0;
                }
                if ($stats[$bannerIndex]['keywords'][$keywordIndex]['sales'] > 0) {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['averageValue'] = $stats[$bannerIndex]['keywords'][$keywordIndex]['totalValue'] / $stats[$bannerIndex]['keywords'][$keywordIndex]['sales'];
                } else {
                    $stats[$bannerIndex]['keywords'][$keywordIndex]['averageValue'] = 0;
                }

                // Update the keyword index
                $keywordIndex++;

            }

            // Calculate the banner totals and other statistics
            $totalClicksForBanner      = 0;
            $totalSalesForBanner       = 0;
            $totalConversionsForBanner = 0;
            $totalValueForBanner       = 0;

            if (isset($stats[$bannerIndex]['keywords'])) {
                foreach($stats[$bannerIndex]['keywords'] as $sources) {
                    $totalClicksForBanner      += $sources['clicks'];
                    $totalSalesForBanner       += $sources['sales'];
                    $totalConversionsForBanner += $sources['conversions'];
                    $totalValueForBanner       += $sources['totalValue'];
                }
            }

            $stats[$bannerIndex]['clicks']           = $totalClicksForBanner;
            $stats[$bannerIndex]['sales']            = $totalSalesForBanner;
            $stats[$bannerIndex]['conversions']      = $totalConversionsForBanner;
            if ($stats[$bannerIndex]['clicks'] > 0) {
                $stats[$bannerIndex]['cpc']          = $stats[$bannerIndex]['totalCost'] / $stats[$bannerIndex]['clicks'];
                $stats[$bannerIndex]['cpc']          = phpAds_formatPercentage($stats[$bannerIndex]['cpc'], 2);
                $stats[$bannerIndex]['sr']           = $stats[$bannerIndex]['sales'] / $stats[$bannerIndex]['clicks'];
                $stats[$bannerIndex]['sr']           = phpAds_formatPercentage($stats[$bannerIndex]['sr'], 2);
            } else {
                $stats[$bannerIndex]['cpc']          = 0;
                $stats[$bannerIndex]['sr']           = 0;
            }
            if ($stats[$bannerIndex]['conversions'] > 0) {
                $stats[$bannerIndex]['cpco']         = $stats[$bannerIndex]['totalCost'] / $stats[$bannerIndex]['conversions'];
            } else {
                $stats[$bannerIndex]['cpco']         = 0;
            }
            $stats[$bannerIndex]['totalValue']       = $totalValueForBanner;
            if ($stats[$bannerIndex]['sales'] > 0) {
                $stats[$bannerIndex]['averageValue'] = $stats[$bannerIndex]['totalValue'] / $stats[$bannerIndex]['sales'];
            } else {
                $stats[$bannerIndex]['averageValue'] = 0;
            }

            // Update the banner index
            $bannerIndex++;

        }

        // Print the campaign information

    	// mask campaign name if anonymous campaign
        echo $strCampaign.": ".strip_tags(MAX_getPlacementName($campaign_details))." - ".$start." - ".$end."\n\n";

        foreach($stats as $banner) {

            // Print the main column headings for each banner
            echo $GLOBALS['strName'].$delimiter.
                 $GLOBALS['strID'].$delimiter.
                 $GLOBALS['strClicks'].$delimiter.
                 $GLOBALS['strCPCShort'].$delimiter.
                 $GLOBALS['strTotalCost'].$delimiter.
                 $GLOBALS['strConversions'].$delimiter.
                 $GLOBALS['strCNVRShort'].$delimiter.
                 $GLOBALS['strCPCoShort'].$delimiter.
                 'Total Value'.$delimiter.
                 'Average Value';

            // Print the different tracker column headings for each banner
            foreach ($trackers as $trackerid => $tracker) {
                echo $delimiter.$trackerid." - ".$tracker['name'];
            }

            echo "\n\n";

            // Print the banner totals information
            echo 'Banner: '.$banner['name'].$delimiter.
                 $banner['id'].$delimiter.
                 ($banner['clicks']       == 0 ? '' : $banner['clicks']).$delimiter.
                 ($banner['cpc']          == 0 ? '' : phpAds_formatNumber($banner['cpc'],2)).$delimiter.
                 ($banner['totalCost']    == 0 ? '' : $banner['totalCost']).$delimiter.
                 ($banner['sales']        == 0 ? '' : $banner['sales']).$delimiter.
                 ($banner['sr']           == 0 ? '' : $banner['sr']).$delimiter.
                 ($banner['cpco']         == 0 ? '' : phpAds_formatNumber($banner['cpco'],2)).$delimiter.
                 ($banner['totalValue']   == 0 ? '' : number_format($banner['totalValue'], 2, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)).$delimiter.
                 ($banner['averageValue'] == 0 ? '' : number_format($banner['averageValue'], 2, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator));

            echo "\n\n";

            // Print each keyword line for the banner
            if (isset($banner['keywords'])) {
                foreach ($banner['keywords'] as $source) {
                    echo $source['name'].$delimiter.
                         $source['id'].$delimiter.
                         ($source['clicks']       == 0 ? '' : $source['clicks']).$delimiter.
                         ($source['cpc']          == 0 ? '' : phpAds_formatNumber($source['cpc'],2)).$delimiter.
                         ($source['totalCost']    == 0 ? '' : $source['totalCost']).$delimiter.
                         ($source['sales']        == 0 ? '' : $source['sales']).$delimiter.
                         ($source['sr']           == 0 ? '' : $source['sr']).$delimiter.
                         ($source['cpco']         == 0 ? '' : phpAds_formatNumber($source['cpco'],2)).$delimiter.
                         ($source['totalValue']   == 0 ? '' : number_format($source['totalValue'], 2, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)).$delimiter.
                         ($source['averageValue'] == 0 ? '' : number_format($source['averageValue'], 2, $phpAds_DecimalPoint, $phpAds_ThousandsSeperator));

                    foreach ($source['trackers'] as $id=>$tracker) {
                        echo $delimiter.$tracker['conversions'];
                    }

                    echo "\n";

                }
            }

            echo "\n\n";

        }

    }
}

?>