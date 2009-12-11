<?php

class RequestUtilsTest 
    extends UnitTestCase
{
    /**
     * Enter description here...
     *
     * @var Zend_Controller_Request_Abstract
     */
    private $request;
    
    public function setUp()
    {
        $this->request = new Zend_Controller_Request_HttpTestCase();    
    }
    
    
    public function testMatches()
    {
        $aActions = $this->getActionsArray();
        
        //check exact matches
        $request = $this->setRequest('publisher', 'home', 'index');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertTrue($result);
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, true);
        $this->assertTrue($result);
        
        $request = $this->setRequest('account', 'payment', 'index');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertTrue($result);
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, true);
        $this->assertTrue($result);
        
        $request = $this->setRequest('account', 'payment', 'list');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertTrue($result);
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, true);
        $this->assertTrue($result);
        
        
        //check fuzzy matches
        $request = $this->setRequest('account', 'account', 'index');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertTrue($result);
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, true);
        $this->assertFalse($result);
        
        $request = $this->setRequest('account', 'account', 'list');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertTrue($result);
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, true);
        $this->assertTrue($result);        
        
        
        //check non-matching
        $request = $this->setRequest('publisher', 'home', 'list');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertFalse($result);
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, false);
        $this->assertFalse($result);
        
        $request = $this->setRequest('index', 'home', 'publisher');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions);
        $this->assertFalse($result);
        
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, $aActions, false);
        $this->assertFalse($result);
        
        
        //check empty
        $request = $this->setRequest('publisher', 'home', 'index');
        $result = OX_UI_Controller_Request_RequestUtils::matches($request, array());
        $this->assertFalse($result);
    }
       
    
    private function getActionsArray()
    {
        return array (
            array (
                    'module' => 'publisher',
                    'controller' => 'home', 
                    'action' => 'index'), 
            array (
                    'module' => 'account',
                    'controller' => 'payment', 
                    'action' => 'index'), 
            array (
                    'module' => 'account',
                    'controller' => 'payment', 
                    'action' => 'list'), 
            array (                             //fuzzy one
                    'module' => 'account',
                    'controller' => 'account'),
            array (
                    'module' => 'account',
                    'controller' => 'account',
                    'action' => 'list')            
            );
            
    }

    
    private function setRequest($module, $controller, $action)
    {
        $request = $this->request;
        
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
        
        return $request;
    }
}


