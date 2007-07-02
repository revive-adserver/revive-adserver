<?php

class OA_UpgradePrescript
{
    var $oUpgrade;
    var $oSchema;

    function OA_UpgradePrescript()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        if (PEAR::isError($this->alterDatabaseActionTable()))
        {
            return false;
        }
        if (!$this->migrateGeotargetingConfig()) {
        	return false;
        }
        return true;
    }

    function alterDatabaseActionTable()
    {
        $this->oSchema  = MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $aPrev  = $this->oSchema->getDefinitionFromDatabase(array($prefix.'database_action'));
        $aCurr  = $this->_getLatestDatabaseActionSchema($prefix);
        $aChanges = $this->oSchema->compareDefinitions($aCurr, $aPrev);
        if (is_array($aChanges) && count($aChanges)>0)
        {
            if (isset($aChanges['tables']['change'][$prefix.'database_action']))
            {
                if (isset($aChanges['tables']['change'][$prefix.'database_action']['indexes']['add']['database_action_pkey']))
                {
                    unset($aChanges['tables']['change'][$prefix.'database_action']['indexes']['add']['database_action_pkey']);
                    unset($aChanges['tables']['change'][$prefix.'database_action']['indexes']['change']);
                }
                if (isset($aChanges['tables']['change'][$prefix.'database_action']['add']['database_action_id']))
                {
                    $result = $this->oSchema->alterDatabase($aCurr, $aPrev, $aChanges);
                    if (PEAR::isError($result))
                    {
                        $this->oUpgrade->oLogger->logError($result->getUserInfo());
                        return false;
                    }
                    $this->oUpgrade->oLogger->log('database_action table schema successfully upgraded');
                    return true;
                }
            }
        }
        $this->oUpgrade->oLogger->log('database_action table schema upgrade unnecessary');
        return true;
    }

    function _getLatestDatabaseActionSchema($prefix)
    {
        $aCurr         = $this->oSchema->parseDatabaseDefinitionFile(MAX_PATH.'/etc/database_action.xml');
        $aCurr['name'] = $this->oSchema->db->connected_database_name;
        $aCurr['tables'][$prefix.'database_action']        = $aCurr['tables']['database_action'];
        $aCurr['tables'][$prefix.'database_action']['was'] = $prefix.'database_action';
        unset($aCurr['tables']['database_action']);

        return $aCurr;
    }
    
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