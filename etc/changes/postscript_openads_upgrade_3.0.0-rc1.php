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

        $this->_updateSyncServerSettings();
        $this->_removeShareDataSetting();
        $this->_removeOacXmlRpcSettings();
        $this->_removeOacDashboardSettings();
        $this->_removeShowContactUsLinkSetting();

        return true;
    }

    /**
     * Update the sync server configuration settings, as the server changed
     * with the release of Revive Adserver 3.0.0
     */
    function _updateSyncServerSettings()
    {
        $this->logOnly("Attempting to update the configuration file sync server settings");
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
    }

    /**
     * Remove the sync server "share data" setting, as this was deprecated in
     * Revive Adserver 3.0.0
     */
    function _removeShareDataSetting()
    {
        $this->logOnly("Attempting to remove the 'share data' sync setting from the configuration file");
        $oConfiguration = new OA_Admin_Settings();
        unset($oConfiguration->aConf['sync']['shareData']);
        if ($oConfiguration->writeConfigChange()) {
            $this->logOnly("Removed the 'share data' sync setting from the configuration file");
        } else {
            $this->logError("Failed to remove the 'share data' sync setting from the configuration file");
        }
    }

    /**
     * Remove the entire "oacXmlRpc" setting section, as this was deprecated in
     * Revive Adserver 3.0.0
     */
    function _removeOacXmlRpcSettings()
    {
        $this->logOnly("Attempting to remove the 'oacXmlRpc' settings from the configuration file");
        $oConfiguration = new OA_Admin_Settings();
        unset($oConfiguration->aConf['oacXmlRpc']['protocol']);
        unset($oConfiguration->aConf['oacXmlRpc']['host']);
        unset($oConfiguration->aConf['oacXmlRpc']['httpPort']);
        unset($oConfiguration->aConf['oacXmlRpc']['httpsPort']);
        unset($oConfiguration->aConf['oacXmlRpc']['path']);
        unset($oConfiguration->aConf['oacXmlRpc']['captcha']);
        unset($oConfiguration->aConf['oacXmlRpc']['signUpUrl']);
        unset($oConfiguration->aConf['oacXmlRpc']['publihserUrl']);
        if ($oConfiguration->writeConfigChange()) {
            $this->logOnly("Removed the 'oacXmlRpc' settings from the configuration file");
        } else {
            $this->logError("Failed to remove the 'oacXmlRpc' settings from the configuration file");
        }
    }

    /**
     * Remove the entire "oacDashboard" setting section, as this was deprecated in
     * Revive Adserver 3.0.0
     */
    function _removeOacDashboardSettings()
    {
        $this->logOnly("Attempting to remove the 'oacDashboard' settings from the configuration file");
        $oConfiguration = new OA_Admin_Settings();
        unset($oConfiguration->aConf['oacDashboard']['protocol']);
        unset($oConfiguration->aConf['oacDashboard']['host']);
        unset($oConfiguration->aConf['oacDashboard']['port']);
        unset($oConfiguration->aConf['oacDashboard']['path']);
        unset($oConfiguration->aConf['oacDashboard']['ssoCheck']);
        if ($oConfiguration->writeConfigChange()) {
            $this->logOnly("Removed the 'oacDashboard' settings from the configuration file");
        } else {
            $this->logError("Failed to remove the 'oacDashboard' settings from the configuration file");
        }
    }

    /**
     * Remove the UI "show contact us link" setting, as this was deprecated in
     * Revive Adserver 3.0.0
     */
    function _removeShowContactUsLinkSetting()
    {
        $this->logOnly("Attempting to remove the 'share data' sync setting from the configuration file");
        $oConfiguration = new OA_Admin_Settings();
        unset($oConfiguration->aConf['ui']['showContactUsLink']);
        if ($oConfiguration->writeConfigChange()) {
            $this->logOnly("Removed the 'share data' sync setting from the configuration file");
        } else {
            $this->logError("Failed to remove the 'share data' sync setting from the configuration file");
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