<?php

class OA_Buckets
{
    public $createPrimaryKeys = true;

    public $dbType;
    public $typeTimestamp;

    public function __construct()
    {
        $this->dbType = $GLOBALS['_MAX']['CONF']['database']['type'];
        switch ($this->dbType) {
            case 'mysql':
                $this->typeTimestamp = 'DATETIME';
                break;
            case 'postgresql':
                $this->typeTimestamp = 'timestamp(0)';
                break;
            default:
                die('Unknown database type');
        }
    }

    function createBuckets()
    {
        if (isset($_GET['logMethod']) && $_GET['logMethod'] == 'insert') {
            $this->createPrimaryKeys = false;
        }
        $buckets = isset($_GET['buckets']) ?
            $_GET['buckets'] : $GLOBALS['OA_DEFAULT_BUCKETS'];
        $aBuckets = explode(',', $buckets);
        foreach ($aBuckets as $bucket) {
            $methodName = 'create_' . $bucket;
            if (method_exists($this, $methodName)) {
                $this->$methodName();
            }
        }
    }

    function createTableFromQuery($tableName, $query, $pk)
    {
        $this->dropTable($tableName);
        echo 'creating: '.$tableName."<br/>\n";
        if ($this->createPrimaryKeys) {
            $query = str_replace('{pk}', ',' . $pk, $query);
        } else {
            $query = str_replace('{pk}', '', $query);
        }
        return $this->query($query);
    }

    function modifyQuery($query, $dbType)
    {
        $query = str_replace('DATETIME', $this->typeTimestamp, $query);
        switch($dbType) {
            case 'mysql':
                $query .= ' ENGINE =' . $this->getEngineType();
                break;
            case 'postgresql':
                break;
        }
        return $query;
    }

    function getEngineType()
    {
        return isset($_GET['engine']) ? $_GET['engine'] : 'MEMORY';
    }

    function query($sql)
    {
        $ret = OA_Dal_Delivery_query(
            $sql,
            'rawDatabase'
        );
        if (!$ret) {
            OA_mysqlPrintError('rawDatabase');
        }
        return $ret;
    }

    function dropTable($tableName)
    {
        if (!empty($_GET['dropBuckets'])) {
            echo 'dropping: '.$tableName."<br/>\n";
            return $this->query("DROP TABLE IF EXISTS $tableName");
        }
        return true;
    }

    function create_data_bucket_impression()
    {
        $tableName = 'data_bucket_impression';
        $query = "CREATE TABLE IF NOT EXISTS data_bucket_impression (
          interval_start DATETIME,
          creative_id    INT,
          zone_id        INT,
          count          INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (interval_start, creative_id, zone_id)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }

    function create_data_bucket_impression_country()
    {
        $tableName = 'data_bucket_impression_country';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          interval_start DATETIME,
          creative_id    INT,
          zone_id        INT,
          country        CHAR(3),
          count          INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (interval_start, creative_id, zone_id, country)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }

    function create_data_bucket_fb_impression()
    {
        $tableName = 'data_bucket_fb_impression';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          interval_start      DATETIME,
          primary_creative_id INT,
          creative_id         INT,
          zone_id             INT,
          count               INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (interval_start, primary_creative_id, creative_id, zone_id)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }

    function create_data_bucket_oxm_impression()
    {
        $tableName = 'data_bucket_oxm_impression';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          interval_start      DATETIME,
          primary_creative_id INT,
          zone_id             INT,
          count               INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (interval_start, primary_creative_id, zone_id)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }

    function create_data_bucket_unique_website()
    {
        $tableName = 'data_bucket_unique_website';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          month_start    DATETIME,
          website_id     INT,
          count          INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (month_start, website_id)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }

    function create_data_bucket_unique_campaign()
    {
        $tableName = 'data_bucket_unique_campaign';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          month_start    DATETIME,
          campaign_id    INT,
          count          INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (month_start, campaign_id)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }

    function create_data_bucket_frequency()
    {
        $tableName = 'data_bucket_frequency';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          campaign_id    INT,
          frequency      INT,
          count          INT
          {pk}
        )";
        $pk = 'PRIMARY KEY (campaign_id, frequency)';
        return $this->createTableFromQuery($tableName, $query, $pk);
    }
}

?>