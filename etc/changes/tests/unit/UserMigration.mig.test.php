<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Migration_546Test extends MigrationTest
{
    var $tblPrefsOld;
    var $tblAgency;
    var $tblAffilates;
    var $tblChannel;
    var $tblClients;
    var $tblUsers;
    var $tblAccounts;
    var $tblPrefsNew;
    var $tblAccPrefs;
    var $tblAppVars;

    var $aPrefsOld = array(
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
                            'statslastday' => null,
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
                            'gui_column_id'                     => array('1'=>array('show'=>0,'label'=>'id','rank'=>1)),
                            'gui_column_requests'               => array('1'=>array('show'=>1,'label'=>'requests','rank'=>2)),
                            'gui_column_impressions'            => array('1'=>array('show'=>0,'label'=>'impressions','rank'=>3)),
                            'gui_column_clicks'                 => array('1'=>array('show'=>1,'label'=>'clicks','rank'=>4)),
                            'gui_column_ctr'                    => array('1'=>array('show'=>1,'label'=>'ctr','rank'=>5)),
                            'gui_column_conversions'            => array('1'=>array('show'=>1,'label'=>'conversions','rank'=>6)),
                            'gui_column_conversions_pending'    => array('1'=>array('show'=>0,'label'=>'conversions_pending','rank'=>7)),
                            'gui_column_sr_views'               => array('1'=>array('show'=>1,'label'=>'sr_views','rank'=>8)),
                            'gui_column_sr_clicks'              => array('1'=>array('show'=>0,'label'=>'sr_clicks','rank'=>9)),
                            'gui_column_revenue'                => array('1'=>array('show'=>1,'label'=>'revenue','rank'=>10)),
                            'gui_column_cost'                   => array('1'=>array('show'=>1,'label'=>'cost','rank'=>11)),
                            'gui_column_bv'                     => array('1'=>array('show'=>0,'label'=>'bv','rank'=>12)),
                            'gui_column_num_items'              => array('1'=>array('show'=>0,'label'=>'num_items','rank'=>13)),
                            'gui_column_revcpc'                 => array('1'=>array('show'=>1,'label'=>'revcpc','rank'=>14)),
                            'gui_column_costcpc'                => array('1'=>array('show'=>1,'label'=>'costcpc','rank'=>15)),
                            'gui_column_technology_cost'        => array('1'=>array('show'=>1,'label'=>'technology_cost','rank'=>16)),
                            'gui_column_income'                 => array('1'=>array('show'=>1,'label'=>'income','rank'=>17)),
                            'gui_column_income_margin'          => array('1'=>array('show'=>1,'label'=>'income_margin','rank'=>18)),
                            'gui_column_profit'                 => array('1'=>array('show'=>1,'label'=>'profit','rank'=>19)),
                            'gui_column_margin'                 => array('1'=>array('show'=>1,'label'=>'margin','rank'=>20)),
                            'gui_column_erpm'                   => array('1'=>array('show'=>1,'label'=>'erpm','rank'=>21)),
                            'gui_column_erpc'                   => array('1'=>array('show'=>1,'label'=>'erpc','rank'=>22)),
                            'gui_column_erps'                   => array('1'=>array('show'=>1,'label'=>'erps','rank'=>23)),
                            'gui_column_eipm'                   => array('1'=>array('show'=>1,'label'=>'eipm','rank'=>24)),
                            'gui_column_eipc'                   => array('1'=>array('show'=>1,'label'=>'eipc','rank'=>25)),
                            'gui_column_eips'                   => array('1'=>array('show'=>1,'label'=>'eips','rank'=>26)),
                            'gui_column_ecpm'                   => array('1'=>array('show'=>1,'label'=>'ecpm','rank'=>27)),
                            'gui_column_ecpc'                   => array('1'=>array('show'=>1,'label'=>'ecpc','rank'=>28)),
                            'gui_column_ecps'                   => array('1'=>array('show'=>1,'label'=>'ecps','rank'=>29)),
                            'gui_column_epps'                   => array('1'=>array('show'=>0,'label'=>'epps','rank'=>30)),
                            'maintenance_cron_timestamp' => 1198674011,
                            'warn_limit_days' => 1);

    function Migration_546Test()
    {
        // Ensure that the old preference table conf entry exist
        $GLOBALS['_MAX']['CONF']['table']['preference'] = 'preference';
        $aConf = &$GLOBALS['_MAX']['CONF']['table'];
        $this->oDbh = &OA_DB::singleton();
        $prefix = $this->getPrefix();

        $this->tblPrefsOld  = $this->oDbh->quoteIdentifier($prefix.$aConf['preference'], true);
        $this->tblAgency    = $this->oDbh->quoteIdentifier($prefix.$aConf['agency'], true);
        $this->tblAffilates = $this->oDbh->quoteIdentifier($prefix.$aConf['affiliates'], true);
        $this->tblChannel   = $this->oDbh->quoteIdentifier($prefix.$aConf['channel'], true);
        $this->tblClients   = $this->oDbh->quoteIdentifier($prefix.$aConf['clients'], true);
        $this->tblUsers     = $this->oDbh->quoteIdentifier($prefix.$aConf['users'], true);

        $this->tblAccounts  = $this->oDbh->quoteIdentifier($prefix.$aConf['accounts'], true);
        $this->tblPrefsNew  = $this->oDbh->quoteIdentifier($prefix.$aConf['preferences'],true);
        $this->tblAccPrefs  = $this->oDbh->quoteIdentifier($prefix.$aConf['account_preference_assoc'],true);
        $this->tblAppVars   = $this->oDbh->quoteIdentifier($prefix.$aConf['application_variable'],true);

        $this->_setupAccounts();
        $this->_setupPreferences();
        $this->_setupSettings();
    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    function _setupAccounts()
    {

        $this->initDatabase(542, array('agency', 'affiliates', 'application_variable', 'audit', 'channel', 'clients', 'preference', 'preference_advertiser', 'preference_publisher'));


        $this->oDbh->exec("INSERT INTO {$this->tblPrefsOld} (agencyid, admin_fullname, admin_email, admin, admin_pw) VALUES
            (0, 'Administrator', 'admin@example.com', 'admin', 'admin')");
        $this->oDbh->exec("INSERT INTO {$this->tblPrefsOld} (agencyid) VALUES (1)");

        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email) VALUES ('Agency 1', 'ag1@example.com')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password, language) VALUES ('Agency 2', 'ag2@example.com', 'agency2', 'agency2', 'portuguese')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password, language) VALUES ('Agency 3', 'ag3@example.com', 'agency3', 'agency3', 'russian_koi8r')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password, language) VALUES ('Agency 4', 'ag4@example.com', 'agency4', NULL, 'french')");
        $this->oDbh->exec("INSERT INTO {$this->tblAgency} (name, email, username, password) VALUES ('Agency 5', 'ag5@example.com', NULL, 'agency3')");

        $this->oDbh->exec("INSERT INTO {$this->tblAffilates} (name, email, language, agencyid) VALUES ('Publisher 1', 'pu1@example.com', 'korean', 1)");
        $this->oDbh->exec("INSERT INTO {$this->tblAffilates} (name, email, language, username, password) VALUES ('Publisher 2', 'pu2@example.com', 'german', 'publisher2', 'publisher2')");

        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 1', 0, 0)");
        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 2', 0, 2)");
        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 3', 1, 0)");
        $this->oDbh->exec("INSERT INTO {$this->tblChannel} (name, agencyid, affiliateid) VALUES ('Channel 4', 1, 1)");

        $this->oDbh->exec("INSERT INTO {$this->tblClients} (clientname, email, language, agencyid) VALUES ('Advertiser 1', 'ad1@example.com', 'chinese_big5', 1)");
        $this->oDbh->exec("INSERT INTO {$this->tblClients} (clientname, email, language, clientusername, clientpassword, agencyid) VALUES ('Advertiser 2', 'ad2@example.com', NULL, 'advertiser2', 'advertiser2', 3)");

    }

    function _setupPreferences()
    {
        // set up the admin preferences
        $query = "UPDATE {$this->tblPrefsOld} SET ";
        $n = count($this->aPrefsOld)-1;
        $i = 0;
        foreach ($this->aPrefsOld AS $k => $v)
        {
            if (is_array($v))
            {
                $v = serialize($v);
            }
            $query.= $k."=".$v = $this->oDbh->quote($v, null, true, false);
            if ($i < $n)
            {
                $query.= ",";
            }
            $i++;
        }
        $query.= " WHERE agencyid = 0";
        $this->oDbh->exec($query);

        // set up the agency preferences
        // agency 1 has identical admin prefs bar 2
        $query = "UPDATE {$this->tblPrefsOld} SET ";
        $n = count($this->aPrefsOld)-1;
        $i = 0;
        foreach ($this->aPrefsOld AS $k => $v)
        {
            if ($k == 'default_banner_url')
            {
                $v = 'http://www.custom_url.net';
            }
            if ($k == 'default_banner_destination')
            {
                $v = 'http://www.custom_dest.net';
            }
            if ($k == 'gui_column_id')
            {
                $v = serialize(array('1'=>array('show'=>1,'label'=>'ident','rank'=>2)));
            }
            $query.= $k."=".$v = $this->oDbh->quote($v, null, true, false);
            if ($i < $n)
            {
                $query.= ",";
            }
            $i++;
        }
        $query.= " WHERE agencyid = 1";
        $this->oDbh->exec($query);
    }

    function _setupSettings()
    {
        $aSettingsExpectations = $this->_getSettingsExpectations();
        foreach ($aSettingsExpectations AS $section => $aPair)
        {
            $name = key($aPair);
            unset($aConf[$section][$name]);
        }
    }

    function testUpgradeSchema()
    {
        $this->upgradeToVersion(543);
        $this->upgradeToVersion(544);
        $this->upgradeToVersion(546);
    }

    function testMigratePrefsToSettings()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aSettingsExpectations = $this->_getSettingsExpectations();
        foreach ($aSettingsExpectations AS $section => $aPair)
        {
            $name = key($aPair);
            $value = $aPair[$name];
            $this->assertTrue(isset($aConf[$section]),'section missing');
            $this->assertTrue(isset($aConf[$section][$name]),'key missing');
            $this->assertEqual($aConf[$section][$name],$value,'incorrect value');
        }
        TestEnv::restoreConfig();
    }

    function testMigratePrefsToAppVars()
    {
        $query = "SELECT *
                    FROM {$this->tblAppVars} AS av"
                 ;
        $aResults = $this->oDbh->queryAll($query, null, null, true);

        $aAppVarExpectations['maintenance_timestamp']      =  $this->aPrefsOld['maintenance_timestamp'];
        $aAppVarExpectations['maintenance_cron_timestamp'] =  $this->aPrefsOld['maintenance_cron_timestamp'];

        foreach ($aAppVarExpectations as $name => $value)
        {
            $this->assertTrue(array_key_exists($name,$aResults));
            if (array_key_exists($name,$aResults))
            {
                $this->assertEqual($value,$aAppVarExpectations[$name],'wrong value for '.$name);
            }
        }
    }

    function testMigratePrefsToPrefs()
    {
        // Test 1 : Admin Prefs
        $query = "SELECT p.preference_name AS name, ap.value, p.account_type AS type
                    FROM {$this->tblAccPrefs} AS ap
                    LEFT JOIN {$this->tblPrefsNew} AS p ON p.preference_id = ap.preference_id
                    LEFT JOIN {$this->tblAccounts} AS a ON a.account_id = ap.account_id
                    WHERE a.account_type = 'ADMIN'"
                 ;
        $aResults       = $this->oDbh->queryAll($query, null, null, true);
        $aExpectations  =  $this->_getPrefsExpectations();
        $this->assertEqual(count($aResults),count($aExpectations));
        foreach ($aResults as $nameNew => $aVals)
        {
            $this->assertTrue(array_key_exists($nameNew,$aExpectations));
            if (array_key_exists($nameNew,$aExpectations))
            {
                $this->assertEqual($aVals['value'],$aExpectations[$nameNew]['value'],'wrong value for '.$nameNew);
                $this->assertEqual($aVals['type'],$aExpectations[$nameNew]['level'],'wrong level for '.$nameNew);
            }
        }
        // Test 2 : Agency Prefs
        $query = "SELECT p.preference_name AS name, ap.value, p.account_type AS type
                    FROM {$this->tblAccPrefs} AS ap
                    LEFT JOIN {$this->tblPrefsNew} AS p ON p.preference_id = ap.preference_id
                    LEFT JOIN {$this->tblAccounts} AS a ON a.account_id = ap.account_id
                    LEFT JOIN {$this->tblAgency} AS ag ON ag.account_id = a.account_id
                    WHERE ag.agencyid = 1"
                 ;
        $aResults = $this->oDbh->queryAll($query, null, null, true);

        $aAgencyExpectations['default_banner_image_url'] =  array('value'=> 'http://www.custom_url.net');
        $aAgencyExpectations['default_banner_destination_url'] =  array('value'=> 'http://www.custom_dest.net');
        $this->assertEqual(count($aResults),count($aAgencyExpectations));
        foreach ($aResults as $nameNew => $aVals)
        {
            $this->assertTrue(array_key_exists($nameNew,$aAgencyExpectations));
            if (array_key_exists($nameNew,$aAgencyExpectations))
            {
                $this->assertEqual($aVals['value'],$aAgencyExpectations[$nameNew]['value'],'wrong value for '.$nameNew);
                $this->assertEqual($aVals['type'],$aExpectations[$nameNew]['level'],'wrong level for '.$nameNew);
            }
        }

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
            'language' => 'en',
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
            'language' => 'pt_BR',
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
            'language' => 'ru',
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
            'language' => 'de',
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
            'agencyid' => '3',
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
            'language' => 'ru',
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

   function _getSettingsExpectations()
   {
        $oMig = new Migration_546();
        foreach ($oMig->aConfMap AS $section => $aPair)
        {
            $name = key($aPair);
            $value = $this->aPrefsOld[$aPair[$name]];
            $aResult[$section][$name] = $value;
        }
        return $aResult;
   }

   function _getPrefsExpectations()
   {
    return array(
                'company_name' => array('value'=>$this->aPrefsOld['company_name'],'level'=>OA_ACCOUNT_MANAGER),
                'ui_week_start_day'=> array('value'=>$this->aPrefsOld['begin_of_week'], 'level'=>''),
                'ui_percentage_decimals'=> array('value'=>$this->aPrefsOld['percentage_decimals'], 'level'=>''),
                'warn_admin'=> array('value'=>$this->aPrefsOld['warn_admin'], 'level'=>OA_ACCOUNT_ADMIN),
                'warn_email_manager'=> array('value'=>$this->aPrefsOld['warn_agency'], 'level'=>OA_ACCOUNT_MANAGER),
                'warn_email_advertiser'=> array('value'=>$this->aPrefsOld['warn_client'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'warn_email_admin_impression_limit'=> array('value'=>$this->aPrefsOld['warn_limit'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_novice_user'=> array('value'=>$this->aPrefsOld['admin_novice'], 'level'=>''),
                'default_banner_weight'=> array('value'=>$this->aPrefsOld['default_banner_weight'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'default_campaign_weight'=> array('value'=>$this->aPrefsOld['default_campaign_weight'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'default_banner_image_url'=> array('value'=>$this->aPrefsOld['default_banner_url'], 'level'=>OA_ACCOUNT_TRAFFICKER),
                'default_banner_destination_url'=> array('value'=>$this->aPrefsOld['default_banner_destination'], 'level'=>OA_ACCOUNT_TRAFFICKER),
                'ui_show_campaign_info'=> array('value'=>$this->aPrefsOld['gui_show_campaign_info'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'ui_show_campaign_preview'=> array('value'=>$this->aPrefsOld['gui_show_campaign_preview'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'ui_show_banner_info'=> array('value'=>$this->aPrefsOld['gui_show_banner_info'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'ui_show_banner_preview'=> array('value'=>$this->aPrefsOld['gui_show_banner_preview'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'ui_show_banner_html'=> array('value'=>$this->aPrefsOld['gui_show_banner_html'], 'level'=>OA_ACCOUNT_ADVERTISER),
                'ui_show_matching_banners'=> array('value'=>$this->aPrefsOld['gui_show_matching'], 'level'=>OA_ACCOUNT_TRAFFICKER),
                'ui_show_matching_banners_parents'=> array('value'=>$this->aPrefsOld['gui_show_parents'], 'level'=>OA_ACCOUNT_TRAFFICKER),
                'ui_hide_inactive'=> array('value'=>$this->aPrefsOld['gui_hide_inactive'], 'level'=>''),
                'tracker_default_status'=> array('value'=>$this->aPrefsOld['default_tracker_status'], 'level'=>''),
                'tracker_default_type'=> array('value'=>$this->aPrefsOld['default_tracker_type'], 'level'=>''),
                'tracker_link_campaigns'=> array('value'=>$this->aPrefsOld['default_tracker_linkcampaigns'], 'level'=>''),
                'ui_column_id' => array('value'=>$this->aPrefsOld['gui_column_id']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_requests' => array('value'=>$this->aPrefsOld['gui_column_requests']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_impressions' => array('value'=>$this->aPrefsOld['gui_column_impressions']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_clicks' => array('value'=>$this->aPrefsOld['gui_column_clicks']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ctr' => array('value'=>$this->aPrefsOld['gui_column_ctr']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_conversions' => array('value'=>$this->aPrefsOld['gui_column_conversions']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_conversions_pending' => array('value'=>$this->aPrefsOld['gui_column_conversions_pending']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_sr_views' => array('value'=>$this->aPrefsOld['gui_column_sr_views']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_sr_clicks' => array('value'=>$this->aPrefsOld['gui_column_sr_clicks']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_revenue' => array('value'=>$this->aPrefsOld['gui_column_revenue']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_cost' => array('value'=>$this->aPrefsOld['gui_column_cost']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_bv' => array('value'=>$this->aPrefsOld['gui_column_bv']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_num_items' => array('value'=>$this->aPrefsOld['gui_column_num_items']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_revcpc' => array('value'=>$this->aPrefsOld['gui_column_revcpc']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_costcpc' => array('value'=>$this->aPrefsOld['gui_column_costcpc']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_technology_cost' => array('value'=>$this->aPrefsOld['gui_column_technology_cost']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_income' => array('value'=>$this->aPrefsOld['gui_column_income']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_income_margin' => array('value'=>$this->aPrefsOld['gui_column_income_margin']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_profit' => array('value'=>$this->aPrefsOld['gui_column_profit']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_margin' => array('value'=>$this->aPrefsOld['gui_column_margin']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erpm' => array('value'=>$this->aPrefsOld['gui_column_erpm']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erpc' => array('value'=>$this->aPrefsOld['gui_column_erpc']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erps' => array('value'=>$this->aPrefsOld['gui_column_erps']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eipm' => array('value'=>$this->aPrefsOld['gui_column_eipm']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eipc' => array('value'=>$this->aPrefsOld['gui_column_eipc']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eips' => array('value'=>$this->aPrefsOld['gui_column_eips']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecpm' => array('value'=>$this->aPrefsOld['gui_column_ecpm']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecpc' => array('value'=>$this->aPrefsOld['gui_column_ecpc']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecps' => array('value'=>$this->aPrefsOld['gui_column_ecps']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_epps' => array('value'=>$this->aPrefsOld['gui_column_epps']['1']['show'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_id_label' => array('value'=>$this->aPrefsOld['gui_column_id']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_requests_label' => array('value'=>$this->aPrefsOld['gui_column_requests']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_impressions_label' => array('value'=>$this->aPrefsOld['gui_column_impressions']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_clicks_label' => array('value'=>$this->aPrefsOld['gui_column_clicks']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ctr_label' => array('value'=>$this->aPrefsOld['gui_column_ctr']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_conversions_label' => array('value'=>$this->aPrefsOld['gui_column_conversions']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_conversions_pending_label' => array('value'=>$this->aPrefsOld['gui_column_conversions_pending']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_sr_views_label' => array('value'=>$this->aPrefsOld['gui_column_sr_views']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_sr_clicks_label' => array('value'=>$this->aPrefsOld['gui_column_sr_clicks']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_revenue_label' => array('value'=>$this->aPrefsOld['gui_column_revenue']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_cost_label' => array('value'=>$this->aPrefsOld['gui_column_cost']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_bv_label' => array('value'=>$this->aPrefsOld['gui_column_bv']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_num_items_label' => array('value'=>$this->aPrefsOld['gui_column_num_items']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_revcpc_label' => array('value'=>$this->aPrefsOld['gui_column_revcpc']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_costcpc_label' => array('value'=>$this->aPrefsOld['gui_column_costcpc']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_technology_cost_label' => array('value'=>$this->aPrefsOld['gui_column_technology_cost']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_income_label' => array('value'=>$this->aPrefsOld['gui_column_income']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_income_margin_label' => array('value'=>$this->aPrefsOld['gui_column_income_margin']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_profit_label' => array('value'=>$this->aPrefsOld['gui_column_profit']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_margin_label' => array('value'=>$this->aPrefsOld['gui_column_margin']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erpm_label' => array('value'=>$this->aPrefsOld['gui_column_erpm']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erpc_label' => array('value'=>$this->aPrefsOld['gui_column_erpc']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erps_label' => array('value'=>$this->aPrefsOld['gui_column_erps']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eipm_label' => array('value'=>$this->aPrefsOld['gui_column_eipm']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eipc_label' => array('value'=>$this->aPrefsOld['gui_column_eipc']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eips_label' => array('value'=>$this->aPrefsOld['gui_column_eips']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecpm_label' => array('value'=>$this->aPrefsOld['gui_column_ecpm']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecpc_label' => array('value'=>$this->aPrefsOld['gui_column_ecpc']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecps_label' => array('value'=>$this->aPrefsOld['gui_column_ecps']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_epps_label' => array('value'=>$this->aPrefsOld['gui_column_epps']['1']['label'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_id_rank' => array('value'=>$this->aPrefsOld['gui_column_id']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_requests_rank' => array('value'=>$this->aPrefsOld['gui_column_requests']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_impressions_rank' => array('value'=>$this->aPrefsOld['gui_column_impressions']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_clicks_rank' => array('value'=>$this->aPrefsOld['gui_column_clicks']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ctr_rank' => array('value'=>$this->aPrefsOld['gui_column_ctr']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_conversions_rank' => array('value'=>$this->aPrefsOld['gui_column_conversions']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_conversions_pending_rank' => array('value'=>$this->aPrefsOld['gui_column_conversions_pending']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_sr_views_rank' => array('value'=>$this->aPrefsOld['gui_column_sr_views']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_sr_clicks_rank' => array('value'=>$this->aPrefsOld['gui_column_sr_clicks']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_revenue_rank' => array('value'=>$this->aPrefsOld['gui_column_revenue']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_cost_rank' => array('value'=>$this->aPrefsOld['gui_column_cost']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_bv_rank' => array('value'=>$this->aPrefsOld['gui_column_bv']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_num_items_rank' => array('value'=>$this->aPrefsOld['gui_column_num_items']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_revcpc_rank' => array('value'=>$this->aPrefsOld['gui_column_revcpc']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_costcpc_rank' => array('value'=>$this->aPrefsOld['gui_column_costcpc']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_technology_cost_rank' => array('value'=>$this->aPrefsOld['gui_column_technology_cost']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_income_rank' => array('value'=>$this->aPrefsOld['gui_column_income']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_income_margin_rank' => array('value'=>$this->aPrefsOld['gui_column_income_margin']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_profit_rank' => array('value'=>$this->aPrefsOld['gui_column_profit']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_margin_rank' => array('value'=>$this->aPrefsOld['gui_column_margin']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erpm_rank' => array('value'=>$this->aPrefsOld['gui_column_erpm']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erpc_rank' => array('value'=>$this->aPrefsOld['gui_column_erpc']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_erps_rank' => array('value'=>$this->aPrefsOld['gui_column_erps']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eipm_rank' => array('value'=>$this->aPrefsOld['gui_column_eipm']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eipc_rank' => array('value'=>$this->aPrefsOld['gui_column_eipc']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_eips_rank' => array('value'=>$this->aPrefsOld['gui_column_eips']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecpm_rank' => array('value'=>$this->aPrefsOld['gui_column_ecpm']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecpc_rank' => array('value'=>$this->aPrefsOld['gui_column_ecpc']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_ecps_rank' => array('value'=>$this->aPrefsOld['gui_column_ecps']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'ui_column_epps_rank' => array('value'=>$this->aPrefsOld['gui_column_epps']['1']['rank'], 'level'=>OA_ACCOUNT_MANAGER),
                'warn_email_admin_day_limit' => array('value'=>$this->aPrefsOld['warn_limit_days'], 'level'=>OA_ACCOUNT_MANAGER),
                );
   }
}
