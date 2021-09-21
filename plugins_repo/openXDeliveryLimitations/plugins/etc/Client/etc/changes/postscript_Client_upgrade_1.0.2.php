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

$className = 'Client_UpgradePostscript_1_0_2';

/**
 * Migrates the old [logging][sniff] conf setting
 *
 * @package    Plugin
 * @subpackage openxDeliveryLimitations
 */
class Client_UpgradePostscript_1_0_2
{
    public function __construct()
    {
    }

    public function execute($aParams)
    {
        if (isset($GLOBALS['_MAX']['CONF']['logging']['sniff'])) {
            $value = $GLOBALS['_MAX']['CONF']['logging']['sniff'];
            unset($GLOBALS['_MAX']['CONF']['logging']['sniff']);

            $oSettings = new OA_Admin_Settings();
            $oSettings->settingChange('Client', 'sniff', $value);
            $oSettings->writeConfigChange();
        }
        return true;
    }
}
