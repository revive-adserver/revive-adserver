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

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * A class for testing the OA_Algorithm_DependencySource class
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Algorithm_Dependency_Ordered extends UnitTestCase
{

    function __construct()
    {
        parent::__construct();
    }

    function testDependcy()
    {
        $items = array(
            'C', 'B', 'F',
            'A' => array('B', 'C'),
            'E' => array('B'),
            'D' => array('A', 'E'),
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $dep = new OA_Algorithm_Dependency_Ordered($source);

        // test schedule
        $ret = $dep->schedule(array('G'));
        $this->assertFalse($ret);

        $ret = $dep->schedule(array('B'));
        $this->assertEqual(array_values($ret), array('B'));

        $ret = $dep->schedule(array('A'));
        $this->assertEqual(array_values($ret), array('B', 'C', 'A'));

        $ret = $dep->schedule(array('D'));
        $this->assertEqual(array_values($ret), array('B', 'C', 'E', 'A', 'D'));

        // test schedule all
        $ret = $dep->scheduleAll();
        $this->assertEqual(array_values($ret), array('B', 'C', 'E', 'F', 'A', 'D'));
    }

    function getAlgorithmWithData($selected = array(), $ignoreOrphans = false)
    {
        $items = array(
            'C', 'B', 'F',
            'A' => array('B', 'C'),
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        return new OA_Algorithm_Dependency_Ordered($source, $selected, $ignoreOrphans);
    }

    function testUseOfIgnoreOrphans()
    {
        $dep = $this->getAlgorithmWithData();

        $ret = $dep->schedule(array('A', 'G'));
        $this->assertFalse($ret);

        $dep = $this->getAlgorithmWithData(array(), $ignoreOrphans = true);
        $ret = $dep->schedule(array('A', 'G'));
        $this->assertEqual(array_values($ret), array('B', 'C', 'A'));
    }

    function testUseOfSelected()
    {
        $dep = $this->getAlgorithmWithData(array('C'));

        $ret = $dep->schedule(array('A'));
        $this->assertEqual(array_values($ret), array('B', 'A'));
    }
}

?>