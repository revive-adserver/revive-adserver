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

require_once MAX_PATH . '/lib/OA/Cache/tests/util/DeliveryCacheUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheManager.php';

/**
 * A class for testing the OA_Cache_DeliveryCacheManager class.
 *
 * To run tests installed delivery cache storage plugin is required.
 * Don't forget to set plugin enabled in test.conf.php
 * if [delivery] cacheStorePlugin = Extension/Group/Component   (e.g. deliveryCacheStore:oxCacheFile:oxCacheFile)
 * add to [pluginGroupComponents] entry: Group=1        (e.g. oxCacheFile=1)
 *
 * If you want to run tests for memcached plugin you have to create [oxMemcached] section in test.conf
 * and set memcachedServers parameter in this new section
 * e.g.
 * [oxMemcached]
 * memcachedServers = 127.0.0.1:11211  ; If you run memcached server on same host and default port
 *
 * @package    OpenXCache
 * @subpackage TestSuite
 *
 */
class test_OA_Cache_DeliveryCacheManager extends DeliveryCacheUnitTestCase
{
    /**
     * Array of database object Ids
     * @see DeliveryCacheUnitTestCase::_createTestData()
     *
     * @var array
     */
    public $_aIds;

    /**
     * An instance of OA_Cache_DeliveryCacheManager
     *
     * @var OA_Cache_DeliveryCacheManager
     */
    public $oDeliveryCacheManager;

    public function __construct()
    {
        $this->oDeliveryCacheManager = new OA_Cache_DeliveryCacheManager();
    }

    public function setUp()
    {
        // Make sure that delivery cache is clear for tests
        $this->oDeliveryCacheManager->invalidateAll();
        // Prepare sample data
        $this->_aIds = $this->_createTestData();
        $this->_createTestCacheFiles($this->_aIds);
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        $this->oDeliveryCacheManager->invalidateAll();
    }

    /**
     * Check if tests can be runned
     */
    public function skip()
    {
        // Skip tests if cache storage plugin
        // isn't installed or enabled
        $this->skipIf(
            ($this->oDeliveryCacheManager->oCacheStorePlugin === false),
            "There is no cache storage plugin",
        );
    }

