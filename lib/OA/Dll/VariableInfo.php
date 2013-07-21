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
 * @author     David Keen <david.keen@openx.org>
 *
 */

require_once MAX_PATH . '/lib/OA/Info.php';
require_once MAX_PATH . '/lib/OA/Dll/TrackerInfo.php';

class OA_Dll_VariableInfo extends OA_Info {
    const VARIABLE_DATATYPE_NUMERIC = 'numeric';
    const VARIABLE_DATATYPE_STRING = 'string';
    const VARIABLE_DATATYPE_DATE = 'date';
    const VARIABLE_PURPOSE_BASKET_VALUE = 'basket_value';
    const VARIABLE_PURPOSE_NUM_ITEMS = 'num_items';
    const VARIABLE_PURPOSE_POST_CODE = 'post_code';

    // Required fields
    public $variableId;
    public $trackerId;
    public $variableName;

    // Optional fields
    public $description;
    public $dataType;
    public $purpose;
    public $rejectIfEmpty;
    public $isUnique;
    public $uniqueWindow;
    public $variableCode;
    public $hidden;
    public $hiddenWebsites;

    /**
     * This method sets default values for optional fields when adding a new variable.
     *
     */
    public function setDefaultForAdd() {
        if (empty($this->description)) {
            $this->description = '';
        }

        if (empty($this->dataType)) {
            $this->dataType = self::VARIABLE_DATATYPE_NUMERIC;
        }

        if (empty($this->purpose)) {
            $this->purpose = null;
        }

        if (empty($this->rejectIfEmpty)) {
            $this->rejectIfEmpty = false;
        }

        if (empty($this->isUnique)) {
            $this->isUnique = false;
        }

        if (empty($this->uniqueWindow)) {
            $this->uniqueWindow = 0;
        }

        if (empty($this->variableCode)) {
            $this->variableCode = '';
        }

        if (empty($this->hidden)) {
            $this->hidden = false;
        }

        if (empty($this->hiddenWebsites)) {
            // leave the array empty.
        }
    }

    public function getFieldsTypes() {
        return array(
        'variableId' => 'integer',
        'trackerId' => 'integer',
        'variableName' => 'string',
        'description' => 'string',
        'dataType' => 'string',
        'purpose' => 'string',
        'rejectIfEmpty' => 'boolean',
        'isUnique' => 'boolean',
        'uniqueWindow' => 'integer',
        'variableCode' => 'string',
        'hidden' => 'boolean',
        'hiddenWebsites' => 'array'
        );
    }

    /**
     * Returns an array suitable for updating a dataobject.
     *
     * @return array array of values to set on a dataobject.
     */
    public function getDataObjectArray() {
        // Transalate any object variables to field names
        // eg, $aVariableData['tableColumnName'] = $aVariableData['objectVarName']
        $aVariableData = (array) $this;
        $aVariableData['variableid'] = $aVariableData['variableId'];
        $aVariableData['trackerid'] = $aVariableData['trackerId'];
        $aVariableData['name'] = $aVariableData['variableName'];
        $aVariableData['datatype'] = $aVariableData['dataType'];

        // Convert from boolean.
        $aVariableData['reject_if_empty'] = $aVariableData['rejectIfEmpty'] ? 1 : 0;
        $aVariableData['is_unique'] = $aVariableData['isUnique'] ? 1 : 0;
        $aVariableData['hidden'] = $aVariableData['hidden'] ? 1 : 0;

        $aVariableData['unique_window'] = $aVariableData['uniqueWindow'];

        $aVariableData['variablecode'] = $aVariableData['variableCode'];

        return $aVariableData;
    }

    /**
     * Sets the VariableInfo object from a dataObject array.
     *
     * @param array $aVariableData array of values to set on VariableInfo object.
     */
    public function setVariableDataFromArray($aVariableData) {
        // Transalate any field names to object variables
        // eg, $aVariableData['objectVarName'] = $aVariableData['tableColumnName']
        $aVariableData['variableId'] = $aVariableData['variableid'];
        $aVariableData['trackerId'] = $aVariableData['trackerid'];
        $aVariableData['variableName'] = $aVariableData['name'];
        $aVariableData['dataType'] = $aVariableData['datatype'];

        // Convert to boolean.
        $aVariableData['rejectIfEmpty'] = $aVariableData['reject_if_empty'] == 1 ? true : false;
        $aVariableData['isUnique'] = $aVariableData['is_unique'] == 1 ? true : false;
        $aVariableData['hidden'] = $aVariableData['hidden'] == 1 ? true : false;

        $aVariableData['uniqueWindow'] = $aVariableData['unique_window'];
        $aVariableData['variableCode'] = $aVariableData['variablecode'];

        $this->readDataFromArray($aVariableData);
    }

}

?>
