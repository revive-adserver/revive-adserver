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

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';

function deliverVastAd($pluginType, &$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $loc, $referer)
{
    global $format;
    extractVastParameters( $aBanner );
    $aOutputParams = array();
    $aOutputParams['format'] = $format;

    $aOutputParams['videoPlayerSwfUrl'] = getVideoPlayerUrl('flowplayerSwfUrl');
    $aOutputParams['videoPlayerJsUrl'] = getVideoPlayerUrl('flowplayerJsUrl');
    $aOutputParams['videoPlayerRtmpPluginUrl'] = getVideoPlayerUrl('flowplayerRtmpPluginUrl');
    $aOutputParams['videoPlayerControlsPluginUrl'] = getVideoPlayerUrl('flowplayerControlsPluginUrl');

    if ( getVideoPlayerSetting('isAutoPlayOfVideoInOpenXAdminToolEnabled' )){
        $aOutputParams['isAutoPlayOfVideoInOpenXAdminToolEnabled'] = "true";
    } else {
        $aOutputParams['isAutoPlayOfVideoInOpenXAdminToolEnabled'] = "false";
    }
    if(!empty($aBanner['vast_thirdparty_impression'])) {
        $aOutputParams['thirdPartyImpressionUrl'] = $aBanner['vast_thirdparty_impression'];
    }
    prepareCompanionBanner($aOutputParams, $aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $loc, $referer);
    prepareVideoParams( $aOutputParams, $aBanner );
    prepareOverlayParams( $aOutputParams, $aBanner );

    $player = "";
    prepareTrackingParams( $aOutputParams, $aBanner, $zoneId, $source, $loc, $ct0, $logClick, $referer );
    if ( $format == 'vast' ){
        if ( $pluginType == 'vastInline' ){
            $player .= renderVastOutput( $aOutputParams, $pluginType, "Inline Video Ad" );
        } else if ( $pluginType == 'vastOverlay' ) {
            $player .= renderVastOutput( $aOutputParams, $pluginType, "Overlay Video Ad" );
        } else {
            throw new Exception("Uncatered for vast plugintype|$pluginType|");
        }
    } else {
        if ( $pluginType == 'vastInline' ){
            $player .= renderPlayerInPage($aOutputParams);
            $player .= renderCompanionInAdminTool($aOutputParams);
        } else if ( $pluginType == 'vastOverlay' ) {
            $player .= renderOverlayInAdminTool($aOutputParams, $aBanner);
            $player .= renderCompanionInAdminTool($aOutputParams);
            $player .= renderPlayerInPage($aOutputParams);
        } else {
            throw new Exception("Uncatered for vast plugintype|$pluginType|");
        }
    }
    return $player;
}

function getVastXMLHeader($charset)
{
	$header   = "<?xml version=\"1.0\" encoding=\"".xmlspecialchars($charset)."\"?>\n";
    $header  .= "<VideoAdServingTemplate xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"vast.xsd\">\n";
    return $header;
}

function getVastXMLFooter()
{
	$footer = "</VideoAdServingTemplate>\n";
	return $footer;
}

/*
 * By default we return something like this:
 * http://.../openx/www/delivery_dev/fc.php?script=deliveryLog:logVastEvent:logVastEvent&banner_id=7&zone_id=2&source=&vast_event=start
 */
