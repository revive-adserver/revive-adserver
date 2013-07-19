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

require_once '../../../../init.php';
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';
require_once MAX_PATH . '/www/api/v2/common/BaseVariableService.php';
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';
require_once MAX_PATH . '/lib/OA/Dll/Variable.php';

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
class VariableXmlRpcService extends BaseVariableService
{
    /**
     *
     * @param XML_RPC_Message &$oParams
     * @return generated result (data or error)
     */
    public function addVariable(&$oParams)
    {
        $sessionId = null;
        $oVariableInfo = new OA_Dll_VariableInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarAndNotScalarFields($oVariableInfo, $oParams, 1,
                array('trackerId', 'variableName', 'description', 'dataType',
                    'purpose', 'rejectIfEmpty', 'isUnique', 'uniqueWindow',
                    'variableCode', 'hidden'),
                array('hiddenWebsites'),
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->oVariableServiceImpl->addVariable($sessionId, $oVariableInfo)) {
            return XmlRpcUtils::integerTypeResponse($oVariableInfo->variableId);
        } else {
            return XmlRpcUtils::generateError($this->oVariableServiceImpl->getLastError());
        }
    }

    /**
     * Changes the details for an existing variable.
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function modifyVariable(&$oParams)
    {
        $sessionId  = null;
        $oVariableInfo = new OA_Dll_VariableInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarAndNotScalarFields($oVariableInfo, $oParams, 1,
                array('variableId', 'trackerId', 'variableName', 'description',
                    'dataType', 'purpose', 'rejectIfEmpty', 'isUnique', 'uniqueWindow',
                    'variableCode', 'hidden'),
                array('hiddenWebsites'),
                $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->oVariableServiceImpl->modifyVariable($sessionId, $oVariableInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->oVariableServiceImpl->getLastError());
        }
    }

    /**
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function deleteVariable(&$oParams)
    {
        $sessionId = null;
        $variableId = null;
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$variableId),
            array(true, true), $oParams, $oResponseWithError )) {

            return $oResponseWithError;
        }

        if ($this->oVariableServiceImpl->deleteVariable($sessionId, $variableId)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->oVariableServiceImpl->getLastError());
        }
    }

    public function getVariable(&$oParams)
    {
        $sessionId = null;
        $variableId = null;
        $oVariableInfo = new OA_Dll_VariableInfo();
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$variableId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        if ($this->oVariableServiceImpl->getVariable($sessionId,
                $variableId, $oVariableInfo)) {

            return XmlRpcUtils::getEntityResponse($oVariableInfo);
        } else {

            return XmlRpcUtils::generateError($this->oVariableServiceImpl->getLastError());
        }
    }
}

?>
