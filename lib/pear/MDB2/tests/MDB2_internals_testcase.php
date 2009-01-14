<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2009 OpenX Limited                                |
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
// | Author: Monique Szpak <monique.szpak@openads.org>                    |
// |         Andrew Hill <andrew.hill@openads.org>                        |
// +----------------------------------------------------------------------+
//
// $Id$

require_once 'MDB2_testcase.php';

class MDB2_Internals_TestCase extends MDB2_TestCase {

    var $clear_tables = false;

    /**
     * Tests that the MDB2::apiVersion() method returns an API version number.
     */
    function test_apiVersion()
    {
        $result = MDB2::apiVersion();
        $this->assertNotNull($result, 'apiVersion');
        $result = strtok($result, '.');
        $this->assertTrue(is_numeric($result), 'apiVersion');
        $result = strtok('.');
        $this->assertTrue(is_numeric($result), 'apiVersion');
        $result = strtok('.');
        $this->assertTrue(is_numeric($result), 'apiVersion');
    }

    /**
     * Tests that the MDB2::classExists() method correctly tests for
     * existence of a class.
     */
    function test_classExists()
    {
        $this->assertFalse(MDB2::classExists('null'), 'classExists');
        $this->assertTrue(MDB2::classExists('MDB2'), 'classExists');
    }

    /**
     * Tests that the MDB2::loadClass() method correctly loads classes.
     */
    function test_loadClass()
    {
        $this->assertTrue(MDB2::loadClass('MDB2', false), 'loadClass');
        // Suppress handling of PEAR errors while testing next case
        PEAR::pushErrorHandling(null);
        $result = MDB2::loadClass('null', false);
        $this->assertTrue(is_a($result, 'pear_error'), 'loadClass');
        PEAR::popErrorHandling();
    }

    /**
     * Tests that the MDB2::factory() method correctly connects to a
     * database.
     */
    function test_factory()
    {
        $db =& MDB2::factory($this->dsn);
        $this->assertTrue(MDB2::isConnection($db), 'factory');
        // Suppress handling of PEAR errors while preparing the
        // next test case database connection
        PEAR::pushErrorHandling(null);
        $db =& MDB2::factory(null);
        PEAR::popErrorHandling();
        $this->assertFalse(MDB2::isConnection($db), 'factory');
    }

    /**
     * Tests that the MDB2::loadFile() method returns the expected
     * filename.
     */
    function test_loadFile()
    {
        $filename = 'Extended';
        $this->assertEquals('MDB2/'.$filename.'.php', MDB2::loadFile($filename), 'loadFile');
    }

    /**
     * Tests that the MDB2::isConnection() method correctly reports
     * connections.
     */
    function test_isConnection()
    {
        $this->assertTrue(MDB2::isConnection($this->db), 'isConnection');
        $this->assertFalse(MDB2::isConnection(null), 'isConnection');
    }

    /**
     * Tests that the MDB2::isResult() method correctly identifies
     * results.
     */
    function test_isResult()
    {
        $obj = new MDB2_Result();
        $this->assertTrue(MDB2::isResult($obj), 'isResult');
        $obj = null;
        $this->assertFalse(MDB2::isResult($obj), 'isResult');
    }

    /**
     * Tests that the MDB2::isResultCommon() method correctly identifies
     * common results.
     */
    function test_isResultCommon()
    {
        $result = null;
        $obj = new MDB2_Result_Common($this->db, $result);
        $this->assertTrue(MDB2::isResultCommon($obj), 'isResultCommon');
        $obj = null;
        $this->assertFalse(MDB2::isResultCommon($obj), 'isResultCommon');
    }

