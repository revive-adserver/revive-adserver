<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 *
 */

require_once MAX_PATH . '/plugins/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_adframe_adframe extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('iFrame Tag', $this->module, $this->package);
    }

    /**
     * Return setting configuration file code - required for plugins
     * that store a value in the configuration file.
     *
     * Value returned should be NULL if the plugin does not store
     * a value in the configuration file, otherwise it should be a
     * string in the form "level_key".
     *
     * @return string The setting "code".
     */
    function getSettingCode()
    {
        return 'allowedTags_adframe';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra)
    {
        $isAllowed = parent::isAllowed($extra);
        if ((is_array($extra) && $extra['delivery'] == phpAds_ZoneText)) {
            return false;
        } else {
            return $isAllowed;
        }
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        $options = array (
            'spacer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            //'clientid'    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid'  => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'refresh'     => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'size'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'resize'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'transparent' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'ilayer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'iframetracking' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        );

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
        $uniqueid = 'a'.substr(md5(uniqid('', 1)), 0, 7);

        if (!isset($mi->iframetracking) || $mi->iframetracking == 1) {
            // Add n as first parameter
            array_unshift($mi->parameters, "{$conf['var']['n']}={$uniqueid}");
        }

        if (isset($mi->refresh) && $mi->refresh != '') {
            if (is_array($mi->parameters)) {
                $mi->parameters = array('refresh' => "refresh=".$mi->refresh) + $mi->parameters;
            } else {
                $mi->parameters['refresh'] = "refresh=".$mi->refresh;
            }
        }
        if (isset($mi->resize) && $mi->resize == '1') {
            if (is_array($mi->parameters)) {
                $mi->parameters = array('resize' => "resize=1") + $mi->parameters;
            } else {
                $mi->parameters['resize'] = "resize=1";
            }
        }

        $buffer .= "<iframe id='{$uniqueid}' name='{$uniqueid}' src='".MAX_commonConstructDeliveryUrl($conf['file']['frame']);
        if (sizeof($mi->parameters) > 0) {
            $buffer .= "?".implode ("&amp;", $mi->parameters);
        }
        $buffer .= "' framespacing='0' frameborder='no' scrolling='no'";
        if (isset($mi->width) && $mi->width != '' && $mi->width != '-1') {
            $buffer .= " width='".$mi->width."'";
        }
        if (isset($mi->height) && $mi->height != '' && $mi->height != '-1') {
            $buffer .= " height='".$mi->height."'";
        }
        if (isset($mi->transparent) && $mi->transparent == '1') {
            $buffer .= " allowtransparency='true'";
        }
        $buffer .= ">";
        if (isset($mi->refresh) && $mi->refresh != '') {
            unset ($mi->parameters['refresh']);
        }
        if (isset($mi->resize) && $mi->resize == '1') {
            unset ($mi->parameters['resize']);
        }

        if (isset($mi->ilayer) && $mi->ilayer == 1 &&  isset($mi->width) && $mi->width != '' && $mi->width != '-1' && isset($mi->height) && $mi->height != '' && $mi->height != '-1') {
            $buffer .= "<script type='text/javascript'>\n";
            $buffer .= "<!--// <![CDATA[\n";
            $buffer .= "   document.write (\"<nolayer>\");\n";
            $buffer .= "   document.write (\"{$mi->backupImage}\");\n";
            $buffer .= "   document.write (\"</nolayer>\");\n";
            $buffer .= "   document.write (\"<ilayer id='layer".$uniqueid."' visibility='hidden' width='".$mi->width."' height='".$mi->height."'></ilayer>\");\n";
            $buffer .= "// ]]> -->\n";
            $buffer .= "</script>";
            $buffer .= "<noscript>\n  <a href='".MAX_commonConstructDeliveryUrl($conf['file']['click']);
            $buffer .= "?n=".$uniqueid;
            $buffer .= "'";
            if (isset($mi->target) && $mi->target != '') {
                $buffer .= " target='$mi->target'";
            }
            $buffer .= ">\n  <img src='".MAX_commonConstructDeliveryUrl($conf['file']['view']);
            if (sizeof($mi->parameters) > 0) {
                $buffer .= "?".implode ("&", $mi->parameters);
            }
            $buffer .= "' border='0' alt='' /></a></noscript>";
        } else {
            $buffer .= $mi->backupImage;
        }
        $buffer .= "</iframe>\n";

        if (isset($mi->target) && $mi->target != '') {
            $mi->parameters['target'] = "target=".urlencode($mi->target);
        }
        if (isset($mi->ilayer) && $mi->ilayer == 1 && isset($mi->width) && $mi->width != '' && $mi->width != '-1' && isset($mi->height) && $mi->height != '' && $mi->height != '-1') {
            // Do no rewrite target frames
            $mi->parameters['rewrite'] = 'rewrite=0';
            $buffer .= "\n\n";
            $buffer .= "<!-- " . MAX_Plugin_Translation::translate('Placement Comment', $this->module, $this->package) . " -->\n";
            $buffer .= "<layer src='".MAX_commonConstructDeliveryUrl($conf['file']['frame']);
            $buffer .= "?n=".$uniqueid;
            if (sizeof($mi->parameters) > 0) {
                $buffer .= "&".implode ("&", $mi->parameters);
            }
            $buffer .= "' width='".$mi->width."' height='".$mi->height."' visibility='hidden' onload=\"moveToAbsolute(layer".$uniqueid.".pageX,layer".$uniqueid.".pageY);clip.width=".$mi->width.";clip.height=".$mi->height.";visibility='show';\"></layer>";
        }

        if (!isset($mi->iframetracking) || $mi->iframetracking != 0) {
            $buffer .= "<script type='text/javascript' src='".MAX_commonConstructDeliveryUrl($conf['file']['google'])."'></script>";
        }

        return $buffer;
    }

}

?>
