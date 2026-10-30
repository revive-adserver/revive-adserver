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

require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';

class OX_Plugin_PreferenceUpgrade_TestManager
{
    public $calls = [];
    public $registerResult = true;
    public $unregisterResult = true;

    public function _registerPreferences($name, $preferences)
    {
        $this->calls[] = ['register', $name, $preferences];
        return $this->registerResult;
    }

    public function _unregisterPreferences($name, $preferences)
    {
        $this->calls[] = ['unregister', $name, $preferences];
        return $this->unregisterResult;
    }
}

class Test_OX_Plugin_UpgradeComponentGroup_Preferences extends UnitTestCase
{
    private $storedPreferences = [];

    public function tearDown()
    {
        foreach ($this->storedPreferences as $preference) {
            $preference->delete();
        }
        $this->storedPreferences = [];
    }

    private function storePreference($name)
    {
        $preference = OA_Dal::factoryDO('preferences');
        $preference->preference_name = 'testPreferenceUpgrade_' . $name;
        $preference->account_type = 'ADMIN';
        $this->assertTrue($preference->insert());
        $this->storedPreferences[] = $preference;
    }

    private function createUpgrader($manager)
    {
        // Exercise preference reconciliation without initializing the full schema upgrader.
        $upgrader = (new ReflectionClass(OX_Plugin_UpgradeComponentGroup::class))->newInstanceWithoutConstructor();
        $upgrader->oDbh = OA_DB::singleton();
        $upgrader->oComponentGroupManager = $manager;
        $upgrader->aComponentGroup = [
            'name' => 'testPreferenceUpgrade',
            'install' => ['conf' => ['preferences' => [
                ['name' => 'first', 'value' => 'one'],
                ['name' => 'second', 'value' => 'two'],
            ]]],
        ];
        return $upgrader;
    }

    public function testNewAndDeletedPreferenceBatchesAreAppliedOnce()
    {
        $this->storePreference('obsolete1');
        $this->storePreference('obsolete2');
        $manager = new OX_Plugin_PreferenceUpgrade_TestManager();
        $upgrader = $this->createUpgrader($manager);

        $this->assertTrue($upgrader->_upgradePreferences());
        $this->assertEqual(['register', 'unregister'], array_column($manager->calls, 0));
        $this->assertEqual(['register', 'testPreferenceUpgrade', [
            'first' => ['name' => 'first', 'value' => 'one'],
            'second' => ['name' => 'second', 'value' => 'two'],
        ]], $manager->calls[0]);
        $this->assertEqual('testPreferenceUpgrade', $manager->calls[1][1]);
        $deletedNames = array_column($manager->calls[1][2], 'name');
        sort($deletedNames);
        $this->assertEqual(['obsolete1', 'obsolete2'], $deletedNames);
    }

    public function testExistingPreferencesAreNotRegisteredAgain()
    {
        $this->storePreference('first');
        $manager = new OX_Plugin_PreferenceUpgrade_TestManager();

        $this->assertTrue($this->createUpgrader($manager)->_upgradePreferences());
        $this->assertEqual([
            ['register', 'testPreferenceUpgrade', ['second' => ['name' => 'second', 'value' => 'two']]],
            ['unregister', 'testPreferenceUpgrade', []],
        ], $manager->calls);
    }

    public function testRegistrationFailureStopsUpgradeBeforeDeletingPreferences()
    {
        $manager = new OX_Plugin_PreferenceUpgrade_TestManager();
        $manager->registerResult = false;

        $this->assertFalse($this->createUpgrader($manager)->_upgradePreferences());
        $this->assertEqual(['register'], array_column($manager->calls, 0));
    }

    public function testRemovalFailureIsReturned()
    {
        $this->storePreference('obsolete');
        $manager = new OX_Plugin_PreferenceUpgrade_TestManager();
        $manager->unregisterResult = false;

        $this->assertFalse($this->createUpgrader($manager)->_upgradePreferences());
        $this->assertEqual(['register', 'unregister'], array_column($manager->calls, 0));
        $this->assertEqual([['name' => 'obsolete']], $manager->calls[1][2]);
    }

    public function testEmptyPreferenceBatchesSucceed()
    {
        $manager = new OX_Plugin_PreferenceUpgrade_TestManager();
        $upgrader = $this->createUpgrader($manager);
        $upgrader->aComponentGroup['install']['conf']['preferences'] = [];

        $this->assertTrue($upgrader->_upgradePreferences());
        $this->assertEqual([
            ['register', 'testPreferenceUpgrade', []],
            ['unregister', 'testPreferenceUpgrade', []],
        ], $manager->calls);
    }
}
