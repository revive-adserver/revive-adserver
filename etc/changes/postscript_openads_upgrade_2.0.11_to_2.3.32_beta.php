<?php

require_once MAX_PATH . '/lib/max/Maintenance/Priority.php';

class OA_UpgradePostscript
{
    var $oUpgrade;

    function OA_UpgradePostscript()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        if (!$this->configPan())
        {
            return false;
        }
        if (!MAX_Maintenance_Priority::run())
        {
            return false;
        }
        return true;
    }

    function configPan()
    {
        if (!$this->oUpgrade->oConfiguration->putNewConfigFile())
        {
            $this->oUpgrade->oLogger->logError('Installation failed to create the configuration file');
            return false;
        }
        $aConfig = $this->oUpgrade->oPAN->aConfig;
        $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
        $this->oUpgrade->oConfiguration->setupConfigPan($aConfig);
        $this->oUpgrade->oConfiguration->writeConfig();
        if (!$this->oUpgrade->oConfiguration->oConfig->backupConfig(MAX_PATH.'/var/'.$this->oUpgrade->oPAN->fileCfg))
        {
            $this->oUpgrade->oLogger->logError('Failed to rename your old configuration file (non-critical, you should delete or rename /var/config.inc.php yourself)');
            $this->oUpgrade->message = 'Failed to rename your old configuration file (non-critical, you should delete or rename /var/config.inc.php yourself)';
        }
        if (file_exists(MAX_PATH.'/var/'.$this->oUpgrade->oPAN->fileCfg))
        {
            unlink(MAX_PATH.'/var/'.$this->oUpgrade->oPAN->fileCfg);
        }
        $this->oUpgrade->oLogger->log('Removed old application version');
        return true;
    }

}

?>