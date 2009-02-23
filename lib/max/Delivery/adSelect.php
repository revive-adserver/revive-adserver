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
 * @package    MaxDelivery
 * @subpackage adSelect
 * @author     Chris Nutting <chris@m3.net>
 *
 * This library contains the functions to select an ad either by zone or direct selection
 * and generate the HTML for an ad
 *
 * The code below makes several references to an "ad-array", this is /almost/ an ad-object, and implements
 * the following interface.
 *
 * Array
 *   (
 *       [ad_id] => 123
 *       [placement_id] => 4
 *       [active] => t
 *       [name] => Web Flash (With backup)
 *       [type] => web
 *       [contenttype] => swf
 *       [pluginversion] => 6
 *       [filename] => banner_468x60.swf
 *       [imageurl] =>
 *       [htmltemplate] =>
 *       [htmlcache] =>
 *       [width] => 468
 *       [height] => 60
 *       [weight] => 1
 *       [seq] => 0
 *       [target] => _blank
 *       [url] => http://www.example.net/landing_page/
 *       [alt] =>
 *       [status] =>
 *       [bannertext] =>
 *       [adserver] =>
 *       [block] => 0
 *       [capping] => 0
 *       [session_capping] => 0
 *       [compiledlimitation] =>
 *       [acl_plugins] =>
 *       [append] =>
 *       [appendtype] => 0
 *       [bannertype] => 0
 *       [alt_filename] => backup_banner_468x60.gif
 *       [alt_imageurl] =>
 *       [alt_contenttype] => gif
 *       [campaign_priority] => 5
 *       [campaign_weight] => 0
 *       [campaign_companion] => 0
 *       [priority] => 0.10989010989
 *       [zoneid] => 567
 *       [bannerid] => 123
 *       [storagetype] => web
 *       [campaignid] => 4
 *       [zone_companion] =>
 *       [prepend] =>
 *   )
 *
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.php';
require_once MAX_PATH . '/lib/max/Delivery/adRender.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

/**
 * This is the main ad selection and rendering function
 *
 * @param string  $what         The ad-selection string, colon seperated name=value
 *                              e.g. bannerid=X, campaignid=Y, zone:Z or search:criteria
 * @param string  $campaignid   The campaign ID to fecth banners from, added in 2.3.32 to allow BC with 2.0
 * @param string  $target       The target attribute for generated <a href> links
 * @param string  $source       The "source" parameter passed into the adcall
 * @param int     $withtext     Should "text below banner" be appended to the generated code
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 * @param boolean $richmedia    Does this invocation method allow for serving 3rd party/html ads
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return array                An array containing selected banner information, including generated HTML
 *                      example:
 *                      Array
 *                      (
 *                          [html] =>
 *                              <div id='m3_7e8d56ca8e5231613e0c41ab149b8cab' style='display: inline;'><a href='http://d.dev.m3.net/ck.php?maxparams=2__bannerid=123__zoneid=567__cb=7ff857d85a' target='_blank'><img src='http://max.images.example.net/backup_banner_468x60.gif' width='468' height='60' alt='' title='' border='0'></a></div>
 *                              <script type='text/javascript'>
 *                                  var fo = new FlashObject('http://max.images.example.net/banner_468x60.swf?clickTARGET=_blank&clickTAG=http://delivery.max.example.com/ck.php?maxparams=2__bannerid=123__zoneid=567__cb=7ff857d85a', 'mymovie', '468', '60', '6');
 *                                  //fo.addParam('wmode','transparent');
 *                                  fo.write('m3_7e8d56ca8e5231613e0c41ab149b8cab');
 *                              </script><div id='beacon_123' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://delivery.max.example.com/lg.php?bannerid=123&amp;campaignid=4&amp;zoneid=567&amp;source=&amp;block=0&amp;capping=0&amp;session_capping=0&amp;loc=http%3A%2F%2Flocalhost%2Ftest%2Finvocationh.html&amp;referer=http%3A%2F%2Flocalhost%2Ftest%2F&amp;cb=7ff857d85a' width='0' height='0' alt='' style='width: 0px; height: 0px;'></div>
 *                          [bannerid] => 123
 *                          [contenttype] => swf
 *                          [alt] =>
 *                          [width] => 468
 *                          [height] => 60
 *                          [url] => http://www.example.net/landing_page/
 *                          [campaignid] => 4
 *                          [context] => Array
 *                              (
 *                              )
 *                      )
 */
