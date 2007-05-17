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
$Id $
*/


require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/VersionController.php';
require_once MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php';

/**
 * A class for testing the Openads Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_OA_Upgrade extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Upgrade()
    {
        $this->UnitTestCase();
    }

    function test_runScript()
    {
        $oUpgrade  = new OA_Upgrade();
        $this->assertTrue($oUpgrade->runScript(MAX_PATH.'/lib/OA/Upgrade/tests/data/prescript_openads_upgrade_1_to_2.php', 'prescript'));
    }

    function test_writeRecoveryFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->versionInitialSchema['tables_core'] = -1;
        $oUpgrade->versionInitialApplication = '0.3.31';
        $this->assertTrue($oUpgrade->_writeRecoveryFile('tables_core', 0),'failed to write recovery file');
        $this->assertTrue($oUpgrade->_writeRecoveryFile('tables_core', 1),'failed to write recovery file');
        $this->assertTrue($oUpgrade->_writeRecoveryFile('tables_core', 2),'failed to write recovery file');
        $this->assertTrue($oUpgrade->_writeRecoveryFile('tables_core', 3),'failed to write recovery file');
    }

    function test_seekRecoveryFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $aResult = $oUpgrade->seekRecoveryFile();
        $this->assertIsA($aResult,'array','failed to find recovery file');

        $this->assertEqual($aResult[0]['schema'],'tables_core','error in recovery array: schema');
        $this->assertEqual($aResult[0]['version'],0,'error in recovery array: versionTo');
        $this->assertEqual($aResult[0]['versionInitialSchema'],-1,'error in recovery array: versionInitialSchema');
        $this->assertEqual($aResult[0]['versionInitialApplication'],'0.3.31','error in recovery array: versionInitialApplication');
        $this->assertTrue(isset($aResult[0]['updated']),'error in recovery array: updated');

        $this->assertEqual($aResult[1]['schema'],'tables_core','error in recovery array: schema');
        $this->assertEqual($aResult[1]['version'],1,'error in recovery array: versionTo');
        $this->assertEqual($aResult[1]['versionInitialSchema'],-1,'error in recovery array: versionInitialSchema');
        $this->assertEqual($aResult[1]['versionInitialApplication'],'0.3.31','error in recovery array: versionInitialApplication');
        $this->assertTrue(isset($aResult[1]['updated']),'error in recovery array: updated');

        $this->assertEqual($aResult[2]['schema'],'tables_core','error in recovery array: schema');
        $this->assertEqual($aResult[2]['version'],2,'error in recovery array: version');
        $this->assertEqual($aResult[2]['versionInitialSchema'],-1,'error in recovery array: versionInitialSchema');
        $this->assertEqual($aResult[2]['versionInitialApplication'],'0.3.31','error in recovery array: versionInitialApplication');
        $this->assertTrue(isset($aResult[2]['updated']),'error in recovery array: updated');

        $this->assertEqual($aResult[3]['schema'],'tables_core','error in recovery array: schema');
        $this->assertEqual($aResult[3]['version'],3,'error in recovery array: version');
        $this->assertEqual($aResult[3]['versionInitialSchema'],-1,'error in recovery array: versionInitialSchema');
        $this->assertEqual($aResult[3]['versionInitialApplication'],'0.3.31','error in recovery array: versionInitialApplication');
        $this->assertTrue(isset($aResult[3]['updated']),'error in recovery array: updated');
    }

    function test_pickupRecoveryFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $this->assertTrue($oUpgrade->_pickupRecoveryFile(),'failed to remove recovery file');
    }

    function test_upgradeSchemasPass()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_Version_Controller',
            $mockVersioner = 'OA_Version_Controller'.rand(),
            array('getSchemaVersion', 'putSchemaVersion')
        );

        $oUpgrade->oVersioner = new $mockVersioner($this);
        $oUpgrade->oVersioner->setReturnValue('getSchemaVersion', 1);
        $oUpgrade->oVersioner->expectOnce('getSchemaVersion');
        $oUpgrade->oVersioner->setReturnValue('putSchemaVersion', null);
        $oUpgrade->oVersioner->expectOnce('putSchemaVersion');

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('upgrade','init')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('upgrade', true);
        $oUpgrade->oDBUpgrader->expectCallCount('upgrade',2);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectCallCount('init',2);

        $oUpgrade->aDBPackages = array(0=>array('version'=>'2','schema'=>'test_tables','files'=>''));

        $this->assertTrue($oUpgrade->upgradeSchemas(),'schema upgrade method failed');
        $this->assertEqual($oUpgrade->versionInitialSchema['test_tables'],1,'error setting initial schema version');

        $oUpgrade->oDBUpgrader->tally();
        $oUpgrade->oVersioner->tally();
    }

    function test_upgradeSchemasFail()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_Version_Controller',
            $mockVersioner = 'OA_Version_Controller'.rand(),
            array('getSchemaVersion', 'putSchemaVersion')
        );

        $oUpgrade->oVersioner = new $mockVersioner($this);
        $oUpgrade->oVersioner->setReturnValueAt(0, 'getSchemaVersion', 1);
        $oUpgrade->oVersioner->expectCallCount('getSchemaVersion', 2);
        $oUpgrade->oVersioner->setReturnValueAt(2, 'getSchemaVersion', 2);
        $oUpgrade->oVersioner->setReturnValue('putSchemaVersion', null);
        $oUpgrade->oVersioner->expectCallCount('putSchemaVersion', 2);

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('init','upgrade', 'rollback', 'prepPrescript', 'prepPostcript', 'prepRollback')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectCallCount('init', 3);
        $oUpgrade->oDBUpgrader->setReturnValue('prepPrescript', true);
        $oUpgrade->oDBUpgrader->expectCallCount('prepPrescript', 0);
        $oUpgrade->oDBUpgrader->setReturnValue('upgrade', false);
        $oUpgrade->oDBUpgrader->expectCallCount('upgrade', 1);
        $oUpgrade->oDBUpgrader->setReturnValue('prepPostcript', true);
        $oUpgrade->oDBUpgrader->expectCallCount('prepPostcript', 0);
        $oUpgrade->oDBUpgrader->setReturnValue('prepRollback', true);
        $oUpgrade->oDBUpgrader->expectCallCount('prepRollback', 2);
        $oUpgrade->oDBUpgrader->setReturnValue('rollback', true);
        $oUpgrade->oDBUpgrader->expectCallCount('rollback', 2);

        $oUpgrade->aDBPackages = array(0=>array('version'=>'2','schema'=>'test_tables','files'=>''));

        $this->assertFalse($oUpgrade->upgradeSchemas(),'schema upgrade method failed (testing failure.  it was supposed to fail and it didn\'t)');

        $this->assertTrue($oUpgrade->_pickupRecoveryFile(),'failed to remove recovery file');

        $this->assertEqual($oUpgrade->versionInitialSchema['test_tables'],1,'error setting initial schema version');

        $oUpgrade->oDBUpgrader->tally();
        $oUpgrade->oVersioner->tally();
    }

    function test_rollbackSchemas()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_Version_Controller',
            $mockVersioner = 'OA_Version_Controller'.rand(),
            array('getSchemaVersion', 'putSchemaVersion')
        );

        $oUpgrade->oVersioner = new $mockVersioner($this);
        $oUpgrade->oVersioner->setReturnValue('getSchemaVersion', 2);
        $oUpgrade->oVersioner->expectOnce('getSchemaVersion');
        $oUpgrade->oVersioner->setReturnValue('putSchemaVersion', null);
        $oUpgrade->oVersioner->expectCallCount('putSchemaVersion', 2);

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('init','rollback', 'prepRollback')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectCallCount('init', 2);
        $oUpgrade->oDBUpgrader->setReturnValue('prepRollback', true);
        $oUpgrade->oDBUpgrader->expectCallCount('prepRollback', 2);
        $oUpgrade->oDBUpgrader->setReturnValue('rollback', true);
        $oUpgrade->oDBUpgrader->expectCallCount('rollback', 2);

        $oUpgrade->versionInitialSchema = array('test_tables'=>'1');
        $oUpgrade->aDBPackages = array(0=>array('version'=>'2','schema'=>'test_tables','files'=>''));

        $this->assertTrue($oUpgrade->rollbackSchemas(),'schema rollback method failed');

        $oUpgrade->oDBUpgrader->tally();
        $oUpgrade->oVersioner->tally();

    }

    function test_parseUpgradePackageFile()
    {
        $oUpgrade  = new OA_Upgrade();

        $aExpected = array();
        $aExpected['db_pkgs'] = array();
        $aExpected['name'] ='Openads';
        $aExpected['creationDate'] ='2007-01-01';
        $aExpected['author'] ='Test Author';

        Mock::generatePartial(
            'OA_UpgradePackageParser',
            $mockParser = 'OA_UpgradePackageParser'.rand(),
            array('setInputFile', 'parse')
        );

        $oUpgrade->oParser = new $mockParser($this);
        $oUpgrade->oParser->setReturnValue('setInputFile', true);
        $oUpgrade->oParser->expectOnce('setInputFile');
        $oUpgrade->oParser->setReturnValue('parse', $aExpected);
        $oUpgrade->oParser->expectOnce('parse');

        $this->assertTrue($oUpgrade->_parseUpgradePackageFile('test_file'),'upgrade package parse method failed');

        $oUpgrade->oParser->tally();

    }



}

?>
