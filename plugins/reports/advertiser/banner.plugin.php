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

class Plugins_Reports_Advertiser_Banner extends Plugins_Reports  {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';

        $plugininfo = array (
            'plugin-name'             => MAX_Plugin_Translation::translate('Creative Summary', $this->module, $this->package),
            'plugin-description'      => MAX_Plugin_Translation::translate('This report is a summary of the campaign by creative.', $this->module, $this->package),
            'plugin-category'         => 'advertiser',
            'plugin-category-name'    => MAX_Plugin_Translation::translate('Advertiser Reports', $this->module, $this->package),
            'plugin-author'           => 'Michal Pawlowski',
            'plugin-export'           => 'csv',
            'plugin-authorize'        => phpAds_Admin+phpAds_Agency+phpAds_Client,
            'plugin-import'           => $this->getDefaults()
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
        $oDbh = & OA_DB::singleton();

    	$reportName = $GLOBALS['strAdvertiserCreativeSummaryReport'];

    	$startDate  = date(str_replace('%','',$date_format), strtotime($startdate));
    	$endDate    = date(str_replace('%','',$date_format), strtotime($enddate));
    	$dbStart    = date('Y-m-d', strtotime($startdate));
    	$dbEnd      = date('Y-m-d', strtotime($enddate));
    	// creating report object
        $workbook = new Spreadsheet_Excel_Writer();

        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate,
                                       $clientid, $GLOBALS['strAdvertiserCreativeSummaryDescription'], 'advertiser');
        // where to start printing structural data
        $rowStart = 7;
        $columnStart = 0;