function MAX_adSelect($what, $campaignid = '', $target = '', $source = '', $withtext = 0, $charset = '', $context = array(), $richmedia = true, $ct0 = '', $loc = '', $referer = '')
{
    $conf = $GLOBALS['_MAX']['CONF'];

    // For local mode and XML-RPC calls the some parameters are not set in the global scope
    // So we need to override the empty globals with the values passed into this function.
    if (empty($GLOBALS['source'])) {
        $GLOBALS['source'] = $source;
    }
    if (empty($GLOBALS['loc'])) {
        $GLOBALS['loc'] = $loc;
    }

    // Store the original zone, campaign or banner IDs for later use
    if (strpos($what,'zone:') === 0) {
        $originalZoneId = intval(substr($what,5));
    } elseif (strpos($what,'campaignid:') === 0) {
        $originalCampaignId = intval(substr($what,11));
    } elseif (strpos($what, 'bannerid:') === 0) {
        $originalBannerId = intval(substr($what,9));
    }
    $userid = MAX_cookieGetUniqueViewerID();
    MAX_cookieSet($conf['var']['viewerId'], $userid, _getTimeYearFromNow());
    $outputbuffer = '';
    // Set flag
    $found = false;
    // Reset followed zone chain
    $GLOBALS['_MAX']['followedChain'] = array();
    $GLOBALS['_MAX']['adChain'] = array();

    $first = true;
    global $g_append, $g_prepend;
    $g_append = '';
    $g_prepend = '';
    while ($first || ($what != '' && $found == false)) {
        $first = false;
        // Get first part, store second part
        $ix = strpos($what, '|');
        if ($ix === false) {
            $remaining = '';
        } else {
            $remaining = substr($what, $ix+1);
            $what = substr($what, 0, $ix);
        }
        if (strpos($what, 'zone:') === 0) {
            $zoneId  = intval(substr($what,5));
            $row = _adSelectZone($zoneId, $context, $source, $richmedia);
        } else {
            // Expand paths to regular statements
            if (strpos($what, '/') > 0) {
                if (strpos($what, '@') > 0) {
                    list ($what, $append) = explode ('@', $what);
                } else {
                    $append = '';
                }

                $separate  = explode ('/', $what);
                $expanded  = '';
                $collected = array();

                reset($separate);
                while (list(,$v) = each($separate)) {
                    $expanded .= ($expanded != '' ? ',+' : '') . $v;
                    $collected[] = $expanded . ($append != '' ? ',+'.$append : '');
                }

                $what = strtok(implode('|', array_reverse ($collected)), '|');
                $remaining = strtok('').($remaining != '' ? '|'.$remaining : '');
            }

            $row = _adSelectDirect($what, $campaignid, $context, $source, $richmedia, $remaining == '');
        }
        if (is_array($row) && empty($row['default'])) {
            // Log the ad request
            MAX_Delivery_log_logAdRequest($row['bannerid'], $row['zoneid'], $row);
            if (($row['adserver'] == 'max' || $row['adserver'] == '3rdPartyServers:ox3rdPartyServers:max')
                && preg_match("#{$conf['webpath']['delivery']}.*zoneid=([0-9]+)#", $row['htmltemplate'], $matches) && !stristr($row['htmltemplate'], $conf['file']['popup'])) {
                // The ad selected was an OpenX HTML ad on the same server... do internal redirecty stuff
                $GLOBALS['_MAX']['adChain'][] = $row;
                $found = false;
                $what = "zone:{$matches[1]}";
            } else {
                $found = true;
            }
        } else {
          $what  = $remaining;
        }
    }

    // Return the banner information
    if ($found) {
        $zoneId = empty($row['zoneid']) ? 0 : $row['zoneid'];
        // For internal redirected creatives, make sure that any appended code in the adChain is appended
        if (!empty($GLOBALS['_MAX']['adChain'])) {
            foreach ($GLOBALS['_MAX']['adChain'] as $index => $ad) {
                if (($ad['ad_id'] != $row['ad_id']) && !empty($ad['append'])) {
                    $row['append'] .= $ad['append'];
                }
            }
        }
        $outputbuffer = MAX_adRender($row, $zoneId, $source, $target, $ct0, $withtext, $charset, true, true, $richmedia, $loc, $referer, $context);
        $output = array(
            'html'          => $outputbuffer,
            'bannerid'      => $row['bannerid'],
            'contenttype'   => $row['contenttype'],
            'alt'           => $row['alt'],
            'width'         => $row['width'],
            'height'        => $row['height'],
            'url'           => $row['url'],
            'campaignid'    => $row['campaignid'],
            'clickUrl'      => $row['clickUrl'],
            'logUrl'        => $row['logUrl'],
            'aSearch'       => $row['aSearch'],
            'aReplace'      => $row['aReplace'],
            'bannerContent' => $row['bannerContent'],
            'clickwindow'   => $row['clickwindow'],
            'aRow'          => $row,
            'context'       => _adSelectBuildContext($row, $context)
        );
        // If ad-logging is disabled, the log beacon won't be sent, so set the capping at request
        if (MAX_Delivery_cookie_cappingOnRequest()) {
            if ($row['block_ad'] > 0 || $row['cap_ad'] > 0 || $row['session_cap_ad'] > 0) {
                MAX_Delivery_cookie_setCapping('Ad', $row['bannerid'], $row['block_ad'], $row['cap_ad'], $row['session_cap_ad']);
            }
            if ($row['block_campaign'] > 0 || $row['cap_campaign'] > 0 || $row['session_cap_campaign'] > 0) {
                MAX_Delivery_cookie_setCapping('Campaign', $row['campaign_id'], $row['block_campaign'], $row['cap_campaign'], $row['session_cap_campaign']);
            }
            if ($row['block_zone'] > 0 || $row['cap_zone'] > 0 || $row['session_cap_zone'] > 0) {
                MAX_Delivery_cookie_setCapping('Zone', $row['zoneid'], $row['block_zone'], $row['cap_zone'], $row['session_cap_zone']);
            }
            // Store the last view action event om the cookie as well (if required)
            MAX_Delivery_log_setLastAction(0, array($row['bannerid']), array($zoneId), array($row['viewwindow']));
        }
        return $output;
    } else {
        // No banner found
        if (!empty($row['default'])) {
            // Return the default banner
            if (empty($target)) {
                $target = '_blank';  // Default
            }
            $outputbuffer = $g_prepend . '<a href=\'' . $row['default_banner_destination_url'] . '\' target=\'' .
                            $target . '\'><img src=\'' . $row['default_banner_image_url'] .
                            '\' border=\'0\' alt=\'\'></a>' . $g_append;
            return array('html' => $outputbuffer, 'bannerid' => '', 'default_banner_image_url' => $row['default_banner_image_url'] );
        } else {
            // No default banner was returned, return no banner
            $outputbuffer = $g_prepend . $g_append;
            return array('html' => $outputbuffer, 'bannerid' => '' );
        }
    }
}

