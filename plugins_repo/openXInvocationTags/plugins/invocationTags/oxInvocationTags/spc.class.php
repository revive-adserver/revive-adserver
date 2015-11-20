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
 * @package    MaxPlugins
 * @subpackage InvocationTags
 */

require_once MAX_PATH . '/lib/Max.php';
require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/JSON/JSON.php';

require_once OX_PATH . '/lib/OX.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_Spc extends Plugins_InvocationTags
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
        'noscript' => 1,
        'ssl' => 0,
        'charset' => '',
    );

    /**
     * Make this the default publisher plugin
     *
     * @var boolean
     */
    var $default = true;

    var $varprefix;
    var $appname;

    /**
     * Constructor
     *
     */
    function __construct()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->publisherPlugin = true;
        $this->varprefix = $conf['var']['prefix'];
        $this->appname = PRODUCT_NAME . " v" . VERSION;
    }

     /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate("Publisher code - Single Page Call");
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
        return 'Publisher code - Single Page Call';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra = null)
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
            // Email/Newsletter and DHTML and Video zones are not included in SPC
            if ($row['delivery'] != MAX_ZoneEmail
                && $row['delivery'] != phpAds_ZoneInterstitial
                && $row['delivery'] != OX_ZoneVideoInstream
                && $row['delivery'] != OX_ZoneVideoOverlay) {
                $aZones[] = $row;
            }
        }

        if(count($aZones) == 0) {
            return 'No Zones Available!';
        }


        $channel = (!empty($mi->source)) ? $mi->source : $affiliate['mnemonic'] . "/test/preview";

        $script = "<?xml version='1.0' encoding='UTF-8' ?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
    <title>Tags for [id{$affiliate['affiliateid']}] ".htmlspecialchars($affiliate['name'])."</title>
        <link rel='stylesheet' type='text/css' href='" . OX::assetPath() .  "/css/preview.css' />
        <script type='text/javascript' src='" . OX::assetPath() .  "/js/jquery-1.2.3.js'></script>

        <script type='text/javascript'>
        <!--

            function selectElement() {
                if (window.getSelection) {
                    var r = document.createRange();
                    r.selectNodeContents($(this)[0]);
                    var s = window.getSelection();
                    if (s.rangeCount) {
                        s.collapseToStart();
                        s.removeAllRanges();
                    }
                    s.addRange(r);
                } else if (document.body.createTextRange) {
                    var r = document.body.createTextRange();
                    r.moveToElementText($(this)[0]);
                    r.select();
                }
            }

            $(document).ready(function() {
                $('pre').bind('mousedown', selectElement);
                $('pre').bind('click', selectElement);
                $('pre').bind('mousemove', selectElement);

                $('#closeWindow').click(function() {
                    window.close();
                });
            });

        //-->
        </script>
    </head>

    <body class='invocationCodes'>
        <div class='header'>
            <h1>" . PRODUCT_NAME . "</h1>
        </div>
        ";

        $script .= "
        <div class='settings'>
            <h2>Tags <small>for <span class='inlinePublisher'>[id{$affiliate['affiliateid']}] ".htmlspecialchars($affiliate['name'])."</span></small></h2>
            <p>
                This page contains all the information you need to show banners on your website.
                Please follow the instructions carefully and ensure that you copied the scripts <strong>exactly</strong> as shown below.
            </p>

            <h3>The following settings were used to generate this page:</h3>
            <table class='horizontalSummary' summary=''>
        ";

        reset ($this->defaultOptionValues);
        foreach ($this->defaultOptionValues as $feature => $default) {
            switch ($feature) {
                case 'block':
                        $optionName = $GLOBALS['strInvocationDontShowAgain'];
                        $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                        break;
                case 'blockcampaign':
                        $optionName = $GLOBALS['strInvocationDontShowAgainCampaign'];
                        $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                        break;
                case 'target':
                        $optionName = $GLOBALS['strInvocationTarget'];
                        switch($mi->$feature) {
                            case '_blank':  $optionValue = 'New window'; break;
                            case '_top':    $optionValue = 'Same window'; break;
                            default:        $optionValue = $GLOBALS['strDefault']; break;
                        }
                        break;
                case 'source':
                        $optionName = $GLOBALS['strInvocationSource'];
                        $optionValue = $mi->$feature != '' ? htmlspecialchars(stripslashes($mi->$feature)) : '-';
                        break;
                case 'withtext':
                        $optionName = $GLOBALS['strInvocationWithText'];
                        $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                        break;
                case 'noscript':
                        $optionName = $this->translate("Option - noscript");
                        $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                        break;
                case 'ssl':
                        $optionName = $this->translate("Option - SSL");
                        $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                        break;
                case 'charset':
                        $optionName = $GLOBALS['strCharset'];
                        $optionValue = empty($mi->$feature) ? $GLOBALS['strAutoDetect'] : htmlspecialchars($mi->$feature);
                        break;
                default:
                        $optionName = $feature;
                        $optionValue = htmlspecialchars(stripslashes($mi->$feature));
                        break;
            }

            $script .= "
                <tr>
                    <th>{$optionName}</th>
                    <td>{$optionValue}</td>
                </tr>
            ";
        }

        $script .= "
            </table>
        </div>
        ";

        /* Common script at the top of the page */
        $codeblock = $this->getHeaderCode();

        $script .= "
        <div class='step'>
            <h2>
                <div class='number'><span>1</span></div>
                Header script
            </h2>
            <p>
                Insert the following script at the top of every page on the {$affiliate['website']} website. This code
                belongs between the <code>&lt;head&gt;</code> and <code>&lt;/head&gt;</code> tags, before any ad scripts
                on the page:
            </p>

            <pre>". htmlspecialchars($codeblock) ."</pre>
        </div>
        ";

        $i = 2;




        foreach($aZones as $zone) {
            $width = $zone['width'] > -1 ? $zone['width'] : 150;
            $widthLabel = $zone['width'] > -1 ? $zone['width'] : '*';

            $height = $zone['height'] > -1 ? $zone['height'] : 150;
            $heightLabel = $zone['height'] > -1 ? $zone['height'] : '*';

            $customClass = array();

            if ($zone['width'] == -1 && $zone['height'] == -1) {
                $customClass[] = 'customBoth';
            } elseif ($zone['height'] == -1) {
                $customClass[] = 'customHeight';
            } elseif ($zone['width'] == -1) {
                $customClass[] = 'customWidth';
            }

            // Labels are roughly 80 x 30 pixels...
            // width < 80 || height < 30 => No room for even a single label, drop the OpenX logo and show the size outside
            // width < 160 && height < 60   => No room for both labels... drop the OpenX logo
            if (($zone['width'] > -1 && $zone['width'] < 80) || ($zone['height'] > -1 && $zone['height'] < 30)) {
                $customClass[] = 'labelsMicro';
            } elseif ($zone['width'] > -1 && $zone['width'] < 160 && $zone['height'] > -1 && $zone['height'] < 60) {
                $customClass[] = 'labelsMini';
            }

            $codeblock = $this->getZoneCode($zone, $affiliate);

            $script .= "
        <div class='step'>
            <h2>
                <div class='number'><span>{$i}</span></div>
                Ad script <small>for <span class='inlineZone'>[id{$zone['zoneid']}] ".htmlspecialchars($zone['zonename'])."</span></small>
            </h2>
            <p>
                Copy the following script and place it in the site where you want the ad to display:
            </p>

            <pre>" . htmlspecialchars($codeblock) . "</pre>

            <p>
                Example" . ($zone['width'] == -1 || $zone['height'] == -1 ? ' (actual size may vary)' : '') . ":
            </p>

            <div class='sizePreview " . (count($customClass) ? ' ' . implode(' ', $customClass) : '') . "' style='width: {$width}px; height: {$height}px;'>
                <img src='" . OX::assetPath() . "/images/logo-adserver-small.png' alt='' />
                <span>{$widthLabel} x {$heightLabel}</span>
            </div>

        </div>
            ";

            $i++;
        }

        $script .= "
        <div class='step'>
            <h2>
                <div class='number'><span>{$i}</span></div>
                Done
            </h2>
            <p>
                Banners should now appear on your website
            </p>

            <button id='closeWindow'><img src='" . OX::assetPath() . "/images/cross.png' alt='' />Close this window</button>
        </div>

        <div class='generated'>
            Generated by {$this->appname}
        </div>
    </body>
