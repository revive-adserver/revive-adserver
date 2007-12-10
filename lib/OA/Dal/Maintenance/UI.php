<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';

/**
 * A static class for providing maintenance DAL methods for the UI.
 *
 * @package    Openads
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class OA_Dal_Maintenance_UI
{
    /**
     * A static method to check if an alert needs to be shown to the user
     *
     * @return bool
     */
    function alertNeeded()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];

        if ($aPref['maintenance_timestamp'] > 0 && !$aPref['maintenance']['autoMaintenance']) {
            if ($aPref['maintenance_timestamp'] < time() - 86400) {
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
    function updateLastRun()
    {
        $doPreference = OA_Dal::factoryDO('preference');
        $doPreference->whereAdd('1 = 1'); //Global table update.
        $doPreference->maintenance_timestamp = time();
        $doPreference->update(DB_DATAOBJECT_WHEREADD_ONLY);
    }
}

?>