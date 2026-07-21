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

require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

class LibIoTest extends UnitTestCase
{
    public function test_phpAds_registerGlobalUnslashed()
    {
        unset($GLOBALS['foo']);

        phpAds_registerGlobalUnslashed('foo');
        $this->assertNull($GLOBALS['foo']);

        $_GET['foo'] = 'bar';
        phpAds_registerGlobalUnslashed('foo');
        $this->assertEqual($GLOBALS['foo'], 'bar');

        $_POST['foo'] = 'baz';
        phpAds_registerGlobalUnslashed('foo');
        $this->assertEqual($GLOBALS['foo'], 'baz');

        unset($GLOBALS['foo']);
    }
}
