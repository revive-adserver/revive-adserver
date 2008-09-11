<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
