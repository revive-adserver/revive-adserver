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
$Id$
*/

/**
 * This package contains various utility functions used by Delivery Limitation
 * plugins.
 *
 * @package    MaxDelivery
 * @subpackage limitations
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 * @todo Move all the functions used by delivery part of delivery limitation
 * plugins from here to limitations.php. Move other functions to relevant
 * files, possibly creating a few libraries on the way.
 */

/**
 * The shortcut for {@link MAX_limitationsMatchString} with
 * $namespace set to 'CLIENT_GEO'. Useful for Geo delivery
 * limitation plugins.
 *
 * @param string $paramName
 * @param string $limitation
 * @param string $op
 * @param string $aParams
 * @return boolean
 * @see MAX_limitationsMatchString
 */
function MAX_limitationsMatchStringClientGeo($paramName, $limitation, $op, $aParams = array())
{
    return MAX_limitationsMatchString($paramName, $limitation, $op, $aParams, 'CLIENT_GEO');
}

/**
 * The utility function which checks if the value in the parameters
 * in the request for an ad fulfill the requirements of delivery limitation.
 * This function checks string values.
 * The parameters are looked in the $aParam array. If the $aParam array
 * is empty or unspecified, then $GLOBALS['_MAX']['$namespace'] array
 * is used instead.
 *
 * @param string $paramName Name of the parameter to look for in an array.
 * @param string $limitation Value to be matched with.
 * @param string $op The operator used to compare strings.
 * @param string $aParams The array in which the value is looked for.
 * @param string $namespace The namespace in the $GLOBALS['_MAX'] array used
 *               if when $aParams is empty.
 * @return boolean True if the parameters fulfill the limitations, false
 *                 otherwise.
 * @see MAX_limitationsMatchStringClientGeo
 * @see MAX_limitationsMatchStringValue
 */
function MAX_limitationsMatchString(
    $paramName, $limitation, $op, $aParams = array(), $namespace = 'CLIENT')
{
    if ($limitation == '') {
        return true;
    }
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX'][$namespace];
    }

    $value = $aParams[$paramName];

    return MAX_limitationsMatchStringValue($value, $limitation, $op);
}

/**
 * Match a numeric value (greater than or less than)
 *
 * @param string $paramName Name of the parameter to look for in an array.
 * @param string $limitation Value to be matched with.
 * @param string $op The operator used to compare strings.
 * @param string $aParams The array in which the value is looked for.
 * @param string $namespace The namespace in the $GLOBALS['_MAX'] array used
 *               if when $aParams is empty.
 * @return boolean True if the parameters fulfill the limitations, false
 *                 otherwise.
 *
 * @author Mohammed El-Hakim
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
function MAX_limitationMatchNumeric(
    $paramName, $limitation, $op, $aParams = array(), $namespace = 'CLIENT')
{
    if ($limitation == '') {
        return !MAX_limitationsIsOperatorPositive($op);
    }
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX'][$namespace];
    }

	if (!isset($aParams[$paramName]) || !is_numeric($aParams[$paramName]) || !is_numeric($limitation)) {
		return !MAX_limitationsIsOperatorPositive($op);
	} else {
	    $value = $aParams[$paramName];
	}

	if ($op == 'lt'){
    	return $value < $limitation;
    } else if ($op == 'gt'){
    	return $value > $limitation;
    } else {
    	return !MAX_limitationsIsOperatorPositive($op);
    }
}

/**
 * An utility function which matches the $value with $limitation
 * using $op operator.
 *
 * The possible operators are:
 * <ul>
 *   <li>==: true iff $value and $limitation are exactly the same</li>
 *   <li>!=: true iff $value and $limitation are different</li>
 *   <li>=~: true iff $value contains $limitation</li>
 *   <li>!=: true iff $value does not contain $limitation</li>
 *   <li>=x: true iff $value matches regular expression $limitation</li>
 *   <li>!x: true iff $value does not match regular expression $limitation</li>
 * </ul>
 *
 * @param string $value
 * @param string $limitation
 * @param string $op
 * @return boolean True if the $value matches the limitation,
 * false otherwise.
 */