/**
 * This function selects an ad selected by direct selection
 *
 * @param string  $what         The search term being used to select the ad
 * @param string  $campaignid   The campaign ID to fecth banners from, added in 2.3.32 to allow BC with 2.0
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 * @param string  $source       The "source" parameter passed into the adcall
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 * @param boolean $lastpart     Are there any other search strings left
 *
 * @return array|false          Returns an ad-array (see page DocBlock) or false if no ad found
 */
function _adSelectDirect($what, $campaignid = '', $context = array(), $source = '', $richMedia = true, $lastpart = true)
{
    $aDirectLinkedAds = MAX_cacheGetLinkedAds($what, $campaignid, $lastpart);

    $aLinkedAd = _adSelectCommon($aDirectLinkedAds, $context, $source, $richMedia);

    if (is_array($aLinkedAd)) {
        $aLinkedAd['zoneid'] = 0;
        $aLinkedAd['bannerid'] = $aLinkedAd['ad_id'];
        $aLinkedAd['storagetype'] = $aLinkedAd['type'];
        $aLinkedAd['campaignid'] = $aLinkedAd['placement_id'];
        $aLinkedAd['prepend'] = '';

        return $aLinkedAd;
    }
    if (!empty($aDirectLinkedAds['default_banner_image_url'])) {
        return array(
           'default'                        => true,
           'default_banner_image_url'       => $aZoneLinkedAds['default_banner_image_url'],
           'default_banner_destination_url' => $aZoneLinkedAds['default_banner_destination_url']
        );
    }

    return false;
}


