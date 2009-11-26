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
        
        $this->migrateFromPre283();
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

    function migrateFromPre283()
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $query = '	INSERT INTO '.$prefix.OX_oxMarket_Stats::MARKET_STATS_TABLE.'
                    SELECT date_time, 
                    		NULL as market_advertiser_id, 
                    		t.width as ad_width, 
                    		t.height as ad_height, 
                    		t2.affiliateid as website_id, 
                    		0 as zone_id, 
                    		t6.bannerid as ad_id, 
                    		t.impressions as impressions, 
                    		0 as clicks, 
                    		t.revenue as revenue,
                    		NULL as market_advertiser_id 
                    FROM '.$prefix.'ext_market_web_stats t
                    LEFT JOIN '.$prefix.'ext_market_website_pref t2
                    ON t2.website_id = t.p_website_id 
                    LEFT JOIN '.$prefix.'affiliates t3
                    ON t3.affiliateid = t2.affiliateid
                    LEFT JOIN '.$prefix.'clients t4
                    ON t4.agencyid = t3.agencyid 
                    LEFT JOIN '.$prefix.'campaigns t5
                    ON t5.clientid=t4.clientid 
                    LEFT JOIN '.$prefix.'banners t6
                    ON t6.campaignid = t5.campaignid
                    WHERE t4.type = 1
                    AND t5.type=1
                    ';
        $oDbh = OA_DB::singleton();
        $rows = $oDbh->query('TRUNCATE TABLE '.$prefix.OX_oxMarket_Stats::MARKET_STATS_TABLE);
        $rows = $oDbh->query($query);
        if (PEAR::isError($rows))
        {
            $this->logError($rows->getUserInfo());
            $this->logOnly('Migration stats query failed. You can execute try to execute it manually: <br> '.$query);
        }
    }
}

