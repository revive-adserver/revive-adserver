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

$className = 'RV_UpgradePostscript_5_4_0_beta_rc4';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class RV_UpgradePostscript_5_4_0_beta_rc4
{
    /** @var MDB2_Driver_Common */
    public $oDbh;

    public function execute($aParams)
    {
        $this->oDbh = OA_DB::singleton();

        $this->migrateAdminUser();

        return true;
    }

    private function migrateAdminUser()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $newHash = $GLOBALS['session']['password_hash'] ?? null;

        if (empty($newHash)) {
            $this->logOnly('Missing new password hash, skipping');

            return true;
        }

        $userId = OA_Permission::getUserId();

        if (empty($userId)) {
            $this->logError('Missing user ID');

            return false;
        }

        $tblUsers = $aConf['table']['prefix'] . ($aConf['table']['users'] ?? 'users');
        $qtblUsers = $this->oDbh->quoteIdentifier($tblUsers, true);

        /** @var MDB2_Statement_Common $stmt */
        $stmt = $this->oDbh->prepare("UPDATE {$qtblUsers} SET password = :newHash WHERE userid = :userId");

        $ret = $stmt->execute([
            'userId' => $userId,
            'newHash' => $newHash,
        ]);

        if (PEAR::isError($ret)) {
            $this->logError($ret->getUserInfo());

            return false;
        }

        $this->logOnly('New admin password hash has been saved');
    }

    private function logOnly($msg)
    {
        if (isset($this->oUpgrade->oLogger)) {
            $this->oUpgrade->oLogger->logOnly($msg);
        }
    }

    private function logError($msg)
    {
        if (isset($this->oUpgrade->oLogger)) {
            $this->oUpgrade->oLogger->logError($msg);
        }
    }
}
