<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * A class for testing the OA_Dal_ApplicationVariables class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
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
     * Test set, getAll, delete
     *
     */
    function testSetGetAllDelete()
    {
        // Force cache clean-up
        OA_Dal_ApplicationVariables::cleanCache();

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

        // Check cached values
        $result = OA_Dal_ApplicationVariables::getAll();
        $this->assertEqual($result, $aData);

        // Force cache clean-up
        OA_Dal_ApplicationVariables::cleanCache();

        // Check DB-stored values
        $result = OA_Dal_ApplicationVariables::getAll();
        $this->assertEqual($result, $aData);

        foreach (array_keys($aData) as $name) {
            $result = OA_Dal_ApplicationVariables::delete($name);
            $this->assertTrue($result);
        }
    }

    /**
     * Test set, get and delete
     *
     */
    function testSetGetDelete()
    {
        // Force cache clean-up
        OA_Dal_ApplicationVariables::cleanCache();

        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertNull($result);

        $result = OA_Dal_ApplicationVariables::set('foo', 'bar');
        $this->assertTrue($result);

        // Check cached values
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertEqual($result, 'bar');

        // Force cache clean-up
        OA_Dal_ApplicationVariables::cleanCache();

        // Check DB-stored values
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertEqual($result, 'bar');

        $result = OA_Dal_ApplicationVariables::set('foo', 'foobar');
        $this->assertTrue($result);

        // Check cached values
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertEqual($result, 'foobar');

        // Force cache clean-up
        OA_Dal_ApplicationVariables::cleanCache();

        // Check DB-stored values
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertEqual($result, 'foobar');

        $result = OA_Dal_ApplicationVariables::delete('foo');
        $this->assertTrue($result);

        // Check cached values
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertNull($result);

        // Force cache clean-up
        OA_Dal_ApplicationVariables::cleanCache();

        // Check DB-stored values
        $result = OA_Dal_ApplicationVariables::get('foo');
        $this->assertNull($result);
    }

    /**
     * Test delete
     *
     */
    function testDelete()
    {
        $result = OA_Dal_ApplicationVariables::delete('foo');
        $this->assertFalse($result);
    }
    
    /**
     * Test generatin platform hash
     * 
     */
    function testGeneratePlatformHash()
    {
        $hash1 = OA_Dal_ApplicationVariables::generatePlatformHash();
        $hash2 = OA_Dal_ApplicationVariables::generatePlatformHash();
        $this->assertEqual(strlen($hash1), 40);
        $this->assertEqual(strlen($hash2), 40);
        $this->assertNotEqual($hash1, $hash2);
    }
}

?>