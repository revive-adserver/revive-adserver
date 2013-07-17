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
 * A rule to check a maximum value of a number represented by validated string 
 */
class OA_Admin_UI_Rule_Max
    extends HTML_QuickForm_Rule
{
    /**
     * Checks if an element is a number with value equal or smaller than a given maximum value.
     *
     * @param     string  $value Value to check
     * @param     float   $max maximum value
     * @access    public
     * @return    boolean true if value is equal or smaller than max
     */
    function validate($value, $max)
    {
        $numVal = (float)$value;         
        return $numVal <= $max;
    } 


    function getValidationScript($options = null)
    {
        return array('', ""); //return nothing, we use JQuery validate anyway
    } 

} 
?>