    /**
     * Tests that the MDB2::parseDSN() method works.
     */
    function test_parseDSN()
    {
        $dsn = $this->dsn;
        $result = MDB2::parseDSN($dsn);
        $this->assertEquals($dsn['phptype'],$result['dbsyntax'],'parseDSN');

        $dsn = "mydbms://myname:mypassword@localhost";
        $result = MDB2::parseDSN($dsn);
        $this->assertEquals('mydbms', $result['phptype'],'parseDSN');
        $this->assertEquals('mydbms',$result['dbsyntax'],'parseDSN');
        $this->assertEquals('tcp',$result['protocol'],'parseDSN');
        $this->assertEquals('localhost',$result['hostspec'],'parseDSN');
        $this->assertEquals(false,$result['port'],'parseDSN');
        $this->assertEquals(false,$result['socket'],'parseDSN');
        $this->assertEquals('myname',$result['username'],'parseDSN');
        $this->assertEquals('mypassword',$result['password'],'parseDSN');
        $this->assertEquals(false,$result['database'],'parseDSN');

        $dsn = "somesql://myname:mypassword@localhost:1234/mydb";
        $result = MDB2::parseDSN($dsn);
        $this->assertEquals('somesql',$result['phptype'],'parseDSN');
        $this->assertEquals('somesql',$result['dbsyntax'],'parseDSN');
        $this->assertEquals('tcp',$result['protocol'],'parseDSN');
        $this->assertEquals('localhost',$result['hostspec'],'parseDSN');
        $this->assertEquals('1234',$result['port'],'parseDSN');
        $this->assertEquals(false,$result['socket'],'parseDSN');
        $this->assertEquals('myname',$result['username'],'parseDSN');
        $this->assertEquals('mypassword',$result['password'],'parseDSN');
        $this->assertEquals('mydb',$result['database'],'parseDSN');

        $dsn = "dbms1://myname@unix(opts)/mydb?param1=value1";
        $result = MDB2::parseDSN($dsn);
        $this->assertEquals('dbms1',$result['phptype'],'parseDSN');
        $this->assertEquals('dbms1',$result['dbsyntax'],'parseDSN');
        $this->assertEquals('unix',$result['protocol'],'parseDSN');
        $this->assertEquals(false,$result['hostspec'],'parseDSN');
        $this->assertEquals(false,$result['port'],'parseDSN');
        $this->assertEquals('opts',$result['socket'],'parseDSN');
        $this->assertEquals('myname',$result['username'],'parseDSN');
        $this->assertEquals(false,$result['password'],'parseDSN');
        $this->assertEquals('mydb',$result['database'],'parseDSN');
        $this->assertEquals('value1',$result['param1'],'parseDSN');
    }

    /**
     * Tests that the MDB2::fileExists() method correctly identifies
     * existing/non-existing files.
     */
    function test_fileExists()
    {
        $this->assertTrue(MDB2::fileExists('PEAR.php'), 'fileExists');
        $this->assertFalse(MDB2::fileExists('itIsHopedThatNoOneHasAFileWithThisName.php'), 'fileExists');
    }

    /**
     * Tests that the MDB2::__toString() method returns the expected
     * string result.
     */
    function test__toString()
    {
        $expected = "MDB2_Driver_{$this->dsn['phptype']}: (phptype = {$this->dsn['phptype']}, dbsyntax = {$this->db->dbsyntax})";
        if (version_compare(PHP_VERSION, "5.0.0", "<")) {
            $expected = strtolower($expected);
        }
        $this->assertEquals($expected ,$this->db->__toString(), '__toString');
    }

    /**
     * Tests that the MDB2::setFetchMode() method correctly sets the
     * fetch mode.
     */
    function test_setFetchMode()
    {
        $tmp = $this->db->fetchmode;
        $this->db->setFetchMode(MDB2_FETCHMODE_OBJECT);
        $this->assertEquals('stdClass', $this->db->options['fetch_class'], 'setFetchMode');
        $this->db->setFetchMode(MDB2_FETCHMODE_ORDERED);
        $this->assertEquals(MDB2_FETCHMODE_ORDERED, $this->db->fetchmode, 'setFetchMode');
        $this->db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        $this->assertEquals(MDB2_FETCHMODE_ASSOC, $this->db->fetchmode, 'setFetchMode');
        $this->db->fetchmode = $tmp;
    }

    /**
     * Tests that the MDB2::escape() method correctly escapes strings.
     */
    function test_escape()
    {
        $tmp = $this->db->string_quoting;
        $this->string_quoting['escape'] = '\\';
        $this->string_quoting['end'] = '"';
        $text = 'xxx"z"xxx';
        $this->assertEquals('xxx\"z\"xxx', MDB2_Driver_Common::escape($text), 'escape');
        $this->db->string_quoting = $tmp;
    }

    /**
     * Tests that the MDB2::quoteIdentifier() method correctly quotes strings.
     */
    function test_quoteIdentifier()
    {
        $tmp = $this->db->identifier_quoting;
        $this->db->identifier_quoting['start'] = '"';
        $this->db->identifier_quoting['end'] = '`';
        $this->db->identifier_quoting['escape'] = '/';
        $text = 'my`identifier';
        $this->assertEquals('"my/`identifier`', $this->db->quoteIdentifier($text), 'quoteIdentifier');
        $this->db->identifier_quoting = $tmp;
    }

    /**
     * Tests that the MDB2::getAsKeyword() method correctly returns
     * the set "as" keyword.
     */
    function test_getAsKeyword()
    {
        $tmp = $this->db->as_keyword;
        $this->db->as_keyword = 'ALIAS';
        $this->assertEquals('ALIAS', $this->db->getAsKeyword(), 'getAsKeyword');
        $this->db->as_keyword = $tmp;
    }

