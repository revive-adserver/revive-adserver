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


/**
 * A very simple base controller for home cooked MVC for installer.
 * 
 * @package OX_Admin_UI
 * @subpackage Controller
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Controller_BaseController
{
    /**
     * @var $request OX_Admin_UI_Controller_Request
     */
    protected $request;

    /**
     * Registered actions. Only these actions may be executed from withing controller
     *
     * @var array
     */
    protected $aActions;
    protected $actionDefault = 'index';
    protected $currentAction;
    
    
    protected $oView;
    protected $aModel;
    
    protected $hasLayout;
    protected $hasViewScript;

    protected $aErrors = array();
    
    
    public function __construct()
    {
        $this->hasLayout = true;
        $this->hasViewScript = true;
        
    }

    
    protected function init()
    {
        $this->initModel();
        $this->aActions = $this->getRegisteredActions();
    }

    
    protected function initModel()
    {
        $this->aModel = array();
    }
    
    
    protected function getRegisteredActions()
    {
        return array();
    }
    
    
    /**
     * Checks request action parameter and executes appriopriate action.
     *
     * @param OX_Admin_UI_Controller_Request $request
     * @return mixed action results
     */
    public function process($request)
    {
        $this->setRequest($request);
        $this->init();
        return $this->execute($this->request->getParam('action'));
    }
    

    protected function execute($action = null)
    {
        if (empty($action)) {
            $action = $this->actionDefault;
        }
        if (in_array($action, $this->aActions)) {
            $functionName = $action.'Action';
            $this->currentAction = $action;
            return $this->$functionName();
        }
        MAX::raiseError('No such action: ' . $action, PEAR_ERROR_DIE);
    }
    

    /**
     * Forwards processing of request to another action. All model properties
     * are preserved. Also, view and layout status is preserved. 
     *
     * @param string $action
     */
    protected function forward($action)
    {
        return $this->execute($action);
    }
    
    
    /**
     * Performs HTTP redirect to given action in same controller
     *
     * @param string $action action name to be redirected to
     */
    protected function redirect($action)
    {
        $oRequest = $this->getRequest();
        
        $url = $oRequest->getRequestUri();
        // Remove the query string from REQUEST_URI
        if ($pos = strpos($url, '?')) {
            $url = substr($url, 0, $pos);
        }
        $url = $url.'?action='.$action;
        header('Location: ' . $url);
        exit;    
    }
    

    protected function setRequest($request)
    {
        $this->request = $request;
    }
    
    
    /*
     * Returns request object for that request.
     * 
     * @return OX_Admin_UI_Controller_Request
     */
    protected function getRequest()
    {
        return $this->request;
    }
    

    public function setView($oView)
    {
        $this->oView = $oView;
    }
    
     /*
      * Returns the name of the serviced action 
      */
    public function getAction()
    {
        return $this->currentAction;
    }

    

    public function getView()
    {
        return $this->oView;
    }
    

    public function setModelProperty($property, $value)
    {
        $this->aModel[$property] = $value;
    }
    
    
    public function getModelProperty($property)
    {
        return isset($this->aModel[$property]) ? $this->aModel[$property] : null; 
    }
    
    

    public function assignModelToView($view = null)
    {
        if ($view == null) {
            if ($this->getView() == null) {
                MAX::raiseError('No view provided', PEAR_ERROR_DIE);
                return;
            }
            $view = $this->getView();
        }
        
        foreach ($this->aModel as $property => $value) {
            $view->assign($property, $value);
        }
    }
    

    /**
     * Indicates that action has no view script
     */
    public function noViewScript()
    {
        $this->hasViewScript = false;    
    }
    
    
    public function hasViewScript()
    {
        return $this->hasViewScript;    
    }
    
    
    public function disableLayout()
    {
        $this->hasLayout = false;
    }
    

    public function hasLayout()
    {
        return $this->hasLayout;
    }
        
    
    /**
     * Returns true if checked value is equal false or it it is a PEAR_Error
     *
     * @param mixed $error
     * @return boolean
     */
    protected function isError($error)
    {
        return $error === false || PEAR::isError($error);
    }
    

    protected function getErrors()
    {
        return $this->aErrors;
    }

    
    protected function addError($errorMsg)
    {
        if (PEAR::isError($errorMsg)) {
            $errorMsg = $this->translate($this->msgErrorPrefix) . $errorMsg->getMessage();
        } else {
            $errorMsg = $this->translate($errorMsg);
        }
        $this->aErrors[] = $errorMsg;
    }
    
    
}

?>