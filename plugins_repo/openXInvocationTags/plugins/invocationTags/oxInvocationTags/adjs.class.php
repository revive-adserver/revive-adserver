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
    public function getName()
    {
        return $this->translate("Javascript Tag");
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
        return 'Javascript Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    public function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        return $isAllowed;
    }

    public function getOrder()
    {
        parent::getOrder();
        return 1;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    public function getOptionsList()
    {
        if (is_array($this->defaultOptions)) {
            if (in_array('cacheBuster', $this->defaultOptions)) {
                unset($this->defaultOptions['cacheBuster']);
            }
        }
        $options = [
            'spacer' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            //'clientid'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'block' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'charset' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD
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
        $aComments = [
            'Comment' => $this->translate("
  * This noscript section of this tag only shows image banners. There
  * is no width or height in these banners, so if you want these tags to
  * allocate space for the ad before it shows, you will need to add this
  * information to the <img> tag.
  *
  * If you do not want to deal with the intricities of the noscript
  * section, delete the tag (from <noscript>... to </noscript>). On
  * average, the noscript tag is called from less than 1% of internet
  * users."),
            ];
        parent::prepareCommonInvocationData($aComments);

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
            $mi->parameters['campaignid'] = "campaignid=" . $mi->campaignid;
        }
        // The cachebuster for JS tags is auto-generated
        unset($mi->parameters['cb']);

        $buffer .= "<script type='text/javascript'><!--//<![CDATA[\n";
        $buffer .= "   var m3_u = (location.protocol=='https:'?'https:" . MAX_commonConstructPartialDeliveryUrl($conf['file']['js'], true) . "':'http:" . MAX_commonConstructPartialDeliveryUrl($conf['file']['js']) . "');\n";
        $buffer .= "   var m3_r = Math.floor(Math.random()*99999999999);\n";
        $buffer .= "   if (!document.MAX_used) document.MAX_used = ',';\n";
        // Removed the non-XHTML compliant "language='JavaScript'
        $buffer .= "   document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);\n";
        if (count($mi->parameters) > 0) {
            $buffer .= "   document.write (\"?" . implode("&amp;", $mi->parameters) . "\");\n";
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

        $buffer .= "   document.write (\"'><\\/scr\"+\"ipt>\");\n";
        $buffer .= "//]]>--></script>";

        if (isset($mi->extra['delivery']) && $mi->extra['delivery'] != phpAds_ZoneText) {
            $buffer .= "<noscript>{$mi->backupImage}</noscript>\n";
        }
        return $buffer;
    }

    public function setInvocation(&$invocation)
    {
        $this->maxInvocation = &$invocation;
        $this->maxInvocation->canDetectCharset = true;
    }
}
