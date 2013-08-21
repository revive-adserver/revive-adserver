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

$className = 'OA_UpgradePostscript_3_0_0_rc1';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class OA_UpgradePostscript_3_0_0_rc1
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        $this->logOnly("Attempting to update the configuration file sync server settings");

        // Update the sync server configuration settings, as these change with
        // Revive Adserver 3.0.0
        $oConfiguration = new OA_Admin_Settings();
        $oConfiguration->aConf['oacSync']['protocol']  = 'https';
        $oConfiguration->aConf['oacSync']['host']      = 'sync.revive-adserver.com';
        $oConfiguration->aConf['oacSync']['path']      = '/xmlrpc.php';
        $oConfiguration->aConf['oacSync']['httpPort']  = '80';
        $oConfiguration->aConf['oacSync']['httpsPort'] = '443';
        if ($oConfiguration->writeConfigChange()) {
            $this->logOnly("Updated the configuration file sync server settings");
        } else {
            $this->logError("Failed to update the configuration file sync server settings");
        }

        return true;
    }

    function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }


    function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }

}

?>