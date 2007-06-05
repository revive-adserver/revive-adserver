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

    function test_versionCompare()
    {
        $verPrev = '2.3.32-beta';
        $verCurr = '2.3.32-beta-rc2';
        $upgrade  = (version_compare($verPrev,$verCurr)<0);
        $current  = (version_compare($verCurr,$verCurr)==0);
        $this->assertFalse($upgrade,'');
        $this->assertTrue($current,'');

        $verPrev = '2.3.32-beta-rc12';
        $verCurr = '2.3.32-beta';
        $upgrade  = (version_compare($verPrev,$verCurr)<0);
        $current  = (version_compare($verCurr,$verCurr)==0);
        $this->assertTrue($upgrade,'');
        $this->assertTrue($current,'');

        $verPrev = '2.3.32-beta-rc12';
        $verCurr = '2.3.32';
        $upgrade  = (version_compare($verPrev,$verCurr)<0);
        $current  = (version_compare($verCurr,$verCurr)==0);
        $this->assertTrue($upgrade,'');
        $this->assertTrue($current,'');

        $verPrev = '2.3.32-beta-rc1';
        $verCurr = '2.3.32-beta-rc2';
        $upgrade  = (version_compare($verPrev,$verCurr)<0);
        $current  = (version_compare($verCurr,$verCurr)==0);
        $this->assertTrue($upgrade,'');
        $this->assertTrue($current,'');

        $verPrev = '2.3.32-beta-rc1';
        $verCurr = '2.3.32-beta-rc10';
        $upgrade  = (version_compare($verPrev,$verCurr)<0);
        $current  = (version_compare($verCurr,$verCurr)==0);
        $this->assertTrue($upgrade,'');
        $this->assertTrue($current,'');
    }

    function _writeUpgradePackagesArray()
    {
        global $readPath, $writeFile;
        $readPath = MAX_PATH.'/lib/OA/Upgrade/tests/data/changes';
        $writeFile = MAX_PATH.'/var/openads_upgrade_array.txt';
        include MAX_PATH.'/lib/OA/Upgrade/tests/data/changes/build_upgrade_packages_array.php';
        $this->assertTrue(file_exists($writeFile),'array file was not written');
        return $aVersions;
    }

//    function _readUpgradePackagesArray()
//    {
//        global $readPath, $writeFile;
//
//        $this->assertTrue(file_exists($writeFile),'array file not found');
//        $array = file_get_contents($writeFile);
//        $aVersions = unserialize($array);
//        $this->assertIsA($aVersions,'array','aVersions is not an array');
//        return $aVersions;
//    }

    function test_writeUpgradePackagesArray()
    {
        $aVersions = $this->_writeUpgradePackagesArray();

        $this->assertEqual(count($aVersions),1,'');
        $this->assertEqual(count($aVersions[2]),2,'');
        $this->assertEqual(count($aVersions[2][3]),2,'');

        $this->assertEqual(count($aVersions[2][3][32]),2,'');
        $this->assertEqual(count($aVersions[2][3][32]['-beta']),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta']['file'],'openads_upgrade_2.3.32-beta.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc']),4,'');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][2]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][2]['file'],'openads_upgrade_2.3.32-beta-rc2.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][5]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][5]['file'],'openads_upgrade_2.3.32-beta-rc5.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][10]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][10]['file'],'openads_upgrade_2.3.32-beta-rc10.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][21]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][21]['file'],'openads_upgrade_2.3.32-beta-rc21.xml','');

        $this->assertEqual(count($aVersions[2][3][33]),2,'');
        $this->assertEqual(count($aVersions[2][3][33]['-beta']),1,'');
        $this->assertEqual($aVersions[2][3][33]['-beta']['file'],'openads_upgrade_2.3.33-beta.xml','');
        $this->assertEqual(count($aVersions[2][3][33]['-beta-rc']),2,'');
        $this->assertEqual($aVersions[2][3][33]['-beta-rc'][1]['file'],'openads_upgrade_2.3.33-beta-rc1.xml','');
        $this->assertEqual($aVersions[2][3][33]['-beta-rc'][2]['file'],'openads_upgrade_2.3.33-beta-rc2.xml','');

        $this->assertEqual(count($aVersions[2][4]),2,'');
        $this->assertEqual(count($aVersions[2][4][0]),1,'');
        $this->assertEqual($aVersions[2][4][0]['file'],'openads_upgrade_2.4.0.xml','');
        $this->assertEqual(count($aVersions[2][4][1]),2,'');
        $this->assertEqual(count($aVersions[2][4][1]['-rc']),2,'');
        $this->assertEqual($aVersions[2][4][1]['-rc'][1]['file'],'openads_upgrade_2.4.1-rc1.xml','');
        $this->assertEqual($aVersions[2][4][1]['-rc'][5]['file'],'openads_upgrade_2.4.1-rc5.xml','');
        $this->assertEqual($aVersions[2][4][1]['file'],'openads_upgrade_2.4.1.xml','');
    }

    function test_getUpgradePackagesList()
    {
        global $writePath, $writeFile;

        $oUpgrade  = new OA_Upgrade();

        $aVersions = $oUpgrade->_readUpgradePackagesArray($writePath.$writeFile);

        $verPrev = '2.3.32-beta-rc1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),12,$verPrev);

        $verPrev = '2.3.32-beta-rc2';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),11,$verPrev);

        $verPrev = '2.3.32-beta-rc3';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),11,$verPrev);

        $verPrev = '2.3.32-beta-rc4';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),11,$verPrev);

        $verPrev = '2.3.32-beta-rc5';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);

        $verPrev = '2.3.32-beta-rc6';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);

        $verPrev = '2.3.32-beta-rc7';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);

        $verPrev = '2.3.32-beta-rc8';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);

        $verPrev = '2.3.32-beta-rc9';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);

        $verPrev = '2.3.32-beta-rc10';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),9,$verPrev);

        $verPrev = '2.3.32-beta-rc20';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),9,$verPrev);

        $verPrev = '2.3.32-beta-rc21';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),8,$verPrev);

        $verPrev = '2.3.32-beta';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),7,$verPrev);

        $verPrev = '2.3.33-beta-rc1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),6,$verPrev);

        $verPrev = '2.3.33-beta-rc2';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),5,$verPrev);

        $verPrev = '2.3.33-beta';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),4,$verPrev);

        $verPrev = '2.4.0';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),3,$verPrev);

        $verPrev = '2.4.1-rc1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),2,$verPrev);

        $verPrev = '2.4.1-rc5';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),1,$verPrev);

        $verPrev = '2.4.1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),0,$verPrev);

        if (file_exists($writeFile))
        {
            unlink($writeFile);
        }
    }

    function test_runScript()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->upgradePath = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $this->assertTrue($oUpgrade->runScript('prescript_openads_upgrade_1_to_2.php', 'prescript'));
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
        $this->test_writeRecoveryFile();
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


        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor'.rand(),
            array('logDatabaseAction')
        );

        $oUpgrade->oDBAuditor = new $mockAuditor($this);
        $oUpgrade->oDBAuditor->setReturnValue('logDatabaseAction', true);

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

        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor'.rand(),
            array('logDatabaseAction')
        );

        $oUpgrade->oDBAuditor = new $mockAuditor($this);
        $oUpgrade->oDBAuditor->setReturnValue('logDatabaseAction', true);

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

        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor'.rand(),
            array('logDatabaseAction')
        );

        $oUpgrade->oDBAuditor = new $mockAuditor($this);
        $oUpgrade->oDBAuditor->setReturnValue('logDatabaseAction', true);

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
