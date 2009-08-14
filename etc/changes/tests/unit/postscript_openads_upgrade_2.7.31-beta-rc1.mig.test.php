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
$Id$
*/


require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.7.31-beta-rc1.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * A class for testing adding campaign_ecpm_enabled preference
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
class Migration_postscript_2_7_31_beta_RC1Test extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
    }

    function testChangePluginPaths()
    {
        TestEnv::restoreConfig();
    	// prepare data
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->oConfiguration = new OA_Upgrade_Config();
        
        Mock::generatePartial(
            'OA_UpgradePostscript_2_7_31_beta_rc1',
            $mockName = 'OA_UpgradePostscript_2_7_31_beta_rc1'.rand(),
            array('logOnly','logError')
        );
        $doMockPostUpgrade = new $mockName($this);
        $doMockPostUpgrade->oUpgrade = &$oUpgrade;

        // delete max section to make a new max section for testing
        unset($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']);
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginUpdatesServer'] = array(
            'protocol'  => 'test',
            'host'      => 'test',
            'path'      => 'test',
            'httpPort'  => 'test',
        );
        $this->assertNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']);
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths'] = array(
            'packages' => '/extensions/etc/',
            'extensions' => '/extensions/',
            'admin'=>'/www/admin/plugins/',
            'var'=>'/var/plugins/',
            'plugins'=>'/plugins/',
        );

        // check that aConfig pluginPaths section is not null
        $this->assertNotNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']);

        // Execute
        $doMockPostUpgrade->execute(array($oUpgrade));

        // assert that ['pluginPaths'] and ['pluginUpdatesServer have been upgraded to the correct values
        $this->assertEqual($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']['packages'], '/plugins/etc/');
        $this->assertNull($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']['extensions']);
        $this->assertEqual($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginUpdatesServer'], array(
            'protocol'  => 'http',
            'host'      => 'code.openx.org',
            'path'      => '/openx/plugin-updates',
            'httpPort'  => '80',
        ));
        TestEnv::restoreConfig();
    }
}
?>