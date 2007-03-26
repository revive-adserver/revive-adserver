<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Campaigns extends MAX_Dal_Common
{
    var $table = 'campaigns';
    
	var $orderListName = array(
        'name' => 'campaignname',
        'id'   => array('clientid', 'campaignid'),
    );
    
    /**
     * Determines the AdViews left before expiration
     *
     * @param int $campaignId  the campaign ID.
     * @return mixed  the number of ad views left or 'unlimited'
     */
    function getAdViewsLeft($campaignId)
    {
        global $strUnlimited;
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                views
		    FROM
		        {$prefix}campaigns
	        WHERE
	            campaignid = $campaignId
        ";
        
        $rsCampaigns = DBC::FindRecord($query);
        $aViews = $rsCampaigns->toArray();
        if ($aViews['views'] == -1) {
            return $strUnlimited;
        }
        return $aViews['views'];
    }
    
    /**
     * Determines the AdClicks left before expiration
     *
     * @param int $campaignId  the campaign ID
     * @return mixed  the number of ad clicks left or 'unlimited'
     */
    function getAdClicksLeft($campaignId)
    {
        global $strUnlimited;
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                clicks
            FROM
                {$prefix}campaigns
            WHERE
                campaignid = $campaignId
        ";
        
        $rsCampaigns = DBC::FindRecord($query);
        $aClicks = $rsCampaigns->toArray();
        if ($aClicks['clicks'] == -1) {
            return $strUnlimited;
        }
        return $aClicks['clicks'];
    }
    
    /**
     * Estimates time before expiration.
     * This function calculates the estimated end of a
     * client's credits in clicks or views based on used
     * views and clicks, the time from the first to the last 
     * view and click and the current date. If the client
     * has an expiration date this one will have priority.
     * 
     * The return value is an array which returns a ready to 
     * use string with expiration and left days contents
     * based on language string settings, a string with the
     * date and an integer value with the amount of days
     * left for alternate usage
     * 
     * Usage: list($desc,$enddate,$daysleft)=$dalCampaigns->getDaysLeft($campaignid)
     * 
     * This function will temporarily not work properly, if
     * statistics are reset or the amount of the credit in
     * views or clicks or left days is modified.
     *
     * @param int $campaignid  the campaign ID
     * @return array
     */
    function getDaysLeft($campaignid)
    {
        global $date_format, $strExpiration, $strNoExpiration, $strDaysLeft, $strEstimated;
        $prefix = $this->getTablePrefix();
        
        // preset return values
    	$estimated_end = "-";
    	$days_left="-";
    	$description="";
    	$absolute=0;
    	
    	// Get client record
	    $query = "
		    SELECT
		        views,
		        clicks,
		        expire,
		        DATE_FORMAT(expire, '$date_format') as expire_f,
		        TO_DAYS(expire) - TO_DAYS(NOW()) as days_left
	        FROM
	            {$prefix}campaigns
            WHERE
                campaignid = $campaignid
	    ";
	    
	    if ($rsCampaigns = DBC::FindRecord($query)) {
	        $row_campaign = $rsCampaigns->toArray();
	        
	        // Check if the expiration date is set
    		if ($row_campaign['expire'] != '0000-00-00' && $row_campaign['expire'] != '') {
    			$expiration[] = array (
    				"days_left" => round($row_campaign["days_left"]),
    				"date"	  	=> $row_campaign["expire_f"],
    				"absolute"  => true
    			);
    		}
    		
    		if ($row_campaign["views"] != -1) {
               	$query = "
               	    SELECT
               	        SUM(impressions) AS total_views,
               	        MAX(TO_DAYS(day)) - TO_DAYS(NOW()) AS days_since_last_view,
               		    TO_DAYS(NOW()) - MIN(TO_DAYS(day)) AS days_since_start
           		    FROM
           		        {$prefix}banners AS b
           		        LEFT JOIN {$prefix}data_summary_ad_hourly AS v
               		    ON b.bannerid = v.ad_id
               		WHERE b.campaignid= $campaignid
               	";
    			
               	$rsCampaigns = DBC::FindRecord($query);
    			if ($rsCampaigns) {
    				$row_views = $rsCampaigns->toArray();
    				
    				if (!isset($row_views["days_since_start"]) ||
    				    $row_views["days_since_start"] == '' ||
    				    $row_views["days_since_start"] == 0  ||
    					$row_views["days_since_start"] == null)
    				{
    					$row_views["days_since_start"] = 1;
    				}
    				
    				if (!empty ($row_views["total_views"]) && $row_views["total_views"] > 0) {
    					$days_left = round ($row_campaign["views"] / ($row_views["total_views"] / $row_views["days_since_start"]));
    					
    					if ($row_campaign["views"] > 0) {
    						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") + $days_left, date("Y")));
    						$expiration[] = array (
    							"days_left" => $days_left,
    							"date"	  	=> $estimated_end,
    							"absolute"  => false
    						);
    					} else {
    						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") - $row_views["days_since_last_view"], date("Y")));
    						$expiration[] = array (
    							"days_left" => 0 - $row_views["days_since_last_view"],
    							"date"	  	=> $estimated_end,
    							"absolute"  => true
    						);
    					}
    				}
    			}
    		}
    		
    		if ($row_campaign["clicks"] != -1) {
            	$click_query = "
                    SELECT
                        SUM(clicks) as total_clicks,
                        MAX(TO_DAYS(day)) - TO_DAYS(NOW()) as days_since_last_click,
                        TO_DAYS(NOW()) - MIN(TO_DAYS(day)) as days_since_start
                    FROM
                        {$prefix}data_summary_ad_hourly AS a
            		    LEFT JOIN {$prefix}banners AS b
            		    ON a.ad_id = b.bannerid
            		WHERE
            		    campaignid = $campaignid
            		AND
            		    clicks > 0
            	";
    
                $rsClicks = DBC::FindRecord($click_query);
            	if ($rsClicks) {
    				$row_clicks = $rsClicks->toArray();
    				
    				if (!isset($row_clicks["days_since_start"]) ||
    				    $row_clicks["days_since_start"] == '' ||
    				    $row_clicks["days_since_start"] == 0  ||
    					$row_clicks["days_since_start"] == null)
    				{
    					$row_clicks["days_since_start"] = 1;
    				}
    				
    				if (!empty ($row_clicks["total_clicks"]) && $row_clicks["total_clicks"] > 0) {
    					$days_left = round($row_campaign["clicks"] / ($row_clicks["total_clicks"] / $row_clicks["days_since_start"]));
    					
    					if ($row_campaign["clicks"] > 0) {
    						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") + $days_left, date("Y")));
    						$expiration[] = array (
    							"days_left" => $days_left,
    							"date"	  	=> $estimated_end,
    							"absolute"  => false
    						);
    					} else {
    						$estimated_end = strftime ($date_format, mktime (0, 0, 0, date("m"), date("d") - $row_clicks["days_since_last_view"], date("Y")));
    						$expiration[] = array (
    							"days_left" => 0 - $row_clicks["days_since_last_view"],
    							"date"	  	=> $estimated_end,
    							"absolute"  => true
    						);
    					}
    				}
    			}
    		}
    	}
    	
    	// Build Return value
    	if (isset($expiration) && sizeof($expiration) > 0) {
    		$sooner = $expiration[0];
    		
    		for ($i = 0; $i < sizeof($expiration); $i++) {
    			if ($expiration[$i]['days_left'] < $sooner['days_left']) {
    				$sooner = $expiration[$i];
    			}
    		}
    		
    		if ($sooner['days_left'] < 0) {
    		    $sooner['days_left'] = 0;
    		}
    		
    		if ($sooner['absolute']) {
    			$ret_val[] = $strExpiration.": ".$sooner['date']." (".$strDaysLeft.": ".$sooner['days_left'].")";
    		} else {
    			$ret_val[] = $strEstimated.": ".$sooner['date']." (".$strDaysLeft.": ".$sooner['days_left'].")";
    		}
    		
    		$ret_val[]=$sooner['date'];
    		$ret_val[]=$sooner['days_left'];
    	} else {
    		// Unknown
    		$ret_val[] = $strExpiration.": ".$strNoExpiration;
    		$ret_val[] = '';
    		$ret_val[] = '';
    	}
    	
    	return isset($ret_val) ? $ret_val : false;
    }
    
    /**
     * Gets campaign Id and name and client Id by keyword and agency Id
     * matched by keyword and either client name or client id.
     *
     * @param $keyword  string  Keyword to look for
     * @param $agencyId int  Agency Id
     *
     * @return RecordSet
     * @access public
     */
    function getCampaignAndClientByKeyword($keyword, $agencyId = null)
    {
        $whereCampaign = is_numeric($keyword) ? " OR m.campaignid=$keyword" : '';
        $prefix = $this->getTablePrefix();

        $query = "
        SELECT
            m.campaignid AS campaignid,
            m.campaignname AS campaignname,
            m.clientid AS clientid
        FROM
            {$prefix}campaigns AS m,
            {$prefix}clients AS c
        WHERE
            (
            m.clientid=c.clientid
            AND (m.campaignname LIKE ".DBC::makeLiteral('%'.$keyword.'%')."
                $whereCampaign)
            )
        ";

        if($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaigns($listorder, $orderdirection)
    {
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                campaignid,
                clientid,
                campaignname,
                active
            FROM
                {$prefix}campaigns " .
            $this->getSqlListOrder($listorder, $orderdirection)
        ;
        
        $rsCampaigns = DBC::NewRecordSet($query);
        $aCampaigns = $rsCampaigns->getAll(array('campaignid', 'clientid', 'campaignname', 'active'));
        $aCampaigns = $this->_rekeyCampaignsArray($aCampaigns);
        return $aCampaigns;
    }

    /**
     * @param int $agency_id
     * @return array    An array of arrays, representing a list of campaigns.
     *
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection)
    {
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                m.campaignid as campaignid,
                m.clientid as clientid,
                m.campaignname as campaignname,
                m.active as active
            FROM
                {$prefix}campaigns AS m,
                {$prefix}clients AS c
            WHERE
                c.clientid=m.clientid
                AND c.agencyid=$agency_id " .
            $this->getSqlListOrder($listorder, $orderdirection)
        ;
        
        $rsCampaigns = DBC::NewRecordSet($query);
        $aCampaigns = $rsCampaigns->getAll(array('campaignid', 'clientid', 'campaignname', 'active'));
        $aCampaigns = $this->_rekeyCampaignsArray($aCampaigns);
        return $aCampaigns;
    }

    function countActiveCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." WHERE active='t'";
        return $this->oDbh->queryOne($query_active_campaigns);
    }

    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countCampaignsUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    function countActiveCampaignsUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
            ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
            " WHERE m.clientid=c.clientid".
            " AND c.agencyid=".$agency_id.
            " AND m.active='t'";
        return $this->oDbh->queryOne($query_active_campaigns);
    }

    /**
     * Converts a database result into an array keyed by campaign ID.
     * @param array $flat_campaign_data An flat array of campaign field arrays
     * @return array An array of arrays, representing a list of campaigns.
     */
    function _rekeyCampaignsArray($flat_campaign_data)
    {
        $campaigns = array();
        foreach ($flat_campaign_data as $row_campaign) {
            $campaigns[$row_campaign['campaignid']] = $row_campaign;
            $campaigns[$row_campaign['campaignid']]['expand'] = false;
            unset($campaigns[$row_campaign['campaignid']]['campaignid']);
        }
        return $campaigns;
    }
}

?>