    /**
     * Tests that the MDB2::getConnection() method correctly returns
     * a database resource.
     */
    function test_getConnection()
    {
        $result = $this->db->getConnection();
        $this->assertTrue(is_resource($result), 'getConnection');
    }

    /**
     * A private method to return a defined "row" of data for use
     * in the next set of tests.
     *
     * @access private
     * @return array The array of "row" data.
     */
    function _fetchRowData()
    {
        return array(
            0         => '',
            1         => 'notnull',
            2         => 'length7   ',
            '1?2:3.4' => 'assoc'
        );
    }

    /**
     * A private method to test results from the MDB2::_fixResultArrayValues()
     * method when the $mode parameter was set to MDB2_PORTABILITY_EMPTY_TO_NULL.
     *
     * @access private
     * @param array $row The result of the call to MDB2::_fixResultArrayValues().
     */
    function _fixResultArrayValues_Test_EmptyToNull($row)
    {
        $this->assertNull($row[0], '_fixResultArrayValues');
        $this->assertNotNull($row[1], '_fixResultArrayValues');
        $this->assertNotNull($row[2], '_fixResultArrayValues');
    }

    /**
     * A private method to test results from the MDB2::_fixResultArrayValues()
     * method when the $mode parameter was set to MDB2_PORTABILITY_RTRIM.
     *
     * @access private
     * @param array $row The result of the call to MDB2::_fixResultArrayValues().
     */
    function _fixResultArrayValues_Test_Rtrim($row)
    {
        $this->assertEquals(strlen($row[0]), 0, '_fixResultArrayValues');
        $this->assertEquals(strlen($row[1]), 7, '_fixResultArrayValues');
        $this->assertEquals(strlen($row[2]), 7, '_fixResultArrayValues');
    }

    /**
     * A private method to test results from the MDB2::_fixResultArrayValues()
     * method when the $mode parameter was set to MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES.
     *
     * @access private
     * @param array $row The result of the call to MDB2::_fixResultArrayValues().
     */
    function _fixResultArrayValues_Test_FixAssocFieldNames($row)
    {
        $this->assertTrue(array_key_exists(4, $row), '_fixResultArrayValues');
        $this->assertTrue($row[4] == 'assoc', '_fixResultArrayValues');
    }

    /**
     * Tests that the MDB2::_fixResultArrayValues() method fixes array
     * values when used with various $mode parameters.
     */
    function test__fixResultArrayValues()
    {
        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_EmptyToNull($row);

        $mode = MDB2_PORTABILITY_RTRIM;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_Rtrim($row);

        $mode = MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_FixAssocFieldNames($row);

        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL + MDB2_PORTABILITY_RTRIM;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_EmptyToNull($row);
        $this->_fixResultArrayValues_Test_Rtrim($row);

        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL + MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_EmptyToNull($row);
        $this->_fixResultArrayValues_Test_FixAssocFieldNames($row);

        $mode = MDB2_PORTABILITY_RTRIM + MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_Rtrim($row);
        $this->_fixResultArrayValues_Test_FixAssocFieldNames($row);

        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL + MDB2_PORTABILITY_RTRIM + MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->_fetchRowData();
        $this->db->_fixResultArrayValues($row, $mode);
        $this->_fixResultArrayValues_Test_EmptyToNull($row);
        $this->_fixResultArrayValues_Test_Rtrim($row);
        $this->_fixResultArrayValues_Test_FixAssocFieldNames($row);
    }

    /**
     * Tests that the MDB2::transaction() method returns expected values
     * when starting or rolling back a transaction, and for testing if
     * the connection is in a transaction.
     */
    function test_transaction()
    {
        if (!$this->db->supports('transactions'))
        {
            $this->assertTrue($this->db->beginTransaction(), 'transaction');
            $this->assertTrue($this->db->in_transaction, 'transaction');
            $this->assertTrue($this->db->rollback(), 'transaction');
            $this->assertFalse($this->db->in_transaction, 'transaction');

            $this->assertTrue($this->db->beginTransaction(), 'transaction');
            $this->assertTrue($this->db->in_transaction, 'transaction');
            $this->assertTrue($this->db->commit(), 'transaction');
            $this->assertFalse($this->db->in_transaction, 'transaction');
        }
    }

    // Nested transactions are not yet tested, due to a MySQL 5 problem with
    // savepoints causing netsted transactions to fail.
    //
    // See http://bugs.mysql.com/bug.php?id=26288

    /**
     * Tests that the MDB2::setDatabase() and MDB2::getDatabase() methods
     * correctly set and get the database name.
     */
    function test_setGetDatabase()
    {
        $old_name = $this->db->database_name;
        $this->assertEquals($old_name, $this->db->setDatabase('test_database'), 'setDatabase');
        $this->assertEquals('test_database', $this->db->database_name, 'setDatabase');
        $this->assertEquals('test_database', $this->db->getDatabase(), 'getDatabase');
        $this->db->database_name = $old_name;
    }

