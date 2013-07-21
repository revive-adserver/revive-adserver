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

$className = 'OA_UpgradePostscript_2_7_31_beta_rc1';


class OA_UpgradePostscript_2_7_31_beta_rc1
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    function OA_UpgradePostscript_2_7_31_beta_rc11()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade =& $aParams[0];
        $this->oUpgrade->oConfiguration->aConfig = $GLOBALS['_MAX']['CONF'];
        // Change the pluginPaths values from /extensions/ to /plugins/
        $this->oUpgrade->oConfiguration->aConfig['pluginPaths']['plugins'] = '/plugins/';
        $this->oUpgrade->oConfiguration->aConfig['pluginPaths']['packages'] = '/plugins/etc/';
        unset($this->oUpgrade->oConfiguration->aConfig['pluginPaths']['extensions']);
        
        // Also change the check for updates server which may have been previously set to localhost
        $this->oUpgrade->oConfiguration->aConfig['pluginUpdatesServer'] = array(
            'protocol'  => 'http',
            'host'      => 'code.openx.org',
            'path'      => '/openx/plugin-updates',
            'httpPort'  => '80',
        );
        $this->oUpgrade->oConfiguration->writeConfig();
        $this->oUpgrade->oLogger->logOnly("Renamed [pluginPaths]extensions to [pluginPaths]plugins");
        return true;
    }
}