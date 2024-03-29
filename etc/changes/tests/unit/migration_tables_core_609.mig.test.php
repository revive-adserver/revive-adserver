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

require_once MAX_PATH . '/etc/changes/migration_tables_core_609.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

TestEnv::recreateDatabaseAsLatin1OnMysql();

/**
 * Test for migration class #609
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_609Test extends MigrationTest
{
    public $aTables = [
        'tblAppVar' => 'application_variable',
        'tblAccounts' => 'accounts',
        'tblAgency' => 'agency',
        'tblClients' => 'clients',
        'tblCampaigns' => 'campaigns',
        'tblPrefs' => 'preferences',
        'tblAccPrefs' => 'account_preference_assoc',
    ];


    public function testMigrateActivateExpire()
    {
        $prefix = $this->getPrefix();
        $oDbh = $this->oDbh;

        $aTblConf = $GLOBALS['_MAX']['CONF']['table'];

        foreach ($this->aTables as $k => $v) {
            $$k = $oDbh->quoteIdentifier($prefix . ($aTblConf[$v] ?? $v), true);
        }

        $this->initDatabase(608, array_values($this->aTables));

        $noDate = ($oDbh->dbsyntax == 'mysql' || $oDbh->dbsyntax == 'mysqli') ? "'0000-00-00'" : "NULL";

        // Create accounts
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (1, 'ADMIN', 'Admin')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (2, 'MANAGER', 'Agency 1')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (3, 'MANAGER', 'Agency 2')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (4, 'ADVERTISER', 'Client 1')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (5, 'ADVERTISER', 'Client 2')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (6, 'ADVERTISER', 'Client 3')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (7, 'MANAGER', 'Agency 3')");
        $oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (8, 'ADVERTISER', 'Client 4')");

        // Create admin account ID variable
        $oDbh->exec("INSERT INTO {$tblAppVar} (name, value) VALUES ('admin_account_id', '1')");

        // Create TZ preferences
        $oDbh->exec("INSERT INTO {$tblPrefs} (preference_id, preference_name, account_type) VALUES (16, 'timezone', 'MANAGER')");
        $oDbh->exec("INSERT INTO {$tblAccPrefs} (preference_id, account_id, value) VALUES (16, 1, 'Europe/Rome')");
        $oDbh->exec("INSERT INTO {$tblAccPrefs} (preference_id, account_id, value) VALUES (16, 2, 'America/New_York')");
        $oDbh->exec("INSERT INTO {$tblAccPrefs} (preference_id, account_id, value) VALUES (16, 7, 'Asia/Tokyo')");

        // Create agencies
        $oDbh->exec("INSERT INTO {$tblAgency} (agencyid, account_id, name, email) VALUES (1, 2, 'Agency 1', 'ag1@example.com')");
        $oDbh->exec("INSERT INTO {$tblAgency} (agencyid, account_id, name, email) VALUES (2, 3, 'Agency 2', 'ag2@example.com')");
        $oDbh->exec("INSERT INTO {$tblAgency} (agencyid, account_id, name, email) VALUES (3, 7, 'Agency 3', 'ag2@example.com')");

        // Create clients
        $oDbh->exec("INSERT INTO {$tblClients} (clientid, agencyid, account_id, clientname) VALUES (1, 1, 4, 'Client 1')");
        $oDbh->exec("INSERT INTO {$tblClients} (clientid, agencyid, account_id, clientname) VALUES (2, 1, 5, 'Client 2')");
        $oDbh->exec("INSERT INTO {$tblClients} (clientid, agencyid, account_id, clientname) VALUES (3, 2, 6, 'Client 3')");
        $oDbh->exec("INSERT INTO {$tblClients} (clientid, agencyid, account_id, clientname) VALUES (4, 3, 8, 'Client 4')");

        // Create campaigns
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname, activate, expire) VALUES (1, 1, 'Campaign 1', {$noDate}, {$noDate})");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname, activate, expire) VALUES (2, 1, 'Campaign 2', '2009-02-01', {$noDate})");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname, activate, expire) VALUES (3, 2, 'Campaign 3', {$noDate}, '2009-07-01')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname, activate, expire) VALUES (4, 3, 'Campaign 4', '2009-02-01', {$noDate})");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname, activate, expire) VALUES (5, 3, 'Campaign 5', {$noDate}, '2009-07-01')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname, activate, expire) VALUES (6, 4, 'Campaign 6', '2009-02-01', '2009-07-01')");

        // Migrate!
        $this->upgradeToVersion(609);

        $aCampaigns = $this->oDbh->getAssoc("SELECT campaignid, activate_time, expire_time FROM {$tblCampaigns} ORDER BY campaignid");
        $aExpected = [
            1 => ['activate_time' => null,                     'expire_time' => null],
            2 => ['activate_time' => '2009-02-01 05:00:00',    'expire_time' => null],
            3 => ['activate_time' => null,                     'expire_time' => '2009-07-02 03:59:59'],
            4 => ['activate_time' => '2009-01-31 23:00:00',    'expire_time' => null],
            5 => ['activate_time' => null,                     'expire_time' => '2009-07-01 21:59:59'],
            6 => ['activate_time' => '2009-01-31 15:00:00',    'expire_time' => '2009-07-01 14:59:59'],
        ];
        $this->assertEqual($aCampaigns, $aExpected);
    }
}
