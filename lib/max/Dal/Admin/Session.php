<?php
/**
 * @since Openads v2.3.30-alpah - 16-Nov-2006
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
            $timeLastUsed = strtotime($doSession->lastused);
            if (time() - $timeLastUsed < 3600) {
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $session_table_name = $conf['table']['prefix'] . $conf['table']['session'];
        $query = "
                    UPDATE
                        $session_table_name
                    SET
                        lastused = NOW()
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $session_table_name = $conf['table']['prefix'] . $conf['table']['session'];
        $query = "
                DELETE FROM $session_table_name
                WHERE
                    UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(lastused) > 43200
                ";
        $this->oDbh->query($query);
    }

    /**
     * Remove a specific session from storage.
     */
    function deleteSession($session_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $session_table_name = $conf['table']['prefix'] . $conf['table']['session'];
        $query="
           DELETE FROM $session_table_name
           WHERE sessionid=?
           ";
        $query_params = array($session_id);
        $this->oDbh->extended->execParam($query, $query_params);
    }

}
?>
