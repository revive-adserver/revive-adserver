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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once(MAX_PATH . '/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH . '/lib/OA/DB/Sql.php');

define('GEOCONFIG_PATH', MAX_PATH . '/var/plugins/config/geotargeting');


class Migration_108 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddTable__application_variable';
        $this->aTaskList_constructive[] = 'afterAddTable__application_variable';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_intermediate_ad';
        $this->aTaskList_constructive[] = 'afterAddTable__data_intermediate_ad';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_intermediate_ad_connection';
        $this->aTaskList_constructive[] = 'afterAddTable__data_intermediate_ad_connection';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_intermediate_ad_variable_value';
        $this->aTaskList_constructive[] = 'afterAddTable__data_intermediate_ad_variable_value';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_raw_ad_click';
        $this->aTaskList_constructive[] = 'afterAddTable__data_raw_ad_click';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_raw_ad_impression';
        $this->aTaskList_constructive[] = 'afterAddTable__data_raw_ad_impression';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_raw_ad_request';
        $this->aTaskList_constructive[] = 'afterAddTable__data_raw_ad_request';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_raw_tracker_click';
        $this->aTaskList_constructive[] = 'afterAddTable__data_raw_tracker_click';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_raw_tracker_impression';
        $this->aTaskList_constructive[] = 'afterAddTable__data_raw_tracker_impression';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_raw_tracker_variable_value';
        $this->aTaskList_constructive[] = 'afterAddTable__data_raw_tracker_variable_value';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_ad_hourly';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_ad_hourly';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_ad_zone_assoc';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_ad_zone_assoc';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_channel_daily';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_channel_daily';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_country_daily';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_country_daily';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_country_forecast';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_country_forecast';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_country_monthly';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_country_monthly';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_domain_page_daily';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_domain_page_daily';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_domain_page_forecast';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_domain_page_forecast';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_domain_page_monthly';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_domain_page_monthly';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_impression_history';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_impression_history';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_site_keyword_daily';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_site_keyword_daily';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_site_keyword_forecast';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_site_keyword_forecast';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_site_keyword_monthly';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_site_keyword_monthly';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_source_daily';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_source_daily';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_source_forecast';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_source_forecast';
        $this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_source_monthly';
        $this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_source_monthly';
        $this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_forecasting';
        $this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_forecasting';
        $this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_priority';
        $this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_priority';
        $this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_statistics';
        $this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_statistics';
        $this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_assoc';
        $this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_assoc';
        $this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_domains';
        $this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_domains';
        $this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_rules';
        $this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_rules';
        $this->aTaskList_constructive[] = 'beforeAddTable__agency';
        $this->aTaskList_constructive[] = 'afterAddTable__agency';
        $this->aTaskList_constructive[] = 'beforeAddTable__campaigns';
        $this->aTaskList_constructive[] = 'afterAddTable__campaigns';
        $this->aTaskList_constructive[] = 'beforeAddTable__acls_channel';
        $this->aTaskList_constructive[] = 'afterAddTable__acls_channel';
        $this->aTaskList_constructive[] = 'beforeAddTable__channel';
        $this->aTaskList_constructive[] = 'afterAddTable__channel';
        $this->aTaskList_constructive[] = 'beforeAddTable__ad_category_assoc';
        $this->aTaskList_constructive[] = 'afterAddTable__ad_category_assoc';
        $this->aTaskList_constructive[] = 'beforeAddTable__category';
        $this->aTaskList_constructive[] = 'afterAddTable__category';
        $this->aTaskList_constructive[] = 'beforeAddTable__ad_zone_assoc';
        $this->aTaskList_constructive[] = 'afterAddTable__ad_zone_assoc';
        $this->aTaskList_constructive[] = 'beforeAddTable__placement_zone_assoc';
        $this->aTaskList_constructive[] = 'afterAddTable__placement_zone_assoc';
        $this->aTaskList_constructive[] = 'beforeAddTable__campaigns_trackers';
        $this->aTaskList_constructive[] = 'afterAddTable__campaigns_trackers';
        $this->aTaskList_constructive[] = 'beforeAddTable__tracker_append';
        $this->aTaskList_constructive[] = 'afterAddTable__tracker_append';
        $this->aTaskList_constructive[] = 'beforeAddTable__trackers';
        $this->aTaskList_constructive[] = 'afterAddTable__trackers';
        $this->aTaskList_constructive[] = 'beforeAddTable__variable_publisher';
        $this->aTaskList_constructive[] = 'afterAddTable__variable_publisher';
        $this->aTaskList_constructive[] = 'beforeAddTable__variables';
        $this->aTaskList_constructive[] = 'afterAddTable__variables';
        $this->aTaskList_constructive[] = 'beforeAddTable__preference';
        $this->aTaskList_constructive[] = 'afterAddTable__preference';
        $this->aTaskList_constructive[] = 'beforeAddTable__preference_advertiser';
        $this->aTaskList_constructive[] = 'afterAddTable__preference_advertiser';
        $this->aTaskList_constructive[] = 'beforeAddTable__preference_publisher';
        $this->aTaskList_constructive[] = 'afterAddTable__preference_publisher';
        $this->aTaskList_constructive[] = 'beforeAddTable__affiliates_extra';
        $this->aTaskList_constructive[] = 'afterAddTable__affiliates_extra';
        $this->aTaskList_constructive[] = 'beforeAddTable__password_recovery';
        $this->aTaskList_constructive[] = 'afterAddTable__password_recovery';
    }



    public function beforeAddTable__application_variable()
    {
        return $this->beforeAddTable('application_variable');
    }

    public function afterAddTable__application_variable()
    {
        return $this->afterAddTable('application_variable');
    }

    public function beforeAddTable__data_intermediate_ad()
    {
        return $this->beforeAddTable('data_intermediate_ad');
    }

    public function afterAddTable__data_intermediate_ad()
    {
        return $this->afterAddTable('data_intermediate_ad');
    }

    public function beforeAddTable__data_intermediate_ad_connection()
    {
        return $this->beforeAddTable('data_intermediate_ad_connection');
    }

    public function afterAddTable__data_intermediate_ad_connection()
    {
        return $this->afterAddTable('data_intermediate_ad_connection');
    }

    public function beforeAddTable__data_intermediate_ad_variable_value()
    {
        return $this->beforeAddTable('data_intermediate_ad_variable_value');
    }

    public function afterAddTable__data_intermediate_ad_variable_value()
    {
        return $this->afterAddTable('data_intermediate_ad_variable_value');
    }

    public function beforeAddTable__data_raw_ad_click()
    {
        return $this->beforeAddTable('data_raw_ad_click');
    }

    public function afterAddTable__data_raw_ad_click()
    {
        return $this->afterAddTable('data_raw_ad_click');
    }

    public function beforeAddTable__data_raw_ad_impression()
    {
        return $this->beforeAddTable('data_raw_ad_impression');
    }

    public function afterAddTable__data_raw_ad_impression()
    {
        return $this->afterAddTable('data_raw_ad_impression');
    }

    public function beforeAddTable__data_raw_ad_request()
    {
        return $this->beforeAddTable('data_raw_ad_request');
    }

    public function afterAddTable__data_raw_ad_request()
    {
        return $this->afterAddTable('data_raw_ad_request');
    }

    public function beforeAddTable__data_raw_tracker_click()
    {
        return $this->beforeAddTable('data_raw_tracker_click');
    }

    public function afterAddTable__data_raw_tracker_click()
    {
        return $this->afterAddTable('data_raw_tracker_click');
    }

    public function beforeAddTable__data_raw_tracker_impression()
    {
        return $this->beforeAddTable('data_raw_tracker_impression');
    }

    public function afterAddTable__data_raw_tracker_impression()
    {
        return $this->afterAddTable('data_raw_tracker_impression');
    }

    public function beforeAddTable__data_raw_tracker_variable_value()
    {
        return $this->beforeAddTable('data_raw_tracker_variable_value');
    }

    public function afterAddTable__data_raw_tracker_variable_value()
    {
        return $this->afterAddTable('data_raw_tracker_variable_value');
    }

    public function beforeAddTable__data_summary_ad_hourly()
    {
        return $this->beforeAddTable('data_summary_ad_hourly');
    }

    public function afterAddTable__data_summary_ad_hourly()
    {
        $migration = new StatMigration();
        $migration->init($this->oDBH, $this->logFile);
        return $migration->migrateData() && $this->afterAddTable('data_summary_ad_hourly');
    }

    public function beforeAddTable__data_summary_ad_zone_assoc()
    {
        return $this->beforeAddTable('data_summary_ad_zone_assoc');
    }

    public function afterAddTable__data_summary_ad_zone_assoc()
    {
        return $this->afterAddTable('data_summary_ad_zone_assoc');
    }

    public function beforeAddTable__data_summary_channel_daily()
    {
        return $this->beforeAddTable('data_summary_channel_daily');
    }

    public function afterAddTable__data_summary_channel_daily()
    {
        return $this->afterAddTable('data_summary_channel_daily');
    }

    public function beforeAddTable__data_summary_zone_country_daily()
    {
        return $this->beforeAddTable('data_summary_zone_country_daily');
    }

    public function afterAddTable__data_summary_zone_country_daily()
    {
        return $this->afterAddTable('data_summary_zone_country_daily');
    }

    public function beforeAddTable__data_summary_zone_country_forecast()
    {
        return $this->beforeAddTable('data_summary_zone_country_forecast');
    }

    public function afterAddTable__data_summary_zone_country_forecast()
    {
        return $this->afterAddTable('data_summary_zone_country_forecast');
    }

    public function beforeAddTable__data_summary_zone_country_monthly()
    {
        return $this->beforeAddTable('data_summary_zone_country_monthly');
    }

    public function afterAddTable__data_summary_zone_country_monthly()
    {
        return $this->afterAddTable('data_summary_zone_country_monthly');
    }

    public function beforeAddTable__data_summary_zone_domain_page_daily()
    {
        return $this->beforeAddTable('data_summary_zone_domain_page_daily');
    }

    public function afterAddTable__data_summary_zone_domain_page_daily()
    {
        return $this->afterAddTable('data_summary_zone_domain_page_daily');
    }

    public function beforeAddTable__data_summary_zone_domain_page_forecast()
    {
        return $this->beforeAddTable('data_summary_zone_domain_page_forecast');
    }

    public function afterAddTable__data_summary_zone_domain_page_forecast()
    {
        return $this->afterAddTable('data_summary_zone_domain_page_forecast');
    }

    public function beforeAddTable__data_summary_zone_domain_page_monthly()
    {
        return $this->beforeAddTable('data_summary_zone_domain_page_monthly');
    }

    public function afterAddTable__data_summary_zone_domain_page_monthly()
    {
        return $this->afterAddTable('data_summary_zone_domain_page_monthly');
    }

    public function beforeAddTable__data_summary_zone_impression_history()
    {
        return $this->beforeAddTable('data_summary_zone_impression_history');
    }

    public function afterAddTable__data_summary_zone_impression_history()
    {
        return $this->afterAddTable('data_summary_zone_impression_history');
    }

    public function beforeAddTable__data_summary_zone_site_keyword_daily()
    {
        return $this->beforeAddTable('data_summary_zone_site_keyword_daily');
    }

    public function afterAddTable__data_summary_zone_site_keyword_daily()
    {
        return $this->afterAddTable('data_summary_zone_site_keyword_daily');
    }

    public function beforeAddTable__data_summary_zone_site_keyword_forecast()
    {
        return $this->beforeAddTable('data_summary_zone_site_keyword_forecast');
    }

    public function afterAddTable__data_summary_zone_site_keyword_forecast()
    {
        return $this->afterAddTable('data_summary_zone_site_keyword_forecast');
    }

    public function beforeAddTable__data_summary_zone_site_keyword_monthly()
    {
        return $this->beforeAddTable('data_summary_zone_site_keyword_monthly');
    }

    public function afterAddTable__data_summary_zone_site_keyword_monthly()
    {
        return $this->afterAddTable('data_summary_zone_site_keyword_monthly');
    }

    public function beforeAddTable__data_summary_zone_source_daily()
    {
        return $this->beforeAddTable('data_summary_zone_source_daily');
    }

    public function afterAddTable__data_summary_zone_source_daily()
    {
        return $this->afterAddTable('data_summary_zone_source_daily');
    }

    public function beforeAddTable__data_summary_zone_source_forecast()
    {
        return $this->beforeAddTable('data_summary_zone_source_forecast');
    }

    public function afterAddTable__data_summary_zone_source_forecast()
    {
        return $this->afterAddTable('data_summary_zone_source_forecast');
    }

    public function beforeAddTable__data_summary_zone_source_monthly()
    {
        return $this->beforeAddTable('data_summary_zone_source_monthly');
    }

    public function afterAddTable__data_summary_zone_source_monthly()
    {
        return $this->afterAddTable('data_summary_zone_source_monthly');
    }

    public function beforeAddTable__log_maintenance_forecasting()
    {
        return $this->beforeAddTable('log_maintenance_forecasting');
    }

    public function afterAddTable__log_maintenance_forecasting()
    {
        return $this->afterAddTable('log_maintenance_forecasting');
    }

    public function beforeAddTable__log_maintenance_priority()
    {
        return $this->beforeAddTable('log_maintenance_priority');
    }

    public function afterAddTable__log_maintenance_priority()
    {
        return $this->afterAddTable('log_maintenance_priority');
    }

    public function beforeAddTable__log_maintenance_statistics()
    {
        return $this->beforeAddTable('log_maintenance_statistics');
    }

    public function afterAddTable__log_maintenance_statistics()
    {
        return $this->afterAddTable('log_maintenance_statistics');
    }

    public function beforeAddTable__plugins_channel_delivery_assoc()
    {
        return $this->beforeAddTable('plugins_channel_delivery_assoc');
    }

    public function afterAddTable__plugins_channel_delivery_assoc()
    {
        return $this->afterAddTable('plugins_channel_delivery_assoc');
    }

    public function beforeAddTable__plugins_channel_delivery_domains()
    {
        return $this->beforeAddTable('plugins_channel_delivery_domains');
    }

    public function afterAddTable__plugins_channel_delivery_domains()
    {
        return $this->afterAddTable('plugins_channel_delivery_domains');
    }

    public function beforeAddTable__plugins_channel_delivery_rules()
    {
        return $this->beforeAddTable('plugins_channel_delivery_rules');
    }

    public function afterAddTable__plugins_channel_delivery_rules()
    {
        return $this->afterAddTable('plugins_channel_delivery_rules');
    }

    public function beforeAddTable__agency()
    {
        return $this->beforeAddTable('agency');
    }

    public function afterAddTable__agency()
    {
        return $this->afterAddTable('agency');
    }

    public function beforeAddTable__campaigns()
    {
        return $this->beforeAddTable('campaigns');
    }

    public function afterAddTable__campaigns()
    {
        return $this->afterAddTable('campaigns');
    }

    public function beforeAddTable__acls_channel()
    {
        return $this->beforeAddTable('acls_channel');
    }

    public function afterAddTable__acls_channel()
    {
        return $this->afterAddTable('acls_channel');
    }

    public function beforeAddTable__channel()
    {
        return $this->beforeAddTable('channel');
    }

    public function afterAddTable__channel()
    {
        return $this->afterAddTable('channel');
    }

    public function beforeAddTable__ad_category_assoc()
    {
        return $this->beforeAddTable('ad_category_assoc');
    }

    public function afterAddTable__ad_category_assoc()
    {
        return $this->afterAddTable('ad_category_assoc');
    }

    public function beforeAddTable__category()
    {
        return $this->beforeAddTable('category');
    }

    public function afterAddTable__category()
    {
        return $this->afterAddTable('category');
    }

    public function beforeAddTable__ad_zone_assoc()
    {
        return $this->beforeAddTable('ad_zone_assoc');
    }

    public function afterAddTable__ad_zone_assoc()
    {
        return $this->afterAddTable('ad_zone_assoc');
    }

    public function beforeAddTable__placement_zone_assoc()
    {
        return $this->beforeAddTable('placement_zone_assoc');
    }

    public function afterAddTable__placement_zone_assoc()
    {
        return $this->afterAddTable('placement_zone_assoc');
    }

    public function beforeAddTable__campaigns_trackers()
    {
        return $this->beforeAddTable('campaigns_trackers');
    }

    public function afterAddTable__campaigns_trackers()
    {
        return $this->afterAddTable('campaigns_trackers');
    }

    public function beforeAddTable__tracker_append()
    {
        return $this->beforeAddTable('tracker_append');
    }

    public function afterAddTable__tracker_append()
    {
        return $this->afterAddTable('tracker_append');
    }

    public function beforeAddTable__trackers()
    {
        return $this->beforeAddTable('trackers');
    }

    public function afterAddTable__trackers()
    {
        return $this->afterAddTable('trackers');
    }

    public function beforeAddTable__variable_publisher()
    {
        return $this->beforeAddTable('variable_publisher');
    }

    public function afterAddTable__variable_publisher()
    {
        return $this->afterAddTable('variable_publisher');
    }

    public function beforeAddTable__variables()
    {
        return $this->beforeAddTable('variables');
    }

    public function afterAddTable__variables()
    {
        return $this->afterAddTable('variables');
    }

    public function beforeAddTable__preference()
    {
        return $this->beforeAddTable('preference');
    }

    public function afterAddTable__preference()
    {
        //	    $migration = new Migration_119();
        //	    $migration->init($this->oDBH);

        return $this->migrateData() && $this->afterAddTable('preference');
    }

    public function beforeAddTable__preference_advertiser()
    {
        return $this->beforeAddTable('preference_advertiser');
    }

    public function afterAddTable__preference_advertiser()
    {
        return $this->afterAddTable('preference_advertiser');
    }

    public function beforeAddTable__preference_publisher()
    {
        return $this->beforeAddTable('preference_publisher');
    }

    public function afterAddTable__preference_publisher()
    {
        return $this->afterAddTable('preference_publisher');
    }

    public function beforeAddTable__affiliates_extra()
    {
        return $this->beforeAddTable('affiliates_extra');
    }

    public function afterAddTable__affiliates_extra()
    {
        return $this->afterAddTable('affiliates_extra');
    }

    public function beforeAddTable__password_recovery()
    {
        return $this->beforeAddTable('password_recovery');
    }

    public function afterAddTable__password_recovery()
    {
        return $this->afterAddTable('password_recovery');
    }

    public function migrateData()
    {
        $prefix = $this->getPrefix();
        $tablePreference = $prefix . 'preference';
        $aColumns = $this->oDBH->manager->listTableFields($tablePreference);

        $table = $this->oDBH->quoteIdentifier($prefix . 'config', true);
        $sql = "
	       SELECT * from {$table}";
        $rsConfig = DBC::NewRecordSet($sql);
        if ($rsConfig->find() && $rsConfig->fetch()) {
            $aDataConfig = $rsConfig->toArray();
            $aValues = [];
            foreach ($aDataConfig as $column => $value) {
                if (in_array($column, $aColumns)) {
                    $aValues[$column] = $value;
                }
            }

            // Migrate PAN config variables
            $phpAdsNew = new OA_phpAdsNew();
            $aPanConfig = $phpAdsNew->_getPANConfig();
            $aValues['warn_admin'] = $aPanConfig['warn_admin'] ? 't' : 'f';
            $aValues['warn_client'] = $aPanConfig['warn_client'] ? 't' : 'f';
            $aValues['warn_limit'] = $aPanConfig['warn_limit'] ? $aPanConfig['warn_limit'] : 100;
            $aValues['default_banner_url'] = $aPanConfig['default_banner_url'];
            $aValues['default_banner_destination'] = $aPanConfig['default_banner_target'];

            $result = $this->createGeoTargetingConfiguration(
                $aPanConfig['geotracking_type'],
                $aPanConfig['geotracking_location'],
                $aPanConfig['geotracking_stats']
            );

            if ($result === false) {
                return $this->_logErrorAndReturnFalse('Error configuring geotargeting');
            }

            $sql = \OA_DB_Sql::sqlForInsert('preference', $aValues);
            $result = $this->oDBH->exec($sql);
            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse('Error inserting preferences during data migration 108: ' . $result->getUserInfo());
            }
            return true;
        } else {
            return false;
        }
    }


    public function createGeoTargetingConfiguration(
        $geotracking_type,
        $geotracking_location,
        $geotracking_stats
    ) {
        $upgradeConfig = new OA_Upgrade_Config();
        $host = OX_getHostName();

        if (empty($geotracking_type) || $geotracking_type == 'ip2country') {
            return $this->writeGeoPluginConfig('"none"', $geotracking_stats, $host);
        } elseif ($geotracking_type == 'mod_geoip') {
            return
               $this->writeGeoPluginConfig('ModGeoIP', $geotracking_stats, $host)
               && $this->writeGeoSpecificConfig('ModGeoIP', '', $host);
        } elseif ($geotracking_type == 'geoip') {
            $databaseSetting = $this->getDatabaseSetting($geotracking_location);
            if ($databaseSetting === false) {
                $this->_logError('Unable to configure geoip');
                return $this->writeGeoPluginConfig('"none"', $geotracking_stats, $host);
            }
            $result = $this->writeGeoPluginConfig('GeoIP', $geotracking_stats, $host);
            return $result && $this->writeGeoSpecificConfig('GeoIP', $databaseSetting, $host);
        }
        return false;
    }

    public function getDatabaseSetting($geotracking_location)
    {
        $geotracking_conf = OA_phpAdsNew::phpAds_geoip_getConf($geotracking_location);

        $sDatabaseType = $this->getDatabaseType($geotracking_conf);
        if ($sDatabaseType === false) {
            return $this->_logErrorAndReturnFalse('Could not set the geotracking database configuration');
        }
        return "$sDatabaseType=$geotracking_location\n";
    }


    public function getDatabaseType($geotracking_conf)
    {
        $aLocationStrings = [
           1 => 'geoipCountryLocation',
           7 => 'geoipRegionLocation',
           3 => 'geoipRegionLocation',
           6 => 'geoipCityLocation',
           2 => 'geoipCityLocation',
           5 => 'geoipOrgLocation',
           4 => 'geoipIspLocation',
           10 => 'geoipNetspeedLocation',
           // 8 => 'geoipDmaLocation', // GEOIP_PROXY_EDITION // We're unsure
           // 9 => 'geoipAreaLocation' // GEOIP_ASNUM_EDITION // of these two
                                                              // and will have
                                                              // to check with
                                                              // MaxMind
        ];
        $aGeotrackingConf = unserialize($geotracking_conf);
        if ($aGeotrackingConf === false) {
            return $this->_logErrorAndReturnFalse('Could not retrieve geotracking configuration information, geotracking_conf is empty');
        }
        if (!isset($aGeotrackingConf['databaseType'])) {
            return $this->_logErrorAndReturnFalse('Could not retrieve geotracking database type');
        }
        $databaseType = $aGeotrackingConf['databaseType'];
        if (!isset($aLocationStrings[$databaseType])) {
            return $this->_logErrorAndReturnFalse('Could not determine the geotracking location string');
        }
        return $aLocationStrings[$databaseType];
    }


    public function writeGeoPluginConfig($type, $geotracking_stats, $host)
    {
        $result = $this->createConfigDirectory(GEOCONFIG_PATH);
        if ($result === false) {
            return $this->_logErrorAndReturnFalse('Could not create the geotargeting plugin configuration directory');
        }
        $saveStats = $geotracking_stats ? 'true' : 'false';
        $pluginConfigPath = MAX_PATH . "/var/plugins/config/geotargeting/$host.plugin.conf.php";
        $pluginConfigContents = "[geotargeting]\ntype=$type\nsaveStats=$saveStats\nshowUnavailable=false";
        return $this->writeContents($pluginConfigPath, $pluginConfigContents);
    }


    public function writeGeoSpecificConfig($type, $append, $host)
    {
        $pluginConfigDir = MAX_PATH . "/var/plugins/config/geotargeting/$type";
        $result = $this->createConfigDirectory($pluginConfigDir);
        $pluginConfigPath = "$pluginConfigDir/$host.plugin.conf.php";
        $pluginConfigContents = "[geotargeting]\ntype=$type\n$append";
        return $result && $this->writeContents($pluginConfigPath, $pluginConfigContents);
    }


    public function createConfigDirectory($dir, $recursive = true)
    {
        if (file_exists($dir)) {
            return is_dir($dir);
        }
        $parent = dirname($dir);
        if ($recursive && !file_exists($parent)) {
            $result = $this->createConfigDirectory($parent, false);
            if (!$result) {
                return $this->_logErrorAndReturnFalse('Could not create the ' . $parent . ' directory');
            }
        }
        $old_umask = umask(0);
        $result = mkdir($dir, 0777);
        umask($old_umask);
        return $result;
    }

    /**
     * Reimplements file_put_contents for PHP4, but works only for text
     * content.
     *
     * @param string $filename
     * @param string $contents
     */
    public function writeContents($filename, $contents)
    {
        $file = fopen($filename, "wt");
        if ($file === false) {
            return false;
        }
        $result = fwrite($file, $contents);
        if ($result === false) {
            return false;
        }
        return fclose($file);
    }
}
