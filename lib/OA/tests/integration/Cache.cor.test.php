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

require_once MAX_PATH.'/lib/OA/Cache.php';

/**
 * A class for testing the OX_ManagerPlugin class.
 *
 * @package Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 * @subpackage TestSuite
 */
class Test_OA_Cache extends UnitTestCase
{
    var $aData;

    /**
     * The constructor method.
     */
    function Test_OA_Cache()
    {
        $this->UnitTestCase();
    }

    function setup()
    {
        $this->aData = $this->_createTestArray();
        $this->serverSave = $_SERVER['HTTP_HOST'];
        $_SERVER['HTTP_HOST'] = 'servername';
    }

    function teardown()
    {
        $this->aData = null;
        $_SERVER['HTTP_HOST'] = $this->serverSave;
    }

    function test_Cache()
    {
        // Default never expire
        $oCache = new OA_Cache('testId', 'testGroup');

        $this->assertEqual($oCache->id,'testId');
        $this->assertEqual($oCache->group,'servername_testGroup');
        $this->assertEqual($oCache->oCache->_cacheDir,MAX_PATH . '/var/cache/');
        $this->assertIsA($oCache->oCache,'Cache_Lite');
        $this->assertNull($oCache->oCache->_lifeTime);
        $this->assertEqual($oCache->oCache->_readControlType,'md5');
        //$this->assertTrue($oCache->oCache->_dontCacheWhenTheResultIsFalse);
        $this->assertTrue($oCache->oCache->_automaticSerialization);

        // test that the test data passes first
        $this->_assertTestArray($this->aData);

        // Test no validity check
        $this->assertTrue($oCache->save($this->aData));
        $aCache = $oCache->load(true);
        $this->_assertTestArray($aCache);

        // Test validity check ... requires some test setup (lifetime, refreshdate)
        //$aCache = $oCache->load(false);
        //$this->_assertTestArray($aCache);

        $this->assertTrue($oCache->clear());
        $aCache = $oCache->load();
        $this->assertTrue(empty($aCache));

        // Test lifeTime
        $oCache = new OA_Cache('testId', 'testGroup', 10);
        $this->assertIsA($oCache->oCache,'Cache_Lite');
        $this->assertEqual($oCache->oCache->_lifeTime, 10);

    }

    function _createTestArray()
    {
        $aArray = array(
                        'testString'=>'abcdefghijklmnopqrstuvwxyz01234567890',
                        'testInteger'=>1234567890,
                        'testFloat'=>1234567890.0987654321,
                        'testBinary'=>decbin(1234567890),
                        'testHex'=>dechex(1234567890),
                        'testDateTime'=>getdate(),
                        'testUTF8'=>utf8_encode('abcdefghijklmnopqrstuvwxyz01234567890'),
                        );
        $aResult[0]          = $aArray;
        $aResult[0][0]       = $aArray;
        $aResult[0][1]       = $aArray;
        $aResult[0][1][0]    = $aArray;
        return $aResult;
    }

    function _assertTestArray($aResult)
    {
        $elems = count($this->aData[0]);

        $this->assertEqual(count($aResult),1);
        $this->assertEqual(count($aResult[0]),9);
        $this->assertEqual(count($aResult[0][0]),7);
        $this->assertEqual(count($aResult[0][1]),8);
        $this->assertEqual(count($aResult[0][1][0]),7);

        for ($i=0;$i<4;$i++)
        {
            switch ($i)
            {
                case 0:
                    $aExpect = $this->aData[0];
                    $aActual = $aResult[0];
                    $msg     = 'IDX [0] : ';
                    break;
                case 1:
                    $aExpect = $this->aData[0][0];
                    $aActual = $aResult[0][0];
                    $msg     = 'IDX [0][0] : ';
                    break;
                case 2:
                    $aExpect = $this->aData[0][1];
                    $aActual = $aResult[0][1];
                    $msg     = 'IDX [0][1] : ';
                    break;
                case 3:
                    $aExpect = $this->aData[0][1][0];
                    $aActual = $aResult[0][1][0];
                    $msg     = 'IDX [0][1][0] : ';
                    break;
            }

            foreach ($aExpect AS $key => $val)
            {
                $this->assertEqual($aActual[$key], $val, $msg.' Expectecd '.$val.' got', $aActual[$key].' key '.$key);
            }
        }
    }
    
    function testLifeTime() 
    {
        $oCache = new OA_Cache('test', 'oxpTestCache', 1);
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
        $oCache = new OA_Cache('test', 'oxpTestCache', 1);
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
        $oCache = new OA_Cache('test', 'oxpTestCache');
        $oCache->clear();
        
        $result = $oCache->load(true);
        $this->assertFalse($result);
        
        $newCacheDir = dirname(__FILE__) . '/../data/'; 
        
        $oCache = new OA_Cache('test', 'oxpTestCache', null, $newCacheDir);
        $oCache->setFileNameProtection(false);
        
        $result = $oCache->load(true);
        $this->assertEqual('test', $result);
    }
}

?>
