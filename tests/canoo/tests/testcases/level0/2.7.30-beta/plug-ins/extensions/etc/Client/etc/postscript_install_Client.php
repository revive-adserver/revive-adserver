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

$className = 'postscript_install_Client';

/**
 * Migrates the old [logging][sniff] conf setting
 *
 * @package    Plugin
 * @subpackage openxDeliveryLimitations
 */
class postscript_install_Client
{

    /**
     *
     * @return boolean True
     */
    function execute()
    {
        if (isset($GLOBALS['_MAX']['CONF']['logging']['sniff']))
        {
            $value = $GLOBALS['_MAX']['CONF']['logging']['sniff'];
            unset($GLOBALS['_MAX']['CONF']['logging']['sniff']);

            $oSettings  = new OA_Admin_Settings();
            $oSettings->settingChange('Client','sniff',$value);
            $oSettings->writeConfigChange();
        }
        return true;
    }
}

?>