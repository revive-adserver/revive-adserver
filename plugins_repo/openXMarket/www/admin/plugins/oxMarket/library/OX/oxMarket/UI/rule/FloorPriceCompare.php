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
 * Quickform floor_price validation rule
 *
 * @package    openXMarket
 * @author     Bernard Lange  <bernard.lange@openx.org>
 */
class OX_oxMarket_UI_rule_FloorPriceCompare
    extends HTML_QuickForm_Rule
{
    /**
     * A hack class to register JS validation for floor price (e)CPM comparisons
     * 
     * @param     string  $value Value to check
     * @return    boolean   always true 
     */
    function validate($value)
    {
        return true;
    } 


    function getValidationScript($options = null)
    {
        return array('', ""); //return nothing, we use JQuery validate anyway
    } 
    
}
