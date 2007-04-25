<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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
            array('init','upgrade')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectOnce('init');
        $oUpgrade->oDBUpgrader->setReturnValue('upgrade', true);
        $oUpgrade->oDBUpgrader->expectOnce('upgrade');

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
        $oUpgrade->oVersioner->expectCallCount('getSchemaVersion',2);
        $oUpgrade->oVersioner->setReturnValueAt(2, 'getSchemaVersion', 2);
        $oUpgrade->oVersioner->setReturnValue('putSchemaVersion', null);
        $oUpgrade->oVersioner->expectOnce('putSchemaVersion');

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('init','upgrade', 'rollback')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectCallCount('init',2);
        $oUpgrade->oDBUpgrader->setReturnValue('upgrade', false);
        $oUpgrade->oDBUpgrader->expectOnce('upgrade');
        $oUpgrade->oDBUpgrader->setReturnValue('rollback', true);
        $oUpgrade->oDBUpgrader->expectOnce('rollback');

        $oUpgrade->aDBPackages = array(0=>array('version'=>'2','schema'=>'test_tables','files'=>''));

        $this->assertFalse($oUpgrade->upgradeSchemas(),'schema upgrade method failed (testing failure.  it was supposed to fail and it didn\'t)');
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
        $oUpgrade->oVersioner->expectOnce('putSchemaVersion');

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('init','rollback')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectOnce('init');
        $oUpgrade->oDBUpgrader->setReturnValue('rollback', true);
        $oUpgrade->oDBUpgrader->expectOnce('rollback');

        $oUpgrade->versionInitialSchema = array('test_tables'=>'1');

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
