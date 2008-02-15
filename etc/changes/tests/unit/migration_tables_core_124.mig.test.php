<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

require_once MAX_PATH . '/etc/changes/migration_tables_core_124.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #124.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class migration_tables_core_124Test extends MigrationTest
{
    function testMigrateCampaignIds()
    {
        $this->initDatabase(123, array('banners'));

        $sql = OA_DB_Sql::sqlForInsert('banners', array(
            'bannerid'           => '1',
            'clientid'           => '4',
            'htmltemplate'       => '',
            'htmlcache'          => '',
            'bannertext'         => '',
            'compiledlimitation' => '',
            'append'             => ''
        ));
        $this->oDbh->exec($sql);

        $this->upgradeToVersion(124);

        $table = $this->oDbh->quoteIdentifier($this->getPrefix().'banners',true);

        $rsBanners = DBC::NewRecordSet("SELECT campaignid FROM {$table}");
        $this->assertTrue($rsBanners->find());
        $this->assertTrue($rsBanners->fetch());
        $this->assertEqual(4, $rsBanners->get('campaignid'));
    }
}