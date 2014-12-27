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

require_once MAX_PATH . '/etc/changes/ConfigMigration.php';
require_once MAX_PATH . '/lib/util/file/file.php';


/**
 * Test for ConfigMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
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

		$GLOBALS['_MAX']['CONF']['webpath']['delivery'] = OX_getHostName();

		// set up test folders
    	$this->moduleDir = MAX_PATH . '/var/plugins/config/testModule';
    	if(!file_exists($this->moduleDir)) {
    		mkdir($this->moduleDir, 0777, true);
    	}
    	$this->packageDir = $this->moduleDir.'/testType';
    	if (!file_exists($this->packageDir)) {
    		mkdir($this->packageDir, 0777, true);
    	}
	}

	function tearDown()
	{
        // Resume normal service with regards to the configuration file writer...
        unset($GLOBALS['override_TEST_ENVIRONMENT_RUNNING']);

        if (file_exists(MAX_PATH.'/var/'.OX_getHostName().'.conf.php'))
        {
            @unlink(MAX_PATH.'/var/'.OX_getHostName().'.conf.php');
        }
	    $_SERVER['HTTP_HOST'] = $this->host;

	    // Clean up
	    Util_File_remove(MAX_PATH . '/var/plugins/config/');
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

        @unlink($this->packageDir.'/'.OX_getHostName().'.plugin.conf.php');
        @unlink($this->packageDir.'/test_host.plugin.conf.php');
        @unlink($this->packageDir);

        @unlink($this->moduleDir.'/'.OX_getHostName().'.plugin.conf.php');
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
        $host = OX_getHostName();
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
        if (!(file_exists(MAX_PATH.'/var/'.OX_getHostName().'.conf.php'))) {
        	$oConfig = new OA_Upgrade_Config();
        	$oConfig->writeConfig(true);
        }
    }

}

?>
