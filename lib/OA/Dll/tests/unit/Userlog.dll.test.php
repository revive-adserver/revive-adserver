<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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
$Id:$
*/

require_once MAX_PATH . '/lib/OA/Dll/Userlog.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';
//require_once MAX_PATH . '/lib/max/Dal/DataObjects/Audit.php';

/**
 * A class for testing DLL Agency methods
 *
 * @package    OpenadsDll
 * @subpackage TestSuite
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */


class OA_Dll_UserlogTest extends DllUnitTestCase
{

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown auditId Error';

    /**
     * The constructor method.
     */
    function OA_Dll_UserlogTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Userlog',
            'PartialMockOA_Dll_Userlog',
            array()
        );
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function test_getAuditLogForCampaignWidget()
    {
        $dllUserlogPartialMock = new PartialMockOA_Dll_Userlog($this);

        $oneDay  = 60*60*24;
        $oneWeek = $oneDay*7;

        $oDate = & new Date(OA::getNow());
        $oDate->subtractSeconds($oneWeek + $oneDay);

        // record 1
        $oAudit = OA_Dal::factoryDO('audit');
        $oAudit->context = 'Campaign';
        $oAudit->contextid = 1;
        $oAudit->parentid = null;
        $oAudit->username = 'maintenance';
        $oAudit->actionid = OA_AUDIT_ACTION_UPDATE;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[6] = $oAudit->toArray();

        // record 2
        $oDate->addSeconds($oneDay);
        $oAudit->updated = $oDate->getDate();
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[5] = $oAudit->toArray();

        // record 3
        $oDate->addSeconds($oneDay);
        $oAudit->updated = $oDate->getDate();
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[4] = $oAudit->toArray();

        // record 4
        $oDate->addSeconds($oneDay);
        $oAudit->contextid = 2;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 2';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[3] = $oAudit->toArray();

        // record 5
        $oDate->addSeconds($oneDay);
        $oAudit->updated = $oDate->getDate();
        $aDetails['status'] = OA_ENTITY_STATUS_EXPIRED;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[2] = $oAudit->toArray();

        // record 6
        $oDate->addSeconds($oneDay);
        $oAudit->contextid = 3;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 3';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[1] = $oAudit->toArray();

        // record 7
        $oDate->addSeconds($oneDay);
        $oAudit->username = 'admin';
        $oAudit->contextid = 1;
        $oAudit->updated = $oDate->getDate();
        $aDetails['campaignname'] = 'Campaign 1';
        $aDetails['status'] = OA_ENTITY_STATUS_RUNNING;
        $oAudit->details = serialize($aDetails);
        $oAudit->insert();
        $aExpect[0] = $oAudit->toArray();

        $aResults = $dllUserlogPartialMock->getAuditLogForCampaignWidget();

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
            $this->assertEqual($aRow['updated'],$aExpect[$i]['updated']);
            $this->assertEqual($aRow['details']['campaignname'],$aExpect[$i]['details']['campaignname']);
            $this->assertEqual($aRow['details']['status'],$aExpect[$i]['details']['status']);
        }
    }


}

?>