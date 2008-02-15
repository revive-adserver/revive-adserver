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

require_once MAX_PATH . '/lib/OA/Central/M2M.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Central_M2M class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Central_M2M extends UnitTestCase
{
    var $adminAccountId;
    var $managerAccountId;

    function Test_OA_Central_M2M()
    {
        parent::UnitTestCase();

        OA_Dal_ApplicationVariables::set('platform_hash', sha1('foo'));

        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $doAccounts->account_name = 'Administrator';
        $this->adminAccountId = DataGenerator::generateOne($doAccounts);

        OA_Dal_ApplicationVariables::set('admin_account_id', $this->adminAccountId);

        $doAccounts->account_type = OA_ACCOUNT_MANAGER;
        $doAccounts->account_name = 'Manager';
        $this->managerAccountId = DataGenerator::generateOne($doAccounts);
    }

    function _mockSendReference(&$oM2M, &$reference, $args = false)
    {
        $oM2M->oMapper->oRpc->oXml->setReturnReference('send', $reference, $args);
    }

    function _mockSendReferenceAt(&$oM2M, $timing, &$reference, $args = false) {
        $oM2M->oMapper->oRpc->oXml->setReturnReferenceAt($timing, 'send', $reference, $args);
    }

    function _mockSendExpect(&$oM2M, $args)
    {
        $oM2M->oMapper->oRpc->oXml->expect('send', $args);
    }

    /**
     * Create a new OA_Central_M2M instance with a mocked Rpc class
     *
     * @param int $accountId
     * @return OA_Central_M2M
     */
    function _newInstance($accountId)
    {
        Mock::generatePartial(
            'OA_XML_RPC_Client',
            $oXmlRpc = 'OA_XML_RPC_Client_'.md5(uniqid('', true)),
            array('send')
        );

        $oM2M = new OA_Central_M2M($accountId);
        $oM2M->oMapper->oRpc->oXml = new $oXmlRpc();

        return $oM2M;
    }

    function testConnectAdmin()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   '');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, '');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->adminAccountId);

        $oResponse = new XML_RPC_Response(XML_RPC_encode('bar'));

        $this->_mockSendReference($oM2M, $oResponse);

        $this->assertTrue($oM2M->connectM2M());

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   'bar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   '');
    }

    function testGetTicketAdmin()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   'bar');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, '');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->adminAccountId);

        $oResponse = new XML_RPC_Response(XML_RPC_encode('baz'));

        $this->_mockSendReference($oM2M, $oResponse);

        $this->assertTrue($oM2M->getM2MTicket());

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   'bar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     'baz');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   '');
    }

    function testGetTicketManager()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   'bar');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, '');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->managerAccountId);

        $oResponsePassword = new XML_RPC_Response(XML_RPC_encode('foobar'));
        $oResponseTicket   = new XML_RPC_Response(XML_RPC_encode('foobaz'));

        $this->_mockSendReferenceAt($oM2M, 0, $oResponsePassword);
        $this->_mockSendReferenceAt($oM2M, 1, $oResponseTicket);

        $this->assertTrue($oM2M->getM2MTicket());

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   'bar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), 'foobar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   'foobaz');
    }

    function testGetTicketAdminWithExpiredPassword()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   'bar');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, '');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->adminAccountId);

        $oResponseError    = new XML_RPC_Response('', OA_CENTRAL_ERROR_M2M_PASSWORD_EXPIRED, 'foo');
        $oResponsePassword = new XML_RPC_Response(XML_RPC_encode('bar2'));
        $oResponseTicket   = new XML_RPC_Response(XML_RPC_encode('baz2'));

        $this->_mockSendReferenceAt($oM2M, 0, $oResponseError);
        $this->_mockSendReferenceAt($oM2M, 1, $oResponsePassword);
        $this->_mockSendReferenceAt($oM2M, 2, $oResponseTicket);

        $this->assertTrue($oM2M->getM2MTicket());

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   'bar2');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     'baz2');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   '');
    }

    function testGetTicketManagerWithExpiredPassword()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   'bar');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, 'foobar');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->managerAccountId);

        $oResponseError    = new XML_RPC_Response('', OA_CENTRAL_ERROR_M2M_PASSWORD_EXPIRED, 'foo');
        $oResponsePassword = new XML_RPC_Response(XML_RPC_encode('foobar2'));
        $oResponseTicket   = new XML_RPC_Response(XML_RPC_encode('foobaz2'));

        $this->_mockSendReferenceAt($oM2M, 0, $oResponseError);
        $this->_mockSendReferenceAt($oM2M, 1, $oResponsePassword);
        $this->_mockSendReferenceAt($oM2M, 2, $oResponseTicket);

        $this->assertTrue($oM2M->getM2MTicket());

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   'bar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), 'foobar2');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   'foobaz2');
    }

    function testGetTicketAdminWithWrongPwd()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   'bar');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, '');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->adminAccountId);

        $oResponseError  = new XML_RPC_Response('', OA_CENTRAL_ERROR_M2M_PASSWORD_INVALID, 'foo');
        $oResponseError2 = new XML_RPC_Response('', OA_CENTRAL_ERROR_M2M_PASSWORD_ALREADY_GENERATED, 'foo');

        $this->_mockSendReferenceAt($oM2M, 0, $oResponseError);
        $this->_mockSendReferenceAt($oM2M, 1, $oResponseError2);

        $this->assertIsA($oM2M->getM2MTicket(), 'PEAR_Error');

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   '');
    }

    function testManagerWithWrongPwdRequestingTicket()
    {
        OA_Dal_Central_M2M::setM2MPassword($this->adminAccountId,   'bar');
        OA_Dal_Central_M2M::setM2MTicket($this->adminAccountId,     '');
        OA_Dal_Central_M2M::setM2MPassword($this->managerAccountId, 'foo');
        OA_Dal_Central_M2M::setM2MTicket($this->managerAccountId,   '');

        $oM2M = $this->_newInstance($this->managerAccountId);

        $oResponseError    = new XML_RPC_Response('', OA_CENTRAL_ERROR_M2M_PASSWORD_INVALID, 'foo');
        $oResponsePassword = new XML_RPC_Response(XML_RPC_encode('foobar'));
        $oResponseTicket   = new XML_RPC_Response(XML_RPC_encode('foobaz'));

        $this->_mockSendReferenceAt($oM2M, 0, $oResponseError);
        $this->_mockSendReferenceAt($oM2M, 1, $oResponsePassword);
        $this->_mockSendReferenceAt($oM2M, 2, $oResponseTicket);

        $this->assertTrue($oM2M->getM2MTicket());

        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->adminAccountId),   'bar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->adminAccountId),     '');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MPassword($this->managerAccountId), 'foobar');
        $this->assertEqual(OA_Dal_Central_M2M::getM2MTicket($this->managerAccountId),   'foobaz');
    }
}

?>