        // formatting for excel - begin
        $formatInteger =& $workbook->addFormat();
        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);

        $formatDecimalPercentage =& $workbook->addFormat();
        $formatDecimalPercentage->setNumFormat(getPercentageDecimalFormat());

        $columnHeader =& $workbook->addFormat();
        $columnHeader->setAlign('center');
        $columnHeader->setBold();

        $formatRight =& $workbook->addFormat();
        $formatRight->setAlign('right');
        // formatting for excel - end


        $query = "SELECT
                      b.bannerid AS ad_id
                      ,c.campaignid AS campaign_id
                      ,z.zoneid AS zone_id
                      ,a.affiliateid AS publisher_id
                      ,c.campaignname
                      ,c.priority
                      ,b.description as bannername
                      ,z.zonename
                      ,a.name as affiliatename
                      ,coalesce(sum(ds.requests),0)        as requests
                      ,coalesce(sum(ds.impressions),0)     as impressions
                      ,coalesce(sum(ds.clicks),0)          as clicks
                      ,coalesce(sum(ds.conversions),0)     as conversions
                  FROM ".$conf['table']['prefix'].$conf['table']['zones']." z
                      ,".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." ds
                      ,".$conf['table']['prefix'].$conf['table']['banners']." b
                      ,".$conf['table']['prefix'].$conf['table']['campaigns']." c
                      ,".$conf['table']['prefix'].$conf['table']['affiliates']." a
                 WHERE z.zoneid = ds.zone_id
                   AND z.affiliateid = a.affiliateid
                   AND ds.ad_id = b.bannerid
                   AND b.campaignid = c.campaignid
                   AND c.clientid = ". $oDbh->quote($clientid, 'integer') ."
                   AND ds.day >= ". $oDbh->quote($dbStart, 'date') ."
                   AND ds.day <= ". $oDbh->quote($dbEnd, 'date') ."
                 GROUP BY campaignname, priority, bannername, zonename
                 ORDER BY priority, affiliatename, campaignname ASC";

    	$res = $oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }

    	// if there is any data for this query
    	if ($res->numRows()) {

        	// getting the db result to the temporary table - results needs to be
        	// prepared first
        	while ($row = $res->fetchRow()) {

                // mask banner, campaign, zone and publisher names if anonymous campaign
                $campaign_details = Admin_DA::getPlacement($row['campaign_id']);
                $campaignAnonymous = $campaign_details['anonymous'] == 't' ? true : false;
           	    $row['bannername'] = MAX_getAdName($row['bannername'], null, null, $campaignAnonymous, $row['ad_id']);
                $row['campaignname'] = MAX_getPlacementName($campaign_details);
                $row['zonename'] = MAX_getZoneName($row['zonename'], null, $campaignAnonymous, $row['zone_id']);
                $row['affiliatename'] = MAX_getPublisherName($row['affiliatename'], null, $campaignAnonymous, $row['publisher_id']);

                // remove certain elements as they will screw up the output
                unset($row['ad_id']);
                unset($row['campaign_id']);
                unset($row['zone_id']);
                unset($row['publisher_id']);

                $data[] = $row;
        	}

        	$numrows = (is_array($data)) ? count($data): 0;

            // preparing result data
        	$dataSorted = $this->prepareData($data);

        	$priorityNames = array('0' => $GLOBALS['strPriorityLow'],
        	                       '1' => $GLOBALS['strPriorityMedium'],
        	                       '2' => $GLOBALS['strPriorityHigh'],
        	                       't' => "All campaigns");
        	$previousPriority = '';
        	$previousStart = $rowStart;

        	$i = 0; $currentRow = $rowStart;
        	foreach ($dataSorted as $block) {

        	   // find the priority of this block
        	   if (list(,$row) = each($block)) {
        	       $worksheet->write($currentRow,$columnStart,
        	                         $priorityNames[$row['priority']], $columnHeader);
        	   }
        	   $currentRow++;

               $worksheet->write($currentRow,$columnStart,
                                 $GLOBALS['strAffiliates']   , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 1,
                                 $GLOBALS['strCampaign']   , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 2,
                                 $GLOBALS['strBanners']    , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 3,
                                 $GLOBALS['strZone']       , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 4,
                                 $GLOBALS['strRequests']   , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 5,
                                 $GLOBALS['strImpressions']      , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 6,
                                 $GLOBALS['strImpressionsRequestsRatio'], $columnHeader);
               $worksheet->write($currentRow,$columnStart + 7,
                                 $GLOBALS['strClicks']     , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 8,
                                 $GLOBALS['strCTRShort']   , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 9,
                                 $GLOBALS['strConversions'], $columnHeader);
               $worksheet->write($currentRow,$columnStart + 10,
                                 $GLOBALS['strCNVRShort']  , $columnHeader);


               $currentRow++;
        	   foreach ($block as $rowId => $row) {
        	       $worksheet->write($currentRow, $columnStart,     $row['affiliatename']);
        	       $worksheet->write($currentRow, $columnStart + 1, $row['campaignname']);
        	       $worksheet->write($currentRow, $columnStart + 2, $row['bannername']);
        	       $worksheet->write($currentRow, $columnStart + 3, $row['zonename']);
            	   $worksheet->writeNumber($currentRow, $columnStart + 4,
            	                           $row['requests'],$formatInteger);
        	       $worksheet->writeNumber($currentRow, $columnStart + 5,
        	                               $row['impressions'],$formatInteger);
        	       if ($row['requests'] != 0) {
        	           $worksheet->writeNumber($currentRow, $columnStart + 6,
        	                                   ($row['impressions'] / $row['requests']) * 100, $formatDecimalPercentage);
        	       } else {
        	           $worksheet->write($currentRow, $columnStart + 6,"N/A");
        	       }
        	       $worksheet->writeNumber($currentRow, $columnStart + 7,$row['clicks'],$formatInteger);
        	       if ($row['impressions'] != 0) {
        	           $worksheet->writeNumber($currentRow, $columnStart + 8,
        	                                   ($row['clicks'] / $row['impressions']) * 100, $formatDecimalPercentage);
        	       } else {
        	           $worksheet->write($currentRow, $columnStart + 8,"N/A");
        	       }
        	       $worksheet->writeNumber($currentRow, $columnStart + 9, $row['conversions'],$formatInteger);
        	       if ($row['impressions'] != 0) {
        	           $worksheet->writeNumber($currentRow, $columnStart + 10,
        	                                   ($row['conversions'] / $row['clicks']) * 100, $formatDecimalPercentage);
        	       } else {
        	           $worksheet->write($currentRow, $columnStart + 10,"N/A");
        	       }

        	       $currentRow++;
        	   }

        	   $currentRow++;
        	   $i++;
        	}
    	} else {
    	    $worksheet->write($rowStart, $columnStart, $GLOBALS['strNoData'], $columnHeader);
    	}

        $workbook->close();
    }

    /*----------------------------------------*/
    /* Function for sorting result data       */
    /* and splitting into blocks result array */
    /* for next step - display                */
    /*----------------------------------------*/
    function prepareData(& $data)
    {
        $retArray = array();

        $totalBlock = array();
        $blockNr = 1;
        $previousPriority = '';

        // Sorting Array by priority
        foreach ($data as $row) {
            if ($previousPriority != $row['priority']) {
                $previousPriority = $row['priority'];
                $blockIndex = 0;
                $blockNr++;
            }

            $retArray[$blockNr][] = $row;
            $totalBlock[$row['campaignname']]['campaignname']   = $row['campaignname'];
            $totalBlock[$row['campaignname']]['priority']       = 't';
            $totalBlock[$row['campaignname']]['affiliatename']  = $row['affiliatename'];
            $totalBlock[$row['campaignname']]['bannername']     = $row['bannername'];
            $totalBlock[$row['campaignname']]['clientname']     = $row['clientname'];
            $totalBlock[$row['campaignname']]['zonename']       = $row['zonename'];
            $totalBlock[$row['campaignname']]['requests']      += $row['requests'];
            $totalBlock[$row['campaignname']]['impressions']   += $row['impressions'];
            $totalBlock[$row['campaignname']]['clicks']        += $row['clicks'];
            $totalBlock[$row['campaignname']]['conversions']   += $row['conversions'];
            $blockIndex++;
        }

        $retArray[0] = $totalBlock;

        ksort($retArray);

        // Sorting array by day of the week
        foreach ($retArray as $blockId => $block) {
            ksort($retArray[$blockId]);
            addTotals($retArray[$blockId]);
        }

        return $retArray;
    }

    /*----------------------------------------------------------*/
    /* Customized function for adding "total" row to the blocks */
    /*----------------------------------------------------------*/
    function addTotals(& $table) {
        global $strTotal;

        $totalRow = array();

        foreach ($table as $id => $row) {
            for ($i = 0; list($fieldName, $fieldValue) = each($row); $i++) {
                if ($i < 4) {
                    $totalRow[$fieldName] = "";
                } else  {
                    if (isset($totalRow[$fieldName])) {
                        if (is_numeric($totalRow[$fieldName])) {
                            $totalRow[$fieldName] += $fieldValue;
                        } else {
                            $totalRow[$fieldName] = '';
                        }
                    } else {
                        $totalRow[$fieldName] = $fieldValue;
                    }
                }
            }
        }

        $totalRow['affiliatename'] = $strTotal;

        $table[] = $totalRow;
    }
}

?>