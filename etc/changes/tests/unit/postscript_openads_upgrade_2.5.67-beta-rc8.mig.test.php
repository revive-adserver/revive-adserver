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

// require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
// require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.5.67-beta-rc8.php';


/**
 * A class for testing creation and resetting of affiliates_affiliateid_seq
 * sequence.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class Migration_postscript_2_5_67_RC8Test extends MigrationTest
{
    function testExecute()
    {
        if ($this->oDbh->dbsyntax == 'pgsql') {
            $prefix = $this->getPrefix();
            $this->initDatabase(581, array('affiliates'));

            $aAValues = array(
                array('name' => 'x'),
                array('name' => 'y')
            );
            foreach ($aAValues as $aValues) {
                $sql = OA_DB_Sql::sqlForInsert('affiliates', $aValues);
                $this->oDbh->exec($sql);
            }

            // Simulate upgrade from phpPgAds with a wrongly named sequence
            $sequenceName = "{$prefix}affiliates_affiliateid_seq";
            $this->oDbh->exec("ALTER TABLE {$sequenceName} RENAME TO {$prefix}foobar");
            $this->oDbh->exec("ALTER TABLE {$prefix}affiliates ALTER affiliateid SET DEFAULT nextval('{$prefix}foobar')");

            // Create a publisher using the nextID call to generate the ID beforehand (two will fail because IDs already exist)
            $aAValues = array(
                array(
                    'affiliateid' => $this->oDbh->nextID($prefix.'affiliates_affiliateid'),
                    'name' => 'z1'
                ),
                array(
                    'affiliateid' => $this->oDbh->nextID($prefix.'affiliates_affiliateid'),
                    'name' => 'z2'
                ),
                array(
                    'affiliateid' => $this->oDbh->nextID($prefix.'affiliates_affiliateid'),
                    'name' => 'z3'
                ),
            );
            $aExpect = array(
                'PEAR_Error',
                'PEAR_Error',
                'int'
            );
            $this->oDbh->expectError(MDB2_ERROR_CONSTRAINT);
            foreach ($aAValues as $key => $aValues) {
                $sql = OA_DB_Sql::sqlForInsert('affiliates', $aValues);
                $result = $this->oDbh->exec($sql);
                $this->assertIsA($result, $aExpect[$key]);
            }
            $this->oDbh->popExpect();

            Mock::generatePartial(
                'OA_UpgradeLogger',
                $mockLogger = 'OA_UpgradeLogger'.rand(),
                array('logOnly', 'logError', 'log')
            );

            $oLogger = new $mockLogger($this);
            $oLogger->setReturnValue('logOnly', true);
            $oLogger->setReturnValue('logError', true);
            $oLogger->setReturnValue('log', true);

            $mockUpgrade = new StdClass();
            $mockUpgrade->oLogger = $oLogger;
            $mockUpgrade->oDBUpgrader = new OA_DB_Upgrade($oLogger);
            $mockUpgrade->oDBUpgrader->oTable = &$this->oaTable;

            $postscript = new OA_UpgradePostscript_2_5_67_RC8();
            $postscript->execute(array(&$mockUpgrade));

            $value = $this->oDbh->queryOne("SELECT nextval('$sequenceName')");

            $this->assertEqual($value, 4, "The current sequence value is $value (expected: 4)");
        }
    }
}
?>
