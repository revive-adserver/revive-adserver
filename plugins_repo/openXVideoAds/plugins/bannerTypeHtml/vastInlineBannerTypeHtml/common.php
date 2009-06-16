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

if ( !function_exists('xdebug_break') ){
    function xdebug_break(){
        // xdebug not installed - do nothing
    }
}

function getVastVideoTypes(){
   static $videoEncodingTypes = array( 'video/x-mp4' =>  'video/x-mp4',
                                       'video/x-flv' => 'video/x-flv',
                                       'video/x-ms-wmv' => 'video/x-ms-wmv',
                                       'video/x-ra' => 'video/x-ra',
                                      );
   return $videoEncodingTypes;
}

function parseVideoUrl( $fullPathToVideo, &$aDeliveryFields, &$aAdminFields )
{    
    if ( ($fileDelimPosn = strrpos($fullPathToVideo, '/mp4:')) !== false ) {
        
      $aDeliveryFields['videoFilePath'] = substr( $fullPathToVideo, 0, $fileDelimPosn );
      $aDeliveryFields['videoFileName'] = substr( $fullPathToVideo, $fileDelimPosn +1, strlen($fullPathToVideo) );
      $aDeliveryFields['videoDelivery'] =  'player_in_rtmp_mode';
      
      // parameters used at admin time
      $aAdminFields['vast_video_type'] = 'video/x-mp4';
      $aAdminFields['vast_video_delivery'] = 'streaming';
            
    }
    else if ( ($fileDelimPosn = strrpos($fullPathToVideo, '/flv:')) !== false ){
       
      $aDeliveryFields['videoFilePath'] = substr( $fullPathToVideo, 0, $fileDelimPosn  );
      $aDeliveryFields['videoFileName'] = substr( $fullPathToVideo, $fileDelimPosn +1, strlen($fullPathToVideo) );
      $aDeliveryFields['videoDelivery'] = 'player_in_rtmp_mode';
      
      // parameters used at admin time
      $aAdminFields['vast_video_type'] = 'video/x-flv';
      $aAdminFields['vast_video_delivery'] = 'streaming';

    }
    else if ( ($fileDelimPosn = strpos($fullPathToVideo, 'http://' )) === 0 ){

      $aDeliveryFields['videoFilePath'] = "";  
      $aDeliveryFields['videoFileName'] = $fullPathToVideo; 
      $aDeliveryFields['videoDelivery'] = 'player_in_http_mode';
      
      // parameters used at admin time
      $aAdminFields['vast_video_delivery'] = 'progressive';
      
      if ( ($fileExtensionDelimPosn = strrpos($fullPathToVideo, '.' )) !== false ){
             
          $fileExtension = substr( $fullPathToVideo, $fileExtensionDelimPosn +1, strlen($fullPathToVideo) ); 

          if ( $fileExtension == 'flv' ){
              
              $aAdminFields['vast_video_type'] = 'video/x-flv';    
          }
          else if ( $fileExtension == 'mp4' ){
              
              $aAdminFields['vast_video_type'] = 'video/x-mp4'; 
          }
          /*
          // Format not supported by flowplayer
          else if ( $fileExtension == 'ra' ){
              
              $aAdminFields['vast_video_type'] = 'video/x-ra';               
          } 
          // Format not supported by flowplayer
          else if ( $fileExtension == 'wmv' ){

              $aAdminFields['vast_video_type'] = 'video/x-ms-wmv';              
          } */ 
          else {
              // default value 
              $aAdminFields['vast_video_type'] = 'video/x-mp4';
          }        
      } 
    }
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
        OA::debug("[VAST]" . $message);
    }

    function debugLog($message){
        OA::debug("[VAST]" . $message);
    }

    function appendDebugMessage($message){
        OA::debug("[VAST]" . $message);
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

