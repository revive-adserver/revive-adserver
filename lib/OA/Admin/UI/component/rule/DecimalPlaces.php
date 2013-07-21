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
 * Decimal validation with added support for a specific number of decimal places
 */
class OA_Admin_UI_Rule_DecimalPlaces
    extends HTML_QuickForm_Rule
{
    /**
     * Checks if an element is a valid decimal with a given number of decimal places.
     * If strict mode is set, value must be exactly the given number of decimal places.
     *
     * @param     string  $value Value to check
     * @param     int     $decimalPlaces maximum number of decimal places allowed
     * @access    public
     * @return    boolean   true if value is a proper decimal number with proper number of decimal places
     */
    function validate($value, $decimalPlaces = 0)
    {
        $regex = '/^\d+(\.\d{1,'.$decimalPlaces.'})?$/';        
        return preg_match($regex . 'D', $value) == 0 ? false : true;
    } 


    function getValidationScript($options = null)
    {
        return array('', ""); //return nothing, we use JQuery validate anyway
    } 

} 
?>
