<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: MaintenanceCommon.dal.test.php 5662 2006-10-11 09:51:48Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Dal/Entities.php';
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

    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Entities()
    {
        $this->UnitTestCase();
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
        $table  = $conf['table']['prefix'] . $conf['table']['banners'];
        $dbh = MAX_DB::singleton();

        $oDal = new MAX_Dal_Entities();

        // Test 1
        $placementId = 'foo';
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $this->assertNull($aResult);

        // Test 2
        $placementId = 1;
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $this->assertNull($aResult);

        TestEnv::startTransaction();

        // Test 3
        $query = "
            INSERT INTO
                $table
                (
                    bannerid,
                    campaignid,
                    active,
                    storagetype,
                    weight
                )
            VALUES
                (
                    1,
                    1,
                    't',
                    'sql',
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $aExpectedResult = array(
            1 => array(
                'ad_id'  => 1,
                'active' => 't',
                'type'   => 'sql',
                'weight' => 1
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);

        // Test 4
        $query = "
            INSERT INTO
                $table
                (
                    bannerid,
                    campaignid,
                    active,
                    storagetype,
                    weight
                )
            VALUES
                (
                    2,
                    1,
                    'f',
                    'sql',
                    5
                ),
                (
                    3,
                    2,
                    't',
                    'sql',
                    2
                )";
        $dbh->query($query);
        $aResult = $oDal->getAdsByPlacementId($placementId);
        $aExpectedResult = array(
            1 => array(
                'ad_id'  => 1,
                'active' => 't',
                'type'   => 'sql',
                'weight' => 1
            ),
            2 => array(
                'ad_id'  => 2,
                'active' => 'f',
                'type'   => 'sql',
                'weight' => 5
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);

        TestEnv::rollbackTransaction();
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
        $adTable  = $conf['table']['prefix'] . $conf['table']['banners'];
        $azaTable = $conf['table']['prefix'] . $conf['table']['ad_zone_assoc'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    active
                )
            VALUES
                (
                    1,
                    'f'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $azaTable
                (
                    zone_id,
                    ad_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $azaTable
                (
                    zone_id,
                    ad_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $aExpectedResult = array(1 => array(1));
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                ),
                (
                    2,
                    'f'
                ),
                (
                    3,
                    't'
                ),
                (
                    4,
                    't'
                ),
                (
                    5,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $azaTable
                (
                    zone_id,
                    ad_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                ),
                (
                    1,
                    2,
                    1
                ),
                (
                    1,
                    3,
                    0
                ),
                (
                    2,
                    3,
                    1
                ),
                (
                    2,
                    4,
                    1
                ),
                (
                    2,
                    5,
                    1
                )";
        $dbh->query($query);
        $aZoneIds = array(1, 2);
        $aResult = $oDal->getLinkedActiveAdIdsByZoneIds($aZoneIds);
        $aExpectedResult = array(
            1 => array(1),
            2 => array(3, 4, 5)
        );
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::rollbackTransaction();
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
        $adTable = $conf['table']['prefix'] . $conf['table']['banners'];
        $dlTable = $conf['table']['prefix'] . $conf['table']['acls'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid,
                    active,
                    weight
                )
            VALUES
                (
                    2,
                    1,
                    'f',
                    1
                )";
        $dbh->query($query);
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid,
                    active,
                    weight
                )
            VALUES
                (
                    2,
                    1,
                    't',
                    1
                )";
        $dbh->query($query);
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $aExpectedResult = array(
            1 => array(
                2 => array(
                    'active' => 't',
                    'weight' => 1,
                    'deliveryLimitations' => array()
                )
            )
        );
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid,
                    active,
                    weight
                )
            VALUES
                (
                    2,
                    1,
                    't',
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $dlTable
                (
                    bannerid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (
                    2,
                    'and',
                    'Site:Channel',
                    '==',
                    12,
                    0
                )";
        $dbh->query($query);
        $aPlacmementIds = array(1);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $aExpectedResult = array(
            1 => array(
                2 => array(
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
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid,
                    active,
                    weight
                )
            VALUES
                (
                    2,
                    1,
                    'f',
                    1
                ),
                (
                    3,
                    1,
                    't',
                    1
                ),
                (
                    4,
                    8,
                    't',
                    1
                ),
                (
                    5,
                    7,
                    't',
                    10
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $dlTable
                (
                    bannerid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (
                    2,
                    'and',
                    'Site:Channel',
                    '==',
                    12,
                    0
                ),
                (
                    3,
                    'and',
                    'Site:Channel',
                    '!=',
                    12,
                    1
                ),
                (
                    3,
                    'and',
                    'Site:Channel',
                    '==',
                    15,
                    0
                ),
                (
                    5,
                    'and',
                    'Site:Channel',
                    '==',
                    10,
                    0
                )";
        $dbh->query($query);
        $aPlacmementIds = array(1, 7);
        $aResult = $oDal->getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacmementIds);
        $aExpectedResult = array(
            1 => array(
                3 => array(
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
                5 => array(
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
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['acls'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    bannerid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (
                    2,
                    'and',
                    'Site:Channel',
                    '==',
                    12,
                    0
                )";
        $dbh->query($query);
        $adId = 1;
        $aResult = $oDal->getDeliveryLimitationsByAdId($adId);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    bannerid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (
                    1,
                    'and',
                    'Site:Channel',
                    '==',
                    10,
                    0
                ),
                (
                    1,
                    'or',
                    'Site:Channel',
                    '==',
                    11,
                    1
                ),
                (
                    2,
                    'and',
                    'Site:Channel',
                    '==',
                    12,
                    0
                )";
        $dbh->query($query);
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
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['agency'];
        $dbh = MAX_DB::singleton();

        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertNull($aResult);

        // Test 2
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    agencyid,
                    active
                )
            VALUES
                (
                    1,
                    0
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    agencyid,
                    active
                )
            VALUES
                (
                    1,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    agencyid,
                    active
                )
            VALUES
                (
                    1,
                    0
                ),
                (
                    2,
                    1
                ),
                (
                    3,
                    0
                ),
                (
                    4,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveAgencyIds();
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 2);
        $this->assertEqual($aResult[1], 4);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['channel'];
        $dbh = MAX_DB::singleton();

        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId('foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertNull($aResult);

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    agencyid,
                    affiliateid,
                    active
                )
            VALUES
                (
                    1,
                    0,
                    0
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    active
                )
            VALUES
                (
                    1,
                    1,
                    0,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    active
                )
            VALUES
                (
                    1,
                    1,
                    0,
                    0
                ),
                (
                    2,
                    1,
                    0,
                    1
                ),
                (
                    3,
                    2,
                    0,
                    1
                ),
                (
                    4,
                    1,
                    2,
                    1
                ),
                (
                    5,
                    1,
                    0,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 2);
        $this->assertEqual($aResult[1], 5);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['channel'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    active
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    0
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    active
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    active
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    0
                ),
                (
                    2,
                    1,
                    1,
                    1
                ),
                (
                    3,
                    2,
                    1,
                    1
                ),
                (
                    4,
                    1,
                    2,
                    1
                ),
                (
                    5,
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllActiveChannelIdsByAgencyPublisherId(1, 1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 2);
        $this->assertEqual($aResult[1], 5);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['acls_channel'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (
                    2,
                    'and',
                    'Time:Hour',
                    '==',
                    12,
                    0
                )";
        $dbh->query($query);
        $channelId = 1;
        $aResult = $oDal->getDeliveryLimitationsByChannelId($channelId);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    channelid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (
                    1,
                    'and',
                    'Time:Hour',
                    '==',
                    10,
                    0
                ),
                (
                    1,
                    'or',
                    'Time:Hour',
                    '==',
                    11,
                    1
                ),
                (
                    2,
                    'and',
                    'Time:Hour',
                    '==',
                    12,
                    0
                )";
        $dbh->query($query);
        $channelId = 1;
        $aResult = $oDal->getDeliveryLimitationsByChannelId($channelId);
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
        TestEnv::rollbackTransaction();
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
        $adTable        = $conf['table']['prefix'] . $conf['table']['banners'];
        $placementTable = $conf['table']['prefix'] . $conf['table']['campaigns'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    1,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    active,
                    activate
                )
            VALUES
                (
                    1,
                    'f',
                    '0000-00-00'
                )";
        $dbh->query($query);
        $aAdIds = array(1);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    1,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    active,
                    expire
                )
            VALUES
                (
                    1,
                    't',
                    '2006-10-22'
                )";
        $dbh->query($query);
        $aAdIds = array(1);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    't',
                    1,
                    '0000-00-00',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => '0000-00-00',
                'placement_end'             => '0000-00-00',
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
        TestEnv::rollbackTransaction();

        // Test 6
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    't',
                    1,
                    '0000-00-00',
                    '2006-10-28',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => '0000-00-00',
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
        TestEnv::rollbackTransaction();

        // Test 7
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    't',
                    1,
                    '0000-00-00',
                    '2006-10-27',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => '0000-00-00',
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
        TestEnv::rollbackTransaction();
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    't',
                    1,
                    '0000-00-00',
                    '2006-10-25',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => '0000-00-00',
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
        TestEnv::rollbackTransaction();
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    't',
                    1,
                    '0000-00-00',
                    '2006-10-23',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 't',
                'weight'                    => 1,
                'placement_start'           => '0000-00-00',
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
        TestEnv::rollbackTransaction();

        // Test 8
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    'f',
                    1,
                    '2006-10-22',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-22',
                'placement_end'             => '0000-00-00',
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
        TestEnv::rollbackTransaction();

        // Test 9
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    'f',
                    1,
                    '2006-10-23',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-23',
                'placement_end'             => '0000-00-00',
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
        TestEnv::rollbackTransaction();
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    'f',
                    1,
                    '2006-10-25',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-25',
                'placement_end'             => '0000-00-00',
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
        TestEnv::rollbackTransaction();
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    'f',
                    1,
                    '2006-10-27',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-27',
                'placement_end'             => '0000-00-00',
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
        TestEnv::rollbackTransaction();

        // Test 10
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    'f',
                    1,
                    '2006-10-28',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(2);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 11
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid
                )
            VALUES
                (
                    2,
                    1
                ),
                (
                    3,
                    1
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                $placementTable
                (
                    campaignid,
                    campaignname,
                    active,
                    weight,
                    activate,
                    expire,
                    priority,
                    views,
                    clicks,
                    conversions,
                    target_impression,
                    target_click,
                    target_conversion
                )
            VALUES
                (
                    1,
                    'Test Placement',
                    'f',
                    1,
                    '2006-10-23',
                    '0000-00-00',
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1,
                    -1
                )";
        $dbh->query($query);
        $aAdIds = array(1, 2, 3, 4);
        $aPeriod = array(
            'start' => new Date('2006-10-23'),
            'end'   => new Date('2006-10-27')
        );
        $aResult = $oDal->getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod);
        $aExpectedResult = array(
            1 => array(
                'placement_id'              => 1,
                'placement_name'            => 'Test Placement',
                'active'                    => 'f',
                'weight'                    => 1,
                'placement_start'           => '2006-10-23',
                'placement_end'             => '0000-00-00',
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
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['affiliates'];
        $dbh = MAX_DB::singleton();

        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllPublisherIdsByAgencyId('foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllPublisherIdsByAgencyId(1);
        $this->assertNull($aResult);

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    affiliateid,
                    agencyid
                )
            VALUES
                (
                    1,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllPublisherIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    affiliateid,
                    agencyid
                )
            VALUES
                (
                    1,
                    1
                ),
                (
                    2,
                    2
                ),
                (
                    3,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllPublisherIdsByAgencyId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 1);
        $this->assertEqual($aResult[1], 3);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['zones'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    zoneid,
                    affiliateid,
                    zonename,
                    description,
                    delivery,
                    zonetype,
                    category,
                    width,
                    height,
                    ad_selection,
                    chain,
                    prepend,
                    append,
                    appendtype,
                    forceappend,
                    inventory_forecast_type,
                    comments,
                    cost,
                    cost_type,
                    cost_variable_id,
                    technology_cost,
                    technology_cost_type,
                    updated,
                    block,
                    capping,
                    session_capping
                )
            VALUES
                (
                    1,
                    2,
                    'Test',
                    'Test Zone',
                    3,
                    4,
                    'Category',
                    5,
                    6,
                    'Selection',
                    'Chain',
                    'Prepend',
                    'Append',
                    7,
                    't',
                    8,
                    'Comments',
                    9.1,
                    10,
                    11,
                    12.1,
                    13,
                    '2006-11-03 11:40:15',
                    14,
                    15,
                    16
                )";
        $dbh->query($query);
        $aZoneIds = array(1, 3);
        $aResult = $oDal->getZonesByZoneIds($aZoneIds);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1]['zone_id'], 1);
        $this->assertEqual($aResult[1]['publisher_id'], 2);
        $this->assertEqual($aResult[1]['zonename'], 'Test');
        $this->assertEqual($aResult[1]['description'], 'Test Zone');
        $this->assertEqual($aResult[1]['delivery'], 3);
        $this->assertEqual($aResult[1]['zonetype'], 4);
        $this->assertEqual($aResult[1]['category'], 'Category');
        $this->assertEqual($aResult[1]['width'], 5);
        $this->assertEqual($aResult[1]['height'], 6);
        $this->assertEqual($aResult[1]['ad_selection'], 'Selection');
        $this->assertEqual($aResult[1]['chain'], 'Chain');
        $this->assertEqual($aResult[1]['prepend'], 'Prepend');
        $this->assertEqual($aResult[1]['append'], 'Append');
        $this->assertEqual($aResult[1]['appendtype'], 7);
        $this->assertEqual($aResult[1]['forceappend'], 't');
        $this->assertEqual($aResult[1]['inventory_forecast_type'], 8);
        $this->assertEqual($aResult[1]['comments'], 'Comments');
        $this->assertEqual($aResult[1]['cost'], 9.1);
        $this->assertEqual($aResult[1]['cost_type'], 10);
        $this->assertEqual($aResult[1]['cost_variable_id'], 11);
        $this->assertEqual($aResult[1]['technology_cost'], 12.1);
        $this->assertEqual($aResult[1]['technology_cost_type'], 13);
        $this->assertEqual($aResult[1]['updated'], '2006-11-03 11:40:15');
        $this->assertEqual($aResult[1]['block'], 14);
        $this->assertEqual($aResult[1]['capping'], 15);
        $this->assertEqual($aResult[1]['session_capping'], 16);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['zones'];
        $dbh = MAX_DB::singleton();

        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllZonesIdsByPublisherId('foo');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDal->getAllZonesIdsByPublisherId(1);
        $this->assertNull($aResult);

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    zoneid,
                    affiliateid
                )
            VALUES
                (
                    1,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    zoneid,
                    affiliateid
                )
            VALUES
                (
                    1,
                    1
                ),
                (
                    2,
                    2
                ),
                (
                    3,
                    1
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 1);
        $this->assertEqual($aResult[1], 3);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['zones'];
        $dbh = MAX_DB::singleton();

        $oDal = new MAX_Dal_Entities();

        // Test 1
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId('foo');
        $this->assertNull($aResult);


        // Test 2
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertNull($aResult);

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    zoneid,
                    affiliateid,
                    inventory_forecast_type
                )
            VALUES
                (
                    1,
                    1,
                    0
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertNull($aResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    zoneid,
                    affiliateid,
                    inventory_forecast_type
                )
            VALUES
                (
                    1,
                    1,
                    8
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 1);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    zoneid,
                    affiliateid,
                    inventory_forecast_type
                )
            VALUES
                (
                    1,
                    1,
                    10
                ),
                (
                    2,
                    2,
                    8
                ),
                (
                    3,
                    1,
                    12
                ),
                (
                    4,
                    1,
                    4
                )";
        $dbh->query($query);
        $aResult = $oDal->getAllChannelForecastZonesIdsByPublisherId(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[0], 1);
        $this->assertEqual($aResult[1], 3);
        TestEnv::rollbackTransaction();
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
        $table = $conf['table']['prefix'] . $conf['table']['ad_zone_assoc'];
        $dbh = MAX_DB::singleton();

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
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    ad_id,
                    zone_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $aZoneIds = array(1);
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aZoneIds);
        $aExpectedResult = array(1 => array(1));
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                $table
                (
                    ad_id,
                    zone_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                ),
                (
                    1,
                    2,
                    1
                ),
                (
                    1,
                    3,
                    0
                ),
                (
                    2,
                    3,
                    1
                ),
                (
                    2,
                    4,
                    1
                ),
                (
                    2,
                    5,
                    1
                )";
        $dbh->query($query);
        $aZoneIds = array(1, 2);
        $aResult = $oDal->getLinkedZonesIdsByAdIds($aZoneIds);
        $aExpectedResult = array(
            1 => array(1, 2),
            2 => array(3, 4, 5)
        );
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::rollbackTransaction();
    }

}

?>
