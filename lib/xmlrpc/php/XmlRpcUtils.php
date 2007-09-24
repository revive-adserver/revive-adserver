<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * @package    Openads
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * A file to description XmlRpcUtils class.
 *
 */

// Require the XMLRPC classes
require_once '../../pear/XML/RPC/Server.php';

/**
 * Class to description XmlRpc methods.
 *
 */
class XmlRpcUtils
{

    /**
     * Converts Info Object into XML_RPC_Value and delete null fields
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
     * Set RPC type for variable.
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

            case 'date':

                if (!is_object($variable) || !is_a($variable, 'Date')) {
                    die('Value should be PEAR::Date type');
                }

                if ($variable->format('%Y-%m-%d') == OA_DAL::noDateValue()) {

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