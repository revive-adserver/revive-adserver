<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/openads/Dal.php';

/**
 * A class for testing that the required custom MDB2 datatypes, MDB2 datatype
 * to nativetype mappings, and nativetype to MDB2 datatype mappings work as
 * expected.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_Openads_Dal_CustomDatatypes_mysql extends UnitTestCase
{

    var $db;

    /**
     * The constructor method.
     */
    function Test_Openads_Dal_CustomDatatypes_mysql()
    {
        $this->UnitTestCase();
        $this->db = Openads_Dal::singleton();
        $this->db->loadModule('Datatype', null, true);
    }

    /**
     * A method to test that the database nativetype to MDB2 datatype
     * mappings work as expected.
     */
    function testNativetypeToDatatypeMappings()
    {
        $aTestData = array(
            'boolean' => array(
                'default' => '',
                'extra'   => '',
                'key'     => '',
                'name'    => '',
                'type'    => 'boolean'
            )
        );
        $aResultData = array(
            'boolean' => array(
                0    => array('tinyint'),
                1  => '1',
                2 => false,
                3 => null
            )
        );
        foreach ($aTestData as $nativetype => $aFields) {
            $aDefinition = $this->db->datatype->mapNativeDatatype($aFields);
            $this->assertEqual($aDefinition, $aResultData[$nativetype]);
        }
    }

}

?>