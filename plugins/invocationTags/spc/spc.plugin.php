<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
        'noscript' => 1,
        'ssl' => 0,
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
        }

        if(count($aZones) == 0) {
            return 'No Zones Available!';
        }

        $additionalParams = "";
        foreach ($this->defaultOptionValues as $feature => $default) {
            // Skip invocation code settings here if they don't affect delivery
            if ($feature == 'source' || $feature == 'noscript' || $feature == 'ssl') { continue; }
            if ($mi->$feature != $this->defaultOptionValues[$feature]) {
                $additionalParams .= "&amp;{$feature}=" . $mi->$feature;
            }
        }

        $varprefix = $conf['var']['prefix'];
        $name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
        $channel = (!empty($mi->source)) ? $mi->source : $affiliate['mnemonic'] . "/test/preview";
        $uri = (!empty($mi->ssl)) ? MAX_commonConstructSecureDeliveryUrl() : MAX_commonConstructDeliveryUrl();

        $script = "<?xml version='1.0' encoding='UTF-8' ?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
    <title>{$affiliate['name']} - Single Page Call (SPC) tags - Test page</title>";
        if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 && strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
            $script .="\n    <script type='text/javascript' src='js-gui.js'></script>";
        }
        if ($mi->comments) {
            $search = array("{affiliate['mnemonic']}");
            $replace = array($affiliate['mnemonic']);
            $script .= "\n    <!--/*\n";
            $script .= str_replace($search, $replace, MAX_Plugin_Translation::translate('SPC Header script comment', $this->module, $this->package));
            $script .= "\n    */-->";
        }
        if ($mi->source) {
            $script .= "\n    <script type='text/javascript'><!--// <![CDATA[\n        var {$varprefix}source = '{$mi->source}';\n    // ]]> --></script>";
        }
        $script .= "\n    <script type='text/javascript' src='{$uri}{$conf['file']['spcjs']}?id={$mi->affiliateid}{$additionalParams}'></script>
</head>

<body><div id='body'>";

        if ($mi->comments) {
            $script .= "
<blockquote>
<b>Instructions:</b> ". htmlspecialchars(MAX_Plugin_Translation::translate('SPC Header script instrct', $this->module, $this->package));

            $script  .= "<table>";
            // Show clipboard button only on IE since Mozilla will throw a security warning
            if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 && strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
                $script .= "<tr><td align='right'><img src='images/icon-clipboard.gif'>&nbsp;";
                $script .= "<a href='javascript:max_CopyClipboard(\"spcJsSrc\");'>".$GLOBALS['strCopyToClipboard']."</a></td></tr>";
            }

            $scriptJs = "<script type='text/javascript' src='{$uri}{$conf['file']['spcjs']}?id={$mi->affiliateid}{$additionalParams}'></script>";
            $script .= "<tr><td><textarea id='spcJsSrc' rows='1' cols='120'>". htmlspecialchars($scriptJs) ."</textarea></td></tr></table>";
            $script .= MAX_Plugin_Translation::translate('SPC codeblock instrct', $this->module, $this->package) ." </blockquote>";

            $script .= "\n\n\n    <!--/*\n" . MAX_Plugin_Translation::translate('SPC codeblock comment', $this->module, $this->package) . "\n    */-->";

        }

        foreach($aZones as $zone) {
            $name = '[id'. $zone['zoneid'] .'] '. $zone['zonename'] . ' ' . (($zone['width'] > -1) ? $zone['width'] : '*') . 'x' . (($zone['height'] > -1) ? $zone['height'] : '*');
            $script .= "<br /><br />{$name}<br />\n";

            $codeblock = "<script type='text/javascript'><!--// <![CDATA[";
            $js_func = $varprefix . (($zone['delivery'] == phpAds_ZonePopup) ? 'showpop' : 'show');
            if ($mi->comments) {
                $codeblock .= "\n    /* {$name} */";
            }
            $codeblock .= "\n    {$js_func}({$zone['zoneid']});\n// ]]> --></script>";
            if ($zone['delivery'] != phpAds_ZoneText && $mi->noscript) {
                $codeblock .= "<noscript><a target='_blank' href='{$uri}{$conf['file']['click']}?n={$zone['n']}'>";
                $codeblock .= "<img border='0' alt='' src='{$uri}{$conf['file']['view']}?zoneid={$zone['zoneid']}&amp;n={$zone['n']}' /></a>";
                $codeblock .= "</noscript>";
            }
            if ($mi->comments) {
            $script .= "
<table cellpadding='0' cellspacing='0' border='0'>
<tr height='32'>
    <td width='32'><img src='images/cropmark-tl.gif' width='32' height='32'></td>
    <td background='images/ruler-top.gif'>&nbsp;</td>
    <td width='32'><img src='images/cropmark-tr.gif' width='32' height='32'></td>
</tr>
<tr>
    <td width='32' background='images/ruler-left.gif'>&nbsp;</td>
    <td bgcolor='#FFFFFF'>";
            }

            $script .= "\n\n" . $codeblock;

            if ($mi->comments) {
            $script .= "    </td>
    <td width='32'>&nbsp;</td>
</tr>
<tr height='32'>
    <td width='32'><img src='images/cropmark-bl.gif' width='32' height='32'></td>
    <td>&nbsp;</td>
    <td width='32'><img src='images/cropmark-br.gif' width='32' height='32'></td>
</tr>
</table>";
            $script .= "
<table>
<tr>
    <td><img src='images/icon-generatecode.gif' align='absmiddle'><b>Bannercode</b></td>";
            // Show clipboard button only on IE since Mozilla will throw a security warning
            if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 && strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
                $script .= "<td align='right'><img src='images/icon-clipboard.gif'>&nbsp;";
                $script .= "<a href='javascript:max_CopyClipboard(\"code_{$zone['zoneid']}\");'>".$GLOBALS['strCopyToClipboard']."</a></td>";
            }
            $script .= "
</tr>
<tr>
    <td colspan='2'><textarea id='code_{$zone['zoneid']}' rows='10' cols='80'>" . htmlspecialchars($codeblock) . "</textarea>
</tr>
</table>
";
            }
        }
            $script .= "
</div></body>
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
        $option .= "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>" . MAX_Plugin_Translation::translate('Option - noscript', $this->module, $this->package) . "</td>";
        $option .= "<td width='370'><input type='radio' name='noscript' value='1'".($noscript == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='noscript' value='0'".($noscript == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
        return $option;
    }


    function ssl()
    {
        $maxInvocation = &$this->maxInvocation;
        $ssl = (isset($maxInvocation->ssl)) ? $maxInvocation->ssl : $this->defaultOptionValues['ssl'];

        $option = '';
        $option .= "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>" . MAX_Plugin_Translation::translate('Option - SSL', $this->module, $this->package) . "</td>";
        $option .= "<td width='370'><input type='radio' name='ssl' value='1'".($ssl == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='ssl' value='0'".($ssl == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
        return $option;
    }
}

?>