function MAX_limitationsMatchStringValue($value, $limitation, $op)
{
    $limitation = strtolower($limitation);
    $value = strtolower($value);

    if ($op == '==') {
        return $limitation == $value;
    } elseif ($op == '!=') {
        return $limitation != $value;
    } elseif ($op == '=~') {
        return MAX_stringContains($value, $limitation);
    } elseif ($op == '!~') {
        return !MAX_stringContains($value, $limitation);
    } elseif ($op == '=x') {
        return preg_match(_getSRegexpDelimited($limitation), $value);
    } else {
        return !preg_match(_getSRegexpDelimited($limitation), $value);
    }
}


/**
 * An utility function which checks if the value in the array matches
 * the limitation specified in the $limitation and $op arguments.
 * Uses $GLOBALS['_MAX']['CLIENT_GEO'] array if $aParams is empty.
 * For details on how matching is done see
 * {@link MAX_limitationsMatchArrayValue}.
 *
 * @param string $paramName
 * @param string $limitation
 * @param string $op
 * @param array $aParams
 * @return boolean true if the value matches the limitation, false otherwise.
 */
function MAX_limitationsMatchArrayClientGeo($paramName, $limitation, $op, $aParams = array())
{
    return MAX_limitationsMatchArray($paramName, $limitation, $op, $aParams, 'CLIENT_GEO');
}


/**
 * An utility function which checks if the value in $aParams[$paramName]
 * matches the array limitations specified in $limitation and $op.
 * If $aParams is empty then $GLOBALS['_MAX'][$namespace] is used instead.
 * See {@link MAX_limitationsMatchArrayValue} for more details on
 * how matching is done.
 *
 * @param string $paramName
 * @param string $limitation
 * @param string $op
 * @param string $aParams
 * @param string $namespace
 * @return boolean True if the value matches the limitations, false otherwise.
 */
function MAX_limitationsMatchArray($paramName, $limitation, $op, $aParams = array(), $namespace='CLIENT')
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX'][$namespace];
    }
    if ($limitation == '' || empty($aParams)) {
        return true;
    }

    return MAX_limitationsMatchArrayValue($aParams[$paramName], $limitation, $op);
}

/**
 * An utility function which checks if the array specified in the $value
 * matches the limitation specified in the $limitation and $op variables.
 * The $value is supposed to be a single string and $limitation is
 * a list of values separated by `,' character.
 *
 * The function returns true if the $value matches the limitation,
 * false otherwise.
 *
 * The meaning of $op is the following:
 * <ul>
 *   <li>==: true iff $limitation consists of single value and this value
 *     is exactly the same as $value.</li>
 *   <li>=~: true iff $value is a member of the $limitation array.</li>
 *   <li>!~: true iff $value is not a member of the $limitation array.</li>
 * </ul>
 *
 * @param string $value Value to check against the limitation.
 * @param string $limitation The limitation specification as a string.
 * @param string $op The operator to use to apply the limitation.
 * @return boolean True if the $value matches the limitation,
 * false otherwise.
 */
function MAX_limitationsMatchArrayValue($value, $limitation, $op)
{
    $limitation = strtolower($limitation);
    $value = strtolower($value);

    $aLimitation = MAX_limitationsGetAFromS($limitation);

    if ($op == '==') {
        return count($aLimitation) == 1 && $value == $aLimitation[0];
    } elseif ($op == '=~') {
        return in_array($value, $aLimitation);
    } else {
        return !in_array($value, $aLimitation);
    }
}

/**
 * Returns true if $op is one of the simple operators: either '==' or '!=',
 * false otherwise.
 *
 * @param string $op The operator to be checked.
 * @return boolean True if $op is either '==' or '!=', false otherwise.
 */
