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

require_once MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php';

/**
 * A class for testing the OpenX Upgrade Package Parser class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 */
class Test_OA_UpgradePackageParser extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function test_parse()
    {
        $oParser   = new OA_UpgradePackageParser();
        $testfile  = 'openads_upgrade_1_to_2.xml';
        $testpath  = MAX_PATH.'/lib/OA/Upgrade/tests/data/';

        $oParser->setInputFile($testpath.$testfile);
        $this->assertTrue($oParser->parse(),'failed to parse input file');
        $aPackage = $oParser->aPackage;

        $this->assertIsA($aPackage,'array','problem with package array');
        $this->assertTrue(array_key_exists('db_pkgs',$aPackage),'problem with package array: no db_pkgs element');
        $aDBPackages = $aPackage['db_pkgs'];
        $this->assertIsA($aDBPackages,'array','problem with db packages array');

        $this->assertEqual($aPackage['name'],'Openads','wrong value: name');
        $this->assertEqual($aPackage['creationDate'],'2007-01-01','wrong value: creationDate');
        $this->assertEqual($aPackage['author'],'Test Author','wrong value: author');
        $this->assertEqual($aPackage['authorEmail'],'test@openads.org','wrong value: authorEmail');
        $this->assertEqual($aPackage['authorUrl'],'http://www.openx.org','wrong value: authorUrl');
        $this->assertEqual($aPackage['license'],'LICENSE.txt','wrong value: license');
        $this->assertEqual($aPackage['description'],'Openads Upgrade Test 1 to 2','wrong value: description');
        $this->assertEqual($aPackage['versionFrom'],'1','wrong value: versionFrom');
        $this->assertEqual($aPackage['versionTo'],'2','wrong value: versionTo');
        $this->assertEqual($aPackage['product'],'oa','wrong value: product');

        $this->assertEqual($aPackage['prescript'],'prescript_openads_upgrade_1_to_2.php','wrong value: prescript');
        $this->assertEqual($aPackage['postscript'],'postscript_openads_upgrade_1_to_2.php','wrong value: postscript');


        $this->assertEqual($aDBPackages[0]['schema'],'tables_core','');
        $this->assertEqual($aDBPackages[0]['version'],'2','');
        $this->assertEqual($aDBPackages[0]['stamp'],'100','');
        $this->assertEqual($aDBPackages[0]['prescript'],'prescript_tables_core_2.php','');
        $this->assertEqual($aDBPackages[0]['postscript'],'postscript_tables_core_2.php','');
        $this->assertEqual($aDBPackages[0]['files'][0],'schema_tables_core_2.xml','');
        $this->assertEqual($aDBPackages[0]['files'][1],'changes_tables_core_2.xml','');
        $this->assertEqual($aDBPackages[0]['files'][2],'migration_tables_core_2.php','');
    }

}

?>
