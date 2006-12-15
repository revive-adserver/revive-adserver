<?php

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
