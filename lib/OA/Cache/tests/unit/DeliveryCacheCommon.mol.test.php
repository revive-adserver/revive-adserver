<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Cache/tests/util/DeliveryCacheUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/Cache/DeliveryCacheCommon.php';

/**
 * A class for testing the OA_Cache_DeliveryCacheCommon class.
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
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 *
 */
class test_OA_Cache_DeliveryCacheCommon extends DeliveryCacheUnitTestCase
{
    /**
     * An instance of OA_Cache_DeliveryCacheCommon
     *
     * @var OA_Cache_DeliveryCacheCommon
     */
    var $oDeliveryCacheCommon;

    function __construct(){
        $this->oDeliveryCacheCommon = new OA_Cache_DeliveryCacheCommon();
    }

    function setUp()
    {
        // Make sure that delivery cache is clear for tests
        $this->oDeliveryCacheCommon->invalidateAll();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
        $this->oDeliveryCacheCommon->invalidateAll();
        // Restore cache storage plugin settings
        $this->aConf['delivery']['cacheStoragePlugin'] = $this->currentCacheStorageSettings;
    }

    /**
     * Check if tests can be runned
     *
     */
    function skip()
    {
        // Skip tests if cache storage plugin
        // isn't installed or enabled
        $this->skipIf(
            ($this->oDeliveryCacheCommon->oCacheStorePlugin === false),
            "There is no cache storage plugin"
        );
    }

    /**
     * Method tests invalidateAll method
     *
     */
    function test_invalidateAll() {
        for($i=0; $i<5; $i++) {
            $filename = 'testname'.$i;
            OA_Delivery_Cache_store($filename, $i);
        }
        for($i=0; $i<5; $i++) {
            $this->assertEqual($i, OA_Delivery_Cache_fetch('testname'.$i));
        }
        $result = $this->oDeliveryCacheCommon->invalidateAll();
        $this->assertTrue($result);

        for($i=0; $i<5; $i++) {
            $this->assertFalse(OA_Delivery_Cache_fetch('testname'.$i));
        }
    }

