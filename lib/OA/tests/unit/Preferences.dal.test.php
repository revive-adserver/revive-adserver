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

require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the core OA_Preferences class.
 *
 * @package    OpenXPermission
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Preferences extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Preferences()
    {
        $this->UnitTestCase();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the OA_Preferences::loadPreferences() method
     * when the preferences should be loaded in a one-dimensional
     * array.
     */
    function testLoadPreferencesOneDimensional()
    {
        // Test 1: Test with no user logged in, and ensure that no
        //         preferences are loaded.
        unset($GLOBALS['_MAX']['PREF']);
        unset($GLOBALS['_MAX']['CONF']['max']['language']);

        OA_Preferences::loadPreferences();
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Test 2: Test with no user logged in, and ensure that no
        //         preferences are loaded, and that esisting preferences
        //         that may exist are removed.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        // Create a user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->contact_name = 'Andrew Hill';
        $doUsers->email_address = 'andrew.hill@openads.org';
        $doUsers->username = 'admin';
        $doUsers->password = md5('password');
        $doUsers->default_account_id = $adminAccountId;
        $userId = DataGenerator::generateOne($doUsers);

        // Create admin association
        $doAUA = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = $adminAccountId;
        $doAUA->user_id = $userId;
        $doAUA->insert();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 3: Test with the admin account logged in, but no preferences in
        //         the system, and ensure that no preferences are loaded, and
        //         that esisting preferences that may exist are removed.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Prepare a fake preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'preference_1';
        $doPreferences->account_type = OA_ACCOUNT_ADMIN;
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Test 4: Test with the admin user logged in, and a preference in
        //         the system, but no preference values set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Insert a fake preference value
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'foo!';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 5: Test with the admin account logged in, a preference in the
        //         system, and a preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');

        // Prepare a second fake preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'preference_2';
        $doPreferences->account_type = OA_ACCOUNT_MANAGER;
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Test 6: Test with the admin account logged in, two preferences in the
        //         system, and one preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');

        // Insert a second fake preference value
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'bar!';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 7: Test with the admin account logged in, two preferences in the
        //         system, and two preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'bar!');

        // Create a manager "agency" and account
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Manager Account';
        $doAgency->contact = 'Andrew Hill';
        $doAgency->email = 'andrew.hill@openads.org';
        $managerAgencyId = DataGenerator::generateOne($doAgency);

        // Get the account ID for the manager "agency"
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agency_id = $managerAgencyId;
        $doAgency->find();
        $doAgency->fetch();
        $aAgency = $doAgency->toArray();
        $managerAccountId = $aAgency['account_id'];

        // Update the existing user to log into the manager account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 8: Test with the manager account logged in, two preferences in the
        //         system, and two preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'bar!');

        // Overwrite preference_2 at the manager account level
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $managerAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'baz!';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 9: Test with the manager account logged in, two preferences in the
        //         system, two preference value set for the admin account, with
        //         one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'baz!');

        // Update the existing user to log into the admin account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $adminAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 10: Test with the admin account logged in, two preferences in the
        //          system, two preference value set for the admin account, with
        //          one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'bar!');

        // Create an advertiser "client" and account, owned by the manager
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->name = 'Advertiser Account';
        $doClients->contact = 'Andrew Hill';
        $doClients->email = 'andrew.hill@openads.org';
        $doClients->agencyid = $managerAgencyId;
        $advertiserClientId = DataGenerator::generateOne($doClients);

        // Get the account ID for the advertiser "client"
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid = $advertiserClientId;
        $doClients->find();
        $doClients->fetch();
        $aAdvertiser = $doClients->toArray();
        $advertiserAccountId = $aAdvertiser['account_id'];

        // Update the existing user to log into the advertiser account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $advertiserAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 11: Test with the advertiser account logged in, two preferences in the
        //          system, two preference value set for the admin account, with
        //          one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'baz!');

        // Prepare a third fake preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'preference_3';
        $doPreferences->account_type = OA_ACCOUNT_ADVERTISER;
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Insert a third fake preference value
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'Admin Preference for Preference 3';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 12: Test with the advertiser account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'baz!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3'], 'Admin Preference for Preference 3');

        // Overwrite preference_3 at the advertiser account level
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'Advertiser Preference for Preference 3';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 13: Test with the advertiser account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account, and another
        //          overwritten by the advertiser account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'baz!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3'], 'Advertiser Preference for Preference 3');

        // Update the existing user to log into the manager account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 14: Test with the manager account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account, and another
        //          overwritten by the advertiser account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'baz!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3'], 'Admin Preference for Preference 3');

        // Update the existing user to log into the admin account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $adminAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 14: Test with the admin account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account, and another
        //          overwritten by the advertiser account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2'], 'bar!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3'], 'Admin Preference for Preference 3');

        // Test 15: Test that with the admin account logged in, but no language preference (nor config language) that english is returned

        // Update the existing user to clear the language field
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->language = '';
        $doUsers->update();

        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['language']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['language'], 'en');

        // Test 16: Test that if we set a default in the conf array and have no user pref, this is returned:
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'de';
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['language']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['language'], 'de');

        // Test 17: Test that if we set a default in the conf array and have no user pref, this is returned:
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['language']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['language'], 'de');

        // Test 18: Test that if we have a language set for the user, this is returned:
        $doUsers->language = 'pt_BR';
        $doUsers->update();

        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences();
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['language']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['language'], 'pt_BR');
    }

    /**
     * A method to test the OA_Preferences::loadPreferences() method
     * when the preferences should be loaded in a two-dimensional
     * array.
     */
    function testLoadPreferencesTwoDimensional()
    {
        // Test 1: Test with no user logged in, and ensure that no
        //         preferences are loaded.
        unset($GLOBALS['_MAX']['PREF']);
        unset($GLOBALS['_MAX']['CONF']['max']['language']);

        OA_Preferences::loadPreferences(true);
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Test 2: Test with no user logged in, and ensure that no
        //         preferences are loaded, and that esisting preferences
        //         that may exist are removed.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Create the admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);

        // Create a user
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->contact_name = 'Andrew Hill';
        $doUsers->email_address = 'andrew.hill@openads.org';
        $doUsers->username = 'admin';
        $doUsers->password = md5('password');
        $doUsers->default_account_id = $adminAccountId;
        $userId = DataGenerator::generateOne($doUsers);

        // Create admin association
        $doAUA = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = $adminAccountId;
        $doAUA->user_id = $userId;
        $doAUA->insert();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 3: Test with the admin account logged in, but no preferences in
        //         the system, and ensure that no preferences are loaded, and
        //         that esisting preferences that may exist are removed.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Prepare a fake preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'preference_1';
        $doPreferences->account_type = OA_ACCOUNT_ADMIN;
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Test 4: Test with the admin user logged in, and a preference in
        //         the system, but no preference values set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNull($GLOBALS['_MAX']['PREF']);

        // Insert a fake preference value
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'foo!';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 5: Test with the admin account logged in, a preference in the
        //         system, and a preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');

        // Prepare a second fake preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'preference_2';
        $doPreferences->account_type = OA_ACCOUNT_MANAGER;
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Test 6: Test with the admin account logged in, two preferences in the
        //         system, and one preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 1);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);

        // Insert a second fake preference value
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'bar!';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 7: Test with the admin account logged in, two preferences in the
        //         system, and two preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'bar!');

        // Create a manager "agency" and account
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Manager Account';
        $doAgency->contact = 'Andrew Hill';
        $doAgency->email = 'andrew.hill@openads.org';
        $managerAgencyId = DataGenerator::generateOne($doAgency);

        // Get the account ID for the manager "agency"
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->agency_id = $managerAgencyId;
        $doAgency->find();
        $doAgency->fetch();
        $aAgency = $doAgency->toArray();
        $managerAccountId = $aAgency['account_id'];

        // Update the existing user to log into the manager account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 8: Test with the manager account logged in, two preferences in the
        //         system, and two preference value set for the admin account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'bar!');

        // Overwrite preference_2 at the manager account level
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $managerAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'baz!';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 9: Test with the manager account logged in, two preferences in the
        //         system, two preference value set for the admin account, with
        //         one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'baz!');

        // Update the existing user to log into the admin account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $adminAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 10: Test with the admin account logged in, two preferences in the
        //          system, two preference value set for the admin account, with
        //          one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'bar!');

        // Create an advertiser "client" and account, owned by the manager
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->name = 'Advertiser Account';
        $doClients->contact = 'Andrew Hill';
        $doClients->email = 'andrew.hill@openads.org';
        $doClients->agencyid = $managerAgencyId;
        $advertiserClientId = DataGenerator::generateOne($doClients);

        // Get the account ID for the advertiser "client"
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientid = $advertiserClientId;
        $doClients->find();
        $doClients->fetch();
        $aAdvertiser = $doClients->toArray();
        $advertiserAccountId = $aAdvertiser['account_id'];

        // Update the existing user to log into the advertiser account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $advertiserAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 11: Test with the advertiser account logged in, two preferences in the
        //          system, two preference value set for the admin account, with
        //          one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 3);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'baz!');

        // Prepare a third fake preference
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'preference_3';
        $doPreferences->account_type = OA_ACCOUNT_ADVERTISER;
        $preferenceId = DataGenerator::generateOne($doPreferences);

        // Insert a third fake preference value
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $adminAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'Admin Preference for Preference 3';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 12: Test with the advertiser account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'baz!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_3']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_3']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['account_type'], OA_ACCOUNT_ADVERTISER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['value'], 'Admin Preference for Preference 3');

        // Overwrite preference_3 at the advertiser account level
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $advertiserAccountId;
        $doAccount_Preference_Assoc->preference_id = $preferenceId;
        $doAccount_Preference_Assoc->value = 'Advertiser Preference for Preference 3';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        // Test 13: Test with the advertiser account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account, and another
        //          overwritten by the advertiser account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'baz!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_3']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_3']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['account_type'], OA_ACCOUNT_ADVERTISER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['value'], 'Advertiser Preference for Preference 3');

        // Update the existing user to log into the manager account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 14: Test with the manager account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account, and another
        //          overwritten by the advertiser account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'baz!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_3']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_3']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['account_type'], OA_ACCOUNT_ADVERTISER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['value'], 'Admin Preference for Preference 3');

        // Update the existing user to log into the admin account by default
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $doUsers->default_account_id = $adminAccountId;
        $doUsers->update();

        // Ensure this user is "logged in"
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->username = 'admin';
        $doUsers->find();
        $doUsers->fetch();
        $oUser = new OA_Permission_User($doUsers);
        global $session;
        $session['user'] = $oUser;

        // Test 14: Test with the admin account logged in, three preferences in the
        //          system, three preference value set for the admin account, with
        //          one of them overwritten by the manager account, and another
        //          overwritten by the advertiser account.
        $GLOBALS['_MAX']['PREF'] = array('foo' => 'bar');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        OA_Preferences::loadPreferences(true);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']), 4);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_1']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_1']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['account_type'], OA_ACCOUNT_ADMIN);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_1']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_1']['value'], 'foo!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_2']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_2']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['account_type'], OA_ACCOUNT_MANAGER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_2']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_2']['value'], 'bar!');
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']);
        $this->assertTrue(is_array($GLOBALS['_MAX']['PREF']['preference_3']));
        $this->assertEqual(count($GLOBALS['_MAX']['PREF']['preference_3']), 2);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['account_type']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['account_type'], OA_ACCOUNT_ADVERTISER);
        $this->assertNotNull($GLOBALS['_MAX']['PREF']['preference_3']['value']);
        $this->assertEqual($GLOBALS['_MAX']['PREF']['preference_3']['value'], 'Admin Preference for Preference 3');
    }

    function _createPreferences($aPrefs)
    {
        foreach($aPrefs as $prefName => $prefId) {
            $doPreferences = OA_Dal::factoryDO('preferences');
            $doPreferences->preference_id = $prefId;
            $doPreferences->preference_name = $prefName;
            $doPreferences->account_type = 'ADMIN';
            DataGenerator::generateOne($doPreferences);
        }
    }

    function testCacheGetPreferenceIds()
    {
        $expectedPrefs = array(
            'pref1' => 1,
            'pref2' => 2,
        );
        $this->_createPreferences($expectedPrefs);

        $prefs = OA_Preferences::getPreferenceIds(array(''), 'ADMIN');
        $this->assertEqual($prefs, array());
        $prefs = OA_Preferences::getCachedPreferencesIds(array(''), 'ADMIN');
        $this->assertEqual($prefs, array());

        $expectedPref1 = array('pref1' => 1);
        $prefs = OA_Preferences::getPreferenceIds(array('pref1'), 'ADMIN');
        $this->assertEqual($prefs, $expectedPref1);
        $prefs = OA_Preferences::getCachedPreferencesIds(array('pref1'), 'ADMIN');
        $this->assertEqual($prefs, $expectedPref1);

        $prefs = OA_Preferences::getPreferenceIds(array('pref1', 'pref2'), 'ADMIN');
        $this->assertEqual($prefs, $expectedPrefs);
        $prefs = OA_Preferences::getCachedPreferencesIds(array('pref1', 'pref2'), 'ADMIN');
        $this->assertEqual($prefs, $expectedPrefs);
        // change one of the cached preferences and check that getCachedPreferencesIds() still returns
        // old values
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_id = 1;
        $doPreferences->preference_name = 'test';
        $doPreferences->update();
        $prefs = OA_Preferences::getCachedPreferencesIds(array('pref1', 'pref2'), 'ADMIN');
        $this->assertEqual($prefs, $expectedPrefs);
        $prefs = OA_Preferences::getCachedPreferencesIds(array('test'), 'ADMIN');
        $this->assertEqual($prefs, array('test' => 1));
    }

    function testCachePreferences()
    {
        $prefsNames = array('pref1', 'pref2');
        $accountId = 1;

        $prefs = OA_Preferences::cachePreferences($accountId, $prefsNames);
        $this->assertEqual($prefs, array());

        // cache preferences
        $prefsValues = array(
            'pref1' => 'val1',
            'pref2' => 'val2',
        );
        OA_Preferences::cachePreferences($accountId, $prefsValues, false);

        // check that preferences were cached
        $prefs = OA_Preferences::cachePreferences($accountId, $prefsNames);
        $this->assertEqual($prefs, $prefsValues);

        // check that different account is not cached
        $prefs = OA_Preferences::cachePreferences(2, $prefsNames);
        $this->assertEqual($prefs, array());
    }

    function _addPrefsToAccount($prefs, $accountId)
    {
        foreach ($prefs as $prefId => $prefVal) {
            $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_preference_assoc->account_id = $accountId;
            $doAccount_preference_assoc->preference_id = $prefId;
            $doAccount_preference_assoc->value = $prefVal;
            DataGenerator::generateOne($doAccount_preference_assoc);
        }
    }

    function testLoadPreferencesByNameAndAccount()
    {
        // clean cache
        OA_Preferences::cachePreferences(null, array(), null, true);
        $prefs = OA_Preferences::loadPreferencesByNameAndAccount($accountId = 1, array('pref1'), 'ADMIN');
        $this->assertEqual($prefs, array());
        // add prefs
        $prefsNamesIds = array(
            'pref1' => 1,
            'pref2' => 2,
        );
        $this->_createPreferences($prefsNamesIds);
        $this->_addPrefsToAccount(array(1 => 'pref1val'), $accountId);
        $prefs = OA_Preferences::loadPreferencesByNameAndAccount($accountId, array('pref1'), 'ADMIN');
        $this->assertEqual($prefs, array('pref1' => 'pref1val'));

        $this->_addPrefsToAccount(array(2 => 'pref2val'), $accountId);
        $prefs = OA_Preferences::loadPreferencesByNameAndAccount($accountId, array('pref1', 'pref2'), 'ADMIN');
        $this->assertEqual($prefs, array('pref1' => 'pref1val', 'pref2' => 'pref2val'));

        $prefs = OA_Preferences::loadPreferencesByNameAndAccount(2, array('pref1'), 'ADMIN');
        $this->assertEqual($prefs, array());
    }
}

?>