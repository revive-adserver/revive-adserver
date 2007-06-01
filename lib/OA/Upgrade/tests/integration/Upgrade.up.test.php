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
require_once MAX_PATH.'/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_OA_Upgrade extends UnitTestCase
{
    var $prefix;

    /**
     * The constructor method.
     */
    function Test_OA_Upgrade()
    {
        $this->UnitTestCase();
        $this->prefix  = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    }

    function test_constructor()
    {
        $oUpgrade = new OA_Upgrade();
        $this->assertIsA($oUpgrade->oDBAuditor,'OA_DB_UpgradeAuditor','class mismatch: OA_DB_UpgradeAuditor');
        $this->assertIsA($oUpgrade->oDBUpgrader,'OA_DB_Upgrade','class mismatch: OA_DB_Upgrade');
        $this->assertIsA($oUpgrade->oLogger,'OA_UpgradeLogger','class mismatch: OA_UpgradeLogger');
        $this->assertIsA($oUpgrade->oParser,'OA_UpgradePackageParser','class mismatch: OA_UpgradePackageParser');
        $this->assertIsA($oUpgrade->oVersioner,'OA_Version_Controller','class mismatch: OA_Version_Controller');
        $this->assertIsA($oUpgrade->oPAN,'OA_phpAdsNew','class mismatch: OA_phpAdsNew');
        $this->assertIsA($oUpgrade->oSystemMgr,'OA_Environment_Manager','class mismatch: OA_Environment_Manager');
        $this->assertIsA($oUpgrade->oConfiguration,'OA_Upgrade_Config','class mismatch: OA_Upgrade_Config');
        $this->assertIsA($oUpgrade->oTable,'OA_DB_Table','class mismatch: OA_DB_Table');
    }

    function test_initDatabaseConnection()
    {
        $oUpgrade = new OA_Upgrade();
        $oUpgrade->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $oUpgrade->initDatabaseConnection();
        $this->assertIsA($oUpgrade->oDbh,'MDB2_driver_Common','class mismatch: MDB2_driver_Common');
    }

    function test_install()
    {
//        $oUpgrade = new OA_Upgrade();
//
//        $aDsnOld = $GLOBALS['_MAX']['CONF']['database'];
//        $aTblOld = $GLOBALS['_MAX']['CONF']['table'];
//
//        $aDsn['database']           = $aDsnOld;
//        $aDsn['table']              = $aTblOld;
//        $aDsn['database']['name']   = 'openads_install';
//        $aDsn['table']['prefix']    = 'oa_';
//
//        OA_DB::dropDatabase($aDsn['database']['name']);
//        $oUpgrade->install($aDsn);
//        //OA_DB::dropDatabase($aDsn['database']['name']);
//
//        $GLOBALS['_MAX']['CONF']['database'] = $aDsnOld;
//        $GLOBALS['_MAX']['CONF']['table']    = $aTblOld;
    }

    function test_getUpgradeLogFileName()
    {
        $oUpgrade = new OA_Upgrade();
        $pattern = '/openads_upgrade_1_to_2_constructive_[\d]{4}_[\d]{2}_[\d]{2}_[\d]{2}_[\d]{2}_[\d]{2}\.log/';
        $logfile = $oUpgrade->_getUpgradeLogFileName('openads_upgrade_1_to_2','constructive');
        $this->assertWantedPattern($pattern, $logfile, 'wrong logfile pattern');

    }

    function testcheckPermissionToCreateTable()
    {
        $oUpgrade = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();
        $this->assertIsA($oUpgrade->oDbh,'MDB2_driver_Common','class mismatch: MDB2_driver_Common');
        $this->assertTrue($oUpgrade->checkPermissionToCreateTable(),'database permissions');
    }

    function test_parseUpgradePackageFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $testid    = 'openads_upgrade_1_to_2';
        $testfile  = $testid.'.xml';
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        if (file_exists($testpath.$testfile))
        {
            $this->assertTrue(copy($testpath.$testfile, $oUpgrade->upgradePath.$testfile));
        }
        $this->assertTrue(file_exists($oUpgrade->upgradePath.$testfile));

        $oUpgrade->_parseUpgradePackageFile($testpath.$testfile);
        $this->assertIsA($oUpgrade->aPackage,'array','problem with package array');
        $this->assertTrue(array_key_exists('db_pkgs',$oUpgrade->aPackage),'problem with package array: no db_pkgs element');
        $this->assertIsA($oUpgrade->aDBPackages,'array','problem with db packages array');


        $this->assertIsA($oUpgrade->aPackage,'array','problem with package array');
        $this->assertTrue(array_key_exists('db_pkgs',$oUpgrade->aPackage),'problem with package array: no db_pkgs element');
        $aDBPackages = $oUpgrade->aPackage['db_pkgs'];
        $this->assertIsA($aDBPackages,'array','problem with db packages array');

        $this->assertEqual($oUpgrade->aPackage['name'],'Openads','wrong value: name');
        $this->assertEqual($oUpgrade->aPackage['creationDate'],'2007-01-01','wrong value: creationDate');
        $this->assertEqual($oUpgrade->aPackage['author'],'Test Author','wrong value: author');
        $this->assertEqual($oUpgrade->aPackage['authorEmail'],'test@openads.org','wrong value: authorEmail');
        $this->assertEqual($oUpgrade->aPackage['authorUrl'],'http://www.openads.org','wrong value: authorUrl');
        $this->assertEqual($oUpgrade->aPackage['license'],'LICENSE.txt','wrong value: license');
        $this->assertEqual($oUpgrade->aPackage['description'],'Openads Upgrade Test 1 to 2','wrong value: description');
        $this->assertEqual($oUpgrade->aPackage['versionFrom'],'1','wrong value: versionFrom');
        $this->assertEqual($oUpgrade->aPackage['versionTo'],'2','wrong value: versionTo');

        $this->assertEqual($oUpgrade->aPackage['prescript'],'prescript_openads_upgrade_1_to_2.php','wrong value: prescript');
        $this->assertEqual($oUpgrade->aPackage['postscript'],'postscript_openads_upgrade_1_to_2.php','wrong value: postscript');


        $this->assertEqual($oUpgrade->aDBPackages[0]['schema'],'tables_core','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['version'],'2','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['prescript'],'prescript_tables_core_2.php','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['postscript'],'postscript_tables_core_2.php','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['files'][0],'schema_tables_core_2.xml','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['files'][1],'changes_tables_core_2.xml','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['files'][2],'migration_tables_core_2.php','');

        if (file_exists($oUpgrade->upgradePath.$testfile))
        {
            unlink($oUpgrade->upgradePath.$testfile);
        }
    }

    /**
     * testing for invalid version to upgrade and upgrade required
     * does not test for absent database
     *
     */
    function test_checkExistingTables()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();

        $this->_createTestTableConfig($oUpgrade->oDbh, 'preference');

        // pan config exists
        $this->assertFalse($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();

        $this->_createTestTableConfig($oUpgrade->oDbh, 'config');

        // both configs exist
        $this->assertFalse($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();

        $this->_dropTestTableConfig($oUpgrade->oDbh, 'preference');

        // max config exists
        $this->assertFalse($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();

        $this->_dropTestTableConfig($oUpgrade->oDbh, 'config');

        // no config exists but other prefixed tables do exist
        $this->_createTestTableConfig($oUpgrade->oDbh, 'other');
        $this->assertFalse($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();
        $this->_dropTestTableConfig($oUpgrade->oDbh, 'other');

        // no config or other prefixed tables exist
        $prefix = $oUpgrade->aDsn['table']['prefix'];
        $oUpgrade->aDsn['table']['prefix'] = 'xxx_';
        $this->assertTrue($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();
    }

    function _createTestTableConfig($oDbh, $name)
    {
        //$this->_dropTestTableConfig($oDbh, $name);
        //$conf = &$GLOBALS['_MAX']['CONF'];
        //$conf['table']['prefix'] = 'test_';
        //$conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oTable->init($testpath.'schema_test_config.xml');
        $this->assertTrue($oTable->createTable($name),'error creating '.$this->prefix.$name);
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertTrue(in_array($this->prefix.$name, $aExistingTables), '_createTestTableConfig');
    }

    function _dropTestTableConfig($oDbh, $name)
    {
        //$conf = &$GLOBALS['_MAX']['CONF'];
        //$conf['table']['prefix'] = 'test_';
        //$conf['table']['split'] = false;
        $oTable = new OA_DB_Table();
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oTable->init($testpath.'schema_test_config.xml');
        $aExistingTables = $oDbh->manager->listTables();
        if (in_array($this->prefix.$name, $aExistingTables))
        {
            $this->assertTrue($oTable->dropTable($this->prefix.$name),'error dropping test '.$this->prefix.$name);
        }
        $aExistingTables = $oDbh->manager->listTables();
        $this->assertFalse(in_array($this->prefix.$name, $aExistingTables), '_dropTestTableConfig');
    }

    /**
     * testing for invalid version to upgrade and upgrade required
     * does not test for absent database
     *
     */
    function test_detectPAN()
    {
        Mock::generatePartial(
            'OA_Upgrade',
            'OA_Upgrade_for_detectPAN',
            array('initDatabaseConnection')
        );
        $oUpgrade = new OA_Upgrade_for_detectPAN($this);
        $oUpgrade->setReturnValue('initDatabaseConnection', true);
        $oUpgrade->expectOnce('initDatabaseConnection');
        $oUpgrade->OA_Upgrade();

        Mock::generatePartial(
            'OA_phpAdsNew',
            'OA_phpAdsNew_for_detectPAN',
            array('init', 'getPANversion')
        );

        $oUpgrade->oPAN = new OA_phpAdsNew_for_detectPAN($this);
        $oUpgrade->oPAN->setReturnValue('init', true);
        $oUpgrade->oPAN->expectCallCount('init', 2);
        $oUpgrade->oPAN->setReturnValueAt(0, 'getPANversion', '200.311');
        $oUpgrade->oPAN->expectCallCount('getPANversion',2);
        $oUpgrade->oPAN->setReturnValueAt(1, 'getPANversion', '200.313');

        $oUpgrade->oPAN->detected = true;
        $oUpgrade->oPAN->aDsn['database']['name'] = 'pan_test';
        $oUpgrade->oPAN->oDbh = null;

        Mock::generatePartial(
            'OA_DB_Integrity',
            'OA_DB_Integrity_for_detectPAN',
            array('checkIntegrityQuick')
        );
        $oUpgrade->oIntegrity = new OA_DB_Integrity_for_detectPAN($this);
        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
        $oUpgrade->oIntegrity->expectOnce('checkIntegrityQuick');

        $this->assertFalse($oUpgrade->detectPAN(),'');
        $this->assertEqual($oUpgrade->versionInitialApplication,'200.311','wrong initial application version');
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_PAN_VERSION_FAILED,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->package_file, '', 'wrong package file assigned');

        $this->assertTrue($oUpgrade->detectPAN(),'');
        $this->assertEqual($oUpgrade->versionInitialApplication,'200.313','wrong initial application version');
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->package_file, 'openads_upgrade_2.0.11_to_2.3.32_beta.xml','wrong package file assigned');

        $this->assertEqual($GLOBALS['_MAX']['CONF']['database']['name'], 'pan_test', '');

        $oUpgrade->tally();
        $oUpgrade->oPAN->tally();
        $oUpgrade->oIntegrity->tally();

        TestEnv::restoreConfig();
    }

    /**
     * testing for invalid version to upgrade and upgrade required
     * does not test for absent database
     *
     */
    function test_detectMax()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();

        Mock::generatePartial(
            'OA_DB_Integrity',
            'OA_DB_Integrity_for_detectMax',
            array('checkIntegrityQuick')
        );
        $oUpgrade->oIntegrity = new OA_DB_Integrity_for_detectMax($this);
        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
        $oUpgrade->oIntegrity->expectOnce('checkIntegrityQuick');

        $this->_createTestAppVarRecord('max_version','v0.3.30-alpha');
        $this->assertFalse($oUpgrade->detectMAX(),'');
        $this->assertEqual($oUpgrade->versionInitialApplication,'v0.3.30-alpha','wrong initial application version');
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_MAX_VERSION_FAILED,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->package_file, '', 'wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('max_version');

        $this->_createTestAppVarRecord('max_version','v0.3.31-alpha');
        $this->assertTrue($oUpgrade->detectMAX(),'');
        $this->assertEqual($oUpgrade->versionInitialApplication,'v0.3.31-alpha','wrong initial application version');
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->package_file, 'openads_upgrade_2.3.31_to_2.3.32_beta.xml','wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('max_version');

        $oUpgrade->oIntegrity->tally();
    }

    /**
     * testing for upgrade required and no upgrade required
     * does not test for absent database
     *
     */
    function test_detectOpenads()
    {
        $oUpgrade  = new OA_Upgrade();
        //$oUpgrade->initDatabaseConnection();

        Mock::generatePartial(
            'OA_DB_Integrity',
            $mockInteg = 'OA_DB_Integrity'.rand(),
            array('checkIntegrityQuick')
        );
        $oUpgrade->oIntegrity = new $mockInteg($this);
        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
        $oUpgrade->oIntegrity->expectOnce('checkIntegrityQuick');


        $GLOBALS['_MAX']['CONF']['openads']['installed'] = true;
        $this->_createTestAppVarRecord('oa_version','2.3.31-beta');
        $this->assertTrue($oUpgrade->detectOpenads(),'');
        $this->assertEqual($oUpgrade->versionInitialApplication,'2.3.31-beta','wrong initial application version');
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->package_file, 'openads_upgrade_2.3.32_to_2.3.33_beta.xml','wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('oa_version');

        $this->_createTestAppVarRecord('oa_version',OA_VERSION);
        $this->assertTrue($oUpgrade->detectOpenads(),'');
        $this->assertEqual($oUpgrade->versionInitialApplication,OA_VERSION,'wrong initial application version');
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CURRENT_VERSION,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->package_file, '', 'wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('oa_version');

        $oUpgrade->oIntegrity->tally();
    }

    /**
     * tests a set of constructive & destructive changes
     * over 2 upgrade packages
     * and ensures that they rollback correctly
     *
     */
    function test_schemaUpgradeRollback()
    {
        $this->_deleteTestAppVarRecord('tables_core', '');
        $this->assertEqual($this->_getTestAppVarValue('tables_core', ''), '', '');
        $this->_createTestAppVarRecord('tables_core', '997');
        $this->assertEqual($this->_getTestAppVarValue('tables_core', '997'), '997', '');

        $this->_createTestAppVarRecord('oa_version','2.3.97');
        $oUpgrade->versionInitialSchema['tables_core'] = 997;
        $oUpgrade->versionInitialApplication = '2.3.97';

        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->upgradePath = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oUpgrade->oDBUpgrader->path_changes = $oUpgrade->upgradePath;
        $oUpgrade->oDBUpgrader->path_schema = $oUpgrade->upgradePath;
        $input_file = 'openads_upgrade_2.3.97_to_2.3.99_beta.xml';
        $oUpgrade->initDatabaseConnection();
        $oUpgrade->_parseUpgradePackageFile($oUpgrade->upgradePath.$input_file);

        $this->assertTrue($oUpgrade->upgradeSchemas(),'upgradeSchemas');

        $this->_checkTablesUpgraded($oUpgrade);
        $this->assertEqual($this->_getTestAppVarValue('tables_core', '999'), '999', '');

        $this->assertTrue($oUpgrade->rollbackSchemas(),'rollbackSchemas');

        $this->assertEqual($this->_getTestAppVarValue('tables_core', '997'), '997', '');

        $this->_checkTablesRolledBack($oUpgrade);

        // remove the fake application variable records
        $this->_deleteTestAppVarRecordAllNames('oa_version');
        $this->_deleteTestAppVarRecordAllNames('tables_core');
    }

    /**
     * tests a set of constructive & destructive changes
     * over 2 upgrade packages
     * emulates an interruption, dropping a recovery file
     * ensure that the recovery info is read correctly
     * and that the tables are restored correctly
     *
     */
    function test_recover()
    {
        $schema = 'tables_core';

        $this->_createTestAppVarRecord($schema, '997');
        $this->assertEqual($this->_getTestAppVarValue($schema, '997'), '997', '');

        $oUpgrade  = new OA_Upgrade();

        // divert objects to test data
        $oUpgrade->upgradePath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oUpgrade->oDBUpgrader->path_changes = $oUpgrade->upgradePath;
        $oUpgrade->oDBUpgrader->path_schema = $oUpgrade->upgradePath;
        $oUpgrade->package_file = 'openads_upgrade_2.3.97_to_2.3.99_beta.xml';
        $oDB_Upgrade->logFile = MAX_PATH . "/var/DB_Upgrade.dev.test.log";

        // just in case of error, lose this so we can continue afresh
        $oUpgrade->_pickupRecoveryFile();

        // fake the versions we are starting with
        $this->_createTestAppVarRecord('oa_version', '2.3.97');
        $oUpgrade->versionInitialSchema[$schema] = 997;
        $oUpgrade->versionInitialApplication = '0.3.31';

        // perform a good upgrade
        $this->assertTrue($oUpgrade->upgrade($oUpgrade->package_file),'upgrade');

        // check the upgraded tables
        $this->_checkTablesUpgraded($oUpgrade);
        $this->assertEqual($this->_getTestAppVarValue($schema, '999'), '999', '');

        // emulate a partial upgrade...
        $this->assertTrue($oUpgrade->_writeRecoveryFile($schema, 998),'failed to write recovery file');
        $this->assertTrue($oUpgrade->_writeRecoveryFile($schema, 999),'failed to write recovery file');

        // perform recovery
        $this->assertTrue($oUpgrade->recoverUpgrade(),'recoverUpgrade');

        // check the restored tables
        $this->_checkTablesRolledBack($oUpgrade);
        $this->assertEqual($this->_getTestAppVarValue($schema, '997'), '997', '');

        // remove the fake application variable records
        $this->_deleteTestAppVarRecordAllNames('oa_version');
        $this->_deleteTestAppVarRecordAllNames($schema);

        // just in case of error, lose this so we can continue afresh
        $oUpgrade->_pickupRecoveryFile();
    }

    function _checkTablesUpgraded($oUpgrade)
    {
        $aDBTables = $oUpgrade->oDBUpgrader->_listTables();
        $this->assertTrue(in_array($this->prefix.'aardvark',$aDBTables), 'aardvark was not found');
        $this->assertTrue(in_array($this->prefix.'bandicoot',$aDBTables), 'bandicoot was not found');
        $this->assertFalse(in_array($this->prefix.'affiliates',$aDBTables), 'affiliates was found');

        $aDBFields = $oUpgrade->oDBUpgrader->oSchema->db->manager->listTableFields($this->prefix.'campaigns');

        $this->assertFalse(in_array('campaignid',$aDBFields), 'campaignid was found');
        $this->assertTrue(in_array('campaign_id',$aDBFields), 'campaign_id was not found');

        $aDBFields = $oUpgrade->oDBUpgrader->oSchema->db->manager->listTableFields($this->prefix.'acls_channel');

        $this->assertFalse(in_array('channelid',$aDBFields), 'channelid was found');
        $this->assertTrue(in_array('channel_id',$aDBFields), 'channel_id was not found');
        $this->assertTrue(in_array('newfield',$aDBFields), 'newfield was not found');

    }

    function _checkTablesRolledBack($oUpgrade)
    {
        $aDBTables = $oUpgrade->oDBUpgrader->_listTables();

        $this->assertFalse(in_array($this->prefix.'aardvark',$aDBTables), 'aardvark was not found');
        $this->assertFalse(in_array($this->prefix.'bandicoot',$aDBTables), 'bandicoot was not found');
        $this->assertTrue(in_array($this->prefix.'affiliates',$aDBTables), 'affiliates was found');

        $aDBFields = $oUpgrade->oDBUpgrader->oSchema->db->manager->listTableFields($this->prefix.'campaigns');

        $this->assertTrue(in_array('campaignid',$aDBFields), 'campaignid was not found');
        $this->assertFalse(in_array('campaign_id',$aDBFields), 'campaign_id was found');

        $aDBFields = $oUpgrade->oDBUpgrader->oSchema->db->manager->listTableFields($this->prefix.'acls_channel');

        $this->assertTrue(in_array('channelid',$aDBFields), 'channelid was not found');
        $this->assertFalse(in_array('channel_id',$aDBFields), 'channel_id was found');
        $this->assertFalse(in_array('newfield',$aDBFields), 'newfield was found');
    }

    function _createTestAppVarRecord($name, $value)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->value   = $value;
        $doApplicationVariable->delete();
        return DataGenerator::generateOne($doApplicationVariable);
    }

    function _getTestAppVarValue($name, $value)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->find();
        $doApplicationVariable->fetch();
        return $doApplicationVariable->value;
    }

    function _deleteTestAppVarRecord($name, $value)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->value   = $value;
        $doApplicationVariable->delete();
    }

    function _deleteTestAppVarRecordAllNames($name)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->delete();
    }
}

?>
