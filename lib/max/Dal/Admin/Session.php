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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

/**
 * A data access layer for storing and retrieving persistent Web sessions.
 *
 * @todo Factor out the repetitive "session_table_name" calculation
 */
class MAX_Dal_Admin_Session extends MAX_Dal_Common
{
    var $table = 'session';

	/**
     * @param string $session_id
     * @return string A serialized array (probably)
     *
     * @todo Consider raise an error when no session is found.
     */
    function getSerializedSession($session_id)
    {
        $doSession = OA_Dal::staticGetDO('session', $session_id);
        if ($doSession) {
            // Deal with MySQL 4.0 timestamp format (YYYYMMDDHHIISS)
            if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)$/', $doSession->lastused, $m)) {
                $doSession->lastused = "{$m[1]}-{$m[2]}-{$m[3]} {$m[4]}:{$m[5]}:{$m[6]}";
            }
            // Deal with PgSQL timestamp with timezone
            if (preg_match('/^(\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d)./', $doSession->lastused, $m)) {
                $doSession->lastused = $m[1];
            }
            $timeNow = strtotime(OA::getNowUTC());
            $timeLastUsed = strtotime($doSession->lastused);
            if ($timeNow - $timeLastUsed < 3600) {
                return $doSession->sessiondata;
            }
        }
        return false;
    }

    /**
     * Reset "last used" timestamp on a session to prevent it from timing out.
     *
     * @param string $session_id
     * @return void
     */
    function refreshSession($session_id)
    {
        $doSession = OA_Dal::staticGetDO('session', $session_id);
        if ($doSession) {
            $doSession->lastused = OA::getNowUTC();
            $doSession->update();
        }
    }

    /**
     * @param string $serialized_session_data
     * @param string $session_id
     *
     * @todo Use ANSI SQL syntax, such as an UPDATE/INSERT cycle.
     * @todo Push down REPLACE INTO into a MySQL-specific DAL.
     */
    function storeSerializedSession($serialized_session_data, $session_id)
    {
        $doSession = OA_Dal::staticGetDO('session', $session_id);
        if ($doSession) {
            $doSession->sessiondata = $serialized_session_data;
            $doSession->update();
        } else {
            $doSession = OA_Dal::factoryDO('session');
            // It's an md5, so 32 chars max
            $doSession->sessionid = substr($session_id, 0, 32);
            $doSession->sessiondata = $serialized_session_data;
            $doSession->insert();
        }
    }

    /**
     * Remove many unused sessions from storage.
     *
     * @todo Use ANSI SQL syntax, such as NOW() + INTERVAL '12' HOUR
     */
    function pruneOldSessions()
    {
        $tableS = $this->oDbh->quoteIdentifier( $this->getTablePrefix().'session',true);
        $query = "
                DELETE FROM {$tableS}
                WHERE
                    UNIX_TIMESTAMP('". OA::getNowUTC() ."') - UNIX_TIMESTAMP(lastused) > 43200
                ";
        $this->oDbh->query($query);
    }

    /**
     * Remove a specific session from storage.
     */
    function deleteSession($session_id)
    {
        $doSession = OA_Dal::staticGetDO('session', $session_id);
        if ($doSession) {
            $doSession->delete();
        }
    }

}
?>
