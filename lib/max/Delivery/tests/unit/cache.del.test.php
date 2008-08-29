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

require_once MAX_PATH . '/lib/max/Delivery/cache.php';

/**
 * A class for testing the cache.php functions.
 *
 * To run all tests installed delivery cache storage plugin is required.
 * Don't forget to set plugin enabled in test.conf.php
 * if [delivery] cacheStorePlugin = Extension/Group/Component   (e.g. deliveryCacheStore:oxCacheFile:oxCacheFile)
 * add to [pluginGroupComponents] entry: Group=1        (e.g. oxCacheFile=1)
 * 
 * If you want to run tests for memcached plugin you have to set additionally set 
 * memcachedServers in [delivery] section in test.conf
 * e.g.
 * [delivery]
 * memcachedServers = 127.0.0.1:11211  ; If you run memcached server on same host and default port
 * 
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 *
 */
class test_DeliveryCommon extends UnitTestCase
{
    
    /**
     * delivery cache store plugin
     * Used to clear cache
     *
     * @var Plugins_DeliveryCacheStore
     */
    var $oDeliveryCacheStore;
    
    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->UnitTestCase();
        $this->oDeliveryCacheStore = &OX_Component::factoryByComponentIdentifier($GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);
    }
    
    /**
     * Tests OA_Delivery_Cache_fetch function
     */
    function test_OA_Delivery_Cache_fetch() {
        // Just to show message that some tests was skipped
        // this not interrupt tests 
        $this->skipIf( ($this->oDeliveryCacheStore === false),
            "Some tests was skipped because there is no cache store plugin"
        );
        // Run test only if cache storage Plugin is enabled and working
        if ($this->oDeliveryCacheStore !== false) {
            $name = 'test';
            $this->oDeliveryCacheStore->deleteCacheFile($name);

            // Test fetch for non existing entry
            $this->assertFalse(OA_Delivery_Cache_fetch($name));

            $content = array( 'string' => 'teststring', 'num' => -1);
            OA_Delivery_Cache_store($name, $content);

            // Test existing entry
            $this->assertEqual($content, OA_Delivery_Cache_fetch($name));

            // Change cache time using cache storage interface 
            $filename = OA_Delivery_Cache_buildFileName($name);
            $aCacheVar = OX_Delivery_Common_hook( 'cacheRetrieve', array($filename), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);
            $aCacheVar['cache_time'] = MAX_commonGetTimeNow() - $GLOBALS['OA_Delivery_Cache']['expiry'] - 1;
            OX_Delivery_Common_hook( 'cacheStore', array($filename, $aCacheVar), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);

            // Test expired cache
            $this->assertFalse(OA_Delivery_Cache_fetch($name));

            // Test if second call recive data - "permament cache" option
            $this->assertEqual($content, OA_Delivery_Cache_fetch($name));

            // Test if cache is expired for given expire time
            OA_Delivery_Cache_store($name, $content, false, MAX_commonGetTimeNow()-5);
            // Test expired cache
            $this->assertFalse(OA_Delivery_Cache_fetch($name));

            $this->oDeliveryCacheStore->deleteCacheFile($name);
        }
    }
    
    /**
     * Tests OA_Delivery_Cache_store function
     */
    function test_OA_Delivery_Cache_store() {
        // Run test only if cache storage Plugin is enabled and working
        if ($this->oDeliveryCacheStore !== false) {
            $name = 'test';
            $this->oDeliveryCacheStore->deleteCacheFile($name);

            $content = array( 'string' => 'teststring', 'num' => -1);
            OA_Delivery_Cache_store($name, $content);

            // Get cache using cache storage interface
            $filename = OA_Delivery_Cache_buildFileName($name);
            $aCacheVar = OX_Delivery_Common_hook( 'cacheRetrieve', array($filename), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);
            $this->assertTrue(is_array($aCacheVar));
            $this->assertEqual($content, $aCacheVar['cache_contents']);
            $this->assertEqual($name, $aCacheVar['cache_name']);
            $this->assertNotNull($aCacheVar['cache_time']);
            $this->assertTrue($aCacheVar['cache_time'] <= MAX_commonGetTimeNow());
            $this->assertTrue(array_key_exists('cache_expire', $aCacheVar));
            $this->assertNull($aCacheVar['cache_expire']);

            $expireTime = MAX_commonGetTimeNow()+1200;
            $content = array( 'string' => 'teststring2', 'num' => -23, 'specialChars' => addslashes(serialize(("\x00\xff\x02\xea"))));
            OA_Delivery_Cache_store($name, $content, false, $expireTime);
            $aCacheVar = OX_Delivery_Common_hook( 'cacheRetrieve', array($filename), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);
            $this->assertTrue(is_array($aCacheVar));
            $this->assertEqual(4, count($aCacheVar));
            $this->assertEqual($content, $aCacheVar['cache_contents']);
            $this->assertEqual($expireTime, $aCacheVar['cache_expire']);

            $this->oDeliveryCacheStore->deleteCacheFile($name);
        }
    }
    
    /**
     * Tests OA_Delivery_Cache_store function
     */
    function test_OA_Delivery_Cache_store_return() {
        // Run test only if cache storage Plugin is enabled and working
        if ($this->oDeliveryCacheStore !== false) {
            $name = 'test';
            $this->oDeliveryCacheStore->deleteCacheFile($name);

            $content = array( 'string' => 'teststring', 'num' => -1);
            $content2 = array( 'string' => 'teststring2', 'num' => -2);
            $result = OA_Delivery_Cache_store_return($name, $content);
            $this->assertEqual($content, $result);

            // manipulate on cache entry, to change cache_contents
            $filename = OA_Delivery_Cache_buildFileName($name);
            $aCacheVar = OX_Delivery_Common_hook( 'cacheRetrieve', array($filename), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);
            $aCacheVar['cache_contents'] = $content2;
            OX_Delivery_Common_hook( 'cacheStore', array($filename, $aCacheVar), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);

            // Tests if return cached contents
            $result = OA_Delivery_Cache_store_return($name, OA_DELIVERY_CACHE_FUNCTION_ERROR);
            $this->assertEqual($content2, $result);

            // Now tests if store new content
            $result = OA_Delivery_Cache_store_return($name, $content);
            $this->assertEqual($content, $result);
            $aCacheVar = OX_Delivery_Common_hook( 'cacheRetrieve', array($filename), 
                            $GLOBALS['_MAX']['CONF']['delivery']['cacheStorePlugin']);
            $this->assertEqual($content, $aCacheVar['cache_contents']);
        }
    }
    
    /**
     * Tests OA_Delivery_Cache_buildFileName function
     */
    function test_OA_Delivery_Cache_buildFileName() {
        $filename = 'testname';
        $expected = $GLOBALS['OA_Delivery_Cache']['prefix'].md5($filename).'.php';
        $result = OA_Delivery_Cache_buildFileName($filename);
        $this->assertEqual($result, $expected);
    }
    
    /**
     * Tests test_OA_Delivery_Cache_getName function
     */
    function test_OA_Delivery_Cache_getName() {
        $param1 = 5;
        $param2 = 'text';
        $result = OA_Delivery_Cache_getName('MAX_cacheGetTestFunction', $param1, $param2);
        $expected = "testfunction^5^text@".$GLOBALS['OA_Delivery_Cache']['host'];
        $this->assertEqual($result, $expected);
    }
}
?>