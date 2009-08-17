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

/*
 * We define these hardcoded width and height parameters for the banner
 * so that other types of zones/banners cannot be linked to these incompatable items
 * In the future, a banner-zone compatability hook will exist
 */
define( 'VAST_OVERLAY_DIMENSIONS', -2 );
define( 'VAST_INLINE_DIMENSIONS', -3 );


define( 'VAST_RTMP_MP4_DELIMITER', 'mp4:' );
define( 'VAST_RTMP_FLV_DELIMITER', 'flv:' );


if ( !function_exists('xdebug_break') ){
    function xdebug_break(){
        // xdebug not installed - do nothing
    }
}

function getVastVideoTypes(){
   static $videoEncodingTypes = array( 'video/x-mp4' =>  'video/x-mp4',
                                       'video/x-flv' => 'video/x-flv',
                                       // not supported by flowplayer -  'video/x-ms-wmv' => 'video/x-ms-wmv',
                                       // not supported by flowplayer -  'video/x-ra' => 'video/x-ra',
                                      );
   return $videoEncodingTypes;
}


function encodeUserSuppliedData($text) {
    
   return htmlspecialchars($text, ENT_QUOTES); 
}

function xmlspecialchars($text) {
    
   return htmlspecialchars($text, ENT_QUOTES); 
}

function combineVideoUrl( &$aAdminFields )
{    
    xdebug_break();
    
    // If either of these fields are set we know that its a form submit (as these fields do not exist in db)
    if ( $aAdminFields['vast_net_connection_url'] || $aAdminFields['vast_video_filename'] ){
        
        // In the case of streaming - there are 2 seperate fields stored in the db field vast_video_outgoing_filename
        if ( $aAdminFields['vast_video_delivery'] == 'streaming'  ) {
            
            $aSeek = array( VAST_RTMP_FLV_DELIMITER, VAST_RTMP_MP4_DELIMITER );
            str_replace( $aSeek, '', $aAdminFields['vast_net_connection_url'] );
            str_replace( $aSeek, '', $aAdminFields['vast_video_filename'] );
            
            if ( $aAdminFields['vast_video_type'] == 'video/x-flv' ){
    
                $aAdminFields['vast_video_outgoing_filename'] = $aAdminFields['vast_net_connection_url']  . VAST_RTMP_FLV_DELIMITER  . $aAdminFields['vast_video_filename']; 
            }
            elseif ( $aAdminFields['vast_video_type'] == 'video/x-mp4' ){
    
                $aAdminFields['vast_video_outgoing_filename'] = $aAdminFields['vast_net_connection_url'] . VAST_RTMP_MP4_DELIMITER  . $aAdminFields['vast_video_filename']; 
            } 
        } 
        // In the case of progressive - we just store vast_video_filename in the db field vast_video_outgoing_filename
        else {
            
            $aAdminFields['vast_video_outgoing_filename'] = $aAdminFields['vast_video_filename'];  
        }
    }
  
}

function parseVideoUrl( $inFields, &$aDeliveryFields, &$aAdminFields )
{    
    // xdebug_break();
    
    $fullPathToVideo = $inFields['vast_video_outgoing_filename'];
    $aDeliveryFields['fullPathToVideo'] = $fullPathToVideo; 
    
    if ( ($fileDelimPosn = strpos($fullPathToVideo, VAST_RTMP_MP4_DELIMITER)) !== false ) {
        
      $netConnectionUrl = substr( $fullPathToVideo, 0, $fileDelimPosn ); 
      $filename = substr( $fullPathToVideo, $fileDelimPosn + strlen( VAST_RTMP_MP4_DELIMITER ), strlen($fullPathToVideo) );
      
      $aDeliveryFields['videoNetConnectionUrl'] = $netConnectionUrl;
      
      // for some unknown reason - I need to have mp4: at the start of the filename to play in the in Admin tool player..
      
      $aDeliveryFields['videoFileName'] = 'mp4:' . $filename;
      $aDeliveryFields['videoDelivery'] =  'player_in_rtmp_mode';
      
      // parameters used at admin time
      //$aAdminFields['vast_video_type'] = 'video/x-mp4';
      //$aAdminFields['vast_video_delivery'] = 'streaming';
      $aAdminFields['vast_net_connection_url'] =  $netConnectionUrl;
      $aAdminFields['vast_video_filename'] = $filename;     
    }
    else if ( ($fileDelimPosn = strpos($fullPathToVideo, VAST_RTMP_FLV_DELIMITER)) !== false ){
       
      $netConnectionUrl = substr( $fullPathToVideo, 0, $fileDelimPosn ); 
      $filename = substr( $fullPathToVideo, $fileDelimPosn + strlen( VAST_RTMP_FLV_DELIMITER ), strlen($fullPathToVideo) );
      
      $aDeliveryFields['videoNetConnectionUrl'] = $netConnectionUrl;
      $aDeliveryFields['videoFileName'] =  $filename;
      $aDeliveryFields['videoDelivery'] = 'player_in_rtmp_mode';
      
      // parameters used at admin time
      //$aAdminFields['vast_video_type'] = 'video/x-flv';
      //$aAdminFields['vast_video_delivery'] = 'streaming';
      $aAdminFields['vast_net_connection_url'] = $netConnectionUrl;
      $aAdminFields['vast_video_filename'] = $filename; 
 
    }
    else {
        
      $aDeliveryFields['videoDelivery'] = 'player_in_http_mode';
      $aDeliveryFields['videoFileName'] = $inFields['vast_video_outgoing_filename'];
       
      $aAdminFields['vast_video_filename'] = $inFields['vast_video_outgoing_filename'];  
    }
    
    
    //vastIntelligentParseVideoUrl( $inFields, $aDeliveryFields, $aAdminFields );
    
}