function MAX_limitationsIsOperatorSimple($op)
{
    return $op == '==' || $op == '!=';
}


/**
 * Returns true if $op is one of the contains operators: either '=~' or '!~',
 * false otherwise.
 *
 * @param string $op The operator to be checked.
 * @return boolean True if $op is either '=~' or '!~', false otherwise.
 */
function MAX_limitationsIsOperatorContains($op)
{
    return $op == '=~' || $op == '!~';
}

function MAX_limitationsIsOperatorNumeric($op)
{
    return $op == 'gt' || $op == 'lt' ;
}

/**
 * Returns true if $op is one of the simple operators: either '=x' or '!x',
 * false otherwise.
 *
 * @param string $op The operator to be checked.
 * @return boolean True if $op is either '=x' or '!x', false otherwise.
 */
function MAX_limitationsIsOperatorRegexp($op)
{
    return $op == '=x' || $op == '!x';
}


/**
 * Returns true if $op is one of the positive operators: '==', '=~' or '=x',
 * false otherwise.
 *
 * @param string $op The operator to be checked.
 * @return boolean True if $op is '==', '=~' or '=x', false otherwise.
 */
function MAX_limitationsIsOperatorPositive($op)
{
    return $op == '==' || $op == '=~' || $op == '=x' || $op == 'gt' || $op == 'lt';
}

/**
 * Returns an array where the keys are delivery limitation plugins operators
 * suitable for numeric tests and the values are properly translated strings which
 * describe these operators to the user.
 *
 * @param DeliveryLimitationPlugin $oPlugin
 * @return array Array associating operators with their localized names.
 * @author By Mohammed El-Hakim
 */
function MAX_limitationsGetAOperationsForNumeric($oPlugin)
{
    return array(
        'lt'  => $GLOBALS['strLessThan'],
        'gt'  => $GLOBALS['strGreaterThan'],
    );
}

/**
 * Returns an array where the keys are delivery limitation plugins operators
 * suitable for strings and the values are properly translated strings which
 * describe these operators to the user.
 *
 * @param DeliveryLimitationPlugin $oPlugin
 * @return array Array associating operators with their localized names.
 */
function MAX_limitationsGetAOperationsForString($oPlugin)
{
    return array(
        '==' => $GLOBALS['strEqualTo'],
        '!=' => $GLOBALS['strDifferentFrom'],
        '=~' => MAX_Plugin_Translation::translate('Contains', $oPlugin->module, $oPlugin->package),
        '!~' => MAX_Plugin_Translation::translate('Does not contain', $oPlugin->module, $oPlugin->package),
        '=x' => MAX_Plugin_Translation::translate('Regex match', $oPlugin->module, $oPlugin->package),
        '!x' => MAX_Plugin_Translation::translate('Regex does not match', $oPlugin->module, $oPlugin->package)
    );
}


/**
 * An utility function to use in delivery limitation plugins
 * based on array. It creates a condition to be used as a part
 * of SQL query to select these impressions which match the
 * limitation.
 *
 * @param string $op The operator to be used in the limitation.
 * @param array $aData The limitation data in the form of array.
 * @param string $columnName The database column to check the limitation
 *        against. Usually a column from data_raw_ad_impression table.
 * @return string A SQL condition.
 */
function MAX_limitationsGetSqlForArray($op, $aData, $columnName)
{
    if (!is_array($aData) || empty($aData)) {
        return !MAX_limitationsIsOperatorPositive($op);
    }

    if ($op == '==') {
        return _getSqlForArrayIsEqualTo($aData, $columnName);
    } elseif ($op == '=~') {
        return _getWhereComponentForArray('IN', $aData, $columnName);
    } else {
        return _getWhereComponentForArray('NOT IN', $aData, $columnName);
    }
}

/**
 * An utility function to get SQL condition for array for the
 * operator '=='. It returns a proper condition iff the array
 * contains a single element. Otherwise it return false since
 * a single value can not equal many different values at the
 * same time.
 *
 * @param array $aData The limitation data in the form of array.
 * @param string $columnName The table column to be used in SQL query.
 * @return mixed SQL condition if possible or false otherwise.
 */
