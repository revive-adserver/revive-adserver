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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.5.67-beta-rc3.php';

/**
 * A class for testing non standard DataObjects_Users methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class Migration_postscript_2_5_67_UsersTest extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
    }

    function testUpdate()
    {
        $oUpgrade  = new OA_Upgrade();
        $this->oConfiguration = $oUpgrade->oConfiguration;
        $oUpgrade->initDatabaseConnection();

        // run the upgrade
        Mock::generatePartial(
            'OA_UpgradePostscript_2_5_67',
            $mockName = 'OA_UpgradePostscript_2_5_67_'.rand(),
            array('logOnly','logError')
        );
        $oMockPostUpgrade = new $mockName($this);
        $oMockPostUpgrade->oUpgrade = &$oUpgrade;

        $aContexts  = array_keys($oMockPostUpgrade->aContexts);
        $aTables    = array_values($oMockPostUpgrade->aContexts);
        array_push($aTables,'audit');
        $this->initDatabase(581, $aTables);
        array_pop($aTables);

        // prepare data
        $tblAudit = $this->oDbh->quoteIdentifier($this->getPrefix().'audit',true);

        foreach ($aContexts as $i => $context)
        {
            $query = "INSERT INTO {$tblAudit} (actionid, context, details, userid, usertype, account_id) VALUES ({$i}, '{$context}', 'details', 1, 0, 1)";
            $this->oDbh->exec($query);
        }
        $query = "SELECT actionid, context FROM {$tblAudit}";
        $result = $this->oDbh->queryAll($query);
        $this->assertIsA($result,'array');
        foreach ($result as $i => $row)
        {
            $this->assertEqual($row['context'], $aContexts[$row['actionid']]);//$aData[$row['actionid']]['original']);
        }
        $oMockPostUpgrade->updateAuditContext();

        // test results
        $query = "SELECT actionid, context FROM {$tblAudit}";
        $result = $this->oDbh->queryAll($query);
        $this->assertIsA($result,'array');
        foreach ($result as $i => $row)
        {
            $this->assertEqual($row['context'], $aTables[$row['actionid']]);//$aData[$row['actionid']]['expected']);
        }
    }

    function testRemoveMaxSection()
    {
    	// prepare data
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_UpgradePostscript_2_5_67',
            $mockName = 'OA_UpgradePostscript_2_5_67_'.rand(),
            array('logOnly','logError')
        );
        $doMockPostUpgrade = new $mockName($this);
        $doMockPostUpgrade->oUpgrade = &$oUpgrade;

        // delete max section to make a new max section for testing
        unset($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']);

        $this->assertNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']);

        // add installed, uiEnabled and language to max section as can be possible
        // to find at openx
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['installed'] = '';
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['uiEnabled'] = '1';
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['language'] = 'english';

        // check that aConfig max section is not null
        $this->assertNotNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']);

        // remove max section
        $doMockPostUpgrade->removeMaxSection();

        // check that aConfig max section has been removed
        $this->assertNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']);

        // assert that ['openads']['language'] has been created with the correct value
        $this->assertEqual($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['openads']['language'], 'en');

        // generate the max section with more than the three possible original openx parameters
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['installed'] = '';
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['uiEnabled'] = '1';
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['language'] = 'catalan';
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['foo'] = 'foo';

        // try to remove max section
        $doMockPostUpgrade->removeMaxSection();

        // assert that max section has not been removed because it has no original openx parameters
        $this->assertNotNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']);

        // assert that the no original openx parameters still at the max section with their original value
        $this->assertEqual($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['foo'], 'foo');

        // assert that ['openads']['language'] has been created with the default value because
        // the language is not recognise
        $this->assertEqual($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['openads']['language'], 'en');

        // remove the not original openx parameter
        unset($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']['foo']);

        // try to remove max section
        $doMockPostUpgrade->removeMaxSection();

        // check if the max section has been removed as is expected
        $this->assertNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['max']);
    }
}
?>
