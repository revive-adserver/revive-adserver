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

require_once 'HTML/Template/Flexy.php';
require_once 'HTML/Template/Flexy/Element.php';

/**
 * A class of helper methods that can be called from the statistics
 * Flexy templates to help display the required data.
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
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