function _getSqlForArrayIsEqualTo($aData, $columnName)
{
    if (count($aData) == 1) {
        return _getWhereComponentForArray('IN', $aData, $columnName);
    } else {
        return false;
    }
}

/**
 * Creates a proper SQL condition for an array value given
 * a SQL operator. Quotes every string if necessary.
 *
 * @param string $sqlOp SQL operator.
 * @param array $aData The limitation data in the form of an array.
 * @param string $columnName The name of table column to use in the condition.
 * @return string SQL condition for the delivery limitation.
 */
function _getWhereComponentForArray($sqlOp, $aData, $columnName)
{
    $aData = MAX_limitationsGetAQuotedStrings($aData);
    $sData = MAX_limitationsGetSFromA($aData);
    return _getWhereComponent($sqlOp, $sData, $columnName);
}

/**
 * Returns 'LOWER($columnName) $sqlOp ($sData)'.
 *
 * @param string $sqlOp
 * @param string $sData
 * @param string $columnName
 * @return string
 */
function _getWhereComponent($sqlOp, $sData, $columnName)
{
    return "LOWER($columnName) $sqlOp ($sData)";
}

/**
 * An utility function which prepares a SQL condition for the string-based
 * limitation. It is used by delivery limitation plugins to create their
 * SQL limitation condition. The returned condition is fully quoted and
 * prepared to be used as a part of SQL statement.
 *
 * @param string $op The operator to be used.
 * @param string $sData The limitation data.
 * @param unknown_type $columnName The table column name to be used.
 * @return mixed The SQL condition for the limitation or boolean
 * if the limitation always yields the same kind of result (true or false).
 */
function MAX_limitationsGetSqlForString($op, $sData, $columnName)
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (empty($sData)) {
        return !MAX_limitationsIsOperatorPositive($op);
    }
    if ($op == '==') {
        return _getWhereComponent('=', "'$sData'", $columnName);
    } elseif ($op == '!=') {
        return _getWhereComponent('!=', "'$sData'", $columnName);
    } elseif ($op == '=~') {
        return _getWhereComponent('LIKE', "'%$sData%'", $columnName);
    } elseif ($op == '!~') {
        return _getWhereComponent('NOT LIKE', "'%$sData%'", $columnName);
    } elseif ($op == '=x') {
        $operator = '~';
        if (strcasecmp($aConf['database']['type'], 'mysql') === 0) {
            $operator = 'REGEXP';
        }
        return _getWhereComponent($operator, "'$sData'", $columnName);
    } else {
        $operator = '!~';
        if (strcasecmp($aConf['database']['type'], 'mysql') === 0) {
            $operator = 'NOT REGEXP';
        }
        return _getWhereComponent($operator, "'$sData'", $columnName);
    }
}

/**
 * Checks if the string limitations overlaps according to the selected
 * operators.
 *
 * @param string $op1
 * @param string $sData1
 * @param string $op2
 * @param string $sData2
 * @return boolean
 * @see Plugins_DeliveryLimitations#overlap
 *
 * @TODO Implementation was postponed for the following pairs of
 * operators because of its complexity:
 * <ul>
 *   <li>!=, !x False if !x specifies exactly the space !x does not specify</li>
 *   <li>=~, =x True iff =~ matches a part of =x</li>
 *   <li>=~, !x Negation of the above</li>
 *   <li>!~, =x Similar to above</li>
 *   <li>!~, !x Similar to above</li>
 *   <li>=x, =x Normalize regexp and see if they are equal</li>
 *   <li>=x, !x As above</li>
 *   <li>!x, !x As above</li>
 * </ul>
 */
