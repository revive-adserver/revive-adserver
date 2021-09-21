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

require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once(MAX_PATH . '/lib/OA/Upgrade/phpAdsNew.php');
require_once(MAX_PATH . '/lib/OA/DB/Sql.php');

class prescript_tables_core_399
{
    public function __construct()
    {
    }

    public function execute_constructive($aParams)
    {
        $oDBUpgrader = $aParams[0];

        $migration = new StatMigration();
        $migration->compactStats = true;
        $migration->init($oDBUpgrader->oSchema->db, $oDBUpgrader->logFile);

        return $migration->migrateData();
    }

    public function execute_destructive($aParams)
    {
        return true;
    }
}
