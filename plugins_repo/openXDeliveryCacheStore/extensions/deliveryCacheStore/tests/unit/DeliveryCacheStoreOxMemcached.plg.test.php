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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/oxMemcached/oxMemcached.delivery.php';
require_once dirname(dirname(dirname(__FILE__))) . '/oxMemcached/oxMemcached.class.php';


/**
 * A class for testing the Plugins_DeliveryCacheStore_oxMemcached_oxMemcached class.
 *
 * To run tests of memcached plugin you have to create [oxMemcached] section in test.conf
 * and set memcachedServers parameter in this new section
 * Don't forget to run memcached first!
 *
 * e.g.
 * [oxMemcached]
 * memcachedServers = 127.0.0.1:11211  ; If you run memcached server on same host and default port
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPlugins_DeliveryCacheStore_oxMemcached_oxMemcached extends UnitTestCase
{
    /**
     * Memcached connection
     */
    var $oMemcached;

    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->UnitTestCase();
        _oxMemcached_MemcachedInit();
        $this->oMemcached = $GLOBALS['OA_Delivery_Cache']['MemcachedObject'];
    }

    /**
     * Check if tests can be runned
     */
    function skip()
    {
        // Skip tests if there is no Memcached connection
        $this->skipUnless(
            isset($this->oMemcached),
            "There are no memcached settings"
        );

        $this->skipIf(
            (@$this->oMemcached->getVersion()=== false),
            "There is no connection to the memcached server(s)"
        );
    }

    /**
     * Tests the delivery part of this plugin.
     */

    /**
     * A method to test the Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheRetrieve
     */
    function Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheRetrieve() {
        $content = array( 'string' => 'teststring', 'num' => -1);
        $name = 'testname';
        $filename = OA_Delivery_Cache_buildFileName($name);
        Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore($filename, $content);

        // Test retriving new created file
        $result = Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheRetrieve($filename, $name);
        $this->assertEqual($result, $content);

        $oPlgOxMemcached= new Plugins_DeliveryCacheStore_oxMemcached_oxMemcached('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        $oPlgOxMemcached->deleteCacheFile($filename);
    }

    /**
     * A method to test the Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore
     */
    function test_Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore() {
        $content = array( 'string' => 'teststring', 'num' => -1, 'file' => "\x02\x00\xff\xea\x01");
        $name = 'testname';
        $filename = OA_Delivery_Cache_buildFileName($filename);

        Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore($filename, $content);

        $cacheContent = $this->oMemcached->get($filename);
        $this->assertEqual($content, unserialize($cacheContent));

        // Test for new content (null)
        $content = null;
        $cacheContent = Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore($filename, $content);

        $cacheContent = $this->oMemcached->get($filename);
        $this->assertEqual(serialize($content), $cacheContent);

        $oPlgOxMemcached= new Plugins_DeliveryCacheStore_oxMemcached_oxMemcached('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        $oPlgOxMemcached->deleteCacheFile($filename);
    }

    /**
     * Tests the class part of this plugin.
     */

    /**
     * A method to test the _deleteCacheFile method
     */
    function test__deleteCacheFile() {
        $oPlgOxMemcached= new Plugins_DeliveryCacheStore_oxMemcached_oxMemcached('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        $content = NULL;
        $name = 'test';
        $filename = OA_Delivery_Cache_buildFileName($name);

        Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore($filename, $content);
        $cacheContent = $this->oMemcached->get($filename);
        $this->assertEqual(serialize($content), $cacheContent);

        $oPlgOxMemcached->_deleteCacheFile($filename);
        $this->assertFalse(file_exists($cachefile));
        $this->assertFalse($this->oMemcached->get($filename));
    }

    /**
     * A method to test the _deleteAll mathod
     */
    function test__deleteAll() {
        $oPlgOxMemcached= new Plugins_DeliveryCacheStore_oxMemcached_oxMemcached('deliveryCacheStore', 'oxMemcached', 'oxMemcached');
        $content = NULL;
        $name = 'test';
        $filename = OA_Delivery_Cache_buildFileName($name);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;

        Plugin_deliveryCacheStore_oxMemcached_oxMemcached_Delivery_cacheStore($filename, $content);
        $cacheContent = $this->oMemcached->get($filename);
        $this->assertEqual(serialize($content), $cacheContent);

        $oPlgOxMemcached->_deleteAll();
        $this->assertFalse(file_exists($cachefile));
        $this->assertFalse($this->oMemcached->get($filename));
    }
}
?>