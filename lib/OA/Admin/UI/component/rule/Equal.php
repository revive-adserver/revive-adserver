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
 * A rule to check if the value from field a equals the value from field b
 */
class OA_Admin_UI_Rule_Equal
    extends HTML_QuickForm_Rule
{
    /**
     * Checks if an element is a number with value equal or greater than a given minimum value.
     *
     * @param     string  $a Value to check against $b
     * @param     float   $b Value to check against $a
     * @access    public
     * @return    boolean   true if a is equal to be
     */
    function validate($a, $b)
    {
        return ($a == $b[1]) ? true : false;
    }


    function getValidationScript($options = null)
    {
        return array('', ""); //return nothing, we use JQuery validate anyway
    }

}
?>
