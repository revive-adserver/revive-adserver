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

require_once 'HTML/QuickForm/Rule.php';

/**
 * Unique elements validation
 */
class OA_Admin_UI_Rule_Unique extends HTML_QuickForm_Rule
{
    /**
     * Checks if an element value is unique
     *
     * @param     string    $value      Value to check
     * @param     array     $otherValues List of values to check against
     * @access    public
     * @return    boolean   true if value is not in the list of otherValues
     */
    public function validate($value, $options = null)
    {
        return !in_array($value, $options ?? []);
    }


    public function getValidationScript($options = null)
    {
        //return array('', "{jsVar} == ''");
        return ['', ""]; //return nothing, we use JQuery validate anyway
    }
}
