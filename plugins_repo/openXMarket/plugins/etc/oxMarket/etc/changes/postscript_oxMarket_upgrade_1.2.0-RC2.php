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

$className = 'oxMarket_UpgradePostscript_1_2_0_RC2';

/**
 * Mark all websites as not synchronized, to update website names during next maintenanace.
 *
 * @package    Plugin
 * @subpackage openXMarket
 */
class oxMarket_UpgradePostscript_1_2_0_RC2
{
    var $oUpgrade;
    
    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
    
        $oManager   = & new OX_Plugin_ComponentGroupManager();
        $aComponentSettings    = $oManager->getComponentGroupSettings('oxMarket', false);
        foreach ($aComponentSettings as $setting) {
            if ($setting['key'] == 'marketPublicApiUrl') {
                $value = $setting['value'];
                break; 
            }
        } 
        
        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('oxMarket','marketPublicApiUrl',$value);
        if (!$oSettings->writeConfigChange()) {
            OA::debug('openXMarket plugin: Couldn\'t update marketPublicApiUrl, value should be '.$value);
        }
        
        $this->optOutExclusiveCampaigns();
        
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

    /**
     * Opt out Contract Exclusive and Contract with end date set campaigns
     *
     * @return bool
     */
    function optOutExclusiveCampaigns()
    {
        $oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF'];
        $prefix = $aConf['table']['prefix'];
        $campaignPrefTable = $oDbh->quoteIdentifier($prefix.'ext_market_campaign_pref', true);
        $campaignsTable = $oDbh->quoteIdentifier($prefix.$aConf['table']['campaigns'], true);

        $query = "UPDATE ".$campaignPrefTable."
                  SET is_enabled = 0 
                  WHERE campaignid IN (
                    SELECT campaignid FROM ".$campaignsTable."
                    WHERE priority = -1 OR (priority>0 AND expire_time is NOT NULL))";
        $ret = $oDbh->query($query);

        if (PEAR::isError($ret))
        {
            $this->logError($ret->getUserInfo());
            $this->logOnly('Cannot opt out Contract Exclusive and Contract with end date set campaigns.');
        }
        
        return true;
    }
}

