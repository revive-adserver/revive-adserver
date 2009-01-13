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
$Id$
*/

require_once MAX_PATH . '/etc/changes/migration_tables_core_538.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #538.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Migration_538Test extends MigrationTest
{
    function testMigration()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(537, array('data_intermediate_ad', 'data_summary_ad_hourly'));

        $tableDia   = $this->oDbh->quoteIdentifier($prefix.'data_intermediate_ad', true);
        $tableDsah  = $this->oDbh->quoteIdentifier($prefix.'data_summary_ad_hourly', true);

        $query = "
            INSERT INTO {$tableDia} (
                day,
                hour,
                ad_id,
                zone_id,
                creative_id,
                impressions,
                operation_interval,
                operation_interval_id
            ) VALUES (
                '2007-01-01',
                1,
                1,
                0,
                0,
                1,
                1,
                1
            )";
        $result = $this->oDbh->exec($query);
        $this->assertTrue($result);

        $query = "
            INSERT INTO {$tableDsah} (
                day,
                hour,
                ad_id,
                zone_id,
                creative_id,
                impressions
            ) VALUES (
                '2007-01-01',
                1,
                1,
                0,
                0,
                1
            )";
        $result = $this->oDbh->exec($query);
        $this->assertTrue($result);

        $this->upgradeToVersion(538);

        $aExpected = array(
            array(
                'date_time'   => '2007-01-01 01:00:00',
                'impressions' => '1'
            )
        );

        $aResult = $this->oDbh->queryAll("SELECT date_time, impressions FROM {$tableDia} ORDER BY date_time");
        $this->assertEqual($aResult, $aExpected);

        $aResult = $this->oDbh->queryAll("SELECT date_time, impressions FROM {$tableDsah} ORDER BY date_time");
        $this->assertEqual($aResult, $aExpected);
    }
}