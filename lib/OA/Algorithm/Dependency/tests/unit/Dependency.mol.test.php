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
    public function __construct()
    {
        parent::__construct();
    }

    public function testDependcy()
    {
        // test depends
        $items = [
            'C', 'B', 'F',
            'A' => ['B', 'C'],
            'E' => ['B'],
            'D' => ['A', 'E'],
        ];
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $dep = new OA_Algorithm_Dependency($source);

        $ret = $dep->depends(['B']);
        $this->assertEqual($ret, []);

        $ret = $dep->depends(['A']);
        $this->assertEqual($ret, ['B', 'C']);

        $ret = $dep->depends(['D']);
        $this->assertEqual($ret, ['A', 'B', 'C', 'E']);

        // test schedule
        $ret = $dep->schedule(['G']);
        $this->assertFalse($ret);

        $ret = $dep->schedule(['B']);
        $this->assertEqual($ret, ['B']);

        $ret = $dep->schedule(['A']);
        $this->assertEqual($ret, ['A', 'B', 'C']);

        $ret = $dep->schedule(['D']);
        $this->assertEqual($ret, ['A', 'B', 'C', 'D', 'E']);

        // test schedule all
        $ret = $dep->scheduleAll();
        $this->assertEqual($ret, ['A', 'B', 'C', 'D', 'E', 'F']);
    }

    public function getAlgorithmWithData($selected = [], $ignoreOrphans = false)
    {
        $items = [
            'C', 'B', 'F',
            'A' => ['B', 'C'],
        ];
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        return new OA_Algorithm_Dependency($source, $selected, $ignoreOrphans);
    }

    public function testUseOfIgnoreOrphans()
    {
        $dep = $this->getAlgorithmWithData();

        $ret = $dep->depends(['A', 'G']);
        $this->assertFalse($ret);
        $ret = $dep->schedule(['A', 'G']);
        $this->assertFalse($ret);

        $dep = $this->getAlgorithmWithData([], $ignoreOrphans = true);
        $ret = $dep->depends(['A', 'G']);
        $this->assertEqual($ret, ['B', 'C']);
        $ret = $dep->schedule(['A', 'G']);
        $this->assertEqual($ret, ['A', 'B', 'C', 'G']);
    }

    public function testUseOfSelected()
    {
        $dep = $this->getAlgorithmWithData(['C']);

        $ret = $dep->depends(['A']);
        $this->assertEqual($ret, ['B']);

        $ret = $dep->schedule(['A']);
        $this->assertEqual($ret, ['A', 'B']);
    }
}
