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
class Plugins_InvocationTags_OxInvocationTags_adviewnocookies extends Plugins_InvocationTags
{
    /**
     * Use only for factory default plugin
     * @see MAX_Admin_Invocation::placeInvocationForm()
     */
    var $defaultZone = MAX_ZoneEmail;

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate("No Cookie Image Tag");
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
        return 'No Cookie Image Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        if((is_array($extra) && $extra['delivery'] != MAX_ZoneEmail) || $this->maxInvocation->zone_invocation) {
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
        if (!$this->maxInvocation->zone_invocation) {
            $options = array (
                'spacer'          => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
                'bannerid'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'target'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'source'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            );
        } else {
            $options = array (
                'spacer'          => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
                //'bannerzone'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'target'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
                'source'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
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
        $aComments = array(
            'Third Party Comment'  => '',
            'SSL Delivery Comment' => '',
            'Comment'              => '',
            );
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;

       if (!empty($mi->uniqueid) && ($mi->extra['delivery'] != MAX_ZoneEmail)) {
            $mi->parameters[] = "n=".$mi->uniqueid;
        }
        $buffer .= "<a href='";
        if (!empty($mi->thirdpartytrack)) {
            $buffer .= $mi->macros['clickurl'];
        }
        $buffer .= MAX_commonConstructDeliveryUrl($conf['file']['click']);
        $mi->clickParams = array();

        // Only need the banner id for direct selection not zone
        if (empty($mi->extra['delivery']) || ($mi->extra['delivery'] != MAX_ZoneEmail)) {
            //$buffer .= "?bannerid=" . $mi->bannerid;
            $mi->clickParams[] = 'bannerid=' . $mi->bannerid;
        }
        if ((isset($mi->zoneid)) && ($mi->zoneid != '')) {
            //$buffer .= "&zoneid=".$mi->zoneid;
            $mi->clickParams[] = 'zoneid=' . $mi->zoneid;
        }

        if (count($mi->clickParams) > 0) {
            $buffer .= '?' . implode('&amp;', $mi->clickParams);
        }
        $buffer .= "'";
        if (isset($mi->target) && $mi->target != '') {
            $buffer .= " target='".$mi->target."'";
        } else {
            $buffer .= " target='_blank'";
        }
        $buffer .= "><img src='".MAX_commonConstructDeliveryUrl($conf['file']['view']);
        // Without cookies, passing in the click URL to view is not possible
        unset($mi->parameters['ct0']);
        if (sizeof($mi->parameters) > 0) {
            $buffer .= "?" . implode ("&amp;", $mi->parameters);
        }
        $buffer .= "' border='0' alt='' /></a>\n";

        return $buffer;
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
}

?>