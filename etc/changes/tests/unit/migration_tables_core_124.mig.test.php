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

require_once MAX_PATH . '/etc/changes/migration_tables_core_124.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #124.
 *
 * @package    changes
 * @subpackage TestSuite
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