    /**
     * Tests that the MDB2::setDSN() method correctly sets
     * the DSN.
     */
    function test_setDSN()
    {
        $dsn = "mydbms://myname:mypassword@localhost";
        $result = $this->db->setDSN($dsn);
        $dsn_set = $this->db->dsn;

        $this->assertEquals('mydbms', $dsn_set['phptype'],'setDSN');
        $this->assertEquals('mydbms',$dsn_set['dbsyntax'],'setDSN');
        $this->assertEquals('tcp',$dsn_set['protocol'],'setDSN');
        $this->assertEquals('localhost',$dsn_set['hostspec'],'setDSN');
        $this->assertEquals(false,$dsn_set['port'],'setDSN');
        $this->assertEquals(false,$dsn_set['socket'],'setDSN');
        $this->assertEquals('myname',$dsn_set['username'],'setDSN');
        $this->assertEquals('mypassword',$dsn_set['password'],'setDSN');
        $this->assertEquals(false,$dsn_set['database'],'setDSN');
    }

    /**
     * Tests that the MDB2::getDSN() method correctly gets
     * the DSN.
     */
    function test_getDSN()
    {
        $dsn_set = "mydbms://myname:mypassword@localhost";
        $result = $this->db->setDSN($dsn_set);
        $dsn_get = $this->db->getDSN();
        $dsn_rex = "/(([\w]+)\(mydbms\):\/\/myname:mypassword@localhost\/)/";
        //preg_match($dsn_rex, $dsn_get, $matches);
        $this->assertRegExp($dsn_rex, $dsn_get, 'testGetDSN');
        $dsn_rex = "/{$this->dsn['phptype']}[\w\W]+/";
        $this->assertRegExp($dsn_rex, $dsn_get, 'testGetDSN');

        $dsn_set = "mydbms://myname:mypassword@localhost";
        $result = $this->db->setDSN($dsn_set);
        $dsn_get = $this->db->getDSN('string', true);
        $dsn_rex = "/(([\w]+)\(mydbms\):\/\/myname:1@localhost\/)/";
        $this->assertRegExp($dsn_rex, $dsn_get, 'testGetDSN');
        $dsn_rex = "/{$this->dsn['phptype']}[\w\W]+/";
        $this->assertRegExp($dsn_rex, $dsn_get, 'testGetDSN');

    }

    /**
     * Tests that the MDB2::setLimit() method correctly sets the limit
     * and offset values.
     */
    function test_setLimit()
    {
        if (!$this->db->supports('limit_queries'))
        {
            $this->db->limit = null;
            $this->db->offset = null;
            $this->db->setLimit(100, 50);
            $this->assertEquals(100, $this->db->limit , 'setLimit');
            $this->assertEquals( 50, $this->db->offset, 'setLimit');
        }
    }

    /**
     * Tests that the MDB2::supports() method correctly finds keys
     * in the "supports" array.
     */
    function test_supports()
    {
        $this->db->supports['testkey'] = true;
        $this->assertTrue($this->db->supports('testkey'), 'supports');
        unset($this->db->supports['testkey']);
    }

    /**
     * Tests that the MDB2::getSequenceName() method correctly gets
     * sequence names.
     */
    function test_getSequenceName()
    {
        $tmp = $this->db->options['seqname_format'];
        $this->db->options['seqname_format'] = '%s_seq';
        $this->assertEquals('test_seq', $this->db->getSequenceName('test'), 'getSequenceName');
        $this->db->options['seqname_format'] = $tmp;
    }

    /**
     * Tests that the MDB2::getIndexName() method correctly gets
     * index names.
     */
    function test_getIndexName()
    {
        $tmp = $this->db->options['idxname_format'];
        $this->db->options['idxname_format'] = 'idx_%s';
        $this->assertEquals('idx_test', $this->db->getIndexName('test'), 'getIndexName');
        $this->db->options['idxname_format'] = $tmp;
    }

    /**
     * Tests that the MDB2::disconnect() method correctly disconnects.
     */
    function test_disconnect()
    {
        $this->assertTrue($this->db->disconnect(), 'disconnect');
        $this->assertEquals(0, $this->db->connection, 'disconnect');
        $this->assertEquals(array(), $this->db->connected_dsn, 'disconnect');
        $this->assertEquals('', $this->db->connected_database_name, 'disconnect');
        $this->assertNull($this->db->opened_persistent, 'disconnect');
        $this->assertEquals('', $this->db->connected_server_info, 'disconnect');
        $this->assertNull($this->db->in_transaction, 'disconnect');
        $this->assertEquals(0, $this->db->nested_transaction_counter, 'disconnect');
    }

}

?>