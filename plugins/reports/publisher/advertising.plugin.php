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
$Id: advertising.plugin.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

class Plugins_Reports_Publisher_Advertising extends Plugins_Reports {

    // Public info function
    function info()
    {
    	include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Advertising Summary', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('This is a summary of the advertising activity on the site.', $this->module, $this->package),
            'plugin-category'       => 'publisher',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Publisher Reports', $this->module, $this->package),
            'plugin-author'         => 'Michal Pawlowski',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency+phpAds_Affiliate,
            'plugin-import'         => $this->getDefaults()
    	);

    	$this->saveDefaults();

    	return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strAffiliate, $strStartDate, $strEndDate;

        $default_publisher = isset($session['prefs']['GLOBALS']['report_publisher']) ? $session['prefs']['GLOBALS']['report_publisher'] : '';
        $default_start_date  = isset($session['prefs']['GLOBALS']['report_start_date']) ? $session['prefs']['GLOBALS']['report_start_date'] : date("Y/m/d",mktime (0,0,0,date("m")-1,1,date("Y")));
        $default_end_date  = isset($session['prefs']['GLOBALS']['report_end_date']) ? $session['prefs']['GLOBALS']['report_end_date'] : date("Y/m/d",mktime (0,0,0,date("m"),0,date("Y")));

        $aImport = array (
            'publisher' => array (
                'title'         => MAX_Plugin_Translation::translate($strAffiliate, $this->module, $this->package),
                'type'          => 'affiliateid-dropdown',
                'default'       => $default_publisher
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

        if (isset($_REQUEST['publisher'])) {
            $session['prefs']['GLOBALS']['report_publisher'] = $_REQUEST['publisher'];
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
    function execute($affiliateid, $startdate, $enddate)
    {

        require_once 'Spreadsheet/Excel/Writer.php';

    	global $date_format;
    	global $strAffiliate;

    	$conf = & $GLOBALS['_MAX']['CONF'];

    	$reportName = $GLOBALS['strPublisherAdvertisingSummaryReport'];

    	$startDate = date(str_replace('%','',$date_format), strtotime($startdate));
    	$endDate   = date(str_replace('%','',$date_format), strtotime($enddate));
    	$dbStart = date('Y-m-d', strtotime($startdate));
    	$dbEnd = date('Y-m-d', strtotime($enddate));
    	// creating report object
        $workbook = new Spreadsheet_Excel_Writer();

        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate,
                                       $affiliateid, $GLOBALS['strPublisherAdvertisingSummaryDescription']);
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
                       c.priority
                      ,coalesce(sum(ds.requests),0)        as requests
                      ,coalesce(sum(ds.impressions),0)     as impressions
                      ,coalesce(sum(ds.clicks),0)          as clicks
                      ,coalesce(sum(ds.conversions),0)     as conversions
                  FROM ".$conf['table']['prefix'].$conf['table']['zones']." z
                      ,".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." ds
                      ,".$conf['table']['prefix'].$conf['table']['banners']." b
                      ,".$conf['table']['prefix'].$conf['table']['campaigns']." c
                 WHERE z.zoneid = ds.zone_id
                   AND ds.ad_id = b.bannerid
                   AND b.campaignid = c.campaignid
                   AND z.affiliateid = '".$affiliateid."'
                   AND ds.day >= '$dbStart'
                   AND ds.day <= '$dbEnd'
                 GROUP BY c.priority
                 ORDER BY c.priority ASC";

    	$res = phpAds_dbQuery($query) or phpAds_sqlDie();

    	// getting the db result to the temporary table - results needs to be prepared first
    	while ($row = phpAds_dbFetchArray($res)) {
    	    $data[] = $row;
    	}

        $numrows = (is_array($data)) ? count($data): 0;

        // preparing result data
    	$row = $this->prepareData($data);
    	//var_dump($row);
    	$priorityNames = array('0' => $GLOBALS['strPriorityLow']
    	                      ,'1' => $GLOBALS['strPriorityMedium']
    	                      ,'2' => $GLOBALS['strPriorityHigh']
    	                      ,'t' => "All Campaigns");
    	$previousPriority = '';
    	$previousStart = $currentRow = $rowStart;

        $worksheet->write($currentRow,$columnStart + 1,$GLOBALS['strValue']   , $columnHeader);

        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strRequests']);
        $worksheet->writeNumber($currentRow, $columnStart + 1, $row['requests'],$formatInteger);
        $currentRow++;
        $currentRow++;
        $worksheet->write($currentRow, $columnStart, $GLOBALS['strImpressions'], $columnHeader);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strPriorityHigh']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['views']['2'],$formatInteger);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strPriorityMedium']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['views']['1'],$formatInteger);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strPriorityLow']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['views']['0'],$formatInteger);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strTotal']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['views']['total'],$formatInteger);
        $currentRow++;
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strClicks'], $columnHeader);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                $row['clicks']['total'],$formatInteger);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strCTR']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                ($row['clicks']['total'] / $row['views']['total']) * 100,$formatDecimalPercentage);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strCTRShortHigh']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                ($row['clicks']['2'] / $row['views']['2']) * 100,$formatDecimalPercentage);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strCTRShortMedium']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                ($row['clicks']['1'] / $row['views']['1']) * 100,$formatDecimalPercentage);
        $currentRow++;
    	$worksheet->write($currentRow, $columnStart, $GLOBALS['strCTRShortLow']);
        $worksheet->writeNumber($currentRow, $columnStart + 1,
                                ($row['clicks']['0'] / $row['views']['0']) * 100,$formatDecimalPercentage);
        $currentRow++;

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