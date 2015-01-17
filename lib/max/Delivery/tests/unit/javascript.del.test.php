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

require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

/**
 * A class for testing the javascript.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class Test_DeliveryJavascript extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }


    /**
     * This function takes some HTML, and generates JavaScript document.write() code
     * to output that HTML via JavaScript
     *
     * @param string  $string   The string to be converted
     * @param string  $varName  The JS variable name to store the output in
     * @param boolean $output   Should there be a document.write to output the code?
     *
     * @return string   The JS-ified string
     */
    function test_MAX_javascriptToHTML()
    {
        $string     = '<div>write this to document/div>';
        $varName    = 'myVar';
        $output     = true;
        $return     = MAX_javascriptToHTML($string, $varName, $output);
        $result     = str_replace("\r", '', 'var myVar = \'\';
myVar += "<"+"div>write this to document/div>\n";
document.write(myVar);
');
        $this->assertEqual($return, $result);
    }

}

?>