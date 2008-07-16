<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
// $Id$
*/

require_once MAX_PATH.'/lib/OA/Plugin/UpgradeComponentGroup.php';

/**
 * A class for testing the Test_OX_Plugin_UpgradeComponentGroup class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OX_Plugin_UpgradeComponentGroup extends UnitTestCase
{
    var $packageName   = 'testPluginPackage';
    var $aUpload       = array('name'=>'', 'tmp_name'=>'');

    var $testpathData  = '/lib/OA/Plugin/tests/data/plugins_repo/';


    /**
     * The constructor method.
     */
    function Test_OX_Plugin_UpgradeComponentGroup()
    {
        $this->UnitTestCase();
        $this->aUpload['name'] = $this->packageName.'.zip';
        $this->aUpload['tmp_name'] = MAX_PATH.$this->testpathData.$this->aUpload['name'];
    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function test_canUpgrade()
    {
        $oPkgMgr = new OX_PluginManager();
        $oPkgMgr->uninstallPackage($this->packageName);

        // put the version 1 package in place
        $this->_switchFiles(1);

        // third param indicates whether pkg mgr is expecting an upgrade
        // this time it expects to install
        $aPackage = $oPkgMgr->_checkPackageContents($this->packageName.'.xml', $this->aUpload['tmp_name'], false);
        $aPlugin = $aPackage['plugins'][1];
        $this->assertEqual($aPlugin['version'],'0.0.1');

        // need to have version 1 installed
        $this->assertTrue($oPkgMgr->installPackage($this->aUpload));

        // Test 1 : package definition has same version than installation
        $oUpgrader = new OX_Plugin_UpgradeComponentGroup($aPlugin, $oPkgMgr);
        $this->assertFalse($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_PLUGIN_CURRENT_VERSION);

        // Test 2 : package definition has lower version than installation
        $aPlugin['version'] = '0.0.0';
        $oUpgrader = new OX_Plugin_UpgradeComponentGroup($aPlugin, $oPkgMgr);
        $this->assertFalse($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_PLUGIN_VERSION_FAILED);

        // Test 3 : package definition has higher version than installation
        $aPlugin['version'] = '0.0.2';
        $oUpgrader = new OX_Plugin_UpgradeComponentGroup($aPlugin, $oPkgMgr);
        $this->assertTrue($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_PLUGIN_CAN_UPGRADE);

        // leave the version 1 package installed for next test (upgrade)
    }

    function test_upgrade()
    {
        $oPkgMgr = new OX_PluginManager();
        $zipFile = $this->aUpload['tmp_name'];

        // version 1 package should be installed

        // put the version 2 package in place
        $this->_switchFiles(2);

        $aPackage = $oPkgMgr->_checkPackageContents($this->packageName.'.xml', $zipFile, true);
        $aPlugin = $aPackage['plugins'][1];
        $this->assertEqual($aPlugin['version'],'0.0.2');

        // Test 1 : upgrade to version 0.0.2 ; this involves 3 upgrade packages and 1 schema package
        $oUpgrader = new OX_Plugin_UpgradeComponentGroup($aPlugin, $oPkgMgr);
        $this->assertEqual($oUpgrader->oVersioner->getApplicationVersion('testPlugin'),'0.0.1');
        $this->assertEqual($oUpgrader->oVersioner->getSchemaVersion('tables_testplugin'),'001');
        $this->assertTrue($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_PLUGIN_CAN_UPGRADE);

        // decompress the zip file, 2nd param indicates overwrite previous files
        $oPkgMgr->_unpack($this->aUpload, true);
        // now that the files are in place, the upgrader can do a schema integrity check
        $this->assertTrue($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_PLUGIN_CAN_UPGRADE);
        $this->assertEqual(count($oUpgrader->aPackageList),3);

        $this->assertTrue($oUpgrader->upgrade());
        $this->assertEqual($oUpgrader->oVersioner->getApplicationVersion('testPlugin'),'0.0.2');
        $this->assertEqual($oUpgrader->oVersioner->getSchemaVersion('tables_testplugin'),'002');

        // leave the version 2 package installed for next test (upgrade menu, settings, prefs)
    }

    function test_upgradeConfig()
    {
        $oPkgMgr = new OX_PluginManager();
        $zipFile = $this->aUpload['tmp_name'];

        // version 2 package should be installed

        // put the version 3 package in place
        $this->_switchFiles(3);

        $aPackage = $oPkgMgr->_checkPackageContents($this->packageName.'.xml', $zipFile, true);
        $aPlugin = $aPackage['plugins'][1];
        $this->assertEqual($aPlugin['version'],'0.0.3');

        // Test 2 : upgrade to version 0.0.3 ; this involves 0 upgrade or schema packages, just a version stamp
        $oUpgrader = new OX_Plugin_UpgradeComponentGroup($aPlugin, $oPkgMgr);
        $this->assertTrue($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_CAN_UPGRADE);

        // decompress the zip file, 2nd param indicates overwrite previous files
        $oPkgMgr->_unpack($this->aUpload, true);
        // now that the files are in place, the upgrader can do a schema integrity check
        $this->assertTrue($oUpgrader->canUpgrade());
        $this->assertEqual($oUpgrader->existing_installation_status, OA_STATUS_CAN_UPGRADE);
        $this->assertEqual(count($oUpgrader->aPackageList),0);

        $aConf = & $GLOBALS['_MAX']['CONF'][$aPlugin['name']];

        // _upgradeConfig calls _upgradeSettings() and _upgradePreferences

        // Test 1 Settings

        // set non-default settings
        $aConf['setting1'] = 'testval1';
        $aConf['setting2'] = 'testval2';
        $aConf['setting3'] = 'testval3';
        $this->assertTrue($oUpgrader->_upgradeSettings());

        // old settings should have original values
        // new setting should have default value
        // deprecated setting should no longer exist
        $aConf = & $GLOBALS['_MAX']['CONF'][$aPlugin['name']];
        $this->assertEqual(count($aConf),3);
        $this->assertEqual($aConf['setting1'], 'testval1');
        $this->assertEqual($aConf['setting2'], 'testval2');
        $this->assertFalse(isset($aConf['setting3']));
        $this->assertEqual($aConf['setting4'], 'setval4');

        // Test 2 Preferences

        $oDbh = OA_DB::singleton();
        $qryPrefs = 'preference_name LIKE '.$oDbh->quote('%'.$prefix.'%');

        $prefix = $aPlugin['name'].'_';
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->whereAdd($qryPrefs);
        $doPreferences->find();
        while ($doPreferences->fetch())
        {
            $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_Preference_Assoc->whereAdd('preference_id = '.$doPreferences->preference_id);
        	$aPrefsOld[$doPreferences->preference_name] =  array(
                                        	                       'permission'      => $doPreferences->account_type,
                                        	                       'id'              => $doPreferences->preference_id,
                                        	                       'acct_assoc'      => $doAccount_Preference_Assoc->getAll(),
                                        	                       );
        }
        $this->assertEqual(count($aPrefsOld),2);
        $this->assertFalse(isset($aPrefsOld[$prefix.'preference3']));
        $this->assertTrue(isset($aPrefsOld[$prefix.'preference1']));
        $this->assertTrue(isset($aPrefsOld[$prefix.'preference2']));
        $this->assertEqual($aPrefsOld[$prefix.'preference1']['permission'],'MANAGER');
        $this->assertEqual($aPrefsOld[$prefix.'preference2']['permission'],'ADMIN');

        $this->assertTrue(isset($aPrefsOld[$prefix.'preference1']['acct_assoc']));
        $this->assertTrue(isset($aPrefsOld[$prefix.'preference2']['acct_assoc']));
        $this->assertEqual($aPrefsOld[$prefix.'preference1']['acct_assoc'][0]['account_id'],'0');
        $this->assertEqual($aPrefsOld[$prefix.'preference2']['acct_assoc'][0]['account_id'],'0');

        $this->assertTrue($oUpgrader->_upgradePreferences());

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->whereAdd($qryPrefs);
        $doPreferences->find();
        while ($doPreferences->fetch())
        {
            $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_Preference_Assoc->whereAdd('preference_id = '.$doPreferences->preference_id);
        	$aPrefsNew[$doPreferences->preference_name] =  array(
                                        	                       'permission'      => $doPreferences->account_type,
                                        	                       'id'              => $doPreferences->preference_id,
                                        	                       'acct_assoc'      => $doAccount_Preference_Assoc->getAll(),
                                        	                       );
        }
        $this->assertEqual(count($aPrefsNew),2);
        $this->assertFalse(isset($aPrefsNew[$prefix.'preference2']));
        $this->assertTrue(isset($aPrefsNew[$prefix.'preference1']));
        $this->assertTrue(isset($aPrefsNew[$prefix.'preference3']));
        $this->assertEqual($aPrefsNew[$prefix.'preference1']['permission'],'MANAGER');
        $this->assertEqual($aPrefsNew[$prefix.'preference3']['permission'],'ADMIN');

        $this->assertTrue(isset($aPrefsNew[$prefix.'preference1']['acct_assoc']));
        $this->assertTrue(isset($aPrefsNew[$prefix.'preference3']['acct_assoc']));
        $this->assertEqual($aPrefsNew[$prefix.'preference1']['acct_assoc'][0]['account_id'],'0');
        $this->assertEqual($aPrefsNew[$prefix.'preference3']['acct_assoc'][0]['account_id'],'0');

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->preference_id = $aPrefsOld['testPlugin_preference2']['id'];
        $this->assertFalse($doAccount_Preference_Assoc->find());

        $oPkgMgr->uninstallPackage($this->packageName);
    }

    /**
     * copy a specific zipfile of $version
     * to the main package zipfile
     *
     * e.g.
     * copy testPluginPackage_v1.zip
     * to testPluginPackage.zip
     *
     * @param integer $version
     * @return boolean
     */
    function _switchFiles($version)
    {
        $zipFile = $this->aUpload['tmp_name'];
        if (file_exists($zipFile) && (!unlink($zipFile)) )
        {
            $this->fail('error unlinking '.$zipFile);
            return false;
        }
        if (!copy(MAX_PATH.$this->testpathData.$this->packageName.'_v'.$version.'.zip',$zipFile))
        {
            $this->fail('error copying '.$zipFile);
            return false;
        }
        if (!file_exists($zipFile))
        {
            $this->fail('file does not exist '.$zipFile);
            return false;
        }
        return true;
    }



}

?>
