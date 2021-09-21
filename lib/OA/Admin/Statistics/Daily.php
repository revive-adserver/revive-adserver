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

require_once MAX_PATH . '/www/admin/lib-gui.inc.php';

/**
 * A class of helper methods that can be called from the statistics
 * classes when generating "history" style statistics that need to
 * be displayed in a "daily breakdown" format.
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
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
    public function parseDay(&$aDates)
    {
        $day = MAX_getValue('day', '');
        if (!preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/D', $day, $matches)) {
            phpAds_PageHeader('2');
            phpAds_Die($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
        if (!checkdate($matches[2], $matches[3], $matches[1])) {
            phpAds_PageHeader('2');
            phpAds_Die($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
        $aDates = [];
        $aDates['day_begin'] = "{$matches[1]}-{$matches[2]}-{$matches[3]}";
        $aDates['day_end'] = "{$matches[1]}-{$matches[2]}-{$matches[3]}";
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
    public function showContext($aDates, $currentDay, $oCaller)
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
