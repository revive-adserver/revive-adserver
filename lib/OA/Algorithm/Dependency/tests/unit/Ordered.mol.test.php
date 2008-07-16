<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * A class for testing the OA_Algorithm_DependencySource class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_OA_Algorithm_Dependency_Ordered extends UnitTestCase
{

    function Test_OA_Algorithm_Dependency_Ordered()
    {
        $this->UnitTestCase();
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