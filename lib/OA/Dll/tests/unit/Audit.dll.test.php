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

require_once MAX_PATH . '/lib/OA/Dll/Audit.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';
//require_once MAX_PATH . '/lib/max/Dal/DataObjects/Audit.php';

/**
 * A class for testing DLL Agency methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dll_AuditTest extends DllUnitTestCase
{

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown auditId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_AuditTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Audit',
            'PartialMockOA_Dll_Audit',
            array()
        );

        OA_setTimeZone('Europe/Rome');
    }

    function tearDown()
    {
        DataGenerator::cleanUp(array('audit'));
    }

    function test_getAuditLogForCampaignWidget()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay  = new Date_Span('1-0-0-0');

        $oDate = & new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1 - more than 7 days old so should not be returned
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'Campaign';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'Maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();

        // record 2
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[4] = $oAudit->toArray();

        // record 3
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[3] = $oAudit->toArray();

        // record 4
        $oDate->addSpan($oSpanDay);
        $oAudit->contextid = 2;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[2] = $oAudit->toArray();

        // record 5
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[1] = $oAudit->toArray();

        // record 6
        $oDate->addSpan($oSpanDay);
        $oAudit->account_id = 2;
        $oAudit->contextid = 3;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 3';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[0] = $oAudit->toArray();

        // record 7 - not a maintenance audit rec so should not be returned
        $oDate->addSpan($oSpanDay);
        $oAudit->username = 'admin';
        $oAudit->contextid = 1;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();

        $aParams = array();
        $aResults = $dllAuditPartialMock->getAuditLogForCampaignWidget($aParams);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults),5);

        for ($i=0;$i<5;$i++)
        {
            $aRow = $aResults[$i];
            $aExpect[$i]['details'] = unserialize($aExpect[$i]['details']);
            $this->assertEqual($aRow['auditid'],$aExpect[$i]['auditid']);
            $this->assertEqual($aRow['actionid'],$aExpect[$i]['actionid']);
            $this->assertEqual($aRow['context'],$aExpect[$i]['context']);
            $this->assertEqual($aRow['contextid'],$aExpect[$i]['contextid']);
            $this->assertEqual($aRow['parentid'],$aExpect[$i]['parentid']);
            $this->assertEqual($aRow['username'],$aExpect[$i]['username']);
            $this->assertEqual($aRow['details']['campaignname'],$aExpect[$i]['details']['campaignname']);
            $this->assertEqual($aRow['details']['status'],$aExpect[$i]['details']['status']);

            $oDate = new Date($aRow['updated']);
            $oDate->toUTC();
            $this->assertEqual($oDate->getDate(),$aExpect[$i]['updated']);
        }

        // Check that the account_id filter is working
        $aParams = array('account_id' => 2);
        $aResults = $dllAuditPartialMock->getAuditLogForCampaignWidget($aParams);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults),1);
    }

    function test_getAuditLogForAuditWidget()
    {
        $dllAuditPartialMock = new PartialMockOA_Dll_Audit($this);

        $oSpanDay  = new Date_Span('1-0-0-0');

        $oDate = & new Date(OA::getNow());
        $oDate->toUTC();
        $oDate->subtractSpan(new Date_Span('8-0-0-0'));

        // add 1 hour to make sure that the test passes even if it takes some time
        $oDate->addSpan(new Date_Span('0-1-0-0'));

        // record 1 - more than 7 days old so should not be returned
        $oDateCopy = new Date($oDate);
        $oDateCopy->toUTC();
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->account_id = 1;
        $oAudit->context = 'Campaign';
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
        $oAudit->insert();
        $aExpect[4] = $oAudit->toArray();

        // record 3
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user3';
        $aDetails['status'] = OA_ENTITY_STATUS_PAUSED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[3] = $oAudit->toArray();

        // record 4
        $oDate->addSpan($oSpanDay);
        $oAudit->contextid = 2;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[2] = $oAudit->toArray();

        // record 5
        $oDate->addSpan($oSpanDay);
        $oAudit->updated = $oDate->getDate();
        $oAudit->username = 'user2';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[1] = $oAudit->toArray();

        // record 6
        $oDate->addSpan($oSpanDay);
        $oAudit->account_id = 2;
        $oAudit->contextid = 3;
        $oAudit->username = 'user1';
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 3';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[0] = $oAudit->toArray();

        // record 7 - is a maintenance audit rec so should not be returned
        $oDate->addSpan($oSpanDay);
        $oAudit->username = 'Maintenance';
        $oAudit->contextid = 1;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();

        $aParams = array();
        $aResults = $dllAuditPartialMock->getAuditLogForAuditWidget($aParams);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults),5);

        for ($i=0;$i<5;$i++)
        {
            $aRow = $aResults[$i];
            $aExpect[$i]['details'] = unserialize($aExpect[$i]['details']);
            $this->assertEqual($aRow['auditid'],$aExpect[$i]['auditid']);
            $this->assertEqual($aRow['actionid'],$aExpect[$i]['actionid']);
            $this->assertEqual($aRow['context'],$aExpect[$i]['context']);
            $this->assertEqual($aRow['contextid'],$aExpect[$i]['contextid']);
            $this->assertEqual($aRow['parentid'],$aExpect[$i]['parentid']);
            $this->assertEqual($aRow['username'],$aExpect[$i]['username']);
            $this->assertEqual($aRow['details']['campaignname'],$aExpect[$i]['details']['campaignname']);
            $this->assertEqual($aRow['details']['status'],$aExpect[$i]['details']['status']);

            $oDate = new Date($aRow['updated']);
            $oDate->toUTC();
            $this->assertEqual($oDate->getDate(),$aExpect[$i]['updated']);
        }

        // Check that the account_id filter is working
        $aParams = array('account_id' => 2);
        $aResults = $dllAuditPartialMock->getAuditLogForAuditWidget($aParams);

        $this->assertIsA($aResults, 'array');
        $this->assertEqual(count($aResults),1);
    }
}

?>
