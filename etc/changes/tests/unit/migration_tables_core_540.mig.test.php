<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/etc/changes/migration_tables_core_540.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #540.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
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