function getVideoPlayerUrl($parameterId)
{
    static $aDefaultPlayerFiles = array(
        'flowplayerSwfUrl'=> "flowplayer/3.1.1/flowplayer-3.1.1.swf",
        'flowplayerJsUrl'=> "flowplayer/3.1.1/flowplayer-3.1.1.min.js",
        'flowplayerControlsPluginUrl' =>  "flowplayer/3.1.1/flowplayer.controls-3.1.1.swf",
        'flowplayerRtmpPluginUrl'=> "flowplayer/3.1.1/flowplayer.rtmp-3.1.0.swf",
    );

    $conf = $GLOBALS['_MAX']['CONF'];

    // you can set this by adding a setting under [vastServeVideoPlayer] in the hostname.conf.php config file
    $fullFileLocationUrl = $GLOBALS['_MAX']['SSL_REQUEST'] ? 'https://' . $conf['webpath']['deliverySSL'] : 'http://' .  $conf['webpath']['delivery'];

    $fullFileLocationUrl .= "/fc.php?script=deliveryLog:vastServeVideoPlayer:player&file_to_serve=";

    if(isset( $conf['vastServeVideoPlayer'][$parameterId])) {
        $configFileLocation = $conf['vastServeVideoPlayer'][$parameterId];
        $fullFileLocationUrl .= $configFileLocation;
    } else {
        if(!isset($aDefaultPlayerFiles[$parameterId])) {
            throw new Exception("Uncatered for setting type in getVideoPlayerUrl() |$parameterId| in <pre>" . print_r( $aDefaultPlayerFiles, true) . '</pre>' );
        } else {
            $fullFileLocationUrl .= $aDefaultPlayerFiles[$parameterId];
        }
    }
    return $fullFileLocationUrl;
}

function extractVastParameters( &$aBanner )
{
    if ( isset($aBanner['parameters']) ){
        $vastVariables = unserialize($aBanner['parameters']);
        $aBanner = array_merge($aBanner, $vastVariables);
    }
}

function prepareVideoParams(&$aOutputParams, $aBanner)
{
    $aOutputParams['name'] = $aBanner['name'];
    if(isset($aBanner['vast_video_outgoing_filename'] )
        && $aBanner['vast_video_outgoing_filename']) {
       $aAdminParamsNotUsed = array();
       parseVideoUrl($aBanner, $aOutputParams, $aAdminParamsNotUsed );
       $aOutputParams['vastVideoDuration'] = secondsToVASTDuration( $aBanner['vast_video_duration'] );
       $aOutputParams['vastVideoBitrate'] = $aBanner['vast_video_bitrate'];
       $aOutputParams['vastVideoWidth']= $aBanner['vast_video_width'];
       $aOutputParams['vastVideoHeight'] = $aBanner['vast_video_height'];
       $aOutputParams['vastVideoId'] =  $aBanner['bannerid'];
       $aOutputParams['vastVideoType'] = $aBanner['vast_video_type'];
       $aOutputParams['vastVideoDelivery'] = $aBanner['vast_video_delivery'];
    }
}

function prepareOverlayParams(&$aOutputParams, $aBanner)
{
    $aOutputParams['overlayHeight'] = $aBanner['vast_overlay_height'];
    $aOutputParams['overlayWidth'] = $aBanner['vast_overlay_width'];
    $aOutputParams['overlayDestinationUrl'] = $aBanner['url'];
    if (isset($aBanner['htmltemplate'])) {
        $aOutputParams['overlayMarkupTemplate'] = $aBanner['htmltemplate'];
    }
    if(!empty($aBanner['filename'])) {
        $aOutputParams['overlayFilename'] = $aBanner['filename'];
    }
    if(!empty($aBanner['contenttype'])) {
        $aOutputParams['overlayContentType'] = $aBanner['vast_creative_type'];
    }
    $aOutputParams['overlayFormat'] = $aBanner['vast_overlay_format'];
    switch($aOutputParams['overlayFormat']) {
        case VAST_OVERLAY_FORMAT_TEXT:
            $aOutputParams['overlayTextTitle'] = $aBanner['vast_overlay_text_title'];
            $aOutputParams['overlayTextDescription'] = $aBanner['vast_overlay_text_description'];
            $aOutputParams['overlayTextCall'] = $aBanner['vast_overlay_text_call'];
            $aOutputParams['overlayHeight'] = VAST_OVERLAY_DEFAULT_HEIGHT;
            $aOutputParams['overlayWidth'] = VAST_OVERLAY_DEFAULT_WIDTH;
        break;

        case VAST_OVERLAY_FORMAT_HTML:
            $aOutputParams['overlayHeight'] = VAST_OVERLAY_DEFAULT_HEIGHT;
            $aOutputParams['overlayWidth'] = VAST_OVERLAY_DEFAULT_WIDTH;
        break;
    }
//    var_dump($aBanner);
//    var_dump($aOutputParams);exit;
}

