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

require_once MAX_PATH . '/www/admin/lib-gui.inc.php';

/**
 * A class of helper methods that can be called from the statistics
 * classes when generating "history" style statistics that need to
 * be displayed in a "daily breakdown" format.
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Daily
{

    /**
     * A method to parse the day paramer, check it's validity, and store it
     * in the provided $aDates array.
     *
     * @param array $aDates A references to an array that will be set to
     *                      contain the valid day as the "day_begin" and
     *                      "day_end" values.
     */
    function parseDay(&$aDates)
    {
        $day = MAX_getValue('day', '');
        if (!preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/D', $day, $matches)) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
        if (!checkdate($matches[2], $matches[3], $matches[1])) {
            phpAds_PageHeader('2');
            phpAds_Die ($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
        $aDates = array();
        $aDates['day_begin'] = "{$matches[1]}-{$matches[2]}-{$matches[3]}";
        $aDates['day_end']   = "{$matches[1]}-{$matches[2]}-{$matches[3]}";
    }

    /**
     * Prepare context using the last settings of the statistics day-span
     * selector, falling back to the parent class function if not applicable
     *
     * @param array $aDates      An array of dates, indexed by "YYYYMMDD" with
     *                           user formatted values, that should be set for
     *                           the context links.
     * @param string $currentDay The currently selected day, in "YYYYMMDD" format.
     * @param OA_Admin_Statistics_Common $oCaller The calling object, with the
     *                                            $pageURI parameter set.
     */
    function showContext($aDates, $currentDay, $oCaller)
    {
        $pageURI = preg_replace('/day=\d{8}(&amp;|&)?/', '', $oCaller->pageURI);
        if (!preg_match('/entity/', $pageURI)) {
            $pageURI .= 'entity=' . $oCaller->entity . '&';
        }
        if (!preg_match('/breakdown/', $pageURI)) {
            $pageURI .= 'breakdown=' . $oCaller->breakdown . '&';
        }
        foreach ($aDates as $day => $date_f) {
            phpAds_PageContext(
                $date_f,
                $pageURI . 'day=' . str_replace('-', '', $day),
                $currentDay == $day
            );
        }
    }

}

?>