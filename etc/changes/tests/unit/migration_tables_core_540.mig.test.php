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

require_once MAX_PATH . '/etc/changes/migration_tables_core_540.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #540.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_540Test extends MigrationTest
{
    function testMigrateStatus()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(539, array('affiliates', 'banners', 'campaigns', 'clients', 'zones'));

        $tblBanners    = $this->oDbh->quoteIdentifier($prefix.'banners', true);
        $tblCampaigns  = $this->oDbh->quoteIdentifier($prefix.'campaigns', true);

        $this->oDbh->exec("INSERT INTO {$tblBanners} (active) VALUES ('t')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (active) VALUES ('f')");

        $this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblBanners}"), 2);

        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (active) VALUES ('t')");
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (active, activate) VALUES ('f', '2030-01-01')");
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (active, expire) VALUES ('f', '2000-01-01')");
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (active, views) VALUES ('f', 1)");
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (active, clicks) VALUES ('f', 1)");
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (active, conversions) VALUES ('f', 1)");

        $this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblCampaigns}"), 6);

        // Migrate!
        $this->upgradeToVersion(540);

        $aBanners = $this->oDbh->getAssoc("SELECT bannerid, status FROM {$tblBanners} ORDER BY bannerid");
        $aExpected = array (
            1 => OA_ENTITY_STATUS_RUNNING,
            2 => OA_ENTITY_STATUS_PAUSED
        );
        $this->assertEqual($aBanners, $aExpected);

        $aCampaigns = $this->oDbh->getAssoc("SELECT campaignid, status FROM {$tblCampaigns} ORDER BY campaignid");
        $aExpected = array (
            1 => OA_ENTITY_STATUS_RUNNING,
            2 => OA_ENTITY_STATUS_AWAITING,
            3 => OA_ENTITY_STATUS_EXPIRED,
            4 => OA_ENTITY_STATUS_EXPIRED,
            5 => OA_ENTITY_STATUS_EXPIRED,
            6 => OA_ENTITY_STATUS_EXPIRED
        );
        $this->assertEqual($aCampaigns, $aExpected);
    }

}