<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

function Plugins_deliveryLog_oxLogConversion_logConversion_Delivery_logConversion()
{
    $data = $GLOBALS['_MAX']['deliveryData'];
    $aQuery = array(
        'server_ip'   => $data['server_ip'],
        'tracker_id' => $data['tracker_id'],
        'date_time'     => $data['interval_start'],
        'action_date_time'     => $data['interval_start'],
        'creative_id'     => $data['creative_id'], // @todo - take it from cookie?
        'zone_id'     => $data['zone_id'], // @todo - take it from cookie?
        'ip_address'     => $data['ip_address'],
    );
    return OX_bucket_updateTable('data_bkt_c', $aQuery);
}

/**
 * A function to insert tracker impressions into the raw table.
 *
 * @param string  $table         The raw table name to insert into.
 * @param string  $viewerId      The viewer ID.
 * @param integer $adId          The advertisement ID.
 * @param integer $creativeId    The creative ID (currently unused).
 * @param integer $zoneId        The zone ID.
 * @param array   $aGeotargeting An array holding the viewer's geotargeting info.
 * @param array   $zoneInfo      An array to store information about the URL
 *                               the viewer used to access the page containing the zone.
 * @param array   $userAgentInfo An array to store information about the
 *                               viewer's web browser and operating system.
 * @param integer $maxHttps      An integer to store if the call to OpenX was
 *                               performed using HTTPS or not.
 *
 * @return int|false             Returns the insert ID for this record or false on failure
 */
function Plugins_deliveryLog_oxLogConversion_logConversion_Delivery_logConversion_mysql($aQuery)
{
    // Whenever we assign a *new* viewer ID (or no viewerId was found),
    // we should log the cookieless ID
    if ((empty($viewerId) || !empty($GLOBALS['_MAX']['COOKIE']['newViewerId']))) {
        $log_viewerId = MAX_cookieGetCookielessViewerID();
    } else {
        $log_viewerId = str_replace('-', '', $viewerId);
    }
    $source = isset($_GET['source']) ? $_GET['source'] : '';
    $referer = isset($_GET['referer']) ? $_GET['referer'] : '';
    $httpUserAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $httpLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
    // Ensure that all geotargeting data is correctly escaped
    $aGeotargeting = array_map('mysql_escape_string', $aGeotargeting);
    // Log the raw data
    OA_Dal_Delivery_query("
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
            '".gmdate('Y-m-d H:i:s')."',
            '$trackerId',
            '".mysql_escape_string(MAX_commonDecrypt($source))."',
            '{$zoneInfo['channel_ids']}',
            '".mysql_escape_string(substr($httpLanguage, 0, 32))."',
            '".mysql_escape_string($_SERVER['REMOTE_ADDR'])."',
            '".mysql_escape_string($_SERVER['REMOTE_HOST'])."',
            '{$aGeotargeting['country_code']}',
            '".intval($zoneInfo['scheme'])."',
            '{$zoneInfo['host']}',
            '{$zoneInfo['path']}',
            '{$zoneInfo['query']}',
            '{$referer}',
            '',
            '".mysql_escape_string(substr($httpUserAgent, 0, 255))."',
            '{$userAgentInfo['os']}',
            '{$userAgentInfo['browser']}',
            '".intval($maxHttps)."',
            '{$aGeotargeting['region']}',
            '{$aGeotargeting['city']}',
            '{$aGeotargeting['postal_code']}',
            '".floatval($aGeotargeting['latitude'])."',
            '".floatval($aGeotargeting['longitude'])."',
            '{$aGeotargeting['dma_code']}',
            '{$aGeotargeting['area_code']}',
            '{$aGeotargeting['organisation']}',
            '{$aGeotargeting['netspeed']}',
            '{$aGeotargeting['continent']}'
    )", 'rawDatabase');
    return OA_Dal_Delivery_insertId('rawDatabase');
}

?>