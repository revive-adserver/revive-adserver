<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
+---------------------------------------------------------------------------+
$Id: spc.plugin.php 526 2006-10-18 11:23:13Z chris@m3.net $
*/

/**
 * @package    MaxPlugins
 * @subpackage InvocationTags
 * @author     Chris Nutting <chris@m3.net>
 *
 */

require_once MAX_PATH . '/plugins/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_Spc_Spc extends Plugins_InvocationTags
{
    /**
     * Set default values for options used by this plugin
     *
     * @var array Array of $key => $defaultValue
     */
    var $defaultOptionValues = array(
        'block' => 0,
        'blockcampaign' => 0,
        'target' => '',
        'source' => '',
        'withtext' => 0,
    );

    /**
     * Make this the default publisher plugin
     *
     * @var boolean
     */
    var $default = true;

    /**
     * Constructor
     *
     */
    function Plugins_InvocationTags_Spc_Spc() {
        $this->publisherPlugin = true;
    }

     /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Publisher code - Single Page Call', $this->module, $this->package);
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed()
    {
        return false;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    function generateInvocationCode()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['CONF'];

        $mi = &$this->maxInvocation;

        // Get the affiliate information
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($mi->affiliateid)) {
            $affiliate = $doAffiliates->toArray();
        }
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $mi->affiliateid;
        $doZones->find();
        while ($doZones->fetch() && $row = $doZones->toArray()) {
            $row['n'] = $affiliate['mnemonic'] . substr(md5(uniqid('', 1)), 0, 7);
            $aZones[] = $row;
            $zones[$row['delivery']][] = "            '{$row['zonename']}' : {$row['zoneid']}";
        }

        if(count($aZones) == 0) {
            return 'No Zones Available!';
        }

        $additionalParams = "";
        foreach ($this->defaultOptionValues as $feature => $default) {
            // Skip source here since it's dealt with earlier
            if ($feature == 'source') { continue; }
            if (!empty($mi->$feature)) {
                $additionalParams .= "&amp;{$feature}=" . $mi->$feature;
            }
        }

        $varprefix = $conf['var']['prefix'];
        $name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
        $channel = (!empty($mi->source)) ? $mi->source : $affiliate['mnemonic'] . "/test/preview";
        $script = "
<html>
<head>
    <title>{$affiliate['name']} - Single Page Call (SPC) tags - Test page</title>\n";
        if ($mi->comments) {
            $search = array("{affiliate['mnemonic']}");
            $replace = array($affiliate['mnemonic']);
            $script .= str_replace($search, $replace, MAX_Plugin_Translation::translate('SPC Setup Instructions', $this->module, $this->package));
        }
$script .= "    <script type='text/javascript'><!--// <![CDATA[
        var {$varprefix}channel = '{$channel}';
        var {$varprefix}zones = {\n" . implode(",\n", $zones[phpAds_ZoneBanner]) . "\n        };\n";
        if (!empty($zones[phpAds_ZonePopup])) {
            $script .="        var {$varprefix}popupZones = {\n";
            $script .= implode(",\n", $zones[phpAds_ZonePopup]) . "\n        };\n";
        }
        $script .= "        var {$varprefix}uri = 'http:" . MAX_commonConstructPartialDeliveryUrl('') . "spc.js';\n";
        $script .= "        var {$varprefix}uri_ssl = 'https:" . MAX_commonConstructPartialDeliveryUrl('', true) . "spc.js';\n";
        $script .= "        var {$varprefix}options = '" .((!empty($additionalParams)) ? $additionalParams : '') . "';
    // ]]> --></script>\n";

        if ($mi->comments) {
            $search = array('{url}');
            $replace = array(MAX_commonConstructPartialDeliveryUrl(''));
            $script .= str_replace($search, $replace, MAX_Plugin_Translation::translate('SPC Header script comment', $this->module, $this->package));
        }
        $script .= "
    <script type='text/javascript'><!--// <![CDATA[
        {$varprefix}zoneids = '';
        for (var zonename in {$varprefix}zones) {$varprefix}zoneids += escape(zonename+'=' + {$varprefix}zones[zonename] + \"|\");

        var {$varprefix}p=location.protocol=='https:'?'https:':'http:';
        var {$varprefix}r=Math.floor(Math.random()*99999999);
        {$varprefix}output = new Array();

        var {$varprefix}spc=\"<\"+\"script type='text/javascript' \";
        {$varprefix}spc+=\"src='\"+{$varprefix}p+\"".MAX_commonConstructPartialDeliveryUrl($conf['file']['singlepagecall'])."?zones=\"+{$varprefix}zoneids;
        {$varprefix}spc+=\"&channel=\"+{$varprefix}channel+\"&r=\"+{$varprefix}r;" .
        ((!empty($additionalParams)) ? "\n        {$varprefix}spc+=\"{$additionalParams}\";" : '') . "
        if (window.location) {$varprefix}spc+=\"&loc=\"+escape(window.location);
        if (document.referrer) {$varprefix}spc+=\"&referer=\"+escape(document.referrer);
        {$varprefix}spc+=\"'><\"+\"/script>\";
        document.write({$varprefix}spc);

        function {$varprefix}show(name) {
            if ((typeof({$varprefix}zones[name]) == 'undefined') || (typeof({$varprefix}output[name]) == 'undefined')) {
                return;
            } else {
                document.write({$varprefix}output[name]);
            }
        }";
        if (!empty($zones[phpAds_ZonePopup])) {
            $script .= "

        function {$varprefix}showpop(name) {
            if (typeof({$varprefix}popupZones[name]) == 'undefined') {
                return;
            }

            var {$varprefix}pop=\"<\"+\"script type='text/javascript' \";
            {$varprefix}pop+=\"src='\"+{$varprefix}p+\"".MAX_commonConstructPartialDeliveryUrl($conf['file']['popup'])."?zoneid=\"+{$varprefix}popupZones[name];
            {$varprefix}pop+=\"&source=\"+{$varprefix}channel+\"&r=\"+{$varprefix}r;" .
            ((!empty($additionalParams)) ? "\n        {$varprefix}spc+=\"{$additionalParams}\";" : '') . "
            {$varprefix}spc+=\"{$additionalParams}\";
            if (window.location) {$varprefix}pop+=\"&loc=\"+escape(window.location);
            if (document.referrer) {$varprefix}pop+=\"&referer=\"+escape(document.referrer);
            {$varprefix}pop+=\"'><\"+\"/script>\";

            document.write({$varprefix}pop);
        }    ";
        }
        $script .= "\n    // ]]> --></script>";

        $script .= "
</head>

<body>";

        if ($mi->comments) {
            $script .= MAX_Plugin_Translation::translate('SPC codeblock comment', $this->module, $this->package);
        }

        foreach($aZones as $zone) {
            $name = str_replace('\'','',$zone['zonename']) . " - " . str_replace('\'','',$zone['width']) . "x". str_replace('\'','',$zone['height']);
            if ($zone['delivery'] != phpAds_ZonePopup) {
                $script .= "

<br /><br />$name<br />
<script type='text/javascript'><!--// <![CDATA[
    {$varprefix}show('{$zone['zonename']}');
// ]]> --></script>";
                    if ($zone['delivery'] != phpAds_ZoneText) {
                        $script .= "<noscript><a target='_blank' href='".MAX_commonConstructDeliveryUrl($conf['file']['click'])."?n={$zone['n']}'>";
                        $script .= "<img border='0' alt='' src='".MAX_commonConstructDeliveryUrl($conf['file']['view'])."?zoneid={$zone['zoneid']}&n={$zone['n']}' /></a>";
                        $script .= "</noscript>";
                    }
                }
                else {
                    // This is a popup zone, so generate popup.php invocation not javascript

                    $script .= "

<br /><br />$name<br />
<script type='text/javascript'><!--// <![CDATA[
    {$varprefix}showpop('{$zone['zonename']}');
// ]]> --></script>
";
                }
            }

            $script .= "
</body>
</html>";

        return $script;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        // Publisher Invocation doesn't require a lot of the default options...
        if (is_array($this->defaultOptions)) {
            // JS code generates it's own cacheBuster
            unset($this->defaultOptions['cacheBuster']);
            // Publisher invocation is not designed for loading into another adserver
            unset($this->defaultOptions['3thirdPartyServer']);
        }
        $options = array (
            'spacer'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'block'         => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'spacer'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        );

        return $options;
    }
}

?>
