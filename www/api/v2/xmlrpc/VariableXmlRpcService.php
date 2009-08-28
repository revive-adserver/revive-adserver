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
