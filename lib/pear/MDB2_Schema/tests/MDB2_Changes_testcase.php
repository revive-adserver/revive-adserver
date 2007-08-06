<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Paul Cooper                    |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Author: Paul Cooper <pgc@ucecom.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id$

require_once 'MDB2/Schema.php';

class MDB2_Changes_TestCase extends PHPUnit_TestCase {
    //contains the dsn of the database we are testing
    var $dsn;
    //contains the options that should be used during testing
    var $options;
    //contains the name of the database we are testing
    var $database;
    //contains the MDB2_Schema object of the db once we have connected
    var $schema;
    //contains a list of test schema filenames (inc paths)
    var $aSchemas;

    function MDB2_Changes_Test($name) {
        $this->PHPUnit_TestCase($name);
    }

    function setUp() {
        PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'catchErrorHandlerPEAR');
        $this->dsn = $GLOBALS['dsn'];
        $this->options = $GLOBALS['options'];
        $this->database = $GLOBALS['database'];
        $this->dsn['database'] = $this->database;
        $this->schema =& MDB2_Schema::factory($this->dsn, $this->options);
        if (PEAR::isError($this->schema)) {
            $this->assertTrue(false, 'Could not connect to manager in setUp');
            exit;
        }
        $this->aSchemas = array(
                                1 => SCHEMA_PATH.'schema_1_original.xml',
                                2 => SCHEMA_PATH.'schema_2_newfield.xml',
                                3 => SCHEMA_PATH.'schema_3_primarykey.xml',
                                4 => SCHEMA_PATH.'schema_4_idxfieldorder.xml',
                                5 => SCHEMA_PATH.'schema_5_fieldtype.xml',
                                6 => SCHEMA_PATH.'schema_6_removefield.xml',
                                7 => SCHEMA_PATH.'schema_7_removeindex.xml',
                                8 => SCHEMA_PATH.'schema_8_addtable.xml',
                                9 => SCHEMA_PATH.'schema_9_removetable.xml',
                                10=> SCHEMA_PATH.'schema_10_keyfield.xml'
                                );
    }

    function tearDown() {
        unset($this->dsn);
        if (!PEAR::isError($this->schema)) {
            $this->schema->disconnect();
        }
        unset($this->schema);
    }

    function testNewField()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[1]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[2]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['add']['new_field']), 'added field not found');
    }

    function testPrimaryKey()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[2]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[3]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['indexes']['change']['index1']['primary']), 'primary key index not found');
    }

    function testIdxFieldOrder()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[3]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[4]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['indexes']['change']['index2']), 'index with changed field order not found');
    }

    function testFieldType()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[4]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[5]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['change']['new_field']), 'changed field not found');
        $this->assertEquals($changes['tables']['change']['table1']['change']['new_field']['type'], 'text', 'changed field type is wrong');
    }

    function testRemoveField()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[5]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[6]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['remove']['new_field']), 'removed field not found');
    }

    function testRemoveIndex()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[6]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[7]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['indexes']['remove']['index2']), 'removed index not found');
    }

    function testAddTable()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[7]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[8]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['add']['new_table']), 'added table not found');
    }

    function testRemoveTable()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[8]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[9]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['remove']['new_table']), 'removed table not found');
    }

    /**
     * test that renaming of an autoinc field and affect on primary index
     *
     */
    function testKeyField()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[3]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[10]);
        $changes                        = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $this->assertTrue(isset($changes['tables']['change']['table1']['indexes']['change']['index1']), 'primary index with renamed field not found');
        $this->assertTrue(isset($changes['tables']['change']['table1']['add']['id_field_renamed']), 'renamed key field not found in add array');
    }

    function testDumpSplitChanges()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[1]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[9]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '9';
        $changes_write['name']          = 'changes_split';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = SCHEMA_PATH.'changes_split.xml';
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['constructive']), 'constructive changes not found');
        $this->assertTrue(isset($changes_parse['destructive']), 'destructive changes not found');
    }

    function testDumpNewField()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[1]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[2]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '2';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[2]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['constructive']['tables']['change']['table1']['add']['fields']['new_field']), 'added field not found');
    }

    function testDumpPrimaryKey()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[2]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[3]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '3';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[3]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['constructive']['tables']['change']['table1']['indexes']['add']['index1']['primary']), 'primary field not found');
        $this->assertTrue($changes_parse['constructive']['tables']['change']['table1']['indexes']['add']['index1']['primary'], 'primary field not true');
    }

    function testDumpIdxFieldOrder()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[3]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[4]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '4';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[4]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['tables']['change']['table1']['indexes']['change']['index2']), 'index with changed field order not found');
    }

    function testDumpFieldType()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[4]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[5]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '5';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[5]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['constructive']['tables']['change']['table1']['change']['fields']['new_field']), 'changed field not found');
        $this->assertEquals($changes_parse['constructive']['tables']['change']['table1']['change']['fields']['new_field']['type'], 'text', 'changed field type is wrong');
    }

    function testDumpRemoveField()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[5]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[6]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '6';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[6]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['destructive']['tables']['change']['table1']['remove']['new_field']), 'removed field not found');
    }

    function testDumpRemoveIndex()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[6]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[7]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '7';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[7]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['destructive']['tables']['change']['table1']['indexes']['remove']['index2']), 'removed index not found');
    }

    function testDumpAddTable()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[7]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[8]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '8';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[8]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['constructive']['tables']['add']['new_table']), 'added table not found');
    }

    function testDumpRemoveTable()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[8]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[9]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '9';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[9]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);

        $this->assertTrue(isset($changes_parse['destructive']['tables']['remove']['new_table']), 'removed table not found');
    }

    /**
     * test the renaming of an autoinc field and affect on primary index
     * this test xml file 10 does not *upgrade* from test 9 but test 3 instead
     *
     * you cannot add a primary key field to a table with an existing primary key field and primary index
     * you cannot drop a primary index on a table with an autoincremnt field
     * therefore we have to rename that field, the index will follow automatically
     *
     */
    function testDumpKeyField()
    {
        $prev_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[3]);
        $curr_definition                = $this->schema->parseDatabaseDefinitionFile($this->aSchemas[10]);
        $changes_write                  = $this->schema->compareDefinitions($curr_definition, $prev_definition);

        $changes_write['version']       = '10';
        $changes_write['name']          = 'changes_test';
        $changes_write['comments']      = '';
        $options['split']               = true;
        $options['output']              = str_replace('schema', 'changes', $this->aSchemas[10]);
        $options['xsl_file']            = "";
        $options['output_mode']         = 'file';
        $result                         = $this->schema->dumpChangeset($changes_write, $options);
        $changes_parse                  = $this->schema->parseChangesetDefinitionFile($options['output']);


        $this->assertFalse(isset($changes_parse['constructive']['tables']['change']['table1']['indexes']['change']['index1']), 'primary index with renamed field found in change array');
        $this->assertFalse(isset($changes_parse['constructive']['tables']['change']['table1']['add']['id_field_renamed']), 'renamed key field found in add array');
        $this->assertTrue(isset($changes_parse['constructive']['tables']['change']['table1']['rename']['fields']['id_field_renamed']), 'renamed key field not found in rename array');
    }



}

?>