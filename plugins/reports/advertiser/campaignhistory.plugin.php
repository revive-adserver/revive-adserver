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

//require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/proprietary/EnhancedReport.php';

class Plugins_Reports_Advertiser_Campaignhistory extends EnhancedReport {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Campaign History Report', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('A daily breakdown of all activity for a specific campaign', $this->module, $this->package),
            'plugin-category'       => 'advertiser',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Advertiser Reports', $this->module, $this->package),
            'plugin-author'         => 'Niels Leenheer',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency+phpAds_Client,
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
        $conf = $GLOBALS['_MAX']['CONF'];
    	global $date_format;
    	global $strCampaign, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort, $strConversions, $strCNVRShort;

    	$conf = & $GLOBALS['_MAX']['CONF'];

    	// Format the start and end dates
        $dbStart = date("Y-m-d", strtotime($start));
        $dbEnd   = date("Y-m-d", strtotime($end));
        $start = date("Y/m/d", strtotime($start));
        $end   = date("Y/m/d", strtotime($end));

        $reportName = 'm3 Campaign History Report from ' . date('Y-M-d', strtotime($start)) . ' to ' . date('Y-M-d', strtotime($end)) . '.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

    	$res_query = "  SELECT
    						s.ad_id AS bannerid,
    						DATE_FORMAT(s.day, '".$date_format."') as day,
    						SUM(s.impressions) AS adviews,
    						SUM(s.clicks) AS adclicks,
    						SUM(s.conversions) AS adconversions
    					FROM
    						".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." as s,
    						".$conf['table']['prefix'].$conf['table']['banners']." as b
    					WHERE
    						s.ad_id=b.bannerid
    						AND b.campaignid='".$campaignid."'
    						AND s.day >= '".$dbStart."'
    						AND s.day <  '".$dbEnd."'
    					GROUP BY
    						day
                        ORDER BY
                            DATE_FORMAT(day, '%Y%m%d')
    				";
    	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();

    	while ($row_banners = phpAds_dbFetchArray($res_banners))
    	{
    		$stats[$row_banners['day']]['views'] 		= $row_banners['adviews'];
    		$stats[$row_banners['day']]['clicks'] 		= $row_banners['adclicks'];
    		$stats[$row_banners['day']]['conversions'] 	= $row_banners['adconversions'];
    	}

        // mask campaign name if anonymous campaign
        $campaign_details = Admin_DA::getPlacement($campaignid);
        echo $strCampaign.": ".strip_tags(MAX_getPlacementName($campaign_details))." - ".$start." - ".$end."\n\n";

        echo $strDay.$delimiter.$strImpressions.$delimiter.$strClicks.$delimiter.$strCTRShort.$delimiter.$strConversions.$delimiter.$strCNVRShort."\n";

    	$totalclicks      = 0;
    	$totalviews       = 0;
    	$totalconversions = 0;

    	if (isset($stats) && is_array($stats))
    	{
    		foreach (array_keys($stats) as $key)
    		{
    			echo $key.
    				 $delimiter.
    				 $stats[$key]['views'].
    				 $delimiter.
    				 $stats[$key]['clicks'].
    				 $delimiter.
    				 str_replace(',','.',phpAds_buildCTR($stats[$key]['views'], $stats[$key]['clicks'])).
    				 $delimiter.
    				 $stats[$key]['conversions'].
    				 $delimiter.
    				 str_replace(',','.',phpAds_buildCTR($stats[$key]['clicks'], $stats[$key]['conversions'])).
    				 "\n";

    			$totalclicks 		+= $stats[$key]['clicks'];
    			$totalviews			+= $stats[$key]['views'];
    			$totalconversions 	+= $stats[$key]['conversions'];
    		}
    	}

    	echo "\n";
    	echo $strTotal.
    		 $delimiter.
    		 $totalviews.
    		 $delimiter.
    		 $totalclicks.
    		 $delimiter.
    		 str_replace(',','.',phpAds_buildCTR ($totalviews, $totalclicks)).
    		 $delimiter.
    		 $totalconversions.
    		 $delimiter.
    		 str_replace(',','.',phpAds_buildCTR ($totalclicks, $totalconversions)).
    		 "\n";
    }

