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


/**
 * Test for ConfigMigration class.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_openads_upgrade_task_Check_Plugins extends UnitTestCase
{

    function setUp()
	{
	    TestEnv::installPluginPackage('openXTests', false);
	}

	function tearDown()
	{
	    TestEnv::uninstallPluginPackage('openXTests', false);
	}

	/**
	 * tests the check plugins script
	 * will not run the install default plugins script
	 *
	 */
    function testCheckPlugins()
    {
        // in case something went wrong installing the test plugin
        $this->assertTrue($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        $this->assertTrue($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

        // Test 1 : valid plugin that is enabled to start with

        // simulate upgrader method
        $this->_disableAllPlugins();

        // ensure that they are disabled
        $this->assertFalse($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        $this->assertFalse($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

        // clear down globals in between script runs
        unset($aDefaultPlugins);
        unset($upgradeTaskError);
        unset($upgradeTaskResult);

        // run the script
        include MAX_PATH . '/etc/changes/tasks/openads_upgrade_task_Check_Plugins.php';

        // if false, you may be running with a dirty system - clean out other plugins and try again
        $this->assertTrue($upgradeTaskResult);

        // ensure that they have been re-enabled
        $this->assertTrue($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        $this->assertTrue($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

        // ensure that they are disabled
        $GLOBALS['_MAX']['CONF']['plugins']['openXTests'] = 0;
        $GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy'] = 0;

        // simulate upgrader method
        $this->_disableAllPlugins();

        // clear down globals in between script runs
        unset($aDefaultPlugins);
        unset($upgradeTaskError);
        unset($upgradeTaskResult);

        // run the script
        include MAX_PATH . '/etc/changes/tasks/openads_upgrade_task_Check_Plugins.php';

        // if false, you may be running with a dirty system - clean out other plugins and try again
        $this->assertTrue($upgradeTaskResult);

        // ensure that they are still disabled
        $this->assertFalse($GLOBALS['_MAX']['CONF']['plugins']['openXTests']);
        $this->assertFalse($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['Dummy']);

    }

    /**
     * simulates the upgrader
     * records the list of plugins to a file
     * switches enabled to 0 for each plugin and group conf setting
     *
     * @param unknown_type $aPackages
     * @return unknown
     */
    function _disableAllPlugins($aPackages='')
    {
        $file = MAX_PATH.'/var/plugins/recover/enabled.log';
        if (file_exists($file))
        {
            @unlink($file);
        }
        if ($fh = fopen($file, 'w'))
        {
            foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled)
            {
                fwrite($fh, "{$name}={$enabled};\r\n");
            }
            fclose($fh);
        }
        foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled)
        {
            $GLOBALS['_MAX']['CONF']['plugins'][$name] = 0;
        }
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] as $name => $enabled)
        {
            $GLOBALS['_MAX']['CONF']['pluginGroupComponents'][$name] = 0;
        }
        return true;
    }


}
?>