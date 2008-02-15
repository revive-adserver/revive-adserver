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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';

/**
 * A class for testing the OA_DB_Table class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_DB_XmlCache extends UnitTestCase
{
    var $oDbh;
    var $oCache;
    var $oSchema;

    /**
     * The constructor method.
     */
    function Test_OA_DB_XmlCache()
    {
        $this->UnitTestCase();

        $this->oDbh    = OA_DB::singleton();
        $this->oCache  = new OA_DB_XmlCache();
        $this->oSchema =& MDB2_Schema::factory($this->oDbh, array('force_defaults'=>false));
    }

    function test_Etc()
    {
        foreach (glob(MAX_PATH.'/etc/tables_*.xml') as $fileName)
        {
            $result = $this->oSchema->parseDatabaseDefinitionFile($fileName, true);
            $this->assertIsA($result,'array','parsed definition is not an array: '.$fileName);
            $cache  = $this->oCache->get($fileName);
            $this->assertIsA($cache,'array','cached definition is not an array: '.$fileName);
            $this->assertEqual($result, $cache, 'FILE: '.$fileName);

            $this->_testPrimaryKey($result);
        }

    }

    /**
     * @todo Remove the hack for schema 049
     *
     */
    function test_EtcChangesSchema()
    {
        foreach (glob(MAX_PATH.'/etc/changes/schema_tables_*.xml') as $fileName)
        {
            $result = $this->oSchema->parseDatabaseDefinitionFile($fileName, true);
            $this->assertIsA($result,'array','parsed definition is not an array: '.$fileName);
            $cache  = $this->oCache->get($fileName);
            $this->assertIsA($cache,'array','cached definition is not an array: '.$fileName);
            $this->assertEqual($result, $cache, 'FILE: '.$fileName);

            $this->_testPrimaryKey($result);
        }
    }

    function test_EtcChangesChanges()
    {
        foreach (glob(MAX_PATH.'/etc/changes/changes_tables_*.xml') as $fileName)
        {
            $result = $this->oSchema->parseChangesetDefinitionFile($fileName);
            $this->assertIsA($result,'array','parsed definition is not an array: '.$fileName);
            $cache  = $this->oCache->get($fileName);
            $this->assertIsA($cache,'array','cached definition is not an array: '.$fileName);
            $this->assertEqual($result, $cache, 'FILE: '.$fileName);
        }
    }

    function _testPrimaryKey($aSchema)
    {
        foreach ($aSchema['tables'] as $tableName => $aTable) {
            foreach ($aTable['indexes'] as $indexName => $aIndex) {
                if (!empty($aIndex['primary'])) {
                    $this->assertEqual("{$tableName}_pkey", $indexName);
                }
            }
        }
    }

}

?>
