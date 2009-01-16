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
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/Ad.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Zone.php';

/**
 * A class for testing the getPreviousAdDeliveryInfo() method of the non-DB
 * specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getPreviousAdDeliveryInfo extends UnitTestCase
{
    var $doInterAd = null;
    var $doAdZone = null;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getPreviousAdDeliveryInfo()
    {
        $this->UnitTestCase();
        $this->doInterAd = OA_Dal::factoryDO('data_intermediate_ad');
        $this->doAdZone = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
    }

    function _insertDataIntermediateAd($aData)
    {
        $this->doInterAd->operation_interval = $aData[0];
        $this->doInterAd->operation_interval_id = $aData[1];
        $this->doInterAd->interval_start = $aData[2];
        $this->doInterAd->interval_end = $aData[3];
        $this->doInterAd->day = $aData[4];
        $this->doInterAd->hour = $aData[5];
        $this->doInterAd->ad_id = $aData[6];
        $this->doInterAd->creative_id = $aData[7];
        $this->doInterAd->zone_id = $aData[8];
        $this->doInterAd->impressions = $aData[9];
        $this->doInterAd->updated = $aData[10];
        return DataGenerator::generateOne($this->doInterAd);
    }

    function _insertDataSummaryAdZoneAssoc($aData)
    {
        $this->doAdZone->operation_interval = $aData[0];
        $this->doAdZone->operation_interval_id = $aData[1];
        $this->doAdZone->interval_start = $aData[2];
        $this->doAdZone->interval_end = $aData[3];
        $this->doAdZone->ad_id = $aData[4];
        $this->doAdZone->zone_id = $aData[5];
        $this->doAdZone->required_impressions = $aData[6];
        $this->doAdZone->requested_impressions = $aData[7];
        $this->doAdZone->priority = $aData[8];
        $this->doAdZone->priority_factor = $aData[9];
        $this->doAdZone->past_zone_traffic_fraction = $aData[10];
        $this->doAdZone->created = $aData[11];
        $this->doAdZone->created_by = $aData[12];
        if (isset($aData[13]))
        {
            $this->doAdZone->expired = $aData[13];
        }
        else
        {
            $this->doAdZone->expired = '';
        }
        return DataGenerator::generateOne($this->doAdZone);
    }

    /**
     * Method to test the getPreviousAdDeliveryInfo method.
     *
     * Requirements:
     * Test 1:   Test with no Date registered in the service locator, ensure false returned.
     * Test 2:   Test with a Date registered in the service locator, no data in the database,
     *           and ensure no data is returned.
     *
     * Test 3:   Test with ONLY impression data, but NOT in the previous OI, and ensure no
     *           data is returned.
     * Test 4:   Test with ONLY impression data, in the previous OI, and ensure that ONLY
     *           data relating to the impressions is returned.
     * Test 5:   Test with ONLY impression data, in the 2nd previous OI, and ensure that
     *           no data is returned.
     * Test 5a:  Re-test with ONLY impression data, in the 2nd previous OI, but pass in the
     *           ad/zone pair, and ensure that no data is returned.
     *
     * Test 6:   Test with ONLY prioritisation data, but NOT in the previous OI, and
     *           ensure no data is returned.
     * Test 7:   Test with ONLY prioritisation data, in the previous OI, and ensure that
     *           ONLY data relating to the prioritisation is returned.
     * Test 8:   Test with ONLY prioritisation data, in the 2nd previous OI, and ensure no
     *           data is returned.
     * Test 8a:  Re-test with ONLY prioritisation data, in the 2nd previous OI, but pass in
     *           the ad/zone pair, and ensure that ONLY data relating to the prioritisation
     *           is returned.
     *
     * Test 9:   Test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data NOT in the previous OI, and ensure no data is returned.
     * Test 10:  Test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data in the previous OI, and ensure ONLY data relating to the prioritisation
     *           is returned.
     * Test 11:  Test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data in the 2nd previous OI, and ensure no data is returned.
     * Test 11a: Re-test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data in the 2nd previous OI, but pass in the ad/zone pair, and ensure that
     *           ONLY data relating to the prioritisation is returned.
     *
     * Test 12:  Test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data NOT in the previous OI, and ensure no data is returned.
     * Test 13:  Test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data in the previous OI, and ensure ONLY data relating to the prioritisation
     *           is returned.
     * Test 14:  Test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data in the 2nd previous OI, and ensure no data is returned.
     * Test 14a: Re-test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data in the 2nd previous OI, but pass in the ad/zone pair, and ensure that
     *           all data is returned.
     *
     * Test 15:  Test with BOTH impressions data in the previous OI, and prioritisation
     *           data NOT in the previous OI, and ensure that ONLY data relating to the
     *           impressions is returned.
     * Test 16:  Test with BOTH impressions data in the previous OI, and prioritisation
     *           data in the previous OI, and ensure that all data is returned.
     * Test 17:  Test with BOTH impressions data in the previous OI, and prioritisation
     *           data in the 2nd previous OI, and ensure that all data is returned.
     * Test 17a: Re-test with BOTH impressions data in the previous OI, and prioritisation
     *           data in the 2nd previous OI, but pass in the ad/zone pair, and ensure that
     *           all data is returned.
     *
     * Test 18:  Perform a more realistic test, with data for the ads/zones in various
     *           past OIs, and including some ads with multiple prioritisation data
     *           per OI, as well as ads with no prioritisation data in some OIs, and
     *           ensure that the correct values are returned for each one. Test that:
     *           - Only ad/zones that delivered in the previous operation interval,
     *             or were requested to deliver in the previous operation interval,
     *             but didn't (i.e. not in other intervals) are returned in the
     *             results.
     *           - That prioritisation information where just ONE set of data exists
     *             is returned correctly.
     *           - That prioritisation information where multiple sets of INDENTICAL
     *             data exists is returned correctly.
     *           - That prioritisation information where multiple sets of DIFFERENT
     *             data exists is returned correctly.
     *           - That prioritisation information from older sets of data is
     *             returned correctly.
     * Test 18a: Re-test, but also include ad/zone pairs that are in/not in the above
     *           set of data, and ensure that these ad/zone pairs are also included
     *           in the results.
     */
    function testGetPreviousAdDeliveryInfo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $aEmptyZoneAdArray = array();

        $aAdParams = array(
            'ad_id'  => 1,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new OA_Maintenance_Priority_Ad($aAdParams);
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 1));
        $oZone->addAdvert($oAd);
        $aZoneAdArray = array($oZone->id => $oZone);

        // Test 1
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        // Test 3
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $oNow = new Date();
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 5, 5a
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 6
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0.1,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 7
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 8, 8a
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 9
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 10
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 11, 11a
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 12
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 13
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 14, 14a
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 15
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 16
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 17, 17a
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 18
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            5,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            4,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            2,
            10,
            10,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            9,
            9,
            59,
            59,
            0,
            95,
            0.995,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            10,
            10,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            20,
            20,
            0,
            0.8,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            200,
            200,
            0,
            0.2,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            100,
            100,
            0,
            0.4,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 4);
        $this->assertEqual(count($result[1]), 2);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);
        $this->assertEqual($result[1][2]['ad_id'], 1);
        $this->assertEqual($result[1][2]['zone_id'], 2);
        $this->assertEqual($result[1][2]['required_impressions'], 10);
        $this->assertEqual($result[1][2]['requested_impressions'], 10);
        $this->assertEqual($result[1][2]['priority_factor'], 0.5);
        $this->assertEqual($result[1][2]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][2]['impressions'], 1);
        $this->assertEqual(count($result[2]), 2);
        $this->assertEqual($result[2][3]['ad_id'], 2);
        $this->assertEqual($result[2][3]['zone_id'], 3);
        $this->assertEqual($result[2][3]['required_impressions'], 30);
        $this->assertEqual($result[2][3]['requested_impressions'], 30);
        $this->assertEqual($result[2][3]['priority_factor'], 0.4);
        $this->assertEqual($result[2][3]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][3]['impressions'], 2);
        $this->assertEqual($result[2][4]['ad_id'], 2);
        $this->assertEqual($result[2][4]['zone_id'], 4);
        $this->assertEqual($result[2][4]['required_impressions'], 15);
        $this->assertEqual($result[2][4]['requested_impressions'], 15);
        $this->assertEqual($result[2][4]['priority_factor'], 0.6);
        $this->assertEqual($result[2][4]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][4]['impressions'], 2);
        $this->assertEqual(count($result[3]), 1);
        $this->assertEqual($result[3][5]['ad_id'], 3);
        $this->assertEqual($result[3][5]['zone_id'], 5);
        $this->assertEqual($result[3][5]['required_impressions'], 150);
        $this->assertEqual($result[3][5]['requested_impressions'], 150);
        $this->assertEqual($result[3][5]['priority_factor'], 0.3);
        $this->assertEqual($result[3][5]['past_zone_traffic_fraction'], 0.95);
        $this->assertEqual($result[3][5]['impressions'], 5);
        $this->assertEqual(count($result[9]), 1);
        $this->assertEqual($result[9][9]['ad_id'], 9);
        $this->assertEqual($result[9][9]['zone_id'], 9);
        $this->assertEqual($result[9][9]['required_impressions'], 59);
        $this->assertEqual($result[9][9]['requested_impressions'], 59);
        $this->assertEqual($result[9][9]['priority_factor'], 95);
        $this->assertEqual($result[9][9]['past_zone_traffic_fraction'], 0.995);
        $this->assertNull($result[9][9]['impressions']);

        $oDate =& $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 18a
        $oZone = new OX_Maintenance_Priority_Zone(array('zoneid' => 4));
        $aAdParams = array(
            'ad_id'  => 10,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new OA_Maintenance_Priority_Ad($aAdParams);
        $oZone->addAdvert($oAd);
        $aAdParams = array(
            'ad_id'  => 11,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new OA_Maintenance_Priority_Ad($aAdParams);
        $oZone->addAdvert($oAd);
        $aZoneAdArray = array($oZone->id => $oZone);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            5,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            4,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            10,
            0,
            4,
            1000,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        }
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        }
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            11,
            0,
            4,
            2000,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDia = $this->_insertDataIntermediateAd($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            2,
            10,
            10,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            9,
            9,
            59,
            59,
            0,
            95,
            0.995,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            10,
            10,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            20,
            20,
            0,
            0.8,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            200,
            200,
            0,
            0.2,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            100,
            100,
            0,
            0.4,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            10,
            4,
            1000,
            1000,
            0,
            1,
            0.9,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $previousOperationIntervalID = OX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        }
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        }
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            11,
            4,
            2000,
            2000,
            0,
            1,
            0.9,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $this->_insertDataSummaryAdZoneAssoc($aData);
        $result =& $oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 5);
        $this->assertEqual(count($result[1]), 2);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);
        $this->assertEqual($result[1][2]['ad_id'], 1);
        $this->assertEqual($result[1][2]['zone_id'], 2);
        $this->assertEqual($result[1][2]['required_impressions'], 10);
        $this->assertEqual($result[1][2]['requested_impressions'], 10);
        $this->assertEqual($result[1][2]['priority_factor'], 0.5);
        $this->assertEqual($result[1][2]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][2]['impressions'], 1);
        $this->assertEqual(count($result[2]), 2);
        $this->assertEqual($result[2][3]['ad_id'], 2);
        $this->assertEqual($result[2][3]['zone_id'], 3);
        $this->assertEqual($result[2][3]['required_impressions'], 30);
        $this->assertEqual($result[2][3]['requested_impressions'], 30);
        $this->assertEqual($result[2][3]['priority_factor'], 0.4);
        $this->assertEqual($result[2][3]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][3]['impressions'], 2);
        $this->assertEqual($result[2][4]['ad_id'], 2);
        $this->assertEqual($result[2][4]['zone_id'], 4);
        $this->assertEqual($result[2][4]['required_impressions'], 15);
        $this->assertEqual($result[2][4]['requested_impressions'], 15);
        $this->assertEqual($result[2][4]['priority_factor'], 0.6);
        $this->assertEqual($result[2][4]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][4]['impressions'], 2);
        $this->assertEqual(count($result[3]), 1);
        $this->assertEqual($result[3][5]['ad_id'], 3);
        $this->assertEqual($result[3][5]['zone_id'], 5);
        $this->assertEqual($result[3][5]['required_impressions'], 150);
        $this->assertEqual($result[3][5]['requested_impressions'], 150);
        $this->assertEqual($result[3][5]['priority_factor'], 0.3);
        $this->assertEqual($result[3][5]['past_zone_traffic_fraction'], 0.95);
        $this->assertEqual($result[3][5]['impressions'], 5);
        $this->assertEqual(count($result[9]), 1);
        $this->assertEqual($result[9][9]['ad_id'], 9);
        $this->assertEqual($result[9][9]['zone_id'], 9);
        $this->assertEqual($result[9][9]['required_impressions'], 59);
        $this->assertEqual($result[9][9]['requested_impressions'], 59);
        $this->assertEqual($result[9][9]['priority_factor'], 95);
        $this->assertEqual($result[9][9]['past_zone_traffic_fraction'], 0.995);
        $this->assertNull($result[9][9]['impressions']);
        $this->assertEqual(count($result[10]), 1);
        $this->assertEqual($result[10][4]['ad_id'], 10);
        $this->assertEqual($result[10][4]['zone_id'], 4);
        $this->assertEqual($result[10][4]['required_impressions'], 1000);
        $this->assertEqual($result[10][4]['requested_impressions'], 1000);
        $this->assertEqual($result[10][4]['priority_factor'], 1);
        $this->assertEqual($result[10][4]['past_zone_traffic_fraction'], 0.9);
        $this->assertEqual($result[10][4]['impressions'], 1000);

        TestEnv::restoreEnv();
    }

}

?>