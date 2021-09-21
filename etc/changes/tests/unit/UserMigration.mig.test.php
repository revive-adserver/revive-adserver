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

require_once MAX_PATH . '/etc/changes/migration_tables_core_546.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Upgrade.php';

TestEnv::recreateDatabaseAsLatin1OnMysql();

/**
 * Test for migration class #546. Tests that the user/account preferences
 * from before the creation of the Users, Accounts, Permissions and
 * Preferences system are correctly migrated into global settings and
 * user and account preferences.
 *
 * @package    MigrationPackages
 * @subpackage TestSuite
 */
 class Test_Migration_546 extends MigrationTest
 {
     public $tblPrefsOld;
     public $tblAgency;
     public $tblAffiliates;
     public $tblChannel;
     public $tblClients;
     public $tblUsers;
     public $tblAccounts;
     public $tblPrefsNew;
     public $tblAccPrefs;
     public $tblAppVars;

     /**
      * An array of arrays, each containing known good preference table
      * configurations from past OpenX versions.
      *
      * 0 => A known good preference set from an OpenX 2.4 system that was upgraded
      *          from Openads 2.0.11-pr1
      * 1 => Default set from OpenX 2.4.4 after installation
      *
      * @var array
      */
     public $aPrefsOld = [
        0 => [
            'config_version' => 200.314,
            'my_header' => 'this is MY header',
            'my_footer' => 'this is MY footer',
            'my_logo' => 'this is MY logo',
            'language' => 'australian',
            'name' => 'AdServer',
            'company_name' => 'adhd.com',
            'override_gd_imageformat' => 'f',
            'begin_of_week' => 1,
            'percentage_decimals' => 2,
            'type_sql_allow' => 't',
            'type_url_allow' => 't',
            'type_web_allow' => 't',
            'type_html_allow' => 't',
            'type_txt_allow' => 't',
            'banner_html_auto' => 't',
            'admin_fullname' => 'Administrator',
            'admin_email' => 'admin@example.com',
            'warn_admin' => 't',
            'warn_agency' => 't',
            'warn_client' => 't',
            'warn_limit' => 2000,
            'admin_email_headers' => '',
            'admin_novice' => 't',
            'default_banner_weight' => 1,
            'default_campaign_weight' => 1,
            'default_banner_url' => '',
            'default_banner_destination' => '',
            'client_welcome' => 't',
            'client_welcome_msg' => 'hi there client!',
            'publisher_welcome' => 't',
            'publisher_welcome_msg' => 'hi there publisher!',
            'content_gzip_compression' => 't',
            'userlog_email' => 't',
            'gui_show_campaign_info' => 't',
            'gui_show_campaign_preview' => 't',
            'gui_campaign_anonymous' => 'f',
            'gui_show_banner_info' => 't',
            'gui_show_banner_preview' => 't',
            'gui_show_banner_html' => 't',
            'gui_show_matching' => 't',
            'gui_show_parents' => 't',
            'gui_hide_inactive' => 't',
            'gui_link_compact_limit' => 50,
            'gui_header_background_color' => '#FFFFFF',
            'gui_header_foreground_color' => '#000000',
            'gui_header_active_tab_color' => '#111111',
            'gui_header_text_color' => '#777777',
            'gui_invocation_3rdparty_default' => '0',
            'qmail_patch' => 'f',
            'updates_enabled' => 't',
            'updates_cache' => 'b:0;',
            'updates_timestamp' => 1199316921,
            'updates_last_seen' => 0.000,
            'allow_invocation_plain' => 't',
            'allow_invocation_plain_nocookies' => 'f',
            'allow_invocation_js' => 't',
            'allow_invocation_frame' => 'f',
            'allow_invocation_xmlrpc' => 'f',
            'allow_invocation_local' => 'f',
            'allow_invocation_interstitial' => 'f',
            'allow_invocation_popup' => 'f',
            'allow_invocation_clickonly' => 't',
            'auto_clean_tables' => 'f',
            'auto_clean_tables_interval' => 5,
            'auto_clean_userlog' => 't',
            'auto_clean_userlog_interval' => 3,
            'auto_clean_tables_vacuum' => 't',
            'autotarget_factor' => 0.69,
            'maintenance_timestamp' => 1199354707,
            'compact_stats' => 't',
            'statslastday' => '2008-01-01',
            'statslasthour' => 0,
            'default_tracker_status' => 1,
            'default_tracker_type' => 1,
            'default_tracker_linkcampaigns' => 'f',
            'publisher_agreement' => 'f',
            'publisher_agreement_text' => '',
            'publisher_payment_modes' => '',
            'publisher_currencies' => '',
            'publisher_categories' => '',
            'publisher_help_files' => '',
            'publisher_default_tax_id' => 'f',
            'publisher_default_approved' => 'f',
            'more_reports' => null,
            'gui_column_id' => ['1' => ['show' => 0, 'label' => 'id', 'rank' => 1]],
            'gui_column_requests' => ['1' => ['show' => 1, 'label' => 'requests', 'rank' => 2]],
            'gui_column_impressions' => ['1' => ['show' => 0, 'label' => 'impressions', 'rank' => 3]],
            'gui_column_clicks' => ['1' => ['show' => 1, 'label' => 'clicks', 'rank' => 4]],
            'gui_column_ctr' => ['1' => ['show' => 1, 'label' => 'ctr', 'rank' => 5]],
            'gui_column_conversions' => ['1' => ['show' => 1, 'label' => 'conversions', 'rank' => 6]],
            'gui_column_conversions_pending' => ['1' => ['show' => 0, 'label' => 'conversions_pending', 'rank' => 7]],
            'gui_column_sr_views' => ['1' => ['show' => 1, 'label' => 'sr_views', 'rank' => 8]],
            'gui_column_sr_clicks' => ['1' => ['show' => 0, 'label' => 'sr_clicks', 'rank' => 9]],
            'gui_column_revenue' => ['1' => ['show' => 1, 'label' => 'revenue', 'rank' => 10]],
            'gui_column_cost' => ['1' => ['show' => 1, 'label' => 'cost', 'rank' => 11]],
            'gui_column_bv' => ['1' => ['show' => 0, 'label' => 'bv', 'rank' => 12]],
            'gui_column_num_items' => ['1' => ['show' => 0, 'label' => 'num_items', 'rank' => 13]],
            'gui_column_revcpc' => ['1' => ['show' => 1, 'label' => 'revcpc', 'rank' => 14]],
            'gui_column_costcpc' => ['1' => ['show' => 1, 'label' => 'costcpc', 'rank' => 15]],
            'gui_column_technology_cost' => ['1' => ['show' => 1, 'label' => 'technology_cost', 'rank' => 16]],
            'gui_column_income' => ['1' => ['show' => 1, 'label' => 'income', 'rank' => 17]],
            'gui_column_income_margin' => ['1' => ['show' => 1, 'label' => 'income_margin', 'rank' => 18]],
            'gui_column_profit' => ['1' => ['show' => 1, 'label' => 'profit', 'rank' => 19]],
            'gui_column_margin' => ['1' => ['show' => 1, 'label' => 'margin', 'rank' => 20]],
            'gui_column_erpm' => ['1' => ['show' => 1, 'label' => 'erpm', 'rank' => 21]],
            'gui_column_erpc' => ['1' => ['show' => 1, 'label' => 'erpc', 'rank' => 22]],
            'gui_column_erps' => ['1' => ['show' => 1, 'label' => 'erps', 'rank' => 23]],
            'gui_column_eipm' => ['1' => ['show' => 1, 'label' => 'eipm', 'rank' => 24]],
            'gui_column_eipc' => ['1' => ['show' => 1, 'label' => 'eipc', 'rank' => 25]],
            'gui_column_eips' => ['1' => ['show' => 1, 'label' => 'eips', 'rank' => 26]],
            'gui_column_ecpm' => ['1' => ['show' => 1, 'label' => 'ecpm', 'rank' => 27]],
            'gui_column_ecpc' => ['1' => ['show' => 1, 'label' => 'ecpc', 'rank' => 28]],
            'gui_column_ecps' => ['1' => ['show' => 1, 'label' => 'ecps', 'rank' => 29]],
            'gui_column_epps' => ['1' => ['show' => 0, 'label' => 'epps', 'rank' => 30]],
            'maintenance_cron_timestamp' => 1198674011,
            'warn_limit_days' => 1
        ],
        1 => [
            'config_version' => 0.000,
            'my_header' => null,
            'my_footer' => null,
            'my_logo' => null,
            'language' => 'english',
            'name' => null,
            'company_name' => 'mysite.com',
            'override_gd_imageformat' => null,
            'begin_of_week' => 1,
            'percentage_decimals' => 2,
            'type_sql_allow' => 't',
            'type_url_allow' => 't',
            'type_web_allow' => 'f',
            'type_html_allow' => 't',
            'type_txt_allow' => 't',
            'banner_html_auto' => 't',
            'admin_fullname' => 'admin',
            'admin_email' => 'admin@example.com',
            'warn_admin' => 't',
            'warn_agency' => 't',
            'warn_client' => 't',
            'warn_limit' => 100,
            'admin_email_headers' => null,
            'admin_novice' => 't',
            'default_banner_weight' => 1,
            'default_campaign_weight' => 1,
            'default_banner_url' => null,
            'default_banner_destination' => null,
            'client_welcome' => 't',
            'client_welcome_msg' => null,
            'publisher_welcome' => 't',
            'publisher_welcome_msg' => null,
            'content_gzip_compression' => 'f',
            'userlog_email' => 't',
            'gui_show_campaign_info' => 't',
            'gui_show_campaign_preview' => 'f',
            'gui_campaign_anonymous' => 'f',
            'gui_show_banner_info' => 't',
            'gui_show_banner_preview' => 't',
            'gui_show_banner_html' => 'f',
            'gui_show_matching' => 't',
            'gui_show_parents' => 'f',
            'gui_hide_inactive' => 'f',
            'gui_link_compact_limit' => 50,
            'gui_header_background_color' => null,
            'gui_header_foreground_color' => null,
            'gui_header_active_tab_color' => null,
            'gui_header_text_color' => null,
            'gui_invocation_3rdparty_default' => '',
            'qmail_patch' => 'f',
            'updates_enabled' => 't',
            'updates_cache' => 'b:0;',
            'updates_timestamp' => 1205747697,
            'updates_last_seen' => 0.000,
            'allow_invocation_plain' => 'f',
            'allow_invocation_plain_nocookies' => 't',
            'allow_invocation_js' => 't',
            'allow_invocation_frame' => 'f',
            'allow_invocation_xmlrpc' => 'f',
            'allow_invocation_local' => 't',
            'allow_invocation_interstitial' => 't',
            'allow_invocation_popup' => 't',
            'allow_invocation_clickonly' => 't',
            'auto_clean_tables' => 'f',
            'auto_clean_tables_interval' => 5,
            'auto_clean_userlog' => 't',
            'auto_clean_userlog_interval' => 5,
            'auto_clean_tables_vacuum' => 't',
            'autotarget_factor' => -1,
            'maintenance_timestamp' => 0,
            'compact_stats' => 't',
            'statslastday' => '0000-00-00',
            'statslasthour' => 0,
            'default_tracker_status' => 1,
            'default_tracker_type' => 1,
            'default_tracker_linkcampaigns' => 'f',
            'publisher_agreement' => 'f',
            'publisher_agreement_text' => null,
            'publisher_payment_modes' => null,
            'publisher_currencies' => null,
            'publisher_categories' => null,
            'publisher_help_files' => null,
            'publisher_default_tax_id' => 'f',
            'publisher_default_approved' => 'f',
            'more_reports' => null,
            'gui_column_id' => null,
            'gui_column_requests' => null,
            'gui_column_impressions' => null,
            'gui_column_clicks' => null,
            'gui_column_ctr' => null,
            'gui_column_conversions' => null,
            'gui_column_conversions_pending' => null,
            'gui_column_sr_views' => null,
            'gui_column_sr_clicks' => null,
            'gui_column_revenue' => null,
            'gui_column_cost' => null,
            'gui_column_bv' => null,
            'gui_column_num_items' => null,
            'gui_column_revcpc' => null,
            'gui_column_costcpc' => null,
            'gui_column_technology_cost' => null,
            'gui_column_income' => null,
            'gui_column_income_margin' => null,
            'gui_column_profit' => null,
            'gui_column_margin' => null,
            'gui_column_erpm' => null,
            'gui_column_erpc' => null,
            'gui_column_erps' => null,
            'gui_column_eipm' => null,
            'gui_column_eipc' => null,
            'gui_column_eips' => null,
            'gui_column_ecpm' => null,
            'gui_column_ecpc' => null,
            'gui_column_ecps' => null,
            'gui_column_epps' => null,
            'maintenance_cron_timestamp' => null,
            'warn_limit_days' => 1
        ]
    ];

     public function __construct()
     {
         // Ensure that the old preference table conf entry exists
         $GLOBALS['_MAX']['CONF']['table']['preference'] = 'preference';
         $aConf = &$GLOBALS['_MAX']['CONF']['table'];
         $this->oDbh = OA_DB::singleton();
         $prefix = $this->getPrefix();

         // Prepare all of the required table names that are used in the tests,
         // both old names and new
         $this->tblPrefsOld = $this->oDbh->quoteIdentifier($prefix . $aConf['preference'], true);
         $this->tblAgency = $this->oDbh->quoteIdentifier($prefix . $aConf['agency'], true);
         $this->tblAffiliates = $this->oDbh->quoteIdentifier($prefix . $aConf['affiliates'], true);
         $this->tblChannel = $this->oDbh->quoteIdentifier($prefix . $aConf['channel'], true);
         $this->tblClients = $this->oDbh->quoteIdentifier($prefix . $aConf['clients'], true);
         $this->tblUsers = $this->oDbh->quoteIdentifier($prefix . $aConf['users'], true);

         $this->tblAccounts = $this->oDbh->quoteIdentifier($prefix . $aConf['accounts'], true);
         $this->tblPrefsNew = $this->oDbh->quoteIdentifier($prefix . $aConf['preferences'], true);
         $this->tblAccPrefs = $this->oDbh->quoteIdentifier($prefix . $aConf['account_preference_assoc'], true);
         $this->tblAppVars = $this->oDbh->quoteIdentifier($prefix . $aConf['application_variable'], true);
     }

     /**
      * The master test class that performs the various upgrades of the system,
      * and calls private methods to test various sections of the upgrade.
      */
     public function testUpgrade()
     {
         $aConf = $GLOBALS['_MAX']['CONF'];
         // Run the tests for every set of preferences that have been defined
         foreach (array_keys($this->aPrefsOld) as $set) {
             if ($set == 1 && ($aConf['database']['type'] != 'mysql' || $aConf['database']['type'] != 'mysqli')) {
                 // OpenX 2.4.4 is only valid for MySQL
                 continue;
             }
             // Initialise the database at schema 542
             $this->initDatabase(
                 542,
                 [
                    'agency',
                    'affiliates',
                    'application_variable',
                    'audit',
                    'channel',
                    'clients',
                    'preference',
                    'preference_advertiser',
                    'preference_publisher',
                    'acls', 'acls_channel', 'banners', 'campaigns', 'tracker_append', 'trackers', 'userlog', 'variables', 'zones'
                ]
             );
             // Set up the database with the standard set of accounts,
             // preferences and settings
             $this->_setupAccounts();
             $this->_setupPreferences($set);
             // Perform the required upgrade on the database
             $this->upgradeToVersion(543);
             $this->upgradeToVersion(544);
             $this->upgradeToVersion(546);
             // Test the results of the upgrade
             $this->_testMigratePrefsToSettings($set);
             $this->_testMigratePrefsToAppVars($set);
             $this->_testMigratePrefsToPrefs($set);
             $this->_testMigrateUsers($set);
             // Restore the testing environment
             TestRunner::setupEnv(null);
             $this->oDbh = OA_DB::singleton();
         }
     }

     /**
      * A private method to configure:
      * - One admin account
      * - Five agency accounts
      * - Two publisher accounts
      * - Four channels
      * - Two advertiser accounts
      *
      * @access private
      */
     public function _setupAccounts()
     {
         $this->oDbh->exec("INSERT INTO {$this->tblPrefsOld} (agencyid, admin_fullname, admin_email, admin, admin_pw) VALUES (0, 'Administrator', 'admin@example.com', 'admin', 'admin')");
         $this->oDbh->exec("INSERT INTO {$this->tblPrefsOld} (agencyid) VALUES (1)");

         $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email) VALUES ('Agency 1', 'ag1@example.com')");
         $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password, language) VALUES ('Agency 2', 'ag2@example.com', 'agency2', 'agency2', 'portuguese')");
         $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password, language) VALUES ('Agency 3', 'ag3@example.com', 'agency3', 'agency3', 'russian_koi8r')");
         $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password, language) VALUES ('Agency 4', 'ag4@example.com', 'agency4', NULL, 'french')");
         $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password) VALUES ('Agency 5', 'ag5@example.com', NULL, 'agency3')");

         $this->oDbh->exec("INSERT INTO {$this->tblAffiliates} (name, email, language, agencyid) VALUES ('Publisher 1', 'pu1@example.com', 'korean', 1)");
         $this->oDbh->exec("INSERT INTO {$this->tblAffiliates} (name, email, language, username, password) VALUES ('Publisher 2', 'pu2@example.com', 'german', 'publisher2', 'publisher2')");

         $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 1', 0, 0)");
         $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 2', 0, 2)");
         $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 3', 1, 0)");
         $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 4', 1, 1)");

         $this->oDbh->exec("INSERT INTO {$this->tblClients} (clientname, email, language, agencyid) VALUES ('Advertiser 1', 'ad1@example.com', 'chinese_big5', 1)");
         $this->oDbh->exec("INSERT INTO {$this->tblClients} (clientname, email, language, clientusername, clientpassword, agencyid) VALUES ('Advertiser 2', 'ad2@example.com', NULL, 'advertiser2', 'advertiser2', 3)");
     }

     /**
      * A private method to configure preferences. Sets up one
      * of the available sets of preferences stored in the
      * $this->aPrefsOld array.
      *
      * @access private
      * @param integer $set The index number of the preference
      *                     set to configure.
      */
     public function _setupPreferences($set)
     {
         // Set up the admin preferences
         $query = "UPDATE {$this->tblPrefsOld} SET ";
         $n = count($this->aPrefsOld[$set]) - 1;
         $i = 0;
         foreach ($this->aPrefsOld[$set] as $k => $v) {
             if (is_array($v)) {
                 $v = serialize($v);
             }
             $query .= $k . "=" . $v = $this->oDbh->quote($v, null, true, false);
             if ($i < $n) {
                 $query .= ",";
             }
             $i++;
         }
         $query .= " WHERE agencyid = 0";
         $this->oDbh->exec($query);

         // Set up the agency preferences
         // Agency 1 has identical preferences to that of the
         // admin user, except for the default_banner_url,
         // default_banner_destination and gui_column_id values
         $query = "UPDATE {$this->tblPrefsOld} SET ";
         $n = count($this->aPrefsOld[$set]) - 1;
         $i = 0;
         foreach ($this->aPrefsOld[$set] as $k => $v) {
             if ($k == 'default_banner_url') {
                 $v = 'http://www.custom_url.net';
             }
             if ($k == 'default_banner_destination') {
                 $v = 'http://www.custom_dest.net';
             }
             if ($k == 'gui_column_id') {
                 $v = serialize(['1' => ['show' => 1, 'label' => 'ident', 'rank' => 2]]);
             }
             $query .= $k . "=" . $v = $this->oDbh->quote($v, null, true, false);
             if ($i < $n) {
                 $query .= ",";
             }
             $i++;
         }
         $query .= " WHERE agencyid = 1";
         $this->oDbh->exec($query);
     }

     /**
      * A private method to return the expected configuration file
      * values that should be set when the preferences have been
      * migrated into the config file.
      *
      * @access private
      * @param integer $set The index number of the preference
      *                     set that has been configured.
      */
     public function _getSettingsExpectations($set)
     {
         $oMig = new Migration_546();
         foreach ($oMig->aConfMap as $section => $aPairs) {
             foreach ($aPairs as $newName => $oldName) {
                 $value = $this->aPrefsOld[$set][$oldName];
                 $aResult[$section][$newName] = $value;
             }
         }
         return $aResult;
     }

     /**
      * A private method to return the default preferences
      *
      * @access private
      */
     public function _getDefaultPreferences()
     {
         $oMig = new Migration_546();
         return $oMig->_getDefaultPreferences();
     }

     /**
      * A private method that tests that preferences have been
      * correctly migrated to settings.
      *
      * @access private
      * @param integer $set The index number of the preference
      *                     set that has been configured.
      */
     public function _testMigratePrefsToSettings($set)
     {
         $aConf = $GLOBALS['_MAX']['CONF'];
         // Get the expected results of the migration of preferences to settings
         $aSettingsExpectations = $this->_getSettingsExpectations($set);
         // Test the settings are correct
         foreach ($aSettingsExpectations as $section => $aPair) {
             $this->assertTrue(isset($aConf[$section]), "Section '$section' missing");
             foreach ($aPair as $key => $value) {
                 $this->assertTrue(isset($aConf[$section][$key]), "Key '$key' in section '$section' missing");
                 $this->assertEqual($aConf[$section][$key], $value, "Incorrect value \$aConf[{$section}][{$key}]: {{$aConf[$section][$key]}} != {{$value}}");
             }
         }
         TestEnv::restoreConfig();
     }

     /**
      * A private method that tests that preferences have been
      * correctly migrated to application variables.
      *
      * @access private
      * @param integer $set The index number of the preference
      *                     set that has been configured.
      */
     public function _testMigratePrefsToAppVars($set)
     {
         // Get the application variables from the database
         $query = "
            SELECT
                *
            FROM
                {$this->tblAppVars} AS av";
         $aResults = $this->oDbh->queryAll($query, null, null, true);

         // Test the application variables from the database
         $aAppVarExpectations['maintenance_timestamp'] = $this->aPrefsOld[$set]['maintenance_timestamp'];
         $aAppVarExpectations['maintenance_cron_timestamp'] = $this->aPrefsOld[$set]['maintenance_cron_timestamp'];
         foreach ($aAppVarExpectations as $name => $value) {
             $this->assertTrue(array_key_exists($name, $aResults));
             if (array_key_exists($name, $aResults)) {
                 $this->assertEqual($value, $aAppVarExpectations[$name], "Application variable $name has wrong value");
             }
         }
     }

     /**
      * A private method that tests that preferences have been
      * correctly migrated to to the new style of preferences.
      *
      * @access private
      * @param integer $set The index number of the preference
      *                     set that has been configured.
      */
     public function _testMigratePrefsToPrefs($set)
     {
         // Test 1 : Admin Prefs
         $query = "
            SELECT
                p.preference_name AS name,
                ap.value,
                p.account_type AS type
            FROM
                {$this->tblAccPrefs} AS ap
            LEFT JOIN
                {$this->tblPrefsNew} AS p
            ON
                p.preference_id = ap.preference_id
            LEFT JOIN
                {$this->tblAccounts} AS a
            ON
                a.account_id = ap.account_id
            WHERE
                a.account_type = 'ADMIN'";
         $aResults = $this->oDbh->queryAll($query, null, null, true);
         $aExpectations = $this->_getPrefsExpectations($set);
         $this->assertEqual(count($aResults), count($aExpectations));
         foreach ($aResults as $nameNew => $aVals) {
             $this->assertTrue(array_key_exists($nameNew, $aExpectations), "Did not locate preference $nameNew");
             if (array_key_exists($nameNew, $aExpectations)) {
                 $this->assertEqual($aVals['value'], $aExpectations[$nameNew]['value'], "Wrong value for admin preference '$nameNew'; Expected '{$aExpectations[$nameNew]['value']}', got '{$aVals['value']}'");
                 $this->assertEqual($aVals['type'], $aExpectations[$nameNew]['level'], 'Wrong preference level for ' . $nameNew);
             }
         }

         // Test 2 : Agency Prefs
         $query = "
            SELECT
                p.preference_name AS name,
                ap.value,
                p.account_type AS type
            FROM
                {$this->tblAccPrefs} AS ap
            LEFT JOIN
                {$this->tblPrefsNew} AS p
            ON
                p.preference_id = ap.preference_id
            LEFT JOIN
                {$this->tblAccounts} AS a
            ON
                a.account_id = ap.account_id
            LEFT JOIN
                {$this->tblAgency} AS ag
            ON
                ag.account_id = a.account_id
            WHERE
                ag.agencyid = 1";
         $aResults = $this->oDbh->queryAll($query, null, null, true);

         $aAgencyExpectations['default_banner_image_url'] = ['value' => 'http://www.custom_url.net'];
         $aAgencyExpectations['default_banner_destination_url'] = ['value' => 'http://www.custom_dest.net'];
         $this->assertEqual(count($aResults), count($aAgencyExpectations));
         foreach ($aResults as $nameNew => $aVals) {
             $this->assertTrue(array_key_exists($nameNew, $aAgencyExpectations));
             if (array_key_exists($nameNew, $aAgencyExpectations)) {
                 $this->assertEqual($aVals['value'], $aAgencyExpectations[$nameNew]['value'], 'Wrong value for agency preference ' . $nameNew);
                 $this->assertEqual($aVals['type'], $aExpectations[$nameNew]['level'], 'Wrong preference level for ' . $nameNew);
             }
         }
     }

     /**
      * A private method that returns the new preference values that are
      * expected after migration, based on the initial set of preferences
      * that were loaded.
      *
      * @access private
      * @param integer $set The index number of the preference
      *                     set that has been configured.
      * @return array The expected set of new preferences.
      */
     public function _getPrefsExpectations($set)
     {
         $aReturn = [
            'default_banner_image_url' => [
                                                               'value' => $this->aPrefsOld[$set]['default_banner_url'],
                                                               'level' => OA_ACCOUNT_TRAFFICKER
                                                            ],
            'default_banner_destination_url' => [
                                                               'value' => $this->aPrefsOld[$set]['default_banner_destination'],
                                                               'level' => OA_ACCOUNT_TRAFFICKER
                                                            ],
            'auto_alter_html_banners_for_click_tracking' => [
                                                                'value' => $this->aPrefsOld[$set]['banner_html_auto'],
                                                                'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'default_banner_weight' => [
                                                               'value' => $this->aPrefsOld[$set]['default_banner_weight'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'default_campaign_weight' => [
                                                               'value' => $this->aPrefsOld[$set]['default_campaign_weight'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'warn_email_admin' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_admin'],
                                                               'level' => OA_ACCOUNT_ADMIN
                                                            ],
            'warn_email_admin_impression_limit' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_limit'],
                                                               'level' => OA_ACCOUNT_ADMIN
                                                            ],
            'warn_email_admin_day_limit' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_limit_days'],
                                                               'level' => OA_ACCOUNT_ADMIN
                                                            ],
            'warn_email_manager' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_agency'],
                                                               'level' => OA_ACCOUNT_MANAGER
                                                            ],
            'warn_email_manager_impression_limit' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_limit'],
                                                               'level' => OA_ACCOUNT_MANAGER
                                                            ],
            'warn_email_manager_day_limit' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_limit_days'],
                                                                'level' => OA_ACCOUNT_MANAGER
                                                            ],
            'warn_email_advertiser' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_client'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'warn_email_advertiser_impression_limit' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_limit'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'warn_email_advertiser_day_limit' => [
                                                               'value' => $this->aPrefsOld[$set]['warn_limit_days'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'tracker_default_status' => [
                                                               'value' => $this->aPrefsOld[$set]['default_tracker_status'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'tracker_default_type' => [
                                                               'value' => $this->aPrefsOld[$set]['default_tracker_type'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'tracker_link_campaigns' => [
                                                               'value' => $this->aPrefsOld[$set]['default_tracker_linkcampaigns'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'ui_show_campaign_info' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_campaign_info'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'ui_show_banner_info' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_banner_info'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'ui_show_campaign_preview' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_campaign_preview'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'ui_show_banner_html' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_banner_html'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'ui_show_banner_preview' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_banner_preview'],
                                                               'level' => OA_ACCOUNT_ADVERTISER
                                                            ],
            'ui_hide_inactive' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_hide_inactive'],
                                                               'level' => ''
                                                            ],
            'ui_show_matching_banners' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_matching'],
                                                               'level' => OA_ACCOUNT_TRAFFICKER
                                                            ],
            'ui_show_matching_banners_parents' => [
                                                               'value' => $this->aPrefsOld[$set]['gui_show_parents'],
                                                               'level' => OA_ACCOUNT_TRAFFICKER
                                                            ],
            'ui_novice_user' => [
                                                               'value' => $this->aPrefsOld[$set]['admin_novice'],
                                                               'level' => ''
                                                            ],
            'ui_week_start_day' => [
                                                               'value' => $this->aPrefsOld[$set]['begin_of_week'],
                                                               'level' => ''
                                                            ],
            'ui_percentage_decimals' => [
                                                               'value' => $this->aPrefsOld[$set]['percentage_decimals'],
                                                               'level' => ''
                                                            ]
        ];
         if ($set == 0) {
             $aColumnPreferences = [
                'ui_column_id' => [
                                                            'value' => '',
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_requests' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_requests']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_impressions' => [
                                                            'value' => '',
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_clicks' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_clicks']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ctr' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ctr']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_conversions']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_pending' => [
                                                            'value' => '',
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_views' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_sr_views']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_clicks' => [
                                                            'value' => '',
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revenue' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_revenue']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_cost' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_cost']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_bv' => [
                                                            'value' => '',
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_num_items' => [
                                                            'value' => '',
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revcpc' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_revcpc']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_costcpc' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_costcpc']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_technology_cost' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_technology_cost']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_income']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_margin' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_income_margin']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_profit' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_profit']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_margin' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_margin']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpm' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erpm']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpc' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erpc']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erps' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erps']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipm' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eipm']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipc' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eipc']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eips' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eips']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpm' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecpm']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpc' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecpc']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecps' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecps']['1']['show'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_id_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_id']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_requests_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_requests']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_impressions_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_impressions']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_clicks_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_clicks']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ctr_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ctr']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_conversions']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_pending_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_conversions_pending']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_views_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_sr_views']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_clicks_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_sr_clicks']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revenue_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_revenue']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_cost_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_cost']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_bv_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_bv']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_num_items_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_num_items']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revcpc_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_revcpc']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_costcpc_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_costcpc']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_technology_cost_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_technology_cost']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_income']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_margin_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_income_margin']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_profit_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_profit']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_margin_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_margin']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpm_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erpm']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpc_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erpc']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erps_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erps']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipm_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eipm']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipc_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eipc']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eips_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eips']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpm_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecpm']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpc_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecpc']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecps_label' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecps']['1']['label'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_id_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_id']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_requests_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_requests']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_impressions_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_impressions']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_clicks_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_clicks']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ctr_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ctr']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_conversions']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_pending_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_conversions_pending']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_views_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_sr_views']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_clicks_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_sr_clicks']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revenue_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_revenue']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_cost_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_cost']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_bv_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_bv']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_num_items_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_num_items']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revcpc_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_revcpc']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_costcpc_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_costcpc']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_technology_cost_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_technology_cost']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_income']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_margin_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_income_margin']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_profit_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_profit']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_margin_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_margin']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpm_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erpm']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpc_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erpc']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erps_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_erps']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipm_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eipm']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipc_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eipc']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eips_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_eips']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpm_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecpm']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpc_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecpc']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecps_rank' => [
                                                            'value' => $this->aPrefsOld[$set]['gui_column_ecps']['1']['rank'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ]
            ];
         } elseif ($set == 1) {
             $aColumnDefaults = $this->_getDefaultPreferences();
             $aColumnPreferences = [
                'ui_column_id' => [
                                                            'value' => $aColumnDefaults['ui_column_id']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_requests' => [
                                                            'value' => $aColumnDefaults['ui_column_requests']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_impressions' => [
                                                            'value' => $aColumnDefaults['ui_column_impressions']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_clicks' => [
                                                            'value' => $aColumnDefaults['ui_column_clicks']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ctr' => [
                                                            'value' => $aColumnDefaults['ui_column_ctr']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions' => [
                                                            'value' => $aColumnDefaults['ui_column_conversions']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_pending' => [
                                                            'value' => $aColumnDefaults['ui_column_conversions_pending']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_views' => [
                                                            'value' => $aColumnDefaults['ui_column_sr_views']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_clicks' => [
                                                            'value' => $aColumnDefaults['ui_column_sr_clicks']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revenue' => [
                                                            'value' => $aColumnDefaults['ui_column_revenue']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_cost' => [
                                                            'value' => $aColumnDefaults['ui_column_cost']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_bv' => [
                                                            'value' => $aColumnDefaults['ui_column_bv']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_num_items' => [
                                                            'value' => $aColumnDefaults['ui_column_num_items']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revcpc' => [
                                                            'value' => $aColumnDefaults['ui_column_revcpc']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_costcpc' => [
                                                            'value' => $aColumnDefaults['ui_column_costcpc']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_technology_cost' => [
                                                            'value' => $aColumnDefaults['ui_column_technology_cost']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income' => [
                                                            'value' => $aColumnDefaults['ui_column_income']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_margin' => [
                                                            'value' => $aColumnDefaults['ui_column_income_margin']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_profit' => [
                                                            'value' => $aColumnDefaults['ui_column_profit']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_margin' => [
                                                            'value' => $aColumnDefaults['ui_column_margin']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpm' => [
                                                            'value' => $aColumnDefaults['ui_column_erpm']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpc' => [
                                                            'value' => $aColumnDefaults['ui_column_erpc']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erps' => [
                                                            'value' => $aColumnDefaults['ui_column_erps']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipm' => [
                                                            'value' => $aColumnDefaults['ui_column_eipm']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipc' => [
                                                            'value' => $aColumnDefaults['ui_column_eipc']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eips' => [
                                                            'value' => $aColumnDefaults['ui_column_eips']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpm' => [
                                                            'value' => $aColumnDefaults['ui_column_ecpm']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpc' => [
                                                            'value' => $aColumnDefaults['ui_column_ecpc']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecps' => [
                                                            'value' => $aColumnDefaults['ui_column_ecps']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_id_label' => [
                                                            'value' => $aColumnDefaults['ui_column_id_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_requests_label' => [
                                                            'value' => $aColumnDefaults['ui_column_requests_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_impressions_label' => [
                                                            'value' => $aColumnDefaults['ui_column_impressions_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_clicks_label' => [
                                                            'value' => $aColumnDefaults['ui_column_clicks_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ctr_label' => [
                                                            'value' => $aColumnDefaults['ui_column_ctr_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_label' => [
                                                            'value' => $aColumnDefaults['ui_column_conversions_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_pending_label' => [
                                                            'value' => $aColumnDefaults['ui_column_conversions_pending_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_views_label' => [
                                                            'value' => $aColumnDefaults['ui_column_sr_views_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_clicks_label' => [
                                                            'value' => $aColumnDefaults['ui_column_sr_clicks_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revenue_label' => [
                                                            'value' => $aColumnDefaults['ui_column_revenue_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_cost_label' => [
                                                            'value' => $aColumnDefaults['ui_column_cost_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_bv_label' => [
                                                            'value' => $aColumnDefaults['ui_column_bv_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_num_items_label' => [
                                                            'value' => $aColumnDefaults['ui_column_num_items_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revcpc_label' => [
                                                            'value' => $aColumnDefaults['ui_column_revcpc_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_costcpc_label' => [
                                                            'value' => $aColumnDefaults['ui_column_costcpc_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_technology_cost_label' => [
                                                            'value' => $aColumnDefaults['ui_column_technology_cost_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_label' => [
                                                            'value' => $aColumnDefaults['ui_column_income_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_margin_label' => [
                                                            'value' => $aColumnDefaults['ui_column_income_margin_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_profit_label' => [
                                                            'value' => $aColumnDefaults['ui_column_profit_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_margin_label' => [
                                                            'value' => $aColumnDefaults['ui_column_margin_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpm_label' => [
                                                            'value' => $aColumnDefaults['ui_column_erpm_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpc_label' => [
                                                            'value' => $aColumnDefaults['ui_column_erpc_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erps_label' => [
                                                            'value' => $aColumnDefaults['ui_column_erps_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipm_label' => [
                                                            'value' => $aColumnDefaults['ui_column_eipm_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipc_label' => [
                                                            'value' => $aColumnDefaults['ui_column_eipc_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eips_label' => [
                                                            'value' => $aColumnDefaults['ui_column_eips_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpm_label' => [
                                                            'value' => $aColumnDefaults['ui_column_ecpm_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpc_label' => [
                                                            'value' => $aColumnDefaults['ui_column_ecpc_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecps_label' => [
                                                            'value' => $aColumnDefaults['ui_column_ecps_label']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_id_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_id_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_requests_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_requests_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_impressions_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_impressions_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_clicks_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_clicks_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ctr_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_ctr_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_conversions_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_conversions_pending_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_conversions_pending_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_views_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_sr_views_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_sr_clicks_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_sr_clicks_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revenue_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_revenue_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_cost_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_cost_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_bv_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_bv_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_num_items_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_num_items_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_revcpc_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_revcpc_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_costcpc_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_costcpc_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_technology_cost_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_technology_cost_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_income_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_income_margin_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_income_margin_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_profit_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_profit_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_margin_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_margin_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpm_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_erpm_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erpc_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_erpc_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_erps_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_erps_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipm_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_eipm_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eipc_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_eipc_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_eips_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_eips_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpm_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_ecpm_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecpc_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_ecpc_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ],
                'ui_column_ecps_rank' => [
                                                            'value' => $aColumnDefaults['ui_column_ecps_rank']['default'],
                                                            'level' => OA_ACCOUNT_MANAGER
                                                         ]
            ];
         }
         $aReturn = array_merge($aReturn, $aColumnPreferences);
         return $aReturn;
     }



     public function _testMigrateUsers($set)
     {
         $aAgencies = $this->oDbh->queryAll("SELECT agencyid, name, email, account_id FROM {$this->tblAgency} ORDER BY agencyid");
         $aAffiliates = $this->oDbh->queryAll("SELECT affiliateid, agencyid, account_id FROM {$this->tblAffiliates} ORDER BY affiliateid");
         $aChannels = $this->oDbh->queryAll("SELECT channelid, agencyid FROM {$this->tblChannel} ORDER BY channelid");
         $aClients = $this->oDbh->queryAll("SELECT clientid, agencyid, account_id FROM {$this->tblClients} ORDER BY clientid");
         $aAccounts = $this->oDbh->queryAll("SELECT * FROM {$this->tblAccounts} ORDER BY account_id");
         $aUsers = $this->oDbh->queryAll("SELECT * FROM {$this->tblUsers} ORDER BY user_id");

         // Check Admin
         $acCount = 2;
         $usCount = 1;
         $aReturnAgencies = array_slice($aAgencies, -1);
         $aReturnAccounts = array_slice($aAccounts, 0, $acCount);
         $aReturnUsers = array_slice($aUsers, 0, $usCount);

         $this->assertEqual($aReturnAgencies, $this->_getAdminAgencies());
         $this->assertEqual($aReturnAccounts, $this->_getAdminAccounts());
         $this->assertEqual($aReturnUsers, $this->_getAdminUsers($set));

         // Check Manager
         $ac = 5;
         $us = 2;
         $acOffset = $acCount;
         $acCount += $ac;
         $usOffset = $usCount;
         $usCount += $us;
         $aReturnAgencies = array_slice($aAgencies, 0, $ac);
         $aReturnAccounts = array_slice($aAccounts, $acOffset, $ac);
         $aReturnUsers = array_slice($aUsers, $usOffset, $us);

         $this->assertEqual($aReturnAgencies, $this->_getManagerAgencies());
         $this->assertEqual($aReturnAccounts, $this->_getManagerAccounts());
         $this->assertEqual($aReturnUsers, $this->_getManagerUsers());

         // Check Advertiser
         $ac = 2;
         $us = 1;
         $acOffset = $acCount;
         $acCount += $ac;
         $usOffset = $usCount;
         $usCount += $us;
         $aReturnClients = array_slice($aClients, 0, $ac);
         $aReturnAccounts = array_slice($aAccounts, $acOffset, $ac);
         $aReturnUsers = array_slice($aUsers, $usOffset, $us);

         $this->assertEqual($aReturnClients, $this->_getAdvertiserClients());
         $this->assertEqual($aReturnAccounts, $this->_getAdvertiserAccounts());
         $this->assertEqual($aReturnUsers, $this->_getAdvertiserUsers());

         // Check Trafficker
         $ac = 2;
         $us = 1;
         $acOffset = $acCount;
         $acCount += $ac;
         $usOffset = $usCount;
         $usCount += $us;
         $aReturnAffiliates = array_slice($aAffiliates, 0, $ac);
         $aReturnAccounts = array_slice($aAccounts, $acOffset, $ac);
         $aReturnUsers = array_slice($aUsers, $usOffset, $us);

         $this->assertEqual($aReturnAffiliates, $this->_getTraffickerAffiliates());
         $this->assertEqual($aReturnAccounts, $this->_getTraffickerAccounts());
         $this->assertEqual($aReturnUsers, $this->_getTraffickerUsers());

         // Check channels
         $this->assertEqual($aChannels, $this->_getChannels());
     }

     public function _getAdminAgencies()
     {
         return [
            0 => [
                'agencyid' => '6',
                'name' => 'Default manager',
                'email' => 'admin@example.com',
                'account_id' => '2',
            ]
        ];
     }

     public function _getAdminAccounts()
     {
         return [
            0 => [
                'account_id' => '1',
                'account_type' => 'ADMIN',
                'account_name' => 'Administrator',
            ],
            1 => [
                'account_id' => '2',
                'account_type' => 'MANAGER',
                'account_name' => 'Default manager',
            ]
        ];
     }

     public function _getAdminUsers($set)
     {
         $aReturn = [
            0 => [
                'user_id' => '1',
                'email_address' => 'admin@example.com',
                'username' => 'admin',
                'password' => 'admin',
                'language' => 'en',
                'default_account_id' => '2',
                'comments' => null,
                'active' => '1',
            ]
        ];
         if ($set == 0) {
             $aReturn[0]['contact_name'] = 'Administrator';
         } elseif ($set == 1) {
             $aReturn[0]['contact_name'] = 'admin';
         }
         return $aReturn;
     }

     public function _getManagerAgencies()
     {
         return [
            0 => [
                'agencyid' => '1',
                'name' => 'Agency 1',
                'email' => 'ag1@example.com',
                'account_id' => '3',
            ],
            1 => [
                'agencyid' => '2',
                'name' => 'Agency 2',
                'email' => 'ag2@example.com',
                'account_id' => '4',
            ],
            2 => [
                'agencyid' => '3',
                'name' => 'Agency 3',
                'email' => 'ag3@example.com',
                'account_id' => '5',
            ],
            3 => [
                'agencyid' => '4',
                'name' => 'Agency 4',
                'email' => 'ag4@example.com',
                'account_id' => '6',
            ],
            4 => [
                'agencyid' => '5',
                'name' => 'Agency 5',
                'email' => 'ag5@example.com',
                'account_id' => '7',
            ]
        ];
     }

     public function _getManagerAccounts()
     {
         return [
            0 => [
                'account_id' => '3',
                'account_type' => 'MANAGER',
                'account_name' => 'Agency 1',
            ],
            1 => [
                'account_id' => '4',
                'account_type' => 'MANAGER',
                'account_name' => 'Agency 2',
            ],
            2 => [
                'account_id' => '5',
                'account_type' => 'MANAGER',
                'account_name' => 'Agency 3',
            ],
            3 => [
                'account_id' => '6',
                'account_type' => 'MANAGER',
                'account_name' => 'Agency 4',
            ],
            4 => [
                'account_id' => '7',
                'account_type' => 'MANAGER',
                'account_name' => 'Agency 5',
            ]
        ];
     }

     public function _getManagerUsers()
     {
         return [
            0 => [
                'user_id' => '2',
                'contact_name' => 'Agency 2',
                'email_address' => 'ag2@example.com',
                'username' => 'agency2',
                'password' => 'agency2',
                'language' => 'pt_BR',
                'default_account_id' => '4',
                'comments' => null,
                'active' => '1',
            ],
            1 => [
                'user_id' => '3',
                'contact_name' => 'Agency 3',
                'email_address' => 'ag3@example.com',
                'username' => 'agency3',
                'password' => 'agency3',
                'language' => 'ru',
                'default_account_id' => '5',
                'comments' => null,
                'active' => '1',
            ]
        ];
     }

     public function _getTraffickerAffiliates()
     {
         return [
            0 => [
                'affiliateid' => '1',
                'agencyid' => '1',
                'account_id' => '10',
            ],
            1 => [
                'affiliateid' => '2',
                'agencyid' => '6',
                'account_id' => '11',
            ]
        ];
     }

     public function _getTraffickerAccounts()
     {
         return [
            0 => [
                'account_id' => '10',
                'account_type' => 'TRAFFICKER',
                'account_name' => 'Publisher 1',
            ],
            1 => [
                'account_id' => '11',
                'account_type' => 'TRAFFICKER',
                'account_name' => 'Publisher 2',
            ]
        ];
     }

     public function _getTraffickerUsers()
     {
         return [
            0 => [
                'user_id' => '5',
                'contact_name' => 'Publisher 2',
                'email_address' => 'pu2@example.com',
                'username' => 'publisher2',
                'password' => 'publisher2',
                'language' => 'de',
                'default_account_id' => '11',
                'comments' => null,
                'active' => '1',
            ]
        ];
     }

     public function _getAdvertiserClients()
     {
         return [
            0 => [
                'clientid' => '1',
                'agencyid' => '1',
                'account_id' => '8',
            ],
            1 => [
                'clientid' => '2',
                'agencyid' => '3',
                'account_id' => '9',
            ]
        ];
     }

     public function _getAdvertiserAccounts()
     {
         return [
            0 => [
                'account_id' => '8',
                'account_type' => 'ADVERTISER',
                'account_name' => 'Advertiser 1',
            ],
            1 => [
                'account_id' => '9',
                'account_type' => 'ADVERTISER',
                'account_name' => 'Advertiser 2',
            ]
        ];
     }

     public function _getAdvertiserUsers()
     {
         return [
            0 => [
                'user_id' => '4',
                'contact_name' => 'Advertiser 2',
                'email_address' => 'ad2@example.com',
                'username' => 'advertiser2',
                'password' => 'advertiser2',
                'language' => 'ru',
                'default_account_id' => '9',
                'comments' => null,
                'active' => '1',
            ]
        ];
     }

     public function _getChannels()
     {
         return [
            0 => [
                'channelid' => '1',
                'agencyid' => '6',
            ],
            1 => [
                'channelid' => '2',
                'agencyid' => '6',
            ],
            2 => [
                'channelid' => '3',
                'agencyid' => '1',
            ],
            3 => [
                'channelid' => '4',
                'agencyid' => '1',
            ]
        ];
     }
 }
