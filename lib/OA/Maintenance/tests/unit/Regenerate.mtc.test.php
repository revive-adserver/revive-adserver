<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Regenerate.php';

class Test_OA_Maintenenace_Regenerate extends UnitTestCase
{     
    function tearDown()
    {
        DataGenerator::cleanUp();
    }
    
    function testClearIntermediateAndSummaryTables()
    {   
        $oStartDate = new Date('2006-05-09 13:00:00');
        $oEndDate   = new Date('2006-05-09 13:59:59');
       
        $aTestDates  = array( 1 => array ( 'start' => new Date('2006-05-09 13:10:00'), 'end' => new Date('2006-05-09 13:14:59')),
                              2 => array ( 'start' => new Date('2006-05-09 12:00:00'), 'end' => new Date('2006-05-09 12:59:59')),
                              3 => array ( 'start' => new Date('2006-05-09 13:55:00'), 'end' => new Date('2006-05-09 12:59:59')) );  

        // Create some test data 
        foreach ($aTestDates as $key => $aDates) {
            $doIntermediateAdConnection = OA_Dal::factoryDO('data_intermediate_ad_connection');
            $doIntermediateAdConnection->tracker_date_time = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $aIntermediateAdConnectionId[$key] = DataGenerator::generateOne($doIntermediateAdConnection);
            
            $doDataIntermediateAdVariableValue = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
            $doDataIntermediateAdVariableValue->data_intermediate_ad_connection_id = $aIntermediateAdConnectionId[$key];
            $aDataIntermediateAdVariableValueId[$key] = DataGenerator::generateOne($doDataIntermediateAdVariableValue); 
            
            $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
            $doDataIntermediateAd->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $doDataIntermediateAd->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
            $aDataIntermediateAdId[$key] = DataGenerator::generateOne($doDataIntermediateAd);
            
            $doDataSummaryAdHourly = OA_Dal::factoryDO('data_summary_ad_hourly');
            $doDataSummaryAdHourly->date_time = $aDates['start']->format('%Y-%m-%d %H:00:00');
            $aDataSummaryAdHourlyId[$key] = DataGenerator::generateOne($doDataSummaryAdHourly);
            
            $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
            $doDataSummaryAdZoneAssoc->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $doDataSummaryAdZoneAssoc->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
            $aDataSummaryAdZoneAssocId[$key] = DataGenerator::generateOne($doDataSummaryAdZoneAssoc);
        }

        OA_Maintenance_Regenerate::clearIntermediateAndSummaryTables($oStartDate,$oEndDate);

        // Check if proper rows was deleted         
        foreach ($aIntermediateAdConnectionId as $key=>$intermediateAdConnectionId) {
            $adoIntermediateAdConnection[$key] = OA_Dal::staticGetDO('data_intermediate_ad_connection', $aIntermediateAdConnectionId[$key]);
            $adoDataIntermediateAdVariableValue[$key] = OA_Dal::staticGetDO('data_intermediate_ad_variable_value', $aDataIntermediateAdVariableValueId[$key]);
            $adoDataIntermediateAd[$key] = OA_Dal::staticGetDO('data_intermediate_ad', $aDataIntermediateAdId[$key]);
            $adoDataSummaryAdHourly[$key] = OA_Dal::staticGetDO('data_summary_ad_hourly', $aDataSummaryAdHourlyId[$key]);
            $adoDataSummaryAdZoneAssoc[$key] = OA_Dal::staticGetDO('data_summary_ad_zone_assoc', $aDataSummaryAdZoneAssocId[$key]);
        }
        
        $this->assertFalse($adoIntermediateAdConnection[1]);
        $this->assertFalse($adoDataIntermediateAdVariableValue[1]);
        $this->assertFalse($adoDataIntermediateAd[1]);
        $this->assertFalse($adoDataSummaryAdHourly[1]);
        $this->assertFalse($adoDataSummaryAdZoneAssoc[1]);
        
        $this->assertNotNull($adoIntermediateAdConnection[2]);
        $this->assertNotNull($adoDataIntermediateAdVariableValue[2]);
        $this->assertNotNull($adoDataIntermediateAd[2]);
        $this->assertNotNull($adoDataSummaryAdHourly[2]);
        $this->assertNotNull($adoDataSummaryAdZoneAssoc[2]);
        
        $this->assertFalse($adoIntermediateAdConnection[3]);
        $this->assertFalse($adoDataIntermediateAdVariableValue[3]);
        $this->assertFalse($adoDataIntermediateAd[3]);
        $this->assertFalse($adoDataSummaryAdHourly[3]);
        $this->assertFalse($adoDataSummaryAdZoneAssoc[3]);
    }    
}
?>