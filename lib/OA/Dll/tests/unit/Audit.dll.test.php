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

require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Agency methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 */

class OA_Dll_AuditTest extends DllUnitTestCase
{
    /**
     * Errors
     *
     */
    public $unknownIdError = 'Unknown auditId Error';

    public function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OA_Dll_Audit',
            'PartialMockOA_Dll_Audit',
            [],
        );

        OA_setTimeZone('Europe/Rome');
    }

    public function tearDown()
    {
        DataGenerator::cleanUp(['audit']);
    }

    public function test_getActionName()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);
        $aActionName = [
            OA_AUDIT_ACTION_INSERT => $GLOBALS['strInserted'],
            OA_AUDIT_ACTION_UPDATE => $GLOBALS['strUpdated'],
            OA_AUDIT_ACTION_DELETE => $GLOBALS['strDeleted'],
        ];
        foreach ($aActionName as $key => $str) {
            $this->assertIdentical($str, $dllAuditPartialMock->getActionName($key));
        }
    }

    public function test_getAuditDetail()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay = new Date_Span('1-0-0-0');

        $oDate = new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'user1';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 2
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        foreach ($aExpect as $i => $aExpRow) {
            $aResRow = $dllAuditPartialMock->getAuditDetail($i);

            $this->assertIsA($aResRow, 'array');
            $this->assertEqual($aResRow['auditid'], $aExpRow['auditid']);
            $this->assertEqual($aResRow['actionid'], $aExpRow['actionid']);
            $this->assertEqual($aResRow['context'], $aExpRow['context']);
            $this->assertEqual($aResRow['contextid'], $aExpRow['contextid']);
            $this->assertEqual($aResRow['parentid'], $aExpRow['parentid']);
            $this->assertEqual($aResRow['username'], $aExpRow['username']);
            $this->assertEqual($aResRow['details']['campaignname'], $aExpRow['details']['campaignname']);
            $this->assertEqual($aResRow['details']['status'], $aExpRow['details']['status']);
        }
    }

    public function test_getAuditLog()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay = new Date_Span('1-0-0-0');

        $oDate = new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'user1';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 2
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 3
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user3';
        $aDetails['status'] = OA_ENTITY_STATUS_PAUSED;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 4
        $oDate->addSpan($oSpanDay);
        $oAudit->contextid = 2;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 5
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user2';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 6
        $oDate->addSpan($oSpanDay);
        $oAudit->account_id = 2;
        $oAudit->contextid = 3;
        $oAudit->username = 'user1';
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 3';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 7 - is a maintenance audit rec so should not be returned
        $oDate->addSpan($oSpanDay);
        $oAudit->username = 'Maintenance';
        $oAudit->contextid = 1;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        $oSpanDay = new Date_Span('1-0-0-0');

        $oSpanDate = new Date(OA::getNow());
        $oSpanDate->toUTC();
        $oSpanDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oSpanDate->addSpan(new Date_Span('0-1-0-0'));

        $startDate = $oSpanDate->getDate();
        $endDate = $oDate->getDate();
        $aParam = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'startRecord' => 0,
            'perPage' => 10];
        $aResults = $dllAuditPartialMock->getAuditLog($aParam);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults), count($aExpect));

        foreach ($aResults as $i => $aResRow) {
            $aExpRow = $aExpect[$aResRow['auditid']];
            $this->assertEqual($aResRow['auditid'], $aExpRow['auditid']);
            $this->assertEqual($aResRow['actionid'], $aExpRow['actionid']);
            $this->assertEqual($aResRow['context'], $aExpRow['context']);
            $this->assertEqual($aResRow['contextid'], $aExpRow['contextid']);
            $this->assertEqual($aResRow['parentid'], $aExpRow['parentid']);
            $this->assertEqual($aResRow['username'], $aExpRow['username']);
            $this->assertEqual($aResRow['details']['campaignname'], $aExpRow['details']['campaignname']);
            $this->assertEqual($aResRow['details']['status'], $aExpRow['details']['status']);
        }
    }

    public function test_getParentContextData()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $aExpect = [
            [  //  Banner
                'parentcontext' => $GLOBALS['strCampaign'],
                'parentcontextid' => 1,
            ],
            [  //  Campaign
                'parentcontext' => $GLOBALS['strClient'],
                'parentcontextid' => 2,
            ],
            [  //  Channel
                'parentcontext' => $GLOBALS['strAffiliate'],
                'parentcontextid' => 3,
            ],
            [  //  Zone
                'parentcontext' => $GLOBALS['strAffiliate'],
                'parentcontextid' => 4,
            ],
        ];

        $aContext = [
            ['context' => 'banners',    'details' => ['campaignid' => 1]],
            ['context' => 'campaigns',  'details' => ['clientid' => 2]],
            ['context' => 'channel',   'details' => ['affiliateid' => 3]],
            ['context' => 'zones',      'details' => ['affiliateid' => 4]],
        ];

        for ($i = 0; $i < 4; $i++) {
            $result = $dllAuditPartialMock->getParentContextData($aContext[$i]);
            $this->assertTrue($result);
            $this->assertEqual($aContext[$i]['parentcontext'], $aExpect[$i]['parentcontext']);
            $this->assertEqual($aContext[$i]['parentcontextid'], $aExpect[$i]['parentcontextid']);
        }

        $aContext = ['context' => 'Client'];
        $result = $dllAuditPartialMock->getParentContextData($aContext);
        $this->assertFalse($result);
        $this->assertTrue(empty($aContext['parentcontext']));
        $this->assertTrue(empty($aContext['parentcontextid']));
    }

    public function test_getChildren()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay = new Date_Span('1-0-0-0');

        $oDate = new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $idAuditParent1 = $oAudit->insert();
        $aAudit = $oAudit->toArray();

        // child 1 record of record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = $aAudit['auditid'];
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $oAudit->details = serialize($aDetails);
        $idAuditChild1 = $oAudit->insert();

        // child 2 record of record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = $aAudit['auditid'];
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $oAudit->details = serialize($aDetails);
        $idAuditChild2 = $oAudit->insert();

        // record 2 - has no children
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $oAudit->details = serialize($aDetails);
        $idAuditParent2 = $oAudit->insert();

        $aParam = [
            'perPage' => 10,
            'startRecord' => 0,
        ];
        $aResult = $dllAuditPartialMock->getAuditLog($aParam);
        $this->assertEqual(count($aResult), 2);

        $aChildren1 = $dllAuditPartialMock->getChildren($idAuditParent1, 'Campaign');
        $this->assertTrue(!empty($aChildren1));
        $this->assertEqual(count($aChildren1), 2);

        $aChildren2 = $dllAuditPartialMock->getChildren($idAuditChild1, 'Campaign');
        $this->assertFalse($aChildren2);

        $aChildren3 = $dllAuditPartialMock->getChildren($idAuditChild2, 'Campaign');
        $this->assertFalse($aChildren3);

        $aChildren3 = $dllAuditPartialMock->getChildren($idAuditParent2, 'Campaign');
        $this->assertFalse($aChildren3);
    }

    public function test_hasChildren()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay = new Date_Span('1-0-0-0');

        $oDate = new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $idAuditParent1 = $oAudit->insert();
        $aAudit = $oAudit->toArray();

        // child 1 record of record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = $aAudit['auditid'];
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $oAudit->details = serialize($aDetails);
        $idAuditChild1 = $oAudit->insert();

        // child 2 record of record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = $aAudit['auditid'];
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $oAudit->details = serialize($aDetails);
        $idAuditChild2 = $oAudit->insert();

        // record 2 - has no children
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $oAudit->details = serialize($aDetails);
        $idAuditParent2 = $oAudit->insert();

        $aParam = [
            'perPage' => 10,
            'startRecord' => 0,
        ];
        $aResult = $dllAuditPartialMock->getAuditLog($aParam);
        $this->assertEqual(count($aResult), 2);

        $hasChildren1 = $dllAuditPartialMock->hasChildren($idAuditParent1, 'Campaign');
        $this->assertTrue($hasChildren1);

        $hasChildren2 = $dllAuditPartialMock->hasChildren($idAuditChild1, 'Campaign');
        $this->assertFalse($hasChildren2);

        $hasChildren3 = $dllAuditPartialMock->hasChildren($idAuditChild2, 'Campaign');
        $this->assertFalse($hasChildren3);

        $hasChildren4 = $dllAuditPartialMock->hasChildren($idAuditParent2, 'Campaign');
        $this->assertFalse($hasChildren4);
    }

    public function test__removeParentContextId()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $aExpect = ['bannerid', 'campaignid', 'clientid', 'affiliateid'];
        $aContext = [
            ['context' => 'images',     'details' => ['bannerid' => 1]],
            ['context' => 'banners',    'details' => ['campaignid' => 2]],
            ['context' => 'campaigns',  'details' => ['clientid' => 3]],
            ['context' => 'zones',      'details' => ['affiliateid' => 4]],
        ];

        for ($i = 0; $i < 4; $i++) {
            $result = $dllAuditPartialMock->_removeParentContextId($aContext[$i]);
            $this->assertTrue($result);
            $this->assertTrue(empty($aContext[$i]['details'][$aExpect[$i]]));
        }
    }

    public function test_getAuditLogForAuditWidget()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay = new Date_Span('1-0-0-0');

        $oDate = new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1 - more than 7 days old so should not be returned
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'campaigns';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'user1';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();

        // record 2
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 3
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user3';
        $aDetails['status'] = OA_ENTITY_STATUS_PAUSED;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 4
        $oDate->addSpan($oSpanDay);
        $oAudit->contextid = 2;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 5
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user2';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 6
        $oDate->addSpan($oSpanDay);
        $oAudit->account_id = 2;
        $oAudit->contextid = 3;
        $oAudit->username = 'user1';
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 3';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $idAudit = $oAudit->insert();
        $aExpect[$idAudit] = $oAudit->toArray();
        $aExpect[$idAudit]['details'] = $aDetails;

        // record 7 - is a maintenance audit rec so should not be returned
        $oDate->addSpan($oSpanDay);
        $oAudit->username = 'Maintenance';
        $oAudit->contextid = 1;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();

        $aParams = [];
        $aResults = $dllAuditPartialMock->getAuditLogForAuditWidget($aParams);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults), 5);

        $oNow = new Date();

        foreach ($aResults as $i => $aResRow) {
            $aExpRow = $aExpect[$aResRow['auditid']];

            $this->assertEqual($aResRow['auditid'], $aExpRow['auditid']);
            $this->assertEqual($aResRow['actionid'], $aExpRow['actionid']);
            $this->assertEqual(
                $aResRow['context'],
                $dllAuditPartialMock->getContextDescription($aExpRow['context']),
            );
            $this->assertEqual($aResRow['contextid'], $aExpRow['contextid']);
            $this->assertEqual($aResRow['parentid'], $aExpRow['parentid']);
            $this->assertEqual($aResRow['username'], $aExpRow['username']);
            $this->assertEqual($aResRow['details']['campaignname'], $aExpRow['details']['campaignname']);
            $this->assertEqual($aResRow['details']['status'], $aExpRow['details']['status']);

            $oDate = new Date($aResRow['updated']);
            $oDate->setTZ($oNow->tz);
            $oDate->toUTC();
            $this->assertEqual($oDate->getDate(), $aExpRow['updated']);
        }
        // Check that the account_id filter is working
        $aParams = ['account_id' => 2];
        $aResults = $dllAuditPartialMock->getAuditLogForAuditWidget($aParams);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults), 1);
    }

    public function testGetContext()
    {
        $audit = new OA_Dll_Audit();
        $context = $audit->getContextDescription($table = 'campaigns');
        $doCampaigns = OA_Dal::factoryDO($table);
        $this->assertEqual($context, $doCampaigns->_getContext());

        // test https://developer.openx.org/jira/browse/OX-3105
        // Pear Error when User Log includes records for tables that no longer exist
        $table = 'foo_123';
        $context = $audit->getContextDescription($table);
        $this->assertEqual($context, $table);
    }
}
