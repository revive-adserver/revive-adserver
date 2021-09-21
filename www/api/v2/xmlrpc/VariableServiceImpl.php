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

/**
 * @package    OpenX
 */

require_once MAX_PATH . '/www/api/v2/common/BaseServiceImpl.php';
require_once MAX_PATH . '/lib/OA/Dll/Variable.php';


class VariableServiceImpl extends BaseServiceImpl
{
    private $dllVariable;


    public function __construct()
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
                $this->dllVariable->getVariable($variableId, $oVariableInfo)
            );
        } else {
            return false;
        }
    }
}
