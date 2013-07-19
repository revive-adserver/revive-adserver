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
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 *
 */

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_popup extends Plugins_InvocationTags
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
        return $this->translate("Popup Tag");
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
     * Check if plugin has enough data to perform tag generation
     *
     * @return boolean
     */
    function canGenerate()
    {
        return !empty($this->maxInvocation->submitbutton);
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
        $aComments = array(
            'Third Party Comment'  => $this->translate("
  -- Don't forget to replace the 'Insert_Clicktrack_URL_Here' text with
  -- the click tracking URL if this ad is to be delivered through a 3rd
  -- party (non-Max) adserver.
  --
  -- Don't forget to replace the 'Insert_Random_Number_Here' text with
  -- a cache-buster random number each time you deliver the tag through
  -- a 3rd party (non-Max) adserver.
  --"),
            'Comment'              => $this->translate("
  -- This tag has been generated for use on a non-SSL page. If this tag
  -- is to be placed on an SSL page, change all instances of
  --   'http://%s/...'
  -- to
  --   'https://%s/...'
  --", array($conf['webpath']['delivery'],$conf['webpath']['deliverySSL'])),
            );
        parent::prepareCommonInvocationData($aComments);

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