function prepareCompanionBanner(&$aOutputParams, $aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $loc, $referer)
{
    // If we have a companion banner to serve
    if ( isset( $aBanner['vast_companion_banner_id']  )
        && ($aBanner['vast_companion_banner_id'] != 0) )
    {
        $companionBannerId = $aBanner['vast_companion_banner_id'];

        // VAST supports the concept of an ad having multlple  companions returned(each with different formats and sizes
        // its then the role of the player to choose the appropriate companion ad to display based on users screen size etc
        // However for now we just focus on serving a single companion banner. Also in vast - I think - the player should be adding the click tracking
        // for now we are doing this server side.
        global $context;

        if (isset($context) && !is_array($context)) {
            $context = MAX_commonUnpackContext($context);
        }
        if (!is_array($context)) {
            $context = array();
        }
        $companionOutput = MAX_adSelect("bannerid:$companionBannerId", '', "", $source, $withText, '', $context, true, $ct0, $loc, $referer);

        //$aBanner = _adSelectDirect("bannerid:$companionBannerId", '', $context, $source);
        //$companionOutput = MAX_adRender($aBanner, 0, '', '', '', true, '', false, false);
        //$aOutputParams['companionId'] = $companionBannerId;
        if ( !empty($companionOutput['html'] )){
            // We only regard  a companion existing, if we have some markup to output
            $html = $companionOutput['html'];

            // deal with the case where the companion code itself contains a CDATA
            $html = str_replace(']]>', ']]]]><![CDATA[>', $html);
            $aOutputParams['companionMarkup'] = $html;

            $aOutputParams['companionWidth'] = $companionOutput['width'];
            $aOutputParams['companionHeight'] = $companionOutput['height'];
            $aOutputParams['companionClickUrl'] = $companionOutput['url'];
        }
    }
}

function prepareTrackingParams(&$aOutputParams, $aBanner, $zoneId, $source, $loc, $ct0, $logClick, $referer)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $aOutputParams['impressionUrl'] =  _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, '&');
    if ( $aOutputParams['format'] == 'vast' ){
       $trackingUrl = 'http://' . $conf['webpath']['delivery'] . "/fc.php?script=deliveryLog:oxLogVast:logImpressionVast&banner_id=" . $aBanner['bannerid'] . "&zone_id=$zoneId&source=$source";
       $aOutputParams['trackUrlStart'] = $trackingUrl . '&vast_event=start';
       $aOutputParams['trackUrlMidPoint'] = $trackingUrl . '&vast_event=midpoint';
       $aOutputParams['trackUrlFirstQuartile'] = $trackingUrl . '&vast_event=firstquartile';
       $aOutputParams['trackUrlThirdQuartile'] = $trackingUrl . '&vast_event=thirdquartile';
       $aOutputParams['trackUrlComplete'] = $trackingUrl . '&vast_event=complete';
       $aOutputParams['trackUrlMute'] = $trackingUrl . '&vast_event=mute';
       $aOutputParams['trackUrlPause'] = $trackingUrl . '&vast_event=pause';
       $aOutputParams['trackReplay'] = $trackingUrl . '&vast_event=replay';
       $aOutputParams['trackUrlFullscreen'] = $trackingUrl . '&vast_event=fullscreen';
       $aOutputParams['trackUrlStop'] = $trackingUrl . '&vast_event=stop';
       $aOutputParams['trackUrlUnmute'] = $trackingUrl . '&vast_event=unmute';
       $aOutputParams['trackUrlResume'] = $trackingUrl . '&vast_event=resume';
       $aOutputParams['vastVideoClickThroughUrl'] = _adRenderBuildVideoClickThroughUrl($aBanner, $zoneId, $source, $ct0 );
    }
    $aOutputParams['clickUrl'] = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick);
}

/**
 * This function builds the Click through URL for this ad
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 *
 * @return string The click URL
 */
