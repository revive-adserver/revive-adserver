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

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.7.26-beta-rc5.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing deleting auto_alter_html_banners_for_click_tracking preference
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_postscript_2_7_26_beta_RC5Test extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
        $this->assertTrue($this->initDatabase(604, array('preferences', 'account_preference_assoc')).'failed to created version 604 of campaigns of preference table and account_preference_assoc table');
    }

    function testExecute()
    {
        // Add the auto_alter_html_banners_for_click_tracking to the preferences table
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'auto_alter_html_banners_for_click_tracking';
        $doPreferences->account_type = 'ADVERTISER';
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Get the preference that we have inserted
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_id = $preferenceId;
        $doPreferences->find();
        $numberPreferences = $doPreferences->getRowCount();

        $numberPreferences = 0;
        if ($doPreferences->getRowCount() > 0) {
            while ($doPreferences->fetch()) {
                $aPreferences = $doPreferences->toArray();
                $numberPreferences++;
            }
        }

        // test that just one preference exists and is auto_alter_html_banners_for_click_tracking
        $this->assertTrue($numberPreferences==1);
        $this->assertTrue($aPreferences['preference_name']=='auto_alter_html_banners_for_click_tracking');


        // Add three account preferences associations for the auto_alter_html_banners_for_click_tracking
        // using the preference_id that we got previously
        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->account_id = 1;
        $doAccountPreferenceAssoc->preference_id = $preferenceId;
        $doAccountPreferenceAssoc->value = '1';
        DataGenerator::generateOne($doAccountPreferenceAssoc);

        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->account_id = 2;
        $doAccountPreferenceAssoc->preference_id = $preferenceId;
        $doAccountPreferenceAssoc->value = '';
        DataGenerator::generateOne($doAccountPreferenceAssoc);

        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->account_id = 3;
        $doAccountPreferenceAssoc->preference_id = $preferenceId;
        $doAccountPreferenceAssoc->value = '1';
        DataGenerator::generateOne($doAccountPreferenceAssoc);

        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->preference_id = $preferenceId;
        $doAccountPreferenceAssoc->find();
        $numberAccountPreferenceAssoc = $doAccountPreferenceAssoc->getRowCount();

        // test that three account preference association have been added to account_preference_assoc table
        $this->assertTrue($numberAccountPreferenceAssoc==3);

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
        $postscript = new OA_UpgradePostscript_2_7_26_beta_rc5();
        $postscript->execute(array(&$mockUpgrade));


        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'auto_alter_html_banners_for_click_tracking';
        $doPreferences->find();
        $deletedPreference = true;
        if ($doPreferences->getRowCount() > 0) {
            $deletedPreference = false;
        }
        // Is the preference removed from the preference table?
        $this->assertTrue($deletedPreference);

        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->preference_id = $preferenceId;
        $doAccountPreferenceAssoc->find();
        $deletedAssociations = true;
        if ($doAccountPreferenceAssoc->getRowCount() > 0) {
            $deletedAssociations = false;
        }
        // Are the associations removed from the account_preference_assoc table?
        $this->assertTrue($deletedAssociations);
    }
}