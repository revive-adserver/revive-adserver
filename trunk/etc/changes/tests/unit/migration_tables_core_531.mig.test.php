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

require_once MAX_PATH . '/etc/changes/migration_tables_core_531.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #531.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Migration_531Test extends MigrationTest
{
    function testMigrateInstanceId()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(530, array('preference', 'application_variable'));

        $tablePref   = $this->oDbh->quoteIdentifier($prefix.'preference', true);

        $query = "INSERT INTO {$tablePref} (agencyid, instance_id) VALUES (0, 'foo')";
        $result = $this->oDbh->exec($query);

        $this->assertTrue($result);

        $migration = new Migration_531();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');
        $migration->migrateInstanceId();

        $this->assertEqual(OA_Dal_ApplicationVariables::get('platform_hash'), 'foo');
    }
}