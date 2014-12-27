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

require_once MAX_PATH . '/etc/changes/migration_tables_core_601.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #540.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_601Test extends MigrationTest
{
    function testMigrateTrackerWindows()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(600, array('campaigns', 'clients', 'campaigns_trackers'));

        $tblCampaigns  = $this->oDbh->quoteIdentifier($prefix.'campaigns', true);
        $tblCampaignsTrackers  = $this->oDbh->quoteIdentifier($prefix.'campaigns_trackers', true);

        // Setup some campaign with linked tracker combinations
        // One with no linked trackers
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, campaignname) VALUES (1, 'test campaign one')");

        // One with one linked tracker
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, campaignname) VALUES (2, 'test campaign two')");
        $this->oDbh->exec("INSERT INTO {$tblCampaignsTrackers} (campaignid, trackerid, viewwindow, clickwindow) VALUES (2, 1, 100, 200)");

        // One with two linked trackers (view > in #1, click greater in #2
        $this->oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, campaignname) VALUES (3, 'test campaign three')");
        $this->oDbh->exec("INSERT INTO {$tblCampaignsTrackers} (campaignid, trackerid, viewwindow, clickwindow) VALUES (3, 1, 500, 200)");
        $this->oDbh->exec("INSERT INTO {$tblCampaignsTrackers} (campaignid, trackerid, viewwindow, clickwindow) VALUES (3, 1, 100, 600)");

        // Migrate!
        $this->upgradeToVersion(601);

        $aCampaigns = $this->oDbh->getAssoc("SELECT campaignid, viewwindow, clickwindow FROM {$tblCampaigns} ORDER BY campaignid");
        $aExpected = array(
            1 => array('clickwindow' => 0, 'viewwindow' => 0),
            2 => array('clickwindow' => 200, 'viewwindow' => 100),
            3 => array('clickwindow' => 600, 'viewwindow' => 500),
        );
        $this->assertEqual($aCampaigns, $aExpected);
    }

}