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

require_once(MAX_PATH . '/lib/max/Util/ArrayUtils.php');

class MAX_Util_ArrayUtilsTest extends UnitTestCase
{
    function testUnsetIfKeyNumeric()
    {
        $aValuesExpected = array(1 => 'aaaa', 2 => 'bbbb', 3 => 'cccc', 'x' => 'zzzz');
        $aValues = $aValuesExpected;
        
        ArrayUtils::unsetIfKeyNumeric($aValues, 'non-existent');
        $this->assertEqual($aValuesExpected, $aValues);

        ArrayUtils::unsetIfKeyNumeric($aValues, null);
        $this->assertEqual($aValuesExpected, $aValues);
        
        ArrayUtils::unsetIfKeyNumeric($aValues, 'zzzz');
        $this->assertEqual($aValuesExpected, $aValues);

        $aValuesExpected = array(1 => 'aaaa', 3 => 'cccc', 'x' => 'zzzz');
        ArrayUtils::unsetIfKeyNumeric($aValues, 'bbbb');
        $this->assertEqual($aValuesExpected, $aValues);

        $aValuesExpected = array(1 => 'aaaa', 2 => 'bbbb','x' => 'zzzz');
        $aValues = array(1 => 'aaaa', 2 => 'bbbb', 3 => null, 'x' => 'zzzz');
        
        ArrayUtils::unsetIfKeyNumeric($aValues, null);
        $this->assertEqual($aValuesExpected, $aValues);
    }
}
?>