function _adRenderBuildVideoClickThroughUrl($aBanner, $zoneId=0, $source='', $ct0='', $logClick=true){

    // We dont pass $aBanner by reference - so the changes to this $aBanner are lost - which is a good thing
    // we need the url attribute of aBanner to contain the url we want created
    $clickUrl = '';
    if(!empty($aBanner['vast_video_clickthrough_url'])) {
        $aBanner['url'] = $aBanner['vast_video_clickthrough_url'];
        $clickUrl = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick);
    }
    return $clickUrl;
}

function getVastVideoAdOutput($aO)
{
    if(!empty($aO['vastVideoClickThroughUrl'])) {
        $videoClicksVast = '<VideoClicks>
                        <ClickThrough>
                            <URL id="destination"><![CDATA['.$aO['vastVideoClickThroughUrl'].']]></URL>
                        </ClickThrough>
                    </VideoClicks>';
    }

    $vastVideoMarkup =<<<VAST_VIDEO_AD_TEMPLATE
			    <Video>
                    <Duration>${aO['vastVideoDuration']}</Duration>
                    <AdID><![CDATA[${aO['vastVideoId']}]]></AdID>
                    $videoClicksVast
                    <MediaFiles>
                        <MediaFile delivery="${aO['vastVideoDelivery']}" bitrate="${aO['vastVideoBitrate']}" width="${aO['vastVideoWidth']}" height="${aO['vastVideoHeight']}" type="${aO['vastVideoType']}">
                            <URL><![CDATA[${aO['fullPathToVideo']}]]></URL>
                        </MediaFile>
                    </MediaFiles>
                </Video>

                <TrackingEvents>
                    <Tracking event="start">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlStart']}]]></URL>
                    </Tracking>
                    <Tracking event="midpoint">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlMidPoint']}]]></URL>
                    </Tracking>
                    <Tracking event="firstQuartile">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlFirstQuartile']}]]></URL>
                    </Tracking>
                    <Tracking event="thirdQuartile">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlThirdQuartile']}]]></URL>
                    </Tracking>
                    <Tracking event="complete">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlComplete']}]]></URL>
                    </Tracking>
                    <Tracking event="mute">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlMute']}]]></URL>
                    </Tracking>
                    <Tracking event="pause">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlPause']}]]></URL>
                    </Tracking>
                    <Tracking event="replay">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackReplay']}]]></URL>
                    </Tracking>
                    <Tracking event="fullscreen">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlFullscreen']}]]></URL>
                    </Tracking>
                    <Tracking event="stop">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlStop']}]]></URL>
                    </Tracking>
                    <Tracking event="unmute">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlUnmute']}]]></URL>
                    </Tracking>
                   <Tracking event="resume">
                        <URL id="primaryAdServer"><![CDATA[${aO['trackUrlResume']}]]></URL>
                    </Tracking>
                </TrackingEvents>
VAST_VIDEO_AD_TEMPLATE;

    return $vastVideoMarkup;
}

function getImageUrlFromFilename($filename)
{
    return _adRenderBuildImageUrlPrefix() . "/" . $filename;
}

