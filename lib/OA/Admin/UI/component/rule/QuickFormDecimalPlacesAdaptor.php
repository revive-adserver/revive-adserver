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
require_once MAX_PATH.'/lib/OA/Admin/UI/component/rule/BaseQuickFormRuleToJQueryRuleAdaptor.php';


/**
 * Wrapper rule for "decimalplaces" rule.
 */
class OA_Admin_UI_Rule_QuickFormDecimalPlacesAdaptor
    extends OA_Admin_UI_Rule_BaseQuickFormRuleToJQueryRuleAdaptor   
{
    /**
     * Returns a custom JS function which adds unique method to jquery
     */
    public function getJQueryValidationMethodCode()
    {
        return "function(value, element, regex) {
            var oRegex = new RegExp(regex);
            return this.optional(element) || value.match(oRegex);
        }";
    }
    //this.optional(element) ||
    
    /**
     * Returns custom Jquery validation "regex" rule 
     * "regex": /regex/
     * @param array $rule
     * @return JS string with unique rule definition 
     */
    public function getJQueryValidationRule($rule)
    {
        $regex = '^\\\d+(\\\.\\\d{1,'.$rule['format'].'})?$'; //in JS when regexp is created via string all \ must be escaped
        return '"'.$rule['type'].'": "'.$regex.'"';
    }
}

?>
