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