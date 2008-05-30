<?php

require_once 'BucketDB.php';

class BucketDb_PgSQL extends bucketDB
{
    function  __construct($aConf)
    {
        parent::__construct($aConf);
        $this->hasTransactions = true;
    }

    function connect()
    {
        $host = !empty($this->aConf['host']) ? "host={$this->aConf['host']} " : '';
        $port = empty($this->aConf['port']) ? 5432 : $this->aConf['port'];
        return $this->db = pg_connect("{$host}port={$port} user={$this->aConf['user']} password={$this->aConf['password']} dbname={$this->aConf['dbname']}", PGSQL_CONNECT_FORCE_NEW);
    }

    function disconnect()
    {
        if (!empty($this->db)) {
            pg_close($this->db);
            $this->db = null;
        }
    }

    function query($sql)
    {
        if (!empty($this->db) || $this->connect()) {
            return @pg_query($this->db, $sql);
        }
        return false;
    }

    function error()
    {
        return pg_errormessage($this->db);
    }

    function fetch($result)
    {
        return pg_fetch_assoc($result);
    }

    function affectedRows($result)
    {
        return @pg_affected_rows($result);
    }

    function updateCreate()
    {
        $sql = "
            CREATE TABLE {$this->tableName} (
                date_time timestamp(0) NOT NULL,
                creative_id int NOT NULL,
                zone_id int NOT NULL,
                counter int NOT NULL DEFAULT 1,
                PRIMARY KEY (date_time, creative_id, zone_id)
            )
        ";
        $this->query($sql) or die($this->error());
    }
    
    function updateTest($date_time, $creative_id, $zone_id) {
        $this->query('SET SESSION synchronous_commit TO OFF');
        parent::updateTest($date_time, $creative_id, $zone_id);
    }
}

?>