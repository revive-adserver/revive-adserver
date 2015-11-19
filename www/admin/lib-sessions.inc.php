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
/* Sets an admin cookie                                  */
/*-------------------------------------------------------*/

function phpAds_SessionSetAdminCookie($name, $value)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    return setcookie(
        $name,
        $value,
        0,
        dirname($_SERVER["SCRIPT_NAME"]),
        empty($_SERVER['HTTP_HOST']) ? null : preg_replace('#:\d+$#', '', $_SERVER['HTTP_HOST']),
        !empty($conf['openads']['requireSSL']),
        true
    );
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

        phpAds_SessionSetAdminCookie('sessionID', $_COOKIE['sessionID']);
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
    global $session;

    $dal = new MAX_Dal_Admin_Session();

    if (isset($_COOKIE['sessionID']) && $_COOKIE['sessionID'] != '') {
        $session_id = $_COOKIE['sessionID'];
        $serialized_session_data = serialize($session);
        $dal->storeSerializedSession($serialized_session_data, $session_id);
    }

    // Garbage collect old sessions, 1 out of 100 requests, roughly
    if (mt_rand(1, 100) == 42) {
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

    phpAds_SessionSetAdminCookie('sessionID', '');

	unset($session);
	unset($_COOKIE['sessionID']);
}

function phpAds_SessionGetToken()
{
    if (OA_INSTALLATION_STATUS != OA_INSTALLATION_STATUS_INSTALLED) {
        return false;
    }
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
    static $result;

    if (!isset($result)) {
        $result = ($token === phpAds_SessionGetToken());
        phpAds_SessionDataRegister('token', null);
    }
    return $result;
}

?>
