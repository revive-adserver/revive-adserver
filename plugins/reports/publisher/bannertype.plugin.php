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

class Plugins_Reports_Publisher_Bannertype extends Plugins_Reports {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'             => MAX_Plugin_Translation::translate('Banner Type Analysis', $this->module, $this->package),
            'plugin-description'      => MAX_Plugin_Translation::translate('This report is a summary of the campaigns by placement.', $this->module, $this->package),
            'plugin-category'         => 'publisher',
            'plugin-category-name'    => MAX_Plugin_Translation::translate('Publisher Reports', $this->module, $this->package),
            'plugin-author'           => 'Michal Pawlowski',
            'plugin-export'           => 'csv',
            'plugin-authorize'        => phpAds_Admin+phpAds_Agency+phpAds_Affiliate,
            'plugin-import'           => $this->getDefaults()
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

        $conf = & $GLOBALS['_MAX']['CONF'];

    	global $date_format;
    	global $strAffiliate;

    	$conf = & $GLOBALS['_MAX']['CONF'];

    	$reportName = $GLOBALS['strPublisherBannerTypeAnalysisReport'];

    	$startDate = date(str_replace('%','',$date_format), strtotime($startdate));
    	$endDate   = date(str_replace('%','',$date_format), strtotime($enddate));
    	$dbStart = date('Y-m-d', strtotime($startdate));
    	$dbEnd = date('Y-m-d', strtotime($enddate));
    	// creating report object
        $workbook = new Spreadsheet_Excel_Writer();

        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate,
                                       $affiliateid, $GLOBALS['strPublisherBannerTypeAnalysisDescription']);
        // where to start printing structural data
        $rowStart = 7;
        $columnStart = 0;

        // formatting
        $formatInteger =& $workbook->addFormat();
        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);

        $formatDecimalPercentage =& $workbook->addFormat();
        $formatDecimalPercentage->setNumFormat(getPercentageDecimalFormat());

        $columnHeader =& $workbook->addFormat();
        $columnHeader->setAlign('center');
        $columnHeader->setBold();

        $query = "SELECT
                       b.contenttype
                      ,b.storagetype AS type
                      ,b.adserver
                      ,coalesce(sum(ds.requests),0)        as requests
                      ,coalesce(sum(ds.impressions),0)     as impressions
                      ,coalesce(sum(ds.clicks),0)          as clicks
                      ,coalesce(sum(ds.conversions),0)     as conversions
                  FROM ".$conf['table']['prefix'].$conf['table']['zones']." z
                      ,".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." ds
                      ,".$conf['table']['prefix'].$conf['table']['banners']." b
                 WHERE z.zoneid = ds.zone_id
                   AND ds.ad_id = b.bannerid
                   AND z.affiliateid = '".$affiliateid."'
                   AND ds.day >= '$dbStart'
                   AND ds.day <= '$dbEnd'
                 GROUP BY contenttype, type, adserver
                 ORDER BY type";

    	$res = phpAds_dbQuery($query) or phpAds_sqlDie();

    	if (phpAds_dbNumRows($res)) {
        	while ($row = phpAds_dbFetchArray($res)) {
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

        	   // generating header for each block
               $worksheet->write($currentRow,$columnStart    ,
                                 $GLOBALS['strBannerType'] , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 1,
                                 $GLOBALS['strRequests']   , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 2,
                                 $GLOBALS['strImpressions']      , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 3,
                                 $GLOBALS['strImpressionsRequestsRatio'],$columnHeader);
               $worksheet->write($currentRow,$columnStart + 4,
                                 $GLOBALS['strClicks']     , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 5,
                                 $GLOBALS['strCTRShort']   , $columnHeader);
               $worksheet->write($currentRow,$columnStart + 6,
                                 $GLOBALS['strConversions'], $columnHeader);
               $worksheet->write($currentRow,$columnStart + 7,
                                 $GLOBALS['strCNVRShort']  , $columnHeader);

               $currentRow++;
        	   foreach ($block as $rowId => $row) {
        	       $worksheet->write($currentRow, $columnStart,
        	                         $this->getAdType($row['type'],
        	                         $row['adserver'],
        	                         $row['contenttype'])
        	                         );
            	   $worksheet->writeNumber($currentRow, $columnStart + 1,
            	                           $row['requests'],$formatInteger);
        	       $worksheet->writeNumber($currentRow, $columnStart + 2,
        	                               $row['impressions'],$formatInteger);
        	       if ($row['requests'] != 0) {
        	           $worksheet->writeNumber($currentRow, $columnStart + 3,
        	                                   ($row['impressions'] / $row['requests']) * 100, $formatDecimalPercentage);
        	       } else {
        	           $worksheet->write($currentRow, $columnStart + 3,"N/A");
        	       }
        	       $worksheet->writeNumber($currentRow, $columnStart + 4, $row['clicks'],$formatInteger);
        	       if ($row['impressions'] != 0) {
        	           $worksheet->writeNumber($currentRow, $columnStart + 5,
        	                                   ($row['clicks'] / $row['impressions']) * 100, $formatDecimalPercentage);
        	       } else {
        	           $worksheet->write($currentRow, $columnStart + 5,"N/A");
        	       }
        	       $worksheet->writeNumber($currentRow, $columnStart + 6, $row['conversions'],$formatInteger);
        	       if ($row['impressions'] != 0) {
        	           $worksheet->writeNumber($currentRow, $columnStart + 7,
        	                                   ($row['conversions'] / $row['clicks']) * 100, $formatDecimalPercentage);
        	       } else {
        	           $worksheet->write($currentRow, $columnStart + 7,"N/A");
        	       }

        	       $currentRow++;
        	   }

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
    /*----------------------------------------*/
    function prepareData(& $data)
    {
        $retArray = array();

        $blockNr = 0;
        $previousPriority = '';

        // Sorting Array by priority
        foreach ($data as $row) {
            if ($previousPriority != $row['priority']) {
                $previousPriority = $row['priority'];
                $blockIndex = 0;
                $blockNr++;
            }

            $retArray[$blockNr][] = $row;
            $blockIndex++;
        }

        // Sorting array by day of the week
        foreach ($retArray as $blockId => $block) {
            ksort($retArray[$blockId]);
            addTotals($retArray[$blockId]);
        }

        return $retArray;
    }

    /*---------------------------------------------------------*/
    /* Function creates user friendly banner type description  */
    /*---------------------------------------------------------*/
    function getAdType($type, $adserver, $contenttype)
    {
        $adtype = "";

        $contentTypes = array('gif' => "Image",
                              'jpeg' => "Image",
                              'png' => "Image",
                              'swf' => "Flash");

        switch ($type) {
                case 'txt':
                    $adtype = $GLOBALS['strTextBanner'];
                    break;
                case 'url':
                    $adtype = "External ";
                    if(key_exists($contenttype, $contentTypes)) {
                        $adtype .= $contentTypes[$contenttype];
                    } else {
                        $adtype .= 'Rich Media';
                    }
                    break;
                case 'web':
                    $adtype = "Internal ";
                    if(key_exists($contenttype, $contentTypes)) {
                        $adtype .= $contentTypes[$contenttype];
                    } else {
                        $adtype .= 'Rich Media';
                    }
                    $adtype .= " Storage: Web";
                    break;
                case 'sql':
                    $adtype = "Internal ";
                    if(key_exists($contenttype, $contentTypes)) {
                        $adtype .= $contentTypes[$contenttype];
                    } else {
                        $adtype .= 'Rich Media';
                    }
                    $adtype .= " Storage: SQL";
                    break;
                case 'html':

                    switch ($adserver) {
                        case "max":
                            $adtype .= "Max Media Manager Rich Media";
                            break;
                        case "atlas":
                            $adtype .= "Atlas Rich Media";
                            break;
                        case "bluestreak":
                            $adtype .= "Bluestreak Rich Media";
                            break;
                        case "doubleclick":
                            $adtype .= "Doubleclick Rich Media";
                            break;
                        case "eyeblaster":
                            $adtype .= "Eyeblaster Rich Media";
                            break;
                        case "falk":
                            $adtype .= "Falk Rich Media";
                            break;
                        case "mediaplex":
                            $adtype .= "Mediaplex Rich Media";
                            break;
                        case "tangozebra":
                            $adtype .= "Tangozebra Rich Media";
                            break;
                        default:
                            $adtype .= "Generic Rich Media";
                            break;
                    }

                    break;
                case $GLOBALS['strTotal']:
                    $adtype = $GLOBALS['strTotal'];
                    break;
                default:
                    $adtype = "Total";
                    break;
        }
        return $adtype;
    }

    /*----------------------------------------------------------*/
    /* Customized function for adding "total" row to the blocks */
    /*----------------------------------------------------------*/
    function addTotals(& $table) {
        global $strTotal;

        $totalRow = array();

        foreach ($table as $id => $row) {
            for ($i = 0; list($fieldName, $fieldValue) = each($row); $i++) {

                // start adding values from columns starting from 3th column
                if ($i < 3) {
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

        // first column of the table is "Total"
        if (list($key, $val) = each($totalRow)) {
            $totalRow[$key] = $strTotal;
        }

        $table[] = $totalRow;
    }
}

?>