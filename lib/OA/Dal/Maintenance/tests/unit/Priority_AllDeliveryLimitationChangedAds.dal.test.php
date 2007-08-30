<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';

require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once 'Date.php';
require_once 'DB/QueryTool.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

// pgsql execution time before refactor: 217.33s
// pgsql execution time after refactor: 50.142s

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_AllDeliveryLimitationChangedAds extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_AllDeliveryLimitationChangedAds()
    {
        $this->UnitTestCase();
    }


    /**
     * Method to test the getAllDeliveryLimitationChangedAds method.
     *
     * Requirements:
     * Test 0: Test with bad input data, and ensure the method survives.
     * Test 1: Test with no data, and ensure no data are returned.
     * Test 2: Test with an active ad that has not had any delivery limitation changes,
     *         and ensure that no data are returned: DEPRECATED TEST, PostgreSQL DOES
     *         NOT PERMIT THE acls_update FIELD TO HAVE A NULL ENTRY.
     * Test 3: Test with an active ad that has had a delivery limitation change in the
     *         last OI, before the last Priority Compensation run, and ensure that no
     *         data are returned.
     * Test 4: Test with an active ad that has had a delivery limitation change in the
     *         last OI, after the last Priority Compensation run, and ensure that the
     *         correct data are returned.
     * Test 5: Test with an active ad that has had a delivery limitation change in the
     *         current OI, and ensure that the correct data are returned.
     * Test 6: Repeat test 3, but with an inactive ad.
     * Test 7: Repeat test 4, but with an inactive ad.
     * Test 8: Repeat test 5, but with an inactive ad.
     * Test 9: Test with a mixture of ads, and ensure the correct data are returned.
     */
    function testGetAllDeliveryLimitationChangedAds()
    {
        TestEnv::restoreEnv('dropTmpTables');

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oDateNow = new Date('2006-10-04 12:07:01');
        $oDateLastPC = new Date('2006-10-04 11:14:53');
        $aLastRun = array(
            'start_run' => $oDateLastPC,
            'now'       => $oDateNow
        );

        // Test 0
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds(array());
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 1
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 3
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 't';
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 11:10:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 4
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 't';
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 11:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$idBanner], '2006-10-04 11:15:00');
        DataGenerator::cleanUp();

        // Test 5
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 't';
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 12:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$idBanner], '2006-10-04 12:15:00');
        DataGenerator::cleanUp();

        // Test 6
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 't';
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 11:10:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 7
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 'f';
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 11:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 8
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 'f';
        $idCampaign = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid=$idCampaign;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 'f';
        $doBanners->acls_updated = '2006-10-04 12:15:00';
        $idBanner = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        DataGenerator::cleanUp();

        // Test 9
        $doCampaigns = OA_Dal::factoryDO('campaigns');

        $doCampaigns->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doCampaigns->active  = 't';
        $aIdCampaignsActive = DataGenerator::generate($doCampaigns,2);
        $doCampaigns->active  = 'f';
        $idCampaignInactive = DataGenerator::generateOne($doCampaigns);

        $doBanners = OA_Dal::factoryDO('banners');

        $doBanners->campaignid=$aIdCampaignsActive[0];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 11:30:00';
        $idBanner1 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$aIdCampaignsActive[0];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 10:15:00';
        $idBanner2 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$aIdCampaignsActive[1];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 'f';
        $doBanners->acls_updated = '2006-10-04 12:06:00';
        $idBanner3 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$aIdCampaignsActive[1];
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 12:15:00';
        $idBanner4 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$idCampaignInactive;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 12:05:00';
        $idBanner5 = DataGenerator::generateOne($doBanners);

        $doBanners->campaignid=$idCampaignInactive;
        $doBanners->updated = $oDateNow->format('%Y-%m-%d %H:%M:%S');
        $doBanners->active  = 't';
        $doBanners->acls_updated = '2006-10-04 12:01:00';
        $idBanner5 = DataGenerator::generateOne($doBanners);

        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[$idBanner1], '2006-10-04 11:30:00');
        $this->assertEqual($aResult[$idBanner4], '2006-10-04 12:15:00');
        DataGenerator::cleanUp();
    }

    /**
     * Method to test the getAllDeliveryLimitationChangedAds method.
     *
     * Requirements:
     * Test 0: Test with bad input data, and ensure the method survives.
     * Test 1: Test with no data, and ensure no data are returned.
     * Test 2: Test with an active ad that has not had any delivery limitation changes,
     *         and ensure that no data are returned: DEPRECATED TEST, PostgreSQL DOES
     *         NOT PERMIT THE acls_update FIELD TO HAVE A NULL ENTRY.
     * Test 3: Test with an active ad that has had a delivery limitation change in the
     *         last OI, before the last Priority Compensation run, and ensure that no
     *         data are returned.
     * Test 4: Test with an active ad that has had a delivery limitation change in the
     *         last OI, after the last Priority Compensation run, and ensure that the
     *         correct data are returned.
     * Test 5: Test with an active ad that has had a delivery limitation change in the
     *         current OI, and ensure that the correct data are returned.
     * Test 6: Repeat test 3, but with an inactive ad.
     * Test 7: Repeat test 4, but with an inactive ad.
     * Test 8: Repeat test 5, but with an inactive ad.
     * Test 9: Test with a mixture of ads, and ensure the correct data are returned.
     */
    function OLD_testGetAllDeliveryLimitationChangedAds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oDateNow = new Date('2006-10-04 12:07:01');
        $oDateLastPC = new Date('2006-10-04 11:14:53');
        $aLastRun = array(
            'start_run' => $oDateLastPC,
            'now'       => $oDateNow
        );

        // Test 0
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds(array());
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 1
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 3
        $tblCampaigns = $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['campaigns'],true);
        $query = "
            INSERT INTO
                {$tblCampaigns}
                (
                    campaignid,
                    active,
                    updated
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'timestamp'
        );
        $stPl = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['banners'],true)."
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append,
                    updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'timestamp',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'timestamp'
        );
        $stAd = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:10:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        TestEnv::restoreEnv('dropTmpTables');

        // Test 4
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], '2006-10-04 11:15:00');
        TestEnv::restoreEnv('dropTmpTables');

        // Test 5
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 12:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], '2006-10-04 12:15:00');
        TestEnv::restoreEnv('dropTmpTables');

        // Test 6
        $aData = array(
            1,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:10:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv('dropTmpTables');

        // Test 7
        $aData = array(
            1,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv('dropTmpTables');

        // Test 8
        $aData = array(
            1,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            'f',
            '2006-10-04 12:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv('dropTmpTables');

        // Test 9
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            2,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            3,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:30:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            2,
            1,
            't',
            '2006-10-04 10:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            3,
            2,
            'f',
            '2006-10-04 12:06:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            4,
            2,
            't',
            '2006-10-04 12:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            5,
            3,
            't',
            '2006-10-04 12:05:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            6,
            3,
            't',
            '2006-10-04 12:01:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[1], '2006-10-04 11:30:00');
        $this->assertEqual($aResult[4], '2006-10-04 12:15:00');
        TestEnv::restoreEnv('dropTmpTables');
    }


}

?>
