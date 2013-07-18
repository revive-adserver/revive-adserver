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

$className = 'oxMarket_UpgradePostscript_1_2_0_RC1';

/**
 * Mark all websites as not synchronized, to update website names during next maintenanace.
 *
 * @package    Plugin
 * @subpackage openXMarket
 */
class oxMarket_UpgradePostscript_1_2_0_RC1
{
    var $oUpgrade;
    
    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        
        $oDbh = &OA_DB::singleton();
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $prefTable = $oDbh->quoteIdentifier($prefix.'ext_market_website_pref', true);

        $query = "UPDATE ".$prefTable."
                  SET is_url_synchronized = 'f'";
        $ret = $oDbh->query($query);
    
        if (PEAR::isError($ret))
        {
            $this->logError($ret->getUserInfo());
            $this->logOnly('Cannot mark websites as not synchronized, to allow send proper website names.');
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