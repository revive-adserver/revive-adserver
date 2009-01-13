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

require_once MAX_PATH . '/etc/changes/ConfigMigration.php';


$className = 'OA_UpgradePrescript_2_3_33';


class OA_UpgradePrescript_2_3_33
{
    var $oUpgrade;
    var $oSchema;
    var $oConfigMigration;

    function OA_UpgradePrescript_2_3_33()
    {
        $this->oConfigMigration = new ConfigMigration();
    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        if (PEAR::isError($this->alterDatabaseActionTable()))
        {
            return false;
        }
        if (!$this->migratePluginsIniConfigs()) {
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
        OA_DB::setCaseSensitive();
        $aPrev  = $this->oSchema->getDefinitionFromDatabase(array($prefix.'database_action'));
        OA_DB::disableCaseSensitive();
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
		$aGeoConfig = $this->oConfigMigration->getGeotargetingConfig();
		$this->oUpgrade->oConfiguration->setBulkValue('geotargeting', $aGeoConfig);
        if(!$this->oConfigMigration->mergeConfigWith('geotargeting', $aGeoConfig)) {
        	$this->oUpgrade->oLogger->logOnly('Failed to merge geotargeting files (non-critical, you should set geotargeting options by yourself)');
        }
        return true;
	}

	function migratePluginsIniConfigs()
	{
	    if (!$this->oConfigMigration->renamePluginsConfigAffix('ini', 'php')) {
	        $this->oUpgrade->oLogger->logOnly('Failed to rename plugins config files from *.ini to *.php (non-critical, you should set geotargeting options by yourself)');
	    }
	    return true;
	}

}