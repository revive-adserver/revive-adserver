<?php

$GENERATE_MARKET_STATS = false;
$TEMP_DEBUG = false;

if($GENERATE_MARKET_STATS) {
    $marketGenerator = new OX_oxMarket_Stats_DataGenerator();
    $marketGenerator->main();
}

class OX_oxMarket_Stats extends OA_StatisticsFieldsDelivery
{
    const MARKET_STATS_TABLE = 'ext_market_stats';

    function __construct()
    {
        $this->_aFields = array();
        $this->displayOrder = -10;
    }

    function summarizeStats(&$row)
    {
    }
    
    function getName()
    {
        return 'where is this used?';
    }
    
    function mergeAds($ads)
    {
        $do = DB_DataObject::factory('Banners');
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
        $aParams['market_stats'] = true;
        $aParams['custom_table'] = OX_oxMarket_Stats::MARKET_STATS_TABLE;
        $aParams['custom_columns'] = array(
        				"CONCAT(market_advertiser_id, ' ',ad_width, 'x',ad_height)" => 'ad_id', 
            			's.zone_id' => 'zone_id', 
            			'SUM(s.impressions)' => 'sum_views', 
            			'SUM(s.clicks)' => 'sum_clicks',  
            			'SUM(s.revenue)' => 'sum_revenue'
        );
        $this->marketRows = Admin_DA::fromCache($method, $aParams);

        if($TEMP_DEBUG) {
            var_dump($method);
            var_dump($aParams);
            echo "Core stats rows:";
            var_dump($aRows);
            echo "Returned market stats rows:";
            var_dump($this->marketRows);
        }    
            
        $columnsToSum = array('sum_views', 'sum_clicks', 'sum_revenue');
        foreach($this->marketRows as $key => $marketValues) {
            $adId = $marketValues['ad_id'];
            
            // this is the core stats row for this entity (campaign, zone, website, etc.)
            $coreValues =& $aRows[$key];
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
    }
    
    
    static function getTableName()
    {
		$prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
		return $prefix . self::MARKET_STATS_TABLE;
    }
}

class OX_oxMarket_Stats_DataGenerator
{
    function main()
    {
        $bannerIds = range($minBannerId = 50, $maxBannerId = 51, $step = 1);
        $websiteIds = range($minWebsiteId = 1, $maxWebsiteId = 2, $step = 1);
        $zoneIds = range($minZoneId = 1, $maxZoneId = 15, $step = 1);
        // insert a record for the catch-all zone after migration from previous market stats
        $zoneIds[] = null; 
        
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
