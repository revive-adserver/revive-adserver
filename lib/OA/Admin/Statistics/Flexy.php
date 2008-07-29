<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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

require_once 'HTML/Template/Flexy.php';
require_once 'HTML/Template/Flexy/Element.php';

/**
 * A class of helper methods that can be called from the statistics
 * Flexy templates to help display the required data.
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Flexy
{

    /**
     * A Flexy helper method to display the day span selector
     * element.
     */
    function showDaySpanSelector()
    {
        $this->oDaySpanSelector->_tabIndex = $this->tabindex;

        echo "
        <form id='period_form' name='period_form' action='{$this->pageName}'>";

        // Create a temporary array and remove period_preset to prevent
        // parameters duplicating in links
        $aTempPageParams = $this->aPageParams;
        unset($aTempPageParams['period_preset']);
        unset($aTempPageParams['period_start']);
        unset($aTempPageParams['period_end']);

        _displayHiddenValues($aTempPageParams);

        $this->oDaySpanSelector->display();

        $this->tabindex = $this->oDaySpanSelector->_tabIndex;

        echo "
        <a href='#' onclick='return periodFormSubmit()'>
        <img src='" . OX::assetPath() . "/images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' tabindex='".$this->tabindex++."' /></a>
        </form>";
    }

    /**
     * A Flexy helper method to return the value of a field for display.
     *
     * @param array  $aArray An array of items.
     * @param string $k      The index name of the item to display.
     * @return mixed The item to display.
     */
    function showValue($aArray, $k)
    {
        return $aArray[$k];
    }

    /**
     * A Flexy helper method to return a translation for a string.
     *
     * @param string $str The string to translate.
     */
    function tr($str)
    {
        if (preg_match('/^(str|key)/', $str) && isset($GLOBALS[$str])) {
            $str = $GLOBALS[$str];
        }
        return $str;
    }

    /**
     * A Flexy helper method to return a partial URI that can be used in
     * the teplate to construct a link to change the current sorting order.
     *
     * @param string  $fieldname The name of the field.
     * @param boolean $reverse   Should default sorting order be reversed?
     * @return string The partial URI.
     */
    function listOrderHref($fieldname, $reverse = false)
    {
        if ($this->listOrderField == $fieldname) {
            $orderdirection = $this->listOrderDirection == 'up' ? 'down' : 'up';
        } else {
            $orderdirection = $reverse ? 'down' : 'up';
        }
        return "{$this->pageURI}listorder={$fieldname}&orderdirection={$orderdirection}";
    }

    /**
     * A Flexy helper method to return a partial URI that can be used in
     * the teplate to construct a link to change the current sorting order,
     * where the default sorting order IS reversed.
     *
     * @param string $fieldname The name of the field.
     * @return string The partial URI.
     */
    function listOrderHrefRev($fieldname)
    {
        return $this->listOrderHref($fieldname, true);
    }

    /**
     * A Flexy helper method to return the appropriate image to display
     * the current sorting order, if appropriate.
     *
     * @param string $fieldname The name of the field.
     * @return string|false The image URI if the field is sorted, false otherwise.
     */
    function listOrderImage($fieldname)
    {
        if ($this->listOrderField == $fieldname) {
            return OX::assetPath("images/caret-".($this->listOrderDirection == 'up' ? 'u': 'ds').".gif");
        } else {
            return false;
        }
    }

}

?>