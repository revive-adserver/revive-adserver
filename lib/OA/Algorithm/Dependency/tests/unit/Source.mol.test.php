<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * A class for testing the OA_Algorithm_Dependency_Source class and HoA subclass
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_OA_Algorithm_Dependency_Source extends UnitTestCase
{

    function Test_OA_Algorithm_Dependency_Source()
    {
        $this->UnitTestCase();
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