    /**
     * Method tests invalidateGetAdCache method
     */
    function test_invalidateGetAdCache() {
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetAd($aIds['banners'][0]);
        // Change something in banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($aIds['banners'][0]);
        $doBanners->description = 'new description';
        $doBanners->update();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetAd($aIds['banners'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetAdCache($aIds['banners'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetAd($aIds['banners'][0]), $cachedData);
    }

    /**
     * Method tests invalidateGetAccountTZsCache method
     */
    function test_invalidateGetAccountTZsCache() {
        $cachedData = MAX_cacheGetAccountTZs();

        // Add Admin user and set time zone in his preferences
        $doAccount = OA_Dal::factoryDO('accounts');
        $doAccount->account_type = 'ADMIN';
        $accountId = DataGenerator::generateOne($doAccount);

        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $doPreferences->value           = 'new value';
        $doPreferences->account_type    = 'ADMIN';
        $preferencesId = DataGenerator::generateOne($doPreferences);

        $doAccountPreferenceAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccountPreferenceAssoc->account_id    = $accountId;
        $doAccountPreferenceAssoc->preference_id = $preferencesId;
        $doAccountPreferenceAssoc->value         = 'new value';
        DataGenerator::generateOne($doAccountPreferenceAssoc);

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetAccountTZs(), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetAccountTZsCache();
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetAccountTZs(), $cachedData);
    }

    /**
     * Method tests invalidateZoneLinkedAdsCache method
     */
    function test_invalidateZoneLinkedAdsCache() {
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetZoneLinkedAds($aIds['zones'][0]);
        // Change zone
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->get($aIds['zones'][0]);
        $doZone->zonename = 'new name';
        $doZone->update();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($aIds['zones'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateZoneLinkedAdsCache($aIds['zones'][0]);
        // Now expect changes in cache
        $cachedData2 = MAX_cacheGetZoneLinkedAds($aIds['zones'][0]);
        $this->assertNotEqual($cachedData2, $cachedData);

        // Change linked banner
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->get($aIds['banners'][0]);
        $doBanners->description = 'new description';
        $doBanners->update();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($aIds['zones'][0]), $cachedData2);
        $this->oDeliveryCacheCommon->invalidateZoneLinkedAdsCache($aIds['zones'][0]);
        // Now expect changes in cache
        $cachedData3 = MAX_cacheGetZoneLinkedAds($aIds['zones'][0]);
        $this->assertNotEqual($cachedData3, $cachedData2);

        // Unlink banner
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->zone_id = $aIds['zones'][0];
        $doAdZoneAssoc->ad_id   = $aIds['banners'][0];
        $doAdZoneAssoc->delete();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetZoneLinkedAds($aIds['zones'][0]), $cachedData3);
        $this->oDeliveryCacheCommon->invalidateZoneLinkedAdsCache($aIds['zones'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetZoneLinkedAds($aIds['zones'][0]), $cachedData3);
    }


    /**
     * Method tests invalidateGetZoneInfoCache method
     */
    function test_invalidateGetZoneInfoCache() {
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetZoneInfo($aIds['zones'][0]);
        // Change zone
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->get($aIds['zones'][0]);
        $doZone->zonename = 'new name';
        $doZone->update();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetZoneInfo($aIds['zones'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetZoneInfoCache($aIds['zones'][0]);
        // Now expect changes in cache
        $cachedData2 = MAX_cacheGetZoneInfo($aIds['zones'][0]);
        $this->assertNotEqual($cachedData2, $cachedData);
    }

    /**
     * Method tests invalidateGetCreativeCache method
     */
    function test_invalidateGetCreativeCache() {
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetCreative($aIds['images'][0]);
        // Change something in image
        $doImage = OA_Dal::factoryDO('images');
        $doImage->get($aIds['images'][0]);
        $doImage->contents = 'new content';
        $doImage->update();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetCreative($aIds['images'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetCreativeCache($aIds['images'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetCreative($aIds['images'][0]), $cachedData);
    }

    /**
     * Method tests invalidateGetTrackerCache method
     */
    function test_invalidateGetTrackerCache(){
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetTracker($aIds['tracker'][0]);
        // Do some changes in tracker
        $doTracker = OA_Dal::factoryDO('trackers');
        $doTracker->get($aIds['trackers'][0]);
        $doTracker->description = 'new description';
        $doTracker->update();
        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetTracker($aIds['tracker'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetTrackerCache($aIds['trackers'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetTracker($aIds['trackers'][0]), $cachedData);
    }

    /**
     * Method tests invalidateGetTrackerVariablesCache method
     */
    function test_invalidateGetTrackerVariablesCache(){
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetTrackerVariables($aIds['tracker'][0]);
        // Add new variable to the tracker
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $aIds['trackers'][0];
        DataGenerator::generateOne($doVariables);

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetTrackerVariables($aIds['tracker'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetTrackerVariablesCache($aIds['trackers'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetTrackerVariables($aIds['trackers'][0]), $cachedData);
    }

    /**
     * Method tests invalidateCheckIfMaintenanceShouldRunCache method
     */
    function test_invalidateCheckIfMaintenanceShouldRunCache(){
        $interval    = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] * 60;
        $delay       = intval(($GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'] / 12) * 60);

        // Set value for maintenace_timestamp that maintenace should run now
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name  = 'maintenance_timestamp';
        $doAppVar->value = MAX_commonGetTimeNow()-2*$interval;
        $doAppVar->insert();

        $cachedData = MAX_cacheCheckIfMaintenanceShouldRun();

        // Set value for maintenace_timestamp that maintenace shouldn't be run
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name  = 'maintenance_timestamp';
        $doAppVar->value = MAX_commonGetTimeNow()+$delay+1;
        $doAppVar->update();

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheCheckIfMaintenanceShouldRun(), $cachedData);
        $this->oDeliveryCacheCommon->invalidateCheckIfMaintenanceShouldRunCache();
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheCheckIfMaintenanceShouldRun(), $cachedData);
    }

    /**
     * Method tests invalidateGetChannelLimitationsCache method
     */
    function test_invalidateGetChannelLimitationsCache(){
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = MAX_cacheGetChannelLimitations($aIds['channel'][0]);

        // Change channel data
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->get($aIds['channel'][0]);
        $doChannel->acl_plugins = 'new value';
        $doChannel->update();

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetChannelLimitations($aIds['channel'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetChannelLimitationsCache($aIds['channel'][0]);
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetChannelLimitations($aIds['channel'][0]), $cachedData);
    }

    /**
     * Method tests invalidateGetGoogleJavaScriptCache method
     */
    function test_invalidateGetGoogleJavaScriptCache(){
        $cachedData = MAX_cacheGetGoogleJavaScript();

        $currentClick = $GLOBALS['_MAX']['CONF']['file']['click'];
        $GLOBALS['_MAX']['CONF']['file']['click'] = 'newclick.php';

        // Expect no changes in cache
        $this->assertEqual(MAX_cacheGetGoogleJavaScript(), $cachedData);
        $this->oDeliveryCacheCommon->invalidateGetGoogleJavaScriptCache();
        // Now expect changes in cache
        $this->assertNotEqual(MAX_cacheGetGoogleJavaScript(), $cachedData);

        $GLOBALS['_MAX']['CONF']['file']['click'] = $currentClick;
    }

    /**
     * Method tests invalidatePublisherZonesCache method
     */
    function test_invalidatePublisherZonesCache() {
        $aIds = $this->_createTestData();
        $this->_createTestCacheFiles($aIds);

        $cachedData = OA_cacheGetPublisherZones($aIds['affiliates'][0]);
        // Change zone
        $doZone = OA_Dal::factoryDO('zones');
        $doZone->get($aIds['zones'][0]);
        $doZone->zonename = 'new name';
        $doZone->update();
        // Expect no changes in cache
        $this->assertEqual(OA_cacheGetPublisherZones($aIds['affiliates'][0]), $cachedData);
        $this->oDeliveryCacheCommon->invalidatePublisherZonesCache($aIds['zones'][0]);
        // Now expect changes in cache
        $cachedData2 = OA_cacheGetPublisherZones($aIds['affiliates'][0]);
        $this->assertNotEqual($cachedData2, $cachedData);

        // Delete zone
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zoneid = $aIds['zones'][0];
        $doZones->delete();
        // Expect no changes in cache
        $this->assertEqual(OA_cacheGetPublisherZones($aIds['affiliates'][0]), $cachedData2);
        $this->oDeliveryCacheCommon->invalidatePublisherZonesCache($aIds['affiliates'][0]);
        // Now expect changes in cache
        $cachedData3 = OA_cacheGetPublisherZones($aIds['affiliates'][0]);
        $this->assertNotEqual($cachedData3, $cachedData2);
    }
}
?>