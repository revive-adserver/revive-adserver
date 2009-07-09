<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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

require_once MAX_PATH . '/etc/changes/migration_tables_core_609.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #609
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Migration_609Test extends MigrationTest
{
    var $aTables = array(
        'tblAppVar'    => 'application_variable',
        'tblAccounts'  => 'accounts',
        'tblAgency'    => 'agency',
        'tblClients'   => 'clients',
        'tblCampaigns' => 'campaigns',
        'tblPrefs'     => 'preferences',
        'tblAccPrefs'  => 'account_preference_assoc',
    );


    function testMigrateActivateExpire()
    {
        $prefix = $this->getPrefix();
        $oDbh = $this->oDbh;

        foreach ($this->aTables as $k => $v) {
            $$k = $oDbh->quoteIdentifier($prefix.($aConf[$v] ? $aConf[$v] : $v), true);
        }

        $this->initDatabase(608, array_values($this->aTables));

        $noDate = $oDbh->dbsyntax == 'mysql' ? "'0000-00-00'" : "NULL";

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
        $aExpected = array(
            1 => array('activate_time' => null,                     'expire_time' => null),
            2 => array('activate_time' => '2009-02-01 05:00:00',    'expire_time' => null),
            3 => array('activate_time' => null,                     'expire_time' => '2009-07-02 03:59:59'),
            4 => array('activate_time' => '2009-01-31 23:00:00',    'expire_time' => null),
            5 => array('activate_time' => null,                     'expire_time' => '2009-07-01 21:59:59'),
            6 => array('activate_time' => '2009-01-31 15:00:00',    'expire_time' => '2009-07-01 14:59:59'),
        );
        $this->assertEqual($aCampaigns, $aExpected);

    }

}

?>