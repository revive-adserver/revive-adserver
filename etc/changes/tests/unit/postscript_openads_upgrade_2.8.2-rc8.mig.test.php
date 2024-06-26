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

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.8.2-rc8.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

TestEnv::recreateDatabaseAsLatin1OnMysql();

/**
 * A class for testing acls with timezone
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_postscript_2_8_2_RC8Test extends MigrationTest
{
    public $aTables = [
        'tblAppVar' => 'application_variable',
        'tblAccounts' => 'accounts',
        'tblAgency' => 'agency',
        'tblClients' => 'clients',
        'tblCampaigns' => 'campaigns',
        'tblBanners' => 'banners',
        'tblAcls' => 'acls',
        'tblPrefs' => 'preferences',
        'tblAccPrefs' => 'account_preference_assoc',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->assertTrue($this->initDatabase(608, array_values($this->aTables)));
    }

    public function testExecute()
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger' . rand(),
            ['logOnly', 'logError', 'log'],
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        Mock::generatePartial(
            'OA_Upgrade',
            $mockUpgrade = 'OA_Upgrade' . rand(),
            ['addPostUpgradeTask'],
        );
        $mockUpgrade = new $mockUpgrade($this);
        $mockUpgrade->setReturnValue('addPostUpgradeTask', true);
        $mockUpgrade->oLogger = $oLogger;
        $mockUpgrade->oDBUpgrader = new OA_DB_Upgrade($oLogger);
        $mockUpgrade->oDBUpgrader->oTable = &$this->oaTable;

        $prefix = $this->oaTable->getPrefix();
        $oDbh = $this->oaTable->oDbh;

        $aTblConf = $GLOBALS['_MAX']['CONF']['table'];

        foreach ($this->aTables as $k => $v) {
            $$k = $oDbh->quoteIdentifier($prefix . ($aTblConf[$v] ?? $v), true);
        }

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
        $oDbh->exec("INSERT INTO {$tblAccPrefs} (preference_id, account_id, value) VALUES (16, 7, 'Asia/Tokio')");

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
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname) VALUES (1, 1, 'Campaign 1')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname) VALUES (2, 1, 'Campaign 2')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname) VALUES (3, 2, 'Campaign 3')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname) VALUES (4, 3, 'Campaign 4')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname) VALUES (5, 3, 'Campaign 5')");
        $oDbh->exec("INSERT INTO {$tblCampaigns} (campaignid, clientid, campaignname) VALUES (6, 4, 'Campaign 6')");

        // Create banners
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (1, 1, 'Banner 1')");
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (2, 1, 'Banner 2')");
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (3, 2, 'Banner 3')");
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (4, 3, 'Banner 4')");
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (5, 4, 'Banner 5')");
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (6, 5, 'Banner 6')");
        $oDbh->exec("INSERT INTO {$tblBanners} (bannerid, campaignid, alt) VALUES (7, 6, 'Banner 7')");

        // Create ACLs
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (1, 0, 'deliveryLimitations:Time:Date', '20090701')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (1, 1, 'deliveryLimitations:Time:Day',  '3,4')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (1, 2, 'deliveryLimitations:Time:Hour', '3,15@UTC')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (1, 3, 'deliveryLimitations:Client:IP', '127.0.0.1')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (2, 0, 'deliveryLimitations:Time:Date', '20090702')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (3, 0, 'deliveryLimitations:Time:Date', '20090703')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (5, 0, 'deliveryLimitations:Time:Date', '20090704')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (6, 0, 'deliveryLimitations:Client:IP', '127.0.0.1')");
        $oDbh->exec("INSERT INTO {$tblAcls} (bannerid, executionorder, type, data) VALUES (7, 0, 'deliveryLimitations:Time:Date', '20090705')");
        // Run the upgrade
        $postscript = new OA_UpgradePostscript_2_8_2_rc8();
        $ret = $postscript->execute([&$mockUpgrade]);
        $this->assertTrue($ret);

        // Test succesful upgrade
        $aResult = $oDbh->queryAll("SELECT data FROM {$tblAcls} ORDER BY bannerid, executionorder");
        $this->assertEqual($aResult, [
            ['data' => '20090701@America/New_York'], // Agency 1 TZ
            ['data' => '3,4@America/New_York'],      // Agency 1 TZ
            ['data' => '3,15@UTC'],                  // Hardcoded TZ - skipped
            ['data' => '127.0.0.1'],                 // Non-time - skipped
            ['data' => '20090702@America/New_York'], // Agency 1 TZ
            ['data' => '20090703@America/New_York'], // Agency 1 TZ
            ['data' => '20090704@Europe/Rome'],      // Admin TZ
            ['data' => '127.0.0.1'],                 // Non-time - skipped,
            ['data' => '20090705@Asia/Tokio'],       // Agency 3 TZ
        ]);
    }
}
