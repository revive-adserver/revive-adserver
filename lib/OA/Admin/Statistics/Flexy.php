<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * @package    OpenadsAdmin
 * @subpackage Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Flexy
{

    /**
     * A method to display the day span selector element.
     *
     * Flexy template helper - to be called from templates.
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
        <img src='images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' tabindex='".$this->tabindex++."' /></a>
        </form>";
    }

}

?>