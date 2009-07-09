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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Campaigns methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_CampaignsTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_CampaignsTest()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testInsert()
    {
        $numTrackers = 2;
        $clientId = 7;

        // Prepare test data
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->acls_updated = '2007-04-03 19:29:54';
        $channelId = DataGenerator::generateOne($doChannel, true);

        // Test non empty connection wondows
        $GLOBALS['_MAX']['CONF']['logging']['defaultImpressionConnectionWindow'] = 1000;
        $GLOBALS['_MAX']['CONF']['logging']['defaultClickConnectionWindow']      = 2000;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $campaignId = DataGenerator::generateOne($doCampaigns);
        $this->assertNotEmpty($campaignId);
        $this->assertEqual($doCampaigns->viewwindow, 1000);
        $this->assertEqual($doCampaigns->clickwindow, 2000);
        $GLOBALS['_MAX']['CONF']['logging']['defaultImpressionConnectionWindow'] = '';
        $GLOBALS['_MAX']['CONF']['logging']['defaultClickConnectionWindow']      = '';

        // Add trackers
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->clientid = $clientId;
        $doTrackers->linkcampaigns = 't';
        $aTrackerId = DataGenerator::generate($doTrackers, $numTrackers, false);

        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->linkcampaigns = 'f';
        DataGenerator::generateOne($doTrackers); // redundant one

        // Test that inserting new campaigns triggers to insert new campaigns_trackers (if exists)
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $campaignId = DataGenerator::generateOne($doCampaigns);
        $this->assertNotEmpty($campaignId);

        // Test that two campaign_trackers were inserted as well
        $doCampaigns_trackers = OA_Dal::factoryDO('campaigns_trackers');
        $doCampaigns_trackers->campaignid = $campaignId;
        $this->assertEqual($doCampaigns_trackers->count(), $numTrackers);

        // Delete any data which wasn't created by DataGenerator
        DataGenerator::cleanUp(array('campaigns', 'campaigns_trackers','trackers'));
    }

    function testUpdateExpire()
    {
        $ndv = OX_DATAOBJECT_NULL;

        $expire = '2020-01-01';

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->expire_time = $expire_time;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $campaignId;
        $doCampaigns->expire_time = $ndv;
        $doCampaigns->update();

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertNull($doCampaigns->expire_time);

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->get($campaignId);
        $doCampaigns->expire_time = $ndv;
        $doCampaigns->update();

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertNull($doCampaigns->expire_time);
    }

    function testGetStatus()
    {
        $ndv = OX_DATAOBJECT_NULL;

        $past   = date('Y-m-d', time() - 200000);
        $future = date('Y-m-d', time() + 200000);

        $aInsertTests = array(
            0  => array(0,  null,                       null,       null,       OA_ENTITY_STATUS_RUNNING),
            1  => array(0,  OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_RUNNING),
            2  => array(0,  OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_RUNNING),
            3  => array(0,  OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_RUNNING),
            4  => array(0,  OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_PAUSED),
            5  => array(0,  null,                       $past,      null,       OA_ENTITY_STATUS_RUNNING),
            6  => array(0,  null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING),
            7  => array(0,  OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
            8  => array(0,  OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
            9  => array(0,  OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_RUNNING),
            10 => array(0,  OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING),
            11 => array(0,  OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
            12 => array(0,  OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
            13 => array(0,  OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED),
            14 => array(0,  OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING),
            15 => array(0,  null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED),
            16 => array(0,  null,                       null,       $future,    OA_ENTITY_STATUS_RUNNING),
            17 => array(0,  OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
            18 => array(0,  OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
            19 => array(0,  OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED),
            20 => array(0,  OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_RUNNING),
            21 => array(0,  OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
            22 => array(0,  OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
            23 => array(0,  OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED),
            24 => array(0,  OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED),
            25 => array(0,  null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
            26 => array(0,  null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING),
            27 => array(0,  OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
            28 => array(0,  OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
            29 => array(0,  OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
            30 => array(0,  OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING),
            31 => array(0,  OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
            32 => array(0,  OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
            33 => array(0,  OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
            34 => array(0,  OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING),
            35 => array(0,  null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING),
            36 => array(0,  null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            37 => array(0,  OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
            38 => array(0,  OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            39 => array(0,  OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING),
            40 => array(0,  OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            41 => array(0,  OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
            42 => array(0,  OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            43 => array(0,  OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED),
            44 => array(0,  OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
        );

        foreach ($aInsertTests as $testKey => $aTest) {
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            if (isset($aTest[1])) {
                $doCampaigns->status   = $aTest[1];
            }
            if (isset($aTest[2])) {
                $doCampaigns->activate_time = $aTest[2];
            }
            if (isset($aTest[3])) {
                $doCampaigns->expire_time   = $aTest[3];
            }
            $campaignId  = DataGenerator::generateOne($doCampaigns);
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
            $this->assertEqual($doCampaigns->status, $aTest[4], "Insert test {$testKey} failed, expected {$aTest[4]}, got $doCampaigns->status");

            // Store ID for update tests
            $aInsertTests[$testKey][0] = $campaignId;
        }

        $aUpdateTests = array(
            0 => array(
                0  => array(null,                       null,       null,       OA_ENTITY_STATUS_RUNNING),
                1  => array(OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_RUNNING),
                2  => array(OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_RUNNING),
                3  => array(OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_RUNNING),
                4  => array(OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_PAUSED),
                5  => array(null,                       $past,      null,       OA_ENTITY_STATUS_RUNNING),
                6  => array(null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING),
                7  => array(OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
                8  => array(OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
                9  => array(OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_RUNNING),
                10 => array(OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING),
                11 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
                12 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
                13 => array(OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED),
                14 => array(OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING),
                15 => array(null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                16 => array(null,                       null,       $future,    OA_ENTITY_STATUS_RUNNING),
                17 => array(OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                18 => array(OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
                19 => array(OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                20 => array(OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_RUNNING),
                21 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                22 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
                23 => array(OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                24 => array(OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED),
                25 => array(null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                26 => array(null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                27 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                28 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                29 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                30 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                31 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                32 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                33 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                34 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                35 => array(null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                36 => array(null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                37 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                38 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                39 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                40 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                41 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                42 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                43 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                44 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            ),

            // Paused banner
            4 => array(
                0  => array(null,                       null,       null,       OA_ENTITY_STATUS_PAUSED),
                1  => array(OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_RUNNING),
                2  => array(OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_PAUSED),
                3  => array(OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_PAUSED),
                4  => array(OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_PAUSED),
                5  => array(null,                       $past,      null,       OA_ENTITY_STATUS_PAUSED),
                6  => array(null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING),
                7  => array(OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
                8  => array(OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
                9  => array(OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_PAUSED),
                10 => array(OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING),
                11 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_PAUSED),
                12 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
                13 => array(OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED),
                14 => array(OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING),
                15 => array(null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                16 => array(null,                       null,       $future,    OA_ENTITY_STATUS_PAUSED),
                17 => array(OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                18 => array(OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
                19 => array(OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                20 => array(OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_PAUSED),
                21 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                22 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_PAUSED),
                23 => array(OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                24 => array(OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED),
                25 => array(null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                26 => array(null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                27 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                28 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                29 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                30 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                31 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                32 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                33 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                34 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                35 => array(null,                       $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                36 => array(null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                37 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                38 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                39 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                40 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                41 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                42 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                43 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                44 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            ),

            // Awaiting banner - Don't reset activation
            8 => array(
                0  => array(null,                       null,       null,       OA_ENTITY_STATUS_AWAITING),
                1  => array(OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_AWAITING),
                2  => array(OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_AWAITING),
                3  => array(OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_AWAITING),
                4  => array(OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_AWAITING),
                5  => array(null,                       $past,      null,       OA_ENTITY_STATUS_RUNNING),
                6  => array(null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING),
                7  => array(OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
                8  => array(OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
                9  => array(OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_RUNNING),
                10 => array(OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING),
                11 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_RUNNING),
                12 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING),
                13 => array(OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED),
                14 => array(OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING),
                15 => array(null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                16 => array(null,                       null,       $future,    OA_ENTITY_STATUS_AWAITING),
                17 => array(OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                18 => array(OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_AWAITING),
                19 => array(OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                20 => array(OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_AWAITING),
                21 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                22 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_AWAITING),
                23 => array(OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                24 => array(OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_AWAITING),
                25 => array(null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                26 => array(null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                27 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                28 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                29 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                30 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                31 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                32 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                33 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                34 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                35 => array(null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                36 => array(null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                37 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                38 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                39 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                40 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                41 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                42 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                43 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                44 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            ),

            // Awaiting banner - Reset activation
            10 => array(
                0  => array(null,                       $ndv,       null,       OA_ENTITY_STATUS_RUNNING),
                1  => array(OA_ENTITY_STATUS_RUNNING,   $ndv,       null,       OA_ENTITY_STATUS_RUNNING),
                2  => array(OA_ENTITY_STATUS_AWAITING,  $ndv,       null,       OA_ENTITY_STATUS_RUNNING),
                3  => array(OA_ENTITY_STATUS_EXPIRED,   $ndv,       null,       OA_ENTITY_STATUS_RUNNING),
                4  => array(OA_ENTITY_STATUS_PAUSED,    $ndv,       null,       OA_ENTITY_STATUS_PAUSED),
                16 => array(null,                       $ndv,       $future,    OA_ENTITY_STATUS_RUNNING),
                17 => array(OA_ENTITY_STATUS_RUNNING,   $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED),
                18 => array(OA_ENTITY_STATUS_RUNNING,   $ndv,       $future,    OA_ENTITY_STATUS_RUNNING),
                19 => array(OA_ENTITY_STATUS_AWAITING,  $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED),
                20 => array(OA_ENTITY_STATUS_AWAITING,  $ndv,       $future,    OA_ENTITY_STATUS_RUNNING),
                21 => array(OA_ENTITY_STATUS_EXPIRED,   $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED),
                22 => array(OA_ENTITY_STATUS_EXPIRED,   $ndv,       $future,    OA_ENTITY_STATUS_RUNNING),
                23 => array(OA_ENTITY_STATUS_PAUSED,    $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED),
                24 => array(OA_ENTITY_STATUS_PAUSED,    $ndv,       $future,    OA_ENTITY_STATUS_PAUSED),
            ),

            // Expired banner - Don't reset expiry
            17 => array(
                0  => array(null,                       null,       null,       OA_ENTITY_STATUS_EXPIRED),
                1  => array(OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_EXPIRED),
                2  => array(OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_EXPIRED),
                3  => array(OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_EXPIRED),
                4  => array(OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_EXPIRED),
                5  => array(null,                       $past,      null,       OA_ENTITY_STATUS_EXPIRED),
                6  => array(null,                       $future,    null,       OA_ENTITY_STATUS_EXPIRED),
                7  => array(OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_EXPIRED),
                8  => array(OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_EXPIRED),
                9  => array(OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_EXPIRED),
                10 => array(OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_EXPIRED),
                11 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_EXPIRED),
                12 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_EXPIRED),
                13 => array(OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_EXPIRED),
                14 => array(OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_EXPIRED),
                15 => array(null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                16 => array(null,                       null,       $future,    OA_ENTITY_STATUS_RUNNING),
                17 => array(OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                18 => array(OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
                19 => array(OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                20 => array(OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_RUNNING),
                21 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                22 => array(OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_RUNNING),
                23 => array(OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED),
                24 => array(OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED),
                25 => array(null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                26 => array(null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                27 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                28 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                29 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                30 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                31 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                32 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                33 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED),
                34 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING),
                35 => array(null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                36 => array(null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                37 => array(OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                38 => array(OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                39 => array(OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                40 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                41 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING),
                42 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
                43 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED),
                44 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED), // Shouldn't never happen
            ),

            // Expired banner - Reset expiry
            19 => array(
                0  => array(null,                       null,       $ndv,       OA_ENTITY_STATUS_RUNNING),
                1  => array(OA_ENTITY_STATUS_RUNNING,   null,       $ndv,       OA_ENTITY_STATUS_RUNNING),
                2  => array(OA_ENTITY_STATUS_AWAITING,  null,       $ndv,       OA_ENTITY_STATUS_RUNNING),
                3  => array(OA_ENTITY_STATUS_EXPIRED,   null,       $ndv,       OA_ENTITY_STATUS_RUNNING),
                4  => array(OA_ENTITY_STATUS_PAUSED,    null,       $ndv,       OA_ENTITY_STATUS_PAUSED),
                5  => array(null,                       $past,      $ndv,       OA_ENTITY_STATUS_RUNNING),
                6  => array(null,                       $future,    $ndv,       OA_ENTITY_STATUS_AWAITING),
                7  => array(OA_ENTITY_STATUS_RUNNING,   $past,      $ndv,       OA_ENTITY_STATUS_RUNNING),
                8  => array(OA_ENTITY_STATUS_RUNNING,   $future,    $ndv,       OA_ENTITY_STATUS_AWAITING),
                9  => array(OA_ENTITY_STATUS_AWAITING,  $past,      $ndv,       OA_ENTITY_STATUS_RUNNING),
                10 => array(OA_ENTITY_STATUS_AWAITING,  $future,    $ndv,       OA_ENTITY_STATUS_AWAITING),
                11 => array(OA_ENTITY_STATUS_EXPIRED,   $past,      $ndv,       OA_ENTITY_STATUS_RUNNING),
                12 => array(OA_ENTITY_STATUS_EXPIRED,   $future,    $ndv,       OA_ENTITY_STATUS_AWAITING),
                13 => array(OA_ENTITY_STATUS_PAUSED,    $past,      $ndv,       OA_ENTITY_STATUS_PAUSED),
                14 => array(OA_ENTITY_STATUS_PAUSED,    $future,    $ndv,       OA_ENTITY_STATUS_AWAITING),
            ),

        );

        foreach ($aUpdateTests as $srcId => $aSuite) {
            foreach ($aSuite as $testKey => $aTest) {
                $doCampaigns = OA_Dal::staticGetDO('campaigns', $aInsertTests[$srcId][0]);
                $campaignId  = DataGenerator::generateOne($doCampaigns);
                $doCampaigns = OA_Dal::factoryDO('campaigns');
                $doCampaigns->campaignid = $campaignId;
                if (isset($aTest[0])) {
                    $doCampaigns->status   = $aTest[0];
                }
                if (isset($aTest[1])) {
                    $doCampaigns->activate_time = $aTest[1];
                }
                if (isset($aTest[2])) {
                    $doCampaigns->expire_time   = $aTest[2];
                }
                $doCampaigns->update();
                $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
                $this->assertEqual($doCampaigns->status, $aTest[3], "Update test {$srcId}/{$testKey} failed, expected {$aTest[3]}, got $doCampaigns->status");
            }
        }
    }

    function testSetStatus2()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $campaignId  = DataGenerator::generateOne($doCampaigns);
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);

        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doCampaigns->weight = 0;
        $doCampaigns->update();

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_INACTIVE);

        $doCampaigns->weight = 1;
        $doCampaigns->update();

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);
    }

    function testSetStatus3()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $campaignId  = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $bannerId  = DataGenerator::generateOne($doBanners);

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doDia = OA_Dal::factoryDO('data_intermediate_ad');
        $doDia->date_time             = '2008-01-01';
        $doDia->operation_interval    = 1;
        $doDia->operation_interval_id = 1;
        $doDia->interval_start        = '2008-01-01';
        $doDia->interval_end          = '2008-01-01';
        $doDia->ad_id       = $bannerId;
        $doDia->zone_id     = 0;
        $doDia->creative_id = 0;
        $doDia->impressions = 100;
        $this->assertTrue($doDia->insert());

        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doCampaigns->views = 10;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_EXPIRED);

        $doDia = OA_Dal::factoryDO('data_intermediate_ad');
        $doDia->date_time             = '2008-01-01';
        $doDia->operation_interval    = 1;
        $doDia->operation_interval_id = 1;
        $doDia->interval_start        = '2008-01-01';
        $doDia->interval_end          = '2008-01-01';
        $doDia->ad_id       = $bannerId;
        $doDia->zone_id     = 0;
        $doDia->creative_id = 0;
        $doDia->impressions = 100;
        $doDia->clicks      = 100;
        $doDia->conversions = 100;
        $this->assertTrue($doDia->insert());

        $doCampaigns->views = 300;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doCampaigns->clicks = 100;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_EXPIRED);

        $doCampaigns->clicks      = -1;
        $doCampaigns->conversions = 200;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doCampaigns->conversions = 50;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_EXPIRED);
    }


    function testUpdateHighWithNoTargetSet()
    {
        //test for OX-3635
        $expire = '2020-01-01';

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->name = 'Some test campaign';
        $doCampaigns->expire_time = $expire;
        $doCampaigns->views  = -1;
        $doCampaigns->clicks = -1;
        $doCampaigns->conversions = -1;
        $doCampaigns->priority = 5;
        $doCampaigns->weight = 0;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        //get campaign and check if it's inactive (it should be since we have not
        //set target per day nor limit for high campaign
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_INACTIVE);

        $doCampaigns->views = 1000;
        $doCampaigns->update();

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);
    }


}

?>