function MAX_limitationsGetOverlapForStrings($op1, $sData1, $op2, $sData2)
{
    if ($op1 == '==' && $op2 == '==') {
        return $sData1 == $sData2;
    } elseif (($op1 == '==' && $op2 == '!=') || ($op1 == '!=' && $op2 == '==')) {
        return $sData1 != $sData2;
    } elseif ($op1 == '==' && $op2 == '=~') {
        return MAX_stringContains($sData1, $sData2);
    } elseif ($op1 == '=~' && $op2 == '==') {
        return MAX_stringContains($sData2, $sData1);
    } elseif ($op1 == '==' && $op2 == '=x') {
        return preg_match(_getSRegexpDelimited($sData2), $sData1);
    } elseif ($op1 == '=x' && $op2 == '==') {
        return preg_match(_getSRegexpDelimited($sData1), $sData2);
    } elseif ($op1 == '==' && $op2 == '!x') {
        return !preg_match(_getSRegexpDelimited($sData2), $sData1);
    } elseif ($op1 == '!x' && $op2 == '==') {
        return !preg_match(_getSRegexpDelimited($sData1), $sData2);
    } elseif ($op1 == '!=' && $op2 == '=x') {
        return "^$sData1$" != $sData2;
    } elseif ($op1 == '=x' && $op2 == '!=') {
        return $sData1 != "^$sData2$";
    } elseif ($op1 == '=~' && $op2 == '=~') {
        return MAX_stringContains($sData1, $sData2) || MAX_stringContains($sData2, $sData1);
    } elseif ($op1 == '=~' && $op2 == '!~') {
        return !MAX_stringContains($sData1, $sData2);
    } elseif ($op1 == '!~' && $op2 == '=~') {
        return !MAX_stringContains($sData2, $sData1);
    }
    return true;
}


/**
 * Returns true if $aArray1 and $aArray2 have at least one common value,
 * false otherwise.
 *
 * @param array $aArray1
 * @param array $aArray2
 * @return boolean
 */
function MAX_limitationsDoArraysOverlap($aArray1, $aArray2)
{
    return count(array_intersect($aArray1, $aArray2)) != 0;
}

/*
 ***** STRING UTILITY FUNCTIONS *****
*/


/**
 * Returns true if $sString contains $sToken, false otherwise.
 *
 * @param string $sString String to be checked.
 * @param unknown_type $sToken String to be contained.
 * @return boolean true if $sString contains $sToken, false otherwise.
 */
function MAX_stringContains($sString, $sToken)
{
    return strpos($sString, $sToken) !== false;
}


/**
 * Returns an array created by exploding string via ','
 * or empty array if the string is empty.
 *
 * @param string $sString String to be exploded.
 * @return array An array exploded from the string.
 */
function MAX_limitationsGetAFromS($sString)
{
    return strlen($sString) ? explode(',', $sString) : array();
}


/**
 * Returns a string created by imploding string via ','
 * or empty string if the array is empty.
 *
 * @param array $aArray An array to implode.
 * @return string A string imploded from the array.
 */
function MAX_limitationsGetSFromA($aArray)
{
    return is_array($aArray) ? implode(',', $aArray) : '';
}

/*
 ***** SQL UTILITY FUNCTIONS *****
*/

/**
 * Returns a string preprocessed to be used properly in the
 * database comparisons: trimmed, lowercased and quoted if
 * the magic_quotes_environment is not turned on.
 *
 * @param string $sString
 * @return string Preprocessed string value.
 */
function MAX_limitationsGetPreprocessedString($sString)
{
    return MAX_limitationsGetQuotedString(strtolower(trim($sString)));
}

/**
 * Returns a quoted string to be used in database queries
 * if the magic quotes runtime is not enabled. Otherwise
 * returns string as it is.
 *
 * @param string $sString
 * @return string
 */
function MAX_limitationsGetQuotedString($sString)
{
    if (!get_magic_quotes_runtime()) {
        return addslashes($sString);
    }
    return $sString;
}

