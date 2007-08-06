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

class MDB2_Api_TestCase extends MDB2_TestCase {
    var $clear_tables = false;

    //test stuff in common.php
    function testConnect() {
        $db =& MDB2::factory($this->dsn, $this->options);
        if (PEAR::isError($db)) {
            $this->assertTrue(false, 'Connect failed bailing out - ' .$db->getMessage() . ' - ' .$db->getUserInfo());
        }
        if (PEAR::isError($this->db)) {
            exit;
        }
    }

    function testGetOption() {
        if (!$this->methodExists($this->db, 'getOption')) {
            return;
        }
        $option = $this->db->getOption('persistent');
        $this->assertEquals($option, $this->db->options['persistent']);
    }

    function testSetOption() {
        if (!$this->methodExists($this->db, 'setOption')) {
            return;
        }
        $option = $this->db->getOption('persistent');
        $this->db->setOption('persistent', !$option);
        $this->assertEquals(!$option, $this->db->getOption('persistent'));
        $this->db->setOption('persistent', $option);
    }

    function testLoadModule() {
        if (!$this->methodExists($this->db, 'loadModule')) {
            return;
        }
        $this->assertTrue(!PEAR::isError($this->db->loadModule('Manager', null, true)));
    }

    // test of the driver
    // helper function so that we don't have to write out a query a million times
    function standardQuery() {
        $query = 'SELECT * FROM users';
        // run the query and get a result handler
        if (!PEAR::isError($this->db)) {
            return $this->db->query($query);
        }
        return false;
    }

    function testQuery() {
        if (!$this->methodExists($this->db, 'query')) {
            return;
        }
        $result = $this->standardQuery();

        $this->assertTrue(MDB2::isResult($result), 'query: $result returned is not a resource');
    }

    function testFetchRow() {
        $result = $this->standardQuery();
        if (!$this->methodExists($result, 'fetchRow')) {
            return;
        }
        $err = $result->fetchRow();
        $result->free();

        if (PEAR::isError($err)) {
            $this->assertTrue(false, 'Error testFetch: '.$err->getMessage().' - '.$err->getUserInfo());
        }
    }

    function testNumRows() {
        $result = $this->standardQuery();
        if (!$this->methodExists($result, 'numRows')) {
            return;
        }
        $numrows = $result->numRows();
        $this->assertTrue(!PEAR::isError($numrows) && is_int($numrows));
        $result->free();
    }

    function testNumCols() {
        $result = $this->standardQuery();
        if (!$this->methodExists($result, 'numCols')) {
            return;
        }
        $numcols = $result->numCols();
        $this->assertTrue(!PEAR::isError($numcols) && $numcols > 0);
        $result->free();
    }

    function testSingleton() {
        $db =& MDB2::singleton();
        $this->assertTrue(MDB2::isConnection($db));

        // should have a different database name set
        $db =& MDB2::singleton($this->dsn, $this->options);

        $this->assertTrue($db->db_index != $this->db->db_index);
    }

    function testGetServerVersion() {
        $server_info = $this->db->getServerVersion(true);
        if (PEAR::isError($server_info)) {
            $this->assertTrue(false, 'Error: '.$server_info->getMessage().' - '.$server_info->getUserInfo());
        } else {
            $this->assertTrue(is_string($server_info), 'Error: Server info is not returned as a string: '. serialize($server_info));
        }
        $server_info = $this->db->getServerVersion();
        if (PEAR::isError($server_info)) {
            $this->assertTrue(false, 'Error: '.$server_info->getMessage().' - '.$server_info->getUserInfo());
        } else {
            $this->assertTrue(is_array($server_info), 'Error: Server info is not returned as an array: '. serialize($server_info));
        }
    }
}

?>