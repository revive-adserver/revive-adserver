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

require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

/**
 * A class for testing the javascript.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryJavascript extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function test_DeliveryJavascript()
    {
        $this->UnitTestCase();
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