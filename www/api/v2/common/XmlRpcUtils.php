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

// Require the XMLRPC classes
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

// Require the Pear::Date class
require_once MAX_PATH . '/lib/pear/Date.php';

// Require the lib/OA/Dal.php class to deal with DBMS-specific zero-date values
require_once MAX_PATH . '/lib/OA/Dal.php';

/**
 * XmlRpc methods class description.
 *
 */
class XmlRpcUtils
{
    /**
     * Generate Error message.
     *
     * @access public
     *
     * @param string $errorMessage
     *
     * @return XML_RPC_Response
     */
    public static function generateError($errorMessage)
    {
        // import user errcode value
        global $XML_RPC_erruser;

        $errorCode = $XML_RPC_erruser + 1;
        return new XML_RPC_Response(0, $errorCode, $errorMessage);
    }

    /**
     * Response string.
     *
     * @access public
     *
     * @param string $string
     *
     * @return XML_RPC_Response
     */
    public static function stringTypeResponse($string)
    {
        $value = new XML_RPC_Value($string, $GLOBALS['XML_RPC_String']);
        return new XML_RPC_Response($value);
    }

    /**
     * Response boolean.
     *
     * @access public
     *
     * @param boolean $boolean
     *
     * @return XML_RPC_Response
     */
    public static function booleanTypeResponse($boolean)
    {
        $value = new XML_RPC_Value($boolean, $GLOBALS['XML_RPC_Boolean']);
        return new XML_RPC_Response($value);
    }

    /**
     * Response integer.
     *
     * @access public
     *
     * @param integer $integer
     *
     * @return XML_RPC_Response
     */
    public static function integerTypeResponse($integer)
    {
        $value = new XML_RPC_Value($integer, $GLOBALS['XML_RPC_Int']);
        return new XML_RPC_Response($value);
    }

    /**
     * Convert array, MDB2 resultset or RecordSet into the array of XML_RPC_Response structures.
     *
     * @access public
     *
     * @param array $aFieldTypes  field name - field type
     * @param mixed $data         Array or RecordSet with all data
     *
     * @return XML_RPC_Response
     */
    public static function arrayOfStructuresResponse($aFieldTypes, $data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::convertRowDataToStruct($aFieldTypes, $v);
            }

