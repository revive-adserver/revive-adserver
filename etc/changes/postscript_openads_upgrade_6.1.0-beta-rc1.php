<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| https://www.revive-adserver.com                                           |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

$className = 'RV_UpgradePostscript_6_1_0_beta_rc1';

class RV_UpgradePostscript_6_1_0_beta_rc1
{
    /** @var OA_Upgrade */
    public $oUpgrade;

    /** @var MDB2_Driver_Common */
    public $oDbh;

    public function execute($aParams): bool
    {
        $this->oUpgrade = $aParams[0];
        $this->oDbh = OA_DB::singleton();

        if (PEAR::isError($this->oDbh)) {
            $this->logError($this->oDbh->getUserInfo());
            return false;
        }

        $tableConfig = $GLOBALS['_MAX']['CONF']['table'];
        $tableName = $tableConfig['prefix'] . (($tableConfig['ad_zone_assoc'] ?? '') ?: 'ad_zone_assoc');
        $quotedTableName = $this->oDbh->quoteIdentifier($tableName, true);
        if (PEAR::isError($quotedTableName)) {
            $this->logError($quotedTableName->getUserInfo());
            return false;
        }

        // Link type 2 represented the obsolete category-based ad/zone associations.
        $deletedRows = $this->oDbh->exec("DELETE FROM {$quotedTableName} WHERE link_type = 2");
        if (PEAR::isError($deletedRows)) {
            $this->logError($deletedRows->getUserInfo());
            return false;
        }

        $this->logOnly("Removed {$deletedRows} legacy category ad/zone associations");
        return true;
    }

    private function logOnly(string $message): void
    {
        $this->oUpgrade->oLogger->logOnly($message);
    }

    private function logError(string $message): void
    {
        $this->oUpgrade->oLogger->logError($message);
    }
}
