<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
    public function tearDown()
    {
        DataGenerator::cleanUp();
    }

    public function testInsert()
    {
        $numTrackers = 2;
        $clientId = 7;

        // Prepare test data
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->acls_updated = '2007-04-03 19:29:54';
        $channelId = DataGenerator::generateOne($doChannel, true);

        // Test non empty connection wondows
        $GLOBALS['_MAX']['CONF']['logging']['defaultImpressionConnectionWindow'] = 1000;
        $GLOBALS['_MAX']['CONF']['logging']['defaultClickConnectionWindow'] = 2000;
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientId;
        $campaignId = DataGenerator::generateOne($doCampaigns);
        $this->assertNotEmpty($campaignId);
        $this->assertEqual($doCampaigns->viewwindow, 1000);
        $this->assertEqual($doCampaigns->clickwindow, 2000);
        $GLOBALS['_MAX']['CONF']['logging']['defaultImpressionConnectionWindow'] = '';
        $GLOBALS['_MAX']['CONF']['logging']['defaultClickConnectionWindow'] = '';

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
        DataGenerator::cleanUp(['campaigns', 'campaigns_trackers', 'trackers']);
    }

    public function testUpdateExpire()
    {
        $ndv = OX_DATAOBJECT_NULL;

        $expire = '2030-01-01';

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->expire_time = null;
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

    public function testGetStatus()
    {
        $ndv = OX_DATAOBJECT_NULL;

        $past = date('Y-m-d', time() - 200000);
        $future = date('Y-m-d', time() + 200000);

        $aInsertTests = [
            0 => [0,  null,                       null,       null,       OA_ENTITY_STATUS_RUNNING],
            1 => [0,  OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_RUNNING],
            2 => [0,  OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_RUNNING],
            3 => [0,  OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_RUNNING],
            4 => [0,  OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_PAUSED],
            5 => [0,  null,                       $past,      null,       OA_ENTITY_STATUS_RUNNING],
            6 => [0,  null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING],
            7 => [0,  OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
            8 => [0,  OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
            9 => [0,  OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_RUNNING],
            10 => [0,  OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING],
            11 => [0,  OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
            12 => [0,  OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
            13 => [0,  OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED],
            14 => [0,  OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING],
            15 => [0,  null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED],
            16 => [0,  null,                       null,       $future,    OA_ENTITY_STATUS_RUNNING],
            17 => [0,  OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
            18 => [0,  OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
            19 => [0,  OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED],
            20 => [0,  OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_RUNNING],
            21 => [0,  OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
            22 => [0,  OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
            23 => [0,  OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED],
            24 => [0,  OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED],
            25 => [0,  null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
            26 => [0,  null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING],
            27 => [0,  OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
            28 => [0,  OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
            29 => [0,  OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
            30 => [0,  OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING],
            31 => [0,  OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
            32 => [0,  OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
            33 => [0,  OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
            34 => [0,  OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING],
            35 => [0,  null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING],
            36 => [0,  null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            37 => [0,  OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
            38 => [0,  OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            39 => [0,  OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING],
            40 => [0,  OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            41 => [0,  OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
            42 => [0,  OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            43 => [0,  OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED],
            44 => [0,  OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
        ];

        foreach ($aInsertTests as $testKey => $aTest) {
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            if (isset($aTest[1])) {
                $doCampaigns->status = $aTest[1];
            }
            if (isset($aTest[2])) {
                $doCampaigns->activate_time = $aTest[2];
            }
            if (isset($aTest[3])) {
                $doCampaigns->expire_time = $aTest[3];
            }
            $campaignId = DataGenerator::generateOne($doCampaigns);
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
            $this->assertEqual($doCampaigns->status, $aTest[4], "Insert test {$testKey} failed, expected {$aTest[4]}, got $doCampaigns->status");

            // Store ID for update tests
            $aInsertTests[$testKey][0] = $campaignId;
        }

        $aUpdateTests = [
            0 => [
                0 => [null,                       null,       null,       OA_ENTITY_STATUS_RUNNING],
                1 => [OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_RUNNING],
                2 => [OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_RUNNING],
                3 => [OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_RUNNING],
                4 => [OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_PAUSED],
                5 => [null,                       $past,      null,       OA_ENTITY_STATUS_RUNNING],
                6 => [null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING],
                7 => [OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
                8 => [OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
                9 => [OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_RUNNING],
                10 => [OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING],
                11 => [OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
                12 => [OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
                13 => [OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED],
                14 => [OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING],
                15 => [null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                16 => [null,                       null,       $future,    OA_ENTITY_STATUS_RUNNING],
                17 => [OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                18 => [OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
                19 => [OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                20 => [OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_RUNNING],
                21 => [OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                22 => [OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
                23 => [OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                24 => [OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED],
                25 => [null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                26 => [null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                27 => [OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                28 => [OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                29 => [OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                30 => [OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                31 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                32 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                33 => [OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                34 => [OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                35 => [null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                36 => [null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                37 => [OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                38 => [OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                39 => [OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                40 => [OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                41 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                42 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                43 => [OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                44 => [OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            ],

            // Paused banner
            4 => [
                0 => [null,                       null,       null,       OA_ENTITY_STATUS_PAUSED],
                1 => [OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_RUNNING],
                2 => [OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_PAUSED],
                3 => [OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_PAUSED],
                4 => [OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_PAUSED],
                5 => [null,                       $past,      null,       OA_ENTITY_STATUS_PAUSED],
                6 => [null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING],
                7 => [OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
                8 => [OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
                9 => [OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_PAUSED],
                10 => [OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING],
                11 => [OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_PAUSED],
                12 => [OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
                13 => [OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED],
                14 => [OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING],
                15 => [null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                16 => [null,                       null,       $future,    OA_ENTITY_STATUS_PAUSED],
                17 => [OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                18 => [OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
                19 => [OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                20 => [OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_PAUSED],
                21 => [OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                22 => [OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_PAUSED],
                23 => [OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                24 => [OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED],
                25 => [null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                26 => [null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                27 => [OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                28 => [OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                29 => [OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                30 => [OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                31 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                32 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                33 => [OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                34 => [OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                35 => [null,                       $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                36 => [null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                37 => [OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                38 => [OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                39 => [OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                40 => [OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                41 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                42 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                43 => [OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                44 => [OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            ],

            // Awaiting banner - Don't reset activation
            8 => [
                0 => [null,                       null,       null,       OA_ENTITY_STATUS_AWAITING],
                1 => [OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_AWAITING],
                2 => [OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_AWAITING],
                3 => [OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_AWAITING],
                4 => [OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_AWAITING],
                5 => [null,                       $past,      null,       OA_ENTITY_STATUS_RUNNING],
                6 => [null,                       $future,    null,       OA_ENTITY_STATUS_AWAITING],
                7 => [OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
                8 => [OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
                9 => [OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_RUNNING],
                10 => [OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_AWAITING],
                11 => [OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_RUNNING],
                12 => [OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_AWAITING],
                13 => [OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_PAUSED],
                14 => [OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_AWAITING],
                15 => [null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                16 => [null,                       null,       $future,    OA_ENTITY_STATUS_AWAITING],
                17 => [OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                18 => [OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_AWAITING],
                19 => [OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                20 => [OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_AWAITING],
                21 => [OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                22 => [OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_AWAITING],
                23 => [OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                24 => [OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_AWAITING],
                25 => [null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                26 => [null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                27 => [OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                28 => [OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                29 => [OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                30 => [OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                31 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                32 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                33 => [OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                34 => [OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                35 => [null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                36 => [null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                37 => [OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                38 => [OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                39 => [OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                40 => [OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                41 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                42 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                43 => [OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                44 => [OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            ],

            // Awaiting banner - Reset activation
            10 => [
                0 => [null,                       $ndv,       null,       OA_ENTITY_STATUS_RUNNING],
                1 => [OA_ENTITY_STATUS_RUNNING,   $ndv,       null,       OA_ENTITY_STATUS_RUNNING],
                2 => [OA_ENTITY_STATUS_AWAITING,  $ndv,       null,       OA_ENTITY_STATUS_RUNNING],
                3 => [OA_ENTITY_STATUS_EXPIRED,   $ndv,       null,       OA_ENTITY_STATUS_RUNNING],
                4 => [OA_ENTITY_STATUS_PAUSED,    $ndv,       null,       OA_ENTITY_STATUS_PAUSED],
                16 => [null,                       $ndv,       $future,    OA_ENTITY_STATUS_RUNNING],
                17 => [OA_ENTITY_STATUS_RUNNING,   $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED],
                18 => [OA_ENTITY_STATUS_RUNNING,   $ndv,       $future,    OA_ENTITY_STATUS_RUNNING],
                19 => [OA_ENTITY_STATUS_AWAITING,  $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED],
                20 => [OA_ENTITY_STATUS_AWAITING,  $ndv,       $future,    OA_ENTITY_STATUS_RUNNING],
                21 => [OA_ENTITY_STATUS_EXPIRED,   $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED],
                22 => [OA_ENTITY_STATUS_EXPIRED,   $ndv,       $future,    OA_ENTITY_STATUS_RUNNING],
                23 => [OA_ENTITY_STATUS_PAUSED,    $ndv,       $past,      OA_ENTITY_STATUS_EXPIRED],
                24 => [OA_ENTITY_STATUS_PAUSED,    $ndv,       $future,    OA_ENTITY_STATUS_PAUSED],
            ],

            // Expired banner - Don't reset expiry
            17 => [
                0 => [null,                       null,       null,       OA_ENTITY_STATUS_EXPIRED],
                1 => [OA_ENTITY_STATUS_RUNNING,   null,       null,       OA_ENTITY_STATUS_EXPIRED],
                2 => [OA_ENTITY_STATUS_AWAITING,  null,       null,       OA_ENTITY_STATUS_EXPIRED],
                3 => [OA_ENTITY_STATUS_EXPIRED,   null,       null,       OA_ENTITY_STATUS_EXPIRED],
                4 => [OA_ENTITY_STATUS_PAUSED,    null,       null,       OA_ENTITY_STATUS_EXPIRED],
                5 => [null,                       $past,      null,       OA_ENTITY_STATUS_EXPIRED],
                6 => [null,                       $future,    null,       OA_ENTITY_STATUS_EXPIRED],
                7 => [OA_ENTITY_STATUS_RUNNING,   $past,      null,       OA_ENTITY_STATUS_EXPIRED],
                8 => [OA_ENTITY_STATUS_RUNNING,   $future,    null,       OA_ENTITY_STATUS_EXPIRED],
                9 => [OA_ENTITY_STATUS_AWAITING,  $past,      null,       OA_ENTITY_STATUS_EXPIRED],
                10 => [OA_ENTITY_STATUS_AWAITING,  $future,    null,       OA_ENTITY_STATUS_EXPIRED],
                11 => [OA_ENTITY_STATUS_EXPIRED,   $past,      null,       OA_ENTITY_STATUS_EXPIRED],
                12 => [OA_ENTITY_STATUS_EXPIRED,   $future,    null,       OA_ENTITY_STATUS_EXPIRED],
                13 => [OA_ENTITY_STATUS_PAUSED,    $past,      null,       OA_ENTITY_STATUS_EXPIRED],
                14 => [OA_ENTITY_STATUS_PAUSED,    $future,    null,       OA_ENTITY_STATUS_EXPIRED],
                15 => [null,                       null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                16 => [null,                       null,       $future,    OA_ENTITY_STATUS_RUNNING],
                17 => [OA_ENTITY_STATUS_RUNNING,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                18 => [OA_ENTITY_STATUS_RUNNING,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
                19 => [OA_ENTITY_STATUS_AWAITING,  null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                20 => [OA_ENTITY_STATUS_AWAITING,  null,       $future,    OA_ENTITY_STATUS_RUNNING],
                21 => [OA_ENTITY_STATUS_EXPIRED,   null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                22 => [OA_ENTITY_STATUS_EXPIRED,   null,       $future,    OA_ENTITY_STATUS_RUNNING],
                23 => [OA_ENTITY_STATUS_PAUSED,    null,       $past,      OA_ENTITY_STATUS_EXPIRED],
                24 => [OA_ENTITY_STATUS_PAUSED,    null,       $future,    OA_ENTITY_STATUS_PAUSED],
                25 => [null,                       $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                26 => [null,                       $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                27 => [OA_ENTITY_STATUS_RUNNING,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                28 => [OA_ENTITY_STATUS_RUNNING,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                29 => [OA_ENTITY_STATUS_AWAITING,  $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                30 => [OA_ENTITY_STATUS_AWAITING,  $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                31 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                32 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                33 => [OA_ENTITY_STATUS_PAUSED,    $past,      $past,      OA_ENTITY_STATUS_EXPIRED],
                34 => [OA_ENTITY_STATUS_PAUSED,    $future,    $future,    OA_ENTITY_STATUS_AWAITING],
                35 => [null,                       $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                36 => [null,                       $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                37 => [OA_ENTITY_STATUS_RUNNING,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                38 => [OA_ENTITY_STATUS_RUNNING,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                39 => [OA_ENTITY_STATUS_AWAITING,  $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                40 => [OA_ENTITY_STATUS_AWAITING,  $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                41 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $future,    OA_ENTITY_STATUS_RUNNING],
                42 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
                43 => [OA_ENTITY_STATUS_PAUSED,    $past,      $future,    OA_ENTITY_STATUS_PAUSED],
                44 => [OA_ENTITY_STATUS_PAUSED,    $future,    $past,      OA_ENTITY_STATUS_EXPIRED], // Shouldn't never happen
            ],

            // Expired banner - Reset expiry
            19 => [
                0 => [null,                       null,       $ndv,       OA_ENTITY_STATUS_RUNNING],
                1 => [OA_ENTITY_STATUS_RUNNING,   null,       $ndv,       OA_ENTITY_STATUS_RUNNING],
                2 => [OA_ENTITY_STATUS_AWAITING,  null,       $ndv,       OA_ENTITY_STATUS_RUNNING],
                3 => [OA_ENTITY_STATUS_EXPIRED,   null,       $ndv,       OA_ENTITY_STATUS_RUNNING],
                4 => [OA_ENTITY_STATUS_PAUSED,    null,       $ndv,       OA_ENTITY_STATUS_PAUSED],
                5 => [null,                       $past,      $ndv,       OA_ENTITY_STATUS_RUNNING],
                6 => [null,                       $future,    $ndv,       OA_ENTITY_STATUS_AWAITING],
                7 => [OA_ENTITY_STATUS_RUNNING,   $past,      $ndv,       OA_ENTITY_STATUS_RUNNING],
                8 => [OA_ENTITY_STATUS_RUNNING,   $future,    $ndv,       OA_ENTITY_STATUS_AWAITING],
                9 => [OA_ENTITY_STATUS_AWAITING,  $past,      $ndv,       OA_ENTITY_STATUS_RUNNING],
                10 => [OA_ENTITY_STATUS_AWAITING,  $future,    $ndv,       OA_ENTITY_STATUS_AWAITING],
                11 => [OA_ENTITY_STATUS_EXPIRED,   $past,      $ndv,       OA_ENTITY_STATUS_RUNNING],
                12 => [OA_ENTITY_STATUS_EXPIRED,   $future,    $ndv,       OA_ENTITY_STATUS_AWAITING],
                13 => [OA_ENTITY_STATUS_PAUSED,    $past,      $ndv,       OA_ENTITY_STATUS_PAUSED],
                14 => [OA_ENTITY_STATUS_PAUSED,    $future,    $ndv,       OA_ENTITY_STATUS_AWAITING],
            ],

        ];

        foreach ($aUpdateTests as $srcId => $aSuite) {
            foreach ($aSuite as $testKey => $aTest) {
                $doCampaigns = OA_Dal::staticGetDO('campaigns', $aInsertTests[$srcId][0]);
                $campaignId = DataGenerator::generateOne($doCampaigns);
                $doCampaigns = OA_Dal::factoryDO('campaigns');
                $doCampaigns->campaignid = $campaignId;
                if (isset($aTest[0])) {
                    $doCampaigns->status = $aTest[0];
                }
                if (isset($aTest[1])) {
                    $doCampaigns->activate_time = $aTest[1];
                }
                if (isset($aTest[2])) {
                    $doCampaigns->expire_time = $aTest[2];
                }
                $doCampaigns->update();
                $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
                $this->assertEqual($doCampaigns->status, $aTest[3], "Update test {$srcId}/{$testKey} failed, expected {$aTest[3]}, got $doCampaigns->status");
            }
        }
    }

    public function testSetStatus2()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $campaignId = DataGenerator::generateOne($doCampaigns);
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

    public function testSetStatus3()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $campaignId = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $bannerId = DataGenerator::generateOne($doBanners);

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doDia = OA_Dal::factoryDO('data_intermediate_ad');
        $doDia->date_time = '2008-01-01';
        $doDia->operation_interval = 1;
        $doDia->operation_interval_id = 1;
        $doDia->interval_start = '2008-01-01';
        $doDia->interval_end = '2008-01-01';
        $doDia->ad_id = $bannerId;
        $doDia->zone_id = 0;
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
        $doDia->date_time = '2008-01-01';
        $doDia->operation_interval = 1;
        $doDia->operation_interval_id = 1;
        $doDia->interval_start = '2008-01-01';
        $doDia->interval_end = '2008-01-01';
        $doDia->ad_id = $bannerId;
        $doDia->zone_id = 0;
        $doDia->creative_id = 0;
        $doDia->impressions = 100;
        $doDia->clicks = 100;
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

        $doCampaigns->clicks = -1;
        $doCampaigns->conversions = 200;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_RUNNING);

        $doCampaigns->conversions = 50;
        $doCampaigns->update();
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $this->assertEqual($doCampaigns->status, OA_ENTITY_STATUS_EXPIRED);
    }


    public function testUpdateHighWithNoTargetSet()
    {
        //test for OX-3635
        $expire = '2030-01-01';

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->name = 'Some test campaign';
        $doCampaigns->expire_time = $expire;
        $doCampaigns->views = -1;
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
