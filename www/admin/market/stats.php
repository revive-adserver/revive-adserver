<?php

//$c = new OX_oxMarket_Stats_Migration();
//$c->migrateFromPre283();
//exit;
$GENERATE_MARKET_STATS = false;

if($GENERATE_MARKET_STATS) {
    $marketGenerator = new OX_oxMarket_Stats_DataGenerator();
    $marketGenerator->main();
}

class OX_oxMarket_Stats extends OA_StatisticsFieldsDelivery
{
    const MARKET_STATS_TABLE = 'ext_market_stats';

    private $marketRowsOnlyZoneZero = array();
    private $marketRows = array();
    
    function __construct()
    {
        $this->_aFields = array();
        $this->displayOrder = -10;
        
        // loading the DO classes necessary to access DataObjects_*
        $do = DB_DataObject::factory('Banners');
        $do = DB_DataObject::factory('Zones');
    }

    function summarizeStats(&$row)
    {
    }
    
    function getName()
    {
        return 'where is this used?';
    }

    function getHistorySpanParams()
    {
        $aParams = array();
        $aParams['custom_table'] = self::MARKET_STATS_TABLE;
        $aParams['add_columns'] = array("DATE_FORMAT(MIN(date_time), '%Y-%m-%d')" => 'start_date');
        $aParams['market_stats_get_start_date'] = true;
        $aParams['market_stats'] = true;
        return $aParams;
    }
    
    function mergeZones($zones)
    {
        if(empty($this->marketRowsOnlyZoneZero)) {
            return;
        }
        
        foreach($this->marketRowsOnlyZoneZero as $zoneKey => $zoneInfo) {
            $zone = array(
                'zone_id' => $zoneKey,
                'publisher_id' => $zoneInfo['publisher_id'],
                'name' => '', // will be set in lib/OA/Admin/Statistics/Delivery/CommonEntity.php getZones()
                'type' => MAX_ZoneMarketMigrated,
            );
            $zones[$zoneKey] = $zone;
        }
    }
    function mergeAds($ads)
    {
        $bannerType = DataObjects_Banners::BANNER_TYPE_MARKET;
        // remove market banners from the  list - market banners are simple proxies
        // that are never displayed on screen
        foreach($ads as $key => $row) {
            $extBannerType = $row['ext_bannertype'];
            if($extBannerType == $bannerType) {
                unset($ads[$key]);
            }
        }
        $defaultMarketAd = array(
            'status' => OA_ENTITY_STATUS_RUNNING,
            'type' => $bannerType,
            'ext_bannertype' => $bannerType,
        );
        foreach($this->marketRows as $row) {
            $adName = $row['ad_id'];
            $ads[$adName] = $defaultMarketAd + array(
                'ad_id' => $adName,
                'placement_id' => $row['placement_id'],
                'name' => $adName,
            );
        }
    }
    
    function mergeData(&$aRows, $emptyRow, $method, $aParams)
    {
        if($TEMP_DEBUG = !true) {
            var_dump('mmarket ROW');
            var_dump($method);
            var_dump($aParams);
            echo "Core stats rows:";
            var_dump($aRows);
            echo "Returned market stats rows:";            
            var_dump($this->marketRows);
        }
        $aParams['market_stats'] = true;
        $aParams['custom_table'] = OX_oxMarket_Stats::MARKET_STATS_TABLE;
        $standardCustomColumns = array(
            			'SUM(s.impressions)' => 'sum_views', 
            			'SUM(s.clicks)' => 'sum_clicks',  
            			'SUM(s.revenue)' => 'sum_revenue',
            			"CONCAT(m.campaignid, IF( market_advertiser_id, CONCAT('-', market_advertiser_id, '-'), '-'), ad_width, ' x ',ad_height)" => 'ad_id'
        );

        $aParams['custom_columns'] = $standardCustomColumns;
        $this->marketRows = Admin_DA::fromCache($method, $aParams);
        
        $includeZoneZeroStats = !isset($aParams['zone_id']);
        if($includeZoneZeroStats) {
            // because the query above joined the zones/publishers tables, they did not include the records
            // for zone_id = 0 which is a contained for all market stats pre-2.8.3, where we did not know 
            // what zones served Market ads. We will now select all stats for ads that served in zone_id = 0
            // we will later merge them back in the stats array
            $aParams['zone_id'] = 0;
            $aParams['custom_columns'] = $standardCustomColumns;
            $aParams['market_stats_including_zone_zero'] = true;
    
            $this->marketRowsOnlyZoneZero = Admin_DA::fromCache($method, $aParams);
            foreach($this->marketRowsOnlyZoneZero as &$row) {
                $row['zone_id'] = $row['publisher_id'].'-'.$row['zone_id'];
            }
            $this->sumStatsArray($this->marketRowsOnlyZoneZero, $this->marketRows);
        }    
            
        $this->sumStatsArray($this->marketRows, $aRows);
    }
    
