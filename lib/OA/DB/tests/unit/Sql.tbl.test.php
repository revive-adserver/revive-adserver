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

require_once MAX_PATH . '/tests/testClasses/DbTestCase.php';

/**
 * Tests for OA_DB_Sql class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB_Sql extends DbTestCase
{
    public function testSqlForInsert()
    {
        $sql = OA_DB_Sql::sqlForInsert('zones', ['zonetype' => 1, 'name' => "120x72"]);
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($this->getPrefix() . 'zones', true);
        $this->assertEqual("INSERT INTO {$table} (zonetype,name) VALUES (1,'120x72')", $sql);
    }

}
