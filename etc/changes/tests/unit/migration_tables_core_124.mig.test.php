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

require_once MAX_PATH . '/etc/changes/migration_tables_core_124.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #124.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class migration_tables_core_124Test extends MigrationTest
{
    function testMigrateCampaignIds()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(123, array('banners'));
        
        $sql = OA_DB_Sql::sqlForInsert('banners', array('bannerid' => '1', 'clientid' => 4));
        $this->oDbh->exec($sql);
        
        $this->upgradeToVersion(124);
        
        $rsBanners = DBC::NewRecordSet("SELECT campaignid FROM {$prefix}banners");
        $this->assertTrue($rsBanners->find());
        $this->assertTrue($rsBanners->fetch());
        $this->assertEqual(4, $rsBanners->get('campaignid'));
    }
}