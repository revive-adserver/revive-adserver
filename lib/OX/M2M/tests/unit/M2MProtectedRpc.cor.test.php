<?php

//hack to fix LIB_PATH inconsistency among projects
define("LIB_PATH_", preg_replace("/OX$/", "", LIB_PATH));

require_once(LIB_PATH_ . '/simpletest/unit_tester.php');
require_once(LIB_PATH_ . '/simpletest/reporter.php');

require_once(dirname(__FILE__) . "/DummyXmlRpcExecutor.php");
require_once(dirname(__FILE__) . "/DummyM2MService.php");
require_once(dirname(__FILE__) . "/DummyM2MDataProvider.php");
require_once(dirname(__FILE__) . "/../../M2MTicketProviderImpl.php");
require_once(dirname(__FILE__) . "/../../M2MServiceImpl.php");
require_once(dirname(__FILE__) . "/../../M2MProtectedRpc.php");


class OX_M2M_M2MProtectedRpcTest extends UnitTestCase
{
	public function test()
    {
    	$service = new OX_M2M_tests_unit_DummyXmlRpcExecutor();
    	$m2mService = new OX_M2M_tests_unit_DummyM2MService();
    	$m2mProvider = new OX_M2M_tests_unit_DummyM2MDataProvider();
    	$service->m2mService = &$m2mService;
    	$ticketProvider = new OX_M2M_M2MTicketProviderImpl(
    		new OX_M2M_M2MServiceImpl($m2mService, $m2mProvider), $m2mProvider, "1", 'MANAGER');
    	$protectedService = new OX_M2M_M2MProtectedRpc($service, $ticketProvider);
    	
    	$accountId = 1;
    	$m2mProvider->accountId = $accountId;
    	$this->assertEqual(10, $protectedService->call("multiply", array(5)));
    	$this->assertEqual(4, $m2mService->callCounter);
    	
    	$this->assertEqual(18, $protectedService->call("multiply", array(9)));
    	$this->assertEqual(4, $m2mService->callCounter);
    	
    	$oldTicket = $m2mService->tickets[$accountId];
    	unset($m2mService->tickets[$accountId]);

    	$this->assertEqual(14, $protectedService->call("multiply", array(7)));
    	$this->assertEqual(5, $m2mService->callCounter);
    	
    	$this->assertNotEqual($oldTicket, $m2mService->tickets[$accountId]);
    }
}
