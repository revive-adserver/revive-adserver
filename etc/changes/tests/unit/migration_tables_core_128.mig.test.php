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

require_once MAX_PATH . '/etc/changes/migration_tables_core_128.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_UpgradeAuditor.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #128.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_128Test extends MigrationTest
{
    function testMigrateData()
    {
        $this->initDatabase(127, array('banners'));
        
        $toInt['f'] = 0;
        $toInt['t'] = 1;
        $aAValues = array(
            array('bannerid' => 1, 'transparent' => "f"),
            array('bannerid' => 2, 'transparent' => "t"),
            array('bannerid' => 3, 'transparent' => "f"),
            array('bannerid' => 4, 'transparent' => "f"),
            array('bannerid' => 5, 'transparent' => "t")
        );
        foreach ($aAValues as $aValues) {
            $sql = OA_DB_Sql::sqlForInsert('banners', $aValues);
            $this->oDbh->exec($sql);
        }

        $upgrader = new OA_DB_Upgrade();
        $upgrader->initMDB2Schema();
        $auditor   = new OA_DB_UpgradeAuditor();
        $upgrader->oAuditor = &$auditor;
        $this->assertTrue($auditor->init($upgrader->oSchema->db), 'error initialising upgrade auditor, probable error creating database action table');
        $upgrader->init('constructive', 'tables_core', 128);
        $upgrader->upgrade();

        $rsBanners = DBC::NewRecordSet("SELECT bannerid, transparent FROM banners ORDER BY bannerid");
        $rsBanners->find();
        $this->assertEqual(count($aAValues), $rsBanners->getRowCount());
        for ($idxBanner = 0; $idxBanner < count($aAValues); $idxBanner++) {
            $this->assertTrue($rsBanners->fetch());
            $this->assertEqual($aAValues[$idxBanner]['bannerid'], $rsBanners->get('bannerid'));
            $this->assertEqual($toInt[$aAValues[$idxBanner]['transparent']], $rsBanners->get('transparent'));
        }
        $this->assertFalse($rsBanners->fetch());
    }
}