/**
 * Returns an id of the next's zone in the chain specified in $arrZone
 * or $zoneId if there is no chained zone.
 *
 * @param int $zoneId Zone id to be returned if the chain was not found.
 * @param array $arrZone An associative array with an attribute 'chain' which
 *              contains zone's chain specification.
 * @return int Id of the next zone in the chain or $zoneId if there is no chain.
 */
function _getNextZone($zoneId, $arrZone)
{
    if (!empty($arrZone['chain']) && (substr($arrZone['chain'],0,5) == 'zone:')) {
        return intval(substr($arrZone['chain'],5));
    }
    else {
        return $zoneId;
    }
}



/**
 * This function selects an ad selected from a specific zone
 *
 * @param int     $zoneId       The ID of the zone to select an ad from
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 * @param string  $source       The "source" parameter passed into the adcall
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 *
 * @return array|false          Returns an ad-array (see page DocBlock) or false if no ad found
 */
function _adSelectZone($zoneId, $context = array(), $source = '', $richMedia = true)
{
    global $g_append, $g_prepend;
    while (!in_array($zoneId, $GLOBALS['_MAX']['followedChain'])) {
        $GLOBALS['_MAX']['followedChain'][] = $zoneId;
        $appendedThisZone = false;

        // Get all ads which are linked to the zone
        $aZoneLinkedAds = MAX_cacheGetZoneLinkedAds($zoneId);

        if ($zoneId != 0 && MAX_limitationsIsZoneForbidden($zoneId, $aZoneLinkedAds)) {
            $zoneId = _getNextZone($zoneId, $aZoneLinkedAds);
            continue;
        }

        if (is_array($aZoneLinkedAds)) {
            if (isset($aZoneLinkedAds['forceappend']) && $aZoneLinkedAds['forceappend'] == 't') {
                $g_prepend .= $aZoneLinkedAds['prepend'];
                $g_append = $aZoneLinkedAds['append'] . $g_append;
                $appendedThisZone = true;
            }

            $aLinkedAd = _adSelectCommon($aZoneLinkedAds, $context, $source, $richMedia);

            if (is_array($aLinkedAd)) {
                $aLinkedAd['zoneid'] = $zoneId;
                $aLinkedAd['bannerid'] = $aLinkedAd['ad_id'];
                $aLinkedAd['storagetype'] = $aLinkedAd['type'];
                $aLinkedAd['campaignid'] = $aLinkedAd['placement_id'];
                $aLinkedAd['zone_companion'] = $aZoneLinkedAds['zone_companion'];
                $aLinkedAd['block_zone'] = $aZoneLinkedAds['block_zone'];
                $aLinkedAd['cap_zone'] = $aZoneLinkedAds['cap_zone'];
                $aLinkedAd['session_cap_zone'] = $aZoneLinkedAds['session_cap_zone'];

                if (!$appendedThisZone) {
                    $aLinkedAd['append'] .= $aZoneLinkedAds['append'] . $g_append;
                    $aLinkedAd['prepend'] = $g_prepend . $aZoneLinkedAds['prepend'];
                } else {
                    $aLinkedAd['append'] .= $g_append;
                    $aLinkedAd['prepend'] = $g_prepend;
                }
                return ($aLinkedAd);
            }

            $zoneId = _getNextZone($zoneId, $aZoneLinkedAds);
        }
    }
    if (!empty($aZoneLinkedAds['default_banner_image_url'])) {
        return array(
           'default'                        => true,
           'default_banner_image_url'       => $aZoneLinkedAds['default_banner_image_url'],
           'default_banner_destination_url' => $aZoneLinkedAds['default_banner_destination_url']
        );
    }

    return false;
}


/**
 * This function selects an ad cyclying through exclusive, paid, low-pri etc.
 *
 * @param string  $aAds         The array of ads to pick from
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 * @param string  $source       The "source" parameter passed into the adcall
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 *
 * @return array|false          Returns an ad-array (see page DocBlock) or false if no ad found
 */
