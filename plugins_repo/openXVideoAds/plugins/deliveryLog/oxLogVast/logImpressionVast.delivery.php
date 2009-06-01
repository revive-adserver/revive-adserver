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

/* 
 * NOTE: If this list of event ever changes (IDs or names), the Video Reports must be updated as well
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

function getVastEventIdFromVastEventStr($eventIdStr)
{
    global $aVastEventStrToIdMap;
    $vastEventId = 0; // Unknown event
    if ( isset($aVastEventStrToIdMap[$eventIdStr]) ){
        $vastEventId = $aVastEventStrToIdMap[$eventIdStr];
    }
    return $vastEventId;
}

function getTimeNow()
{
    if (empty($GLOBALS['_MAX']['NOW'])) {
        $GLOBALS['_MAX']['NOW'] = time();
    }
    $time = $GLOBALS['_MAX']['NOW'];
    return $time;
}

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
                     //'video_time_posn'  => intVal($video_time_posn), 
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
