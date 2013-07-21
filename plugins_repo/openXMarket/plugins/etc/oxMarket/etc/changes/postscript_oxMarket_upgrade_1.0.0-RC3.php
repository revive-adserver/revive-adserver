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

$className = 'oxMarket_UpgradePostscript_1_0_0_RC3';

/**
 * Updates the url conf setting
 *
 * @package    Plugin
 * @subpackage openXMarket
 */
class oxMarket_UpgradePostscript_1_0_0_RC3
{
    
    
    function execute($aParams)
    {
        $oManager   = & new OX_Plugin_ComponentGroupManager();
        $aComponentSettings    = $oManager->getComponentGroupSettings('oxMarket', false);
        foreach ($aComponentSettings as $setting) {
            if ($setting['key'] == 'marketCaptchaUrl') {
                $value = $setting['value'];
                break; 
            }
        } 
        
        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('oxMarket','marketCaptchaUrl',$value);
        if (!$oSettings->writeConfigChange()) {
            OA::debug('openXMarket plugin: Couldn\'t update marketCaptchaUrl');
        }
        return true;
    }
}

?>