function _adSelectCommon($aAds, $context, $source, $richMedia)
{
    // Are there any ads linked?
    if (!empty($aAds['count_active'])) {
        // Get an ad from the any exclusive campaigns first...
        $aLinkedAd = _adSelect($aAds, $context, $source, $richMedia, 'xAds');
        // If no ad selected, and a previous ad on the page has set that companion ads should be selected...
        if (!is_array($aLinkedAd) && isset($aAds['zone_companion']) && is_array($aAds['zone_companion']) && !empty($context)) {
            // The companion paid ads are now grouped by campaign-priority so we need to iterate over the
            for ($i=10;$i>0;$i--) {
                if (!empty($aAds['cAds'][$i])) {
                    $aLinkedAd = _adSelect($aAds, $context, $source, $richMedia, 'cAds', $i);
                    // Did we pick an ad from this campaign-priority level?
                    if (is_array($aLinkedAd)) { break; }
                }
            }
            // If still no ad selected...
            if (!is_array($aLinkedAd)) {
                // Select one of the low-priority companion ads
                $aLinkedAd = _adSelect($aAds, $context, $source, $richMedia, 'clAds');
            }
        }
        // If still no ad selected...
        if (!is_array($aLinkedAd)) {
            // Select one of the normal ads
            // The normal ads are now grouped by campaign-priority so we need to iterate over the
            for ($i=10;$i>0;$i--) {
                if (!empty($aAds['ads'][$i])) {
                    $aLinkedAd = _adSelect($aAds, $context, $source, $richMedia, 'ads', $i);
                    // Did we pick an ad from this campaign-priority level?
                    if (is_array($aLinkedAd)) { break; }
                }
            }
        }
        // If still no ad selected...
        if (!is_array($aLinkedAd)) {
            // Select one of the low-priority ads
            $aLinkedAd = _adSelect($aAds, $context, $source, $richMedia, 'lAds');
        }
        if (!is_array($aLinkedAd)) {
            // Select one of the low-priority ads
            $aLinkedAd = _adSelect($aAds, $context, $source, $richMedia, 'eAds', -2);
        }
        if (is_array($aLinkedAd)) {
            return $aLinkedAd;
        }
    }

    return false;
}


/**
 * This function takes a group of ads, and selects the ad to show
 *
 * @param array   $aLinkedAds   The array of possible ads for this search criteria
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 * @param string  $source       The "source" parameter passed into the adcall
 * @param boolean $richmedia    Does this invocation method allow for serving 3rd party/html ads
 * @param string  $adArrayVar   The collection of ads in $aLinkedAds to select the ad from
 * @param integer $
 *
 * @return array|void           The ad-array for the selected ad or void if no ad selected
 */
function _adSelect(&$aLinkedAds, $context, $source, $richMedia, $adArrayVar = 'ads', $cp = null)
{
    // If there are no linked ads, we can return
    if (!is_array($aLinkedAds)) { return; }

    if (!is_null($cp) && isset($aLinkedAds[$adArrayVar][$cp])) {
        $aAds = $aLinkedAds[$adArrayVar][$cp];
    } elseif (isset($aLinkedAds[$adArrayVar])) {
        $aAds = $aLinkedAds[$adArrayVar];
    } else {
        $aAds = array();
    }

    // If there are no linked ads of the specified type, we can return
    if (count($aAds) == 0) { return; }

    // Build preconditions
    $aContext = _adSelectBuildContextArray($aAds, $adArrayVar, $context);

    // New delivery algorithm: discard all invalid ads before iterating over them
    $aAds = _adSelectDiscardNonMatchingAds($aAds, $aContext, $source, $richMedia);

    // If there are no linked ads of the specified type, we can return
    if (count($aAds) == 0) { return; }

    if (!is_null($cp)) {
        // Scale priorities
        $total_priority = 0;
        foreach ($aAds as $ad) {
            $total_priority += $ad['priority'] * $ad['priority_factor'];
        }

        if ($total_priority) {
            if ($adArrayVar == 'eAds') {
                foreach ($aAds as $key => $ad) {
                    $aAds[$key]['priority'] = $ad['priority']
                        * $ad['priority_factor'] / $total_priority;
                }
            } else {
                foreach ($aAds as $key => $ad) {
                    $aAds[$key]['priority'] = $ad['priority'] * $ad['priority_factor'] *
                        $aLinkedAds['priority'][$adArrayVar][$cp] / $total_priority;
                }
            }
        }
    }

    // Seed the random number generator
    global $n;
    mt_srand(floor((isset($n) && strlen($n) > 5 ? hexdec($n[0].$n[2].$n[3].$n[4].$n[5]): 1000000) * (double)microtime()));

    $conf = $GLOBALS['_MAX']['CONF'];

    $paidAds = ($adArrayVar == 'ads') || (empty($aContext) && $adArrayVar == 'cAds') || ($adArrayVar == 'eAds');

    if ($paidAds) {
        // Paid campaigns have a sum of priorities of unity, so pick
        // a float random number between 0 and 1, inclusive.
        $ranweight = (mt_rand(0, $GLOBALS['_MAX']['MAX_RAND']) / $GLOBALS['_MAX']['MAX_RAND']);
    } else {
        // All other campaigns have integer-based priority values, so
        // select an integer random number between 0 and the sum of all the
        // priority values
        $prioritysum = 0;
        foreach ($aAds as $aAd) {
            $prioritysum += $aAd['priority'];
        }
        if (!$prioritysum) {
            // No priority, exit!
            return;
        }
        $ranweight = ($prioritysum > 1) ? mt_rand(0, $prioritysum - 1) : 0;
    }

    // Perform selection of an ad, based on the random number
    $low = 0;
    $high = 0;
    foreach($aAds as $aLinkedAd) {
        if (is_array($aLinkedAd)) {
            $low = $high;
            $high += $aLinkedAd['priority'];
            if ($high > $ranweight && $low <= $ranweight) {
                return $aLinkedAd;
            }
        }
    }

    return;
}

