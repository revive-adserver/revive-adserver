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

$className = 'OA_UpgradePostscript_2_1_29';


class OA_UpgradePostscript_2_1_29
{
    public $oUpgrade;
    public function __construct()
    {
    }

    public function execute($aParams)
    {
        $this->oUpgrade = &$aParams[0];
        if (!$this->configPan()) {
            return false;
        }
        if (!$this->configMax()) {
            return false;
        }
        $this->oUpgrade->addPostUpgradeTask('Rebuild_Banner_Cache');
        $this->oUpgrade->addPostUpgradeTask('Maintenance_Priority');
        $this->oUpgrade->addPostUpgradeTask('Recompile_Acls');
        return true;
    }

    public function configPan()
    {
        if (!$this->oUpgrade->oConfiguration->putNewConfigFile()) {
            $this->oUpgrade->oLogger->logError('Installation failed to create the configuration file');
            return false;
        }
        $aConfig = $this->oUpgrade->oPAN->aConfig;
        $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
        $this->oUpgrade->oConfiguration->setupConfigPan($aConfig);
        $this->oUpgrade->oConfiguration->writeConfig();
        if (!$this->oUpgrade->oConfiguration->oSettings->backupConfig(MAX_PATH . '/var/' . $this->oUpgrade->oPAN->fileCfg)) {
            $this->oUpgrade->oLogger->logError('Failed to rename your old configuration file (non-critical, you should delete or rename /var/config.inc.php yourself)');
            $this->oUpgrade->message = 'Failed to rename your old configuration file (non-critical, you should delete or rename /var/config.inc.php yourself)';
        }
        if (file_exists(MAX_PATH . '/var/' . $this->oUpgrade->oPAN->fileCfg)) {
            unlink(MAX_PATH . '/var/' . $this->oUpgrade->oPAN->fileCfg);
        }
        return true;
    }

    public function configMax()
    {
        if (!$this->oUpgrade->oVersioner->removeMaxVersion()) {
            $this->oUpgrade->oLogger->logError('Failed to remove your old application version');
            $this->oUpgrade->message = 'Failed to remove your old application version';
            return false;
        }
        $this->oUpgrade->oLogger->log('Removed old application version');
        return true;
    }
}
