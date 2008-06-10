<?php

function OA_createBuckets()
{
    OA_create__data_bucket_impression();
    OA_create__data_bucket_impression_country();
//    OA_create__data_bucket_fb_impression();
//    OA_create__data_bucket_oxm_impression();
//    OA_create__data_bucket_unique_website();
//    OA_create__data_bucket_unique_campaign();
//    OA_create__data_bucket_frequency();
}

function OA_create__data_bucket_impression()
{
    $query = 'CREATE TABLE data_bucket_impression (
      interval_start DATETIME,
      creative_id    INT,
      zone_id        INT,
      count          INT
    ) PRIMARY KEY (interval_start, creative_id, zone_id)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

function OA_create__data_bucket_impression_country()
{
    $query = 'CREATE TABLE data_bucket_impression_country (
      interval_start DATETIME,
      creative_id    INT,
      zone_id        INT,
      country        CHAR(3),
      count          INT
    ) PRIMARY KEY (interval_start, creative_id, zone_id, country)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

function OA_create__data_bucket_fb_impression()
{
    $query = 'CREATE TABLE data_bucket_fb_impression (
      interval_start      DATETIME,
      primary_creative_id INT, -- Currently bannerid or ad_id
      creative_id         INT, -- Currently bannerid or ad_id
      zone_id             INT,
      count               INT
    ) PRIMARY KEY (interval_start, primary_creative_id, creative_id, zone_id)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

function OA_create__data_bucket_oxm_impression()
{
    $query = 'CREATE TABLE data_bucket_oxm_impression (
      interval_start      DATETIME,
      primary_creative_id INT, -- Currently bannerid or ad_id
      zone_id             INT,
      count               INT
    ) PRIMARY KEY (interval_start, primary_creative_id, zone_id)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

function OA_create__data_bucket_unique_website()
{
    $query = 'CREATE TABLE data_bucket_unique_website (
      month_start    DATETIME,
      website_id     INT, -- Currently affiliate_id
      count          INT
    ) PRIMARY KEY (month_start, website_id)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

function OA_create__data_bucket_unique_campaign()
{
    $query = 'CREATE TABLE data_bucket_unique_campaign (
      month_start    DATETIME,
      campaign_id    INT,
      count          INT
    ) PRIMARY KEY (month_start, campaign_id)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

function OA_create__data_bucket_frequency()
{
    $query = 'CREATE TABLE data_bucket_frequency (
      campaign_id    INT,
      frequency      INT,
      count          INT
    ) PRIMARY KEY (campaign_id, frequency)';
    return OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
}

?>