/**
 * Returns a copy of the $aArray with a quote at the beginning and end of
 * every item in the array.
 *
 * @param array $aArray Array which contains strings
 * @return array The copy of the array with all the items quoted.
 */
function MAX_limitationsGetAQuotedStrings($aArray)
{
    $aResult = array();
    foreach ($aArray AS $key => $value) {
        $aResult[$key] = "'$value'";
    }
    return $aResult;
}


/**
 * Returns an array of preprocessed strings. Each string
 * is preprocessed with {@link MAX_limitationsGetPreprocessedString}
 * function.
 *
 * @param array $aArray Array of strings.
 * @return array Array of preprocessed string.
 */
function MAX_limitationsGetPreprocessedArray($aArray) {
    $aItems = array();
    foreach ($aArray as $key => $sItem) {
        $aItems[$key] = MAX_limitationsGetPreprocessedString($sItem);
    }
    return $aItems;
}

/* *****
   COUNTRY DELIVERY LIMITATION PLUGIN functions
   *****/

/**
 * Returns an element of the array which represents country.
 * Used by a few of Geo delivery limitation plugins.
 *
 * @param array $aData An array with Geo data.
 * @return string The country.
 */
function MAX_limitationsGetCountry($aData)
{
    return $aData[0];
}

/**
 * Sets a value of the element of the array which represents
 * the country in the array data in some Geo delivery limitation plugins.
 *
 * @param array $aData The array in which the country should be set.
 * @param string $sCountry The value to which country should be set.
 */
function MAX_limitationsSetCountry(&$aData, $sCountry)
{
    $aData[0] = $sCountry;
}

/* *****
   UPGRADE/DOWNGRADE functions
   ***** */

/**
 * Returns an array with upgraded format of operator and data
 * for string-based delivery limitations.
 * The new operator is stored in ['op'] field,
 * the data in ['data'] field.
 *
 * @param string $op An old operator.
 * @param string $sData An old data specification.
 * @return array An array which contains a new operator in the ['op'] field
 * and the new data in ['data'] field.
 */
function MAX_limitationsGetAUpgradeForString($op, $sData)
{
    $sData = preg_replace('#[\\*]+#', '*', $sData);
    $aResult = array();
    if ($sData == '*'
        || preg_match('#^\\*[^\\*]+$#', $sData)
        || preg_match('#^[^\\*]+\\*$#', $sData)
        || preg_match('#[^\\*]+\\*[^\\**]+#', $sData)
        ) {
        $sData = str_replace('(', '\\(', $sData);
        $sData = str_replace(')', '\\)', $sData);
        $sData = str_replace('.', '\\.', $sData);
        $sData = str_replace('*', '.*', $sData);
        $sData = "^$sData$";
        $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=x' : '!x';
        $aResult['data'] = $sData;
        return $aResult;
    } elseif (preg_match('#^\\*[^\\*]*\\*$#', $sData)) {
        $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=~' : '!~';
        $aResult['data'] = str_replace('*', '', $sData);
        return $aResult;
    } else {
        $aResult['op'] = $op;
        $aResult['data'] = $sData;
        return $aResult;
    }
}


/**
 * Returns an array with upgraded format of operator and data
 * for array-based delivery limitations.
 * The new operator is stored in ['op'] field,
 * the data in ['data'] field.
 *
 * @param string $op An old operator.
 * @param string $sData An old data specification.
 * @return array An array which contains a new operator in the ['op'] field
 * and the new data in ['data'] field.
 */
function MAX_limitationsGetAUpgradeForArray($op, $sData)
{
    $aResult = array('data' => $sData);
    if (MAX_limitationsIsOperatorPositive($op)) {
        $aResult['op'] = '=~';
    } else {
        $aResult['op'] = '!~';
    }
    return $aResult;
}


/**
 * Returns an array with upgraded format of operator and data
 * for {@link Plugins_DeliveryLimitations_Client_Language}.
 * The new operator is stored in ['op'] field,
 * the data in ['data'] field.
 *
 * @param string $op An old operator.
 * @param string $sData An old data specification.
 * @return array An array which contains a new operator in the ['op'] field
 * and the new data in ['data'] field.
 */