</html>
        ";

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
            'charset'       => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'noscript'      => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
            'ssl'           => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
        );

        return $options;
    }

    /**
     * A custom handler for the <noscript> option
     *
     * @return string HTML to show the <noscript> option
     */
    function noscript()
    {
        $maxInvocation = &$this->maxInvocation;
        $noscript = (isset($maxInvocation->noscript)) ? $maxInvocation->noscript : $this->defaultOptionValues['noscript'];

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>" . $this->translate("Option - noscript") . "</td>";
        $option .= "<td width='370'><input type='radio' id='noscript-y' name='noscript' value='1'".($noscript == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;<label for='noscript-y'>".$GLOBALS['strYes']."</label><br />";
        $option .= "<input type='radio' id='noscript-n' name='noscript' value='0'".($noscript == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;<label for='noscript-n'>".$GLOBALS['strNo']."</label></td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
        return $option;
    }

    function ssl()
    {
        $maxInvocation = &$this->maxInvocation;
        $ssl = (isset($maxInvocation->ssl)) ? $maxInvocation->ssl : $this->defaultOptionValues['ssl'];

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>" . $this->translate("Option - SSL") . "</td>";
        $option .= "<td width='370'><input type='radio' id='ssl-y' name='ssl' value='1'".($ssl == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;<label for='ssl-y'>".$GLOBALS['strYes']."</label><br />";
        $option .= "<input type='radio' name='ssl' id='ssl-y' value='0'".($ssl == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;<label for='ssl-n'>".$GLOBALS['strNo']."</label></td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";
        return $option;
    }

    function setInvocation(&$invocation) {
        $this->maxInvocation = &$invocation;
        $this->maxInvocation->canDetectCharset = true;
    }

    /**
     * Generates header spc tag.
     * If optional $aZoneAliases is given, additional zone aliasing array will be generated.
     *
     * @param array $aZoneAliases zone id => array of alias names
     * @return unknown
     */
    function getHeaderCode($aZoneAliases = null)
    {
        $mi = &$this->maxInvocation;
        $conf = $GLOBALS['_MAX']['CONF'];

        $additionalParams = "";
        foreach ($this->defaultOptionValues as $feature => $default) {
            // Skip invocation code settings here if they don't affect delivery
            if ($feature == 'source' || $feature == 'noscript' || $feature == 'ssl') { continue; }
            if ($mi->$feature != $this->defaultOptionValues[$feature]) {
                $additionalParams .= "&amp;{$feature}=" . $mi->$feature;
            }
        }

        $codeblock = "";
        if ($mi->comments) {
            $codeblock .= "<!-- Generated by {$this->appname} -->\n";
        }
        if ($mi->source) {
            $source = stripslashes($mi->source);
            $source = addcslashes($source, "\x00..\x1F\'\\");
            $codeblock .= "<script type='text/javascript'><!--// <![CDATA[\n";
            $codeblock .= "    var {$this->varprefix}source = '{$source}';\n";
            $codeblock .= "// ]]> --></script>";
        }

        $aliasesBlock = '';
        if (!empty($aZoneAliases)) {
            $aliasesBlock = $this->generateAliasesCode($aZoneAliases);
            $codeblock .= !empty($aliasesBlock) ? $aliasesBlock : '';
        }
        $url = (!empty($mi->ssl)) ? MAX_commonConstructSecureDeliveryUrl($conf['file']['spcjs'])  : MAX_commonConstructDeliveryUrl($conf['file']['spcjs']);
        $codeblock .= "<script type='text/javascript' src='{$url}?id={$mi->affiliateid}{$additionalParams}'></script>";

        return $codeblock;
    }


    private function generateAliasesCode($aZoneAliases)
    {
        $oJson = new Services_JSON();

        $aStruct = array();
        foreach ($aZoneAliases as $zoneId => $aAliases) {
            foreach($aAliases as $alias) {
                $aStruct[$alias] = $zoneId;
            }
        }
        $aliasesCode.= $oJson->encode($aStruct);

        $codeblock .= "<script type='text/javascript'><!--// <![CDATA[\n";
        $codeblock .= "    var {$this->varprefix}zones = ";
        $codeblock .= $aliasesCode;
        $codeblock .= "    \n";
        $codeblock .= "// ]]> --></script>\n";

        return $codeblock;
    }


    function getZoneCode($zone, $affiliate, $zoneAlias = null)
    {
        $mi = &$this->maxInvocation;
        $conf = $GLOBALS['_MAX']['CONF'];

        $zone['n'] = $affiliate['mnemonic'] . substr(md5(uniqid('', 1)), 0, 7);

        $uri = (!empty($mi->ssl)) ? MAX_commonConstructSecureDeliveryUrl('')  : MAX_commonConstructDeliveryUrl('');

        $codeblock = "<script type='text/javascript'><!--// <![CDATA[";
        $js_func = $this->varprefix . (($zone['delivery'] == phpAds_ZonePopup) ? 'showpop' : 'show');
        if ($mi->comments) {
            $codeblock .= "\n    /* ".($zoneAlias ? addcslashes($zoneAlias)." - " : '')."[id{$zone['zoneid']}] ".addcslashes($zone['zonename'], '/')." */";
        }
        $codeblock .= "\n    {$js_func}(".($zoneAlias ? "'".$zoneAlias."'" : $zone['zoneid']).");\n// ]]> --></script>";
        if ($zone['delivery'] != phpAds_ZoneText && $mi->noscript) {
            $codeblock .= "<noscript><a target='_blank' href='{$uri}{$conf['file']['click']}?n={$zone['n']}'>";
            $codeblock .= "<img border='0' alt='' src='{$uri}{$conf['file']['view']}?zoneid={$zone['zoneid']}&amp;n={$zone['n']}' /></a>";
            $codeblock .= "</noscript>";
        }

        return $codeblock;
    }
}

?>
