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
 * @package    OpenXDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 *
 */

require_once MAX_PATH . '/lib/pear/Date.php';


/**
 * Base class for all info classes
 *
 */
class OA_Info
{

    /**
     * This method should be redeclared in the inherited classes.
     *
     */
    function getFieldsTypes()
    {
        die('Please define this method in each derivative class');
    }

    /**
     * This method returns class field type.
     *
     * @param string $fieldName
     * @return string  field type
     */
    function getFieldType($fieldName)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        if (!isset($aFieldsTypes) || !is_array($aFieldsTypes)) {
            MAX::raiseError('Please provide field types array for Info object creation');
        }

        if (!array_key_exists($fieldName, $aFieldsTypes)) {
            MAX::raiseError('Unknown type for field \'' . $fieldName .'\'');
        }
        return $aFieldsTypes[$fieldName];
    }

    /**
     * This method initialises object from array.
     *
     * @param array $aEntityData
     */
    function readDataFromArray($aEntityData)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        foreach($aFieldsTypes as $fieldName => $fieldType) {
            if (array_key_exists($fieldName, $aEntityData)) {
                if ($fieldType == 'date') {
                    // If the date is 'no date' then don't return this element in the response at all.
                    if (empty($aEntityData[$fieldName])) {
                        unset($this->$fieldName);
                    } else {
                        $this->$fieldName = new Date($aEntityData[$fieldName]);
                    }
                } else {
                    $this->$fieldName = $aEntityData[$fieldName];
                }
            }
        }
    }

    function toArray()
    {
        return array_filter(get_object_vars($this), array($this, '_nullFilter'));
    }

    function _nullFilter($var)
    {
        return isset($var);
    }
}
