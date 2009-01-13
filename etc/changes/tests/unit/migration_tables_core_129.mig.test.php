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

require_once MAX_PATH . '/etc/changes/migration_tables_core_129.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #129.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class Migration_tables_core_129Test extends MigrationTest
{
    function testMigrateData()
    {
        $this->initDatabase(129, array('config', 'preference'));

        $this->setupPanConfig();

        $migration = new Migration_129();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');

        $aValues = array('warn_limit_days' => 1);

        $migration->migrateData();
        $table = $this->oDbh->quoteIdentifier($this->getPrefix().'preference');
        $rsPreference = DBC::NewRecordSet("SELECT * from {$table}");

        $rsPreference->find();
        $this->assertTrue($rsPreference->fetch());
        $aDataPreference = $rsPreference->toArray();
        foreach($aValues as $column => $value) {
            $this->assertEqual($value, $aDataPreference[$column]);
        }

        $this->restorePanConfig();
    }
}