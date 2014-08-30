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

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.8.1-rc10.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing adding ui_show_entity_id preference
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.com>
 */
class Migration_postscript_2_8_1_RC10Test extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
        $this->assertTrue($this->initDatabase(607, array('preferences')),'failed to created version 607 of campaigns of preference table');
    }

    function testExecute()
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger'.rand(),
            array('logOnly', 'logError', 'log')
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        Mock::generatePartial(
            'OA_Upgrade',
            $mockUpgrade = 'OA_Upgrade'.rand(),
            array('addPostUpgradeTask')
        );
        $mockUpgrade = new $mockUpgrade($this);
        $mockUpgrade->setReturnValue('addPostUpgradeTask', true);
        $mockUpgrade->oLogger = $oLogger;
        $mockUpgrade->oDBUpgrader = new OA_DB_Upgrade($oLogger);
        $mockUpgrade->oDBUpgrader->oTable = &$this->oaTable;

        // Run the upgrade
        $postscript = new OA_UpgradePostscript_2_8_1_rc10();
        $ret = $postscript->execute(array(&$mockUpgrade));
        $this->assertTrue($ret);

        // Get the preference that we have inserted
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'ui_show_entity_id';
        $doPreferences->account_type = '';
        $doPreferences->find();
        $numberPreferences = $doPreferences->getRowCount();

        $this->assertEqual(1, $numberPreferences);
    }
}