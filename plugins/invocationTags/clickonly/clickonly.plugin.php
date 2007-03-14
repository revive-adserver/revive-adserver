<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
 * @package    MaxPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Dal/Delivery/mysql.php';
require_once(MAX_PATH . '/lib/max/Delivery/cache.php');

/**
 * Invocation tag plugin.
 */
class Plugins_InvocationTags_clickonly_clickonly extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Track Clicks Only Tag', $this->module, $this->package);
    }

    /**
     * Return preference code
     *
     * @return string
     */
    function getPreferenceCode()
    {
        return 'allow_invocation_clickonly';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra)
    {
        $isAllowed = parent::isAllowed($extra);
        /*if((is_array($extra) && $extra['delivery'] == phpAds_ZoneText) || $this->maxInvocation->zone_invocation) {
            return false;
        } else {*/
            return $isAllowed;
        /*}*/
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        if (!$this->maxInvocation->zone_invocation) {
            $options = array (
                'spacer'          => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
                'bannerid'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'target'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'source'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'setRequirements' => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
            );
        } else {
            $options = array (
                'spacer'          => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
                'target'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'source'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'setRequirements' => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
            );
        }

        return $options;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    function generateInvocationCode()
    {
        parent::prepareCommonInvocationData();

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;

        if ($this->maxInvocation->zone_invocation) {
            $buffer .= "<!--\nClick through URLs\n\n";

            $zoneAds = MAX_cacheGetZoneLinkedAds($mi->zoneid, true, false);

            $ads = array();
            foreach ($zoneAds['xAds'] as $iAdId => $aAd) {
                $ads[$iAdId] = $aAd;
            }
            foreach ($zoneAds['ads'] as $iAdId => $aAd) {
                $ads[$iAdId] = $aAd;
            }
            foreach ($zoneAds['lAds'] as $iAdId => $aAd) {
                $ads[$iAdId] = $aAd;
            }
            foreach ($ads as $ad) {
                $buffer .= $ad['name'] . ":\n" . MAX_commonConstructDeliveryUrl($conf['file']['click']);
                $buffer .= "?bannerid=" . $ad['ad_id'];
                $buffer .= "&zoneid=".$mi->zoneid;
                if ((isset($mi->source)) && ($mi->source != '')) {
                    $buffer .= "&{$conf['var']['channel']}=" . urlencode($mi->source);
                }
                if ((isset($mi->cachebuster)) && ($mi->cachebuster != '0')) {
                    $buffer .= "&cb=INSERT_RANDOM_NUMBER_HERE";
                }
                $buffer .= "\n";
            }

            $buffer .= "\n\nHTML code:\n-->\n";
            foreach ($ads as $ad) {
                $buffer .= "<a href='".MAX_commonConstructDeliveryUrl($conf['file']['click']);
                $buffer .= "?{$conf['var']['adId']}=" . $ad['ad_id'];
                if ((isset($mi->zoneid)) && ($mi->zoneid != '')) {
                    $buffer .= "&amp;{$conf['var']['zoneId']}=".$mi->zoneid;
                }
                if ((isset($mi->source)) && ($mi->source != '')) {
                    $buffer .= "&amp;{$conf['var']['channel']}=" . urlencode($mi->source);
                }
                if ((isset($mi->cachebuster)) && ($mi->cachebuster != '0')) {
                    $buffer .= "&amp;{$conf['var']['cacheBuster']}=" . $mi->macros['cachebuster'];
                }
                $buffer .= "'";
                if (isset($mi->target) && $mi->target != '') {
                    $buffer .= " target='".$mi->target."'";
                }
                $buffer .= ">{$ad['bannertext']}</a>\n";

            }
            return $buffer;

        } else {
            if (!empty($mi->uniqueid)) {
                $mi->parameters[] = "n=".$mi->uniqueid;
            }
            $buffer .= "<a href='".MAX_commonConstructDeliveryUrl($conf['file']['click']);
            $buffer .= "?bannerid=" . $mi->bannerid;
            if ((isset($mi->zoneid)) && ($mi->zoneid != '')) {
                $buffer .= "&zoneid=".$mi->zoneid;
            }
            if ((isset($mi->cachebuster)) && ($mi->cachebuster != '0')) {
                $buffer .= "&cb=" . $mi->macros['cachebuster'];
            }
            $buffer .= "'";
            if (isset($mi->target) && $mi->target != '') {
                $buffer .= " target='".$mi->target."'";
            } else {
                $buffer .= " target='_blank'";
            }
            $buffer .= ">\n";
            $buffer .= "<img src='INSERT_BANNER_SRC";
            if (sizeof($mi->parameters) > 0) {
                $buffer .= "?".implode ("&", $mi->parameters);
            }
            $buffer .= "' border='0' alt='' /></a>\n";

            return $buffer;
        }
    }


    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function spacer()
    {
        $option = "<tr bgcolor='#F6F6F6'><td height='10' colspan='3'>&nbsp;</td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function setRequirements()
    {
        $option = '';

        $option .= "<script type='text/javascript'>\n";
        $option .= "<!--// <![CDATA[ \n";
        $option .= "\tmax_formSetRequirements('bannerid', '".addslashes($GLOBALS['strInvocationBannerID'])."', true)\n";
        $option .= "// ]]> -->\n";
        $option .= "</script>\n";

        return $option;
    }
}

?>
