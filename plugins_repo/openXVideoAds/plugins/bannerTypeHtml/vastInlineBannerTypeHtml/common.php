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

// Definition of different overlay formats supported
define( 'VAST_OVERLAY_FORMAT_TEXT', 'text_overlay' );
define( 'VAST_OVERLAY_FORMAT_SWF', 'swf_overlay' );
define( 'VAST_OVERLAY_FORMAT_IMAGE', 'image_overlay' );
define( 'VAST_OVERLAY_FORMAT_HTML', 'html_overlay' );

// Definition of different actions supported as a result of a click
define( 'VAST_OVERLAY_CLICK_TO_PAGE', 'click_to_page' );
define( 'VAST_OVERLAY_CLICK_TO_VIDEO', 'click_to_video' );

define( 'VAST_VIDEO_URL_STREAMING_FORMAT', 'streaming' );
define( 'VAST_VIDEO_URL_PROGRESSIVE_FORMAT', 'progressive' );

define('VAST_OVERLAY_DEFAULT_WIDTH', 600);
define('VAST_OVERLAY_DEFAULT_HEIGHT', 40);

function getVastVideoTypes()
{
   static $videoEncodingTypes = array( 'video/x-mp4' =>  'MP4',
                                       'video/x-flv' => 'FLV',
                                       'video/webm' => 'WEBM',
                                       // not supported by flowplayer -  'video/x-ms-wmv' => 'WMV',
                                       // not supported by flowplayer -  'video/x-ra' => 'video/x-ra',
   );
   return $videoEncodingTypes;
}


function encodeUserSuppliedData($text)
{
   return htmlspecialchars($text, ENT_QUOTES);
}

function xmlspecialchars($text)
{
   return htmlspecialchars($text, ENT_QUOTES);
}

function combineVideoUrl( &$aAdminFields )
{
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
            elseif ( $aAdminFields['vast_video_type'] == 'video/x-mp4'){
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
    $fullPathToVideo = $inFields['vast_video_outgoing_filename'];
    $aDeliveryFields['fullPathToVideo'] = $fullPathToVideo;

    if(($fileDelimPosn = strpos($fullPathToVideo, VAST_RTMP_MP4_DELIMITER)) !== false )
    {
      $netConnectionUrl = substr( $fullPathToVideo, 0, $fileDelimPosn );
      $filename = substr( $fullPathToVideo, $fileDelimPosn + strlen( VAST_RTMP_MP4_DELIMITER ), strlen($fullPathToVideo) );

      $aDeliveryFields['videoNetConnectionUrl'] = $netConnectionUrl;

      // for some unknown reason - I need to have mp4: at the start of the filename to play in the in Admin tool player..
      $aDeliveryFields['videoFileName'] = 'mp4:' . $filename;
      $aDeliveryFields['videoDelivery'] =  'player_in_rtmp_mode';

      // parameters used at admin time
      $aAdminFields['vast_net_connection_url'] =  $netConnectionUrl;
      $aAdminFields['vast_video_filename'] = $filename;
    }
    elseif ( ($fileDelimPosn = strpos($fullPathToVideo, VAST_RTMP_FLV_DELIMITER)) !== false )
    {
      $netConnectionUrl = substr( $fullPathToVideo, 0, $fileDelimPosn );
      $filename = substr( $fullPathToVideo, $fileDelimPosn + strlen( VAST_RTMP_FLV_DELIMITER ), strlen($fullPathToVideo) );

      $aDeliveryFields['videoNetConnectionUrl'] = $netConnectionUrl;
      $aDeliveryFields['videoFileName'] =  $filename;
      $aDeliveryFields['videoDelivery'] = 'player_in_rtmp_mode';

      // parameters used at admin time
      $aAdminFields['vast_net_connection_url'] = $netConnectionUrl;
      $aAdminFields['vast_video_filename'] = $filename;
    }
    else
    {
      $aDeliveryFields['videoDelivery'] = 'player_in_http_mode';
      $aDeliveryFields['videoFileName'] = $inFields['vast_video_outgoing_filename'];
      $aAdminFields['vast_video_filename'] = $inFields['vast_video_outgoing_filename'];
    }
}

// This will be used to send debug messages to the requesting client
$aClientMessages = array();

function appendClientMessage( $message, $variableToDump = null )
{
    global $aClientMessages;
    if ( $variableToDump ){
        $message .= '<pre>' . print_r( $variableToDump, true ) . '</pre>';
    }
    $aClientMessages[] = $message;
}

function getClientMessages()
{
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

function getVideoPlayerSetting($parameterId)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $value = $conf['vastServeVideoPlayer'][$parameterId];

    return $value;
}

function getVideoOverlaySetting($parameterId)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $value = $conf['vastOverlayBannerTypeHtml'][$parameterId];

    return $value;
}


class VideoAdsHelper
{
    static function getWarningMessage($message)
    {
        return "<div class='errormessage' style='width:750px;'><img class='errormessage' src='" . OX::assetPath() . "/images/info.gif' align='absmiddle'>
              <span class='tab-r' style='font-weight:normal;'>&nbsp;". $message ."</span>
              </div>";
    }

    static function displayWarningMessage( $message )
    {
        echo self::getWarningMessage($message);
    }

    static function getErrorMessage($message)
    {
        return '<div style="" id="errors" class="form-message form-message-error">'. $message .'</div>';
    }

    static function getHelpLinkVideoPlayerConfig()
    {
        return 'http://documentation.revive-adserver.com/display/DOCS/Invocation+code%3A+Zone+level#Invocationcode:Zonelevel-Video';
    }

    static function getHelpLinkOpenXPlugin()
    {
        return 'http://documentation.revive-adserver.com/display/DOCS/Inline+Video+banners';
    }

    static function getLinkCrossdomainExample()
    {
        return 'https://raw.githubusercontent.com/revive-adserver/revive-adserver/master/www/delivery_dev/crossdomain.xml';
    }
}
