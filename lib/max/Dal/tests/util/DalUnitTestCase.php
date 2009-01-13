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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A common DataObjects unit class for testing DataObjects
 *
 * @package    MaxDal
 * @subpackage TestSuite
 */
class DalUnitTestCase extends UnitTestCase
{
    /**
     *    Uses reflection to run every method within itself
     *    starting with the string "test" unless a method
     *    is specified.
     *    @param SimpleReporter $reporter    Current test reporter.
     *    @return boolean                    True if all tests passed.
     *    @access public
     */
    function run(&$reporter) {
        $this->setUpFixture();
        $ret = parent::run($reporter);
        $this->tearDownFixture();
        return $ret;
    }
    
    /**
     * setUpFixture() method is executed once before running all the tests
     *
     */
    function setUpFixture() {
    }
    
    /**
     * tearDownFixture() method is executed once after running all the tests
     *
     */
    function tearDownFixture() {
    }
    
    /**
     * Should we compare DataObjects with or without "updated" fields? Default true means
     * it should be compared without "updated"
     *
     * @var boolean
     */
    var $stripUpdated = true;

    /**
     *    Will trigger a pass if the two DataObjects have
     *    the same value only (except private fields). Otherwise a fail.
     *    By private fields we mean all fields starting with "_"
     *    @param mixed $first          Value to compare.
     *    @param mixed $second         Value to compare.
     *    @param string $message       Message to display.
     *    @return boolean              True on pass
     *    @access public
     */
    function assertEqualDataObjects($first, $second, $message = "%s")
    {
        return $this->assertExpectation(
                    new EqualExpectation($this->stripUpdated($this->stripPrivateFields($first))),
                    $this->stripUpdated($this->stripPrivateFields($second)),
                    $message);
    }

    /**
     *    Will trigger a pass if the two DataObjects have
     *    a different value (after removing private fields from them). Otherwise a fail.
     *    By private fields we mean all fields starting with "_"
     *    @param mixed $first          Value to compare.
     *    @param mixed $second         Value to compare.
     *    @param string $message       Message to display.
     *    @return boolean              True on pass
     *    @access public
     */
    function assertNotEqualDataObjects($first, $second, $message = "%s")
    {
        return $this->assertExpectation(
                    new NotEqualExpectation($this->stripUpdated($this->stripPrivateFields($first))),
                    $this->stripUpdated($this->stripPrivateFields($second)),
                    $message);
    }

    /**
     *    Will be true if the value is empty.
     *    @param null $value       Supposedly null value.
     *    @param string $message   Message to display.
     *    @return boolean                        True on pass
     *    @access public
     */
    function assertEmpty($value, $message = "%s") {
        $dumper =& new SimpleDumper();
        $message = sprintf(
                $message,
                "[" . $dumper->describeValue($value) . "] should be empty");
        return $this->assertTrue(empty($value), $message);
    }

    /**
     *    Will be true if the value is not empty.
     *    @param mixed $value           Supposedly set value.
     *    @param string $message        Message to display.
     *    @return boolean               True on pass.
     *    @access public
     */
    function assertNotEmpty($value, $message = "%s") {
        $dumper =& new SimpleDumper();
        $message = sprintf(
                $message,
                "[" . $dumper->describeValue($value) . "] should not be null");
        return $this->assertTrue(!empty($value), $message);
    }

    /**
     *   Unset (before comparison) any non transent private fields in DataObject
     *   By private fields we mean all fields starting with "_"
     *
     *   @param DataObject $do
     *   @return DataObject
     */
    function stripPrivateFields($do)
    {
        if (is_object($do)) {
            $fields = get_object_vars($do);
            foreach ($fields as $field => $v) {
                if (strpos($field, '_') === 0) {
                    unset($do->$field);
                }
            }
        }
        return $do;
    }

    /**
     *   Unset (before comparison) any Primary Keys which DataObject could have
     *
     *   @param DataObject $do
     *   @param bool $stripPrivateFields  Should we also strip private fields?
     *   @return DataObject
     */
    function stripKeys($do)
    {
        if (is_a($do, 'DB_DataObject')) {
            $keys = $do->keys();
            foreach ($keys as $key) {
                unset($do->$key);
            }
        }
        return $do;
    }

    function stripUpdated($do)
    {
        if ($this->stripUpdated && $do->refreshUpdatedFieldIfExists) {
            unset($do->updated);
        }
        return $do;
    }

    function getPrefix()
    {
        return OA_Dal::getTablePrefix();
    }
    
}
