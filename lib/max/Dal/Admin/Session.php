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
        $tableS = $this->oDbh->quoteIdentifier( $this->getTablePrefix().'session',true);

        $query = "
                    UPDATE
                        {$tableS}
                    SET
                        lastused = '". OA::getNowUTC() ."'
                    WHERE
                        sessionid = ?
                    ";
        $query_params = array($session_id);
        $result = $this->oDbh->extended->execParam($query, $query_params);
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
        }
        else {
            $doSession = OA_Dal::factoryDO('session');
            $doSession->sessionid = $session_id;
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
        $tableS = $this->oDbh->quoteIdentifier( $this->getTablePrefix().'session',true);
        $query="
           DELETE FROM {$tableS}
           WHERE sessionid=?
           ";
        $query_params = array($session_id);
        $this->oDbh->extended->execParam($query, $query_params);
    }

}
?>
