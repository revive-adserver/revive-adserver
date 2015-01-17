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
require_once dirname(dirname(dirname(__FILE__))) . '/oxCacheFile/oxCacheFile.delivery.php';
require_once dirname(dirname(dirname(__FILE__))) . '/oxCacheFile/oxCacheFile.class.php';

/**
 * A class for testing the Plugins_DeliveryCacheStore_OxCacheFile_OxCacheFile class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryCacheStore_oxCacheFile_oxCacheFile extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Tests the delivery part of this plugin.
     */

    /**
     * A method to test the Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheRetrieve
     */
    function test_Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheRetrieve() {
        $content = array( 'string' => 'teststring', 'num' => -1);
        $name = 'testname';
        $filename = OA_Delivery_Cache_buildFileName($name);
        Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore($filename,$content);

        // Test reading new created file
        $result = Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheRetrieve($filename, $name);
        $this->assertEqual($result, $content);

        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_oxCacheFile_oxCacheFile('deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
        $oPlgOxCacheFile->deleteCacheFile($filename);
    }

    /**
     * A method to test the Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore
     */
    function test_Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore() {
        $content = array( 'string' => 'teststring', 'num' => -1);
        $name = 'testname';
        $filename = OA_Delivery_Cache_buildFileName($filename);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;

        Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore($filename, $content);
        // Check if file exists
        $this->assertTrue(file_exists($cachefile));

        $aFileContent = file($cachefile);
        $this->assertEqual(count($aFileContent), 10);
        // test several lines (what if var_export gives different result in new version php?)
        $this->assertEqual(trim($aFileContent[2]), '$cache_contents   = array (');
        $this->assertEqual(trim($aFileContent[3]), "'string' => 'teststring',");
        $this->assertEqual(trim($aFileContent[4]), "'num' => -1,");
        $this->assertEqual(trim($aFileContent[7]), '$cache_complete   = true;');

        $content = null;
        Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore($filename, $content);
        // Check if file exists
        $this->assertTrue(file_exists($cachefile));

        $aFileContent = file($cachefile);
        $this->assertEqual(count($aFileContent), 7);
        $this->assertEqual(trim($aFileContent[2]), '$cache_contents   = NULL;');
        $this->assertEqual(trim($aFileContent[4]), '$cache_complete   = true;');

        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_oxCacheFile_oxCacheFile('deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
        $oPlgOxCacheFile->deleteCacheFile($filename);
    }

    /**
     * Tests the class part of this plugin.
     */

    /**
     * A method to test the _deleteCacheFile method
     */
    function test__deleteCacheFile() {
        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_oxCacheFile_oxCacheFile('deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
        $content = NULL;
        $name = 'test';
        $filename = OA_Delivery_Cache_buildFileName($name);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;

        Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore($filename, $content);
        $this->assertTrue(file_exists($cachefile));
        $oPlgOxCacheFile->_deleteCacheFile($filename);
        $this->assertFalse(file_exists($cachefile));
    }

    /**
     * A method to test the _deleteAll mathod
     */
    function test__deleteAll() {
        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_oxCacheFile_oxCacheFile('deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
        $content = NULL;
        $name = 'test';
        $filename = OA_Delivery_Cache_buildFileName($name);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;

        Plugin_deliveryCacheStore_oxCacheFile_oxCacheFile_Delivery_cacheStore($filename, $content);
        $this->assertTrue(file_exists($cachefile));
        $oPlgOxCacheFile->_deleteAll();
        $this->assertFalse(file_exists($cachefile));
    }
}
?>