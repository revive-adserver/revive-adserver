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

$className = 'OA_UpgradePostscript_2_3_31';


class OA_UpgradePostscript_2_3_31
{
    var $oUpgrade;

    function __construct()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        if (!$this->configMax())
        {
            return false;
        }
        $this->oUpgrade->addPostUpgradeTask('Rebuild_Banner_Cache');
        $this->oUpgrade->addPostUpgradeTask('Maintenance_Priority');
        $this->oUpgrade->addPostUpgradeTask('Recompile_Acls');
        return true;
    }

    function configMax()
    {
        if ($this->oUpgrade->oConfiguration->isMaxConfigFile())
        {
            if (!$this->oUpgrade->oConfiguration->replaceMaxConfigFileWithOpenadsConfigFile())
            {
                $this->oUpgrade->oLogger->logError('Failed to replace your old configuration file with a new OpenX configuration file');
                $this->oUpgrade->message = 'Failed to replace your old configuration file with a new OpenX configuration file';
                return false;
            }
            $this->oUpgrade->oLogger->log('Replaced your old configuration file with a new OpenX configuration file');
            $this->oUpgrade->oConfiguration->setMaxInstalledOff();
            $this->oUpgrade->oConfiguration->writeConfig();
        }
        if (!$this->oUpgrade->oVersioner->removeMaxVersion())
        {
            $this->oUpgrade->oLogger->logError('Failed to remove your old application version');
            $this->oUpgrade->message = 'Failed to remove your old application version';
            return false;
        }
        $this->oUpgrade->oLogger->log('Removed old application version');
        $this->oUpgrade->oConfiguration->setupConfigPriority('');
        if (!$this->oUpgrade->oConfiguration->writeConfig())
        {
            $this->oUpgrade->oLogger->logError('Failed to set the randmax priority value');
            $this->oUpgrade->message = 'Failed to set the randmax priority value';
            return false;
        }
        return true;
    }
}

?>