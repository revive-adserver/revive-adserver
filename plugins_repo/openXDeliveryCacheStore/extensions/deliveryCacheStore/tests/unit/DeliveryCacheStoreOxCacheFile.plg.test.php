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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/OxCacheFile/OxCacheFile.delivery.php';
require_once dirname(dirname(dirname(__FILE__))) . '/OxCacheFile/OxCacheFile.class.php';

/**
 * A class for testing the Plugins_DeliveryCacheStore_OxCacheFile_OxCacheFile class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPlugins_DeliveryCacheStore_OxCacheFile_OxCacheFile extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->UnitTestCase();
    }
    
    /** 
     * Tests the delivery part of this plugin.
     */
    
    /**
     * A method to test the Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheRetrieve 
     */
    function test_Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheRetrieve() {
        $content = array( 'string' => 'teststring', 'num' => -1);
        $name = 'testname';
        $filename = OA_Delivery_Cache_buildFileName($name);
        Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore($filename,$content);
        
        // Test reading new created file
        $result = Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheRetrieve($filename, $name);
        $this->assertEqual($result, $content);
        
        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_OxCacheFile_OxCacheFile('deliveryCacheStore', 'OxCacheFile', 'OxCacheFile');
        $oPlgOxCacheFile->deleteCacheFile($filename);
    }
    
    /**
     * A method to test the Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore 
     */
    function test_Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore() {
        $content = array( 'string' => 'teststring', 'num' => -1);
        $name = 'testname';
        $filename = OA_Delivery_Cache_buildFileName($filename);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;
        
        Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore($filename, $content);
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
        Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore($filename, $content);
        // Check if file exists
        $this->assertTrue(file_exists($cachefile));
        
        $aFileContent = file($cachefile);
        $this->assertEqual(count($aFileContent), 7);
        $this->assertEqual(trim($aFileContent[2]), '$cache_contents   = NULL;');
        $this->assertEqual(trim($aFileContent[4]), '$cache_complete   = true;');

        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_OxCacheFile_OxCacheFile('deliveryCacheStore', 'OxCacheFile', 'OxCacheFile');
        $oPlgOxCacheFile->deleteCacheFile($filename);
    }
    
    /** 
     * Tests the class part of this plugin.
     */
    
    /**
     * A method to test the _deleteCacheFile method
     */
    function test__deleteCacheFile() {
        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_OxCacheFile_OxCacheFile('deliveryCacheStore', 'OxCacheFile', 'OxCacheFile');
        $content = NULL;
        $name = 'test';
        $filename = OA_Delivery_Cache_buildFileName($name);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;

        Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore($filename, $content);
        $this->assertTrue(file_exists($cachefile));
        $oPlgOxCacheFile->_deleteCacheFile($filename);
        $this->assertFalse(file_exists($cachefile));
    }
    
    /**
     * A method to test the _deleteAll mathod 
     */
    function test__deleteAll() {
        $oPlgOxCacheFile = new Plugins_DeliveryCacheStore_OxCacheFile_OxCacheFile('deliveryCacheStore', 'OxCacheFile', 'OxCacheFile');
        $content = NULL;
        $name = 'test';
        $filename = OA_Delivery_Cache_buildFileName($name);
        $cachefile = $GLOBALS['OA_Delivery_Cache']['path'].$filename;
        
        Plugin_deliveryCacheStore_OxCacheFile_OxCacheFile_Delivery_cacheStore($filename, $content);
        $this->assertTrue(file_exists($cachefile));
        $oPlgOxCacheFile->_deleteAll();
        $this->assertFalse(file_exists($cachefile));
    }
}
?>