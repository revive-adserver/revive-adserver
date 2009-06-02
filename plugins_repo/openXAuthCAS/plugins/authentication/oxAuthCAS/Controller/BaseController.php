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
$Id: ConfirmAccount.php 30820 2009-01-13 19:02:17Z andrew.hill $
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