    /**
     * Sums stats array2 = array1 + array2 by summing columns sum_views, sum_clicks, sum_revenue
     * @param $array1
     * @param $array2
     * @return void
     */
    protected function sumStatsArray($array1, &$array2)
    {
        $columnsToSum = array('sum_views', 'sum_clicks', 'sum_revenue');
        foreach($array1 as $key => $marketValues) {
            // this is the core stats row for this entity (campaign, zone, website, etc.)
            $coreValues =& $array2[$key];
            if(!empty($coreValues)) {
                // merge (sum) core and Market stats 
                foreach($columnsToSum as $columnToSum) {
                    if(!isset($coreValues[$columnToSum])) {
                        $coreValues[$columnToSum] = 0;
                    }
                    $coreValues[$columnToSum] += $marketValues[$columnToSum];
                }
            } else {
                $coreValues = $marketValues;
            } 
        }
        // now set all rows not found in array2 from array1
        $array2 += $array1;
    }
    
    static function getTableName()
    {
		$prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
		return $prefix . self::MARKET_STATS_TABLE;
    }
}
class OX_oxMarket_Stats_Migration
{
    function migrateFromPre283()
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $query = '	INSERT INTO '.$prefix.OX_oxMarket_Stats::MARKET_STATS_TABLE.'
                    SELECT date_time, 
                    		NULL as market_advertiser_id, 
                    		t.width as ad_width, 
                    		t.height as ad_height, 
                    		t2.affiliateid as website_id, 
                    		0 as zone_id, 
                    		t6.bannerid as ad_id, 
                    		t.impressions as impressions, 
                    		0 as clicks, 
                    		t.revenue as revenue
                    FROM '.$prefix.'ext_market_web_stats t
                    LEFT JOIN '.$prefix.'ext_market_website_pref t2
                    ON t2.website_id = t.p_website_id 
                    LEFT JOIN '.$prefix.'affiliates t3
                    ON t3.affiliateid = t2.affiliateid
                    LEFT JOIN '.$prefix.'clients t4
                    ON t4.agencyid = t3.agencyid 
                    LEFT JOIN '.$prefix.'campaigns t5
                    ON t5.clientid=t4.clientid 
                    LEFT JOIN '.$prefix.'banners t6
                    ON t6.campaignid = t5.campaignid
                    WHERE t4.type = 1
                    AND t5.type=1
                    ';
        $oDbh = OA_DB::singleton();
        $rows = $oDbh->query($query);

    }
}
class OX_oxMarket_Stats_DataGenerator
{
    function main()
    {
        $bannerIds = range($minBannerId = 50, $maxBannerId = 53, $step = 1);
        $websiteIds = range($minWebsiteId = 1, $maxWebsiteId = 2, $step = 1);
        $zoneIds = range($minZoneId = 1, $maxZoneId = 15, $step = 1);
        // insert a record for the catch-all zone after migration from previous market stats
        $zoneIds = array(0); 
        
        $pastDays = 15;
        echo "hello world, generating market stats...";
	    $this->generateFakeMarketStatistics($pastDays, $websiteIds, $zoneIds, $bannerIds);
        echo "done!";
        exit;
    }

    /**
     * This is a rather bruteforce data generator. 
     * It will also generate data for non existing zones and websites.
     * this helps testing the stats screen and ensure that only entities 
     * available to the logged-in user are displayed.
     */
    function generateFakeMarketStatistics($pastDays, $websiteIds, $zoneIds, $bannerIds)
    {
    	echo "generating fake data for ".count($websiteIds)." websites, 
    			". count($zoneIds)." zones, 
    			". count($bannerIds)." banners 
    			for the last ".$pastDays." days...<br>";
    	flush();
        
    	$IAB = array(array(728,90), array(468,60),array(120,90), array(336,280));
        $advertisers = array('Richmedia', 'AdReady', 'LongName advertiser ', 'VeryNice advertiser', 'éè adv');
        
		$oDbh = OA_DB::singleton();
		$now = time();
		$stop = $now - $pastDays*86400;
		while($now > $stop) {
		    foreach($websiteIds as $websiteId) {
		        foreach($zoneIds as $zoneId) {
		            foreach($bannerIds as $bannerId) {
		                $countRowsByHourByZone = rand(1,5);
		                while($countRowsByHourByZone > 0) {
		                    $countRowsByHourByZone--;
		                    
                		    $advertiser = $advertisers[array_rand($advertisers, 1)];
                		    $adSize = $IAB[array_rand($IAB, 1)];
                		    $adWidth = $adSize[0];
                		    $adHeight = $adSize[1];
                		    $impressions = rand(0,15000);
                		    $clicks = rand(0,1100);
                		    $revenue = rand(0.1,150)+lcg_value();
                			$data[] = array(
                			    gmdate('Y-m-d H:i:s', $now),
                			    $advertiser,
                			    $adWidth,
                			    $adHeight,
                			    $websiteId,
                			    $zoneId,
                			    $bannerId,
                			    $impressions,
                			    $clicks,
                			    $revenue
                			);
		                }
		            }
		        }
		    }
			$now = strtotime("1 hour ago", $now);
		}
		$fields = array(
					'date_time' ,
                    'market_advertiser_id' ,
                    'ad_width' ,
                    'ad_height' ,
                    'website_id' ,
                    'zone_id' ,
                    'ad_id' ,
                    'impressions' ,
                    'clicks' ,
                    'revenue');
		OA_Dal::batchInsert(OX_oxMarket_Stats::getTableName(), $fields, $data);
	}
}
