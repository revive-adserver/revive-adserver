<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * A common DataObjects unit class for testing DataObjects
 *
 * @package    MaxDal
 * @subpackage TestSuite
 */
class DataObjectsUnitTestCase extends UnitTestCase 
{
    /**
     * The constructor method.
     */
    function DataObjectsUnitTestCase()
    {
        $this->UnitTestCase();
    }
    
    /**
     *    Will trigger a pass if the two parameters have
     *    the same value only. Otherwise a fail.
     *    @param mixed $first          Value to compare.
     *    @param mixed $second         Value to compare.
     *    @param string $message       Message to display.
     *    @return boolean              True on pass
     *    @access public
     */
    function assertEqualDataObjects($first, $second, $message = "%s")
    {
        return $this->assertExpectation(
                    new DataObjectsEqualExpectation($first),
                    $second,
                    $message);
    }
}

    /**
     *    Test for equality.
	 *    @package    MaxDal
     *    @subpackage TestSuite
     */
    class DataObjectsEqualExpectation extends EqualExpectation {
        
        /**
         *    Sets the value to compare against.
         *    @param mixed $value        Test value to match.
         *    @param string $message     Customised message on failure.
         *    @access public
         */
        function DataObjectsEqualExpectation($value, $message = '%s') {
            $this->EqualExpectation($this->removePrivateFields($value), $message);
        }
        
        /**
         *    Tests the expectation. True if it matches the
         *    held value.
         *    @param mixed $compare        Comparison value.
         *    @return boolean              True if correct.
         *    @access public
         */
        function test($compare) {
            $compare = $this->removePrivateFields($compare);
            return (($this->_value == $compare) && ($compare == $this->_value));
        }
        
        function removePrivateFields($value)
        {
            if (is_object($value)) {
                $fields = get_object_vars($value);
                foreach ($fields as $field => $v) {
                    if (strpos($field, '_') === 0) {
                        unset($value->$field);
                    }
                }
            }
            return $value;
        }
    }