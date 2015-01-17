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

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * A class for testing the OA_Algorithm_Dependency_Source class and HoA subclass
 *
 * @package    OpenX
 * @subpackage TestSuite
 */
class Test_OA_Algorithm_Dependency_Source extends UnitTestCase
{

    function __construct()
    {
        parent::__construct();
    }

    function testLoad()
    {
        // call emptry constructor
        $source = new OA_Algorithm_Dependency_Source_HoA();

        // test load
        $items = array(
            'B' => array(),
            'C' => array(),
            'A' => array('B', 'C')
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $ret = $source->load();
        $this->assertTrue($ret);

        // test that items were correctly loaded
        $ret = $source->getItem('A');
        $this->assertEqual($ret, new OA_Algorithm_Dependency_Item('A', array('B', 'C')));

        $ret = $source->getItem('foo');
        $this->assertFalse($ret);

        $ret = $source->getItems();
        $this->assertEqual(count($items), count($ret));
        foreach ($ret as $item) {
            $this->assertIsA($item, 'OA_Algorithm_Dependency_Item');
            $this->assertTrue(isset($items[$item->getId()]));
        }

        // test that re-loading reset elements
        $items = array(
            'D' => array('A'),
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $ret = $source->load();
        $this->assertTrue($ret);

        $ret = $source->getItem('B');
        $this->assertFalse($ret);

        $ret = $source->getItem('D');
        $this->assertEqual($ret, new OA_Algorithm_Dependency_Item('D', array('A')));
    }

    function testMissingDependencies()
    {
        // all dependencies are met
        $items = array(
            'B' => array(),
            'C',
            'A' => array('B', 'C')
        );
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $source->load();
        $deps = $source->getMissingDependencies();
        $this->assertEqual($deps, array());

        // E doesn't exist, so there are missing dependencies
        $items['D'] = array('A', 'E');
        $source = new OA_Algorithm_Dependency_Source_HoA($items);
        $source->load();
        $deps = $source->getMissingDependencies();
        $this->assertEqual(array_values($deps), array('E'));
    }
}

?>