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

require_once MAX_PATH . '/lib/OA/Admin/ExcelWriter.php';

/**
 * A class for testing the OA_Admin_ExcelWriter class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OA_Admin_ExcelWriter extends UnitTestCase
{
    /**
     * A method to test the getFormat() method.
     */
    public function testGetFormat()
    {
        $oExcelWriter = new OA_Admin_ExcelWriter();
        $workbook = new Spreadsheet_Excel_Writer();
        $oExcelWriter ->_setExcelWriter($workbook);

        // Test usual case
        $aFormat = [0 => "h1", 1 => "border-top", 2 => "border-left"];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertIsA($result, 'Spreadsheet_Excel_Writer_Format');

        // One parameter is set to null
        $aFormat = [0 => null, 1 => "border-bottom"];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertIsA($result, 'Spreadsheet_Excel_Writer_Format');

        // All parameters are set to null
        $aFormat = [0 => null];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);

        // Empty array
        $aFormat = [];
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);

        // Not array
        $aFormat = null;
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);
    }
}