function MAX_limitationsGetAUpgradeForLanguage($op, $sData)
{
    $sData = substr($sData, 1, strlen($sData) - 2);
    $sData = str_replace(')|(', ',', $sData);
    return MAX_limitationsGetAUpgradeForArray($op, $sData);
}

function MAX_limitationsGetAUpgradeForVariable($op, $sData)
{
    $idxBreak = strpos($sData, ',');
    $varName = substr($sData, 0, $idxBreak);
    $varValue = substr($sData, $idxBreak + 1);
    $aResult = MAX_limitationsGetAUpgradeForString($op, $varValue);
    $aResult['data'] = $varName . ',' . $aResult['data'];
    return $aResult;
}

/**
 * This function should be used for the following delivery limitations:
 *   * browser,
 *   * operating system,
 *   * useragent.
 *
 * @param string $op
 * @param string $sData
 */
function OA_limitationsGetAUpgradeFor20Regexp($op, $sData)
{
    $aResult = array();
    $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=x' : '!x';
    $aResult['data'] = $sData;
    return $aResult;
}


/**
 * This function should be used for the 'referer' delivery limitation and other "==" to "=~" based limitations
 *
 * @param string $op
 * @param string $sData
 * @return array
 */
function OA_limitationsGetUpgradeForContains($op, $sData)
{
    $aResult = array();
    $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=~' : '!~';
    $aResult['data'] = $sData;
    return $aResult;
}

/**
 * This function should be used for the 'city' delivery limitation
 *
 * @param string $op
 * @param string $sData
 * @return array
 */
function OA_limitationsGetUpgradeForGeoCity($op, $sData)
{
    $aResult = array();
    $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=~' : '!~';
    $aResult['data'] = '|'.$sData;
    return $aResult;
}

/**
 * This function should be used for the 'region' delivery limitation
 *
 * @param string $op
 * @param string $sData
 * @return array
 */
function OA_limitationsGetUpgradeForGeoRegion($op, $sData)
{
    $aData = array();
    foreach (explode(',', $sData) as $v) {
        $country = substr($v, 0, 2);
        $region  = substr($v, 2);
        if (!isset($aData[$country])) {
            $aData[$country] = array();
            $aCount[$country] = 0;
        }
        $aData[$country][] = $region;
    }

    ksort($aData);

    $country = key($aData);
    $sData = $country.'|'.join(',', $aData[$country]);
    unset($aData[$country]);

    $aResult = array();
    $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=~' : '!~';
    $aResult['data'] = $sData;

    if (count($aData)) {
        $aResult['add'] = array();
        foreach ($aData as $country => $aRegions) {
            $aResult['add'][] = array(
                'type'       => 'Geo:Region',
                'logical'    => MAX_limitationsIsOperatorPositive($op) ? 'or' : 'and',
                'comparison' => MAX_limitationsIsOperatorPositive($op) ? '=~' : '!~',
                'data'       => $country.'|'.join(',', $aRegions)
            );
        }
    }

    return $aResult;
}

/**
 * This function should be used for the 'netspeed' delivery limitation
 *
 * @param string $op
 * @param string $sData
 * @return array
 */
function OA_limitationsGetUpgradeForGeoNetspeed($op, $sData)
{
    $aTrans = array('unknown','dialup','cabledsl', 'corporate');
    $aData = explode(',', $sData);
    foreach ($aData as $k => $v) {
        $aData[$k] = $aTrans[$v];
    }
    $sData = join(',', $aData);

    $aResult = array();
    $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '=~' : '!~';
    $aResult['data'] = $sData;
    return $aResult;
}


/**
 * Returns an array with downgraded format of operator and data
 * for string-based delivery limitations.
 * The old operator is stored in ['op'] field,
 * the data in ['data'] field.
 *
 * @param string $op A new operator.
 * @param string $sData A new data specification.
 * @return array An array which contains an old operator in the ['op'] field
 * and an old data in ['data'] field.
 */
