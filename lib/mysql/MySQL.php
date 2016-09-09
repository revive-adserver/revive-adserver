<?php
/**
 * This file is to be used if your codebase still
 * uses mysql_* functions in a PHP version that
 * doesn't declare those functions (>PHP 5.5.5)
 *
 * Note: Since this is handled by our object, the DB
 * resource link will be the subscript of the database
 * connection, 0-X, where X is INT. If not passed, assumed
 * subscript last connection.
 *
 * @author    Aziz S. Hussain <azizsaleh@gmail.com>
 * @copyright GPL license 
 * @license   http://www.gnu.org/copyleft/gpl.html 
 * @link      http://www.AzizSaleh.com
 */

/**
 * MySQL
 *
 * This object will replicate MySQL functions
 * http://www.php.net/manual/en/ref.mysql.php
 * 
 * @author    Aziz S. Hussain <azizsaleh@gmail.com>
 * @copyright GPL license 
 * @license   http://www.gnu.org/copyleft/gpl.html 
 * @link      http://www.AzizSaleh.com
 */
 class MySQL
 {
    /**
     * Object instance
     *
     * @var MySQL
     */
    protected static $_instance;

    /**
     * Instances of the Db
     *
     * Start position @ 1
     *
     * @array PDO
     */
    protected $_instances = array(array());
    
    /**
     * Db Instances params
     *
     * @var array
     */
    protected $_params = array();
    
    /**
     * Next offset used by mysql_field_seek
     *
     * @var int
     */
    protected $_nextOffset = false;
    
    /**
     * Row seek
     *
     * @var int
     */
    protected $_rowSeek = array();

    /**
     * Get singelton instance
     *
     * @return MySQL
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * mysql_connect
     * http://www.php.net/manual/en/function.mysql-connect.php
     */
    public function mysql_connect($server, $username, $password, $newLink = false, $clientFlags = false, $usePosition = false)
    {
        // If we don't have to create a new instance and we have an instance, return it
        if ($newLink == false && count($this->_instances) > 1) {
            return 1;
        }
        
        $flags = $this->_translateFlags($clientFlags);
        
        // Set connection element
        if ($usePosition === false) {
            $usePosition = count($this->_instances) + 1;
        }
        
        // Set connection params
        $this->_params[$usePosition] = array (
            'server'        => $server,
            'username'      => $username,
            'password'      => $password,
            'newLink'       => $newLink,
            'clientFlags'   => $clientFlags,
            'errno'         => 0,
            'error'         => "",
            'rowCount'      => -1,
            'lastQuery'     => false,
        );

        // Create new instance
        $dsn = "mysql:host={$server}";
        try {
            // Add instance
            $this->_instances[$usePosition] = new Pdo($dsn, $username, $password, $flags);

            return $usePosition;
        } catch (PDOException $e) {
            // Mock the instance for error reporting
            $this->_instances[$usePosition] = array();
            $this->_loadError($usePosition, $e);
            return false;
        }
        
        return false;
    }
    
    /**
     * mysql_pconnect
     * http://www.php.net/manual/en/function.mysql-pconnect.php
     */
    public function mysql_pconnect($server, $username, $password, $newLink = false, $clientFlags = false)
    {
        $persistent = PDO::ATTR_PERSISTENT;
        $clientFlags = ($clientFlags !== false) ? array_merge($clientFlags, $persistent) : $persistent;
        return $this->mysql_connect($server, $username, $password, $newLink, $clientFlags);
    }
    
    /**
     * mysql_select_db
     * http://www.php.net/manual/en/function.mysql-select-db.php
     */
    public function mysql_select_db($databaseName, $link = false)
    {
        $link = $this->_getLastLink($link);

        // Select the DB
        try {
            $this->_params[$link]['databaseName'] = $databaseName;
            return $this->mysql_query("USE {$databaseName}", $link);
        } catch (PDOException $e) {
            return false;
        }

        return false;
    }
    
    /**
     * mysql_query
     * http://www.php.net/manual/en/function.mysql-query.php
     */
    public function mysql_query($query, $link = false)
    {
        $link = $this->_getLastLink($link);

        try {
            if ($res = $this->_instances[$link]->query($query)) {
                $this->_params[$link]['rowCount'] = $res->rowCount();
                $this->_params[$link]['lastQuery'] = $res;
                $this->_loadError($link, false);
                return $res;
            }
        } catch (PDOException $e) {
            $this->_loadError($link, $e);
        }

        $this->_params[$link]['rowCount'] = -1;
        $this->_params[$link]['lastQuery'] = false;

        // Set query error
        $errorCode = $this->_instances[$link]->errorInfo();
        $this->_params[$link]['errno'] = $errorCode[1];
        $this->_params[$link]['error'] = $errorCode[2];
        return false;
    }
    
    /**
     * mysql_unbuffered_query
     * http://www.php.net/manual/en/function.mysql-unbuffered-query.php
     */
    public function mysql_unbuffered_query($query, $link = false)
    {
        return $this->mysql_query($query, $link);
    }

    /**
     * mysql_fetch_array
     * http://www.php.net/manual/en/function.mysql-fetch-array.php
     */
    public function mysql_fetch_array(&$result, $resultType = 3, $doCounts = false, $elementId = false)
    {
        static $last = null;

        if ($result === false) {
            echo 'Warning: mysql_fetch_*(): supplied argument is not a valid MySQL result resource' . PHP_EOL;
            return false;
        }        

        // Are we only doing length counts?
        if ($doCounts === true) {
            return $this->_mysqlGetLengths($last, $elementId);
        }

        $hash = false;

        // Set retrieval type
        if (!is_array($result)) {
            $hash = spl_object_hash($result);
            switch ($resultType) {
                case 1:
                    // by field names only as array
                    $result = $result->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case 2:
                    // by field position only as array
                    $result = $result->fetchAll(PDO::FETCH_NUM);
                    break;
                case 3:
                    // by both field name/position as array
                    $result = $result->fetchAll();
                    break;
                case 4:
                    // by field names as object
                    $result = $result->fetchAll(PDO::FETCH_OBJ);
                    break;
            }
        }
        
        // Row seek
        if ($hash !== false && isset($this->_rowSeek[$hash])) {
            // Check valid skip
            $rowNumber = $this->_rowSeek[$hash];
            if ($rowNumber > count($result) - 1) {
                echo "Warning: mysql_data_seek(): Offset $rowNumber is invalid for MySQL result (or the query data is unbuffered)" . PHP_EOL;
            }

            while($rowNumber > 0) {
                next($result);
                $rowNumber--;
            }
            
            unset($this->_rowSeek[$hash]);
        }

        $last = current($result);
        next($result);

        return $last;
    }
    
    /**
     * mysql_fetch_assoc
     * http://www.php.net/manual/en/function.mysql-fetch-assoc.php
     */
    public function mysql_fetch_assoc(&$result)
    {
        return $this->mysql_fetch_array($result, 1);
    }
    
    /**
     * mysql_fetch_row
     * http://www.php.net/manual/en/function.mysql-fetch-row.php
     */
    public function mysql_fetch_row(&$result)
    {
        return $this->mysql_fetch_array($result, 2);
    }
    
    /**
     * mysql_fetch_object
     * http://www.php.net/manual/en/function.mysql-fetch-object.php
     */
    public function mysql_fetch_object(&$result)
    {
        return $this->mysql_fetch_array($result, 4);
    }
    
    /**
     * mysql_num_fields
     * http://www.php.net/manual/en/function.mysql-num-fields.php
     */
    public function mysql_num_fields($result)
    {
        if (is_array($result)) {
            return count($result);
        }

        $data = $result->fetch(PDO::FETCH_NUM);
        return count($data);
    }
    
    /**
     * mysql_num_rows
     * http://www.php.net/manual/en/function.mysql-num-rows.php
     */
    public function mysql_num_rows($result)
    {
        if (is_array($result)) {
            return count($result);
        }
        
        // Hard clone (cloning PDOStatements doesn't work)
        $query = $result->queryString;
        $cloned = $this->mysql_query($query);
        $data = $cloned->fetchAll();
        return count($data);
    }

    /**
     * mysql_ping
     * http://www.php.net/manual/en/function.mysql-ping.php
     */
    public function mysql_ping($link = false)
    {
        $link = $this->_getLastLink($link);

        try {
            $this->_instances[$link]->query('SELECT 1');
            $this->_loadError($link, false);
        } catch (PDOException $e) {
            try {
                // Reconnect
                $set = $this->mysql_connect(
                    $this->_params[$link]['server'],
                    $this->_params[$link]['username'],
                    $this->_params[$link]['password'],
                    $this->_params[$link]['newLink'],
                    $this->_params[$link]['clientFlags'],
                    $link
                );
            } catch (PDOException $e) {
                $this->_loadError($link, $e);
                return false;
            }

            // Select db if any
            if (isset($this->_params[$link]['databaseName'])) {
                $set = $this->mysql_select_db($this->_params[$link]['databaseName'], $link);
                
                if (!$set) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    /**
     * mysql_affected_rows
     * http://www.php.net/manual/en/function.mysql-affected-rows.php
     */
    public function mysql_affected_rows($link = false)
    {
        $link = $this->_getLastLink($link);
        
        return $this->_params[$link]['rowCount'];
    }

    /**
     * mysql_client_encoding
     * http://www.php.net/manual/en/function.mysql-client-encoding.php
     */
    public function mysql_client_encoding($link = false)
    {
        $link = $this->_getLastLink($link);

        $res = $this->_instances[$link]->query('SELECT @@character_set_database')->fetch(PDO::FETCH_NUM);

        return $res[0];
    }
    
    /**
     * mysql_close
     * http://www.php.net/manual/en/function.mysql-close.php
     */
    public function mysql_close($link = false)
    {
        $link = $this->_getLastLink($link);

        if (isset($this->_instances[$link])) {
            $this->_instances[$link] = null;
            unset($this->_instances[$link]);
            return true;
        }
        
        return false;
    }
    
    /**
     * mysql_create_db
     * http://www.php.net/manual/en/function.mysql-create-db.php
     */
    public function mysql_create_db($databaseName, $link = false)
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->prepare('CREATE DATABASE ' . $databaseName)->execute();
    }

    /**
     * mysql_data_seek
     * http://www.php.net/manual/en/function.mysql-data-seek.php
     */
    public function mysql_data_seek($result, $rowNumber)
    {
        // Set seek
        $this->_rowSeek[spl_object_hash($result)] = $rowNumber;
        return true;
    }

    /**
     * mysql_list_dbs
     * http://www.php.net/manual/en/function.mysql-list-dbs.php
     */
    public function mysql_list_dbs($link = false)
    {
        $link = $this->_getLastLink($link);

        return $this->_instances[$link]->query('SHOW DATABASES');
    }
    
    /**
     * mysql_db_name
     * http://www.php.net/manual/en/function.mysql-db-name.php
     */
    public function mysql_db_name(&$result, $row, $field = 'Database')
    {
        // Get list if not gotten yet (still PDOStatement)
        if (!is_array($result)) {
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
        }

        if (isset($result[$row][$field])) {
            return $result[$row][$field];
        }

        return '';
    }
    
    /**
     * mysql_db_query
     * http://www.php.net/manual/en/function.mysql-db-query.php
     */
    public function mysql_db_query($databaseName, $query, $link = false)
    {
        $link = $this->_getLastLink($link);
        
        $this->mysql_select_db($databaseName, $link);
        
        return $this->mysql_query($query, $link);
    }
    
    /**
     * mysql_drop_db
     * http://www.php.net/manual/en/function.mysql-drop-db.php
     */
    public function mysql_drop_db($databaseName, $link = false)
    {
        $link = $this->_getLastLink($link);

        return $this->_instances[$link]->prepare('DROP DATABASE ' . $databaseName)->execute();
    }
    
    /**
     * mysql_thread_id
     * http://www.php.net/manual/en/function.mysql-thread-id.php
     */
    public function mysql_thread_id($link = false)
    {
        $link = $this->_getLastLink($link);

        $res = $this->_instances[$link]
            ->query('SELECT CONNECTION_ID()')->fetch(PDO::FETCH_NUM);
            
        return $res[0];
    }
    
    /**
     * mysql_list_tables
     * http://www.php.net/manual/en/function.mysql-list-tables.php
     */
    public function mysql_list_tables($databaseName, $link = false)
    {
        $link = $this->_getLastLink($link);

        return $this->_instances[$link]->query('SHOW TABLES FROM ' . $databaseName);
    }
    
    /**
     * mysql_tablename
     * http://www.php.net/manual/en/function.mysql-tablename.php
     */
    public function mysql_tablename(&$result, $row)
    {
        // Get list if not gotten yet (still PDOStatement)
        if (!is_array($result)) {
            $result = $result->fetchAll(PDO::FETCH_NUM);
        }

        $counter = count($result);
        for ($x = 0; $x < $counter; $x++) {
            if ($x == $row) {
                return $result[$row][0];
            }
        }
        
        return '';
    }
    
    /**
     * mysql_fetch_lengths
     * http://www.php.net/manual/en/function.mysql-fetch-lengths.php
     */
    public function mysql_fetch_lengths(&$result)
    {
        // Get list if not gotten yet (still PDOStatement)
        return $this->mysql_fetch_array($result, false, true);
    }
    
    /**
     * mysql_field_len
     * http://www.php.net/manual/en/function.mysql-field-len.php
     */
    public function mysql_field_len(&$result, $fieldOffset = false)
    {
        if (!is_array($result)) {
            $result = $result->fetchAll(PDO::FETCH_NUM);
            $result = current($result);
        }

        return $this->_mysqlGetLengths($result, $fieldOffset);
    }

    /**
     * mysql_field_flags
     * http://www.php.net/manual/en/function.mysql-field-flags.php
     */
    public function mysql_field_flags(&$result, $fieldOffset = false)
    {
        return $this->_getColumnMeta($result, 'flags', $fieldOffset);
    }
    
    /**
     * mysql_field_name
     * http://www.php.net/manual/en/function.mysql-field-name.php
     */
    public function mysql_field_name(&$result, $fieldOffset = false)
    {
        return $this->_getColumnMeta($result, 'name', $fieldOffset);
    }
    
    /**
     * mysql_field_type
     * http://www.php.net/manual/en/function.mysql-field-type.php
     */
    public function mysql_field_type(&$result, $fieldOffset = false)
    {
        return $this->_getColumnMeta($result, 'type', $fieldOffset);
    }
    
    /**
     * mysql_field_table
     * http://www.php.net/manual/en/function.mysql-field-table.php
     */
    public function mysql_field_table(&$result, $fieldOffset = false)
    {
        return $this->_getColumnMeta($result, 'table', $fieldOffset);
    }
    /**
     * mysql_fetch_field
     * http://www.php.net/manual/en/function.mysql-fetch-field.php
     */
    public function mysql_fetch_field(&$result, $fieldOffset = false)
    {
        return $this->_getColumnMeta($result, false, $fieldOffset);
    }
        
    /**
     * mysql_field_seek
     * http://www.php.net/manual/en/function.mysql-field-seek.php
     */
    public function mysql_field_seek(&$result, $fieldOffset = false)
    {
        $this->_nextOffset = $fieldOffset;
    }

    /**
     * mysql_stat
     * http://www.php.net/manual/en/function.mysql-stat.php
     */
    public function mysql_stat($link = false) 
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->getAttribute(PDO::ATTR_SERVER_INFO);
    }
    
    /**
     * mysql_get_server_info
     * http://www.php.net/manual/en/function.mysql-get-server-info.php
     */
    public function mysql_get_server_info($link = false) 
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->getAttribute(PDO::ATTR_SERVER_VERSION);
    }
    
    /**
     * mysql_get_proto_info
     * http://www.php.net/manual/en/function.mysql-get-proto-info.php
     */
    public function mysql_get_proto_info($link = false)
    {
        $link = $this->_getLastLink($link);

        $res = $this->_instances[$link]
            ->query("SHOW VARIABLES LIKE 'protocol_version'")->fetch(PDO::FETCH_NUM);
            
        return (int) $res[1];
    }
    
    /**
     * mysql_get_host_info
     * http://www.php.net/manual/en/function.mysql-get-server-info.php
     */
    public function mysql_get_host_info($link = false) 
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->getAttribute(PDO::ATTR_CONNECTION_STATUS);
    }
    
    /**
     * mysql_get_client_info
     * http://www.php.net/manual/en/function.mysql-get-client-info.php
     */
    public function mysql_get_client_info($link = false) 
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->getAttribute(PDO::ATTR_CLIENT_VERSION);
    }
    
    /**
     * mysql_free_result
     * http://www.php.net/manual/en/function.mysql-free-result.php
     */
    public function mysql_free_result(&$result) 
    {
        if (is_array($result)) {
            $result = false;
            return true;
        }

        if (get_class($result) != 'PDOStatement') {
            return false;
        }

        return $result->closeCursor();
    }
    
    /**
     * mysql_result
     * http://www.php.net/manual/en/function.mysql-result.php
     */
    public function mysql_result(&$result, $row, $field = false)
    {

        // Get list if not gotten yet (still PDOStatement)
        if (!is_array($result)) {
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
        }

        $counter = count($result);
        for ($x = 0; $x < $counter; $x++) {
            if ($x == $row) {
                if ($field === false) {
                    return current($result[$row]);
                } else {
                    return $result[$row][$field];
                }
            }
        }
        
        return '';
    }
    
    /**
     * mysql_list_processes
     * http://www.php.net/manual/en/function.mysql-list-processes.php
     */
    public function mysql_list_processes($link = false) 
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->query("SHOW PROCESSLIST");
    }

    /**
     * mysql_set_charset
     * http://www.php.net/manual/en/function.mysql-set-charset.php
     */
    public function mysql_set_charset($charset, $link = false) 
    {
        $link = $this->_getLastLink($link);
        $set = "SET character_set_results = '$charset', character_set_client = '$charset', character_set_connection = '$charset', character_set_database = '$charset', character_set_server = '$charset'";
        return $this->_instances[$link]->query($set);
    }
    
    /**
     * mysql_insert_id
     * http://www.php.net/manual/en/function.mysql-insert-id.php
     */
    public function mysql_insert_id($link = false)
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->lastInsertId();
    }
    
    /**
     * mysql_list_fields
     * http://www.php.net/manual/en/function.mysql-list-fields.php
     */
    public function mysql_list_fields($databaseName, $tableName, $link = false)
    {
        $link = $this->_getLastLink($link);
        return $this->_instances[$link]->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_SCHEMA = '$databaseName' AND TABLE_NAME = '$tableName'")->fetchAll();
    }
    
    /**
     * mysql_errno
     * http://www.php.net/manual/en/function.mysql-errno.php
     */
    public function mysql_errno($link = false) 
    {
        $link = $this->_getLastLink($link, false);
        return $this->_params[$link]['errno'];
    }

    /**
     * mysql_error
     * http://www.php.net/manual/en/function.mysql-error.php
     */
    public function mysql_error($link = false) 
    {
        $link = $this->_getLastLink($link, false);
        return $this->_params[$link]['error'];
    }
    
    /**
     * mysql_real_escape_string
     * http://www.php.net/manual/en/function.mysql-real-escape-string.php
     */
    public function mysql_real_escape_string($string, $link = false)
    {
        $link = $this->_getLastLink($link);

        try {
            $string = $this->_instances[$link]->quote($string);
            $this->_loadError($link, false);
            return substr($string, 1, -1);
        } catch (PDOException $e) {
            $this->_loadError($link, $e);
            return false;
        }
        
        return false;
    }
    
    /**
     * mysql_escape_string
     * http://www.php.net/manual/en/function.mysql-escape-string.php
     */
    public function mysql_escape_string($string, $link = false)
    {
        $link = $this->_getLastLink($link, false);
        return $this->mysql_real_escape_string($string, $link);
    }

    /**
     * mysql_info
     *
     * Not sure how to get the actual result message from MySQL
     * so the best I could do was to get the affected rows
     * and construct a message that way. If you have a better way
     * or know of a more accurate method, send it to me @
     * azizsaleh@gmail.com and I'll update the code with it. All I got is
     * the affected rows, so it will be missing changed, warnings,
     * skipped, and rows matched
     *
     * http://www.php.net/manual/en/function.mysql-escape-string.php
     */
    public function mysql_info($link = false)
    {
        $link = $this->_getLastLink($link);

        $query = $this->_params[$link]['lastQuery'];

        if (!isset($query->queryString)) {
            return false;
        }
        
        $affected = $this->_params[$link]['rowCount'];

        if (strtoupper(substr($query->queryString, 0, 5)) == 'INSERT INTO') {
            return "Records: {$affected}  Duplicates: 0  Warnings: 0";
        }
        
        if (strtoupper(substr($query->queryString, 0, 9)) == 'LOAD DATA') {
            return "Records: {$affected}  Deleted: 0  Skipped: 0  Warnings: 0";
        }
        
        if (strtoupper(substr($query->queryString, 0, 11)) == 'ALTER TABLE') {
            return "Records: {$affected}  Duplicates: 0  Warnings: 0";
        }
        
        if (strtoupper(substr($query->queryString, 0, 6)) == 'UPDATE') {
            return "Rows matched: {$affected}  Changed: {$affected}  Warnings: 0";
        }
        
        if (strtoupper(substr($query->queryString, 0, 6)) == 'DELETE') {
            return "Records: 0  Deleted: {$affected}  Skipped: 0  Warnings: 0";
        }
        
        return false;
    }
    
    /**
     * Close all connections
     *
     * @return void
     */
    public function mysql_close_all()
    {
        // Free connections
        foreach ($this->_instances as $id => $pdo) {
            $this->_instances[$id] = null;
        }
        
        // Reset arrays
        $this->_instances = array(array());
        $this->_params    = array();
    }

    /**
     * is_resource function over ride
     *
     * @param RESOURCE $resource
     *
     * @return boolean
     */
    public function is_resource($resource)
    {
        // Check for a mysql result
        if (is_object($resource) && $resource instanceof PDOStatement) {
            return true;
        // Check if it is a mysql instance
        } else if (isset($this->_instances[$resource]) && !empty($this->_instances[$resource])) {
            return true;
        }

        return is_resource($resource);
    }

    /**
     * get_resource_type function over ride
     *
     * @param RESOURCE $resource
     *
     * @return boolean
     */
    public function get_resource_type($resource)
    {
        // mysql result resource type
        if (is_object($resource) && $resource instanceof PDOStatement) {
            return 'mysql result';
        }

        // Check if it is a mysql instance
        if (isset($this->_instances[$resource]) && !empty($this->_instances[$resource])) {
            // Check type
            if ($this->_params[$resource]['clientFlags'] == PDO::ATTR_PERSISTENT){
                return 'mysql link persistent';
            } else {
                return 'mysql link';
            }
        }

        return get_resource_type($resource);
    }

    /**
     * Get column meta information
     *
     * @param   object          $result
     * @param   enum|boolean    $type   flags|name|type|table|len
     * @param   int             $index
     *
     * @return  mixed
     */
    protected function _getColumnMeta(&$result, $type, $index)
    {
        // No index, but seek index
        if ($index === false && $this->_nextOffset !== false) {
            $index = $this->_nextOffset;
            // Reset
            $this->_nextOffset = false;
        }
        
        // No index, start @ 0 by default
        if ($index === false) {
            $index = 0;
        }
        
        if (is_array($result)) {
            return $result[$index][0];
        }

        $data = $result->getColumnMeta($index);

        switch ($type) {
            case 'flags':
                // Flags in PDO getColumMeta() is incomplete, so we will get flags manually
                return $this->_getAllColumnData($data, true);
            case 'name':
                return $data['name'];
            case 'type':
                return $this->_mapPdoType($data['native_type']);
            case 'table':
                return $data['table'];
            // Getting all data (mysql_fetch_field)
            case false:
                // Calculate max_length of all field in the resultset
                $rows = $result->fetchAll(PDO::FETCH_NUM);
                $counter = count($rows);
                $maxLength = 0;
                for ($x = 0; $x < $counter; $x++) {
                    $len = strlen($rows[$x][$index]);
                    if ($len > $maxLength) {
                        $maxLength = $len;
                    }
                }
                return $this->_getAllColumnData($data, false, $maxLength);
            default:
                return null;
        }
    }
    
    /**
     * Get all field data, mimick mysql_fetch_field functionality
     *
     * @param   array   $data
     * @param   boolean $simple
     * @param   int     $maxLength
     *
     * @return  object
     */
    protected function _getAllColumnData($data, $simple = false, $maxLength = 0)
    {
        $type = $this->_mapPdoType($data['native_type']);

        // for zerofill/unsigned, we do a describe
        $query = $this->mysql_query("DESCRIBE `{$data['table']}` `{$data['name']}`");
        $typeInner = $this->mysql_fetch_assoc($query);

        // Flags
        if ($simple === true) {
            $string = in_array('not_null', $data['flags']) ? 'not_null' : 'null';
            $string .= in_array('primary_key', $data['flags']) ? ' primary_key' : '';
            $string .= in_array('unique_key', $data['flags']) ? ' unique_key' : '';
            $string .= in_array('multiple_key', $data['flags']) ? ' multiple_key' : '';

            $unSigned = strpos($typeInner['Type'], 'unsigned');
            if ($unSigned !== false) {
                $string .= ' unsigned';
            } else {
                $string .= strpos($typeInner['Type'], 'signed') !== false ? ' signed' : '';
            }

            $string .= strpos($typeInner['Type'], 'zerofill') !== false ? ' zerofill' : '';
            $string .= isset($typeInner['Extra']) ? ' ' . $typeInner['Extra'] : '';
            return $string;
        }

        $return = array (
            'name'          => $data['name'],
            'table'         => $data['table'],
            'def'           => $typeInner['Default'],
            'max_length'    => $maxLength,
            'not_null'      => in_array('not_null', $data['flags']) ? 1 : 0,
            'primary_key'   => in_array('primary_key', $data['flags']) ? 1 : 0,
            'multiple_key'  => in_array('multiple_key', $data['flags']) ? 1 : 0,
            'unique_key'    => in_array('unique_key', $data['flags']) ? 1 : 0,
            'numeric'       => ($type == 'int') ? 1: 0,
            'blob'          => ($type == 'blob') ? 1: 0,
            'type'          => $type,
            'unsigned'      => strpos($typeInner['Type'], 'unsigned') !== false ? 1 : 0,
            'zerofill'      => strpos($typeInner['Type'], 'zerofill') !== false ? 1 : 0,
        );
        
        return (object) $return;
    }
    
    /**
     * Map PDO::TYPE_* to MySQL Type
     *
     * @param int   $type   PDO::TYPE_*
     *
     * @return string
     */
    protected function _mapPdoType($type)
    {
        // Types enum defined @ http://lxr.php.net/xref/PHP_5_4/ext/mysqlnd/mysqlnd_enum_n_def.h#271
        $type = strtolower($type);
        switch ($type) {
            case 'tiny':
            case 'short':
            case 'long':
            case 'longlong';
            case 'int24':
                return 'int';
            case 'null':
                return null;
            case 'varchar':
            case 'var_string':
            case 'string':
                return 'string';
            case 'blob':
            case 'tiny_blob':
            case 'long_blob':
                return 'blob';
            default:
                return $type;
        }
    }

    /**
     * For now we handle single flags, future feature
     * is to handle multiple flags with pipe |
     *
     * @param  string
     *
     * @return array
     */
    protected function _translateFlags($mysqlFlags)
    {
        if ($mysqlFlags == false || empty($mysqlFlags)) {
            return array();
        }
        
        // Array it
        if (!is_array($mysqlFlags)) {
            $mysqlFlags = array($mysqlFlags);
        }

        /*
         * I am only adding flags that are mappable in PDO
         * unfortunatly if you were using MySQL SSL, you will
         * need to manually add that flag in using PDO constants
         * located here: http://php.net/manual/en/ref.pdo-mysql.php
         */
        $pdoParams = array();
        foreach ($mysqlFlags as $flag) {
            switch ($flag)
            {
                // CLIENT_FOUND_ROWS (found instead of affected rows)
                case 2:
                    $params = array(PDO::MYSQL_ATTR_FOUND_ROWS => true);
                    break;
                // CLIENT_COMPRESS (can use compression protocol)
                case 32:
                    $params = array(PDO::MYSQL_ATTR_COMPRESS => true);
                    break;
                // CLIENT_LOCAL_FILES (can use load data local)
                case 128:
                    $params = array(PDO::MYSQL_ATTR_LOCAL_INFILE => true);
                    break;
                // CLIENT_IGNORE_SPACE (ignore spaces before '(')
                case 256:
                    $params = array(PDO::MYSQL_ATTR_IGNORE_SPACE => true);
                    break;
                // Persistent connection
                case 12:
                    $params = array(PDO::ATTR_PERSISTENT => true);
                    break;
            }
            
            $pdoParams[] = $params;
        }

        return $pdoParams;
    }

    /**
     * Load data into array
     *
     * @param int                       $link
     * @param PDO|PDOException|false    $object
     *
     * @return void
     */
    protected function _loadError($link, $object)
    {
        // Reset errors
        if ($object === false || is_null($object)) {
            $this->_params[$link]['errno'] = 0;
            $this->_params[$link]['error'] = "";
            return;
        }
        // Set error
        $this->_params[$link]['errno'] = $object->getCode();
        $this->_params[$link]['error'] = $object->getMessage();
    }
    
    /**
     * get last db connection
     *
     * @param   int     $link
     * @param   boolean $validate
     *
     * @return int
     */
    protected function _getLastLink($link, $validate = true)
    {
        if ($link === false) {
            $link = count($this->_instances);
        }

        if ($validate === true && !isset($this->_instances[$link]) || empty($this->_instances[$link])) {
            $error = '';
            if (isset($this->_instances[$link])) {
                die($this->_params[$link]['errno'] .': ' . $this->_params[$link]['error']);
            } else {
                die('No db at instance #' . ($link - 1));
            }
        }
        return $link;
    }
    
    /**
     * Get result set and turn them into lengths
     *
     * @param   array|object|null $resultSet
     * @param   boolean           $elementId
     *
     * @return  array
     */
    protected function _mysqlGetLengths(&$resultSet = false, $elementId = false)
    {
        // If we don't have data
        if (empty($resultSet) || is_null($resultSet)) {
            if ($elementId === false) {
                return null;
            }
            return 0;
        }
        
        // Make sure it is an array
        if (!is_array($resultSet)) {
            $resultSet = (array) $resultSet;
        }
        
        // Return lengths
        $resultSet = array_map('strlen', $resultSet);
        
        if ($elementId === false) {
            return $resultSet;
        }

        return $resultSet[$elementId];
    }
 }