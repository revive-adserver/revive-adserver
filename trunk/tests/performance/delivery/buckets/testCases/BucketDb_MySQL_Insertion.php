<?php

require_once 'BucketDB.php';

class BucketDb_MySQL_Insertion extends BucketDb_MySQL
{

    function __construct($aConf)
    {
        parent::__construct($aConf);
    }

    function updateCreate()
    {
        $sql = "
            CREATE TABLE {$this->tableName} (
                date_time datetime NOT NULL,
                creative_id int NOT NULL,
                zone_id int NOT NULL
            ) ENGINE={$this->aConf['engine']}
        ";
        $this->query($sql) or die($this->error());
    }

    function updateTest($date_time, $creative_id, $zone_id)
    {
        $result = $this->query("INSERT INTO {$this->tableName} VALUES ('$date_time', $creative_id, $zone_id)");
        return (bool)$result;
    }

    function updateResult()
    {
        $result = $this->query("SELECT COUNT(*) as cnt FROM {$this->tableName} GROUP BY date_time, creative_id, zone_id");
        $counter = 0;
        while($row = $this->fetch($result)) {
            $counter += $row['cnt'];
        }
        return $counter;
    }
}

?>