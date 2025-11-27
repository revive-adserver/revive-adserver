<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver - Markdown Plugin                                         |
+---------------------------------------------------------------------------+
*/


/**
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 */


require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * Markdown Invocation tag plugin.
 */
class Plugins_InvocationTags_OxInvocationTags_markdown extends Plugins_InvocationTags
{
    /**
     * Return name of plugin
     *
     * @return string
     */
    public function getName()
    {
        return $this->translate("Markdown (GitHub)");
    }

    /**
     * Return the English name of the plugin.
     *
     * @return string An English string describing the class.
     */
    public function getNameEN()
    {
        return 'Markdown (GitHub)';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    public function isAllowed($extra = null)
    {
        return parent::isAllowed($extra);
    }

    public function getOrder()
    {
        parent::getOrder();
        return 0;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    public function getOptionsList()
    {
        $options = [];
        return $options;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    public function generateInvocationCode()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $buffer = '';

        $zoneId = 0;
        if (isset($this->invocationObject->zoneid)) {
            $zoneId = $this->invocationObject->zoneid;
        } elseif (isset($this->maxInvocation->zoneid)) {
            $zoneId = $this->maxInvocation->zoneid;
        }

        // error_log("--- DEBUG MARKDOWN START ---");
        // error_log("Markdown Plugin - Generating for Zone ID: " . $zoneId);

        // construct the "magic" image URL
        // we use the .htaccess rule we just created: /www/images/zone-{ID}.png
        
        // base URL (e.g., http://localhost:8080/www)
        $deliveryUrl = $conf['webpath']['delivery'];
        $baseUrl = rtrim(str_replace('/delivery', '', $deliveryUrl), '/');
        
        $imgUrl = $baseUrl . "/images/zone-" . $zoneId . ".png";

        // click URL
        $random = mt_rand(100000, 999999);
        $clickUrl = MAX_commonConstructDeliveryUrl($conf['file']['click']);
        $clickUrl .= "?n=" . $random;

        // markdown
        $buffer .= "[![Ad](" . $imgUrl . ")](" . $clickUrl . ")";

        return $buffer;
    }
}
?>