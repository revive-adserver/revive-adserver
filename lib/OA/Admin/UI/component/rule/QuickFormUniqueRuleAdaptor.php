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

require_once MAX_PATH . '/lib/OA/Admin/UI/component/rule/BaseQuickFormRuleToJQueryRuleAdaptor.php';


/**
 * Wrapper rule for OA_Admin_UI_Rule_Unique"unique" rule.
 */
class OA_Admin_UI_Rule_JQueryUniqueRule extends OA_Admin_UI_Rule_BaseQuickFormRuleToJQueryRuleAdaptor
{
    /**
     * Returns a custom JS function which adds unique method to jquery
     */
    public function getJQueryValidationMethodCode()
    {
        return "function(value, element, otherValuesArr) {
                    return $.inArray(value, otherValuesArr) == -1;
                }";
    }
    
    
    /**
     * Returns custom Jquery validation "unique" rule
     * "unique": ["name1", "name2", "name3"]
     * @param array $rule
     * @return JS string with unique rule definition
     */
    public function getJQueryValidationRule($rule)
    {
        if (empty($rule['format'])) {
            return '"' . $rule['type'] . '": []';
        }
        
        $aSlashedNames = array_map("addslashes", $rule['format']);
        //comma separate, double quote list of items
        $sNamesList = '"' . implode('", "', $aSlashedNames) . '"';
        
        //complete array string
        return '"' . $rule['type'] . '": ' . ' [' . $sNamesList . ']';
    }
}
