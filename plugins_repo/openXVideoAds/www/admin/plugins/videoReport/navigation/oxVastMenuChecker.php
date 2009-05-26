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
*/
require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

class Plugins_admin_openXVideoAds_vastMenuChecker implements OA_Admin_Menu_IChecker
{
    /**
     * @param OA_Admin_Menu_Section $oSection
     */
    public function check($oSection) 
    {
        // this checker is called 6 times, not sure why, but we cache the lookup in a static variable
        static $cache = array();
        if(isset($cache[$oSection->getId()])) {
            return $cache[$oSection->getId()];
        }
        $enabled = false;
        require_once MAX_PATH . '/www/admin/plugins/videoReport/stats-api.php';
        $vast = new OX_Video_Report;
        phpAds_registerGlobal( 'clientid', 'campaignid', 'bannerid', 'zoneid' );
        global $clientid, $campaignid, $bannerid, $zoneid, $affiliateid;
        switch($oSection->getId()) {
            case 'stats-vast-advertiser':
                    $enabled = $vast->doesAdvertiserHaveVast($clientid);
                break;
            case 'stats-vast-campaign':
                    $enabled = $vast->doesCampaignHaveVast($campaignid);
                break;
            case 'stats-vast-banner': 
                    $enabled = $vast->doesBannerHaveVast($bannerid);
                break;
            case 'stats-vast-zone':
                    $enabled = $vast->isZoneVast($zoneid);
                break;
            case 'stats-vast-website':
                    $enabled = $vast->doesWebsiteHaveVast($affiliateid);
                break;
            case 'players-vast':
                return true;
                break;
            case 'zone-invocation':
                if(!empty($zoneid) && $vast->isZoneVast($zoneid)) {
                    $oSection->setNameKey('Video Invocation Code');
                    $oSection->setLink('plugins/videoReport/zone-invocation-code.php?zoneid='.$zoneid);
                }
                $enabled = true;
                break;
        }
        $cache[$oSection->getId()] = $enabled;
        return $enabled;
    }
}

?>
