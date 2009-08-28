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
 * @package    OpenX
 * @author     David Keen <david.keen@openx.org>
 *
 */

require_once MAX_PATH . '/www/api/v2/common/BaseServiceImpl.php';
require_once MAX_PATH . '/lib/OA/Dll/Variable.php';


class VariableServiceImpl extends BaseServiceImpl
{
    private $dllVariable;


    function __construct()
    {
        parent::__construct();
        $this->dllVariable = new OA_Dll_Variable();
    }

    /**
     * This method checks if an action is valid and either returns a result
     * or an error, as appropriate.
     *
     * @param boolean $result
     *
     * @return boolean
     */
    private function validateResult($result)
    {
        if ($result) {
            return true;
        } else {
            $this->raiseError($this->dllVariable->getLastError());
            return false;
        }
    }

    /**
     *
     * @param string $sessionId
     * @param OA_Dll_VariableInfo &$oVariableInfo <br />
     *          <b>Required properties:</b> variableName, trackerId<br />
     *          <b>Optional properties:</b> description, dataType, purpose, rejectIfEmpty, isUnique, uniqueWindow, variableCode, hidden, hiddenWebsites<br />
     *
     * @return boolean
     */
    public function addVariable($sessionId, &$oVariableInfo)
    {
        if ($this->verifySession($sessionId)) {
            return $this->validateResult($this->dllVariable->modify($oVariableInfo));
        } else {
            return false;
        }
    }

    /**
     * Modifies the details for the variable
     *
     * @param string $sessionId
     * @param OA_Dll_VariableInfo &$oVariable <br />
     *          <b>Required properties:</b> variableId<br />
     *          <b>Optional properties:</b> variableName, description, dataType, purpose, rejectIfEmpty, isUnique, uniqueWindow, variableCode, hidden, hiddenWebsites<br />
     *
     * @return boolean
     */
    public function modifyVariable($sessionId, &$oVariableInfo)
    {
        if ($this->verifySession($sessionId)) {
            if (isset($oVariableInfo->variableId)) {
                return $this->validateResult($this->dllVariable->modify($oVariableInfo));
            } else {
                $this->raiseError("Field 'variableId' in structure does not exist");
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     *
     * @param string $sessionId
     * @param integer $variableId
     *
     * @return boolean
     */
    public function deleteVariable($sessionId, $variableId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->validateResult($this->dllVariable->delete($variableId));
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $sessionId
     * @param int $variableId
     * @param OA_Dll_VariableInfo $oVariableInfo
     * @return boolean
     */
    public function getVariable($sessionId, $variableId, &$oVariableInfo)
    {
        if ($this->verifySession($sessionId)) {

            return $this->validateResult(
                $this->dllVariable->getVariable($variableId, $oVariableInfo));
        } else {

            return false;
        }
    }
}

?>