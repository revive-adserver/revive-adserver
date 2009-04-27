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

require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMforContract.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ECPMCommon.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_ECPMforContract class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_ECPMforContract extends UnitTestCase
{
    private $mockDal;
    
    const IDX_ADS = OA_Maintenance_Priority_AdServer_Task_ECPMforContract::IDX_ADS;
    const IDX_WEIGHT = OA_Maintenance_Priority_AdServer_Task_ECPMforContract::IDX_WEIGHT;
    const IDX_ZONES = OA_Maintenance_Priority_AdServer_Task_ECPMforContract::IDX_ZONES;

    const ALPHA = OA_Maintenance_Priority_AdServer_Task_ECPMforContract::ALPHA;
    const MU_1 = OA_Maintenance_Priority_AdServer_Task_ECPMforContract::MU_1;
    const MU_2 = OA_Maintenance_Priority_AdServer_Task_ECPMforContract::MU_2;

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_ECPMforContract()
    {
        $this->UnitTestCase();
        Mock::generate(
            'OA_Dal_Maintenance_Priority',
            $this->mockDal = 'MockOA_Dal_Maintenance_Priority'.rand()
        );
        Mock::generatePartial(
            'OA_Maintenance_Priority_AdServer_Task_ECPMforContract',
            'PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPMforContract',
            array('_getDal', '_factoryDal', 'calculateCampaignEcpm'
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
     * A method to test the prepareCampaignsParameters() method.
     */
    function testPrepareCampaignsParameters()
    {
        $aCampaignsInfo = array();
        $aEcpm = array();
        $aCampaignsDeliveredImpressions = array();
        $aExpAdsEcpmPowAlpha = array();
        $aExpZonesEcpmPowAlphaSums = array();
        $aAdsGoals = array();

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
        );
        $aAdsGoals[$zoneId1][$adId1] = 100;
        $aEcpm[$campaignId1] = 0.5;
        $aExpAdsEcpmPowAlpha[$adId1] = pow(0.5, self::ALPHA);
        $aExpZonesEcpmPowAlphaSums[$zoneId1] = self::MU_2 * $aAdsGoals[$zoneId1][$adId1] *
            $aExpAdsEcpmPowAlpha[$adId1];
        $aExpZonesGuaranteedImpr[$zoneId1] = self::MU_1 * $aAdsGoals[$zoneId1][$adId1];

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
        );
        $aAdsGoals[$zoneId2][$adId2] = 200;
        $aAdsGoals[$zoneId3][$adId2] = 200;
        $aEcpm[$campaignId2] = 0.6;
        $aExpAdsEcpmPowAlpha[$adId2] = pow(0.6, self::ALPHA);
        $aExpZonesEcpmPowAlphaSums[$zoneId2] = self::MU_2 * $aAdsGoals[$zoneId2][$adId2] *
            $aExpAdsEcpmPowAlpha[$adId2];
        $aExpZonesGuaranteedImpr[$zoneId2] = self::MU_1 * $aAdsGoals[$zoneId2][$adId2];
        $aExpZonesEcpmPowAlphaSums[$zoneId3] = self::MU_2 * $aAdsGoals[$zoneId3][$adId2] *
            $aExpAdsEcpmPowAlpha[$adId2];
        $aExpZonesGuaranteedImpr[$zoneId3] = self::MU_1 * $aAdsGoals[$zoneId3][$adId2];

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPMforContract class
        $oDal = new $this->mockDal($this);
        $oDal->setReturnReference('getRequiredAdZoneImpressions', $aAdsGoals);

        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPMforContract($this);
        $oEcpm->setReturnReference('_getDal', $oDal);
        $oEcpm->OA_Maintenance_Priority_AdServer_Task();
        foreach ($aEcpm as $campId => $ecpm) {
            $oEcpm->setReturnValue('calculateCampaignEcpm', $ecpm, array($campId, '*'));
        }

        // Test
        $oEcpm->prepareCampaignsParameters($aCampaignsInfo);

        $this->assertEqual($aExpAdsEcpmPowAlpha, $oEcpm->aAdsEcpmPowAlpha);
        $this->assertEqual($aExpZonesEcpmPowAlphaSums, $oEcpm->aZonesEcpmPowAlphaSums);
        $this->assertEqual($aExpZonesGuaranteedImpr, $oEcpm->aZonesGuaranteedImpressionsSums);
    }

    /**
     * A method to test the calculateDeliveryProbabilities() method.
     */
    function testCalculateDeliveryProbabilities()
    {
        $aExpAdZonesProbabilities = array();
        $aZonesAvailableImpressions = array();
        $aZoneAdGoal = array();

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
        );
        $aEcpm[$campaignId1] = 0.1;
        $aZoneAdGoal[$zoneId1][$adId1] = $G = 20;
        $aZonesAvailableImpressions[$zoneId1] = $M = 10;
        // probability equal 1.0 because more required than available impressions
        $aExpAdZonesProbabilities[$adId1][$zoneId1] = 1.0;

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
        );
        $aEcpm[$campaignId2] = 0.6;
        // as many impressions in first zone as in second, sum equal to required minimum
        $aZoneAdGoal[$zoneId2][$adId2] = $G1 = 200;
        $aZoneAdGoal[$zoneId3][$adId2] = $G2 = 200;
        $aZonesAvailableImpressions[$zoneId2] = $M1 = 100;
        $aZonesAvailableImpressions[$zoneId3] = $M2 = 100;

        // simple case
        $aExpAdZonesProbabilities[$adId2][$zoneId2] = 1.0;
        $aExpAdZonesProbabilities[$adId2][$zoneId3] = 1.0;

        ///////////////////////////////////////////////////
        // one ad linked to one zone (undersubscribed)
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId3 = 3] = array(
            self::IDX_ADS => array(
                $adId3 = 3 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId4 = 4),
                )
            ),
        );
        $aEcpm[$campaignId4] = 0.1;
        $aZoneAdGoal[$zoneId4][$adId3] = $G = 5;
        $aZonesAvailableImpressions[$zoneId4] = $M = 10;
        // probability not set because campaign is undersubscribed
        // the stanndad MPE should calculate the probability in this case
        // $aExpAdZonesProbabilities[$adId3][$zoneId4] = as calculated by MPE;

        ///////////////////////////////////////////////////
        // two ads with different eCPM linked to same zone
        ///////////////////////////////////////////////////
        $aCampaignsInfo[$campaignId4 = 4] = array(
            self::IDX_ADS => array(
                $adId4 = 4 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId5 = 5),
                )
            ),
        );
        $aCampaignsInfo[$campaignId5 = 5] = array(
            self::IDX_ADS => array(
                $adId5 = 5 => array(
                    self::IDX_WEIGHT => 1,
                    self::IDX_ZONES => array($zoneId5 = 5),
                )
            ),
        );
        $aEcpm[$campaignId4] = $ecpm1 = 0.3;
        $aEcpm[$campaignId5] = $ecpm2 = 0.6;
        $aZoneAdGoal[$zoneId5][$adId4] = $G = 100;
        $aZoneAdGoal[$zoneId5][$adId5] = $G = 100;
        $aZonesAvailableImpressions[$zoneId5] = $M = 100;

        $a = self::MU_1 * $G;
        $b = self::MU_2 * $G;
        $ecpmZone = $b * pow($ecpm1, self::ALPHA) + $b * pow($ecpm2, self::ALPHA);
        $p1 = $b * pow($ecpm1, self::ALPHA) / $ecpmZone;
        $p2 = $b * pow($ecpm2, self::ALPHA) / $ecpmZone;

        $aExpAdZonesProbabilities[$adId4][$zoneId5] = $a / $M + (1 - 2 * $a / $M) * $p1;
        $aExpAdZonesProbabilities[$adId5][$zoneId5] = $a / $M + (1 - 2 * $a / $M) * $p2;

        /////////////////////////////////////////////////////////

        $oDal = new $this->mockDal($this);
        $oDal->setReturnReference('getRequiredAdZoneImpressions', $aZoneAdGoal);

        // Partially mock the OA_Maintenance_Priority_AdServer_Task_ECPM class
        $oEcpm = new PartialMock_OA_Maintenance_Priority_AdServer_Task_ECPMforContract($this);
        foreach ($aEcpm as $campId => $ecpm) {
            $oEcpm->setReturnValue('calculateCampaignEcpm', $ecpm, array($campId, '*'));
        }
        $oEcpm->setReturnReference('_getDal', $oDal);
        $oEcpm->OA_Maintenance_Priority_AdServer_Task();
        $oEcpm->aZonesAvailableImpressions = $aZonesAvailableImpressions;
        $oEcpm->prepareCampaignsParameters($aCampaignsInfo);

        // Test
        $aAdZonesProbabilities = $oEcpm->calculateDeliveryProbabilities($aCampaignsInfo);
        $this->assertEqualsFloatsArray($aExpAdZonesProbabilities, $aAdZonesProbabilities);
    }
}

?>
