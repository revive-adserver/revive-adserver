<?php

class OA_Buckets
{
    function createBuckets()
    {
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

    function getEngine()
    {
        return isset($_GET['engine']) ? $_GET['engine'] : 'MEMORY';
    }

    function createTableFromQuery($query, $tableName)
    {
        $this->dropTable($tableName);
        echo 'creating: '.$tableName."<br/>\n";
        return $this->query($query . $this->getEngine());
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
          count          INT,
          PRIMARY KEY (interval_start, creative_id, zone_id)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }

    function create_data_bucket_impression_country()
    {
        $tableName = 'data_bucket_impression_country';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          interval_start DATETIME,
          creative_id    INT,
          zone_id        INT,
          country        CHAR(3),
          count          INT,
          PRIMARY KEY (interval_start, creative_id, zone_id, country)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }

    function create_data_bucket_fb_impression()
    {
        $tableName = 'data_bucket_fb_impression';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          interval_start      DATETIME,
          primary_creative_id INT, -- Currently bannerid or ad_id
          creative_id         INT, -- Currently bannerid or ad_id
          zone_id             INT,
          count               INT,
          PRIMARY KEY (interval_start, primary_creative_id, creative_id, zone_id)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }

    function create_data_bucket_oxm_impression()
    {
        $tableName = 'data_bucket_oxm_impression';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          interval_start      DATETIME,
          primary_creative_id INT, -- Currently bannerid or ad_id
          zone_id             INT,
          count               INT,
          PRIMARY KEY (interval_start, primary_creative_id, zone_id)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }

    function create_data_bucket_unique_website()
    {
        $tableName = 'data_bucket_unique_website';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          month_start    DATETIME,
          website_id     INT, -- Currently affiliate_id
          count          INT,
          PRIMARY KEY (month_start, website_id)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }

    function create_data_bucket_unique_campaign()
    {
        $tableName = 'data_bucket_unique_campaign';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          month_start    DATETIME,
          campaign_id    INT,
          count          INT,
          PRIMARY KEY (month_start, campaign_id)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }

    function create_data_bucket_frequency()
    {
        $tableName = 'data_bucket_frequency';
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
          campaign_id    INT,
          frequency      INT,
          count          INT,
          PRIMARY KEY (campaign_id, frequency)
        ) ENGINE =";
        return $this->createTableFromQuery($query, $tableName);
    }
}

?>