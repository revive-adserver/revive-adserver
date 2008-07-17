<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/etc/changes/migration_tables_core_122.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #122.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class migration_tables_core_122Test extends MigrationTest
{
    function testMigrateData()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(121, array('clients', 'campaigns'));

        $aCampaigns = array(
            array('clientid' => 3, 'parent' => 1, 'views' => '100', target => '1000'),
            array('clientid' => 4, 'parent' => 1, 'views' => '200', target => '1'),
            array('clientid' => 5, 'parent' => 1, 'views' => '200', target => '0'),
        );
        $cCampaigns = count($aCampaigns);
        $aAValues = array(
            array('clientid' => 1, 'parent' => 0, 'views' => '0', target => '0'),
            array('clientid' => 2, 'parent' => 0, 'views' => '0', target => '0'),
        );
        $aAValues = array_merge($aAValues, $aCampaigns);
        foreach ($aAValues as $aValues) {
            $sql = OA_DB_Sql::sqlForInsert('clients', $aValues);
            $this->oDbh->exec($sql);
        }

        $this->upgradeToVersion(122);

        $tableCampaigns = $this->oDbh->quoteIdentifier($prefix.'campaigns',true);
        $rsCampaigns = DBC::NewRecordSet("SELECT * from {$tableCampaigns}");
        $this->assertTrue($rsCampaigns->find());
        $this->assertEqual($cCampaigns, $rsCampaigns->getRowCount());
        for ($idxCampaign = 0; $idxCampaign < $cCampaigns; $idxCampaign++) {
            $this->assertTrue($rsCampaigns->fetch());
            $this->assertEqual($aCampaigns[$idxCampaign]['clientid'], $rsCampaigns->get('campaignid'));
            $this->assertEqual($aCampaigns[$idxCampaign]['parent'], $rsCampaigns->get('clientid'));
            $this->assertEqual($aCampaigns[$idxCampaign]['views'], $rsCampaigns->get('views'));
            $priority = $aCampaigns[$idxCampaign]['target'] > 0 ? 5 : 0;
            $this->assertEqual($priority, $rsCampaigns->get('priority'));
        }
        $tableClients = $this->oDbh->quoteIdentifier($prefix.'clients',true);
        $rsClients = DBC::NewRecordSet("SELECT count(*) AS nclients FROM {$tableClients}");
        $this->assertTrue($rsClients->find());
        $this->assertTrue($rsClients->fetch());
        $this->assertEqual(count($aAValues) - $cCampaigns, $rsClients->get('nclients'));
        
        if ($this->oDbh->dbsyntax == 'pgsql') {
            $value = $this->oDbh->queryOne(
                "SELECT NEXTVAL('{$prefix}campaigns_campaignid_seq')");
            
            $this->assertTrue($value > 5, "The current sequence value is $value.");
        }
    }
}
