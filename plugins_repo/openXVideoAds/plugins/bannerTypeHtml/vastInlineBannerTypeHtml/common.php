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

function vastPluginErrorHandler($errNo, $errStr, $file, $line, $context){
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