function renderVastOutput( $aOut, $pluginType, $vastAdDescription )
{
    $adName = $aOut['name'];
    $player = "";
    $player .= "    <Ad id=\"{player_allocated_ad_id}\" >";
    $player .= "        <InLine>";
    $player .= "            <AdSystem>OpenX</AdSystem>\n";
    $player .= "                <AdTitle><![CDATA[$adName]]></AdTitle>\n";
    $player .= "                    <Description><![CDATA[$vastAdDescription]]></Description>\n";
    $player .= "                    <Impression>\n";
    $player .= "                        <URL id=\"primaryAdServer\"><![CDATA[${aOut['impressionUrl']}]]></URL>\n";
    if(!empty($aOut['thirdPartyImpressionUrl'])) {
        $player .= "                        <URL id=\"secondaryAdServer\"><![CDATA[${aOut['thirdPartyImpressionUrl']}]]></URL>\n";
    }
    $player .= "                    </Impression>\n";

    if ( isset($aOut['companionMarkup'])  ){
        if(!empty($aOut['companionClickUrl'])) {
            $CompanionClickThrough  = "                    <CompanionClickThrough>\n";
            $CompanionClickThrough .= "                        <URL><![CDATA[${aOut['companionClickUrl']}]]></URL>\n";
            $CompanionClickThrough .= "                    </CompanionClickThrough>\n";
        }
        //debugdump( '$companionOutput', $companionOutput );
        $player .= "             <CompanionAds>\n";
        $player .= "                <Companion id=\"companion\" width=\"${aOut['companionWidth']}\" height=\"${aOut['companionHeight']}\" resourceType=\"HTML\">\n";
        $player .= "                    <Code><![CDATA[${aOut['companionMarkup']}]]></Code>\n";
        $player .= "					$CompanionClickThrough";
        $player .= "                </Companion>\n";
        $player .= "            </CompanionAds>\n";
    }

    if ( $pluginType == 'vastOverlay') {
        $code = $resourceType = $creativeType = $elementName = '';
        switch($aOut['overlayFormat']) {
            case VAST_OVERLAY_FORMAT_HTML:
                $code = "<![CDATA[". $aOut['overlayMarkupTemplate'] . "]]>";
                $resourceType = 'HTML';
                $elementName = 'Code';
            break;

            case VAST_OVERLAY_FORMAT_IMAGE:
                $creativeType = strtoupper($aOut['overlayContentType']);
                // BC when the overlay_creative_type field is not set in the DB
                if(empty($creativeType)) {
                    $creativeType = strtoupper(substr($aOut['overlayFilename'], -3));
                    // case of .jpeg files OXPL-493
                    if($creativeType == 'PEG') {
                        $creativeType = 'JPEG';
                    }
                }
                if($creativeType == 'JPEG') {
                    $creativeType = 'JPG';
                }
                $creativeType = 'image/'.$creativeType;
                $code = getImageUrlFromFilename($aOut['overlayFilename']);
                $resourceType = 'static';
                $elementName = 'URL';
            break;

            case VAST_OVERLAY_FORMAT_SWF:
                $creativeType = 'application/x-shockwave-flash';
                $code = getImageUrlFromFilename($aOut['overlayFilename']);
                $resourceType = 'static';
                $elementName = 'URL';
            break;

            case VAST_OVERLAY_FORMAT_TEXT:
                $resourceType = 'TEXT';
                $code = "<![CDATA[
                	<Title>".xmlspecialchars($aOut['overlayTextTitle'])."</Title>
               		<Description>".xmlspecialchars($aOut['overlayTextDescription'])."</Description>
               		<CallToAction>".xmlspecialchars($aOut['overlayTextCall'])."</CallToAction>
               		]]>
               ";
                $elementName = 'Code';
            break;
        }

        if(!empty($aOut['clickUrl'])) {
            $nonLinearClickThrough = "<NonLinearClickThrough>
                    <URL><![CDATA[${aOut['clickUrl']}]]></URL>
                </NonLinearClickThrough>\n";
        }

        $creativeTypeAttribute = '';
        if(!empty($creativeType)) {
            $creativeType = strtolower($creativeType);
            $creativeTypeAttribute = 'creativeType="'. $creativeType .'"';
        }

        $player .= "             <NonLinearAds>\n";
        $player .= "                <NonLinear id=\"overlay\" width=\"${aOut['overlayWidth']}\" height=\"${aOut['overlayHeight']}\" resourceType=\"$resourceType\" $creativeTypeAttribute>\n";
        $player .= "                    <$elementName>
        									$code
        								</$elementName>\n";
        $player .= "                    $nonLinearClickThrough";
        $player .= "                </NonLinear>\n";
        $player .= "            </NonLinearAds>\n";
    }


    if ( isset($aOut['fullPathToVideo']) ){
        $player .= getVastVideoAdOutput($aOut);
    }
    $player .= "        </InLine>\n";
    $player .= "    </Ad>\n";
    return $player;
}


