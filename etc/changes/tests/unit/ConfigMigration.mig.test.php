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
$Id: StatMigration.mig.test.php 7421 2007-06-08 15:33:23Z monique.szpak@openads.org $
*/

require_once MAX_PATH . '/etc/changes/ConfigMigration.php';


/**
 * Test for ConfigMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class ConfigMigrationTest extends UnitTestCase
{
	var $moduleDir;
	var $packageDir;
	var $host;

    function setUp()
	{
        // Tests in this class need to use the "real" configuration
        // file writing method, not the one reserved for the test
        // environment...
        $GLOBALS['override_TEST_ENVIRONMENT_RUNNING'] = true;

	    $this->host = $_SERVER['HTTP_HOST'];
	    $_SERVER['HTTP_HOST'] = 'test1';

		$GLOBALS['_MAX']['CONF']['webpath']['delivery'] = getHostName();

		// set up test folders
    	$this->moduleDir = MAX_PATH . '/var/plugins/config/testModule';
    	if(!file_exists($this->moduleDir)) {
    		mkdir($this->moduleDir);
    	}
    	$this->packageDir = $this->moduleDir.'/testType';
    	if (!file_exists($this->packageDir)) {
    		mkdir($this->packageDir);
    	}
	}

	function tearDown()
	{
        // Resume normal service with regards to the configuration file writer...
        unset($GLOBALS['override_TEST_ENVIRONMENT_RUNNING']);

        if (file_exists(MAX_PATH.'/var/'.getHostName().'.conf.php'))
        {
            @unlink(MAX_PATH.'/var/'.getHostName().'.conf.php');
        }
	    $_SERVER['HTTP_HOST'] = $this->host;
	}

    function testGetGeotargetingConfig()
    {
    	$array1 = array('type' => 'testType');
    	MAX_Plugin::writePluginConfig($array1, 'testModule');
    	$array2 = array('key2' => 'val2');
    	MAX_Plugin::writePluginConfig($array2, 'testModule', 'testType');

    	$configMigration = new ConfigMigration();
    	$this->assertEqual(array_merge($array1, $array2), $configMigration->getPluginsConfigByType('testModule'));
    }

    function testMergeConfigWith()
    {
    	$this->createConfigIfNotExists();
    	$aTest = array(
    		'testKey1' => 'testVal1',
    		'testKey2' => 'testVal2'
    	);
    	$configMigration = new ConfigMigration();
    	$configMigration->mergeConfigWith('testSection', $aTest);
    	$this->checkGlobalConfigConsists('testSection', $aTest);
    }

    function testRenamePluginsConfigAffix()
    {
        // create testing files
        touch($this->moduleDir.'/test_host.plugin.conf.ini');
        touch($this->packageDir.'/test_host.plugin.conf.ini');

        $configMigration = new ConfigMigration();
        $aFiles = $configMigration->getPluginsConfigFiles('testModule', 'ini');
        $this->assertTrue(!empty($aFiles));

        // rename them
        $configMigration->renamePluginsConfigAffix('ini', 'php');

        // get all config files and test that ini files doesn't exist anymore
        $aFiles = $configMigration->getPluginsConfigFiles('testModule', 'ini');
        $this->assertTrue(empty($aFiles));

        // Test that configs were correctly renamed
        $this->assertTrue(file_exists($this->moduleDir.'/test_host.plugin.conf.php'));
        $this->assertTrue(file_exists($this->packageDir.'/test_host.plugin.conf.php'));

        @unlink($this->packageDir.'/'.getHostName().'.plugin.conf.php');
        @unlink($this->packageDir.'/test_host.plugin.conf.php');
        @unlink($this->packageDir);

        @unlink($this->moduleDir.'/'.getHostName().'.plugin.conf.php');
        @unlink($this->moduleDir.'/test_host.plugin.conf.php');
        @unlink($this->moduleDir);
    }

    /**
     * Checks if $testArray exists in $section in global config file
     *
     * @param string $testSection
     * @param array $testArray
     */
    function checkGlobalConfigConsists($testSection, $testArray)
    {
        $host = getHostName();
    	$configPath = MAX_PATH . "/var/$host.conf.php";
    	if ($this->assertTrue(file_exists($configPath), "File: '$configPath' should exist!")) {
            $aContents = parse_ini_file($configPath, true);
            foreach($testArray as $key => $val) {
            	$this->assertEqual($aContents[$testSection][$key], $val);
            }
        }
    }

    /**
     * This method creates config if it doesn't exist so test won't fail
     *
     */
    function createConfigIfNotExists()
    {
        if (!(file_exists(MAX_PATH.'/var/'.getHostName().'.conf.php'))) {
        	$oConfig = new OA_Upgrade_Config();
        	$oConfig->putNewConfigFile();
        	$oConfig->writeConfig(true);
        }
    }

}
?>