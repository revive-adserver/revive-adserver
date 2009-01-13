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

require_once MAX_PATH . '/lib/Max.php';

/**
 * A class for testing the common.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_MAX extends UnitTestCase
{
    /** @var int */
    var $original_server_port;

    /**
     * The constructor method.
     */
    function test_MAX()
    {
        $this->UnitTestCase();
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
