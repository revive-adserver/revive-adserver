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

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

class Plugins_Reports_Advertiser_Campaigndropdown extends Plugins_Reports {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Campaign Analysis', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('This report is a summary of the campaign by placement.', $this->module, $this->package),
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
        global $session, $strClient, $strStartDate, $strEndDate;

        $default_advertiser = isset($session['prefs']['GLOBALS']['report_advertiser']) ? $session['prefs']['GLOBALS']['report_advertiser'] : '';
        $default_start_date  = isset($session['prefs']['GLOBALS']['report_start_date']) ? $session['prefs']['GLOBALS']['report_start_date'] : date("Y/m/d", mktime(0,0,0,date("m")-1,1,date("Y")));
        $default_end_date  = isset($session['prefs']['GLOBALS']['report_end_date']) ? $session['prefs']['GLOBALS']['report_end_date'] : date("Y/m/d",mktime (0,0,0,date("m"),0,date("Y")));

        $aImport = array (
            'advertiser' => array (
                'title'         => MAX_Plugin_Translation::translate($strClient, $this->module, $this->package),
                'type'          => 'clientid-dropdown',
                'default'       => $default_advertiser
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

        if (isset($_REQUEST['advertiser'])) {
            $session['prefs']['GLOBALS']['report_advertiser'] = $_REQUEST['advertiser'];
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

    function execute($clientid, $startdate, $enddate)
    {
        require_once 'Spreadsheet/Excel/Writer.php';

    	global $date_format;
    	global $phpAds_ThousandsSeperator,$phpAds_DecimalPoint;

    	$conf = & $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

    	$reportName = $GLOBALS['strAdvertiserCampaignAnalysisReport'];

    	$startDate = date(str_replace('%','',$date_format), strtotime($startdate));
    	$endDate   = date(str_replace('%','',$date_format), strtotime($enddate));
    	$dbStart = date('Y-m-d', strtotime($startdate));
    	$dbEnd = date('Y-m-d', strtotime($enddate));
    	// creating report object
        $workbook = new Spreadsheet_Excel_Writer();

        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate,
                                       $clientid, $GLOBALS['strAdvertiserCampaignAnalysisDescription'],'advertiser');
        // where to start printing structural data
        $rowStart = 7;
        $columnStart = 0;

        // formatting - begin
        $formatInteger =& $workbook->addFormat();
        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);

        $formatDecimalPercentage =& $workbook->addFormat();
        $formatDecimalPercentage->setNumFormat(getPercentageDecimalFormat());

        $columnHeader =& $workbook->addFormat();
        $columnHeader->setAlign('center');
        $columnHeader->setBold();

        $formatRight =& $workbook->addFormat();
        $formatRight->setAlign('right');
        // formating - end

        $query = "SELECT
                      c.campaignid AS campaign_id
                      ,c.campaignname
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
                   AND c.clientid = ". $oDbh->quote($clientid, 'integer')."
                   AND ds.day >= ". $oDbh->quote($dbStart, 'date') ."
                   AND ds.day <= ". $oDbh->quote($dbEnd, 'date') ."
                 GROUP BY c.campaignname, c.priority
                 ORDER BY day ASC";

    	$res = $oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }

    	if ($res->numRows()) {
        	while ($row = $res->fetchRow()) {

                // mask campaign name if anonymous campaign
                $campaign_details = Admin_DA::getPlacement($row['campaign_id']);
                $row['campaignname'] = MAX_getPlacementName($campaign_details);

                // remove campaign_id as it will screw up the output
                unset($row['campaign_id']);

                $data[] = $row;
        	}

            $numrows = (is_array($data)) ? count($data): 0;

            // adding "total" rows
        	addTotals($data);

        	$currentRow = $rowStart;

            $worksheet->write($currentRow,$columnStart,
                              $GLOBALS['strCampaign'],$columnHeader);
            $worksheet->write($currentRow,$columnStart + 1,
                              $GLOBALS['strRequests'],$columnHeader);
            $worksheet->write($currentRow,$columnStart + 2,
                              $GLOBALS['strImpressions'],$columnHeader);
            $worksheet->write($currentRow,$columnStart + 3,
                              $GLOBALS['strClicks'],$columnHeader);
            $worksheet->write($currentRow,$columnStart + 4,
                              $GLOBALS['strCTRShort'],$columnHeader);
            $worksheet->write($currentRow,$columnStart + 5,
                              $GLOBALS['strConversions'],$columnHeader);
            $worksheet->write($currentRow,$columnStart + 6,
                              $GLOBALS['strCNVRShort'], $columnHeader);

            $currentRow++;
        	foreach ($data as $rowId => $row) {
        	    $worksheet->write($currentRow, $columnStart, $row['campaignname']);
                $worksheet->writeNumber($currentRow, $columnStart + 1,
                                        $row['requests'],$formatInteger);
        	    $worksheet->writeNumber($currentRow, $columnStart + 2,
        	                            $row['impressions'],$formatInteger);
        	    $worksheet->writeNumber($currentRow, $columnStart + 3,
        	                            $row['clicks'], $formatInteger);
        	    if ($row['impressions'] != 0) {
        	       $worksheet->writeNumber($currentRow, $columnStart + 4,
        	                               ($row['clicks'] / $row['impressions']) * 100, $formatDecimalPercentage);
        	    } else {
        	       $worksheet->write($currentRow, $columnStart + 4,"N/A");
        	    }
        	    $worksheet->writeNumber($currentRow, $columnStart + 5,
        	                            $row['conversions'], $formatInteger);
        	    if ($row['clicks'] != 0) {
        	       $worksheet->writeNumber($currentRow, $columnStart + 6,
        	                               ($row['conversions'] / $row['clicks']) * 100, $formatDecimalPercentage);
        	    } else {
        	       $worksheet->write($currentRow, $columnStart + 6,"N/A");
        	    }
        	    $currentRow++;
        	}
    	} else { // there is no data
    	    $worksheet->write($rowStart, $columnStart,
    	                      $GLOBALS['strNoData'], $columnHeader);
    	}

    	$workbook->close();
    }
}

?>