            $aReturnData = $data;
        } elseif ($data instanceof MDB2_Result_Common) {
            $aReturnData = [];
            while ($aRowData = $data->fetchRow(MDB2_FETCHMODE_ASSOC)) {
                $aReturnData[] = self::convertRowDataToStruct($aFieldTypes, $aRowData);
            }
        } elseif ($data instanceof MDB2RecordSet) {
            $aReturnData = [];
            $data->find();
            while ($data->fetch()) {
                $aReturnData[] = self::convertRowDataToStruct($aFieldTypes, $data->toArray());
            }
        } else {
            return new XML_RPC_Response('', $GLOBALS['XML_RPC_error'], 'Unsupported data passed to arrayOfStructuresResponse');
        }

        $value = new XML_RPC_Value($aReturnData, $GLOBALS['XML_RPC_Array']);

        return new XML_RPC_Response($value);
    }

    /**
     * A private method to convert a data row to an XML-RPC struct
     *
     * @param array $aFieldTypes
     * @param array $aRowData
     * @return XML_RPC_Value
     */
    private static function convertRowDataToStruct($aFieldTypes, $aRowData)
    {
        $aResult = [];
        foreach ($aRowData as $databaseFieldName => $fieldValue) {
            foreach ($aFieldTypes as $fieldName => $fieldType) {
                if (strtolower($fieldName) == strtolower($databaseFieldName)) {
                    $aResult[$fieldName] = self::_setRPCTypeWithDefaultValues(
                        $fieldType,
                        $fieldValue
                    );
                }
            }
        }

        return new XML_RPC_Value($aResult, $GLOBALS['XML_RPC_Struct']);
    }

    /**
     * Converts Info Object into XML_RPC_Value
     *
     * @access public
     *
     * @param object &$oInfoObject
     *
     * @return XML_RPC_Value
     */
    public static function getEntity(&$oInfoObject)
    {
        $aInfoData = (array) $oInfoObject;
        $aReturnData = [];

        foreach ($aInfoData as $fieldName => $fieldValue) {
            $aReturnData[$fieldName] = self::_setRPCTypeForField(
                $oInfoObject->getFieldType($fieldName),
                $fieldValue
            );
        }
        return new XML_RPC_Value(
            $aReturnData,
            $GLOBALS['XML_RPC_Struct']
        );
    }

    /**
     * Converts Info Object into XML_RPC_Value and deletes null fields
     *
     * @access public
     *
     * @param object &$oInfoObject
     *
     * @return XML_RPC_Value
     */
    public static function getEntityWithNotNullFields(&$oInfoObject)
    {
        $aInfoData = $oInfoObject->toArray();
        $aReturnData = [];

        foreach ($aInfoData as $fieldName => $fieldValue) {
            if (!is_null($fieldValue)) {
                $aReturnData[$fieldName] = self::_setRPCTypeForField(
                    $oInfoObject->getFieldType($fieldName),
                    $fieldValue
                );
            }
        }
        return new XML_RPC_Value(
            $aReturnData,
            $GLOBALS['XML_RPC_Struct']
        );
    }

    /**
     * Converts Info Object into XML_RPC_Response structure
     *
     * @access public
     *
     * @param object &$oInfoObject
     *
     * @return XML_RPC_Response
     */
    public static function getEntityResponse(&$oInfoObject)
    {
        return new XML_RPC_Response(self::getEntityWithNotNullFields($oInfoObject));
    }

    /**
     * Converts Info Object into the array of  XML_RPC_Response structures
     *
     * @access public
     *
     * @param object $aInfoObjects
     *
     * @return XML_RPC_Response
     */
    public static function getArrayOfEntityResponse($aInfoObjects)
    {
        $cRecords = 0;

        foreach ($aInfoObjects as $oInfoObject) {
            $xmlValue[$cRecords] = self::getEntityWithNotNullFields($oInfoObject);
            $cRecords++;
        }

        $value = new XML_RPC_Value(
            $xmlValue,
            $GLOBALS['XML_RPC_Array']
        );

        return new XML_RPC_Response($value);
    }

    /**
     * Set RPC type for variable with default values.
     *
     * @access private
     *
     * @param string $type
     * @param mixed $variable
     *
     * @return XML_RPC_Value or false
     */
    private static function _setRPCTypeWithDefaultValues($type, $variable)
    {
        switch ($type) {
            case 'struct':
                if (is_null($variable)) {
                    $variable = [];
                }
                return XML_RPC_encode($variable);
            case 'array':
                if (is_null($variable)) {
                    $variable = [];
                }
                return XML_RPC_encode($variable);
            case 'string':
                if (is_null($variable)) {
                    $variable = '';
                }
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_String']);

            case 'integer':
                if (is_null($variable)) {
                    $variable = 0;
                }
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Int']);

            case 'float':
            case 'double':
                if (is_null($variable)) {
                    $variable = 0.0;
                }
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Double']);

            case 'date':
                $dateVariable = null;
                if (isset($variable)) {
                    if (!is_string($variable)) {
                        MAX::raiseError('Date for statistics should be represented as string');
                        exit;
                    }

                    if (!empty($variable)) {
                        $dateVariable = date('Ymd\TH:i:s', strtotime($variable));
                    }
                }

                return new XML_RPC_Value($dateVariable, $GLOBALS['XML_RPC_DateTime']);
        }
        MAX::raiseError('Unsupported Xml Rpc type \'' . $type . '\'');
        exit;
    }

    /**
     * Set RPC type for variable.
     *
     * @access private
     *
     * @param string $type
     * @param mixed $variable
     *
     * @return XML_RPC_Value or false
     */
    private static function _setRPCTypeForField($type, $variable)
    {
        switch ($type) {
            case 'string':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_String']);

            case 'integer':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Int']);

            case 'float':
            case 'double':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Double']);

            case 'boolean':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Boolean']);

            case 'date':

                if (!is_object($variable) || !is_a($variable, 'Date')) {
                    MAX::raiseError('Value should be PEAR::Date type');
                    exit;
                }

                $value = $variable->format('%Y%m%d') . 'T00:00:00';
                return new XML_RPC_Value($value, $GLOBALS['XML_RPC_DateTime']);

            case 'array':
                return new XML_RPC_Value($variable, $GLOBALS['XML_RPC_Array']);

            case 'custom':
                return $variable;
        }
        MAX::raiseError('Unsupported Xml Rpc type \'' . $type . '\'');
        exit;
    }

    /**
     * Convert Date from iso 8601 format.
     *
     * @access private
     *
     * @param string $date  date string in ISO 8601 format
     * @param PEAR::Date &$oResult  transformed date
     * @param XML_RPC_Response &$oResponseWithError  response with error message
     *
     * @return boolean  shows true if method was executed successfully
     */
    private static function _convertDateFromIso8601Format($date, &$oResult, &$oResponseWithError)
    {
        $datetime = explode('T', $date);
        $year = substr($datetime[0], 0, (strlen($datetime[0]) - 4));
        $month = substr($datetime[0], -4, 2);
        $day = substr($datetime[0], -2, 2);

        // Explicitly allow the "zero date" value to be set
        if (($year == 0) && ($month == 0) && ($day == 0)) {
            $oResult = new Date('0000-00-00');
            return true;
        }

        if (($year < 1970) || ($year > 2038)) {
            $oResponseWithError = self::generateError('Year should be in range 1970-2038');
            return false;
        } elseif (($month < 1) || ($month > 12)) {
            $oResponseWithError = self::generateError('Month should be in range 1-12');
            return false;
        } elseif (($day < 1) || ($day > 31)) {
            $oResponseWithError = self::generateError('Day should be in range 1-31');
            return false;
        } else {
            $oResult = new Date();
            $oResult->setYear($year);
            $oResult->setMonth($month);
            $oResult->setDay($day);

            return true;
        }
    }

    /**
     * Get scalar value from parameter
     *
     * @access private
     *
     * @param mixed &$result
     * @param XML_RPC_Value &$oParam
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    private static function _getScalarValue(&$result, &$oParam, &$oResponseWithError)
    {
        if ($oParam->scalartyp() == $GLOBALS['XML_RPC_Int']) {
            $result = (int) $oParam->scalarval();
            return true;
        } elseif ($oParam->scalartyp() == $GLOBALS['XML_RPC_DateTime']) {
            return self::_convertDateFromIso8601Format(
                $oParam->scalarval(),
                $result,
                $oResponseWithError
            );
        } elseif ($oParam->scalartyp() == $GLOBALS['XML_RPC_Boolean']) {
            $result = (bool) $oParam->scalarval();
            return true;
        } elseif ($oParam->scalartyp() == $GLOBALS['XML_RPC_Double']) {
            $result = (float) $oParam->scalarval();
            return true;
        } else {
            $result = $oParam->scalarval();
            return true;
        }
    }

    /**
     * Get non-scalar value from parameter
     *
     * @param mixed &$result
     * @param XML_RPC_Value &$oParam
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getNonScalarValue(&$result, &$oParam, &$oResponseWithError)
    {
        $result = XML_RPC_decode($oParam);
        return true;
    }

    /**
     * Get not required non-scalar value
     *
     * @param mixed &$result value or null
     * @param XML_RPC_Message  &$oParams
     * @param integer $idxParam
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getNotRequiredNonScalarValue(&$result, &$oParams, $idxParam, &$oResponseWithError)
    {
        $cParams = $oParams->getNumParams();
        if ($cParams > $idxParam) {
            $oParam = $oParams->getParam($idxParam);

            return self::getNonScalarValue($result, $oParam, $oResponseWithError);
        } else {
            $result = null;
            return true;
        }
    }

    /**
     * Get required scalar value
     *
     * @access public
     *
     * @param mixed &$result
     * @param XML_RPC_Message  &$oParams
     * @param integer $idxParam
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getRequiredScalarValue(&$result, &$oParams, $idxParam, &$oResponseWithError)
    {
        $oParam = $oParams->getParam($idxParam);
        return self::_getScalarValue($result, $oParam, $oResponseWithError);
    }

    /**
     * Get not required scalar value
     *
     * @access private
     *
     * @param mixed &$result value or null
     * @param XML_RPC_Message  &$oParams
     * @param integer $idxParam
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    private static function _getNotRequiredScalarValue(&$result, &$oParams, $idxParam, &$oResponseWithError)
    {
        $cParams = $oParams->getNumParams();
        if ($cParams > $idxParam) {
            $oParam = $oParams->getParam($idxParam);

            return self::_getScalarValue($result, $oParam, $oResponseWithError);
        } else {
            $result = null;
            return true;
        }
    }

    /**
     * Get scalar values from parameters
     *
     * @access public
     *
     * @param array $aReferencesOnVariables array of references to variables
     * @param array $aRequired array of boolean values to indicate which field is required
     * @param XML_RPC_Message  $oParams
     * @param XML_RPC_Response &$oResponseWithError
     * @param integer $idxStart Index of parameter from which values start
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getScalarValues(
        $aReferencesOnVariables,
        $aRequired,
        &$oParams,
        &$oResponseWithError,
        $idxStart = 0
    ) {
        if (count($aReferencesOnVariables) != count($aRequired)) {
            MAX::raiseError('$aReferencesOnVariables & $aRequired arrays should have the same length');
            exit;
        }

        $cVariables = count($aReferencesOnVariables);
        for ($i = 0; $i < $cVariables; $i++) {
            if ($aRequired[$i]) {
                if (!self::getRequiredScalarValue(
                    $aReferencesOnVariables[$i],
                    $oParams,
                    $i + $idxStart,
                    $oResponseWithError
                )) {
                    return false;
                }
            } else {
                if (!self::_getNotRequiredScalarValue(
                    $aReferencesOnVariables[$i],
                    $oParams,
                    $i + $idxStart,
                    $oResponseWithError
                )) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Gets Structure Scalar field from XML RPC Value parameter
     *
     * @access private
     *
     * @param structure &$oStructure  to return data
     * @param XML_RPC_Value $oStructParam
     * @param string $fieldName
     * @param XML_RPC_Response &$responseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    private static function _getStructureScalarField(
        &$oStructure,
        &$oStructParam,
        $fieldName,
        &$oResponseWithError
    ) {
        $oParam = $oStructParam->structmem($fieldName);
        if (isset($oParam)) {
            if ($oParam->kindOf() == 'scalar') {
                return self::_getScalarValue($oStructure->$fieldName, $oParam, $oResponseWithError);
            } else {
                $oResponseWithError = self::generateError(
                    'Structure field \'' . $fieldName . '\' should be scalar type '
                );
                return false;
            }
        } else {
            return true;
        }
    }


    /**
     * Gets Structure Non Scalar field from XML RPC Value parameter
     *
     * @access private
     *
     * @param structure &$oStructure  to return data
     * @param XML_RPC_Value $oStructParam
     * @param string $fieldName
     * @param XML_RPC_Response &$responseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    private static function _getStructureNonScalarField(&$oStructure, &$oStructParam, $fieldName, &$oResponseWithError)
    {
        $oParam = $oStructParam->structmem($fieldName);
        if (isset($oParam)) {
            if ($oParam->kindOf() != 'scalar') {
                return self::getNonScalarValue($oStructure->$fieldName, $oParam, $oResponseWithError);
            } else {
                $oResponseWithError = self::generateError(
                    'Structure field \'' . $fieldName . '\' should be non-scalar type '
                );
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Gets Structure Scalar fields
     *
     * @access public
     *
     * @param structure &$oStructure  to return data
     * @param XML_RPC_Message &$oParams
     * @param integer $idxParam
     * @param array $aFieldNames
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getStructureScalarFields(
        &$oStructure,
        &$oParams,
        $idxParam,
        $aFieldNames,
        &$oResponseWithError
    ) {
        $oStructParam = $oParams->getParam($idxParam);

        foreach ($aFieldNames as $fieldName) {
            if (!self::_getStructureScalarField(
                $oStructure,
                $oStructParam,
                $fieldName,
                $oResponseWithError
            )) {
                return false;
            }
        }
        return true;
    }

    /**
     * Gets array of Structures
     *
     * @access public
     *
     * @param array &$aStructures  to return data
     * @param string $className class name for entity
     * @param XML_RPC_Message &$oParams
     * @param integer $idxParam
     * @param array $aFieldNames
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getArrayOfStructuresScalarFields(
        &$aStructures,
        $className,
        &$oParams,
        $idxParam,
        $aFieldNames,
        &$oResponseWithError
    ) {
        $oArrayParam = $oParams->getParam($idxParam);
        $count = $oArrayParam->arraysize();

        for ($i = 0; $i < $count; $i++) {
            $oStructure = new $className();
            foreach ($aFieldNames as $fieldName) {
                $oStructParam = $oArrayParam->arraymem($i);
                if (!self::_getStructureScalarField(
                    $oStructure,
                    $oStructParam,
                    $fieldName,
                    $oResponseWithError
                )) {
                    return false;
                }
            }
            $aStructures[] = $oStructure;
        }
        return true;
    }


    /**
     * Gets Structure Scalar and non-Scalar fields
     *
     * @access public
     *
     * @param structure &$oStructure  to return data
     * @param XML_RPC_Message &$oParams
     * @param integer $idxParam
     * @param array $aScalars Field names array
     * @param array $aNonScalars Field names array
     * @param XML_RPC_Response &$oResponseWithError
     *
     * @return boolean  shows true if method was executed successfully
     */
    public static function getStructureScalarAndNotScalarFields(
        &$oStructure,
        &$oParams,
        $idxParam,
        $aScalars,
        $aNonScalars,
        &$oResponseWithError
    ) {
        $result = self::getStructureScalarFields($oStructure, $oParams, $idxParam, $aScalars, $oResponseWithError);

        if ($result) {
            $oStructParam = $oParams->getParam($idxParam);

            foreach ($aNonScalars as $fieldName) {
                if (!self::_getStructureNonScalarField(
                    $oStructure,
                    $oStructParam,
                    $fieldName,
                    $oResponseWithError
                )) {
                    return false;
                }
            }
        } else {
            return false;
        }

        return true;
    }
}
