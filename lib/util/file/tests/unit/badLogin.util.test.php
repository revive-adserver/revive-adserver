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

/**
 * A class for testing badLogin.
 *
 * @package    Util
 * @subpackage BadLogin
 */
class Test_BadLogin extends UnitTestCase
{
    public $initialIp = null;
    public $initialBadLoginLogPath = null;
    public $badLoginLogPathForTest = MAX_PATH . '/var/testBadLogin.log';
    public $badIpForTest = '127.0.0.1';

    public function __construct()
    {
        parent::__construct();
	$this->initialIp = $this->_getIp();
	$this->initialBadLoginLogPath = $this->_getBadLoginFilePath();
	$this->_setBadLoginLogPath($this->badLoginLogPathForTest);
	$this->_setIp($this->badIpForTest);
    }

    /**
     * Set the badLoginLogPath as if it was set by the user in the admin interface.
     *
     */
    public function _setBadLoginLogPath($path)
    {
	global $GLOBALS;
	$GLOBALS['_MAX']['CONF']['ui']["badLoginLogPath"]=$path;
    }

    /**
     * Get the badLoginLogPath (mainly to be able to restore it).
     *
     */
    public function _getBadLoginFilePath()
    {
	global $GLOBALS;
	if(!$this->array_structure_exists(['_MAX','CONF','ui',"badLoginLogPath"],$GLOBALS))
	{
	    return "";
	}
        return $GLOBALS['_MAX']['CONF']['ui']["badLoginLogPath"];
    }

    /**
     * Set the ip as if it was sent by the request.
     *
     */
    public function _setIp($ip)
    {
        putenv("HTTP_CLIENT_IP=$ip");
    }

    /**
     * Get the ip (mainly to be able to restore it).
     *
     */
    public function _getIp()
    {
        return getenv('HTTP_CLIENT_IP');
    }

    public function _deleteBadLoginLogFileForTest()
    {
	unlink($this->badLoginLogPathForTest);
    }

    public function _getBadLoginLogFileContent()
    {
	return file_get_contents($this->badLoginLogPathForTest);
    }

    public function array_structure_exists($keys, $array) {
        if (!count($array) || !count($keys)) {
            return false;
        }
        foreach ($keys as $key) {
            if (!is_array($array) || !is_scalar($key) || !array_key_exists($key, $array)) {
                return false;
            } else {
                $array = $array[$key];
            }
        }
        return true;
    }

    public function __destruct()
    {
	$this->_setIp($this->initialIp);
	$this->_setBadLoginLogPath($this->initialBadLoginLogPath);
	$this->_deleteBadLoginLogFileForTest();
    }

    public function test_badLogin_WriteToLogFile()
    {
	require_once MAX_PATH . '/lib/util/file/badLogin.php';
	$res = $this->_getBadLoginLogFileContent();
	$this->assertEqual(explode(": ",$res,2)[1],$this->badIpForTest."\n");
    }
}
