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
 * Wrapper rule for HTML_QuickForm "required" rule.
 */
class OA_Admin_UI_Rule_JQueryRequiredRule
    extends OA_Admin_UI_Rule_BaseQuickFormRuleToJQueryRuleAdaptor   
{
    /**
     * Returns Jquery validation plugin required rule 
     * "required": true
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationRule($rule)
    {
        return "\"required\": true";    
    }
}

?>
