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
$Id$
*/

require_once MAX_PATH . '/lib/OA/DB.php';
require_once 'Date.php';

/**
 * A class for testing the OA_DB_Table class.
 *
 * @package    OpenadsDB
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class OA_DBTest extends UnitTestCase
{
    function testSingleton()
    {
        $oDbh = OA_DB::singleton();
        $this->assertNotNull($oDbh);
        $this->assertFalse(PEAR::isError($oDbh));
        
        $dsn = "mysql://scott:tiger@non-existent-host:666/non-existent-database";
        $oDbh = &OA_DB::singleton($dsn);
        $this->assertNotNull($oDbh);
        $this->assertTrue(PEAR::isError($oDbh));
    }
}