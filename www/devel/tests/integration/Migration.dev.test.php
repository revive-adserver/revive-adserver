<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
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
$Id $
*/


//require_once MAX_PATH.'/lib/OA/DB.php';
//require_once MAX_PATH.'/lib/OA/DB/Table.php';
//
//require_once MAX_PATH.'/www/devel/lib/openads/DB_Upgrade.php';
require_once MAX_PATH.'/www/devel/lib/openads/Migration.php';


/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    Openads Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class Test_Migration extends UnitTestCase
{

    var $path;

    var $aChangesVars;
    var $aOptions;

    /**
     * The constructor method.
     */
    function Test_Migration()
    {
        $this->UnitTestCase();

        $this->aChangesVars['version']       = '2';
        $this->aChangesVars['name']          = 'changes_test';
        $this->aChangesVars['comments']      = '';
        $this->aOptions['split']             = true;
        $this->aOptions['output']            = MAX_PATH.'/var/changes_test.xml';
        $this->aOptions['xsl_file']          = "";
        $this->aOptions['output_mode']       = 'file';
    }

    function test_copyColumnData()
    {
        $oMigration = new Migration();
    }

    function test_copyTableData()
    {
        $oMigration = new Migration();
    }
}

?>
