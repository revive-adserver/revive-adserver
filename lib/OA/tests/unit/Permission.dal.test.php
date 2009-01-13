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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing DAL Permission methods
 *
 * @package    OpenXPermission
 * @subpackage TestSuite
 *
 */
class Test_OA_Permission extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Permission()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testSwitchToSystemProcessUser()
    {
        global $session;

        OA_Permission::switchToSystemProcessUser('installer');

        $oUser = $session['user'];
        $this->assertIsA($oUser, 'OA_Permission_SystemUser');
        $this->assertEqual($oUser->aUser['username'], 'installer');

        OA_Permission::switchToSystemProcessUser();
        $this->assertNull($session['user']);

        $oUser = new OA_Permission_User(OA_Dal::factoryDO('users'));
        $oUser->aUser['username'] = 'testuser';
        $session['user'] = $oUser;

        OA_Permission::switchToSystemProcessUser('installer');

        $oUser = $session['user'];
        $this->assertIsA($oUser, 'OA_Permission_SystemUser');
        $this->assertEqual($oUser->aUser['username'], 'installer');

        OA_Permission::switchToSystemProcessUser('maintenance');

        $oUser = $session['user'];
        $this->assertIsA($oUser, 'OA_Permission_SystemUser');
        $this->assertEqual($oUser->aUser['username'], 'maintenance');

        OA_Permission::switchToSystemProcessUser();

        $oUser = $session['user'];
        $this->assertIsA($oUser, 'OA_Permission_User');
        $this->assertEqual($oUser->aUser['username'], 'testuser');
    }

    function testIsUsernameAllowed()
    {
        // If the names are the same then true
        $this->assertTrue(OA_Permission::isUsernameAllowed('foo', 'foo'));

        // Check users as client, affiliate, agency
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-02 12:00:00';
        $clientId = DataGenerator::generateOne($doClients);

        $username = 'username1'.rand(1,1000);
        $aUser = array(
            'contact_name' => 'contact',
            'email_address' => 'email@example.com',
            'username' => $username,
            'password' => 'password',
        );

        $doClient = OA_Dal::staticGetDO('clients', $clientId);
        $doClient->createUser($aUser);

        $this->assertFalse(OA_Permission::isUsernameAllowed($username, 'foo'));

        $this->assertTrue(OA_Permission::isUsernameAllowed('newname', 'foo'));
    }

    // hasAccessToObject($objectTable, $objectId, $accountId = null)
    function testHasAccessToObject()
    {
        $userTables = array(
		    OA_ACCOUNT_ADVERTISER => 'clients',
		    OA_ACCOUNT_TRAFFICKER => 'affiliates',
		    OA_ACCOUNT_MANAGER    => 'agency',
		);

        // Test if all users have access to new objects
        foreach ($userTables as $userType => $userTable) {
            $this->assertTrue(OA_Permission::hasAccessToObject('banners', null, rand(1,100), $userType));
        }

        // Create some record
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->acls_updated = '2007-04-05 16:18:00';
        $aData = array(
            'reportlastdate' => array('2007-04-05 16:18:00')
        );
        $dg = new DataGenerator();
        $dg->setData('clients', $aData);
        $bannerId = $dg->generateOne($doBanners, true);

        $clientId = DataGenerator::getReferenceId('clients');
        $doClient = OA_Dal::staticGetDO('clients', $clientId);

        $agencyId = DataGenerator::getReferenceId('agency');
        $doAgency = OA_Dal::staticGetDO('agency', $agencyId);

        // Test that admin doesn't have access anymore to all objects
        $this->assertFalse(OA_Permission::hasAccessToObject('banners', 'booId', 1, OA_ACCOUNT_ADMIN));

        // Test accounts have access
        $this->assertTrue(OA_Permission::hasAccessToObject('banners', $bannerId, $doClient->account_id, OA_ACCOUNT_ADVERTISER));
        $this->assertTrue(OA_Permission::hasAccessToObject('banners', $bannerId, $doAgency->account_id, OA_ACCOUNT_MANAGER));

        // Create users who don't have access
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->reportlastdate = '2007-04-05 16:18:00';
        $clientId2 = DataGenerator::generateOne($doClients);
        $agencyId2 = DataGenerator::generateOne('agency');

        $doClientId2 = OA_Dal::staticGetDO('clients', $clientId2);
        $doAgency2 = OA_Dal::staticGetDO('agency', $agencyId2);

        $this->assertFalse(OA_Permission::hasAccessToObject('banners', $bannerId, $fakeId = 123, OA_ACCOUNT_TRAFFICKER));
        $this->assertFalse(OA_Permission::hasAccessToObject('banners', $bannerId, $doClientId2->account_id, OA_ACCOUNT_ADVERTISER));
        $this->assertFalse(OA_Permission::hasAccessToObject('banners', $bannerId, $doAgency2->account_id, OA_ACCOUNT_MANAGER));
    }
}
?>