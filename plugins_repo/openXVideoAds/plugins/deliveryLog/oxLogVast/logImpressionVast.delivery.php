<?php

/*    
 *    Copyright (c) 2009 Bouncing Minds - Option 3 Ventures Limited
 *
 *    This file is part of the Regions plug-in for Flowplayer.
 *
 *    The Regions plug-in is free software: you can redistribute it 
 *    and/or modify it under the terms of the GNU General Public License 
 *    as published by the Free Software Foundation, either version 3 of 
 *    the License, or (at your option) any later version.
 *
 *    The Regions plug-in is distributed in the hope that it will be 
 *    useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with the plug-in.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @package    Plugin
 * @subpackage logVastEvent
 * @author     Paul Birnie <paul.birnie@bouncingminds.com>
 */


/* 
 * We have to call this file directly via the FC. 
 * using something like: 
 * 
 *  http://dev.hccorp.co.uk/openx/www/delivery_dev/fc.php?script=deliveryLog:logVastEvent:logVastEvent&banner_id=7&zone_id=2&source=&vast_event=start
 * 
 */

 $aVastEventStrToIdMap = array(
     'start' => 1,
     'midpoint' => 2,
     'firstquartile' => 3,
     'thirdquartile' => 4,
     'complete' => 5,
     'mute' => 6,
     'replay' => 7,
     'fullscreen' => 8,
     'stop' => 9,
 );

function getVastEventIdFromVastEventStr($eventIdStr){

    global $aVastEventStrToIdMap;
    
    $vastEventId = 0; // Unknown event
    
    if ( isset($aVastEventStrToIdMap[$eventIdStr]) ){
    
        $vastEventId = $aVastEventStrToIdMap[$eventIdStr];
    }
    
    return $vastEventId;
}

function getTimeNow(){
    
    if (empty($GLOBALS['_MAX']['NOW'])) {
        $GLOBALS['_MAX']['NOW'] = time();
    }
    
    $time = $GLOBALS['_MAX']['NOW'];
    
    return $time;
}

/* 
 * Raw logging of vast events not currently supported
 * 
function logRawVastDataEvent($aQuery){

    // Initiate the connection to the database (before using mysql_real_escape_string)
    OA_Dal_Delivery_connect('rawDatabase');

    $table = $GLOBALS['_MAX']['CONF']['table']['prefix'] . 'data_raw_vast_event';

    $time = $GLOBALS['_MAX']['NOW'];

    $aFields = array(
        //  'server_ip'        => $serverRawIp,
        //  'tracker_id'       => $trackerId,
        'viewer_id'        => $aQuery['viewer_id'],
        'viewer_session_id'=> $aQuery['viewer_session_id'],
        'date_time'        => gmdate('Y-m-d H:i:s', $time),
        'ad_id'            => $aQuery['ad_id'],
        'creative_id'      => $aQuery['creative_id'],
        'zone_id'          => $aQuery['zone_id'],
        //'ip_address'       => $_SERVER['REMOTE_ADDR'],
        'vast_event_id'    => $aQuery['vast_event_id'],
        'is_host_ok'       => $aQuery['is_host_ok'],
    ); 

    array_walk($aFields, 'OX_escapeString');

    $query = "
        INSERT INTO
            {$table}
            (" . implode(', ', array_keys($aFields)) . ")
        VALUES
            ('" . implode("', '", $aFields) . "')
    ";
    $result = OA_Dal_Delivery_query($query, 'rawDatabase');
    if (!$result) {
        return false;
    }

    $aResult = OA_Dal_Delivery_insertId('rawDatabase', $table, 'server_conv_id');

    return $aResult;
}
*/

function bumpVastEventTrackingBucketCounter($data)
{
    $aQuery = array(
        'interval_start' => $data['interval_start'],
        'creative_id'    => $data['creative_id'],
        'zone_id'        => $data['zone_id'],
        'vast_event_id'  => $data['vast_event_id'],
    );
    return OX_bucket_updateTable('data_bkt_vast_e', $aQuery);
}


// End of code

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

MAX_commonRegisterGlobalsArray(array('vast_event' ));

// if its a vast tracking event
if ( $vast_event ){

    // NB: videotimeposn is not yet supported by the player
    //
    MAX_commonRegisterGlobalsArray(array('video_time_posn', 'banner_id', 'zone_id' ));


    // Prevent the logging beacon from being cached by browsers
    MAX_commonSetNoCacheHeaders();
    
    // Remove any special characters from the request variables
    MAX_commonRemoveSpecialChars($_REQUEST);
    
    //$GLOBALS['_MAX']['deliveryData']['interval_start'] = gmdate('Y-m-d H:i:s', $time - $time % ($oi * 60));
   
    $time = getTimeNow();
    
    $oi = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];
    $intervalStart =  gmdate('Y-m-d H:i:s', $time - $time % ($oi * 60));   
    
    $viewerIsOkToLog = _viewersHostOkayToLog();
    
    $aQuery = array( 'creative_id'      => intVal($banner_id),
                     'zone_id'          => intVal($zone_id),
                     'vast_event_id'    => getVastEventIdFromVastEventStr($vast_event),
                     'interval_start'   => $intervalStart,
                     'is_host_ok'       => $viewerIsOkToLog,
                     'video_time_posn'  => intVal($video_time_posn), 
                   );
  
    //logRawVastDataEvent($aQuery);
    
    if ( $viewerIsOkToLog ){
        
       bumpVastEventTrackingBucketCounter( $aQuery );      
    }
    
    if (!empty($_REQUEST[$GLOBALS['_MAX']['CONF']['var']['dest']])) {
        
        MAX_redirect($_REQUEST[$GLOBALS['_MAX']['CONF']['var']['dest']]);
    } else {
        // Display a 1x1 pixel gif
        MAX_commonDisplay1x1();
    }
    
}
else {
    
   // do nothing
}

?>
