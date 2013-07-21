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

$className = 'oxMarket_UpgradePostscript_1_1_0_RC1';

/**
 * Moves shownSplash from config to database
 * Ensures that multiple accounts mode is off
 *
 * @package    Plugin
 * @subpackage openxDeliveryLimitations
 */
class oxMarket_UpgradePostscript_1_1_0_RC1
{
    var $oUpgrade;

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        // This is first update from market plugin without multiple accounts switch
        // so we can insert splashAlreadyShown and set multipleAccountsMode=0
        if (isset($GLOBALS['_MAX']['CONF']['oxMarket']['splashAlreadyShown']))
        {
            $account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
            $value = $GLOBALS['_MAX']['CONF']['oxMarket']['splashAlreadyShown'];

            $oDbh = &OA_DB::singleton();
            $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
            $prefTable = $oDbh->quoteIdentifier($prefix.'ext_market_general_pref', true);
            $account_id = $oDbh->escape($account_id);
            $value = $oDbh->escape($value);

            $query = "INSERT INTO ".$prefTable."
                      (account_id, name, value)
                      VALUES('".$account_id."', 'splashAlreadyShown', '".$value."')";
            $ret = $oDbh->query($query);

            if (PEAR::isError($ret))
            {
                $this->logError($ret->getUserInfo());
                return false;
            }

            if (!PEAR::isError($ret)) {
                unset($GLOBALS['_MAX']['CONF']['oxMarket']['splashAlreadyShown']);
                $this->logOnly('splashAlreadyShown setting was moved from config to database');
            } else {
                $this->logError('Couldn\'t move splashAlreadyShown setting from config to database');
                $this->logError($ret->getUserInfo());
            }
        }

        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('oxMarket','multipleAccountsMode','0');
        if (!$oSettings->writeConfigChange()) {
            $this->logError('Couldn\'t reset multipleAccountsMode to 0');
        }

        return true;
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