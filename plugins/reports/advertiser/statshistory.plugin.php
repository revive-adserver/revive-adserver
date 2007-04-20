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
 * @author     Dawid Kordek    <dawid@arlenmedia.com>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';

class Plugins_Reports_Advertiser_Statshistory extends Plugins_Reports {
    
    // Public info function
    function info()
    {
    	global $strClient, $strPluginClient, $strDelimiter;
    	
    	include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);
        
    	$plugininfo = array (
    		"plugin-name"			=> MAX_Plugin_Translation::translate('Stats Report', $this->module, $this->package),
    		"plugin-description"	=> MAX_Plugin_Translation::translate('A breakdown of stats data', $this->module, $this->package),
    		'plugin-category'     => 'advertiser',
    		'plugin-category-name'	=> MAX_Plugin_Translation::translate('Advertiser Reports', $this->module, $this->package),
    		"plugin-author"			=> "Dawid Kordek",
    		"plugin-export"			=> "csv",
    		"plugin-authorize"		=> phpAds_Admin+phpAds_Agency+phpAds_Client,
    		"plugin-import"			=> array (
    			"campaignid"			=> array (
    				"title"					=> $strClient,
    				"type"					=> "clientid-dropdown" ),
    			"delimiter"		=> array (
    				"title"					=> $strDelimiter,
    				"type"					=> "edit",
    				"size"					=> 1,
    				"default"				=> "," ) )
    	);

    	return ($plugininfo);
    }
    
    
    
    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/
    
    function execute($clientid, $delimiter=",")
    {
        require_once 'Spreadsheet/Excel/Writer.php';
        $conf = & $GLOBALS['_MAX']['CONF'];
        global $stats;


    	  global $date_format, $startdate, $enddate;
    	
    	  $reportName = $GLOBALS['strStatsAnalysisReport'];
    	
        //find startData and endData
        foreach($stats->history as $k => $v) {
          $tempTimeArray[] = $k;
          sort($tempTimeArray);
          $startDate = date("d-m-Y", strtotime($tempTimeArray[0]));
          $endDate   = date("d-m-Y", strtotime($tempTimeArray[count($tempTimeArray)-1]));
        }

    	  $dbStart = date('Y-m-d', strtotime($startdate));
    	  $dbEnd = date('Y-m-d', strtotime($enddate));
    	  
        // creating report object
        $workbook = new Spreadsheet_Excel_Writer();
        
        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate,
                                       $clientid, $GLOBALS['strStatsAnalysisReport'], null);
        // where to start printing structural data
        $rowStart = 7;
        $columnStart = 0;
        
        // formatting - begin
        $formatInteger =& $workbook->addFormat();
        $formatInteger->setNumFormat($GLOBALS['excel_integer_formatting']);
        $formatInteger->setAlign('center');
        
        $columnHeader =& $workbook->addFormat();
        $columnHeader->setAlign('center');
        $columnHeader->setBold();
        //formatting - end
        

        	
        $currentRow    = $rowStart;      	   
        $currentColumn = $columnStart;



        $worksheet->write($currentRow,$columnStart,
                          'Date', $columnHeader);


        foreach($stats->columns as $k => $v) {

            if($stats->columnVisible[$k] == 1) {

               $worksheet->write($currentRow,++$currentColumn    ,
                                 $v ,
                                 $columnHeader);
            }        

        }

        $currentRow++;


        // output records
        foreach($stats->history as $k => $record) {

            $currentColumn = $columnStart;

            // output date
            $worksheet->write($currentRow, $currentColumn,
                              $k , $columnHeader);
            
            // output data for selected day 
            foreach($stats->columns as $subK => $subV) {

                if($stats->columnVisible[$subK] == 1) {

                    $worksheet->write($currentRow, ++$currentColumn,
                                      $record[$subK] , $formatInteger);
                }                                        
            }
            $currentRow++;



        }        

        $workbook->close();

    }
}

?>
