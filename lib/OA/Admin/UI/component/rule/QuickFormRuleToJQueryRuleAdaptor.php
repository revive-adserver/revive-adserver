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
 * A wrapper rule for HTML_QuickForm email rule. Accepts quickform rule data in the
 * for of array:
 *   array(
 *           'type'        => $type,
 *           'format'      => $format,
 *           'message'     => $message,
 *           'validation'  => $validation,
 *           'reset'       => $reset,
 *           'dependent'   => $dependent
 *       );
 *
 */
interface OA_Admin_UI_Rule_QuickFormToJQueryRuleAdaptor
{
    /**
     * Returns JS method code that should be installed as a validation method
     * to JQuery validation plugin under the Quickfor rule name
     *
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationMethodCode();
    
    
    /**
     * Returns Jquery validation plugin compliant rule definition for a given quickform rule
     *
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationRule($rule);

    /**
     * Returns Jquery validation plugin compliant message definition for a given quickform rule
     *
     * @param array $rule
     * @return string
     */
    public function getJQueryValidationMessage($rule);
}
