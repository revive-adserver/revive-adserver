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

require_once MAX_PATH . '/init-parse.php';

class test_init extends UnitTestCase
{
    private const PATH = __DIR__ . '/../data';

    public function test_initParseOk(): void
    {
        $this->assertEqual(['database' => ['password' => 'hi* asd=#!!"£$%&/()']], parseIniFile(self::PATH, 'ok'));
    }

    public function test_initParseMalformed(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->assertNotEqual([], parseIniFile(self::PATH, 'malformed'));
    }
}
