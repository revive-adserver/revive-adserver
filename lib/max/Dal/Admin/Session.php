<?php
/**
 * @since Max v0.3.30 - 16-Nov-2006
 */


require_once MAX_PATH . '/lib/max/Dal/Common.php';

/**
 * A data access layer for storing and retrieving persistent Web sessions.
 * 
 * @todo Factor out the repetitive "session_table_name" calculation
 */
class MAX_Dal_Admin_Session extends MAX_Dal_Common
{
    /**
     * @param string $session_id
     * @return string A serialized array (probably)
     * 
     * @todo Consider raise an error when no session is found. 
     */
    function getSerializedSession($session_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $session_table_name = $conf['table']['prefix'] . $conf['table']['session'];
        $query = "
            SELECT
                sessiondata
            FROM
                $session_table_name
            WHERE
                sessionid = ?
                AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastused) < 3600
            ";
        $query_params = array($session_id);
        $serialized_session_data = $this->dbh->getOne($query, $query_params);
        return $serialized_session_data;
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
        $result = $this->dbh->query($query, $query_params);
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $session_table_name = $conf['table']['prefix'] . $conf['table']['session'];
        $query = "
            REPLACE INTO $session_table_name
                (sessionid, sessiondata)
            VALUES
                (?, ?)
            ";
        $query_params = array($session_id, $serialized_session_data);
        $this->dbh->query($query, $query_params);
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
        $this->dbh->query($query);
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
        $this->dbh->query($query, $query_params);
    }

}
?>
