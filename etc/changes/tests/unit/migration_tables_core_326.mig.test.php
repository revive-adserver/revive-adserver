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

require_once MAX_PATH . '/etc/changes/migration_tables_core_326.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #128.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_326Test extends MigrationTest
{
    function testMigrateData()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(325, array('campaigns'));

        $tableCampaigns = $this->oDbh->quoteIdentifier($prefix.'campaigns', true);

	    $result = $this->oDbh->exec("ALTER TABLE {$tableCampaigns} MODIFY priority enum('h','m','l') NOT NULL DEFAULT 'l'");

        $oInsert = $this->oDbh->prepare("
            INSERT INTO {$tableCampaigns} (
                campaignname,
                priority
            ) VALUES (
                'foo',
                ?
            )
        ", array('text'));

        $aPriorities = array(
           'h' => 5,
           'm' => 3,
           'l' => 0
        );

        foreach ($aPriorities as $old => $new) {
            $this->assertTrue($oInsert->execute(array($old)), "Couldn't create campaign");
        }

        $migration = new Migration_326();
        $migration->init($this->oDbh);
        $migration->migrateData();

        $query = "SELECT campaignid, priority FROM {$tableCampaigns} ORDER BY campaignid";
        $aCampaigns = $this->oDbh->getAssoc($query);
        $this->assertEqual(count($aCampaigns), 3);
        $i = 1;
        foreach ($aPriorities as $old => $new) {
            $this->assertEqual($new, $aCampaigns[$i++]);
        }
    }
}