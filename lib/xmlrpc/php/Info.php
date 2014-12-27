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
 *
 * The Info class is the base class for all info classes.
 */


class OA_Info
{

    function getFieldsTypes()
    {
        die('Please define this method in each derivative class');
    }

    function getFieldType($fieldName)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        if (!isset($aFieldsTypes) || !is_array($aFieldsTypes)) {
            die('Please provide field types array for Info object creation');
        }

        if (!array_key_exists($fieldName, $aFieldsTypes)) {
            die('Unknown type for field \'' . $fieldName .'\'');
        }
        return $aFieldsTypes[$fieldName];
    }

    function readDataFromArray($aEntityData)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        foreach($aFieldsTypes as $fieldName => $fieldType) {
            if (array_key_exists($fieldName, $aEntityData)) {
                if ($fieldType == 'date') {
                    $this->$fieldName = new Date($aEntityData[$fieldName]);
                } else {
                    $this->$fieldName = $aEntityData[$fieldName];
                }
            }
        }
    }

    function toArray()
    {
        return (array)$this;
    }
}

?>