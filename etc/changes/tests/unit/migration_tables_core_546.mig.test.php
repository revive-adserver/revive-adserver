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
$Id $
*/

require_once MAX_PATH . '/etc/changes/migration_tables_core_546.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';

/**
 * Test for migration class #546
 *
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class Migration_546Test extends MigrationTest
{
    var $tblPreference;
    var $tblAgency;
    var $tblAffilates;
    var $tblChannel;
    var $tblClients;
    var $tblUsers;
    var $tblAccounts;

    function Migration_546Test()
    {
        $this->oDbh = &OA_DB::singleton();
        $prefix = $this->getPrefix();
        $this->tblPreference = $this->oDbh->quoteIdentifier($prefix.'preference', true);
        $this->tblAgency     = $this->oDbh->quoteIdentifier($prefix.'agency', true);
        $this->tblAffilates  = $this->oDbh->quoteIdentifier($prefix.'affiliates', true);
        $this->tblChannel    = $this->oDbh->quoteIdentifier($prefix.'channel', true);
        $this->tblClients    = $this->oDbh->quoteIdentifier($prefix.'clients', true);
        $this->tblUsers      = $this->oDbh->quoteIdentifier($prefix.'users', true);
        $this->tblAccounts   = $this->oDbh->quoteIdentifier($prefix.'accounts', true);

        $this->_setupAccounts();
    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function _setupAccounts()
    {

        $this->initDatabase(542, array('agency', 'affiliates', 'application_variable', 'channel', 'clients', 'preference'));


        $this->oDbh->exec("INSERT INTO {$this->tblPreference} (agencyid, admin_fullname, admin_email, admin, admin_pw) VALUES
            (0, 'Administrator', 'admin@example.com', 'admin', 'admin')");
        $this->oDbh->exec("INSERT INTO {$this->tblPreference} (agencyid) VALUES (1)");

        //$this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblPreference}"), 2);

        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email) VALUES ('Agency 1', 'ag1@example.com')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password) VALUES ('Agency 2', 'ag2@example.com', 'agency2', 'agency2')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password) VALUES ('Agency 3', 'ag3@example.com', 'agency3', 'agency3')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password) VALUES ('Agency 4', 'ag4@example.com', 'agency4', NULL)");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password) VALUES ('Agency 5', 'ag5@example.com', NULL, 'agency3')");

        //$this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblAgency}"), 5);

        $this->oDbh->exec("INSERT INTO {$this->tblAffilates} (name, email, agencyid) VALUES ('Publisher 1', 'pu1@example.com', 1)");
        $this->oDbh->exec("INSERT INTO {$this->tblAffilates} (name, email, username, password) VALUES ('Publisher 2', 'pu2@example.com', 'publisher2', 'publisher2')");

        //$this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblAffilates}"), 2);

        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 1', 0, 0)");
        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 2', 0, 2)");
        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 3', 1, 0)");
        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 4', 1, 1)");

        //$this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblChannel}"), 4);

        $this->oDbh->exec("INSERT INTO {$this->tblClients} (clientname, email, agencyid) VALUES ('Advertiser 1', 'ad1@example.com', 1)");
        $this->oDbh->exec("INSERT INTO {$this->tblClients} (clientname, email, clientusername, clientpassword) VALUES ('Advertiser 2', 'ad2@example.com', 'advertiser2', 'advertiser2')");

        //$this->assertEqual($this->oDbh->getOne("SELECT COUNT(*) FROM {$tblClients}"), 2);

    }

    function testUpgradeSchema()
    {
        $this->upgradeToVersion(543);
        $this->upgradeToVersion(544);
        $this->upgradeToVersion(546);
    }

    function testMigratePreferences()
    {

    }


    function testMigrateUsers()
    {
        $aAgencies   = $this->oDbh->queryAll("SELECT agencyid, name, email, account_id FROM {$this->tblAgency} ORDER BY agencyid");
        $aAffiliates = $this->oDbh->queryAll("SELECT affiliateid, agencyid, account_id FROM {$this->tblAffilates} ORDER BY affiliateid");
        $aChannels   = $this->oDbh->queryAll("SELECT channelid, agencyid FROM {$this->tblChannel} ORDER BY channelid");
        $aClients    = $this->oDbh->queryAll("SELECT clientid, agencyid, account_id FROM {$this->tblClients} ORDER BY clientid");
        $aAccounts   = $this->oDbh->queryAll("SELECT * FROM {$this->tblAccounts} ORDER BY account_id");
        $aUsers      = $this->oDbh->queryAll("SELECT * FROM {$this->tblUsers} ORDER BY user_id");

        // Check Admin
        $acCount = 2;
        $usCount = 1;
        $aReturnAgencies = array_slice($aAgencies, -1);
        $aReturnAccounts = array_slice($aAccounts, 0, $acCount);
        $aReturnUsers    = array_slice($aUsers, 0, $usCount);

        $this->assertEqual($aReturnAgencies, $this->_getAdminAgencies());
        $this->assertEqual($aReturnAccounts, $this->_getAdminAccounts());
        $this->assertEqual($aReturnUsers,    $this->_getAdminUsers());

        // Check Manager
        $ac = 5;
        $us = 2;
        $acOffset = $acCount;
        $acCount  += $ac;
        $usOffset = $usCount;
        $usCount  += $us;
        $aReturnAgencies = array_slice($aAgencies, 0, $ac);
        $aReturnAccounts = array_slice($aAccounts, $acOffset, $ac);
        $aReturnUsers    = array_slice($aUsers, $usOffset, $us);

        $this->assertEqual($aReturnAgencies, $this->_getManagerAgencies());
        $this->assertEqual($aReturnAccounts, $this->_getManagerAccounts());
        $this->assertEqual($aReturnUsers,    $this->_getManagerUsers());

        // Check Advertiser
        $ac = 2;
        $us = 1;
        $acOffset = $acCount;
        $acCount  += $ac;
        $usOffset = $usCount;
        $usCount  += $us;
        $aReturnClients  = array_slice($aClients, 0, $ac);
        $aReturnAccounts = array_slice($aAccounts, $acOffset, $ac);
        $aReturnUsers    = array_slice($aUsers, $usOffset, $us);

        $this->assertEqual($aReturnClients,  $this->_getAdvertiserClients());
        $this->assertEqual($aReturnAccounts, $this->_getAdvertiserAccounts());
        $this->assertEqual($aReturnUsers,    $this->_getAdvertiserUsers());

        // Check Trafficker
        $ac = 2;
        $us = 1;
        $acOffset = $acCount;
        $acCount  += $ac;
        $usOffset = $usCount;
        $usCount  += $us;
        $aReturnAffiliates = array_slice($aAffiliates, 0, $ac);
        $aReturnAccounts   = array_slice($aAccounts, $acOffset, $ac);
        $aReturnUsers      = array_slice($aUsers, $usOffset, $us);

        $this->assertEqual($aReturnAffiliates, $this->_getTraffickerAffiliates());
        $this->assertEqual($aReturnAccounts,   $this->_getTraffickerAccounts());
        $this->assertEqual($aReturnUsers,      $this->_getTraffickerUsers());

        // Check channels
        $this->assertEqual($aChannels, $this->_getChannels());
   }

   function _getAdminAgencies()
   {
       return array (
          0 =>
          array (
            'agencyid' => '6',
            'name' => 'Default manager',
            'email' => 'admin@example.com',
            'account_id' => '2',
          ),
        );
   }

   function _getAdminAccounts()
   {
       return array (
          0 =>
          array (
            'account_id' => '1',
            'account_type' => 'ADMIN',
            'account_name' => 'Administrator',
          ),
          1 =>
          array (
            'account_id' => '2',
            'account_type' => 'MANAGER',
            'account_name' => 'Default manager',
          ),
        );
   }

   function _getAdminUsers()
   {
       return array (
          0 =>
          array (
            'user_id' => '1',
            'contact_name' => 'Administrator',
            'email_address' => 'admin@example.com',
            'username' => 'admin',
            'password' => 'admin',
            'default_account_id' => '2',
            'comments' => NULL,
            'active'   => '1',
          ),
        );
   }

   function _getManagerAgencies()
   {
       return array (
          0 =>
          array (
            'agencyid' => '1',
            'name' => 'Agency 1',
            'email' => 'ag1@example.com',
            'account_id' => '3',
          ),
          1 =>
          array (
            'agencyid' => '2',
            'name' => 'Agency 2',
            'email' => 'ag2@example.com',
            'account_id' => '4',
          ),
          2 =>
          array (
            'agencyid' => '3',
            'name' => 'Agency 3',
            'email' => 'ag3@example.com',
            'account_id' => '5',
          ),
          3 =>
          array (
            'agencyid' => '4',
            'name' => 'Agency 4',
            'email' => 'ag4@example.com',
            'account_id' => '6',
          ),
          4 =>
          array (
            'agencyid' => '5',
            'name' => 'Agency 5',
            'email' => 'ag5@example.com',
            'account_id' => '7',
          ),
        );
   }

   function _getManagerAccounts()
   {
       return array (
          0 =>
          array (
            'account_id' => '3',
            'account_type' => 'MANAGER',
            'account_name' => 'Agency 1',
          ),
          1 =>
          array (
            'account_id' => '4',
            'account_type' => 'MANAGER',
            'account_name' => 'Agency 2',
          ),
          2 =>
          array (
            'account_id' => '5',
            'account_type' => 'MANAGER',
            'account_name' => 'Agency 3',
          ),
          3 =>
          array (
            'account_id' => '6',
            'account_type' => 'MANAGER',
            'account_name' => 'Agency 4',
          ),
          4 =>
          array (
            'account_id' => '7',
            'account_type' => 'MANAGER',
            'account_name' => 'Agency 5',
          ),
        );
   }

   function _getManagerUsers()
   {
       return array (
          0 =>
          array (
            'user_id' => '2',
            'contact_name' => 'Agency 2',
            'email_address' => 'ag2@example.com',
            'username' => 'agency2',
            'password' => 'agency2',
            'default_account_id' => '4',
            'comments' => NULL,
            'active'   => '1',
          ),
          1 =>
          array (
            'user_id' => '3',
            'contact_name' => 'Agency 3',
            'email_address' => 'ag3@example.com',
            'username' => 'agency3',
            'password' => 'agency3',
            'default_account_id' => '5',
            'comments' => NULL,
            'active'   => '1',
          ),
        );
   }

   function _getTraffickerAffiliates()
   {
       return array (
          0 =>
          array (
            'affiliateid' => '1',
            'agencyid' => '1',
            'account_id' => '10',
          ),
          1 =>
          array (
            'affiliateid' => '2',
            'agencyid' => '6',
            'account_id' => '11',
          ),
        );
   }

   function _getTraffickerAccounts()
   {
       return array (
          0 =>
          array (
            'account_id' => '10',
            'account_type' => 'TRAFFICKER',
            'account_name' => 'Publisher 1',
          ),
          1 =>
          array (
            'account_id' => '11',
            'account_type' => 'TRAFFICKER',
            'account_name' => 'Publisher 2',
          ),
        );
   }

   function _getTraffickerUsers()
   {
       return array (
          0 =>
          array (
            'user_id' => '5',
            'contact_name' => 'Publisher 2',
            'email_address' => 'pu2@example.com',
            'username' => 'publisher2',
            'password' => 'publisher2',
            'default_account_id' => '11',
            'comments' => NULL,
            'active'   => '1',
          ),
        );
   }

   function _getAdvertiserClients()
   {
       return array (
          0 =>
          array (
            'clientid' => '1',
            'agencyid' => '1',
            'account_id' => '8',
          ),
          1 =>
          array (
            'clientid' => '2',
            'agencyid' => '6',
            'account_id' => '9',
          ),
        );
   }

   function _getAdvertiserAccounts()
   {
       return array (
          0 =>
          array (
            'account_id' => '8',
            'account_type' => 'ADVERTISER',
            'account_name' => 'Advertiser 1',
          ),
          1 =>
          array (
            'account_id' => '9',
            'account_type' => 'ADVERTISER',
            'account_name' => 'Advertiser 2',
          ),
        );
   }

   function _getAdvertiserUsers()
   {
       return array (
          0 =>
          array (
            'user_id' => '4',
            'contact_name' => 'Advertiser 2',
            'email_address' => 'ad2@example.com',
            'username' => 'advertiser2',
            'password' => 'advertiser2',
            'default_account_id' => '9',
            'comments' => NULL,
            'active'   => '1',
          ),
        );
   }

   function _getChannels()
   {
       return array (
          0 =>
          array (
            'channelid' => '1',
            'agencyid' => '6',
          ),
          1 =>
          array (
            'channelid' => '2',
            'agencyid' => '6',
          ),
          2 =>
          array (
            'channelid' => '3',
            'agencyid' => '1',
          ),
          3 =>
          array (
            'channelid' => '4',
            'agencyid' => '1',
          ),
        );
   }

}