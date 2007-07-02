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
$Id: StatMigration.mig.test.php 7421 2007-06-08 15:33:23Z monique.szpak@openads.org $
*/

require_once MAX_PATH . '/etc/changes/ConfigMigration.php';


/**
 * Test for ConfigMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 */
class ConfigMigrationTest extends UnitTestCase
{
	function setUp()
	{
		$GLOBALS['_MAX']['CONF']['webpath']['delivery'] = getHostName();
	}
	
    function testGetGeotargetingConfig()
    {
    	// set up test folders
    	$moduleDir = MAX_PATH . '/var/plugins/config/testModule';
    	if(!file_exists($moduleDir)) {
    		mkdir($moduleDir);
    	}
    	if (!file_exists($moduleDir.'/testType')) {
    		mkdir($moduleDir.'/testType');
    	}
    	
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
        if (!(file_exists('/var/'.getHostName().'.conf.php'))) {
        	$oConfig = new OA_Upgrade_Config();
        	$oConfig->putNewConfigFile();
        	$oConfig->writeConfig(true);
        }
    }

}
?>