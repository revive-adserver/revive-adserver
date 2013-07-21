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
 * A rule to check a minimum value of a number represented by validated string 
 */
class OA_Admin_UI_Rule_Min
    extends HTML_QuickForm_Rule
{
    /**
     * Checks if an element is a number with value equal or greater than a given minimum value.
     *
     * @param     string  $value Value to check
     * @param     float   $min minimum value
     * @access    public
     * @return    boolean   true if value is equal or greater than min
     */
    function validate($value, $min)
    {
        $numVal = (float)$value;         
        return $numVal >= $min;
    } 


    function getValidationScript($options = null)
    {
        return array('', ""); //return nothing, we use JQuery validate anyway
    } 

} 
?>