function vastIntelligentParseVideoUrl($inFields, $aDeliveryFields, $aAdminFields){
   
    $fullPathToVideo = $inFields['vast_video_outgoing_filename'];
    $aParams = array();
    
    
    // If the url starts with http we know its progressive
    if ( ($fileDelimPosn = strpos($fullPathToVideo, 'http://' )) === 0 ){
      
      // parameters used at admin time
      $aAdminFields['vast_video_delivery'] = 'progressive'; 
    }
    
    // If the url starts with rtmp we know its streaming
    
    if ( ($fileDelimPosn = strpos($fullPathToVideo, 'rtmp://' )) === 0 ){

      
      // parameters used at admin time
      $aAdminFields['vast_video_delivery'] = 'streaming';
    }
    
/*
    // get parameters off the url supplied
    $aUrlParts = parse_url( $fullPathToVideo );
    
    if ( $aUrlParts['query'] ){
        
        parse_str( $aUrlParts['query'], $aParams ); 
        
        if ( isset($aParams['vast_video_id'] )){

            $aAdminFields['vast_video_id'] = $aParams['vast_video_id'];   
        }
        
        if ( isset($aParams['vast_video_delivery']) ) {

            if (  $aParams['vast_video_delivery'] == 'progressive' ){

                $aAdminFields['vast_video_delivery'] = 'progressive';
                
                $aAdminFields['vast_video_filename'] = $aUrlParts['scheme'] . ':' . $aUrlParts['port'] . '//' . $aUrlParts['host'] . $aUrlParts['path'];
                
            }
            else if ( $aParams['vast_video_delivery'] == 'streaming') {
                
               $aAdminFields['vast_video_delivery'] = 'streaming';

               $aAdminFields['vast_net_connection_url'] = $aUrlParts['scheme'] . ':' . $aUrlParts['port'] . '//' . $aUrlParts['host']  . $aUrlParts['path'];
               
               if ( isset($aParams['filename'])){
            
                   $aAdminFields['vast_video_filename'] = $aParams['filename'];
               }
            }
        }
        
        if ( isset($aParams['vast_video_type'] ) ){
            
            if ( array_search( $aParams['vast_video_type'], getVastVideoTypes()) ){
                
               $aAdminFields['vast_video_type'] = $aParams['vast_video_type'];    
            }
        }  

        if ( isset($aParams['vast_video_duration'])){
            
           $aAdminFields['vast_video_duration'] = $aParams['vast_video_duration'];
        }

        if ( isset($aParams['vast_video_clickthrough_url'])){
            
           $aAdminFields['vast_video_clickthrough_url'] = $aParams['vast_video_clickthrough_url'];
        }   
        
        */
    
}

function vastPluginErrorHandler($errNo, $errStr, $file, $line, $context){
    
    xdebug_break();
    
    if ( strpos( $errStr, 'should not be called statically')
        || strpos( $errStr, 'is_a()')){
        // ignore
    }
    else {
        // Other errors - I like to know about
        appendDebugMessage("ERROR No: $errNo, $errStr, $file, $line, $context<br>" );
    }
}

if ( !function_exists('debugDump') ){
    
    function debugDump($id, $value){
        $message = "ID:$id VALUE:" . print_r( $value, true);
        
        // In some cases the class OA - is not in existance yet - hence comment this out - see OXPL-345
        //OA::debug("[VAST]" . $message);
    }

    function debugLog($message){
        
        // In some cases the class OA - is not in existance yet - hence comment this out - see OXPL-345
        //OA::debug("[VAST]" . $message);
    }

    function appendDebugMessage($message){
        
        // In some cases the class OA - is not in existance yet - hence comment this out - see OXPL-345
        //OA::debug("[VAST]" . $message);
        
    }
}

function activatePluginErrorHandler(){
    set_error_handler('vastPluginErrorHandler');
}

function dectivatePluginErrorHandler(){
    restore_error_handler();
}


// This will be used to send debug messages to the requesting client
//  I have already implemented this code
//  just need a nice way to integrate it and get it pulled into the core
$aClientMessages = array();

function appendClientMessage( $message, $variableToDump = null ){
    global $aClientMessages;
    if ( $variableToDump ){
        $message .= '<pre>' . print_r( $variableToDump, true ) . '</pre>';
    }
    $aClientMessages[] = $message;
}

function getClientMessages(){
    global $aClientMessages;
    global $clientdebug;
    $str = "";
    if ( $clientdebug ){
        $str = "<!-- \n";
        foreach( $aClientMessages as $currentMessage ){
            $str .= "$currentMessage\n";
        }
        $str .= " -->\n";
    }
    return $str;
}