function MAX_limitationsGetADowngradeForString($op, $sData)
{
    $aResult['op'] = MAX_limitationsIsOperatorPositive($op) ? '==' : '!=';
    if (MAX_limitationsIsOperatorRegexp($op)) {
        if (substr($sData, 0, 1) == '^') {
            $sData = substr($sData, 1);
        }
        if (substr($sData, strlen($sData) - 1) == '$') {
            $sData = substr($sData, 0, strlen($sData) - 1);
        }
        $sData = str_replace('.*', '*', $sData);
        $sData = str_replace('\\(', '(', $sData);
        $sData = str_replace('\\)', ')', $sData);
        $sData = str_replace('\\.', '.', $sData);
        $aResult['data'] = $sData;
    } elseif (MAX_limitationsIsOperatorContains($op)) {
        $aResult['data'] = "*$sData*";
    } else {
        $aResult['data'] = $sData;
    }
    return $aResult;
}


/**
 * Returns an array with downgraded format of operator and data
 * for array-based delivery limitations.
 * The old operator is stored in ['op'] field,
 * the data in ['data'] field.
 *
 * @param string $op A new operator.
 * @param string $sData A new data specification.
 * @return array An array which contains an old operator in the ['op'] field
 * and an old data in ['data'] field.
 */
function MAX_limitationsGetADowngradeForArray($op, $sData)
{
    $aResult = array('data' => $sData);
    if (MAX_limitationsIsOperatorPositive($op)) {
        $aResult['op'] = '==';
    } else {
        $aResult['op'] = '!=';
    }
    return $aResult;
}

/**
 * Returns an array with downgraded format of operator and data
 * for {@link Plugins_DeliveryLimitations_Client_Language}.
 * The old operator is stored in ['op'] field,
 * the data in ['data'] field.
 *
 * @param string $op A new operator.
 * @param string $sData A new data specification.
 * @return array An array which contains an old operator in the ['op'] field
 * and an old data in ['data'] field.
 */
function MAX_limitationsGetADowngradeForLanguage($op, $sData)
{
    $sData = '(' . str_replace(',', ')|(', $sData) . ')';
    return MAX_limitationsGetADowngradeForArray($op, $sData);
}


function MAX_limitationsGetADowngradeForVariable($op, $sData)
{
    $idxBreak = strpos($sData, ',');
    $varName = substr($sData, 0, $idxBreak);
    $varValue = substr($sData, $idxBreak + 1);
    $aResult = MAX_limitationsGetADowngradeForString($op, $varValue);
    $aResult['data'] = $varName . ',' . $aResult['data'];
    return $aResult;
}


/**
 * Returns the string delimited with '#' character.
 * All '#' characters within a string are escaped
 * with a '\'. Thus, the resulting string can be used
 * as a pattern in preg functions, like preg_match.
 *
 * @param string $sRawRegexp Non-delimited regular expression.
 * @return string Regular expression delimited with '#'.
 */
function _getSRegexpDelimited($sRawRegexp)
{
    return '#' . str_replace('#', '\\#', $sRawRegexp) . '#';
}

/* *****
   IP functions
   ***** */


/**
 * Returns a string representing IP with the last number replaced by the star
 * '*' character.
 *
 * @param string $ip The IP address specified in the 'dot' format.
 * @return string The IP address with last part replaced by '*'.
 */
function MAX_ipWithLastComponentReplacedByStar($ip)
{
    return substr($ip, 0, strrpos($ip, '.') + 1) . '*';
}


/**
 * Returns true if the string contains the start '*' character,
 * false otherwise.
 *
 * @param string $ip A string to check.
 * @return true if the string contains the start '*' character,
 * false otherwise.
 */
function MAX_ipContainsStar($ip)
{
    return MAX_stringContains($ip, '*');
}


?>
