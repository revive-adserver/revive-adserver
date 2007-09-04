<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Dal/Entities.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'Date.php';

/**
 * A class for testing the non-DB specific MAX_Dal_Entities DAL class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfMAX_Dal_Entities extends UnitTestCase
{

    var $doBanners = null;
    var $doZones = null;
    var $doAdZone = null;
    var $doAcls = null;
    var $doAgency = null;
    var $doChannel = null;
    var $doAclsChannel = null;
    var $doCampaigns = null;
    var $doAffiliates = null;

    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Entities()
    {
        $this->UnitTestCase();
        $this->doBanners   = OA_Dal::factoryDO('banners');
        $this->doZones = OA_Dal::factoryDO('zones');
        $this->doAcls = OA_Dal::factoryDO('acls');
        $this->doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $this->doAgency = OA_Dal::factoryDO('agency');
        $this->doChannel = OA_Dal::factoryDO('channel');
        $this->doAclsChannel = OA_Dal::factoryDO('acls_channel');
        $this->doCampaigns = OA_Dal::factoryDO('campaigns');
        $this->doAffiliates = OA_Dal::factoryDO('affiliates');
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

    function _insertZone($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doZones->$key = $val;
        }
        return DataGenerator::generateOne($this->doZones);
    }

    function _insertAdZoneAssoc($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doAdZone->$key = $val;
        }
        return DataGenerator::generateOne($this->doAdZone);
    }

    function _insertAgency($aData)
    {
        $this->doAgency->active = $aData[1];
        $this->doAgency->updated = $aData[2];
        return DataGenerator::generateOne($this->doAgency);
    }

    function _insertAcls($aData)
    {
        $this->doAcls->bannerid = $aData[0];
        $this->doAcls->logical = $aData[1];
        $this->doAcls->type = $aData[2];
        $this->doAcls->comparison = $aData[3];
        $this->doAcls->data = $aData[4];
        $this->doAcls->executionorder = $aData[5];
        return DataGenerator::generateOne($this->doAcls);
    }

    function _insertChannel($aData)
    {
        $this->doChannel->agencyid = $aData[1];
        $this->doChannel->affiliateid = $aData[2];
        $this->doChannel->active = $aData[3];
        $this->doChannel->compiledlimitation = $aData[4];
        $this->doChannel->updated = $aData[5];
        $this->doChannel->acls_updated = $aData[6];
        return DataGenerator::generateOne($this->doChannel);
    }

    function _insertAclsChannel($aData)
    {
        $this->doAclsChannel->channelid = $aData[0];
        $this->doAclsChannel->logical = $aData[1];
        $this->doAclsChannel->type = $aData[2];
        $this->doAclsChannel->comparison = $aData[3];
        $this->doAclsChannel->data = $aData[4];
        $this->doAclsChannel->executionorder = $aData[5];
        return DataGenerator::generateOne($this->doAclsChannel);
    }

    function _insertCampaign($aData)
    {
        $this->doCampaigns->campaignname = 'Test Placement';
        $this->doCampaigns->weight = 1;
        $this->doCampaigns->priority = -1;
        $this->doCampaigns->views = -1;
        $this->doCampaigns->clicks = -1;
        $this->doCampaigns->conversions = -1;
        $this->doCampaigns->target_impression = -1;
        $this->doCampaigns->target_click = -1;
        $this->doCampaigns->target_conversion = -1;
        $this->doCampaigns->updated = null;
        $this->doCampaigns->expire = null;
        $this->doCampaigns->activate = null;
        foreach ($aData AS $key => $val)
        {
            $this->doCampaigns->$key = $val;
        }
        return DataGenerator::generateOne($this->doCampaigns);
    }

    function _insertAffiliate($aData)
    {
        $this->doAffiliates->agencyid = $aData[1];
        $this->doAffiliates->updated = $aData[2];
        return DataGenerator::generateOne($this->doAffiliates);
    }

    /**
     * A method to test the getAdsByPlacementId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with a single ad in the database, and ensure it is returned
     * Test 4: Test with multiple ads in the database, and ensure only the
     *         required ads are returned
     */
    function testGetAdsByPlacementId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $placementId = 'foo';
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $this->assertNull($aResult);

        // Test 2
        $placementId = 1;
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            'campaignid'=>$placementId,
            'active'=>'t',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $aExpectedResult = array(
            1 => array(
                'ad_id'  => $idBanner1,
                'active' => 't',
                'type'   => 'sql',
                'weight' => 1
            )
        );
        $this->assertEqual($aResult[1]['ad_id'], $aExpectedResult[1]['ad_id']);

        // Test 4
        $aData = array(
            'campaignid'=>$placementId,
            'active'=>'f',
            'weight'=>5,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>$placementId+1,
            'active'=>'t',
            'weight'=>2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner3 = $this->_insertBanner($aData);
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $aExpectedResult = array(
            1 => array(
                'ad_id'  => $idBanner1,
                'active' => 't',
                'type'   => 'sql',
                'weight' => 1
            ),
            2 => array(
                'ad_id'  => $idBanner2,
                'active' => 'f',
                'type'   => 'sql',
                'weight' => 5
            )
        );
        $this->assertEqual($aResult[1]['ad_id'], $aExpectedResult[1]['ad_id']);
        $this->assertEqual($aResult[2]['ad_id'], $aExpectedResult[2]['ad_id']);

        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getLinkedActiveAdIdsByZoneIds() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with an inactive ad in the database, and ensure nothing returned
     * Test 4: Test with an active ad in the database, and ensure it is returned
     * Test 5: Test with multiple active and inactive ads in the database, and
     *         ensure the correct data is returned
     */
    function testGetLinkedActiveAdIdsByZoneIds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aZoneIds = 'foo';
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        $aZoneIds = array(1, 2, 'foo', 3);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        // Test 2
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();

        $aData = array(
            'campaignid'=>1,
            'active'=>'f',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);

        $aData = array(
            'zone_id'=>1,
            'ad_id'=>$idBanner1,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            'campaignid'=>'',
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aData = array(
            'zone_id'=>1,
            'ad_id'=>$idBanner1,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $aExpectedResult = array(1 => array($idBanner1));
        $this->assertEqual($aResult, $aExpectedResult);
        $this->assertEqual($aResult[1], $aExpectedResult[1]);
        $this->assertEqual($aResult[1][0], $aExpectedResult[1][0]);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            'campaignid'=>'',
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>'',
            'active'=>'f',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>'',
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner3 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>'',
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner4 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>'',
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner5 = $this->_insertBanner($aData);
        $aData = array(
            'zone_id'=>1,
            'ad_id'=>$idBanner1,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'zone_id'=>1,
            'ad_id'=>$idBanner2,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'zone_id'=>1,
            'ad_id'=>$idBanner3,
            'link_type'=>0
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'zone_id'=>2,
            'ad_id'=>$idBanner3,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'zone_id'=>2,
            'ad_id'=>$idBanner4,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'zone_id'=>2,
            'ad_id'=>$idBanner5,
            'link_type'=>1
        );
        $idAdZone = $this->_insertAdZoneAssoc($aData);
        $aZoneIds = array(1, 2);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $aExpectedResult = array(
            1 => array($idBanner1),
            2 => array($idBanner3, $idBanner4, $idBanner5)
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllActiveAdsDeliveryLimitationsByPlacementIds() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with an inactive ad in a test placement, and ensure nothing returned
     * Test 4: Test with an active ad in a test placement, and ensure it is returned
     * Test 5: Test with an active ad and delivery limitations in a test placement,
     *         and ensure it is returned
     * Test 6: Test with multiple active and inactive ads, with delivery limitations,
     *         in test placements, and ensure the correct data is returned
     */
    function testGetAllActiveAdsDeliveryLimitationsByPlacementIds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aPlacmementIds = 'foo';
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $this->assertNull($aResult);

        $aPlacmementIds = array(1, 2, 'foo', 3);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $this->assertNull($aResult);

        // Test 2
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            'campaignid'=>1,
            'active'=>'f',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $aExpectedResult = array(
            1 => array(
                $idBanner1 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);

        $aData = array(
            $idBanner1,
            'and',
            'Site:Channel',
            '==',
            12,
            0
        );
        $idAcls1 = $this->_insertAcls($aData);
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $aExpectedResult = array(
            1 => array(
                $idBanner1 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array(
                        0 => array(
                            'logical'    => 'and',
                            'type'       => 'Site:Channel',
                            'comparison' => '==',
                            'data'       => 12
                        )
                    )
                )
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            'campaignid'=>1,
            'active'=>'f',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner3 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>8,
            'active'=>'t',
            'weight'=>1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner4 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>7,
            'active'=>'t',
            'weight'=>10,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner5 = $this->_insertBanner($aData);
        $aData = array(
            $idBanner2,
            'and',
            'Site:Channel',
            '==',
            12,
            0
        );
        $idAcls1 = $this->_insertAcls($aData);
        $aData = array(
            $idBanner3,
            'and',
            'Site:Channel',
            '!=',
            12,
            1
        );
        $idAcls2 = $this->_insertAcls($aData);
        $aData = array(
            $idBanner3,
            'and',
            'Site:Channel',
            '==',
            15,
            0
        );
        $idAcls3 = $this->_insertAcls($aData);
        $aData = array(
            $idBanner5,
            'and',
            'Site:Channel',
            '==',
            10,
            0
        );
        $idAcls4 = $this->_insertAcls($aData);
        $aPlacmementIds = array(1, 7);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $aExpectedResult = array(
            1 => array(
                $idBanner3 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array(
                        0 => array(
                            'logical'    => 'and',
                            'type'       => 'Site:Channel',
                            'comparison' => '==',
                            'data'       => 15
                        ),
                        1 => array(
                            'logical'    => 'and',
                            'type'       => 'Site:Channel',
                            'comparison' => '!=',
                            'data'       => 12
                        )
                    )
                )
            ),
            7 => array(
                $idBanner5 => array(
                    'active' => 't',
                    'weight' => 10,
                    'deliveryLimitations' => array(
                        0 => array(
                            'logical'    => 'and',
                            'type'       => 'Site:Channel',
                            'comparison' => '==',
                            'data'       => 10
                        )
                    )
                )
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getDeliveryLimitationsByAdId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with delivery limitations attached to ad NOT desired, and
     *         ensure nothing returned
     * Test 4: Test with delivery limitations attached to the ad desired, and
     *         ensure they are returned
     */
    function testGetDeliveryLimitationsByAdId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $adId = 'foo';
        $aResult = $oDal->getDeliveryLimitationsByAdId($adId);
        $this->assertNull($aResult);

        // Test 2
        $adId = 1;
        $aResult = $oDal->getDeliveryLimitationsByAdId($adId);
        $this->assertNull($aResult);

        // Test 3
        $aData = array(
            2,
            'and',
            'Site:Channel',
            '==',
            12,
            0
        );
        $idAcls1 = $this->_insertAcls($aData);
        $adId = 1;
        $aResult = $oDal->getDeliveryLimitationsByAdId($adId);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            1,
            'and',
            'Site:Channel',
            '==',
            10,
            0
        );
        $idAcls1 = $this->_insertAcls($aData);
        $aData = array(
            1,
            'or',
            'Site:Channel',
            '==',
            11,
            1
        );
        $idAcls2 = $this->_insertAcls($aData);
        $aData = array(
            2,
            'and',
            'Site:Channel',
            '==',
            12,
            0
        );
        $idAcls3 = $this->_insertAcls($aData);
        $adId = 1;
        $aResult = $oDal->getDeliveryLimitationsByAdId($adId);
        $aExpectedResult = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Site:Channel',
                'comparison' => '==',
                'data'       => 10
            ),
            1 => array(
                'logical'    => 'or',
                'type'       => 'Site:Channel',
                'comparison' => '==',
                'data'       => 11
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllActiveAgencyIds() method.
     *
     * Requirements:
     * Test 1: Test with nothing in the database, and ensure nothing returned
     * Test 2: Test with an inactive agency in the database, and ensure nothing
     *         returned
     * Test 3: Test with an active agency in the database, and ensure it is
     *         returned
     * Test 4: Test with multiple active and inactive agencies in the database,
     *         and ensure the correct values are returned
     */
    function testGetAllActiveAgencyIds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertNull($aResult);

        // Test 2
        $oNow = new Date();
        $aData = array(
            1,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAgency1 = $this->_insertAgency($aData);
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 3
        $aData = array(
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAgency1 = $this->_insertAgency($aData);
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            1,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAgency1 = $this->_insertAgency($aData);
        $aData = array(
            2,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAgency2 = $this->_insertAgency($aData);
        $aData = array(
            3,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAgency3 = $this->_insertAgency($aData);
        $aData = array(
            4,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAgency4 = $this->_insertAgency($aData);
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 2);
        $this->assertEqual($aResult[1], 4);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllActiveChannelIdsByAgencyId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with an inactive channel in the database, and ensure nothing
     *         returned
     * Test 4: Test with an active channel in the database, and ensure it is
     *         returned
     * Test 5: Test with multiple active and inactive channels in the database,
     *         and ensure the correct values are returned
     */
    function testGetAllActiveChannelIdsByAgencyId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId('foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            '',
            1,
            0,
            0,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel1 = $this->_insertChannel($aData);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            1,
            1,
            0,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel1 = $this->_insertChannel($aData);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            1,
            1,
            0,
            0,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel1 = $this->_insertChannel($aData);
        $aData = array(
            2,
            1,
            0,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel2 = $this->_insertChannel($aData);
        $aData = array(
            3,
            2,
            0,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel3 = $this->_insertChannel($aData);
        $aData = array(
            4,
            1,
            2,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel4 = $this->_insertChannel($aData);
        $aData = array(
            5,
            1,
            0,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel5 = $this->_insertChannel($aData);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 2);
        $this->assertEqual($aResult[1], 5);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllActiveChannelIdsByAgencyPublisherId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with an inactive channel in the database, and ensure nothing
     *         returned
     * Test 4: Test with an active channel in the database, and ensure it is
     *         returned
     * Test 5: Test with multiple active and inactive channels in the database,
     *         and ensure the correct values are returned
     */
    function testGetAllActiveChannelIdsByAgencyPublisherId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId('foo', 1);
        $this->assertNull($aResult);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 'foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            1,
            1,
            1,
            0,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel1 = $this->_insertChannel($aData);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            1,
            1,
            1,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel1 = $this->_insertChannel($aData);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            1,
            1,
            1,
            0,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel1 = $this->_insertChannel($aData);
        $aData = array(
            2,
            1,
            1,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel2 = $this->_insertChannel($aData);
        $aData = array(
            3,
            2,
            1,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel3 = $this->_insertChannel($aData);
        $aData = array(
            4,
            1,
            2,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel4 = $this->_insertChannel($aData);
        $aData = array(
            5,
            1,
            1,
            1,
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idChannel5 = $this->_insertChannel($aData);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 2);
        $this->assertEqual($aResult[1], 5);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getDeliveryLimitationsByChannelId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with delivery limitations attached to channel NOT desired, and
     *         ensure nothing returned
     * Test 4: Test with delivery limitations attached to the channel desired, and
     *         ensure they are returned
     */
    function testGetDeliveryLimitationsByChannelId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $channelId = 'foo';
        $aResult = $oDal->getDeliveryLimitationsByChannelId($channelId);
        $this->assertNull($aResult);

        // Test 2
        $channelId = 1;
        $aResult = $oDal->getDeliveryLimitationsByChannelId($channelId);
        $this->assertNull($aResult);

        // Test 3
        $aData = array(
            2,
            'and',
            'Time:Hour',
            '==',
            12,
            0
        );
        $idAclsChannel1 = $this->_insertAclsChannel($aData);
        $aResult = $oDal->getDeliveryLimitationsByChannelId(1);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            1,
            'and',
            'Time:Hour',
            '==',
            10,
            0
        );
        $idAclsChannel1 = $this->_insertAclsChannel($aData);
        $aData = array(
            1,
            'or',
            'Time:Hour',
            '==',
            11,
            1
        );
        $idAclsChannel2 = $this->_insertAclsChannel($aData);
        $aData = array(
            2,
            'and',
            'Time:Hour',
            '==',
            12,
            0
        );
        $idAclsChannel3 = $this->_insertAclsChannel($aData);
        $aResult = $oDal->getDeliveryLimitationsByChannelId(1);
        $aExpectedResult = array(
            0 => array(
                'logical'    => 'and',
                'type'       => 'Time:Hour',
                'comparison' => '==',
                'data'       => 10
            ),
            1 => array(
                'logical'    => 'or',
                'type'       => 'Time:Hour',
                'comparison' => '==',
                'data'       => 11
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllActivePlacementsByAdIdsPeriod() method.
     *
     * Requirements:
     * Test 1:  Test with invalid input, and ensure nothing returned
     * Test 2:  Test with nothing in the database, and ensure nothing returned
     * Test 3:  Test with an inactive placement that will not activate, and
     *          ensure nothing returned
     * Test 4:  Test with an active placement that will expire, and ensure
     *          nothing returned
     * Test 5:  Test with an active placement that will not expire, and ensure
     *          that it is returned
     * Test 6:  Test with an active placement that will expire after the
     *          period, and ensure that it is returned
     * Test 7:  Test with an active placement that will expire during the
     *          period, and ensure that it is returned
     * Test 8:  Test with an inactive placement that will activate before
     *          the period, and ensure that it is returned
     * Test 9:  Test with an inactive placement that will activate during
     *          the period, and ensure that it is returned
     * Test 10: Test with an inactive placement that will activate after
     *          the period, and ensure nothing returned
     * Test 11: Test with an inactive placement that will activate during
     *          the period, where multiple ads are linked, and ensure that
     *          it is returned once
     */
    function testGetAllActivePlacementsByAdIdsPeriod()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aAdIds = 'foo';
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);

        $aAdIds = array(1, 'foo', 2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);

        $aAdIds = array(1, 2);
        $aPeriod = array(
            'start' => 'foo',
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);

        $aAdIds = array(1, 2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => 'foo'
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 2
        $aAdIds = array(1, 2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aData = array(
            'active'=>'f',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aAdIds = array($idBanner1);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            'active'=>'t',
            'expire'=>'2006-10-22',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner1);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner1);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => OA_Dal::noDateValue(),
                'placement_end'             => OA_Dal::noDateValue(),
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 6
        $aData = array(
            'active'=>'t',
            'expire'=>'2006-10-28',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner1);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => OA_Dal::noDateValue(),
                'placement_end'             => '2006-10-28',
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 7
        $aData = array(
            'active'=>'t',
            'expire'=>'2006-10-27',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => OA_Dal::noDateValue(),
                'placement_end'             => '2006-10-27',
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        $aData = array(
            'active'=>'t',
            'expire'=>'2006-10-25',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => OA_Dal::noDateValue(),
                'placement_end'             => '2006-10-25',
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        $aData = array(
            'active'=>'t',
            'expire'=>'2006-10-23',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => OA_Dal::noDateValue(),
                'placement_end'             => '2006-10-23',
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 8
        $aData = array(
            'active'=>'f',
            'activate'=>'2006-10-22',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-22',
                'placement_end'             => OA_Dal::noDateValue(),
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 9
        $aData = array(
            'active'=>'f',
            'activate'=>'2006-10-23',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>$idCampaign1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-23',
                'placement_end'             => OA_Dal::noDateValue(),
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        $aData = array(
            'active'=>'f',
            'activate'=>'2006-10-25',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-25',
                'placement_end'             => OA_Dal::noDateValue(),
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        $aData = array(
            'active'=>'f',
            'activate'=>'2006-10-27',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-27',
                'placement_end'             => OA_Dal::noDateValue(),
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 10
        $aData = array(
            'active'=>'f',
            'activate'=>'2006-10-28',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>1,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 11
        $aData = array(
            'active'=>'f',
            'activate'=>'2006-10-23',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'campaignid'=>1,
            'active'=>'f',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>1,
            'active'=>'f',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner3 = $this->_insertBanner($aData);
        $aAdIds = array($idBanner1, $idBanner2, $idBanner3, 4);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => $idCampaign1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-23',
                'placement_end'             => OA_Dal::noDateValue(),
                'priority'                  => -1,
                'impression_target_total'   => -1,
                'click_target_total'        => -1,
                'conversion_target_total'   => -1,
                'impression_target_daily'   => -1,
                'click_target_daily'        => -1,
                'conversion_target_daily'   => -1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllPublisherIdsByAgencyId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with a publisher in the database, and ensure the
     *         correct value is returned
     * Test 4: Test with multiple publishers in the database, and ensure the
     *         correct values are returned
     */
    function testGetAllPublisherIdsByAgencyId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllPublisherIdsByAgencyId('foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllPublisherIdsByAgencyId(1);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAffiliate1 = $this->_insertAffiliate($aData);

        $aResult = $oDal->getAllPublisherIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAffiliate1 = $this->_insertAffiliate($aData);
        $aData = array(
            2,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAffiliate2 = $this->_insertAffiliate($aData);
        $aData = array(
            3,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idAffiliate3 = $this->_insertAffiliate($aData);
        $aResult = $oDal->getAllPublisherIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 1);
        $this->assertEqual($aResult[1], 3);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getZonesByZoneIds() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with a zone in the database, and ensure the
     *         correct value is returned
     */
    function testGetZonesByZoneIds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getZonesByZoneIds('foo');
        $this->assertNull($aResult);

        $aZoneIds = array(1, 2, 'foo', 3);
        $aResult = $oDal->getZonesByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        // Test 2
        $aZoneIds = array(1);
        $aResult = $oDal->getZonesByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        // Test 3
//        $oNow = new Date();
//        $updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        $this->doZones->affiliateid = 2;
        $this->doZones->zonename = 'Test';
        $this->doZones->description = 'Test Zone';
        $this->doZones->delivery = 3;
        $this->doZones->zonetype = 4;
        $this->doZones->category = 'Category';
        $this->doZones->width = 5;
        $this->doZones->height = 6;
        $this->doZones->ad_selection = 'Selection';
        $this->doZones->chain = 'Chain';
        $this->doZones->prepend = 'Prepend';
        $this->doZones->append = 'Append';
        $this->doZones->appendtype = 7;
        $this->doZones->forceappend = 't';
        $this->doZones->inventory_forecast_type = 8;
        $this->doZones->comments = 'Comments';
        $this->doZones->cost = 9.1;
        $this->doZones->cost_type = 10;
        $this->doZones->cost_variable_id = 11;
        $this->doZones->technology_cost = 12.1;
        $this->doZones->technology_cost_type = 13;
//        $this->doZones->updated = $updated;
        $this->doZones->block = 14;
        $this->doZones->capping = 15;
        $this->doZones->session_capping = 16;
        $idZone1 =  DataGenerator::generateOne($this->doZones);


        $aZoneIds = array($idZone1, 3);
        $aResult = $oDal->getZonesByZoneIds($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$idZone1]['zone_id'], 1);
        $this->assertEqual($aResult[$idZone1]['publisher_id'], 2);
        $this->assertEqual($aResult[$idZone1]['zonename'], 'Test');
        $this->assertEqual($aResult[$idZone1]['description'], 'Test Zone');
        $this->assertEqual($aResult[$idZone1]['delivery'], 3);
        $this->assertEqual($aResult[$idZone1]['zonetype'], 4);
        $this->assertEqual($aResult[$idZone1]['category'], 'Category');
        $this->assertEqual($aResult[$idZone1]['width'], 5);
        $this->assertEqual($aResult[$idZone1]['height'], 6);
        $this->assertEqual($aResult[$idZone1]['ad_selection'], 'Selection');
        $this->assertEqual($aResult[$idZone1]['chain'], 'Chain');
        $this->assertEqual($aResult[$idZone1]['prepend'], 'Prepend');
        $this->assertEqual($aResult[$idZone1]['append'], 'Append');
        $this->assertEqual($aResult[$idZone1]['appendtype'], 7);
        $this->assertEqual($aResult[$idZone1]['forceappend'], 't');
        $this->assertEqual($aResult[$idZone1]['inventory_forecast_type'], 8);
        $this->assertEqual($aResult[$idZone1]['comments'], 'Comments');
        $this->assertEqual($aResult[$idZone1]['cost'], 9.1);
        $this->assertEqual($aResult[$idZone1]['cost_type'], 10);
        $this->assertEqual($aResult[$idZone1]['cost_variable_id'], 11);
        $this->assertEqual($aResult[$idZone1]['technology_cost'], 12.1);
        $this->assertEqual($aResult[$idZone1]['technology_cost_type'], 13);
//        $this->assertEqual($aResult[$idZone1]['updated'], $updated);
        $this->assertEqual($aResult[$idZone1]['block'], 14);
        $this->assertEqual($aResult[$idZone1]['capping'], 15);
        $this->assertEqual($aResult[$idZone1]['session_capping'], 16);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllZonesIdsByPublisherId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with a zone in the database, and ensure the
     *         correct value is returned
     * Test 4: Test with multiple zones in the database, and ensure the
     *         correct values are returned
     */
    function testGetAllZonesIdsByPublisherId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllZonesIdsByPublisherId('foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllZonesIdsByPublisherId(1);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            'affiliateid'=>1,
            'category'=>1,
            'inventory_forecast_type'=>'',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone1 = $this->_insertZone($aData);
        $aResult = $oDal->getAllZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            'affiliateid'=>1,
            'category'=>1,
            'inventory_forecast_type'=>'',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone1 = $this->_insertZone($aData);
        $aData = array(
            'affiliateid'=>2,
            'category'=>2,
            'inventory_forecast_type'=>'',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone2 = $this->_insertZone($aData);
        $aData = array(
            'affiliateid'=>1,
            'category'=>1,
            'inventory_forecast_type'=>'',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone3 = $this->_insertZone($aData);
        $aResult = $oDal->getAllZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 1);
        $this->assertEqual($aResult[1], 3);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getAllChannelForecastZonesIdsByPublisherId() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with a non-forecast zone in the database, and ensure
     *         nothing is returned
     * Test 4: Test with a zone in the database, and ensure the
     *         correct value is returned
     * Test 5: Test with multiple zones in the database, and ensure the
     *         correct values are returned
     */
    function testGetAllChannelForecastZonesIdsByPublisherId()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId('foo');
        $this->assertNull($aResult);


        // Test 2
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertNull($aResult);

        // Test 3
        $oNow = new Date();
        $aData = array(
            'affiliateid'=>1,
            'category'=>1,
            'inventory_forecast_type'=>0,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone1 = $this->_insertZone($aData);
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertNull($aResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            'affiliateid'=>1,
            'category'=>1,
            'inventory_forecast_type'=>8,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone1 = $this->_insertZone($aData);
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        DataGenerator::cleanUp();


        // Test 5
        $aData = array(
            'affiliateid'=>1,
            'inventory_forecast_type'=>10,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone3 = $this->_insertZone($aData);
        $aData = array(
            'affiliateid'=>2,
            'inventory_forecast_type'=>8,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone4 = $this->_insertZone($aData);
        $aData = array(
            'affiliateid'=>1,
            'inventory_forecast_type'=>12,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone5 = $this->_insertZone($aData);
        $aData = array(
            'affiliateid'=>1,
            'inventory_forecast_type'=>4,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idZone5 = $this->_insertZone($aData);
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 1);
        $this->assertEqual($aResult[1], 3);
        DataGenerator::cleanUp();

    }

    /**
     * A method to test the getLinkedZonesIdsByAdIds() method.
     *
     * Requirements:
     * Test 1: Test with invalid input, and ensure nothing returned
     * Test 2: Test with nothing in the database, and ensure nothing returned
     * Test 3: Test with single ad/zone link, and ensure it is returned
     * Test 4: Test with multiple ad/zone links, and ensure they are returned
     */
    function testGetLinkedZonesIdsByAdIds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aAdIds = 'foo';
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aAdIds);
        $this->assertNull($aResult);

        $aAdIds = array(1, 2, 'foo', 3);
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aAdIds);
        $this->assertNull($aResult);

        // Test 2
        $aAdIds = array(1);
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aAdIds);
        $this->assertNull($aResult);

        // Test 3
        $aData = array(
            'zone_id'=>1,
            'ad_id'=>1,
            'link_type'=>1
        );
        $idAdZone1 = $this->_insertAdZoneAssoc($aData);
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aZoneIds);
        $aExpectedResult = array(1 => array(1));
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();


        // Test 4
        $aData = array(
            'ad_id'=>1,
            'zone_id'=>1,
            'link_type'=>1
        );
        $idAdZone1 = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'ad_id'=>1,
            'zone_id'=>2,
            'link_type'=>1
        );
        $idAdZone2 = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'ad_id'=>1,
            'zone_id'=>3,
            'link_type'=>0
        );
        $idAdZone3 = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'ad_id'=>2,
            'zone_id'=>3,
            'link_type'=>1
        );
        $idAdZone4 = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'ad_id'=>2,
            'zone_id'=>4,
            'link_type'=>1
        );
        $idAdZone5 = $this->_insertAdZoneAssoc($aData);
        $aData = array(
            'ad_id'=>2,
            'zone_id'=>5,
            'link_type'=>1
        );
        $idAdZone6 = $this->_insertAdZoneAssoc($aData);
        $aZoneIds = array(1, 2);
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aZoneIds);
        $aExpectedResult = array(
            1 => array(1, 2),
            2 => array(3, 4, 5)
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

    }

}

?>
