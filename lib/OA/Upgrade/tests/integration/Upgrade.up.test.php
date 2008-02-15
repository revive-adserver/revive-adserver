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


require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
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
        $this->assertIsA($oUpgrade->oAuditor,'OA_UpgradeAuditor','class mismatch: OA_UpgradeAuditor');
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
        $oUpgrade->package_file = 'openads_upgrade_1_to_2.xml';
        $pattern = '/openads_upgrade_1_to_2_[\d]{4}_[\d]{2}_[\d]{2}_[\d]{2}_[\d]{2}_[\d]{2}\.log/';
        $logfile = $oUpgrade->_getUpgradeLogFileName();
        $this->assertWantedPattern($pattern, $logfile, 'wrong logfile pattern: '.$logfile);
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
        $this->assertEqual($oUpgrade->aPackage['authorUrl'],'http://www.openx.org','wrong value: authorUrl');
        $this->assertEqual($oUpgrade->aPackage['license'],'LICENSE.txt','wrong value: license');
        $this->assertEqual($oUpgrade->aPackage['description'],'OpenXUpgrade Test 1 to 2','wrong value: description');
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
     * ensure this runs without error
     *
     */
    function test_checkPermissionToCreateTable()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->initDatabaseConnection();
        $this->assertTrue($oUpgrade->checkPermissionToCreateTable(),'failed permissions check for test user');
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

        $this->_dropTestTable($oUpgrade->oDbh, 'preference');

        // max config exists
        $this->assertFalse($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();

        $this->_dropTestTable($oUpgrade->oDbh, 'config');

        // no config exists but other prefixed tables do exist
        $this->_createTestTableConfig($oUpgrade->oDbh, 'other');
        $this->assertFalse($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();
        $this->_dropTestTable($oUpgrade->oDbh, 'other');

        // no config or other prefixed tables exist
        $prefix = $oUpgrade->aDsn['table']['prefix'];
        $oUpgrade->aDsn['table']['prefix'] = 'xxx_';
        $this->assertTrue($oUpgrade->checkExistingTables(),'');
        $oUpgrade->oLogger->logClear();
    }

    function _createTestTableConfig($oDbh, $name)
    {
        $oTable = new OA_DB_Table();
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oTable->init($testpath.'schema_test_config.xml');
        $this->assertTrue($oTable->createTable($name),'error creating '.$this->prefix.$name);
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertTrue(in_array($this->prefix.$name, $aExistingTables), '_createTestTableConfig');
    }

    function _dropTestTable($oDbh, $name)
    {
        $oTable = new OA_DB_Table();
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oTable->init($testpath.'schema_test_config.xml');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        if (in_array($this->prefix.$name, $aExistingTables))
        {
            $this->assertTrue($oTable->dropTable($this->prefix.$name),'error dropping test '.$this->prefix.$name);
        }
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertFalse(in_array($this->prefix.$name, $aExistingTables), '_dropTestTableConfig');
    }

    function _dropAuditTables($oDbh)
    {
        $oTable = new OA_DB_Table();
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oTable->init($testpath.'schema_test_config.xml');
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        if (in_array($this->prefix.'database_action', $aExistingTables))
        {
            $this->assertTrue($oTable->dropTable($this->prefix.'database_action'),'error dropping test '.$this->prefix.'database_action');
        }
        if (in_array($this->prefix.'upgrade_action', $aExistingTables))
        {
            $this->assertTrue($oTable->dropTable($this->prefix.'upgrade_action'),'error dropping test '.$this->prefix.'upgrade_action');
        }
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        $this->assertFalse(in_array($this->prefix.'database_action', $aExistingTables), 'database_action');
        $this->assertFalse(in_array($this->prefix.'upgrade_action', $aExistingTables), 'upgrade_action');
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
        $oUpgrade->expectCallCount('initDatabaseConnection', 2);
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

//        Mock::generatePartial(
//            'OA_DB_Integrity',
//            'OA_DB_Integrity_for_detectPAN',
//            array('checkIntegrityQuick')
//        );
//        $oUpgrade->oIntegrity = new OA_DB_Integrity_for_detectPAN($this);
//        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
//        $oUpgrade->oIntegrity->expectOnce('checkIntegrityQuick');

        $this->assertFalse($oUpgrade->detectPAN(true),'PAN not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'200.311','wrong initial application version expected 200.311 got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_PAN_NOT_INSTALLED,'wrong upgrade status code, expected '.OA_STATUS_PAN_NOT_INSTALLED.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], '', 'wrong package file assigned');

        $this->assertTrue($oUpgrade->detectPAN(true),'PAN not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'200.313','wrong initial application version expected 200.313 got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code, expected '.OA_STATUS_CAN_UPGRADE.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], 'openads_upgrade_2.0.11_to_2.3.32_beta.xml','wrong package file assigned');

        $this->assertEqual($GLOBALS['_MAX']['CONF']['database']['name'], 'pan_test', '');

        $oUpgrade->tally();
        $oUpgrade->oPAN->tally();
//        $oUpgrade->oIntegrity->tally();

        TestEnv::restoreConfig();
    }

    /**
     * testing for invalid version to upgrade and upgrade required
     * does not test for absent database
     *
     */
    function test_detectMAX01()
    {
        Mock::generatePartial(
            'OA_Upgrade',
            'OA_Upgrade_for_detectM01',
            array('initDatabaseConnection')
        );
        $oUpgrade = new OA_Upgrade_for_detectM01($this);
        $oUpgrade->setReturnValue('initDatabaseConnection', true);
        $oUpgrade->expectCallCount('initDatabaseConnection', 3);
        $oUpgrade->OA_Upgrade();

        Mock::generatePartial(
            'OA_phpAdsNew',
            'OA_phpAdsNew_for_detectM01',
            array('init', 'getPANversion')
        );

        $oUpgrade->oPAN = new OA_phpAdsNew_for_detectPAN($this);
        $oUpgrade->oPAN->setReturnValue('init', true);
        $oUpgrade->oPAN->expectCallCount('init', 2);
        $oUpgrade->oPAN->setReturnValueAt(0, 'getPANversion', '0.000');
        $oUpgrade->oPAN->expectCallCount('getPANversion',2);
        $oUpgrade->oPAN->setReturnValueAt(1, 'getPANversion', '0.100');

        $oUpgrade->oPAN->detected = true;
        $oUpgrade->oPAN->aDsn['database']['name'] = 'm01_test';
        $oUpgrade->oPAN->oDbh = null;

//        Mock::generatePartial(
//            'OA_DB_Integrity',
//            'OA_DB_Integrity_for_detectM01',
//            array('checkIntegrityQuick')
//        );
//        $oUpgrade->oIntegrity = new OA_DB_Integrity_for_detectPAN($this);
//        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
//        $oUpgrade->oIntegrity->expectOnce('checkIntegrityQuick');

        $this->assertFalse($oUpgrade->detectMAX01(true),'Max 0.1 not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'0.000','wrong initial application version expected 0.000 got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_M01_VERSION_FAILED,'wrong upgrade status code, expected '.OA_STATUS_M01_VERSION_FAILED.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], '', 'wrong package file assigned');

        $this->assertTrue($oUpgrade->detectMAX01(true),'Max 0.1 not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'0.100','wrong initial application version expected 0.100 got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code, expected '.OA_STATUS_CAN_UPGRADE.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], 'openads_upgrade_2.1.29_to_2.3.32_beta.xml','wrong package file assigned');

        $this->assertEqual($GLOBALS['_MAX']['CONF']['database']['name'], 'm01_test', '');

        $oUpgrade->tally();
        $oUpgrade->oPAN->tally();
//        $oUpgrade->oIntegrity->tally();

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

//        Mock::generatePartial(
//            'OA_DB_Integrity',
//            'OA_DB_Integrity_for_detectMax',
//            array('checkIntegrityQuick')
//        );
//        $oUpgrade->oIntegrity = new OA_DB_Integrity_for_detectMax($this);
//        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
//        $oUpgrade->oIntegrity->expectOnce('checkIntegrityQuick');

        $this->_createTestAppVarRecord('max_version','v0.3.30-alpha');
        $this->assertFalse($oUpgrade->detectMAX(true),'Max 0.3 not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'v0.3.30-alpha','wrong initial application version expected v0.3.30-alpha got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_MAX_VERSION_FAILED,'wrong upgrade status code');
        $this->assertEqual($oUpgrade->aPackageList[0], '', 'wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('max_version');

        $this->_createTestAppVarRecord('max_version','v0.3.31-alpha');
        $this->assertTrue($oUpgrade->detectMAX(true),'Max 0.3 not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'v0.3.31-alpha','wrong initial application version expected v0.3.31-alpha got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code, expected '.OA_STATUS_CAN_UPGRADE.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], 'openads_upgrade_2.3.31_to_2.3.32_beta.xml','wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('max_version');

//        $oUpgrade->oIntegrity->tally();
    }

    /**
     * testing for upgrade required and no upgrade required
     * does not test for absent database
     *
     */
    function test_detectOpenads()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->upgradePath = MAX_PATH.'/lib/OA/Upgrade/tests/data/changes/';
        $this->assertNull($oUpgrade->versionInitialApplication,'wrong initial application version expected null got'.$oUpgrade->versionInitialApplication);

        $GLOBALS['_MAX']['CONF']['openads']['installed'] = true;

//        Mock::generatePartial(
//            'OA_DB_Integrity',
//            $mockInteg = 'OA_DB_Integrity'.rand(),
//            array('checkIntegrityQuick')
//        );
//        $oUpgrade->oIntegrity = new $mockInteg($this);
//        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);
//        $oUpgrade->oIntegrity->expectCallCount('checkIntegrityQuick',2);

        $this->_createTestAppVarRecord('oa_version','2.3.31-beta');
        $this->assertTrue($oUpgrade->detectOpenads(true),'openads not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'2.3.31-beta','wrong initial application version expected 2.3.31-beta got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code, expected '.OA_STATUS_CAN_UPGRADE.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], 'openads_upgrade_2.3.32-beta-rc2.xml','wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('oa_version');

        $this->_createTestAppVarRecord('oa_version','2.3.32-beta-rc5');
        $this->assertTrue($oUpgrade->detectOpenads(true),'openads not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,'2.3.32-beta-rc5','wrong initial application version expected 2.3.32-beta-rc5 got'.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CAN_UPGRADE,'wrong upgrade status code, expected '.OA_STATUS_CAN_UPGRADE.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], 'openads_upgrade_2.3.32-beta-rc10.xml','wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('oa_version');

        // testing installation is up to date, no upgrade required
        $this->_createTestAppVarRecord('oa_version',OA_VERSION);
        $this->assertFalse($oUpgrade->detectOpenads(true),'openads not detected: found application version '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->versionInitialApplication,OA_VERSION,'wrong initial application version expected '.OA_VERSION.' got '.$oUpgrade->versionInitialApplication);
        $this->assertEqual($oUpgrade->existing_installation_status, OA_STATUS_CURRENT_VERSION,'wrong upgrade status code, expected '.OA_STATUS_CURRENT_VERSION.' got '.$oUpgrade->existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList[0], '', 'wrong package file assigned');
        $this->_deleteTestAppVarRecordAllNames('oa_version');

//        $oUpgrade->oIntegrity->tally();
    }

    /**
     * tests an upgrade package containing two schema upgrades
     *
     */
    function test_upgradeSchemas()
    {
        $this->_deleteTestAppVarRecord('tables_core', '');
        $this->assertEqual($this->_getTestAppVarValue('tables_core', ''), '', '');
        $this->_createTestAppVarRecord('tables_core', '997');
        $this->assertEqual($this->_getTestAppVarValue('tables_core', '997'), '997', '');

        $this->_createTestAppVarRecord('oa_version','2.3.00');
        $oUpgrade->versionInitialSchema['tables_core'] = 997;
        $oUpgrade->versionInitialApplication = '2.3.00';

        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->upgradePath = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $oUpgrade->oDBUpgrader->path_changes = $oUpgrade->upgradePath;
        $oUpgrade->oDBUpgrader->path_schema = $oUpgrade->upgradePath;
        $input_file = 'openads_upgrade_2.3.00_to_2.3.02_beta.xml';
        $oUpgrade->initDatabaseConnection();
        $oUpgrade->_parseUpgradePackageFile($oUpgrade->upgradePath.$input_file);

        $this->assertTrue($oUpgrade->upgradeSchemas(),'upgradeSchemas');

        $this->_checkTablesUpgraded($oUpgrade);
        $this->assertEqual($this->_getTestAppVarValue('tables_core', '999'), '999', '');

        // remove the fake application variable records
        $this->_deleteTestAppVarRecordAllNames('oa_version');
        $this->_deleteTestAppVarRecordAllNames('tables_core');
        TestEnv::restoreConfig();
        TestEnv::restoreEnv();
    }

    /**
     * tests an openads upgrade where a series of upgrade packages may be required
     * the upgrade method will detectOpenXand cycle through the list of upgrade packages
     * executing the upgrade packages in the right order
     * until it runs out of upgrade packages
     * when no more upgrade packages are found
     * the application is stamped with the latest version
     *
     */
    function test_upgradeIncremental()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
                                'OA_Upgrade_Config',
                                $mockConfig = 'OA_Upgrade_Config'.rand(),
                                array('mergeConfig','setupConfigDatabase','setupConfigTable','writeConfig','getConfigBackupName')
                             );
        $oUpgrade->oConfiguration = new $mockConfig($this);

        $oUpgrade->oConfiguration->setReturnValue('setupConfigDatabase', true);
        $oUpgrade->oConfiguration->setReturnValue('setupConfigTable', true);
        $oUpgrade->oConfiguration->setReturnValue('writeConfig', true);

        $oUpgrade->oConfiguration->expectCallCount('mergeConfig', 1);
        $oUpgrade->oConfiguration->setReturnValue('mergeConfig', true);

        $oUpgrade->oConfiguration->expectCallCount('getConfigBackupName', 13);
        for ($i = 0; $i < 13; $i++)
        {
            $oUpgrade->oConfiguration->setReturnValueAt($i, 'getConfigBackupName', $i.'_old.www.mysite.net.conf.php');
            // drop a fake conf backup
            @copy(MAX_PATH.'/var/test.conf.php',MAX_PATH.'/var/'.$i.'_old.www.mysite.net.conf.php');
        }

        // divert objects to test data
        $oUpgrade->upgradePath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/changes/';
        $GLOBALS['_MAX']['CONF']['openads']['installed'] = true;

        $this->_dropTestTable($oUpgrade->oDbh, 'database_action');
        $this->_dropTestTable($oUpgrade->oDbh, 'upgrade_action');

        // just in case of error, lose this so we can continue afresh
        $oUpgrade->_pickupRecoveryFile();
        // fake the versions we are starting with
        $this->_createTestAppVarRecord('oa_version', '2.3.32-beta-rc1');
        // mock the integrity checker
        Mock::generatePartial(
                                'OA_DB_Integrity',
                                $mockInteg = 'OA_DB_Integrity'.rand(),
                                array('checkIntegrityQuick')
                             );
        $oUpgrade->oIntegrity = new $mockInteg($this);
        $oUpgrade->oIntegrity->setReturnValue('checkIntegrityQuick', true);

        // do the initial detection
        $this->assertTrue($oUpgrade->detectOpenads());

        // this should identify 12 upgrade packages to be executed
        // (from /lib/OA/Upgrade/tests/data/changes)
        $this->assertEqual(count($oUpgrade->aPackageList),12,'wrong number of packages in upgrader package list');
        $this->assertIsA($oUpgrade->oAuditor,'OA_UpgradeAuditor','class mismatch: OA_UpgradeAuditor');

        // perform the upgrade
        $this->assertTrue($oUpgrade->upgrade(),'upgrade');

        $aAudit = $oUpgrade->oAuditor->queryAuditAllDescending();
        // we should have 13 records in the upgrade_action audit table
        // we should have 13 logfiles in the var folder
        // one for each package plus a version stamp
        $this->assertEqual(count($aAudit),13,'wrong number of audit records');
        $aPackageList = $oUpgrade->aPackageList;
        krsort($aPackageList, SORT_NUMERIC);
        foreach ($aAudit as $k => $aRec)
        {
            $idx = 12-$k;
            $this->assertEqual($aRec['upgrade_action_id'],$idx+1,'');
            $this->assertEqual($aRec['confbackup'],$idx.'_old.www.mysite.net.conf.php');
            $this->assertTrue(file_exists(MAX_PATH.'/var/'.$aRec['logfile']));
            @unlink(MAX_PATH.'/var/'.$aRec['logfile']);
            if ($k > 0)
            {
                $this->assertEqual($aRec['upgrade_name'],$aPackageList[$idx],'package mismatch: '.$aRec['upgrade_name'].' and '.$aPackageList[$idx]);
            }
            else
            {
                $this->assertEqual($aRec['upgrade_name'],'openads_version_stamp_'.OA_VERSION, 'wrong package name for version stamp');
            }
        }
        // the application variable should match the code version stamp
        $this->assertEqual($oUpgrade->versionInitialApplication,OA_VERSION,'wrong initial application version: '.$oUpgrade->versionInitialApplication);
//        $this->_deleteTestAppVarRecordAllNames('oa_version');

        $oUpgrade->oConfiguration->tally();
        $oUpgrade->oIntegrity->tally();

        TestEnv::restoreConfig();
    }

    /**
     * rollback the upgrade executed during the previous test
     * copy the *fake* RECOVER file to the var folder
     * check the audit trail
     * delete the RECOVER file after
     *
     */
    function test_recoverUpgrade()
    {
        $host = getHostName();
        $confFile = $host.'.conf.php';
        if (file_exists(MAX_PATH.'/var/test_'.$confFile))
        {
            if (! @unlink(MAX_PATH.'/var/test_'.$confFile))
            {
                $this->oLogger->logError('failed to remove the backup configuration file');
                return false;
            }
        }
        if (file_exists(MAX_PATH.'/var/'.$confFile))
        {
            if (! copy(MAX_PATH.'/var/'.$confFile,MAX_PATH.'/var/test_'.$confFile))
            {
                $this->assertTrue(false,'test failed to backup conf file before upgrade recovery');
                return false;
            }
        }

        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->_pickupRecoveryFile();

        $this->_writeTestRecoveryFile();

        $oUpgrade->recoverUpgrade();

        if (file_exists(MAX_PATH.'/var/'.$confFile))
        {
            if (! @unlink(MAX_PATH.'/var/'.$confFile))
            {
                $this->oLogger->logError('failed to remove the backup configuration file');
                return false;
            }
        }
        if (file_exists(MAX_PATH.'/var/test_'.$confFile))
        {
            if (! copy(MAX_PATH.'/var/test_'.$confFile,MAX_PATH.'/var/'.$confFile))
            {
                $this->assertTrue(false,'test failed to restore the test conf file after upgrade recovery');
                return false;
            }
            @unlink(MAX_PATH.'/var/test_'.$confFile);
        }


        $aAudit = $oUpgrade->oAuditor->queryAuditAllDescending();
        // we should have another 13 records in the upgrade_action audit table
        // we should have another 13 logfiles in the var folder
        // we should have 13 backup conf files in the var folder
        // one for each of the 12 packages plus a version stamp *package*
        $this->assertEqual(count($aAudit),26,'wrong number of audit records');

        foreach ($aAudit as $k => $aRec)
        {
            $idx = 25-$k;
            if ($idx >12)
            {
                $this->assertEqual($aRec['upgrade_action_id'],$idx+1,'');
                $this->assertEqual($aRec['action'],UPGRADE_ACTION_ROLLBACK_SUCCEEDED,'wrong action definition');

                $result = $oUpgrade->oAuditor->queryAuditByUpgradeId($k+1);
                $this->assertIsA($result,'array','failed to retrieve the original audit record array');
                $this->assertTrue(isset($result[0]),'failed to retrieve the original audit record');
                $aOriginalAuditRec = $result[0];

                $this->assertEqual($aOriginalAuditRec['confbackup'],'dropped during recovery', 'failure to audit that conf was dropped'); //$aOriginalAuditRec['confbackup']);

                // recovery should restore then drop the backup tables
                if (file_exists(MAX_PATH.'/var/'.($k+11).'_old.www.mysite.net.conf.php'))
                {
                    $this->assertFalse(true,'conf backup was not deleted');
                    @unlink(MAX_PATH.'/var/'.($k+11).'_old.www.mysite.net.conf.php');
                }
                $this->assertTrue(file_exists(MAX_PATH.'/var/'.$aRec['logfile']),'logfile does not exist');
                $this->assertEqual($aRec['logfile'],$aOriginalAuditRec['logfile'].'.rollback','wrong log file');
                @unlink(MAX_PATH.'/var/'.$aRec['logfile']);
                $this->assertEqual($aRec['upgrade_name'],$aOriginalAuditRec['upgrade_name'],'package mismatch: '.$aRec['upgrade_name'].' and '.$aOriginalAuditRec['upgrade_name']);
            }
        }
        // the application variable should match the initial version given in the previous test
        $this->assertEqual($oUpgrade->oVersioner->getApplicationVersion(),'2.3.32-beta-rc1','wrong initial application version: '.$oUpgrade->versionInitialApplication);

        $this->assertFalse(file_exists($oUpgrade->recoveryFile),'recovery file was not deleted after recovery');
        // just in case of error, lose the recovery file so we can continue afresh
        // and not screw up someone's installation next time they run
        $oUpgrade->_pickupRecoveryFile();
        // delete the *restored* dummy conf file
        @unlink(MAX_PATH.'/var/www.mysite.net.conf.php');
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

//        $this->_dropTestTable($oUpgrade->oDbh, 'aardvark');
//        $this->_dropTestTable($oUpgrade->oDbh, 'bandicoot');
    }

//    function _checkTablesRolledBack($oUpgrade)
//    {
//        $aDBTables = $oUpgrade->oDBUpgrader->_listTables();
//
//        $this->assertFalse(in_array($this->prefix.'aardvark',$aDBTables), 'aardvark was not found');
//        $this->assertFalse(in_array($this->prefix.'bandicoot',$aDBTables), 'bandicoot was not found');
//        $this->assertTrue(in_array($this->prefix.'affiliates',$aDBTables), 'affiliates was found');
//
//        $aDBFields = $oUpgrade->oDBUpgrader->oSchema->db->manager->listTableFields($this->prefix.'campaigns');
//
//        $this->assertTrue(in_array('campaignid',$aDBFields), 'campaignid was not found');
//        $this->assertFalse(in_array('campaign_id',$aDBFields), 'campaign_id was found');
//
//        $aDBFields = $oUpgrade->oDBUpgrader->oSchema->db->manager->listTableFields($this->prefix.'acls_channel');
//
//        $this->assertTrue(in_array('channelid',$aDBFields), 'channelid was not found');
//        $this->assertFalse(in_array('channel_id',$aDBFields), 'channel_id was found');
//        $this->assertFalse(in_array('newfield',$aDBFields), 'newfield was found');
//    }

    function _createTestAppVarRecord($name, $value)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->value   = $value;
        $doApplicationVariable->delete();
        $id = DataGenerator::generateOne($doApplicationVariable);
        $this->assertTrue($id,'failed to generate application variable '.$name.'='.$value);
        return $id;
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
        //$doApplicationVariable->value   = $value;
        $doApplicationVariable->delete();
    }

    function _deleteTestAppVarRecordAllNames($name)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->delete();
    }

    function _writeTestRecoveryFile()
    {
        $datapath = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $this->assertTrue(file_exists($datapath.'RECOVER'),'test file RECOVER is missing');
        $this->assertTrue(@copy($datapath.'RECOVER',MAX_PATH.'/var/RECOVER'),'failed to copy test RECOVER file');

        $fp = fopen(MAX_PATH.'/var/RECOVER','a');
        if (is_resource($fp))
        {
            $line = '13/openads_version_stamp_'.OA_VERSION.'/2007-07-02 03:32:39;';
            fwrite($fp, $line);
        }
    }
}

?>
