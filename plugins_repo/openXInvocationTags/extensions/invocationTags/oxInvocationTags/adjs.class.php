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

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_adjs extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Javascript Tag', $this->extension, $this->group);
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
        return 'Javascript Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra)
    {
        $isAllowed = parent::isAllowed($extra);
        return $isAllowed;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        if (is_array($this->defaultOptions)) {
            if (in_array('cacheBuster', $this->defaultOptions)) {
                unset($this->defaultOptions['cacheBuster']);
            }
        }
        $options = array (
            'spacer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            //'clientid'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid'    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'block'         => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'charset'       => MAX_PLUGINS_INVOCATION_TAGS_STANDARD
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

       if (isset($mi->withtext) && $mi->withtext != '0') {
            $mi->parameters['withtext'] = "withtext=1";
        }
        if (isset($mi->block) && $mi->block == '1') {
            $mi->parameters['block'] = "block=1";
        }
        if (isset($mi->blockcampaign) && $mi->blockcampaign == '1') {
            $mi->parameters['blockcampaign'] = "blockcampaign=1";
        }
        if (!empty($mi->campaignid)) {
            $mi->parameters['campaignid'] = "campaignid=".$mi->campaignid;
        }
        // The cachebuster for JS tags is auto-generated
        unset($mi->parameters['cb']);

        $buffer .= "<script type='text/javascript'><!--//<![CDATA[\n";
        // Support for 3rd party server clicktracking
        if (!empty($mi->thirdpartytrack)) {
            // Don't pass this in as a parameter... it is dealt with seperatly
            unset($mi->parameters['ct0']);
            $buffer .= "   document.MAX_ct0 ='{$mi->macros['clickurl']}';\n\n";
        }
        $buffer .= "   var m3_u = (location.protocol=='https:'?'https:".MAX_commonConstructPartialDeliveryUrl($conf['file']['js'], true)."':'http:".MAX_commonConstructPartialDeliveryUrl($conf['file']['js'])."');\n";
        $buffer .= "   var m3_r = Math.floor(Math.random()*99999999999);\n";
        $buffer .= "   if (!document.MAX_used) document.MAX_used = ',';\n";
        // Removed the non-XHTML compliant "language='JavaScript'
        $buffer .= "   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);\n";
        if (count($mi->parameters) > 0) {
            $buffer .= "   document.write (\"?".implode ("&amp;", $mi->parameters)."\");\n";
        }
        $buffer .= "   document.write ('&amp;cb=' + m3_r);\n";

        // Don't pass in exclude unless necessary
        $buffer .= "   if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);\n";

        if (empty($mi->charset)) {
            $buffer .= "   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));\n";
        } else {
            $buffer .= "   document.write ('&amp;charset=" . $mi->charset . "');\n";
        }
        $buffer .= "   document.write (\"&amp;loc=\" + escape(window.location));\n";
        $buffer .= "   if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));\n";
        $buffer .= "   if (document.context) document.write (\"&context=\" + escape(document.context));\n";

        // Only pass in the 3rd party click URL if it is required and (probably) a valid URL (i.e. not a macro like '%c')
        if (!empty($mi->thirdpartytrack)) {
            $buffer .= "   if ((typeof(document.MAX_ct0) != 'undefined') && (document.MAX_ct0.substring(0,4) == 'http')) {\n";
            $buffer .= "       document.write (\"&amp;ct0=\" + escape(document.MAX_ct0));\n   }\n";
        }
        // Pass in if the FlashObject - Inline code has already been passed in
        $buffer .= "   if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");\n";
        $buffer .= "   document.write (\"'><\\/scr\"+\"ipt>\");\n";
        $buffer .= "//]]>--></script>";

        if ($mi->extra['delivery'] != phpAds_ZoneText) {
            $buffer .= "<noscript>{$mi->backupImage}</noscript>\n";
        }
        return $buffer;
    }

    function setInvocation(&$invocation) {
        $this->maxInvocation = &$invocation;
        $this->maxInvocation->canDetectCharset = true;
    }

}

?>
