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



MAX_commonRegisterGlobalsArray(array('format', 'clientdebug'));

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonDelivery.php';
if(!is_callable('MAX_adSelect')) {
    require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
}

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 *
 * This function generates the code to show a "vast" ad
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param boolean $useAlt       Should the backup file be used for this code
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function Plugin_BannerTypeHTML_vastBannerTypeHtml_vastHtml_delivery()
{
    return true;
}

function Plugin_BannerTypeHTML_vastBannerTypeHtml_vastHtml_Delivery_postAdRender()
{
    return true;
}


function Plugin_bannerTypeHtml_vastInlineBannerTypeHtml_vastInlineHtml_Delivery_adRender(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $loc, $referer)
{
    return deliverVastAd('vastInline', $aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $loc, $referer);
}

// End of functions


if ( !empty($format) && $format == 'vast'){

    // ----------------- MARK start of cut-and-paste from spc.php ---------------
    require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
    require_once MAX_PATH . '/lib/max/Delivery/flash.php';
    require_once MAX_PATH . '/lib/max/Delivery/javascript.php';
    ###START_STRIP_DELIVERY
    OX_Delivery_logMessage('starting delivery script '.__FILE__, 7);
    ###END_STRIP_DELIVERY
    MAX_commonSetNoCacheHeaders();
    MAX_commonRegisterGlobalsArray(array('zones' ,'source', 'block', 'blockcampaign', 'exclude', 'mmm_fo', 'q', 'nz'));
    $source = MAX_commonDeriveSource($source);
    $zones = explode('|', $zones);
    // ----------------- MARK end of cut-and-paste from spc.php ---------------
    if ( $format == 'vast' ){
        $spc_output  = getVastXMLHeader($charset);
    }

    // -------------- MARK start cut-and-paste from spc.php --------------------
    // This code was cut and pasted as we also need access to this business logic
    else {
        $spc_output = 'var ' . $conf['var']['prefix'] . 'output = new Array(); ' . "\n";
    }
    foreach ($zones as $thisZone) {
        if (empty($thisZone)) continue;
        // nz is set when "named zones" are being used, this allows a zone to be selected more than once
        if (!empty($nz)) {
            @list($zonename,$thisZoneid) = explode('=', $thisZone);
            $varname = $zonename;
        } else {
            $thisZoneid = $varname = $thisZone;
        }

        ###START_STRIP_DELIVERY
        appendClientMessage( "Processing zoneid:|$thisZoneid| zonename:|$varname|" );
        ###END_STRIP_DELIVERY

        $what = 'zone:'.$thisZoneid;

        ###START_STRIP_DELIVERY
        OX_Delivery_logMessage('$what='.$what, 7);
        OX_Delivery_logMessage('$context='.print_r($context,true), 7);
        ###END_STRIP_DELIVERY

        // Get the banner
        $output = MAX_adSelect($what, $clientid, $target, $source, $withtext, $charset, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

        ###START_STRIP_DELIVERY
        OX_Delivery_logMessage('$block='.$block, 7);
        //OX_Delivery_logMessage(print_r($output, true), 7);
        OX_Delivery_logMessage('output bannerid='.(empty($output['bannerid']) ? ' NO BANNERID' : $output['bannerid']), 7);
        ###END_STRIP_DELIVERY

        // BM - output format is vast xml
        if ( $format == 'vast' ){

            if (  $output['html']  && 
                 (
                     ($output['width'] != VAST_OVERLAY_DIMENSIONS) && 
                     ($output['width'] != VAST_INLINE_DIMENSIONS) 
                 )
               ){
                $badZoneId = $output['aRow']['zoneid'];
                $badBannerId = $output['bannerid'];
                // Store the html2js'd output for this ad
                $spc_output .= "<!-- You are requesting vast xml for zone $badZoneId which does not apear to be a video overlay banner nor a vast inline banner. -->\n";
            } else {
                // Store the html2js'd output for this ad
                $spc_output .= $output['html'] . "\n";
            }
  
            // Help the player (requestor of VAST) to match the ads in the response with his request by using his id in the Ad xml node
            $spc_output = str_replace( '{player_allocated_ad_id}', $varname, $spc_output );
        }
        else {
            // Store the html2js'd output for this ad
            $spc_output .= MAX_javascriptToHTML($output['html'], $conf['var']['prefix'] . "output['{$varname}']", false, false) . "\n";
        }

        // Block this banner for next invocation
        if (!empty($block) && !empty($output['bannerid'])) {
            $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
        }
        // Block this campaign for next invocation
        if (!empty($blockcampaign) && !empty($output['campaignid'])) {
            $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
        }

        // Pass the context array back to the next call, have to iterate over elements to prevent duplication
        if (!empty($output['context'])) {
            foreach ($output['context'] as $id => $contextArray) {
                if (!in_array($contextArray, $context)) {
                    $context[] = $contextArray;
                }
            }
        }
    }
    MAX_cookieFlush();
    // -------------- MARK end cut-and-paste from spc.php --------------------

    if ( $format == 'vast' ){
        $spc_output .=  getVastXMLFooter();
        // Setup the banners for this page
        MAX_commonSendContentTypeHeader("application/xml", $charset);
        header("Content-Length: ".strlen($spc_output));
    }
    else {
        // Setup the banners for this page
        MAX_commonSendContentTypeHeader("application/x-javascript", $charset);
        header("Content-Length: ".strlen($spc_output));
    }
    $spc_output .= getClientMessages();
    echo $spc_output;
}
else {
   //echo "<!-- vast delivery include called -->";
}

