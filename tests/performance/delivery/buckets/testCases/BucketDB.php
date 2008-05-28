<?php

abstract class BucketDB
{
    protected   $aConf;
    protected   $db;
    protected   $tableName;
    protected   $hasTransactions;

    function __construct($aConf)
    {
        $this->aConf = $aConf;
        $this->tableName = 'test_'.mt_rand(1000,1999);
    }

    function __destruct()
    {
        $this->disconnect();
    }

    static function factory($aConf)
    {
        $className = 'BucketDb_'.$aConf['type'];
        require_once $className . '.php';
        return new $className($aConf);
    }

    abstract function connect();

    abstract function disconnect();

    abstract function query($sql);

    abstract function fetch($result);

    abstract function error();

    abstract function affectedRows($result);

    abstract function updateCreate();

    function updateDrop()
    {
        $this->query("DROP TABLE {$this->tableName}");
    }

    function updateTest($date_time, $creative_id, $zone_id)
    {
        $updateSql = "UPDATE {$this->tableName} SET counter = counter + 1 WHERE date_time = '$date_time' AND creative_id = $creative_id AND zone_id = $zone_id";
        $result = $this->query($updateSql);
        if (!$this->affectedRows($result)) {
            if ($this->hasTransactions) {
                $this->query("BEGIN");
            }
            $result = $this->query("INSERT INTO {$this->tableName} VALUES ('$date_time', $creative_id, $zone_id, 1)");
            if (!$result) {
                if ($this->hasTransactions) {
                    $this->query("ROLLBACK");
                }
                $result = $this->query($updateSql);
            } else {
                if ($this->hasTransactions) {
                    $this->query("COMMIT");
                }
            }
        }

        return (bool)$result;
    }

    function updateResult()
    {
        $result = $this->query("SELECT SUM(counter) AS cnt FROM {$this->tableName}");
        $row = $this->fetch($result);
        return (int)$row['cnt'];
    }
}

?>