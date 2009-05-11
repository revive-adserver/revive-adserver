<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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
$Id: postscript_openads_upgrade_2.7.26-beta-rc5.mig.test.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.8.1-rc4.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing adding campaign_ecpm_enabled preference
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Migration_postscript_2_8_1_RC4Test extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
        $this->assertTrue($this->initDatabase(606, array(
            'accounts',
            'agency',
            'clients',
            'campaigns',
            'banners',
            'zones',
            'ad_zone_assoc',
            'placement_zone_assoc',
            'trackers',
        )));
    }

    function testExecute()
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger'.rand(),
            array('logOnly', 'logError', 'log')
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        Mock::generatePartial(
            'OA_Upgrade',
            $mockUpgrade = 'OA_Upgrade'.rand(),
            array('addPostUpgradeTask')
        );
        $mockUpgrade = new $mockUpgrade($this);
        $mockUpgrade->setReturnValue('addPostUpgradeTask', true);
        $mockUpgrade->oLogger = $oLogger;
        $mockUpgrade->oDBUpgrader = new OA_DB_Upgrade($oLogger);
        $mockUpgrade->oDBUpgrader->oTable = &$this->oaTable;

        // Create a regular banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-03 19:28:06';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $this->assertTrue($bannerId);

        // Create a text banner
        $doBanners->contenttype = 'txt';
        $doBanners->storagetype = 'txt';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $this->assertTrue($bannerId);

        // Remove zone assoc for text banner
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = 0;
        $doAdZoneAssoc->delete();

        // Create another text banner
        $doBanners->contenttype = 'txt';
        $doBanners->storagetype = 'txt';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $this->assertTrue($bannerId);

        // Remove zone assoc for text banner
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = 0;
        $doAdZoneAssoc->delete();

        // Test that only one banner is now linked to zone 0
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->zone_id = 0;
        $doAdZoneAssoc->find();
        $this->assertEqual($doAdZoneAssoc->getRowCount(), 1);

        // Run the upgrade
        $postscript = new OA_UpgradePostscript_2_8_1_rc4();
        $ret = $postscript->execute(array(&$mockUpgrade));
        $this->assertTrue($ret);

        // Test that all the banners are now linked to zone 0
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->zone_id = 0;
        $doAdZoneAssoc->find();
        $this->assertEqual($doAdZoneAssoc->getRowCount(), 3);
    }
}