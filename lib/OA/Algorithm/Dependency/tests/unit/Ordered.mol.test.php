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
    public function __construct()
    {
        parent::__construct();
    }

    public function testDependcy()
    {
        $items = [
            'C', 'B', 'F',
            'A' => ['B', 'C'],
            'E' => ['B'],
            'D' => ['A', 'E'],
        ];
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $dep = new OA_Algorithm_Dependency_Ordered($source);

        // test schedule
        $ret = $dep->schedule(['G']);
        $this->assertFalse($ret);

        $ret = $dep->schedule(['B']);
        $this->assertEqual(array_values($ret), ['B']);

        $ret = $dep->schedule(['A']);
        $this->assertEqual(array_values($ret), ['B', 'C', 'A']);

        $ret = $dep->schedule(['D']);
        $this->assertEqual(array_values($ret), ['B', 'C', 'E', 'A', 'D']);

        // test schedule all
        $ret = $dep->scheduleAll();
        $this->assertEqual(array_values($ret), ['B', 'C', 'E', 'F', 'A', 'D']);
    }

    public function getAlgorithmWithData($selected = [], $ignoreOrphans = false)
    {
        $items = [
            'C', 'B', 'F',
            'A' => ['B', 'C'],
        ];
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        return new OA_Algorithm_Dependency_Ordered($source, $selected, $ignoreOrphans);
    }

    public function testUseOfIgnoreOrphans()
    {
        $dep = $this->getAlgorithmWithData();

        $ret = $dep->schedule(['A', 'G']);
        $this->assertFalse($ret);

        $dep = $this->getAlgorithmWithData([], $ignoreOrphans = true);
        $ret = $dep->schedule(['A', 'G']);
        $this->assertEqual(array_values($ret), ['B', 'C', 'A']);
    }

    public function testUseOfSelected()
    {
        $dep = $this->getAlgorithmWithData(['C']);

        $ret = $dep->schedule(['A']);
        $this->assertEqual(array_values($ret), ['B', 'A']);
    }
}
