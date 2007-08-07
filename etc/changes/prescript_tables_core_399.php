<?php

require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once(MAX_PATH . '/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH . '/lib/OA/DB/Sql.php');

class prescript_tables_core_399
{
    function prescript_tables_core_399()
    {

    }

    function execute_constructive($aParams)
    {
        $oDBUpgrader = $aParams[0];

        $migration = new StatMigration();
	    $migration->compactStats = true;

	    $migration->init($oDBUpgrader->oSchema->db);

		return $migration->migrateData();
    }

    function execute_destructive($aParams)
    {
        return true;
    }
}

?>