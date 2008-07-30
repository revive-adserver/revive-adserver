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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

require_once MAX_PATH . '/lib/OA/Preferences.php';

define('OA_TEST_AUDIT_USERNAME', 'username');

/**
 * A class for testing DataObject Auditing methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DB_DataObjectAuditTest extends DalUnitTestCase
{
    var $doAudit;

    /**
     * The constructor method.
     */
    function DB_DataObjectAuditTest()
    {
        $this->UnitTestCase();
        $this->_setUpUser();
    }

    function setUp()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        $GLOBALS['dataGeneratorDontOptimize'] = true;
    }

    function tearDown()
    {
        unset($GLOBALS['dataGeneratorDontOptimize']);
    }

    function _setUpUser()
    {
        $doUser = OA_Dal::factoryDO('users');
        $doUser->username = OA_TEST_AUDIT_USERNAME;
        $GLOBALS['session']['user'] = new OA_Permission_User($doUser);
    }

    function _fetchAuditRecord($context, $actionid)
    {
        $doAudit = OA_Dal::factoryDO('audit');
        $doAudit->context = $context;
        $doAudit->actionid = $actionid;
        $doAudit->orderBy('auditid');
        $n = $doAudit->find();
        $result = $doAudit->fetch();
        $this->assertEqual($doAudit->context, $context);
        $this->assertEqual($doAudit->actionid, $actionid);
        if ($n>1)
        {
            $aAudit[1] = clone($doAudit);
            for ($i=2;$i<=$n;$i++)
            {
                $result = $doAudit->fetch();
                $this->assertEqual($doAudit->context, $context);
                $this->assertEqual($doAudit->actionid, $actionid);
                $aAudit[$i] = clone($doAudit);
            }
            return $aAudit;
        }
        return $doAudit;
    }

    function _fetchAuditArrayAll()
    {
        $aResult = array();
        $this->doAudit = OA_Dal::factoryDO('audit');
        $aRows = $this->doAudit->getAll('',true);
        foreach ($aRows as $k => $aRow)
        {
            $idx = $aRow['auditid'];
            $aResult[$idx] = $aRow;
            $aResult[$idx]['array']   = unserialize($aRow['details']);
        }
        return $aResult;
    }

    function testAuditAccounts()
    {
        $doAccounts = OA_Dal::factoryDO($context = 'accounts');
        $doAccounts->account_name = 'Administrator Account';
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $accountId = DataGenerator::generateOne($doAccounts);

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$accountId);
        $this->assertEqual($aAudit['key_desc'],$doAccounts->account_name);
        $this->assertEqual($aAudit['account_id'],$accountId);
        $this->assertTrue(!isset($aAudit['m2m_password']));
        $this->assertTrue(!isset($aAudit['m2m_ticket']));

        $doAccounts = OA_Dal::staticGetDO('accounts', $accountId);
        $doAccounts->account_name = 'Administrator Account Changed';
        $doAccounts->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['account_name']['is'],$doAccounts->account_name);
        $this->assertEqual($aAudit['account_name']['was'],'Administrator Account');

        // M2M records should not be audited
        $doAccounts = OA_Dal::staticGetDO('accounts', $accountId);
        $doAccounts->m2m_password = 'foo';
        $doAccounts->m2m_ticket = 'bar';
        $doAccounts->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $this->assertNotA($oAudit, 'array', 'M2M information was logged, found more than one update audit row');

        $doAccounts->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['account_id'],$accountId);

        DataGenerator::cleanUp(array('accounts', 'audit'));
    }

    function testAuditUsers()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->contact_name = 'Test User';
        $doUsers->email_address = 'test.user@openads.org';
        $doUsers->username = 'admin';
        $doUsers->password = md5('password');
        $doUsers->default_account_id = 1;
        $userId = DataGenerator::generateOne($doUsers);
        $context = 'users';

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$userId);
        $this->assertEqual($aAudit['key_desc'],$doUsers->username);
        $this->assertEqual($aAudit['user_id'],$userId);
        $this->assertEqual($aAudit['contact_name'],$doUsers->contact_name);
        $this->assertEqual($aAudit['username'],$doUsers->username);
        $this->assertEqual($aAudit['password'],'******');
        $this->assertEqual($aAudit['default_account_id'],$doUsers->default_account_id);
        $this->assertEqual($aAudit['email_address'],$doUsers->email_address);

        $doUsers = OA_Dal::staticGetDO('users', $userId);
        $doUsers->contact_name = 'Test User Changed';
        $doUsers->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contact_name']['is'],$doUsers->contact_name);
        $this->assertEqual($aAudit['contact_name']['was'],'Test User');

        $doUsers->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['user_id'],$doUsers->user_id);

        DataGenerator::cleanUp(array('accounts', 'users', 'audit'));
    }

    function testAuditPreferences()
    {
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'Test Preference';
        $preferenceId = DataGenerator::generateOne($doPreferences);
        $context = 'preferences';

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$preferenceId);
        $this->assertEqual($aAudit['key_desc'],$doPreferences->preference_name);
        $this->assertEqual($aAudit['preference_id'],$preferenceId);
        $this->assertEqual($aAudit['preference_name'],$doPreferences->preference_name);

        $doPreferences = OA_Dal::staticGetDO('preferences', $preferenceId);
        $doPreferences->preference_name = 'Test Preference Changed';
        $doPreferences->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['preference_name']['is'],$doPreferences->preference_name);
        $this->assertEqual($aAudit['preference_name']['was'],'Test Preference');

        $doPreferences->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['preference_id'],$preferenceId);

        DataGenerator::cleanUp(array('accounts', 'users', 'audit'));
    }

    function testAuditAccountPreferenceAssoc()
    {
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $this->generateAccountId();
        $doAccount_Preference_Assoc->preference_id = 1;
        $doAccount_Preference_Assoc->value = 'foo1';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $context = 'account_preference_assoc';
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,0);  // there is no unique id
        $this->assertEqual($aAudit['key_desc'],'Account #1 -> Preference #1');
        $this->assertEqual($aAudit['account_id'],$doAccount_Preference_Assoc->account_id);
        $this->assertEqual($aAudit['preference_id'],$doAccount_Preference_Assoc->preference_id);
        $this->assertEqual($aAudit['value'],$doAccount_Preference_Assoc->value);

        // generate a few more to ensure that the correct update is audited
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = 1;
        $doAccount_Preference_Assoc->preference_id = 2;
        $doAccount_Preference_Assoc->value = 'foo2';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = 1;
        $doAccount_Preference_Assoc->preference_id = 3;
        $doAccount_Preference_Assoc->value = 'foo3';
        DataGenerator::generateOne($doAccount_Preference_Assoc);

        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = 1;
        $doAccount_Preference_Assoc->preference_id = 4;
        $doAccount_Preference_Assoc->value = 'foo4';
        DataGenerator::generateOne($doAccount_Preference_Assoc);


        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = 1;
        $doAccount_Preference_Assoc->preference_id = 1;
        $doAccount_Preference_Assoc->find(true);
        $doAccount_Preference_Assoc->value = 'bar';
        $doAccount_Preference_Assoc->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['value']['is'],$doAccount_Preference_Assoc->value);
        $this->assertEqual($aAudit['value']['was'],'foo1');

        $doAccount_Preference_Assoc->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        //$this->assertEqual($aAudit['preference_id'],$preferenceId);

        DataGenerator::cleanUp(array('accounts', 'account_preference_assoc', 'audit'));
    }

    function testAuditAccountUserPermissionAssoc()
    {
        $doAccount_User_Perm_Assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_User_Perm_Assoc->account_id = $this->generateAccountId();
        $doAccount_User_Perm_Assoc->user_id = 2;
        $doAccount_User_Perm_Assoc->permission_id = 3;
        $doAccount_User_Perm_Assoc->is_allowed = 1;
        DataGenerator::generateOne($doAccount_User_Perm_Assoc);
        $context = 'account_user_permission_assoc';

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,0);  // there is no unique id
        $this->assertEqual($aAudit['key_desc'],'Account #1 -> User #2 -> Permission #3');
        $this->assertEqual($aAudit['account_id'],$doAccount_User_Perm_Assoc->account_id);
        $this->assertEqual($aAudit['user_id'],$doAccount_User_Perm_Assoc->user_id);
        $this->assertEqual($aAudit['permission_id'],$doAccount_User_Perm_Assoc->permission_id);
        $this->assertEqual($aAudit['is_allowed'],'true');

        // generate a few more to ensure that the correct update is audited
        $doAccount_User_Perm_Assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_User_Perm_Assoc->account_id = 1;
        $doAccount_User_Perm_Assoc->user_id = 1;
        $doAccount_User_Perm_Assoc->permission_id = 3;
        $doAccount_User_Perm_Assoc->is_allowed = 1;
        DataGenerator::generateOne($doAccount_User_Perm_Assoc);

        $doAccount_User_Perm_Assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_User_Perm_Assoc->account_id = 1;
        $doAccount_User_Perm_Assoc->user_id = 3;
        $doAccount_User_Perm_Assoc->permission_id = 3;
        $doAccount_User_Perm_Assoc->is_allowed = 1;
        DataGenerator::generateOne($doAccount_User_Perm_Assoc);

        $doAccount_User_Perm_Assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_User_Perm_Assoc->account_id = 1;
        $doAccount_User_Perm_Assoc->user_id = 4;
        $doAccount_User_Perm_Assoc->permission_id = 3;
        $doAccount_User_Perm_Assoc->is_allowed = 1;
        DataGenerator::generateOne($doAccount_User_Perm_Assoc);

        $doAccount_User_Perm_Assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_User_Perm_Assoc->account_id = 1;
        $doAccount_User_Perm_Assoc->user_id = 2;
        $doAccount_User_Perm_Assoc->permission_id = 3;
        $doAccount_User_Perm_Assoc->find(true);
        $doAccount_User_Perm_Assoc->is_allowed = 0;
        $doAccount_User_Perm_Assoc->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['is_allowed']['is'],'false');
        $this->assertEqual($aAudit['is_allowed']['was'],'true');

        $doAccount_User_Perm_Assoc->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['key_desc'],'Account #1 -> User #2 -> Permission #3');
        $this->assertEqual($aAudit['account_id'],$doAccount_User_Perm_Assoc->account_id);
        $this->assertEqual($aAudit['user_id'],$doAccount_User_Perm_Assoc->user_id);

        DataGenerator::cleanUp(array('accounts', 'account_user_permission_assoc', 'audit'));
    }

    function testAuditAccountUserAssoc()
    {
        $doAccount_User_Perm_Assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_User_Perm_Assoc->account_id = $this->generateAccountId();
        $doAccount_User_Perm_Assoc->user_id = 2;
        $doAccount_User_Perm_Assoc->permission_id = 3;
        $doAccount_User_Perm_Assoc->is_allowed = 1;
        DataGenerator::generateOne($doAccount_User_Perm_Assoc);

        $doAccount_User_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_User_Assoc->account_id = 1;
        $doAccount_User_Assoc->user_id = 2;
        DataGenerator::generateOne($doAccount_User_Assoc);
        $context = 'account_user_assoc';

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,0);  // there is no unique id
        $this->assertEqual($aAudit['key_desc'],'Account #1 -> User #2');
        $this->assertEqual($aAudit['account_id'],$doAccount_User_Assoc->account_id);
        $this->assertEqual($aAudit['user_id'],$doAccount_User_Assoc->user_id);

        $doAccount_User_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_User_Assoc->account_id = 1;
        $doAccount_User_Assoc->user_id = 2;

        // ARE THEY EVER UPDATED?  ONLY INSERTED/DELETED?

        $doAccount_User_Assoc->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['key_desc'],'Account #1 -> User #2');
        $this->assertEqual($aAudit['account_id'],$doAccount_User_Assoc->account_id);
        $this->assertEqual($aAudit['user_id'],$doAccount_User_Assoc->user_id);

        DataGenerator::cleanUp(array('accounts', 'audit'));
    }

    function testAuditZone()
    {
        $doZone = OA_Dal::factoryDO('zones');
        $context = 'zones';

        $doZone->affiliateid = DataGenerator::generateOne('affiliates', true);
        $doZone->zonename = 'Zone A';
        $zoneId = DataGenerator::generateOne($doZone, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$zoneId);
        $this->assertEqual($aAudit['key_desc'],$doZone->zonename);
        $this->assertEqual($aAudit['zoneid'],$zoneId);
        $this->assertEqual($aAudit['zonename'],$doZone->zonename);
        $this->assertEqual($aAudit['affiliateid'],$doZone->affiliateid);

        $doZone = OA_Dal::staticGetDO('zones', $zoneId);
        $doZone->zonename = 'Zone B';
        $doZone->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['zonename']['is'],$doZone->zonename);
        $this->assertEqual($aAudit['zonename']['was'],'Zone A');

        $doZone->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['zoneid'],$zoneId);

        DataGenerator::cleanUp(array('accounts', 'zones', 'audit'));
    }

    function testAuditChannel()
    {
        $context = 'channel';

        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->name = 'Channel A';
        $channelId = DataGenerator::generateOne($doChannel, true);

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);

        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$channelId);
        $this->assertEqual($aAudit['key_desc'],$doChannel->name);
        $this->assertEqual($aAudit['channelid'],$channelId);
        $this->assertEqual($aAudit['name'],$doChannel->name);
        $this->assertEqual($aAudit['agencyid'],1);
        $this->assertEqual($aAudit['affiliateid'],1);

        $doChannel = OA_Dal::staticGetDO('channel', $channelId);
        $doChannel->name = 'Channel B';
        $doChannel->update();

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);

        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['name']['is'],$doChannel->name);
        $this->assertEqual($aAudit['name']['was'],'Channel A');

        $doChannel->delete();

        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);

        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['channelid'],$channelId);

        DataGenerator::cleanUp(array('accounts', 'affiliates', 'channel', 'audit'));
    }

    /**
     * NOTE: Test disabled, category auditing disabled...
     */
    function XXXtestAuditCategory()
    {
        $doCategory = OA_Dal::factoryDO('category');
        $context = 'category';

        $doCategory->name = 'Category A';
        $categoryId = DataGenerator::generateOne($doCategory);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$categoryId);
        $this->assertEqual($aAudit['key_desc'],$doCategory->name);
        $this->assertEqual($aAudit['category_id'],$categoryId);
        $this->assertEqual($aAudit['name'],$doCategory->name);

        $doCategory = OA_Dal::staticGetDO('category', $categoryId);
        $doCategory->name = 'Category B';
        $doCategory->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['name']['is'],$doCategory->name);
        $this->assertEqual($aAudit['name']['was'],'Category A');

        $doCategory->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['category_id'],$categoryId);

        DataGenerator::cleanUp(array('accounts', 'category', 'audit'));
    }

    function testAuditClient()
    {
        $doClients = OA_Dal::factoryDO($context = 'clients');

        $doClients->clientname = 'Client A';
        $clientId = DataGenerator::generateOne($doClients, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$clientId);
        $this->assertEqual($aAudit['key_desc'],$doClients->clientname);
        $this->assertEqual($aAudit['clientid'],$clientId);
        $this->assertEqual($aAudit['clientname'],$doClients->clientname);

        $doClients = OA_Dal::staticGetDO('clients', $clientId);
        $doClients->clientname = 'Client B';
        $doClients->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['clientname']['is'],$doClients->clientname);
        $this->assertEqual($aAudit['clientname']['was'],'Client A');

        $doClients->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['clientid'],$clientId);

        DataGenerator::cleanUp(array('accounts', 'clients', 'audit'));
    }

    function testAuditAffiliate()
    {
        $doAffiliate = OA_Dal::factoryDO($context = 'affiliates');

        $doAffiliate->name = 'Client A';
        $affiliateId = DataGenerator::generateOne($doAffiliate, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$affiliateId);
        $this->assertEqual($aAudit['key_desc'],$doAffiliate->name);
        $this->assertEqual($aAudit['affiliateid'],$affiliateId);
        $this->assertEqual($aAudit['name'],$doAffiliate->name);

        $doAffiliate = OA_Dal::staticGetDO('affiliates', $affiliateId);
        $doAffiliate->name = 'Client B';
        $doAffiliate->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['name']['is'],$doAffiliate->name);
        $this->assertEqual($aAudit['name']['was'],'Client A');

        $doAffiliate->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['affiliateid'],$affiliateId);

        DataGenerator::cleanUp(array('accounts', 'affiliates', 'audit'));
    }

    function testAuditAffiliateExtra()
    {
        $doAffiliateX = OA_Dal::factoryDO($context = 'affiliates_extra');
        $doAffiliateX->postcode = 'ABC 123';
        $affiliateXId = DataGenerator::generateOne($doAffiliateX, true);
        $doAffiliateX->affiliateid = $affiliateXId;
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,1);
        $this->assertEqual($aAudit['key_desc'],'');
        $this->assertEqual($aAudit['affiliateid'],$doAffiliateX->affiliateid);

        $doAffiliateX->postcode = 'DEF 456';
        $doAffiliateX->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['postcode']['is'],$doAffiliateX->postcode);
        $this->assertEqual($aAudit['postcode']['was'],'ABC 123');

        $doAffiliateX->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['affiliateid'],$doAffiliateX->affiliateid);

        DataGenerator::cleanUp(array('accounts', 'affiliates_extra', 'audit'));
    }

    function testAuditTracker()
    {
        $doTrackers = OA_Dal::factoryDO($context = 'trackers');

        $doTrackers->trackername = 'Tracker A';
        $trackerId = DataGenerator::generateOne($doTrackers, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$trackerId);
        $this->assertEqual($aAudit['key_desc'],$doTrackers->trackername);
        $this->assertEqual($aAudit['trackerid'],$trackerId);
        $this->assertEqual($aAudit['clientid'],1);
        $this->assertEqual($aAudit['trackername'],$doTrackers->trackername);

        $doTrackers = OA_Dal::staticGetDO('trackers', $trackerId);
        $doTrackers->trackername = 'Tracker B';
        $doTrackers->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['trackername']['is'],$doTrackers->trackername);
        $this->assertEqual($aAudit['trackername']['was'],'Tracker A');

        $doTrackers->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['trackerid'],$trackerId);

        DataGenerator::cleanUp(array('accounts', 'trackers', 'audit'));
    }

    function testAuditCampaign()
    {
        $doCampaigns = OA_Dal::factoryDO($context = 'campaigns');

        $doCampaigns->campaignname = 'Campaign A';
        $campaignId = DataGenerator::generateOne($doCampaigns, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$campaignId);
        $this->assertEqual($aAudit['key_desc'],$doCampaigns->campaignname);
        $this->assertEqual($aAudit['campaignid'],$campaignId);
        $this->assertEqual($aAudit['clientid'],1);
        $this->assertEqual($aAudit['campaignname'],$doCampaigns->campaignname);

        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $doCampaigns->campaignname = 'Campaign B';
        $doCampaigns->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['campaignname']['is'],$doCampaigns->campaignname);
        $this->assertEqual($aAudit['campaignname']['was'],'Campaign A');

        // The viewwindow is now a property of the campaign, not the campaigns trackers table
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        // Use 2,360 because previous windows were set to 1 by the generator
        $doCampaigns->viewwindow = rand(2,360);
        $doCampaigns->clickwindow = rand(2,360);
        $doCampaigns->update();
        $aAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        // Since this is the 2nd OA_AUDIT_ACTION_UPDATE for this test, make sure we only look at the latest record
        $oAudit = array_pop($aAudit);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['viewwindow']['is'],$doCampaigns->viewwindow,'expected viewwindow='.$doCampaigns->clickwindow.' got '.$aAudit['viewwindow']['is']);
        $this->assertEqual($aAudit['clickwindow']['is'],$doCampaigns->clickwindow,'expected clickwindow='.$doCampaigns->clickwindow.' got '.$aAudit['clickwindow']['is']);

        
        $doCampaigns->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['campaignid'],$campaignId);

        DataGenerator::cleanUp(array('accounts', 'campaigns', 'audit'));
    }

    function testAuditCampaignTrackers()
    {
        $doCampaignsTrackers = OA_Dal::factoryDO($context = 'campaigns_trackers');

        $doCampaignsTrackers->trackerid  = DataGenerator::generateOne('trackers', true);
        $campaign_trackerId = DataGenerator::generateOne($doCampaignsTrackers, true);
        $doCampaignsTrackers = OA_Dal::staticGetDO('campaigns_trackers', $campaign_trackerId);
        $this->assertNotNull($campaign_trackerId,'failed to insert campaign_tracker');
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$campaign_trackerId,'expected contextid '.$campaign_trackerId.' got '.$oAudit->contextid);
        $this->assertEqual($aAudit['campaign_trackerid'],$campaign_trackerId,'expected (details) campaign_trackerid '.$campaign_trackerId);
        $this->assertEqual($aAudit['campaignid'],$doCampaignsTrackers->campaignid,'expected (details) campaignid='.$doCampaignsTrackers->campaignid.' got '.$aAudit['campaignid']);
        $this->assertEqual($aAudit['trackerid'],$doCampaignsTrackers->trackerid,'expected (details) trackerid='.$doCampaignsTrackers->trackerid.' got '.$aAudit['trackerid']);

        $doCampaignsTrackers->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['campaign_trackerid'],$campaign_trackerId,'expected (details) campaign_trackerid '.$campaign_trackerId.' got '.$aAudit['campaign_trackerid']);

        DataGenerator::cleanUp(array('accounts', 'campaigns_trackers', 'audit'));
    }

    function testAuditCampaignLinkTrackers()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');

        $doTrackers = OA_Dal::factoryDO($context = 'trackers');
        $doTrackers->clientid = $doCampaigns->clientid;
        $doTrackers->linkcampaigns = 't';

        $trackerId = DataGenerator::generateOne($doTrackers, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($aAudit['clientid'],1);
        $this->assertEqual($aAudit['trackerid'],$trackerId);

        DataGenerator::cleanUp(array('accounts', 'campaigns', 'trackers', 'campaigns_trackers', 'audit'));
    }

    function testAuditBanner()
    {
        $doBanners = OA_Dal::factoryDO($context = 'banners');

        $doBanners->description = 'Banner A';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doBanners->description);
        $this->assertEqual($aAudit['bannerid'],$bannerId);
        $this->assertEqual($aAudit['description'],$doBanners->description);
        $this->assertEqual($aAudit['campaignid'],1);

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $doBanners->description = 'Banner B';
        $doBanners->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['description']['is'],$doBanners->description);
        $this->assertEqual($aAudit['description']['was'],'Banner A');

        $doBanners->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['bannerid'],$bannerId);

        DataGenerator::cleanUp(array('accounts', 'banners', 'audit'));
    }

    function testAuditAcls()
    {
        $doBanners = OA_Dal::factoryDO($context = 'acls');

        $doAcls = OA_Dal::factoryDO('acls');
        $aResult = array();

        $doBanners = OA_Dal::factoryDO('banners');
        $bannerId = DataGenerator::generateOne($doBanners, true);

        $doAcls->bannerid = $bannerId;
        $doAcls->logical = 'and';
        $doAcls->type = 'Geo:Country';
        $doAcls->comparison = '==';
        $doAcls->data = 'AF,DZ,AD';
        $doAcls->executionorder = 0;

        $aclsId = DataGenerator::generateOne($doAcls);
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_INSERT);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doAcls->type);
        $this->assertEqual($aAudit['bannerid'],$bannerId);
        $this->assertEqual($aAudit['logical'],$doAcls->logical);
        $this->assertEqual($aAudit['type'],$doAcls->type);
        $this->assertEqual($aAudit['comparison'],$doAcls->comparison);
        $this->assertEqual($aAudit['data'],$doAcls->data);
        $this->assertEqual($aAudit['executionorder'],$doAcls->executionorder);

        $doAcls = OA_Dal::staticGetDO('acls', 'bannerid', $bannerId);
        $doAcls->data = 'AX,EZ,AZ';
        $doAcls->update();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_UPDATE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doAcls->type);
        $this->assertEqual($aAudit['data']['is'],$doAcls->data);
        $this->assertEqual($aAudit['data']['was'],'AF,DZ,AD');

        $doAcls->delete();
        $oAudit = $this->_fetchAuditRecord($context, OA_AUDIT_ACTION_DELETE);
        $aAudit = unserialize($oAudit->details);
        $this->assertEqual($oAudit->username,OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($oAudit->contextid,$bannerId);
        $this->assertEqual($aAudit['key_desc'],$doAcls->type);
        $this->assertEqual($aAudit['bannerid'],$bannerId);
        $this->assertEqual($aAudit['logical'],$doAcls->logical);
        $this->assertEqual($aAudit['type'],$doAcls->type);
        $this->assertEqual($aAudit['comparison'],$doAcls->comparison);
        $this->assertEqual($aAudit['data'],$doAcls->data);
        $this->assertEqual($aAudit['executionorder'],$doAcls->executionorder);

        DataGenerator::cleanUp(array('accounts', 'acls', 'audit'));
    }

    function testAuditAgency()
    {
        // insert an agency record
        // audit event 1 & 2
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->name = 'Agency';
        $doAgency->language = 'French';
        $doAgency->contact = 'Agency Admin';
        $doAgency->email = 'admin@agency.com';
        $agencyId1 = DataGenerator::generateOne($doAgency);

        // change the agency record
        // audit event 3 & 4
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId1);
        $doAgency->name = 'Agency Changed';
        $doAgency->language = 'German';
        $doAgency->contact = 'Agency Admin Changed';
        $doAgency->email = 'newadmin@agency.com';
        $doAgency->update();

        // add a client for this agency
        // audit event 5 & 6
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId1;
        $doClients->clientname = 'Client A';
        $doClients->reportlastdate = '2007-04-03 18:39:45';
        $clientId = DataGenerator::generateOne($doClients);

        // delete the agency record
        // audit event 7 & 8 & 9 (1 agency, 1 client, 1 acc)
        $doAgency->delete();

        $aAudit = $this->_fetchAuditArrayAll();
        $this->assertEqual(count($aAudit), 9,'wrong number of audit records');

        // test 1: default agency account insert audited
        $this->assertTrue(isset($aAudit[1]));
        $aEvent = $aAudit[1];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],1);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'accounts');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertIsA($aEvent['array'], 'array');
        //$this->assertEqual($aEvent['array']['key_field'],0);
        $this->assertEqual($aEvent['array']['key_desc'],'Agency');
        //$this->assertEqual($aEvent['array']['account_id'],0);
        $this->assertEqual($aEvent['array']['account_name'],'Agency');
        $this->assertEqual($aEvent['array']['account_type'],'MANAGER');

        // test 2: new agency insert audited
        $this->assertTrue(isset($aAudit[2]));
        $aEvent = $aAudit[2];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],2);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'agency');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);
        $this->assertEqual($aEvent['array']['name'],'Agency');
        $this->assertEqual($aEvent['array']['contact'],'Agency Admin');


        // test 3: agency account update audited
        $this->assertTrue(isset($aAudit[3]));
        $aEvent = $aAudit[3];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],3);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_UPDATE);
        $this->assertEqual($aEvent['context'],'agency');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['contact']['is'],'Agency Admin Changed');
        $this->assertEqual($aEvent['array']['contact']['was'],'Agency Admin');
        $this->assertEqual($aEvent['array']['email']['is'],'newadmin@agency.com');
        $this->assertEqual($aEvent['array']['email']['was'],'admin@agency.com');
        $this->assertEqual($aEvent['array']['name']['is'],'Agency Changed');
        $this->assertEqual($aEvent['array']['name']['was'],'Agency');

        // test 4: new agency update audited
        $this->assertTrue(isset($aAudit[4]));
        $aEvent = $aAudit[4];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],4);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_UPDATE);
        $this->assertEqual($aEvent['context'],'accounts');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        //$this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['account_name']['is'],'Agency Changed');
        $this->assertEqual($aEvent['array']['account_name']['was'],'Agency');

        // test 5: new agency account update audited
        $this->assertTrue(isset($aAudit[5]));
        $aEvent = $aAudit[5];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],5);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'accounts');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        //$this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Client A');
        $this->assertEqual($aEvent['array']['account_name'],'Client A');
        $this->assertEqual($aEvent['array']['account_type'],'ADVERTISER');

        // test 6: new client insert audited
        $this->assertTrue(isset($aAudit[6]));
        $aEvent = $aAudit[6];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],6);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aEvent['context'],'clients');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aEvent['contextid'],$clientId);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Client A');
        $this->assertEqual($aEvent['array']['clientid'],$clientId);
        $this->assertEqual($aEvent['array']['clientname'],'Client A');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);

        // test 7: new agency delete audited
        $this->assertTrue(isset($aAudit[7]));
        $aEvent = $aAudit[7];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],7);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'agency');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);
        $this->assertEqual($aEvent['array']['name'],'Agency Changed');

        // test 8: new agency client delete audited
        $this->assertTrue(isset($aAudit[8]));
        $aEvent = $aAudit[8];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],8);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'clients');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aEvent['contextid'],$clientId);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Client A');
        $this->assertEqual($aEvent['array']['clientid'],$clientId);
        $this->assertEqual($aEvent['array']['clientname'],'Client A');
        $this->assertEqual($aEvent['array']['agencyid'],$agencyId1);

        // test 9: new agency account delete audited
        $this->assertTrue(isset($aAudit[9]));
        $aEvent = $aAudit[9];
        $this->assertIsA($aEvent, 'array');
        $this->assertEqual($aEvent['auditid'],9);
        $this->assertEqual($aEvent['actionid'],OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aEvent['context'],'accounts');
        $this->assertEqual($aEvent['username'],OA_TEST_AUDIT_USERNAME);
        //$this->assertEqual($aEvent['contextid'],$agencyId1);
        $this->assertIsA($aEvent['array'], 'array');
        $this->assertEqual($aEvent['array']['key_desc'],'Agency Changed');
        $this->assertEqual($aEvent['array']['account_name'],'Agency Changed');
        $this->assertEqual($aEvent['array']['account_type'],'MANAGER');

        DataGenerator::cleanUp(array('accounts', 'agency', 'clients', 'audit'));
    }

    function testAuditParentId()
    {
        // Insert a banner with parents
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->description = 'Banner A';
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $campaignId = DataGenerator::getReferenceId('campaigns');

        // Delete the campaign
        $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
        $doCampaigns->delete();

        // Test the campaign auditid == banner parentid
        $oAuditCampaign = $this->_fetchAuditRecord('campaigns', OA_AUDIT_ACTION_DELETE);
        $this->assertNull($oAuditCampaign->parentid);

        $oAuditBanner = $this->_fetchAuditRecord('banners', OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($oAuditCampaign->auditid, $oAuditBanner->parentid);

        DataGenerator::cleanUp(array('accounts', 'campaigns', 'banners', 'audit'));

    }
    
    function getMatchingAudit($aResult, $context, $contextId, $action = null)
    {
        foreach($aResult as $aAudit) {
            if ($aAudit['context'] == $context && $aAudit['contextid'] == $contextId) {
                if (!empty($action) && $action != $aAudit['actionid']) {
                    continue;
                }
                return $aAudit;
            }
        }
        MAX::raiseError('No matchind audit record, context: '.$context.', contextid: '.$contextId);
        return false;
    }
    
    /**
     * auditing a more complex scenario
     * create a banner - this should create a default assoc between banner and zone 0
     * create a zone and link the banner to the new zone
     * delete the zone - this should delete the linked assoc
     * delete the banner - this should delete the default assoc between banner and zone 0
     */
    function testAuditAdZoneAssoc()
    {
        global $session;

        // In this test, all ancestors are generated manually, otherwise the
        // DataGenerator will create separate "owning" manager accounts for
        // the banner and the zone; and linking these is not permitted!

        // Insert a common manager account
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId = DataGenerator::generateOne($doAgency);

        // Insert an advertiser
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = $agencyId;
        $advertiserId = DataGenerator::generateOne($doClients);

        // Insert a campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $advertiserId;
        $campaignId = DataGenerator::generateOne($doCampaigns);

        // Insert a banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->description = 'Banner A';
        $bannerId = DataGenerator::generateOne($doBanners);

        // Insert a website
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId;
        $websiteId = DataGenerator::generateOne($doAffiliates);

        // Insert a zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $websiteId;
        $doZones->zonename = 'Zone A';
        $zoneId = DataGenerator::generateOne($doZones);

        // Link the banner and the zone
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $bannerId;
        $doAdZoneAssoc->zone_id = $zoneId;
        $doAdZoneAssoc->link_type = 99;
        $doAdZoneAssoc->priority = 1;
        $doAdZoneAssoc->priority_factor = 2;
        $doAdZoneAssoc->to_be_delivered = 1;
        $adZoneAssocId = $doAdZoneAssoc->insert();

        // deleting a zone should trigger deletion of assocs linked to that zone
        $doZones = OA_Dal::staticGetDO('zones', $zoneId);
        $doZones->delete();

        // deleting a banner should trigger deletion of default assoc
        // (also other zone assocs, could test that by deleting banner without deleting zone)
        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $doBanners->delete();

        $aResult = $this->_fetchAuditArrayAll();

        // Test 1 :test the insert banner audit
        $aAudit = $this->getMatchingAudit($aResult, 'banners', $bannerId, OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$bannerId);
        $this->assertEqual($aAudit['array']['key_desc'],$doBanners->description);
        $this->assertEqual($aAudit['array']['bannerid'],$bannerId);
        $this->assertEqual($aAudit['array']['description'],$doBanners->description);
        $this->assertEqual($aAudit['array']['campaignid'],$doBanners->campaignid);

        // Test 2 :test the insert (default) adzoneassoc audit
        $aAudit = $this->getMatchingAudit($aResult, 'ad_zone_assoc', $adZoneAssocId-1, OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId-1);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #0');
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'],0);
        $this->assertEqual($aAudit['array']['link_type'],0);
        $this->assertEqual($aAudit['array']['priority'],0);
        $this->assertEqual($aAudit['array']['priority_factor'],0);
        $this->assertEqual($aAudit['array']['to_be_delivered'],0);

        // Test 3 :test the insert zone audit
        $aAudit = $this->getMatchingAudit($aResult, 'zones', $zoneId, OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$zoneId);
        $this->assertEqual($aAudit['array']['key_desc'],$doZones->zonename);
        $this->assertEqual($aAudit['array']['zoneid'],$zoneId);
        $this->assertEqual($aAudit['array']['zonename'],$doZones->zonename);
        $this->assertEqual($aAudit['array']['affiliateid'],$doZones->affiliateid);

        // Test 4: test the insert (user linked) adzoneassoc audit
        $aAudit = $this->getMatchingAudit($aResult, 'ad_zone_assoc', $adZoneAssocId, OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #'.$zoneId);
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'],$zoneId);
        $this->assertEqual($aAudit['array']['link_type'], 99);
        $this->assertEqual($aAudit['array']['priority'],   1);
        $this->assertEqual($aAudit['array']['priority_factor'], 2);
        $this->assertEqual($aAudit['array']['to_be_delivered'],'true');

        // Test 5 :test the delete zone audit
        $aAudit = $this->getMatchingAudit($aResult, 'zones', $zoneId, OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$zoneId);
        $this->assertEqual($aAudit['array']['key_desc'],$doZones->zonename);
        $this->assertEqual($aAudit['array']['zoneid'],$zoneId);
        $this->assertEqual($aAudit['array']['zonename'],$doZones->zonename);
        $this->assertEqual($aAudit['array']['affiliateid'],$doZones->affiliateid);

        // Test 6: test the delete (user linked) adzoneassoc audit
        $aAudit = $this->getMatchingAudit($aResult, 'ad_zone_assoc', $adZoneAssocId, OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #'.$zoneId);
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'],$zoneId);
        $this->assertEqual($aAudit['array']['link_type'], 99);
        $this->assertEqual($aAudit['array']['priority'],   1);
        $this->assertEqual($aAudit['array']['priority_factor'], 2);
        $this->assertEqual($aAudit['array']['to_be_delivered'],'true');

        // Test 7 :test the delete banner audit
        $aAudit = $this->getMatchingAudit($aResult, 'banners', $bannerId, OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$bannerId);
        $this->assertEqual($aAudit['array']['key_desc'],$doBanners->description);
        $this->assertEqual($aAudit['array']['bannerid'],$bannerId);
        $this->assertEqual($aAudit['array']['description'],$doBanners->description);
        $this->assertEqual($aAudit['array']['campaignid'],$doBanners->campaignid);

        // Test 8: test the delete (default) audit result
        $aAudit = $this->getMatchingAudit($aResult, 'ad_zone_assoc', $adZoneAssocId-1, OA_AUDIT_ACTION_DELETE);
        $this->assertEqual($aAudit['username'],OA_TEST_AUDIT_USERNAME);
        $this->assertEqual($aAudit['contextid'],$adZoneAssocId-1);
        $this->assertEqual($aAudit['array']['key_desc'],'Ad #'.$bannerId.' -> Zone #0');
        $this->assertEqual($aAudit['array']['ad_id'],$bannerId);
        $this->assertEqual($aAudit['array']['zone_id'], 0);
        $this->assertEqual($aAudit['array']['link_type'],0);
        $this->assertEqual($aAudit['array']['priority'], 0);
        $this->assertEqual($aAudit['array']['priority_factor'], 0);
        $this->assertEqual($aAudit['array']['to_be_delivered'], 0);

        DataGenerator::cleanUp(array('accounts', 'banners', 'zones', 'ad_zone_assoc', 'audit'));
    }
    
    function generateAccountId()
    {
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_name = 'Default Manager';
        $doAccounts->account_type = OA_ACCOUNT_MANAGER;
        return DataGenerator::generateOne($doAccounts);
    }
}

?>
