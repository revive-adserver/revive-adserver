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

require_once 'MDB2_testcase.php';

class MDB2_Internals_TestCase extends MDB2_TestCase {
    var $clear_tables = false;

    function test_apiVersion()
    {
        $this->assertNotNull(MDB2::apiVersion(),'apiVersion');
    }

    function test_classExists()
    {
        $this->assertTrue(MDB2::classExists('MDB2'), 'classExists');
        $this->assertFalse(MDB2::classExists('null'), 'classExists');
    }

    function test_loadClass()
    {
        $this->assertTrue(MDB2::loadClass('MDB2', false));
    }

    function test_factory()
    {
        $db =& MDB2::factory($this->dsn);
        $this->assertTrue(MDB2::isConnection($db));
    }

    function test_loadFile()
    {
        $filename = 'Extended';
        $this->assertEquals('MDB2/'.$filename.'.php', MDB2::loadFile($filename));
    }

    function test_isConnection()
    {
        $this->assertTrue(MDB2::isConnection($this->db), 'isConnection');
        $this->assertFalse(MDB2::isConnection(null), 'isConnection');
    }

    function test_isResult()
    {
        $obj = new MDB2_Result();
        $this->assertTrue(MDB2::isResult($obj), 'isResult');
    }

    function test_isResultCommon()
    {
        $result = null;
        $obj = new MDB2_Result_Common($this->db, $result);
        $this->assertTrue(MDB2::isResultCommon($obj), 'isResultCommon');
    }

    function test_isStatement()
    {
        // MS
        // SOMETHING WRONG WITH THE isStatement method?  class does not exist
        // can't find method used anywhere
//        $statement = null;
//        $obj = new MDB2_Statement_Common($this->db, $statement, array(), '', array(), array());
//        $this->assertTrue(MDB2::isStatement($obj), 'isStatement - NOT CALLED ANYWHERE?');
    }

