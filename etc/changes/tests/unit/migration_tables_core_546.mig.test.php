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

require_once MAX_PATH . '/etc/changes/migration_tables_core_546.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once(MAX_PATH. '/lib/OA/Upgrade/Configuration.php');

/**
 * Test for migration class #546 that check that the old preferences
 * stored on the table 'preference' are migrated to the table 'preferences'
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Miguel Correa <miguel.correa@openx.org>
 */
class Migration_546Test extends MigrationTest
{
    /**
     *  Test for migration class
     *
     */
    function testMigrateStatus()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(544, array('preference', 'preferences', 'account_preference_assoc', 'preference_advertiser', 'preference_publisher', 'agency', 'application_variable', 'accounts'));

        $tblPreference = $this->oDbh->quoteIdentifier($prefix.'preference', true);
        $tblAgency = $this->oDbh->quoteIdentifier($prefix.'agency', true);
        $tblApplicationVariable = $this->oDbh->quoteIdentifier($prefix.'application_variable', true);
        $tblAccounts = $this->oDbh->quoteIdentifier($prefix.'accounts', true);

        $aExistingTablesInicio = $this->oDbh->manager->listTables();

        $this->oDbh->exec("INSERT INTO {$tblPreference} (agencyid, config_version, my_header, my_footer, my_logo, language, name, company_name,
                                                          override_gd_imageformat, begin_of_week, percentage_decimals, type_sql_allow, type_url_allow,
                                                          type_web_allow, type_html_allow, type_txt_allow, banner_html_auto, admin, admin_pw, admin_fullname,
                                                          admin_email, warn_admin, warn_agency, warn_client, warn_limit, admin_email_headers, admin_novice,
                                                          default_banner_weight, default_campaign_weight, default_banner_url, default_banner_destination,
                                                          client_welcome, client_welcome_msg, publisher_welcome, publisher_welcome_msg, content_gzip_compression,
                                                          userlog_email, gui_show_campaign_info, gui_show_campaign_preview, gui_campaign_anonymous, gui_show_banner_info,
                                                          gui_show_banner_preview, gui_show_banner_html, gui_show_matching, gui_show_parents, gui_hide_inactive,
                                                          gui_link_compact_limit, gui_header_background_color, gui_header_foreground_color, gui_header_active_tab_color,
                                                          gui_header_text_color, gui_invocation_3rdparty_default, qmail_patch, updates_enabled, updates_cache,
                                                          updates_timestamp, updates_last_seen, allow_invocation_plain, allow_invocation_plain_nocookies, allow_invocation_js,
                                                          allow_invocation_frame, allow_invocation_xmlrpc, allow_invocation_local, allow_invocation_interstitial,
                                                          allow_invocation_popup, allow_invocation_clickonly, auto_clean_tables, auto_clean_tables_interval, auto_clean_userlog,
                                                          auto_clean_userlog_interval, auto_clean_tables_vacuum, autotarget_factor, maintenance_timestamp, compact_stats,
                                                          statslastday, statslasthour, default_tracker_status, default_tracker_type, default_tracker_linkcampaigns,
                                                          publisher_agreement, publisher_agreement_text, publisher_payment_modes, publisher_currencies, publisher_categories,
                                                          publisher_help_files, publisher_default_tax_id, publisher_default_approved, more_reports, gui_column_id, gui_column_requests,
                                                          gui_column_impressions, gui_column_clicks, gui_column_ctr, gui_column_conversions, gui_column_conversions_pending,
                                                          gui_column_sr_views, gui_column_sr_clicks, gui_column_revenue, gui_column_cost, gui_column_bv, gui_column_num_items,
                                                          gui_column_revcpc, gui_column_costcpc, gui_column_technology_cost, gui_column_income, gui_column_income_margin,
                                                          gui_column_profit, gui_column_margin, gui_column_erpm, gui_column_erpc, gui_column_erps, gui_column_eipm,
                                                          gui_column_eipc, gui_column_eips, gui_column_ecpm, gui_column_ecpc, gui_column_ecps, gui_column_epps,
                                                          maintenance_cron_timestamp, warn_limit_days) VALUES (0, 0.000, NULL, NULL, NULL, 'english', NULL, 'mysite.com', NULL, 1, 2, 't', 't', 'f', 't', 't', 't', 'admin', 'bdcf5fc18e4f01990300ed0d0a306428', 'Your Name', 'miguel.correa@openx.org', 't', 't', 't', 100, NULL, 't', 1, 1, NULL, NULL, 't', NULL, 't', NULL, 'f', 't', 't', 'f', 'f', 't', 't', 'f', 't', 'f', 'f', 50, NULL, NULL, NULL, NULL, '', 'f', 't', NULL, 0, NULL, 'f', 't', 't', 'f', 'f', 't', 't', 't', 't', 'f', 5, 'f', 5, 't', -1, 0, 't', '2008-05-02', 0, 1, 1, 'f', 'f', NULL, NULL, NULL, NULL, NULL, 'f', 'f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1)");

        $this->oDbh->exec("INSERT INTO {$tblAgency} (agencyid, name, contact, email, logout_url, active, updated, account_id) VALUES (1, 'Default manager', NULL, '', NULL, 1, '2008-05-16 11:01:56', 2)");
        $this->oDbh->exec("INSERT INTO {$tblApplicationVariable} (name, value) VALUES ('tables_core', '544')");
        $this->oDbh->exec("INSERT INTO {$tblApplicationVariable} (name, value) VALUES ('oa_version', '2.5.46-dev')");
        $this->oDbh->exec("INSERT INTO {$tblApplicationVariable} (name, value) VALUES ('platform_hash', '70fb56249cb15a78d4ed6aa81d068e74e07b8cc3')");
        $this->oDbh->exec("INSERT INTO {$tblApplicationVariable} (name, value) VALUES ('sync_last_run', '2008-05-16 11:01:45')");
        $this->oDbh->exec("INSERT INTO {$tblApplicationVariable} (name, value) VALUES ('sync_cache', 'b:0;')");
        $this->oDbh->exec("INSERT INTO {$tblApplicationVariable} (name, value) VALUES ('sync_timestamp', '1210932105')");
        $this->oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (1, 'ADMIN', 'Administrator account')");
        $this->oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (2, 'MANAGER', 'Default manager')");
        $this->oDbh->exec("INSERT INTO {$tblAccounts} (account_id, account_type, account_name) VALUES (3, 'TRAFFICKER', 'localhost')");

        $migration = new Migration_546();
        $migration->init($this->oDbh, MAX_PATH.'/var/DB_Upgrade.test.log');
        $migration->migratePreferences();

        $tblPreferences = $this->oDbh->quoteIdentifier($prefix.'preferences', true);
        $aResults = $this->oDbh->queryAll("SELECT * FROM ".$tblPreferences);

        $aExpected = array(array (
                              'preference_id' => '1',
                              'preference_name' => 'auto_alter_html_banners_for_click_tracking',
                              'account_type' => 'ADVERTISER'
                          ),
                          array (
                              'preference_id' => '2',
                              'preference_name' => 'ui_week_start_day',
                              'account_type' => ''
                          ),
                          array (
                              'preference_id' => '3',
                              'preference_name' => 'ui_percentage_decimals',
                              'account_type' => ''
                          ),
                          array (
                              'preference_id' => '4',
                              'preference_name' => 'warn_email_admin',
                              'account_type' => 'ADMIN'
                          ),
                          array (
                              'preference_id' => '5',
                              'preference_name' => 'warn_email_admin_impression_limit',
                              'account_type' => 'ADMIN'
                          ),
                          array (
                              'preference_id' => '6',
                              'preference_name' => 'warn_email_admin_day_limit',
                              'account_type' => 'ADMIN'
                          ),
                          array (
                              'preference_id' => '7',
                              'preference_name' => 'warn_email_manager',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '8',
                              'preference_name' => 'warn_email_manager_impression_limit',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '9',
                              'preference_name' => 'warn_email_manager_day_limit',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '10',
                              'preference_name' => 'warn_email_advertiser',
                              'account_type' => 'ADVERTISER'
                          ),
                          array (
                              'preference_id' => '11',
                              'preference_name' => 'warn_email_advertiser_impression_limit',
                              'account_type' => 'ADVERTISER'
                          ),
                          array (
                              'preference_id' => '12',
                              'preference_name' => 'warn_email_advertiser_day_limit',
                              'account_type' => 'ADVERTISER'
                          ),
                          array (
                              'preference_id' => '13',
                              'preference_name' => 'ui_novice_user',
                              'account_type' => ''
                          ),
                          array (
                              'preference_id' => '14',
                              'preference_name' => 'default_banner_weight',
                              'account_type' => 'ADVERTISER'
                          ),
                          array (
                              'preference_id' => '15',
                              'preference_name' => 'default_campaign_weight',
                              'account_type' => 'ADVERTISER'
                          ),
                          array (
                              'preference_id' => '16',
                              'preference_name' => 'default_banner_image_url',
                              'account_type' => 'TRAFFICKER'
                          ),
                          array (
                              'preference_id' => '17',
                              'preference_name' => 'default_banner_destination_url',
                              'account_type' => 'TRAFFICKER'
                           ),
                           array ('preference_id' => '18',
                                 'preference_name' => 'ui_show_campaign_info',
                                 'account_type' => 'ADVERTISER'
                                 ),
                           array('preference_id' => '19',
                                 'preference_name' => 'ui_show_campaign_preview',
                                 'account_type' => 'ADVERTISER'
                                 ),
                           array('preference_id' => '20',
                                 'preference_name' => 'ui_show_banner_info',
                                 'account_type' => 'ADVERTISER'
                                 ),
                           array ('preference_id' => '21',
                                 'preference_name' => 'ui_show_banner_preview',
                                 'account_type' => 'ADVERTISER'
                                 ),
                           array (
                                  'preference_id' => '22',
                                  'preference_name' => 'ui_show_banner_html',
                                  'account_type' => 'ADVERTISER'
                           ),
                           array (
                               'preference_id' => '23',
                               'preference_name' => 'ui_show_matching_banners',
                               'account_type' => 'TRAFFICKER'
                           ),
                           array (
                               'preference_id' => '24',
                               'preference_name' => 'ui_show_matching_banners_parents',
                               'account_type' => 'TRAFFICKER'
                           ),
                           array (
                               'preference_id' => '25',
                               'preference_name' => 'ui_hide_inactive',
                               'account_type' => ''
                           ),
                           array (
                               'preference_id' => '26',
                               'preference_name' => 'tracker_default_status',
                               'account_type' => 'ADVERTISER'
                           ),
                           array (
                               'preference_id' => '27',
                               'preference_name' => 'tracker_default_type',
                               'account_type' => 'ADVERTISER'
                           ),
                           array (
                               'preference_id' => '28',
                               'preference_name' => 'tracker_link_campaigns',
                               'account_type' => 'ADVERTISER'
                           ),
                           array (
                               'preference_id' => '29',
                               'preference_name' => 'ui_column_id',
                               'account_type' => 'MANAGER'
                           ),
                           array (
                               'preference_id' => '30',
                               'preference_name' => 'ui_column_id_label',
                               'account_type' => 'MANAGER'
                           ),
                           array (
                               'preference_id' => '31',
                               'preference_name' => 'ui_column_id_rank',
                               'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '32',
                              'preference_name' => 'ui_column_requests',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '33',
                              'preference_name' => 'ui_column_requests_label',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '34',
                              'preference_name' => 'ui_column_requests_rank',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '35',
                              'preference_name' => 'ui_column_impressions',
                              'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '36',
                             'preference_name' => 'ui_column_impressions_label',
                             'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '37',
                             'preference_name' => 'ui_column_impressions_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '38',
                             'preference_name' => 'ui_column_clicks',
                             'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '39',
                             'preference_name' => 'ui_column_clicks_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '40',
                             'preference_name' => 'ui_column_clicks_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '41',
                             'preference_name' => 'ui_column_ctr',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '42',
                             'preference_name' => 'ui_column_ctr_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '43',
                             'preference_name' => 'ui_column_ctr_rank',
                             'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '44',
                             'preference_name' => 'ui_column_conversions',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '45',
                             'preference_name' => 'ui_column_conversions_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '46',
                             'preference_name' => 'ui_column_conversions_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '47',
                             'preference_name' => 'ui_column_conversions_pending',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '48',
                             'preference_name' => 'ui_column_conversions_pending_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '49',
                             'preference_name' => 'ui_column_conversions_pending_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '50',
                             'preference_name' => 'ui_column_sr_views',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '51',
                             'preference_name' => 'ui_column_sr_views_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '52',
                             'preference_name' => 'ui_column_sr_views_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '53',
                             'preference_name' => 'ui_column_sr_clicks',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '54',
                             'preference_name' => 'ui_column_sr_clicks_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '55',
                             'preference_name' => 'ui_column_sr_clicks_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '56',
                             'preference_name' => 'ui_column_revenue',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '57',
                             'preference_name' => 'ui_column_revenue_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '58',
                             'preference_name' => 'ui_column_revenue_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '59',
                             'preference_name' => 'ui_column_cost',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '60',
                             'preference_name' => 'ui_column_cost_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '61',
                             'preference_name' => 'ui_column_cost_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '62',
                             'preference_name' => 'ui_column_bv',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '63',
                             'preference_name' => 'ui_column_bv_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '64',
                             'preference_name' => 'ui_column_bv_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '65',
                             'preference_name' => 'ui_column_num_items',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '66',
                             'preference_name' => 'ui_column_num_items_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '67',
                             'preference_name' => 'ui_column_num_items_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '68',
                             'preference_name' => 'ui_column_revcpc',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '69',
                             'preference_name' => 'ui_column_revcpc_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '70',
                             'preference_name' => 'ui_column_revcpc_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '71',
                             'preference_name' => 'ui_column_costcpc',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '72',
                             'preference_name' => 'ui_column_costcpc_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '73',
                             'preference_name' => 'ui_column_costcpc_rank',
                             'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '74',
                             'preference_name' => 'ui_column_technology_cost',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '75',
                             'preference_name' => 'ui_column_technology_cost_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '76',
                             'preference_name' => 'ui_column_technology_cost_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '77',
                             'preference_name' => 'ui_column_income',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '78',
                             'preference_name' => 'ui_column_income_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '79',
                             'preference_name' => 'ui_column_income_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '80',
                             'preference_name' => 'ui_column_income_margin',
                             'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '81',
                             'preference_name' => 'ui_column_income_margin_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '82',
                             'preference_name' => 'ui_column_income_margin_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '83',
                             'preference_name' => 'ui_column_profit',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '84',
                             'preference_name' => 'ui_column_profit_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '85',
                             'preference_name' => 'ui_column_profit_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '86',
                             'preference_name' => 'ui_column_margin',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '87',
                             'preference_name' => 'ui_column_margin_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '88',
                             'preference_name' => 'ui_column_margin_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '89',
                             'preference_name' => 'ui_column_erpm',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '90',
                             'preference_name' => 'ui_column_erpm_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '91',
                             'preference_name' => 'ui_column_erpm_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '92',
                             'preference_name' => 'ui_column_erpc',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '93',
                             'preference_name' => 'ui_column_erpc_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '94',
                             'preference_name' => 'ui_column_erpc_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '95',
                             'preference_name' => 'ui_column_erps',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '96',
                             'preference_name' => 'ui_column_erps_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '97',
                             'preference_name' => 'ui_column_erps_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '98',
                             'preference_name' => 'ui_column_eipm',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '99',
                             'preference_name' => 'ui_column_eipm_label',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '100',
                             'preference_name' => 'ui_column_eipm_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '101',
                             'preference_name' => 'ui_column_eipc',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                              'preference_id' => '102',
                              'preference_name' => 'ui_column_eipc_label',
                              'account_type' => 'MANAGER'
                         ),
                         array (
                              'preference_id' => '103',
                              'preference_name' => 'ui_column_eipc_rank',
                              'account_type' => 'MANAGER'
                         ),
                         array (
                              'preference_id' => '104',
                              'preference_name' => 'ui_column_eips',
                              'account_type' => 'MANAGER'
                         ),
                         array (
                              'preference_id' => '105',
                              'preference_name' => 'ui_column_eips_label',
                              'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '106',
                             'preference_name' => 'ui_column_eips_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '107',
                             'preference_name' => 'ui_column_ecpm',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '108',
                             'preference_name' => 'ui_column_ecpm_label',
                             'account_type' => 'MANAGER',
                         ),
                         array (
                             'preference_id' => '109',
                             'preference_name' => 'ui_column_ecpm_rank',
                             'account_type' => 'MANAGER'
                         ),
                         array (
                             'preference_id' => '110',
                             'preference_name' => 'ui_column_ecpc',
                             'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '111',
                              'preference_name' => 'ui_column_ecpc_label',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '112',
                              'preference_name' => 'ui_column_ecpc_rank',
                              'account_type' => 'MANAGER',
                          ),
                          array (
                              'preference_id' => '113',
                              'preference_name' => 'ui_column_ecps',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '114',
                              'preference_name' => 'ui_column_ecps_label',
                              'account_type' => 'MANAGER'
                          ),
                          array (
                              'preference_id' => '115',
                              'preference_name' => 'ui_column_ecps_rank',
                              'account_type' => 'MANAGER'
                          )
                      );

        $this->assertEqual($aResults, $aExpected);

    }

}
