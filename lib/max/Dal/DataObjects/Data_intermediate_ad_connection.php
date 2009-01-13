<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

/**
 * Table Definition for data_intermediate_ad_connection
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad_connection extends DB_DataObjectCommon
{
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_intermediate_ad_connection';    // table name
    public $data_intermediate_ad_connection_id;    // BIGINT(20) => openads_bigint => 129 
    public $server_raw_ip;                   // VARCHAR(16) => openads_varchar => 130 
    public $server_raw_tracker_impression_id;    // BIGINT(20) => openads_bigint => 129 
    public $viewer_id;                       // VARCHAR(32) => openads_varchar => 2 
    public $viewer_session_id;               // VARCHAR(32) => openads_varchar => 2 
    public $tracker_date_time;               // DATETIME() => openads_datetime => 142 
    public $connection_date_time;            // DATETIME() => openads_datetime => 14 
    public $tracker_id;                      // INT(10) => openads_int => 129 
    public $ad_id;                           // INT(10) => openads_int => 129 
    public $creative_id;                     // INT(10) => openads_int => 129 
    public $zone_id;                         // INT(10) => openads_int => 129 
    public $tracker_channel;                 // VARCHAR(255) => openads_varchar => 2 
    public $connection_channel;              // VARCHAR(255) => openads_varchar => 2 
    public $tracker_channel_ids;             // VARCHAR(64) => openads_varchar => 2 
    public $connection_channel_ids;          // VARCHAR(64) => openads_varchar => 2 
    public $tracker_language;                // VARCHAR(13) => openads_varchar => 2 
    public $connection_language;             // VARCHAR(13) => openads_varchar => 2 
    public $tracker_ip_address;              // VARCHAR(16) => openads_varchar => 2 
    public $connection_ip_address;           // VARCHAR(16) => openads_varchar => 2 
    public $tracker_host_name;               // VARCHAR(255) => openads_varchar => 2 
    public $connection_host_name;            // VARCHAR(255) => openads_varchar => 2 
    public $tracker_country;                 // CHAR(2) => openads_char => 2 
    public $connection_country;              // CHAR(2) => openads_char => 2 
    public $tracker_https;                   // INT(10) => openads_int => 1 
    public $connection_https;                // INT(10) => openads_int => 1 
    public $tracker_domain;                  // VARCHAR(255) => openads_varchar => 2 
    public $connection_domain;               // VARCHAR(255) => openads_varchar => 2 
    public $tracker_page;                    // VARCHAR(255) => openads_varchar => 2 
    public $connection_page;                 // VARCHAR(255) => openads_varchar => 2 
    public $tracker_query;                   // VARCHAR(255) => openads_varchar => 2 
    public $connection_query;                // VARCHAR(255) => openads_varchar => 2 
    public $tracker_referer;                 // VARCHAR(255) => openads_varchar => 2 
    public $connection_referer;              // VARCHAR(255) => openads_varchar => 2 
    public $tracker_search_term;             // VARCHAR(255) => openads_varchar => 2 
    public $connection_search_term;          // VARCHAR(255) => openads_varchar => 2 
    public $tracker_user_agent;              // VARCHAR(255) => openads_varchar => 2 
    public $connection_user_agent;           // VARCHAR(255) => openads_varchar => 2 
    public $tracker_os;                      // VARCHAR(32) => openads_varchar => 2 
    public $connection_os;                   // VARCHAR(32) => openads_varchar => 2 
    public $tracker_browser;                 // VARCHAR(32) => openads_varchar => 2 
    public $connection_browser;              // VARCHAR(32) => openads_varchar => 2 
    public $connection_action;               // INT(10) => openads_int => 1 
    public $connection_window;               // INT(10) => openads_int => 1 
    public $connection_status;               // INT(10) => openads_int => 129 
    public $inside_window;                   // TINYINT(1) => openads_tinyint => 145 
    public $comments;                        // TEXT() => openads_text => 34 
    public $updated;                         // DATETIME() => openads_datetime => 142 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_intermediate_ad_connection',$k,$v); }

    var $defaultValues = array(
                'server_raw_ip' => '',
                'tracker_date_time' => '%NO_DATE_TIME%',
                'connection_status' => 4,
                'inside_window' => 0,
                'updated' => '%DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>