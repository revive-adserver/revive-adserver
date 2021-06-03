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

//require_once ('lib/simpletest/unit_tester.php');
require_once MAX_PATH . '/lib/OA/Admin/NumberFormat.php';

class Test_OA_Admin_NumberFormat extends UnitTestCase {

    function test_unformatNumber() {
        global $phpAds_DecimalPoint;
        if (isset($phpAds_DecimalPoint)) {
            $remember_phpAds_DecimalPoint = $phpAds_DecimalPoint;
        }

        //set default decimalPoint
        $phpAds_DecimalPoint = ".";

        $this->assertEqual("12345.67", OA_Admin_NumberFormat::unformatNumber("12.345,67")); //test "," as decimal separator
        $this->assertEqual("12345.67", OA_Admin_NumberFormat::unformatNumber("+12,345.67")); //test "+" symbol
        $this->assertEqual("12345.67", OA_Admin_NumberFormat::unformatNumber("12 345.67")); //test " " as thousands separators
        $this->assertEqual("-12345678", OA_Admin_NumberFormat::unformatNumber("-12,345,678")); //test "-" symbol
        $this->assertEqual("12345678", OA_Admin_NumberFormat::unformatNumber("  12.345.678  ")); //test white spaces
        $this->assertFalse(OA_Admin_NumberFormat::unformatNumber("12.34.567")); //test missing numeral between thousands separators
        $this->assertEqual(".123", OA_Admin_NumberFormat::unformatNumber(".123")); //decimal separator at begining
        $this->assertEqual(".123", OA_Admin_NumberFormat::unformatNumber(",123")); //decimal separator at begining

        //test hazard situations; results are determined by default decimal separator
        $this->assertEqual("1234", OA_Admin_NumberFormat::unformatNumber("1,234"));
        $phpAds_DecimalPoint = ","; //set default decimalPoint
        $this->assertEqual("1.234", OA_Admin_NumberFormat::unformatNumber("1,234"));
        //single dot always as decimal point!
        $this->assertEqual("1.234", OA_Admin_NumberFormat::unformatNumber("1.234"));

        //clean up
        if (isset($remember_phpAds_DecimalPoint)) {
            $phpAds_DecimalPoint = $remember_phpAds_DecimalPoint;
        } else {
            unset ($phpAds_DecimalPoint);
        }
    }

    /**
     * Test the number formatting method
     *
     */
    function test_formatNumber()
    {
        $GLOBALS['phpAds_DecimalPoint'] = '.';
        $GLOBALS['phpAds_ThousandsSeperator'] = ',';
        $GLOBALS['_MAX']['PREF']['ui_percentage_decimals'] = 2;

        $number = 3.1415926535897932384626433832795 * 1000;

        $this->assertEqual('1,234', OA_Admin_NumberFormat::formatNumber("1234", 0));
        $this->assertEqual('3,141.59', OA_Admin_NumberFormat::formatNumber($number));
        $this->assertEqual('3,141.593', OA_Admin_NumberFormat::formatNumber($number, 3));
        $this->assertEqual('3,141,5927', OA_Admin_NumberFormat::formatNumber($number, 4, ','));
        $this->assertEqual('3.141,59265', OA_Admin_NumberFormat::formatNumber($number, 5, ',', '.'));

        // Change defaults
        $GLOBALS['phpAds_DecimalPoint'] = ',';
        $GLOBALS['phpAds_ThousandsSeperator'] = '.';
        $GLOBALS['_MAX']['PREF']['ui_percentage_decimals'] = 4;

        $this->assertEqual('3.141,5927', OA_Admin_NumberFormat::formatNumber($number));
        $this->assertEqual('3.141,593', OA_Admin_NumberFormat::formatNumber($number, 3));
        $this->assertEqual('3.141,5927', OA_Admin_NumberFormat::formatNumber($number, 4, ','));
        $this->assertEqual('3.141,59265', OA_Admin_NumberFormat::formatNumber($number, 5, ',', '.'));

        // Test NAN (NotANumber)
        $this->assertFalse(OA_Admin_NumberFormat::formatNumber('string'));
    }
}

?>
