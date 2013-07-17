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

require_once MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormRuleToJQueryRuleAdaptor.php';

/**
 * Base HTML_QuickForm to JQuery validation rule adaptor. 
 */
class OA_Admin_UI_Rule_BaseQuickFormRuleToJQueryRuleAdaptor
    implements OA_Admin_UI_Rule_QuickFormToJQueryRuleAdaptor
{
    /**
     * Returns null by default
     *
     * @return unknown
     */
    public function getJQueryValidationMethodCode()
    {
        return null;    
    }
    
    
    /**
     * Returns Jquery validation plugin compliant rule definition for a given quickform rule
     * Query validation plugin accepts format is as follows:
     * <ruleName>:<ruleOptions>
     * 
     * Returned string is constructed as follows:
     * "$rule['type']" : $rule['format'] 
     *
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationRule($rule)
    {
        return "\"".$rule['type']."\"".": ".$rule['format'];        
    }

    
    /**
     * Returns Jquery validation plugin compliant message definition for a given quickform rule
     * 
     *  Query validation plugin accepts format is as follows:
     *  <ruleName>:<ruleMessage>
     *
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationMessage($rule)
    {
        return "\"".$rule['type']."\"".": \"".$rule['message']."\"";
    }    
}
?>
