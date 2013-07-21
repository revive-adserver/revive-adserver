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

require_once dirname(__FILE__) . '/../Central/Cas.php';

/**
 * A very simple base controller for home cooked MVC for this plugin.
 *
 */
class OA_Controller_SSO_BaseController
{
    var $request;

    /**
     * Registered actions. Only these actions may be executed from withing controller
     *
     * @var array
     */
    var $aActions;
    var $actionDefault = 'display';

    var $oTpl;
    var $aModel;

    var $aErrors = array();

    function init()
    {
        $this->initModel();
        $this->aActions = $this->getRegisteredActions();
    }

    
    function initModel()
    {
    }
    
    
    function getRegisteredActions()
    {
        return array();
    }
    

    function process($request)
    {
        $this->setRequest($request);
        $this->init();
        return $this->executeAction($this->request['action']);
    }
    

    function executeAction($action)
    {
        if (empty($action)) {
            $action = $this->actionDefault;
        }
        if (in_array($action, $this->aActions)) {
            $functionName = $action.'Action';
            return $this->$functionName();
        }
        MAX::raiseError('No such action: ' . $action, PEAR_ERROR_DIE);
    }
    

    function setRequest($request)
    {
        $this->request = $request;
    }
    

    function setView(&$oTpl)
    {
        $this->oTpl = &$oTpl;
    }
    

    function &getView()
    {
        return $this->oTpl;
    }
    

    function setModelProperty($propety, $value)
    {
        $this->aModel[$propety] = $value;
    }
    

    function assignModelToView(&$oTpl)
    {
        foreach ($this->aModel as $property => $value) {
            $oTpl->assign($property, $value);
        }
    }

    
    /**
     * Returns true if checked value is equal false or it it is a PEAR_Error
     *
     * @param mixed $error
     * @return boolean
     */
    function isError($error)
    {
        return $error === false || PEAR::isError($error);
    }
    

    function getErrors()
    {
        return $this->aErrors;
    }

    
    function addError($errorMsg)
    {
        if (PEAR::isError($errorMsg)) {
            $errorMsg = $this->oPlugin->translate($this->msgErrorPrefix) . $errorMsg->getMessage();
        } else {
            $errorMsg = $this->oPlugin->translate($errorMsg);
        }
        $this->aErrors[] = $errorMsg;
    }
}

?>