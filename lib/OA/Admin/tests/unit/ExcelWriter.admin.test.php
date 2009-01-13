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

require_once MAX_PATH . '/lib/OA/Admin/ExcelWriter.php';

/**
 * A class for testing the OA_Admin_ExcelWriter class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierki@openx.org>
 */
class Test_OA_Admin_ExcelWriter extends UnitTestCase
{
    /**
     * A method to test the getFormat() method.
     */
    function testGetFormat()
    {
        $oExcelWriter = new OA_Admin_ExcelWriter();
        $workbook = new Spreadsheet_Excel_Writer();
        $oExcelWriter ->_setExcelWriter($workbook);
        
        // Test usual case
        $aFormat = array (0=>"h1", 1=>"border-top", 2=>"border-left");
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertIsA($result, 'Spreadsheet_Excel_Writer_Format');
        
        // One parameter is set to null
        $aFormat = array (0=>NULL, 1=>"border-bottom");
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertIsA($result, 'Spreadsheet_Excel_Writer_Format');
        
        // All parameters are set to null 
        $aFormat = array (0=>NULL);
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);
        
        // Empty array
        $aFormat = array ();
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);
        
        // Not array
        $aFormat = NULL;
        $result = $oExcelWriter->getFormat($aFormat);
        $this->assertNull($result);
    }
}

?>