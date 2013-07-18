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

require_once dirname(__FILE__) . '/../../../../../../var/config.php';
require_once dirname(__FILE__) . '/../../Cache.php';

class OX_oxMarket_Common_CacheTest extends UnitTestCase 
{
    function testLifeTime() 
    {
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket', 1);
        $oCache->setFileNameProtection(false);
        $oCache->clear();
        
        // File not exist
        $result = $oCache->load(false);
        $this->assertFalse($result);
        
        $data = 'test';
        $oCache->save($data);
        
        // File exists
        $result = $oCache->load(false);
        $this->assertEqual($result, $data);
        
        // Wait 3 seconds and set cache lifetime to 1 second
        sleep(3);
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket', 1);
        $oCache->setFileNameProtection(false);
        
        // File exists but is not valid
        $result = $oCache->load(false);
        $this->assertFalse($result);
        
        // Try to retrive cache ignoring lifetime
        $result = $oCache->load(true);
        $this->assertEqual($result, $data);
    }
    
    function testCacheDir() 
    {
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket');
        $oCache->clear();
        
        $result = $oCache->load(true);
        $this->assertFalse($result);
        
        $newCacheDir = dirname(__FILE__) . '/../data/'; 
        
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket', null, $newCacheDir);
        $oCache->setFileNameProtection(false);
        
        $result = $oCache->load(true);
        $this->assertEqual('test', $result);
    }
}

