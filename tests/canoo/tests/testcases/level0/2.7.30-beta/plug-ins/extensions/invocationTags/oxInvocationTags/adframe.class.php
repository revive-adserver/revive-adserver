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
class Plugins_InvocationTags_OxInvocationTags_adframe extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
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
    function getNameEN()
    {
        return 'iFrame Tag';
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

    function getOrder()
    {
        parent::getOrder();
        return 2;
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
        $aComments['Comment'] =  $this->translate("
  * If iFrames are not supported by the viewer's browser, then this
  * tag only shows image banners. There is no width or height in these
  * banners, so if you want these tags to allocate space for the ad
  * before it shows, you will need to add this information to the <img>
  * tag.");
        parent::prepareCommonInvocationData($aComments);

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

        if (empty($mi->frame_width )) { $mi->frame_width  = $mi->width; }
        if (empty($mi->frame_height)) { $mi->frame_height = $mi->height; }
        $buffer .= "<iframe id='{$uniqueid}' name='{$uniqueid}' src='".MAX_commonConstructDeliveryUrl($conf['file']['frame']);
        if (sizeof($mi->parameters) > 0) {
            $buffer .= "?".implode ("&amp;", $mi->parameters);
        }
        $buffer .= "' frameborder='0' scrolling='no'";
        if (isset($mi->frame_width) && $mi->frame_width != '' && $mi->frame_width != '-1') {
            $buffer .= " width='".$mi->frame_width."'";
        }
        if (isset($mi->frame_height) && $mi->frame_height != '' && $mi->frame_height != '-1') {
            $buffer .= " height='".$mi->frame_height."'";
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

        if (isset($mi->ilayer) && $mi->ilayer == 1 &&  isset($mi->frame_width) && $mi->frame_width != '' && $mi->frame_width != '-1' && isset($mi->frame_height) && $mi->frame_height != '' && $mi->frame_height != '-1') {
            $buffer .= "<script type='text/javascript'>\n";
            $buffer .= "<!--// <![CDATA[\n";
            $buffer .= "   document.write (\"<nolayer>\");\n";
            $buffer .= "   document.write (\"{$mi->backupImage}\");\n";
            $buffer .= "   document.write (\"</nolayer>\");\n";
            $buffer .= "   document.write (\"<ilayer id='layer".$uniqueid."' visibility='hidden' width='".$mi->frame_width."' height='".$mi->frame_height."'></ilayer>\");\n";
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
        if (isset($mi->ilayer) && $mi->ilayer == 1 && isset($mi->frame_width) && $mi->frame_width != '' && $mi->frame_width != '-1' && isset($mi->frame_height) && $mi->frame_height != '' && $mi->frame_height != '-1') {
            // Do no rewrite target frames
            $mi->parameters['rewrite'] = 'rewrite=0';
            $buffer .= "\n\n";
            $buffer .= "<!-- " . $this->translate("Placement Comment") . " -->\n";
            $buffer .= "<layer src='".MAX_commonConstructDeliveryUrl($conf['file']['frame']);
            $buffer .= "?n=".$uniqueid;
            if (sizeof($mi->parameters) > 0) {
                $buffer .= "&".implode ("&", $mi->parameters);
            }
            $buffer .= "' width='".$mi->frame_width."' height='".$mi->frame_height."' visibility='hidden' onload=\"moveToAbsolute(layer".$uniqueid.".pageX,layer".$uniqueid.".pageY);clip.width=".$mi->frame_width.";clip.height=".$mi->frame_height.";visibility='show';\"></layer>";
        }

        if (!isset($mi->iframetracking) || $mi->iframetracking != 0) {
            $buffer .= "<script type='text/javascript' src='".MAX_commonConstructDeliveryUrl($conf['file']['google'])."'></script>";
        }

        return $buffer;
    }

}

?>
