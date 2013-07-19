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

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * Invocation tag plugin class
 *
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 *
 */
class Plugins_InvocationTags_OxInvocationTags_local extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate("Local Mode Tag");
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
        return 'Local Mode Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra, $server_same)
    {
        // Set "same_server" as a property on this object, but still permit invocation
        $this->same_server = $server_same;
        return parent::isAllowed($extra);
    }

    function getOrder()
    {
        parent::getOrder();
        return 3;
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
            'charset'       => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'block'         => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'raw'           => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
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
            'Cache Buster Comment' => '',
            'Third Party Comment'  => '',
            'SSL Delivery Comment' => '',
            'SSL Backup Comment'   => '',
            'Comment'              => '',
            );
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
        $mi = &$this->maxInvocation;

        $buffer = $mi->buffer;

        // Deal with windows style paths
        $path = MAX_PATH;
        $path = str_replace('\\', '/', $path);

        if (empty($mi->clientid))   $mi->clientid = 0;
        if (empty($mi->zoneid))     $mi->zoneid = 0;
        if (empty($mi->campaignid)) $mi->campaignid = 0;
        if (empty($mi->bannerid))   $mi->bannerid = 0;

        $buffer = "<"."?php\n  //" . $buffer;
        $buffer .= (!empty($mi->comments)) ? "  // The MAX_PATH below should point to the base of your {$name} installation\n" : '';
        $buffer .= "  define('MAX_PATH', '" . MAX_PATH . "');\n";
        $buffer .= "  if (@include_once(MAX_PATH . '/www/delivery" . (preg_match('#_dev\/?$#', $conf['webpath']['delivery']) ? '_dev' : '') . "/{$conf['file']['local']}')) {\n";
        $buffer .= "    if (!isset($"."phpAds_context)) {\n      $"."phpAds_context = array();\n    }\n";
        if (!empty($mi->comments)) {
            $buffer .= "    // function view_local(\$what, \$zoneid=0, \$campaignid=0, \$bannerid=0, \$target='', \$source='', \$withtext='', \$context='', \$charset='')\n";
        }
        $buffer .= "    $"."phpAds_raw = view_local('{$mi->what}', {$mi->zoneid}, {$mi->campaignid}, {$mi->bannerid}, '{$mi->target}', '{$mi->source}', '{$mi->withtext}', \$phpAds_context, '{$mi->charset}');\n";
        if (isset($mi->block) && $mi->block == '1') {
            $buffer .= "    $"."phpAds_context[] = array('!=' => 'bannerid:'.$"."phpAds_raw['bannerid']);\n";
        }
        if (isset($mi->blockcampaign) && $mi->blockcampaign == '1') {
            $buffer .= "    $"."phpAds_context[] = array('!=' => 'campaignid:'.$"."phpAds_raw['campaignid']);\n";
        }
        $buffer .= "  }\n";
        $buffer .= (isset($mi->raw) && $mi->raw == '1') ? "  // " . $this->translate("Assign the \$phpAds_raw['html'] variable to your template") . "\n  // " : '  ';
        $buffer .= "echo $"."phpAds_raw['html'];\n";
        $buffer .= "?".">\n";

        return $buffer;
    }

}

?>