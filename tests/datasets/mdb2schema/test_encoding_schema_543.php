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

/**
 *
 * @abstract A class for generating/loading a dataset for encoding testing
 * @package Test Classes
 * @author Chris Nutting <chris.nutting@openx.org>
 *
 */

require_once MAX_PATH . '/tests/testClasses/OATestData_MDB2Schema.php';

class OA_Test_Data_encoding_schema_543 extends OA_Test_Data_MDB2Schema
{
    /**
     * method for extending OA_Test_Data_MDB2Schema
     */
    function generateTestData()
    {
        if (!parent::init('test_encoding_schema_543.xml'))
        {
            return false;
        }
        if (!parent::generateTestData())
        {
            return false;
        }
        return true;
    }
}
?>

