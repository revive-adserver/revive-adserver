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
    public $table = 'session';

    /**
     * @param string $session_id
     * @return string A serialized array (probably)
     *
     * @todo Consider raise an error when no session is found.
     */
    public function getSerializedSession($session_id)
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
    public function refreshSession($session_id)
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
     */
    public function storeSerializedSession($serialized_session_data, $session_id, $user_id = null)
    {
        $doSession = OA_Dal::staticGetDO('session', $session_id);
        if ($doSession) {
            $doSession->sessiondata = $serialized_session_data;

            // We could be upgrading from a version that doesn't have the user_id field
            if (!defined('phpAds_installing')) {
                $doSession->user_id = $user_id;
            }

            $doSession->update();
        } else {
            $doSession = OA_Dal::factoryDO('session');
            // It's an md5, so 32 chars max
            $doSession->sessionid = substr($session_id, 0, 32);
            $doSession->sessiondata = $serialized_session_data;

            // We could be upgrading from a version that doesn't have the user_id field
            if (!defined('phpAds_installing')) {
                $doSession->user_id = $user_id;
            }

            $doSession->insert();
        }
    }

    /**
     * Remove many unused sessions from storage.
     */
    public function pruneOldSessions()
    {
        $qTbl = $this->oDbh->quoteIdentifier($this->getTablePrefix() . 'session', true);

        $dateTime = new \DateTime('now -12hours', new \DateTimeZone('UTC'));
        $qDateTime = $this->oDbh->quote($dateTime->format('Y-m-d H:i:s'));

        $this->oDbh->exec("DELETE FROM {$qTbl} WHERE lastused < {$qDateTime}");
    }

    /**
     * Remove a specific session from storage.
     */
    public function deleteSession($session_id)
    {
        $doSession = OA_Dal::staticGetDO('session', $session_id);
        if ($doSession) {
            $doSession->delete();
        }
    }

    /**
     * Remove all the sessions for a user.
     */
    public function deleteUserSessions($userId)
    {
        $userId = (int)$userId;

        $qTbl = $this->oDbh->quoteIdentifier($this->getTablePrefix() . 'session', true);

        $this->oDbh->exec("DELETE FROM {$qTbl} WHERE user_id = {$userId}");
    }
}
