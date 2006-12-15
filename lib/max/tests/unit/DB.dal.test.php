<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: DB.dal.test.php 6222 2006-12-06 18:44:54Z roh@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once 'DB.php';

/**
 * A class for testing the MAX_DB class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfDB extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfDB()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that the database type is setup in the config .ini file.
     */
    function testDbTypeDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['database']['type']);
        $this->assertNotEqual($conf['database']['type'], '');
    }

    /**
     * Tests that the database host is setup in the config .ini file.
     */
    function testDbHostDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['database']['host']);
        $this->assertNotEqual($conf['database']['host'], '');
    }

    /**
     * Tests that the database port is setup in the config .ini file.
     */
    function testDbPortDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['database']['port']);
        $this->assertNotEqual($conf['database']['port'], '');
    }

    /**
     * Tests that the database user is setup in the config .ini file.
     */
    function testDbUserDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['database']['username']);
        $this->assertNotEqual($conf['database']['username'], '');
    }

    /**
     * Tests that the database password is setup in the config .ini file.
     */
    function testDbPasswordDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['database']['password']);
    }

    /**
     * Tests that the database name is setup in the config .ini file.
     */
    function testDbNameDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['database']['name']);
        $this->assertNotEqual($conf['database']['name'], '');
    }

    /**
     * Tests that the Max table prefix is setup in the config .ini file.
     */
    function testDbPrefixDefined()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($conf['table']['prefix']);
    }

    /**
     * Tests that the database connection can be made, without using the
     * Dal class - that is, that the details specified above are okay.
     */
    function testDbConnection()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbConnection = DB::connect(strtolower($conf['database']['type']) . '://' .
                        $conf['database']['username'] . ':' .  $conf['database']['password'] .
                        '@' . $conf['database']['host'] . ':' . $conf['database']['port'] . '/' .
                        $conf['database']['name']);
        $this->assertTrue($dbConnection);
    }

    /**
     * Tests that the singleton() method only ever returns one
     * database connection.
     */
    function testSingletonDbConnection()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        //$conf['database']['name'] = 'test'; // Is configuring a name part of the test? Why?
        $firstConnection  = &MAX_DB::singleton();
        $secondConnection = &MAX_DB::singleton();
        $this->assertIdentical($firstConnection, $secondConnection);
        $this->assertReference($firstConnection, $secondConnection);
        TestEnv::restoreConfig();
    }

}

?>
