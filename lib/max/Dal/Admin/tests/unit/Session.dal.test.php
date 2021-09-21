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
    public $dalSession;

    /**
     * MDB2 handle.
     *
     * @var MDB2_Driver_Common
     */
    public $dbh;

    public function setUp()
    {
        parent::setUp();
        $this->dalSession = OA_Dal::factoryDAL('session');
        $this->dbh = OA_DB::singleton();
    }


    public function tearDown()
    {
        DataGenerator::cleanUp();
    }


    public function testGetSerializedSession()
    {
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertFalse($actualSerializedData, 'The serialized data is false for non-existent session id.');

        $this->generateSession();
        $this->assertSessionData();

        $this->outdateSession(SESSIONID);
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertFalse($actualSerializedData, 'The serialized data is false for out-of-date session id.');
    }


    public function testRefreshSession()
    {
        $this->generateSession();
        $this->outdateSession(SESSIONID);
        $this->dalSession->refreshSession(SESSIONID);
        $this->assertSessionData();
    }


    public function testStoreSessionData()
    {
        $this->dalSession->storeSerializedSession(SDATA, SESSIONID);
        $this->assertSessionData();
        $this->dalSession->storeSerializedSession(SDATA2, SESSIONID);
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertEqual(SDATA2, $actualSerializedData);
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix . 'session');
        $this->dbh->exec("DELETE FROM {$table}");
    }


    public function testPruneOldSessions()
    {
        $this->generateSession();
        $this->dalSession->pruneOldSessions();
        $this->assertSessionData();

        $this->outdateSession();
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertFalse($actualSerializedData, 'The serialized data is false for non-existent session id.');
        $this->dalSession->pruneOldSessions();
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix . 'session');
        $cSessions = $this->dbh->queryOne("SELECT count(*) AS c FROM {$table}");
        $this->assertEqual(0, $cSessions);
    }


    public function testDeleteSession()
    {
        $this->generateSession();
        $this->dalSession->deleteSession(SESSIONID);
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix . 'session');
        $cSessions = $this->dbh->queryOne("SELECT count(*) AS c FROM {$table}");
        $this->assertEqual(0, $cSessions);
    }


    public function assertSessionData($data = SDATA)
    {
        $actualSerializedData = $this->dalSession->getSerializedSession(SESSIONID);
        $this->assertEqual($data, $actualSerializedData);
    }


    public function generateSession()
    {
        DataGenerator::setDataOne('session', ['sessionid' => SESSIONID, 'sessiondata' => SDATA]);
        DataGenerator::generateOne('session');
    }


    public function outdateSession()
    {
        $sessionId = SESSIONID;
        $prefix = OA_Dal::getTablePrefix();
        $table = $this->dbh->quoteIdentifier($prefix . 'session');
        $this->dbh->exec("UPDATE {$table} set lastused = '2005-01-01 01:00:00' WHERE sessionid = '$sessionId'");
    }
}
