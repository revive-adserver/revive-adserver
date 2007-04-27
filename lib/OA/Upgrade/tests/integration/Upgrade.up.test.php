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
require_once MAX_PATH.'/lib/max/tests/util/DataGenerator.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
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

//    function setUp()
//    {
//        $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
//        $this->oTable = new OA_DB_Table();
//        $this->oTable->init(MAX_PATH.'/lib/OA/Upgrade/tests/integration/migration_test_1.xml');
//        $this->aDefinition = $this->oTable->aDefinition;
//    }

    function test_constructor()
    {
        $oUpgrade = new OA_Upgrade();
        $this->assertIsA($oUpgrade->oDBAuditor,'OA_DB_UpgradeAuditor','class mismatch: OA_DB_UpgradeAuditor');
        $this->assertIsA($oUpgrade->oDbh,'MDB2_driver_Common','class mismatch: MDB2_driver_Common');
        $this->assertIsA($oUpgrade->oDBUpgrader,'OA_DB_Upgrade','class mismatch: OA_DB_Upgrade');
        $this->assertIsA($oUpgrade->oLogger,'OA_UpgradeLogger','class mismatch: OA_UpgradeLogger');
        $this->assertIsA($oUpgrade->oParser,'OA_UpgradePackageParser','class mismatch: OA_UpgradePackageParser');
        $this->assertIsA($oUpgrade->oVersioner,'OA_Version_Controller','class mismatch: OA_Version_Controller');
    }

    function test_init()
    {
        $oUpgrade  = new OA_Upgrade();
        $testid    = 'openads_upgrade_1_to_2';
        $testfile  = $testid.'.xml';
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/unit/';
        if (file_exists($testpath.$testfile))
        {
            $this->assertTrue(copy($testpath.$testfile, $oUpgrade->upgradePath.$testfile));
        }
        $this->assertTrue(file_exists($oUpgrade->upgradePath.$testfile));

        $oUpgrade->init($testfile);
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

        $this->assertEqual($oUpgrade->aPackage['preinstallfile'],'do_this_first.php','wrong value: preinstallfile');
        $this->assertEqual($oUpgrade->aPackage['postinstallfile'],'do_this_last.php','wrong value: postinstallfile');


        $this->assertEqual($oUpgrade->aDBPackages[0]['schema'],'tables_core','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['version'],'2','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['files'][0],'schema_tables_core_2.xml','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['files'][1],'changes_tables_core_2.xml','');
        $this->assertEqual($oUpgrade->aDBPackages[0]['files'][2],'migration_tables_core_2.php','');

        $logpattern = '/openads_upgrade_1_to_2_constructive_[\d]{4}_[\d]{2}_[\d]{2}_[\d]{2}_[\d]{2}_[\d]{2}\.log/';
        $this->assertWantedPattern($logpattern, basename($oUpgrade->oLogger->logFile), '');

        if (file_exists($oUpgrade->upgradePath.$testfile))
        {
            unlink($oUpgrade->upgradePath.$testfile);
        }
    }

    function test_detectOpenads()
    {
        $oUpgrade  = new OA_Upgrade();

        $this->_createTestAppVarRecord('oa_version','1');

        $oUpgrade->detectOpenads();
        $this->assertEqual($oUpgrade->versionInitialApplication,1,'wrong initial application version');

        $this->_deleteTestAppVarRecord('oa_version','1');
        $oUpgrade->detectOpenads();
        $this->assertEqual($oUpgrade->versionInitialApplication,0,'wrong initial application version');

    }

    function _createTestAppVarRecord($name, $value)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->value   = $value;
        $doApplicationVariable->delete();
        return DataGenerator::generateOne($doApplicationVariable);
    }

    function _deleteTestAppVarRecord($name, $value)
    {
        $doApplicationVariable          = OA_Dal::factoryDO('application_variable');
        $doApplicationVariable->name    = $name;
        $doApplicationVariable->value   = $value;
        $doApplicationVariable->delete();
    }


}

?>
