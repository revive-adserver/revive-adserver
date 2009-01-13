<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * @author     Pawel Gruszczynski <pawel.gruszczynski@openx.org>
 */

require_once MAX_PATH . '/lib/OX/M2M/tests/unit/DummyXmlRpcExecutor.php';
require_once MAX_PATH . '/lib/OX/M2M/tests/unit/DummyM2MService.php';
require_once MAX_PATH . '/lib/OA/Central/M2MTicketProviderImpl.php';
require_once MAX_PATH . '/lib/OX/M2M/M2MProtectedRpc.php';


class DummyXmlRpcClient 
	extends OA_XML_RPC_Client
{
	/**
	 * OX_M2M_XmlRpcExecutor
	 */
	private $executor;
	
	function __construct(&$executor)
	{
		$this->executor = &$executor;
	}
	
	
	/**
	 * @param XML_RPC_Message $msg
	 * @param unknown_type $timeout
	 */
	function send($msg, $timeout = 0)
	{
		$params = array();
		for ($i = 0; $i < $msg->getNumParams(); $i++) {
			$params[] = $msg->getParam($i)->getval();
		}
		try {
			$result = $this->executor->call($msg->method(), $params);
			return new XML_RPC_Response(new XML_RPC_Value($result));
		}
		catch (Exception  $e) {
			return new XML_RPC_Response(null, $e->getCode(), $e->getMessage());
		}
	}
}

class Test_OA_Central_M2MProtectedRpc extends UnitTestCase
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
        $doAccounts->m2m_password = "";
        $doAccounts->m2m_ticket = "";
        $doAccounts->update();

        OA_Dal_ApplicationVariables::set('admin_account_id', $this->adminAccountId);

        $doAccounts->account_type = OA_ACCOUNT_MANAGER;
        $doAccounts->account_name = 'Manager';
        $this->managerAccountId = DataGenerator::generateOne($doAccounts);
        $doAccounts->m2m_password = "";
        $doAccounts->m2m_ticket = "";
        $doAccounts->update();
    }
	

	public function test()
    {
    	$service = new OX_M2M_tests_unit_DummyXmlRpcExecutor();
    	$m2mService = new OX_M2M_tests_unit_DummyM2MService();
    	
    	$service->m2mService = &$m2mService;
    	
    	$m2m = new OA_Central_M2M($this->managerAccountId);
    	$m2m->oMapper->oRpc->oXml = new DummyXmlRpcClient($m2mService);
    	
    	$ticketProvider = new OA_Central_M2MTicketProviderImpl(new OA_Dal_Central_M2M(), $m2m);
    	$protectedService = new OX_M2M_M2MProtectedRpc($service, $ticketProvider);
    	
    	$this->assertEqual(10, $protectedService->call("multiply", array(5)));
    	$this->assertEqual(3, $m2mService->callCounter);
    	
    	$this->assertEqual(18, $protectedService->call("multiply", array(9)));
    	$this->assertEqual(3, $m2mService->callCounter);
    	
    	$oldTicket = $m2mService->tickets[$this->managerAccountId];
    	unset($m2mService->tickets[$this->managerAccountId]);

    	$this->assertEqual(14, $protectedService->call("multiply", array(7)));
    	$this->assertEqual(4, $m2mService->callCounter);
    	
    	$this->assertNotEqual($oldTicket, $m2mService->tickets[$this->managerAccountId]);
    }
}

?>