function renderPlayerInPage($aOut)
{
	$player = "";
	if ( isset($aOut['fullPathToVideo'] ) ){
		$player = <<<PLAYER
			<h3>Video ad preview</h3>
			<script type="text/javascript" src="{$aOut['videoPlayerJsUrl']}"></script>
			<style>
			a.player {
			    display:block;
			    width:640px;
			    height:360px;
			    margin:25px 0;
			    text-align:center;
			}
			</style>

			<a class="player" id="player"></a>
PLAYER;

		// encode data before echoing to the browser to prevent xss
		$aOut['videoFileName'] = encodeUserSuppliedData( $aOut['videoFileName'] );
        $aOut['videoNetConnectionUrl'] = encodeUserSuppliedData( $aOut['videoNetConnectionUrl'] );

		$httpPlayer = <<<HTTP_PLAYER

		    <!-- http flowplayer setup -->
            <script language="JavaScript">
            flowplayer("a.player", "${aOut['videoPlayerSwfUrl']}", {
               playlist: [ '${aOut['videoFileName']}' ],
                clip: {
                       autoPlay: ${aOut['isAutoPlayOfVideoInOpenXAdminToolEnabled']}
               },
               plugins: {

                   controls: {
                        url: escape('${aOut['videoPlayerControlsPluginUrl']}')
                   }
               }

            });
            </script>
HTTP_PLAYER;

        $rtmpPlayer = <<<RTMP_PLAYER

            <!-- rmtp flowplayer setup -->
            <script language="JavaScript">
            flowplayer("a.player", "${aOut['videoPlayerSwfUrl']}", {
               clip: {
                       url: '${aOut['videoFileName']}',
                       provider: 'streamer',
                       autoPlay: ${aOut['isAutoPlayOfVideoInOpenXAdminToolEnabled']}
               },

               plugins: {
                   streamer: {
                        // see http://flowplayer.org/forum/8/15861 for reason I use encode() function
                        url: escape('${aOut['videoPlayerRtmpPluginUrl']}'),
                        netConnectionUrl: '${aOut['videoNetConnectionUrl']}'
                   },
                   controls: {
                        url: escape('${aOut['videoPlayerControlsPluginUrl']}')
                   }
               }

            });
            </script>
RTMP_PLAYER;

        $webmPlayer = <<<WEBM_PLAYER

            <!-- HTML5 Webm setup -->
            <script type="text/javascript">
                (function (p) {
                    p.html('<video width="640" height="360" controls><source src="{$aOut['fullPathToVideo']}" type="{$aOut['vastVideoType']}"/>You need an HTML5 compatible player, sorry</video>');
                })($("#player"));
            </script>

WEBM_PLAYER;

        if ( $aOut['videoDelivery'] == 'player_in_http_mode' ){
            if ($aOut['vastVideoType'] == 'video/webm') {
                $player .= $webmPlayer;
            } else {
                $player .= $httpPlayer;
            }
        }
        else if ( $aOut['videoDelivery'] == 'player_in_rtmp_mode' ) {
            $player .= $rtmpPlayer;
        }
        else {
            // default to rtmp play format
            $player .= $rtmpPlayer;
        }
    }
    return $player;
}

function renderCompanionInAdminTool($aOut)
{
    $player = "";
    if(isset($aOut['companionMarkup'])) {
        $player .=  "<h3>Companion Preview (" .$aOut['companionWidth'] . "x" . $aOut['companionHeight'] . ")</h3>";
        $player .= $aOut['companionMarkup'];
        /*$aBanner = Admin_DA::getAd($aOut['companionId']);
        $aBanner['bannerid'] = $aOut['companionId'];
        $bannerCode = MAX_adRender($aBanner, 0, '', '', '', true, '', false, false);
        $player .=  "<h3>Companion Preview</h3>";
        $player .= "This companion banner will appear during the duration of the Video Ad in the DIV specified in the video player plugin configuration. ";
        if(!empty($aOut['companionWidth'])) {
            $player .= " It has the following dimensions: width = ". $aOut['companionWidth'] .", height = ".$aOut['companionHeight'] .". ";
        }
        $player .= "<a href='".VideoAdsHelper::getHelpLinkVideoPlayerConfig()."' target='_blank'>Learn more</a><br/><br/>";
        $player .= $bannerCode;*/
        $player .= "<br>";
    }
    return $player;
}

