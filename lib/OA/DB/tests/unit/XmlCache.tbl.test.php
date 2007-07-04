<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';

/**
 * A class for testing the OA_DB_Table class.
 *
 * @package    OpenadsDB
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class Test_OA_DB_XmlCache extends UnitTestCase
{
    var $oDbh;
    var $oCache;
    var $aOptions;
    
    /**
     * The constructor method.
     */
    function Test_OA_DB_XmlCache()
    {
        $this->UnitTestCase();
        
        $this->oDbh    = OA_DB::singleton();
        $this->oCache  = new OA_DB_XmlCache();
        $this->aOption = array('force_defaults'=>false);

    }

    function test_Etc()
    {
        foreach (glob(MAX_PATH.'/etc/tables_*.xml') as $fileName) {
            $oSchema = &MDB2_Schema::factory($this->oDbh, $this->aOptions);
            $result = $oSchema->parseDatabaseDefinitionFile($fileName, true);
            $cache  = $this->oCache->get($fileName);
            $this->assertEqual($result, $cache);
        }
        
    }

    function test_EtcChangesSchema()
    {
        foreach (glob(MAX_PATH.'/etc/changes/schema_tables_*.xml') as $fileName) {
            $oSchema = &MDB2_Schema::factory($this->oDbh, $this->aOptions);
            $result = $oSchema->parseDatabaseDefinitionFile($fileName, true);
            $cache  = $this->oCache->get($fileName);
            $this->assertEqual($result, $cache);
        }
    }

    function test_EtcChangesChanges()
    {
        foreach (glob(MAX_PATH.'/etc/changes/changes_tables_*.xml') as $fileName) {
            $oSchema = &MDB2_Schema::factory($this->oDbh, $this->aOptions);
            $result = $oSchema->parseChangesetDefinitionFile($fileName);
            $cache  = $this->oCache->get($fileName);
            $this->assertEqual($result, $cache);
        }
    }

}

?>
