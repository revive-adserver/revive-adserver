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
        $dec_point_save = $GLOBALS['phpAds_DecimalPoint'];
        $thousands_save = $GLOBALS['phpAds_ThousandsSeperator'];
        $decimals_save  = $GLOBALS['_MAX']['PREF']['ui_percentage_decimals'];

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

        // Clean up
        $GLOBALS['phpAds_DecimalPoint'] = $dec_point_save;
        $GLOBALS['phpAds_ThousandsSeperator'] = $thousands_save;
        $GLOBALS['_MAX']['PREF']['ui_percentage_decimals'] = $decimals_save;
    }
}

?>
