<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * @package    MaxDelivery
 * @subpackage adSelect
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

define ("PRI_ECPM_FROM", 6);
define ("PRI_ECPM_TO", 9);

/**
 * A "constant" that is used by _adSelect() to inform the caller _adSelectCommon()
 * that any other remaining campaign priority levels need to be skipped.
 *
 * @var int
 */
$GLOBALS['OX_adSelect_SkipOtherPriorityLevels'] = -1;


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
    $originalZoneId = null;
    if (strpos($what,'zone:') === 0) {
        $originalZoneId = intval(substr($what,5));
    } elseif (strpos($what,'campaignid:') === 0) {
        $originalCampaignId = intval(substr($what,11));
    } elseif (strpos($what, 'bannerid:') === 0) {
        $originalBannerId = intval(substr($what,9));
    }
    $userid = MAX_cookieGetUniqueViewerId();
    MAX_cookieAdd($conf['var']['viewerId'], $userid, _getTimeYearFromNow());
    $outputbuffer = '';
    // Set flag
    $found = false;
    // Reset followed zone chain
    $GLOBALS['_MAX']['followedChain'] = array();
    $GLOBALS['_MAX']['adChain'] = array();

    // Reset considered ads set
    $GLOBALS['_MAX']['considered_ads'] = array();

    $first = true;
    global $g_append, $g_prepend;
    $g_append = '';
    $g_prepend = '';
    if(!empty($what)) {
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
                    // Log the ad request
                    MAX_Delivery_log_logAdRequest(null, $originalZoneId, null);
                    $what  = $remaining;
	        }
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
            'context'       => _adSelectBuildContext($row, $context),
            'iframeFriendly' => (bool)$row['iframe_friendly'],
        );
        // Init block/capping fields to avoid notices below
        $row += array(
            'block_ad'             => 0,
            'cap_ad'               => 0,
            'session_cap_ad'       => 0,
            'block_campaign'       => 0,
            'cap_campaign'         => 0,
            'session_cap_campaign' => 0,
            'block_zone'           => 0,
            'cap_zone'             => 0,
            'session_cap_zone'     => 0,
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
    } else {

        // Blank impression beacon
        if (!empty($zoneId)) {
            $logUrl = _adRenderBuildLogURL(array(
                'ad_id' => 0,
                'placement_id' => 0,
            ), $zoneId, $source, $loc, $referer, '&');
            $g_append = str_replace('{random}', MAX_getRandomNumber(), MAX_adRenderImageBeacon($logUrl)).$g_append;
        }

        // No banner found
        if (!empty($row['default'])) {
            // Return the default banner
            if (empty($target)) {
                $target = '_blank';  // Default
            }
            $outputbuffer = $g_prepend . '<a href=\'' . $row['default_banner_destination_url'] . '\' target=\'' .
                            $target . '\'><img src=\'' . $row['default_banner_image_url'] .
                            '\' border=\'0\' alt=\'\'></a>' . $g_append;
            $output = array('html' => $outputbuffer, 'bannerid' => '', 'default_banner_image_url' => $row['default_banner_image_url'] );
        } else if (!empty($conf['defaultBanner']['imageUrl'])) {
            // Return the default banner
            if (empty($target)) {
                $target = '_blank';  // Default
            }
            $outputbuffer = "{$g_prepend}<img src='{$conf['defaultBanner']['imageUrl']}' border='0' alt=''>{$g_append}";
            $output = array('html' => $outputbuffer, 'bannerid' => '', 'default_banner_image_url' => $conf['defaultBanner']['imageUrl']);
        } else {
            // No default banner was returned, return no banner
            $outputbuffer = $g_prepend . $g_append;
            $output = array('html' => $outputbuffer, 'bannerid' => '' );
        }
    }

	// post adSelect hook
    OX_Delivery_Common_hook('postAdSelect', array(&$output));

    return $output;
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
    $aDirectLinkedAdInfos = MAX_cacheGetLinkedAdInfos($what, $campaignid, $lastpart);

    // Set a flag to let the selection algorithm know that this is a direct request
    $GLOBALS['_MAX']['DIRECT_SELECTION'] = true;

    $aLinkedAd = _adSelectCommon($aDirectLinkedAdInfos, $context, $source, $richMedia);

    if (is_array($aLinkedAd)) {
        $aLinkedAd['zoneid'] = 0;
        $aLinkedAd['bannerid'] = $aLinkedAd['ad_id'];
        $aLinkedAd['storagetype'] = $aLinkedAd['type'];
        $aLinkedAd['campaignid'] = $aLinkedAd['placement_id'];

        return $aLinkedAd;
    }
    // this looks broken...
    if (!empty($aDirectLinkedAdInfos['default_banner_image_url'])) {
        return array(
           'default'                        => true,
           'default_banner_image_url'       => $aDirectLinkedAdInfos['default_banner_image_url'],
           'default_banner_destination_url' => $aDirectLinkedAdInfos['default_banner_destination_url']
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
    // ZoneID zero is used for direct selected adRequests only
    if ($zoneId === 0) { return false; }

    global $g_append, $g_prepend;
    while (!in_array($zoneId, $GLOBALS['_MAX']['followedChain'])) {
        $GLOBALS['_MAX']['followedChain'][] = $zoneId;
        $appendedThisZone = false;

        // first get zone info
        $aZoneInfo = MAX_cacheGetZoneInfo($zoneId);

        if (empty($aZoneInfo)) {
            // the zone does not exist, sorry!
            return false;
        }

        //check zone level limitations
        if ($zoneId != 0 && MAX_limitationsIsZoneForbidden($zoneId, $aZoneInfo)) {
            $zoneId = _getNextZone($zoneId, $aZoneInfo);
            continue;
        }

        // Get all ads which are linked to the zone
        $aZoneLinkedAdInfos = MAX_cacheGetZoneLinkedAdInfos ($zoneId);

        if (is_array($aZoneInfo)) {
            if (isset($aZoneInfo['forceappend']) && $aZoneInfo['forceappend'] == 't') {
                $g_prepend .= $aZoneInfo['prepend'];
                $g_append = $aZoneInfo['append'] . $g_append;
                $appendedThisZone = true;
            }

            // merge zone info and banner info
            $aZoneLinkedAdInfos += $aZoneInfo;

            $aLinkedAd = _adSelectCommon($aZoneLinkedAdInfos, $context, $source, $richMedia);

            if (is_array($aLinkedAd)) {
                $aLinkedAd['zoneid'] = $zoneId;
                $aLinkedAd['bannerid'] = $aLinkedAd['ad_id'];
                $aLinkedAd['storagetype'] = $aLinkedAd['type'];
                $aLinkedAd['campaignid'] = $aLinkedAd['placement_id'];
                $aLinkedAd['zone_companion'] = $aZoneLinkedAdInfos['zone_companion'];
                $aLinkedAd['block_zone'] = @$aZoneInfo['block_zone'];
                $aLinkedAd['cap_zone'] = @$aZoneInfo['cap_zone'];
                $aLinkedAd['session_cap_zone'] = @$aZoneInfo['session_cap_zone'];
                $aLinkedAd['affiliate_id'] = @$aZoneInfo['publisher_id'];

                if (!$appendedThisZone) {
                    $aLinkedAd['append'] .= @$aZoneInfo['append'] . $g_append;
                    $aLinkedAd['prepend'] = $g_prepend . @$aZoneInfo['prepend'] . $aLinkedAd['prepend'];
                } else {
                    $aLinkedAd['append'] .= $g_append;
                    $aLinkedAd['prepend'] = $g_prepend . $aLinkedAd['prepend'];
                }
                return ($aLinkedAd);
            }

            $zoneId = _getNextZone($zoneId, $aZoneInfo);
        }
    }
    if (!empty($aZoneInfo['default_banner_image_url'])) {
        return array(
           'default'                        => true,
           'default_banner_image_url'       => $aZoneInfo['default_banner_image_url'],
           'default_banner_destination_url' => $aZoneInfo['default_banner_destination_url']
        );
    }

    return false;
}


/**
 * This function selects an ad cyclying through override, contract, renmant, etc.
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
	// pre adSelect hook
    OX_Delivery_Common_hook('preAdSelect', array(&$aAds, &$context, &$source, &$richMedia));

    if (!empty($aAds['ext_adselection'])) {
        $adSelectFunction = OX_Delivery_Common_getFunctionFromComponentIdentifier($aAds['ext_adselection'], 'adSelect');
    }
    if (empty($adSelectFunction) || !function_exists($adSelectFunction)) {
        $adSelectFunction = '_adSelect';
    }

    // Are there any ads linked?
    if (!empty($aAds['count_active'])) {
        // Is this a companion request and can it be fullfilled?
        if (isset($aAds['zone_companion']) && isset($context)) {
            foreach ($context as $contextEntry) {
                if (isset($contextEntry['==']) && preg_match('/^companionid:/', $contextEntry['=='])) {
                    if ($aLinkedAd = _adSelectInnerLoop($adSelectFunction, $aAds, $context, $source, $richMedia, true)) {
                        return $aLinkedAd;
                    }
                }
            }
        }
        $aLinkedAd = _adSelectInnerLoop($adSelectFunction, $aAds, $context, $source, $richMedia);
        if (is_array($aLinkedAd)) {
            return $aLinkedAd;
        }
    }
    return false;
}

/**
 * This internal function selects an ad cyclying through override, contract, remnant, etc.
 * taking into account companion positioning as requested
 *
 * @param callback $adSelectFunction The plugin callback function
 * @param string  $aAds         The array of ads to pick from
 * @param array   $context      The context of this ad selection
 *                              - used for companion positioning
 *                              - and excluding banner/campaigns from this ad-call
 * @param string  $source       The "source" parameter passed into the adcall
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 * @param boolean $companion    Should ad selection only return companion ads?
 *
 * @return array|false          Returns an ad-array (see page DocBlock) or false if no ad found
 */
function _adSelectInnerLoop($adSelectFunction, $aAds, $context, $source, $richMedia, $companion = false)
{
    // Array of campaign types sorted by priority
    $aCampaignTypes = array(
        'xAds' => false,     // No priority levels
        'ads'  => array(10, 9, 8, 7, 6, 5, 4, 3, 2, 1),
        'lAds' => false,     // No priority levels
        'eAds' => array(-2), // Priority level is fixed to -2
    );

    $GLOBALS['_MAX']['considered_ads'][] = &$aAds;

    foreach ($aCampaignTypes as $type => $aPriorities) {
        if ($aPriorities) {
            $ad_picked = false;
            foreach ($aPriorities as $pri) {
                // Even though we've selected an ad, we need to continue
                // applying filtering rules in order to construct a valid
                // qualified ad set, which MPE 2.x needs to know.
                if (!$ad_picked) {
                    $aLinkedAd = OX_Delivery_Common_hook('adSelect',
                            array(&$aAds, &$context, &$source, &$richMedia, $companion, $type, $pri), $adSelectFunction);
                    // Did we pick an ad from this campaign-priority level?
                    if (is_array($aLinkedAd)) {
                        $ad_picked = true;
                    }
                    // Should we skip the next campaign-priority level?
                    if ($aLinkedAd == $GLOBALS['OX_adSelect_SkipOtherPriorityLevels']) {
                        $ad_picked = true;
                    }
                }
                else
                {
                    if (!empty($aAds[$type][$pri])) {
                        // Build preconditions
                        $aContext = _adSelectBuildContextArray($aAds[$type][$pri], $type, $context);

                        // New delivery algorithm: discard all invalid ads before iterating over them
                        // $aAds passed by ref here
                        _adSelectDiscardNonMatchingAds($aAds[$type][$pri], $aContext, $source, $richMedia);
                    }
                }
            }
            if ($ad_picked && is_array ($aLinkedAd)) {
                return $aLinkedAd;
            }
        } else {
            $aLinkedAd = OX_Delivery_Common_hook('adSelect', array(&$aAds, &$context, &$source, &$richMedia, $companion, $type), $adSelectFunction);
            // Did we pick an ad from this campaign type?
    		if (is_array($aLinkedAd)) {
      			return $aLinkedAd;
    		}
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
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 * @param boolean $companion    Should ad selection only return companion ads?
 * @param string  $adArrayVar   The collection of ads in $aLinkedAds to select the ad from
 * @param integer $cp
 *
 * @return array|void           The ad-array for the selected ad or void if no ad selected
 */
function _adSelect(&$aLinkedAdInfos, $context, $source, $richMedia, $companion, $adArrayVar = 'ads', $cp = null)
{
    // If there are no linked ads, we can return
    if (!is_array($aLinkedAdInfos)) { return; }

    if (!is_null($cp) && isset($aLinkedAdInfos[$adArrayVar][$cp])) {
        $aAds = &$aLinkedAdInfos[$adArrayVar][$cp];
    } elseif (is_null($cp) && isset($aLinkedAdInfos[$adArrayVar])) {
        $aAds = &$aLinkedAdInfos[$adArrayVar];
    } else {
        $aAds = array();
    }

    // If there are no linked ads of the specified type, we can return
    if (count($aAds) == 0) {
        return;
    }

    // Build preconditions
    $aContext = _adSelectBuildContextArray($aAds, $adArrayVar, $context, $companion);

    // New delivery algorithm: discard all invalid ads before iterating over them
    // $aAds passed by ref here
    _adSelectDiscardNonMatchingAds($aAds, $aContext, $source, $richMedia);

    // If there are no linked ads of the specified type, we can return
    if (count($aAds) == 0) {
        return;
    }

    // Seed the random number generator
    global $n;
    mt_srand
        (floor
         ((isset ($n) && strlen ($n) > 5
           ? hexdec ($n[0].$n[2].$n[3].$n[4].$n[5])
           : 1000000) * (double) microtime ()));

    $conf = $GLOBALS['_MAX']['CONF'];

    if ($adArrayVar == 'eAds') {
        if (!empty ($conf['delivery']['ecpmSelectionRate'])) {
            // we should still allow there to be some portion of control
            // responses in order to avoid starving out any ad
            $selection_rate = floatval ($conf['delivery']['ecpmSelectionRate']);

            if (!_controlTrafficEnabled ($aAds) ||
                    (mt_rand (0, $GLOBALS['_MAX']['MAX_RAND']) /
                     $GLOBALS['_MAX']['MAX_RAND']) <= $selection_rate)
            {
                // Find the highest value eCPM ad(s) an naively select
                // from that set.
                $max_ecpm = 0;
                $top_ecpms = array();
                // build an eCPM sorted index for the ads
                foreach ($aAds as $key => $ad) {
                    if ($ad['ecpm'] < $max_ecpm) {
                        continue;
                    } elseif ($ad['ecpm'] > $max_ecpm) {
                        $top_ecpms = array();
                        $max_ecpm = $ad['ecpm'];
                    }
                    $top_ecpms[$key] = 1;
                }

                // fallback to weighted prioritization if ecpm weighting zeros out
                if ($max_ecpm <= 0)
                {
                    $GLOBALS['_MAX']['ECPM_CONTROL'] = 1;
                    $total_priority = _setPriorityFromWeights($aAds);
                } else {
                    // zero out the priority for all except ads with the
                    // highest eCPM value
                    $GLOBALS['_MAX']['ECPM_SELECTION'] = 1;
                    $total_priority = count ($top_ecpms);
                    foreach ($aAds as $key => $ad) {
                        if (!empty ($top_ecpms[$key])) {
                            $aAds[$key]['priority'] = 1 / $total_priority;
                        } else {
                            $aAds[$key]['priority'] = 0;
                        }
                    }
                }
            }
            else
            {
                $GLOBALS['_MAX']['ECPM_CONTROL'] = 1;
                $total_priority = _setPriorityFromWeights($aAds);
            }
        }

    } else if (isset($cp)) {

        // How much of the priority space have we already covered?
        $used_priority = 0;
        for ($i = 10; $i > $cp; $i--)
        {
            if (isset ($aLinkedAdInfos['priority_used'][$adArrayVar][$i]))
            {
                $used_priority += $aLinkedAdInfos['priority_used'][$adArrayVar][$i];
            }
        }

        // sanity check, in case there is no space left.
        if ($used_priority >= 1) {
            return $GLOBALS['OX_adSelect_SkipOtherPriorityLevels'];
        }

        $remaining_priority = 1 - $used_priority;

        // Calculate the sum of all priority values
        $total_priority_orig = 0;
        foreach ($aAds as $ad) {
            $total_priority_orig += $ad['priority'] * $ad['priority_factor'];
        }
        $aLinkedAdInfos['priority_used'][$adArrayVar][$i] = $total_priority_orig;

        // If there are no active ads, we can return
        if ($total_priority_orig <= 0) {
            return;
        }

        // In this case, the sum of priorities is greater than the ratio
        // we have remaining, so just scale to fill the remaining space.
        if ($total_priority_orig > $remaining_priority
            // If this ad belongs to a companion campaign that was previously displayed on the page,
            // we scale up the priority factor as we want to ensure that companion ads are
            // displayed together, potentially ignoring their banner weights (refs OX-4853)
            || $companion
            )
        {
            $scaling_denom = $total_priority_orig;

            // In this case, the space has been oversold, so eCPM optimization
            // is allowed to be applied.  The approach is to give priority to
            // higher eCPM, but not to rescale priorities, unless there is a tie
            // for a position at the edge of the dropoff.
            if ($cp >= PRI_ECPM_FROM &&
                $cp <= PRI_ECPM_TO &&
                !empty ($conf['delivery']['ecpmSelectionRate']))
            {

                // we should still allow there to be some portion of control
                // responses in order to avoid starving out any ad
                $selection_rate = floatval ($conf['delivery']['ecpmSelectionRate']);

                if (!_controlTrafficEnabled ($aAds) ||
                        (mt_rand (0, $GLOBALS['_MAX']['MAX_RAND']) /
                         $GLOBALS['_MAX']['MAX_RAND']) <= $selection_rate)
                {
                    // set flag to indicate this request has applied ecpm optimization
                    $GLOBALS['_MAX']['ECPM_SELECTION'] = 1;

                    // build an eCPM sorted index for the ads
                    foreach ($aAds as $key => $ad) {
                        $ecpms[] = $ad['ecpm'];
                        $adids[] = $key;
                    }
                    array_multisort ($ecpms, SORT_DESC, $adids);

                    $p_avail = $remaining_priority;
                    $ad_count = count ($aAds);
                    $i = 0;
                    while ($i < $ad_count) {

                        // find the range of consecutive ads with equal eCPMs
                        $l = $i;
                        while ($l < $ad_count - 1 &&
                                $ecpms[$l + 1] == $ecpms[$i]) {
                            $l++;
                        }

                        // how much priority space does this range of equal eCPM ads require?
                        $p_needed = 0;
                        for ($a_idx = $i; $a_idx <= $l; $a_idx++) {
                            $id = $adids[$a_idx];
                            $p_needed += $aAds[$id]['priority'] * $aAds[$id]['priority_factor'];
                        }

                        // if this range needs more priority space than is left, we'll scale
                        // these and zero out all ads with lower eCPM values
                        if ($p_needed > $p_avail) {
                            $scale = $p_avail / $p_needed;

                            for ($a_idx = $i; $a_idx <= $l; $a_idx++) {
                                $id = $adids[$a_idx];
                                $aAds[$id]['priority'] = $aAds[$id]['priority'] * $scale;
                            }
                            $p_avail = 0;

                            // zero out remaining ads priorities
                            for ($a_idx = $l + 1; $a_idx < $ad_count; $a_idx++) {
                                $id = $adids[$a_idx];
                                $aAds[$id]['priority'] = 0;
                            }

                            break;

                        } else {
                            $p_avail -= $p_needed;
                            $i = $l + 1;
                        }
                    }

                    $scaling_denom = $remaining_priority;
                } else {
                    // set flag to indicate this request was eligible for ecpm optimization,
                    // but did not apply it in order to serve a control result set
                    $GLOBALS['_MAX']['ECPM_CONTROL'] = 1;
                }
            }

            // scaling_denom is either remaining_priority or total_priority_orig, both of which
            // have been guarded against being 0, so there's no risk of div by 0 here
            $scaling_factor = 1 / $scaling_denom;
        }
        else
        {
            // in this case, we don't need to use the whole of the remaining
            // space, but we scale to the remaining size, which leaves room to
            // select a lower level, since $total_priority_orig / $remaining_priority < 1
            $scaling_factor = 1 / $remaining_priority;
        }

        // recalculate the priorities (in place??), using the scaling factor.
        $total_priority = 0;
        foreach ($aAds as $key => $ad) {
            $newPriority =
                $ad['priority'] * $ad['priority_factor'] * $scaling_factor;

            $aAds[$key]['priority'] = $newPriority;
            $total_priority += $newPriority;
        }

    } else {
        // Rescale priorities by weights
        $total_priority = _setPriorityFromWeights($aAds);
    }

    // Seed the random number generator
    global $n;
    mt_srand
        (floor
         ((isset ($n) && strlen ($n) > 5
           ? hexdec ($n[0].$n[2].$n[3].$n[4].$n[5])
           : 1000000) * (double) microtime ()));

    $conf = $GLOBALS['_MAX']['CONF'];

    // Pick a float random number between 0 and 1, inclusive.
    $random_num =
        mt_rand (0, $GLOBALS['_MAX']['MAX_RAND'])
        / $GLOBALS['_MAX']['MAX_RAND'];

###START_STRIP_DELIVERY
    // testing support
    if (function_exists ('test_mt_rand'))
    {
        $random_num = test_mt_rand (0, $GLOBALS['_MAX']['MAX_RAND'])
        / $GLOBALS['_MAX']['MAX_RAND'];
    }
###END_STRIP_DELIVERY
    // Is it higher than the sum of all the priority values?
    if ($random_num > $total_priority) {
        // No suitable ad found, proceed as usual
        return;
    }

    // Perform selection of an ad, based on the random number
    $low = 0;
    $high = 0;
    foreach($aAds as $aLinkedAd) {
        if (!empty($aLinkedAd['priority'])) {
            $low = $high;
            $high += $aLinkedAd['priority'];
            if ($high > $random_num && $low <= $random_num) {
###START_STRIP_DELIVERY
                // testing support
                if (function_exists ('test_MAX_cacheGetAd'))
                {
                    return test_MAX_cacheGetAd($aLinkedAd['ad_id']);
                }
###END_STRIP_DELIVERY
                $ad = MAX_cacheGetAd($aLinkedAd['ad_id']);
                // Carry over for conversion tracking
                $ad['tracker_status'] = (!empty($aLinkedAd['tracker_status'])) ? $aLinkedAd['tracker_status'] : null;
                // Carry over for ad dimensions for market ads
                if($ad['width'] == $ad['height'] && $ad['width'] == -1) {
                   $ad['width'] = $aLinkedAd['width'];
                   $ad['height'] = $aLinkedAd['height'];
                }
                return $ad;
            }
        }
    }

    return;
}

/**
 * Return boolean indicating if this request is eligible for selection into a
 * control group for ecpm optimization.  Having only CPM ads as being eligible
 * may be a disqualifying criteria, given a configuration setting.
 *
 * @param unknown_type $aAds
 */
function _controlTrafficEnabled (&$aAds)
{
    $control_enabled = true;

    // if enableControlOnPureCPM is not enabled, we will check to see if
    // the ads are all only CPM, and disable control selection if they are
    if (empty ($GLOBALS['_MAX']['CONF']['delivery']['enableControlOnPureCPM']))
    {
        // check for any non-CPM campaign in eligible set
        $control_enabled = false;
        foreach ($aAds as $ad) {
            if ($ad['revenue_type'] != MAX_FINANCE_CPM)
            {
                $control_enabled = true;
                break;
            }
        }

    }

    return $control_enabled;
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

    // Enforce campaign expirations
    if (!empty ($aAd['expire_time'])) {
        $expire = strtotime ($aAd['expire_time']);
        $now = MAX_commonGetTimeNow ();
        if ($expire > 0 && $now > $expire) {
            OX_Delivery_logMessage('Campaign has expired for bannerid '.$aAd['ad_id'], 7);
            return false;
        }
    }

    // Excludelist banners
    if (isset($aContext['banner']['exclude'][$aAd['ad_id']])) {
        OX_Delivery_logMessage('List of excluded banners list contains bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if (isset($aContext['campaign']['exclude'][$aAd['placement_id']])) {
        // Excludelist campaigns
        OX_Delivery_logMessage('List of excluded campaigns contains bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if (isset($aContext['client']['exclude'][$aAd['client_id']])) {
        // Excludelist clients
        OX_Delivery_logMessage('List of excluded clients contains bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if (sizeof($aContext['banner']['include']) && !isset($aContext['banner']['include'][$aAd['ad_id']])) {
        // Includelist banners
        OX_Delivery_logMessage('List of included banners does not contain bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if (sizeof($aContext['campaign']['include']) && !isset($aContext['campaign']['include'][$aAd['placement_id']])) {
        // Includelist campaigns
        OX_Delivery_logMessage('List of included campaigns does not contain bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if (   // Exclude richmedia banners if no alt image is specified
        $richMedia == false &&
        $aAd['alt_filename'] == '' &&
        !($aAd['contenttype'] == 'jpeg' || $aAd['contenttype'] == 'gif' || $aAd['contenttype'] == 'png') &&
        !($aAd['type'] == 'url' && $aAd['contenttype'] == '')
       ) {
        OX_Delivery_logMessage('No alt image specified for richmedia bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if (MAX_limitationsIsAdForbidden($aAd)) {
        // Capping & blocking
        OX_Delivery_logMessage('MAX_limitationsIsAdForbidden = true for bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if ($GLOBALS['_MAX']['SSL_REQUEST'] && $aAd['type'] == 'html' && $aAd['html_ssl_unsafe']) {
        // HTML Banners that contain 'http:' on SSL
        OX_Delivery_logMessage('"http:" on SSL found for html bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if ($GLOBALS['_MAX']['SSL_REQUEST'] && $aAd['type'] == 'url' && $aAd['url_ssl_unsafe']) {
        // It only matters if the initial call is to non-SSL (it can/could contain http:)
        OX_Delivery_logMessage('"http:" on SSL found in imagurl for url bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    if ($conf['delivery']['acls'] && !MAX_limitationsCheckAcl($aAd, $source)) {
        // Delivery limitations
        OX_Delivery_logMessage('MAX_limitationsCheckAcl = false for bannerid '.$aAd['ad_id'], 7);
        return false;
    }

    // If any of the above failed, this function will have already returned false
    // So to get this far means that the ad was valid
    return true;
}

function _adSelectBuildContextArray(&$aLinkedAds, $adArrayVar, $context, $companion = false)
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

            // Skip if value is empty
            if (empty($value)) {
                continue;
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
                        case '!=':
                            // Exclusion list prevents competing companion ads from being displayed
                            // even when a previous try to fatch a companion failed
                            $aContext['campaign']['exclude'][$value] = true;
                            break;
                        case '==':
                            // Inclusion list should be ignored if a previous try already failed
                            // to return an ad
                            if ($companion) {
                                $aContext['campaign']['include'][$value] = true;
                            }
                       break;
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
        // So pass into the next call that we would like a banner from this campaign
        // and not from the other companion linked campaigns
        foreach ($aBanner['zone_companion'] AS $companionCampaign) {
            $value = 'companionid:'.$companionCampaign;
            if ($aBanner['placement_id'] == $companionCampaign) {
                $context[] = array('==' => $value);
            } else {
                // Did we previously deliver an ad from this campaign?
                $key = array_search(array('==', $value), $context);
                if ($key === false) {
                    // Nope, we must exclude the campaign then!
                    $context[] = array('!=' => $value);
                }
            }
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
 * @return none
 */
function _adSelectDiscardNonMatchingAds(&$aAds, $aContext, $source, $richMedia)
{
    // Don't filter ads on direct selection requests (if that setting is disabled)
    if (empty($GLOBALS['_MAX']['CONF']['delivery']['aclsDirectSelection']) && !empty($GLOBALS['_MAX']['DIRECT_SELECTION'])) {
        return;
    }
    foreach ($aAds as $adId => $aAd) {
        OX_Delivery_logMessage('_adSelectDiscardNonMatchingAds: checking bannerid '.$aAd['ad_id'], 7);
        if (!_adSelectCheckCriteria($aAd, $aContext, $source, $richMedia)) {
            OX_Delivery_logMessage('failed _adSelectCheckCriteria: bannerid '.$aAd['ad_id'], 7);
            unset($aAds[$adId]);
        } else {
            OX_Delivery_logMessage('passed _adSelectCheckCriteria: bannerid '.$aAd['ad_id'], 7);
        }
    }
    return;
}

?>
