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

require_once MAX_PATH . '/lib/max/Plugin.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Site/Variable.delivery.php';

/**
 * A class for testing the Plugins_Delivery_Site_Variable class.
 * Note: This test is for the delivery component, much easier to test,
 * since the function simply returns true/false
 *
 * Some notes:
 *  We set the $compiledlimitation string to exactly what the delivery engine would @eval
 * <b>except</b> that we pass $data in as a 3rd parameter, this overrides the plugin's data gatherer
 *
 *
 *
 * @package    OpenXPluginDelivery
 * @subpackage TestSuite
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
class Plugins_TestOfPlugins_Delivery_Site_Variable extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_Delivery_Site_Variable()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the numeric "is greater than" functionality
     */
    function test_numeric_greater_than()
    {
        /**
         * Set the compiled limitation string... we may even be able to instantiate the plugin and generate this from ACL data...
         * Testing variable "key" is greater than 10
         */
        $compiledlimitation = "MAX_checkSite_Variable('key|10', 'gt')";

        // Test that 15 is greater than 10 ;)
        $data = array('key' => '15');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test that 5 is greater than 10
        $data = array('key' => '5');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test non-numeric value is greater than 10
        $data = array('key' => 'value');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Check decimal numbers (using pi as a test)
        $compiledlimitation = "MAX_checkSite_Variable('key|3.1415926535897952384626433832795', 'gt')";

        // Test that decimal 3.14159267 is greater than 3.1415926535897952384626433832795 ;)
        $data = array('key' => '3.14159267');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test that 1.45867 is greater than 3.1415926535897952384626433832795
        $data = array('key' => '1.45867');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

    }

    /**
     * Test the numeric "is less than" functionality
     */
    function test_numeric_less_than()
    {
        /**
         * Try a new compiledlimitation string
         * Testing variable "key" is less than 10
         */
        $compiledlimitation = "MAX_checkSite_Variable('key|10', 'lt')";

        // Test 15 is less than 10
        $data = array('key' => '15');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test 5 is less than 10
        $data = array('key' => '5');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test 5 is less than non-numeric
        $data = array('key' => 'string');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Check decimal numbers (using pi as a test)
        $compiledlimitation = "MAX_checkSite_Variable('key|3.1415926535897952384626433832795', 'lt')";

        // Test that decimal 3.14159267 is greater than 3.1415926535897952384626433832795 ;)
        $data = array('key' => '3.14159267');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test that 1.45867 is greater than 3.1415926535897952384626433832795
        $data = array('key' => '1.45867');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

    }

    /**
     * Test the "is equal to" functionality
     */
    function test_is_equal_to()
    {
        /**
         * Testing "thisisequal" is equal to
         */
        $compiledlimitation = "MAX_checkSite_Variable('name|thisisequal', '==')";

        // Test "thisisequal" is equal to "thisisequal"
        $data = array('name' => 'thisisequal');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Testing "this is not equal" is equal to "thisisequal"
        $data = array('name' => 'this is not equal');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test empty is equal to "thisisequal"
        $data = array('name' => '');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        /**
         * Testing numeric equal functions
         */
        $compiledlimitation = "MAX_checkSite_Variable('variable|123', '==')";

        // Test 123 is equal to "123"
        $data = array('variable' => '123');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test 1234 is equal to "123"
        $data = array('variable' => '1234');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "string" is equal to "123"
        $data = array('variable' => 'string');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        /**
         * Testing decimal equal functions
         */
        $compiledlimitation = "MAX_checkSite_Variable('variable|3.1415926535897932384626433832795', '==')";

        // Test 3.1415926535897932384626433832795 is equal to "3.1415926535897932384626433832795"
        $data = array('variable' => '3.1415926535897932384626433832795');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test 1234 is equal to "3.1415926535897932384626433832795"
        $data = array('variable' => '1234');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "string" is equal to "3.1415926535897932384626433832795"
        $data = array('variable' => 'string');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);


        /**
         * Testing numeric equal-zero functions
         */
        $compiledlimitation = "MAX_checkSite_Variable('variable|0', '==')";

        // Test "0" is equal to "0"
        $data = array('variable' => '0');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test 0 is equal to "0"
        $data = array('variable' => 0);
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "7" is equal to "0"
        $data = array('variable' => '7');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "string" is equal to "0"
        $data = array('variable' => '7');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);
    }

    /**
     * Test the "is different from" functionality
     */
    function test_is_different_from()
    {
        /**
         * Testing "thisisequal" is different from
         */
        $compiledlimitation = "MAX_checkSite_Variable('name|thisisequal', '!=')";

        // Test "thisisequal" is different from "thisisequal"
        $data = array('name' => 'thisisequal');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Testing "this is not equal" is different from "thisisequal"
        $data = array('name' => 'this is not equal');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test empty is different from "thisisequal"
        $data = array('name' => '');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        /**
         * Testing numeric equal functions
         */
        $compiledlimitation = "MAX_checkSite_Variable('variable|123', '!=')";

        // Test 123 is different from "123"
        $data = array('variable' => '123');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test 1234 is different from "123"
        $data = array('variable' => '1234');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "string" is different from "123"
        $data = array('variable' => 'string');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        /**
         * Testing numeric not-equal-zero functions
         */
        $compiledlimitation = "MAX_checkSite_Variable('variable|0', '!=')";

        // Test "0" is different from "0"
        $data = array('variable' => '0');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test 0 is different from "0"
        $data = array('variable' => 0);
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "7" is different from "0"
        $data = array('variable' => '7');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "string" is different from "0"
        $data = array('variable' => '7');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);
    }

    /**
     * Test the "contains" functionality
     */
    function test_string_contains()
    {
        /**
         * Try a new compiledlimitation string
         * Testing variable "key" contains test
         */
        $compiledlimitation = "MAX_checkSite_Variable('key|test', '=~')";

        // Test "toast" contains "test"
        $data = array('key' => 'toast');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "test" contains "test"
        $data = array('key' => 'test');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "test" contains "openadsteststring"
        $data = array('key' => 'openadsteststring');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test numeric contains test
        $data = array('key' => 15);
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);
    }

    /**
     * Test the "does not contain" functionality
     */
    function test_string_does_not_contain()
    {
        /**
         * Try a new compiledlimitation string
         * Testing variable "5" does not contain test
         */
        $compiledlimitation = "MAX_checkSite_Variable('5|test', '!~')";

        // Test "toast" does not contain "test"
        $data = array('5' => 'toast');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "test" does not contain "test"
        $data = array('5' => 'test');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "openadsteststring" does not contains "test"
        $data = array('5' => 'openadsteststring');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test numeric does not contain test
        $data = array('5' => 1561.5);
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);
    }

    /**
     * Test the regular expresion matching functionality
     */
    function test_regex_matches()
    {
        /**
         * Try a new compiledlimitation string
         * Testing variable "key" does not match "[number][letter][number][letter]
         */
        $compiledlimitation = "MAX_checkSite_Variable('key|[0-9][A-Za-z][0-9][A-Za-z]', '=x')";

        // Test "0a7b" matches
        $data = array('key' => '0a7b');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "00aa75rc" does not match
        $data = array('key' => '00aa75rc');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "aaa7e6zyah61" matches
        $data = array('key' => 'aaa7e6zyah61');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test empty does not contain match
        $data = array('key' => '');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);
        
        // Test | in regex
        $compiledlimitation = "MAX_checkSite_Variable('key|([0-4])|([a-z])', '=x')";
        // Test "734" matches
        $data = array('key' => '734');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);
        
        // Test "asdfs" matches
        $data = array('key' => 'asdfs');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);
        
        // Test "567" does not match
        $data = array('key' => '567');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

    }

    /**
     * Test the regular expresion non-matching functionality
     */
    function test_regex_does_not_match()
    {
        /**
         * Try a new compiledlimitation string
         * Testing variable "key" does not match "[number][letter][number][letter]
         */
        $compiledlimitation = "MAX_checkSite_Variable('key|[0-9][A-Za-z][0-9][A-Za-z]', '!x')";

        // Test "0a7b" matches
        $data = array('key' => '0a7b');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test "00aa75rc" does not match
        $data = array('key' => '00aa75rc');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test "aaa7e6zyah61" matches
        $data = array('key' => 'aaa7e6zyah61');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test empty does not contain match
        $data = array('key' => '');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);
    }

    /**
     * Since the other tests would all indicate that the comparison operators are matching
     * now I'm going to test passing in an array with and without the correct key
     */
    function test_wrong_key_name()
    {
        /**
         * Testing "thisisequal" is equal to
         */
        $compiledlimitation = "MAX_checkSite_Variable('name|thisisequal', '==')";

        // Test only correct is passed in
        $data = array('name' => 'thisisequal');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test only correct amongst incorrect is passed in
        $data = array('somekey' => 'nomatch', 'name' => 'thisisequal', 'someotherkey' => 'aeb');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertTrue($result);

        // Test only incorrect is passed in
        $data = array('somekey' => 'nomatch', 'name' => '1234', 'someotherkey' => 'aeb');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test empty is passed in
        $data = array();
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

        // Test right value in wrong key
        $data = array('wrongkey' => 'thisisequal');
        $result = $this->_evalCompiledLimitation($compiledlimitation, $data);
        $this->assertFalse($result);

    }

    /**
     * A private method to take a compiledlimitation string, and some data to test with
     * evaluate the string, and return the result
     *
     * @param string $compiledlimitation    The compiledlimitation string to be tested
     * @param array $data
     * @return mixed $result                boolean on eval sucess, array on false
     *
     * I'm returning an array to allow assertTrue/assertFalse to work as expected
     */
    function _evalCompiledLimitation($compiledlimitation, $data)
    {
        // Add the $data parameter to the end of the compiled limitation string
        $compiledlimitation = preg_replace('#\)$#', ', $data)', $compiledlimitation);

        // Set $result to something other than null/true/false so we can detect eval errors
        $result = array();

        // Eval the function
        @eval('$result = (' . $compiledlimitation . ');');

        // Return the result of the eval
        return $result;
    }
}

?>
