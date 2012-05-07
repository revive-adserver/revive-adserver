<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// Required files
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

if(!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/cookie.php'])) {
    // Required by PHP5.1.2
    require_once MAX_PATH . '/lib/max/Delivery/cookie.php';
}
require_once MAX_PATH . '/lib/max/Dal/Admin/Session.php';

/**
 * Fetch sessiondata from the database
 *
 * This implementation uses the $_COOKIE superglobal to find session identifier.
 * @return void
 *
 * @todo Move to a domain-layer class library.
 */
function phpAds_SessionDataFetch()
{
    global $session;
    $dal = new MAX_Dal_Admin_Session();

    // Guard clause: Can't fetch a session without an ID
	if (empty($_COOKIE['sessionID'])) {
        return;
    }

    $serialized_session = $dal->getSerializedSession($_COOKIE['sessionID']);

    // This is required because 'sessionID' cookie is set to new during logout.
    // According to comments in the file it is because some servers do not
    // support setting cookies during redirect.
    if (empty($serialized_session)) {
        return;
    }

    $loaded_session = unserialize($serialized_session);
	if (!$loaded_session) {
        // XXX: Consider raising an error
        return;
    }
	$session = $loaded_session;
    $dal->refreshSession($_COOKIE['sessionID']);
}

/*-------------------------------------------------------*/
/* Create a new sessionid                                */
/*-------------------------------------------------------*/

function phpAds_SessionStart()
{
	global $session;
	if (empty($_COOKIE['sessionID'])) {
		$session = array();
		$_COOKIE['sessionID'] = md5(uniqid('phpads', 1));
		MAX_cookieAdd('sessionID', $_COOKIE['sessionID']);
		MAX_cookieFlush();
	}
	return $_COOKIE['sessionID'];
}

/*-------------------------------------------------------*/
/* Register the data in the session array                */
/*-------------------------------------------------------*/

function phpAds_SessionDataRegister($key, $value='')
{
    $conf = $GLOBALS['_MAX']['CONF'];
	global $session;
    //if ($conf['openads']['installed'])
    if (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED)
    {
		phpAds_SessionStart();
	}
	if (is_array($key) && $value=='') {
		foreach (array_keys($key) as $name) {
			$session[$name] = $key[$name];
		}
	} else {
		$session[$key] = $value;
	}
    //if ($conf['openads']['installed'])
    if (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED)
    {
	   phpAds_SessionDataStore();
	}
}

/**
 * Store the session array in the database
 */
function phpAds_SessionDataStore()
{
    $dal = new MAX_Dal_Admin_Session();
    $conf = $GLOBALS['_MAX']['CONF'];
    global $session;
    if (isset($_COOKIE['sessionID']) && $_COOKIE['sessionID'] != '') {
        $session_id = $_COOKIE['sessionID'];
        $serialized_session_data = serialize($session);
        $dal->storeSerializedSession($serialized_session_data, $session_id);
    }
    // Randomly purge old sessions
    // XXX: Why is this random?
    // XXX: Shouldn't this be done by a daemon, or at least at logout time?
    srand((double)microtime()*1000000);
    if(rand(1, 100) == 42) {
        $dal->pruneOldSessions();
    }
}


/**
 * Destroy the current session
 *
 * @todo Determine how much of these steps are unnecessary, and remove them.
 */
function phpAds_SessionDataDestroy()
{
    $dal = new MAX_Dal_Admin_Session();

	global $session;
    $dal->deleteSession($_COOKIE['sessionID']);

    MAX_cookieAdd('sessionID', '');
    MAX_cookieFlush();

	unset($session);
	unset($_COOKIE['sessionID']);
}

function phpAds_SessionGetToken()
{
    global $session;
    phpAds_SessionStart();
    if (empty($session['token'])) {
        $session['token'] = md5(uniqid('phpads', 1));
        phpAds_SessionDataStore();
    }
    return $session['token'];
}

function phpAds_SessionValidateToken($token)
{
    $result = ($token === phpAds_SessionGetToken());
    phpAds_SessionDataRegister('token', null);
    return $result;
}

?>
