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

require_once MAX_PATH . '/etc/changes/migration_tables_core_121.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

/**
 * Test for migration class #121.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_121Test extends UnitTestCase
{
    function testMigrateData()
    {
        $oTable = new OA_DB_Table();
        $oTable->init(MAX_PATH . '/etc/changes/schema_tables_core_121.xml');
        $oTable->createTable('acls');
        $oTable->truncateTable('acls');
        
        $oDbh = &OA_DB::singleton();
        $migration = new Migration_121();
        $migration->init($oDbh);
        
        $aTestData = array(
            array('weekday', '==', '0,1'),
            array('weekday', '==', '0,1,4'),
            array('weekday', '==', ''),
            array('time', '==', '5,6'),
            array('time', '==', '5'),
            array('date', '>=', '20070510'),
            array('clientip', '==', '150.254.170.189'),
            array('domain', '!=', 'www.openads.org'),
            array('language', '!=', '(hr)|(nl)'),
            array('language', '!=', '(en)'),
            array('continent', '==', 'AF'),
            array('country', '==', 'PL,GB'),
            array('browser', '==', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('browser', '!=', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('os', '==', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'),
            array('useragent', '==', 'ahahaha'),
            array('referer', '==', 'blabblah'),
            array('source', '==', 'www.openads.org'),
        );
        $aExpectedData = array(
            array('Time:Day', '=~', '0,1'),
            array('Time:Day', '=~', '0,1,4'),
            array('Time:Day', '=~', ''),
            array('Time:Hour', '=~', '5,6'),
            array('Time:Hour', '=~', '5'),
            array('Time:Date', '>=', '20070510'),
            array('Client:Ip', '==', '150.254.170.189'),
            array('Client:Domain', '!=', 'www.openads.org'),
            array('Client:Language', '!~', 'hr,nl'),
            array('Client:Language', '!~', 'en'),
            array('Geo:Continent', '=~', 'AF'),
            array('Geo:Country', '=~', 'PL,GB'),
            array('Client:Useragent', '=x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('Client:Useragent', '!x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('Client:Useragent', '=x', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'),
            array('Client:Useragent', '=x', 'ahahaha'),
            array('Site:Referingpage', '=~', 'blabblah'),
            array('Site:Source', '=x', 'www.openads.org'),
        );
        
        $aValues = array();
        $idx = 0;
        foreach ($aTestData as $testData) {
            $aValues = array(
                'bannerid' => 1,
                'logical' => 'and',
                'type' => $testData[0],
                'comparison' => $testData[1],
                'data' => $testData[2],
                'executionorder' => $idx++);
            $sql = OA_DB_Sql::sqlForInsert('acls', $aValues);
            $oDbh->exec($sql);
        }
        $cLimitations = $idx;
        
        $this->assertTrue($migration->migrateData());
        
        $rsAcls = DBC::NewRecordSet("SELECT type, comparison, data FROM acls ORDER BY executionorder");
        $this->assertTrue($rsAcls->find());
        
        for ($idx = 0; $idx < $cLimitations; $idx++) {
            $this->assertTrue($rsAcls->fetch());
            $this->assertEqual($aExpectedData[$idx][0], $rsAcls->get('type'));
            $this->assertEqual($aExpectedData[$idx][1], $rsAcls->get('comparison'), "%s IN COMPARISON FOR: " . $aExpectedData[$idx][0] . "|" . $aExpectedData[$idx][1] . "|" . $aExpectedData[$idx][2]);
            $this->assertEqual($aExpectedData[$idx][2], $rsAcls->get('data'));
        }
        $this->assertFalse($rsAcls->fetch());
        
        $oTable->dropAllTables();
    }
}