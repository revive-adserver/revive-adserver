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
 * Wrapper rule for HTML_QuickForm "nonzero" rule.
 */
class OA_Admin_UI_Rule_JQueryNonZeroRule extends OA_Admin_UI_Rule_BaseQuickFormRuleToJQueryRuleAdaptor
{
    /**
     * Returns Jquery validation plugin min value rule set to
     * "min": 1
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationRule($rule)
    {
        return "\"min\": 1";
    }
    
    
    public function getJQueryValidationMessage($rule)
    {
        return "\"min\": \"" . $rule['message'] . "\"";
    }
}
