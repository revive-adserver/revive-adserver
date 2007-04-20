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
require_once MAX_PATH . '/plugins/reports/lib.php';

// Public name of the plugin info function
$plugin_info_function		= "info";

class Plugins_Reports_Advertiser_Campaignsummary extends Plugins_Reports {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Campaign Summary', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('Campaign Summary', $this->module, $this->package),
            'plugin-category'       => 'advertiser',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Advertiser Reports', $this->module, $this->package),
            'plugin-author'         => 'Michal Pawlowski',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency+phpAds_Client,
            'plugin-import'         => $this->getDefaults()
        );

        $this->saveDefaults();

        return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strCampaign, $strStartDate, $strEndDate;

        $default_campaign = isset($session['prefs']['GLOBALS']['report_campaign']) ? $session['prefs']['GLOBALS']['report_campaign'] : '';
        $default_start_date  = isset($session['prefs']['GLOBALS']['report_start_date']) ? $session['prefs']['GLOBALS']['report_start_date'] : date("Y/m/d",mktime (0,0,0,date("m")-1,1,date("Y")));
        $default_end_date  = isset($session['prefs']['GLOBALS']['report_end_date']) ? $session['prefs']['GLOBALS']['report_end_date'] : date("Y/m/d",mktime (0,0,0,date("m"),0,date("Y")));

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
        phpAds_SessionDataStore();
    }

    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/
    function execute($campaignid, $startdate, $enddate)
    {

        require_once 'Spreadsheet/Excel/Writer.php';

    	global $date_format;
    	global $strAffiliate;

    	$conf = & $GLOBALS['_MAX']['CONF'];

    	$reportName = $GLOBALS['strAdvertiserCampaignSummaryReport'];

    	$startDate = date(str_replace('%','',$date_format), strtotime($startdate));
    	$endDate   = date(str_replace('%','',$date_format), strtotime($enddate));
    	$dbStart = date('Y-m-d', strtotime($startdate));
    	$dbEnd = date('Y-m-d', strtotime($enddate));
    	// creating report object
        $workbook = new Spreadsheet_Excel_Writer();

    	$campaignArray = phpAds_getCampaignDetails($campaignid);

    	// mask campaign name if anonymous campaign
    	// need to fetch camapign details in another format for this (ugly but true)
        $campaignArray2 = Admin_DA::getPlacement($campaignid);
        $campaignArray['campaignname'] = MAX_getPlacementName($campaignArray2);

    	$clientArray = phpAds_getClientDetails($campaignArray['clientid']);
    	$todayDate = date(str_replace('%','',$GLOBALS['date_format']), time());

        $columnHeader =& $workbook->addFormat();
        $columnHeader->setBold();

        // setting filename for report
        $reportFileName = 'm3 ' . $reportName . ' from ' . date('Y-M-d', strtotime($startdate)) . ' to ' . date('Y-M-d', strtotime($enddate));
        $workbook->send($reportFileName . '.xls');
        $worksheet =& $workbook->addWorksheet(substr($reportName . " Report",0,30));

        $strCampaignRunDates = date(str_replace('%','',$date_format), strtotime($campaignArray['activate'])).
            ' - ' . date(str_replace('%','',$date_format), strtotime($campaignArray['expire']));

        // setting column width
        $worksheet->setColumn(0,0,30);
        $worksheet->setColumn(1,9,15);

        // Report "not structural" data
        $worksheet->write(0,0,'Report:', $columnHeader);
        $worksheet->write(0,1,$reportName);

        $worksheet->write(1,0,'Contact Name:', $columnHeader);
        $worksheet->write(1,1,$clientArray['contact']);

        $worksheet->write(2,0,'Contact E-mail:', $columnHeader);
        $worksheet->write(2,1,$clientArray['email']);

        $worksheet->write(3,0,'Campaign Name:', $columnHeader);
        $worksheet->write(3,1,$campaignArray['campaignname']);

        $worksheet->write(4,0,'Campaign Run Dates:', $columnHeader);
        $worksheet->write(4,1,$strCampaignRunDates);

        $worksheet->write(5,0,'Report Date:', $columnHeader);
        $worksheet->write(5,1,$todayDate);

        $worksheet->write(6,0,'Report Period:', $columnHeader);
        $worksheet->write(6,1,$startDate . ' - ' . $endDate);

        $worksheet->write(5,0,$reportDescription);
        // where to start printing structural data
        $rowStart = 8;
        $columnStart = 0;

        // formatting
        $formatInteger = &$workbook->addFormat();
        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);

        $formatDecimalPercentage =& $workbook->addFormat();
        $formatDecimalPercentage->setNumFormat(getPercentageDecimalFormat());

        $columnHeader = &$workbook->addFormat();
        $columnHeader->setAlign('center');
        $columnHeader->setBold();

        $query = "SELECT
                      c.campaignid AS campaign_id
                      ,c.campaignname
                      ,c.priority
                      ,c.views
                      ,c.clicks
                      ,c.conversions
                      ,coalesce(sum(ds.requests),0)        as requests
                      ,coalesce(sum(ds.impressions),0)     as impressions
                      ,coalesce(sum(ds.clicks),0)          as clicks
                      ,coalesce(sum(ds.conversions),0)     as conversions
                  FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." ds
                      ,".$conf['table']['prefix'].$conf['table']['banners']." b
                      ,".$conf['table']['prefix'].$conf['table']['campaigns']." c
                      ,".$conf['table']['prefix'].$conf['table']['clients']." cl
                 WHERE ds.ad_id = b.bannerid
                   AND b.campaignid = c.campaignid
                   AND c.clientid = cl.clientid
                   AND c.campaignid = '".$campaignid."'
                   AND ds.day >= '$dbStart'
                   AND ds.day <= '$dbEnd'
                 GROUP BY c.priority
                 ORDER BY c.priority ASC";

        $query2 = "SELECT
                       coalesce(sum(ds.requests),0)        as requests
                      ,coalesce(sum(ds.impressions),0)     as impressions
                      ,coalesce(sum(ds.clicks),0)          as clicks
                      ,coalesce(sum(ds.conversions),0)     as conversions
                  FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." ds
                      ,".$conf['table']['prefix'].$conf['table']['banners']." b
                      ,".$conf['table']['prefix'].$conf['table']['campaigns']." c
                      ,".$conf['table']['prefix'].$conf['table']['clients']." cl
                 WHERE ds.ad_id = b.bannerid
                   AND b.campaignid = c.campaignid
                   AND c.clientid = cl.clientid
                   AND c.campaignid = '".$campaignid."'
                   AND ds.day <= '$dbEnd'
                 GROUP BY c.priority
                 ORDER BY c.priority, c.campaignname ASC";

    	$res = phpAds_dbQuery($query) or phpAds_sqlDie();

    	// getting the db result to the temporary table - results needs to be prepared first
    	while ($row = phpAds_dbFetchArray($res)) {
            $data[] = $row;
    	}

    	$res2 = phpAds_dbQuery($query2) or phpAds_sqlDie();

    	$summaryRow = phpAds_dbFetchArray($res2);

        $numrows = (is_array($data)) ? count($data): 0;

        // preparing result data
    	$row = $this->prepareData($data);
    	//var_dump($row);
    	$priorityNames = array('0' => $GLOBALS['strPriorityLow']
    	                      ,'1' => $GLOBALS['strPriorityMedium']
    	                      ,'2' => $GLOBALS['strPriorityHigh']
    	                      ,'t' => "All Campaigns");

    	if ($campaignArray['views'] > 0) {
    	   $bookedMetric = 'CPM';
    	   $bookedValue = $campaignArray['views'];
    	   $remainingValue = $campaignArray['views'] - $summaryRow['views'];
    	} else if ($campaignArray['clicks'] > 0) {
    	   $bookedMetric = 'CPC';
    	   $bookedValue = $campaignArray['clicks'];
    	   $remainingValue = $campaignArray['clicks'] - $summaryRow['clicks'];
    	} else if ($campaignArray['conversions'] > 0) {
    	   $bookedMetric = 'CPA';
    	   $bookedValue = $campaignArray['conversions'];
    	   $remainingValue = $campaignArray['conversions'] - $summaryRow['conversions'];
    	}

    	$previousPriority = '';
    	$previousStart = $currentRow = $rowStart;

        $worksheet->write($currentRow,$columnStart + 1,$GLOBALS['strValue'],$columnHeader);

        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strRequests']);
        $worksheet->writeNumber($currentRow, $columnStart + 1, $row['requests'],$formatInteger);
        $currentRow++;
        $worksheet->write($currentRow, $columnStart, $GLOBALS['strImpressions']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['views']['total'],$formatInteger);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strClicks']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['clicks']['total'],$formatInteger);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strCTR']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                ($row['clicks']['total'] / $row['views']['total']) * 100,$formatDecimalPercentage);
        $currentRow++;
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart    , $GLOBALS['strBookedMetric']);
    	$worksheet->writeNumber($currentRow, $columnStart + 1, $bookedMetric);
        $currentRow++;

    	$worksheet->write($currentRow, $columnStart    , $GLOBALS['strValueBooked']);
    	$worksheet->writeNumber($currentRow, $columnStart + 1, $bookedValue);
        $currentRow++;

        $worksheet->write($currentRow, $columnStart    , $GLOBALS['strRemaining'] . ' as of ' . $endDate);
        $worksheet->writeNumber($currentRow, $columnStart + 1, $remainingValue);

        $workbook->close();
    }

    /*----------------------------------------*/
    /* Function preparing data for display    */
    /*----------------------------------------*/
    function prepareData(& $data)
    {
        $retArray = array();

        foreach ($data as $row) {
            $retArray['requests'] += $row['requests'];
            $retArray['views'][$row['priority']] = $row['impressions'];
            $retArray['views']['total'] += $row['impressions'];
            $retArray['clicks'][$row['priority']] = $row['clicks'];
            $retArray['clicks']['total'] += $row['clicks'];
        }

        return $retArray;
    }

}

?>