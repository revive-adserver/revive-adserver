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

require_once MAX_PATH . '/init-delivery-parse.php';

/**
 * A class for testing the OA_ConfParse class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_ConfParse extends UnitTestCase
{
    /**
     * A method to test the getConfigVersion() method.
     */
    public function test_parseDeliveryIniFile()
    {
        $host = OX_getHostName();

        copy(MAX_PATH . '/lib/OA/tests/data/test.demo.conf.php', MAX_PATH . '/var/' . $host . '.test.demo.conf.php');
        copy(MAX_PATH . '/lib/OA/tests/data/test.real.conf.php', MAX_PATH . '/var/test.real.conf.php');

        $result = parseDeliveryIniFile('', 'test.demo');

        $this->assertIsA($result, 'array');
        $this->assertTrue(isset($result['database']));
        $this->assertEqual($result['database']['username'], 'demo_user');
        $this->assertEqual($result['database']['password'], 'demo_pass');
        $this->assertEqual($result['database']['name'], 'demo_name');
        $this->assertTrue(isset($result['real']));
        $this->assertEqual($result['real']['key1'], 'val1');
        $this->assertEqual($result['real']['key2'], 'val2');

        @unlink(MAX_PATH . '/var/' . $host . '.test.demo.conf.php');
        @unlink(MAX_PATH . '/var/test.real.conf.php');
    }

    public function test_OX_getHostName()
    {
        $aServer = $_SERVER;

        $aTests = [
            // [HTTP_HOST, SERVER_NAME, expected]
            ['www.example.com', 'server.example.com', 'www.example.com'],
            ['www.example.com:8080', null, 'www.example.com'],
            ['Revive-Main_1', null, 'Revive-Main_1'],
            ['127.0.0.1:80', null, '127.0.0.1'],
            ['example.com.', null, 'example.com.'],
            ['../../www/admin/test', 'server.example.com', 'server.example.com'],
            ['..', 'server.example.com', 'server.example.com'],
            ['a..b', 'server.example.com', 'server.example.com'],
            ['.example.com', 'server.example.com', 'server.example.com'],
            ['a/b', null, ''],
            ['a\\b', null, ''],
            ["example.com\n", null, ''],
            ["example.com\0.php", null, ''],
            [null, 'server.example.com:8080', 'server.example.com'],
            [null, '../x', ''],
            [null, null, ''],
        ];

        foreach ($aTests as [$httpHost, $serverName, $expected]) {
            unset($_SERVER['HTTP_HOST'], $_SERVER['SERVER_NAME']);

            if (null !== $httpHost) {
                $_SERVER['HTTP_HOST'] = $httpHost;
            }
            if (null !== $serverName) {
                $_SERVER['SERVER_NAME'] = $serverName;
            }

            $this->assertIdentical(OX_getHostName(), $expected, var_export($httpHost, true) . ' / ' . var_export($serverName, true) . ': %s');
        }

        $_SERVER = $aServer;
    }

    /**
     * test to ensure that special characters
     * are written and read correctly
     * IniCommented config class should quote all special chars
     * except backslash and single quote
     *
     * note: parse_ini_file() will break array on double quote
     *
     */
    public function test_iniFile()
    {
        $test = array_map('chr', range(0, 255));
        $test[] = '${var}';
        $test[] = '${{';
        $test[] = 'à'; // U+00E0 Latin Small Letter A with Grave
        $test[] = 'ァ'; // U+30A1 Katakana Letter Small A

        foreach (['IniFile', 'IniCommented'] as $container) {
            foreach ($test as $k => $string) {
                $aIni = [];
                $aIni['test1'][$k] = 'test' . $string;
                $aIni['test2'][$k] = $string . 'test';
                $aIni['test3'][$k] = 'te' . $string . 'st';
                $aIni['test4'][$k] = 'te\\' . $string . 'st';
                $ini = MAX_PATH . '/var/test_' . $k . '.ini';
                $oConfig = new Config();
                $oConfig->parseConfig($aIni, 'phpArray');
                $this->assertTrue($oConfig->writeConfig($ini, $container));

                $aResult = @parse_ini_file($ini, true);

                $this->assertEqual($aResult, $aIni, str_replace('%', '%%', "ERROR {$container}: {$k} => {$string}"));
                @unlink($ini);
            }
        }
    }
}
