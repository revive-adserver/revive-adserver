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
        parent::__construct();
        _oxMemcached_MemcachedInit();
        $this->oMemcached = $GLOBALS['OA_Delivery_Cache']['MemcachedObject'];
    }

    /**
     * Check if tests can be runned
     */
    function _skip()
    {
        // Skip tests if there is no Memcached connection
		if (!isset($this->oMemcached)) {
		    $this->skip("There are no memcached settings");
		    return true;
        }
        if (@$this->oMemcached->getVersion()=== false) {
            $this->skip("There is no connection to the memcached server(s)");
            return true;
        };

        return false;
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
        if ($this->_skip()) {
           return;
        }

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
        if ($this->_skip()) {
           return;
        }

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
        if ($this->_skip()) {
           return;
        }

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
