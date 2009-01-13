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

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Ordered.php';
require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source/HoA.php';

/**
 * A class for testing the OA_Algorithm_DependencySource class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_OA_Algorithm_Dependency extends UnitTestCase
{

    function Test_OA_Algorithm_Dependency()
    {
        $this->UnitTestCase();
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