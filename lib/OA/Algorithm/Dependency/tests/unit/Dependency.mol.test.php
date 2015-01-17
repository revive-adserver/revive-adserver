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

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * A class for testing the OA_Algorithm_DependencySource class
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Algorithm_Dependency extends UnitTestCase
{

    function __construct()
    {
        parent::__construct();
    }

    function testDependcy()
    {
        // test depends
        $items = array(
            'C', 'B', 'F',
            'A' => array('B', 'C'),
            'E' => array('B'),
            'D' => array('A', 'E'),
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $dep = new OA_Algorithm_Dependency($source);

        $ret = $dep->depends(array('B'));
        $this->assertEqual($ret, array());

        $ret = $dep->depends(array('A'));
        $this->assertEqual($ret, array('B', 'C'));

        $ret = $dep->depends(array('D'));
        $this->assertEqual($ret, array('A', 'B', 'C', 'E'));

        // test schedule
        $ret = $dep->schedule(array('G'));
        $this->assertFalse($ret);

        $ret = $dep->schedule(array('B'));
        $this->assertEqual($ret, array('B'));

        $ret = $dep->schedule(array('A'));
        $this->assertEqual($ret, array('A', 'B', 'C'));

        $ret = $dep->schedule(array('D'));
        $this->assertEqual($ret, array('A', 'B', 'C', 'D', 'E'));

        // test schedule all
        $ret = $dep->scheduleAll();
        $this->assertEqual($ret, array('A', 'B', 'C', 'D', 'E', 'F'));
    }

    function getAlgorithmWithData($selected = array(), $ignoreOrphans = false)
    {
        $items = array(
            'C', 'B', 'F',
            'A' => array('B', 'C'),
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        return new OA_Algorithm_Dependency($source, $selected, $ignoreOrphans);
    }

    function testUseOfIgnoreOrphans()
    {
        $dep = $this->getAlgorithmWithData();

        $ret = $dep->depends(array('A', 'G'));
        $this->assertFalse($ret);
        $ret = $dep->schedule(array('A', 'G'));
        $this->assertFalse($ret);

        $dep = $this->getAlgorithmWithData(array(), $ignoreOrphans = true);
        $ret = $dep->depends(array('A', 'G'));
        $this->assertEqual($ret, array('B', 'C'));
        $ret = $dep->schedule(array('A', 'G'));
        $this->assertEqual($ret, array('A', 'B', 'C', 'G'));
    }

    function testUseOfSelected()
    {
        $dep = $this->getAlgorithmWithData(array('C'));

        $ret = $dep->depends(array('A'));
        $this->assertEqual($ret, array('B'));

        $ret = $dep->schedule(array('A'));
        $this->assertEqual($ret, array('A', 'B'));
    }
}

?>