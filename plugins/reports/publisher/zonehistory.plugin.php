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
$Id: zonehistory.plugin.php 6108 2006-11-24 11:34:58Z andrew@m3.net $
*/

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

class Plugins_Reports_Publisher_Zonehistory extends Plugins_Reports {

    // Public info function
    function info()
    {
    	include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

    	$plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Zone History Report', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('Report of publisher and zone distribution for an advertiser.', $this->module, $this->package),
            'plugin-category'       => 'publisher',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Publisher Reports', $this->module, $this->package),
            'plugin-author'         => 'Niels Leenheer',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency+phpAds_Affiliate,
            'plugin-import'         => $this->getDefaults()
    	);

    	$this->saveDefaults();

    	return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strZone, $strDelimiter;

        $default_zone = isset($session['prefs']['GLOBALS']['report_zone']) ? $session['prefs']['GLOBALS']['report_zone'] : '';
        $default_delimiter  = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';
        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';

        $aImport = array (
            'zone'          => array (
                'title'     => MAX_Plugin_Translation::translate($strZone, $this->module, $this->package),
                'type'      => 'zoneid-dropdown',
                'default'   => $default_zone
            ),
            'delimiter'     => array (
                'title'     => MAX_Plugin_Translation::translate($strDelimiter, $this->module, $this->package),
                'type'      => 'edit',
                'size'      => 1,
                'default'   => $default_delimiter
            ),
            'period'        => array(
                'title'     => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
                'type'      => 'day-span',
                'default' => $default_period_preset
            )
        );
        
        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['zone'])) {
            $session['prefs']['GLOBALS']['report_zone'] = $_REQUEST['zone'];
        }
        if (isset($_REQUEST['delimiter'])) {
            $session['prefs']['GLOBALS']['report_delimiter'] = $_REQUEST['delimiter'];
        }
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset'] = $_REQUEST['period_preset'];
        }
        phpAds_SessionDataStore();
    }

    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/

    function execute($zoneid, $oDaySpan)
    {
        require_once 'Spreadsheet/Excel/Writer.php';

        $conf = & $GLOBALS['_MAX']['CONF'];

    	global $date_format;
    	global $strZone, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort;

    	$startDate = !empty($oDaySpan) ? date('Y-m-d', strtotime($oDaySpan->getStartDateString())): 'Beginning';
        $endDate = !empty($oDaySpan) ? date('Y-m-d', strtotime($oDaySpan->getEndDateString())): date('Y-M-d');
        $reportName = 'm3 Zone History Report from ' . $startDate . ' to ' . $endDate . '.xls';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

        if (!is_null($oDaySpan)) {
            $dateLimitation = " AND day >= '$startDate' AND day <= '$endDate'";
        } else {
            $dateLimitation = '';
        }

        // creating report object
        $workbook = new Spreadsheet_Excel_Writer();

        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate, $zoneid,
            $GLOBALS['strPublisherZoneHistoryDescription'], 'zone');

        // formatting - begin
        $formatInteger =& $workbook->addFormat();
        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);

        $formatDecimalPercentage =& $workbook->addFormat();
        $formatDecimalPercentage->setNumFormat(getPercentageDecimalFormat());

        $columnHeader =& $workbook->addFormat();
        $columnHeader->setAlign('center');
        $columnHeader->setBold();
        // formatting - end

    	// SQL to generate report data:
        $res_query ="SELECT
            c.campaignname AS campaign,
            DATE_FORMAT(a.day, '%d/%m/%Y') as day,
            SUM(a.impressions) AS adviews,
            SUM(a.clicks) AS adclicks
        FROM
            ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." AS a,
            ".$conf['table']['prefix'].$conf['table']['banners']." AS b,
            ".$conf['table']['prefix'].$conf['table']['campaigns']." AS c
        WHERE
            a.zone_id = ".$zoneid."
          AND
            a.ad_id = b.bannerid
          AND
            b.campaignid = c.campaignid
        ".$dateLimitation."
    	GROUP BY
            day, c.campaignname
        ORDER BY
            campaignname, day";

    	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();

        // copy result to array
       	while($row = phpAds_dbFetchArray($res_banners)) {
       	    $data[] = $row;
       	}

       	$currentRow = 0;

       	// output column headers
        $worksheet->write($currentRow+7, 0, $GLOBALS['strCampaign'], $columnHeader);
        $worksheet->write($currentRow+7, 1, $GLOBALS['strDay'], $columnHeader);
        $worksheet->write($currentRow+7, 2, $GLOBALS['strImpressions'], $columnHeader);
        $worksheet->write($currentRow+7, 3, $GLOBALS['strClicks'], $columnHeader);
        $worksheet->write($currentRow+7, 4, $GLOBALS['strCTRShort'], $columnHeader);

       	// output data rows
       	foreach ($data as $item) {
            $worksheet->write($currentRow+8, 0, $data[$currentRow]['campaign']);
            $worksheet->write($currentRow+8, 1, $data[$currentRow]['day']);
            $worksheet->write($currentRow+8, 2, $data[$currentRow]['adviews'], $formatInteger);
            $worksheet->write($currentRow+8, 3, $data[$currentRow]['adclicks'], $formatInteger);
            $worksheet->write($currentRow+8, 4, phpAds_buildCTR($data[$currentRow]['adviews'], $data[$currentRow]['adclicks']), $formatDecimalPercentage);
            $currentRow++;
       	}

        $workbook->close();
    }
}

?>
