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

require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_EncodingMigration extends MigrationTest
{
    /**
     * The constructor method.
     */
    function Test_EncodingMigration()
    {
        $this->UnitTestCase();
    }

    /**
     * Test convertEncoding()
     *
     */
    function test_convertEncoding()
    {
        // Force client charset to latin1 so that the behaviour is similar to a real latin1 database
        // even if the database is encoded in utf8. At first we tried to drop the database an recreate
        // a latin1 encoded database, but PgSQL doesn't allow LATIN1 databases if the locale is set to
        // UTF-8.
        $GLOBALS['_MAX']['CONF']['databaseCharset'] = array(
            'checkComplete' => true,
            'clientCharset' => 'latin1'
        );

        // However MySQL versions < 4.1.2 didn't support charsets, so we don't need to do that
        // and assume that a database can store any 8bit data (which is in fact true)
        if ($this->oDbh->dbsyntax == 'mysql') {
            $aVersion = $this->oDbh->getServerVersion();
            if (version_compare($aVersion['native'], '4.1.2', '<')) {
                $GLOBALS['_MAX']['CONF']['databaseCharset']['clientCharset'] = '';
            }
        }

        // Set client charset
        OA_DB::setCharset($this->oDbh);

        // These tables are required for the encoding migration
        $aTables = array('acls', 'acls_channel', 'ad_zone_assoc', 'affiliates', 'affiliates_extra', 'agency', 'application_variable', 'banners', 'campaigns', 'channel', 'clients', 'preference', 'session', 'tracker_append', 'trackers', 'userlog', 'variables', 'zones');

        // These tables are referenced by schema changes between 515 and 546, therefore need to be created
        $aOtherTables = array('preference_publisher', 'accounts', 'users', 'account_user_assoc');//array('preference', 'data_raw_tracker_click', 'data_summary_zone_country_daily', 'data_summary_zone_country_forecast', 'data_summary_zone_country_monthly', 'data_summary_zone_domain_page_daily', 'data_summary_zone_domain_page_forecast', 'data_summary_zone_domain_page_monthly', 'data_summary_zone_site_keyword_daily', 'data_summary_zone_site_keyword_forecast', 'data_summary_zone_site_keyword_monthly', 'data_summary_zone_source_daily', 'data_summary_zone_source_forecast', 'data_summary_zone_source_monthly', 'preference_advertiser', 'preference_publisher');
        $this->initDatabase(543, array_merge($aTables, $aOtherTables));

        $this->aIds = TestEnv::loadData('encoding_schema_543','mdb2schema');

        // MD5s verified manually setting the terminal encoding to the right encoding.
        $expected = array(
            'latin1_utf8' => array (
                0 => array ('campaignid' => $this->aIds['campaigns'][1],'md5' => '1698982c38317c8c42ae4772bbee8f44',),
                1 => array ('campaignid' => $this->aIds['campaigns'][2],'md5' => '317f56003783a2a9284306eb57fe8146',),
                2 => array ('campaignid' => $this->aIds['campaigns'][3],'md5' => 'fa419947d425b10bd2485e090f4cae60',),
                3 => array ('campaignid' => $this->aIds['campaigns'][4],'md5' => '32395feef462f13071c2a2fe5e44c7c0',),
                4 => array ('campaignid' => $this->aIds['campaigns'][5],'md5' => '9932d540cb5b63f264b3f7391577fe93',),
                5 => array ('campaignid' => $this->aIds['campaigns'][6],'md5' => 'c6ae927806e0a61f9cd269659a225435',),
            ),
            'utf8_utf8'   => array(
                0 => array ('campaignid' => $this->aIds['campaigns'][1],'md5' => '1698982c38317c8c42ae4772bbee8f44',),
                1 => array ('campaignid' => $this->aIds['campaigns'][2],'md5' => '317f56003783a2a9284306eb57fe8146',),
                2 => array ('campaignid' => $this->aIds['campaigns'][3],'md5' => '8c8755d8f519c0245717475757d043f7',),
                3 => array ('campaignid' => $this->aIds['campaigns'][4],'md5' => '7269db488f9672cca26d93105a9a2559',),
                4 => array ('campaignid' => $this->aIds['campaigns'][5],'md5' => '19397ed80befa5539761afed23c4c27a',),
                5 => array ('campaignid' => $this->aIds['campaigns'][6],'md5' => 'a7d508c6c8a494c80e680033cecbc76d',),
            ),
        );

        $tblCampaigns = $this->oDbh->quoteIdentifier($this->getPrefix().'campaigns', true);

        // Check that the campaign names are correctly created:
        $query = "SELECT campaignid, campaignname FROM {$tblCampaigns}";
        $result = $this->oDbh->queryAll($query);
        foreach (array_keys($result) as $k) {
            $result[$k]['md5'] = md5($result[$k]['campaignname']);
            unset($result[$k]['campaignname']);
        }
        $this->assertIdentical($result, $expected['latin1_utf8']);

        // Upgrade the dataset and ensure that the upgraded campaign names were upgraded correctly:
        $this->upgradeToVersion(544);

        // Fields requiring encoding changes should now be correct
        $query = "SELECT campaignid, campaignname FROM {$tblCampaigns}";
        $result = $this->oDbh->queryAll($query);
        foreach (array_keys($result) as $k) {
            $result[$k]['md5'] = md5($result[$k]['campaignname']);
            unset($result[$k]['campaignname']);
        }
        $this->assertIdentical($result, $expected['utf8_utf8']);
    }

}

?>
