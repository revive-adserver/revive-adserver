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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

/**
 * A base class for delivery cache test class.
 *
 * @package    OpenXCache
 * @subpackage TestSuite
 */
abstract class DeliveryCacheUnitTestCase extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Function creates 2 zones on 1 website and 2 campaigns 2 banners each under 1 advertiser
     * website and advertiser are under the same agency
     *
     * @return array Array of DB Ids in format:
     *               array = ( 'zones' => array ( 0=> zone_id_1, ...),
     *                         'agency => array ( 0=> agency_id ) ... )
     *               keys: 'zones', 'affiliates', 'agency', 'clients', 'campaigns', 'images', 'banners', 'trackers', 'channel'
     */
    function _createTestData() {
        $aIds = array();

        // Create zones and websites
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zonename        = 'Zone 1';
        $doZones->width           = 468;
        $doZones->height          = 60;
        $doZones->delivery        = phpAds_ZoneBanner;
        $aIds['zones'][0] = DataGenerator::generateOne($doZones, true);
        $aIds['affiliates'][0] = DataGenerator::getReferenceId('affiliates');
        $aIds['agency'][0] = DataGenerator::getReferenceId('agency');

        $doZones->zonename        = 'Zone 2';
        $doZones->affiliateid     = $aIds['affiliates'][0];
        $aIds['zones'][1] = DataGenerator::generateOne($doZones, true);

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->clientname        = 'Advertiser 1';
        $doClients->agencyid          = $aIds['agency'][0];
        $aIds['clients'][0] = DataGenerator::generateOne($doClients);

        // Create campaigns
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = 'Campaign 1';
        $doCampaigns->clientid     = $aIds['clients'][0];
        $aIds['campaigns'][0] = DataGenerator::generateOne($doCampaigns);

        $doCampaigns->campaignname = 'Campaign 2';
        $aIds['campaigns'][1] = DataGenerator::generateOne($doCampaigns);

        // Create images and banners
        $doImages = OA_Dal::factoryDO('images');
        for($i=0; $i<4; $i++){
            $aIds['images'][$i] = 'test'.$i.'.gif';
            $doImages->filename = $aIds['images'][$i];
            DataGenerator::generateOne($doImages);
        }

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width       = 468;
        $doBanners->height      = 60;
        $doBanners->storagetype = 'sql';
        $doBanners->contenttype = 'gif';

        $doBanners->name        = 'Banner 1-1';
        $doBanners->filename    = $aIds['images'][0];
        $doBanners->campaignid  =  $aIds['campaigns'][0];
        $aIds['banners'][0] = DataGenerator::generateOne($doBanners);

        $doBanners->name        = 'Banner 1-2';
        $doBanners->filename    = $aIds['images'][1];
        $doBanners->campaignid  =  $aIds['campaigns'][0];
        $aIds['banners'][1] = DataGenerator::generateOne($doBanners);

        $doBanners->name        = 'Banner 2-1';
        $doBanners->filename    = $aIds['images'][2];
        $doBanners->campaignid  =  $aIds['campaigns'][1];
        $aIds['banners'][2] = DataGenerator::generateOne($doBanners);

        $doBanners->name        = 'Banner 2-2';
        $doBanners->filename    = $aIds['images'][3];
        $doBanners->campaignid  =  $aIds['campaigns'][1];
        $aIds['banners'][3] = DataGenerator::generateOne($doBanners);

        // Create tracker
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->trackername = "Tracker 1";
        $doTrackers->clientid    = $aIds['clients'][0];
        $aIds['trackers'][0] = DataGenerator::generateOne($doTrackers);

        // Create Channel
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->agencyid    = $aIds['agency'][0];
        $doChannel->affiliateid = $aIds['affiliates'][0];
        $doChannel->name        = 'Website channel';
        $aIds['channel'][0] = DataGenerator::generateOne($doChannel);

        // link zones (and banners) to campaigns
        $dalZones = OA_Dal::factoryDAL('zones');
        $dalZones->linkZonesToCampaign($aIds['zones'], $aIds['campaigns'][0]);
        $dalZones->linkZonesToCampaign($aIds['zones'], $aIds['campaigns'][1]);
        return $aIds;
    }

    /**
     * Creates all possible delivert cache files
     *
     * @param array $aIds array of DB Ids returned by _createTestData
     * @see _createTestData
     */
    function _createTestCacheFiles($aIds) {
        // Create cache files not related to DB Objects
        MAX_cacheGetAccountTZs();
        MAX_cacheCheckIfMaintenanceShouldRun();
        MAX_cacheGetGoogleJavaScript();

        // Create cache files for banners and images
        foreach ($aIds['banners'] as $bannerId) {
            MAX_cacheGetAd($bannerId);
        }
        foreach ($aIds['images'] as $filename) {
            MAX_cacheGetCreative($filename);
        }

        // Create cache files for zones
        foreach ($aIds['zones'] as $zoneId) {
            MAX_cacheGetZoneLinkedAds($zoneId);
            MAX_cacheGetZoneInfo($zoneId);
        }

        // Create cache files for websites
        foreach ($aIds['affiliates'] as $affiliateid) {
            OA_cacheGetPublisherZones($affiliateid);
        }

        // Create cache files for trackers
        foreach ($aIds['trackers'] as $trackerid) {
            MAX_cacheGetTracker($trackerid);
            MAX_cacheGetTrackerVariables($trackerid);
        }

        // Create cache files for channels
        foreach ($aIds['channel'] as $channelid) {
            MAX_cacheGetChannelLimitations($channelid);
        }

        // cache files for direct-selection are not created
        // due to problems with invalidating MAX_cacheGetLinkedAds
    }

}

?>