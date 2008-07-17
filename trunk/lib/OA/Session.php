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

require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';

/**
 * A generic class for storing and retreiving information from session.
 * lib-session should be refactored and moved here
 *
 * @static
 */
class OA_Session
{
    /**
     * Saves information (message) in session
     *
     * @param string $message
     * @static
     */
    function setMessage($message)
    {
        $aArgs = func_get_args();
        if (count($aArgs) > 1) {
            array_shift($aArgs);
            $message = vsprintf($message, $aArgs);
        }
        global $session;
        $session['message'] = $message;
        phpAds_SessionDataStore();
    }

    /**
     * Retreives information from session
     *
     * @return string
     * @static
     */
    function getMessage()
    {
        global $session;
        $message = isset($session['message']) ? $session['message'] : null;
        unset($session['message']);
        phpAds_SessionDataStore();
        return $message;
    }

}

?>