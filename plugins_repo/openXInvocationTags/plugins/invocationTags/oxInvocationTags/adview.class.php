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
class Plugins_InvocationTags_OxInvocationTags_adview extends Plugins_InvocationTags
{
    /**
     * Return name of plugin
     *
     * @return string
     */
    public function getName()
    {
        return $this->translate("Image Tag");
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
        return 'Image Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    public function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        if (is_array($extra) && $extra['delivery'] == phpAds_ZoneText) {
            return false;
        } else {
            return $isAllowed;
        }
    }

    public function getOrder()
    {
        parent::getOrder();
        return 4;
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
            'campaignid' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
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
            'Third Party Comment' => '',
            'Comment' => $this->translate("
  * This tag only shows image banners. There is no width or height in
  * these banners, so if you want these tags to allocate space for the
  * ad before it shows, you will need to add this information to the
  * <img> tag."),
            ];
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;

        $buffer = $mi->buffer;

        $buffer .= $mi->backupImage;

        return $buffer;
    }
}
