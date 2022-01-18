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
 */

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_adframe extends Plugins_InvocationTags
{
    /**
     * Return name of plugin
     *
     * @return string
     */
    public function getName()
    {
        return $this->translate("iFrame Tag");
    }

    /**
     * Return the English name of the plugin. Used when
     * generating translation keys based on the plugin
     * name.
     *
     * @return string An English string describing the class.
     */
    public function getNameEN()
    {
        return 'iFrame Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    public function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        if ((is_array($extra) && $extra['delivery'] == phpAds_ZoneText)) {
            return false;
        } else {
            return $isAllowed;
        }
    }

    public function getOrder()
    {
        parent::getOrder();
        return 2;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    public function getOptionsList()
    {
        $options = [
            'spacer' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            //'clientid'    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'refresh' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'size' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'transparent' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        ];

        return $options;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    public function generateInvocationCode()
    {
        $aComments['Comment'] = $this->translate("
  * If iFrames are not supported by the viewer's browser, then this
  * tag only shows image banners. There is no width or height in these
  * banners, so if you want these tags to allocate space for the ad
  * before it shows, you will need to add this information to the <img>
  * tag.");
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;
        $uniqueid = 'a' . substr(md5(uniqid('', 1)), 0, 7);

        if (isset($mi->refresh) && $mi->refresh != '') {
            if (is_array($mi->parameters)) {
                $mi->parameters = ['refresh' => "refresh=" . $mi->refresh] + $mi->parameters;
            } else {
                $mi->parameters['refresh'] = "refresh=" . $mi->refresh;
            }
        }

        if (empty($mi->frame_width)) {
            $mi->frame_width = $mi->width;
        }
        if (empty($mi->frame_height)) {
            $mi->frame_height = $mi->height;
        }
        $buffer .= "<iframe id='{$uniqueid}' name='{$uniqueid}' src='" . MAX_commonConstructDeliveryUrl($conf['file']['frame'], $mi->https);
        if (sizeof($mi->parameters) > 0) {
            $buffer .= "?" . implode("&amp;", $mi->parameters);
        }
        $buffer .= "' frameborder='0' scrolling='no'";
        if (isset($mi->frame_width) && $mi->frame_width != '' && $mi->frame_width != '-1') {
            $buffer .= " width='" . $mi->frame_width . "'";
        }
        if (isset($mi->frame_height) && $mi->frame_height != '' && $mi->frame_height != '-1') {
            $buffer .= " height='" . $mi->frame_height . "'";
        }
        if (isset($mi->transparent) && $mi->transparent == '1') {
            $buffer .= " allowtransparency='true'";
        }
        $buffer .= " allow='autoplay'";
        $buffer .= ">";
        if (isset($mi->refresh) && $mi->refresh != '') {
            unset($mi->parameters['refresh']);
        }

        $buffer .= $mi->backupImage;
        $buffer .= "</iframe>\n";

        if (isset($mi->target) && $mi->target != '') {
            $mi->parameters['target'] = "target=" . urlencode($mi->target);
        }

        return $buffer;
    }
}
