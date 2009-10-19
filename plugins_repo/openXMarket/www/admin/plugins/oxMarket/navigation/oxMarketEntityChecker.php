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
$Id: oxMarketActiveChecker.php 40924 2009-08-04 12:30:06Z lukasz.wikierski $
*/
require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

/**
 *
 * @package    openXMarket
 * @subpackage oxMarket
 * @author     Bernard Lange  <bernard@openx.org>
 */
class Plugins_admin_oxMarket_oxMarketEntityChecker 
    implements OA_Admin_Menu_IChecker
{
    /**
     * Checks if currently accessed entity (advertiser, campaign) is a market one 
     * and if the given section can be shown for that entity.
     *
     * @param OA_Admin_Menu_Section $oSection
     */
    public function check($oSection) 
    {
        phpAds_registerGlobal('clientid', 'campaignid');
        global $clientid, $campaignid;
        
        $sectionId = $oSection->getId();
        
        //checker is called multiple times, cache the lookup in a static variable
        static $cache = array();
        
        $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
        $oEntityHelper = $oMarketComponent->getEntityHelper();
        
        $enabled = true;
        switch($sectionId) {
            case 'advertiser-edit':
            case 'advertiser-trackers':
            case 'advertiser-access':
            case 'campaign-edit_new':
            case 'campaign-edit':
            case 'campaign-trackers': 
            case 'campaign-banners':
            case 'banner-edit':
            case 'banner-acl':
            case 'banner-zone':
            case 'banner-advanced': {
                if (isset($cache[$clientid])) {
                    return $cache[$clientid];
                }        
                
                //do not allow any entity pages for market advertiser
                $enabled = !$oEntityHelper->isMarketAdvertiser($clientid);
                $cache[$clientid] = $enabled;  
                
                break;
            }
            
            case 'campaign-zone': {
                if (isset($cache[$sectionId.':'.$campaignid])) {
                    return $cache[$sectionId.':'.$campaignid];
                }          
                
                if ($oEntityHelper->isMarketAdvertiser($clientid)) { //market advertiser
                    //show only for contract market camapaigns
                    $enabled = $oEntityHelper->isMarketContractCampaign($campaignid);
                }
                else { 
                    $enabled = true; //show for normal campaigns
                }
                $cache[$sectionId.':'.$campaignid] = $enabled;
                
                break;
            }
            
            case 'market-campaign-edit_new':
            case 'market-campaign-edit':
            case 'market-campaign-acl': {
                $enabled = $oMarketComponent->isActive() 
                    &&  $oEntityHelper->isMarketContractCampaign($campaignid);  
                break;
            }
        }
        
        
        /* Check if id of advertiser stored in session is market, then clear it.
         * Eg. user cannot go directly to banners list from campaign list for market campaign
         * but when he goes to eg. campaign edit screen and then goes to 
         * 'banners' he would see banners of recently viewed campaign 
         * since id is passed via session.
         * We need to prevent that and clear clientid from session for market
         * entities.
         */
        $sessionClientId = $this->getSessionClientId();
        if (isset($sessionClientId) 
            && $oMarketComponent->getEntityHelper()->isMarketAdvertiser($sessionClientId)) {
            $this->clearMarketEntitiesInSession();
        }
        
        
        return $enabled;
    }
    
    
    
    
    private function getSessionClientId()
    {
        return $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];         
    }
    
    
    /**
     * Clears the market entities from session so that pages that use these values
     * cannot display their children.
     * Eg. user cannot go to banners list from campaign list, but when he clicks
     * on campaign and then click banners he would see banners of such campaign
     * since id is passed via session and will not be caught by checker.
     */
    private function clearMarketEntitiesInSession()
    {
        global $session;
        
        $clientid = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];
        unset($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid']);
        if ($clientid) {
            unset($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['campaignid'][$clientid]);
        }
        phpAds_SessionDataStore();
    }
    
}

?>
