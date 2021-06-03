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

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.7.31-beta-rc1.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * A class for testing adding campaign_ecpm_enabled preference
 *
 * @package    changes
 * @subpackage TestSuite
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
            array()
        );
        $doMockPostUpgrade = new OA_UpgradePostscript_2_7_31_beta_rc1($this);
        $doMockPostUpgrade->oUpgrade = $oUpgrade;

        // delete max section to make a new max section for testing
        unset($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']);
        $doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginUpdatesServer'] = array(
            'protocol'  => 'test',
            'host'      => 'test',
            'path'      => 'test',
            'httpPort'  => 'test',
        );
        $this->assertFalse(isset($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']));
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
        $this->assertFalse(isset($doMockPostUpgrade->oUpgrade->oConfiguration->aConfig['pluginPaths']['extensions']));
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