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

require_once MAX_PATH . '/lib/max/Delivery/flash.php';

/**
 * A class for testing the flash.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryFlash extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function test_DeliveryFlash()
    {
        $this->UnitTestCase();
    }

    /**
     * This function outputs the code to include the FlashObject code as an external
     * JavaScript file
     *
     */
    function test_MAX_flashGetFlashObjectExternal()
    {
        $return = MAX_flashGetFlashObjectExternal();
        $result = "<script type='text/javascript' src='http://".$GLOBALS['_MAX']['CONF']['webpath']['delivery']."/".$GLOBALS['_MAX']['CONF']['file']['flash']."'></script>";
        $this->assertEqual($return, $result);
    }

    /**
     * This function outputs the code to include the FlashObject code as inline JavaScript
     * reads the contents of a file that returns javascript
     */
    function test_MAX_flashGetFlashObjectInline()
    {
        $return = MAX_flashGetFlashObjectInline();
        $this->assertNoErrors('MAX_flashGetFlashObjectInline');
        $this->assertTrue($return, 'MAX_flashGetFlashObjectInline');
        $expect = file_get_contents(MAX_PATH . '/www/delivery/' . $GLOBALS['_MAX']['CONF']['file']['flash']);
        $this->assertEqual($return, $expect);
    }
}
?>
