<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id:$
*/

/**
 * @package    OpenX
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * This file describes the XmlRpcUtils class.
 *
 */

// Require the XML-RPC classes.
require_once 'XML/RPC/Server.php';

/**
 * The XmlRpcUtils class contains various XmlRpc methods.
 *
 */
class XmlRpcUtils
{

    /**
     * This method converts the Info object into an XML_RPC_Value and deletes null fields.
     *
     * @param object &$oInfoObject
     * @return XML_RPC_Value
     */
    function getEntityWithNotNullFields(&$oInfoObject)
    {
        $aInfoData = (array) $oInfoObject;
        $aReturnData = array();

        foreach ($aInfoData as $fieldName => $fieldValue) {
            if (!is_null($fieldValue)) {
                $aReturnData[$fieldName] = XmlRpcUtils::_setRPCTypeForField(
                            $oInfoObject->getFieldType($fieldName), $fieldValue);
            }
        }
        return new XML_RPC_Value($aReturnData,
                                            $GLOBALS['XML_RPC_Struct']);
    }

    /**
     * This method sets the RPC type for variables.
     *
     * @param string $type
     * @param mixed $variable
     * @return XML_RPC_Value or false
     */
    function _setRPCTypeForField($type, $variable)
    {
        switch ($type) {
            case 'string':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_String']);

            case 'integer':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Int']);

            case 'float':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Double']);

            case 'boolean':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Boolean']);

            case 'date':

                if (!is_object($variable) || !is_a($variable, 'Date')) {
                    die('Value should be PEAR::Date type');
                }

                if ($variable->format('%Y-%m-%d') == '0000-00-00') {

                    return new XML_RPC_Value(null, $GLOBALS['XML_RPC_DateTime']);

                } else {

                    $value = $variable->format('%Y%m%d') . 'T00:00:00';
                    return new XML_RPC_Value($value, $GLOBALS['XML_RPC_DateTime']);

                }
        }
        die('Unsupported Xml Rpc type \'' . $type . '\'');
    }

}



?>