    /**
     * Method tests invalidateBannerCache method
     */
    public function test_invalidateBannerCache()
    {
        $cachedData = MAX_cacheGetAd($this->_aIds['banners'][0]);
        $zoneLinkingCachedData = MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]);

        // Change something in banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($this->_aIds['banners'][0]);
        $doBanners->description = 'new description';
        $doBanners->update();

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetAd($this->_aIds['banners'][0]), $cachedData);
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]), $zoneLinkingCachedData);

        $this->oDeliveryCacheManager->invalidateBannerCache($this->_aIds['banners'][0]);

        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetAd($this->_aIds['banners'][0]), $cachedData);
        $this->assertNotEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]), $zoneLinkingCachedData);
    }

    /**
     * Method tests invalidateImageCache method
     */
    public function test_invalidateImageCache()
    {
        $cachedData = MAX_cacheGetCreative($this->_aIds['images'][0]);

        // Change something in image
        $doImage = OA_Dal::factoryDO('images');
        $doImage->get($this->_aIds['images'][0]);
        $doImage->contents = 'new contents';
        $doImage->update();

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetCreative($this->_aIds['images'][0]), $cachedData);

        $this->oDeliveryCacheManager->invalidateImageCache($this->_aIds['images'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetCreative($this->_aIds['images'][0]), $cachedData);
    }

    /**
     * Method tests invalidateZoneCache method
     *
     */
    public function test_invalidateZoneCache()
    {
        $cachedZoneInfoData = MAX_cacheGetZoneInfo($this->_aIds['zones'][0]);
        $cachedZoneLinkedAdsData = MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]);
        $cachedPublisherZonesData = OA_cacheGetPublisherZones($this->_aIds['affiliates'][0]);

        // Change zonename
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->get($this->_aIds['zones']);
        $doZone->zonename = 'new name';
        $doZone->update();

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetZoneInfo($this->_aIds['zones'][0]), $cachedZoneInfoData);
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]), $cachedZoneLinkedAdsData);
        $this->assertEqual(OA_cacheGetPublisherZones($this->_aIds['affiliates'][0]), $cachedPublisherZonesData);

        $this->oDeliveryCacheManager->invalidateZoneCache($this->_aIds['zones'][0]);

        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetZoneInfo($this->_aIds['zones'][0]), $cachedZoneInfoData);
        $this->assertNotEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]), $cachedZoneLinkedAdsData);
        $this->assertNotEqual(OA_cacheGetPublisherZones($this->_aIds['affiliates'][0]), $cachedPublisherZonesData);
    }

    /**
     * Method tests invalidateWebsiteCache method
     */
    public function test_invalidateWebsiteCache()
    {
        $cachedData = OA_cacheGetPublisherZones($this->_aIds['zones'][0]);

        // Delete zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zoneid = $this->_aIds['zones'][0];
        $doZones->delete();

        // Expect no changes in cache
        $this->assertEqual(OA_cacheGetPublisherZones($this->_aIds['zones'][0]), $cachedData);

        $this->oDeliveryCacheManager->invalidateWebsiteCache($this->_aIds['zones'][0]);

        // Now expect changes in cache
        $this->assertNotEqual(OA_cacheGetPublisherZones($this->_aIds['zones'][0]), $cachedData);
    }

    /**
     * Method tests invalidateZonesLinkingCache method
     */
    public function test_invalidateZonesLinkingCache()
    {
        $cachedData[0] = MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]);
        $cachedData[1] = MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][1]);

        $aZonesIds = [$this->_aIds['zones'][0], $this->_aIds['zones'][1]];

        // Unlink zones from campaign
        $dalZones = OA_Dal::factoryDAL('zones');
        $dalZones->unlinkZonesFromCampaign($aZonesIds, $this->_aIds['campaigns'][0]);

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]), $cachedData[0]);
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][1]), $cachedData[1]);

        $this->oDeliveryCacheManager->invalidateZonesLinkingCache($aZonesIds);

        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][0]), $cachedData[0]);
        $this->assertNotEqual(MAX_cacheGetZoneLinkedAds($this->_aIds['zones'][1]), $cachedData[1]);
    }

    /**
     * Method tests invalidateTrackerCache method
     */
    public function test_invalidateTrackerCache()
    {
        $cachedTrackerData = MAX_cacheGetTracker($this->_aIds['tracker'][0]);
        $cachedTrackerVariablesData = MAX_cacheGetTrackerVariables($this->_aIds['tracker'][0]);

        // Do some changes in tracker
        $doTracker = OA_Dal::factoryDO('trackers');
        $doTracker->get($this->_aIds['trackers'][0]);
        $doTracker->description = 'new description';
        $doTracker->update();

        // Add new variable to the tracker
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $this->_aIds['trackers'][0];
        DataGenerator::generateOne($doVariables);

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetTracker($this->_aIds['tracker'][0]), $cachedTrackerData);
        $this->assertEqual(MAX_cacheGetTrackerVariables($this->_aIds['tracker'][0]), $cachedTrackerVariablesData);

        $this->oDeliveryCacheManager->invalidateTrackerCache($this->_aIds['trackers'][0]);

        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetTracker($this->_aIds['trackers'][0]), $cachedTrackerData);
        $this->assertNotEqual(MAX_cacheGetTrackerVariables($this->_aIds['trackers'][0]), $cachedTrackerVariablesData);
    }

    /**
     * Method tests invalidateChannelCache method
     */
    public function test_invalidateChannelCache()
    {
        $cachedData = MAX_cacheGetChannelLimitations($this->_aIds['channel'][0]);

        // Change channel data
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->get($this->_aIds['channel'][0]);
        $doChannel->acl_plugins = 'new value';
        $doChannel->update();

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetChannelLimitations($this->_aIds['channel'][0]), $cachedData);
        $this->oDeliveryCacheManager->invalidateChannelCache($this->_aIds['channel'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetChannelLimitations($this->_aIds['channel'][0]), $cachedData);
    }

    /**
     * Method tests invalidateSystemSettingsCache method
     */
    public function test_invalidateSystemSettingsCache()
    {
        $interval = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] * 60;
        $delay = intval(($GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] / 12) * 60);

        // store orginal settings
        $currentClick = $GLOBALS['_MAX']['CONF']['file']['click'];
        // Set maintenace timestamp to 48h ago
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = 'maintenance_timestamp';
        $doAppVar->value = MAX_commonGetTimeNow() - 2 * $interval;
        $doAppVar->insert();

        // Remember current cache
        $cachedTZData = MAX_cacheGetAccountTZs();
        $cachedMaintenanceData = MAX_cacheCheckIfMaintenanceShouldRun();

        // Change JS settings, Time Zone, and time of Last Run of maintenace
        $GLOBALS['_MAX']['CONF']['file']['click'] = 'click.php';

        $doAppVar->name = 'maintenance_timestamp';
        $doAppVar->value = MAX_commonGetTimeNow() + $delay + 1;
        $doAppVar->update();

        // Add Admin user and set time zone in his preferences
        $doAccount = OA_Dal::factoryDO('accounts');
        $doAccount->account_type = 'ADMIN';
        $accountId = DataGenerator::generateOne($doAccount);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $doPreferences->value = 'new value';
        $doPreferences->account_type = 'ADMIN';
        $preferencesId = DataGenerator::generateOne($doPreferences);

        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->account_id = $accountId;
        $doAccountPreferenceAssoc->preference_id = $preferencesId;
        $doAccountPreferenceAssoc->value = 'new value';
        DataGenerator::generateOne($doAccountPreferenceAssoc);

        // Expect no changes in cache files
        $this->assertEqual(MAX_cacheGetAccountTZs(), $cachedTZData);
        $this->assertEqual(MAX_cacheCheckIfMaintenanceShouldRun(), $cachedMaintenanceData);

        $this->oDeliveryCacheManager->invalidateSystemSettingsCache();

        // Now expect changes in cache files
        $this->assertNotEqual(MAX_cacheGetAccountTZs(), $cachedTZData);
        $this->assertNotEqual(MAX_cacheCheckIfMaintenanceShouldRun(), $cachedMaintenanceData);

        // restore orginal settings
        $GLOBALS['_MAX']['CONF']['file']['click'] = $currentClick;
    }
}
