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
$Id: PriorityCompensation.mtp.test.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPM.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Data_intermediate_ad.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_ECPM class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_ECPM extends UnitTestCase
{
    private $mockDal;
    private $mockDalIntermediateAd;
    
    const IDX_ADS = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_ADS;
    const IDX_MIN_IMPRESSIONS = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_MIN_IMPRESSIONS;
    const IDX_WEIGHT = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_WEIGHT;
    const IDX_ZONES = OA_Maintenance_Priority_AdServer_Task_ECPM::IDX_ZONES;

    const ALPHA = OA_Maintenance_Priority_AdServer_Task_ECPM::ALPHA;

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_ECPM()
    {
        $this->UnitTestCase();
        Mock::generate(
            'OA_Dal_Maintenance_Priority',
            $this->mockDal = 'MockOA_Dal_Maintenance_Priority'.rand()
        );
        Mock::generate(
            'MAX_Dal_Admin_Data_intermediate_ad',
            $this->mockDalIntermediateAd = 'MAX_Dal_Admin_Data_intermediate_ad'.rand()
        );
        Mock::generatePartial(
            'OA_Maintenance_Priority_AdServer_Task_ECPM',
            'PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPM',
            array('_getDal', '_factoryDal', 'getTodaysRemainingOperationIntervals',
                'calculateCampaignEcpm'
            )
        );
    }

    /**
     * Used for asserting that two arrays are equal even if
     * both arrays contain floats. All values are first rounded
     * to the given precision before comparing
     */
    function assertEqualsFloatsArray($aExpected, $aChecked, $precision = 4)
    {
        $this->assertTrue(is_array($aExpected));
        $this->assertTrue(is_array($aChecked));
        $aExpected = $this->roundArray($aExpected, $precision);
        $aChecked = $this->roundArray($aChecked, $precision);
        $this->assertEqual($aExpected, $aChecked);
    }

    function roundArray($arr, $precision)
    {
        foreach($arr as $k => $v) {
            if (is_array($v)) {
                $arr[$k] = $this->roundArray($v, $precision);
            } else {
                $arr[$k] = round($v, $precision);
            }
        }
        return $arr;
    }

    /**
     * A method to test the preloadZonesContractsForAgency() method.
     *
     * Requirements
     * Test 1: Test that contracts are correctly calculated based on the forecasts and allocations
     */
    function testPreloadZonesContractsForAgency()
    {
        // Mock the OA_Dal_Maintenance_Priority class used in the constructor method
        $oDal = new $this->mockDal($this);
        $aZonesForecasts = array(
            1 => 10,
            2 => 20,
            3 => 50,
        );
        $oDal->setReturnReference('getZonesForecastsByAgency', $aZonesForecasts);
        $aZonesAllocations = array(
            1 => 10,
            2 => 30,
            4 => 10, // this should be ignored
        );
        $oDal->setReturnReference('getZonesAllocationsByAgency', $aZonesAllocations);
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDal);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPM class
        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPM($this);
        $oEcpm->aOIDates['start'] = $oEcpm->aOIDates['end'] = new Date();
        $oEcpm->setReturnReference('_getDal', $oDal);
        $oEcpm->OA_Maintenance_Priority_AdServer_Task();

        // Test
        $aZonesExpectedContracts = array(
            1 => 0, // 10 - 10
            2 => 0, // 20 - 30 = -10, so it should be 0
            3 => 50, // 50 - no allocations for this zone
        );
        $oEcpm->preloadZonesContractsForAgency(123);
        $this->assertEqual($aZonesExpectedContracts, $oEcpm->aZonesContracts);
    }

    /**
     * A method to test the preloadCampaignsDeliveredImpressionsForAgency() method.
     *
     * Requirements
     * Test 1: Test that campaign impressions are correctly preloaded
     */
    function testPreloadCampaignsDeliveredImpressionsForAgency()
    {
        // Mock the MAX_Dal_Admin_Data_intermediate_ad class used in the constructor method
        $oDal = new $this->mockDalIntermediateAd($this);
        $aCampaignsImpressions = array(
            1 => 10,
            2 => 20,
        );
        $oDal->setReturnReference('getDeliveredEcpmCampainImpressionsByAgency', $aCampaignsImpressions);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPM class
        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPM($this);
        $oEcpm->setReturnReference('_factoryDal', $oDal);
        $oEcpm->OA_Maintenance_Priority_AdServer_Task();

        $oEcpm->preloadCampaignsDeliveredImpressionsForAgency(123);
        $this->assertEqual($aCampaignsImpressions, $oEcpm->aCampaignsDeliveredImpressions);
    }

    /**
     * A method to test the preloadCampaignsDeliveredImpressionsForAgency() method.
     *
     * Requirements
     * Test 1: Test that campaign impressions are correctly preloaded
     */
    function testPrepareCampaignsParameters()
    {
        $aCampaignsInfo = array();
        $aEcpm = array();
        $aCampaignsDeliveredImpressions = array();
        $aExpAdsEcpmPowAlpha = array();
        $aExpZonesEcpmPowAlphaSums = array();
        $aExpAdsMinImpressions = array();

        // 2 operation intervals left to the end of the day
        // (to deliver all minimum impressions)
        $leftOi = 2;

        ///////////////////////////////////////////////////
        // one ad linked to one zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId1 = 1] = array(
            self::IDX_ADS => array(
                $adId1 = 1 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId1 = 1),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 100,
        );
        $aEcpm[$campaignId1] = 0.5;
        $aCampaignsDeliveredImpressions[$campaignId1] = 0;
        $aExpAdsEcpmPowAlpha[$adId1] = pow(0.5, self::ALPHA);
        $aExpZonesEcpmPowAlphaSums[$zoneId1] = $aExpAdsEcpmPowAlpha[$adId1];
        // all minimum impressions go to the only ad
        $aExpAdsMinImpressions[$adId1] = $min / $leftOi;

        ///////////////////////////////////////////////////
        // one ad linked to two zones
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId2 = 2] = array(
            self::IDX_ADS => array(
                $adId2 = 2 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId2 = 2, $zoneId3 = 3),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 200,
        );
        $aEcpm[$campaignId2] = 0.6;
        $aCampaignsDeliveredImpressions[$campaignId2] = $delivered = 100; // half delivered
        $aExpAdsEcpmPowAlpha[$adId2] = pow(0.6, self::ALPHA);
        $aExpZonesEcpmPowAlphaSums[$zoneId2] =
            $aExpZonesEcpmPowAlphaSums[$zoneId3] =
            $aExpAdsEcpmPowAlpha[$adId2];
        // all left minimum impressions go to the only ad
        $aExpAdsMinImpressions[$adId2] = ($min - $delivered) / $leftOi;

        ///////////////////////////////////////////////////
        // two ads linked to one zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId3 = 3] = array(
            self::IDX_ADS => array(
                $adId3 = 3 => array(
                    self::IDX_WEIGHT => $w1 = 1,
                    self::IDX_ZONES => array($zoneId4 = 4),
                ),
                $adId4 = 4 => array(
                    self::IDX_WEIGHT => $w2 = 2, // different weights
                    self::IDX_ZONES => array($zoneId4),
                ),
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 300,
        );
        $aEcpm[$campaignId3] = 0.7;
        $aCampaignsDeliveredImpressions[$campaignId3] = $delivered = 200;
        $aExpAdsEcpmPowAlpha[$adId3] = pow(0.7, self::ALPHA);
        $aExpAdsEcpmPowAlpha[$adId4] = pow(0.7, self::ALPHA);
        $aExpZonesEcpmPowAlphaSums[$zoneId4] =
            $aExpAdsEcpmPowAlpha[$adId3] + $aExpAdsEcpmPowAlpha[$adId4];
        // all left minimum impressions go to two ads based on their weights
        $sumW = $w1 + $w2;
        $toDeliverInNextOI = ($min - $delivered) / $leftOi;
        $aExpAdsMinImpressions[$adId3] = $w1 / $sumW * $toDeliverInNextOI;
        $aExpAdsMinImpressions[$adId4] = $w2 / $sumW * $toDeliverInNextOI;

        ///////////////////////////////////////////////////
        // simple scenario for the case when all impr. are delivered already
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId4 = 4] = array(
            self::IDX_ADS => array(
                $adId5 = 5 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId5 = 5),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => 100,
        );
        $aEcpm[$campaignId4] = 0.8;
        $aCampaignsDeliveredImpressions[$campaignId4] = 100; // all delivered
        $aExpAdsEcpmPowAlpha[$adId5] = pow(0.8, self::ALPHA);
        $aExpZonesEcpmPowAlphaSums[$zoneId5] =
            $aExpAdsEcpmPowAlpha[$adId5];
        $aExpAdsMinImpressions[$adId5] = 0; // all min. impressions delivered

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPM class
        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPM($this);
        // lets assume only two intervals are left till the end of the day
        $oEcpm->setReturnValue('getTodaysRemainingOperationIntervals', $leftOi);
        foreach ($aEcpm as $campId => $ecpm) {
            $oEcpm->setReturnValue('calculateCampaignEcpm', $ecpm, array($campId, '*'));
        }
        // Impressions delivered today in eahc of campaigns
        $oEcpm->aCampaignsDeliveredImpressions = $aCampaignsDeliveredImpressions;

        // Test
        $oEcpm->prepareCampaignsParameters($aCampaignsInfo);

        $this->assertEqual($aExpAdsEcpmPowAlpha, $oEcpm->aAdsEcpmPowAlpha);
        $this->assertEqual($aExpZonesEcpmPowAlphaSums, $oEcpm->aZonesEcpmPowAlphaSums);
        $this->assertEqualsFloatsArray($aExpAdsMinImpressions, $oEcpm->aAdsMinImpressions);
    }

    /**
     * A method to test the calculateAdsZonesMinimumRequiredImpressions() method.
     *
     * Requirements
     * Test 1: Test that minimum ads/zones pair are correctly calculated
     */
    function testCalculateAdsZonesMinimumRequiredImpressions()
    {
        // we assume that only one operation interval is left to the end of the day
        // (it doesn't impact the test and will make calculations easier)
        // prepare test data
        $aCampaignsInfo = array();
        $aAdsMinImpressions = array();
        $aZonesContracts = array();

        $aExpAdZonesMinImpressions = array();

        ///////////////////////////////////////////////////
        // one ad linked to one zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId1 = 1] = array(
            self::IDX_ADS => array(
                $adId1 = 1 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId1 = 1),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 100,
        );
        // less impressions available than the required minumum
        $aZonesContracts[$zoneId1] = 10;
        // can't get more impressions if a contract is smaller than
        // the required minimum
        $aExpAdZonesMinImpressions[$adId1][$zoneId1] = 10;

        ///////////////////////////////////////////////////
        // one ad linked to two zones
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId2 = 2] = array(
            self::IDX_ADS => array(
                $adId2 = 2 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId2 = 2, $zoneId3 = 3),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 200,
        );
        $aEcpm[$campaignId2] = 0.6;
        // as many impressions in first zone as in second, sum equal to required minimum
        $aZonesContracts[$zoneId2] = 100;
        $aZonesContracts[$zoneId3] = 100;
        // ad should get all impr. in both zones
        $aExpAdZonesMinImpressions[$adId2][$zoneId2] = 100;
        $aExpAdZonesMinImpressions[$adId2][$zoneId3] = 100;

        ///////////////////////////////////////////////////
        // two ads linked to one zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId3 = 3] = array(
            self::IDX_ADS => array(
                $adId3 = 3 => array(
                    self::IDX_WEIGHT => $w1 = 1,
                    self::IDX_ZONES => array($zoneId4 = 4),
                ),
                $adId4 = 4 => array(
                    self::IDX_WEIGHT => $w2 = 2, // different weights
                    self::IDX_ZONES => array($zoneId4),
                ),
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 300,
        );
        $aEcpm[$campaignId3] = 0.7;
        // all left minimum impressions go to two ads based on their weights
        $sumW = $w1 + $w2;
        // twice as many impressions as required
        $aZonesContracts[$zoneId4] = 600;
        // ad should get impr. in both zones according to their weights
        $aExpAdZonesMinImpressions[$adId3][$zoneId4] = $w1 / $sumW * $min;
        $aExpAdZonesMinImpressions[$adId4][$zoneId4] = $w2 / $sumW * $min;

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPM class
        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPM($this);
        $oEcpm->setReturnValue('getTodaysRemainingOperationIntervals', 1);
        foreach ($aEcpm as $campId => $ecpm) {
            $oEcpm->setReturnValue('calculateCampaignEcpm', $ecpm, array($campId, '*'));
        }
        $oEcpm->aCampaignsDeliveredImpressions = array(); // nothing was delivered so far
        // precalculate the min/required impressions per ad
        $oEcpm->prepareCampaignsParameters($aCampaignsInfo);
        $oEcpm->aZonesContracts = $aZonesContracts;

        // Test
        $aAdsZonesMinImpressions = $oEcpm->calculateAdsZonesMinimumRequiredImpressions($aCampaignsInfo);
        $this->assertEqual($aExpAdZonesMinImpressions, $aAdsZonesMinImpressions);
    }

    /**
     * A method to test the calculateDeliveryProbabilities() method.
     *
     * Requirements
     * Test 1: Test that method calculates correct probabilities for each ad/zone
     */
    function testCalculateDeliveryProbabilities()
    {
        $aExpAdZonesProbabilities = array();
        $aZonesContracts = array();
        ///////////////////////////////////////////////////
        // one ad linked to one zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId1 = 1] = array(
            self::IDX_ADS => array(
                $adId1 = 1 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId1 = 1),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 100,
        );
        $aEcpm[$campaignId1] = 0.1;
        // less impressions available than the required minumum
        $aZonesContracts[$zoneId1] = 10;
        $aExpAdZonesProbabilities[$adId1][$zoneId1] = 1;

        ///////////////////////////////////////////////////
        // one ad linked to two zones
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId2 = 2] = array(
            self::IDX_ADS => array(
                $adId2 = 2 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId2 = 2, $zoneId3 = 3),
                )
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 200,
        );
        $aEcpm[$campaignId2] = 0.6;
        // as many impressions in first zone as in second, sum equal to required minimum
        $aZonesContracts[$zoneId2] = 100;
        $aZonesContracts[$zoneId3] = 100;
        // separate zones, so each zone get 100%
        $aExpAdZonesProbabilities[$adId2][$zoneId2] = 1;
        $aExpAdZonesProbabilities[$adId2][$zoneId3] = 1;

        ///////////////////////////////////////////////////
        // two ads linked to one zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId3 = 3] = array(
            self::IDX_ADS => array(
                $adId3 = 3 => array(
                    self::IDX_WEIGHT => $w1 = 1,
                    self::IDX_ZONES => array($zoneId4 = 4),
                ),
                $adId4 = 4 => array(
                    self::IDX_WEIGHT => $w2 = 2, // different weights
                    self::IDX_ZONES => array($zoneId4),
                ),
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 300,
        );
        $aEcpm[$campaignId3] = 0.7;
        $aZonesContracts[$zoneId4] = $M = 600;
        // actual algorithm
        $ecpmPow = pow(0.7, self::ALPHA);
        $ecpmZoneSum = $ecpmPow + $ecpmPow;
        $p = $ecpmPow / $ecpmZoneSum;

        $sumW = $w1 + $w2;
        $adMinImpr1 = $w1 / $sumW * $min;
        $adMinImpr2 = $w2 / $sumW * $min;
        $sumAdMinImpr = $adMinImpr1 + $adMinImpr2;

        $aExpAdZonesProbabilities[$adId3][$zoneId4] =
            $adMinImpr1 / $M + (1 - $sumAdMinImpr / $M) * $p;
        $aExpAdZonesProbabilities[$adId4][$zoneId4] =
            $adMinImpr2 / $M + (1 - $sumAdMinImpr / $M) * $p;

        ///////////////////////////////////////////////////
        // two ads linked to one zone
        //////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId3 = 3] = array(
            self::IDX_ADS => array(
                $adId3 = 3 => array(
                    self::IDX_WEIGHT => $w1 = 1,
                    self::IDX_ZONES => array($zoneId4 = 4),
                ),
                $adId4 = 4 => array(
                    self::IDX_WEIGHT => $w2 = 2, // different weights
                    self::IDX_ZONES => array($zoneId4),
                ),
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 300,
        );
        $aEcpm[$campaignId3] = 0.7;
        $aZonesContracts[$zoneId4] = $M = 600;
        // actual algorithm
        $ecpmPow = pow(0.7, self::ALPHA);
        $ecpmZoneSum = $ecpmPow + $ecpmPow;
        $p = $ecpmPow / $ecpmZoneSum;

        $sumW = $w1 + $w2;
        $adMinImpr1 = $w1 / $sumW * $min;
        $adMinImpr2 = $w2 / $sumW * $min;
        $sumAdMinImpr = $adMinImpr1 + $adMinImpr2;

        $aExpAdZonesProbabilities[$adId3][$zoneId4] =
            $adMinImpr1 / $M + (1 - $sumAdMinImpr / $M) * $p;
        $aExpAdZonesProbabilities[$adId4][$zoneId4] =
            $adMinImpr2 / $M + (1 - $sumAdMinImpr / $M) * $p;

        ///////////////////////////////////////////////////
        // two campaigns with different eCPM linked to one zone
        //////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId4 = 4] = array(
            self::IDX_ADS => array(
                $adId5 = 5 => array(
                    self::IDX_WEIGHT => $w1 = 1,
                    self::IDX_ZONES => array($zoneId5 = 5),
                ),
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 100,
        );
        $aEcpm[$campaignId4] = 0.5;
        $aCampaignsInfo[$campaignId4 = 5] = array(
            self::IDX_ADS => array(
                $adId6 = 6 => array(
                    self::IDX_WEIGHT => $w2 = 1,
                    self::IDX_ZONES => array($zoneId5 = 5),
                ),
            ),
            self::IDX_MIN_IMPRESSIONS => $min = 100,
        );
        $aEcpm[$campaignId4] = 1.0;
        $aZonesContracts[$zoneId5] = $M = 1000;
        // actual algorithm
        $ecpmPow1 = pow(0.5, self::ALPHA);
        $ecpmPow2 = pow(1.0, self::ALPHA);
        $ecpmZoneSum = $ecpmPow1 + $ecpmPow2;
        $p1 = $ecpmPow1 / $ecpmZoneSum;
        $p2 = $ecpmPow2 / $ecpmZoneSum;

        $adMinImpr1 = $min;
        $adMinImpr2 = $min;
        $sumAdMinImpr = $adMinImpr1 + $adMinImpr2;

        $aExpAdZonesProbabilities[$adId5][$zoneId5] =
            $adMinImpr1 / $M + (1 - $sumAdMinImpr / $M) * $p1;
        $aExpAdZonesProbabilities[$adId6][$zoneId5] =
            $adMinImpr2 / $M + (1 - $sumAdMinImpr / $M) * $p2;

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPM class
        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPM($this);
        $oEcpm->setReturnValue('getTodaysRemainingOperationIntervals', 1);
        foreach ($aEcpm as $campId => $ecpm) {
            $oEcpm->setReturnValue('calculateCampaignEcpm', $ecpm, array($campId, '*'));
        }
        $oEcpm->aCampaignsDeliveredImpressions = array(); // nothing was delivered so far
        // precalculate the min/required impressions per ad
        $oEcpm->aZonesContracts = $aZonesContracts;
        $oEcpm->prepareCampaignsParameters($aCampaignsInfo);

        // Test
        $aAdZonesProbabilities = $oEcpm->calculateDeliveryProbabilities($aCampaignsInfo);
        $this->assertEqualsFloatsArray($aExpAdZonesProbabilities, $aAdZonesProbabilities);
    }
}

?>
