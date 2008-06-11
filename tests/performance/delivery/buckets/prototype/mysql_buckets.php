<?php

class OA_Buckets
{
    function getEngine()
    {
        return isset($_GET['engine']) ? $_GET['engine'] : 'MEMORY';
    }

    function createBuckets()
    {
        $buckets = isset($_GET['buckets']) ? explode($_GET['buckets']) : $GLOBALS['OA_DEFAULT_BUCKETS'];
        foreach ($buckets as $bucket) {
            if (method_exists($this, $bucket)) {
                $methodName = 'create_' . $bucket;
                $this->$methodName();
            }
        }
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
            return $this->query("DROP TABLE IF EXISTS $tableName");
        }
        return true;
    }

    function create_data_bucket_impression()
    {
        $this->dropTable('data_bucket_impression');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_impression (
          interval_start DATETIME,
          creative_id    INT,
          zone_id        INT,
          count          INT,
          PRIMARY KEY (interval_start, creative_id, zone_id)
        ) ENGINE ='.$this->getEngine();
        return $this->query($query);
    }

    function create_data_bucket_impression_country()
    {
        $this->dropTable('data_bucket_impression_country');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_impression_country (
          interval_start DATETIME,
          creative_id    INT,
          zone_id        INT,
          country        CHAR(3),
          count          INT,
          PRIMARY KEY (interval_start, creative_id, zone_id, country)
        ) ENGINE ='.$this->getEngine();
        return $this->query($query);
    }

    function create_data_bucket_fb_impression()
    {
        $this->dropTable('data_bucket_fb_impression');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_fb_impression (
          interval_start      DATETIME,
          primary_creative_id INT, -- Currently bannerid or ad_id
          creative_id         INT, -- Currently bannerid or ad_id
          zone_id             INT,
          count               INT,
          PRIMARY KEY (interval_start, primary_creative_id, creative_id, zone_id)
        ) ENGINE ='.$this->getEngine();;
        return $this->query($query);
    }

    function create_data_bucket_oxm_impression()
    {
        $this->dropTable('data_bucket_oxm_impression');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_oxm_impression (
          interval_start      DATETIME,
          primary_creative_id INT, -- Currently bannerid or ad_id
          zone_id             INT,
          count               INT,
          PRIMARY KEY (interval_start, primary_creative_id, zone_id)
        ) ENGINE ='.$this->getEngine();
        return $this->query($query);
    }

    function create_data_bucket_unique_website()
    {
        $this->dropTable('data_bucket_unique_website');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_unique_website (
          month_start    DATETIME,
          website_id     INT, -- Currently affiliate_id
          count          INT,
          PRIMARY KEY (month_start, website_id)
        ) ENGINE ='.$this->getEngine();
        return $this->query($query);
    }

    function create_data_bucket_unique_campaign()
    {
        $this->dropTable('data_bucket_unique_campaign');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_unique_campaign (
          month_start    DATETIME,
          campaign_id    INT,
          count          INT,
          PRIMARY KEY (month_start, campaign_id)
        ) ENGINE ='.$this->getEngine();
        return $this->query($query);
    }

    function create_data_bucket_frequency()
    {
        $this->dropTable('data_bucket_frequency');
        $query = 'CREATE TABLE IF NOT EXISTS data_bucket_frequency (
          campaign_id    INT,
          frequency      INT,
          count          INT,
          PRIMARY KEY (campaign_id, frequency)
        ) ENGINE ='.$this->getEngine();
        return $this->query($query);
    }
}

?>