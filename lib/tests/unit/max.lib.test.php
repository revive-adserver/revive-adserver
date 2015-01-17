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

require_once MAX_PATH . '/lib/Max.php';

/**
 * A class for testing the common.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class test_MAX extends UnitTestCase
{
    /** @var int */
    var $original_server_port;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        $this->original_server_port = $_SERVER['SERVER_PORT'];
        $GLOBALS['_MAX']['CONF']['webpath']['admin']     = 'www.maxstore.net/www/admin';
        //$GLOBALS['_MAX']['CONF']['webpath']['imagesSSL']  = 'secure.maxstore.net/www/admin/images';
    }

    function tearDown()
    {
        $_SERVER['SERVER_PORT'] = $this->original_server_port;
    }

    function test_constructURL_Includes_Nonstandard_Secure_Port_Number()
    {
        $http = $GLOBALS['_MAX']['HTTP'];
        $GLOBALS['_MAX']['HTTP'] = 'https://';
        $_SERVER['SERVER_PORT'] = 4430;
        $GLOBALS['_MAX']['CONF']['openads']['sslPort']  = 4430;
        $url    = MAX::constructURL(MAX_URL_ADMIN, 'test.html');
        $this->assertEqual($url, 'https://www.maxstore.net:4430/www/admin/test.html', "A non-standard port number should be explicitly provided in delivery URLs. %s");
        $GLOBALS['_MAX']['HTTP'] = $http;
    }

}

?>
