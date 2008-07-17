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

require_once MAX_PATH . '/lib/max/Delivery/image.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing the flash.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class Test_OA_Dal_DeliveryDB_Image extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_DeliveryDB_Image()
    {
        $this->UnitTestCase();

        // Make sure we don't get a Status: header, but a HTTP/1.0 instead
        $GLOBALS['_MAX']['CONF']['delivery']['cgiForceStatusHeader'] = false;
        $_SERVER["SERVER_PROTOCOL"] = 'HTTP/1.0';

        MAX_Dal_Delivery_Include();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testImageServeUTC()
    {
        $this->_testImageServe('UTC');
    }
    function testImageServeCEST()
    {
        $this->_testImageServe('CET');
    }
    function testImageServeEST()
    {
        $this->_testImageServe('EST');
    }

    function _testImageServe($timeZone)
    {
        OA_setTimeZone($timeZone);

        $fileName = 'tz_test.gif';

        $doImages = OA_Dal::factoryDO('images');
        $doImages->filename = $fileName;
        $doImages->contents = '';
        $this->assertTrue(DataGenerator::generateOne($doImages));

        $now = time();
        $this->assertTrue($timeZone == 'UTC' || date('Z', $now), 'Time zone not correctly set');

        // Simulate delivery
        OA_setTimeZoneUTC();
        $aCreative = OA_Dal_Delivery_getCreative($fileName);
        $this->assertTrue($aCreative);

        // Serve with no If-Modified-Since header
        unset($GLOBALS['_HEADERS']);
        unset($_SERVER['HTTP_IF_MODIFIED_SINCE']);
        MAX_imageServe($aCreative, $fileName, 'gif');
        if ($this->assertEqual(count($GLOBALS['_HEADERS']), 2, 'Mismatching headers with '.$timeZone)) {
            $this->assertPattern('/^Last-Modified: /i', $GLOBALS['_HEADERS'][0]);
            $this->assertPattern('/^Content-Type: /i', $GLOBALS['_HEADERS'][1]);
        }

        // 1-day old If-Modified-Since header
        unset($GLOBALS['_HEADERS']);
        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = gmdate('D, d M Y H:i:s', $now - 86400).' GMT';
        MAX_imageServe($aCreative, $fileName, 'gif');
        if ($this->assertEqual(count($GLOBALS['_HEADERS']), 2, 'Mismatching headers with '.$timeZone)) {
            $this->assertPattern('/^Last-Modified: /i', $GLOBALS['_HEADERS'][0]);
            $this->assertPattern('/^Content-Type: /i', $GLOBALS['_HEADERS'][1]);
        }

        // 1-day future If-Modified-Since header
        unset($GLOBALS['_HEADERS']);
        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = gmdate('D, d M Y H:i:s', $now + 86400).' GMT';
        MAX_imageServe($aCreative, $fileName, 'gif');
        if ($this->assertEqual(count($GLOBALS['_HEADERS']), 1, 'Mismatching headers with '.$timeZone)) {
            $this->assertPattern('/^HTTP\/1.0 304/i', $GLOBALS['_HEADERS'][0]);
        }

        // 1 minute ago If-Modified-Since header
        unset($GLOBALS['_HEADERS']);
        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = gmdate('D, d M Y H:i:s', $now - 60).' GMT';
        MAX_imageServe($aCreative, $fileName, 'gif');
        if ($this->assertEqual(count($GLOBALS['_HEADERS']), 2, 'Mismatching headers with '.$timeZone)) {
            $this->assertPattern('/^Last-Modified: /i', $GLOBALS['_HEADERS'][0]);
            $this->assertPattern('/^Content-Type: /i', $GLOBALS['_HEADERS'][1]);
        }

        // 1 minute in future If-Modified-Since header
        unset($GLOBALS['_HEADERS']);
        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = gmdate('D, d M Y H:i:s', $now + 60).' GMT';
        MAX_imageServe($aCreative, $fileName, 'gif');
        if ($this->assertEqual(count($GLOBALS['_HEADERS']), 1, 'Mismatching headers with '.$timeZone)) {
            $this->assertPattern('/^HTTP\/1.0 304/i', $GLOBALS['_HEADERS'][0]);
        }
    }
}

?>