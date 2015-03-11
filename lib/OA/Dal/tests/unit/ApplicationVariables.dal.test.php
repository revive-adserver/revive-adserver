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

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * A class for testing the OA_Dal_ApplicationVariables class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_ApplicationVariables extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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