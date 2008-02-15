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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

define('SDATA', 'blahblah');
define('SDATA2', 'bumtratata');
define('SESSIONID', '54');

/**
 * A class for testing DAL Session methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_SessionTest extends DalUnitTestCase
{
    /**
     * The Session DAL to be tested
     *
     * @var MAX_Dal_Admin_Session
     */
    var $dalSession;

    /**
     * MDB2 handle.
     *
     * @var MDB2_Driver_Common
     */
    var $dbh;

    function setUp()
    {
        parent::setUp();
        $this->dalSession = OA_Dal::factoryDAL('session');
        $this->dbh = OA_DB::singleton();
    }


    function tearDown()
    {
        DataGenerator::cleanUp();
    }


    function testGetSerializedSession()
    {
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertFalse($actualSerializedData, 'The serialized data is false for non-existent session id.');

        $this->generateSession();
        $this->assertSessionData();

        $this->outdateSession(SESSIONID);
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertFalse($actualSerializedData, 'The serialized data is false for out-of-date session id.');
    }


    function testRefreshSession()
    {
        $this->generateSession();
        $this->outdateSession(SESSIONID);
        $this->dalSession->refreshSession(SESSIONID);
        $this->assertSessionData();
    }


    function testStoreSessionData()
    {
        $this->dalSession->storeSerializedSession(SDATA, SESSIONID);
        $this->assertSessionData();
        $this->dalSession->storeSerializedSession(SDATA2, SESSIONID);
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertEqual(SDATA2, $actualSerializedData);
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix.'session');
        $this->dbh->exec("DELETE FROM {$table}");
    }


    function testPruneOldSessions()
    {
        $this->generateSession();
        $this->dalSession->pruneOldSessions();
        $this->assertSessionData();

        $this->outdateSession();
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertFalse($actualSerializedData, 'The serialized data is false for non-existent session id.');
        $this->dalSession->pruneOldSessions();
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix.'session');
        $cSessions = $this->dbh->queryOne("SELECT count(*) AS c FROM {$table}");
        $this->assertEqual(0, $cSessions);
    }


    function testDeleteSession()
    {
        $this->generateSession();
        $this->dalSession->deleteSession(SESSIONID);
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix.'session');
        $cSessions = $this->dbh->queryOne("SELECT count(*) AS c FROM {$table}");
        $this->assertEqual(0, $cSessions);
    }


    function assertSessionData($data = SDATA)
    {
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertEqual($data, $actualSerializedData);
    }


    function generateSession()
    {
        $dg = new DataGenerator();
        $dg->setDataOne('session', array('sessionid' => SESSIONID, 'sessiondata' => SDATA));
        $dg->generateOne('session');
    }


    function outdateSession()
    {
        $sessionId = SESSIONID;
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix.'session');
        $this->dbh->exec("UPDATE {$table} set lastused = '2005-01-01 01:00:00' WHERE sessionid = '$sessionId'");
    }
}
?>