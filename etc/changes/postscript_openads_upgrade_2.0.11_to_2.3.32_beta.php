<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

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