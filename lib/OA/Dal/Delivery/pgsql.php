<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * The mysql data access layer code the delivery engine.
 *
 * @package    MaxDal
 * @subpackage Delivery
 * @author     Chris Nutting <chris.nutting@openads.org>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */

/**
 * The function to open a database connection, or return the resource if already open
 *
 * @param string $database   The name of the database config to use
 *                           (Must match the database section name in the conf file)
 * @return resource|false    The PgSQL database resource
 *                           or false on failure
 */
function OA_Dal_Delivery_connect($database = 'database') {
    // If a connection already exists, then return that
    if ($database == 'database' && isset($GLOBALS['_MAX']['ADMIN_DB_LINK']) && is_resource($GLOBALS['_MAX']['ADMIN_DB_LINK'])) {
        return $GLOBALS['_MAX']['ADMIN_DB_LINK'];
    } elseif ($database == 'rawDatabase' && isset($GLOBALS['_MAX']['RAW_DB_LINK']) && is_resource($GLOBALS['_MAX']['RAW_DB_LINK'])) {
        return $GLOBALS['_MAX']['RAW_DB_LINK'];
    }
    // No connection exists, so create one
    $conf = $GLOBALS['_MAX']['CONF'];
    if (!empty($conf[$database])) {
        $dbConf = $conf[$database];
    } else {
        $dbConf = $conf['database'];
    }
    $dbParams   = array();
    $dbParams[] = 'port='.(isset($dbConf['port']) ? $dbConf['port'] : 5432);
    $dbParams[] = !empty($dbConf['socket']) ? '' : 'host='.$dbConf['host'];
    $dbParams[] = empty($dbConf['username']) ? '' : 'user='.$dbConf['username'];
    $dbParams[] = empty($dbConf['password']) ? '' : 'password='.$dbConf['password'];
    $dbParams[] = 'dbname='.$dbConf['name'];
    if ($dbConf['persistent']) {
        $dbLink = @pg_pconnect(join(' ', $dbParams));
    } else {
        $dbLink = @pg_connect(join(' ', $dbParams));
    }
    return $dbLink;
}

/**
 * The function to pass a query to a database link
 *
 * @param string $query    The SQL query to execute
 * @param string $database The database to use for this query
 *                         (Must match the database section name in the conf file)
 * @return resource|false  The MySQL resource if the query suceeded
 *                          or false on failure
 */
function OA_Dal_Delivery_query($query, $database = 'database') {
    // Connect to the database if necessary
    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';

    if (empty($GLOBALS['_MAX'][$dbName])) {
        $GLOBALS['_MAX'][$dbName] = OA_Dal_Delivery_connect($database);
    }
    if (is_resource($GLOBALS['_MAX'][$dbName])) {
        return @pg_query($GLOBALS['_MAX'][$dbName], $query);
    } else {
        return false;
    }
}

/**
 * The function to retrieve the last-insert-id from the database
 *
 * @param string $database The name of the database config to use
 *                         (Must match the database section name in the conf file)
 * @param string $table    The name of the table we need to get the ID from
 * @param string $column   The name of the column we need to get the ID from
 * @return int|false       The last insert ID (zero if last query didn't generate an ID)
 *                         or false on failure
 * @todo Fix this!
 */
function OA_Dal_Delivery_insertId($database = 'database', $table = '', $column = '')
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $dbName = ($database == 'rawDatabase') ? 'RAW_DB_LINK' : 'ADMIN_DB_LINK';
    if (!isset($GLOBALS['_MAX'][$dbName]) || !(is_resource($GLOBALS['_MAX'][$dbName]))) {
        return false;
    }
    return pg_fetch_result(pg_query("SELECT currval('".substr("{$conf['table']['prefix']}{$conf['table'][$table]}_{$column}", 0, 59)."_seq')"), 0, 0);
}


/**
 * This function gets zone properties from the databse
 *
 * @param int $zoneid   The ID of the zone to get information about
 * @return array|false  An array containing the properties for that zone
 *                      or false on failure
 */
