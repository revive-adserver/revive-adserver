<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
