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

class Test_BadLoginLogger extends UnitTestCase
{
    private const PATH = MAX_PATH . '/var/testBadLogin.log';


    public function setUp()
    {
        $this->_setBadLoginLogPath(self::PATH);
    }

    public function tearDown(): void
    {
        unset($_SERVER['SERVER_ADDR']);
        unset($_SERVER['HTTP_CLIENT_IP']);
        unset($_SERVER['HTTP_X_FORWARDED_FOR']);

        $this->_setBadLoginLogPath('');

        $this->_deleteBadLoginLogFileForTest();
    }

    public function _setBadLoginLogPath($path)
    {
        $GLOBALS['_MAX']['CONF']['security']['badLoginLogPath'] = $path;
    }

    private function _deleteBadLoginLogFileForTest()
    {
        @unlink(self::PATH);
    }

    private function _getBadLoginLogFileContent()
    {
        return file_get_contents(self::PATH);
    }

    public function test_badLogin_log()
    {
        // Will not log: no good headers, nor REMOTE_ADDR
        $_SERVER['HTTP_CLIENT_IP'] = 'foo';
        (new \RV\Auth\BadLoginLogger())->log();

        // Log REMOTE_ADDR
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        (new \RV\Auth\BadLoginLogger())->log();

        // Log HTTP_CLIENT_IP
        $_SERVER['HTTP_CLIENT_IP'] = '8.8.8.8';
        (new \RV\Auth\BadLoginLogger())->log();

        // Log REMOTE_ADDR as HTTP_CLIENT_IP is private
        $_SERVER['REMOTE_ADDR'] = '7.7.7.7';
        $_SERVER['HTTP_CLIENT_IP'] = '127.0.0.1';
        (new \RV\Auth\BadLoginLogger())->log();

        // Log HTTP_CLIENT_IP
        $_SERVER['HTTP_CLIENT_IP'] = '9.9.9.9';
        (new \RV\Auth\BadLoginLogger())->log();

        // Log the leftmost non-private IP from HTTP_X_FORWARDED_FOR
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '192.168.0.1,1.1.1.1,2.2.2.2';
        (new \RV\Auth\BadLoginLogger())->log();

        $lines = explode("\n", $this->_getBadLoginLogFileContent());

        $this->assertPattern('#^\d+: 127\.0\.0\.1$#', $lines[0]);
        $this->assertPattern('#^\d+: 8\.8\.8\.8$#', $lines[1]);
        $this->assertPattern('#^\d+: 7\.7\.7\.7$#', $lines[2]);
        $this->assertPattern('#^\d+: 9\.9\.9\.9$#', $lines[3]);
        $this->assertPattern('#^\d+: 1\.1\.1\.1$#', $lines[4]);
    }
}
