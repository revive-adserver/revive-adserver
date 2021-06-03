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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';

/**
 * A class for testing the OA_DB_Table class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB_XmlCache extends UnitTestCase
{
    var $oDbh;
    var $oCache;
    var $oSchema;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();

        $this->oDbh    = OA_DB::singleton();
        $this->oCache  = new OA_DB_XmlCache();
        $this->oSchema = MDB2_Schema::factory($this->oDbh, array('force_defaults'=>false));
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
