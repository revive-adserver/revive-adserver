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

$className = 'OA_UpgradePostscript_3_1_0_beta_rc2';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class OA_UpgradePostscript_3_1_0_beta_rc2
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

        $this->_removePluginUpdateServerSettings();
        $this->_updateDefaultManagerToAccount();
        $this->_updateAdministratorAccountToSystemAdministrator();

        return true;
    }

    /**
     * Remove the entire "pluginUpdatesServer" setting section, as this was
     * deprecated in Revive Adserver 3.1.0
     */
    function _removePluginUpdateServerSettings()
    {
        $this->logOnly("Attempting to remove the 'pluginUpdatesServer' settings from the configuration file");
        $oConfiguration = new OA_Admin_Settings();
        unset($oConfiguration->aConf['pluginUpdatesServer']['protocol']);
        unset($oConfiguration->aConf['pluginUpdatesServer']['host']);
        unset($oConfiguration->aConf['pluginUpdatesServer']['path']);
        unset($oConfiguration->aConf['pluginUpdatesServer']['httpPort']);
        if ($oConfiguration->writeConfigChange()) {
            $this->logOnly("Removed the 'pluginUpdatesServer' settings from the configuration file");
        } else {
            $this->logError("Failed to remove the 'pluginUpdatesServer' settings from the configuration file");
        }
    }

    /**
     * Update the "Default Manager" account to "Default Account", if it still
     * exists for the user, as the term "Manager" was deprecated in Revive
     * Adserver 3.1.0
     */
    function _updateDefaultManagerToAccount()
    {
        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];

        $this->logOnly("Attempting to rename the 'Default Manager' account to 'Default Account' in the 'agency' table");
        $tblAgency = $aConf['prefix'] . ($aConf['agency'] ? $aConf['agency'] : 'agency');
        $query = "UPDATE " . $this->oDbh->quoteIdentifier($tblAgency, true) .
                 " SET name = 'Default Account' WHERE name = 'Default manager'";
        $result = $this->oDbh->query($query);
        if (!PEAR::isError($result)) {
            $this->logOnly("Renamed the old 'Default Manager' account in the 'agency' table");
        } else {
            $this->logError("Failed to rename the old 'Default Manager' account in the 'agency' table");
        }

        $this->logOnly("Attempting to rename the 'Default Manager' account to 'Default Account' in the 'accounts' table");
        $tblAccounts = $aConf['prefix'] . ($aConf['accounts'] ? $aConf['accounts'] : 'accounts');
        $query = "UPDATE " . $this->oDbh->quoteIdentifier($tblAccounts, true) .
                 " SET account_name = 'Default Account' WHERE account_name = 'Default manager'";
        $result = $this->oDbh->query($query);
        if (!PEAR::isError($result)) {
            $this->logOnly("Renamed the old 'Default Manager' account in the 'accounts' table");
        } else {
            $this->logError("Failed to rename the old 'Default Manager' account in the 'accounts' table");
        }
    }

    /**
     * Update the "Administrator Account" account to "System Administrator", if
     * it still exists for the user, for improved understanding of the account
     * purpose
     */
    function _updateAdministratorAccountToSystemAdministrator()
    {
        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];

        $this->logOnly("Attempting to rename the 'Administrator Account' account to 'System Administrator' in the 'accounts' table");
        $tblAccounts = $aConf['prefix'] . ($aConf['accounts'] ? $aConf['accounts'] : 'accounts');
        $query = "UPDATE " . $this->oDbh->quoteIdentifier($tblAccounts, true) .
                 " SET account_name = 'System Administrator' WHERE account_name = 'Administrator account'";
        $result = $this->oDbh->query($query);
        if (!PEAR::isError($result)) {
            $this->logOnly("Renamed the old 'Administrator Account' account in the 'accounts' table");
        } else {
            $this->logError("Failed to rename the old 'Administrator Account' account in the 'accounts' table");
        }
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