    function test_parseDSN()
    {
        // test merge dsn arrays
        $dsn = $this->dsn;
        //unset($dsn['dbsyntax']);
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

    function test_fileExists()
    {
        $this->assertTrue(MDB2::fileExists('PEAR.php'), 'fileExists');
    }

    function test__toString()
    {
        $this->assertEquals("MDB2_Driver_{$this->dsn['phptype']}: (phptype = {$this->dsn['phptype']}, dbsyntax = {$this->db->dbsyntax})",$this->db->__toString(), '__toString');
    }

    function test_setFetchMode()
    {
        $tmp = $this->db->fetchmode;
        $this->db->setFetchMode(MDB2_FETCHMODE_OBJECT);
        $this->assertEquals('stdClass',$this->db->options['fetch_class'], 'setFetchMode');
        $this->db->setFetchMode(MDB2_FETCHMODE_ORDERED);
        $this->assertEquals(MDB2_FETCHMODE_ORDERED, $this->db->fetchmode, 'setFetchMode');
        $this->db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        $this->assertEquals(MDB2_FETCHMODE_ASSOC,$this->db->fetchmode, 'setFetchMode');
        $this->db->fetchmode = $tmp;
    }

    function test_escapePattern()
    {
        $tmp = $this->db->string_quoting;
        $this->db->string_quoting['escape_pattern'] = '/';
        $text = 'xxx%xxx';
        $this->assertEquals('xxx/%xxx', $this->db->escapePattern($text), 'testEscapePattern');
        $text = 'xxx/%xxx';
        $this->assertEquals('xxx///%xxx', $this->db->escapePattern($text), 'testEscapePattern');
        $this->db->string_quoting = $tmp;
    }

    function test_escape()
    {
        // MS
        // bodge alert!
        // calling class statically causes it to infer $this as class MDB2_api_testcase
        // this is a php quirk
        $tmp = $this->db->string_quoting;
        $this->string_quoting['escape'] = '\\';
        $this->string_quoting['end'] = '"';
        $text = 'xxx"z"xxx';
//        if ($this->db->dbsyntax == 'mysql')
//        {
//            // mysql driver calls @mysql_real_escape_string
//            // should check magic_quotes?
//            $this->assertEquals('xxx\"z\"xxx', $this->db->escape($text), 'escape');
//        }
//        else
//        {
            $this->assertEquals('xxx\"z\"xxx', MDB2_Driver_Common::escape($text), 'escape');
//        }
        $this->db->string_quoting = $tmp;
    }

    function test_quoteIdentifier()
    {
        $tmp = $this->db->identifier_quoting;
        $this->db->identifier_quoting['escape'] = '/';
        $this->db->identifier_quoting['end'] = '`';
        $text = 'my`identifier';
        $this->assertEquals('`my/`identifier`', $this->db->quoteIdentifier($text), 'quoteIdentifier');
        $this->db->identifier_quoting = $tmp;
    }

    function test_getAsKeyword()
    {
        $tmp = $this->db->as_keyword;
        $this->db->as_keyword = 'ALIAS';
        $this->assertEquals('ALIAS', $this->db->getAsKeyword(), 'getAsKeyword');
        $this->db->as_keyword = $tmp;
    }

    function test_getConnection()
    {
        $result = $this->db->getConnection();
        $this->assertTrue(is_resource($result), 'getConnection');
        //$this->assertType($result, $this->dsn['phptype'].'_link');
    }

    function fetchRowData()
    {
        return array(
                        0=>'',
                        1=>'notnull',
                        2=>'length7   ',
                        '1?2:3.4'=>'assoc'
                    );
    }

    function test__fixResultArrayValues_EmptyToNull(&$row='', $mode='', $sender='_fixResultArrayValues_EmptyToNull')
    {
        $row = (!$row ? $this->fetchRowData() : $row );
        $mode = (!$mode ? MDB2_PORTABILITY_EMPTY_TO_NULL : $mode );

        // check integrity of input data
        //$this->assertNotNull($row[0], $sender);

        $this->db->_fixResultArrayValues($row, $mode);
        $this->assertNull($row[0], $sender);
        $this->assertNotNull($row[1], $sender);
    }

    function test__fixResultArrayValues_Rtrim(&$row='', $mode='', $sender='_fixResultArrayValues_Rtrim')
    {
        $row = (!$row ? $this->fetchRowData() : $row );
        $mode = (!$mode ? MDB2_PORTABILITY_RTRIM : $mode );

        // check integrity of input data
        //$this->assertEquals(10, strlen($row[2]),$sender);

        $this->db->_fixResultArrayValues($row, $mode);
        $this->assertEquals(7, strlen($row[2]),$sender);
    }

    function test__fixResultArrayValues_AssocFieldNames(&$row='', $mode='', $sender='_fixResultArrayValues_AssocFieldNames')
    {
        $row = (!$row ? $this->fetchRowData() : $row );
        $mode = (!$mode ? MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES : $mode );

        $this->db->_fixResultArrayValues($row, $mode);
        $this->assertTrue(array_key_exists(4, $row) && ($row[4]=='assoc'), $sender);
    }

    function test__fixResultArrayValues_EmptyToNull_Rtrim()
    {
        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL + MDB2_PORTABILITY_RTRIM;
        $row = $this->fetchRowData();
        $this->test__fixResultArrayValues_EmptyToNull($row, $mode, '_fixResultArrayValues_EmptyToNull_Rtrim');
        $this->test__fixResultArrayValues_Rtrim($row, $mode, '_fixResultArrayValues_EmptyToNull_Rtrim');
    }

    function test__fixResultArrayValues_EmptyToNull_AssocFieldNames()
    {
        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL + MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->fetchRowData();
        $this->test__fixResultArrayValues_EmptyToNull($row, $mode, 'fixResultArrayValues_EmptyToNull_AssocFieldNames');
        $this->test__fixResultArrayValues_AssocFieldNames($row, $mode, 'fixResultArrayValues_EmptyToNull_AssocFieldNames');
    }

    function test__fixResultArrayValues_Rtrim_AssocFieldNames()
    {
        $mode = MDB2_PORTABILITY_RTRIM + MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->fetchRowData();
        $this->test__fixResultArrayValues_Rtrim($row, $mode, '_fixResultArrayValues_Rtrim_AssocFieldNames');
        $this->test__fixResultArrayValues_AssocFieldNames($row, $mode, '_fixResultArrayValues_Rtrim_AssocFieldNames');
    }

    function test__fixResultArrayValues_EmptyToNull_Rtrim_AssocFieldNames()
    {
        $mode = MDB2_PORTABILITY_EMPTY_TO_NULL + MDB2_PORTABILITY_RTRIM + MDB2_PORTABILITY_FIX_ASSOC_FIELD_NAMES;
        $row = $this->fetchRowData();
        $this->test__fixResultArrayValues_EmptyToNull($row, $mode, '_fixResultArrayValues_EmptyToNull_Rtrim_AssocFieldNames');
        $this->test__fixResultArrayValues_Rtrim($row, $mode, '_fixResultArrayValues_EmptyToNull_Rtrim_AssocFieldNames');
        $this->test__fixResultArrayValues_AssocFieldNames($row, $mode, '_fixResultArrayValues_EmptyToNull_Rtrim_AssocFieldNames');
    }

    function test__call()
    {
    }

    function test_transaction()
    {
        if (!$this->db->supports('transactions'))
        {
            $this->assertTrue($this->db->beginTransaction(), 'testTransaction');
            $this->assertTrue($this->db->in_transaction, 'testTransaction');
            $this->assertTrue($this->db->rollback(), 'testTransaction: rollback');
            $this->assertFalse($this->db->in_transaction, 'testTransaction: rollback');

            $this->assertTrue($this->db->beginTransaction(), 'testTransaction');
            $this->assertTrue($this->db->in_transaction, 'testTransaction');
            $this->assertTrue($this->db->commit(), 'testTransaction: commit');
            $this->assertFalse($this->db->in_transaction, 'testTransaction: commit');
        }
    }

    // MYSQL 5 PROBLEM WITH SAVEPOINTS CAUSE NESTED TRANSACTIONS TO FAIL
    // http://bugs.mysql.com/bug.php?id=26288
    // savepoints not deleted on commit
    // savepoints not exist on rollback
    // Version:	5.0.36bk, 5.1 - Verified

    function test_nestedTransaction()
    {
//        if (!$this->db->supports('transactions'))
//        {
//            $depth = 4;
//            for($i=1;$i<=$depth;$i++)
//            {
//                $this->assertTrue($this->db->beginNestedTransaction(), 'testNestedTransaction: (begin): depth='.$i);
//                $this->assertEquals($i, $this->db->nested_transaction_counter, 'testNestedTransaction: (begin): '.$this->db->last_query);
//            }
//            for($i=$depth;$i>=0;$i--)
//            {
//                // MS
//                // problem with complete?
//                // SAVEPOINT does not exist
//                // error with supporting savepoints in mysql driver?
//                $this->assertTrue($this->db->completeNestedTransaction(true), 'testNestedTransaction: (complete): depth='.$i);
//                if ($i>1)
//                {
//                    $this->assertEquals($i-1, $this->db->nested_transaction_counter, 'testNestedTransaction: (complete): '.$this->db->last_query);
//                }
//                else
//                {
//                    $this->assertNull($this->db->nested_transaction_counter, 'testNestedTransaction: (complete): '.$this->db->last_query);
//                }
//            }
//        }
    }

    function test_failNestedTransactionDelayed()
    {
        if (!$this->db->supports('transactions'))
        {
//             start new transaction
//            $this->assertTrue($this->db->beginNestedTransaction(), 'testFailNestedTransactionDelayed');
//            $this->assertEquals(1, $this->db->nested_transaction_counter, 'testFailNestedTransactionDelayed');
//
//             do not fail immediately - returns true
//            $this->assertTrue($this->db->failNestedTransaction(true, false), 'testFailNestedTransactionDelayed');
//            $this->assertEquals(1, $this->db->nested_transaction_counter, 'testFailNestedTransactionDelayed');
//            $this->assertTrue($this->db->has_transaction_error, 'testFailNestedTransactionDelayed');
//            $this->assertTrue($this->db->rollback(), 'testFailNestedTransactionDelayed: rollback');
//            $this->assertTrue($this->db->completeNestedTransaction(), 'testFailNestedTransactionDelayed: (complete)');
//            $this->assertFalse($this->db->has_transaction_error, 'testFailNestedTransactionImmediate');
//            $this->assertNull($this->db->nested_transaction_counter, 'testFailNestedTransactionDelayed');
        }
    }

    function test_failNestedTransactionImmediate()
    {
        if (!$this->db->supports('transactions'))
        {
//             start new transaction
//            $this->assertTrue($this->db->beginNestedTransaction(), 'testFailNestedTransactionImmediate');
//            $this->assertEquals(1, $this->db->nested_transaction_counter, 'testFailNestedTransactionImmediate');
//
//             fail immediately - this calls a rollback
//            $this->assertTrue($this->db->failNestedTransaction(true, true), 'testFailNestedTransactionImmediate');
//            $this->assertTrue($this->db->has_transaction_error, 'testFailNestedTransactionImmediate');
//            $this->assertTrue($this->db->completeNestedTransaction(), 'testFailNestedTransactionImmediate: (complete)');
//            $this->assertFalse($this->db->has_transaction_error, 'testFailNestedTransactionImmediate');
//            $this->assertNull($this->db->nested_transaction_counter, 'testFailNestedTransactionImmediates');
        }
    }

    function test_setGetDatabase()
    {
        $old_name = $this->db->database_name;
        $this->assertEquals($old_name, $this->db->setDatabase('test_database'), 'setDatabase');
        $this->assertEquals('test_database', $this->db->database_name, 'setDatabase');
        $this->assertEquals('test_database', $this->db->getDatabase(), 'getDatabase');
        $this->db->database_name = $old_name;
    }

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

    function test_standaloneQuery()
    {

    }

//    function &standaloneQuery($query, $types = null, $is_manip = false)
//    {
//        $offset = $this->offset;
//        $limit = $this->limit;
//        $this->offset = $this->limit = 0;
//        $query = $this->_modifyQuery($query, $is_manip, $limit, $offset);
//
//        $connection = $this->getConnection();
//        if (PEAR::isError($connection)) {
//            return $connection;
//        }
//
//        $result =& $this->_doQuery($query, $is_manip, $connection, false);
//        if (PEAR::isError($result)) {
//            return $result;
//        }
//
//        if ($is_manip) {
//            $affected_rows =  $this->_affectedRows($connection, $result);
//            return $affected_rows;
//        }
//        $result =& $this->_wrapResult($result, $types, true, false, $limit, $offset);
//        return $result;
//    }

    function test__modifyQuery()
    {
        if ($this->dsn['phptype']=='mysql')
        {
            $query = 'DELETE FROM users';
            $is_manip = false;
            $limit = 0;
            $offset = 0;

            $this->db->options['portability'] = 0;
            $query_mod = $this->db->_modifyQuery($query, $is_manip, $limit, $offset);
            $this->assertEquals($query, $query_mod, '_modifyQuery: test 2');

            $this->db->options['portability'] = MDB2_PORTABILITY_ALL;
            $query_mod = $this->db->_modifyQuery($query, $is_manip, $limit, $offset);
            $this->assertEquals($query.' WHERE 1=1', $query_mod, '_modifyQuery: test 1');

            $query = 'SELECT FROM users';
            $is_manip = false;
            $limit = 100;
            $offset = 0;
            $query_mod = $this->db->_modifyQuery($query, $is_manip, $limit, $offset);
            $this->assertTrue('SELECT FROM users LIMIT 0, 100', $query_mod, '_modifyQuery: test 3');

            $query = 'SELECT FROM users';
            $is_manip = false;
            $limit = 100;
            $offset = 50;
            $query_mod = $this->db->_modifyQuery($query, $is_manip, $limit, $offset);
            $this->assertTrue('SELECT FROM users LIMIT 50, 100', $query_mod, '_modifyQuery: test 4');

            $query = 'SELECT FROM users LIMIT 100, 50';
            $is_manip = false;
            $limit = 100;
            $offset = 50;
            $query_mod = $this->db->_modifyQuery($query, $is_manip, $limit, $offset);
            $this->assertTrue('SELECT FROM users LIMIT 100, 50', $query_mod, '_modifyQuery: test 4');

            $query = 'SELECT FROM users';
            $is_manip = true;
            $limit = 100;
            $offset = 50;
            $query_mod = $this->db->_modifyQuery($query, $is_manip, $limit, $offset);
            $this->assertTrue('SELECT FROM users LIMIT 100', $query_mod, '_modifyQuery: test 5');
        }
    }

    function test__doQuery()
    {
    }

    function test__affectedRows()
    {

    }

    function test_exec()
    {
    }

    function test__wrapResult()
    {
    }

    function test_setLimit()
    {
        if (!$this->db->supports('limit_queries'))
        {
            $this->db->limit = null;
            $this->db->offset = null;
            $this->db->setLimit(100, 50);
            $this->assertEquals( 50, $this->db->offset, 'setLimit');
            $this->assertEquals(100, $this->db->limit , 'setLimit');
        }
    }

    function test_subSelect()
    {
        if ($this->db->supports('sub_selects'))
        {

        }
    }

    function test_replace()
    {
        if ($this->db->supports('replace'))
        {

        }
    }

    function test_prepare()
    {
        // should test this one
    }

    function test__skipDelimitedStrings()
    {

    }

    function test_quote()
    {

    }

    function test_getDeclaration()
    {
        // this is tested in the declaration_<phptype> test unit
    }

    function test_compareDefinition()
    {

    }

    function test_supports()
    {
        $this->db->supports['testkey'] = true;
        $this->assertTrue($this->db->supports('testkey'), 'supports');
    }

    function test_getSequenceName()
    {
        $format = $this->db->options['seqname_format'];
        $this->db->options['seqname_format'] = '%s_seq';
        $this->assertEquals('test_seq', $this->db->getSequenceName('test'), 'getSequenceName');
        $this->db->options['seqname_format'] = $format;
    }

    function test_getIndexName()
    {
        $format = $this->db->options['idxname_format'];
        $this->db->options['idxname_format'] = 'idx_%s';
        $this->assertEquals('idx_test', $this->db->getIndexName('test'), 'getIndexName');
        $this->db->options['idxname_format'] = $format;
    }

    function test_nextID()
    {
    }

    function test_lastInsertID()
    {
    }

    function test_currID()
    {
    }

    function test_queryOne()
    {
    }

    function test_queryRow()
    {
    }

    function test_queryCol()
    {
    }

    function test_queryAll()
    {
    }

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