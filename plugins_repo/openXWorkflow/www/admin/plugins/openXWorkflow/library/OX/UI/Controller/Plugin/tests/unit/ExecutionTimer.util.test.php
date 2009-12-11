<?php

class ExecutionTimerTest extends UnitTestCase
{
    /**
     * @var OX_UI_Controller_Plugin_ExecutionTimer
     */
    private $timer;
    
    /**
     * @var OX_UI_Controller_Plugin_ExecutionTimerDao
     */
    private $dao;
    
    /**
     * Time measurement margin in microseconds.
     */
    private $margin = 500000;


    public function setUp()
    {
        $this->dao = new DummyExecutionTimerDao();
        $this->timer = new OX_UI_Controller_Plugin_ExecutionTimer($this->dao);
    }


    public function testNoForwarding()
    {
        $startupTime = $this->getDelay(250000);
        $shutdownTime = $this->getDelay(250000);
        $actionTime = $this->getDelay(100000);
        
        $this->timer->routeStartup($this->request());
        usleep($startupTime);
        $this->timer->preDispatch($this->request('a1', 'c1', 'm1'));
        usleep($actionTime);
        $this->timer->postDispatch($this->request('a1', 'c1', 'm1'));
        usleep($shutdownTime);
        $this->timer->dispatchLoopShutdown();
        
        $this->check('a1', 'c1', 'm1', $startupTime + $actionTime + $shutdownTime, $actionTime);
    }


    public function testOneFullForward()
    {
        $startupTime = $this->getDelay(250000);
        $shutdownTime = $this->getDelay(250000);
        $actionTime = $this->getDelay(100000);
        
        $this->timer->routeStartup($this->request());
        usleep($startupTime);
        $this->timer->preDispatch($this->request('a1', 'c1', 'm1'));
        usleep($actionTime);
        $this->timer->postDispatch($this->request('a1', 'c1', 'm1'));
        $this->timer->preDispatch($this->request('a2', 'c2', 'm2'));
        usleep($actionTime);
        $this->timer->postDispatch($this->request('a2', 'c2', 'm2'));
        usleep($shutdownTime);
        $this->timer->dispatchLoopShutdown();
        
        $this->check('a2', 'c2', 'm2', $startupTime + $actionTime * 2 + $shutdownTime, $actionTime * 2);
    }


    public function testAbortedForward()
    {
        $startupTime = $this->getDelay(250000);
        $shutdownTime = $this->getDelay(250000);
        $actionTime = $this->getDelay(100000);
        
        $this->timer->routeStartup($this->request());
        usleep($startupTime);
        $this->timer->preDispatch($this->request('a1', 'c1', 'm1'));
        usleep($actionTime);
        $this->timer->preDispatch($this->request('a2', 'c2', 'm2'));
        usleep($actionTime);
        $this->timer->preDispatch($this->request('a3', 'c3', 'm3'));
        usleep($actionTime);
        $this->timer->postDispatch($this->request('a3', 'c3', 'm3'));
        usleep($shutdownTime);
        $this->timer->dispatchLoopShutdown();
        
        $this->check('a3', 'c3', 'm3', $startupTime + $actionTime * 3 + $shutdownTime, $actionTime);
    }


    public function testActionNotRecorded()
    {
        $startupTime = $this->getDelay(250000);
        $shutdownTime = $this->getDelay(250000);
        $actionTime = $this->getDelay(100000);
        
        $this->timer->routeStartup($this->request());
        usleep($startupTime);
        $this->timer->preDispatch($this->request('a1', 'c1', 'm1'));
        usleep($actionTime);
        $this->timer->preDispatch($this->request('a2', 'c2', 'm2'));
        usleep($actionTime);
        $this->timer->preDispatch($this->request('a3', 'c3', 'm3'));
        usleep($actionTime);
        usleep($shutdownTime);
        $this->timer->dispatchLoopShutdown();
        
        $this->assertFalse($this->dao->timeLogged);
    }


    private function check($expectedAction, $expectedController, $expectedModule, 
            $expectedTotalTime, $expectedActionTime)
    {
        $this->assertTrue($this->dao->timeLogged);
        $this->assertEqual($this->dao->action, $expectedAction);
        $this->assertEqual($this->dao->controller, $expectedController);
        $this->assertEqual($this->dao->module, $expectedModule);
        $this->assertWithinMargin($expectedTotalTime / 1000000, $this->dao->totalTime, $this->margin / 1000000);
        $this->assertWithinMargin($expectedActionTime / 1000000, $this->dao->actionTime, $this->margin / 1000000);
    }


    private function request($action = null, $controller = null, $module = null)
    {
        $request = new Zend_Controller_Request_Http();
        
        if ($action) {
            $request->setActionName($action);
        }
        if ($controller) {
            $request->setControllerName($controller);
        }
        if ($module) {
            $request->setModuleName($module);
        }
        
        return $request;
    }
    
    private function getDelay($delay)
    {
        return $delay + $this->margin;
    }
}

class DummyExecutionTimerDao implements OX_UI_Controller_Plugin_ExecutionTimerDao
{
    public $action;
    public $controller;
    public $module;
    public $totalTime;
    public $actionTime;

    public $timeLogged = false;

    public function logTime($action, $controller, $module, $totalTime, $actionTime)
    {
        $this->action = $action;
        $this->controller = $controller;
        $this->module = $module;
        $this->totalTime = $totalTime;
        $this->actionTime = $actionTime;
        $this->timeLogged = true;
    }
}
