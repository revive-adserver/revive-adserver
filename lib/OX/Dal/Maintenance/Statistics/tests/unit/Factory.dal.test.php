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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OX/Dal/Maintenance/Statistics/Factory.php';

/**
 * A class for testing the OX_Dal_Maintenance_Statistics_Factory class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Dal_Maintenance_Statistics_Factory extends UnitTestCase
{

    /**
     * The database type in use.
     *
     * @var string
     */
    var $dbType = '';

    /**
     * The constructor method.
     */
    function Test_OX_Dal_Maintenance_Statistics_Factory()
    {
        $this->UnitTestCase();
        $oDbh =& OA_DB::singleton();
        $this->dbType = $oDbh->dsn['phptype'];
    }

    /**
     * Test the creation.
     */
    function testCreate()
    {
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $classname = $oFactory->_deriveClassName();
        $this->assertEqual($classname, 'OX_Dal_Maintenance_Statistics_' . ucfirst(strtolower($this->dbType)));
    }

}

?>