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

require_once MAX_PATH . '/lib/max/Dal/Statistics.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/pear/Date.php';


/**
 * A class for testing the non-DB specific MAX_Dal_Statistics DAL class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfMAX_Dal_Statistics extends UnitTestCase
{
    var $doBanners = null;
    var $doDSAH = null;

    /**
     * The constructor method.
     */
    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Statistics()
    {
        $this->UnitTestCase();
        $this->doBanners   = OA_Dal::factoryDO('banners');
        $this->doDSAH = OA_Dal::factoryDO('data_summary_ad_hourly');
    }

    function _insertBanner($aData)
    {
        $this->doBanners->storagetype = 'sql';
        foreach ($aData AS $key => $val)
        {
            $this->doBanners->$key = $val;
        }
        return DataGenerator::generateOne($this->doBanners);
    }

    function _insertDataSummaryAdHourly($aData)
    {
        $aData['date_time'] = sprintf('%s %02d:00:00', $aData['day'], $aData['hour']);
        unset($aData['day']);
        unset($aData['hour']);

        foreach ($aData AS $key => $val)
        {
            $this->doDSAH->$key = $val;
        }
        return DataGenerator::generateOne($this->doDSAH);
    }

    /**
     * A method to test the getPlacementFirstStatsDate() method.
     *
     * Requirements:
     * Test 1: Test with an invalid placement ID, and ensure null is returned.
     * Test 2: Test with no data in the database, and ensure current date is returned.
     * Test 3: Test with single row in the database, and ensure correct date is
     *         returned.
     * Test 4: Test with multi rows in the database, and ensure correct date is
     *         returned.
     */
    function testGetPlacementFirstStatsDate()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oDalStatistics = new MAX_Dal_Statistics();

        // Test 1
        $placementId = 'foo';
        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $this->assertNull($oResult);

        // Test 2
        $placementId = 1;
        $oBeforeDate = new Date();
        sleep(1);
        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        sleep(1);
        $oAfterDate = new Date();
        $this->assertTrue(is_a($oResult, 'Date'));
        $this->assertTrue($oBeforeDate->before($oResult));
        $this->assertTrue($oAfterDate->after($oResult));

        // Test 3
        $oNow = new Date();

        $aData = array(
            'campaignid'=>$placementId,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aData = array(
            'day'=>'2006-10-30',
            'hour'=>12,
            'ad_id'=>$idBanner1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH1 = $this->_insertDataSummaryAdHourly($aData);

        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $oExpectedDate = new Date('2006-10-30 12:00:00');
        $this->assertEqual($oResult, $oExpectedDate);

        // Test 4
        $aData = array(
            'campaignid'=>$placementId,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>999,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner3 = $this->_insertBanner($aData);
        $aData = array(
            'day'=>'2006-10-29',
            'hour'=>12,
            'ad_id'=>$idBanner2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH1 = $this->_insertDataSummaryAdHourly($aData);
        $aData = array(
            'day'=>'2006-10-28',
            'hour'=>12,
            'ad_id'=>$idBanner2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH2 = $this->_insertDataSummaryAdHourly($aData);
        $aData = array(
            'day'=>'2006-10-27',
            'hour'=>12,
            'ad_id'=>$idBanner2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH3 = $this->_insertDataSummaryAdHourly($aData);
        $aData = array(
            'day'=>'2006-10-26',
            'hour'=>12,
            'ad_id'=>999,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH4 = $this->_insertDataSummaryAdHourly($aData);

        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $oExpectedDate = new Date('2006-10-27 12:00:00');
        $this->assertEqual($oResult, $oExpectedDate);

        DataGenerator::cleanUp();
    }

}

?>