/**
 * Enter description here...
 *
 * @param unknown_type $aAd
 * @param unknown_type $context
 * @param unknown_type $source
 * @param unknown_type $richMedia
 */
function _adSelectCheckCriteria($aAd, $aContext, $source, $richMedia)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    // Excludelist banners
    if (isset($aContext['banner']['exclude'][$aAd['ad_id']])) {
        ###START_STRIP_DELIVERY
        OA::debug('List of excluded banners list contains bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if (isset($aContext['campaign']['exclude'][$aAd['placement_id']])) {
        // Excludelist campaigns
        ###START_STRIP_DELIVERY
        OA::debug('List of excluded campaigns contains bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if (isset($aContext['client']['exclude'][$aAd['client_id']])) {
        // Excludelist clients
        ###START_STRIP_DELIVERY
        OA::debug('List of excluded clients contains bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if (sizeof($aContext['banner']['include']) && !isset($aContext['banner']['include'][$aAd['ad_id']])) {
        // Includelist banners
        ###START_STRIP_DELIVERY
        OA::debug('List of included banners does not contain bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if (sizeof($aContext['campaign']['include']) && !isset($aContext['campaign']['include'][$aAd['placement_id']])) {
        // Includelist campaigns
        ###START_STRIP_DELIVERY
        OA::debug('List of included campaigns does not contain bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if (   // Exclude richmedia banners if no alt image is specified
        $richMedia == false &&
        $aAd['alt_filename'] == '' &&
        !($aAd['contenttype'] == 'jpeg' || $aAd['contenttype'] == 'gif' || $aAd['contenttype'] == 'png') &&
        !($aAd['type'] == 'url' && $aAd['contenttype'] == '')
       ) {
        ###START_STRIP_DELIVERY
        OA::debug('No alt image specified for richmedia bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if (MAX_limitationsIsAdForbidden($aAd)) {
        // Capping & blocking
        ###START_STRIP_DELIVERY
        OA::debug('MAX_limitationsIsAdForbidden = true for bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if ($_SERVER['SERVER_PORT'] == 443 && $aAd['type'] == 'html' &&
        (($aAd['adserver'] != 'max' && $aAd['adserver'] != '3rdPartyServers:ox3rdPartyServers:max') || preg_match("#src\s?=\s?['\"]http:#", $aAd['htmlcache']))) {
        // HTML Banners that contain 'http:' on SSL
        ###START_STRIP_DELIVERY
        OA::debug('"http:" on SSL found for html bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if ($_SERVER['SERVER_PORT'] == 443 && $aAd['type'] == 'url' && (substr($aAd['imageurl'], 0, 5) == 'http:')) {
        // It only matters if the initial call is to non-SSL (it can/could contain http:)
        ###START_STRIP_DELIVERY
        OA::debug('"http:" on SSL found in imagurl for url bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    if ($conf['delivery']['acls'] && !MAX_limitationsCheckAcl($aAd, $source)) {
        // Delivery limitations
        ###START_STRIP_DELIVERY
        OA::debug('MAX_limitationsCheckAcl = false for bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        return false;
    }

    // If any of the above failed, this function will have already returned false
    // So to get this far means that the ad was valid
    return true;
}

function _adSelectBuildContextArray(&$aLinkedAds, $adArrayVar, $context)
{
    $aContext = array(
        'campaign' => array('exclude' => array(), 'include' => array()),
        'banner'   => array('exclude' => array(), 'include' => array()),
        'client'   => array('exclude' => array(), 'include' => array()),
    );

    if (is_array($context) && !empty($context)) {
        $cContext = count($context);
        for ($i=0; $i < $cContext; $i++) {
            reset($context[$i]);
            list ($key, $value) = each($context[$i]);

            $valueArray = explode(':', $value);

            if (count($valueArray) == 1) {
                list($value) = $valueArray;
                $type = "";
            } else {
                list($type, $value) = $valueArray;
            }

            switch($type) {
                case 'campaignid':
                    switch ($key) {
                        case '!=': $aContext['campaign']['exclude'][$value] = true; break;
                        case '==': $aContext['campaign']['include'][$value] = true; break;
                    }
                break;
                case 'clientid':
                    switch ($key) {
                        case '!=': $aContext['client']['exclude'][$value] = true; break;
                        case '==': $aContext['client']['include'][$value] = true; break;
                    }
                break;
                case 'companionid':
                    switch ($key) {
                        case '!=': $aContext['campaign']['exclude'][$value]   = true; break;
                        case '==': $aContext['campaign']['include'][$value] = true; break;
                    }
                break;
                default:
                    switch ($key) {
                        case '!=': $aContext['banner']['exclude'][$value] = true; break;
                        case '==': $aContext['banner']['include'][$value] = true; break;
                    }
            }
        }
    }

    return $aContext;
}

/**
 * This function builds the context array to track which ads/campaigns have been shown on the current page
 *
 * @param array $aBanner      The ad-array for the ad to render code for
 * @param array $context      The context of this ad selection
 *                            - used for companion positioning
 *                            - and excluding banner/campaigns from this ad-call
 * @return array              The updated context array
 */
function _adSelectBuildContext($aBanner, $context = array()) {
    if (!empty($aBanner['zone_companion'])) {
        // This zone call has companion banners linked to it.
        // So pass into the next call that we would like a banner from this campaign, and not from the other companion linked campaigns;
        foreach ($aBanner['zone_companion'] AS $companionCampaign) {
            $key = ($aBanner['placement_id'] == $companionCampaign) ? '==' : '!=';
            $context[] = array($key => "companionid:$companionCampaign");
        }
    }
    if (isset($aBanner['advertiser_limitation']) && $aBanner['advertiser_limitation'] == '1') {
        $context[] = array('!=' => 'clientid:' . $aBanner['client_id']);
    }
    return $context;
}

/**
 * This function removes any ads which cannot be shown for the current impression
 *
 * @param array $aAds - The array of ads to be evaluated
 * @param  $aContext
 * @param unknown_type $source
 * @param unknown_type $richMedia
 * @return unknown
 */
function _adSelectDiscardNonMatchingAds($aAds, $aContext, $source, $richMedia)
{
    foreach ($aAds as $adId => $aAd) {
        ###START_STRIP_DELIVERY
        OA::debug('_adSelectDiscardNonMatchingAds: checking bannerid '.$aAd['ad_id'].' '.$aAd['name']);
        ###END_STRIP_DELIVERY
        if (!_adSelectCheckCriteria($aAd, $aContext, $source, $richMedia)) {
            ###START_STRIP_DELIVERY
            OA::debug('failed _adSelectCheckCriteria: bannerid '.$aAd['ad_id'].' '.$aAd['name']);
            ###END_STRIP_DELIVERY
            unset($aAds[$adId]);
        } else {
            ###START_STRIP_DELIVERY
            OA::debug('passed _adSelectCheckCriteria: bannerid '.$aAd['ad_id'].' '.$aAd['name']);
            ###END_STRIP_DELIVERY
        }
    }
    return $aAds;
}

?>