// new execute method that uses Excel workbook object
// speculative work, awaiting analysis and decision on this report

    function execute_NEW($campaignid, $start, $end, $delimiter=",")
    {
        $_REQUEST['breakdown']      = 'day';
        $_REQUEST['campaignid']     = $campaignid;
        $_REQUEST['period_preset']  = 'specific';
        $_REQUEST['period_start']   = date('Y-m-d', strtotime($start));
        $_REQUEST['period_end']     = date('Y-m-d', strtotime($end));
        $this->output($campaignid, $this->getStatsController('campaign-history'), $delimiter);
    }

    function output($campaignid, $statsController)
    {
        // mask campaign name if anonymous campaign
        $campaign_details = Admin_DA::getPlacement($campaignid);
        $start  = $statsController->aDates['day_begin'];
        $end    = $statsController->aDates['day_end'];

        global $strCampaign;

        $reportName = $strCampaign." History ".strip_tags(MAX_getPlacementName($campaign_details))." ".$start." - ".$end;

        require_once 'Spreadsheet/Excel/Writer.php';

        $workbook = new Spreadsheet_Excel_Writer();

        $columnHeader =& $workbook->addFormat();
        $columnHeader->setBold();
        $columnHeader->setSize(12);
        //$columnHeader->setBgColor('gray');
        //$columnHeader->setAlign('center');

//        $formatInteger = &$workbook->addFormat();
//        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);
//
//        $formatDecimalPercentage =& $workbook->addFormat();
//        $formatDecimalPercentage->setNumFormat(getPercentageDecimalFormat());

        $workbook->send($reportName . '.xls');

        $worksheet =& $workbook->addWorksheet(substr($reportName,0,30));

        $row = 0;
        // Report "not structural" data
        $worksheet->write($row,0, $strCampaign.' History:', $columnHeader);
        $worksheet->write($row,1, 'Daily', $columnHeader);
        $worksheet->write(++$row,0, 'Name:', $columnHeader);
        $worksheet->write($row,1, strip_tags(MAX_getPlacementName($campaign_details)), $columnHeader);
        $worksheet->write(++$row,0, 'Period:', $columnHeader);
        $worksheet->write($row,1, $start." - ".$end, $columnHeader);


        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController($statsController);
        $row++;
        $row++;
        $col = 0;
		foreach ($aHeaders as $k=>$v)
		{
            $worksheet->write($row,$col,$k);
		    $col++;
		    $sumKey = array_search($k,$statsController->columns);
		    $sumVal = $statsController->total[$sumKey];
		    $aSumColumns[$sumKey] = $sumVal;
		}
		foreach ($aData as $aRow)
		{
            $row++;
            $col = 0;
    		foreach ($aRow as $k=>$v)
    		{
                $worksheet->write($row,$col,$v);
		        $col++;
    		}
		}
        $row++;
        $row++;
        $col = 0;
		foreach ($aHeaders as $k=>$v)
		{
		    if ($col>0)
		    {
                $worksheet->write($row,$col,$k);
		    }
		    $col++;
		}
        $row++;
        $col = 0;
        $aSumColumns[0]='Totals';
		foreach ($aSumColumns as $k=>$v)
		{
            $worksheet->write($row,$col,$v);
	        $col++;
		}
        $workbook->close();
    }

    /**
     * Return section headers and data from a statsController instance
     *
     * @param string statsController type
     * @return array An array containing headers (key 0) and data (key 1)
     */
    function getStatsController($controller_type)
    {
        require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsControllerFactory.php';
        return StatsControllerFactory::newStatsController($controller_type, array(
            'skipFormatting' => true,
            'disablePager'   => true
        ));
    }

    /**
     * Return section headers and data from a statsController instance
     *
     * @param string statsController type
     * @return array An array containing headers (key 0) and data (key 1)
     */
    function getHeadersAndDataFromStatsController(&$statsController)
    {
        $stats = $statsController->exportArray();

        $aHeaders = array();
        foreach ($stats['headers'] as $k => $v) {
            switch ($stats['formats'][$k]) {
                case 'default':
                    $aHeaders[$v] = 'numeric';
                    break;
                case 'currency':
                    $aHeaders[$v] = 'decimal';
                    break;
                case 'percent':
                case 'date':
                case 'time':
                    $aHeaders[$v] = $stats['formats'][$k];
                    break;
                case 'text':
                default:
                    $aHeaders[$v] = 'text';
                    break;
            }
        }

        $aData = array();
        foreach ($stats['data'] as $i => $row)
        {
            foreach ($row as $k => $v) {
                $aData[$i][] = $stats['formats'][$k] == 'datetime' ? $this->_report_writer->convertToDate($v) : $v;
            }
        }
        return array($aHeaders, $aData);
    }

}

?>