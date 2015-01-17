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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_603 extends Migration
{

    function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAlterField__acls__type';
        $this->aTaskList_constructive[] = 'afterAlterField__acls__type';
        $this->aTaskList_constructive[] = 'beforeAlterField__acls_channel__type';
        $this->aTaskList_constructive[] = 'afterAlterField__acls_channel__type';


    }

    function beforeAlterField__acls__type()
    {
        return $this->beforeAlterField('acls', 'type');
    }

    function afterAlterField__acls__type()
    {
        return $this->afterAlterField('acls', 'type');
    }

    function beforeAlterField__acls_channel__type()
    {
        return $this->beforeAlterField('acls_channel', 'type');
    }

    /**
     * This method calls migrateData and migrateConfig
     * These methods deal with translating any existing config/database values
     * into the new format required by the plugin framework
     *
     * @return unknown
     */
    function afterAlterField__acls_channel__type()
    {
        return $this->migrateData() && $this->migrateConfig() && $this->afterAlterField('acls_channel', 'type');
    }

    function migrateData()
    {
        // banners.ext_bannertype needs to be set for html and txt banners
        $aBannerTypeMap = array(
           'html' => 'bannerTypeHtml:oxHtml:genericHtml',
           'txt'  => 'bannerTypeText:oxText:genericText',
        );
        $table = $this->oDBH->quoteIdentifier($this->_getTableName('banners'));
        $sucess = true;

        foreach ($aBannerTypeMap as $old => $new) {
            $query = "UPDATE {$table} SET ext_bannertype = '{$new}' WHERE storagetype='{$old}'";
            if (!$this->oDBH->query($query)) {
                $sucess = false;
            }
        }
        // acls.type and acls_channel.type need to be updated
        $aAclsTypeMap = array(
            'Client:Browser'    => 'deliveryLimitations:Client:Browser',
            'Client:Domain'     => 'deliveryLimitations:Client:Domain',
            'Client:Ip'         => 'deliveryLimitations:Client:Ip',
            'Client:Useragent'  => 'deliveryLimitations:Client:Useragent',
            'Client:Language'   => 'deliveryLimitations:Client:Language',
            'Client:Os'         => 'deliveryLimitations:Client:Os',
            'Site:Referingpage' => 'deliveryLimitations:Site:Referingpage',
            'Site:Channel'      => 'deliveryLimitations:Site:Channel',
            'Site:Pageurl'      => 'deliveryLimitations:Site:Pageurl',
            'Site:Variable'     => 'deliveryLimitations:Site:Variable',
            'Site:Source'       => 'deliveryLimitations:Site:Source',
            'Geo:Latlong'       => 'deliveryLimitations:Geo:Latlong',
            'Geo:Region'        => 'deliveryLimitations:Geo:Region',
            'Geo:Postalcode'    => 'deliveryLimitations:Geo:Postalcode',
            'Geo:Organisation'  => 'deliveryLimitations:Geo:Organisation',
            'Geo:Country'       => 'deliveryLimitations:Geo:Country',
            'Geo:Continent'     => 'deliveryLimitations:Geo:Continent',
            'Geo:Areacode'      => 'deliveryLimitations:Geo:Areacode',
            'Geo:Netspeed'      => 'deliveryLimitations:Geo:Netspeed',
            'Geo:Dma'           => 'deliveryLimitations:Geo:Dma',
            'Geo:City'          => 'deliveryLimitations:Geo:City',
            'Time:Date'         => 'deliveryLimitations:Time:Date',
            'Time:Day'          => 'deliveryLimitations:Time:Day',
            'Time:Hour'         => 'deliveryLimitations:Time:Hour',
        );
        $tables = array(
           $this->oDBH->quoteIdentifier($this->_getTableName('acls')),
           $this->oDBH->quoteIdentifier($this->_getTableName('acls_channel')),
        );
        foreach ($tables as $table) {
            foreach ($aAclsTypeMap as $old => $new) {
                $query = "UPDATE {$table} SET type = '{$new}' WHERE type='{$old}'";
                if (!$this->oDBH->query($query)) {
                    $sucess = false;
                }
            }
        }
        return $sucess;
    }

    // This method moves some settings out of the global config scope and into plugin config sections
    function migrateConfig()
    {
        $oConfiguration = new OA_Admin_Settings();

        $this->migrateGeoSettings($oConfiguration);
        $this->migrateCasSettings($oConfiguration);
        $this->migrateTagSettings($oConfiguration);

        return $oConfiguration->writeConfigChange();
    }

    function migrateGeoSettings(&$oConfiguration)
    {
        // Migrate any settings from $aConf['geotargeting'] to the appropriate group
        if (!empty($oConfiguration->aConf['geotargeting'])) {
            // ModGeoIP doesn't have any settings, just change the type value
            $fields = array('geoipCountryLocation', 'geoipRegionLocation', 'geoipCityLocation', 'geoipAreaLocation', 'geoipDmaLocation', 'geoipOrgLocation', 'geoipIspLocation', 'geoipNetspeedLocation');
            if ($oConfiguration->aConf['geotargeting']['type'] == 'ModGeoIP') {
                $oConfiguration->aConf['geotargeting']['type'] = 'geoTargeting:oxMaxMindModGeoIP:oxMaxMindModGeoIP';
            } elseif ($oConfiguration->aConf['geotargeting']['type'] == 'GeoIP') {
                // GeoIP requires the type to be set and any file-locations to be set
                $oConfiguration->aConf['geotargeting']['type'] = 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP';
                $oConfiguration->aConf['oxMaxMindGeoIP'] = array();
                foreach ($fields as $field) {
                    if (!empty($oConfiguration->aConf['geotargeting'][$field])) {
                        $oConfiguration->aConf['oxMaxMindGeoIP'][$field] = $oConfiguration->aConf['geotargeting'][$field];
                    }
                }
            }
            foreach ($fields as $field) {
                unset($oConfiguration->aConf['geotargeting'][$field]);
            }
        }
    }

    function migrateCasSettings(&$oConfiguration)
    {
        // Migrate the oacSSO section to oxAuthCAS (if required)
        if ($oConfiguration->aConf['authentication']['type'] == 'cas') {
            $oConfiguration->aConf['authentication']['type'] = 'authentication:oxAuthCAS:oxAuthCAS';
            $oConfiguration->aConf['oxAuthCAS'] = $oConfiguration->aConf['oacSSO'];
        }
        // Now remove the redundant group
        unset($oConfiguration->aConf['oacSSO']);
    }

    function migrateTagSettings(&$oConfiguration)
    {
        // Migrate the allowed invocationTags settings
        if (!empty($oConfiguration->aConf['allowedTags'])) {
            $oConfiguration->aConf['oxInvocationTags'] = array();
            foreach ($oConfiguration->aConf['allowedTags'] as $key => $value) {
                $newKey = 'isAllowed' . ucfirst($key);
                $oConfiguration->aConf['oxInvocationTags'][$newKey] = $value;
            }
        }
        unset($oConfiguration->aConf['allowedTags']);
    }

    /**
     * Get the name of a table
     *
     * @param string $table
     * @return The (prefixed) table name as defined in the config file
     */
    function _getTableName($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        return $aConf['prefix'] . ($aConf[$table] ? $aConf[$table] : $table);
    }
}

?>