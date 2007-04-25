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
 * @author     Dawid Kordek    <dawid@arlenmedia.com>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';
require_once MAX_PATH . '/plugins/reports/lib.php';
require_once            'Spreadsheet/Excel/Writer.php';

class Plugins_Reports_Advertiser_Statshistorybyweek extends Plugins_Reports {
    
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
        $conf = & $GLOBALS['_MAX']['CONF'];
        global $stats;
    	  global $date_format, $startdate, $enddate;

    	  $reportName = $GLOBALS['strStatsAnalysisReport'];
    	
        //add new field to display    	
     	  $stats->columns = array('day' => 'Date') + $stats->columns;
    	  $stats->columnVisible = array('day' => 1) + $stats->columnVisible;

        //find lowest and highest week dates
        foreach($stats->history as $k => $v) {
          $tempTimeArray[] = $k;
        }
        sort($tempTimeArray);
        $startDate = $tempTimeArray[0];
        $endDate   = $tempTimeArray[count($tempTimeArray)-1];


    	  $dbStart = date('Y-m-d', strtotime($startdate));
    	  $dbEnd = date('Y-m-d', strtotime($enddate));

        // creating report object
        $workbook = new Spreadsheet_Excel_Writer();
        
        $worksheet = generateXLSHeader($workbook, $reportName, $startDate, $endDate,
                                       $clientid, $GLOBALS['strStatsAnalysisReport'], null);


        // where to start printing structural data
        $rowStart = 8;
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

        //set all column titles
        $worksheet->write($currentRow,$columnStart,
                          'Week', $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          '',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Mo',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Tu',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'We',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Th',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Fr',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Sa',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Su',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Avg.',
                          $columnHeader);
        $worksheet->write($currentRow,++$currentColumn    ,
                          'Total',
                          $columnHeader);

        $currentRow = $rowStart + 1;

        foreach($stats->history as $k => $record) {
            
            //store avg and summary data
            $tempRecordData = $record;
            
            //unset arrays where loop is able to enter 
            unset($record['week']);      
            unset($record['avg']);      
            unset($record['id']);
            unset($record['sum_requests']);
            unset($record['sum_views']);
            unset($record['sum_sr_clicks']);
            unset($record['sum_revenue']);
            unset($record['sum_cost']);
            unset($record['sum_bv']);
            unset($record['sum_revcpc']);
            unset($record['htmlclass']);



            foreach($record as $subK => $subRecord) {
                  
                $currentColumn = $columnStart + 1;

                foreach($subRecord as $dayK => $dayRecord) {              

                   //for next week change pointer position
                   if($currentColumn == 1 && $currentRow > 8) {
                      $rowStart = $currentRow;
                      $currentRow += 1; 
                   }
                   else {
                      $currentRow = $rowStart + 1;
                   } 

                   // output data for selected day 
                   foreach($stats->columns as $colK => $colV) {

                       if($stats->columnVisible[$colK] == 1 || $colK == 'day') {

                           //put on date row current week   
                           if($colK == 'day') {
                               $worksheet->write($currentRow, 0,
                                                 $tempRecordData['week'] , $formatInteger);                            
                           }

                           //field names 
                           $worksheet->write($currentRow, 1,
                                             $colV , $formatInteger);
                           //data output
                           $worksheet->write($currentRow, $currentColumn+1,
                                             $dayRecord[$colK] , $formatInteger);
                           //avg info
                           $worksheet->write($currentRow, 9,
                                             $tempRecordData['avg'][$colK] , $formatInteger);
                           //total info 
                           $worksheet->write($currentRow, 10,
                                             $tempRecordData[$colK] , $formatInteger);

                           $currentRow++;   
                       }                                        
                   }
                   
                   $currentColumn++;


                }
            }
        }

        $workbook->close();

    }





}

?>
