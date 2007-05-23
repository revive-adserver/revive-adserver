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
$Id: Acls.dal.test.php 5552 2007-04-03 19:52:40Z andrew.hill@openads.org $
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH.'/lib/OA/DB/Sql.php');

define('GEOCONFIG_PATH', MAX_PATH . '/var/plugins/config/geotargeting');

class Migration_119 extends Migration
{

    function Migration_119()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__preference';
		$this->aTaskList_constructive[] = 'afterAddTable__preference';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_publisher';


    }



	function beforeAddTable__preference()
	{
		return $this->beforeAddTable('preference');
	}

	function afterAddTable__preference()
	{
		return $this->migrateData() && $this->afterAddTable('preference');
	}

	function beforeAddTable__preference_advertiser()
	{
		return $this->beforeAddTable('preference_advertiser');
	}

	function afterAddTable__preference_advertiser()
	{
		return $this->afterAddTable('preference_advertiser');
	}

	function beforeAddTable__preference_publisher()
	{
		return $this->beforeAddTable('preference_publisher');
	}

	function afterAddTable__preference_publisher()
	{
		return $this->afterAddTable('preference_publisher');
	}


	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    $tablePreference = $prefix . 'preference';
	    $aColumns = $this->oDBH->manager->listTableFields($tablePreference);

	    $sql = "
	       SELECT * from {$prefix}config";
	    $rsConfig = DBC::NewRecordSet($sql);
	    if ($rsConfig->find() && $rsConfig->fetch()) {
	        $aDataConfig = $rsConfig->toArray();
	        $aValues = array();
	        foreach($aDataConfig as $column => $value) {
	            if (in_array($column, $aColumns)) {
	                $aValues[$column] = $value;
	            }
	        }

	        copy(
	           MAX_PATH.'/etc/changes/tests/data/config_2_0_12.inc.php',
	           MAX_PATH.'/var/config.inc.php'
	        );

	        // Migrate PAN config variables
	        $phpAdsNew = new OA_phpAdsNew();
            $aPanConfig = $phpAdsNew->_getPANConfig();
            $aValues['warn_admin']                 = $aPanConfig['warn_admin'] ? 't' : 'f';
            $aValues['warn_client']                = $aPanConfig['warn_client'] ? 't' : 'f';
            $aValues['warn_limit']                 = $aPanConfig['warn_limit'] ? $aPanConfig['warn_limit'] : 100;
            $aValues['default_banner_url']         = $aPanConfig['default_banner_url'];
            $aValues['default_banner_destination'] = $aPanConfig['default_banner_target'];

            $this->createGeoTargetingConfiguration(
                $aPanConfig['geotracking_type'],
                $aPanConfig['geotracking_location'],
                $aPanConfig['geotracking_stats'],
                $aPanConfig['geotracking_conf']);
            
            unlink(MAX_PATH.'/var/config.inc.php');

	        $sql = OA_DB_SQL::sqlForInsert($tablePreference, $aValues);
	        $result = $this->oDBH->exec($sql);
	        return (!PEAR::isError($result));
	    }
	    else {
	        return false;
	    }
	}
	
	
	function createGeoTargetingConfiguration(
	   $geotracking_type, $geotracking_location, $geotracking_stats, $geotracking_conf)
	{
	    $upgradeConfig = new OA_Upgrade_Config();
	    $host = $upgradeConfig->getHost();
	    
	    if (empty($geotracking_type)) {
	        return $this->writeGeoPluginConfig('"none"', $geotracking_stats, $host);
	    }
	    elseif ($geotracking_type == 'mod_geoip') {
	        return
	           $this->writeGeoPluginConfig('ModGeoIP', $geotracking_stats, $host)
	           && $this->writeGeoSpecificConfig('ModGeoIP', '', $host);
	    }
	    elseif ($geotracking_type == 'geoip') {
	        $result = $this->writeGeoPluginConfig('GeoIP', $geotracking_stats, $host);
	        $databaseSetting = $this->getDatabaseSetting($geotracking_conf, $geotracking_location);
	        if ($databaseSetting === false) {
	            return false;
	        }
	        return $result && $this->writeGeoSpecificConfig('GeoIP', $databaseSetting, $host);
	    }
	    return false;
	}
	
	function getDatabaseSetting($geotracking_conf, $geotracking_location)
	{
	    $sDatabaseType = $this->getDatabaseType($geotracking_conf);
	    if ($sDatabaseType === false) {
	        return false;
	    }
	    return "$sDatabaseType=$geotracking_location\n";
	}
	
	
	function getDatabaseType($geotracking_conf)
	{
	    $aLocationStrings = array(
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
	    );
	    $aGeotrackingConf = unserialize($geotracking_conf);
	    if ($aGeotrackingConf === false) {
	        return false;
	    }
	    if (!isset($aGeotrackingConf['databaseType'])) {
	        return false;
	    }
	    $databaseType = $aGeotrackingConf['databaseType'];
	    if (!isset($aLocationStrings[$databaseType])) {
	        return false;
	    }
	    return $aLocationStrings[$databaseType];
	}
	
	
	function writeGeoPluginConfig($type, $geotracking_stats, $host)
	{
	    if (!file_exists(GEOCONFIG_PATH)) {
	        $result = mkdir(GEOCONFIG_PATH);
	        if ($result === false) {
	            return false;
	        }
	    }
	    $saveStats = $geotracking_stats ? 'true' : 'false';
	    $pluginConfigPath = MAX_PATH . "/var/plugins/config/geotargeting/$host.plugin.conf.php";
        $pluginConfigContents = "[geotargeting]\ntype=$type\nsaveStats=$saveStats\nshowUnavailable=false";
        return $this->writeContents($pluginConfigPath, $pluginConfigContents);
	}
	
	
	function writeGeoSpecificConfig($type, $append, $host)
	{
	    $pluginConfigDir = MAX_PATH . "/var/plugins/config/geotargeting/$type";
	    $result = $this->createConfigDirectory($pluginConfigDir);
	    $pluginConfigPath = "$pluginConfigDir/$host.plugin.conf.php";
        $pluginConfigContents = "[geotargeting]\ntype=$type\n$append";
        return $result && $this->writeContents($pluginConfigPath, $pluginConfigContents);
	}
	
	
	function createConfigDirectory($dir)
	{
	    if (file_exists($dir) && !is_dir($dir)) {
	        return false;
	    }
	    elseif (file_exists($dir)) {
	        return true;
	    }
	    return mkdir($dir, 0700, true);
	}
	
	/**
	 * Reimplements file_put_contents for PHP4, but works only for text
	 * content.
	 *
	 * @param string $filename
	 * @param string $contents
	 */
	function writeContents($filename, $contents)
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

?>