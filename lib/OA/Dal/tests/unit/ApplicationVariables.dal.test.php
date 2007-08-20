<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * A class for testing the OA_Dal_ApplicationVariables class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openads.org
 */
class Test_OA_Dal_ApplicationVariables extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_ApplicationVariables()
    {
        $this->UnitTestCase();
    }

    /**
     * Test set and getAll
     *
     */
    function testSetGetAll()
    {
        $result = OA_Dal_ApplicationVariables::getAll();
        $this->assertEqual($result, array());

        $aData = array(
            'one' => 'foo',
            'two' => 'bar'
        );

        foreach ($aData as $k => $v) {
            $result = OA_Dal_ApplicationVariables::set($k, $v);
            $this->assertTrue($result);
        }

        $result = OA_Dal_ApplicationVariables::getAll();
        $this->assertEqual($result, $aData);
    }

    /**
     * Test set and get
     *
     */
    function testSetGet()
    {
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertNull($result);

        $result = OA_Dal_ApplicationVariables::set('foo', 'bar');
        $this->assertTrue($result);

        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertEqual($result, 'bar');

        $result = OA_Dal_ApplicationVariables::set('foo', 'foobar');
        $this->assertTrue($result);

        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertEqual($result, 'foobar');
    }
}

?>