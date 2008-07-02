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
class Plugins_InvocationTags_popup_popup extends Plugins_InvocationTags
{

    /**
     * Use only for factory default plugin
     * @see MAX_Admin_Invocation::placeInvocationForm()
     */
    var $defaultZone = phpAds_ZonePopup;

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Popup Tag', $this->module, $this->package);
    }

    /**
     * Return the English name of the plugin. Used when
     * generating translation keys based on the plugin
     * name.
     *
     * @return string An English string describing the class.
     */
    function getNameEN()
    {
        return 'Popup Tag';
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
        return 'allowedTags_popup';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra)
    {
        $isAllowed = parent::isAllowed($extra);
        if(is_array($extra) || (is_array($extra) && $extra['delivery'] == phpAds_ZoneText)) {
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
            'what'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid'    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'absolute'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'popunder'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'timeout'       => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'delay'         => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'windowoptions' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
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

        if (isset($mi->popunder) && $mi->popunder == '1') {
            $mi->parameters['popunder'] = "popunder=1";
        }
        if (isset($mi->left) && $mi->left != '' && $mi->left != '-') {
            $mi->parameters['left'] = "left=".$mi->left;
        }
        if (isset($mi->top) && $mi->top != '' && $mi->top != '-') {
            $mi->parameters['top'] = "top=".$mi->top;
        }
        if (isset($mi->timeout) && $mi->timeout != '' && $mi->timeout != '-') {
            $mi->parameters['timeout'] = "timeout=".$mi->timeout;
        }
        if (isset($mi->toolbars) && $mi->toolbars == '1') {
            $mi->parameters['toolbars'] = "toolbars=1";
        }
        if (isset($mi->location) && $mi->location == '1') {
            $mi->parameters['location'] = "location=1";
        }
        if (isset($mi->menubar) && $mi->menubar == '1') {
            $mi->parameters['menubar'] = "menubar=1";
        }
        if (isset($mi->status) && $mi->status == '1') {
            $mi->parameters['status'] = "status=1";
        }
        if (isset($mi->resizable) && $mi->resizable == '1') {
            $mi->parameters['resizable'] = "resizable=1";
        }
        if (isset($mi->scrollbars) && $mi->scrollbars == '1') {
            $mi->parameters['scrollbars'] = "scrollbars=1";
        }

        if (isset($mi->delay_type)) {
            if ($mi->delay_type == 'seconds' && isset($mi->delay) && $mi->delay != '' && $mi->delay != '-') {
                $mi->parameters['delay'] = "delay=".$mi->delay;
            } elseif ($mi->delay_type == 'exit') {
                $mi->parameters['delay'] = "delay=exit";
            }
        }
        $buffer .= "<script type='text/javascript' src='".MAX_commonConstructDeliveryUrl($conf['file']['popup']);
        $buffer .= "?n=".$mi->uniqueid;
        if (sizeof($mi->parameters) > 0) {
            $buffer .= "&".implode ("&", $mi->parameters);
        }
        $buffer .= "'></script>\n";

        return $buffer;
    }

}

?>