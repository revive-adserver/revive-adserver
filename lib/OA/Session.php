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