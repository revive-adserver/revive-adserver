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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * A static class for providing maintenance DAL methods for the UI.
 *
 * @package    OpenX
 */
class OA_Dal_Maintenance_UI
{
    /**
     * A static method to check if an alert needs to be shown to the user
     *
     * @return bool
     */
    public static function alertNeeded()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $iLastRun = (int) OA_Dal_ApplicationVariables::get('maintenance_timestamp');

        if ($iLastRun > 0 && !$aPref['maintenance']['autoMaintenance']) {
            if ($iLastRun < time() - 86400) {
                // Update the timestamp to make sure the warning
                // is shown only once every 24 hours
                OA_Dal_Maintenance_UI::updateLastRun();

                return true;
            }
        }

        return false;
    }

    /**
     * A static method to update the last run
     *
     */
    public static function updateLastRun()
    {
        OA_Dal_ApplicationVariables::set('maintenance_timestamp', time());
    }
}
