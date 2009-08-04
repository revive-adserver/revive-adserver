<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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