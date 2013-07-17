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

require_once MAX_PATH.'/lib/OA/Admin/UI/component/rule/BaseQuickFormRuleToJQueryRuleAdaptor.php';


/**
 * Wrapper rule for "decimalplaces" rule.
 */
class OA_Admin_UI_Rule_QuickFormDecimalPlacesAdaptor
    extends OA_Admin_UI_Rule_BaseQuickFormRuleToJQueryRuleAdaptor   
{
    /**
     * Returns a custom JS function which adds unique method to jquery
     */
    public function getJQueryValidationMethodCode()
    {
        return "function(value, element, regex) {
            var oRegex = new RegExp(regex);
            return this.optional(element) || value.match(oRegex);
        }";
    }
    //this.optional(element) ||
    
    /**
     * Returns custom Jquery validation "regex" rule 
     * "regex": /regex/
     * @param array $rule
     * @return JS string with unique rule definition 
     */
    public function getJQueryValidationRule($rule)
    {
        $regex = '^\\\d+(\\\.\\\d{1,'.$rule['format'].'})?$'; //in JS when regexp is created via string all \ must be escaped
        return '"'.$rule['type'].'": "'.$regex.'"';
    }
}

?>