function OA_Dal_Delivery_getZoneInfo($zoneid) {
    $conf = $GLOBALS['_MAX']['CONF'];

    $rZoneInfo = OA_Dal_Delivery_query("
    SELECT
        z.zoneid AS zone_id,
        z.affiliateid AS publisher_id,
        z.zonename AS name,
        z.delivery AS type,
        z.description AS description,
        z.width AS width,
        z.height AS height,
        z.chain AS chain,
        z.prepend AS prepend,
        z.append AS append,
        z.appendtype AS appendtype,
        z.forceappend AS forceappend,
        z.inventory_forecast_type AS inventory_forecast_type,
        z.block AS block_zone,
        z.capping AS cap_zone,
        z.session_capping AS session_cap_zone,
        p.default_banner_url AS default_banner_url,
        p.default_banner_destination AS default_banner_dest
    FROM
        {$conf['table']['prefix']}{$conf['table']['zones']} AS z,
        {$conf['table']['prefix']}{$conf['table']['affiliates']} AS a,
        {$conf['table']['prefix']}{$conf['table']['preference']} AS p
    WHERE
        z.zoneid={$zoneid}
      AND
        z.affiliateid = a.affiliateid
      AND
        p.agencyid = a.agencyid
    ");

    if (!is_resource($rZoneInfo)) {
        return false;
    }
    $aZoneInfo = pg_fetch_assoc($rZoneInfo);

    if (empty($aZoneInfo['default_banner_url'])) {
        // Agency has no default banner, so overwrite with admin's
        $rAdminDefault = OA_Dal_Delivery_query("
        SELECT
            p.default_banner_url AS default_banner_url,
            p.default_banner_destination AS default_banner_dest
        FROM
            {$conf['table']['prefix']}{$conf['table']['preference']} AS p
        WHERE
            p.agencyid = 0
        ");
        $aAdminDefaultBanner = pg_fetch_assoc($rAdminDefault);
        $aZoneInfo['default_banner_url']  = $aAdminDefaultBanner['default_banner_url'];
        $aZoneInfo['default_banner_dest'] = $aAdminDefaultBanner['default_banner_dest'];
    }
    return ($aZoneInfo);
}

/**
 * The function to get and return the ads linked to a zone
 *
 * @param  int   $zoneid The id of the zone to get linked ads for
 * @return array|false
 *               The array containg zone information with nested arrays of linked ads
 *               or false on failure. Note that:
 *                  - Exclusive ads are in "xAds"
 *                  - Normal (paid) ads are in "ads"
 *                  - Low-priority ads are in "lAds"
 *                  - Companion ads, in addition to being in one of the above, are
 *                    also in "cAds" and "clAds"
 *                  - Exclusive and low-priority ads have had their priorities
 *                    calculated on the basis of the placement and advertisement
 *                    weight
 */
function OA_Dal_Delivery_getZoneLinkedAds($zoneid) {

    $conf = $GLOBALS['_MAX']['CONF'];
    $aRows = OA_Dal_Delivery_getZoneInfo($zoneid);

    $aRows['xAds']  = array();
    $aRows['cAds']  = array();
    $aRows['clAds'] = array();
    $aRows['ads']   = array();
    $aRows['lAds']  = array();
    $aRows['count_active'] = 0;
    $aRows['zone_companion'] = false;
    $aRows['count_active'] = 0;

    $totals = array(
        'xAds'  => 0,
        'cAds'  => 0,
        'clAds' => 0,
        'ads'   => 0,
        'lAds'  => 0
    );

    $query = "
        SELECT
            d.bannerid AS ad_id,
            d.campaignid AS placement_id,
            d.active AS active,
            d.description AS name,
            d.storagetype AS type,
            d.contenttype AS contenttype,
            d.pluginversion AS pluginversion,
            d.filename AS filename,
            d.imageurl AS imageurl,
            d.htmltemplate AS htmltemplate,
            d.htmlcache AS htmlcache,
            d.width AS width,
            d.height AS height,
            d.weight AS weight,
            d.seq AS seq,
            d.target AS target,
            d.url AS url,
            d.alt AS alt,
            d.status AS status,
            d.bannertext AS bannertext,
            d.autohtml AS autohtml,
            d.adserver AS adserver,
            d.block AS block_ad,
            d.capping AS cap_ad,
            d.session_capping AS session_cap_ad,
            d.compiledlimitation AS compiledlimitation,
            d.acl_plugins AS acl_plugins,
            d.append AS append,
            d.appendtype AS appendtype,
            d.bannertype AS bannertype,
            d.alt_filename AS alt_filename,
            d.alt_imageurl AS alt_imageurl,
            d.alt_contenttype AS alt_contenttype,
            d.parameters AS parameters,
            d.transparent AS transparent,
            az.priority AS priority,
            az.priority_factor AS priority_factor,
            az.to_be_delivered AS to_be_delivered,
            c.campaignid AS campaign_id,
            c.priority AS campaign_priority,
            c.weight AS campaign_weight,
            c.companion AS campaign_companion,
            c.block AS block_campaign,
            c.capping AS cap_campaign,
            c.session_capping AS session_cap_campaign
        FROM
            {$conf['table']['prefix']}{$conf['table']['banners']} AS d,
            {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']} AS az,
            {$conf['table']['prefix']}{$conf['table']['campaigns']} AS c
        WHERE
            az.zone_id = {$zoneid}
          AND
            d.bannerid = az.ad_id
          AND
            c.campaignid = d.campaignid
          AND
            d.active = 't'
          AND
            c.active = 't'
    ";

    $rAds = OA_Dal_Delivery_query($query);

    if (!is_resource($rAds)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    }
    while ($aAd = pg_fetch_assoc($rAds)) {
        // Is the ad Exclusive, Low, or Normal Priority?
        if ($aAd['campaign_priority'] == -1) {
            // Ad is in an exclusive placement
            $aAd['priority'] = $aAd['campaign_weight'] * $aAd['weight'];
            $aRows['xAds'][$aAd['ad_id']] = $aAd;
            $aRows['count_active']++;
            $totals['xAds'] += $aAd['priority'];
        } elseif ($aAd['campaign_priority'] == 0) {
            // Ad is in a low priority placement
            $aAd['priority'] = $aAd['campaign_weight'] * $aAd['weight'];
            $aRows['lAds'][$aAd['ad_id']] = $aAd;
            $aRows['count_active']++;
            $totals['lAds'] += $aAd['priority'];
        } else {
            // Ad is in a paid placement
            $aRows['ads'][$aAd['campaign_priority']][$aAd['ad_id']] = $aAd;
            $aRows['count_active']++;
        }
        // Also store Companion ads in additional array
        if ($aAd['campaign_companion'] == 1) {
            if ($aAd['campaign_priority'] == 0) {
                // Store a low priority companion ad
                $aRows['zone_companion'][] = $aAd['placement_id'];
                $aRows['clAds'][$aAd['ad_id']] = $aAd;
                $totals['clAds'] += $aAd['priority'];
            } else {
                // Sore a paid priority companion ad
                $aRows['zone_companion'][] = $aAd['placement_id'];
                $aRows['cAds'][$aAd['ad_id']] = $aAd;
            }

        }
    }
    // If there are paid ads, prepare array of priority totals
    // to allow delivery to do the scaling work later
    if (is_array($aRows['ads'])) {
        $totals['ads'] = _mysqlGetTotalPrioritiesByCP($aRows['ads']);
    }
    // If there are low priority ads, sort by priority
    if (is_array($aRows['lAds'])) {
        uasort($aRows['lAds'], '_mysqlSortArrayPriority');
    }
    // If there are paid companion ads, prepare array of priority totals
    // to allow delivery to do the scaling work later
    if (is_array($aRows['cAds'])) {
        $totals['cAds'] = _mysqlGetTotalPrioritiesByCP($aRows['ads']);
    }
    // If there are low priority companion ads, sort by priority
    if (is_array($aRows['clAds'])) {
        uasort($aRows['clAds'], '_mysqlSortArrayPriority');
    }
    $aRows['priority'] = $totals;
    return $aRows;
}

/**
 * The function to get and return the ads for direct selection
 *
 * @param string  $search       The search string for this banner selection
 *                              Usually 'bannerid:123' or 'campaignid:123'
 * @param string  $campaignid   The campaign ID to fecth banners from, added in 2.3.32 to allow BC with 2.0
 * @param boolean $lastpart     Are there any other search strings left
 *
 * @return array|false          The array of ads matching the search criteria
 *                              or false on failure
 */
function OA_Dal_Delivery_getLinkedAds($search, $campaignid = '', $lastpart = true) {
    $conf = $GLOBALS['_MAX']['CONF'];

    if ($campaignid > 0) {
        $precondition = " AND d.campaignid = '".$campaignid."' ";
    } else {
        $precondition = '';
    }

    $query = OA_Dal_Delivery_buildQuery($search, $lastpart, $precondition);

    $rAds = OA_Dal_Delivery_query($query);

    if (!is_resource($rAds)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    }
    while ($aRow = pg_fetch_assoc($rAds)) {
        $row['weight'] = (empty($aRow['weight'])) ? 1 : $aRow['weight'];
        $row['campaign_weight'] = (empty($aRow['campaign_weight'])) ? 1 : $aRow['campaign_weight'];
        $aRow['priority'] = $aRow['weight'] * $aRow['campaign_weight'];
        if ($aRow['priority'] > 0) {
            $aRows[] = $aRow;
        }
    }
    if (isset($aRows)) {
        uasort($aRows, '_mysqlSortArrayPriority');
    }
    $aAds = array();
    $aAds['ads'] = array();
    $aAds['priority']['ads'] = 0;
    if (isset($aRows)) {
        $aAds['ads'] = $aRows;
        foreach ($aRows as $aRow) {
            $aAds['priority']['ads'] += $aRow['priority'];
        }
    }
    return $aAds;
}

/**
 * The function to get and return a single ad
 *
 * @param  string       $ad_id     The ad id for the specified ad
 *
 * @return array|null   $ad        An array containing the ad data or null if nothing found
 */
function OA_Dal_Delivery_getAd($ad_id) {
    $conf = $GLOBALS['_MAX']['CONF'];

    $query = "
        SELECT
        d.bannerid AS ad_id,
        d.campaignid AS placement_id,
        d.active AS active,
        d.description AS name,
        d.storagetype AS type,
        d.contenttype AS contenttype,
        d.pluginversion AS pluginversion,
        d.filename AS filename,
        d.imageurl AS imageurl,
        d.htmltemplate AS htmltemplate,
        d.htmlcache AS htmlcache,
        d.width AS width,
        d.height AS height,
        d.weight AS weight,
        d.seq AS seq,
        d.target AS target,
        d.url AS url,
        d.alt AS alt,
        d.status AS status,
        d.bannertext AS bannertext,
        d.autohtml AS autohtml,
        d.adserver AS adserver,
        d.block AS block_ad,
        d.capping AS cap_ad,
        d.session_capping AS session_cap_ad,
        d.compiledlimitation AS compiledlimitation,
        d.append AS append,
        d.appendtype AS appendtype,
        d.bannertype AS bannertype,
        d.alt_filename AS alt_filename,
        d.alt_imageurl AS alt_imageurl,
        d.alt_contenttype AS alt_contenttype,
        d.parameters AS parameters,
        d.transparent AS transparent,
        c.campaignid AS campaign_id,
        c.block AS block_campaign,
        c.capping AS cap_campaign,
        c.session_capping AS session_cap_campaign
    FROM
        {$conf['table']['prefix']}{$conf['table']['banners']} AS d,
        {$conf['table']['prefix']}{$conf['table']['campaigns']} AS c
    WHERE
        d.bannerid={$ad_id}
        AND
        d.campaignid = c.campaignid
    ";
    $rAd = OA_Dal_Delivery_query($query);
    if (!is_resource($rAd)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    } else {
        return (pg_fetch_assoc($rAd));
    }
}

/**
 * The function to get delivery limitations for a channel
 *
 * @param  int       $channelid    The channelid for the specified channel
 *
 * @return array     $limitations  An array with the acls_plugins, and compiledlimitation
 */
function OA_Dal_Delivery_getChannelLimitations($channelid) {
    $conf = $GLOBALS['_MAX']['CONF'];

    $rLimitation = OA_Dal_Delivery_query("
    SELECT
            acl_plugins,compiledlimitation
    FROM
            {$conf['table']['prefix']}{$conf['table']['channel']}
    WHERE
            channelid={$channelid}");
    if (!is_resource($rLimitation)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    }
    $limitations = pg_fetch_assoc($rLimitation);
    return $limitations;
}

/**
 * This function gets a creative stored as a BLOB from the database
 *
 * @param string $filename  The filename of the creative as stored in the database
 * @return array            An array with the last-modified timestamp, and the binary contents
 */
function OA_Dal_Delivery_getCreative($filename)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $rCreative = OA_Dal_Delivery_query("
        SELECT
            contents,
            UNIX_TIMESTAMP(t_stamp) AS t_stamp
        FROM
            {$conf['table']['prefix']}{$conf['table']['images']}
        WHERE
            filename = '{$filename}'
    ");
    if (!is_resource($rCreative)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    } else {
        $aResult = pg_fetch_assoc($rCreative);
        $aResult['contents'] = pg_unescape_bytea($aResult['contents']);
        return $aResult;
    }
}

/**
 * This function gets a tracker and it's properties from the database
 *
 * @param int $trackerid    The ID of the tracker to get
 * @return array            The array of tracker properties
 */
function OA_Dal_Delivery_getTracker($trackerid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $rTracker = OA_Dal_Delivery_query("
        SELECT
            t.clientid AS advertiser_id,
            t.trackerid AS tracker_id,
            t.trackername AS name,
            t.variablemethod AS variablemethod,
            t.description AS description,
            t.viewwindow AS viewwindow,
            t.clickwindow AS clickwindow,
            t.blockwindow AS blockwindow,
            t.appendcode AS appendcode
        FROM
            {$conf['table']['prefix']}{$conf['table']['trackers']} AS t
        WHERE
            t.trackerid={$trackerid}
    ");
    if (!is_resource($rTracker)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    } else {
        return (pg_fetch_assoc($rTracker));
    }
}

/**
 * This function gets all variables linked to a tracker
 *
 * @param int $trackerid    The ID of the tracker
 * @return array            An array indexed by variable_id of the variables linked to this tracker
 */
function OA_Dal_Delivery_getTrackerVariables($trackerid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $rVariables = OA_Dal_Delivery_query("
        SELECT
            v.variableid AS variable_id,
            v.trackerid AS tracker_id,
            v.name AS name,
            v.datatype AS type,
            v.variablecode AS variablecode
        FROM
            {$conf['table']['prefix']}{$conf['table']['variables']} AS v
        WHERE
            v.trackerid={$trackerid}
    ");
    if (!is_resource($rVariables)) {
        if (defined('OA_DELIVERY_CACHE_FUNCTION_ERROR')) {
            return OA_DELIVERY_CACHE_FUNCTION_ERROR;
        } else {
            return null;
        }
    } else {
        $output = array();
        while ($aRow = pg_fetch_assoc($rVariables)) {
            $output[$aRow['variable_id']] = $aRow;
        }
        return $output;
    }
}

/**
 * A function to insert ad requests, ad impressions, ad clicks
 * and tracker clicks into the raw tables. Does NOT work with
 * tracker impressions.
 *
 * @param string  $table        The raw table name to insert into.
 * @param string  $viewerId     The viewer ID.
 * @param integer $adId         The advertisement ID.
 * @param integer $creativeId   The creative ID (currently unused).
 * @param integer $zoneId       The zone ID.
 * @param array   $geotargeting An array holding the viewer's geotargeting info.
 * @param array   $zoneInfo     An array to store information about the URL
 *                              the viewer used to access the page containing the zone.
 * @param array   $userAgentInfo An array to store information about the
 *                               viewer's web browser and operating system.
 * @param integer $maxHttps     An integer to store if the call to Openads was
 *                              performed using HTTPS or not.
 */
function OA_Dal_Delivery_logAction($table, $viewerId, $adId, $creativeId, $zoneId,
                        $geotargeting, $zoneInfo, $userAgentInfo, $maxHttps)
{
    // Whenever we assign a *new* viewer ID (or no viewerId was found),
    // we should log the cookieless ID
    if ((empty($viewerId) || !empty($GLOBALS['_MAX']['COOKIE']['newViewerId']))) {
        $log_viewerId = MAX_cookieGetCookielessViewerID();
    } else {
        $log_viewerId = $viewerId;
    }
    // Log the raw data
    $dateFunc = !empty($conf['logging']['logInUTC']) ? 'gmdate' : 'date';
    $query = "
        INSERT INTO
            $table
            (
                viewer_id,
                viewer_session_id,
                date_time,
                ad_id,
                creative_id,
                zone_id,";
    if (isset($_GET['source'])) {
        $query .= "
                channel,";
    }
    if (isset($zoneInfo['channel_ids'])) {
        $query .= "
                channel_ids,";
    }
    $query .= "
                language,
                ip_address,
                host_name,";
    if (isset($geotargeting['country_code'])) {
        $query .= "
                country,";
    }
    if (isset($zoneInfo['scheme'])) {
        $query .= "
                https,";
    }
    if (isset($zoneInfo['host'])) {
        $query .= "
                domain,";
    }
    if (isset($zoneInfo['path'])) {
        $query .= "
                page,";
    }
    if (isset($zoneInfo['query'])) {
        $query .= "
                query,";
    }
    if (isset($_GET['referer'])) {
        $query .= "
                referer,";
    }
    $query .= "
                search_term,
                user_agent,";
    if (isset($userAgentInfo['os'])) {
        $query .= "
                os,";
    }
    if (isset($userAgentInfo['browser'])) {
        $query .= "
                browser,";
    }
    $query .= "
                max_https,";
    if (isset($geotargeting['geo_region'])) {
        $query .= "
                geo_region,";
    }
    if (isset($geotargeting['geo_city'])) {
        $query .= "
                geo_city,";
    }
    if (isset($geotargeting['geo_postal_code'])) {
        $query .= "
                geo_postal_code,";
    }
    if (isset($geotargeting['geo_latitude'])) {
        $query .= "
                geo_latitude,";
    }
    if (isset($geotargeting['geo_longitude'])) {
        $query .= "
                geo_longitude,";
    }
    if (isset($geotargeting['geo_dma_code'])) {
        $query .= "
                geo_dma_code,";
    }
    if (isset($geotargeting['geo_area_code'])) {
        $query .= "
                geo_area_code,";
    }
    if (isset($geotargeting['geo_organisation'])) {
        $query .= "
                geo_organisation,";
    }
    if (isset($geotargeting['geo_netspeed'])) {
        $query .= "
                geo_netspeed,";
    }
    if (isset($geotargeting['geo_continent'])) {
        $query .= "
                geo_continent,";
    }
    // Strip end comma!
    $query = substr_replace($query, '', strlen($query) - 1);
    // Strip end comma!
    $query = substr_replace($query, '', strlen($query) - 1);
    $query .= "
            )
        VALUES
            (
                '$log_viewerId',
                '',
                '".$dateFunc('Y-m-d H:i:s')."',
                '$adId',
                '$creativeId',
                '$zoneId',";
    if (isset($_GET['source'])) {
        $query .= "
                '".MAX_commonDecrypt($_GET['source'])."',";
    }
    if (isset($zoneInfo['channel_ids'])) {
        $query .= "
                '{$zoneInfo['channel_ids']}',";
    }
    $query .= "
                '".substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 32)."',
                '{$_SERVER['REMOTE_ADDR']}',
                '{$_SERVER['REMOTE_HOST']}',";
    if (isset($geotargeting['country_code'])) {
        $query .= "
                '{$geotargeting['country_code']}',";
    }
    if (isset($zoneInfo['scheme'])) {
        $query .= "
                '{$zoneInfo['scheme']}',";
    }
    if (isset($zoneInfo['host'])) {
        $query .= "
                '{$zoneInfo['host']}',";
    }
    if (isset($zoneInfo['path'])) {
        $query .= "
                '{$zoneInfo['path']}',";
    }
    if (isset($zoneInfo['query'])) {
        $query .= "
                '{$zoneInfo['query']}',";
    }
    if (isset($_GET['referer'])) {
        $query .= "
                '{$_GET['referer']}',";
    }
    $query .= "
                '',
                '".substr($_SERVER['HTTP_USER_AGENT'], 0, 255)."',";
    if (isset($userAgentInfo['os'])) {
        $query .= "
                '{$userAgentInfo['os']}',";
    }
    if (isset($userAgentInfo['browser'])) {
        $query .= "
                '{$userAgentInfo['browser']}',";
    }
    $query .= "
                '$maxHttps',";
    if (isset($geotargeting['region'])) {
        $query .= "
                '{$geotargeting['region']}',";
    }
    if (isset($geotargeting['city'])) {
        $query .= "
                '{$geotargeting['city']}',";
    }
    if (isset($geotargeting['postal_code'])) {
        $query .= "
                '{$geotargeting['postal_code']}',";
    }
    if (isset($geotargeting['latitude'])) {
        $query .= "
                '{$geotargeting['latitude']}',";
    }
    if (isset($geotargeting['longitude'])) {
        $query .= "
                '{$geotargeting['longitude']}',";
    }
    if (isset($geotargeting['dma_code'])) {
        $query .= "
                '{$geotargeting['dma_code']}',";
    }
    if (isset($geotargeting['area_code'])) {
        $query .= "
                '{$geotargeting['area_code']}',";
    }
    if (isset($geotargeting['organisation'])) {
        $query .= "
                '{$geotargeting['organisation']}',";
    }
    if (isset($geotargeting['netspeed'])) {
        $query .= "
                '{$geotargeting['netspeed']}',";
    }
    if (isset($geotargeting['continent'])) {
        $query .= "
                '{$geotargeting['continent']}',";
    }
    // Strip end comma!
    $query = substr_replace($query, '', strlen($query) - 1);
    $query .= "
            )";
    $result = OA_Dal_Delivery_query(
        $query,
        'rawDatabase'
    );
    return $result;
}

/**
 * A function to insert tracker impressions into the raw table.
 *
 * @param string  $table        The raw table name to insert into.
 * @param string  $viewerId     The viewer ID.
 * @param integer $adId         The advertisement ID.
 * @param integer $creativeId   The creative ID (currently unused).
 * @param integer $zoneId       The zone ID.
 * @param array   $geotargeting An array holding the viewer's geotargeting info.
 * @param array   $zoneInfo     An array to store information about the URL
 *                              the viewer used to access the page containing the zone.
 * @param array   $userAgentInfo An array to store information about the
 *                               viewer's web browser and operating system.
 * @param integer $maxHttps     An integer to store if the call to Openads was
 *                              performed using HTTPS or not.

 * @return int|false            Returns the insert ID for this record or false on failure
 */
function OA_Dal_Delivery_logTracker($table, $viewerId, $trackerId, $serverRawIp,
                                     $geotargeting, $zoneInfo, $userAgentInfo, $maxHttps)
{
    // Whenever we assign a *new* viewer ID (or no viewerId was found),
    // we should log the cookieless ID
    if ((empty($viewerId) || !empty($GLOBALS['_MAX']['COOKIE']['newViewerId']))) {
        $log_viewerId = MAX_cookieGetCookielessViewerID();
    } else {
        $log_viewerId = $viewerId;
    }
    // Log the raw data
    $dateFunc = !empty($conf['logging']['logInUTC']) ? 'gmdate' : 'date';
    $res = OA_Dal_Delivery_query("
        INSERT INTO
            {$table}
        (
            server_raw_ip,
            viewer_id,
            viewer_session_id,
            date_time,
            tracker_id,
            channel,
            channel_ids,
            language,
            ip_address,
            host_name,
            country,
            https,
            domain,
            page,
            query,
            referer,
            search_term,
            user_agent,
            os,
            browser,
            max_https,
            geo_region,
            geo_city,
            geo_postal_code,
            geo_latitude,
            geo_longitude,
            geo_dma_code,
            geo_area_code,
            geo_organisation,
            geo_netspeed,
            geo_continent
        )
    VALUES
        (
            '$serverRawIp',
            '$log_viewerId',
            '',
            '".$dateFunc('Y-m-d H:i:s')."',
            '$trackerId',
            '".MAX_commonDecrypt($_GET['source'])."',
            '{$zoneInfo['channel_ids']}',
            '".substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 32)."',
            '{$_SERVER['REMOTE_ADDR']}',
            '{$_SERVER['REMOTE_HOST']}',
            '{$geotargeting['country_code']}',
            '".intval($zoneInfo['scheme'])."',
            '{$zoneInfo['host']}',
            '{$zoneInfo['path']}',
            '{$zoneInfo['query']}',
            '{$_GET['referer']}',
            '',
            '".substr($_SERVER['HTTP_USER_AGENT'], 0, 255)."',
            '{$userAgentInfo['os']}',
            '{$userAgentInfo['browser']}',
            '".intval($maxHttps)."',
            '{$geotargeting['region']}',
            '{$geotargeting['city']}',
            '{$geotargeting['postal_code']}',
            '".floatval($geotargeting['latitude'])."',
            '".floatval($geotargeting['longitude'])."',
            '{$geotargeting['dma_code']}',
            '{$geotargeting['area_code']}',
            '{$geotargeting['organisation']}',
            '{$geotargeting['netspeed']}',
            '{$geotargeting['continent']}'
    )", 'rawDatabase');
    return $res ? OA_Dal_Delivery_insertId('rawDatabase', $table, preg_replace('/^data/', 'server', $table).'_id') : false;
}

/**
 * This function logs the variable data passed in to a tracker impression
 *
 * @param array  $variables                     An array of the variable name=value data to be logged
 * @param int    $serverRawTrackerImpressionId  The associated tracker-impression ID for these values
 * @param string $serverRawIp                   The IP address of the raw database that logged the
 *                                              initial tracker-impression
 * @return bool True on success
 */
function OA_Dal_Delivery_logVariableValues($variables, $serverRawTrackerImpressionId, $serverRawIp)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $dateFunc = !empty($conf['logging']['logInUTC']) ? 'gmdate' : 'date';
    $aRows = array();
    foreach ($variables as $variable) {
        $aRows[] = "(
                        '{$variable['variable_id']}',
                        '{$serverRawTrackerImpressionId}',
                        '{$serverRawIp}',
                        '".$dateFunc('Y-m-d H:i:s')."',
                        '{$variable['value']}'
                    )";
    }
    if (empty($aRows)) {
        return;
    }
    foreach ($aRows as $sValues) {
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}
                (
                    tracker_variable_id,
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    date_time,
                    value
                )
            VALUES " . $sValues;

        $res = OA_Dal_Delivery_query($query, 'rawDatabase');

        if (!$res) {
            return false;
        }
    }

    return true;
}

/**
 * A function to generate a direct selection query preserving 2.0 backwards compatibility
 *
 * @param string  $part         The what parameter part to build the query
 * @param boolean $lastpart     True if there are no other parts to work on
 * @param string  $precondition Any SQL preconditions to apply
 * @return string The generated query
 */
function OA_Dal_Delivery_buildQuery($part, $lastpart, $precondition)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $aColumns = array(
        'd.bannerid AS ad_id',
        'd.campaignid AS placement_id',
        'd.active AS active',
        'd.description AS name',
        'd.storagetype AS type',
        'd.contenttype AS contenttype',
        'd.pluginversion AS pluginversion',
        'd.filename AS filename',
        'd.imageurl AS imageurl',
        'd.htmltemplate AS htmltemplate',
        'd.htmlcache AS htmlcache',
        'd.width AS width',
        'd.height AS height',
        'd.weight AS weight',
        'd.seq AS seq',
        'd.target AS target',
        'd.url AS url',
        'd.alt AS alt',
        'd.status AS status',
        'd.bannertext AS bannertext',
        'd.autohtml AS autohtml',
        'd.adserver AS adserver',
        'd.block AS block_ad',
        'd.capping AS cap_ad',
        'd.session_capping AS session_cap_ad',
        'd.compiledlimitation AS compiledlimitation',
        'd.append AS append',
        'd.appendtype AS appendtype',
        'd.bannertype AS bannertype',
        'd.alt_filename AS alt_filename',
        'd.alt_imageurl AS alt_imageurl',
        'd.alt_contenttype AS alt_contenttype',
        'az.priority AS priority',
        'm.campaignid AS campaign_id',
        'm.weight AS campaign_weight',
        'm.block AS block_campaign',
        'm.capping AS cap_campaign',
        'm.session_capping AS session_cap_campaign'
    );

    $aTables = array(
        $conf['table']['prefix'].$conf['table']['banners'] . ' AS d',
        $conf['table']['prefix'].$conf['table']['campaigns'] . ' AS m',
        $conf['table']['prefix'].$conf['table']['ad_zone_assoc'] . ' AS az'
    );

    $select = "
        d.bannerid=az.ad_id
      AND az.zone_id=0
      AND d.campaignid=m.campaignid
      AND m.active='t'
      AND d.active='t'";

    // Add preconditions to query
    if ($precondition != '')
        $select .= " $precondition ";


    // Other
    if ($part != '')
    {
        $conditions = '';
        $onlykeywords = true;

        $part_array = explode(',', $part);
        for ($k=0; $k < count($part_array); $k++)
        {
            // Process switches
            if (substr($part_array[$k], 0, 1) == '+' || substr($part_array[$k], 0, 1) == '_')
            {
                $operator = 'AND';
                $part_array[$k] = substr($part_array[$k], 1);
            }
            elseif (substr($part_array[$k], 0, 1) == '-')
            {
                $operator = 'NOT';
                $part_array[$k] = substr($part_array[$k], 1);
            }
            else
                $operator = 'OR';


            //  Test statements
            if($part_array[$k] != '' && $part_array[$k] != ' ')
            {
                // Banner dimensions, updated to support 2.3-only size keyword
                if(preg_match('#^(?:size:)?([0-9]+x[0-9]+)$#', $part_array[$k], $m))
                {
                    list($width, $height) = explode('x', $m[1]);

                    if ($operator == 'OR')
                        $conditions .= "OR (d.width = $width AND d.height = $height) ";
                    elseif ($operator == 'AND')
                        $conditions .= "AND (d.width = $width AND d.height = $height) ";
                    else
                        $conditions .= "AND (d.width != $width OR d.height != $height) ";

                    $onlykeywords = false;
                }

                // Banner Width
                elseif (substr($part_array[$k],0,6) == 'width:')
                {
                    $part_array[$k] = substr($part_array[$k], 6);

                    if ($part_array[$k] != '' && $part_array[$k] != ' ')
                    {
                        if (is_int(strpos($part_array[$k], '-')))
                        {
                            // Width range
                            list($min, $max) = explode('-', $part_array[$k]);

                            // Only upper limit, set lower limit to make sure not text ads are delivered
                            if ($min == '')
                                $min = 1;

                            // Only lower limit
                            if ($max == '')
                            {
                                if ($operator == 'OR')
                                    $conditions .= "OR d.width >= '".trim($min)."' ";
                                elseif ($operator == 'AND')
                                    $conditions .= "AND d.width >= '".trim($min)."' ";
                                else
                                    $conditions .= "AND d.width < '".trim($min)."' ";
                            }

                            // Both lower and upper limit
                            if ($max != '')
                            {
                                if ($operator == 'OR')
                                    $conditions .= "OR (d.width >= '".trim($min)."' AND d.width <= '".trim($max)."') ";
                                elseif ($operator == 'AND')
                                    $conditions .= "AND (d.width >= '".trim($min)."' AND d.width <= '".trim($max)."') ";
                                else
                                    $conditions .= "AND (d.width < '".trim($min)."' OR d.width > '".trim($max)."') ";
                            }
                        }
                        else
                        {
                            // Single value

                            if ($operator == 'OR')
                                $conditions .= "OR d.width = '".trim($part_array[$k])."' ";
                            elseif ($operator == 'AND')
                                $conditions .= "AND d.width = '".trim($part_array[$k])."' ";
                            else
                                $conditions .= "AND d.width != '".trim($part_array[$k])."' ";
                        }
                    }

                    $onlykeywords = false;
                }

                // Banner Height
                elseif (substr($part_array[$k],0,7) == 'height:')
                {
                    $part_array[$k] = substr($part_array[$k], 7);
                    if ($part_array[$k] != '' && $part_array[$k] != ' ')
                    {
                        if (is_int(strpos($part_array[$k], '-')))
                        {
                            // Height range
                            list($min, $max) = explode('-', $part_array[$k]);

                            // Only upper limit, set lower limit to make sure not text ads are delivered
                            if ($min == '')
                                $min = 1;

                            // Only lower limit
                            if ($max == '')
                            {
                                if ($operator == 'OR')
                                    $conditions .= "OR d.height >= '".trim($min)."' ";
                                elseif ($operator == 'AND')
                                    $conditions .= "AND d.height >= '".trim($min)."' ";
                                else
                                    $conditions .= "AND d.height < '".trim($min)."' ";
                            }

                            // Both lower and upper limit
                            if ($max != '')
                            {
                                if ($operator == 'OR')
                                    $conditions .= "OR (d.height >= '".trim($min)."' AND d.height <= '".trim($max)."') ";
                                elseif ($operator == 'AND')
                                    $conditions .= "AND (d.height >= '".trim($min)."' AND d.height <= '".trim($max)."') ";
                                else
                                    $conditions .= "AND (d.height < '".trim($min)."' OR d.height > '".trim($max)."') ";
                            }
                        }
                        else
                        {
                            // Single value

                            if ($operator == 'OR')
                                $conditions .= "OR d.height = '".trim($part_array[$k])."' ";
                            elseif ($operator == 'AND')
                                $conditions .= "AND d.height = '".trim($part_array[$k])."' ";
                            else
                                $conditions .= "AND d.height != '".trim($part_array[$k])."' ";
                        }
                    }

                    $onlykeywords = false;
                }

                // Banner ID, updated to support 2.3-only adid or ad_id
                elseif (preg_match('#^(?:(?:bannerid|adid|ad_id):)?([0-9]+)$#', $part_array[$k], $m))
                {
                    $part_array[$k] = $m[1];

                    if ($part_array[$k])
                    {
                        if ($operator == 'OR')
                            $conditions .= "OR d.bannerid='".$part_array[$k]."' ";
                        elseif ($operator == 'AND')
                            $conditions .= "AND d.bannerid='".$part_array[$k]."' ";
                        else
                            $conditions .= "AND d.bannerid!='".$part_array[$k]."' ";
                    }

                    $onlykeywords = false;
                }

                // Campaign ID
                elseif (preg_match('#^(?:(?:clientid|campaignid|placementid|placement_id):)?([0-9]+)$#', $part_array[$k], $m))
                {
                    $part_array[$k] = $m[1];

                    if ($part_array[$k])
                    {
                        if ($operator == 'OR')
                            $conditions .= "OR d.campaignid='".trim($part_array[$k])."' ";
                        elseif ($operator == 'AND')
                            $conditions .= "AND d.campaignid='".trim($part_array[$k])."' ";
                        else
                            $conditions .= "AND d.campaignid!='".trim($part_array[$k])."' ";
                    }

                    $onlykeywords = false;
                }

                // Format
                elseif (substr($part_array[$k], 0, 7) == 'format:')
                {
                    $part_array[$k] = substr($part_array[$k], 7);
                    if($part_array[$k] != '' && $part_array[$k] != ' ')
                    {
                        if ($operator == 'OR')
                            $conditions .= "OR d.contenttype='".trim($part_array[$k])."' ";
                        elseif ($operator == 'AND')
                            $conditions .= "AND d.contenttype='".trim($part_array[$k])."' ";
                        else
                            $conditions .= "AND d.contenttype!='".trim($part_array[$k])."' ";
                    }

                    $onlykeywords = false;
                }

                // HTML
                elseif($part_array[$k] == 'html')
                {
                    if ($operator == 'OR')
                        $conditions .= "OR d.storagetype='html' ";
                    elseif ($operator == 'AND')
                        $conditions .= "AND d.storagetype='html' ";
                    else
                        $conditions .= "AND d.storagetype!='html' ";

                    $onlykeywords = false;
                }

                // TextAd
                elseif($part_array[$k] == 'textad')
                {
                    if ($operator == 'OR')
                        $conditions .= "OR d.storagetype='txt' ";
                    elseif ($operator == 'AND')
                        $conditions .= "AND d.storagetype='txt' ";
                    else
                        $conditions .= "AND d.storagetype!='txt' ";

                    $onlykeywords = false;
                }

                // Categories
                elseif (substr($part_array[$k], 0, 4) == 'cat:')
                {
                    $part_array[$k] = substr($part_array[$k], 4);
                    if($part_array[$k] != '' && $part_array[$k] != ' ')
                    {
                        $aTables[] = $conf['table']['prefix'].$conf['table']['ad_category_assoc'] . ' AS ac';
                        $aTables[] = $conf['table']['prefix'].$conf['table']['category'] . ' AS cat';

                        if ($operator == 'OR')
                            $conditions .= "OR d.bannerid=ac.ad_id AND ac.category_id=cat.category_id ";
                        elseif ($operator == 'AND')
                            $conditions .= "AND d.bannerid=ac.ad_id AND ac.category_id=cat.category_id ";
                        else
                            $conditions .= "AND d.bannerid=ac.ad_id AND ac.category_id=cat.category_id ";
                    }
                }

                // Keywords
                else
                {
                    if ($operator == 'OR')
                        $conditions .= "OR LOWER(' ' || d.keyword || ' ') LIKE LOWER('% $part_array[$k] %') ";
                    elseif ($operator == 'AND')
                        $conditions .= "AND LOWER(' ' || d.keyword || ' ') LIKE LOWER('% $part_array[$k] %') ";
                    else
                        $conditions .= "AND LOWER(' ' || d.keyword || ' ') LIKE LOWER('% $part_array[$k] %') ";
                }
            }
        }

        // Strip first AND or OR from $conditions
        $conditions = strstr($conditions, ' ');

        // Add global keyword
        if ($lastpart == true && $onlykeywords == true)
            $conditions .= "OR LOWER(' ' || d.keyword || ' ') LIKE '% global %' ";

        // Add conditions to select
        if ($conditions != '') $select .= ' AND ('.$conditions.') ';
    }

    $columns = implode(",\n    ", $aColumns);
    $tables = implode(",\n    ", $aTables);

    $query = "SELECT\n    " . $columns . "\nFROM\n    " . $tables . "\nWHERE " . $select;

    return $query;
}


/**
 * A private callback function for the uasort function
 *
 * @param  string   $a      First parameter
 * @param  string   $b      Second parameter
 *
 * @return boolean  Compare result
 */
function _mysqlSortArrayPriority($a, $b)
{
    $compare = ($a['priority'] > $b['priority']) ? -1 : 1;
    return $compare;
}

?>
