<?php

require_once MAX_PATH . '/etc/changes/ConfigMigration.php';

/**
 * Common code to all upgrades which upgrades to version 2.3.32-beta
 *
 */
class OA_UpgradePostscriptTo2_3_32
{

    function migrateGeotargetingConfig()
	{
		$configMigration = new ConfigMigration();
		$aGeoConfig = $configMigration->getGeotargetingConfig();
		$this->oUpgrade->oConfiguration->setBulkValue('geotargeting', $aGeoConfig);
        if(!$configMigration->mergeConfigWith('geotargeting', $aGeoConfig)) {
        	$this->oUpgrade->oLogger->logError('Failed to merge geotargeting files (non-critical, you should set geotargeting options by yourself)');
        }
        return true;
	}

}

?>