function renderOverlayInAdminTool($aOut, $aBanner)
{

    $title =  "Overlay Preview";
    $borderStart = "<div style='color:black;text-decoration:none;border:1px solid black;padding:15px;'>";
    $borderEnd = "</div>";
    $htmlOverlay = '';
    switch($aOut['overlayFormat']) {
        case VAST_OVERLAY_FORMAT_HTML:
            $htmlOverlay = $borderStart . $aOut['overlayMarkupTemplate'] . $borderEnd;
        break;

        case VAST_OVERLAY_FORMAT_IMAGE:
            $title = "Image Overlay Preview";
            $imagePath = getImageUrlFromFilename($aOut['overlayFilename']);
            $htmlOverlay = "<img border='0' src='$imagePath' />";
        break;

        case VAST_OVERLAY_FORMAT_SWF:
            $title = "SWF Overlay Preview";
            // we need to set a special state for adRenderFlash to work (which tie us to this implementation...)
            $aBanner['type'] = 'web';
            $aBanner['width'] = $aOut['overlayWidth'];
            $aBanner['height'] = $aOut['overlayHeight'];
            $htmlOverlay = _adRenderFlash($aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=false, $logView=false);
        break;

        case VAST_OVERLAY_FORMAT_TEXT:
            $title = "Text Overlay Preview";
            $overlayTitle = $aOut['overlayTextTitle'];
            $overlayDescription = str_replace("\n","<br/>",$aOut['overlayTextDescription']);
            $overlayCall = $aOut['overlayTextCall'];
            $htmlOverlay = "
            	$borderStart
                    <div style='font-family:arial;font-size:18pt;font-weight:bold;'>$overlayTitle </div>
                    <div style='font-family:arial;font-size:15pt;'>$overlayDescription</div>
                    <div style='font-family:arial;font-size:15pt;font-weight:bold;color:orange;'>$overlayCall</div>
                $borderEnd
            ";
        break;
    }


    $htmlOverlayPrepend = 'The overlay will appear on top of video content during video play.';

    switch($aOut['overlayFormat']) {
        case VAST_OVERLAY_FORMAT_IMAGE:
        case VAST_OVERLAY_FORMAT_SWF:
            $htmlOverlayPrepend .= " This overlay has the following dimensions: width = " . $aOut['overlayWidth'] . ", height = " . $aOut['overlayHeight'] . ".";
        break;
    }
    if ($aOut['overlayDestinationUrl']) {
        $htmlOverlayPrepend .= ' In the video player, this overlay will be clickable.';
        $htmlOverlay =  "<a target=\"_blank\" href=\"${aOut['overlayDestinationUrl']}\"> {$htmlOverlay}</a>";
    }

    $htmlOverlay = $htmlOverlayPrepend . '<br/><br/>' . $htmlOverlay;

    $player = "<h3>$title</h3>";
    $player .= $htmlOverlay;
    $player .= "<br>";
    return $player;
}

// if bcmath php extension not installed
if ( !(function_exists('bcmod'))) {
    /**
     * for extremely large numbers of seconds this will break
     * but for video we will never have extremely large numbers of seconds
     *
     * see http://www.php.net/manual/en/language.operators.arithmetic.php
     **/
    function bcmod( $x, $y )
    {
        $mod= $x % $y;

        return (int)$mod;
    }

}// end of if bcmath php extension not installed

function secondsToVASTDuration($seconds)
{
    $hours = intval(intval($seconds) / 3600);
    $minutes = bcmod((intval($seconds) / 60),60);
    $seconds = bcmod(intval($seconds),60);
    $ret = sprintf( "%02d:%02d:%02d", $hours, $minutes, $seconds );
    return $ret;
}